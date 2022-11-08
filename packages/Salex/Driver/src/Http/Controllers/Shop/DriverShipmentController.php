<?php

namespace Salex\Driver\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Salex\Driver\DataGrids\DriverShipmentDataGrid;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\ShipmentRepository;

class DriverShipmentController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected ShipmentRepository $shipmentRepository,
        protected OrderRepository $orderRepository,
    ) {
        $this->middleware('driver');

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
            return app(DriverShipmentDataGrid::class)->toJson();
        }

        return view($this->_config['view']);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        return view($this->_config['view']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $shipment = $this->shipmentRepository->findOrFail($id);
        $order = $this->orderRepository->findOrFail($shipment->order_id);

        return view($this->_config['view'], compact(['shipment','order']));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipment = $this->shipmentRepository->find($id);
        $shipment->driver_id = 0;
        $shipment->save();

        session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Shipments']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function massAssign()
    {
        $data = request()->all();
        if (!isset($data['massaction-type'])) {
            return redirect()->back();
        }

        if (!$data['massaction-type'] == 'update') {
            return redirect()->back();
        }

        $shipmentIds = explode(',', request()->input('indexes'));

        foreach ($shipmentIds as $shipmentId) {
            $shipment = $this->shipmentRepository->find($shipmentId);

            if (isset($shipment)) {
                $shipment->driver_id = $data['update-options'];
                $shipment->save();
            }
        }

        session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Shipments']));

        return redirect()->route($this->_config['redirect']);
    }
}
