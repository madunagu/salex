@extends('shop::layouts.focused')

@section('page_title')
{{ __('shop::app.customer.login-form.page-title') }}
@endsection



@section('body-header')
<div class="auth-content form-container">

    {!! view_render_event('bagisto.shop.customers.login.before') !!}

    <div class="">
        <div class="row">
            <div class="col-lg-3 col-md-4 container" style="background-color: #032CA6;">
                <div class="body text-center">
                    <a class="mb10">Back to Store</a>
                    <h2 class="fw7 text-white text-uppercase mb-4">Salex</h2>
                    <img src="{{bagisto_asset('images/delivery-guy.svg')}}" class="mx-auto d-block mt-5" style="width: 80%;" />
                    <div class="fs14 mt-4 text-white">{{ __('succinct::app.customer.login-form.form-delivery-text')}} </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="container">
                    <div class="body col-12 rounded-form">
                        <div class="form-header text-center">
                            <h3 class="fw5 mb-4">
                                {{ __('velocity::app.customer.login-form.registered-user')}}
                            </h3>

                            <p class="fs13 fw3">
                                {{ __('velocity::app.customer.login-form.form-login-text')}}
                            </p>
                        </div>
                        <form method="POST" action="{{ route('shop.customer.session.create') }}" @submit.prevent="onSubmit">

                            {{ csrf_field() }}

                            {!! view_render_event('bagisto.shop.customers.login_form_controls.before') !!}

                            <div class="form-group" :class="[errors.has('email') ? 'has-error' : '']">
                                <input type="text" class="form-style" name="email" placeholder="{{ __('shop::app.customer.login-form.email') }}" v-validate="'required|email'" value="{{ old('email') }}" data-vv-as="&quot;{{ __('shop::app.customer.login-form.email') }}&quot;" />

                                <span class="control-error" v-if="errors.has('email')" v-text="errors.first('email')"></span>
                            </div>

                            <div class="form-group" :class="[errors.has('password') ? 'has-error' : '']">
                                <div class="input-btn-group">
                                    <input type="password" class="control form-style" name="password" placeholder="{{ __('shop::app.customer.login-form.password') }}" id="password" v-validate="'required'" value="{{ old('password') }}" data-vv-as="&quot;{{ __('shop::app.customer.login-form.password') }}&quot;" />
                                    <button type="button" onclick="myFunction()" id="shoPassword" class="icon"><i class="rango-eye-hide"></i></button>
                                </div>

                                <input type="checkbox" class="show-password d-none" />


                                <!-- {{ __('shop::app.customer.login-form.show-password') }} -->

                                <a href="{{ route('shop.customer.forgot_password.create') }}" class="show-password fs14 float-right">
                                    {{ __('shop::app.customer.login-form.forgot_pass') }}
                                </a>

                                <div class="mt10">
                                    <span class="control-error" v-if="errors.has('password')" v-text="errors.first('password')"></span>
                                    @if (Cookie::has('enable-resend'))
                                    @if (Cookie::get('enable-resend') == true)
                                    <a href="{{ route('shop.customer.resend.verification_email', Cookie::get('email-for-resend')) }}">{{ __('shop::app.customer.login-form.resend-verification') }}</a>
                                    @endif
                                    @endif
                                </div>
                            </div>
                            <div class="mt10"></div>


                            {!! view_render_event('bagisto.shop.customers.login_form_controls.after') !!}

                            <input class="theme-btn" type="submit" value="{{ __('shop::app.customer.login-form.button_title') }}">
                            <div class="form-group">
                                {!! Captcha::render() !!}
                            </div>
                            <div class="form-group">
                                <p class="fs14 fw4 text-center">
                                    {{ __('succinct::app.customer.login-form.form-signup-text')}}
                                    <a href="{{ route('shop.customer.register.index') }}" class="btn-new-customer fw5">
                                        {{ __('velocity::app.customer.login-form.sign-up')}}
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! view_render_event('bagisto.shop.customers.login.after') !!}
</div>
@endsection

@push('scripts')

{!! Captcha::renderJS() !!}

<script>
    $(function() {
        $(":input[name=email]").focus();
    });

    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

@endpush