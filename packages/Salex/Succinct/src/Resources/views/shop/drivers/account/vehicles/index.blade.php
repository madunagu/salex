@extends('succinct::drivers.account.index')

@section('page_title')
{{ __('driver::app.vehicles.vehicles-title') }}
@endsection

@section('page-detail-wrapper')
<div class="account-head mb-10">
    <span class="account-heading">
    {{ __('driver::app.vehicles.vehicles-title') }}
    </span>

    <span class="account-action">
        <a href="{{ route('driver.vehicles.create') }}" class="theme-btn light unset float-right">
        {{ __('driver::app.vehicles.add-title') }}
        </a>
    </span>
</div>

{!! view_render_event('bagisto.shop.drivers.account.vehicles.list.before') !!}

<div class="account-items-list">
    <div class="account-table-content">

        <datagrid-plus src="{{ route('driver.vehicles.index') }}"></datagrid-plus>

    </div>
</div>

{!! view_render_event('bagisto.shop.drivers.account.vehicles.list.after') !!}
@endsection