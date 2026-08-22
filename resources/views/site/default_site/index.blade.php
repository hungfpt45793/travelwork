@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', isset($information['meta_title']) ? $information['meta_title'] : '')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('canonical', 'https://sanketoan.vn/')
@section('meta_url', 'https://sanketoan.vn/')
@section('content')
    @include('site.default_site.item_jobs_indexs')
    <div class="bgBlock"></div>
    @include('site.default_site.item_recruitments')
    <div class="bgBlock"></div>
    @include('site.default_site.item_vouchers')
    <div class="bgBlock"></div>
    @include('site.default_site.item_news')
    <div class="bgBlock"></div>
    @include('site.module_index_site.dang-ky-tu-van')
    <div class="bgBlock"></div>
    @include('site.module_index_site.hotline')
    <div class="bgBlock"></div>
    <?php
    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    $MAC = '';
    ?>
    {{--//bottom reponsive 500--}}
    {{--@include('site.mobile_bottom_site.fixel_bottom_home')--}}
    @include('site.partials_site.fixel_mobile_bottom')
@endsection
@section('show_js')
@endsection
