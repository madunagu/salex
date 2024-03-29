@extends('shop::layouts.master')

@inject ('reviewHelper', 'Webkul\Product\Helpers\Review')
@inject ('customHelper', 'Webkul\Velocity\Helpers\Helper')

@section('page_title')
{{ trim($product->meta_title) != "" ? $product->meta_title : $product->name }}
@stop

@section('seo')
<meta name="description" content="{{ trim($product->meta_description) != "" ? $product->meta_description : \Illuminate\Support\Str::limit(strip_tags($product->description), 120, '') }}" />

<meta name="keywords" content="{{ $product->meta_keywords }}" />

@if (core()->getConfigData('catalog.rich_snippets.products.enable'))
<script type="application/ld+json">
    {
        !!app('Webkul\Product\Helpers\SEO') - > getProductJsonLd($product) !!
    }
</script>
@endif

@php
$images = product_image()->getGalleryImages($product);

$productImages = [];

foreach ($images as $key => $image) {
array_push($productImages, $image['medium_image_url']);
}

$productBaseImage = product_image()->getProductBaseImage($product, $images);

$store = app('Salex\MarketPlace\Repositories\StoreRepository')->find(1);

@endphp

<meta name="twitter:card" content="summary_large_image" />

<meta name="twitter:title" content="{{ $product->name }}" />

<meta name="twitter:description" content="{{ $product->description }}" />

<meta name="twitter:image:alt" content="" />

<meta name="twitter:image" content="{{ $productBaseImage['medium_image_url'] }}" />

<meta property="og:type" content="og:product" />

<meta property="og:title" content="{{ $product->name }}" />

<meta property="og:image" content="{{ $productBaseImage['medium_image_url'] }}" />

<meta property="og:description" content="{{ $product->description }}" />

<meta property="og:url" content="{{ route('shop.productOrCategory.index', $product->url_key) }}" />
@stop

@push('css')
<style type="text/css">
    .related-products {
        width: 100%;
    }

    .recently-viewed {
        margin-top: 20px;
    }

    .store-meta-images>.recently-viewed:first-child {
        margin-top: 0px;
    }

    .main-content-wrapper {
        margin-bottom: 0px;
    }

    .buynow {
        height: 40px;
        text-transform: uppercase;
    }
</style>
@endpush

@section('full-content-wrapper')
{!! view_render_event('bagisto.shop.products.view.before', ['product' => $product]) !!}

