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
        .ListQuestionExam .btnGreen
        {
            background-color: green;
            color: #fff;
        }
        .ListQuestionExam h3
        {
            margin-top: 0px;
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

    <section class="ListQuestionExam content" id="ListQuestionExam" style="background: #fff;">
        <div class="">
            <form role="form" action="{{ route('question.store') }}" method="POST" id=""
                  class="formQuestion">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                {{--cau hoi trac nghiem--}}
                @if($type == 0)
                    <div class="row bg-white">
                        <div class="col-lg-12">
                            <h3 class="text-center f22 mgTop15  ">Thêm mới câu hỏi trắc nghiệm</h3>
                        </div>
                        <div class="col-lg-6">
                            <div class="addQuestionZelo">
                                <div class="form-group">
                                    <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>
                                    <textarea rows="10" cols="50" name="name_ques" class="editor w checkeditor" id="addzero" required>
                                        {!!  old('name_ques') !!}
                                    </textarea>
                                    @if(($errors->has('name_ques')))
                                        <label class="dsBlock mgBottom0 mgTop5"><i><span
                                                        class="clred error_addzero">Tiêu đề câu hỏi không được để trống</span></i></label>
                                    @endif
                                    <div class="form-group mgTop5">
                                        <label><strong>Hiển thị đáp án : </strong></label>

                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques" class="flat-red"
                                                   value="0" @if(old('show_answer_ques') == 0) checked @else checked @endif >
                                            <!--  <input type="radio" name="r1" checked="checked"> -->
                                            <span>Chia đều hai cột </span>
                                        </label>
                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques" class="flat-red" value="1" @if(old('show_answer_ques') == 1) checked @endif>
                                            <span>Các đáp án trên một hàng </span>
                                        </label>
                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques" class="flat-red" value="2"
                                                   @if(old('show_answer_ques') == 2) checked @endif>
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
                                                       value="{{ old('answer1') }}" >
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
                                                       value="{{ old('answer2') }}" >
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
                                                       value="{{ old('answer3') }}">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp án D
                                            </label>
                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="answer4"
                                                       placeholder="Đáp án D" name="answer4"
                                                       value="{{ old('answer4') }}">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="form-group mgBottom0">
                                        <label><strong>Chọn đáp án đúng : </strong></label>
                                        <br>
                                        <label class="mgRight10">
                                            <input type="radio" name="correct_answer" class="flat-red"
                                                   value="answer1"  @if(old('correct_answer') == 'answer1') checked @else checked @endif>
                                            <!--  <input type="radio" name="r1" checked="checked"> -->
                                            <span>Đáp án A </span>
                                        </label>
                                        <label class="mgRight10">
                                            <input type="radio" name="correct_answer" class="flat-red"
                                                   value="answer2" @if(old('correct_answer') == 'answer2') checked  @endif>
                                            <span>Đáp án B </span>
                                        </label>
                                        <label class="mgRight10">
                                            <input type="radio" name="correct_answer" class="flat-red"
                                                   value="answer3" @if(old('correct_answer') == 'answer3') checked  @endif>
                                            <span>Đáp án C </span>
                                        </label>
                                        <label class="mgRight10">
                                            <input type="radio" name="correct_answer" class="flat-red"
                                                   value="answer4" @if(old('correct_answer') == 'answer4') checked  @endif>
                                            <span>Đáp án D </span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mgBottom0 mgBottom20 text-left">

                                <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}">
                                <input type="hidden" name="type_ques" value="{{ $type }}">
                                <button type="submit" class="btn btnloadding btnGreen w100"><i
                                            class="fa fa-plus mgRight5" aria-hidden="true"></i> Lưu câu hỏi
                                </button>
                            </div>
                        </div>

                    </div>
                @endif

                @if($type == 1)
                    <div class="row bg-white">
                        <div class="col-lg-12">
                            <h3 class="text-center f22 mgTop15  ">Thêm mới câu hỏi Đúng sai</h3>
                        </div>
                        <div class="col-lg-6">
                            <div class="addQuestionZelo">
                                <div class="form-group">
                                    <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>
                                    <textarea rows="10" cols="50" name="name_ques" class="editor w checkeditor" id="addzero" required>
                                        {!!  old('name_ques') !!}
                                    </textarea>
                                    @if(($errors->has('name_ques')))
                                        <label class="dsBlock mgBottom0 mgTop5"><i><span
                                                        class="clred error_addzero">Tiêu đề câu hỏi không được để trống</span></i></label>
                                    @endif
                                    <div class="form-group mgTop5">
                                        <label><strong>Hiển thị đáp án : </strong></label>

                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques" class="flat-red"
                                                   value="0" @if(old('show_answer_ques') == 0) checked @else checked @endif >
                                            <!--  <input type="radio" name="r1" checked="checked"> -->
                                            <span>Chia đều hai cột </span>
                                        </label>
                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques" class="flat-red" value="1" @if(old('show_answer_ques') == 1) checked @endif>
                                            <span>Các đáp án trên một hàng </span>
                                        </label>
                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques" class="flat-red" value="2"
                                                   @if(old('show_answer_ques') == 2) checked @endif>
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
                                                       value="Đúng" >
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
                                                       value="Sai" >
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
                                                   value="answer1"  @if(old('correct_answer') == 'answer1') checked @else checked @endif>
                                            <!--  <input type="radio" name="r1" checked="checked"> -->
                                            <span>Đáp án A </span>
                                        </label>
                                        <label class="mgRight10">
                                            <input type="radio" name="correct_answer" class="flat-red"
                                                   value="answer2" @if(old('correct_answer') == 'answer2') checked  @endif>
                                            <span>Đáp án B </span>
                                        </label>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mgBottom0 mgBottom20 text-left">

                                <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}">
                                <input type="hidden" name="type_ques" value="{{ $type }}">
                                <button type="submit" class="btn btnloadding btnGreen w100"><i
                                            class="fa fa-plus mgRight5" aria-hidden="true"></i> Lưu câu hỏi
                                </button>
                            </div>
                        </div>

                    </div>
                @endif

                @if($type == 2)
                    <div class="row bg-white">
                        <div class="col-lg-12">
                            <h3 class="text-center f22 mgTop15  ">Thêm mới câu hỏi tự luận</h3>
                        </div>
                        <div class="col-lg-6">
                            <div class="addQuestionZelo">
                                <div class="form-group">
                                    <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>
                                    <textarea rows="10" cols="50" name="name_ques" class="editor w checkeditor" id="addzero" required>
                                        {!!  old('name_ques') !!}
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

                                    <div class="form-group">
                                        <label><strong>Nhập đáp án câu hỏi</strong></label>
                                        <textarea rows="15" cols="50" name="correct_answer" class="w100 pd10" style="padding: 10px;"></textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mgBottom0 mgBottom20 text-left">
                                <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}">
                                <input type="hidden" name="type_ques" value="{{ $type }}">
                                <button type="submit" class="btn btnloadding btnGreen w100"><i
                                            class="fa fa-plus mgRight5" aria-hidden="true"></i> Lưu câu hỏi
                                </button>
                            </div>
                        </div>

                    </div>
                @endif
            </form>
        </div>
    </section>




    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
@endsection


