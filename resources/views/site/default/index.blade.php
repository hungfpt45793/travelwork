@extends('site.layout.site')

@section('title', isset($information['meta_title']) ? $information['meta_title'] : '')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('content')

    {{--công việc--}}
    @include('site.default.item_jobs_indexs')
    {{--quy trinh tuyển dung--}}
    @include('site.default.item_recruitments')
    {{--tài lieu--}}
    @include('site.default.item_vouchers')
    {{--tin tuc--}}
    @include('site.default.item_news')
    {{--//so luong tin hien thi tren item_new--}}
    <div class="underLineY h10x bgrGray"></div>

    @include('site.module_index.dang-ky-tu-van')
    @include('site.module_index.hotline')
    <?php
    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    $MAC = exec('getmac');
    // Storing 'getmac' value in $MAC
    $MAC = strtok($MAC, ' ');
    ?>
    <!--
   {{--<script>--}}
    {{--console.log('<?php echo $ip;?>');--}}
    {{--console.log('<?php echo $MAC;?>');--}}
    {{--</script>--}}
            -->

    <script>

        if ($(window).width() <= 500) {
            // alert(1);
            $('#message_noti_mobile').modal('hide');
            $('.close_modal').click(function(){
                $('#message_noti_mobile').modal('hide');
            });
        }
    </script>

@endsection
