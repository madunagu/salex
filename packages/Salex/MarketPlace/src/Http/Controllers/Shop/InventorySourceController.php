<?php

namespace Salex\MarketPlace\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Salex\MarketPlace\Datagrids\InventorySourceDataGrid;
use Webkul\Inventory\Http\Requests\InventorySourceRequest;
use Webkul\Inventory\Repositories\InventorySourceRepository;

class InventorySourceController extends Controller
{

    /**
     * Contains route related configuration.
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Inventory\Repositories\InventorySourceRepository  $inventorySourceRepository
     * @return void
     */
    public function __construct(protected InventorySourceRepository $inventorySourceRepository)
    {
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
            return app(InventorySourceDataGrid::class)->toJson();
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
    public function store(InventorySourceRequest $inventorySourceRequest)
    {
        $data = $inventorySourceRequest->all();

        $data['vendor_id'] = auth()->guard('merchant')->user()->store_id;

        $data['status'] = !isset($data['status']) ? 0 : 1;

        if (auth()->guard('merchant')->user()->store_id >= 1) {
            $inventorySource = $this->inventorySourceRepository->create($data);

            $inventorySource->vendor_id = auth()->guard('merchant')->user()->store_id;
            $inventorySource->save();
            session()->flash('success', trans('admin::app.settings.inventory_sources.create-success'));

            return redirect()->route($this->_config['redirect']);
        }

        session()->flash('error', trans('marketplace::app.create-error', ['name' => 'Inventory source']));
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $inventorySource = $this->inventorySourceRepository->findOrFail($id);

        return view($this->_config['view'], compact('inventorySource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InventorySourceRequest $inventorySourceRequest, $id)
    {
        $data = $inventorySourceRequest->all();

        $data['status'] = !isset($data['status']) ? 0 : 1;

        $inventorySource = $this->inventorySourceRepository->findOrFail($id);

        if ($inventorySource->vendor_id ==  auth()->guard('merchant')->user()->store_id && auth()->guard('merchant')->user()->store_id >= 0) {
            $this->inventorySourceRepository->update($data, $id);

            session()->flash('success', trans('admin::app.settings.inventory_sources.update-success'));

            return redirect()->route($this->_config['redirect']);
        }
        session()->flash('error', trans('marketplace::app.update-error', ['name' => 'Inventory source']));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->inventorySourceRepository->findOrFail($id);

        if ($this->inventorySourceRepository->count() == 1) {
            return response()->json(['message' => trans('admin::app.settings.inventory_sources.last-delete-error')], 400);
        }

        try {
            $this->inventorySourceRepository->delete($id);

            return response()->json(['message' => trans('admin::app.settings.inventory_sources.delete-success')]);
        } catch (\Exception $e) {
            report($e);
        }

        return response()->json(['message' => trans('admin::app.response.delete-failed', ['name' => 'Inventory source'])], 500);
    }
}
