<?php

namespace Salex\MarketPlace\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Salex\MarketPlace\Repositories\StoreRepository;
use Salex\MarketPlace\Models\Store;
use Webkul\Customer\Repositories\CustomerRepository;
use Salex\MarketPlace\Repositories\MerchantRepository;
use Illuminate\Support\Facades\Auth;
use Salex\MarketPlace\Models\Merchant;

class StoreController extends Controller
{
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
        protected MerchantRepository $merchantRepository
    ) {
        $this->_config = request('_config');
  
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $store_id =Auth::guard('merchant')->user()->store_id;
        $store = $this->storeRepository->find($store_id);
        return view($this->_config['view'])->with('store', $store);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $categories = $this->category->all();
        $merchant = Auth::guard('merchant')->user();
        $store_id =$merchant->store_id;
     
        $store = $this->storeRepository->find($store_id);
        if (!empty($store)) {
            return redirect()->route('merchant.store.update');
        }

        $categories = [];
        return view($this->_config['view'], compact(['merchant', 'categories']));
    }

    /**
     * Show the form for updating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        // $categories = $this->category->all();
        $merchant = Auth::guard('merchant')->user();
        $store_id =$merchant->store_id;
     
        $store = $this->storeRepository->find($store_id);

        $categories = [];
        return view($this->_config['view'], compact(['store', 'categories']));
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

        $merchant =   Auth::guard('merchant')->user();
     
        $data['owner_id'] = $merchant->id;
        $store_id = $merchant->store_id;
        $store = $this->storeRepository->find($store_id);

        if (!empty($store)) {
            session()->flash('warning', trans('marketplace::app.messages.already-exists', ['name' => 'Store']));
            return redirect()->route('merchant.store.update');
        }

        $store = $this->storeRepository->create($data);

        $merchant->store_id = $store->id;
        $merchant->save();


        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Store']));
        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
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
        $store_id =   Auth::guard('merchant')->user()->store_id;

        $store = $this->storeRepository->find($store_id);

        if (empty($store)) {
            $store = $this->storeRepository->create($data);

            session()->flash('warning', trans('admin::app.response.create-success', ['name' => 'Store']));

            return redirect()->route($this->_config['redirect']);
        }

        $store = $this->storeRepository->update($data, $store_id);


        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Store']));


        return redirect()->route($this->_config['redirect']);
    }
}
