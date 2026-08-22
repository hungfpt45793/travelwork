@extends('site.layout_site.site')
<?php
$meta_employee = \App\Entity\Config_meta::getslug('danh-sach-ung-vien');
?>
@section('type_meta', 'website')
@section('title', !empty($meta_employee->meta_title) ? $meta_employee->meta_title :'Danh sách ứng viên')
@section('meta_description', !empty($meta_employee->meta_description) ? $meta_employee->meta_description :'Danh sách ứng viên')
@section('keywords', !empty($meta_employee->meta_keywords) ? $meta_employee->meta_keywords :'Danh sách ứng viên')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : ''  )

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/tab_filter.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/list_employee.css"/>
    {{--<link rel="stylesheet" type="text/css" href="/public/assets/web/css/modal_detail_cv_employee.css"/>--}}

@endsection

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar_site.sidebar_search_employee')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">

                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a class=""
                                   href="{{ route('show_employee') }}">Danh sách ứng viên</a>
                            </li>
                        </ul>
                    </div>


                    <div class="btn_show_sidebar dsNone mbdsBlock">
                        <ul class="nav">
                            <li class="nav-item">
                                <a style="color: #fff" class="js_show_sidebar clWhite"><i class="fas fa-bars"></i> Menu
                                    <i class="fas fa-angle-up js_closed_open"></i> </a>
                            </li>
                        </ul>
                    </div>
                    {{--<div class="mbdsNone js_filter_job_face">--}}
                    {{--@include('site.filter_site.filter_search_employee')--}}
                    {{--</div>--}}
                    <section class="section_box_content mgt20">
                        <div class="header_box">
                            <h1 class="title_box  fw6 f20 mgb0 col-f14">
                                Danh sách ứng viên {{ !empty($count) ? '('.number_format($count).' ứng viên )' : '' }}
                            </h1>

                        </div>
                        <div class="content_box">
                            <div class="row">
                                @foreach($list_employee as $emp)
                                    @include('site.employee_site.item_employee_new',['employee' => $emp])
                                @endforeach
                            </div>
                        </div>
                    </section>
                    <section class="link_page bgWhite mgt20">
                        <div class="row">
                            <div class="col-12 text-center">
                                @include('site.default.item_pani',['page_link' => $list_employee])
                            </div>
                        </div>
                    </section>
                    @include('site.jobs_site.item_filter_employee')
                </div>
            </div>
            @include('site.module_index_site.hotline')
        </div>
    </section>
    {{--@include('site.mobile_bottom_site.fixel_bottom_category_job')--}}
    @include('site.mobile_bottom_site.fixel_search_employee')

    {{--@include('site.employee_site.modal_detail_cv_employee')--}}
    {{--@include('site.employee_site.modal_detail_cv_employee_js')--}}
@endsection
@section('show_js')

    <script type="text/javascript" src="/public/assets/js/sitebar.js"></script>
    <script type="text/javascript" src="/public/assets/js/sweetalert.min.js"></script>

    {{--hien thi nut tim kiem o cuoi cung--}}
    <script>
        $(function () {
            var js_sd_fixel_bottom_w = $('.sidebarFillter').width();
            // console.log(js_sd_fixel_bottom_w);
            if(js_sd_fixel_bottom_w == 0 || js_sd_fixel_bottom_w == '')
            {
                js_sd_fixel_bottom_w = 300;
            }
            $('.js_sd_fixel_bottom').css('width', js_sd_fixel_bottom_w);
            var s1 = $('#js_toogle_sidebar').height();
            // var height_window = $(window).height();
            var windowpos = $(window).scrollTop();
            $(window).scroll(function () {
                var w_h = $(this).scrollTop();
                // console.log(s1);
                // console.log( 'winddw'+ w_h);
                if (w_h > 1000) {
                    $('.js_remove_fixel').removeClass('js_sd_fixel_bottom');
                } else {
                    $('.js_remove_fixel').addClass('js_sd_fixel_bottom');
                }
            });
        });
    </script>
    <script>
        $('#btnloading_frofile_search').click(function () {
            $('#btnloading_frofile_search').html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lọc ứng viên...');
            $('#btnloading_frofile_search').attr('disabled', false);
        });

        $('#btnloading_frofile').click(function () {
            $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lọc việc làm...');
            $btn.attr('disabled', false);
        });
        $('#search_city').change(function () {
            var search_city = $(this).val();
            $.get('/tim-kiem-huyen/' + search_city, function (data) {
                if(data)
                {
                    $('#search_county').html('');
                    $('#search_county').html(data);
                }
            });
        });
        $('.js_toogle_sidebar').click(function () {
            $('#js_toogle_sidebar').toggle();
        });
        $('.js_show_sidebar').on('click', function () {
            console.log('aaa');
            $('#js_toogle_sidebar').toggle();
            $('.js_closed_open').toggle();
        });
    </script>
@endsection