@extends('shop::layouts.master')

@include('shop::guest.compare.compare-products')

@section('page_title')
    {{ __('succinct::app.customer.compare.compare_similar_items') }}
@endsection

@section('content-wrapper')
    <compare-product></compare-product>
@endsection