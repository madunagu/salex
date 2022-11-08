@php
$currentCustomer = auth()->guard('customer')->user();
@endphp

@extends('shop::customers.account.index')

@section('page_title')
{{ __('marketplace::app.account.edit-store') }}
@endsection

@section('account-content')
<div class="account-layout">
    <div class="account-head mb-15">
        <span class="back-icon">
            <a href="{{ route('customer.store.index') }}"><i class="icon icon-menu-back"></i></a>
        </span>

        <span class="account-heading">{{ __('marketplace::app.account.edit-store') }}</span>

        <span></span>
    </div>


    <form id="customer-address-form" method="post" action="{{ route('customer.store.update', $store->id) }}" @submit.prevent="onSubmit">


        <div class="account-table-content">
            @method('PUT')

            @csrf

            {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.before') !!}

            <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                <label for="name">{{ __('marketplace::app.sellers.store-name') }}</label>

                <input class="control" type="text" name="name" value="{{ old('name') ?? $store->name  }}" data-vv-as="&quot;{{ __('marketplace::app.sellers.store-name') }}&quot;">

                <span class="control-error" v-text="errors.first('name')" v-if="errors.has('name')">
                </span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.company_name.after') !!}

            <div class="control-group" :class="[errors.has('url') ? 'has-error' : '']">
                <label for="url" class="required">{{ __('marketplace::app.account.create.url') }}</label>

                <input class="control" type="text" name="url" value="{{ old('url') ?? $store->url }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.first_name') }}&quot;">

                <span class="control-error" v-text="errors.first('url')" v-if="errors.has('url')">
                </span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.first_name.after') !!}

            <div class="control-group" :class="[errors.has('tax_number') ? 'has-error' : '']">
                <label for="tax_number" class="required">{{ __('marketplace::app.account.create.tax_number') }}</label>

                <input class="control" type="text" name="tax_number" value="{{ old('tax_number') ?? $store->tax_number}}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.last_name') }}&quot;">

                <span class="control-error" v-text="errors.first('tax_number')" v-if="errors.has('tax_number')">
                </span>
            </div>


            <div class="control-group" :class="[errors.has('phone') ? 'has-error' : '']">
                <label for="phone" class="required">{{ __('shop::app.customer.account.address.create.phone') }}</label>

                <input class="control" type="text" name="phone" value="{{ old('phone')?? $store->phone }}" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.address.create.phone') }}&quot;">

                <span class="control-error" v-text="errors.first('phone')" v-if="errors.has('phone')"></span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.after') !!}

            <div class="control-group" :class="[errors.has('description') ? 'has-error' : '']">
                <label for="description" class="required">
                    {{ __('marketplace::app.sales.stores.description') }}
                </label>
                <textarea type="text" class="control" name="description" v-validate="'required'">{{ old('description')?? $store->description }}
                </textarea>
                <span class="control-error" v-if="errors.has('description')">@{{ errors.first('description') }}</span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.after') !!}

            <div class="control-group">
                <span class="checkbox">
                    <input class="control" id="is_physical" value="1" type="checkbox" name="is_physical" {{ $store->is_physical ? 'checked' : '' }}>

                    <label class="checkbox-view" for="is_physical"></label>

                    {{ __('marketplace::app.account.is-physical') }}
                </span>
            </div>

            <div class="control-group">
                <span class="checkbox">
                    <input class="control" id="featured" value="1" type="checkbox" name="featured" {{ $store->featured ? 'checked' : '' }}>

                    <label class="checkbox-view" for="featured"></label>

                    {{ __('marketplace::app.account.is-featured') }}
                </span>
            </div>


            <div class="control-group">
                <span class="checkbox">
                    <input class="control" id="is_visible" value="1" type="checkbox" name="is_visible" {{ $store->is_visible ? 'checked' : '' }}>

                    <label class="checkbox-view" for="is_visible"></label>

                    {{ __('marketplace::app.account.is-visible') }}
                </span>
            </div>


            <div class="button-group">
                <button class="btn btn-primary btn-lg" type="submit">
                    {{ __('marketplace::app.account.save-store') }}
                </button>
            </div>
        </div>
    </form>

</div>
@endsection

@push('scripts')
@include('admin::layouts.tinymce')
<script>
    $(document).ready(function() {


        tinyMCEHelper.initTinyMCE({
            selector: 'textarea.enable-wysiwyg, textarea.enable-wysiwyg',
            height: 200,
            width: "100%",
            plugins: 'image imagetools media wordcount save fullscreen code table lists link hr',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor link hr | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent  | removeformat | code | table',
            image_advtab: true,
        });
    });
</script>
@endpush