@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', 'Chỉnh sửa câu hỏi')
@section('meta_description', 'Chỉnh sửa câu hỏi')
@section('keywords', 'Thêm mới câu hỏi')
@section('meta_image', !empty($course['course_image']) ? asset($course['course_image']) : asset($information['logo']))

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/teacher_course.css"/>


@endsection
@section('content')
    <style>
        .select2-container {
            width: 100% !important;
            padding: 0;
        }

        span.select2 {
            display: table;
            table-layout: fixed;
            width: 100% !important;
        }

        .notification button {
            background: #009385;
            color: #fff;
        }

        .form_color_input input {
            color: green;
            font-weight: 600;
        }

        .form_color_input select {
            color: green;
            font-weight: 600;
        }

        .form_color_input .label_radio {
            color: green;
            font-weight: 600;
        }

        .form_color_input .select2-search input {
            color: green;
            font-weight: 600;
        }

        .form_color_input .borderSelect2 .select2-container .select2-selection--single .select2-selection__rendered {
            border: 1px solid #ccc;
            border-radius: 5px;
            color: green;
            font-weight: 600;
        }
    </style>


    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar_site.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent col-12 col-12">

                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            @if(empty($course_content->course_content_id))
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_teacher_exam') }}">Đề thi của khóa học</a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_teacher_courses') }}">Quản lý khóa học</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_course_chapter',['courses_id' => $course_content->course_id])  }}">Danh sách chương</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_chapter_content',['course_chapter_id' => $course_content->course_chapter_id])  }}">Danh sách bài học</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_content_question',['content_id' => $course_content->course_content_id])  }}">{{ $course_content->course_content_title }}</a>
                            </li>
                                @endif
                        </ul>
                    </div>


                    {{--cac buoc tao ho so--}}


                    <div class="create_teacher_course mgt20 mgb20" style="border: 1px solid #ccc;">

                        <form role="form" action="{{ route('update_content_question') }}" method="POST"
                              id="form_create_course">
                            {!! csrf_field() !!}
                            {{ method_field('POST') }}
                            <div class="row">
                                <div class="col-xs-6 col-md-6">
                                    <!-- Nội dung thêm mới -->
                                    <div class="box box-primary">

                                        <div class="box-header with-border">
                                            <h3 class="box-title f22">Cập nhật câu hỏi</h3>
                                        </div>

                                        <div class="box-body">
                                            <div class="form-group error">
                                                @if(!empty($errors->all()))
                                                    @foreach($errors->all() as $erorr)
                                                        <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tiêu đề câu hỏi <span
                                                            class="clRed">(*)</span></label>
                                                <textarea class="form-control editor_basic" id="name_ques"
                                                          name="name_ques">{!! $question->name_ques !!}</textarea>

                                                <div class="error_message">
                                                    <div class="mess_notice_course_chapter_name clearfix note_text_course_content_title"></div>
                                                    <div class="error_reg_mess clearfix error_text_course_course_content_title"></div>
                                                </div>
                                            </div>
                                            <div class="form-group mgTop5">
                                                <label><strong>Hiển thị đáp án : </strong></label>

                                                <label class="mgRight10 w100">
                                                    <input type="radio" name="show_answer_ques" class="flat-red"
                                                           value="0" @if($question->show_answer_ques == 0) checked
                                                           @else checked @endif >
                                                    <!--  <input type="radio" name="r1" checked="checked"> -->
                                                    <span>Chia đều hai cột </span>
                                                </label>
                                                <label class="mgRight10 w100">
                                                    <input type="radio" name="show_answer_ques" class="flat-red"
                                                           value="1"
                                                           @if($question->show_answer_ques == 1) checked @endif>
                                                    <span>Các đáp án trên một hàng </span>
                                                </label>
                                                <label class="mgRight10 w100">
                                                    <input type="radio" name="show_answer_ques" class="flat-red"
                                                           value="2"
                                                           @if($question->show_answer_ques == 2) checked @endif>
                                                    <span>Mỗi đáp án trên một hàng </span>
                                                </label>
                                            </div>

                                        </div>

                                        <div class="box-footer">
                                            <input type="hidden" name="course_content_id"
                                                   value="{{ !empty($course_content->course_content_id) ? $course_content->course_content_id : 0 }}">
                                            <input type="hidden" name="type_ques" value="0">
                                            <input type="hidden" name="id_ques" value="{{ $question->id_ques }}">
                                            <button type="submit" class="btn_submit_course js_btn_loadding">Lưu thay đổi
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-md-6">
                                    <!-- Nội dung thêm mới -->
                                    <div class="box box-primary">

                                        <div class="box-header with-border">
                                            <h3 class="box-title f22">Nhập đáp án</h3>
                                        </div>

                                        <div class="box-body">
                                            <div class="form-group  mgBottom0 pdTop0">
                                                <div class="">

                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-12 control-label">Đáp án
                                                            A <span
                                                                    class="clRed">(*)</span>
                                                        </label>
                                                        <div class="col-sm-12 mgBottom5 ">
                                                            <input type="text" class="form-control" id="answer1"
                                                                   placeholder="Đáp án A" name="answer1"
                                                                   value="{{ $question->answer1 }}">
                                                        </div>
                                                        @if(($errors->has('answer1')))
                                                            <label class="dsBlock mgBottom0 mgTop5"><i><span
                                                                            class="clred error_addzero">Đáp án A không được để trống</span></i></label>
                                                        @endif
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-12 control-label">Đáp án
                                                            B <span
                                                                    class="clRed">(*)</span>
                                                        </label>
                                                        <div class="col-sm-12 mgBottom5 ">
                                                            <input type="text" class="form-control" id="answer2"
                                                                   placeholder="Đáp án B" name="answer2"
                                                                   value="{{ $question->answer2 }}">
                                                        </div>
                                                        @if(($errors->has('answer2')))
                                                            <label class="dsBlock mgBottom0 mgTop5"><i><span
                                                                            class="clred error_addzero">Đáp án B không được để trống</span></i></label>
                                                        @endif
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-12 control-label">Đáp án
                                                            C <span
                                                                    class="clRed">(*)</span>
                                                        </label>
                                                        <div class="col-sm-12 mgBottom5 ">
                                                            <input type="text" class="form-control" id="answer3"
                                                                   placeholder="Đáp án C" name="answer3"
                                                                   value="{{ $question->answer3 }}">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-12 control-label">Đáp án
                                                            D <span
                                                                    class="clRed">(*)</span>
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
                                                               value="answer1"
                                                               @if($question->correct_answer == 'answer1') checked
                                                               @else checked @endif>
                                                        <!--  <input type="radio" name="r1" checked="checked"> -->
                                                        <span>Đáp án A </span>
                                                    </label>
                                                    <br>
                                                    <label class="mgRight10">
                                                        <input type="radio" name="correct_answer" class="flat-red"
                                                               value="answer2"
                                                               @if($question->correct_answer == 'answer2') checked @endif>
                                                        <span>Đáp án B </span>
                                                    </label>
                                                    <br>
                                                    <label class="mgRight10">
                                                        <input type="radio" name="correct_answer" class="flat-red"
                                                               value="answer3"
                                                               @if($question->correct_answer == 'answer3') checked @endif>
                                                        <span>Đáp án C </span>
                                                    </label>
                                                    <br>
                                                    <label class="mgRight10">
                                                        <input type="radio" name="correct_answer" class="flat-red"
                                                               value="answer4"
                                                               @if($question->correct_answer == 'answer4') checked @endif>
                                                        <span>Đáp án D </span>
                                                    </label>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </form>


                    </div>


                </div>
            </div>
        </div>
    </section>



