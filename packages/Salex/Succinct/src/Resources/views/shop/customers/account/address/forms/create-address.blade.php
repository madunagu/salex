@php
$currentCustomer = auth()->guard('customer')->user();

$defaultCountry = config('app.default_country');
@endphp

<create-address></create-address>

@push('scripts')
<script type="text/x-template" id="create-address-template">


    <form method="post" action="{{ route('shop.customer.addresses.store') }}" @submit.prevent="onSubmit">
    <div class="account-table-content mb-2">
        <div class="rounded-form">
            @csrf

            <div class="row">

                <div class="col-lg-4 col-md-6">
                    <google-map @onAddressSelected="updateAddress" :formerLocation="{lat:1,lng:1}" ></google-map>
                </div>

                <div class="col-lg-8 col-md-6">

                    {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.before') !!}
                    <input type="hidden" name="from_cart" value="1" />

                    <div class="control-group" :class="[errors.has('company_name') ? 'has-error' : '']">
                        <label for="company_name">{{ __('shop::app.customer.account.address.create.company_name') }}</label>

                        <input class="control" type="text" name="company_name"  v-model="address.company_name"  data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.company_name') }}&quot;">

                        <span class="control-error" v-text="errors.first('company_name')" v-if="errors.has('company_name')">
                        </span>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.company_name.after') !!}

                    <div class="row">
                        <div class="col-lg-6 control-group" :class="[errors.has('first_name') ? 'has-error' : '']">
                            <label for="first_name" class="mandatory">{{ __('shop::app.customer.account.address.create.first_name') }}</label>

                            <input class="control" type="text" name="first_name" v-model="address.first_name" value="{{ old('first_name') ?? $currentCustomer->first_name }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.first_name') }}&quot;">

                            <span class="control-error" v-text="errors.first('first_name')" v-if="errors.has('first_name')">
                            </span>
                        </div>
                        {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.first_name.after') !!}

                        <div class="col-lg-6 control-group" :class="[errors.has('last_name') ? 'has-error' : '']">
                            <label for="last_name" class="mandatory">{{ __('shop::app.customer.account.address.create.last_name') }}</label>

                            <input class="control" type="text" name="last_name"   v-model="address.last_name"  v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.last_name') }}&quot;">

                            <span class="control-error" v-text="errors.first('last_name')" v-if="errors.has('last_name')">
                            </span>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.last_name.after') !!}
                    </div>



                    <div class="row">

                        <div class="col-lg-6 control-group" :class="[errors.has('postcode') ? 'has-error' : '']">
                            <label for="postcode" class="{{ core()->isPostCodeRequired() ? 'mandatory' : '' }}">{{ __('shop::app.customer.account.address.create.postcode') }}</label>

                            <input class="control" type="text" name="postcode" v-model="address.post_code"  v-validate="'{{ core()->isPostCodeRequired() ? 'required' : '' }}'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.postcode') }}&quot;">

                            <span class="control-error" v-text="errors.first('postcode')" v-if="errors.has('postcode')">
                            </span>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.postcode.after') !!}

                        <div class="col-lg-6 control-group" :class="[errors.has('phone') ? 'has-error' : '']">
                            <label for="phone" class="mandatory">{{ __('shop::app.customer.account.address.create.phone') }}</label>
                            <div class="control" id="phone-container">

                            <div class="phone-select-container display-inbl">
                            <img src="{{ asset('/themes/velocity/assets/images/flags/default-locale-image.png') }}" alt="" width="20" height="20" />
                            <select class="phone-code-select" id="country" type="text" name="country" v-model="address.country" v-validate="'{{ core()->isCountryRequired() ? 'required' : '' }}'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.country') }}&quot;">
                                <option value="">{{ __('Select Country') }}</option>

                                @foreach (core()->countries() as $country)
                                    <option {{ $country->code === $defaultCountry ? 'selected' : '' }}  value="{{ $country->code }}">{{ $country->name }}</option>
                                @endforeach

                            </select>
                        </div>

                            <input class="phone-number" type="text" name="phone"   v-model="address.phone"  v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.phone') }}&quot;">
                        </div>
                        <span class="control-error" v-text="errors.first('phone')" v-if="errors.has('phone')"></span>
                        <span class="control-error" v-text="errors.first('country')" v-if="errors.has('country')"></span>
                        </div>
                    </div>


                    <!-- <div class="control-group" :class="[errors.has('vat_id') ? 'has-error' : '']">
                    <label for="vat_id">{{ __('shop::app.customer.account.address.create.vat_id') }}
                        <span class="help-note">{{ __('shop::app.customer.account.address.create.vat_help_note') }}</span>
                    </label>

                    <input class="control" type="text" name="vat_id" value="{{ old('vat_id') }}" v-validate="" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.vat_id') }}&quot;">

                    <span class="control-error" v-text="errors.first('vat_id')" v-if="errors.has('vat_id')">
                    </span>
                </div> -->

                    {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.vat_id.after') !!}

                    <div class="row">
                        <div class="col-lg-6 control-group" :class="[errors.has('state') ? 'has-error' : '']">
                            <label for="state" class="{{ core()->isStateRequired() ? 'mandatory' : '' }}">
                                {{ __('shop::app.customer.account.address.create.state') }}
                            </label>

                            <input class="control" id="state" type="text" name="state"   v-model="address.state"  v-validate="'{{ core()->isStateRequired() ? 'required' : '' }}'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.state') }}&quot;" />
                            <span class="control-error" v-text="errors.first('state')" v-if="errors.has('state')"></span>
                        </div>

                        <div class="col-lg-6 control-group" :class="[errors.has('city') ? 'has-error' : '']">
                            <label for="city" class="mandatory">{{ __('shop::app.customer.account.address.create.city') }}</label>

                            <input type="text" class="control" name="city" v-model="address.city"  v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.city') }}&quot;">

                            <span class="control-error" v-text="errors.first('city')" v-if="errors.has('city')">
                            </span>
                        </div>

                    </div>

                    {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.city.after') !!}
                    @php
                    $addresses = old('address1') ?? ["","",""];
                    @endphp

                    <div class="row">

                        <div class="col-lg-6 control-group" :class="[errors.has('address1[]') ? 'has-error' : '']">
                            <label for="address_0" class="mandatory">{{ __('succinct::app.customer.address.neighbourhood') }}</label>

                            <input class="control" id="address_0" type="text" name="address1[]" v-model="address.address[0]" value="{{ $addresses[0] ?: '' }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.street-address') }}&quot;">

                            <span class="control-error" v-text="'{{ $errors->first('address1.*') }}'">
                            </span>
                        </div>

                        <div class="col-lg-6 control-group" :class="[errors.has('address1[1]') ? 'has-error' : '']">
                            <label for="address_0" class="mandatory">{{ __('succinct::app.customer.address.apartment') }}</label>

                            <input class="control" id="address_1" type="text" name="address1[1]" v-model="address.address[1]" value="{{ $addresses[1] ?: '' }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.apartment') }}&quot;">

                            <span class="control-error" v-text="'{{ $errors->first('address1.*') }}'">
                            </span>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 control-group" :class="[errors.has('address1[2]') ? 'has-error' : '']">
                            <label for="address_0" class="mandatory">{{ __('succinct::app.customer.address.description') }}</label>

                            <textarea class="control" id="address_2" type="text" name="address1[2]" v-model="address.address[3]" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.description') }}&quot;">{{ $addresses[2] ?: '' }}</textarea>

                            <span class="control-error" v-text="'{{ $errors->first('address1.*') }}'">
                            </span>
                        </div>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.after') !!}


                    <div class="control-group d-flex">
                        <input class="w-auto" id="default_address" type="checkbox" name="default_address" {{ old('default_address') ? 'checked' : '' }}>

                        <label class="checkbox-view" for="default_address"></label>

                        {{ __('shop::app.customer.account.address.default-address') }}
                    </div>

                </div>
            </div>
        </div>
        <div class="page-action">
        <div class="button-group float-right">
            <button class="theme-btn opacity-50 mr20">{{ __('succinct::app.customer.address.cancel') }}</button>
            <button type="submit" class="theme-btn mb20">{{ __('shop::app.customer.account.address.create.submit') }}</button>
        </div>
        </div>
    </div>

</form>


    </script>

<script>
    Vue.component('create-address', {
        template: '#create-address-template',

        inject: ['$validator'],

        data: function() {
            return {
                address: {
                    'first_name': '{{ old("first_name") ?? $currentCustomer->first_name }}',
                    'last_name': '{{ old("last_name") ?? $currentCustomer->last_name }}',
                    'phone': '{{ old("phone") ?? $currentCustomer->phone }}',
                    'state': '',
                    'city': '',
                    'company_name': '{{ old("company_name") }}',
                    'address': [],
                },
                countryStates: @json(core()->groupedStatesByCountries()),
            }
        },

        methods: {
            updateAddress: function(mapAddress) {
                this.address = {
                    'first_name': '{{ old("first_name") ?? $currentCustomer->first_name }}',
                    'last_name': '{{ old("last_name") ?? $currentCustomer->last_name }}',
                    'phone': '{{ old("phone") ?? $currentCustomer->phone }}',
                    'state': '',
                    'city': '',
                    'address': [
                        [],
                        [],
                        []
                    ],
                };

                this.address.post_code = mapAddress.postal_code;
                this.address.state = mapAddress.administrative_area_level_1;
                this.address.city = mapAddress.administrative_area_level_2;
                this.address.country = mapAddress.country;

                if (!!mapAddress.neighborhood) {
                    this.address.address[0] = mapAddress.neighborhood + ', ';
                }
                if (!!mapAddress.route) {
                    this.address.address[0] += mapAddress.route;
                }
                this.address.address[1] = mapAddress.street_number;
            }
        }
    });
</script>
@endpush