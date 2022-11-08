<?php

namespace Salex\Driver\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Salex\Driver\DataGrids\VehicleDataGrid;
use Salex\Driver\Repositories\DriverRepository;
use Salex\Driver\Repositories\VehicleRepository;
use Illuminate\Validation\ValidationException;
use Exception;

class VehicleController extends Controller
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
        protected DriverRepository $driverRepository,
        protected VehicleRepository $vehicleRepository,
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
            return app(VehicleDataGrid::class)->toJson();
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
        $driver = $this->driverRepository->find(request('id'));

        return view($this->_config['view'], compact('driver'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        try {
            $driver = $this->driverRepository->find($id);
            $this->validate(request(), [
                'type' => 'required|max:255',
                'plate_no' => 'required|max:255|unique:vehicles',
                'vin_no' => 'required|max:255|unique:vehicles',
                // 'address' => 'required|max:255',
                'color' => 'required|max:255',
                'year' => 'max:255',
                'model' => 'max:255',
                'owned_by_driver' => 'boolean',
                // 'password' => 'required|min:6|confirmed',
            ]);
            $data = request()->all();
            $data['driver_id'] = $driver->id;

            $vehicle = $this->vehicleRepository->create($data);
            session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Vehicle']));

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
        $vehicle = $this->vehicleRepository->findOneWhere(['id' => $id]);

        if (!$vehicle) {
            abort(404);
        }
        return view($this->_config['view'], array_merge(compact('vehicle'), [
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
            // $driver = $this->driverRepository->find($id);
            $this->validate(request(), [
                'type' => 'required|max:255',
                'plate_no' => "required|max:255|unique:vehicles,plate_no,$id",
                'vin_no' => "required|max:255|unique:vehicles,vin_no,$id",
                'color' => 'required|max:255',
                'year' => 'max:255',
                'model' => 'max:255',
                'owned_by_driver' => 'boolean',
            ]);
            // $data['address1'] = implode(PHP_EOL, array_filter(request()->input('address1')));
            $vehicle = $this->vehicleRepository->findOneWhere(['id' => $id]);
            if (!$vehicle) {
                abort(404);
            }

            $data = request()->all();
            // $data['driver_id'] = $driver->id;
            $this->vehicleRepository->update($data, $id);

            session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Vehicle']));

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
        $vehicle = $this->vehicleRepository->findOrFail($id);

        try {
            $this->vehicleRepository->delete($id);

            return response()->json([
                'message' => trans('admin::app.response.delete-success', ['name' => 'Vehicle']),
            ]);
        } catch (Exception $e) {
            report($e);
        }

        return response()->json([
            'message' => trans('admin::app.response.delete-failed', ['name' => 'Vehicle']),
        ], 500);
    }

        /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        $vehicleIds = explode(',', request()->input('indexes'));

        foreach ($vehicleIds as $vehicleId) {
            $vehicle = $this->vehicleRepository->find($vehicleId);

            if (isset($vehicle)) {
                $this->vehicleRepository->delete($vehicleId);
            }
        }

        session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Vehicle']));

        return redirect()->route($this->_config['redirect']);
    }

}
