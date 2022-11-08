@extends('admin::layouts.content')

@section('page_title')
{{ __('driver::app.vehicles.add-title') }}
@stop

@section('content')
<div class="content">
    <form method="POST" action="{{ route('admin.driver.vehicles.store',$driver->id) }}" @submit.prevent="onSubmit">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.driver.index') }}'"></i>

                    {{ __('driver::app.vehicles.add-title') }}

                    {{ Config::get('carrier.social.facebook.url') }}
                </h1>
            </div>

            <div class="page-action">
                <button type="submit" class="btn btn-lg btn-primary">
                    {{ __('driver::app.vehicles.save-btn-title') }}
                </button>
            </div>
        </div>

        <div class="page-content">

            <div class="form-container">
                @csrf()

                {!! view_render_event('bagisto.admin.customers.create.before') !!}

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


                {!! view_render_event('bagisto.admin.customers.create.after') !!}
            </div>
        </div>
    </form>
</div>
@stop