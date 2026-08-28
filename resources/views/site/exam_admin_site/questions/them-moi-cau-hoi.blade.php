@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Danh sách câu hỏi của đề thi')
@section('meta_description',  'mô tả để thi')


@section('content')
    @include('site.admin_site.include-CSS-JS')
    <section class="main bgUser">
        <div class="container">


            <div class="row">

                <div class="col-lg-12 RightLink mgTB5">
                    <div class="mgTB15">
                        <p class="mgBottom0"><h2 class="f20 dsInline">Danh sách câu hỏi của mã đề thi</h2> <a class="btnGreen btnSmall clwhite">{{ $exam->code_exam }}</a></p>
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
                </div>
            </div>

        </div>
    </section>

    <section class="ListQuestionExam" id="ListQuestionExam">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 tabcontent">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Câu hỏi trắc nghiệm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Câu hỏi đúng sai</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Câu hỏi tự luận</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="panel-heading">Câu hỏi phần trắc nghiệm ( 4 đáp án)</div>
                            <button class="btn btn-block btn-success" id="addfile" type="button" data-toggle="modal" data-target="#add01">
                                <i class="fa fa-plus mgRight5" aria-hidden="true"></i>Thêm câu hỏi
                            </button>
                            @if(!empty($question_1))
                                <div class="listQuestion">
                                    @foreach($question_1 as $id1 => $question1)
                                        <div class="item_question" id="view{{ $question1['id_ques'] }}">
                                            <div class="title_question">
                                     <span class="number_question">
                                     Câu hỏi {{ $id1 + 1 }}
                                     </span>
                                                <span class="edit_question" type="button" data-toggle="modal" data-target="#{{ isset($question1['id_ques']) ? $question1['id_ques'] : '' }}"><i class="fa fa-edit"></i></span>
                                                <span class="delete_question deleteItem1"> <a href="{{ route('site_question.destroy',['site_question' => $question1['id_ques'] ]) }}" class="btnDelete" data-toggle="modal" data-target="#myModalDelete0" onclick="return submitDelete(this);" style="color: #fff;text-decoration: none">
                                     X </a></span>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="content_question">
                                                <a  style="color: #000;display: block" class="hidenShowQuestion" id="aclickshow{{ $question1['id_ques'] }}">
                                                    <div class="form-group content_title_question mgBottom0 mgTop10" style="float:left;">
                                                        <p> {!! isset($question1['name_ques']) ? $question1['name_ques'] : '' !!}</p>
                                                        <span style="display: inline-block;border: 1px solid green; padding: 2px 5px;"><i class="fa fa-angle-double-down" aria-hidden="true"></i></span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div id="questionshow{{ $question1['id_ques'] }}" class="Showanswers">
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
                                                                <span class="{{ ($question1['correct_answer'] == 'answer1') ? 'answertrue' : 'answerfasle' }}">A</span> . {!! isset($question1['answer1']) ? $question1['answer1'] : '' !!}
                                                            </label>
                                                        </div>
                                                        <div class="answer_question text-left col-md-3">
                                                            <label>
                                                                <span class="{{ ($question1['correct_answer'] == 'answer2') ? 'answertrue' : 'answerfasle' }}">B</span> . {!! isset($question1['answer2']) ? $question1['answer2'] : '' !!}
                                                            </label>
                                                        </div>
                                                        <div class="answer_question  text-left col-md-3">
                                                            <label>
                                                                <span class="{{ ($question1['correct_answer'] == 'answer3') ? 'answertrue' : 'answerfasle' }}">C</span> . {!! isset($question1['answer3']) ? $question1['answer3'] : '' !!}
                                                            </label>
                                                        </div>
                                                        <div class="answer_question text-left  col-md-3">
                                                            <label>
                                                                <span class="{{ ($question1['correct_answer'] == 'answer4') ? 'answertrue' : 'answerfasle' }}">D</span> . {!! isset($question1['answer4']) ? $question1['answer4'] : '' !!}
                                                            </label>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <p class="text-left f16 answer_succcess"> Đáp án đúng là
                                                            :   @if($question1['correct_answer'] == 'answer1')
                                                                A @elseif($question1['correct_answer'] == 'answer2')
                                                                B @elseif($question1['correct_answer'] == 'answer3')
                                                                C @elseif($question1['correct_answer'] == 'answer4')
                                                                D @endif
                                                        </p>
                                                        <button class=" btn btn-primary pull-left mgRight5" type="button" data-toggle="modal" data-target="#{{ isset($question1['id_ques']) ? $question1['id_ques'] : '' }}">
                                                            Sửa câu hỏi
                                                        </button>
                                                        <button class=" btn btn-primary pull-left"><a href="{{ route('site_question.destroy',['site_question' => $question1['id_ques'] ]) }}" class="btnDelete" data-toggle="modal" data-target="#myModalDelete0" onclick="return submitDelete(this);" style="color: #fff;text-decoration: none">Xóa câu hỏi
                                                            </a></button>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            $(function () {
                                                $('#aclickshow{{ $question1['id_ques'] }}').click(function() {
                                                    $('#questionshow{{ $question1['id_ques'] }}').slideToggle( "slow" );
                                                });
                                            });
                                        </script>
                                    @endforeach
                                </div>
                            @else
                                <p>Chưa có câu hỏi được tạo</p>
                            @endif
                        </div>














                        <!-- END TAB_1 -->
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="panel-heading">Câu hỏi phần trắc nghiệm ( 2 đáp án)</div>

                            <button class="btn  btn-block btn-success" id="addfile" type="button" data-toggle="modal" data-target="#add02">
                                <i class="fa fa-plus mgRight5" aria-hidden="true"></i>Thêm câu hỏi
                            </button>

                            @if(!empty($question_2))
                                <div class="listQuestion">
                                    @foreach($question_2 as $id2 => $question2)
                                        <div class="item_question">
                                            <div class="title_question">
                                     <span class="number_question">
                                     Câu hỏi {{ $id2 + 1 }}
                                     </span>
                                                <span class="edit_question" type="button" data-toggle="modal" data-target="#{{ isset($question2['id_ques']) ? $question2['id_ques'] : '' }}"><i class="fa fa-edit"></i></span>
                                                <span class="delete_question deleteItem1"> <a href="{{ route('site_question.destroy',['site_question' => $question2['id_ques'] ]) }}" class="btnDelete" data-toggle="modal" data-target="#myModalDelete1" onclick="return submitDelete(this);" style="color: #fff;text-decoration: none">
                                     X </a></span>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="content_question">
                                                <a  style="color: #000;display: block" class="hidenShowQuestion" id="aclickshow{{ $question2['id_ques'] }}">
                                                    <div class="form-group content_title_question mgBottom0 mgTop10" style="float:left;">
                                                        <p> {!! isset($question2['name_ques']) ? $question2['name_ques'] : '' !!}</p>
                                                        <span style="display: inline-block;border: 1px solid green; padding: 2px 5px;"><i class="fa fa-angle-double-down" aria-hidden="true"></i></span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div id="questionshow{{ $question2['id_ques'] }}" class="Showanswers">
                                                <div class="clearfix"></div>
                                                <div class="answers_question ">
                                                    <div class="@if($question2['show_answer_ques'] == '0')answer0
                                                            @elseif($question2['show_answer_ques'] == '1')
                                                            answer1
