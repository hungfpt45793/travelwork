@extends('site.layout.site')

@section('title', isset($exam['name_exam']) ? 'Kết quả của '.$exam['name_exam'] : 'Kết quả bài thi')
@section('meta_description', isset( $exam['intro_exam']) ? $exam['intro_exam']  : 'Mô tả đề thi')
@section('keywords', 'Đề thi trắc nghiệm du lịch')

@section('meta_image', !empty($exam['image_exam']) ? asset($exam['image_exam']) : ''  )
@section('meta_url', !empty($exam['id_exam']) ? route('getTestExam',['id_exam' => $exam['id_exam']]) : '' )

@section('content')

    <?php
    $exam = \App\Exam\Exam::getExam($id_exam);
    $count_no_correct0 = 0;
    //        lay ra tong so cau hoi co type = 0
    $count_ques0 = \App\Exam\Questions::countTypeQuestion($id_exam, 0);
    //        lay ra tong so cau tra loi the ma result
    $count_coreect0 = \App\Exam\DetailResultExam::countDetailType($result_id, 0);
    //so cau chua tra loi = tong so cau - tong so dap an trong cau
    $count_no_correct0 = $count_ques0 - $count_coreect0;
    $correct_success0 = 0;
    $detail_result0 = \App\Exam\DetailResultExam::getAllResult($result_id, 0);
    foreach ($detail_result0 as $id => $detail0) {
        $question0 = \App\Exam\Questions::getQuestion($detail0->id_ques, 0);
        if ($detail0->user_correct_ques == $question0->correct_answer) {
            $correct_success0++;
        }
    }
    $correct_erorr0 = $count_coreect0 - $correct_success0;
    //            cau hoi dung sai 1
    $count_no_correct1 = 0;
    $count_ques1 = \App\Exam\Questions::countTypeQuestion($id_exam, 1);
    $count_coreect1 = \App\Exam\DetailResultExam::countDetailType($result_id, 1);
    $count_no_correct1 = $count_ques1 - $count_coreect1;
    $correct_success1 = 0;
    $detail_result1 = \App\Exam\DetailResultExam::getAllResult($result_id, 1);
    foreach ($detail_result1 as $id => $detail1) {
        $question1 = \App\Exam\Questions::getQuestion($detail1->id_ques, 1);
        if ($detail1->user_correct_ques == $question1->correct_answer) {
            $correct_success1++;
        }
    }
    $correct_erorr1 = $count_coreect1 - $correct_success1;

    //            cau hoi tu luan
    $count_no_correct2 = 0;
    $count_correct_answen = 0;
    //    lay ve tong so cau hoi thuoc tu luan
    $count_ques2 = \App\Exam\Questions::countTypeQuestion($id_exam, 2);
    $count_coreect2 = \App\Exam\DetailResultExam::countDetailType($result_id, 2);

    //cau hoi da tra loi
    $count_correct_answen = \App\Exam\DetailResultExam::countDetailAnser($result_id, 2);
    //cau hoi chua tra loi
    $count_no_correct2 = $count_ques2 - $count_correct_answen;
    ?>
    <section class="main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
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
                </div>
            </div>
            <div class="row mgTop15">
                <div class="col-lg-3 col-md-3 leftSidebar">
                    <div class="panelBox">
                        <h1>{{ $exam['name_exam'] }}</h1>
                        <?php $total_question = 0;
                        $total_question = \App\Exam\Questions::countQuestion($exam['id_exam']);
                        ?>
                        <p><strong>Số câu : </strong> <span>{{ $total_question }} câu</span></p>
                        <p><strong>Thời gian : </strong> <span> {{ $exam['time_exam'] }} phút </span></p>


                    </div>
                </div>
                <div class="col-lg-9 col-md-7 guide">
                    <div class="panel panel-default">
                        <div class="panel-heading">Kết quả bài thi</div>
                        <div class="panel-body row">
                            <div class="col-lg-4 itemResult">
                                <h2>Câu hỏi trắc nghiệm</h2>
                                <p>Tống số câu : {{ $count_ques0 }} </p>
                                <p>Số câu đúng : {{ $correct_success0 }}</p>
                                <p>Số câu sai : {{ $correct_erorr0 }}</p>
                                <p>Số câu chưa làm : {{ $count_no_correct0 }}</p>
                            </div>
                            <div class="col-lg-4 itemResult">
                                <h2>Câu hỏi đúng sai</h2>
                                <p>Tống số câu : {{ $count_ques1 }} </p>
                                <p>Số câu đúng : {{ $correct_success1 }}</p>
                                <p>Số câu sai : {{ $correct_erorr1 }}</p>
                                <p>Số câu chưa làm : {{ $count_no_correct1 }}</p>
                            </div>
                            <div class="col-lg-4 itemResult">
                                <h2>Câu hỏi tự luận</h2>
                                <p>Tống số câu : {{ $count_ques2 }} </p>
                                <p>Số câu đã làm :{{ $count_correct_answen  }} </p>
                                {{--<p>Số câu đúng : {{ $correct_success1 }}</p>--}}
                                {{--<p>Số câu sai : {{ $correct_erorr1 }}</p>--}}
                                <p>Số câu chưa làm : {{ $count_no_correct2 }}</p>
                            </div>


                        </div>


                    </div>


                </div>

                <div class="col-lg-12">
                    <div class="LisTab ResultExam">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                   role="tab" aria-controls="nav-home" aria-selected="true">Trắc nghiệm</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                   role="tab" aria-controls="nav-profile" aria-selected="false">Đúng sai</a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                                   role="tab" aria-controls="nav-contact" aria-selected="false">Tự luận</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                 aria-labelledby="nav-home-tab">
                                <div class="TabContent">
                                    <div class="row" id="scollProduct">
                                        <div class="col-lg-9 maxHeightcol">
                                            <div class="listQuestion bg-white">
                                                @if(!empty($question_1))
                                                    <h3 class="f18 text-left pd10 ds-inline" style="background: #ddd">
                                                        Nội dung câu hỏi
                                                    </h3>
                                                    @foreach($question_1 as $id1 => $question1)
                                                        <div class="item_question" id="view{{ $question1['id_ques'] }}">
                                                            <div class="title_question">
                                                                 <span class="number_question">
                                                                 Câu hỏi {{ $id1 + 1 }}
                                                                 </span>
                                                            </div>
                                                            <div class="clearfix"
                                                                 ></div>
                                                            <div class="content_question">
                                                                <a style="color: #000;display: block"
                                                                   class="hidenShowQuestion"
                                                                   id="aclickshow{{ $question1['id_ques'] }}">
                                                                    <div class="form-group content_title_question mgBottom0 mgTop10"
                                                                         style="float:left;">
                                                                        <p> {!! isset($question1['name_ques']) ? $question1['name_ques'] : '' !!}</p>

                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div id="questionshow{{ $question1['id_ques'] }}" class="">
                                                                <div class="clearfix"></div>
                                                                <div class="answers_question ">
                                                                    <div class="@if($question1['show_answer_ques'] == '0')answer0
                                                            @elseif($question1['show_answer_ques'] == '1')
                                                                            answer1
