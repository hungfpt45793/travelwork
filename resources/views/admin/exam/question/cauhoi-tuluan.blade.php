@extends('admin.layout.admin')

@section('title', 'Danh sách câu hỏi')

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
            right: 70px;
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php $exam = \App\Exam\Exam::getExam($id_exam);
            ?>
            <a href="#">
                <button class="btn btn-primary" style="    background: green;
    margin-bottom: 15px;">Danh sách câu hỏi của đề thi {{ $exam->code_exam }}</button>
            </a>
            <a href="{{ route('exam.index') }}">
                <button class="btn btn-primary" style="background: green; margin-bottom: 15px;">Danh sách đề thi</button> </a>

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Câu hỏi</a></li>
            <li><a href="#">Danh sách câu hỏi</a></li>
        </ol>
    </section>
    <section class="">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <?php
                        $countZero = 0;
                        $countOne = 0;
                        $countTwo = 0;
                        $countZero = \App\Exam\Questions::countTypeQuestion($exam->id_exam,0);
                        $countOne = \App\Exam\Questions::countTypeQuestion($exam->id_exam,1);
                        $countTwo = \App\Exam\Questions::countTypeQuestion($exam->id_exam,2);
                        ?>
                        <a href="{{ route('getQuestionZero',['id_exam'=>$id_exam]) }}">
                            <button class="btn btn-primary">Câu hỏi trắc nghiệm ({{ $countZero }})</button>
                        </a>
                        <a href="{{ route('getQuestionOne',['id_exam'=>$id_exam]) }}">
                            <button class="btn btn-primary">Câu hỏi đúng sai ({{ $countOne }})</button>
                        </a>
                        <a href="{{ route('getQuestionTwo',['id_exam'=>$id_exam]) }}">
                            <button class="btn btn-primary">Câu hỏi tự luận ({{ $countTwo }})</button>
                        </a>


                        @if (session('suscees'))
                            <div class="infoAlert">
                                <div class="alert alert-success">
                                    <span>{{ session('suscees') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert"
                                            aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="infoAlert">
                                <div class="alert alert-danger">
                                    <span>{{ session('error') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert"
                                            aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif

                    </div>

                    <!-- /.box-header -->

                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>

    <section class="ListQuestionExam ListQuestionScroll content" id="ListQuestionExam" style="background: #fff">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('createQuestionAdmin',['id_exam' => $exam->id_exam]) }}?type=2" class="btnOrang mgTB10 dsInline" style="margin-bottom: 15px;"><i class="fa fa-plus mgRight5" aria-hidden="true"></i>Thêm
                        mới câu hỏi</a>


                    <div class="row" id="scollProduct">
                        <div class="col-lg-9 maxHeightcol">
                            <div class="listQuestion bg-white">
                                @if(!empty($questionTwo))
                                    <h3 class="f18 text-left ds-inline" style="font-size: 20px;
                                        margin-left: 10px;margin-top: 0">Nội dung câu
                                        hỏi</h3>
                                    @foreach($questionTwo as $id1 => $question1)
                                        <div class="item_question">
                                            <div class="title_question">
                                     <span class="number_question" id="view{{ $question1['id_ques'] }}">
                                     Câu hỏi {{ $id1 + 1 }}
                                     </span>

                                                <a href="{{ route('editQuestionAdmin',['id_ques' => $question1['id_ques'] ]) }}"
                                                   class="edit_question" title="Sửa câu hỏi"><i
                                                            class="fa fa-edit"></i></a>
                                                <a href="{{ route('copyQuestionAdmin',['id_ques' => $question1['id_ques'] ]) }}"
                                                   class="copy_question" title="Copy câu hỏi"><i class="fa fa-clone"
                                                                                                 aria-hidden="true"></i></a>

                                                {{--<a  href="'.route('exam.destroy', ['id_exam' => $e_xams->id_exam]).'" class="btn btn-danger btnDelete"--}}
                                                {{--data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">--}}
                                                {{--<i class="fa fa-trash-o" aria-hidden="true"></i>--}}
                                                {{--</a>--}}


                                                <a href="{{ route('question.destroy',['id_ques' => $question1['id_ques'] ]) }}"
                                                   class=" delete_question btnDelete" data-toggle="modal"
                                                   data-target="#myModalDelete"
                                                   onclick="return submitDelete(this);" title="Xóa câu hỏi">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i> </a>


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
                                                        <!-- ba truong hop chon kiểu đáp án -->
                                                        <!--  one_answer two_answer three_answer -->



                                                        <div class="clearfix"></div>
                                                        <p class="text-left f16 answer_succcess"> Đáp án câu hỏi là :
                                                        </p>
                                                        <p>
                                                            {{ $question1['correct_answer'] }}
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
                        <div class="col-lg-3 maxHeightcol bg-white ListQuestionRight"
                             style="background: #fff;border-left: 1px solid green">
                            <div class="ListItemQues" id="sidebar">
                                <h3 class="f18 text-center pd10 ds-inline mgTB10" style="font-size: 20px;
                                        margin-left: 10px;margin-top: 0">Danh sách câu
                                    hỏi</h3>
                                <div class="listhrel sidebar__inner">
                                    @if(!empty($questionTwo))
                                        <ul id="scroll">
                                            @foreach($questionTwo as $id1 => $question1)
                                                <li>
                                                    <a href="#view{{ $question1['id_ques'] }}"> Câu
                                                        hỏi {{ $id1 + 1 }}</a>

                                                    <div class="group">
                                                        <a href="#view{{ $question1['id_ques'] }}"
                                                           title="Xem câu hỏi"><i class="fa fa-eye"
                                                                                  aria-hidden="true"></i></a>

                                                        <a href="{{ route('editQuestionAdmin',['id_ques' => $question1['id_ques'] ]) }}"
                                                           title="Sửa câu hỏi"><i class="fa fa-pencil"
                                                                                  aria-hidden="true"></i></a>
                                                        <a href="{{ route('copyQuestionAdmin',['id_ques' => $question1['id_ques'] ]) }}"
                                                           title="copy câu hỏi"><i class="fa fa-clone"
                                                                                   aria-hidden="true"></i> </a>
                                                        <a href="{{ route('question.destroy',['id_ques' => $question1['id_ques'] ]) }}"
                                                           title="Xóa câu hỏi" class="btnDelete" data-toggle="modal"
                                                           data-target="#myModalDelete"
                                                           onclick="return submitDelete(this);"><i class="fa fa-trash-o"
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

                {{--<button class="btn btn-block btn-success" id="addfile" type="button" data-toggle="modal" data-target="#add01">--}}
                {{--<i class="fa fa-plus mgRight5" aria-hidden="true"></i>Thêm câu hỏi--}}
                {{--</button>--}}


            </div>
        </div>
    </section>



    <script type="text/javascript"
            src="{{ asset('tracnghiem') }}/js/rAF.js"></script>
    <script type="text/javascript"
            src="{{ asset('tracnghiem') }}/js/ResizeSensor.js"></script>
    <script type="text/javascript"
            src="{{ asset('tracnghiem') }}/js/sticky-sidebar.js"></script>

    <script src="{{ asset('tracnghiem') }}/js/jquery.matchHeight-min.js"></script>



    @if (session('suscees_add'))
        <?php $id_ques = session('suscees_add');?>

        <script>
            $('#view{{$id_ques}}').focus()
        </script>
    @endif
    {{--trac nghiem  4 cau--}}
    <script>
        function clickmodal(e) {
            var id = $(e).attr('dataid')
            $('#' + id + '').modal('show');
        }
    </script>
    <script>
        // $( document ).ready(function() {
        //     $('#46').modal('hiden');
        // });
        function clickmodalcopy(e) {
            var id = $(e).attr('dataid');
            $('#copy' + id + '').modal('show');
        }


    </script>
    {{--validate fom--}}
    <script>
        $(function () {
            $('.maxHeightcol').matchHeight();
            // $('.answer_question ').matchHeight();
        });

        $(function () {
            var name_ques = $('#add001').val();
            $("#valiadateFormAdd").validate({
                rules: {
                    name_ques: {
                        required: true,
                        minlength: 1,
                    },
                    answer1: "required",
                    answer2: "required",
                },
                messages: {
                    name_ques: "Vui lòng nhập tên câu hỏi",
                    answer1: "Vui lòng nhập đáp án A",
                    answer2: "Vui lòng nhập đáp án B",
                }
            });
        });

        $(document).ready(function () {
            $('#valiadateFormAdd').submit(function () {
                var error = 0;
                var comment = $('.checkeditor').val();
                if (comment == '') {
                    error = 1;
                    $('.error_checkeditor').show();
                    $('.error_checkeditor').html('Vui lòng nhập tên câu hỏi');
                }
                if (error) {
                    return false;
                } else {
                    return true;
                }
            });
        });
        // back-to-top

    </script>
    <script>
        //var sticky = new Sticky('[data-sticky]');
        $(document).ready(function () {
            // Optimalisation: Store the references outside the event handler:
            var $window = $(window);

            var windowsize = $window.width();
            if (windowsize >= 1000) {
                var stickySidebar = new StickySidebar('#sidebar', {
                    topSpacing: 0,
                    bottomSpacing: 40,
                    containerSelector: '#scollProduct',
                    innerWrapperSelector: '.sidebar__inner'
                });
            }
        });
    </script>

    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
@endsection


