@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', isset($information['meta_title']) ? $information['meta_title'] : '')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('canonical', 'https://sanketoan.vn/')
@section('meta_url', 'https://sanketoan.vn/')
@section('content')
    <style>
        @media (max-width: 500px) {
            .select2-results__option[aria-selected] {
                cursor: pointer;
                color: #009385;
                font-size: 12px;
            }
        }
    </style>
    <div style="position: absolute!important;clip: rect(1px,1px,1px,1px)">
        <h1  class="">{{isset($information['meta_title']) ? $information['meta_title'] : ''}}</h1>
    </div>
    @include('site.partials.slider_new')
    @include('site.filter_site.filter_new')
    @include('site.default_site.list_carerr_total_home')
    @include('site.default_site.list_job_vip_new')
    {{--@include('site.default_site.list_job_vip_new2')--}}
    @include('site.default_site.list_job_new')
    {{--@include('site.default_site.list_agency')--}}
    @include('site.default_site.list_sale')
    @include('site.default_site.list_post_new')
    @include('site.default_site.list_voucher_home')
    @include('site.default_site.list_pod_cart')





    <?php
    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    //$MAC = exec('getmac');
    // Storing 'getmac' value in $MAC
    $MAC = '';
    ?>
@endsection
@section('show_js')
    <script>
        $(document).ready(function(){
            $('.js_item_agency_content').matchHeight();
        })

    </script>
@endsection
