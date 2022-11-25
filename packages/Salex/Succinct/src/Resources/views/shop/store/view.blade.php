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

@push('css')
    <style type="text/css">
        .product-price span:first-child, .product-price span:last-child {
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
@endphp

@section('content-wrapper')
    <category-component></category-component>
@stop

@push('scripts')
    <script type="text/x-template" id="category-template">
        <section class="row col-12 velocity-divide-page category-page-wrapper">
            {!! view_render_event('bagisto.shop.store.index.before', ['store' => $store]) !!}

            @if (in_array($store->display_mode, [null, 'products_only', 'products_and_description']))
                @include ('shop::products.list.layered-navigation')
            @endif

            <div class="category-container right">
                <div class="row remove-padding-margin">
                    <div class="pl0 col-12">
                        <h2 class="fw6 mb10">{{ $store->name }}</h2>

                        @if ($isDescriptionDisplayMode)
                            @if ($store->description)
                                <div class="category-description">
                                    {!! $store->description !!}
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="col-12 no-padding">
                        <div class="hero-image">
                            @if (!is_null($store->image))
                                <img class="logo" src="{{ $store->image_url }}" alt="" width="20" height="20" />
                            @endif
                        </div>
                    </div>
                </div>

                @if ($isProductsDisplayMode)
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
                @endif
            </div>

            {!! view_render_event('bagisto.shop.store.index.after', ['store' => $store]) !!}
        </section>
    </script>

    <script>
        Vue.component('category-component', {
            template: '#category-template',

            data: function () {
                return {
                    'products': [],
                    'isLoading': true,
                    'paginationHTML': '',
                }
            },

            created: function () {
                this.getCategoryProducts();
            },

            methods: {
                'getCategoryProducts': function () {
                    this.$http.get(`${this.$root.baseUrl}/store-products/{{ $store->id }}${window.location.search}`)
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
@endpush