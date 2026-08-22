@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Danh sách câu hỏi')
@section('meta_description',  'Danh sách câu hỏi')


@section('content')
    @include('site.exam_admin_site.include-CSS-JS')
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/rAF.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/ResizeSensor.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/sticky-sidebar.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/jquery.matchHeight-min.js') }}"></script>

    <section class="content bgrGray pdt5 UpdateUserTab">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs f18 white  pd10-20 col-f14">
                            <div class="link bgrWhite md-mgt20 disOnMobile">
                                <ul class="nav">
                                    <li class="nav-item pd8">
                                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang
                                            chủ</a>
                                    </li>
                                    <li class="nav-item pd8">
                                        <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                                    </li>

                                    <li class="nav-item pd8">
                                        <?php
                                        $link_url = '#';
                                        $link_url = \App\Ultility\Ultility::getUrl();
                                        ?>
                                        <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> Danh sách câu hỏi </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row" id="scollProduct">
                                <div class="col-lg-9 maxHeightcol">
                                    <div class="listQuestion bg-white">
                                        @if(!empty($question_1))
                                            <h3 class="f18 text-left pd10 ds-inline" style="background: #ddd">Nội dung câu hỏi</h3>
                                            @foreach($question_1 as $id1 => $question1)
                                                <div class="item_question">
                                                    <div class="title_question">
                                                        <?php
                                                        $sub = \App\Exam\School_subject::get_sub_id($question1->sub_id)
                                                        ?>
                                                     <span class="number_question" id="view{{ $question1['id_ques'] }}">
                                                     Câu hỏi {{ $id1 + 1 }} @if($question1['type_ques'] == 3)(tự luận) @endif
                                                         @if(!empty($sub)) <i>({{ $sub->sub_name }})</i> @endif
                                                     </span>
                                               

                                                    </div>
                                                    <div class="clearfix" id="view{{ $question1['id_ques'] }}"></div>
                                                    <div class="content_question">
                                                        <a style="color: #000;display: block" class="hidenShowQuestion"
                                                           id="aclickshow{{ $question1['id_ques'] }}">
                                                            <div class="form-group content_title_question mgBottom0 mgTop10"
                                                                 style="float:left;">
                                                                <p> {!! isset($question1['name_ques']) ? $question1['name_ques'] : '' !!}</p>

                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="clearfix"></div>


                                                    @if($question1->type_ques == 0 || $question1->type_ques == 1 || $question1->type_ques == 2)
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
                                                                <!-- ba truong hop chon kiểu đáp án -->
                                                                <!--  one_answer two_answer three_answer -->
                                                                <div class="answer_question text-left col-md-3">
                                                                    <label class="">
                                                                        <span class="{{ ($question1['correct_answer'] == 'answer1') ? 'answertrue' : 'answerfasle' }}">A</span>
                                                                        . {!! isset($question1['answer1']) ? $question1['answer1'] : '' !!}
                                                                    </label>
                                                                </div>
                                                                <div class="answer_question text-left col-md-3">
                                                                    <label>
                                                                        <span class="{{ ($question1['correct_answer'] == 'answer2') ? 'answertrue' : 'answerfasle' }}">B</span>
                                                                        . {!! isset($question1['answer2']) ? $question1['answer2'] : '' !!}
                                                                    </label>
                                                                </div>
                                                                @if(isset($question1['answer3']))
                                                                    <div class="answer_question  text-left col-md-3">
                                                                        <label>
                                                                            <span class="{{ ($question1['correct_answer'] == 'answer3') ? 'answertrue' : 'answerfasle' }}">C</span>
                                                                            . {!! isset($question1['answer3']) ? $question1['answer3'] : '' !!}
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                @if(isset($question1['answer4']))
                                                                    <div class="answer_question text-left  col-md-3">
                                                                        <label>
                                                                            <span class="{{ ($question1['correct_answer'] == 'answer4') ? 'answertrue' : 'answerfasle' }}">D</span>
                                                                            . {!! isset($question1['answer4']) ? $question1['answer4'] : '' !!}
                                                                        </label>
                                                                    </div>
                                                                @endif
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
                                                        @else
                                                        <div id="questionshow{{ $question1['id_ques'] }}" class="">
                                                            <div class="clearfix"></div>
                                                            <div class="answers_question ">
                                                                <div class="" id="">
                                                                    <!-- ba truong hop chon kiểu đáp án -->
                                                                    <!--  one_answer two_answer three_answer -->
                                                                    <div class="clearfix"></div>
                                                                    <p class="text-left f16 answer_succcess"> Câu trả lời là :
                                                                    </p>
                                                                    <p>
                                                                        {!! $question1['correct_answer'] !!}
                                                                    </p>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                            @endforeach
                                        @else
                                            <p>Chưa có câu hỏi được tạo</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-3 maxHeightcol bg-white ListQuestionRight" style="">
                                    <div class="ListItemQues" id="sidebar">
                                        <h3 class="f18 text-center pd10 ds-inline mgTB10" style="background: #ddd">Danh sách câu
                                            hỏi</h3>
                                        <div class="listhrel sidebar__inner">
                                            @if(!empty($question_1))
                                                <ul id="scroll">
                                                    @foreach($question_1 as $id1 => $question1)
                                                        <li>
                                                            <a href="#view{{ $question1['id_ques'] }}"> Câu
                                                                 {{ $id1 + 1 }} @if($question1['type_ques'] == 3)(TL) @endif</a>

                                                            <div class="group">
                                                                <a href="#view{{ $question1['id_ques'] }}"
                                                                   title="Xem câu hỏi"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                       
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
                    </section>


                </div>
            </div>
        </div>
    </section>
    @include('site.exam_admin_site.delete')
@endsection









