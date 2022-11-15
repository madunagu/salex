@extends('succinct::drivers.account.index')

@section('page_title')
{{ __('driver::app.shipments.view.page-title', ['shipment_id' => $shipment->increment_id]) }}
@endsection

@push('css')
    <style type="text/css">
        .account-content .account-layout .account-head {
            margin-bottom: 0px;
        }
        .sale-summary .dash-icon {
            margin-right: 30px;
            float: right;
        }
    </style>
@endpush

@section('page-detail-wrapper')
    <div class="account-head">
        <span class="account-heading">
        {{ __('driver::app.shipments.view.page-title', ['shipment_id' => $shipment->increment_id]) }}
        </span>

        @if ($order->canCancel())
            <span class="account-action">
                <form id="cancelOrderForm" action="{{ route('driver.shipments.cancel', $shipment->id) }}" method="post">
                    @csrf
                </form>

                <a href="javascript:void(0);" class="theme-btn light unset float-right" onclick="cancelOrder('{{ __('shop::app.customer.account.order.view.cancel-confirm-msg') }}')" style="float: right">
                    {{ __('shop::app.customer.account.order.view.cancel-btn-title') }}
                </a>
            </span>
        @endif
    </div>

    {!! view_render_event('bagisto.shop.customers.account.orders.view.before', ['order' => $order]) !!}

    <div class="sale-container mt10">
    <accordian title="{{ __('admin::app.sales.orders.order-and-account') }}" :active="true">
            <div slot="body">
                <div class="sale">
                    <div class="sale-section">
                        <div class="secton-title">
                            <span>{{ __('admin::app.sales.orders.order-info') }}</span>
                        </div>

                        <div class="section-content">
                            <div class="row">
                                <span class="title">
                                    {{ __('admin::app.sales.shipments.order-id') }}
                                </span>

                                <span class="value">
                                    <a href="{{ route('admin.sales.orders.view', $order->id) }}">#{{ $order->increment_id }}</a>
                                </span>
                            </div>

                            <div class="row">
                                <span class="title">
                                    {{ __('admin::app.sales.orders.order-date') }}
                                </span>

                                <span class="value">
                                    {{ $order->created_at }}
                                </span>
                            </div>

                            <div class="row">
                                <span class="title">
                                    {{ __('admin::app.sales.orders.order-status') }}
                                </span>

                                <span class="value">
                                    {{ $order->status_label }}
                                </span>
                            </div>

                            <div class="row">
                                <span class="title">
                                    {{ __('admin::app.sales.orders.channel') }}
                                </span>

                                <span class="value">
                                    {{ $order->channel_name }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="sale-section">
                        <div class="secton-title">
                            <span>{{ __('admin::app.sales.orders.account-info') }}</span>
                        </div>

                        <div class="section-content">
                            <div class="row">
                                <span class="title">
                                    {{ __('admin::app.sales.orders.customer-name') }}
                                </span>

                                <span class="value">
                                    {{ $shipment->order->customer_full_name }}
                                </span>
                            </div>

                            <div class="row">
                                <span class="title">
                                    {{ __('admin::app.sales.orders.email') }}
                                </span>

                                <span class="value">
                                    {{ $shipment->order->customer_email }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </accordian>

        @if ($order->billing_address || $order->shipping_address)
        <accordian title="{{ __('admin::app.sales.orders.address') }}" :active="true">
            <div slot="body">
                <div class="sale">
                    @if ($order->billing_address)
                    <div class="sale-section">
                        <div class="secton-title">
                            <span>{{ __('admin::app.sales.orders.billing-address') }}</span>
                        </div>

                        <div class="section-content">

                            @include ('admin::sales.address', ['address' => $order->billing_address])

                        </div>
                    </div>
                    @endif

                    @if ($order->shipping_address)
                    <div class="sale-section">
                        <div class="secton-title">
                            <span>{{ __('admin::app.sales.orders.shipping-address') }}</span>
                        </div>

                        <div class="section-content">

                            @include ('admin::sales.address', ['address' => $order->shipping_address])

                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </accordian>
        @endif

        <accordian title="{{ __('admin::app.sales.orders.payment-and-shipping') }}" :active="true">
            <div slot="body">
                <div class="sale">
                    <div class="sale-section">
                        <div class="secton-title">
                            <span>{{ __('admin::app.sales.orders.payment-info') }}</span>
                        </div>

                        <div class="section-content">
                            <div class="row">
                                <span class="title">
                                    {{ __('admin::app.sales.orders.payment-method') }}
                                </span>

                                <span class="value">
                                    {{ core()->getConfigData('sales.paymentmethods.' . $order->payment->method . '.title') }}
                                </span>
                            </div>

                            <div class="row">
                                <span class="title">
                                    {{ __('admin::app.sales.orders.currency') }}
                                </span>

                                <span class="value">
                                    {{ $order->order_currency_code }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="sale-section">
                        <div class="secton-title">
                            <span>{{ __('admin::app.sales.orders.shipping-info') }}</span>
                        </div>

                        <div class="section-content">
                            <div class="row">
                                <span class="title">
                                    {{ __('admin::app.sales.orders.shipping-method') }}
                                </span>

                                <span class="value">
                                    {{ $order->shipping_title }}
                                </span>
                            </div>

                            <div class="row">
                                <span class="title">
                                    {{ __('admin::app.sales.orders.shipping-price') }}
                                </span>

                                <span class="value">
                                    {{ core()->formatBasePrice($order->base_shipping_amount) }}
                                </span>
                            </div>

                            @if ($shipment->inventory_source || $shipment->inventory_source_name)
                            <div class="row">
                                <span class="title">
                                    {{ __('admin::app.sales.shipments.inventory-source') }}
                                </span>

                                <span class="value">
                                    {{ $shipment->inventory_source ? $shipment->inventory_source->name : $shipment->inventory_source_name }}
                                </span>
                            </div>
                            @endif

                            <div class="row">
                                <span class="title">
                                    {{ __('admin::app.sales.shipments.carrier-title') }}
                                </span>

                                <span class="value">
                                    {{ $shipment->carrier_title }}
                                </span>
                            </div>

                            <div class="row">
                                <span class="title">
                                    {{ __('admin::app.sales.shipments.tracking-number') }}
                                </span>

                                <span class="value">
                                    {{ $shipment->track_number }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </accordian>


    </div>

    {!! view_render_event('bagisto.shop.customers.account.orders.view.after', ['order' => $order]) !!}
@endsection

@push('scripts')
    <script>
        function cancelOrder(message) {
            if (! confirm(message)) {
                return;
            }

            $('#cancelOrderForm').submit();
        }
    </script>
@endpush