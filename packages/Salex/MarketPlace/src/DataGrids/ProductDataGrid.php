<?php

namespace Salex\MarketPlace\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Core\Models\Channel;
use Webkul\Core\Models\Locale;
use Webkul\Ui\DataGrid\DataGrid;

class ProductDataGrid extends DataGrid
{
    /**
     * Default sort order of datagrid.
     *
     * @var string
     */
    protected $sortOrder = 'desc';

    /**
     * Set index columns, ex: id.
     *
     * @var string
     */
    protected $index = 'product_id';

    /**
     * If paginated then value of pagination.
     *
     * @var int
     */
    protected $itemsPerPage = 10;

    /**
     * Locale.
     *
     * @var string
     */
    protected $locale = 'all';

    /**
     * Channel.
     *
     * @var string
     */
    protected $channel = 'all';

    /**
     * Contains the keys for which extra filters to show.
     *
     * @var string[]
     */
    protected $extraFilters = [
        'channels',
        'locales',
    ];

    protected $enableMassAction = true;
    protected $enableAction = true;
    /**
     * Create datagrid instance.
     *
     * @return void
     */
    public function __construct()
    {
        /* locale */
        $this->locale = core()->getRequestedLocaleCode();

        /* channel */
        $this->channel = core()->getRequestedChannelCode();

        /* parent constructor */
        parent::__construct();
    }

    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        if ($this->channel === 'all') {
            $whereInChannels = Channel::query()->pluck('code')->toArray();
        } else {
            $whereInChannels = [$this->channel];
        }

        if ($this->locale === 'all') {
            $whereInLocales = Locale::query()->pluck('code')->toArray();
        } else {
            $whereInLocales = [$this->locale];
        }





        /* query builder */
        $queryBuilder = DB::table('product_flat')
            ->leftJoin('products', 'products.id', '=', 'product_flat.product_id')
            ->leftJoin('attribute_families', 'product_flat.attribute_family_id', '=', 'attribute_families.id')
            ->leftJoin('product_inventories', 'product_flat.product_id', '=', 'product_inventories.product_id')
            ->select(
                'product_flat.locale',
                'product_flat.channel',
                'product_flat.product_id',
                'product_flat.sku as product_sku',
                'product_flat.product_number',
                'product_flat.name as product_name',
                'product_flat.type as product_type',
                'product_flat.status',
                'product_flat.price',
                'product_flat.url_key',
                'product_flat.visible_individually',
                'attribute_families.name as attribute_family',
                DB::raw('SUM(' . DB::getTablePrefix() . 'product_inventories.qty) as quantity')
            );

        $queryBuilder->groupBy('product_flat.product_id', 'product_flat.locale', 'product_flat.channel');

        $queryBuilder->whereIn('product_flat.locale', $whereInLocales);
        $queryBuilder->whereIn('product_flat.channel', $whereInChannels);        
        $queryBuilder->where('products.vendor_id', auth()->guard('merchant')->user()->store_id);


        $this->addFilter('product_id', 'product_flat.product_id');
        $this->addFilter('product_name', 'product_flat.name');
        $this->addFilter('product_sku', 'product_flat.sku');
        $this->addFilter('product_number', 'product_flat.product_number');
        $this->addFilter('status', 'product_flat.status');
        $this->addFilter('product_type', 'product_flat.type');
        $this->addFilter('attribute_family', 'attribute_families.name');

        $this->setQueryBuilder($queryBuilder);

        // /* query builder */
        // $queryBuilder = DB::table('products')
        //     ->leftJoin('product_flat', 'product_flat.product_id', '=', 'products.id')
        //     ->leftJoin('attribute_families', 'products.attribute_family_id', '=', 'attribute_families.id')
        //     ->leftJoin('product_inventories', 'product_flat.product_id', '=', 'product_inventories.product_id')
        //     ->select(
        //         'product_flat.locale',
        //         'product_flat.channel',
        //         'product_flat.product_id',
        //         'products.sku as product_sku',
        //         'product_flat.product_number',
        //         'product_flat.name as product_name',
        //         'products.type as product_type',
        //         'product_flat.status',
        //         'product_flat.price',
        //         'product_flat.url_key',
        //         'attribute_families.name as attribute_family',
        //         DB::raw('SUM(' . DB::getTablePrefix() . 'product_inventories.qty) as quantity')
        //     );

