@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', 'Quản lý bài học của chương')
@section('meta_description', 'Quản lý bài học của chương')
@section('keywords', 'Quản lý bài học của chương')
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
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_course_chapter',['courses_id' => $course_chapter->course_id])  }}">Danh sách chương</a>
                            </li>
                        </ul>
                    </div>
                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 bg-white mgb20 pd010 pd10 border_1px  ">
                           Danh sách bài học của chương : {{ $course_chapter->course_chapter_name }}
                            <p class="mgb10">
                                <a class="btnOrange f14" href="{{ route('create_chapter_content',['chapter_id' =>$course_chapter->course_chapter_id]) }}"> Thêm mới </a>
                            </p>


                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                @if (session('success'))
                                    <div class="alert alert-success text-center" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger text-center" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <table id="jobfb" class="table table-hover table-bordered text-center" style="background: #fff">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tiêu đề</th>
                                        <th>Linh youtube</th>
                                        <th>Tài liệu</th>
                                        <th>Đề thi</th>
                                        <th>Thao tác</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if(!empty($list_chapter_content))
                                        @foreach($list_chapter_content as $id=>$content)
                                            <tr>
                                                <td>
                                                    {{ $id + 1 }}
                                                </td>
                                                <td class="text-left">
                                                   {{ !empty($content->course_content_title) ? $content->course_content_title : '' }}
                                                </td>
                                                <td>
                                                   {{ !empty($content->course_link_youtuber) ? $content->course_link_youtuber : '' }}
                                                </td>

                                                <td>
                                                    <?php
                                                    $total_voucher = \App\Course\Course_content_voucher::get_total_voucher($content->course_content_id);
                                                    ?>
                                                    <a class="btn_green" href="{{ route('list_voucher_content',['course_id'=>$content->course_content_id]) }}">Danh sách
                                                        <sup>({{ !empty($total_voucher) ? $total_voucher : 0  }})</sup>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php
                                                    $total_question = \App\Course\Questions_course_chapter_contents::get_total_question($content->course_content_id);
                                                    ?>
                                                    <a class="btn_green" href="{{ route('list_content_question',['course_id'=>$content->course_content_id]) }}">Danh sách
                                                        <sup>({{ !empty($total_question) ? $total_question : 0  }})</sup>
                                                    </a>
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
                                                               href="{{ route('edit_chapter_content',['coutent_id'=>$content->course_content_id]) }}"
                                                               title="Sửa KH">Sửa bài học <i class="far fa-edit clorange"></i></a>
                                                            <a class="dropdown-item"
                                                               href="{{ route('delete_chapter_content',['coutent_id'=>$content->course_content_id]) }}"
                                                               title="Xóa KH" class="clred" data-toggle="modal"  data-target="#myModalDelete" onclick="return submitDelete(this);"
                                                               style="color: red !important;">Xóa bài học <i
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



                        </div>
                    </section>


                </div>
            </div>
            {{--@include('site.module_index_site.hotline')--}}

        </div>
    </section>


    <div class="modal fade" id="myModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn muốn xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <form action="" class="submitDelete" method="post">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Đồng ý</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">--}}
    {{--<div class="modal-dialog" role="document">--}}
    {{--<div class="modal-content_1">--}}
    {{--<div class="modal-header">--}}
    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
    {{--<h4 class="modal-title" id="myModalLabel">Bạn có chắc chắn muốn xóa?</h4>--}}
    {{--</div>--}}
    {{--<form action="" class="submitDelete" method="post">--}}
    {{--<div class="modal-footer">--}}
    {{--<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>--}}
    {{--<button type="submit" class="btn btn-primary">Đồng ý</button>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<style>--}}
    {{--.modal-content_1 {--}}
    {{--background: #fff;--}}
    {{--}--}}
    {{--</style>--}}

@endsection

@section('show_js')
    <script>
        function submitDelete(e) {
            var url = $(e).attr('href');
            console.log(url);
            $('.submitDelete').attr('action', url);
            return false;
        }
    </script>


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

