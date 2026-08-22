@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Danh sách câu hỏi khó')
@section('meta_description',  'Danh sách câu hỏi khó')


@section('content')

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
                                        <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> Danh sách câu hỏi (khó)</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <div class="CV bgrWhite radius5 pd20  mgb20 pdb5 pdt10">




                                        <div class="arror bgrWhite radius5 pd5 bdLightGray  mgb15 pd10 row">
                                            <div class="col-md-4">
                                                <p>Có tất cả {{ !empty($total_zero) ? $total_zero  : '0' }} câu hỏi (khó)</p>
                                                <p class="mgb5">
                                                    <a href="{{ route('list_type_question_school',['type_question'=> 2]) }}" class="infoStudent_button">Chuyển câu hỏi khó</a>
                                                </p>
                                            </div>
                                            <div class="col-md-8">
                                                <?php
                                                $school_subject = \App\Exam\School_subject::getAll();
                                                $user = \Illuminate\Support\Facades\Auth::user();
                                                $teacher_school = \App\Entity\Teacher_schools::getTeacher_id($user->id);

                                                $total_all_zero = 0;
                                                ?>
                                                @foreach($school_subject as $sub)
                                                    <?php
                                                    $count_total = 0;
                                                    $count_total  = \App\Exam\School_subject::getTotal(2,$teacher_school->teacher_sc_id,$sub->sub_id);
                                                    $total_all_zero += $count_total;
                                                    ?>
                                                        @if($count_total > 0)
                                                    <p class="mgb5">
                                                        {{ $sub->sub_name }} <sup class="clred">({{ $count_total }} câu)</sup>
                                                    </p>
                                                        @endif
                                                @endforeach


                                            </div>

                                        </div>
                                        <div class="text-center col-lg-12 ">
                                            <form action="" method="GET" id="submitFormSearchRoom" class="mgTop20 " style="margin:  0 auto">
                                                {{ csrf_field() }}
                                                <div class="row mgBottom15 justify-content-md-center">
                                                    <div class="col-lg-6 borderSelect2">
                                                        <?php
                                                        $school_subject = \App\Exam\School_subject::getAll();
                                                        $sub_id = isset($_GET['sub_id']) ? $_GET['sub_id'] : '0';
                                                        ?>
                                                        <select class="form-control select2  js_change_select" id="" name="sub_id">
                                                            <option value="0" @if($sub_id == '0') selected @endif>-- Chọn môn học --</option>
                                                            @foreach($school_subject as $sub)
                                                                <option value="{{ $sub->sub_id }}" @if($sub_id == $sub->sub_id) selected @endif>{{ $sub->sub_name }}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>

                                                    <div class="col-lg-3">

                                                        <button type="submit" class="btnAddQuestionSchool w100" style="">
                                                            Lọc tìm câu hỏi
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>



                                        <div class="content">
                                            <a href="{{ route('create_question_school',['type_question'=> 2]) }}"
                                               class="btnAddQuestionSchool"><i class="fa fa-plus mgRight5" aria-hidden="true"></i>Thêm
                                                mới câu hỏi</a>
                                            <div class="row" id="scollProduct">
                                                <div class="col-lg-9 maxHeightcol">
                                                    <div class="listQuestion bg-white">

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


                                                        @if(!empty($question_zero))
                                                            <h3 class="f18 text-left pd10 ds-inline" style="background: #ddd">Nội dung câu hỏi</h3>
                                                            @foreach($question_zero as $id => $question)
                                                                <div class="item_question">
                                                                    <div class="title_question">
                                                                        <?php
                                                                        $sub = \App\Exam\School_subject::get_sub_id($question->sub_id)
                                                                        ?>
                                                                        <span class="number_question" id="view{{ $question['id_ques'] }}">
                                                                             Câu hỏi {{ $id + 1 }} @if(!empty($sub)) <i>({{ $sub->sub_name }})</i> @endif
                                                                         </span>

                                                                        <a href="{{ route('edit_question_school',['id_ques' => $question['id_ques'] ]) }}"
                                                                           class="copy_question" title="Sửa câu hỏi"><i
                                                                                    class="fa fa-edit"></i></a>

                                                                        <a href="{{ route('delete_question',['ques_id' => $question['id_ques'] ]) }}"
                                                                           class=" delete_question btnDelete" data-toggle="modal"
                                                                           data-target="#myModalDelete0"
                                                                           onclick="return submitDelete(this);" title="Xóa câu hỏi">
                                                                            <i class="far fa-trash-alt"></i> </a>


                                                                    </div>
                                                                    <div class="clearfix" id="view{{ $question['id_ques'] }}"></div>
                                                                    <div class="content_question">
                                                                        <a style="color: #000;display: block" class="hidenShowQuestion"
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
                                                                                    answer
