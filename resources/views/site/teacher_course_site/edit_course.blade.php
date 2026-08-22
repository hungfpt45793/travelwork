@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', 'Chỉnh sửa  khóa học')
@section('meta_description', 'Chỉnh sửa khóa học')
@section('keywords', 'Chỉnh sửa khóa học')
@section('meta_image', !empty($course['course_image']) ? asset($course['course_image']) : asset($information['logo']))

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/teacher_course.css"/>


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
                                <a href="#">Chỉnh sửa khóa học</a>
                            </li>
                        </ul>
                    </div>


                    {{--cac buoc tao ho so--}}


                    <div class="create_teacher_course" style="border: 1px solid #ccc;">

                        <form role="form" action="{{ route('teacher_update_courses') }}" method="POST" id="form_create_course">
                            {!! csrf_field() !!}
                            {{ method_field('POST') }}
                            <div class="row">
                                <div class="col-xs-7 col-md-7">
                                    <!-- Nội dung thêm mới -->
                                    <div class="box box-primary">

                                        <div class="box-header with-border">
                                            <h3 class="box-title f22">Chỉnh sửa khóa học : {{ $course->course_title }}</h3>
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
                                                <label for="exampleInputEmail1">Tiêu đề khóa học <span class="clRed">(*)</span></label>
                                                <input type="text" class="form-control error_border_course_title" name="course_title"
                                                       placeholder="Tiêu đề khóa học" value="{{ $course->course_title }}">

                                                <div class="error_message">
                                                    <div class="mess_notice_course_title clearfix note_text_course_title"></div>
                                                    <div class="error_reg_mess clearfix error_text_course_title"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Mã khóa học <span class="clRed">(*)</span></label>
                                                <input type="text" class="form-control js_courses_code error_border_course_code" name="course_code"
                                                       placeholder="Mã khóa học" value="{{ $course->course_code }}">
                                                <div class="error_message">
                                                    <div class="mess_notice_course_code clearfix note_text_course_code"></div>
                                                    <div class="error_reg_mess clearfix error_text_course_code"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputAddress2" class="fw6">Hình ảnh khóa học <span class="clRed">(*)</span> </label>
                                                <a href="https://sanketoan.vn/ho-tro/huong-dan-tai-anh-dai-dien-vao-ho-so-giao-vien-ung-vien-nha-tuyen-dung" target="_blank">(Hướng dẫn chọn ảnh)</a>
                                                <div class="">
                                                    <div class="form-group">
                                                        <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh" class="error_border_course_image"
                                                               size="20"/>
                                                        <img src="{{ $course->course_image }}" width="80" height="70"/>
                                                        <input name="course_image" type="hidden" value="{{ $course->course_image  }}"/>

                                                        <div class="error_message">
                                                            <div class="mess_notice_course_image clearfix note_text_course_imagee"></div>
                                                            <div class="error_reg_mess clearfix error_text_course_image"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Mô tả khóa học</label>
                                                <textarea class="form-control editor_basic" id="course_descript" name="course_descript" rows="5">
                                                    {{ $course->course_descript }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Khóa học này dành cho ai <span class="clRed">(*)</span></label>
                                                <textarea class="form-control editor_basic" id="course_content"
                                                          name="course_content">{!! $course->course_content !!}</textarea>

                                                <div class="error_message">
                                                    <div class="mess_notice_course_content clearfix note_text_course_content"></div>
                                                    <div class="error_reg_mess clearfix error_text_course_content"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Lọi ích khóa học</label>
                                                <textarea class="form-control editor_basic" id="course_benefit"
                                                          name="course_benefit">{!! $course->course_benefit !!}</textarea>

                                            </div>

                                        </div>
                                        <input type="hidden" name="course_id" value="{{ $course->course_id }}">

                                        <div class="box-footer">
                                            <button type="submit" class="btn_submit_course js_btn_loadding">Lưu thay đổi</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5">
                                    <div class="box box-primary">

                                        <div class="box-header with-border">
                                            <h3 class="box-title f22">Thông tin liên quan</h3>
                                        </div>

                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Mã kích hoạt khóa học</label>
                                                <input type="text" class="form-control" name="activation_code"
                                                       placeholder="Mã kích hoạt khóa học" value="{{ $course->activation_code }}" readonly>
                                            </div>


                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Danh mục khóa học</label>
                                                <select class="select2" name="category_course_id">
                                                    @foreach($list_category as $category)
                                                        <option value="{{ !empty($category->category_course_id) ? $category->category_course_id : '' }}" @if($course->category_course_id == $category->category_course_id) selected @endif>{{ !empty($category->category_course_title) ? $category->category_course_title : '' }} </option>
                                                    @endforeach
                                                        <div class="error_message">
                                                            <div class="mess_notice_category_course_id clearfix note_text_category_course_id"></div>
                                                            <div class="error_reg_mess clearfix error_text_category_course_id"></div>
                                                        </div>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Từ khóa</label>
                                                <select class="select2" name="tag_id[]" multiple>
                                                    @foreach($list_tag as $tags)
                                                        <option @if(in_array($tags['tag_id'], $tag)) selected @endif   value="{{ !empty($tags->tag_id) ? $tags->tag_id : '' }}">{{ !empty($tags->tag_title) ? $tags->tag_title : '' }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Giá của khóa học</label>
                                                <input type="text" class="form-control formatPrice" name="course_price"
                                                       placeholder="Giá của khóa học" value="{{ $course->course_price }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Giảm giá khóa học</label>
                                                <input type="text" class="form-control formatPrice" name="course_discount"
                                                       placeholder="Giá của khóa học" value="{{ $course->course_discount }}">
                                            </div>
                                            <div class="box-footer">
                                                <button type="submit" class="btn_submit_course js_btn_loadding">Lưu thay đổi</button>
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
    <script src="{{ asset('adminstration/jquery.priceformat.js') }}"></script>
    <script src="{{asset('adminstration/js/numeral/numeral.min.js')}}"></script>
    <script src="/public/assets/js/jquery.validate.min.js"></script>
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
                    course_title: {
                        required: true,
                    },
                    course_code: {
                        required: true,
                    },
                    course_image: {
                        required: true,
                    },
                    course_content: {
                        required: true,
                    },
                    category_course_id: {
                        required: true,
                    },
                },
                messages: {
                    course_title: {
                        required: 'Vui lòng nhập tên khóa học',
                    },
                    course_code: {
                        required: 'Vui lòng nhập mã khóa học',
                    },
                    course_image: {
                        required: 'Vui lòng chọn ảnh cho khóa học',
                    },
                    course_content: {
                        required: 'Vui lòng nhập nội dung khóa học',
                    },
                    category_course_id: {
                        required: 'Vui lòng chọn danh mục khóa học',
                    },
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
    <script src="/public/assets/ckeditor_full/ckeditor.js"></script>
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

