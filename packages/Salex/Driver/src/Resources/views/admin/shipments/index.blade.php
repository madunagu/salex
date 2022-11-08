@extends('admin::layouts.content')

@section('page_title')
    {{ __('driver::app.shipments.title') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('driver::app.shipments.title') }}</h1>
            </div>

            <div class="page-action">
                <div class="export-import" @click="showModal('downloadDataGrid')">
                    <i class="export-icon"></i>

                    <span>
                        {{ __('admin::app.export.export') }}
                    </span>
                </div>

                <!-- <a href="{{ route('admin.driver.create') }}" class="btn btn-lg btn-primary">
                    {{ __('driver::app.drivers.add-title') }}
                </a> -->
            </div>
        </div>

        <div class="page-content">
            <datagrid-plus src="{{ route('admin.shipments.index') }}"></datagrid-plus>
        </div>
    </div>

    <modal id="downloadDataGrid" :is-open="modalIds.downloadDataGrid">
        <h3 slot="header">{{ __('admin::app.export.download') }}</h3>

        <div slot="body">
            <export-form></export-form>
        </div>
    </modal>
@stop

@push('scripts')
    @include('admin::export.export', ['gridName' => app('Salex\Driver\DataGrids\DriverDataGrid')])
@endpush
