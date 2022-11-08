<?php

namespace Salex\MarketPlace\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Salex\MarketPlace\DataGrids\StoreDataGrid;
use Salex\MarketPlace\Repositories\StoreRepository;

class StoreController extends Controller
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
    public function __construct(protected StoreRepository $storeRepository )
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
            return app(StoreDataGrid::class)->toJson();
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
        $categories = [];
        return view($this->_config['view'], compact(['categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'name'    => 'string|required',
            'url'     => 'string|required',
            'category_id' => 'number',
            'tax_number' => 'string',
            'featured' => 'bool',
            'is_physical' => 'bool',
            'phone' => 'string|required',
            'geolocation' => 'string',
            'is_visible' => 'bool',
            'facebook' => 'string',
            'twitter' => 'string',
            'instagram' => 'string',
            'telegram' => 'string',
            'state_id' => 'number',
            'description' => 'string|required',
        ]);

        $data = request()->all();

        if (!key_exists('featured', $data)) {
            $data['featured'] = 0;
        }
        if (!key_exists('is_physical', $data)) {
            $data['is_physical'] = 0;
        }
        if (!key_exists('is_visible', $data)) {
            $data['is_visible'] = 0;
        }
        $store = $this->storeRepository->create($data);

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Store']));
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
        $store = $this->storeRepository->find($id);

        if (!$store) {
            abort(404);
        }
        return view($this->_config['view'], compact(['store']));
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
            'name'    => 'string|required',
            'url'     => 'string|required',
            'category_id' => 'number',
            'tax_number' => 'string',
            'featured' => 'bool',
            'is_physical' => 'bool',
            'phone' => 'string|required',
            'geolocation' => 'string',
            'is_visible' => 'bool',
            'facebook' => 'string',
            'twitter' => 'string',
            'instagram' => 'string',
            'telegram' => 'string',
            'state_id' => 'number',
            'description' => 'string|required',
        ]);

        $data = request()->all();
        if (!key_exists('featured', $data)) {
            $data['featured'] = 0;
        }
        if (!key_exists('is_physical', $data)) {
            $data['is_physical'] = 0;
        }
        if (!key_exists('is_visible', $data)) {
            $data['is_visible'] = 0;
        }
        $store = $this->storeRepository->find($id);

        if (!$store) {
            abort(404);
        }
        $store = $this->storeRepository->update($data, $id);


        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Store']));


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
    }
}
