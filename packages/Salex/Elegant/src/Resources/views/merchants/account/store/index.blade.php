@extends('elegant::merchants.account.index')

@section('page_title')
{{ __('marketplace::app.account.store') }}
@endsection

@section('account-content')
<div class="account-layout">
    <div class="account-head">
        <span class="back-icon">
            <a href="{{ route('merchant.profile.index') }}">
                <i class="icon icon-menu-back"></i>
            </a>
        </span>

        <span class="account-heading">{{ __('marketplace::app.account.store') }}</span>

        @if (!empty($store))
        <span class="account-action">
            <a href="{{ route('merchant.store.update') }}">{{ __('marketplace::app.account.edit-store') }}</a>
        </span>
        @else
        <span></span>
        @endif

        <div class="horizontal-rule"></div>
    </div>


    <div class="account-table-content" style="width: 50%;">
        @if (empty($store))
        <div>{{ __('marketplace::app.account.store-empty') }}</div>

        <br />

        <a href="{{ route('merchant.store.create') }}">{{ __('marketplace::app.account.create-store') }}</a>
        @else
        <div class="address-holder">

            <table style="color: #5E5E5E;">
                <tbody>

                    <tr>
                        <td>{{ __('marketplace::app.account.create.name') }}</td>
                        <td>{{ $store->name }}</td>
                    </tr>


                    <tr>
                        <td>{{ __('marketplace::app.account.create.url') }}</td>
                        <td>{{ $store->url }}</td>
                    </tr>


                    <tr>
                        <td>{{ __('marketplace::app.account.create.tax_number') }}</td>
                        <td>{{ $store->tax_number }}</td>
                    </tr>


                    <tr>
                        <td>{{ __('shop::app.customer.account.address.create.phone') }}</td>
                        <td>{{ $store->phone }}</td>
                    </tr>



                    <tr>
                        <td>
                            <button type="submit" @click="showModal('deleteProfile')" class="btn btn-lg btn-primary mt-10">
                                {{ __('marketplace::app.account.delete-store') }}
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>



        </div>
        @endif
    </div>

</div>
@endsection

<!-- @push('scripts')
    <script>
        function deleteAddress(message) {
            if (! confirm(message)) {
                return;
            }

            $('#deleteAddressForm').submit();
        }
    </script>
@endpush -->