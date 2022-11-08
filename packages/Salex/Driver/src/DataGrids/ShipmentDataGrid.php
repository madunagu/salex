<?php

namespace Salex\Driver\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Sales\Models\OrderAddress;
use Webkul\Ui\DataGrid\DataGrid;
use Salex\Driver\Repositories\DriverRepository;
use Illuminate\Support\Facades\Log; 

class ShipmentDataGrid extends DataGrid
{
    protected $index = 'shipment_id';

    protected $sortOrder = 'desc';

    protected $drivers = [];

    /**
     * Create a new datagrid instance.
     *
     * @param  \Salex\Driver\Repositories\DriverRepository $driverRepository
     * @return void
     */
    public function __construct(protected DriverRepository $driverRepository)
    {
        parent::__construct();
    }

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('shipments')
            ->leftJoin('addresses as order_address_shipping', function ($leftJoin) {
                $leftJoin->on('order_address_shipping.order_id', '=', 'shipments.order_id')
                    ->where('order_address_shipping.address_type', OrderAddress::ADDRESS_TYPE_SHIPPING);
            })
            ->leftJoin('orders as ors', 'shipments.order_id', '=', 'ors.id')
            ->leftJoin('drivers', 'shipments.driver_id', '=', 'drivers.id')
            ->leftJoin('inventory_sources as is', 'shipments.inventory_source_id', '=', 'is.id')
            ->select('shipments.id as shipment_id', 'ors.increment_id as shipment_order_id', 'shipments.total_qty as shipment_total_qty', 'ors.created_at as order_date', 'shipments.created_at as shipment_created_at', 'shipments.status as shipment_status', 'shipments.driver_id as driver_id','drivers.first_name','drivers.last_name')
            ->addSelect(DB::raw('CONCAT(' . DB::getTablePrefix() . 'order_address_shipping.first_name, " ", ' . DB::getTablePrefix() . 'order_address_shipping.last_name) as shipped_to'))    
            ->addSelect(DB::raw('CONCAT(' . DB::getTablePrefix() . 'drivers.first_name, " ", ' . DB::getTablePrefix() . 'drivers.last_name) as driver_full_name'))
            ->selectRaw('IF(' . DB::getTablePrefix() . 'shipments.inventory_source_id IS NOT NULL,' . DB::getTablePrefix() . 'is.name, ' . DB::getTablePrefix() . 'shipments.inventory_source_name) as inventory_source_name');

        $this->addFilter('shipment_id', 'shipments.id');
        $this->addFilter('shipment_order_id', 'ors.increment_id');
        $this->addFilter('shipment_total_qty', 'shipments.total_qty');
        $this->addFilter('inventory_source_name', DB::raw('IF(' . DB::getTablePrefix() . 'shipments.inventory_source_id IS NOT NULL,' . DB::getTablePrefix() . 'is.name, ' . DB::getTablePrefix() . 'shipments.inventory_source_name)'));
        $this->addFilter('order_date', 'ors.created_at');
        $this->addFilter('shipment_created_at', 'shipments.created_at');
        $this->addFilter('shipped_to', DB::raw('CONCAT(' . DB::getTablePrefix() . 'order_address_shipping.first_name, " ", ' . DB::getTablePrefix() . 'order_address_shipping.last_name)'));

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'shipment_id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'shipment_order_id',
            'label'      => trans('admin::app.datagrid.order-id'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'shipment_total_qty',
            'label'      => trans('admin::app.datagrid.total-qty'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'inventory_source_name',
            'label'      => trans('admin::app.datagrid.inventory-source'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        // $this->addColumn([
        //     'index'      => 'order_date',
        //     'label'      => trans('admin::app.datagrid.order-date'),
        //     'type'       => 'datetime',
        //     'sortable'   => true,
        //     'searchable' => false,
        //     'filterable' => true,
        // ]);

        $this->addColumn([
            'index'      => 'shipment_created_at',
            'label'      => trans('admin::app.datagrid.shipment-date'),
            'type'       => 'datetime',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'shipped_to',
            'label'      => trans('admin::app.datagrid.shipment-to'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'driver_full_name',
            'label'      => trans('driver::app.shipments.assigned-to'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'shipment_status',
            'label'      => trans('admin::app.datagrid.status'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($row) {
                $html = '';

                if ($row->shipment_status == 'delivered') {
                    $html .= '<span class="badge badge-md badge-success">' . trans('driver::app.shipments.status.delivered') . '</span>';
                } elseif ($row->shipment_status == 'transit') {
                    $html .= '<span class="badge badge-md badge-info">' . trans('driver::app.shipments.status.transit') . '</span>';
                } elseif ($row->shipment_status == 'failed') {
                    $html .= '<span class="badge badge-md badge-danger">' . trans('driver::app.shipments.status.failed') . '</span>';
                } else {
                    $html .= '<span class="badge badge-md badge-warning">' . trans('driver::app.shipments.status.pending') . '</span>';
                }

                return $html;
            },
        ]);

        $this->addColumn([
            'index'      => 'assigned',
            'label'      => trans('driver::app.shipments.assigned.assigned'),
            'type'       => 'boolean',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($row) {
                $html = '';

                if ($row->driver_id == 0) {
                    $html .= '<span class="badge badge-md badge-warning">' . trans('driver::app.shipments.assigned.pending') . '</span>';
                } else {
                    $html .= '<span class="badge badge-md badge-success">' . trans('driver::app.shipments.assigned.assigned') . '</span>';
                }
                return $html;
            },
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('admin::app.datagrid.view'),
            'method' => 'GET',
            'route'  => 'admin.sales.shipments.view',
            'icon'   => 'icon eye-icon',
        ]);
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
            'action' => route('admin.driver.mass-destroy'),
            'method' => 'POST',
        ]);

        $this->addMassAction([
            'type'    => 'update',
            'label'   => trans('driver::app.shipments.assign'),
            'action'  => route('admin.shipments.mass-assign'),
            'method'  => 'POST',
            'options' => $this->listDrivers(),

        ]);
    }

    protected function listDrivers(): array
    {
        $this->drivers = $this->driverRepository->findWhere(['status'=>true],['id', 'first_name', 'last_name']);
        $driversList = ['UnAssign'=>0];
        foreach ($this->drivers as  $driver) {
            $driversList[$driver->first_name.' '.$driver->last_name] = $driver->id;
            Log::info('Listing Single Driver',compact('driver'));
        }
        return $driversList;
    }
}