@endif" id="">
                                                                                <!-- ba truong hop chon kiểu đáp án -->
                                                                                <!--  one_answer two_answer three_answer -->
                                                                                <div class="answer_question text-left col-md-3">
                                                                                    <label class="">
                                                                                        <span class="{{ ($question['correct_answer'] == 'answer1') ? 'answertrue' : 'answerfasle' }}">A</span>
                                                                                        . {!! isset($question['answer1']) ? $question['answer1'] : '' !!}
                                                                                    </label>
                                                                                </div>
                                                                                <div class="answer_question text-left col-md-3">
                                                                                    <label>
                                                                                        <span class="{{ ($question['correct_answer'] == 'answer2') ? 'answertrue' : 'answerfasle' }}">B</span>
                                                                                        . {!! isset($question['answer2']) ? $question['answer2'] : '' !!}
                                                                                    </label>
                                                                                </div>
                                                                                @if(isset($question['answer3']))
                                                                                    <div class="answer_question  text-left col-md-3">
                                                                                        <label>
                                                                                            <span class="{{ ($question['correct_answer'] == 'answer3') ? 'answertrue' : 'answerfasle' }}">C</span>
                                                                                            . {!! isset($question['answer3']) ? $question['answer3'] : '' !!}
                                                                                        </label>
                                                                                    </div>
                                                                                @endif
                                                                                @if(isset($question['answer4']))
                                                                                    <div class="answer_question text-left  col-md-3">
                                                                                        <label>
                                                                                            <span class="{{ ($question['correct_answer'] == 'answer4') ? 'answertrue' : 'answerfasle' }}">D</span>
                                                                                            . {!! isset($question['answer4']) ? $question['answer4'] : '' !!}
                                                                                        </label>
                                                                                    </div>
                                                                                @endif
                                                                                <div class="clearfix"></div>
                                                                                <p class="text-left f16 answer_succcess"> Đáp án đúng là
                                                                                    : @if($question['correct_answer'] == 'answer1')
                                                                                        A @elseif($question['correct_answer'] == 'answer2')
                                                                                        B @elseif($question['correct_answer'] == 'answer3')
                                                                                        C @elseif($question['correct_answer'] == 'answer4')
                                                                                        D @endif
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
                                                <div class="col-lg-3  bg-white " style="">
                                                    <div class="ListItemQues" id="">
                                                        <h3 class="f18 text-center pd10 ds-inline mgTB10" style="background: #ddd">Danh sách câu
                                                            hỏi</h3>
                                                        <div class="listhrel sidebar__inner">
                                                            @if(!empty($question_zero))
                                                                <ul id="scroll">
                                                                    @foreach($question_zero as $id => $question)
                                                                        <li>
                                                                            <a href="#view{{ $question['id_ques'] }}"> Câu
                                                                                 {{ $id + 1 }}</a>

                                                                            <div class="group">
                                                                                <a href="#view{{ $question['id_ques'] }}"
                                                                                   title="Xem câu hỏi"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                                                                <a href="{{ route('edit_question_school',['id_ques' => $question['id_ques'] ]) }}"
                                                                                   title="Sửa câu hỏi"><i class="fa fa-edit"></i></a>


                                                                                <a href="{{ route('delete_question',['ques_id' => $question['id_ques'] ]) }}"
                                                                                   title="Xóa câu hỏi" class="btnDelete" data-toggle="modal"
                                                                                   data-target="#myModalDelete0"
                                                                                   onclick="return submitDelete(this);"><i class="far fa-trash-alt"></i></a>

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
                    </section>

                    {{--@include('site.module_index.dang-ky-tu-van')--}}

                </div>
            </div>
            {{--@include('site.module_index.hotline')--}}
        </div>
    </section>


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
    <div class="modal fade" id="myModalDelete0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="margin-top: 60px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn muốn xóa?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" class="submitDelete" method="post" >
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
@endsection



