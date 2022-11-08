<?php

namespace Salex\MarketPlace\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use Salex\MarketPlace\DataGrids\SellerDataGrid;
use Salex\MarketPlace\Repositories\StoreRepository;

class MarketPlaceController extends Controller
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
    public function __construct(
        protected StoreRepository $storeRepository,
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
        return view($this->_config['view']);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function seller()
    {
        if (request()->ajax()) {
            return app(SellerDataGrid::class)->toJson();
        }
        return view($this->_config['view']);
    }


     /**
     * Mass update the products.
     *
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

        $storeIds = explode(',', $data['indexes']);
        Log::info($storeIds);
        
        foreach ($storeIds as $storeId) {
            // $this->storeRepository->update([
            //     // 'channel' => null,
            //     // 'locale'  => null,
            //     'status'  => $data['update-options'],
            // ], $storeId);
            $store = $this->storeRepository->find($storeId);
            if ($data['update-options'] == 1) {
                $store->activate();
            } else {
                $store->inactivate();
            }
            $store->save();
        }

        session()->flash('success', trans('admin::app.catalog.products.mass-update-success'));

        return redirect()->route($this->_config['redirect']);
    }

        /**
     * Approve Specified Store by Admin
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $store =  $this->storeRepository->find($id);
        $store->activate();

        return response()->json([
            'redirect' => false,
            'message' => trans('marketplace::app.store.approve')
        ]);
    }

        /**
     * Approve Specified Store by Admin
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disapprove($id)
    {
        $store =  $this->storeRepository->find($id);
        $store->inactivate();

        return response()->json([
            'redirect' => false,
            'message' => trans('marketplace::app.store.disapprove')
        ]);
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
        $store =  $this->storeRepository->find($id);
        $store->delete();

        return response()->json([
            'redirect' => false,
            'message' => trans('marketplace::app.store.disapprove')
        ]);
    }


        /**
     * Mass delete the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        $sellerIds = explode(',', request()->input('indexes'));

        foreach ($sellerIds as $sellerId) {
            $seller = $this->storeRepository->find($sellerId);

            if (isset($seller)) {
                $this->storeRepository->delete($sellerId);
            }
        }

        session()->flash('success', trans('marketplace::app.sales.stores.mass-delete-success'));

        return redirect()->route($this->_config['redirect']);
    }
}
