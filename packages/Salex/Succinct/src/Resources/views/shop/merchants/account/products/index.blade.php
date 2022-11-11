@extends('elegant::merchants.account.index')
@php
$store_id = auth()->guard('merchant')->user()->store_id;
@endphp
@section('page_title')
{{ __('marketplace::app.products.products') }}
@endsection

@section('page-detail-wrapper')
<div class="account-head mb-10">
    <span class="account-heading">
        {{ __('marketplace::app.products.products') }}
    </span>

    <span class="account-action">
        <a href="{{ route('merchant.products.create') }}" class="theme-btn light unset float-right">
            {{ __('marketplace::app.account.create-product') }}
        </a>
    </span>
</div>

{!! view_render_event('bagisto.shop.customers.account.orders.list.before') !!}

<div class="account-items-list">
    <div class="account-table-content">

        <datagrid-plus src="{{ route('merchant.products.index') }}"></datagrid-plus>

    </div>
</div>

{!! view_render_event('bagisto.shop.customers.account.orders.list.after') !!}
@endsection