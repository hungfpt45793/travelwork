@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', 'Mã kích hoạt miễn phí của khóa học'. $course['course_title'])
@section('meta_description', 'Mã kích hoạt miễn phí của khóa học' .$course['course_title'])
@section('keywords', 'Mã kích hoạt miễn phí của khóa học' . $course['course_title'])
@section('meta_image',  asset($information['logo']))

@section('show_css')
    {{--<link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>--}}
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>

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
                                <a href="{{ route('list_teacher_courses') }}">Danh sách mã kích hoạt của khóa học : {{ !empty($course['course_title']) ? $course['course_title'] : '' }}</a>
                            </li>
                        </ul>
                    </div>
                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14 mgb20 ">
                           Danh sách mã kích hoạt của khóa học
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                @if(!empty($list_active))
                                <form action="{{ route('create_courses_active') }}" method="post">
                                    <input type="hidden" name="course_id" value="{{ $course['course_id'] }}">
                                    <button type="submit" class="btn btnOrange mgb10">Tạo mã kích hoạt miễn phí cho khóa học</button>
                                </form>
                                @endif
                                <table id="jobfb" class="table table-hover table-bordered text-center" style="background: #fff">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã kích hoạt</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                        <th>Hạn sử dụng</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if(!empty($list_active))
                                        @foreach($list_active as $id=>$active)
                                            <tr>
                                                <td>
                                                    {{ $id + 1 }}
                                                </td>
                                                <td>
                                                    <span class="btnOrange">{{ !empty($active->activation_code) ? $active->activation_code : '' }}</span>
                                                </td>
                                                <td>
                                                    @if($active->status_active_code == 0)
                                                        Chưa sử dụng
                                                    @else
                                                        Đã sử dụng
                                                    @endif
                                                </td>

                                                <td>
                                                    <?php
                                                    $date_create=date_create($active->created_at);
                                                    echo date_format($date_create,"d/m/Y");
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $date_update=date_create($active->date_end_active);
                                                    echo date_format($date_update,"d/m/Y");
                                                    ?>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p class="clRed">Chưa có khóa học nào được tạo</p>
                                    @endif
                                    </tbody>
                                </table>


                            </div>



                        </div>
                    </section>


                </div>
            </div>
            {{--@include('site.module_index_site.hotline')--}}
        </div>
    </section>
    {{--@include('site.mobile_bottom.fixel_bottom_category_job')--}}
    {{--//bottom reponsive 500--}}
    {{--@include('site.mobile_bottom_site.fixel_bottom_category_job')--}}
@endsection

@section('show_js')
    <script type="text/javascript" src="/public/assets/js/sitebar.js"></script>
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

