<div class="modal fade" id="loginTiva" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bgHome">
                <h5 class="modal-title clWhite f18" id="exampleModalLabel">ĐĂNG NHẬP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="clWhite" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('login_home') }}" method="post">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Email đăng ký <span class="clRed">(*)</span></label>
                        <input type="email" name="email" class="form-control f14"
                               aria-describedby="emailHelp" placeholder="Nhập vào email của bạn">
                    </div>
                    <div class="form-group">
                        <label for="">Mật khẩu <span class="clRed">(*)</span></label>
                        <input type="password" name="password" class="form-control f14"
                               placeholder="Nhập mật khẩu của bạn">
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ghi nhớ mật khẩu
                            </label>
                            <label class="mgb0 flRight " for=""> <a class="forget_password" href="{{ route('reset_passwrod') }}">Quên
                                    mật
                                    khẩu</a></label>
                        </div>
                    </div>
                    @if (\Request::is('/'))
                        <input type="hidden" name="home" class="form-control"
                               placeholder="" value="home">
                    @endif
                    @if($errors->any() && $errors->has('loginFail') )
                        <div class="alert alert-danger" role="alert">
                            <strong>Mật khẩu hoặc Email đăng nhập không đúng.</strong>
                        </div>
                    @endif
                    <div class="form-group mgb0 text-center login_forgert">

                        <label class="mgb0 " for="">
                            <a class="btnOrange bdr5" href="{{route('register')}}"> Đăng ký tài khoản</a>
                        </label>
                    </div>
                    <div class="form-group mgb0" style="margin-bottom: 10px">

                    </div>
                    <p class="clRed" id="InfoWarning" style="margin-bottom: 10px"></p>
                    @if(session('error_login'))
                        <div class="form-group mgb0" style="margin-bottom: 10px">
                            <p class="clRed mgb0" style="margin-bottom: 10px">{{ session('error_login') }}</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary f14" data-dismiss="modal">ĐÓNG</button>
                    <button type="submit" class="btn btnHome f14">ĐĂNG NHẬP</button>
                </div>
            </form>
        </div>
    </div>
</div>
