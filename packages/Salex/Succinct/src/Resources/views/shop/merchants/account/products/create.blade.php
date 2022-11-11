@extends('elegant::merchants.account.index')

@section('page_title')
{{ __('admin::app.catalog.products.add-title') }}
@endsection

@php
$locale = core()->checkRequestedLocaleCodeInRequestedChannel();
$channel = core()->getRequestedChannelCode();
$channelLocales = core()->getAllLocalesByRequestedChannel()['locales'];
@endphp

@push('css')
<style>
    .table td .label {
        margin-right: 10px;
    }

    .table td .label:last-child {
        margin-right: 0;
    }

    .table td .label .icon {
        vertical-align: middle;
        cursor: pointer;
    }
</style>
@endpush


@section('page-detail-wrapper')


<form method="POST" @submit.prevent="onSubmit" action="">

    <div class="account-head mb-15">
        <span class="account-heading"> {{ __('admin::app.catalog.products.add-title') }}</span>

        <span class="account-action">
            <button type="submit" class="theme-btn mb20">
                {{ __('admin::app.catalog.products.save-btn-title') }}
            </button>
        </span>
    </div>



    <div class="account-table-content">
        @csrf


        @php
            $familyId = request()->input('family');
            @endphp

            {!! view_render_event('bagisto.admin.catalog.product.create_form_accordian.general.before') !!}

            <accordian title="{{ __('admin::app.catalog.products.general') }}" :active="true">
                <div slot="body">
                    {!! view_render_event('bagisto.admin.catalog.product.create_form_accordian.general.controls.before') !!}

                    <div class="control-group" :class="[errors.has('type') ? 'has-error' : '']">
                        <label for="type" class="required">{{ __('admin::app.catalog.products.product-type') }}</label>

                        <select class="control" v-validate="'required'" id="type" name="type" {{ $familyId ? 'disabled' : '' }} data-vv-as="&quot;{{ __('admin::app.catalog.products.product-type') }}&quot;">
                            @foreach($productTypes as $key => $productType)
                            <option value="{{ $key }}" {{ request()->input('type') == $productType['key'] ? 'selected' : '' }}>
                                {{ __('admin::app.catalog.products.type.'.strtolower($productType['name'])) }}

                            </option>
                            @endforeach
                        </select>

                        @if ($familyId)
                        <input type="hidden" name="type" value="{{ app('request')->input('type') }}" />
                        @endif

                        <span class="control-error" v-if="errors.has('type')">@{{ errors.first('type') }}</span>
                    </div>

                    <div class="control-group" :class="[errors.has('attribute_family_id') ? 'has-error' : '']">
                        <label for="attribute_family_id" class="required">{{ __('admin::app.catalog.products.familiy') }}</label>

                        <select class="control" v-validate="'required'" id="attribute_family_id" name="attribute_family_id" {{ $familyId ? 'disabled' : '' }} data-vv-as="&quot;{{ __('admin::app.catalog.products.familiy') }}&quot;">
                            @foreach ($families as $family)
                            <option value="{{ $family->id }}" {{ ($familyId == $family->id || old('attribute_family_id') == $family->id) ? 'selected' : '' }}>{{ $family->name }}</option>
                            @endforeach
                        </select>

                        @if ($familyId)
                        <input type="hidden" name="attribute_family_id" value="{{ $familyId }}" />
                        @endif

                        <span class="control-error" v-if="errors.has('attribute_family_id')">@{{ errors.first('attribute_family_id') }}</span>
                    </div>

                    <div class="control-group" :class="[errors.has('sku') ? 'has-error' : '']">
                        <label for="sku" class="required">{{ __('admin::app.catalog.products.sku') }}</label>

                        <input type="text" v-validate="{ required: true, regex: /^[a-zA-Z0-9]+(?:-[a-zA-Z0-9]+)*$/ }" class="control" id="sku" name="sku" value="{{ request()->input('sku') ?: old('sku') }}" data-vv-as="&quot;{{ __('admin::app.catalog.products.sku') }}&quot;" />

                        <span class="control-error" v-if="errors.has('sku')">@{{ errors.first('sku') }}</span>
                    </div>

                    {!! view_render_event('bagisto.admin.catalog.product.create_form_accordian.general.controls.after') !!}
                </div>
            </accordian>

            {!! view_render_event('bagisto.admin.catalog.product.create_form_accordian.general.after') !!}

            @if ($familyId)
            {!! view_render_event('bagisto.admin.catalog.product.create_form_accordian.configurable_attributes.before') !!}

            <accordian title="{{ __('admin::app.catalog.products.configurable-attributes') }}" :active="true">
                <div slot="body">
                    {!! view_render_event('bagisto.admin.catalog.product.create_form_accordian.configurable_attributes.controls.before') !!}

                    <div class="table">
                        <table>
                            <thead>
                                <tr>
                                    <th>{{ __('admin::app.catalog.products.attribute-header') }}</th>
                                    <th>{{ __('admin::app.catalog.products.attribute-option-header') }}</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($configurableFamily->configurable_attributes as $attribute)
                                <tr>
                                    <td>
                                        {{ $attribute->admin_name }}
                                    </td>

                                    <td>
                                        @foreach ($attribute->options as $option)
                                        <span class="label">
                                            <input type="hidden" name="super_attributes[{{$attribute->code}}][]" value="{{ $option->id }}" />
                                            {{ $option->admin_name }}

                                            <i class="icon cross-icon"></i>
                                        </span>
                                        @endforeach
                                    </td>

                                    <td class="actions">
                                        <i class="icon trash-icon"></i>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {!! view_render_event('bagisto.admin.catalog.product.create_form_accordian.configurable_attributes.controls.after') !!}
                </div>
            </accordian>

            {!! view_render_event('bagisto.admin.catalog.product.create_form_accordian.configurable_attributes.after') !!}
            @endif


        <button type="submit" class="theme-btn mb20">
            {{ __('velocity::app.shop.general.update') }}
        </button>
    </div>
</form>

@endsection