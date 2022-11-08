@extends('elegant::layouts.master')

@section('content-wrapper')
    <div>
        @if (request()->route()->getName() !== 'merchant.profile.index')
            @if (Breadcrumbs::exists())
                {{ Breadcrumbs::render() }}
            @endif
        @endif
    </div>

    <div class="account-content">
        @include('elegant::merchants.account.partials.sidemenu')

        @yield('account-content')
    </div>
@endsection
