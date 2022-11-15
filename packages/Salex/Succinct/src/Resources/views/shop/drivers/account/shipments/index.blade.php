@extends('succinct::drivers.account.index')

@section('page_title')
{{ __('driver::app.shipments.title') }}
@endsection

@section('page-detail-wrapper')
<div class="account-head mb-10">
    <span class="account-heading">
        {{ __('driver::app.shipments.title') }}
    </span>

</div>

{!! view_render_event('bagisto.shop.customers.account.orders.list.before') !!}

<div class="account-items-list">
    <div class="account-table-content">

        <datagrid-plus src="{{ route('driver.shipments.index') }}"></datagrid-plus>

    </div>
</div>

{!! view_render_event('bagisto.shop.customers.account.orders.list.after') !!}
@endsection