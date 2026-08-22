@extends('site.layout.site')

@section('title','Ứng viên Đăng ký')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')

    <section class="main-ctn pd15-0 ">
        <div class="container">
            <section id="contact-content ">
                <div class="notificationBox mb30 w78 marginAuto">
                    <p class="text-title font15Im mgt0Im">
                        Ứng viên đăng ký nhanh
                    </p>
                    <hr>
                    <div class="supporter text-ct">
                       <span>Nếu gặp bất kỳ khó khăn nào vui lòng liên hệ Hotline hỗ trợ  Ứng viên <br><br>
                           <span class="block font20 red">
                               <span class="dsBlock">
                                   <b>{{ isset($information['hotline']) ? $information['hotline'] : '' }} </b>
                               </span>
                           </span>
                       </span>
                    </div>
                    <div class="recruitmentRegistration">
                        <p class="text-title font15Im">
                            THông tin cá nhân
                        </p>
                    </div>
                    <form action="{{ route('register_login') }}" method="post" class="dang-ky-tuyen-dung">
                        {!! csrf_field() !!}
                        <div class="">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="">Họ và tên <span class="red">(*)</span></label>
                                <input type="text" name="name" class=" form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="Họ và tên ..."
                                       value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại <span class="red">(*)</span></label>
                                <input type="number" name="phone" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="Số điện thoại ..."
                                       value="{{ old('phone') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email đăng ký <span class="red">(*)</span></label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="Nhập vào email của bạn"
                                       value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mật khẩu <span class="red">(*)</span></label>
                                <input type="password" class="form-control" name="password" placeholder="Mật khẩu"
                                       value="{{ old('password') }}" required>
                            </div>

                            <div class="form-group">
                                <!-- Google reCaptcha -->
                                <div class="g-recaptcha" id="feedback-recaptcha"
                                     data-sitekey="{{ '6Le9trIUAAAAALrCbKEVd_fFCOjZm13bNMk9DmZP'  }}"></div>
                                <!-- End Google reCaptcha -->
                            </div>
                            @if ($errors->has('name'))
                                <div class="alert alert-danger" role="alert">
                                    Họ và tên lỗi
                                </div>
                            @endif
                            @if ($errors->has('email'))
                                <div class="alert alert-danger" role="alert">
                                    Email đã tồn tại, hoặc bạn nhập sai địa chỉ email
                                </div>
                            @endif
                            @if ($errors->has('phone'))
                                <div class="alert alert-danger" role="alert">
                                    Số điện thoại đã tồn tại, hoặc Số điện thoại bị bỏ trống
                                </div>
                            @endif
                            @if ($errors->has('password'))
                                <div class="alert alert-danger" role="alert">
                                   Mật khẩu không được để trống và phải lớn hơn 8 kí tự
                                </div>
                            @endif
                            @if ($errors->has('g-recaptcha-response'))
                                <div class="alert alert-danger" role="alert">
                                    Vui lòng click chọn tôi không phải là người máy
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn bgrBlueN white">ĐĂNG KÝ NGAY</button>
                        </div>
                    </form>
                </div>
            </section><!--end: #content-->
        </div>
    </section>

@endsection
