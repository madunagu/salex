@extends('succinct::drivers.account.index')

@section('page_title')
    {{ __('shop::app.customer.account.profile.index.title') }}
@endsection

@push('css')
    <style>
        .account-head {
            height: 50px;
        }
    </style>
@endpush

@section('page-detail-wrapper')
    <div class="account-head mb-0">
        <span class="account-heading">
            {{ __('shop::app.customer.account.profile.index.title') }}
        </span>

        <span class="account-action">
            <a href="{{ route('driver.profile.edit') }}" class="theme-btn light unset float-right">
                {{ __('shop::app.customer.account.profile.index.edit') }}
            </a>
        </span>
    </div>

  
    <div class="account-table-content profile-page-content">
        <div class="row">
            <div class="col-lg-2">
            @if (auth('driver')->user()->image)
            <div>
                <img style="width:100%;border-radius:50%;" src="{{ auth('driver')->user()->image_url }}" alt="{{ auth('driver')->user()->first_name }}"/>
            </div>
        @else
            <div class="customer-name col-12 text-uppercase">
                {{ substr(auth('driver')->user()->first_name, 0, 1) }}
            </div>
        @endif
            </div>
            <div class="col-lg-8">
           
                    <p class="fs18">{{ __('succinct::app.customer.account.title') }}</p>
      
                    
                    <label class="profile-label fs12 fw6 text-uppercase">{{ __('shop::app.customer.account.profile.fname') }}</label>
                    <p class="detail">{{ $driver->first_name }}</p>
                    <br/>

                    <label class="profile-label fs12 fw6 text-uppercase">{{ __('shop::app.customer.account.profile.lname') }}</label>
                    <p class="detail">{{ $driver->last_name }}</p>
                    <br/>

                    <label class="profile-label fs12 fw6 text-uppercase">{{ __('shop::app.customer.account.profile.phone') }}</label>
                    <p class="detail">{{ $driver->phone ?? '-' }}</p>
                    <br/>

                    <label class="profile-label fs12 fw6 text-uppercase">{{ __('shop::app.customer.account.profile.gender') }}</label>
                    <p class="detail">{{ $driver->gender ?? '-' }}</p>
                    <br/>
                
                    <label class="profile-label fs12 fw6 text-uppercase">{{ __('shop::app.customer.account.profile.dob') }}</label>
                    <p class="detail">{{ $driver->date_of_birth ?? '-' }}</p>
                    <br/>

                    <label class="profile-label fs12 fw6 text-uppercase">{{ __('shop::app.customer.account.profile.email') }}</label>
                    <p class="detail">{{ $driver->email ?? '-' }}</p>
                    <br/>

                    <p class="fs18">{{ __('succinct::app.customer.account.security') }}</p>
      
                    <label class="profile-label fs12 fw6 text-uppercase">{{ __('shop::app.customer.account.profile.password') }}</label>
                    <p class="detail">*************</p>
                    <br/>
            </div>
        </div>

        <button
            type="submit"
            class="theme-btn mb20" onclick="window.showDeleteProfileModal();">
            {{ __('shop::app.customer.account.address.index.delete') }}
        </button>

        <div id="deleteProfileForm" class="d-none">
            <form method="POST" action="{{ route('driver.profile.destroy') }}" @submit.prevent="onSubmit">
                @csrf

                <modal id="deleteProfile" :is-open="modalIds.deleteProfile">
                    <h3 slot="header">
                        {{ __('shop::app.customer.account.address.index.enter-password') }}
                    </h3>

                    <i class="rango-close"></i>

                    <div slot="body">
                        <div class="control-group" :class="[errors.has('password') ? 'has-error' : '']">
                            <label for="password" class="required">{{ __('admin::app.users.users.password') }}</label>

                            <input type="password" v-validate="'required|min:6'" class="control" id="password" name="password" data-vv-as="&quot;{{ __('admin::app.users.users.password') }}&quot;"/>

                            <span class="control-error" v-if="errors.has('password')" v-text="errors.first('password')"></span>
                        </div>

                        <div class="page-action">
                            <button type="submit"  class="theme-btn mb20">
                                {{ __('shop::app.customer.account.address.index.delete') }}
                            </button>
                        </div>
                    </div>
                </modal>
            </form>
        </div>
    </div>

  @endsection

@push('scripts')
    <script>
        /**
         * Show delete profile modal.
         */
        function showDeleteProfileModal() {
            document.getElementById('deleteProfileForm').classList.remove('d-none');

            window.app.showModal('deleteProfile');
        }
    </script>
@endpush