<section class="main-ctn pd15-0 ">
    <div class="container">
        <section id="contact-content ">
            <div class="notificationBox mb30 w78 marginAuto" style="background: #fff">
                <p class="text-center clorange">Vui lòng tạo tài khoản hồ sơ ứng viên! Nếu có tài khoản vui
                    lòng đăng nhập <a href="#" data-toggle="modal" data-target="#loginTiva" class="green">tại đây</a></p>
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
                <form action="{{ route('createEmployee') }}" method="post" class="dang-ky-tuyen-dung Register" id="form_register">
                    {!! csrf_field() !!}
                    <div class="">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="">Họ và tên <span class="red">(*)</span></label>
                            <input type="text" name="name" class=" form-control error_border_name" id="exampleInputEmail1"
                                   aria-describedby="emailHelp" placeholder="Họ và tên ..."
                                   value="{{ old('name') }}" required>
                            <div class="mess_notice_name clearfix note_text_name"></div>
                            <div class="error_reg_mess clearfix error_text_name"></div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Số điện thoại <span class="red">(*)</span></label>
                            <input type="number" name="phone" class="form-control error_border_phone" id="exampleInputEmail1"
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
                            <input type="password" class="form-control error_border_password" name="password" placeholder="Mật khẩu"
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
                            <label for="staticEmail" class="col-12 text-left lable">Khu vực cần tìm việc <span class="red">(*)</span>
                            </label>
                            <div class="col-md-6 col-12 mgb10">
                                <select class="form-control select2 error_border_province" name="province"
                                        aria-label="Tỉnh/Thành phố" id="province" >
                                    <option value=""> -- Tất cả các tỉnh/thành phố --</option>
                                    @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                        <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                                    @endforeach
                                </select>

                                <div class="mess_notice_province clearfix note_text_province"></div>
                                <div class="error_reg_mess clearfix error_text_province"></div>
                            </div>
                            <div class="col-md-6 col-12 mgb10">
                                <select class="form-control select2 error_border_district" name="district"
                                        aria-label="Quận/Huyện" id="district" >
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
                                 data-sitekey="{{ '6Le9trIUAAAAALrCbKEVd_fFCOjZm13bNMk9DmZP'  }}"></div>
                            <!-- End Google reCaptcha -->
                        </div>
                        <div class="error error_g-captcha"></div>

                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn bgrBlueN white btn-loading" id="js_btnRegidit">Đăng ký ngay </button>
                    </div>
                </form>



            </div>
        </section><!--end: #content-->
    </div>
</section>


<script>
    $(document).ready(function () {
        $('#province').change(function () {
            $.get('/ajax-district/' + $(this).val(), function (data) {
                $('#district').html(data);
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $( "#form_register" ).validate({
            ignore: [],
            onkeyup: false,
            click: false,
            rules: {
                name: {
                    required: true,
                    minlength: 5,
                },
                email: {
                    required: true,
                    checkEmail: true,
                    email: true
                },
                phone: {
                    required: true,
                    number: true,
                    checkPhone: true,
                },
                password: {
                    required: true,
                    minlength: 8,
                },
                career_category_id: {
                    required: true,
                },
                province: {
                    required: true,
                },
                district: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: 'Vui lòng nhập vào họ và tên.',
                    minlength: 'Họ tên phải tối thiểu 5 ký tự.',
                },
                email: {
                    required: 'Vui lòng nhập địa chỉ Email.',
                    checkEmail: 'Email đã tồn tại.',
                    email: 'Vui lòng nhập một địa chỉ Email hợp lệ !'
                    // checkEmail của jquery layout site
                },
                phone: {
                    required: 'Số điện thoại phải là số và không được để trống.',
                    checkPhone: 'Số điện thoại không hợp lệ',
                },
                password: {
                    required: 'Vui lòng nhập vào mật khẩu.',
                    minlength: 'Mật khẩu tối thiểu 8 ký tự'
                },
                career_category_id: {
                    required: 'Vui lòng chọn công việc cần tìm',
                },
                province: {
                    required: 'Vui lòng chọn tỉnh /thành phố.',
                },
                district: {
                    required: 'Vui lòng chọn quận / huyện.',
                },
            },
            onfocusout: function(element) {
                $(element).valid();
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                $('.note_text_' + name).hide();
                $('.error_text_' + name).html('<i class="error"><span class="error_reg_mess_icon"></span>' + error.text() + '</i>');
                $('.error_border_' + name).css("cssText", "border: 1px solid #ff0000  !important;");
                $('.btn-loading').button('reset');
            },
            success: function(label, element) {
                var name = $(element).attr("name");
                $('.note_text_' + name).show();
                $('.error_text_' + name).html('');
                $('.error_border_' + name).css("cssText", "border: 1px solid #e0e0e0  !important;");
                $('#js_btnRegidit').attr('disabled', false);

            },
            submitHandler: function(form) {
                form.submit();
            }

        });
        //tao jquery load button
        $('#js_btnRegidit').click(function() {

            if ($('#form_register').valid()) {
                if (grecaptcha.getResponse() == ""){
                    $('.error_g-captcha').text("Vui lòng tích chọn tôi không phải người máy");
                    $('.error_g-captcha').css('margin-bottom','5px');
                    return false;
                }
                else
                {
                    $('.error_g-captcha').text("");
                }
                $(this).html( '<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang đăng ký...');
                $btn.attr('disabled', false);
            }
            else {
            }
        });

    });


</script>