        // $queryBuilder->groupBy('product_flat.product_id', 'product_flat.locale', 'product_flat.channel');

        // $queryBuilder->whereIn('product_flat.locale', $whereInLocales);
        // $queryBuilder->whereIn('product_flat.channel', $whereInChannels);
        // $queryBuilder->where('products.vendor_id', auth()->guard('merchant')->user()->store_id);


        // $this->addFilter('product_id', 'product_flat.product_id');
        // $this->addFilter('product_name', 'product_flat.name');
        // $this->addFilter('product_sku', 'products.sku');
        // $this->addFilter('product_number', 'product_flat.product_number');
        // $this->addFilter('status', 'product_flat.status');
        // $this->addFilter('product_type', 'products.type');
        // $this->addFilter('attribute_family', 'attribute_families.name');

        // $this->setQueryBuilder($queryBuilder);
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'product_id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'product_sku',
            'label'      => trans('admin::app.datagrid.sku'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'product_number',
            'label'      => trans('admin::app.datagrid.product-number'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'product_name',
            'label'      => trans('admin::app.datagrid.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($row) {
                if (!empty($row->url_key)) {
                    return "<a href='" . route('shop.productOrCategory.index', $row->url_key) . "' target='_blank'>" . $row->product_name . "</a>";
                }

                return $row->product_name;
            },
        ]);

        $this->addColumn([
            'index'      => 'attribute_family',
            'label'      => trans('admin::app.datagrid.attribute-family'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'product_type',
            'label'      => trans('admin::app.datagrid.type'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('admin::app.datagrid.status'),
            'type'       => 'boolean',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
            'closure'    => function ($value) {
                $html = '';

                if ($value->status == 1) {
                    $html .= '<span class="badge badge-md badge-success">' . trans('admin::app.datagrid.active') . '</span>';
                } else {
                    $html .= '<span class="badge badge-md badge-danger">' . trans('admin::app.datagrid.inactive') . '</span>';
                }

                return $html;
            },
        ]);

        $this->addColumn([
            'index'      => 'price',
            'label'      => trans('admin::app.datagrid.price'),
            'type'       => 'price',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'quantity',
            'label'      => trans('admin::app.datagrid.qty'),
            'type'       => 'number',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => false,
            // 'closure'    => function ($row) {
            //     if (is_null($row->quantity)) {
            //         return 0;
            //     } else {
            //         return $this->renderQuantityView($row);
            //     }
            // },
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        $this->addAction([
            'title'     => trans('admin::app.datagrid.edit'),
            'method'    => 'GET',
            'route'     => 'merchant.products.update',
            'icon'      => 'icon pencil-lg-icon',
            'condition' => function () {
                return true;
            },
        ], true);

        $this->addAction([
            'title'        => trans('admin::app.datagrid.delete'),
            'method'       => 'POST',
            'route'        => 'merchant.products.delete',
            'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'product']),
            'icon'         => 'icon trash-icon',
        ], true);

        $this->addAction([
            'title'  => trans('admin::app.datagrid.copy'),
            'method' => 'GET',
            'route'  => 'merchant.products.copy',
            'icon'   => 'icon copy-icon',
        ], true);
    }

    /**
     * Prepare mass actions.
     *
     * @return void
     */
    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('admin::app.datagrid.delete'),
            'action' => route('merchant.products.massdelete'),
            'method' => 'POST',
        ], true);

        $this->addMassAction([
            'type'    => 'update',
            'label'   => trans('admin::app.datagrid.update-status'),
            'action'  => route('merchant.products.massupdate'),
            'method'  => 'POST',
            'options' => [
                trans('admin::app.datagrid.active')    => 1,
                trans('admin::app.datagrid.inactive')  => 0,
            ],
        ], true);
    }

    /**
     * Render quantity view.
     *
     * @param  object  $row
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    private function renderQuantityView($row)
    {
        $product = app(\Webkul\Product\Repositories\ProductRepository::class)->find($row->product_id);

        $inventorySources = app(\Webkul\Inventory\Repositories\InventorySourceRepository::class)->findWhere(['status' => 1]);

        $totalQuantity = $row->quantity;

        return view('admin::catalog.products.datagrid.quantity', compact('product', 'inventorySources', 'totalQuantity'))->render();
    }
}
