<form data-vv-scope="payment-form" class="payment-form">
    <div class="form-container">
        <accordian :title="'{{ __('shop::app.checkout.payment-methods') }}'" :active="true">
            <div class="form-header mb-30" slot="header">

                <h3 class="fw6 display-inbl">
                    {{ __('shop::app.checkout.onepage.payment-methods') }}
                </h3>

                <i class="rango-arrow"></i>
            </div>

            <div class="payment-methods d-flex pb-4" slot="body">

                @foreach ($paymentMethods as $payment)

                {!! view_render_event('bagisto.shop.checkout.payment-method.before', ['payment' => $payment]) !!}

                <div class="payment-method mr10">
                    @php $additionalDetails = \Webkul\Payment\Payment::getAdditionalDetails($payment['method']); @endphp

                    @if (! empty($additionalDetails))
                    <div class="instructions" v-show="payment.method == '{{$payment['method']}}'">
                        <label>{{ $additionalDetails['title'] }}</label>
                        <p>{{ $additionalDetails['value'] }}</p>
                    </div>
                    @endif

                    <input type="radio" class="d-none" name="payment[method]" v-validate="'required'" v-model="payment.method" @change="methodSelected()" id="{{ $payment['method'] }}" value="{{ $payment['method'] }}" data-vv-as="&quot;{{ __('shop::app.checkout.onepage.payment-method') }}&quot;" />

                    <label for="{{ $payment['method'] }}" class="payment-card">

                    <img src="{{bagisto_asset('images/payment-'.$payment['method'].'.svg')}}" class="payment-image" alt="{{ $payment['method_title'] }}" title="{{$payment['method_title']}}" />
                    </label>
                </div>

                {!! view_render_event('bagisto.shop.checkout.payment-method.after', ['payment' => $payment]) !!}

                @endforeach

                <span class="control-error" v-if="errors.has('payment-form.payment[method]')" v-text="errors.first('payment-form.payment[method]')"></span>
            </div>
        </accordian>
    </div>
</form>