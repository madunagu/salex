<header class="sticky-header">
    <div class="row remove-padding-margin velocity-divide-page">
        <a class="left navbar-brand" href="{{ route('shop.home.index') }}" aria-label="Logo">
            <img class="logo" src="{{ core()->getCurrentChannel()->logo_url ?? asset('themes/succinct/assets/images/logo-text.png') }}" alt="" />
        </a>

        <div class="right searchbar">
            <div class="row">
                <div class="col-lg-5 col-md-12">
                    @include('succinct::shop.layouts.particals.search-bar')
                </div>

                <div class="col-lg-7 col-md-12 vc-full-screen">
                    <div class="left-wrapper">

                            @include('succinct::shop.layouts.particals.contact')

                        {!! view_render_event('bagisto.shop.layout.header.cart-item.before') !!}

                            @include('shop::checkout.cart.mini-cart')

                        {!! view_render_event('bagisto.shop.layout.header.cart-item.after') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@push('scripts')
    <script type="text/javascript">
        (() => {
            document.addEventListener('scroll', e => {
                scrollPosition = Math.round(window.scrollY);

                if (scrollPosition > 50) {
                    document.querySelector('header').classList.add('header-shadow');
                } else {
                    document.querySelector('header').classList.remove('header-shadow');
                }
            });
        })();
    </script>
@endpush
