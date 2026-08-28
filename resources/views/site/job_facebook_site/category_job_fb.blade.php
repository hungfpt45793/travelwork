@extends('site.layout_site.site')
<?php
$meta_list_job_facebook = \App\Entity\Config_meta::getslug('viec-lam-facebook');
?>
@section('type_meta', 'website')
@section('title', isset($meta_list_job_facebook['meta_title']) ? $meta_list_job_facebook['meta_title'] : 'Danh sách tin tuyển dụng')
@section('meta_description')<?php $meta_descript = isset($meta_list_job_facebook->meta_description) ? \App\Ultility\Ultility::textLimit($meta_list_job_facebook->meta_description, 150) : 'Danh sách tin tuyển dụng'; ?>{{ $meta_descript }}
@endsection
@section('keywords', isset($meta_list_job_facebook['meta_keyword']) ? $meta_list_job_facebook['meta_keyword'] : '')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : ''  )
@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/tab_filter.css"/>
@endsection

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar_site.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 ">
                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_job_face') }}">Danh sách việc làm</a>
                            </li>
                        </ul>
                    </div>
                    <div class="btn_show_sidebar dsNone mbdsBlock" id="js_filter_job_face">
                        <ul class="nav">
                            <li class="nav-item">
                                <a style="color: #fff" class=" js_show_sidebar clWhite"><i class="fas fa-bars"></i> Menu
                                    <i class="fas fa-angle-up js_closed_open"></i> </a>
                            </li>

                        </ul>
                    </div>
                    <div class="mbdsNone js_filter_job_face" id="">
                        @include('site.filter_site.filter_job_face')
                    </div>

                    <section class="section_box_content section_box_content_new mgt20 ">
                        <div class="header_box">
                            <h1 class="title_box  fw6 f20 mgb0 col-f14">
                                Việc làm du lịch nổi bật
                            </h1>
                        </div>
                        <div class="content_box">
                            <div class="row">
                                @foreach($list_jobs as $job)
                                    @include('site.jobs_site.item_job_new')
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <section class="link_page bgWhite mgt20">
                        <div class="row">
                            <div class="col-12 text-center">
                                @include('site.default.item_pani',['page_link' => $list_jobs])
                            </div>
                        </div>
                    </section>

                    <section class="section_box_content section_box_content_new mgt20">
                        <div class="header_box">
                            <h1 class="title_box  fw6 f20 mgb0 col-f14">
                                Việc làm du lịch hấp dẫn
                            </h1>
                        </div>
                        <div class="content_box">
                            <div class="row">
                                @foreach($list_jobs2 as $job2)
                                    @include('site.jobs_site.item_job_new',['job'=>$job2])
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <section class="link_page bgWhite mgt20">
                        <div class="row">
                            <div class="col-12 text-center">
                                @include('site.default.item_pani',['page_link' => $list_jobs2])
                            </div>
                        </div>
                    </section>

                    <section class="section_box_content section_box_content_new mgt20">
                        <div class="header_box">
                            <h2 class="title_box">
                                Việc làm du lịch mới
                            </h2>

                        </div>

                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                @foreach ($list_job_fb as $jobFacebook)
                                    {{--@include('site.job_facebook.item_job_facebook')--}}
                                    {{--@include('site.jobs_site.item_job_facebook',['job'=> $jobFacebook])--}}
                                    @include('site.jobs_site.item_job_facebook_new',['job'=> $jobFacebook])
                                @endforeach
                            </div>
                        </div>
                    </section>


                    <section class="link_page bgWhite mgt20">
                        <div class="row">
                            <div class="col-12 text-center">
                                @include('site.default.item_pani',['page_link' => $list_job_fb])
                            </div>
                        </div>
                    </section>

                    <div class="bgBlock"></div>

                    @include('site.jobs_site.item_filter_job')

                    <div class="bgBlock"></div>
                    @include('site.module_index_site.dang-ky-tu-van')
                </div>
            </div>
            @include('site.module_index_site.hotline')
        </div>
    </section>
    {{--@include('site.mobile_bottom.fixel_bottom_category_job')--}}
    {{--//bottom reponsive 500--}}
    @include('site.mobile_bottom_site.fixel_bottom_category_job')
@endsection

@section('show_js')
    <script type="text/javascript" src="/assets/js/sitebar.js"></script>
    <script>
        $('.js_show_search_job').click(function () {
            $('.js_filter_job_face').toggle();
        });
        $('.js_show_sidebar').click(function () {
            $('#js_toogle_sidebar').toggle();
            $('.js_closed_open').toggle();
        });
    </script>
@endsection
