@extends('site.layout_site.site')

@section('title', 'Xác nhận email')
@section('meta_description', 'Xác nhận email đăng ký tài khoản ứng viên')
@section('keywords', 'Xác nhận email')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-xl-9 col-lg-12 col-md-12 col-12 dcontent">
                    <div class="CV bgrWhite radius5 pd20 mgt20 mgb20">
                        <div class="title">
                            <h5 class="lt-f18 fw7 bdLeftBlueN5x pdl10 blueN mgb0">Xác nhận email</h5>
                        </div>
                        <hr class="mgt10 mgb10">
                        <p>Nhập mã OTP đã được gửi tới: <strong>{{ $email }}</strong></p>
                        @if (!empty($message))
                            <div class="alert alert-info">{{ $message }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif
                        <form action="{{ route('verify_registration_otp') }}" method="post">
                            {!! csrf_field() !!}
                            <input type="hidden" name="email" value="{{ $email }}">
                            <div class="form-group">
                                <label for="registration-otp">Mã OTP</label>
                                <input id="registration-otp" class="form-control" type="text" name="otp"
                                       inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required autofocus>
                            </div>
                            <button class="button_change_email" type="submit">Xác nhận email</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
