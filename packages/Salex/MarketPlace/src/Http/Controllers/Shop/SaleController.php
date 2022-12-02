<?php

namespace Salex\MarketPlace\Http\Controllers\Shop;

use Illuminate\Support\Facades\Event;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Salex\MarketPlace\DataGrids\ProductDataGrid;
use Salex\MarketPlace\DataGrids\SaleOrderDataGrid;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Product\Models\Product;
use Webkul\Core\Contracts\Validations\Slug;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Product\Http\Requests\ProductForm;
use Webkul\Inventory\Repositories\InventorySourceRepository;
use Webkul\Product\Helpers\ProductType;
use Webkul\Attribute\Repositories\AttributeFamilyRepository;
use Exception;
use Webkul\Sales\Repositories\OrderRepository;

class SaleController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    protected $merchant;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected ProductRepository $productRepository,
        protected CategoryRepository $categoryRepository,
        protected AttributeFamilyRepository $attributeFamilyRepository,
        protected InventorySourceRepository $inventorySourceRepository,
        protected OrderRepository $orderRepository,
    ) {
        $this->_config = request('_config');
        $this->merchant = auth()->guard('merchant')->user();
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
    public function products()
    {
        if (request()->ajax()) {
            return app(ProductDataGrid::class)->toJson();
        }
        return view($this->_config['view']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function create_product()
    {
        $store_id = auth()->guard('merchant')->user()->store_id;

        $inventorySourcesNumber = $this->inventorySourceRepository->where('vendor_id', $store_id)->count();

        if ($inventorySourcesNumber < 1) {
            session()->flash('error', trans('marketplace::app.messages.create-inventory-source'));

            return redirect()->route('merchant.inventory_sources.create');
        }

        $families = $this->attributeFamilyRepository->all();

        $configurableFamily = null;

        if ($familyId = request()->get('family')) {
            $configurableFamily = $this->attributeFamilyRepository->find($familyId);
        }

        return view($this->_config['view'], compact('families', 'configurableFamily'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_product()
    {
        if (
            !request()->get('family')
            && ProductType::hasVariants(request()->input('type'))
            && request()->input('sku') != ''
        ) {
            return redirect(url()->current() . '?type=' . request()->input('type') . '&family=' . request()->input('attribute_family_id') . '&sku=' . request()->input('sku'));
        }

        if (
            ProductType::hasVariants(request()->input('type'))
            && (!request()->has('super_attributes')
                || !count(request()->get('super_attributes')))
        ) {
            session()->flash('error', trans('admin::app.catalog.products.configurable-error'));

            return back();
        }

        $this->validate(request(), [
            'type'                => 'required',
            'attribute_family_id' => 'required',
            'sku'                 => ['required', 'unique:products,sku', new Slug],
        ]);

        $data = request()->all();

        $this->merchant = auth()->guard('merchant')->user();

        // $data['vendor_id'] = $this->merchant->store_id;

        $product = $this->productRepository->create($data);

        $product->vendor_id = $this->merchant->store_id;

        $product->save();

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Product']));

        return redirect()->route($this->_config['redirect'], ['id' => $product->id]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function update_product($id)
    {

        $product = $this->productRepository->with(['variants', 'variants.inventories'])->findOrFail($id);
        $this->merchant = auth()->guard('merchant')->user();

        $inventorySources = $this->inventorySourceRepository->findWhere(['status' => 1])->whereIn('vendor_id', [0, $this->merchant->store_id]);
        if ($inventorySources < 1) {
            session()->flash('error', trans('marketplace::app.messages.create-inventory-source'));

            return redirect()->route('merchant.inventory_sources.create');
        }
        $categories = $this->categoryRepository->getCategoryTree();

        return view($this->_config['view'], compact('product', 'categories', 'inventorySources'));
    }

    /** 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_product($id)
    {
        $product = $this->productRepository->findOrFail($id);

        try {
            $this->productRepository->delete($id);

            return response()->json([
                'message' => trans('admin::app.response.delete-success', ['name' => 'Product']),
            ]);
        } catch (Exception $e) {
            report($e);
        }

        return response()->json([
            'message' => trans('admin::app.response.delete-failed', ['name' => 'Product']),
        ], 500);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Webkul\Product\Http\Requests\ProductForm  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductForm $request, $id)
    {
        Event::dispatch('catalog.product.update.before', $id);

        $data = $request->all();
        $data['locale'] = 'en';

        $product = $this->productRepository->update($data, $id);

        Event::dispatch('catalog.product.update.after', $product);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Product']));

        return redirect()->route($this->_config['redirect']);
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

        $productIds = explode(',', $data['indexes']);

        foreach ($productIds as $productId) {
            $this->productRepository->update([
                'channel' => null,
                'locale'  => null,
                'status'  => $data['update-options'],
            ], $productId);
        }

        session()->flash('success', trans('admin::app.catalog.products.mass-update-success'));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Mass delete the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        $productIds = explode(',', request()->input('indexes'));

        foreach ($productIds as $productId) {
            $product = $this->productRepository->find($productId);

            if (isset($product)) {
                $this->productRepository->delete($productId);
            }
        }

        session()->flash('success', trans('admin::app.catalog.products.mass-delete-success'));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Copy a given Product.
     *
     * @param  int  $productId
     * @return \Illuminate\Http\Response
     */
    public function copy(int $productId)
    {
        $originalProduct = $this->productRepository->findOrFail($productId);

        if (!$originalProduct->getTypeInstance()->canBeCopied()) {
            session()->flash(
                'error',
                trans('admin::app.response.product-can-not-be-copied', [
                    'type' => $originalProduct->type,
                ])
            );

            return redirect()->to(route('merchant.products.index'));
        }

        if ($originalProduct->parent_id) {
            session()->flash(
                'error',
                trans('admin::app.catalog.products.variant-already-exist-message')
            );

            return redirect()->to(route('merchant.products.index'));
        }

        $copiedProduct = $this->productRepository->copy($originalProduct);

        if ($copiedProduct instanceof Product && $copiedProduct->id) {
            session()->flash('success', trans('admin::app.response.product-copied'));
        } else {
            session()->flash('error', trans('admin::app.response.error-while-copying'));
        }

        return redirect()->to(route('merchant.products.update', ['id' => $copiedProduct->id]));
    }



    /**
     * Display a listing of the sold orders.
     *
     * @return \Illuminate\View\View
     */

    public function orders()
    {
        if (request()->ajax()) {
            return app(SaleOrderDataGrid::class)->toJson();
        }
        return view($this->_config['view']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function viewOrder($id)
    {
        $order = $this->orderRepository->findOrFail($id);

        return view($this->_config['view'], compact('order'));
    }
}
