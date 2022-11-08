@extends('admin::layouts.content')

@section('page_title')
{{ __('marketplace::app.stores.create-title') }}
@stop

@section('content')
<div class="content">
    <form method="POST" action="{{ route('admin.sales.stores.store') }}" @submit.prevent="onSubmit">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.sales.stores.index') }}'"></i>
                    {{ __('marketplace::app.stores.create-title') }}
                </h1>
            </div>

            <div class="page-action">
                <button type="submit" class="btn btn-lg btn-primary">
                    {{ __('marketplace::app.stores.save-title') }}
                </button>
            </div>
        </div>

        <div class="page-content">

            <div class="form-container">
                @csrf()


                {!! view_render_event('bagisto.admin.customers.create.before') !!}

                <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                    <label for="name" class="required">{{ __('marketplace::app.stores.name') }}</label>
                    <input type="text" class="control" id="name" name="name" v-validate="'required'" value="{{ old('name') }}" data-vv-as="&quot;{{ __('marketplace::app.stores.name') }}&quot;">
                    <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.first_name.after') !!}

                <div class="control-group" :class="[errors.has('url') ? 'has-error' : '']">
                    <label for="url" class="required">{{ __('marketplace::app.stores.url') }}</label>
                    <input type="text" class="control" id="url" name="url" v-validate="'required'" value="{{ old('url') }}" data-vv-as="&quot;{{ __('marketplace::app.stores.url') }}&quot;">
                    <span class="control-error" v-if="errors.has('url')">@{{ errors.first('url') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.last_name.after') !!}

                <div class="control-group" :class="[errors.has('tax_number') ? 'has-error' : '']">
                    <label for="tax_number" class="required">{{ __('marketplace::app.stores.tax-number') }}</label>
                    <input type="text" class="control" id="tax_number" name="tax_number" v-validate="'required'" value="{{ old('tax_number') }}" data-vv-as="&quot;{{ __('marketplace::app.stores.tax-number') }}&quot;">
                    <span class="control-error" v-if="errors.has('tax_number')">@{{ errors.first('tax_number') }}</span>
                </div>
                {!! view_render_event('bagisto.admin.customers.create.last_name.after') !!}
             
                <div class="control-group" :class="[errors.has('phone') ? 'has-error' : '']">
                    <label for="phone" class="required">{{ __('marketplace::app.stores.phone') }}</label>
                    <input type="phone" class="control" id="phone" name="phone" v-validate="'required'" value="{{ old('phone') }}" data-vv-as="&quot;{{ __('marketplace::app.stores.phone') }}&quot;">
                    <span class="control-error" v-if="errors.has('phone')">@{{ errors.first('phone') }}</span>
                </div>
                {!! view_render_event('bagisto.admin.customers.create.last_name.after') !!}

                <div class="control-group" :class="[errors.has('is_visible') ? 'has-error' : '']">

                    <label for="is_visible" class="required">{{ __('marketplace::app.account.is-visible') }}</label>
                    <label class="switch">
                        <input type="checkbox" class="control" id="is_visible" name="is_visible" data-vv-as="&quot;{{ old('is_visible') }}&quot;" {{ old('is_visible') ? 'checked' : ''}} value="1">
                        <span class="slider round"></span>
                    </label>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.last_name.after') !!}
               
                <div class="control-group" :class="[errors.has('is_physical') ? 'has-error' : '']">

                    <label for="tax_number" class="required">{{ __('marketplace::app.account.is-physical') }}</label>
                    <label class="switch">
                        <input type="checkbox" class="control" id="is_physical" name="is_physical" data-vv-as="&quot;{{ old('is_physical') }}&quot;" {{ old('is_physical') ? 'checked' : ''}} value="1">
                        <span class="slider round"></span>
                    </label>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.last_name.after') !!}

                <div class="control-group" :class="[errors.has('description') ? 'has-error' : '']">
                    <label for="description" class="required">{{ __('marketplace::app.stores.description') }}</label>
                    <textarea class="control" id="description" name="description" v-validate="'required'" data-vv-as="&quot;{{  __('marketplace::app.stores.description')  }}&quot;">{{ old('description')}}</textarea>
                    <span class="control-error" v-if="errors.has('description')">@{{ errors.first('description') }}</span>
                </div>

                {!! view_render_event('bagisto.admin.customers.create.after') !!}
            </div>
        </div>
    </form>
</div>
@stop