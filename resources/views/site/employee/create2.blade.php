<section id="contact-content dsNone" style="display: none">
    <div class="notificationBox mb30 w78 marginAuto Register" style="background: #fff">
        <p class="text-title font15Im mgt0Im">
            Ứng viên đăng ký
        </p>
        <hr>
        <div class="supporter text-ct">
                       <span>Nếu gặp bất kỳ khó khăn nào vui lòng liên hệ Hotline hỗ trợ  Ứng viên
                           <span class="block font20 red">
                               <span class="dsBlock">
                                   <b>{{ isset($information['hotline']) ? $information['hotline'] : '' }} </b>
                               </span>
                           </span>
                       </span>
        </div>
        <div class="recruitmentRegistration">
            <p class="text-title font15Im">
                Thông tin cá nhân
            </p>
        </div>
        <form action="{{ route('createEmployee') }}" method="post" class="dang-ky-tuyen-dung"
              id="form_register">
            {!! csrf_field() !!}
            <div class="">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="">Họ và tên <span class="red">(*)</span></label>
                    <input type="text" name="name" class=" form-control error_border_name"
                           id="exampleInputEmail1"
                           aria-describedby="emailHelp" placeholder="Họ và tên ..."
                           value="{{ old('name') }}" required>
                    <div class="mess_notice_name clearfix note_text_name"></div>
                    <div class="error_reg_mess clearfix error_text_name"></div>
                </div>


                <div class="form-group">
                    <label for="exampleInputEmail1">Số điện thoại <span class="red">(*)</span></label>
                    <input type="number" name="phone" class="form-control error_border_phone"
                           id="exampleInputEmail1"
                           aria-describedby="emailHelp" placeholder="Số điện thoại ..."
                           value="{{ old('phone') }}" required>
                    <div class="mess_notice_phone clearfix note_text_phone"></div>
                    <div class="error_reg_mess clearfix error_text_phone"></div>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email đăng ký <span class="red">(*)</span></label>
                    <input type="email" name="email" class="form-control error_border_email" id="txt_email"
                           aria-describedby="emailHelp" placeholder="Nhập vào email của bạn"
                           value="{{ old('email') }}" required>
                    <div class="mess_notice_email clearfix note_text_email"></div>
                    <div class="error_reg_mess clearfix error_text_email"></div>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Mật khẩu <span class="red">(*)</span></label>
                    <input type="password" class="form-control error_border_password" name="password"
                           placeholder="Mật khẩu"
                           value="{{ old('password') }}" required>
                    <div class="mess_notice_password clearfix note_text_password"></div>
                    <div class="error_reg_mess clearfix error_text_password"></div>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Công việc cần tìm <span class="red">(*)</span></label>

                    <select class="form-control select2 error_border_career_category_id"
                            name="career_category_id">
                        <option value="" selected>-- Tất cả công việc --</option>
                        @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                            <option value="{{$career->career_category_id}}">{{$career->career_category_name}}</option>
                        @endforeach
                    </select>

                    <div class="mess_notice_career_category_id clearfix note_text_career_category_id"></div>
                    <div class="error_reg_mess clearfix error_text_career_category_id"></div>
                </div>


                <div class="form-group row mgb10">
                    <label for="staticEmail" class="col-12 text-left lable">Khu vực cần tìm việc <span
                                class="red">(*)</span>
                    </label>
                    <div class="col-md-6 col-12 mgb10">
                        {{--<select class="form-control select2 error_border_province" name="province"--}}
                        {{--aria-label="Tỉnh/Thành phố" id="province">--}}
                        {{--<option value=""> -- Tất cả các tỉnh/thành phố --</option>--}}
                        {{--@foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)--}}
                        {{--<option value="{{$province->province_id}}">{{$province->province_name}}</option>--}}
                        {{--@endforeach--}}
                        {{--</select>--}}

                        <div class="mess_notice_province clearfix note_text_province"></div>
                        <div class="error_reg_mess clearfix error_text_province"></div>
                    </div>
                    <div class="col-md-6 col-12 mgb10">
                        <select class="form-control select2 error_border_district" name="district"
                                aria-label="Quận/Huyện" id="district" style="    border: 1px solid green;">
                            <option value=""> -- Tất cả các quận/huyện --</option>
                            @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                <option value="{{$district->district_id}}">{{$district->district_name}}</option>
                            @endforeach
                        </select>

                        <div class="mess_notice_district clearfix note_text_district"></div>
                        <div class="error_reg_mess clearfix error_text_district"></div>


                    </div>


                </div>


                <div class="form-group error">
                    @if(!empty($errors->all()))
                        @foreach($errors->all() as $erorr)
                            <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                        @endforeach
                    @endif
                </div>

                <div class="form-group">
                    <!-- Google reCaptcha -->
                    <div class="g-recaptcha" id="feedback-recaptcha"
                         data-sitekey="{{ env('RE_CAPTCHA_HTML')  }}"></div>
                    <!-- End Google reCaptcha -->
                </div>
                <div class="error error_g-captcha"></div>

            </div>
            <div class="form-group">
                <button type="submit" class="btn bgrBlueN white btn-loading" id="js_btnRegidit">Đăng ký
                    ngay
                </button>
            </div>
        </form>
    </div>
</section><!--end: #content-->