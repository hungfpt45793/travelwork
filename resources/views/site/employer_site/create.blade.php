@extends('site.layout_site.site')

@section('title','Nhà Tuyển dụng Đăng ký')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('meta_image', !empty($information['og_image']) ?  asset($information['og_image']) : '' )

<link rel="stylesheet" type="text/css" href="{{ asset('assets/web/css/register.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/web/css/form.css') }}"/>

@section('content')
    <section class="main-ctn bg_content_regedit">
        <div class="wrapper container container_w_1200">


            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline mgt20 ">
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
                                <a href="{{ $link_url }}" class=""> <i class="fas fa-users mgr5"></i>Nhà tuyển dụng đăng
                                    ký</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 create_employer mgt20 ">
                <div class="main ">
                    @if(session('error'))
                        <div class="form-group" style="margin-top: 10px;">
                            <div class="alert alert-danger">
                                <i>{{ session('error') }}</i>
                            </div>
                        </div>
                    @endif
                    <form action="{{route('createEmployer')}}" id="location-form" method="post"
                          class="form_validate form_create_employer">
                        {!! csrf_field() !!}
                        <div class="box_create_employer">
                            <p class="text-title">
                                nhà tuyển dụng đăng ký
                            </p>
                            <hr>
                            <div class="supporter text-ct">
                           <span>Nếu gặp bất kỳ khó khăn nào vui lòng liên hệ Hotline hỗ trợ nhà tuyển dụng
                               <span class="block font20 red">
                                   <span class="dsBlock">
                                       <b class="f20 clRed fw6"> {{isset($information['hotline']) ? $information['hotline'] : ''}} </b>
                                   </span>
                               </span>
                           </span>
                            </div>

                            <div class="recruitmentRegistration">
                                <p class="text-title font15Im">
                                    thông tin tài khoản - Liên hệ
                                </p>
                            </div>
                            <div class="bodyBox">
                                <div class="accountInfo">
                                    <div class="form-group row mgb10">
                                        <label for="staticEmail" class="col-12 fw6">Họ và tên
                                            <span class="clRed">(*)</span> </label>
                                        <div class="col-12">
                                            <input type="text" name="employer_name" value="{{old('employer_name')}}"
                                                   class="form-control error_border_employer_name"
                                                   placeholder="Tên người phụ trách">

                                            <div class="mess_notice_employer_name clearfix note_text_employer_name"></div>
                                            <div class="error_reg_mess clearfix error_text_employer_name"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row mgb10">
                                        <div class="col-md-6 col-12">
                                            <label class="col-12 fw6 pd0">Tài khoản Email <span class="clRed">(*)</span>
                                            </label>
                                            <div class="col-12 pd0">
                                                <input type="text" name='email' value="{{old('email')}}"
                                                       class="form-control error_border_email"
                                                       placeholder="Email là tài khoản đăng nhập">

                                                <div class="mess_notice_email clearfix note_text_email"></div>
                                                <div class="error_reg_mess clearfix error_text_email"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label class="col-12 fw6 pd0">Số điện thoại liên hệ
                                                <span class="clRed">(*)</span>
                                            </label>
                                            <div class="col-12 pd0">
                                                <input type="number" name='phone' value="{{old('phone')}}"
                                                       class="form-control error_border_phone"
                                                       placeholder="Số điện thoại liên hệ">

                                                <div class="error_message">
                                                    <div class="mess_notice_phone clearfix note_text_phone"></div>
                                                    <div class="error_reg_mess clearfix error_text_phone"></div>
                                                </div>


                                            </div>
                                        </div>


                                    </div>

                                    <div class="form-group row mgb10">

                                    </div>
                                    <div class="form-group row mgb10">
                                        <label class="col-12 fw6">Mật khẩu (ít nhất 8 kí tự) <span
                                                    class="clRed">(*)</span> </label>
                                        <div class="col-12">
                                            <input type="password" name='password'
                                                   class="form-control error_border_password"
                                                   placeholder="Mật khẩu" value="{{old('password')}}">

                                            <div class="mess_notice_password clearfix note_text_password"></div>
                                            <div class="error_reg_mess clearfix error_text_password"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row mgb10">
                                        <label class="col-12 fw6">Mã giới thiệu(nếu có) </label>
                                        <div class="col-12">
                                            <input type="text" name='user_id'
                                                   class="form-control error_border_password"
                                                   placeholder="Mã giới thiệu" value="{{old('user_id')}}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="recruitmentRegistration">
                                <p class="text-title font15Im">
                                    thông tin công ty
                                </p>
                            </div>


                            <div class="bodyBox">
                                <div class="accountInfo">

                                    <div class="form-group row mgb10">
                                        <label class="col-12 fw6">Tên công ty <span class="clRed">(*)</span> </label>
                                        <div class="col-12">
                                            <input type="text" name="name" value="{{old('name')}}"
                                                   class="form-control error_border_name js_name"
                                                   placeholder="Tên công ty">
                                            <small id="emailHelp" class="form-text text-muted"><i>Ghi tên công ty
                                                    đầy đủ và rõ
                                                    ràng theo Giấy phép đăng ký kinh doanh.</i></small>

                                            <div class="mess_notice_name clearfix note_text_name"></div>
                                            <div class="error_reg_mess clearfix error_text_name"></div>

                                        </div>
                                    </div>
                                    <div class="form-group row mgb10">
                                        <label for="staticEmail" class="col-12 fw6">Địa chỉ công
                                            ty <span class="clRed">(*)</span>
                                        </label>
                                        <div class="col-md-6 col-12 mgb10">
                                            <select class="form-control select2 error_border_province" name="province"
                                                    aria-label="Tỉnh/Thành phố" id="province">
                                                <option value=""> -- Tất cả các tỉnh/thành phố --</option>
                                                @foreach(\App\Entity\Province::getAllProvince() as $province)
                                                    <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                                                @endforeach
                                            </select>

                                            <div class="mess_notice_province clearfix note_text_province"></div>
                                            <div class="error_reg_mess clearfix error_text_province"></div>
                                        </div>
                                        <div class="col-md-6 col-12 mgb10">
                                            <select class="form-control select2 error_border_district" name="district"
                                                    aria-label="Quận/Huyện" id="district">
                                                <option value=""> --Vui lòng chọn tỉnh / thành phố trước --</option>
                                                @foreach(\App\Entity\District::getAllDistrict() as $district)
                                                    <option value="{{$district->district_id}}">{{$district->district_name}}</option>
                                                @endforeach
                                            </select>

                                            <div class="mess_notice_district clearfix note_text_district"></div>
                                            <div class="error_reg_mess clearfix error_text_district"></div>

                                        </div>

                                        <div class="col-12">
                                            <input type="text" name="address" id="location-input"
                                                   class="form-control error_border_address js_address"
                                                   placeholder="Địa chỉ chi tiết công ty" value="{{old('address')}}">

                                            <div class="mess_notice_address clearfix note_text_address"></div>
                                            <div class="error_reg_mess clearfix error_text_address"></div>
                                        </div>

                                    </div>

                                    <div class="form-group row mgb10">
                                        <label class="col-12 fw6"> Mã số thuế </label>
                                        <div class="col-6">
                                            <input type="number" name="tax_code" value=""
                                                   class="form-control error_border_name js_tax_code"
                                                   placeholder="Mã số thuế">
                                            <i class="f12 js_check_tax_code_error clRed"></i>
                                        </div>
                                        {{--<div class="col-6">--}}
                                            {{--<span class="js_check_tax_code" style="display: inline-block;color: #fff;background: orange;padding: 10px;cursor: pointer">Lấy thông tin</span>--}}
                                        {{--</div>--}}
                                    </div>


                                </div>
                                <div class="form-group mgb10">
                                    <p class="mgb0"><i>(Vui lòng tích chọn ' Tôi không phải người máy ' hoặc ' I'm not a robot ')</i></p>
                                    <!-- Google reCaptcha -->
                                    <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{{ env('RE_CAPTCHA_HTML')  }}"></div>
                                    <div class="error error_g-captcha"></div>
                                    <!-- End Google reCaptcha -->
                                </div>

                                @if(!empty($errors->all()))
                                    @foreach($errors->all() as $erorr)
                                        <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                    @endforeach
                                @endif
                                <div class="form-group row mgb10">
                                    <div class="col-12">
                                        <button type="submit" class="btn white btn-loading btn_submit"
                                                id="js_btnRegidit">Đăng ký ngay
                                        </button>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>
                        <div class="rs_video pd15">
                            <h3>Video hướng dẫn đăng ký và tạo tài khoản nhà tuyển dụng trên sanketoan.vn</h3>
                            {!! isset($information['video-huong-dan-dang-ky-nha-tuyen-dung']) ?  $information['video-huong-dan-dang-ky-nha-tuyen-dung'] : '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/Ssc6k0w4YnA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' !!}

                        </div>


                </div>


            </div>

        </div>
    </section>
    <style>
        .error label {
            background: #ef5050;
            color: #fff;
            padding: 5px;
            margin-right: 5px;

        }
    </style>

@endsection
@section('show_js')
    <script src="/public/assets/js/jquery.validate.min.js"></script>
    @include('site.layout_site.from')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.js_check_tax_code').click(function () {
                var tax_code = $('.js_tax_code').val();
                console.log(tax_code);
                $.ajax({
                    'type': 'get',
                    'url': "{{ route('check_tax_code') }}",
                    'data': {
                        tax_code: tax_code,
                    },
                    dataType: 'json',
                    'success': function (res) {
                        console.log(res.district_id);
                        console.log(res.DiaChiCongTy);
                        $('.js_name').val(res.Title);
                        $('.js_address').val(res.DiaChiCongTy);
                        if(res.DiaChiCongTy != '')
                        {
                            $('#district').val(res.district_id); // Select the option with a value of '1'
                            $('#district').trigger('change'); // Notify any JS components that the value changed

                            $('#province').val(res.province_id); // Select the option with a value of '1'
                            $('#province').trigger('change'); // Notify any JS components that the value changed
                        }
                        $('.js_check_tax_code_error').html('');
                    },
                    'error':function(){
                        $('.js_check_tax_code_error').html('Mã số thuế này không tìm thấy trên hệ thống daonh nghiệp nhà nước');
                    }
                })
            });
                $('#province').change(function () {
                    console.log(1);
                    if($('#district').val() == '')
                    {
                        $.get('/ajax-district/' + $(this).val(), function (data) {
                            $('#district').html(data);
                        });
                    }
                });
            });

        // });

        $(document).ready(function () {
            email = $.trim('email');
            $("#location-form").validate({
                ignore: [],
                onkeyup: false,
                rules: {
                    name: {
                        required: true,
                        minlength: 10,
                    },
                    province: {
                        required: true,
                    },
                    district: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    employer_name: {
                        required: true,
                    },
                    email: {
                        required: {
                            depends:function(){
                                $(this).val($.trim($(this).val()));
                                return true;
                            }
                        },
                        checkEmail: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        number: true,
                    },
                    password: {
                        required: true,
                        minlength: 8,
                    },
                },
                messages: {
                    name: {
                        required: 'Vui lòng nhập tên công ty.',
                        minlength: 'Tên công ty phải tối thiểu 10 ký tự.',
                    },
                    province: {
                        required: 'Vui lòng chọn tỉnh /thành phố.',
                    },
                    district: {
                        required: 'Vui lòng chọn quận / huyện.',
                    },
                    address: {
                        required: 'Vui lòng nhập địa chỉ công ty.',
                    },
                    employer_name: {
                        required: 'Tên người đại diện không được để trống.',
                    },
                    email: {
                        required: 'Vui lòng nhập địa chỉ Email.',
                        checkEmail: 'Email đã tồn tại.',
                        email: 'Vui lòng nhập một địa chỉ Email hợp lệ !'
                        // checkEmail của jquery layout site
                    },
                    phone: {
                        required: 'Số điện thoại phải là số và không được để trống.',
                    },
                    password: {
                        required: 'Vui lòng nhập vào mật khẩu.',
                        minlength: 'Mật khẩu tối thiểu 8 ký tự'
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
        });
        $('#js_btnRegidit').click(function() {
            if ($('#location-form').valid()) {
                if (grecaptcha.getResponse() == ""){
                    $('.error_g-captcha').text("Vui lòng tích chọn ' Tôi không phải người máy ' hoặc ' I'm not a robot '");
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

    </script>
@endsection