@php
$driver = auth()->guard('driver')->user();
@endphp

@extends('elegant::drivers.account.index')

@section('page_title')
{{ __('marketplace::app.account.create-store') }}
@endsection

@section('account-content')
<div class="account-layout">
    <div class="account-head mb-15">
        <span class="back-icon">
            <a href="{{ route('driver.profile.index') }}"><i class="icon icon-menu-back"></i></a>
        </span>

        <span class="account-heading">{{ __('marketplace::app.account.create-store') }}</span>

        <span></span>
    </div>

    {!! view_render_event('bagisto.shop.customers.account.address.create.before') !!}

    <form id="customer-address-form" method="post" action="{{ route('driver.vehicles.store') }}" @submit.prevent="onSubmit">
        <div class="account-table-content">
            @csrf

            <div class="control-group" :class="[errors.has('type') ? 'has-error' : '']">
                    <label for="type" class="required">{{ __('driver::app.vehicles.type') }}</label>
                    <input type="text" class="control" id="type" name="type" v-validate="'required'" value="{{ old('type') }}" data-vv-as="&quot;{{ __('driver::app.vehicles.type') }}&quot;">
                    <span class="control-error" v-if="errors.has('type')">@{{ errors.first('type') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.first_name.after') !!}

                <div class="control-group" :class="[errors.has('model') ? 'has-error' : '']">
                    <label for="model" class="required">{{ __('driver::app.vehicles.model') }}</label>
                    <input type="text" class="control" id="model" name="model" v-validate="'required'" value="{{ old('model') }}" data-vv-as="&quot;{{ __('driver::app.vehicles.model') }}&quot;">
                    <span class="control-error" v-if="errors.has('model')">@{{ errors.first('model') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.last_name.after') !!}

                <div class="control-group" :class="[errors.has('color') ? 'has-error' : '']">
                    <label for="color" class="required">{{ __('driver::app.vehicles.color') }}</label>
                    <input type="text" class="control" id="color" name="color" v-validate="'required'" value="{{ old('color') }}" data-vv-as="&quot;{{ __('driver::app.vehicles.color') }}&quot;">
                    <span class="control-error" v-if="errors.has('model')">@{{ errors.first('color') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.last_name.after') !!}

                <div class="control-group" :class="[errors.has('year') ? 'has-error' : '']">
                    <label for="year" class="required">{{ __('driver::app.vehicles.year') }}</label>
                    <input type="text" class="control" id="year" name="year" v-validate="'required'" value="{{ old('year') }}" data-vv-as="&quot;{{ __('driver::app.vehicles.year') }}&quot;">
                    <span class="control-error" v-if="errors.has('year')">@{{ errors.first('year') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.identity_number.after') !!}
              
                <div class="control-group" :class="[errors.has('plate_no') ? 'has-error' : '']">
                    <label for="plate_no" class="required">{{ __('driver::app.vehicles.plate-no') }}</label>
                    <input type="text" class="control" id="plate_no" name="plate_no" v-validate="'required'" value="{{ old('plate_no') }}" data-vv-as="&quot;{{ __('driver::app.vehicles.plate-no') }}&quot;">
                    <span class="control-error" v-if="errors.has('plate_no')">@{{ errors.first('plate_no') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.email.after') !!}

                <div class="control-group" :class="[errors.has('vin_no') ? 'has-error' : '']">
                    <label for="vin_no" class="required">{{ __('driver::app.vehicles.vin-no') }}</label>
                    <input type="text" class="control" id="vin_no" name="vin_no" v-validate="'required'" value="{{ old('vin_no') }}" data-vv-as="&quot;{{ __('driver::app.vehicles.vin-no') }}&quot;">
                    <span class="control-error" v-if="errors.has('vin_no')">@{{ errors.first('vin_no') }}</span>
                </div>

            <div class="button-group">
                <input class="btn btn-primary btn-lg" type="submit" value="{{ __('driver::app.vehicles.save-btn-title') }}">
            </div>
        </div>
    </form>

    {!! view_render_event('bagisto.shop.customers.account.address.create.after') !!}
</div>
@endsection