@endsection
@section('show_js')
    {{--scrop js--}}
    <script src="{{ asset('adminstration/jquery.priceformat.js') }}"></script>
    <script src="{{asset('adminstration/js/numeral/numeral.min.js')}}"></script>
    <script src="/assets/js/jquery.validate.min.js"></script>
    {{--end scrop js--}}
    <script>
        $('.formatPrice').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.'
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#form_create_course").validate({
                ignore: [],
                onkeyup: false,
                rules: {
                    name_ques: {
                        required: true,
                    },
                    answer1: {
                        required: true,
                    },
                    answer2: {
                        required: true,
                    },
                    answer3: {
                        required: true,
                    },
                    answer4: {
                        required: true,
                    },
                },
                messages: {
                    name_ques: {
                        required: 'Tiêu đề câu hỏi không được để trống',
                    },
                    answer1: {
                        required: 'Vui lòng nhập đáp án A',
                    },
                    answer2: {
                        required: 'Vui lòng nhập đáp án B',
                    },
                    answer3: {
                        required: 'Vui lòng nhập đáp án C',
                    },
                    answer4: {
                        required: 'Vui lòng nhập đáp án D',
                    }
                },
                onfocusout: function (element) {
                    $(element).valid();
                },
                errorPlacement: function (error, element) {
                    var name = $(element).attr("name");
                    $('.note_text_' + name).hide();
                    $('.error_text_' + name).html('<i class="error"><span class="error_reg_mess_icon"></span>' + error.text() + '</i>');
                    $('#note_' + name).hide();
                    $('.error_border_' + name).css("cssText", "border: 1px solid #ff0000  !important;");
                    $('.btn-loading').button('reset');

                },
                success: function (label, element) {
                    var name = $(element).attr("name");
                    $('.note_text_' + name).show();
                    $('.error_text_' + name).html('');
                    $('.error_border_' + name).css("cssText", "border: 1px solid #e0e0e0  !important;");
                    $('#js_btnRegidit').attr('disabled', false);

                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
        //tao jquery load button
        $('.js_btn_loadding').click(function () {
            if ($('#form_create_course').valid()) {
                $('.js_btn_loadding').html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lưu thay đổi ...');
                $btn.attr('disabled', false);
            } else {
            }
        });
    </script>

    <script>
        // chon thanh pho ra quan huyen
        $('#city').change(function () {
            var city = $(this).val();
            $.get('/tim-kiem-huyen/' + city, function (data) {
                $('#county').html('');
                $('#county').html(data);
            });
        });

        $(document).ready(function () {
            var year_input = $('.js_select_2_change').val();
            var d = new Date();
            var year = d.getFullYear();
            var year_ex = year - year_input;
            if (year_ex == 0) {
                $('.js_result_year_ex').html(' ( dưới 1 năm kinh nghiệm ) ');
            } else {
                $('.js_result_year_ex').html(' ( ' + year_ex + ' năm kinh nghiệm ) ');
            }
            console.log(year_input);
            $('.js_select_2_change').change(function () {
                var year_input = $(this).val();
                // lay ngay hien taih
                var d = new Date();
                var year = d.getFullYear();
                var year_ex = year - year_input;
                if (year_ex == 0) {
                    $('.js_result_year_ex').html(' ( dưới 1 năm kinh nghiệm ) ');
                } else {
                    $('.js_result_year_ex').html(' (' + year_ex + ' năm kinh nghiệm ) ');
                }
            });

        });

    </script>
    <script src="/assets/ckeditor_full/ckeditor.js"></script>
    @include('site.layout_site.from')
    <script>
        $('.editor_basic').each(function (e) {
            CKEDITOR.replace(this.id);
        });
        // CKEDITOR.instances.description.updateElement('1111111111111111111');
        $('.select2').select2({
            width: '100%',
        });
    </script>
    <script type="text/javascript">
        function uploadImage(e) {
            window.KCFinder = {
                callBack: function (url) {
                    window.KCFinder = null;
                    var img = new Image();
                    img.src = url;
                    $(e).next().attr("src", url);
                    $(e).next().next().val(url);
                    $(e).attr("src", url);
                    $(e).next().val(url);
                    $(e).next().next().val(url);
                    $(e).next().next().next().val(url);
                    console.log($(e).next());
                    console.log($(e).next().next());
                }
            };
            window.open('/kcfinder-master/browse.php?type=images&dir=images/public',
                'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
                'directories=0, resizable=1, scrollbars=0, width=800, height=600'
            );
        }

        function openKCFinder(e) {
            window.KCFinder = {
                callBackMultiple: function (files) {
                    window.KCFinder = null;
                    var urlFiles = "";
                    $(e).next().empty();
                    for (var i = 0; i < files.length; i++) {
                        $(e).next().append('<img src="' + files[i] + '" width="80" height="" style="margin-left: 5px; margin-bottom: 5px;"/>');
                        urlFiles += files[i];
                        if (i < (files.length - 1)) {
                            urlFiles += ',';
                        }
                    }

                    $(e).next().next().val(urlFiles);
                }
            };
            window.open('/kcfinder-master/browse.php?type=images&dir=images/public',
                'kcfinder_multiple', 'status=0, toolbar=0, location=0, menubar=0, ' +
                'directories=0, resizable=1, scrollbars=0, width=800, height=600'
            );
        }


        $('.select2_muti').select2({
            width: '100%',
            maximumSelectionLength: 3
        });
        $('#check_upload_file').click(function () {
            $('.js_check_file_image').val(1);
        });

        // ajax upload anh
        $("input[name='images']").change(function () {
            filename = this.files[0].name
            $('.name_image_if_select').html(filename)
            var fd = new FormData();
            var files = $(this)[0].files;
            if (files.length > 0) {
                fd.append('file', files[0]);
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_employee_uplade_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
                $.ajax({
                    url: '{{route("ajaxUpdateEmployeeImage")}}',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (res) {

                        if (res.status == 'success') {
                            $('.ctrl_nortification_success').removeClass('d-none');
                            $('.nortification.success').addClass('animateOpen');
                            setTimeout(function () {
                                $('.ctrl_nortification_success').addClass('d-none');
                            }, 4000);
                            $('.ctrl_nortification_success .nortification_content').html(res.message)
                        }
                        if (res.status == 'error') {
                            $('.ctrl_nortification_danger').removeClass('d-none');
                            $('.nortification.danger').addClass('animateOpen');
                            setTimeout(function () {
                                $('.ctrl_nortification_danger').addClass('d-none');
                            }, 4000);
                            $('.ctrl_nortification_danger .nortification_content').html(res.message)
                        }
                    },
                });
            }
        });
    </script>
@endsection

