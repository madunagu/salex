@extends('shop::layouts.focused')

@section('page_title')
{{ __('shop::app.customer.signup-form.page-title') }}
@endsection

@section('body-header')
<div class="auth-content form-container">
    <div class="row">
        <div class="col-lg-3 col-md-4 container" style="background-color: #032CA6;">
            <div class="body text-center">
                <h2 class="fw7 text-white text-uppercase mb-4">Salex</h2>
                <img src="{{bagisto_asset('images/delivery-guy.svg')}}" class="mx-auto d-block mt-5" style="width: 80%;" />
                <div class="fs14 mt-4 text-white">{{ __('succinct::app.customer.login-form.form-delivery-text')}} </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-8">
            <div class="container">
                <div class="body col-12 rounded-form">


                    <div class="heading">
                        <h2 class="fs24 fw6">
                            {{ __('velocity::app.customer.signup-form.user-registration')}}
                        </h2>

                        <a href="{{ route('shop.customer.session.index') }}" class="btn-new-customer">
                            <button type="button" class="theme-btn light">
                                {{ __('velocity::app.customer.signup-form.login')}}
                            </button>
                        </a>
                    </div>

                    <div class="form-header text-center">
                        <h3 class="fw5 mb-4">
                            {{ __('velocity::app.customer.signup-form.become-user')}}
                        </h3>

                        <p class="fs13 fw3">
                            {{ __('velocity::app.customer.signup-form.form-signup-text')}}
                        </p>
                    </div>
                    {!! view_render_event('bagisto.shop.customers.signup.before') !!}

                    <form method="post" action="{{ route('shop.customer.register.create') }}" @submit.prevent="onSubmit">

                        {{ csrf_field() }}

                        {!! view_render_event('bagisto.shop.customers.signup_form_controls.before') !!}

                        <div class="control-group" :class="[errors.has('first_name') ? 'has-error' : '']">
                            <label for="first_name" class="required label-style">
                                {{ __('shop::app.customer.signup-form.firstname') }}
                            </label>

                            <input type="text" class="form-style" name="first_name" v-validate="'required'" value="{{ old('first_name') }}" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.firstname') }}&quot;" />

                            <span class="control-error" v-if="errors.has('first_name')" v-text="errors.first('first_name')"></span>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.signup_form_controls.firstname.after') !!}

                        <div class="control-group" :class="[errors.has('last_name') ? 'has-error' : '']">
                            <label for="last_name" class="required label-style">
                                {{ __('shop::app.customer.signup-form.lastname') }}
                            </label>

                            <input type="text" class="form-style" name="last_name" v-validate="'required'" value="{{ old('last_name') }}" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.lastname') }}&quot;" />

                            <span class="control-error" v-if="errors.has('last_name')" v-text="errors.first('last_name')"></span>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.signup_form_controls.lastname.after') !!}

                        <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                            <label for="email" class="required label-style">
                                {{ __('shop::app.customer.signup-form.email') }}
                            </label>

                            <input type="email" class="form-style" name="email" v-validate="'required|email'" value="{{ old('email') }}" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.email') }}&quot;" />

                            <span class="control-error" v-if="errors.has('email')" v-text="errors.first('email')"></span>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.signup_form_controls.email.after') !!}

                        <div class="control-group" :class="[errors.has('password') ? 'has-error' : '']">
                            <label for="password" class="required label-style">
                                {{ __('shop::app.customer.signup-form.password') }}
                            </label>

                            <input type="password" class="form-style" name="password" v-validate="'required|min:6'" ref="password" value="{{ old('password') }}" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.password') }}&quot;" />

                            <span class="control-error" v-if="errors.has('password')" v-text="errors.first('password')"></span>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.signup_form_controls.password.after') !!}

                        <div class="control-group" :class="[errors.has('password_confirmation') ? 'has-error' : '']">
                            <label for="password_confirmation" class="required label-style">
                                {{ __('shop::app.customer.signup-form.confirm_pass') }}
                            </label>

                            <input type="password" class="form-style" name="password_confirmation" v-validate="'required|min:6|confirmed:password'" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.confirm_pass') }}&quot;" />

                            <span class="control-error" v-if="errors.has('password_confirmation')" v-text="errors.first('password_confirmation')"></span>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.signup_form_controls.password_confirmation.after') !!}

                        <div class="control-group">

                            {!! Captcha::render() !!}

                        </div>

                        @if (core()->getConfigData('customer.settings.newsletter.subscription'))
                        <div class="control-group">
                            <input type="checkbox" id="checkbox2" name="is_subscribed">
                            <span>{{ __('shop::app.customer.signup-form.subscribe-to-newsletter') }}</span>
                        </div>
                        @endif

                        {!! view_render_event('bagisto.shop.customers.signup_form_controls.after') !!}

                        <input class="theme-btn" type="submit" value="{{ __('shop::app.customer.signup-form.title') }}">

                    </form>

                    {!! view_render_event('bagisto.shop.customers.signup.after') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $(":input[name=first_name]").focus();
    });
</script>

{!! Captcha::renderJS() !!}

@endpush