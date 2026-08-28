@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'thêm mới câu hỏi trắc nghiệm')
@section('meta_description',  'mô tả để thi')


@section('content')
    @include('site.exam_admin_site.include-CSS-JS')
    <?php
    $type = intval($question->type_ques);
    ?>
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
                <div class="col-lg-12" style="padding: 0;">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-white">
                            <li class="breadcrumb-item"><a class="clHome"  href="{{ route('showExam') }}">Danh sách đề thi </a></li>
                            <li class="breadcrumb-item"><a class="clHome" href="{{ route('site_exam.edit',['site_exam' => $exam->id_exam]) }}">Đề thi {{ $exam->code_exam }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Copy câu hỏi</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 RightLink mgTB5  bg-white">
                    <div class="mgTB15">
                        <p class="mgBottom0">
                        <h2 class="f20 dsInline">Copy câu hỏi  cho mã đề thi</h2> <a
                                class="btnGreen btn clwhite">{{ $exam->code_exam }}</a>
                        </p>
                    </div>
                    <?php
                    $countZero = 0;
                    $countOne = 0;
                    $countTwo = 0;
                    $countZero = \App\Exam\Questions::countTypeQuestion($exam->id_exam,0);
                    $countOne = \App\Exam\Questions::countTypeQuestion($exam->id_exam,1);
                    $countTwo = \App\Exam\Questions::countTypeQuestion($exam->id_exam,2);
                    ?>
                    <div class="pdBottom5">
                        <a href="{{ route('getAllQuestionsZero',['id_exam'=>$exam->id_exam]) }}" class="btn btnSmall @if($type == 0) btnGreen clwhite  @else btnNoGreen @endif">Câu hỏi trắc
                            nghiệm({{ $countZero }})</a>
                        <a href="{{ route('getAllQuestionsOne',['id_exam'=>$exam->id_exam]) }}" class="btn btnSmall @if($type == 1) btnGreen clwhite  @else btnNoGreen @endif ">Câu hỏi đúng
                            sai({{ $countOne }})</a>
                        <a  href="{{ route('getAllQuestionsTwo',['id_exam'=>$exam->id_exam]) }}" class="btn btnSmall @if($type == 2) btnGreen clwhite  @else btnNoGreen @endif ">Câu hỏi tự
                            luận({{ $countTwo }})</a>
                    </div>

                </div>
            </div>

        </div>

    </section>
    <section class="ListQuestionExam" id="ListQuestionExam">
        <div class="container">
            {{--cau hoi trac nghiem--}}

            <form role="form" action="{{ route('site_question.store') }}" method="POST"
                  class="formQuestion">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                @if($type == 0)
                    <div class="row bg-white">
                        <div class="col-lg-12">
                            <h3 class="text-center f22 mgTop15  ">Copy câu hỏi trắc nghiệm</h3>
                        </div>
                        <div class="col-lg-6">
                            <div class="addQuestionZelo">
                                <div class="form-group">
                                    <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>
                                    <textarea rows="10" cols="50" name="name_ques" class="editor w checkeditor" id="addzero" required>{!! $question->name_ques !!}
                                    </textarea>
                                    @if(($errors->has('name_ques')))
                                        <label class="dsBlock mgBottom0 mgTop5"><i><span
                                                        class="clred error_addzero">Tiêu đề câu hỏi không được để trống</span></i></label>
                                    @endif
                                    <div class="form-group mgTop5">
                                        <label><strong>Hiển thị đáp án : </strong></label>

                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques" class="flat-red"
                                                   value="0" @if($question->show_answer_ques == 0) checked @endif >
                                            <!--  <input type="radio" name="r1" checked="checked"> -->
                                            <span>Chia đều hai cột </span>
                                        </label>
                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques" class="flat-red" value="1" @if($question->show_answer_ques == 1) checked @endif>
                                            <span>Các đáp án trên một hàng </span>
                                        </label>
                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques" class="flat-red" value="2" @if($question->show_answer_ques == 2) checked @endif>
                                            <span>Mỗi đáp án trên một hàng </span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="addQuestionZelo">
                                <div class="form-group  mgBottom0 pdTop0">
                                    <div class="">
                                        <label><strong>Nhập đáp án <span class="clred"> (*) </span> : </strong></label>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp án A <span
                                                        class="clred">(*)</span>
                                            </label>
                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="answer1"
                                                       placeholder="Đáp án A" name="answer1"
                                                       value="{{ $question->answer1 }}" >
                                            </div>
                                            @if(($errors->has('answer1')))
                                                <label class="dsBlock mgBottom0 mgTop5"><i><span
                                                                class="clred error_addzero">Đáp án A không được để trống</span></i></label>
                                            @endif
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp án B <span
                                                        class="clred">(*)</span>
                                            </label>
                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="answer2"
                                                       placeholder="Đáp án B" name="answer2"
                                                       value="{{ $question->answer2 }}" >
                                            </div>
                                            @if(($errors->has('answer2')))
                                                <label class="dsBlock mgBottom0 mgTop5"><i><span
                                                                class="clred error_addzero">Đáp án B không được để trống</span></i></label>
                                            @endif
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp án C
                                            </label>
                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="answer3"
                                                       placeholder="Đáp án C" name="answer3"
                                                       value="{{ $question->answer3 }}">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp án D
                                            </label>
                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="answer4"
                                                       placeholder="Đáp án D" name="answer4"
                                                       value="{{ $question->answer4 }}">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="form-group mgBottom0">
                                        <label><strong>Chọn đáp án đúng : </strong></label>
                                        <br>
                                        <label class="mgRight10">
                                            <input type="radio" name="correct_answer" class="flat-red"
                                                   value="answer1" @if($question->correct_answer == 'answer1')checked @endif>
                                            <!--  <input type="radio" name="r1" checked="checked"> -->
                                            <span>Đáp án A </span>
                                        </label>
                                        <label class="mgRight10">
                                            <input type="radio" name="correct_answer" class="flat-red"
                                                   value="answer2" @if($question->correct_answer == 'answer2')checked @endif>
                                            <span>Đáp án B </span>
                                        </label>
                                        <label class="mgRight10">
                                            <input type="radio" name="correct_answer" class="flat-red"
                                                   value="answer3" @if($question->correct_answer == 'answer3')checked @endif>
                                            <span>Đáp án C </span>
                                        </label>
                                        <label class="mgRight10">
                                            <input type="radio" name="correct_answer" class="flat-red"
                                                   value="answer4" @if($question->correct_answer == 'answer4')checked @endif>
                                            <span>Đáp án D </span>
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-12 control-label"><strong>Giải đáp đáp án đúng</strong></span>
                                        </label>
                                        <textarea rows="5" cols="50" name="explain_answer" class="form-control editor w checkeditor" id="explain_answer"
                                                  required>
                                       {!! $question->explain_answer !!}
                                        </textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mgBottom0 mgBottom20 text-left">
                                <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}">
                                <input type="hidden" name="type_ques" value="{{ $type }}">
                                <button type="submit" class="btn btnloadding btnGreen w100"><i class="fa fa-clone mgRight5" aria-hidden="true"></i>Lưu thay đổi
                                </button>
                            </div>
                        </div>

                    </div>
                @endif

                @if($type == 1)
                    <div class="row bg-white">
                        <div class="col-lg-12">
                            <h3 class="text-center f22 mgTop15  ">Copy câu hỏi đúng sai</h3>
                        </div>
                        <div class="col-lg-6">
                            <div class="addQuestionZelo">
                                <div class="form-group">
                                    <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>
                                    <textarea rows="10" cols="50" name="name_ques" class="editor w checkeditor" id="addzero" required>{!! $question->name_ques !!}
                                    </textarea>
                                    @if(($errors->has('name_ques')))
                                        <label class="dsBlock mgBottom0 mgTop5"><i><span
                                                        class="clred error_addzero">Tiêu đề câu hỏi không được để trống</span></i></label>
                                    @endif
                                    <div class="form-group mgTop5">
                                        <label><strong>Hiển thị đáp án : </strong></label>

                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques" class="flat-red"
                                                   value="0" @if($question->show_answer_ques == 0) checked @endif >
                                            <!--  <input type="radio" name="r1" checked="checked"> -->
                                            <span>Chia đều hai cột </span>
                                        </label>
                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques" class="flat-red" value="1" @if($question->show_answer_ques == 1) checked @endif>
                                            <span>Các đáp án trên một hàng </span>
                                        </label>
                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques" class="flat-red" value="2" @if($question->show_answer_ques == 2) checked @endif>
                                            <span>Mỗi đáp án trên một hàng </span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="addQuestionZelo">
                                <div class="form-group  mgBottom0 pdTop0">
                                    <div class="">
                                        <label><strong>Nhập đáp án <span class="clred"> (*) </span> : </strong></label>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp án A <span
                                                        class="clred">(*)</span>
                                            </label>
                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="answer1"
                                                       placeholder="Đáp án A" name="answer1"
                                                       value="{{ $question->answer1 }}" >
                                            </div>
                                            @if(($errors->has('answer1')))
                                                <label class="dsBlock mgBottom0 mgTop5"><i><span
                                                                class="clred error_addzero">Đáp án A không được để trống</span></i></label>
                                            @endif
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp án B <span
                                                        class="clred">(*)</span>
                                            </label>
                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="answer2"
                                                       placeholder="Đáp án B" name="answer2"
                                                       value="{{ $question->answer2 }}" >
                                            </div>
                                            @if(($errors->has('answer2')))
                                                <label class="dsBlock mgBottom0 mgTop5"><i><span
                                                                class="clred error_addzero">Đáp án B không được để trống</span></i></label>
                                            @endif
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="form-group mgBottom0">
                                        <label><strong>Chọn đáp án đúng : </strong></label>
                                        <br>
                                        <label class="mgRight10">
                                            <input type="radio" name="correct_answer" class="flat-red"
                                                   value="answer1" @if($question->correct_answer == 'answer1')checked @endif>
                                            <!--  <input type="radio" name="r1" checked="checked"> -->
                                            <span>Đáp án A </span>
                                        </label>
                                        <label class="mgRight10">
                                            <input type="radio" name="correct_answer" class="flat-red"
                                                   value="answer2" @if($question->correct_answer == 'answer2')checked @endif>
                                            <span>Đáp án B </span>
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-12 control-label"><strong>Giải đáp đáp án đúng</strong></span>
                                        </label>
                                        <textarea rows="5" cols="50" name="explain_answer" class="form-control editor w checkeditor" id="explain_answer"
                                                  required>
                                       {!! $question->explain_answer !!}
                                        </textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mgBottom0 mgBottom20 text-left">
                                <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}">
                                <input type="hidden" name="type_ques" value="{{ $type }}">
                                <button type="submit" class="btn btnloadding btnGreen w100"><i class="fa fa-clone mgRight5" aria-hidden="true"></i>Lưu thay đổi
                                </button>
                            </div>
                        </div>

                    </div>
                @endif

                @if($type == 2)
                    <div class="row bg-white">
                        <div class="col-lg-12">
                            <h3 class="text-center f22 mgTop15  ">Copy câu hỏi tự luận</h3>
                        </div>
                        <div class="col-lg-6">
                            <div class="addQuestionZelo">
                                <div class="form-group">
                                    <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>
                                    <textarea rows="10" cols="50" name="name_ques" class="editor w checkeditor" id="addzero" required>{!! $question->name_ques !!}
                                    </textarea>
                                    @if(($errors->has('name_ques')))
                                        <label class="dsBlock mgBottom0 mgTop5"><i><span
                                                        class="clred error_addzero">Tiêu đề câu hỏi không được để trống</span></i></label>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="addQuestionZelo">
                                <div class="form-group  mgBottom0 pdTop0">
                                    <label><strong>Đáp án câu hỏi : </strong></label>
                                    <textarea rows="8" cols="50" name="correct_answer" class="w100 pd10" id="">{{ $question->correct_answer }}
                                    </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-12 control-label"><strong>Giải đáp đáp án đúng</strong></span>
                                    </label>
                                    <textarea rows="5" cols="50" name="explain_answer" class="form-control editor w checkeditor" id="explain_answer"
                                              required>
                                       {!! $question->explain_answer !!}
                                        </textarea>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mgBottom0 mgBottom20 text-left">
                                <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}">
                                <input type="hidden" name="type_ques" value="{{ $type }}">
                                <button type="submit" class="btn btnloadding btnGreen w100"><i class="fa fa-clone mgRight5" aria-hidden="true"></i>Lưu thay đổi
                                </button>
                            </div>
                        </div>

                    </div>
                @endif
            </form>

        </div>
    </section>





    {{--validate fom--}}
    <script>
        $(function () {
            $('.maxHeightcol').matchHeight();
        });
        //     $(function() {
        //     var name_ques = $('#add001').val();
        //     $("#valiadateFormAdd").validate({
        //         rules: {
        //             name_ques: {
        //                 required: true,
        //                 minlength: 1,
        //             },
        //             answer1: "required",
        //             answer2: "required",
        //         },
        //         messages: {
        //             name_ques: "Vui lòng nhập tên câu hỏi",
        //             answer1: "Vui lòng nhập đáp án A",
        //             answer2: "Vui lòng nhập đáp án B",
        //         }
        //     });
        // });
        $(document).ready(function () {
            $('#valiadateFormAddZero').submit(function () {
                var error = 0;
                var comment = $('#addzero').val();
                if (comment == '') {
                    $('.error_addzero').show();
                    $('.error_addzero').html('Vui lòng nhập tên câu hỏi');
                    return false;
                }
            });
        });
    </script>

    @include('site.exam_admin_site.delete')
@endsection



