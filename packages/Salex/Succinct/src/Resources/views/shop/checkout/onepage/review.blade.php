<div class="form-container review-checkout-conainer">
    <accordian :title="'{{ __('shop::app.checkout.onepage.summary') }}'" :active="true">
        <div class="form-header mb-30" slot="header">
            <h3 class="fw6 display-inbl">
                {{ __('shop::app.checkout.onepage.summary') }}
            </h3>
            <i class="rango-arrow"></i>
        </div>

        <div slot="body">
            <div class="address-summary row">
                @if ($billingAddress = $cart->billing_address)
                <div class="billing-address col-lg-6 col-md-12">
                    <div class="card-title mb-20">
                        <b>{{ __('shop::app.checkout.onepage.billing-address') }}</b>
                    </div>

                    <div class="card-content">
                        <ul type="none">
                            <li>
                                {{ $billingAddress->company_name ?? '' }}
                            </li><br />
                            <li>
                                {{ $billingAddress->name }}
                            </li><br />
                            <li>
                                {{ $billingAddress->address1 }}, <br />
                            </li><br />

                            <li>
                                {{ $billingAddress->postcode . " " . $billingAddress->city }}
                            </li><br />

                            <li>
                                {{ $billingAddress->state }}
                            </li><br />

                            <li>
                                {{ core()->country_name($billingAddress->country) }}
                            </li><br />

                            <li>
                                {{ __('shop::app.checkout.onepage.contact') }} : {{ $billingAddress->phone }}
                            </li>
                        </ul>
                    </div>
                </div>
                @endif

                @if (
                $cart->haveStockableItems()
                && $shippingAddress = $cart->shipping_address
                )
                <div class="shipping-address col-6">
                    <div class="card-title mb-20">
                        <b>{{ __('shop::app.checkout.onepage.shipping-address') }}</b>
                    </div>

                    <div class="card-content">
                        <ul>
                            <li>
                                {{ $shippingAddress->company_name ?? '' }}
                            </li><br />
                            <li>
                                {{ $shippingAddress->name }}
                            </li><br />
                            <li>
                                {{ $shippingAddress->address1 }},<br />
                            </li><br />

                            <li>
                                {{ $shippingAddress->postcode . " " . $shippingAddress->city }}
                            </li><br />

                            <li>
                                {{ $shippingAddress->state }}
                            </li><br />

                            <li>
                                {{ core()->country_name($shippingAddress->country) }}
                            </li><br />

                            <li>
                                {{ __('shop::app.checkout.onepage.contact') }} : {{ $shippingAddress->phone }}
                            </li>
                        </ul>
                    </div>
                </div>
                @endif

            </div>

            <div class="cart-item-list review-items">
                <h4 class="fw6">{{ __('velocity::app.checkout.items') }}</h4>

                @foreach ($cart->items as $item)
                @php
                $productBaseImage = $item->product->getTypeInstance()->getBaseImage($item);
                @endphp

                <div class="row col-12 no-padding">
                    <div class="col-2 max-sm-img-dimension">
                        <img src="{{ $productBaseImage['medium_image_url'] }}" alt="" />
                    </div>

                    <div class="col-10 no-padding fs16">

                        {!! view_render_event('bagisto.shop.checkout.name.before', ['item' => $item]) !!}

                        <div class="row fs16">
                            <span class="col-12 fw5">{{ $item->product->name }}</span>
                        </div>

                        {!! view_render_event('bagisto.shop.checkout.name.after', ['item' => $item]) !!}

                        <div class="row col-12 grey fs14 mt-1">
                            {!! view_render_event('bagisto.shop.checkout.price.before', ['item' => $item]) !!}
                            <span class="value">
                                {{ core()->currency($item->base_price) }}
                            </span>
                            {!! view_render_event('bagisto.shop.checkout.price.after', ['item' => $item]) !!}

                            <i class="rango-close text-down-4"></i>

                            {!! view_render_event('bagisto.shop.checkout.quantity.before', ['item' => $item]) !!}
                            <span class="value">
                                {{ $item->quantity }} ({{ __('shop::app.checkout.onepage.quantity') }})
                            </span>
                            {!! view_render_event('bagisto.shop.checkout.quantity.after', ['item' => $item]) !!}
                        </div>

                        <div class="row col-12 mt-1">
                            <b class="blue-color fw5">{{ core()->currency($item->base_total) }}</b>
                        </div>

                        {!! view_render_event('bagisto.shop.checkout.options.before', ['item' => $item]) !!}

                        @if (isset($item->additional['attributes']))
                        <div class="item-options grey fs13 fw3">

                            @foreach ($item->additional['attributes'] as $attribute)
                            <b>{{ $attribute['attribute_name'] }} : </b>{{ $attribute['option_label'] }}</br>
                            @endforeach

                        </div>
                        @endif

                        {!! view_render_event('bagisto.shop.checkout.options.after', ['item' => $item]) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 pl0">
                        <div class="card shipping-choice">
                            <div class="card-body row pb-0">
                                <div class="col-1">
                                    <div class="radio">
                                        <input type="radio" v-validate="'required'" name="shipping_method" id="same_day" value="same_day" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.shipping-method') }}&quot;" />
                                        <label for="same_day" class="radio-view"></label>
                                    </div>
                                </div>

                                <div class="col-10">
                                    <div class="flex">
                                        <b class="fs15">Lu, Nov 18</b>
                                        <b class="float-right fs14">{{ core()->currency(10) }}</b>
                                    </div>
                                    <h5 class="fs13 fw3">Same day shipping </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="order-description row fs16 cart-details">
                <div class="col-lg-4 col-md-12">
                    @if ($cart->haveStockableItems())
                    <div class="shipping mb20">
                        <div class="decorator">
                            <i class="icon shipping-icon"></i>
                        </div>

                        <div class="text">
                            <h4 class="fw6 fs18">
                                {{ core()->currency($cart->selected_shipping_rate->base_price) }}
                            </h4>

                            <div class="info">
                                {{ $cart->selected_shipping_rate->method_title }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="payment mb20">
                        <div class="decorator">
                            <i class="icon payment-icon"></i>
                        </div>

                        <div class="text">
                            <h4 class="fw6 fs18">
                                {{ core()->getConfigData('sales.paymentmethods.' . $cart->payment->method . '.title') }}
                            </h4>

                            <span>{{ __('shop::app.customer.account.order.view.payment-method') }}</span>
                        </div>
                    </div>

                    <slot name="place-order-btn"></slot>
                </div>

                <div class="col-lg-6 col-md-12 order-summary-container bottom pt0 offset-lg-2">
                    <slot name="summary-section"></slot>
                </div>
            </div>
        </div>
    </accordian>
</div>