@elseif($question2['show_answer_ques'] == '2')
                                                            answer2
@else
                                                            answer
@endif" id="">
                                                        <!-- ba truong hop chon kiểu đáp án -->
                                                        <!--  one_answer two_answer three_answer -->
                                                        <div class="answer_question text-left col-md-3">
                                                            <label class="">
                                                                <span class="{{ ($question2['correct_answer'] == 'answer1') ? 'answertrue' : 'answerfasle' }}">A</span> . {!! isset($question2['answer1']) ? $question2['answer1'] : '' !!}
                                                            </label>
                                                        </div>
                                                        <div class="answer_question text-left col-md-3">
                                                            <label>
                                                                <span class="{{ ($question2['correct_answer'] == 'answer2') ? 'answertrue' : 'answerfasle' }}">B</span> . {!! isset($question2['answer2']) ? $question2['answer2'] : '' !!}
                                                            </label>
                                                        </div>


                                                        <div class="clearfix"></div>
                                                        <p class="text-left f16 answer_succcess"> Đáp án đúng là
                                                            :   @if($question2['correct_answer'] == 'answer1')
                                                                A @elseif($question2['correct_answer'] == 'answer2')
                                                                B @endif
                                                        </p>
                                                        <button class=" btn btn-primary pull-left mgRight5" type="button" data-toggle="modal" data-target="#{{ isset($question2['id_ques']) ? $question2['id_ques'] : '' }}">
                                                            Sửa câu hỏi
                                                        </button>
                                                        <button class=" btn btn-primary pull-left"><a href="{{ route('site_question.destroy',['site_question' => $question2['id_ques'] ]) }}" class="btnDelete" data-toggle="modal" data-target="#myModalDelete1" onclick="return submitDelete(this);" style="color: #fff;text-decoration: none">Xóa câu hỏi
                                                            </a></button>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            $(function () {
                                                $('#aclickshow{{ $question2['id_ques'] }}').click(function() {
                                                    $('#questionshow{{ $question2['id_ques'] }}').slideToggle( "slow" );
                                                });
                                            });
                                        </script>
                                    @endforeach
                                </div>
                            @else
                                <p>Chưa có câu hỏi được tạo</p>
                            @endif
                        </div>





                        <!-- END TAB_2 -->












                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab"><div class="panel-heading">Câu hỏi phần tự luận</div>
                            <button class="btn   btn-block btn-success" id="addfile" type="button" data-toggle="modal" data-target="#add03">
                                <i class="fa fa-plus mgRight5" aria-hidden="true"></i>Thêm câu hỏi
                            </button>

                            @if(!empty($question_3))
                                <div class="listQuestion">
                                    @foreach($question_3 as $id3 => $question3)
                                        <div class="item_question">
                                            <div class="title_question">
                                     <span class="number_question">
                                     Câu hỏi {{ $id3 + 1 }}
                                     </span>
                                                <span class="edit_question" type="button" data-toggle="modal" data-target="#{{ isset($question3['id_ques']) ? $question3['id_ques'] : '' }}"><i class="fa fa-edit"></i></span>
                                                <span class="delete_question deleteItem1"> <a href="{{ route('site_question.destroy',['site_question' => $question3['id_ques'] ]) }}" class="btnDelete" data-toggle="modal" data-target="#myModalDelete2" onclick="return submitDelete(this);" style="color: #fff;text-decoration: none">
                                     X </a></span>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="content_question">
                                                <a  style="color: #000;display: block" class="hidenShowQuestion" id="aclickshow{{ $question3['id_ques'] }}">
                                                    <div class="form-group content_title_question mgBottom0 mgTop10" style="float:left;">
                                                        <p> {!! isset($question3['name_ques']) ? $question3['name_ques'] : '' !!}</p>
                                                        <span style="display: inline-block;border: 1px solid green; padding: 2px 5px;"><i class="fa fa-angle-double-down" aria-hidden="true"></i></span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div id="questionshow{{ $question3['id_ques'] }}" class="Showanswers">
                                                <div class="clearfix"></div>
                                                <div class="answers_question ">
                                                    <div class="@if($question3['show_answer_ques'] == '0')answer0
                                                            @elseif($question3['show_answer_ques'] == '1')
                                                            answer1
@elseif($question3['show_answer_ques'] == '2')
                                                            answer2
@else
                                                            answer
