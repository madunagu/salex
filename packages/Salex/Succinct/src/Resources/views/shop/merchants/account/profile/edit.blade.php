@extends('elegant::merchants.account.index')

@section('page_title')
{{ __('shop::app.customer.account.profile.index.title') }}
@endsection

@section('page-detail-wrapper')
<div class="account-head mb-15">
    <span class="account-heading">{{ __('shop::app.customer.account.profile.index.title') }}</span>

    <span></span>
</div>


<form method="POST" @submit.prevent="onSubmit" action="{{ route('merchant.profile.store') }}" enctype="multipart/form-data">

    <div class="account-table-content">
        @csrf


        <div :class="`row ${errors.has('first_name') ? 'has-error' : ''}`">
            <label class="col-12 mandatory">
                {{ __('shop::app.customer.account.profile.fname') }}
            </label>

            <div class="col-12">
                <input value="{{ $merchant->first_name }}" name="first_name" type="text" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.profile.fname') }}&quot;" />
                <span class="control-error" v-if="errors.has('first_name')" v-text="errors.first('first_name')"></span>
            </div>
        </div>


        <div :class="`row ${errors.has('last_name') ? 'has-error' : ''}`">
            <label class="col-12 mandatory">
                {{ __('shop::app.customer.account.profile.lname') }}
            </label>

            <div class="col-12">
                <input value="{{ $merchant->last_name }}" name="last_name" type="text" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.profile.lname') }}&quot;" />
                <span class="control-error" v-if="errors.has('last_name')" v-text="errors.first('last_name')"></span>
            </div>
        </div>

        <div :class="`row ${errors.has('gender') ? 'has-error' : ''}`">
            <label class="col-12 mandatory">
                {{ __('shop::app.customer.account.profile.gender') }}
            </label>

            <div class="col-12">
                <select name="gender" v-validate="'required'" class="control styled-select" data-vv-as="&quot;{{ __('shop::app.customer.account.profile.gender') }}&quot;">

                    <option value="" @if ($merchant->gender == "")
                        selected="selected"
                        @endif>
                        {{ __('admin::app.customers.customers.select-gender') }}
                    </option>

                    <option value="Other" @if ($merchant->gender == "Other")
                        selected="selected"
                        @endif>
                        {{ __('velocity::app.shop.gender.other') }}
                    </option>

                    <option value="Male" @if ($merchant->gender == "Male")
                        selected="selected"
                        @endif>
                        {{ __('velocity::app.shop.gender.male') }}
                    </option>

                    <option value="Female" @if ($merchant->gender == "Female")
                        selected="selected"
                        @endif>
                        {{ __('velocity::app.shop.gender.female') }}
                    </option>
                </select>

                <div class="select-icon-container">
                    <span class="select-icon rango-arrow-down"></span>
                </div>

                <span class="control-error" v-if="errors.has('gender')" v-text="errors.first('gender')"></span>
            </div>
        </div>


        <div :class="`row ${errors.has('date_of_birth') ? 'has-error' : ''}`">
            <label class="col-12">
                {{ __('shop::app.customer.account.profile.dob') }}
            </label>

            <div class="col-12">
                <date id="date-of-birth">
                    <input type="date" name="date_of_birth" placeholder="yyyy/mm/dd" value="{{ old('date_of_birth') ?? $merchant->date_of_birth }}" v-validate="" data-vv-as="&quot;{{ __('shop::app.customer.account.profile.dob') }}&quot;" />
                </date>

                <span class="control-error" v-if="errors.has('date_of_birth')" v-text="errors.first('date_of_birth')"></span>
            </div>
        </div>


        <div class="row">
            <label class="col-12 mandatory">
                {{ __('shop::app.customer.account.profile.email') }}
            </label>

            <div class="col-12">
                <input value="{{ $merchant->email }}" name="email" type="text" v-validate="'required'" />
                <span class="control-error" v-if="errors.has('email')" v-text="errors.first('email')"></span>
            </div>
        </div>


        <div class="row">
            <label class="col-12">
                {{ __('shop::app.customer.account.profile.phone') }}
            </label>

            <div class="col-12">
                <input value="{{ old('phone') ?? $merchant->phone }}" name="phone" type="text" />
                <span class="control-error" v-if="errors.has('phone')" v-text="errors.first('phone')"></span>
            </div>
        </div>


        <div class="row image-container {!! $errors->has('image.*') ? 'has-error' : '' !!}">
            <label class="col-12">
                {{ __('admin::app.catalog.categories.image') }}
            </label>

            <div class="col-12">
                <image-wrapper :button-label="'{{ __('admin::app.catalog.products.add-image-btn-title') }}'" input-name="image" :multiple="false" :images='"{{ $merchant->image_url }}"'></image-wrapper>

                <span class="control-error" v-if="{!! $errors->has('image.*') !!}">
                    @foreach ($errors->get('image.*') as $key => $message)
                    @php echo str_replace($key, 'Image', $message[0]); @endphp
                    @endforeach
                </span>
            </div>
        </div>


        <div class="row">
            <label class="col-12">
                {{ __('velocity::app.shop.general.enter-current-password') }}
            </label>

            <div :class="`col-12 ${errors.has('oldpassword') ? 'has-error' : ''}`">
                <input value="" name="oldpassword" type="password" />
            </div>
        </div>


        <div class="row">
            <label class="col-12">
                {{ __('velocity::app.shop.general.new-password') }}
            </label>

            <div :class="`col-12 ${errors.has('password') ? 'has-error' : ''}`">
                <input value="" name="password" ref="password" type="password" v-validate="'min:6'" />

                <span class="control-error" v-if="errors.has('password')" v-text="errors.first('password')"></span>
            </div>
        </div>

        <div class="row">
            <label class="col-12">
                {{ __('velocity::app.shop.general.confirm-new-password') }}
            </label>

            <div :class="`col-12 ${errors.has('password_confirmation') ? 'has-error' : ''}`">
                <input value="" name="password_confirmation" type="password" v-validate="'min:6|confirmed:password'" data-vv-as="confirm password" />

                <span class="control-error" v-if="errors.has('password_confirmation')" v-text="errors.first('password_confirmation')"></span>
            </div>
        </div>



        <button type="submit" class="theme-btn mb20">
            {{ __('velocity::app.shop.general.update') }}
        </button>
    </div>
</form>

@endsection