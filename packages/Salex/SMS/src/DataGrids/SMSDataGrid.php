<?php

namespace Salex\SMS\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class SMSDataGrid extends DataGrid
{
    /**
     * Index.
     *
     * @var string
     */
    protected $index = 'sms_id';

    /**
     * Sort order.
     *
     * @var string
     */
    protected $sortOrder = 'desc';


    /**
     * Create a new datagrid instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {

        $queryBuilder = DB::table('s_m_s as sms')
            ->select(
                'sms.id as sms_id',
                'sms.text',
                'sms.to',
                'sms.response',
                'sms.sent',
                'sms.event_key',
                'sms.recipient_user_id',
                'customers.first_name as name',
                'customers.last_name',
            )
            ->leftJoin('customers', 'sms.recipient_user_id', '=', 'customers.id');
            // ->groupBy('sms.to');


        $this->addFilter('status', 'sms.status');
        $this->addFilter('event_key', 'sms.event_key');

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
            'index'      => 'sms_id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('admin::app.datagrid.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'text',
            'label'      => trans('sms::app.text'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'to',
            'label'      => trans('sms::app.recipient'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'response',
            'label'      => trans('sms::app.response'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'event_key',
            'label'      => trans('sms::app.event-key'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'sent',
            'label'      => trans('admin::app.datagrid.status'),
            'type'       => 'boolean',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
            'closure'    => function ($value) {
                if ($value->sent == 1) {
                    return '<span class="badge badge-md badge-success">' . trans('sms::app.sent') . '</span>';
                } else {
                    return '<span class="badge badge-md badge-warning">' . trans('sms::app.pending') . '</span>';
                }
            },
        ]);

        // $this->addColumn([
        //     'index'      => 'count',
        //     'label'      => trans('admin::app.datagrid.no-of-products'),
        //     'type'       => 'number',
        //     'sortable'   => true,
        //     'searchable' => false,
        //     'filterable' => false,
        // ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        // $this->addAction([
        //     'title'  => trans('admin::app.datagrid.edit'),
        //     'method' => 'GET',
        //     'route'  => 'admin.catalog.categories.edit',
        //     'icon'   => 'icon pencil-lg-icon',
        // ]);

        // $this->addAction([
        //     'title'        => trans('admin::app.datagrid.delete'),
        //     'method'       => 'POST',
        //     'route'        => 'admin.catalog.categories.delete',
        //     'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'product']),
        //     'icon'         => 'icon trash-icon',
        // ]);

        // $this->addMassAction([
        //     'type'   => 'delete',
        //     'label'  => trans('admin::app.datagrid.delete'),
        //     'action' => route('admin.catalog.categories.massdelete'),
        //     'method' => 'POST',
        // ]);
    }
}
