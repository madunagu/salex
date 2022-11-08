@extends('elegant::merchants.account.index')

@section('page_title')
    {{ __('shop::app.customer.account.profile.index.title') }}
@endsection

@section('account-content')
    <div class="account-layout">
        <div class="account-head">
            <span class="back-icon"><a href="{{ route('merchant.profile.index') }}"><i class="icon icon-menu-back"></i></a></span>

            <span class="account-heading">{{ __('shop::app.customer.account.profile.index.title') }}</span>

            <span class="account-action">
                <a href="{{ route('merchant.profile.edit') }}">{{ __('shop::app.customer.account.profile.index.edit') }}</a>
            </span>

            <div class="horizontal-rule"></div>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.profile.view.before', ['customer' => $merchant]) !!}

        <div class="account-table-content" style="width: 50%;">
            <table style="color: #5E5E5E;">
                <tbody>
            
                    <tr>
                        <td>{{ __('shop::app.customer.account.profile.fname') }}</td>
                        <td>{{ $merchant->first_name }}</td>
                    </tr>

                 
                    <tr>
                        <td>{{ __('shop::app.customer.account.profile.lname') }}</td>
                        <td>{{ $merchant->last_name }}</td>
                    </tr>

              
                    <tr>
                        <td>{{ __('shop::app.customer.account.profile.gender') }}</td>
                        <td>{{ __($merchant->sex) }}</td>
                    </tr>

                    <tr>
                        <td>{{ __('shop::app.customer.account.profile.dob') }}</td>
                        <td>{{ $merchant->date_of_birth }}</td>
                    </tr>

                    <tr>
                        <td>{{ __('shop::app.customer.account.profile.email') }}</td>
                        <td>{{ $merchant->email }}</td>
                    </tr>

                    <tr>
                        <td> 
                            <button type="submit" @click="showModal('deleteProfile')" class="btn btn-lg btn-primary mt-10">
                                {{ __('shop::app.customer.account.address.index.delete') }}
                            </button>
                        </td>                        
                    </tr>

                 </tbody>
            </table>           

            <form method="POST" action="{{ route('merchant.profile.destroy') }}" @submit.prevent="onSubmit">
                @csrf

                <modal id="deleteProfile" :is-open="modalIds.deleteProfile">
                    <h3 slot="header">{{ __('shop::app.customer.account.address.index.enter-password') }}</h3>

                    <div slot="body">
                        <div class="control-group" :class="[errors.has('password') ? 'has-error' : '']">
                            <label for="password" class="required">{{ __('admin::app.users.users.password') }}</label>
                            <input type="password" v-validate="'required|min:6|max:18'" class="control" id="password" name="password" data-vv-as="&quot;{{ __('admin::app.users.users.password') }}&quot;"/>
                            <span class="control-error" v-if="errors.has('password')">@{{ errors.first('password') }}</span>
                        </div>

                        <div class="page-action">
                            <button type="submit"  class="btn btn-lg btn-primary mt-10">
                            {{ __('shop::app.customer.account.address.index.delete') }}
                            </button>
                        </div>
                    </div>
                </modal>
            </form>
        </div>

    </div>
@endsection
