@extends('admin::layouts.content')

@section('page_title')
{{ __('driver::app.drivers.edit-title') }}
@stop

@section('content')
<div class="content">
      <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.driver.index') }}'"></i>

                    <!-- {{ __('driver::app.drivers.edit-title') }} -->
                    {{ $driver->first_name . " " . $driver->last_name }}
                </h1>
            </div>

            <div class="page-action"></div>
        </div>

        <tabs>
            {!! view_render_event('bagisto.admin.customer.edit.before', ['driver' => $driver]) !!}

                <tab name="{{ __('admin::app.sales.orders.info') }}" :selected="true">
                    <div class="sale-container">
                        @include('driver::admin.drivers.general')
                    </div>
                </tab>

                <tab name="{{ __('driver::app.vehicles.vehicles-title') }}" :selected="false">                
                    <div class="page-content">
                        <div class="page-content-button">
                            <a href="{{ route('admin.driver.vehicles.create', ['id' => $driver->id]) }}" class="btn btn-lg btn-primary">
                                {{ __('driver::app.vehicles.create-vehicle') }}
                            </a>
                        </div>

                        <div class="page-content-datagrid">
                            <datagrid-plus src="{{ route('admin.driver.vehicles.index', $driver->id) }}"></datagrid-plus>
                        </div>
                    </div>
                </tab>
                <tab name="{{ __('driver::app.shipments.title') }}" :selected="false">
                    <div class="page-content">

                    {!! view_render_event('bagisto.admin.customer.orders.list.before') !!}

                        <datagrid-plus src="{{ route('admin.driver.shipments.data', $driver->id) }}"></datagrid-plus>

                    {!! view_render_event('bagisto.admin.customer.orders.list.after') !!}
                    </div>
                </tab>

            {!! view_render_event('bagisto.admin.customer.edit.after') !!}
        </tabs>
</div>
@stop