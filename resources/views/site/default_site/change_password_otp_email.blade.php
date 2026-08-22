@extends('site.layout_site.site')

@section('title', 'Đổi mật khẩu')
@section('meta_description', 'Đổi mật khẩu')
@section('keywords', 'Đổi mật khẩu')


@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/employee_profile.css"/>
@endsection
@section('content')
    <section class="content bgrGray pdt5">
        <div class="container container_w_1200 ">
            <div class="row ">

                <div class="col-xl-9 col-lg-12 col-md-12 col-12 col-12 dcontent">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                             style="margin-top: 15px;">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="CV bgrWhite radius5 pd20 mgt20 mgb20 pdb5 UpdateUserTab">

                        @if(!empty($message))
                            <p class="mgb15 clRed f18 fw6">{{ $message }} </p>
                        @endif

                        @if(!empty($message_success))
                            <p class="mgb15 clGreen f18 fw6">{{ $message_success }} ,Đăng nhập tại đây <span class="nav-link white hvWhite f15 pdt0 clWhite hd_btn_login" data-toggle="modal" data-target="#loginTiva">Đăng nhập </span> </p>
                        @endif

                        <div class="title">
                            <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb0">
                                Đổi mật khẩu
                            </h5>
                        </div>
                        <hr class="mgt10 mgb10">
                        <div class="content">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 left">
                                    <form action="{{ route('change_otp_email') }}" method="post"
                                          enctype="multipart/form-data" id="validateForm">
                                        {!! csrf_field() !!}
                                        <input type="hidden" class="form-control" id="inputZip" name="email"
                                               placeholder=" Email" readonly
                                               value="{{ $user->email }}">

                                        <div class="form-row">
                                            <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                                <label for="inputZip" class="fw6">Nhập mã xác thực <span
                                                            class="clRed">(*)</span></label>
                                                <input type="text" class="form-control error_border_password_old"
                                                       id="inputZip"
                                                       placeholder="Nhập mã xác thực" name="otp_email" required>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                                <label for="inputZip" class="fw6">Nhập mật khẩu mới <span
                                                            class="clRed">(*)</span></label>
                                                <input type="password" class="form-control error_border_password"
                                                       id="password"
                                                       placeholder="Nhập mật khẩu mới" name="password" required>
                                            </div>

                                            <div class="mess_notice_password clearfix note_text_password"></div>
                                            <div class="error_reg_mess clearfix error_text_password"></div>
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif

                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                                <label for="inputZip" class="fw6">Nhập lại mật khẩu mới <span
                                                            class="clRed">(*)</span></label>
                                                <input type="password"
                                                       class="form-control error_border_password_confirmation"
                                                       id="inputZip"
                                                       placeholder="Nhập lại mật khẩu mới" required
                                                       name="password_confirmation">

                                                <div class="mess_notice_password_confirmation clearfix note_text_password_confirmation"></div>
                                                <div class="error_reg_mess clearfix error_text_password_confirmation"></div>
                                                @if ($errors->has('password_confirmation'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" class="button_change_email" id="btnLoadding">Đổi mật
                                                khẩu
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div>


                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

@endsection
@section('show_js')
    <script src="/public/assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#validateForm").validate({
                ignore: [],
                onkeyup: false,
                rules: {

                    password: {
                        required: true,
                        minlength: 8,
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 8,
                        equalTo: "#password"
                    },
                },
                messages: {
                    password: {
                        required: 'Vui lòng nhập vào mật khẩu.',
                        minlength: 'Mật khẩu tối thiểu 8 ký tự'
                    },
                    password_confirmation: {
                        required: 'Vui lòng nhập lại mật khẩu.',
                        minlength: 'Mật khẩu tối thiểu 8 ký tự',
                        equalTo: 'Mật khẩu nhập lại không đúng'
                    },
                },
                onfocusout: function (element) {
                    $(element).valid();
                },
                errorPlacement: function (error, element) {
                    var name = $(element).attr("name");
                    $('.note_text_' + name).hide();
                    $('.error_text_' + name).html('<i class="error clRed"><span class="error_reg_mess_icon"></span>' + error.text() + '</i>');
                    $('.error_border_' + name).css("cssText", "border: 1px solid #ff0000  !important;");
                    $('.btn-loading').button('reset');
                    // $('.btn-loading').attr('disabled', true)

                },
                success: function (label, element) {
                    var name = $(element).attr("name");
                    $('.note_text_' + name).show();
                    $('.error_text_' + name).html('');
                    $('.error_border_' + name).css("cssText", "border: 1px solid #e0e0e0  !important;");
                },
            });
        });

        //tao jquery load button
        $('#btnLoadding').click(function () {
            if ($('#validateForm').valid()) {
                $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lưu thay đổi...');
                $btn.attr('disabled', false);
            } else {
            }
        });


    </script>
@endsection