@endif" id="">
                                                        <!-- ba truong hop chon kiểu đáp án -->
                                                        <!--  one_answer two_answer three_answer -->

                                                        <div class="answer_question text-left col-md-12">

                                                            <p class="text-left f16 answer_succcess" style="margin-bottom: 0">  Đáp án của câu hỏi tự luận
                                                            </p>

                                                            <p class="text-left f16 answer_succcess"> {{ isset($question3['correct_answer']) ? $question3['correct_answer'] : '' }}</p>




                                                        </div>



                                                        <button class=" btn btn-primary pull-left mgRight5" type="button" data-toggle="modal" data-target="#{{ isset($question3['id_ques']) ? $question3['id_ques'] : '' }}">
                                                            Sửa câu hỏi
                                                        </button>
                                                        <button class=" btn btn-primary pull-left"><a href="{{ route('site_question.destroy',['site_question' => $question3['id_ques'] ]) }}" class="btnDelete" data-toggle="modal" data-target="#myModalDelet2" onclick="return submitDelete(this);" style="color: #fff;text-decoration: none">Xóa câu hỏi
                                                            </a></button>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            $(function () {
                                                $('#aclickshow{{ $question3['id_ques'] }}').click(function() {
                                                    $('#questionshow{{ $question3['id_ques'] }}').slideToggle( "slow" );
                                                });
                                            });
                                        </script>
                                    @endforeach
                                </div>
                            @else
                                <p>Chưa có câu hỏi được tạo</p>
                            @endif
                        </div>




                    </div>
                </div>
            </div>
        </div>
    </section>


    {{--TAB_1--}}
    {{--thêm câu hỏi--}}
    <div class="modal fade bd-example-modal-lg ModalAdd" id="add01" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form role="form" action="{{ route('site_question.store') }}" method="POST" id="valiadateFormAdd" class="valiadateForm">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Thêm mới câu hỏi (trắc nghiệm chọn 4 đáp án)</h4>
                    </div>
                    <div class="modal-body pd0">
                        <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}"/> {{--kiêu câu hoi--}} {{--0 là kiểu trắc nghiệm--}}
                        <input type="hidden" name="type_ques" value="0"/>
                        <div class="form-group col60">
                            <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>

                            <textarea class="editor w checkeditor" id="add001" name="name_ques" rows="10"
                                      cols="80" required="required" /> {{ old('name_ques') }}</textarea>
                            <label class="dsBlock mgBottom0 mgTop5"><i><span class="clred dsNone error_checkeditor"></span></i></label>
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
                                <button type="submit" class="btn btnloadding btnGreen"><i class="fa fa-plus" aria-hidden="true"></i> Thêm mới</button>
                                <button type="button" class="btn btn-default btnNoGreen" data-dismiss="modal"> <i class="fa fa-times" aria-hidden="true"></i> Hủy bỏ
                                </button>
                            </div>


                        </div>
                        <div class="form-group col40 mgBottom0 pdTop0">
                            <div class="">
                                <label><strong>Nhập đáp án <span class="clred"> (*) </span> : </strong></label>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-12 control-label">Đáp án A <span class="clred">(*)</span>
                                    </label>
                                    <div class="col-sm-12 mgBottom5 ">
                                        <input type="text" class="form-control" id="answer1"
                                               placeholder="Đáp án A" name="answer1" value="{{ old('answer1') }}">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-12 control-label">Đáp án B <span class="clred">(*)</span>
                                    </label>
                                    <div class="col-sm-12 mgBottom5 ">
                                        <input type="text" class="form-control" id="answer2"
                                               placeholder="Đáp án B" name="answer2" value="{{ old('answer2') }}" >
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
    {{--hiển thị câu hỏi--}}

    {{--Sửa câu hỏi--}}
    @if(!empty($question_1))
        @foreach($question_1 as $id=>$question1)
            <div class="modal fade bs-example-modal-lg adđModalQuestion ModalAdd"
                 id="{{ isset($question1['id_ques']) ? $question1['id_ques'] : '' }}" tabindex="-1"
                 role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <form role="form" action="{{ route('site_question.update', ['site_question' => $question1->id_ques]) }}
                            " method="post" id="valiadateForm" class="valiadateForm">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Sửa câu hỏi {{ $id+1 }} </h4>
                            </div>
                            <div class="modal-body pd0">
                                <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}"/>
                                <input type="hidden" name="id_ques" value="{{ $question1->id_ques }}"/>
                                {{--kiêu câu hoi--}} {{--0 là kiểu trắc nghiệm--}}
                                <input type="hidden" name="type_ques" value="0"/>
                                <div class="form-group col60">
                                    <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>

                                    <textarea class="editor w checkeditor" id="add01{{ $id+1 }}" name="name_ques"
                                              rows="10" cols="80" required />
                                    {!! isset($question1['name_ques']) ? $question1['name_ques'] : '' !!}
                                    </textarea>
                                    <label class="dsBlock mgBottom0 mgTop5"><i><span class="clred dsNone error_checkeditor"></span></i></label>

                                    <div class="form-group">
                                        <label><strong>Hiển thị đáp án : </strong></label>
                                        <br>
                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques" class="flat-red"
                                                   value="0"
                                                    {{ isset($question1['show_answer_ques']) && ($question1['show_answer_ques'] == 0) ? 'checked="checked'  : '' }}>
                                            <!--  <input type="radio" name="r1" checked="checked"> -->
                                            <span>Chia đều hai cột </span>
                                        </label>
                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques" class="flat-red"
                                                   value="1"
                                                    {{ isset($question1['show_answer_ques']) && ($question1['show_answer_ques'] == 1) ? 'checked="checked'  : '' }}>
                                            <span>Các đáp án trên một hàng </span>
                                        </label>
                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques" class="flat-red"
                                                   value="2"
                                                    {{ isset($question1['show_answer_ques']) && ($question1['show_answer_ques'] == 2) ? 'checked="checked'  : '' }}>
                                            <span>Mỗi đáp án trên một hàng </span>
                                        </label>
                                    </div>
                                    <div class="form-group mgBottom0 mgBottom10 btnGroup text-center">

                                        <button type="button" class="btn btnNoGreen" data-dismiss="modal" onclick="clickmodal(this)" dataid="add01"> <i class="fa fa-plus mgRight5" aria-hidden="true" ></i>Thêm mới
                                        </button>
                                        <button type="button" class="btn btnNoGreen" data-dismiss="modal" onclick="clickmodalcopy(this)" dataid="{{ $question1->id_ques }}"><i class="fa fa-clone mgRight5" aria-hidden="true"></i>Copy</button>
                                        <button type="submit" class="btn  btnloadding btnGreen"><i class="fa fa-pencil mgRight5" aria-hidden="true"></i>Sửa</button>

                                        <button type="button" class="btn btnNoGreen" data-dismiss="modal"><i class="fa fa-times mgRight5" aria-hidden="true"></i>Hủy bỏ
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group mgBottom0 col40 ">

                                    <div class="">
                                        <label><strong>Nhập đáp án <span class="clred"> (*) </span> : </strong></label>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp
                                                án A  <span class="clred"> (*) </span>
                                            </label>
                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="answer1"
                                                       placeholder="Đáp án A" name="answer1"
                                                       value="{{ isset($question1['answer1']) ? $question1['answer1'] : '' }}" required>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp
                                                án B  <span class="clred"> (*) </span>
                                            </label>

                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="answer2"
                                                       placeholder="Đáp án B" name="answer2"
                                                       value="{{ isset($question1['answer2']) ? $question1['answer2'] : '' }}" required>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp
                                                án C (*)
                                            </label>

                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="answer3"
                                                       placeholder="Đáp án C" name="answer3"
                                                       value="{{ isset($question1['answer3']) ? $question1['answer3'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp
                                                án D (*)
                                            </label>

                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="answer4"
                                                       placeholder="Đáp án D" name="answer4"
                                                       value="{{ isset($question1['answer4']) ? $question1['answer4'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="form-group mgBottom0">
                                            <label><strong>Chọn đáp án đúng : </strong></label>
                                            <br>

                                            <label class="mgRight10">
                                                <input type="radio" name="correct_answer" class="flat-red"
                                                       value="answer1" {{ isset($question1['correct_answer']) && ($question1['correct_answer'] == 'answer1') ? 'checked="checked'  : '' }}>
                                                <!--  <input type="radio" name="r1" checked="checked"> -->
                                                <span>Đáp án A </span>
                                            </label>
                                            <label class="mgRight10">
                                                <input type="radio" name="correct_answer" class="flat-red"
                                                       value="answer2" {{ isset($question1['correct_answer']) && ($question1['correct_answer'] == 'answer2') ? 'checked="checked'  : '' }}>
                                                <span>Đáp án B </span>
                                            </label>
                                            <label class="mgRight10">
                                                <input type="radio" name="correct_answer" class="flat-red"
                                                       value="answer3" {{ isset($question1['correct_answer']) && ($question1['correct_answer'] == 'answer3') ? 'checked="checked'  : '' }}>
                                                <span>Đáp án C </span>
                                            </label>
                                            <label class="mgRight10">
                                                <input type="radio" name="correct_answer" class="flat-red"
                                                       value="answer4" {{ isset($question1['correct_answer']) && ($question1['correct_answer'] == 'answer4') ? 'checked="checked'  : '' }}>
                                                <span>Đáp án D </span>
                                            </label>

                                        </div>
                                        {{--<div class="form-group mgBottom0 mgTop20 textRt">--}}

                                        {{--<button type="submit" class="btn btn-primary">Lưu câu hỏi</button>--}}
                                        {{--<button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ--}}
                                        {{--</button>--}}
                                        {{--</div>--}}


                                    </div>


                                </div>





                            </div>

                            {{--end thêm mới câu hỏi--}}


                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
    {{--copy câu hỏi--}}
    @if(!empty($question_1))
        @foreach($question_1 as $id=>$question1)
            <div class="modal fade bs-example-modal-lg adđModalQuestion ModalAdd"
                 id="copy{{ isset($question1['id_ques']) ? $question1['id_ques'] : '' }}" tabindex="-1"
                 role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <form role="form" action="{{ route('site_question.store') }}" method="POST" id="valiadateForm">
                        {!! csrf_field() !!}
                        {{ method_field('POST') }}
                        {{--{{ method_field('PUT') }} Dạng câu hỏi trắc nghiệm--}}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Copy từ câu hỏi {{ $id+1 }} </h4>
                            </div>

                            <div class="modal-body pd0">
                                <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}"/>
                                <input type="hidden" name="id_ques" value="{{ $question1->id_ques }}"/>
                                {{--kiêu câu hoi--}} {{--0 là kiểu trắc nghiệm--}}
                                <input type="hidden" name="type_ques" value="0"/>
                                <div class="form-group col60">
                                    <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>

                                    <textarea class="editor w checkeditor" id="copy01{{ $id+1 }}" name="name_ques"
                                              rows="10" cols="80"/>
                                    {!! isset($question1['name_ques']) ? $question1['name_ques'] : '' !!}
                                    </textarea>
                                    <label class="dsBlock mgBottom0 mgTop5"><i><span class="clred dsNone error_checkeditor"></span></i></label>

                                    <div class="form-group">
                                        <label><strong>Hiển thị đáp án : </strong></label>
                                        <br>
                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques0" class="flat-red"
                                                   value="0"
                                                    {{ isset($question1['show_answer_ques']) && ($question1['show_answer_ques'] == 0) ? 'checked="checked'  : '' }}>
                                            <!--  <input type="radio" name="r1" checked="checked"> -->
                                            <span>Chia đều hai cột </span>
                                        </label>
                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques0" class="flat-red"
                                                   value="1"
                                                    {{ isset($question1['show_answer_ques']) && ($question1['show_answer_ques'] == 1) ? 'checked="checked'  : '' }}>
                                            <span>Các đáp án trên một hàng </span>
                                        </label>
                                        <label class="mgRight10 w100">
                                            <input type="radio" name="show_answer_ques0" class="flat-red"
                                                   value="2"
                                                    {{ isset($question1['show_answer_ques']) && ($question1['show_answer_ques'] == 2) ? 'checked="checked'  : '' }}>
                                            <span>Mỗi đáp án trên một hàng </span>
                                        </label>
                                    </div>
                                    <div class="form-group mgBottom0 mgBottom10 btnGroup text-center">

                                        <button type="button" class="btn btnNoGreen" data-dismiss="modal" onclick="clickmodal(this)" dataid="add01"> <i class="fa fa-plus mgRight5" aria-hidden="true" ></i>Thêm mới
                                        </button>
                                        <button type="submit" class="btn  btnloadding btnGreen"><i class="fa fa-pencil mgRight5" aria-hidden="true"></i>Lưu câu hỏi</button>

                                        <button type="button" class="btn btnNoGreen" data-dismiss="modal"><i class="fa fa-times mgRight5" aria-hidden="true"></i>Hủy bỏ
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group mgBottom0 col40 ">

                                    <div class="">
                                        <label><strong>Nhập đáp án <span class="clred"> (*) </span> : </strong></label>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp
                                                án A  <span class="clred"> (*) </span>
                                            </label>
                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="answer1"
                                                       placeholder="Đáp án A" name="answer1"
                                                       value="{{ isset($question1['answer1']) ? $question1['answer1'] : '' }}" required>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp
                                                án B  <span class="clred"> (*) </span>
                                            </label>

                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="answer2"
                                                       placeholder="Đáp án B" name="answer2"
                                                       value="{{ isset($question1['answer2']) ? $question1['answer2'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp
                                                án C (*)
                                            </label>

                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="answer3"
                                                       placeholder="Đáp án C" name="answer3"
                                                       value="{{ isset($question1['answer3']) ? $question1['answer3'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp
                                                án D (*)
                                            </label>

                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="answer4"
                                                       placeholder="Đáp án D" name="answer4"
                                                       value="{{ isset($question1['answer4']) ? $question1['answer4'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="form-group mgBottom0">
                                            <label><strong>Chọn đáp án đúng : </strong></label>
                                            <br>

                                            <label class="mgRight10">
                                                <input type="radio" name="correct_answer0" class="flat-red"
                                                       value="answer1" {{ isset($question1['correct_answer']) && ($question1['correct_answer'] == 'answer1') ? 'checked="checked'  : '' }}>
                                                <!--  <input type="radio" name="r1" checked="checked"> -->
                                                <span>Đáp án A </span>
                                            </label>
                                            <label class="mgRight10">
                                                <input type="radio" name="correct_answer0" class="flat-red"
                                                       value="answer2" {{ isset($question1['correct_answer']) && ($question1['correct_answer'] == 'answer2') ? 'checked="checked'  : '' }}>
                                                <span>Đáp án B </span>
                                            </label>
                                            <label class="mgRight10">
                                                <input type="radio" name="correct_answer0" class="flat-red"
                                                       value="answer3" {{ isset($question1['correct_answer']) && ($question1['correct_answer'] == 'answer3') ? 'checked="checked'  : '' }}>
                                                <span>Đáp án C </span>
                                            </label>
                                            <label class="mgRight10">
                                                <input type="radio" name="correct_answer" class="flat-red"
                                                       value="answer4" {{ isset($question1['correct_answer']) && ($question1['correct_answer'] == 'answer4') ? 'checked="checked'  : '' }}>
                                                <span>Đáp án D </span>
                                            </label>

                                        </div>
                                        {{--<div class="form-group mgBottom0 mgTop20 textRt">--}}

                                        {{--<button type="submit" class="btn btn-primary">Lưu câu hỏi</button>--}}
                                        {{--<button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ--}}
                                        {{--</button>--}}
                                        {{--</div>--}}


                                    </div>


                                </div>





                            </div>

                            {{--end thêm mới câu hỏi--}}


                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif





    {{--TAB_2--}}
    <div class="modal fade bd-example-modal-lg ModalAdd" id="add02" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form role="form" action="{{ route('site_question.store') }}" method="POST" id="valiadateForm">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Thêm mới câu hỏi (trắc nghiệm chọn 2 đáp án)</h4>
                    </div>

                    <div class="modal-body pd0">
                        <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}"/> {{--kiêu câu hoi--}} {{--1 là kiểu đúng sai--}}
                        <input type="hidden" name="type_ques" value="1"/>
                        <div class="form-group col60">
                            <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>

                            <textarea class="editor w" id="add002" name="name_ques" rows="10"
                                      cols="80" required="required" /> {{ old('name_ques') }}</textarea>
                        </div>
                        <div class="form-group col40 mgBottom0">
                            <label><strong>Hiển thị đáp án : </strong></label>
                            <label class="mgRight10 w100">
                                <input type="radio" name="show_answer_ques1" class="flat-red"
                                       value="0" checked>
                                <!--  <input type="radio" name="r1" checked="checked"> -->
                                <span>Chia đều hai cột </span>
                            </label>
                            <label class="mgRight10 w100">
                                <input type="radio" name="show_answer_ques1" class="flat-red" value="1">
                                <span>Các đáp án trên một hàng </span>
                            </label>
                            <label class="mgRight10 w100">
                                <input type="radio" name="show_answer_ques1" class="flat-red" value="2">
                                <span>Mỗi đáp án trên một hàng </span>
                            </label>
                            <div class="">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-12 control-label">Đáp án A(*)
                                    </label>
                                    <div class="col-sm-12 mgBottom5 ">
                                        <input type="text" class="form-control" id="inputEmail3"
                                               placeholder="Đáp án A" name="answer1" value="Đúng">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-12 control-label">Đáp án B (*)
                                    </label>
                                    <div class="col-sm-12 mgBottom5 ">
                                        <input type="text" class="form-control" id="inputEmail3"
                                               placeholder="Đáp án B" name="answer2" value="Sai" >
                                    </div>
                                </div>


                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group mgBottom0">
                                <label><strong>Chọn đáp án đúng : </strong></label>
                                <br>
                                <label class="mgRight10">
                                    <input type="radio" name="correct_answer1" class="flat-red"
                                           value="answer1" checked>
                                    <!--  <input type="radio" name="r1" checked="checked"> -->
                                    <span>Đáp án A </span>
                                </label>
                                <label class="mgRight10">
                                    <input type="radio" name="correct_answer1" class="flat-red"
                                           value="answer2">
                                    <span>Đáp án B </span>
                                </label>

                            </div>

                        </div>
                        <div class="form-group mgBottom0 mgTop20 textCt">
                            <button type="submit" class="btn btnloadding btnGreen">Thêm mới</button>
                            <button type="button" class="btn btnNoGreen" data-dismiss="modal">Hủy bỏ
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



    @if(!empty($question_2))
        @foreach($question_2 as $id2=>$question2)
            <div class="modal fade bs-example-modal-lg adđModalQuestion ModalAdd"
                 id="{{ isset($question2['id_ques']) ? $question2['id_ques'] : '' }}" tabindex="-1"
                 role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <form role="form"
                          action="{{ route('site_question.update', ['site_question' => $question2->id_ques]) }}
                                  " method="post">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Sửa câu hỏi {{ $id2+1 }} </h4>
                            </div>
                            <div class="modal-body pd0">
                                <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}"/>
                                <input type="hidden" name="id_ques" value="{{ $question2->id_ques }}"/>
                                {{--kiêu câu hoi--}} {{--0 là kiểu trắc nghiệm--}}
                                <input type="hidden" name="type_ques" value="1"/>
                                <div class="form-group col60">
                                    <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>
                                    <textarea class="editor w" id="add02{{ $id2+1 }}" name="name_ques"
                                              rows="10" cols="80"/>
                                    {!! isset($question2['name_ques']) ? $question2['name_ques'] : '' !!}
                                    </textarea>
                                </div>
                                <div class="form-group mgBottom0 col40 ">
                                    <label><strong>Hiển thị đáp án : </strong></label>
                                    <br>

                                    <label class="mgRight10 w100">
                                        <input type="radio" name="show_answer_ques" class="flat-red"
                                               value="0"
                                                {{ isset($question2['show_answer_ques']) && ($question2['show_answer_ques'] == 0) ? 'checked="checked'  : '' }}>
                                        <!--  <input type="radio" name="r1" checked="checked"> -->
                                        <span>Chia đều hai cột </span>
                                    </label>
                                    <label class="mgRight10 w100">
                                        <input type="radio" name="show_answer_ques" class="flat-red"
                                               value="1"
                                                {{ isset($question2['show_answer_ques']) && ($question2['show_answer_ques'] == 1) ? 'checked="checked'  : '' }}>
                                        <span>Các đáp án trên một hàng </span>
                                    </label>
                                    <label class="mgRight10 w100">
                                        <input type="radio" name="show_answer_ques" class="flat-red"
                                               value="2"
                                                {{ isset($question2['show_answer_ques']) && ($question2['show_answer_ques'] == 2) ? 'checked="checked'  : '' }}>
                                        <span>Mỗi đáp án trên một hàng </span>
                                    </label>
                                    <div class="">

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp
                                                án A (*)
                                            </label>
                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="inputEmail3"
                                                       placeholder="Đáp án A" name="answer1"
                                                       value="{{ isset($question2['answer1']) ? $question2['answer1'] : '' }}" required>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp
                                                án B (*)
                                            </label>

                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="inputEmail3"
                                                       placeholder="Đáp án B" name="answer2"
                                                       value="{{ isset($question2['answer2']) ? $question2['answer2'] : '' }}">
                                            </div>
                                        </div>


                                        <div class="clearfix"></div>

                                        <div class="form-group mgBottom0">
                                            <label><strong>Chọn đáp án đúng : </strong></label>
                                            <br>

                                            <label class="mgRight10">
                                                <input type="radio" name="correct_answer" class="flat-red"
                                                       value="answer1" {{ isset($question2['correct_answer']) && ($question2['correct_answer'] == 'answer1') ? 'checked="checked'  : '' }}>
                                                <!--  <input type="radio" name="r1" checked="checked"> -->
                                                <span>Đáp án A </span>
                                            </label>
                                            <label class="mgRight10">
                                                <input type="radio" name="correct_answer" class="flat-red"
                                                       value="answer2" {{ isset($question2['correct_answer']) && ($question2['correct_answer'] == 'answer2') ? 'checked="checked'  : '' }}>
                                                <span>Đáp án B </span>
                                            </label>


                                        </div>

                                    </div>

                                </div>
                                <div class="form-group mgBottom0 mgBottom10 btnGroup text-center">

                                    <button type="button" class="btn btnNoGreen" data-dismiss="modal" onclick="clickmodal(this)" dataid="add02"> <i class="fa fa-plus mgRight5" aria-hidden="true" ></i>Thêm mới
                                    </button>
                                    <button type="button" class="btn btnNoGreen" data-dismiss="modal" onclick="clickmodalcopy(this)" dataid="{{ $question2->id_ques }}"><i class="fa fa-clone mgRight5" aria-hidden="true"></i>Copy </button>
                                    <button type="submit" class="btn btnloadding btnGreen"><i class="fa fa-pencil mgRight5" aria-hidden="true"></i>Lưu</button>


                                    <button type="button" class="btn btnNoGreen" data-dismiss="modal"><i class="fa fa-times mgRight5" aria-hidden="true"></i>Hủy bỏ
                                    </button>
                                </div>


                            </div>

                            {{--end thêm mới câu hỏi--}}
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
    {{--copy câu hỏi--}}
    @if(!empty($question_2))
        @foreach($question_2 as $id2=>$question2)
            <div class="modal fade bs-example-modal-lg adđModalQuestion ModalAdd"
                 id="copy{{ isset($question2['id_ques']) ? $question2['id_ques'] : '' }}" tabindex="-1"
                 role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <form role="form" action="{{ route('site_question.store') }}" method="POST" id="valiadateForm">
                        {!! csrf_field() !!}
                        {{ method_field('POST') }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Copy câu hỏi {{ $id2+1 }} </h4>
                            </div>
                            <div class="modal-body pd0">
                                <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}"/>
                                <input type="hidden" name="id_ques" value="{{ $question2->id_ques }}"/>
                                {{--kiêu câu hoi--}} {{--0 là kiểu trắc nghiệm--}}
                                <input type="hidden" name="type_ques" value="1"/>
                                <div class="form-group col60">
                                    <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>
                                    <textarea class="editor w" id="copyadd02{{ $id2+1 }}" name="name_ques"
                                              rows="10" cols="80"/>
                                    {!! isset($question2['name_ques']) ? $question2['name_ques'] : '' !!}
                                    </textarea>
                                </div>
                                <div class="form-group mgBottom0 col40 ">
                                    <label><strong>Hiển thị đáp án : </strong></label>
                                    <br>

                                    <label class="mgRight10 w100">
                                        <input type="radio" name="show_answer_ques1" class="flat-red"
                                               value="0"
                                                {{ isset($question2['show_answer_ques']) && ($question2['show_answer_ques'] == 0) ? 'checked="checked'  : '' }}>
                                        <!--  <input type="radio" name="r1" checked="checked"> -->
                                        <span>Chia đều hai cột </span>
                                    </label>
                                    <label class="mgRight10 w100">
                                        <input type="radio" name="show_answer_ques1" class="flat-red"
                                               value="1"
                                                {{ isset($question2['show_answer_ques']) && ($question2['show_answer_ques'] == 1) ? 'checked="checked'  : '' }}>
                                        <span>Các đáp án trên một hàng </span>
                                    </label>
                                    <label class="mgRight10 w100">
                                        <input type="radio" name="show_answer_ques1" class="flat-red"
                                               value="2"
                                                {{ isset($question2['show_answer_ques']) && ($question2['show_answer_ques'] == 2) ? 'checked="checked'  : '' }}>
                                        <span>Mỗi đáp án trên một hàng </span>
                                    </label>
                                    <div class="">

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp
                                                án A (*)
                                            </label>
                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="inputEmail3"
                                                       placeholder="Đáp án A" name="answer1"
                                                       value="{{ isset($question2['answer1']) ? $question2['answer1'] : '' }}" required>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 control-label">Đáp
                                                án B (*)
                                            </label>

                                            <div class="col-sm-12 mgBottom5 ">
                                                <input type="text" class="form-control" id="inputEmail3"
                                                       placeholder="Đáp án B" name="answer2"
                                                       value="{{ isset($question2['answer2']) ? $question2['answer2'] : '' }}">
                                            </div>
                                        </div>


                                        <div class="clearfix"></div>

                                        <div class="form-group mgBottom0">
                                            <label><strong>Chọn đáp án đúng : </strong></label>
                                            <br>

                                            <label class="mgRight10">
                                                <input type="radio" name="correct_answer1" class="flat-red"
                                                       value="answer1" {{ isset($question2['correct_answer']) && ($question2['correct_answer'] == 'answer1') ? 'checked="checked'  : '' }}>
                                                <!--  <input type="radio" name="r1" checked="checked"> -->
                                                <span>Đáp án A </span>
                                            </label>
                                            <label class="mgRight10">
                                                <input type="radio" name="correct_answer1" class="flat-red"
                                                       value="answer2" {{ isset($question2['correct_answer']) && ($question2['correct_answer'] == 'answer2') ? 'checked="checked'  : '' }}>
                                                <span>Đáp án B </span>
                                            </label>


                                        </div>

                                    </div>

                                </div>
                                <div class="form-group mgBottom0 mgBottom10 btnGroup text-center">
                                    {{--<button class="btn   btn-block btn-success" id="addfile" type="button" data-toggle="modal"--}}
                                    {{--data-target="#myModal" dataid="{{ isset($question['id_ques']) ? $question['id_ques'] : '' }}"--}}
                                    {{--<i class="fa fa-plus mgRight5" aria-hidden="true"></i>Thêm câu hỏi--}}
                                    {{--</button>--}}

                                    <button type="button" class="btn btnNoGreen" data-dismiss="modal" onclick="clickmodal(this)" dataid="add02"> <i class="fa fa-plus mgRight5" aria-hidden="true" ></i>Thêm mới
                                    </button>

                                    {{--<button type="button" class="btn btn-primary" id="addfile">Thêm mới câu hỏi</button>--}}

                                    <button type="submit" class="btn btnloadding btnGreen"><i class="fa fa-pencil mgRight5" aria-hidden="true"></i>Lưu câu hỏi</button>


                                    <button type="button" class="btn btnNoGreen" data-dismiss="modal"><i class="fa fa-times mgRight5" aria-hidden="true"></i>Hủy bỏ
                                    </button>
                                </div>


                            </div>

                            {{--end thêm mới câu hỏi--}}
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif

    {{--TAB_3--}}

    {{--them moi cau hoi--}}
    <div class="modal fade bd-example-modal-lg ModalAdd" id="add03" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form role="form" action="{{ route('site_question.store') }}" method="POST" id="valiadateForm">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Thêm mới câu hỏi (tự luận nhâp đáp án)</h4>
                    </div>

                    <div class="modal-body pd0">
                        <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}"/> {{--kiêu câu hoi--}} {{--1 là kiểu đúng sai--}}
                        <input type="hidden" name="type_ques" value="2"/>
                        <div class="form-group col60">
                            <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>
                            <textarea class="editor w" id="add003" name="name_ques" rows="10"
                                      cols="80" required="required" /> {{ old('name_ques') }}</textarea>
                        </div>
                        <div class="form-group col40 mgBottom0">


                            <div class="">
                                <div class="form-group">
                                    <label><strong>Nhập đáp án : </strong></label>

                                    <div class="col-sm-12 mgBottom5 ">
                                        <textarea class="w100" rows="9" name="correct_answer"></textarea>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                            </div>


                        </div>
                        <div class="form-group mgBottom0 mgTop20 textCt">
                            <button type="submit" class="btn btnloadding btnGreen">Thêm mới</button>
                            <button type="button" class="btn btnNoGreen" data-dismiss="modal">Hủy bỏ
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{--sua cau hoi--}}

    @if(!empty($question_3))
        @foreach($question_3 as $id3=>$question3)
            <div class="modal fade bs-example-modal-lg adđModalQuestion ModalAdd"
                 id="{{ isset($question3['id_ques']) ? $question3['id_ques'] : '' }}" tabindex="-1"
                 role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <form role="form"
                          action="{{ route('site_question.update', ['site_question' => $question3->id_ques]) }}
                                  " method="post"  class="">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Sửa câu hỏi {{ $id3+1 }} </h4>
                            </div>
                            <div class="modal-body pd0">
                                <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}"/>
                                <input type="hidden" name="id_ques" value="{{ $question3->id_ques }}"/>
                                {{--kiêu câu hoi--}} {{--0 là kiểu trắc nghiệm--}}
                                <input type="hidden" name="type_ques" value="2"/>
                                <div class="form-group col60">
                                    <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>
                                    <textarea class="editor w" id="add03{{ $id3+1 }}" name="name_ques"
                                              rows="10" cols="80"/>
                                    {!! isset($question3['name_ques']) ? $question3['name_ques'] : '' !!}
                                    </textarea>
                                </div>
                                <div class="form-group mgBottom0 col40 ">
                                    <div class="">
                                        <div class="clearfix"></div>

                                        <div class="form-group">
                                            <label><strong>Nhập đáp án : </strong></label>
                                            <div class="col-sm-12 mgBottom5 ">
                                                <textarea class="w100" rows="9" name="correct_answer"> {{ isset($question3['correct_answer']) ? $question3['correct_answer'] : '' }}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group mgBottom0 mgBottom10 btnGroup text-center">


                                    <button type="button" class="btn btnNoGreen" data-dismiss="modal" onclick="clickmodal(this)" dataid="add03"> <i class="fa fa-plus mgRight5" aria-hidden="true" ></i>Thêm câu hỏi
                                    </button>

                                    {{--<button type="button" class="btn btn-primary" id="addfile">Thêm mới câu hỏi</button>--}}
                                    <button type="button" class="btn btnNoGreen" data-dismiss="modal" onclick="clickmodalcopy(this)" dataid="{{ $question3->id_ques }}"><i class="fa fa-clone mgRight5" aria-hidden="true"></i>Copy câu hỏi</button>
                                    <button type="submit" class="btn btnloadding btnGreen"><i class="fa fa-pencil mgRight5" aria-hidden="true"></i>Lưu câu hỏi</button>

                                    <button type="button" class="btn btnNoGreen" data-dismiss="modal"><i class="fa fa-times mgRight5" aria-hidden="true"></i>Hủy bỏ
                                    </button>
                                </div>

                            </div>

                            {{--end thêm mới câu hỏi--}}
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif

    {{--copy câu hỏi--}}
    @if(!empty($question_3))
        @foreach($question_3 as $id3=>$question3)
            <div class="modal fade bs-example-modal-lg adđModalQuestion ModalAdd"
                 id="copy{{ isset($question3['id_ques']) ? $question3['id_ques'] : '' }}" tabindex="-1"
                 role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <form role="form" action="{{ route('site_question.store') }}" method="POST" id="valiadateForm">
                        {!! csrf_field() !!}
                        {{ method_field('POST') }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Copy câu hỏi {{ $id3+1 }} </h4>
                            </div>
                            <div class="modal-body pd0">
                                <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}"/>
                                <input type="hidden" name="id_ques" value="{{ $question3->id_ques }}"/>
                                {{--kiêu câu hoi--}} {{--0 là kiểu trắc nghiệm--}}
                                <input type="hidden" name="type_ques" value="2"/>
                                <div class="form-group col60">
                                    <label><strong>Tiêu đề câu hỏi <span class="clred"> (*) </span> : </strong></label>
                                    <textarea class="editor w" id="copyadd03{{ $id3+1 }}" name="name_ques"
                                              rows="10" cols="80"/>
                                    {!! isset($question3['name_ques']) ? $question3['name_ques'] : '' !!}
                                    </textarea>
                                </div>
                                <div class="form-group mgBottom0 col40 ">
                                    <div class="">
                                        <div class="clearfix"></div>

                                        <div class="form-group">
                                            <label><strong>Nhập đáp án : </strong></label>
                                            <div class="col-sm-12 mgBottom5 ">
                                                <textarea class="w100" rows="9" name="correct_answer"> {{ isset($question3['correct_answer']) ? $question3['correct_answer'] : '' }}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group mgBottom0 mgBottom10 btnGroup text-center">
                                    {{--<button class="btn   btn-block btn-success" id="addfile" type="button" data-toggle="modal"--}}
                                    {{--data-target="#myModal" dataid="{{ isset($question['id_ques']) ? $question['id_ques'] : '' }}"--}}
                                    {{--<i class="fa fa-plus mgRight5" aria-hidden="true"></i>Thêm câu hỏi--}}
                                    {{--</button>--}}

                                    <button type="button" class="btn btnNoGreen" data-dismiss="modal" onclick="clickmodal(this)" dataid="add03"> <i class="fa fa-plus mgRight5" aria-hidden="true" ></i>Thêm mới
                                    </button>

                                    <button type="submit" class="btn btnloadding btnGreen" id="addfile">Lưu câu hỏi</button>


                                    <button type="button" class="btn btnNoGreen" data-dismiss="modal"><i class="fa fa-times mgRight5" aria-hidden="true"></i>Hủy bỏ
                                    </button>
                                </div>

                            </div>

                            {{--end thêm mới câu hỏi--}}
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif


    @if (session('suscees_add'))
        <?php $id_ques = session('suscees_add');?>

        <script>
            $('#view{{$id_ques}}').focus()
        </script>
    @endif
    {{--trac nghiem  4 cau--}}
    <script>
        function clickmodal(e)
        {
            var id = $(e).attr('dataid');

            $('#'+ id +'').modal('show');
        }
    </script>
    <script>
        // $( document ).ready(function() {
        //     $('#46').modal('hiden');
        // });
        function clickmodalcopy(e) {
            var id = $(e).attr('dataid');
            $('#copy'+ id +'').modal('show');
        }


    </script>
    {{--validate fom--}}
    <script>
        $(function() {
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

        $(document).ready(function(){
            $('#valiadateFormAdd').submit(function() {
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
    </script>
    @include('site.admin_site.delete')
@endsection



