@extends('admin::layouts.content')

@section('page_title')
{{ __('driver::app.drivers.add-title') }}
@stop

@section('content')
<div class="content">
    <form method="POST" action="{{ route('admin.driver.store') }}" @submit.prevent="onSubmit">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.driver.index') }}'"></i>

                    {{ __('driver::app.drivers.add-title') }}

                    {{ Config::get('carrier.social.facebook.url') }}
                </h1>
            </div>

            <div class="page-action">
                <button type="submit" class="btn btn-lg btn-primary">
                    {{ __('driver::app.drivers.save-btn-title') }}
                </button>
            </div>
        </div>

        <div class="page-content">

            <div class="form-container">
                @csrf()

                {!! view_render_event('bagisto.admin.customers.create.before') !!}

                <div class="control-group" :class="[errors.has('first_name') ? 'has-error' : '']">
                    <label for="first_name" class="required">{{ __('admin::app.customers.customers.first_name') }}</label>
                    <input type="text" class="control" id="first_name" name="first_name" v-validate="'required'" value="{{ old('first_name') }}" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.firstname') }}&quot;">
                    <span class="control-error" v-if="errors.has('first_name')">@{{ errors.first('first_name') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.first_name.after') !!}

                <div class="control-group" :class="[errors.has('last_name') ? 'has-error' : '']">
                    <label for="last_name" class="required">{{ __('admin::app.customers.customers.last_name') }}</label>
                    <input type="text" class="control" id="last_name" name="last_name" v-validate="'required'" value="{{ old('last_name') }}" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.lastname') }}&quot;">
                    <span class="control-error" v-if="errors.has('last_name')">@{{ errors.first('last_name') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.last_name.after') !!}

                <!-- <div class="control-group" :class="[errors.has('identity_number') ? 'has-error' : '']">
                    <label for="identity_number" class="required">{{ __('driver::app.drivers.identity-number') }}</label>
                    <input type="text" class="control" id="identity_number" name="identity_number" v-validate="'required'" value="{{ old('identity_number') }}" data-vv-as="&quot;{{ __('driver::app.drivers.identity-number') }}&quot;">
                    <span class="control-error" v-if="errors.has('identity_number')">@{{ errors.first('identity_number') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.identity_number.after') !!} -->
              
                <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                    <label for="email" class="required">{{ __('shop::app.customer.signup-form.email') }}</label>
                    <input type="email" class="control" id="email" name="email" v-validate="'required|email'" value="{{ old('email') }}" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.email') }}&quot;">
                    <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.email.after') !!}

                <div class="control-group" :class="[errors.has('address') ? 'has-error' : '']">
                    <label for="address" class="required">{{ __('driver::app.drivers.address') }}</label>
                    <input type="text" class="control" id="address" name="address" v-validate="'required'" value="{{ old('address') }}" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.email') }}&quot;">
                    <span class="control-error" v-if="errors.has('address')">@{{ errors.first('address') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.email.after') !!}

                <div class="control-group" :class="[errors.has('cnic') ? 'has-error' : '']">
                    <label for="cnic">{{ __('driver::app.drivers.cnic') }}</label>
                    <input type="text" class="control" id="cnic" name="cnic" v-validate="" value="{{ old('cnic') }}" data-vv-as="&quot;{{ __('driver::app.drivers.cnic') }}&quot;">
                    <span class="control-error" v-if="errors.has('cnic')">@{{ errors.first('cnic') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.identity_number.after') !!}

                <div class="control-group" :class="[errors.has('date_of_birth') ? 'has-error' : '']">
                    <label for="dob">{{ __('admin::app.customers.customers.date_of_birth') }}</label>
                    <input type="date" class="control" id="dob" name="date_of_birth" v-validate="" value="{{ old('date_of_birth') }}" placeholder="{{ __('admin::app.customers.customers.date_of_birth_placeholder') }}" data-vv-as="&quot;{{ __('admin::app.customers.customers.date_of_birth') }}&quot;">
                    <span class="control-error" v-if="errors.has('date_of_birth')">@{{ errors.first('date_of_birth') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.date_of_birth.after') !!}

                <div class="control-group" :class="[errors.has('phone') ? 'has-error' : '']">
                    <label for="phone">{{ __('admin::app.customers.customers.phone') }}</label>
                    <input type="text" class="control" id="phone" name="phone" value="{{ old('phone') }}" v-validate="'numeric'" data-vv-as="&quot;{{ __('admin::app.customers.customers.phone') }}&quot;">
                    <span class="control-error" v-if="errors.has('phone')">@{{ errors.first('phone') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.phone.after') !!}



                {!! view_render_event('bagisto.admin.customers.create.after') !!}
            </div>
        </div>
    </form>
</div>
@stop