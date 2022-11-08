<?php

namespace Salex\Driver\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;
use Salex\Driver\Repositories\DriverRepository;

class VehicleDataGrid extends DataGrid
{
    /**
     * Index.
     *
     * @var string
     */
    protected $index = 'vehicle_id';

    /**
     * Sort order.
     *
     * @var string
     */
    protected $sortOrder = 'desc';

    /**
     * Items per page.
     *
     * @var int
     */
    protected $itemsPerPage = 10;
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

    /**
    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        $driver = $this->driverRepository->find(request('id'));


        $queryBuilder = DB::table('vehicles')
            // ->leftJoin('customer_groups', 'customers.customer_group_id', '=', 'customer_groups.id')
            ->addSelect(
                'vehicles.id as vehicle_id',
                'vehicles.type',
                'vehicles.color',
                'vehicles.plate_no',
                'vehicles.vin_no',
                'vehicles.year',
                'vehicles.model',
                'vehicles.owned_by_driver',
                'vehicles.driver_id',
                // 'customer_groups.name as group',
            )
            ->where('vehicles.driver_id', $driver->id);


        $this->addFilter('vehicle_id', 'vehicles.id');
        $this->addFilter('type', 'vehicles.type');
        // $this->addFilter('group', 'customer_groups.name');
        $this->addFilter('plate_no', 'vehicles.plate_no');
        $this->addFilter('vin_no', 'vehicles.vin_no');
        $this->addFilter('year', 'vehicles.year');
        $this->addFilter('model', 'vehicles.model');
        // $this->addFilter('status', 'status');

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
            'index'      => 'vehicle_id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'type',
            'label'      => trans('driver::app.vehicles.type'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'model',
            'label'      => trans('driver::app.vehicles.model'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'year',
            'label'      => trans('driver::app.vehicles.year'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'plate_no',
            'label'      => trans('driver::app.vehicles.plate-no'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => false,
            'closure'    => function ($row) {
                if (!$row->plate_no) {
                    return '-';
                } else {
                    return $row->plate_no;
                }
            },
        ]);

        $this->addColumn([
            'index'      => 'vin_no',
            'label'      => trans('driver::app.vehicles.vin-no'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => false,
            'closure'    => function ($row) {
                if (!$row->plate_no) {
                    return '-';
                } else {
                    return $row->plate_no;
                }
            },
        ]);


        // $this->addColumn([
        //     'index'      => 'status',
        //     'label'      => trans('admin::app.datagrid.status'),
        //     'type'       => 'boolean',
        //     'searchable' => false,
        //     'sortable'   => true,
        //     'filterable' => true,
        //     'closure'    => function ($row) {
        //         $html = '';

        //         if ($row->status == 1) {
        //             $html .= '<span class="badge badge-md badge-success">' . trans('admin::app.customers.customers.active') . '</span>';
        //         } else {
        //             $html .= '<span class="badge badge-md badge-danger">' . trans('admin::app.customers.customers.inactive') . '</span>';
        //         }

        //         // if ($row->is_suspended == 1) {
        //         //     $html .= '<span class="badge badge-md badge-danger">' . trans('admin::app.customers.customers.suspended') . '</span>';
        //         // }
        //         return $html;
        //     },
        // ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        $this->addAction([
            'method' => 'GET',
            'route'  => 'admin.driver.vehicles.edit',
            'icon'   => 'icon pencil-lg-icon',
            'title'  => trans('admin::app.customers.customers.edit-help-title'),
        ]);

        // $this->addAction([
        //     'method' => 'GET',
        //     'route'  => 'admin.driver.note.create',
        //     'icon'   => 'icon note-icon',
        //     'title'  => trans('admin::app.customers.note.help-title'),
        // ]);

        $this->addAction([
            'method' => 'POST',
            'route'  => 'admin.driver.vehicles.delete',
            'icon'   => 'icon trash-icon',
            'title'  => trans('admin::app.customers.customers.delete-help-title'),
        ]);
    }

    /**
     * Prepare mass actions.
     *
     * @return void
     */
    public function prepareMassActions()
    {
        $driverId = request('id');
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('admin::app.datagrid.delete'),
            'action' => route('admin.driver.vehicles.mass-destroy',$driverId),
            'method' => 'POST',
        ]);

        // $this->addMassAction([
        //     'type'    => 'update',
        //     'label'   => trans('admin::app.datagrid.update-status'),
        //     'action'  => route('admin.driver.mass-update'),
        //     'method'  => 'POST',
        //     'options' => [
        //         trans('admin::app.datagrid.active')    => 1,
        //         trans('admin::app.datagrid.inactive')  => 0,
        //     ],
        // ]);
    }
}
