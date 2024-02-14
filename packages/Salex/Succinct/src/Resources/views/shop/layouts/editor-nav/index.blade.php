<nav class="row" id="top">
    <div class="col-sm-6">
        <a class="left navbar-brand" href="{{ route('shop.home.index') }}" aria-label="Logo">
            <img class="logo" src="{{ core()->getCurrentChannel()->logo_url ?? asset('themes/succinct/assets/images/logo-text.png') }}" alt="" />
        </a>
    </div>

    <div class="col-sm-6">
        @include('succinct::layouts.editor-nav.login-section')
    </div>
</nav>