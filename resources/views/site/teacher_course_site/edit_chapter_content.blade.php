@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', 'Cập nhật bài học')
@section('meta_description', 'Cập nhật bài học')
@section('keywords', 'Cập nhật bài học')
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
                                <a href="{{ route('list_course_chapter',['courses_id' => $course_chapter->course_id])  }}">Danh sách chương</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_chapter_content',['course_chapter_id' => $course_chapter->course_chapter_id])  }}">Danh sách bài học</a>
                            </li>
                        </ul>
                    </div>


                    {{--cac buoc tao ho so--}}


                    <div class="create_teacher_course mgt20 mgb20" style="border: 1px solid #ccc;">

                        <form role="form" action="{{ route('update_chapter_content') }}" method="POST"
                              id="form_create_course">
                            {!! csrf_field() !!}
                            {{ method_field('POST') }}
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <!-- Nội dung thêm mới -->
                                    <div class="box box-primary">

                                        <div class="box-header with-border">
                                            <h3 class="box-title f22">Cập nhật bài học : {{ $chapter_content->course_content_title }}</h3>
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
                                                <label for="exampleInputEmail1">Tiêu đề bài học <span
                                                            class="clRed">(*)</span></label>
                                                <input type="text"
                                                       class="form-control error_border_course_content_title"
                                                       name="course_content_title"
                                                       placeholder="Tiêu đề bài học"
                                                       value="{{ $chapter_content->course_content_title }}">

                                                <div class="error_message">
                                                    <div class="mess_notice_course_chapter_name clearfix note_text_course_content_title"></div>
                                                    <div class="error_reg_mess clearfix error_text_course_course_content_title"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Link Youtube <span
                                                            class="clRed">(*)</span></label>
                                                <input type="text"
                                                       class="form-control error_border_course_link_youtuber"
                                                       name="course_link_youtuber"
                                                       placeholder="Link Youtube"
                                                       value="{{ $chapter_content->course_link_youtuber }}">

                                                <div class="error_message">
                                                    <div class="mess_notice_course_chapter_name clearfix note_text_course_link_youtuber"></div>
                                                    <div class="error_reg_mess clearfix error_text_course_link_youtuber"></div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Mô tả bài học </label>
                                                <textarea class="form-control" id=""
                                                          name="course_content_descript"
                                                          rows="3"> {{ $chapter_content->course_content_descript }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Nội dung bài học </label>
                                                <textarea class="form-control editor_basic" id="course_content"
                                                          name="course_content_content">{!! $chapter_content->course_content_content !!}</textarea>
                                            </div>

                                        </div>

                                        <div class="box-footer">
                                            <input type="hidden" name="course_content_id"
                                                   value="{{ $chapter_content->course_content_id }}">
                                            <button type="submit" class="btn_submit_course js_btn_loadding">Lưu thay đổi
                                            </button>
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
                    course_chapter_name: {
                        required: true,
                    },
                    course_link_youtuber: {
                        required: true,
                    }
                },
                messages: {
                    course_chapter_name: {
                        required: 'Vui lòng nhập tên chương khóa học',
                    }, course_link_youtuber: {
                        required: 'Vui lòng nhập link Youtube của khóa học',
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
                $('.js_btn_loadding').html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang Lưu thay đổi ...');
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

