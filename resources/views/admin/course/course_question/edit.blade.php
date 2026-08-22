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
            <a href="{{ route('list_question_content',['course_content_id'=>$course_content->course_content_id]) }}">
                <button class="btn btn-primary" style="background: green; margin-bottom: 15px;">Danh sách đề thi
                </button>
            </a>

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Câu hỏi</a></li>
            <li><a href="#">Danh sách câu hỏi</a></li>
        </ol>
    </section>

    <section class="ListQuestionExam content" id="ListQuestionExam" style="background: #fff;">
        <div class="">
            <form role="form" action="{{ route('update_question_content',['id_ques' => $question->id_ques]) }}" method="POST"
                  class="formQuestion">
                {!! csrf_field() !!}
                {{ method_field('POST') }}

                    <div class="row bg-white">
                        <div class="col-lg-12">
                            <h3 class="text-center f22 mgTop15  ">Sửa câu hỏi trắc nghiệm</h3>
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

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mgBottom0 mgBottom20 text-left">
                                <input type="hidden" name="course_content_id" value="{{ $course_content->course_content_id }}">
                                <input type="hidden" name="type_ques" value="0">
                                <button type="submit" class="btn btnloadding btnGreen w100"><i class="fa fa-edit mgRight5"></i>Lưu thay đổi
                                </button>
                            </div>
                        </div>

                    </div>


            </form>
        </div>
    </section>

@endsection


