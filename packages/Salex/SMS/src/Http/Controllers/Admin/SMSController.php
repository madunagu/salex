<?php

namespace Salex\SMS\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;
use Exception;

use Webkul\Core\Repositories\CoreConfigRepository;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Twilio\Rest\Client as TwilioClient;

use Illuminate\Support\Facades\Log;
use Salex\SMS\DataGrids\SMSDataGrid;
use Salex\SMS\Repositories\SMSRepository;
use Salex\SMS\Traits\Sender;

class SMSController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    use Sender;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Start date.
     *
     * @var \Illuminate\Support\Carbon
     */
    protected $startDate;

    /**
     * Last start date.
     *
     * @var \Illuminate\Support\Carbon
     */
    protected $lastStartDate;

    /**
     * End date.
     *
     * @var \Illuminate\Support\Carbon
     */
    protected $endDate;

    /**
     * Last end date.
     *
     * @var \Illuminate\Support\Carbon
     */
    protected $lastEndDate;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CoreConfigRepository $coreConfigRepository,
        protected SMSRepository $smsRepository,
    ) {
        $this->middleware('admin');

        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(SMSDataGrid::class)->toJson();
        }

        return view($this->_config['view']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $this->setStartEndDate();

        $apiKey = $this->getConfigVal('sms.sms77.config.api_key');
        $client = $this->getClient();

        $params = [
            'start' => $this->startDate,
            'end' => $this->endDate,
        ];
        $statistics = [
            'balance' =>  0,
            'graph' => [],
            'failed' => 0,
            'successful' => 0,
        ];

        // try {
        $balance = $this->getSMSBalance();

        $graph = $this->getGraph($params);

        $statistics = [
            'balance' =>  $balance,
            'graph' => $graph,
            'failed' => $this->currentSMS()->count(['sent'=>0]),
            'successful' => $this->currentSMS()->count(['sent'=>1]),
        ];

        // } catch (Exception $e) {
        // $error = $e->getMessage();
        // $errors[] = $error;
        // Log::error('sms77 failed to get SMS balance.', compact('error'));
        // }

        return view($this->_config['view'], compact('statistics'))->with(['startDate' => $this->startDate, 'endDate' => $this->endDate,'apiKey'=>$apiKey]);
    }


    private function currentSMS()
    {
        return $this->getSMSBetweenDate($this->startDate, $this->endDate);
    }

        /**
     * Returns orders between two dates.
     *
     * @param  \Illuminate\Support\Carbon  $start
     * @param  \Illuminate\Support\Carbon  $end
     * @return Illuminate\Database\Query\Builder
     */
    private function getSMSBetweenDate($start, $end)
    {
        return $this->smsRepository->scopeQuery(function ($query) use ($start, $end) {
            return $query->where('s_m_s.created_at', '>=', $start)->where('s_m_s.created_at', '<=', $end);
        });
    }

    /**
     * Sets start and end date.
     *
     * @return void
     */
    public function setStartEndDate()
    {
        $this->startDate = request()->get('start')
            ? Carbon::createFromTimeString(request()->get('start') . " 00:00:01")
            : Carbon::createFromTimeString(Carbon::now()->subDays(30)->format('Y-m-d') . " 00:00:01");

        $this->endDate = request()->get('end')
            ? Carbon::createFromTimeString(request()->get('end') . " 23:59:59")
            : Carbon::now();

        if ($this->endDate > Carbon::now()) {
            $this->endDate = Carbon::now();
        }

        $this->lastStartDate = clone $this->startDate;
        $this->lastEndDate = clone $this->startDate;

        $this->lastStartDate->subDays($this->startDate->diffInDays($this->endDate));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view($this->_config['view']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'response'    => 'string|required',
            'text'     => 'string|required',
            'to'        => 'string|required',
            'sent'         => 'bool|required',
            'recipient_user_id'         => 'number|required',
            'event_key' => 'string',
        ]);

        $data = request()->all();


        $data['is_verified'] = 1;

        $sms = $this->smsRepository->create($data);

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'SMS']));

        return redirect()->route($this->_config['redirect']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $sms = $this->smsRepository->findOrFail($id);

        return view($this->_config['view'], compact('customer', 'address', 'customerGroup', 'channelName'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
            'first_name'    => 'string|required',
            'last_name'     => 'string|required',
            'gender'        => 'required',
            'email'         => 'required|unique:customers,email,' . $id,
            'date_of_birth' => 'date|before:today',
        ]);

        $data = request()->all();

        $data['status'] = !isset($data['status']) ? 0 : 1;

        $data['is_suspended'] = !isset($data['is_suspended']) ? 0 : 1;

        $this->customerRepository->update($data, $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Customer']));

        return redirect()->route($this->_config['redirect']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = $this->customerRepository->findorFail($id);

        try {
            if (!$this->customerRepository->checkIfCustomerHasOrderPendingOrProcessing($customer)) {
                $this->customerRepository->delete($id);

                return response()->json(['message' => trans('admin::app.response.delete-success', ['name' => 'Customer'])]);
            }

            return response()->json(['message' => trans('admin::app.response.order-pending', ['name' => 'Customer'])], 400);
        } catch (\Exception $e) {
        }

        return response()->json(['message' => trans('admin::app.response.delete-failed', ['name' => 'Customer'])], 400);
    }


    /**
     * To mass delete the customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        $customerIds = explode(',', request()->input('indexes'));

        if (!$this->customerRepository->checkBulkCustomerIfTheyHaveOrderPendingOrProcessing($customerIds)) {
            foreach ($customerIds as $customerId) {
                $this->customerRepository->deleteWhere(['id' => $customerId]);
            }

            session()->flash('success', trans('admin::app.customers.customers.mass-destroy-success'));

            return redirect()->back();
        }

        session()->flash('error', trans('admin::app.response.order-pending', ['name' => 'Customers']));
        return redirect()->back();
    }
}
