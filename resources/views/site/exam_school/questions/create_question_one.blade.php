@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Thêm mới câu hỏi trung bình')
@section('meta_description',  'Thêm mới câu hỏi trung bình')


@section('content')

    {{--<script src="{{ asset('assets/ckeditor_basic/ckeditor.js') }}"></script>--}}
    {{--@include('site.exam_admin_site.include-CSS-JS')--}}
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/rAF.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/ResizeSensor.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/sticky-sidebar.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/jquery.matchHeight-min.js') }}"></script>


    <script>
        $('.editor').each(function(e){
            CKEDITOR.replace( this.id);
        });
    </script>




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
                                        <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> Thêm mới câu hỏi trung bình</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <div class="CV bgrWhite radius5 pd20  mgb20 pdb5 pdt10">
                                        <div class="content">
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


                                                @if(!empty($errors->all()))
                                                    @foreach($errors->all() as $erorr)
                                                        <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                                    @endforeach
                                                @endif

                                            <section class="ListQuestionExam" id="ListQuestionExam">
                                                <div class="container">
                                                    <form role="form" action="{{ route('store_question_school') }}" method="POST" id=""
                                                    class="formQuestion">
                                                    {!! csrf_field() !!}
                                                    {{ method_field('POST') }}
                                                    {{--cau hoi trac nghiem--}}
                                                    <div class="row bg-white">
                                                        <div class="col-lg-12">
                                                            <h3 class="text-center f22 mgTop15  ">Thêm mới câu hỏi (trung bình)</h3>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="">
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

                                                        <div class="col-lg-12">
                                                            <div class="">
                                                                <div class="form-group  mgBottom0 pdTop0">
                                                                    <div class="">
                                                                        <label><strong>Nhập đáp án <span class="clred"> (*) </span> : </strong></label>


                                                                        <div class="form-group row">
                                                                            <label for="staticEmail" class="col-sm-2 col-form-label te">Đáp án A <span class="clred">(*)</span></label>
                                                                            <div class="col-sm-10">
                                                                                <input type="text" class="form-control" id="answer1"
                                                                                       placeholder="Đáp án A" name="answer1"
                                                                                       value="{{ old('answer1') }}" >
                                                                                @if(($errors->has('answer1')))
                                                                                    <label class="dsBlock mgBottom0 mgTop5"><i><span
                                                                                                    class="clred error_addzero">Đáp án A không được để trống</span></i></label>
                                                                                @endif
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <label for="staticEmail" class="col-sm-2 col-form-label te">Đáp án B <span class="clred">(*)</span></label>
                                                                            <div class="col-sm-10">
                                                                                <input type="text" class="form-control" id="answer2"
                                                                                       placeholder="Đáp án B" name="answer2"
                                                                                       value="{{ old('answer2') }}" >
                                                                                @if(($errors->has('answer2')))
                                                                                    <label class="dsBlock mgBottom0 mgTop5"><i><span
                                                                                                    class="clred error_addzero">Đáp án B không được để trống</span></i></label>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="clearfix"></div>

                                                                        <div class="form-group row">
                                                                            <label for="staticEmail" class="col-sm-2 col-form-label te">Đáp án C <span class="clred">(*)</span></label>
                                                                            <div class="col-sm-10">
                                                                                <input type="text" class="form-control" id="answer3"
                                                                                       placeholder="Đáp án C" name="answer3"
                                                                                       value="{{ old('answer3') }}">
                                                                                @if(($errors->has('answer3')))
                                                                                    <label class="dsBlock mgBottom0 mgTop5"><i><span
                                                                                                    class="clred error_addzero">Đáp án C không được để trống</span></i></label>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="staticEmail" class="col-sm-2 col-form-label te">Đáp án D <span class="clred">(*)</span></label>
                                                                            <div class="col-sm-10">
                                                                                <input type="text" class="form-control" id="answer4"
                                                                                       placeholder="Đáp án D" name="answer4"
                                                                                       value="{{ old('answer4') }}">
                                                                                @if(($errors->has('answer4')))
                                                                                    <label class="dsBlock mgBottom0 mgTop5"><i><span
                                                                                                    class="clred error_addzero">Đáp án D không được để trống</span></i></label>
                                                                                @endif
                                                                            </div>
                                                                        </div>
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
                                                        <div class="col-lg-12 borderSelect2">
                                                            <div class=" row form-group mgTop5 ">
                                                                <label for="staticEmail" class="col-sm-2 col-form-label fw6">Lựa chọn môn học  <span class="clred">(*)</span></label>
                                                                <div class="col-sm-10">
                                                                    <?php
                                                                    $school_subject = \App\Exam\School_subject::getAll();
                                                                    ?>
                                                                    <select class="form-control select2  js_change_select" id="" name="sub_id">
                                                                        <option value="0">-- Chọn môn học --</option>
                                                                        @foreach($school_subject as $sub)
                                                                            <option value="{{ $sub->sub_id }}">{{ $sub->sub_name }}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group mgBottom0 mgBottom20 text-left">
                                                                <input type="hidden" name="type_ques" value="1">
                                                                <button type="submit" class="btn btnloadding btnGreen w100"><i
                                                                            class="fa fa-plus mgRight5" aria-hidden="true"></i> Lưu câu hỏi
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>

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
    @include('site.exam_admin_site.delete')
@endsection




