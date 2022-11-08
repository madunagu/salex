<?php

namespace Salex\Driver\DataGrids;

use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\PseudoTypes\False_;
use Webkul\Ui\DataGrid\DataGrid;

class DriverDataGrid extends DataGrid
{
    /**
     * Index.
     *
     * @var string
     */
    protected $index = 'driver_id';

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
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('drivers')
            // ->leftJoin('customer_groups', 'customers.customer_group_id', '=', 'customer_groups.id')
            ->addSelect(
                'drivers.id as driver_id',
                'drivers.first_name',
                'drivers.last_name',
                'drivers.email',
                'drivers.phone',
                'drivers.address',
                'drivers.status',
                'drivers.identity_number',
                // 'customer_groups.name as group',
            )
            ->addSelect(
                DB::raw('CONCAT(' . DB::getTablePrefix() . 'drivers.first_name, " ", ' . DB::getTablePrefix() . 'drivers.last_name) as full_name')
            );

        $this->addFilter('driver_id', 'drivers.id');
        // $this->addFilter('full_name','full_name');
        // $this->addFilter('group', 'customer_groups.name');
        $this->addFilter('phone', 'drivers.phone');
        $this->addFilter('email', 'drivers.email');
        $this->addFilter('status', 'status');

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
            'index'      => 'driver_id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'full_name',
            'label'      => trans('admin::app.datagrid.name'),
            'type'       => 'string',
            'searchable' => false,
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

        // $this->addColumn([
        //     'index'      => 'identity_number',
        //     'label'      => trans('admin::app.datagrid.group'),
        //     'type'       => 'string',
        //     'searchable' => false,
        //     'sortable'   => true,
        //     'filterable' => true,
        // ]);

        $this->addColumn([
            'index'      => 'phone',
            'label'      => trans('admin::app.datagrid.phone'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => false,
            'closure'    => function ($row) {
                if (! $row->phone) {
                    return '-';
                } else {
                    return $row->phone;
                }
            },
        ]);

        // $this->addColumn([
        //     'index'      => 'gender',
        //     'label'      => trans('admin::app.datagrid.gender'),
        //     'type'       => 'string',
        //     'searchable' => false,
        //     'sortable'   => true,
        //     'filterable' => false,
        //     'closure'    => function ($row) {
        //         if (! $row->gender) {
        //             return '-';
        //         } else {
        //             return $row->gender;
        //         }
        //     },
        // ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('admin::app.datagrid.status'),
            'type'       => 'boolean',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($row) {
                $html = '';

                if ($row->status == 1) {
                    $html .= '<span class="badge badge-md badge-success">' . trans('admin::app.customers.customers.active') . '</span>';
                } else {
                    $html .= '<span class="badge badge-md badge-danger">' . trans('admin::app.customers.customers.inactive') . '</span>';
                }

                // if ($row->is_suspended == 1) {
                //     $html .= '<span class="badge badge-md badge-danger">' . trans('admin::app.customers.customers.suspended') . '</span>';
                // }
                return $html;
            },
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
            'method' => 'GET',
            'route'  => 'admin.driver.edit',
            'icon'   => 'icon pencil-lg-icon',
            'title'  => trans('admin::app.customers.customers.edit-help-title'),
        ]);

        // $this->addAction([
        //     'method' => 'GET',
        //     'route'  => 'admin.driver.note.create',
        //     'icon'   => 'icon note-icon',
        //     'title'  => trans('admin::app.customers.note.help-title'),
        // ]);

        // $this->addAction([
        //     'method' => 'POST',
        //     'route'  => 'admin.driver.delete',
        //     'icon'   => 'icon trash-icon',
        //     'title'  => trans('admin::app.customers.customers.delete-help-title'),
        // ]);
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
            'label'   => trans('admin::app.datagrid.update-status'),
            'action'  => route('admin.driver.mass-update'),
            'method'  => 'POST',
            'options' => [
                trans('admin::app.datagrid.active')    => 1,
                trans('admin::app.datagrid.inactive')  => 0,
            ],
        ]);
    }
}
