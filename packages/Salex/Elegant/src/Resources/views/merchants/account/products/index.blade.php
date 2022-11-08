@extends('elegant::merchants.account.index')
@php
$store_id = auth()->guard('merchant')->user()->store_id;
@endphp
@section('page_title')
{{ __('marketplace::app.products.products') }}
@endsection

@section('account-content')
<div class="account-layout">
    <div class="account-head mb-10">
        <span class="back-icon"><a href="{{ route('merchant.profile.index') }}"><i class="icon icon-menu-back"></i></a></span>

        <span class="account-heading">
            {{ __('marketplace::app.products.products') }}
        </span>

        <span class="account-action">
            <a href="{{ route('merchant.products.create') }}">{{ __('marketplace::app.account.create-product') }}</a>
        </span>

        <div class="horizontal-rule"></div>
    </div>

    {!! view_render_event('bagisto.shop.customers.account.products.list.before') !!}
    @if ($store_id==0)
    <div>{{ __('marketplace::app.account.store-empty') }}</div>

    <br />

    <a href="{{ route('merchant.store.create') }}">{{ __('marketplace::app.account.create-store') }}</a>
    @else
    <div class="account-items-list">
        <div class="account-table-content">

            <datagrid-plus src="{{ route('merchant.products.index') }}"></datagrid-plus>

        </div>
    </div>
    @endif
    {!! view_render_event('bagisto.shop.customers.account.products.list.after') !!}
</div>
@endsection