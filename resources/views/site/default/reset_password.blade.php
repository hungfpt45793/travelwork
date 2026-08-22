@extends('site.layout_site.site')

@section('type_meta', 'Quên mật khẩu')
@section('title','Quên mật khẩu')
@section('meta_description','Quên mật khẩu' )

@section('content')
    <section class="PagesNewsContent bkxam pdb20 pdt20">
        <div class="container pd0 ">
            <div class="link bgrWhite mgb20">
                <ul class="nav">
                    <li class="nav-item pd8">
                        <a href="#" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                    </li>
                    <li class="nav-item pd8">
                        <p class="mgb0 md-f13 md-mgt2 blueDN clorange"><i class="fas fa-chevron-right"></i></p>
                    </li>
                    <li class="nav-item pd8">
                        <p class=" f18 md-f14 mgb0 clorange ">Quên mật khẩu</p>
                    </li>

                </ul>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="bgrWhite" style="padding: 20px;">
                        <h1 class="title_contact f24" style="margin-bottom: 15px;">Quên mật khẩu</h1>
                        <div class="contact-info ">

                            <form action="{{ route('send_email') }}" method="post" enctype="multipart/form-data" id="is_change_email">
                                {!! csrf_field() !!}

                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label"><span class="text-b700">Nhập email đăng kí</span><span
                                                class="clred pd-05">(*)</span></label>
                                    <div class="col-sm-9">
                                        <input id="email" type="email" class="form-control error_border_email"
                                               name="email" placeholder="Nhập email đăng kí tài khoản"
                                               required >
                                        <div class="mess_notice_email clearfix note_text_email"></div>
                                        <div class="error_reg_mess clearfix error_text_email"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 pdtop30">
                                        <button type="submit" class="btnOrange" id="btn_changeEmail">Gửi email kích hoạt mật khẩu mới</button>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 pdtop30">
                                        @if(session('success_email'))
                                            <p style="color: red;display: inline-block;text-align: center;font-size: 20px;font-weight: 700">{{ session('success_email') }}</p>
                                        @endif
                                        @if(session('error'))
                                            <p class="red">{{ session('error') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </form>


                        </div><!--end: .contact-info-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $("#is_change_email").validate({
            ignore: [],
            onkeyup: false,
            rules: {
                email: {
                    required: true,
                    checkEmailExist: true,
                    email: true
                },
            },
            messages: {
                email: {
                    required: 'Vui lòng nhập địa chỉ Email.',
                    checkEmailExist: 'Không tồn tại địa chỉ email này !.',
                    email: 'Vui lòng nhập một địa chỉ Email hợp lệ !'
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
                // $('.btn-loading').attr('disabled', true)

            },
            success: function (label, element) {
                var name = $(element).attr("name");
                $('.note_text_' + name).show();
                $('.error_text_' + name).html('');
                $('.error_border_' + name).css("cssText", "border: 1px solid #e0e0e0  !important;");
            },
        });
        jQuery.validator.addMethod("checkEmailExist", function(value, element) {
            var result = false;
            $.ajax({
                async: false,
                url: '{!! route('check_email_employee') !!}',
                type: 'get',
                dataType: 'json',
                data: {
                    email: value
                },  success: function() {
                    result = false;
                },
                error: function() {
                    result = true;
                }
            });

            return result;
        });
        console.log(result);
        $('#btn_changeEmail').click(function() {
            if ($('#is_change_email').valid()) {
                $(this).html( '<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang gửi email kích hoạt mật khẩu mới ...');
                $btn.attr('disabled', false);
            }
            else {
            }
        });
    </script>
@endsection

