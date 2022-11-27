<div>
    <sidebar-header heading="{{ __('velocity::app.menu-navbar.text-category') }}">

        {{-- this is default content if js is not loaded --}}
        <div class="main-category fs16 unselectable fw6 left">
            <i class="rango-view-list align-vertical-top fs18"></i>

            <span class="pl5">{{ __('velocity::app.menu-navbar.text-category') }}</span>
        </div>

    </sidebar-header>
</div>

<div class="content-list right">
    <div class="row">
        <div class="col-lg-8">

            <right-side-header :header-content="{{ json_encode(app('Webkul\Velocity\Repositories\ContentRepository')->getAllContents()) }}">

                {{-- this is default content if js is not loaded --}}
                <ul type="none" class="no-margin">
                </ul>

            </right-side-header>
        </div>
        <div class="col-lg-4">
            <div class="left-wrapper customer-functions">
                {!! view_render_event('bagisto.shop.layout.header.wishlist.before') !!}

                @include('succinct::shop.layouts.particals.wishlist', ['isText' => true])

                {!! view_render_event('bagisto.shop.layout.header.wishlist.after') !!}

                {!! view_render_event('bagisto.shop.layout.header.compare.before') !!}

                @include('succinct::shop.layouts.particals.compare', ['isText' => true])
            </div>
        </div>
    </div>
</div>