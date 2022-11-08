@extends('elegant::drivers.account.index')

@section('page_title')
{{ __('driver::app.vehicles.vehicles-title') }}
@endsection

@section('account-content')
<div class="account-layout">
    <div class="account-head mb-10">
        <span class="back-icon"><a href="{{ route('driver.profile.index') }}"><i class="icon icon-menu-back"></i></a></span>

        <span class="account-heading">
            {{ __('driver::app.vehicles.vehicles-title') }}
        </span>

        <span class="account-action">
            <a href="{{ route('driver.vehicles.create') }}">{{ __('driver::app.vehicles.add-title') }}</a>
        </span>

        <div class="horizontal-rule"></div>
    </div>

    {!! view_render_event('bagisto.shop.customers.account.orders.list.before') !!}

    <div class="account-items-list">
        <div class="account-table-content">

            <datagrid-plus src="{{ route('driver.vehicles.index') }}"></datagrid-plus>

        </div>
    </div>

    {!! view_render_event('bagisto.shop.customers.account.orders.list.after') !!}
</div>
@endsection