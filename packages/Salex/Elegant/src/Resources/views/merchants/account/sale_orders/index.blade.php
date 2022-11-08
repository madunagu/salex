@extends('elegant::merchants.account.index')
@php
$store_id = auth()->guard('merchant')->user()->store_id;
@endphp
@section('page_title')
    {{ __('shop::app.customer.account.order.index.page-title') }}
@endsection

@section('account-content')
    <div class="account-layout">
        <div class="account-head mb-10">
            <span class="back-icon"><a href="{{ route('merchant.profile.index') }}"><i class="icon icon-menu-back"></i></a></span>

            <span class="account-heading">
                {{ __('shop::app.customer.account.order.index.title') }}
            </span>

            <div class="horizontal-rule"></div>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.orders.list.before') !!}
        @if ($store_id==0)
    <div>{{ __('marketplace::app.account.store-empty') }}</div>

    <br />

    <a href="{{ route('merchant.store.create') }}">{{ __('marketplace::app.account.create-store') }}</a>
    @else
        <div class="account-items-list">
            <div class="account-table-content">
                
                <datagrid-plus src="{{ route('merchant.sale_orders.index') }}"></datagrid-plus>
                
            </div>
        </div>
@endif
        {!! view_render_event('bagisto.shop.customers.account.orders.list.after') !!}
    </div>
@endsection