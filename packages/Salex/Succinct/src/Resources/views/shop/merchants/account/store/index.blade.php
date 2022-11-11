@extends('succinct::merchants.account.index')

@section('page_title')
{{ __('marketplace::app.account.store') }}
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
    {{ __('marketplace::app.account.store') }}
    </span>

    @if (!empty($store))
    <span class="account-action">
        <a href="{{ route('merchant.store.update') }}" class="theme-btn light unset float-right">
            {{ __('marketplace::app.account.edit-store') }}
        </a>
    </span>
    @else
    <span></span>
    @endif

</div>


<div class="account-table-content profile-page-content">
    @if (empty($store))
    <div>{{ __('marketplace::app.account.store-empty') }}</div>

    <br />

    <a href="{{ route('merchant.store.create') }}">{{ __('marketplace::app.account.create-store') }}</a>
    @else
    <div class="row">
        <div class="col-lg-2">
            @if ($store->image)
            <div>
                <img style="width:100%;border-radius:50%;" src="{{ $store->image_url }}" alt="{{ $store->name }}" />
            </div>
            @else
            <div class="customer-name col-12 text-uppercase">
                {{ substr($store->name, 0, 1) }}
            </div>
            @endif
        </div>
        <div class="col-lg-8">

            <p class="fs18">{{ __('succinct::app.customer.account.title') }}</p>


            <label class="profile-label fs12 fw6 text-uppercase">{{ __('marketplace::app.account.create.name') }}</label>
            <p class="detail">{{ $store->name }}</p>
            <br />

            <label class="profile-label fs12 fw6 text-uppercase">{{ __('marketplace::app.account.create.url') }}</label>
            <p class="detail">{{ $store->url }}</p>
            <br />

            <label class="profile-label fs12 fw6 text-uppercase">{{ __('marketplace::app.account.create.tax_number') }}</label>
            <p class="detail">{{ $store->tax_number }}</p>
            <br />

            <label class="profile-label fs12 fw6 text-uppercase">{{ __('shop::app.customer.account.address.create.phone') }}</label>
            <p class="detail">{{ $store->phone ?? '-' }}</p>
            <br />

        </div>
    </div>

    <button type="submit" class="theme-btn mb20" onclick="window.showDeleteProfileModal();">
        {{ __('shop::app.customer.account.address.index.delete') }}
    </button>
    <div id="deleteProfileForm" class="d-none">
        <form method="POST" action="{{ route('shop.customer.profile.destroy') }}" @submit.prevent="onSubmit">
            @csrf

            <modal id="deleteProfile" :is-open="modalIds.deleteProfile">
                <h3 slot="header">
                    {{ __('shop::app.customer.account.address.index.enter-password') }}
                </h3>

                <i class="rango-close"></i>

                <div slot="body">
                    <div class="control-group" :class="[errors.has('password') ? 'has-error' : '']">
                        <label for="password" class="required">{{ __('admin::app.users.users.password') }}</label>

                        <input type="password" v-validate="'required|min:6'" class="control" id="password" name="password" data-vv-as="&quot;{{ __('admin::app.users.users.password') }}&quot;" />

                        <span class="control-error" v-if="errors.has('password')" v-text="errors.first('password')"></span>
                    </div>

                    <div class="page-action">
                        <button type="submit" class="theme-btn mb20">
                            {{ __('shop::app.customer.account.address.index.delete') }}
                        </button>
                    </div>
                </div>
            </modal>
        </form>
    </div>
    @endif

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