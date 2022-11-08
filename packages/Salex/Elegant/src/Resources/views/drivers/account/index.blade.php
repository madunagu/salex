@extends('shop::layouts.master')

@section('content-wrapper')
    <div>
        @if (request()->route()->getName() !== 'driver.profile.index')
            @if (Breadcrumbs::exists())
                {{ Breadcrumbs::render() }}
            @endif
        @endif
    </div>

    <div class="account-content">
        @include('elegant::drivers.account.partials.sidemenu')

        @yield('account-content')
    </div>
@endsection
