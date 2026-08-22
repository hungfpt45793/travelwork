@extends('site.layout_site.site')

<?php
$slug = 'danh-sach-ung-vien';
$meta_employee = \App\Entity\Config_meta::getslug($slug);

?>

@section('type_meta', 'website')
@section('title', !empty($meta_employee->meta_title) ? $meta_employee->meta_title :'Danh sách ứng viên')
@section('meta_description', !empty($meta_employee->meta_description) ? $meta_employee->meta_description :'Danh sách ứng viên')
@section('keywords', !empty($meta_employee->meta_keywords) ? $meta_employee->meta_keywords :'Danh sách ứng viên')
@section('meta_image', !empty($meta_employee['image']) ?  asset($meta_employee['image']) : asset($information['logo'])  )


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

                @if(\Illuminate\Support\Facades\Auth::check())
                    @include('site.sidebar_site.sidebar_job')
                @else
                    @include('site.sidebar_site.sidebar_no_login_employer')
                @endif

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

                    <div class="btn_show_sidebar dsNone mbdsBlock" id="js_filter_job_face">
                        <ul class="nav">
                            <li class="nav-item">
                                <a style="color: #fff" class="js_show_sidebar clWhite"><i class="fas fa-bars"></i> Menu
                                    <i class="fas fa-angle-up js_closed_open"></i> </a>
                            </li>

                        </ul>
                    </div>

                    <div class="mbdsNone js_filter_job_face">
                        @include('site.filter_site.filter_search_employee')
                    </div>

                    <section class="section_box_content mgt20">
                        <div class="header_box">
                            <h1 class="title_box  fw6 f20 mgb0 col-f14">
                                Ứng viên nổi bật
                            </h1>

                        </div>
                        <div class="content_box_employee">
                            @foreach($vip_employee as $employee)
                                @include('site.employee_site.item_employee_new',['employee' => $employee])
                            @endforeach
                        </div>
                    </section>

                    <section class=" bgWhite mgt20">
                        <div class="row">
                            <div class="col-12 text-center">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php
                                        $link_back = 1;
                                        $link_next = 2;
                                        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
                                        if ($page > 1) {
                                            $link_back = $page - 1;
                                            $link_next = $page + 1;
                                        }
                                        ?>
                                        <li class="page-item">
                                            <a style="background: #28a745;color: #fff;" class="page-link"
                                               href="{{ url()->current().'?page='.$link_back }}">Quay lại</a>
                                        </li>
                                        <li class="page-item"><a style="background: #28a745;color: #fff;"
                                                                 class="page-link"
                                                                 href="{{ url()->current().'?page='.$link_next }}">Tiếp
                                                theo</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </section>

                    @include('site.jobs_site.item_filter_employee')

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

    <script>
        $('#city').change(function () {
            var city = $(this).val();
            $.get('/tim-kiem-huyen/' + city, function (data) {
                $('#county').html('');
                $('#county').html(data);
            });
        });
        $('.js_show_search_job').click(function () {
            $('.js_filter_job_face').toggle();
        });
        $('.js_show_sidebar').click(function () {
            console.log('aaa');
            $('#js_toogle_sidebar').toggle();
            $('.js_closed_open').toggle();
        });
    </script>
@endsection