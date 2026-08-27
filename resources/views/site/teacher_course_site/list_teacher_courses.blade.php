@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', 'Quản lý khóa học')
@section('meta_description', 'Quản lý khóa học')
@section('keywords', 'Quản lý khóa học')
@section('meta_image', !empty($course['course_image']) ? asset($course['course_image']) : asset($information['logo']))

@section('show_css')
    {{--<link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>--}}
    <link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/teacher_course.css"/>

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
                                <a href="{{ route('list_teacher_courses') }}">Quản lý khóa học</a>
                            </li>
                        </ul>
                    </div>
                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 bg-white mgb20 pd010 pd10 border_1px ">
                            Danh sách khóa học <a class="btnOrange f14 dsInline" href="{{ route('teacher_create_courses') }}"> Thêm mới khóa học </a>
                            <p class="mgb10 f14">Muốn đăng khóa học được duyệt vui lòng liên hệ với quản trị viên</p>

                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                @if (session('success'))
                                    <div class="alert alert-success text-center" role="alert" style="width: 100%">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger text-center" role="alert" style="width: 100%">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <table id="jobfb" class="table table-hover table-bordered text-center" style="background: #fff">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Trạng thái</th>
                                        <th>Tên khóa học</th>
                                        <th>Mã KH<sup>(20)</sup></th>
                                        <th>Giá khóa học</th>
                                        <th>Giá đã giảm</th>
                                        <th>Lượt xem</th>
                                        <th>Lượt học thử</th>
                                        <th>Lượt đăng ký</th>
                                        <th>Thao tác</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if(!empty($list_course))
                                        @foreach($list_course as $id=>$course)
                                            <tr>
                                            <td>
                                                {{ $id + 1 }}
                                            </td>
                                            <td>
                                                @if($course->course_status == 0)
                                                   <span class="btn_red">Chưa duyệt</span>
                                                @else
                                                    <span class="btn_green"> Đã duyệt</span>
                                                @endif
                                            </td>
                                            <td class="text-left">
                                                <a href="{{ route('course_showCourseDetail',['course_slug' => $course->course_slug]) }}">
                                                    {{ !empty($course->course_code) ? $course->course_code : '' }}-
                                                    {{ !empty($course->course_title) ? $course->course_title : '' }}
                                                </a>
                                            </td>
                                                <td><a href="{{ route('list_courses_active',['course_id'=>$course->course_id]) }}">Danh sách</a></td>
                                            <td>
                                                 <span class="clRed fw6">
                                                    {{ !empty($course->course_price) ? number_format($course->course_price) : '' }} <sup>đ</sup>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="clRed fw6">
                                                    {{ !empty($course->course_discount) ? number_format($course->course_discount) : '' }} <sup>đ</sup>
                                                </span>
                                            </td>
                                            <td>
                                                {{ !empty($course->course_views) ? $course->course_views : '0' }}
                                            </td>
                                            <td>
                                                {{ !empty($course->course_study) ? $course->course_study : '0' }}
                                            </td>
                                                <td>
                                                    <?php
                                                        $total_course = \App\Course\Course_employee::get_total_employee($course->course_id);
                                                    ?>
                                                    {{ !empty($total_course) ? $total_course : '0' }}
                                                </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button"
                                                            class="btn btn-info dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false"
                                                            style="    padding: 2px 10px;">Thao tác
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                           href="{{ route('list_course_chapter',['course_id'=>$course->course_id]) }}"
                                                           title="Đẩy tin">Danh sách chương <i
                                                                    class="fas fa-external-link-square-alt"></i></a>
                                                        <a class="dropdown-item"
                                                           href="{{ route('teacher_edit_courses',['course_id'=>$course->course_id]) }}"
                                                           title="Sửa khóa học">Sửa KH <i
                                                                    class="far fa-edit clorange"></i></a>
                                                        <a class="dropdown-item"
                                                           href="{{ route('teacher_delete_courses',['course_id'=>$course->course_id]) }}"
                                                           title="Xóa khóa học" class="clred" data-toggle="modal"  data-target="#myModalDelete" onclick="return submitDelete(this);"
                                                           style="color: red !important;">Xóa KH <i
                                                                    class="fas fa-stop-circle"></i></a>

                                                    </div>
                                                </div>
                                            </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p class="clRed">Chưa có khóa học nào được tạo</p>
                                    @endif
                                    </tbody>
                                </table>


                            </div>

                            <div class="link_page bgWhite mgt20">
                                    <div class="col-12 text-center">
                                        @include('site.default.item_pani',['page_link' => $list_course])
                                    </div>
                            </div>

                        </div>
                    </section>


                </div>
            </div>
            {{--@include('site.module_index_site.hotline')--}}
            <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content_1">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Bạn có chắc chắn muốn xóa?</h4>
                        </div>
                        <form action="" class="submitDelete" method="post">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary">Đồng ý</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                function submitDelete(e) {
                    var url = $(e).attr('href');
                    console.log(url);
                    $('.submitDelete').attr('action', url);
                    return false;
                }
            </script>
            <style>
                .modal-content_1 {
                    background: #fff;
                }
            </style>
        </div>
    </section>
    {{--@include('site.mobile_bottom.fixel_bottom_category_job')--}}
    {{--//bottom reponsive 500--}}
    {{--@include('site.mobile_bottom_site.fixel_bottom_category_job')--}}
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

