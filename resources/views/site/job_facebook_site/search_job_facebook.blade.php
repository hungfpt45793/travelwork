@extends('site.layout_site.site')

<?php
$title = 'Tuyển du lịch';
$caneer_id = isset($_GET['c']) ? $_GET['c'] : '';
$caneer = \App\Entity\Career::getIdCareer($caneer_id);
if(!empty($caneer))
{
    $title = 'Tuyển '.$caneer->career_category_name;
}
$province_id = isset($_GET['p']) ? $_GET['p'] : '';
$province = \App\Entity\Province::getId($province_id);
if(!empty($province))
{
    $title .= ' tại '.$province->province_name;
}
$title = ucwords($title);
?>
@section('type_meta', 'website')
@section('title', $title)
@section('meta_description', $title.' Từ Các Công Ty Uy Tín Trên sanketoan.vn')
@section('keywords',$title)
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/tab_filter.css"/>
@endsection

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">

                @include('site.sidebar_site.sidebar_search_job')

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
                                <a href="{{ route('list_job_face') }}">Danh sách việc làm</a>
                            </li>
                        </ul>
                    </div>
                    <div class="btn_show_sidebar dsNone mbdsBlock" id="js_filter_job_face">
                        <ul class="nav">
                            <li class="nav-item">
                                <a style="color: #fff" class=" js_show_sidebar clWhite"><i class="fas fa-bars"></i> Tìm kiếm nâng cao <i class="fas fa-angle-up js_closed_open"></i> </a>
                            </li>

                        </ul>
                    </div>



                    <section class="section_box_content section_box_content_new mgt20">
                        <div class="header_box">
                            <h1 class="title_box  fw6 f20 mgb0 col-f14">
                                Việc làm về du lịch
                            </h1>

                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                {{--//truyen bien hien thi image trng serach de biet tin la tin gi--}}
                                @foreach($list_jobs as $job)
                                    @include('site.jobs_site.item_job_new',['image'=>'job'])
                                @endforeach

                                @foreach ($list_job_fb as $jobFacebook)
                                    @include('site.jobs_site.item_job_facebook_new',['job'=> $jobFacebook])
                                    {{--@include('site.job_facebook_site.item_job_facebook_new',['image'=>'job_fb','job'=>$jobFacebook])--}}
                                @endforeach
                            </div>
                        </div>



                    </section>
                    <section class="link_page bgWhite mgt20">
                        <div class="row">
                            <div class="col-12 text-center">
                                @if($total_jobs < 10 && $total_job_fb < 10)
                                @elseif($total_jobs >= $total_job_fb && $total_jobs == 0)
                                    @include('site.default.item_pani',['page_link' => $total_jobs])
                                @else
                                    @include('site.default.item_pani',['page_link' => $list_job_fb])
                                @endif

                            </div>
                        </div>
                    </section>



                    @include('site.jobs_site.item_filter_job')

                    <div class="bgBlock"></div>
                    @include('site.module_index_site.dang-ky-tu-van')

                </div>
            </div>
            {{--@include('site.module_index_site.hotline')--}}
        </div>
    </section>

    @include('site.mobile_bottom_site.fixel_bottom_category_job')
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
            if($('input[name="old_employee"]').val() == '')
            {
                $('#btnloading_frofile_search').html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lọc ứng viên...');
                $('#btnloading_frofile_search').attr('disabled', false);
            }
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
