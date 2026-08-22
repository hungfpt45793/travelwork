@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Phòng thi')
@section('meta_description', 'Phòng thi')
@section('keywords', 'Phòng thi')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : ''  )
@section('content')

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row ">
                <?php $user = ''; ?>
                <div class="col-xl-3 col-lg-4 col-md-12 dsmbNone sidebar_show_hidden" id="js_toogle_sidebar">

                    <div id="dismiss">
                        <i class="fas fa-arrow-left"></i>
                    </div>

                    <div class="side-bar-left formJobLarge  sidebarJobFacebook">
                        <div class="createNew text-center bgrBlueN" style="    padding: 4px 0;">
                            <a href=""
                               class="createNewButton white">
                                <i class="fas disInBlock fa-paper-plane "></i>
                                <p class="disInBlock font20 fontBold ">Thông tin giáo viên</p>
                            </a>
                        </div>
                    </div>
                    <div class="account bg-white pd10">
                        <?php
                        $teacher_school = \App\Entity\Teacher_schools::showTeacher($room->id_room);
                        ?>
                        <p>Tên giáo viên
                            : {{ isset($teacher_school->teacher_sc_name) ? $teacher_school->teacher_sc_name : '' }}</p>
                        <p>Trường
                            : {{ isset($teacher_school->teacher_school) ? $teacher_school->teacher_school : '' }}</p>
                        <p>Email : {{ $teacher_school->teacher_sc_email }}</p>
                        <p>Số điện thoại : {{  $teacher_school->teacher_sc_phone }}</p>
                    </div>

                    <div class="side-bar-left formJobLarge  sidebarJobFacebook">
                        <div class="createNew text-center bgrBlueN" style="    padding: 4px 0;">
                            <a href=""
                               class="createNewButton white">
                                <i class="fas disInBlock fa-paper-plane "></i>
                                <p class="disInBlock font20 fontBold ">Thông tin phòng thi</p>
                            </a>
                        </div>
                    </div>
                    <div class="account bg-white pd10">
                        <p>Mã phòng thi : {{ isset($room->code_room) ? $room->code_room : '' }}</p>
                        <p>Tên phòng thi : {{ isset($room->name_room) ? $room->name_room : '' }}</p>
                        <p>Mô tả phòng thi : {{ isset($room->des_room) ? $room->des_room : '' }}</p>
                        <div class="exam_rules_p">Quy chế thi : {!! isset($room->exam_rules) ? $room->exam_rules : '' !!}</div>
                    </div>
                    @include('site.sidebar.list_banner')

                </div>


                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline" style="margin-top:0px">
                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8 mgt7">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Phòng thi</a>
                            </li>
                        </ul>
                    </div>

                    <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14 text-center">
                        Nhập thông tin sinh viên để vào thi
                    </div>
                    <div class="bg-white pd20">

                        <form action="{{ route('createStudentRoom') }}" method="post" class="dang-ky-tuyen-dung"
                              id="form_register">
                            {!! csrf_field() !!}
                            <div class="form-group mgb5 row ">
                                <label for="recipient-name" class="col-form-label col-sm-2 text-right">Mã sinh viên
                                    <span class="clred fw6">(*)</span></label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="student_code"
                                           placeholder="Mã sinh viên ..." onkeyup="
  var start = this.selectionStart;
  var end = this.selectionEnd;
  this.value = this.value.toUpperCase();
  this.setSelectionRange(start, end);
">
                                    <div class="mess_notice_student_code clearfix note_text_student_code"></div>
                                    <div class="error_reg_mess clearfix error_text_student_code"></div>
                                </div>

                            </div>
                            <div class="form-group mgb5 row">
                                <label for="recipient-name" class="col-form-label col-sm-2 text-right">Tên sinh viên
                                    <span class="clred fw6">(*)</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="student_name"
                                           placeholder="Tên sinh viên ...">
                                    <div class="mess_notice_student_name clearfix note_text_student_name"></div>
                                    <div class="error_reg_mess clearfix error_text_student_name"></div>
                                </div>
                            </div>
                            <div class="form-group mgb5 row">
                                <label for="recipient-name" class="col-form-label col-sm-2 text-right">Lớp hành
                                    chính <span class="clred fw6">(*)</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="class_primakey"
                                           placeholder="Lớp hành chính ..." onkeyup="
  var start = this.selectionStart;
  var end = this.selectionEnd;
  this.value = this.value.toUpperCase();
  this.setSelectionRange(start, end);
">
                                    <div class="mess_notice_class_primakey clearfix note_text_class_primakey"></div>
                                    <div class="error_reg_mess clearfix error_text_class_primakey"></div>
                                </div>
                            </div>

                            <div class="form-group mgb5 row">
                                <label for="recipient-name" class="col-form-label col-sm-2 text-right">Lớp học
                                    phần <span class="clred fw6">(*)</span> </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="class_section"
                                           placeholder="Lớp học phần ..." onkeyup="
  var start = this.selectionStart;
  var end = this.selectionEnd;
  this.value = this.value.toUpperCase();
  this.setSelectionRange(start, end);
