<div class="tab-content mgb20" id="nav-tabContent">
    <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

        <div class="account dnavnone mgb5 mbdsNone">
            <div class="employee dnavnone">

                <div class="account_qrcode text-center">
                    <p class="clRed fw6 text-center mgb0">Quét QR Tải App</p>
                    <p class="clRed fw6 text-center mgb0">Mạng xã hội du lịch</p>
                    <img class="lazy img_qrcode" style="max-width: 200px !important;"
                         src="{{ asset('assets/image/qrcode.jpg') }}"
                         title="Tải App"
                         alt="Tải App">
                </div>
                @if(!\Illuminate\Support\Facades\Auth::check())
                    <form action="{{ route('login_home') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email đăng ký <span
                                            class="clRed">(*)</span></label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="Nhập vào email của bạn">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mật khẩu <span class="clRed">(*)</span></label>
                                <input type="password" name="password" class="form-control"
                                       id="exampleInputPassword1" placeholder="Nhập mật khẩu của bạn">
                            </div>
                            @if($errors->any() && $errors->has('loginFail') )
                                <div class="alert alert-danger" role="alert">
                                    <strong>Mật khẩu hoặc Email đăng nhập không đúng.</strong>
                                </div>
                            @endif
                            @if (\Request::is('/'))
                                <input type="hidden" name="home" class="form-control" id="exampleInputPassword1"
                                       placeholder="" value="home">
                            @endif
                            @if(session('error_login'))
                                <div class="form-group mgb0" style="margin-bottom: 10px">
                                    <p class="red mgb0" style="margin-bottom: 10px">{{ session('error_login') }}</p>
                                </div>
                            @endif
                            @if($errors->any() && $errors->has('loginFail') )
                                <div class="alert alert-danger" role="alert">
                                    <strong>Mật khẩu hoặc Email đăng nhập không đúng.</strong>
                                </div>
                            @endif
                            <div class="form-group mgb0">
                                <label class="mgb0" for="exampleInputPassword1"> <a
                                            href="{{ route('reset_passwrod') }}">Quên
                                        mật
                                        khẩu</a></label>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Chưa có tài khoản?
                                    <a href="{{route('register')}}"> Đăng ký tài khoản</a>
                                </label>
                            </div>
                            <button type="submit" class="btn bgHome clWhite">ĐĂNG NHẬP</button>
                        </div>

                    </form>
                @endif
            </div>
        </div>
        @include('site.sidebar_site.item_job_facebook')
    </div>
</div>
