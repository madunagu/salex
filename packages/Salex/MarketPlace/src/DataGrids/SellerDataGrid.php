<?php

namespace Salex\MarketPlace\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class SellerDataGrid extends DataGrid
{
    /**
     * Index.
     *
     * @var string
     */
    protected $index = 'customer_id';

    /**
     * Sort order.
     *
     * @var string
     */
    protected $sortOrder = 'desc';

    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('merchants')
            ->leftJoin('stores', 'merchants.store_id', '=', 'stores.id')
            ->leftJoin('store_translations', 'merchants.store_id', '=', 'store_translations.store_id')
            ->addSelect('merchants.id as customer_id', 'merchants.store_id as store_id', 'merchants.email', 'merchants.phone', 'stores.status as status', 'store_translations.name as store_name')
            ->addSelect(DB::raw('CONCAT(' . DB::getTablePrefix() . 'merchants.first_name, " ", ' . DB::getTablePrefix() . 'merchants.last_name) as full_name'))
            ->where('merchants.store_id', '<>', '0')
            ->whereNotNull('stores.url');

        $this->addFilter('full_name', DB::raw('CONCAT(' . DB::getTablePrefix() . 'merchants.first_name, " ", ' . DB::getTablePrefix() . 'merchants.last_name)'));

        $this->setQueryBuilder($queryBuilder);
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'store_id',
            'label'      => trans('marketplace::app.sellers.seller_id'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'full_name',
            'label'      => trans('admin::app.datagrid.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'email',
            'label'      => trans('admin::app.datagrid.email'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'store_name',
            'label'      => trans('marketplace::app.sellers.store-name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'phone',
            'label'      => trans('admin::app.datagrid.phone'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,

        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('shop::app.customer.account.order.index.status'),
            'type'       => 'checkbox',
            'options'    => [
                'approved'      => trans('marketplace::app.sellers.approved'),
                'pending'       => trans('marketplace::app.sellers.pending'),
            ],
            'searchable' => false,
            'sortable'   => true,
            'closure'    => function ($value) {
                if ($value->status == '1') {
                    return '<span class="badge badge-md badge-success">' .  trans('marketplace::app.sellers.approved') . '</span>';
                } elseif ($value->status == '0') {
                    return '<span class="badge badge-md badge-warning">' .  trans('marketplace::app.sellers.pending') . '</span>';
                }
            },
            'filterable' => true,
        ]);
    }
    /**
     * Prepare mass actions.
     *
     * @return void
     */
    public function prepareMassActions()
    {
        // $this->addMassAction([
        //     'type'   => 'delete',
        //     'label'  => trans('admin::app.datagrid.delete'),
        //     'action' => route('admin.sales.sellers.mass-destroy'),
        //     'method' => 'POST',
        // ],true);

        // $this->addMassAction([
        //     'type'    => 'update',
        //     'label'   => trans('admin::app.datagrid.update-status'),
        //     'action'  => route('admin.sales.sellers.mass-update'),
        //     'method'  => 'POST',
        //     'options' => [
        //         trans('marketplace::app.sellers.approved')    => 1,
        //         trans('marketplace::app.sellers.pending')  => 0,
        //     ],
        // ],true);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        $this->addAction([
            'type'   => 'View',
            'method' => 'GET',
            'route'  => 'admin.customer.edit',
            'icon'   => 'icon pencil-lg-icon',
            'title'  => trans('admin::app.customers.customers.edit-help-title'),
        ], true);
    }
}