<div class="row no-margin">
    <section class="col-lg-10 product-detail">
        <div class="layouter">
            <product-view>
                <div class="form-container">
                    @csrf()

                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="row">
                        {{-- product-gallery --}}
                        <div class="left col-lg-7 col-md-7">
                            @include ('shop::products.view.gallery')
                        </div>

                        {{-- right-section --}}
                        <div class="right col-lg-5 col-md-5">
                            {{-- product-info-section --}}
                            <div class="info">

                                <div class="col-12 availability">
                                    @php
                                    $inStock = $product->haveSufficientQuantity(1);
                                    @endphp

                                    <label class="{{ $inStock ? 'active' : '' }} disable-box-shadow">
                                        @if ($inStock)
                                        {{ __('shop::app.products.in-stock') }}
                                        @else
                                        {{ __('shop::app.products.out-of-stock') }}
                                        @endif
                                    </label>

                                    @if (isset($showCompare) && $showCompare)
                                    <compare-component @auth('customer') customer="true" @endif @guest('customer') customer="false" @endif slug="{{ $product->url_key }}" product-id="{{ $product->id }}" add-tooltip="{{ __('velocity::app.customer.compare.add-tooltip') }}"></compare-component>
                                    @endif

                                    @if (! (isset($showWishlist)
                                    && ! $showWishlist)
                                    && (bool) core()->getConfigData('general.content.shop.wishlist_option'))

                                    @include('shop::products.wishlist', [
                                    'addClass' => $addWishlistClass ?? ''
                                    ])
                                    @endif
                                </div>


                                <h2 class="col-12 product-name">{{ $product->name }}</h2>

                                @if ($total = $reviewHelper->getTotalReviews($product))
                                <div class="reviews col-lg-12">
                                    <star-ratings push-class="mr5" :ratings="{{ round($reviewHelper->getAverageRating($product)) }}"></star-ratings>

                                    <div class="reviews fs13">
                                        <span>
                                            {{ __('succinct::app.products.rating-reviews', [
                                                        'rating' => round($reviewHelper->getAverageRating($product)),
                                                        'review' => $total])
                                                    }}
                                        </span>
                                    </div>
                                </div>
                                @endif


                                <div class="col-12 price">
                                    @include ('shop::products.price', ['product' => $product])

                                    @if (
                                    Webkul\Tax\Helpers\Tax::isTaxInclusive()
                                    && $product->getTypeInstance()->getTaxCategory()
                                    )
                                    <span>
                                        {{ __('velocity::app.products.tax-inclusive') }}
                                    </span>
                                    @endif
                                </div>

                                @if (count($offers = $product->getTypeInstance()->getCustomerGroupPricingOffers()) > 0)
                                <div class="col-12">
                                    @foreach ($offers as $offer)
                                    {{ $offer }} </br>
                                    @endforeach
                                </div>
                                @endif

                                @include ('shop::products.view.configurable-options')

                                {!! view_render_event('bagisto.shop.products.view.quantity.before', ['product' => $product]) !!}



                                {!! view_render_event('bagisto.shop.products.view.quantity.after', ['product' => $product]) !!}

                                @include ('shop::products.view.downloadable')

                                @include ('shop::products.view.grouped-products')

                                @include ('shop::products.view.bundle-options')

                                <div class="row product-actions">
                                    @if ($product->getTypeInstance()->showQuantityBox())

                                    <quantity-changer quantity-text="{{ __('shop::app.products.quantity') }}"></quantity-changer>

                                    @else
                                    <input type="hidden" name="quantity" value="1">
                                    @endif

                                    @if (core()->getConfigData('catalog.products.storefront.buy_now_button_display'))
                                    @include ('shop::products.buy-now', [
                                    'product' => $product,
                                    ])
                                    @endif

                                    <div class="add-to-cart-btn pl0">

                                        <button type="submit" {{ ! $product->isSaleable() ? 'disabled' : '' }} class="theme-btn {{ $addToCartBtnClass ?? '' }}">
                                            {{ ($product->type == 'booking') ?  __('shop::app.products.book-now') :  __('shop::app.products.add-to-cart') }}
                                        </button>

                                    </div>
                                </div>

                                <div class="row delivery-detail">
                                    <div class="col-lg-1"><img class="material-icons" src="{{ bagisto_asset('images/icon-fast-delivery.svg') }}" /></div>
                                    <div class="col-lg-10"><label class="fw6 fs12">{{__('succinct::app.products.arrival-date',['date'=>'05 November'])}}</label>
                                        <p class="fs12 fw3">{{__('succinct::app.products.order-before',['time'=>'02:02:01'])}}</p>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <p class="">{{__('succinct::app.products.share-product')}}
                                    <p>
                                    <div class="social-icons">
                                        <a href="https://www.facebook.com/share.php?u={{url()->current()}}" target="_blank" class="unset" rel="noopener noreferrer"><i class="fs30 rango-facebook" title="facebook"></i> </a>
                                        <a href="http://twitter.com/share?text={{$product->name}}&url={{url()->current()}}&hashtags=trendingProducts,SanSalvador" target="_blank" class="unset" rel="noopener noreferrer"><i class="fs30 rango-twitter" title="twitter"></i> </a>
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{url()->current()}}" target="_blank" class="unset" rel="noopener noreferrer"><i class="fs30 rango-linked-in" title="linkedin"></i> </a>
                                        <a href="http://pinterest.com/pin/create/link/?url={{url()->current()}}" target="_blank" class="unset" rel="noopener noreferrer"><i class="fs30 rango-pintrest" title="Pinterest"></i> </a>
                                        <a href="https://www.instagram.com/?url={{url()->current()}}" target="_blank" class="unset" rel="noopener noreferrer"><i class="fs30 rango-instagram" title="instagram"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 detail-pane">
                            <tabs>
                                <tab name="{{__('succinct::app.products.details')}}" :selected="true">
                                    @include ('shop::products.view.short-description')

                                    @include ('shop::products.view.attributes', ['active' => true])

                                    {{-- product long description --}}
                                    @include ('shop::products.view.description')
                                </tab>

                                <tab name="{{__('succinct::app.products.reviews-title')}}" :selected="false">

                                    {{-- reviews count --}}
                                    @include ('shop::products.view.reviews', ['accordian' => true])

                                </tab>
                            </tabs>
                        </div>
                    </div>

                </div>
            </product-view>
        </div>
    </section>

    @if(!empty($store))
    <section class="col-lg-2">
        <div class="seller-detail">
            <div class="mb-4">
                <img src="{{$store->image_url}}" style="width: 52px;" alt="{{$store->name}}" />
            </div>
            <label class="fs16 fw6 mb-2">{{$store->name}}</label>
            <div class="reviews mb-2">
                <span class="fs16">{{ $total }}</span>
                <star-ratings push-class="mr5" :ratings="{{ round($reviewHelper->getAverageRating($product)) }}"></star-ratings>

                <div class="reviews fs13">

                </div>
            </div>
            <p class="fs13 fw3">{{$store->description}}</p>

            <a href="{{route('shop.store.view',$store->url)}}" class="btn btn-about-seller ">
                <span class="fs14 fw6">About Seller</span>
            </a>
        </div>
        <div class="seller-detail">
            <label class="fs16 fw6">Located In</label>
            <label class="location-label"><i class="material-icons text-down-3">maps</i>
                <span class="fs14 fw7 text-up-4 location-text">San Salvador</span></label>
            <div class="location-image">
                <google-maps></google-maps>
            </div>
        </div>

    </section>
    @endif
