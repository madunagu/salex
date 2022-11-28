@inject ('toolbarHelper', 'Webkul\Product\Helpers\Toolbar')
@inject ('productRepository', 'Webkul\Product\Repositories\ProductRepository')

@extends('shop::layouts.master')

@section('page_title')
{{ trim($store->meta_title) != "" ? $store->meta_title : $store->name }}
@stop

@section('seo')
<meta name="description" content="{{ $store->meta_description }}" />
<meta name="keywords" content="{{ $store->meta_keywords }}" />
@stop

@php
$isProductsDisplayMode = in_array(
$store->display_mode, [
null,
'products_only',
'products_and_description'
]
);

$isDescriptionDisplayMode = in_array(
$store->display_mode, [
null,
'description_only',
'products_and_description'
]
);


$storeImages = $store->images()->get();
$images = [];

foreach($storeImages as $key=>$storeImage){
$images[] = [
'id' => $storeImage->id,
'url' => Storage::url($storeImage->path),
];
}

$banner = "";
if($storeImages){
$banner = array_pop($images);

$bannerURL = $banner['url'];
}



@endphp

@push('css')
<style type="text/css">
    .tabs ul {
        display: flex;
        justify-content: center
    }

    .tabs ul li {
        border: 1px solid transparent;
        border-radius: 50px;
        cursor: pointer;
        display: inline-block;
        list-style: none;
        padding: 15px 52px
    }

    .tabs ul li.active {
        border: 1px solid #dedede
    }

    .tabs ul li a {
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase
    }

    .store-banner {
        background-color: #EDE5FF;
        width: 100%;
        background-size: contain;
        min-height: 138px;
        background-repeat: no-repeat;
        background-position-x: right;
        margin-bottom: 64px;
    }

    .gallery__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 16px;
    }

    .gallery {
        display: grid;
        grid-template-columns: repeat(2, 4fr);
        grid-template-rows: repeat(2, 20vw);
        grid-gap: 15px;
    }

    .gallery__item {
        margin: 0 !important;
    }

    .gallery__item--1 {
        grid-column-start: 1;
        grid-column-end: 2;
        grid-row-start: 1;
        grid-row-end: 3;
    }

    .gallery__item--2 {
        grid-column-start: 2;
        grid-column-end: 3;
        grid-row-start: 1;
        grid-row-end: 2;
    }

    .gallery__item--3 {
        grid-column-start: 2;
        grid-column-end: 3;
        grid-row-start: 2;
        grid-row-end: 3;
    }

    .product-price span:first-child,
    .product-price span:last-child {
        font-size: 18px;
        font-weight: 600;
    }

    @media only screen and (max-width: 992px) {
        .main-content-wrapper .vc-header {
            box-shadow: unset;
        }
    }
</style>
@endpush



@section('content-wrapper')
<section class="row col-12 category-page-wrapper">
    <div class="store-banner" style="background-image: url({{$bannerURL}})">
        <div class="container">
            @php
            if(!empty($store->name)){
            $storeNameArray = explode(' ',$store->name);
            if(count($storeNameArray)>1){
            $prefixName = $storeNameArray[0];
            $suffixName = implode(' ',array_slice($storeNameArray,1));

            } else{
            $prefixName = '';
            $suffixName = $store->name;
            }
            }

            @endphp

            @if ($prefixName)
            <div class="mt-4 fs30 fw3 mb-1">{{ $prefixName }} </div>
            @endif
            @if($suffixName)
            <h2>{{ $suffixName }}</h2>
            @endif

            @if ($store->description)
            <div class="category-description fw2">
                {!! $store->description !!}
            </div>
            @endif
        </div>
    </div>
    <div></div>

    <div class="container mt-4">
        <div class="row remove-padding-margin">



            <div class="col-12 no-padding">
                <div class="hero-image">

                    <div class="gallery">
                        @foreach (array_slice($images,0,3) as $key => $image)
                        <figure class="gallery__item gallery__item--{{$key+1}}">
                            <img src="{{$image['url']}}" class="gallery__img" alt="Image 1">
                        </figure>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>


        <div class="mt-4">
            <tabs>
                <tab name="{{__('succinct::app.products.details')}}" :selected="true">
                    <store-component></store-component>
                </tab>
                <tab name="{{__('succinct::app.products.reviews-title')}}" :selected="false">
      
                </tab>
            </tabs>
        </div>
    </div>

    {!! view_render_event('bagisto.shop.store.index.after', ['store' => $store]) !!}
</section>
@stop

@push('scripts')

<script type="text/x-template" id="store-template">

    <div class="filters-container">
                        <template v-if="products.length >= 0">
                            @include ('shop::products.list.toolbar')
                        </template>
                    </div>

                    <div
                        class="category-block"
                        @if ($store->display_mode == 'description_only')
                            style="width: 100%"
                        @endif>

                        <shimmer-component v-if="isLoading" shimmer-count="4"></shimmer-component>

                        <template v-else-if="products.length > 0">
                            @if ($toolbarHelper->getCurrentMode() == 'grid')
                                <div class="row col-12 remove-padding-margin">
                                    <product-card
                                        :key="index"
                                        :product="product"
                                        v-for="(product, index) in products">
                                    </product-card>
                                </div>
                            @else
                                <div class="product-list">
                                    <product-card
                                        list=true
                                        :key="index"
                                        :product="product"
                                        v-for="(product, index) in products">
                                    </product-card>
                                </div>
                            @endif

                            {!! view_render_event('bagisto.shop.store.index.pagination.before', ['store' => $store]) !!}

                            <div class="bottom-toolbar" v-html="paginationHTML"></div>

                            {!! view_render_event('bagisto.shop.store.index.pagination.after', ['store' => $store]) !!}
                        </template>

                        <div class="product-list empty" v-else>
                            <h2>{{ __('shop::app.products.whoops') }}</h2>
                            <p>{{ __('shop::app.products.empty') }}</p>
                        </div>
                    </div>


    </script>

<script>
    Vue.component('store-component', {
        template: '#store-template',

        data: function() {
            return {
                'products': [],
                'isLoading': true,
                'paginationHTML': '',
            }
        },

        created: function() {
            this.getCategoryProducts();
        },

        methods: {
            'getCategoryProducts': function() {
                this.$http.get(`${this.$root.baseUrl}/category-products/4${window.location.search}`)
                    .then(response => {
                        this.isLoading = false;
                        this.products = response.data.products;
                        this.paginationHTML = response.data.paginationHTML;
                    })
                    .catch(error => {
                        this.isLoading = false;
                        console.log(this.__('error.something_went_wrong'));
                    })
            }
        }
    })
</script>

<script type="text/javascript" src="{{ asset('vendor/webkul/ui/assets/js/ui.js') }}"></script>

<script type="text/javascript" src="{{ asset('themes/succinct/assets/js/jquery-ez-plus.js') }}"></script>

@endpush