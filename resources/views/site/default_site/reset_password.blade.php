@extends('site.layout_site.site')

@section('type_meta', 'Quên mật khẩu từ mã xác thực')
@section('title','Quên mật khẩu')
@section('meta_description','Quên mật khẩu' )

@section('content')
    <section class="PagesNewsContent bkxam pdb20 pdt20">
        <div class="container container_w_1200 pd0 ">
            <div class="link_breakcrum">
                <ul class="nav">
                    <li class="nav-item">
                        <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                    </li>
                    <li class="nav-item ">
                        <span><i class="fas fa-chevron-right"></i></span>
                    </li>
                    <li class="nav-item pd8">
                        <?php
                        $link_url = '#';
                        $link_url = \App\Ultility\Ultility::getUrl();
                        ?>
                        <a href="{{ $link_url }}" class=""> <i class="fas fa-users mgr5"></i>Quên mật khẩu
                        </a>
                    </li>
                </ul>
            </div>


            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="bgrWhite" style="padding: 20px;">
                        <h1 class="title_contact f24" style="margin-bottom: 15px;">Quên mật khẩu</h1>
                        <div class="contact-info ">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                <strong> {{ session('success') }}</strong>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    <strong>{{ session('error') }}</strong>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <ul class="mgb0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('send_email') }}" method="post" enctype="multipart/form-data"
                                  id="is_change_email">
                                {!! csrf_field() !!}

                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label fw6">
                                        <span class="text-b700">Nhập email đăng kí</span>
                                        <span class="clRed pd-05"> (*)</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input id="email" type="email" class="form-control error_border_email"
                                               name="email" placeholder="Nhập email đăng kí tài khoản"
                                               value="{{ old('email') }}" required>
                                        <div class="mess_notice_email clearfix note_text_email"></div>
                                        <div class="error_reg_mess clearfix error_text_email"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 pdtop30">
                                        <button type="submit" class="btnOrange" id="btn_changeEmail">Gửi mã xác thực
                                        </button>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 pdtop30">
                                        @if(session('success_email'))
                                            <p style="color: red;display: inline-block;text-align: center;font-size: 20px;font-weight: 700">{{ session('success_email') }}</p>
                                        @endif
                                        @if(session('error_reset_email'))
                                            <p class="red">{{ session('error_reset_email') }}</p>
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

@endsection
@section('show_js')
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    @include('site.layout_site.from')
    <script>
        $(function () {
            var $form = $('#is_change_email');
            var $submitButton = $('#btn_changeEmail');

            if (!$.fn.validate) {
                return;
            }

            $form.validate({
                ignore: [],
                onkeyup: false,
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    email: {
                        required: 'Vui lòng nhập địa chỉ Email.',
                        email: 'Vui lòng nhập một địa chỉ Email hợp lệ!'
                    }
                },
                onfocusout: function (element) {
                    $(element).valid();
                },
                errorPlacement: function (error, element) {
                    var name = $(element).attr('name');
                    $('.note_text_' + name).hide();
                    $('.error_text_' + name).html('<i class="error clRed"><span class="error_reg_mess_icon"></span>' + error.text() + '</i>');
                    $('.error_border_' + name).css('cssText', 'border: 1px solid #ff0000 !important;');
                },
                success: function (label, element) {
                    var name = $(element).attr('name');
                    $('.note_text_' + name).show();
                    $('.error_text_' + name).html('');
                    $('.error_border_' + name).css('cssText', 'border: 1px solid #e0e0e0 !important;');
                },
                submitHandler: function (form) {
                    $submitButton
                        .prop('disabled', true)
                        .html('<i class="fas fa-spinner fa-spin mgr5"></i>Đang gửi mã xác thực ...');
                    form.submit();
                }
            });
        });
    </script>
@endsection
