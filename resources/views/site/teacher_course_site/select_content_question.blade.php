@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', 'Danh sách câu hỏi')
@section('meta_description', 'Danh sách câu hỏi')
@section('keywords', 'Quản lý khóa học')
@section('meta_image', !empty($course['course_image']) ? asset($course['course_image']) : asset($information['logo']))

@section('show_css')
    {{--<link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>--}}
    <link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/teacher_course.css"/>

@endsection

@section('content')
    <style>
        #scroll {
            overflow-y: scroll;
            max-height: 500px;
            background: #fff;
            padding: 0;
        }
        #scroll li {
            display: block;
            height: 35px;

        }
        #scroll li a {
            color: #000;
        }
        .ListItemQues ul li .group {
            display: inline-block;
            text-align: right;
            float: right;
            width: 150px;
        }
        .ListItemQues ul li .group a {
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 3px;
            padding: 2px 4px;
            margin-right: 3px;
        }
        .edit_question {
            color: #fff;
            background: #ff6b00;
            padding: 4px 6px;
            display: inline-block;
            text-align: center;
            position: absolute;
            top: -28px;
            right: 120px;
            cursor: pointer;
        }
        .copy_question {
            color: #fff;
            background: #ff6b00;
            padding: 4px 6px;
            display: inline-block;
            text-align: center;
            position: absolute;
            top: -28px;
            right: 35px;
            cursor: pointer;
        }
        .btnOrang {
            padding: 3px 10px;
            color: #fff;
            background: #ff6b00;
            border: 1px solid #ff6b00;
        }
        .btnOrang:hover {
            padding: 3px 10px;
            color: #ff6b00;
            background: #fff;
            border: 1px solid #ff6b00;
            text-decoration: none;
        }
        .item_question .titleQuestion p ,.item_question .titleQuestion p strong
        {
            font-weight: 700;
        }

    </style>

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
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_chapter_content',['course_chapter_id' => $course_chapter->course_chapter_id])  }}">Danh sách bài học</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_content_question',['content_id' => $course_content->course_content_id])  }}">{{ $course_content->course_content_title }}</a>
                            </li>
                        </ul>
                    </div>
                    <section class="jobsInteresting radius5 mgt20">
                        <div class="titleJobs  fw6 f20 bg-white mgb20 pd010 pd10 border_1px ">
                            Chọn câu hỏi : {{ $course_content->course_content_title }}
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                @if (session('success'))
                                    <div class="alert alert-success text-center" role="alert" style="width: 100%">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger text-center" role="alert"  style="width: 100%">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                    <form method="post" action="{{ route('post_content_question') }}">

                                    <table id="jobfb" class="table table-bordered text-center" style="background: #fff">
                                        <thead>
                                        <tr>
                                            <th><input type="checkbox" name="check_all" value="" id="checkAll"></th>
                                            <th>STT</th>
                                            <th>Tiêu đề</th>
                                            <th>Bài học đã chọn</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @if(!empty($list_question))
                                            @foreach($list_question as $id=>$question)
                                                <tr>
                                                    <td>
                                                        <?php
                                                        $content_title = \App\Course\Course_chapter_contents::where('course_content_id',$question->course_content_id)->first();
                                                        ?>
                                                        @if($course_content->course_content_id == $content_title->course_content_id)
                                                            @else
                                                                <input type="checkbox" name="id_ques[]" value="{{ $question->id_ques }}">
                                                            @endif

                                                    </td>
                                                    <td style="width: 90px">
                                                        {{ $id + 1 }}
                                                    </br>
                                                        @if($course_content->course_content_id == $content_title->course_content_id)
                                                            <span class="clRed"><i>(đã chọn)</i></span>
                                                        @endif
                                                    </td>
                                                    <td class="text-left">
                                                   <span>{!! !empty($question->name_ques) ? $question->name_ques : '' !!}
                                                      </span>

                                                    </td>
                                                    <td class="text-left">
                                                        @if(!empty($content_title->course_content_title))
                                                        <span class="clGreen">
                                                            {{ $content_title->course_content_title }}
                                                        </span>
                                                           @else
                                                        <span class="clRed">
                                                            Chưa chọn bài nào
                                                        </span>
                                                           @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <p class="clRed">Chưa có câu hỏi nào được tạo</p>
                                        @endif
                                        </tbody>
                                    </table>
                                        <input type="hidden" name="course_content_id" value="{{ $course_content->course_content_id  }}">
                                        <p>
                                            <button type="submit" class="btn_green" style="width: 120px">Chọn câu hỏi</button>
                                        </p>
                                    </form>

                                    <section class="link_page bgWhite mgt20">
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                @include('site.default.item_pani',['page_link' => $list_question])
                                            </div>
                                        </div>
                                    </section>



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
    {{--@include('site.mobile_bottom.fixel_bottom_category_job')--}}
    {{--//bottom reponsive 500--}}
    {{--@include('site.mobile_bottom_site.fixel_bottom_category_job')--}}
@endsection

@section('show_js')
    <script>

        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        function submitDelete(e) {
            var url = $(e).attr('href');
            console.log(url);
            $('.submitDelete').attr('action', url);
            return false;
        }
    </script>
    <script src="/assets/ckeditor/ckeditor.js"></script>

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

