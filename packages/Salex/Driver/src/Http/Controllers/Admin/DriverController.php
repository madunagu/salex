<?php

namespace Salex\Driver\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Salex\Driver\DataGrids\DriverDataGrid;
use Salex\Driver\DataGrids\DriverShipmentDataGrid;
use Salex\Driver\Repositories\DriverRepository;

class DriverController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

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
    public function __construct(protected DriverRepository $driverRepository)
    {
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
            return app(DriverDataGrid::class)->toJson();
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
        try {
            $this->validate(request(), [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                // 'address' => 'required|max:255',
                'email' => 'required|email|max:255|unique:drivers',
                'phone' => 'max:255|unique:drivers',
                // 'password' => 'required|min:6|confirmed',
            ]);

            // $driver = Driver::create((request()->all()));
            $driver = $this->driverRepository->create(request()->all());
            // $driver = new Driver;
            // $driver->full_name = $request->input('full_name');
            // $driver->cnic = $request->input('cnic');
            // $driver->address = $request->input('address');
            // $driver->email = $request->input('email');
            // $driver->phone = $request->input('phone');
            // $driver->password = bcrypt($request->input('password'));
            // $driver->save();
            session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Driver']));


            return redirect()->route($this->_config['redirect']);
        } catch (ValidationException $e) {
            if ($firstError = collect($e->errors())->first()) {
                session()->flash('error', $firstError[0]);
            }
        }
        return redirect()->back()->withInput(request()->all())->withErrors($e->errors());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            return app(DriverShipmentDataGrid::class)->toJson();
        }
        
        $driver = $this->driverRepository->findOneWhere(['id' => $id]);

        if (!$driver) {
            abort(404);
        }
        return view($this->_config['view'], array_merge(compact('driver'), [
            'defaultCountry' => config('app.default_country'),
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        try {
            $this->validate(request(), [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                // 'address' => 'required|max:255',
                'email' => "required|email|max:255|unique:drivers,email,$id",
                'phone' => "max:255|unique:drivers,phone,$id",
                'status' => "boolean",
                // 'password' => 'required|min:6|confirmed',
            ]);
            // $data['address1'] = implode(PHP_EOL, array_filter(request()->input('address1')));
            $driver = $this->driverRepository->findOneWhere(['id' => $id]);
            if (!$driver) {
                abort(404);
            }

            $data = request()->all();
            $data['status'] = ! isset($data['status']) ? 0 : 1;
            $data['is_suspended'] = ! isset($data['is_suspended']) ? 0 : 1;
            $this->driverRepository->update($data, $id);

            session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Driver']));

            return redirect()->route($this->_config['redirect']);
        } catch (ValidationException $e) {
            if ($firstError = collect($e->errors())->first()) {
                session()->flash('error', $firstError[0]);
            }
        }
        return redirect()->back()->withInput(request()->all())->withErrors($e->errors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }


    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        $driverIds = explode(',', request()->input('indexes'));

        foreach ($driverIds as $driverId) {
            $driver = $this->driverRepository->find($driverId);

            if (isset($driver)) {
                $this->driverRepository->delete($driverId);
            }
        }

        session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Drivers']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function massUpdate()
    {
        $data = request()->all();

        if (!isset($data['massaction-type'])) {
            return redirect()->back();
        }

        if (!$data['massaction-type'] == 'update') {
            return redirect()->back();
        }

        $driverIds = explode(',', request()->input('indexes'));

        foreach ($driverIds as $driverId) {
            $driver = $this->driverRepository->find($driverId);

            if (isset($driver)) {
                if ($data['update-options'] == 1) {
                    $driver->activate();
                } else {
                    $driver->inactivate();
                }
                // $this->driverRepository->delete($driverId);
            }
        }
        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Drivers']));

        return redirect()->route($this->_config['redirect']);
    }
}
