<div class="customer-sidebar row no-margin no-padding">
    <div class="account-details col-12">
        <div class="col-12 customer-name-text text-capitalize text-break no-padding">{{ __('succinct::app.customer.sidebar.hello') }} {{ auth('merchant')->user()->first_name }}</div>
    </div>


    @foreach ($menu->items as $menuItem)
    <ul type="none" class="navigation">
        {{-- rearrange menu items --}}
        @php
        $subMenuCollection = [];

        try {
        $subMenuCollection['profile'] = $menuItem['children']['profile'];
        $subMenuCollection['orders'] = $menuItem['children']['orders'];
        $subMenuCollection['downloadables'] = $menuItem['children']['downloadables'];

        if ((bool) core()->getConfigData('general.content.shop.wishlist_option')) {
        $subMenuCollection['wishlist'] = $menuItem['children']['wishlist'];
        }

        if ((bool) core()->getConfigData('general.content.shop.compare_option')) {
        $subMenuCollection['compare'] = $menuItem['children']['compare'];
        }

        $subMenuCollection['reviews'] = $menuItem['children']['reviews'];
        $subMenuCollection['address'] = $menuItem['children']['address'];

        unset(
        $menuItem['children']['profile'],
        $menuItem['children']['orders'],
        $menuItem['children']['downloadables'],
        $menuItem['children']['wishlist'],
        $menuItem['children']['compare'],
        $menuItem['children']['reviews'],
        $menuItem['children']['address']
        );

        foreach ($menuItem['children'] as $key => $remainingChildren) {
        $subMenuCollection[$key] = $remainingChildren;
        }
        } catch (\Exception $exception) {
        $subMenuCollection = $menuItem['children'];
        }
        @endphp

        <li class="menu-title text-uppercase">
            {{__('marketplace::app.merchants.account')}}
        </li>

        @foreach ($subMenuCollection as $index => $subMenuItem)
        <li class="{{ $menu->getActive($subMenuItem) }}" title="{{ trans($subMenuItem['name']) }}">
            <a class="unset full-width" href="{{ $subMenuItem['url'] }}">
                <i class="icon {{ $index }} text-down-3"></i>
                <span>{{ trans($subMenuItem['name']) }}<span>
                        <i class="rango-arrow-right float-right text-down-3"></i>
            </a>
        </li>
        @endforeach

        <li>
            <form id="merchantLogout" action="{{ route('merchant.session.destroy') }}" method="POST">
                @csrf

                @method('DELETE')
            </form>

            <a class="unset full-width" href="{{ route('merchant.session.destroy') }}" onclick="event.preventDefault(); document.getElementById('merchantLogout').submit();">
                <i class="icon text-down-3"></i>

                <span> {{ __('shop::app.header.logout') }}</span>

                <i class="rango-arrow-right float-right text-down-3"></i>
            </a>
        </li>
    </ul>
    @endforeach
</div>

@push('css')
<style type="text/css">
    .main-content-wrapper {
        margin-bottom: 0px;
        min-height: 100vh;
    }
</style>
@endpush