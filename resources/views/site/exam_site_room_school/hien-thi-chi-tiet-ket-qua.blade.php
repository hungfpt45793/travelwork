@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', 'Hiển thị kết quả thi')
@section('content')
    @include('site.exam_admin_site.include-CSS-JS')

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row">
              
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
                                <div class="panelBox">
                                    <h1>{{ $exam['name_exam'] }}</h1>
                                    <p><strong>Số câu : </strong> <span>{{ $total_question + $total_choice }} câu</span></p>
                                    <p><strong>Thời gian : </strong> <span> {{ $exam['time_exam'] }} phút </span></p>
                                </div>

                                {{--<div class="panelBox mgt5">--}}
                                {{--<p>Chú ý : Đáp án <span class="userCorrect ">màu vàng </span> là đáp án của bạn chọn</p>--}}
                                {{--</div>--}}
                            </div>
                            <div class="col-lg-9 col-md-9 guide">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Kết quả bài thi</div>
                                    <div class="panel-body row">
                                        <div class="col-lg-6 itemResult">
                                            <h2>Câu hỏi trắc nghiệm</h2>
                                            <p>Tống số câu : <span>{{ $total_question }} câu</span>  </p>
                                            <p>Số câu đúng : {{ $total_true }} câu</p>
                                            <p>Số câu sai : {{ $total_question - $total_true }} câu</p>

                                        </div>
                                        <div class="col-lg-6 itemResult">
                                            <h2>Câu hỏi tự luận</h2>
                                            <p>Tống số câu : <span>{{  $total_choice }} câu</span>  </p>
                                            <p>Kết quả của bài thi tự luận sẽ được giáo viên chấm bài gửi qua email của bạn</p>
                                        </div>


                                    </div>
                                </div>


                            </div>



                        </div>


                    </div>
                    <div class="row" id="js_sidebar-right">
                        <div class="col-lg-9 maxHeightcol">



                            <div class="listQuestion bg-white">
                                @if(!empty($list_question))
                                    <?php
//                                    echo '<pre>';
//                                    print_r($list_question);die();
                                    ?>
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



                                                        <?php
                                                        $anser = 0;
                                                        $anser = \App\Exam\Detail_result_school::getAnswer($result->id_result, $question['id_ques']);
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
                                                                <p class="mgb0"><span class="">Đáp án của sinh viên :</span>
                                                                </p>
                                                                <p class="mgb0 userCorrect dsInline">
                                                                    {{ isset($anser['user_correct_ques']) ? $anser['user_correct_ques'] : '' }}
                                                                </p>


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
                                                    $anser = \App\Exam\Detail_result_school::getAnswer($result->id_result, $question['id_ques'])?>

                                                    <a class="@if($question->correct_answer == $anser['user_correct_ques']) anserSuccess @else anserErorr @endif"
                                                       href="#view{{ $id1 }}"> Câu
                                                        hỏi {{ $id1 + 1 }} @if($question['type_ques'] == 3)(TL) @endif</a>
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


    <script>
        $(document).ready(function ($) {


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
                // if (windowpos > (pos.top)) {
                //     s2.addClass("ds-none");
                //     $('.submenuPC').click(function () {
                //         s2.removeClass("ds-none");
                //     });
                //
                //     $('.Mbsubmenu .Mobilemenu .navbar').css('margin-top', '0');
                // } else {
                //     s2.removeClass("ds-none");
                //     $('.Mbsubmenu .Mobilemenu .navbar').css('margin-top', '50px');
                //
                //
                // }
            });

        });
    </script>
@endsection