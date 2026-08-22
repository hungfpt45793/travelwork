@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', 'Danh sách câu hỏi')
@section('meta_description', 'Danh sách câu hỏi')
@section('keywords', 'Quản lý khóa học')
@section('meta_image', !empty($course['course_image']) ? asset($course['course_image']) : asset($information['logo']))

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
                                <a href="{{ route('list_teacher_question') }}">Quản lý câu hỏi</a>
                            </li>
                        </ul>
                    </div>
                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14 mgb20 ">
                            Danh sách câu hỏi liên quan đến khóa học

                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <table id="jobfb" class="table table-hover table-bordered text-center" style="background: #fff">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên khóa học</th>
                                        <th>User đặt câu hỏi</th>
                                        <th>Câu hỏi</th>
                                        <th>Ngày cập nhật</th>
                                        <th>Thông tin câu hỏi</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if(!empty($list_question))
                                        @foreach($list_question as $id=>$question)
                                            <tr>
                                                <td>
                                                    {{ $id + 1 }}
                                                </td>
                                                <td class="text-left">
                                                    <a href="{{ route('course_showCourseDetail',['course_slug' => $question->course_slug]) }}">
                                                        {{ !empty($question->course_code) ? $question->course_code : '' }}-
                                                        </br>
                                                        {{ !empty($question->course_title) ? $question->course_title : '' }}
                                                    </a>
                                                </td>
                                                <td>
                                                <span>
                                                   {{ !empty($question->name) ? $question->name : '' }}
                                                </span>
                                                </td>

                                                <td>
                                                    {{ !empty($question->course_comments_content) ? $question->course_comments_content : '' }}
                                                </td>

                                                <td>
                                                    <?php
                                                    $date=date_create($question->updated_at);
                                                    echo date_format($date,"d/m/Y");
                                                    ?>
                                                </td>
                                                <td><a href="{{ route('detail_teacher_question',['course_comments_id'=>$question->course_comments_id]) }}"><span class="btn_submit_search">Xem chi tiết</span></a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p class="clRed">Chưa có câu hỏi</p>
                                    @endif
                                    </tbody>
                                </table>


                            </div>

                            <div class="link_page bgWhite mgt20">
                                <div class="col-12 text-center">
                                    @include('site.default.item_pani',['page_link' => $list_question])
                                </div>
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
    <script src="/public/assets/ckeditor/ckeditor.js"></script>

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