">
                                    <div class="mess_notice_class_section clearfix note_text_class_section"></div>
                                    <div class="error_reg_mess clearfix error_text_class_section"></div>
                                </div>
                            </div>
                            <div class="form-group mgb5 row">
                                <label for="recipient-name" class="col-form-label col-sm-2 text-right">Email sinh viên
                                    <span class="clred fw6">(*)</span></label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="student_email"
                                           placeholder="Email sinh viên ...">
                                    <i class="f12">Vui lòng nhập đúng địa chỉ email để nhận kết quả bài thi về email của
                                        bạn</i>
                                    <div class="mess_notice_student_email clearfix note_text_student_email"></div>
                                    <div class="error_reg_mess clearfix error_text_student_email"></div>
                                </div>
                            </div>
                            <div class="form-group mgb5 row">
                                <label for="recipient-name" class="col-form-label col-sm-2 text-right">Số điện thoại
                                    <span class="clred fw6">(*)</span></label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="student_phone"
                                           placeholder="Số điện thoại sinh viên ...">
                                    <div class="mess_notice_student_phone clearfix note_text_student_phone"></div>
                                    <div class="error_reg_mess clearfix error_text_student_phone"></div>
                                </div>
                            </div>

                            <div class="form-group mgb5 row">
                                @if(session('erorrRoomPassword'))
                                    <p style="color: red;margin-bottom: 0">{{ session('erorrRoomPassword') }} </p>
                                @endif

                                <label for="recipient-name" class="col-form-label col-sm-2 text-right">Mật khẩu phòng
                                    thi <span class="clred fw6">(*)</span></label>

                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password_room"
                                           placeholder="Nhập mật khẩu ...">
                                    <div class="mess_notice_password_room clearfix note_text_password_room"></div>
                                    <div class="error_reg_mess clearfix error_text_password_room"></div>
                                    <input type="hidden" name="id_room" value="{{ $room->id_room }}">
                                </div>
                            </div>


                            <div class="form-group error">
                                @if(!empty($errors->all()))
                                    @foreach($errors->all() as $erorr)
                                        <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                    @endforeach
                                @endif
                            </div>

                            <div class="form-group row">
                                <label for="recipient-name" class="col-form-label col-sm-2 text-right"></label>
                                <!-- Google reCaptcha -->
                                <div class="col-sm-10">
                                    <div class="g-recaptcha" id="feedback-recaptcha"
                                         data-sitekey="{{ '6Le9trIUAAAAALrCbKEVd_fFCOjZm13bNMk9DmZP'  }}"></div>
                                    <div class="error error_g-captcha"></div>
                                    <!-- End Google reCaptcha -->
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="recipient-name" class="col-form-label col-sm-2 text-right"></label>
                                <input type="hidden" name="id_room" value="{{ $room->id_room }}">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn bgrBlueN white btn-loading" id="js_btnRegidit">Vào
                                        thi
                                        luôn
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>


                </div>
            </div>
        </div>
    </section>
    @include('site.module_index.hotline')

    <script type="text/javascript">
        $(document).ready(function () {
            $("#form_register").validate({
                ignore: [],
                onkeyup: false,
                click: false,
                rules: {
                    student_code: {
                        required: true,
                        check_student_code: true,
                    },
                    student_name: {
                        required: true,
                    },
                    class_primakey: {
                        required: true,
                    },
                    class_section: {
                        required: true,
                    },
                    student_email: {
                        required: true,
                        email: true
                    },
                    student_phone: {
                        required: true,
                    },
                    password_room: {
                        required: true,
                        check_password: true,
                    },
                },
                messages: {
                    student_code: {
                        required: 'Mã sinh viên không được để trống.',
                        check_student_code: 'Mã sinh viên đã làm bài thi này rồi'
                    }, student_name: {
                        required: 'Tên sinh viên không được để trống.',
                    }, class_primakey: {
                        required: 'Lớp hành chính không được để trống.',
                    }, class_section: {
                        required: 'Lớp học phần không được để trống.',
                    }, student_email: {
                        required: 'Email sinh viên không được để trống.',
                        email: 'Vui lòng nhập một địa chỉ Email hợp lệ !'
                    }, student_phone: {
                        required: 'Số điện thoại phải là số và không được để trống.',
                    }, password_room: {
                        required: 'Mật khẩu vào phòng thi không được để trống.',
                        check_password: 'Mật khẩu vào phòng thi không chính xác'
                    },
                },
                onfocusout: function (element) {
                    $(element).valid();
                },
                errorPlacement: function (error, element) {
                    var name = $(element).attr("name");
                    $('.note_text_' + name).hide();
                    $('.error_text_' + name).html('<i class="error"><span class="error_reg_mess_icon"></span>' + error.text() + '</i>');
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
            // {id_room}/{student_code}
            jQuery.validator.addMethod("check_student_code", function (value, element) {

                var result = false;
                var id_room = '{{ $room->id_room }}';
                console.log(value);
                console.log(id_room);
                $.ajax({
                    async: false,
                    url: '{!! route('check_student_code') !!}',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        code: value,
                        id_room: id_room,
                    }
                }).done(function (response) {
                    result = response;
                    console.log(response);
                });

                return result;
            }, 'Mã sinh viên này đã làm bài thi này rồi.');

            jQuery.validator.addMethod("check_password", function (value, element) {
                var result = false;
                var id_room = '{{ $room->id_room }}';
                console.log(value);
                console.log(id_room);
                $.ajax({
                    async: false,
                    url: '{!! route('check_password') !!}',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        password: value,
                        id_room: id_room,
                    }
                }).done(function (response) {
                    result = response;
                    console.log(response);
                });
                return result;
            }, 'Mật khẩu phòng thi không chính xác.');

            //tao jquery load button
            $('#js_btnRegidit').click(function () {

                if ($('#form_register').valid()) {
                    if (grecaptcha.getResponse() == "") {
                        $('.error_g-captcha').text("Vui lòng tích chọn tôi không phải người máy");
                        $('.error_g-captcha').css('margin-bottom', '5px');
                        return false;
                    }
                    else {
                        $('.error_g-captcha').text("");
                    }
                    $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang vào thi...');
                    $btn.attr('disabled', false);
                }
                else {
                }
            });

        });

    </script>
    @if(session('errorRoomschool'))
        <div class="modal fade" id="check_error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p> {{ session('errorRoomschool') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#check_error').modal('show');
        </script>
    @endif


@endsection

