@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Danh sách câu hỏi của đề thi')
@section('meta_description',  'mô tả để thi')


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


    <section class="main bgUser">
        <div class="container">
            <div class="row">
                @include('site.exam_admin_site.itemTop')
                <div class="col-lg-12 RightLink mgTB5">
                    <div class="bg-white pd15">
                        <?php
                        $countZero = 0;
                        $countOne = 0;
                        $countTwo = 0;
                        $countZero = \App\Exam\Questions::countTypeQuestion($exam->id_exam,0);
                        $countOne = \App\Exam\Questions::countTypeQuestion($exam->id_exam,1);
                        $countTwo = \App\Exam\Questions::countTypeQuestion($exam->id_exam,2);
                        ?>
                        <div class="mgBottom10">
                            <a href="{{ route('getAllQuestionsZero',['id_exam'=>$exam->id_exam]) }}"
                               class="btn btnSmall btnGreen clwhite">Câu hỏi trắc nghiệm({{ $countZero }})</a>
                            <a href="{{ route('getAllQuestionsOne',['id_exam'=>$exam->id_exam]) }}"
                               class="btn btnSmall btnNoGreen ">Câu hỏi đúng sai({{ $countOne }})</a>
                            <a href="{{ route('getAllQuestionsTwo',['id_exam'=>$exam->id_exam]) }}"
                               class="btn btnSmall btnNoGreen ">Câu hỏi tự luận({{ $countTwo }})</a>
                        </div>

                        @if(session('suscees'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ $value = session('suscees') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $value = session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if($checklever == 0)
                        <a href="{{ route('createQuestion',['id_exam' => $exam->id_exam]) }}?type=0"
                           class="btnOrang mgTB10 dsInline"><i class="fa fa-plus mgRight5" aria-hidden="true"></i>Thêm
                            mới câu hỏi</a>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ListQuestionExam ListQuestionScroll" id="ListQuestionExam">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row" id="scollProduct">
                        <div class="col-lg-9 maxHeightcol">
                            <div class="listQuestion bg-white">
                                @if(!empty($question_1))
                                    <h3 class="f18 text-left pd10 ds-inline" style="background: #ddd">Nội dung câu hỏi</h3>
                                    @foreach($question_1 as $id1 => $question1)
                                        <div class="item_question">
                                            <div class="title_question">
                                     <span class="number_question" id="view{{ $question1['id_ques'] }}">
                                     Câu hỏi {{ $id1 + 1 }}
                                     </span>
                                                @if($checklever == 0)
                                                <a href="{{ route('editQuestion',['id_ques' => $question1['id_ques'] ]) }}"
                                                   class="edit_question" title="Sửa câu hỏi"><i
                                                            class="fa fa-edit"></i></a>
                                                <a href="{{ route('copyQuestion',['id_ques' => $question1['id_ques'] ]) }}"
                                                   class="copy_question" title="Copy câu hỏi"><i class="fa fa-clone" aria-hidden="true"></i></a>

                                                <a href="{{ route('site_question.destroy',['site_question' => $question1['id_ques'] ]) }}"
                                                   class=" delete_question btnDelete" data-toggle="modal"
                                                   data-target="#myModalDelete0"
                                                   onclick="return submitDelete(this);" title="Xóa câu hỏi">
                                                    <i class="far fa-trash-alt"></i> </a>
                                                    @endif

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
                                                        <div class="clearfix"></div>
                                                        <p class=""><span class="text-left f16 answer_succcess mgBottom5">Giải đáp kết quả:</span>{!! !empty($question1['explain_answer']) ? $question1['explain_answer'] : '' !!}</p>
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
                                <h3 class="f18 text-center pd10 ds-inline mgTB10" style="background: #ddd">Danh sách câu
                                    hỏi</h3>
                                <div class="listhrel sidebar__inner">
                                    @if(!empty($question_1))
                                        <ul id="scroll">
                                            @foreach($question_1 as $id1 => $question1)
                                                <li>
                                                    <a href="#view{{ $question1['id_ques'] }}"> Câu
                                                        hỏi {{ $id1 + 1 }}</a>

                                                    <div class="group">
                                                        <a href="#view{{ $question1['id_ques'] }}"
                                                           title="Xem câu hỏi"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        @if($checklever == 0)
                                                        <a href="{{ route('editQuestion',['id_ques' => $question1['id_ques'] ]) }}"
                                                           title="Sửa câu hỏi"><i class="fa fa-edit"></i></a>
                                                        <a href="{{ route('copyQuestion',['id_ques' => $question1['id_ques'] ]) }}"
                                                           title="copy câu hỏi"><i class="fa fa-clone"
                                                                                   aria-hidden="true"></i> </a>
                                                        <a href="{{ route('site_question.destroy',['site_question' => $question1['id_ques'] ]) }}"
                                                           title="Xóa câu hỏi" class="btnDelete" data-toggle="modal"
                                                           data-target="#myModalDelete0"
                                                           onclick="return submitDelete(this);"><i class="far fa-trash-alt"></i></a>
                                                    @endif
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


    <div class="modal fade bd-example-modal-lg ModalAdd" id="add01" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form role="form" action="{{ route('site_question.store') }}" method="POST" id="valiadateFormAdd"
                  class="valiadateForm">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Thêm mới câu hỏi (trắc nghiệm chọn 4 đáp án)</h4>
                    </div>
                    <div class="modal-body pd0">
                        <input type="hidden" name="id_exam"
                               value="{{ $exam->id_exam }}"/> {{--kiêu câu hoi--}} {{--0 là kiểu trắc nghiệm--}}
                        <input type="hidden" name="type_ques" value="0"/>
                        <div class="form-group col60">
                            <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>

                            <textarea class="editor w checkeditor" id="add001" name="name_ques" rows="10"
                                      cols="80" required="required"/> {{ old('name_ques') }}</textarea>
                            <label class="dsBlock mgBottom0 mgTop5"><i><span
                                            class="clred dsNone error_checkeditor"></span></i></label>
                            <div class="form-group mgTop5">
                                <label><strong>Hiển thị đáp án : </strong></label>

                                <label class="mgRight10 w100">
                                    <input type="radio" name="show_answer_ques0" class="flat-red"
                                           value="0" checked>
                                    <!--  <input type="radio" name="r1" checked="checked"> -->
                                    <span>Chia đều hai cột </span>
                                </label>
                                <label class="mgRight10 w100">
                                    <input type="radio" name="show_answer_ques0" class="flat-red" value="1">
                                    <span>Các đáp án trên một hàng </span>
                                </label>
                                <label class="mgRight10 w100">
                                    <input type="radio" name="show_answer_ques0" class="flat-red" value="2">
                                    <span>Mỗi đáp án trên một hàng </span>
                                </label>
                            </div>
                            <div class="form-group mgBottom0 mgTop20 textCt">
                                <button type="submit" class="btn btnloadding btnGreen"><i class="fa fa-plus"
                                                                                          aria-hidden="true"></i> Thêm
                                    mới
                                </button>
                                <button type="button" class="btn btn-default btnNoGreen" data-dismiss="modal"><i
                                            class="fa fa-times" aria-hidden="true"></i> Hủy bỏ
                                </button>
                            </div>


                        </div>
                        <div class="form-group col40 mgBottom0 pdTop0">
                            <div class="">
                                <label><strong>Nhập đáp án <span class="clred"> (*) </span> : </strong></label>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-12 control-label">Đáp án A <span
                                                class="clred">(*)</span>
                                    </label>
                                    <div class="col-sm-12 mgBottom5 ">
                                        <input type="text" class="form-control" id="answer1"
                                               placeholder="Đáp án A" name="answer1" value="{{ old('answer1') }}">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-12 control-label">Đáp án B <span
                                                class="clred">(*)</span>
                                    </label>
                                    <div class="col-sm-12 mgBottom5 ">
                                        <input type="text" class="form-control" id="answer2"
                                               placeholder="Đáp án B" name="answer2" value="{{ old('answer2') }}">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-12 control-label">Đáp án C
                                    </label>
                                    <div class="col-sm-12 mgBottom5 ">
                                        <input type="text" class="form-control" id="answer3"
                                               placeholder="Đáp án C" name="answer3" value="{{ old('answer3') }}">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-12 control-label">Đáp án D
                                    </label>
                                    <div class="col-sm-12 mgBottom5 ">
                                        <input type="text" class="form-control" id="answer4"
                                               placeholder="Đáp án D" name="answer4" value="{{ old('answer4') }}">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group mgBottom0">
                                <label><strong>Chọn đáp án đúng : </strong></label>
                                <br>
                                <label class="mgRight10">
                                    <input type="radio" name="correct_answer0" class="flat-red"
                                           value="answer1" checked>
                                    <!--  <input type="radio" name="r1" checked="checked"> -->
                                    <span>Đáp án A </span>
                                </label>
                                <label class="mgRight10">
                                    <input type="radio" name="correct_answer0" class="flat-red"
                                           value="answer2">
                                    <span>Đáp án B </span>
                                </label>
                                <label class="mgRight10">
                                    <input type="radio" name="correct_answer0" class="flat-red"
                                           value="answer3">
                                    <span>Đáp án C </span>
                                </label>
                                <label class="mgRight10">
                                    <input type="radio" name="correct_answer0" class="flat-red"
                                           value="answer4">
                                    <span>Đáp án D </span>
                                </label>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @if (session('suscees_add'))
        <?php $id_ques = session('suscees_add');?>

        <script>
            $('#view{{$id_ques}}').focus()
        </script>
    @endif
    {{--trac nghiem  4 cau--}}
    <script>
        function clickmodal(e) {
            var id = $(e).attr('dataid');

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

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.js"></script>--}}

    <script>
        // menu chay theo khi scrool chuot
        $(document).ready(function () {
            $(this).scrollTop(0);
            var s1 = $("header");

            var s2 = $(".submenu1");
            var pos = s1.position();
            var posheight = s1.height();
            var heightbody = $('body').height();
            var heightwindow = $(window).height();
            // alert('body ' + heightbody +'---------' + 'window' + heightwindow + '+++++++' + posheight);


        });
    </script>
    @include('site.exam_admin_site.delete')
@endsection
<script>
    $(window).scroll(function () {
        var windowpos = $(window).scrollTop();
        if (windowpos > pos.top && ((heightbody - posheight) > heightwindow )) {
            s1.removeClass("sticky");
        } else {
            s1.removeClass("sticky");
        }
    });
</script>



