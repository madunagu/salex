<form data-vv-scope="shipping-form" class="shipping-form">
    <div class="form-container">
        <accordian :title="'{{ __('shop::app.checkout.onepage.shipping-method') }}'" :active="true">
            <div class="form-header" slot="header">
                <h3 class="fw6 display-inbl">
                    {{ __('shop::app.checkout.onepage.shipping-method') }}
                </h3>
                <i class="rango-arrow"></i>
            </div>

            <div :class="`pb-4 address-container shipping-methods ${errors.has('shipping-form.shipping_method') ? 'has-error' : ''}`" slot="body">

                <div class="d-flex">
                    @foreach ($shippingRateGroups as $rateGroup)

                    {!! view_render_event('bagisto.shop.checkout.shipping-method.before', ['rateGroup' => $rateGroup]) !!}
                    @foreach ($rateGroup['rates'] as $rate)

                    <div class="col-lg-4 col-md-6 address-holder pl0">
                        <div class="card">
                            <div class="card-body row pb-0">
                                <div class="col-1">
                                    <div class="radio">
                                        <input type="radio" v-validate="'required'" name="shipping_method" id="{{ $rate->method }}" value="{{ $rate->method }}" @change="methodSelected()" v-model="selected_shipping_method" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.shipping-method') }}&quot;" />

                                        <label for="{{ $rate->method }}" class="radio-view"></label>
                                    </div>
                                </div>

                                <div class="col-10">
                                    <div class="flex">
                                        <img class="" src="{{ bagisto_asset('images/city-express.svg') }}" style="width:50px" />

                                        <b class="float-right">{{ core()->currency($rate->base_price) }}</b>
                                    </div>
                                    <h5 class="fs15 fw6">{{ $rate->method_title }}</h5>

                                </div>
                            </div>
                        </div>
                    </div>


                    @endforeach

                    {!! view_render_event('bagisto.shop.checkout.shipping-method.after', ['rateGroup' => $rateGroup]) !!}

                    @endforeach
                </div>


                <span class="control-error" v-if="errors.has('shipping-form.shipping_method')" v-text="errors.first('shipping-form.shipping_method')">
                </span>
            </div>
        </accordian>
    </div>
</form>