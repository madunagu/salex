@extends('elegant::merchants.account.index')
@php
$store_id = auth()->guard('merchant')->user()->store_id;
@endphp
@section('page_title')
{{ __('admin::app.settings.inventory_sources.title') }}
@endsection

@section('page-detail-wrapper')
<div class="account-head mb-10">
    <span class="account-heading">
    {{ __('admin::app.settings.inventory_sources.title') }}
    </span>

    <span class="account-action">
            <a href="{{ route('merchant.inventory_sources.create') }}" class="theme-btn light unset float-right">
            {{ __('admin::app.settings.inventory_sources.add') }}
            </a>
        </span>
</div>

{!! view_render_event('bagisto.shop.customers.account.orders.list.before') !!}

<div class="account-items-list">
    <div class="account-table-content">

    <datagrid-plus src="{{ route('merchant.inventory_sources.index') }}"></datagrid-plus>
       
    </div>
</div>

{!! view_render_event('bagisto.shop.customers.account.orders.list.after') !!}
@endsection