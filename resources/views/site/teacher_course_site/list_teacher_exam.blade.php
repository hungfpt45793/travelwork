@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', 'Danh sách đề thi của khóa học')
@section('meta_description', 'Danh sách đề thi của khóa học')
@section('keywords', 'Danh sách đề thi của khóa học')
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
                                <a href="#">Đề thi của khóa học</a>
                            </li>
                        </ul>
                    </div>
                    <section class="jobsInteresting bgrWhite  radius5 mgt20 mgb20">
                        <div class="titleJobs  fw6 f20 bg-white mgb20 pd010 pd10 border_1px ">
                            Danh sách đề thi của khóa học <a class="btnOrange f14 dsInline" href="{{ route('create_content_question',['course_content_id' =>0]) }}"> Thêm mới câu hỏi </a>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14 border_1px ">
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
                                <div class="listQuestion bg-white" style="width: 100%;padding: 15px">
                                    @if(!empty($list_question))
                                        <h3 class="f18 text-left ds-inline" style="font-size: 20px;
                                        margin-left: 10px;margin-top: 0">Nội dung câu
                                            hỏi</h3>
                                        @foreach($list_question as $id1 => $question1)
                                            <div class="item_question">
                                                <div class="title_question">
                                     <span class="number_question" id="view{{ $question1['id_ques'] }}">
                                     Câu hỏi {{ $id1 + 1 }}
                                     </span>

                                                    <a href="{{ route('edit_content_question',['id_ques' => $question1['id_ques'] ]) }}"
                                                       class="edit_question" title="Sửa câu hỏi"><i
                                                                class="fa fa-edit"></i>Sửa câu hỏi</a>
                                                    <a href="{{ route('delete_content_question',['id_ques'=>$question1['id_ques']]) }}"
                                                       class=" delete_question btnDelete" data-toggle="modal"
                                                       data-target="#myModalDelete"
                                                       onclick="return submitDelete(this);" title="Xóa câu hỏi">
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>Xóa câu hỏi </a>


                                                </div>
                                                <div class="clearfix" id="view{{ $question1['id_ques'] }}"></div>
                                                <div class="content_question">
                                                    <a style="color: #000;display: block" class="hidenShowQuestion"
                                                       id="aclickshow{{ $question1['id_ques'] }}">
                                                        <div class="form-group content_title_question mgBottom0 mgTop10 titleQuestion"
                                                             style="float:left;">
                                                            {!! isset($question1['name_ques']) ? $question1['name_ques'] : '' !!}

                                                        </div>
                                                    </a>
                                                </div>

                                                <div id="questionshow{{ $question1['id_ques'] }}" class="">
                                                    <div class="clearfix"></div>
                                                    <div class="answers_question">
                                                        <div class="@if($question1['show_answer_ques'] == '0')
                                                                answer0
                                                            @elseif($question1['show_answer_ques'] == '1')
                                                                answer1
@elseif($question1['show_answer_ques'] == '2')
                                                                answer2
@else
                                                                answer
@endif" id="">
                                                            <!-- ba truong hop chon kiểu đáp án -->
                                                            <!--  one_answer two_answer three_answer -->
                                                            <div class="answer_question text-left">
                                                                <label class="">
                                                                    <span class="{{ ($question1['correct_answer'] == 'answer1') ? 'answertrue' : 'answerfasle' }}">A</span>
                                                                    . {!! isset($question1['answer1']) ? $question1['answer1'] : '' !!}
                                                                </label>
                                                            </div>
                                                            <div class="answer_question text-left">
                                                                <label>
                                                                    <span class="{{ ($question1['correct_answer'] == 'answer2') ? 'answertrue' : 'answerfasle' }}">B</span>
                                                                    . {!! isset($question1['answer2']) ? $question1['answer2'] : '' !!}
                                                                </label>
                                                            </div>
                                                            <div class="answer_question  text-left ">
                                                                <label>
                                                                    <span class="{{ ($question1['correct_answer'] == 'answer3') ? 'answertrue' : 'answerfasle' }}">C</span>
                                                                    . {!! isset($question1['answer3']) ? $question1['answer3'] : '' !!}
                                                                </label>
                                                            </div>
                                                            <div class="answer_question text-left">
                                                                <label>
                                                                    <span class="{{ ($question1['correct_answer'] == 'answer4') ? 'answertrue' : 'answerfasle' }}">D</span>
                                                                    . {!! isset($question1['answer4']) ? $question1['answer4'] : '' !!}
                                                                </label>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <p class="text-left f16 answer_succcess"> Đáp án đúng là
                                                                : @if($question1['correct_answer'] == 'answer1')
                                                                    A @elseif($question1['correct_answer'] == 'answer2')
                                                                    B @elseif($question1['correct_answer'] == 'answer3')
                                                                    C @elseif($question1['correct_answer'] == 'answer4')
                                                                    D @endif
                                                            </p>

                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    @else
                                        <p>Chưa có câu hỏi được tạo</p>
                                    @endif
                                </div>


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

