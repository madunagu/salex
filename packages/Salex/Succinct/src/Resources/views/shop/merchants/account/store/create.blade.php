@php
$currentCustomer = auth()->guard('merchant')->user();
@endphp
@extends('succinct::merchants.account.index')

@section('page_title')
{{ __('marketplace::app.account.create-store') }}
@endsection

@section('page-detail-wrapper')
<div class="account-head mb-15">
    <span class="account-heading">{{ __('marketplace::app.account.create-store') }}</span>

    <span></span>
</div>


<form method="POST" @submit.prevent="onSubmit" action="{{ route('merchant.store.store') }}" enctype="multipart/form-data">

    <div class="account-table-content">
        @csrf

        {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.before') !!}

        <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
            <label for="name">{{ __('marketplace::app.sellers.store-name') }}</label>

            <input class="control" type="text" name="name" v-validate="'required'" value="{{ old('name') ?? $currentCustomer->first_name  }}" data-vv-as="&quot;{{ __('marketplace::app.sellers.store-name') }}&quot;">

            <span class="control-error" v-text="errors.first('name')" v-if="errors.has('name')">
            </span>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.company_name.after') !!}

        <div class="control-group" :class="[errors.has('url') ? 'has-error' : '']">
            <label for="url" class="required">{{ __('marketplace::app.account.create.url') }}</label>

            <input class="control" type="text" name="url" value="{{ old('url') ?? strtolower($currentCustomer->first_name.'-store') }}" v-validate="'required'" data-vv-as="&quot;{{ __('marketplace::app.account.create.url') }}&quot;">

            <span class="control-error" v-text="errors.first('url')" v-if="errors.has('url')">
            </span>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.first_name.after') !!}

        <div class="control-group" :class="[errors.has('tax_number') ? 'has-error' : '']">
            <label for="tax_number" class="required">{{ __('marketplace::app.account.create.tax_number') }}</label>

            <input class="control" type="text" name="tax_number" value="{{ old('tax_number')}}" v-validate="'required'" data-vv-as="&quot;{{ __('marketplace::app.account.create.tax_number') }}&quot;">

            <span class="control-error" v-text="errors.first('tax_number')" v-if="errors.has('tax_number')">
            </span>
        </div>


        <div class="control-group" :class="[errors.has('phone') ? 'has-error' : '']">
            <label for="phone" class="required">{{ __('shop::app.customer.account.address.create.phone') }}</label>

            <input class="control" type="text" name="phone" value="{{ old('phone') ?? $currentCustomer->phone}}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.phone') }}&quot;">

            <span class="control-error" v-text="errors.first('phone')" v-if="errors.has('phone')"></span>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.after') !!}



        <div class="control-group" :class="[errors.has('description') ? 'has-error' : '']">
            <label for="description" class="required">
                {{ __('marketplace::app.sales.stores.description') }}
            </label>
            <textarea type="text" class="control" name="description" v-validate="'required'">{{ old('description')}}
            </textarea>
            <span class="control-error" v-if="errors.has('description')">@{{ errors.first('description') }}</span>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.after') !!}

        <div class="control-group">
            <span class="checkbox">
                <input class="control" id="is_physical" value="1" type="checkbox" name="is_physical" {{ old('is_physical') ? 'checked' : '' }}>

                <label class="checkbox-view" for="is_physical"></label>

                {{ __('marketplace::app.account.is-physical') }}
            </span>
        </div>

        <div class="control-group">
            <span class="checkbox">
                <input class="control" id="featured" value="1" type="checkbox" name="featured" {{ old('featured') ? 'checked' : '' }}>

                <label class="checkbox-view" for="featured"></label>

                {{ __('marketplace::app.account.is-featured') }}
            </span>
        </div>


        <div class="control-group">
            <span class="checkbox">
                <input class="control" id="is_visible" value="1" type="checkbox" name="is_visible" {{ old('is_visible') ? 'checked' : '' }}>

                <label class="checkbox-view" for="is_visible"></label>

                {{ __('marketplace::app.account.is-visible') }}
            </span>
        </div>


        <div class="row image-container {!! $errors->has('image.*') ? 'has-error' : '' !!}">
            <label class="col-12">
                {{ __('admin::app.catalog.categories.image') }}
            </label>

            <div class="col-12">
                <image-wrapper :button-label="'{{ __('admin::app.catalog.products.add-image-btn-title') }}'" input-name="image" :multiple="false" ></image-wrapper>

                <span class="control-error" v-if="{!! $errors->has('image.*') !!}">
                    @foreach ($errors->get('image.*') as $key => $message)
                    @php echo str_replace($key, 'Image', $message[0]); @endphp
                    @endforeach
                </span>
            </div>
        </div>

        <button type="submit" class="theme-btn mb20">
            {{ __('velocity::app.shop.general.update') }}
        </button>
    </div>
</form>

@endsection