</div>
<div class="row">
    <div class="related-products">
        @include('shop::products.view.related-products')

        @include('shop::products.view.up-sells')
    </div>
</div>

{!! view_render_event('bagisto.shop.products.view.after', ['product' => $product]) !!}
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('vendor/webkul/ui/assets/js/ui.js') }}"></script>

<script type="text/javascript" src="{{ asset('themes/succinct/assets/js/jquery-ez-plus.js') }}"></script>

<script type='text/javascript' src='https://unpkg.com/spritespin@4.1.0/release/spritespin.js'></script>

<script type="text/x-template" id="product-view-template">
    <form
            method="POST"
            id="product-form"
            @click="onSubmit($event)"
            @submit.enter.prevent="onSubmit($event)"
            action="{{ route('shop.cart.add', $product->id) }}"
        >
            <input type="hidden" name="is_buy_now" v-model="is_buy_now">

            <slot v-if="slot"></slot>

            <div v-else>
                <div class="spritespin"></div>
            </div>
        </form>
    </script>

<script>
    Vue.component('product-view', {
        inject: ['$validator'],
        template: '#product-view-template',
        data: function() {
            return {
                slot: true,
                is_buy_now: 0,
            }
        },

        mounted: function() {
            let currentProductId = '{{ $product->url_key }}';
            let existingViewed = window.localStorage.getItem('recentlyViewed');

            if (!existingViewed) {
                existingViewed = [];
            } else {
                existingViewed = JSON.parse(existingViewed);
            }

            if (existingViewed.indexOf(currentProductId) == -1) {
                existingViewed.push(currentProductId);

                if (existingViewed.length > 3)
                    existingViewed = existingViewed.slice(Math.max(existingViewed.length - 4, 1));

                window.localStorage.setItem('recentlyViewed', JSON.stringify(existingViewed));
            } else {
                var uniqueNames = [];

                $.each(existingViewed, function(i, el) {
                    if ($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                });

                uniqueNames.push(currentProductId);

                uniqueNames.splice(uniqueNames.indexOf(currentProductId), 1);

                window.localStorage.setItem('recentlyViewed', JSON.stringify(uniqueNames));
            }
        },

        methods: {
            onSubmit: function(event) {
                if (event.target.getAttribute('type') != 'submit')
                    return;

                event.preventDefault();

                this.$validator.validateAll().then(result => {
                    if (result) {
                        this.is_buy_now = event.target.classList.contains('buynow') ? 1 : 0;

                        setTimeout(function() {
                            document.getElementById('product-form').submit();
                        }, 0);
                    } else {
                        this.activateAutoScroll();
                    }
                });
            },

            activateAutoScroll: function(event) {

                /**
                 * This is normal Element
                 */
                const normalElement = document.querySelector(
                    '.control-error:first-of-type'
                );

                /**
                 * Scroll Config
                 */
                const scrollConfig = {
                    behavior: 'smooth',
                    block: 'end',
                    inline: 'nearest',
                }

                if (normalElement) {
                    normalElement.scrollIntoView(scrollConfig);
                    return;
                }
            }
        }
    });

    window.onload = function() {
        var thumbList = document.getElementsByClassName('thumb-list')[0];
        var thumbFrame = document.getElementsByClassName('thumb-frame');
        var productHeroImage = document.getElementsByClassName('product-hero-image')[0];

        if (thumbList && productHeroImage) {
            for (let i = 0; i < thumbFrame.length; i++) {
                thumbFrame[i].style.height = (productHeroImage.offsetHeight / 4) + "px";
                thumbFrame[i].style.width = (productHeroImage.offsetHeight / 4) + "px";
            }

            if (screen.width > 720) {
                thumbList.style.width = (productHeroImage.offsetHeight / 4) + "px";
                thumbList.style.minWidth = (productHeroImage.offsetHeight / 4) + "px";
                thumbList.style.height = productHeroImage.offsetHeight + "px";
            }
        }

        window.onresize = function() {
            if (thumbList && productHeroImage) {

                for (let i = 0; i < thumbFrame.length; i++) {
                    thumbFrame[i].style.height = (productHeroImage.offsetHeight / 4) + "px";
                    thumbFrame[i].style.width = (productHeroImage.offsetHeight / 4) + "px";
                }

                if (screen.width > 720) {
                    thumbList.style.width = (productHeroImage.offsetHeight / 4) + "px";
                    thumbList.style.minWidth = (productHeroImage.offsetHeight / 4) + "px";
                    thumbList.style.height = productHeroImage.offsetHeight + "px";
                }
            }
        }
    };
</script>

<script type="text/x-template" id="google-maps-template">
    <gmap-map @click="saveLocation" :zoom="14" :center="center" style="width:100%;  height: 200px;overflow: hidden;border-radius: 12px;">
                    <gmap-marker :key="index" v-for="(m, index) in locationMarkers" :position="m.position" @click="center = m.position"></gmap-marker>
                </gmap-map>
</script>

<script>
    Vue.component('google-maps', {
        template: '#google-maps-template',

        inject: ['$validator'],


        name: "GoogleMap",
        data() {
            return {
                center: {
                    lat: 39.7837304,
                    lng: -100.4458825
                },
                locationMarkers: [],
                locPlaces: [],
                existingPlace: null
            };
        },

        mounted() {
            this.locateGeoLocation();
        },

        methods: {
            initMarker(loc) {
                this.existingPlace = loc;
                this.addLocationMarker();
            },
            saveLocation(e) {
                console.log(e);
            },
            addLocationMarker() {
                if (this.existingPlace) {
                    const marker = {
                        lat: this.existingPlace.geometry.location.lat(),
                        lng: this.existingPlace.geometry.location.lng()
                    };
                    this.locationMarkers.push({
                        position: marker
                    });
                    this.locPlaces.push(this.existingPlace);
                    this.center = marker;
                    this.existingPlace = null;
                }
            },
            locateGeoLocation: function() {
                navigator.geolocation.getCurrentPosition(res => {
                    this.center = {
                        lat: res.coords.latitude,
                        lng: res.coords.longitude
                    };
                });
            }
        },




        watch: {
            couponCode: function(value) {
                if (value != '') {
                    this.errorMessage = '';
                }
            }
        },


    });
</script>

@endpush