@elseif($question1['show_answer_ques'] == '2')
                                                                            answer2
@else
                                                                            answer
@endif" id="">

                                                                    {{--getAnswer($id_result,$id_ques,$type)--}}

                                                                    <?php
                                                                    $anser = 0;
                                                                    $anser = \App\Exam\DetailResultExam::getAnswer($result_id, $question1['id_ques'], 0)?>
                                                                        <!--  one_answer two_answer three_answer -->
                                                                        <div class="answer_question text-left col-md-3">
                                                                            <label class="@if($anser['user_correct_ques'] == 'answer1') userCorrect @endif">
                                                                                <span class="{{ ($question1['correct_answer'] == 'answer1') ? 'answertrue' : 'answerfasle' }}">A</span>
                                                                                . {!! isset($question1['answer1']) ? $question1['answer1'] : '' !!}
                                                                            </label>
                                                                        </div>
                                                                        <div class="answer_question text-left col-md-3">
                                                                            <label class="@if($anser['user_correct_ques'] == 'answer2') userCorrect @endif">
                                                                                <span class="{{ ($question1['correct_answer'] == 'answer2') ? 'answertrue' : 'answerfasle' }}">B</span>
                                                                                . {!! isset($question1['answer2']) ? $question1['answer2'] : '' !!}
                                                                            </label>
                                                                        </div>
                                                                        @if(!empty($question1['answer3']))
                                                                            <div class="answer_question  text-left col-md-3">
                                                                                <label class="@if($anser['user_correct_ques'] == 'answer3') userCorrect @endif">
                                                                                    <span class="{{ ($question1['correct_answer'] == 'answer3') ? 'answertrue' : 'answerfasle' }}">C</span>
                                                                                    . {!! isset($question1['answer3']) ? $question1['answer3'] : '' !!}
                                                                                </label>
                                                                            </div>
                                                                        @endif

                                                                        @if(!empty($question1['answer4']))
                                                                            <div class="answer_question text-left  col-md-3">
                                                                                <label class="@if($anser['user_correct_ques'] == 'answer4') userCorrect @endif">
                                                                                    <span class="{{ ($question1['correct_answer'] == 'answer4') ? 'answertrue' : 'answerfasle' }}">D</span>
                                                                                    . {!! isset($question1['answer4']) ? $question1['answer4'] : '' !!}
                                                                                </label>
                                                                            </div>
                                                                        @endif

                                                                        <div class="clearfix"></div>
                                                                        <p class="text-left f16 answer_succcess"> Đáp án
                                                                            đúng là
                                                                            : @if($question1['correct_answer'] == 'answer1')
                                                                                A @elseif($question1['correct_answer'] == 'answer2')
                                                                                B @elseif($question1['correct_answer'] == 'answer3')
                                                                                C @elseif($question1['correct_answer'] == 'answer4')
                                                                                D @endif
                                                                        </p>
                                                                        <p class="text-left f16 answer_succcess">
                                                                            Giải thích:
                                                                            {!! !empty($question1['explain_answer']) ? $question1['explain_answer'] : 'Đang cập nhật' !!}
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
                                        <div class="col-lg-3 maxHeightcol bg-white ListQuestionRight" style="">
                                            <div class="ListItemQues" id="sidebar">
                                                <h3 class="f18 text-center pd10 ds-inline mgTB10"
                                                    style="background: #ddd">Danh sách câu
                                                    hỏi</h3>
                                                <div class="listhrel sidebar__inner">
                                                    @if(!empty($question_1))
                                                        <ul id="scroll">
                                                            @foreach($question_1 as $id1 => $question1)
                                                                <li>
                                                                    <?php
                                                                    $anser = 0;
                                                                    $anser = \App\Exam\DetailResultExam::getAnswer($result_id, $question1['id_ques'], 0)?>

                                                                    <a class="@if($question1->correct_answer == $anser['user_correct_ques']) anserSuccess @else anserErorr @endif"
                                                                       href="#view{{ $question1['id_ques'] }}"> Câu
                                                                        hỏi {{ $id1 + 1 }}</a>
                                                                    <div class="group">
                                                                        <a href="#view{{ $question1['id_ques'] }}"
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
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                 aria-labelledby="nav-profile-tab">
                                <div class="TabContent">
                                    <div class="row" id="scollProduct">
                                        <div class="col-lg-9 maxHeightcol">
                                            <div class="listQuestion bg-white">
                                                @if(!empty($question_2))
                                                    <h3 class="f18 text-left pd10 ds-inline" style="background: #ddd">
                                                        Nội dung câu hỏi
                                                    </h3>
                                                    @foreach($question_2 as $id1 => $question2)
                                                        <div class="item_question">
                                                            <div class="title_question">
                                                                 <span class="number_question"
                                                                       id="view{{ $question2['id_ques'] }}">
                                                                 Câu hỏi {{ $id1 + 1 }}
                                                                 </span>
                                                            </div>
                                                            <div class="clearfix"
                                                                 id="view{{ $question2['id_ques'] }}"></div>
                                                            <div class="content_question">
                                                                <a style="color: #000;display: block"
                                                                   class="hidenShowQuestion"
                                                                   id="aclickshow{{ $question2['id_ques'] }}">
                                                                    <div class="form-group content_title_question mgBottom0 mgTop10"
                                                                         style="float:left;">
                                                                        <p> {!! isset($question2['name_ques']) ? $question2['name_ques'] : '' !!}</p>

                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div id="questionshow{{ $question2['id_ques'] }}" class="">
                                                                <div class="clearfix"></div>
                                                                <div class="answers_question ">
                                                                    <div class="@if($question2['show_answer_ques'] == '0')answer0
                                                            @elseif($question2['show_answer_ques'] == '1')

                                                                    @else
                                                                            answer
