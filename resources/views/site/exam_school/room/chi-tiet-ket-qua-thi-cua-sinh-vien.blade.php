@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', 'Danh sách phòng thi đang thi')
@section('content')
    @include('site.exam_admin_site.include-CSS-JS')

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container">
            <div class="row">
                {{--@include('site.sidebar.sidebar_job_face')--}}
                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline bg-white">
                    @if(session('suscess'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! $value = session('suscess') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(session('erorr'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $value = session('erorr') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="row mgt10" id="js-postion">
                        <div class="col-lg-3 col-md-3 leftSidebar">

                            <div class="panelBox ">
                                <h1>{{ $room_school['code_room'] }}</h1>

                                <p class="mgb5"><strong>Tên phòng thi : </strong> <span>{{ $room_school['name_room'] }}
                                        câu</span></p>
                                <p class="mgb5"><strong>Ngày thi : </strong> <span>
                                                 <?php
                                        $date_time = date_create($room_school['day_room']);
                                        echo date_format($date_time, "d/m/Y");
                                        ?>
                                            </span>
                                </p>


                            </div>
                            <div class="panelBox mgt5">
                                <h1>{{ $exam['name_exam'] }}</h1>

                                <p class="mgb5"><strong>Số câu : </strong> <span>{{ $total_question }} câu</span></p>
                                <p class="mgb5"><strong>Thời gian : </strong> <span> {{ $exam['time_exam'] }}
                                        phút </span>
                                </p>


                            </div>

                            <div class="panelBox mgt5">

                                <p>Chú ý : Đáp án <span class="userCorrect ">màu vàng </span> là đáp án của bạn
                                    chọn</p>

                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 guide">
                            <div class="panel panel-default">
                                <div class="panel-heading">Thông tin sinh viên</div>
                                <div class="panel-body row">
                                    <div class="col-md-12">
                                        <div class="itemResult row">
                                            <p class="col-lg-6">Mã sinh viên:
                                                <span>{{ isset($student_school->student_code)   ? $student_school->student_code : ''}} </span>
                                            </p>

                                            <p class="col-lg-6">Tên sinh viên:
                                                <span>{{ isset($student_school->student_name)   ? $student_school->student_name : ''}}</span>
                                            </p>
                                            <p class="col-lg-6">Email sinh viên:
                                                <span>{{ isset($student_school->student_email)   ? $student_school->student_email : ''}}</span>
                                            </p>
                                            <p class="col-lg-6">Số điện thoại:
                                                <span>{{ isset($student_school->student_phone)   ? $student_school->student_phone : ''}}</span>
                                            </p>
                                            <p class="col-lg-6">Lớp hành chính:
                                                <span>{{ isset($student_school->class_primakey)   ? $student_school->class_primakey : ''}}</span>
                                            </p>
                                            <p class="col-lg-6">Lớp học phần:
                                                <span>{{ isset($student_school->class_section)   ? $student_school->class_section : ''}}</span>
                                            </p>
                                        </div>
                                    </div>


                                </div>
                                <div class="panel-heading">Kết quả bài thi của mã sinh viên
                                    : {{ $student_school->student_code }}</div>
                                <div class="panel-body row">
                                    <div class="col-lg-6 itemResult">
                                        <h2>Câu hỏi trắc nghiệm</h2>
                                        <p>Tống số câu : <span>{{ $total_choice }} câu</span></p>
                                        <p>Số câu đúng : {{ $total_true }} câu</p>
                                        <p>Số câu sai : {{ $total_choice - $total_true }} câu</p>

                                    </div>

                                    <div class="col-lg-6 itemResult">
                                        <h2>Câu hỏi tự luận</h2>
                                        <p>Tống số câu : <span>{{ $total_question - $total_choice }} câu</span>
                                        </p>
                                        <p>Bạn có thể chấm điểm cho phần thi tự luận của sinh viên</p>
                                    </div>


                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="row" id="js_sidebar-right">
                        <div class="col-lg-9 col-md-12 maxHeightcol">




                            <div class="listQuestion bg-white">
                                @if(!empty($list_question))
                                    <h3 class="f18 text-left pd10 ds-inline" style="background: #ddd">
                                        Nội dung câu hỏi
                                    </h3>


                                        @foreach($list_question as $id1 => $question)
                                            <div class="item_question">
                                                <div class="title_question">
                                                                     <span class="number_question"
                                                                           id="view{{ $id1 + 1 }}">
                                                                     Câu hỏi {{ $id1 + 1 }} @if($question['type_ques'] == 3)
                                                                             (tự luận) @endif
                                                                     </span>
                                                </div>
                                                <div class="clearfix"
                                                     id="view{{ $id1 + 1 }}"></div>
                                                <div class="content_question">
                                                    <a style="color: #000;display: block"
                                                       class="hidenShowQuestion"
                                                       id="aclickshow{{ $question['id_ques'] }}">
                                                        <div class="form-group content_title_question mgBottom0 mgTop10"
                                                             style="float:left;">
                                                            <p> {!! isset($question['name_ques']) ? $question['name_ques'] : '' !!}</p>

                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div id="questionshow{{ $question['id_ques'] }}" class="">
                                                    <div class="clearfix"></div>
                                                    <div class="answers_question ">
                                                        <div class="@if($question['show_answer_ques'] == '0')answer0
                                                                @elseif($question['show_answer_ques'] == '1')
                                                                answer1
@elseif($question['show_answer_ques'] == '2')
                                                                answer2
@else

                                                        @endif" id="">

                                                            {{--getAnswer($id_result,$id_ques,$type)--}}

                                                            <?php
                                                            $anser = 0;
                                                            $anser = \App\Exam\Detail_result_school::getAnswer($result_id, $question['id_ques']);
                                                            //                                                            echo $anser['user_correct_ques'];
                                                            ?>


                                                            @if($question['type_ques'] < 3)
                                                                <div class="answer_question text-left col-md-3">
                                                                    <label class="@if($anser['user_correct_ques'] == 'answer1') userCorrect @endif">
                                                                        <span class="{{ ($question['correct_answer'] == 'answer1') ? 'answertrue' : 'answerfasle' }}">A</span>
                                                                        . {!! isset($question['answer1']) ? $question['answer1'] : '' !!}
                                                                    </label>
                                                                </div>
                                                                <div class="answer_question text-left col-md-3">
                                                                    <label class="@if($anser['user_correct_ques'] == 'answer2') userCorrect @endif">
                                                                        <span class="{{ ($question['correct_answer'] == 'answer2') ? 'answertrue' : 'answerfasle' }}">B</span>
                                                                        . {!! isset($question['answer2']) ? $question['answer2'] : '' !!}
                                                                    </label>
                                                                </div>
                                                                <div class="answer_question  text-left col-md-3">
                                                                    <label class="@if($anser['user_correct_ques'] == 'answer3') userCorrect @endif">
                                                                        <span class="{{ ($question['correct_answer'] == 'answer3') ? 'answertrue' : 'answerfasle' }}">C</span>
                                                                        . {!! isset($question['answer3']) ? $question['answer3'] : '' !!}
                                                                    </label>
                                                                </div>
                                                                <div class="answer_question text-left  col-md-3">
                                                                    <label class="@if($anser['user_correct_ques'] == 'answer4') userCorrect @endif">
                                                                        <span class="{{ ($question['correct_answer'] == 'answer4') ? 'answertrue' : 'answerfasle' }}">D</span>
                                                                        . {!! isset($question['answer4']) ? $question['answer4'] : '' !!}
                                                                    </label>
                                                                </div>
                                                            @else
                                                                <div class="answer_question text-left  col-md-12">
                                                                    <p class="mgb0"><span class="userCorrect">Đáp án của sinh viên :</span>
                                                                    </p>
                                                                    <p class="mgb0">
                                                                        {{ isset($anser['user_correct_ques']) ? $anser['user_correct_ques'] : '' }}
                                                                    </p>

                                                                    <p class="mgb0 clred">Nhận xét câu trả lời cho đáp án của
                                                                        sinh viên :
                                                                    </p>
                                                                    <div style="border: 1px solid #ccc;padding: 10px">{{ isset($anser->teacher_correct) ? $anser->teacher_correct : '' }}</div>
                                                                    <p></p>
                                                                </div>
                                                            @endif


                                                            <div class="clearfix"></div>
                                                            @if($question['type_ques'] < 3)
                                                                <p class="text-left f16 answer_succcess"> Đáp án
                                                                    đúng là

                                                                    : @if($question['correct_answer'] == 'answer1')
                                                                        A @elseif($question['correct_answer'] == 'answer2')
                                                                        B @elseif($question['correct_answer'] == 'answer3')
                                                                        C @elseif($question['correct_answer'] == 'answer4')
                                                                        D @endif

                                                                </p>
                                                            @else
                                                                {{--<p class="text-left f16 answer_succcess">--}}
                                                                {{--Đáp án của câu hỏi tự luận sẽ được giáo viên chấm điểm và gửi lại sau !--}}
                                                                {{--</p>--}}
                                                                <p class="text-left f16 answer_succcess"> Đáp án của câu
                                                                    hỏi là
                                                                    : {{ $question['correct_answer'] }}
                                                                </p>
                                                            @endif

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
                        <div class="col-lg-3  bg-white" id="js-fixel" style="">
                            <div class="ListItemQues" id="sidebar_menu_fixel">
                                <h3 class="f18 text-center pd10 ds-inline mgTB10"
                                    style="background: #ddd">Danh sách câu
                                    hỏi</h3>
                                <div class="listhrel sidebar__inner">
                                    @if(!empty($list_question))
                                        <ul id="scroll">
                                            @foreach($list_question as $id1 => $question)
                                                <li>
                                                    <?php
                                                    $anser = 0;
                                                    $anser = \App\Exam\Detail_result_school::getAnswer($result_id, $question['id_ques'])?>

                                                    <a class="@if($question->correct_answer == $anser['user_correct_ques']) anserSuccess @else anserErorr @endif"
                                                       href="#view{{ $id1 }}"> Câu
                                                        hỏi {{ $id1 + 1 }} @if($question['type_ques'] == 3)
                                                            (TL) @endif</a>
                                                    <div class="group">
                                                        <a href="#view{{ $id1 }}"
                                                           title="Xem câu hỏi"><i class="fa fa-eye"
                                                                                  aria-hidden="true"></i></a>

                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.js"></script>--}}
    <div class="modal fade" id="myModalDelete0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="margin-top: 60px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn muốn xóa?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" class="submitDelete" method="post">
                    {!! csrf_field() !!}
                    <div class="modal-footer" style="border-top: 0px">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Xóa</button>
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
    {{--<style>--}}
    {{--#sidebar_menu_fixel {--}}
    {{--position: fixed;--}}
    {{--right: 0;--}}
    {{--min-width: 15%;--}}
    {{--}--}}
    {{--</style>--}}

    <script>
        $(document).ready(function ($) {
            var width = $(window ).width();
            // if(width < 900)
            // {
            //     $('#js_toogle_sidebar').hide();
            // }
            $(this).scrollTop(0);
            var s1 = $("header");
            var s2 = $("#js-postion");
            var pos = s1.position();
            var posheight = s1.height();
            var heightbody = $('body').height();
            var heightwindow = $(window).height();
            // alert('body ' + heightbody +'---------' + 'window' + heightwindow + '+++++++' + posheight);

            $(window).scroll(function () {
                var windowpos = $(window).scrollTop();
                if (windowpos > pos.top && ((heightbody - posheight) > heightwindow)) {
                    $('#js-fixel').addClass("js-scroll_sidebar-right");
                } else {
                    $('#js-fixel').removeClass("js-scroll_sidebar-right");
                }
                if(width < 1100)
                {
                    $('#js-fixel').removeClass("js-scroll_sidebar-right");
                }
            });

        });
    </script>

    <script>


    </script>
@endsection