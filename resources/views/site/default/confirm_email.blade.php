@extends('site.layout.site')

@section('title', 'Kích hoạt tài khoản')
@section('meta_description', 'Kích hoạt tài khoản')
@section('keywords', 'Kích hoạt tài khoản')

@section('content')

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>--}}

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline">
                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Xác thực email</a>
                            </li>
                        </ul>
                    </div>

                    <div class="InfoCompanyJob bgrWhite mgt20 pd20">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="title mgb20">
                                    <h5 class="lt-f20  fw7 bdLeftBlueN5x pdl10 blueN mgb0 dsInline">
                                        Xác thực email
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </h5>
                                </div>

                                {{--<i class="fas fa-spinner fa-spin"></i>--}}
                                {{--<i class="fas fa-circle-notch fa-spin"></i>--}}
                                {{--<i class="fas fa-sync fa-spin"></i>--}}
                                {{--<i class="fas fa-cog fa-spin"></i>--}}
                                {{--<i class="fas fa-spinner fa-pulse"></i>--}}
                                {{--<i class="fas fa-stroopwafel fa-spin"></i>--}}

                                {{--<div class="spinner-border"> <i class="fas fa-spinner fa-spin"></i></div>--}}

                                <div>
                                    <p class="f16 mgb0">
                                        Để xác thực Email, xin vui lòng đăng nhập tài khoản email<span
                                                class="clHome mgl5">{{ isset($user_confirm->email) ? $user_confirm->email : '' }}</span>
                                        và làm theo hướng dẫn.
                                        ( Lưu ý kiểm tra hộp thư Spam/ Junk )
                                    </p>
                                    <p class="f16 mgb0">
                                        Nếu bạn chưa nhận được Email xác thực, hãy bấm nút Gửi lại Email dưới đây:
                                        {{--<i><a class="dsInline"><span class="clorang f14">(Xem hướng dẫn tại đây !)</span></a></i>--}}
                                    </p>
                                </div>
                                <div class="mgt20 js_resetButton">
                                    <a class="sendConfirmEmail js_send_confirm_email mb_f12" id="load2"
                                       data-loading-text="<i class='fas fa-spinner fa-spin mgr5'></i> Đang gửi email kích hoạt"
                                       style="border: none"><i class="far fa-envelope mgr5"></i> Gửi lại email kích hoạt
                                        tài khoản</a>


                                </div>
                                <div class="mgt30 f16">
                                    Bạn nhập sai hoặc muốn đổi Email đăng ký? <span
                                            class="btnChangeEmail js_toggle_changle_email bdr5"> BẤM VÀO ĐÂY</span>
                                </div>

                                <div id="" class="email-moi mt15 box_change_email js_box_change_email pd10 mgt20 ">
                                    <form class="form_submit_loading" id="is_change_email" name="change_email"
                                          method="post" action="{{ route('change_email_confirm') }}">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="f16 fw6">Vui lòng nhập email mới
                                                <span class="red">(*)</span></label>
                                            <input type="email" name="email" class="form-control error_border_email"
                                                   id="txt_email"
                                                   aria-describedby="emailHelp" placeholder="Nhập vào email của bạn"
                                                   value="{{ old('email') }}" required>

                                            <div class="mess_notice_email clearfix note_text_email"></div>
                                            <div class="error_reg_mess clearfix error_text_email"></div>
                                            <i>Lưu ý : Khi bạn đổi lại email thì phải xác thực lại tài khoản</i>
                                        </div>
                                        <div class="form-group">
                                            <!-- Google reCaptcha -->
                                            <div class="g-recaptcha" id="feedback-recaptcha"
                                                 data-sitekey="{{ '6Le9trIUAAAAALrCbKEVd_fFCOjZm13bNMk9DmZP'  }}"></div>
                                            <!-- End Google reCaptcha -->
                                        </div>

                                        <button id="btn_changeEmail" class="btn btn-doi-email font16 bolder">
                                            Đổi Email
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('site.module_index.dang-ky-tu-van')


                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>

    <script>


        $("#is_change_email").validate({
            ignore: [],
            onkeyup: false,
            rules: {
                email: {
                    required: true,
                    checkEmail: true,
                    email: true
                },
            },
            messages: {
                email: {
                    required: 'Vui lòng nhập địa chỉ Email.',
                    checkEmail: 'Email đã tồn tại.',
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

        $('#btn_changeEmail').click(function() {
            if ($('#is_change_email').valid()) {
                $(this).html( '<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang đổi email...');
                $btn.attr('disabled', false);
            }
            else {
            }
        });


        $('.js_box_change_email').hide();
        $(".js_toggle_changle_email").click(function () {
            $(".js_box_change_email").toggle(500);
        });

        $('.js_send_confirm_email').on('click', function () {
            var $this = $(this);
            if ($this.hasClass('is-sending')) {
                return;
            }

            $this.addClass('is-sending').attr('aria-disabled', 'true');
            $this.html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang gửi email xác thực');
            $.ajax({
                type: "GET",
                url: '{!! route('ajax_send_email_confirm') !!}',
                dataType: 'json',
                timeout: 30000,
                success: function (data) {
                    if (data.success) {
                        $this.text(data.message || 'Email xác thực đã được gửi thành công');
                        return;
                    }

                    $this.text(data.message || 'Đã có lỗi khi gửi email, vui lòng thử lại');
                },
                error: function (xhr) {
                    var message = xhr.responseJSON && xhr.responseJSON.message
                        ? xhr.responseJSON.message
                        : 'Đã có lỗi khi gửi email, vui lòng thử lại';
                    $this.text(message);
                },
                complete: function () {
                    setTimeout(function () {
                        $this.removeClass('is-sending').removeAttr('aria-disabled');
                        $this.html('<i class="far fa-envelope mgr5"></i>' + 'Gửi lại email kích hoạt tài khoản');
                    }, 10000);
                }
            });
        });
    </script>
@endsection