@endif" id="">

                                                                    {{--getAnswer($id_result,$id_ques,$type)--}}

                                                                    <?php
                                                                    $anser1= 0;
                                                                    $anser1 = \App\Exam\DetailResultExam::getAnswer($result_id, $question2['id_ques'], 1)?>

                                                                        <div class="answer_question text-left col-md-3">
                                                                            <label class="@if($anser1['user_correct_ques'] == 'answer1') userCorrect @endif">

                                                                                <span class="{{ ($question2['correct_answer'] == 'answer1') ? 'answertrue' : 'answerfasle' }}">A</span>
                                                                                . {!! isset($question2['answer1']) ? $question2['answer1'] : '' !!}
                                                                            </label>
                                                                        </div>
                                                                        <div class="answer_question text-left col-md-3">
                                                                            <label class="@if($anser1['user_correct_ques'] == 'answer2') userCorrect @endif">
                                                                                <span class="{{ ($question2['correct_answer'] == 'answer2') ? 'answertrue' : 'answerfasle' }}">B</span>
                                                                                . {!! isset($question2['answer2']) ? $question2['answer2'] : '' !!}
                                                                            </label>
                                                                        </div>

                                                                        <p class="text-left f16 answer_succcess"> Đáp án
                                                                            đúng là
                                                                            : @if($question2['correct_answer'] == 'answer1')
                                                                                A @elseif($question2['correct_answer'] == 'answer2')
                                                                                B @endif
                                                                        </p>
                                                                        <p class="text-left f16 answer_succcess">
                                                                            Giải thích:
                                                                            {!! !empty($question2['explain_answer']) ? $question2['explain_answer'] : 'Đang cập nhật' !!}
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
                                        <div class="col-lg-3 maxHeightcol bg-white ListQuestionRight" style="">
                                            <div class="ListItemQues" id="sidebar">
                                                <h3 class="f18 text-center pd10 ds-inline mgTB10"
                                                    style="background: #ddd">Danh sách câu
                                                    hỏi</h3>
                                                <div class="listhrel sidebar__inner">
                                                    @if(!empty($question_2))
                                                        <ul id="scroll">
                                                            @foreach($question_2 as $id1 => $question2)
                                                                <li>
                                                                    <?php
                                                                    $anser2 = 0;
                                                                    $anser2 = \App\Exam\DetailResultExam::getAnswer($result_id, $question2['id_ques'], 1)?>

                                                                    <a class="@if($question2->correct_answer == $anser2['user_correct_ques']) anserSuccess @else anserErorr @endif"
                                                                       href="#view{{ $question2['id_ques'] }}"> Câu
                                                                        hỏi {{ $id1 + 1 }}</a>
                                                                    <div class="group">
                                                                        <a href="#view{{ $question2['id_ques'] }}"
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
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                 aria-labelledby="nav-contact-tab">
                                <div class="TabContent">

                                    <div class="row" id="scollProduct">
                                        <div class="col-lg-9 maxHeightcol">
                                            <div class="listQuestion bg-white">
                                                @if(!empty($question_3))
                                                    <h3 class="f18 text-left pd10 ds-inline" style="background: #ddd">
                                                        Nội dung câu hỏi

                                                    </h3>
                                                    @foreach($question_3 as $id1 => $question3)
                                                        <div class="item_question">
                                                            <div class="title_question">
                                                                 <span class="number_question"
                                                                       id="view{{ $question3['id_ques'] }}">
                                                                 Câu hỏi {{ $id1 + 1 }}
                                                                 </span>
                                                            </div>
                                                            <div class="clearfix"
                                                                 id="view{{ $question3['id_ques'] }}"></div>
                                                            <div class="content_question">
                                                                <a style="color: #000;display: block"
                                                                   class="hidenShowQuestion"
                                                                   id="aclickshow{{ $question3['id_ques'] }}">
                                                                    <div class="form-group content_title_question mgBottom0 mgTop10"
                                                                         style="float:left;">
                                                                        <p> {!! isset($question3['name_ques']) ? $question3['name_ques'] : '' !!}</p>

                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div id="questionshow{{ $question3['id_ques'] }}" class="">
                                                                <div class="clearfix"></div>
                                                                <div class="answers_question ">
                                                                    <div>

                                                                        <?php
                                                                        $anser = 0;
                                                                        $anser3 = \App\Exam\DetailResultExam::getAnswer($result_id, $question3['id_ques'], 2)
                                                                        ?>



                                                                        {{--getAnswer($id_result,$id_ques,$type)--}}
                                                                        <span class="clred">
                                                                        Đáp án của bạn :
                                                                                </span>
                                                                        <p>{{$anser3['user_correct_ques']  }}</p>
                                                                        <span class="clHome">
                                                                        Đáp án của câu hỏi :
                                                                            </span>
                                                                        <p>
                                                                            {{ $anser3['correct_answer'] }}
                                                                        </p>

                                                                            <p class="text-left f16 answer_succcess">
                                                                                Giải thích:
                                                                                {!! !empty($anser3['explain_answer']) ? $anser3['explain_answer'] : 'Đang cập nhật' !!}
                                                                            </p>
                                                                        <!-- ba truong hop chon kiểu đáp án -->
                                                                        <!--  one_answer two_answer three_answer -->


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
                                        <div class="col-lg-3 maxHeightcol bg-white ListQuestionRight" style="">
                                            <div class="ListItemQues" id="sidebar">
                                                <h3 class="f18 text-center pd10 ds-inline mgTB10"
                                                    style="background: #ddd">Danh sách câu
                                                    hỏi</h3>
                                                <div class="listhrel sidebar__inner">
                                                    @if(!empty($question_3))
                                                        <ul id="scroll">
                                                            @foreach($question_3 as $id1 => $question3)
                                                                <li>
                                                                    <?php
                                                                    $anser = 0;
                                                                    $anser = \App\Exam\DetailResultExam::getAnswer($result_id, $question1['id_ques'], 0)?>

                                                                    <a class=""
                                                                       href="#view{{ $question1['id_ques'] }}"> Câu
                                                                        hỏi {{ $id1 + 1 }}</a>
                                                                    <div class="group">
                                                                        <a href="#view{{ $question1['id_ques'] }}"
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
                    </div>
                </div>
            </div>

        </div>

        <script>
            //var sticky = new Sticky('[data-sticky]');
            $(document).ready(function () {
                $.ajax({
                    url : '{{ route('update_question_showResult') }}',
                    type : "post",
                    dataType:"text",
                    data : {
                        id_result : {{ $result_id }},
                        question_1 : {{ $correct_success0 }},
                        question_2 : {{ $correct_success1 }},
                        question_3 : {{ $count_correct_answen }},
                    },
                    success : function (result){
                        console.log("thanh cong");
                    },
                    error : function(result)
                    {
                        console.log("thất bại");
                    }
                });

                var id = 'time' + '<?php echo $id_exam; ?>';
                localStorage.removeItem(id);
                // Optimalisation: Store the references outside the event handler:
                var $window = $(window);

                var windowsize = $window.width();
                if (windowsize >= 1000) {
                    var stickySidebar = new StickySidebar('#sidebar', {
                        topSpacing: 50,
                        bottomSpacing: 40,
                        containerSelector: '#scollProduct',
                        innerWrapperSelector: '.sidebar__inner'
                    });
                }
            });
        </script>

    </section>



    <div class="modal fade" id="starExam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form role="form" action="{{ route('star_exam.store') }}" method="POST" id="star_form">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Đánh giá đề thi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Đánh giá  : </label>
                            <div class="rate-product  text-center"></div>
                            <script>
                                $(".rate-product").starRating({
                                    initialRating: 5,
                                    useFullStars: true,
                                    starSize: 40,
                                    disableAfterRate: false,
                                    strokeColor: '#894A00',
                                    callback: function(currentRating, $el){
                                        $('#rate').val(currentRating);
                                    }
                                });
                            </script>
                            <input type="hidden" value="" id="rate" name="qty_stars" class="star_rate">
                        </div>
                        <div class="form-group">
                            <label>Nội dung đánh giá : </label>
                            <textarea class="form-control" placeholder="Nhận xét" rows="4" name="content_star"> </textarea>
                            <input type="hidden" value="{{ $id_exam }}" name="id_exam">
                            <input type="hidden" value="{{ $result_id }}" name="result_id">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn bgHome clwhite">Lưu đánh giá</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <div class="modal fade" id="commentExam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form role="form" action="{{ route('comment_exam.store') }}" method="POST" id="comment_form">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bình luận đề thi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Bình luận đề thi : </label>
                            <textarea class="form-control" placeholder="Bình luận" rows="4" name="name_comment" id="name_comment" required> {{ old('name_comment') }}</textarea>
                            <input type="hidden" value="{{ $id_exam }}" name="id_exam">
                            <input type="hidden" value="{{ $result_id }}" name="result_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn bgHome clwhite">Lưu bình luận</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>

        //check danh giá sao
        $("#star_form").submit(function( event ) {
            if($('#rate').val()  == '' )
            {
                alert('Vui lòng chọn đánh giá sao');
                return false;
            }
        });
        $("#comment_form").submit(function( event ) {
            if($('#name_comment').val()  == '' )
            {
                alert('Vui lòng nhập nội dung bình luận');
                return false;
            }
        });
        // $('#sidebar ul li a').click(function(){
        //
        //     $('.bgHome').removeClass('sticky');
        // });


    </script>
    <script>
        $(document).ready(function () {
            @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1)
            $.ajax({
                type: "get",
                dataType: 'json',
                url: '{!! route('updateStatiscal_view_job',['val' => 'total_exam']) !!}',
                data: {
                    val : 'total_exam'
                },
                success: function (result) {
                    console.log("Thêm thành công");
                },
                error: function (result) {
                    console.log("Thêm thất bại  ");
                }
            });
            @endif
        });
    </script>


@endsection

