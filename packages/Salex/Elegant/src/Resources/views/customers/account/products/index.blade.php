@extends('shop::customers.account.index')

@section('page_title')
    {{ __('marketplace::app.products.products') }}
@endsection

@section('account-content')
    <div class="account-layout">
        <div class="account-head mb-10">
            <span class="back-icon"><a href="{{ route('customer.profile.index') }}"><i class="icon icon-menu-back"></i></a></span>

            <span class="account-heading">
                {{ __('marketplace::app.products.products') }}
            </span>

                <span class="account-action">
                    <a href="{{ route('customer.products.create') }}">{{ __('marketplace::app.account.create-product') }}</a>
                </span>
      
            <div class="horizontal-rule"></div>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.products.list.before') !!}

        <div class="account-items-list">
            <div class="account-table-content">
                
                <datagrid-plus src="{{ route('customer.products.index') }}"></datagrid-plus>
                
            </div>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.products.list.after') !!}
    </div>
@endsection