@extends('staff_admin.layouts.master')

@section('title', 'Thêm mới giáo viên' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.teacher')
        </div>

        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section id="contact-content" class="w78 marginAuto">
                <div class="col-xl-12 col-lg-12 col-md-12 JobSeeker EmployerRegistration mgb20">
                    <div class="main Register">
                        @if(session('error'))
                            <div class="form-group" style="margin-top: 10px;">
                                <div class="alert alert-danger">
                                    <i>{{ session('error') }}</i>
                                </div>
                            </div>
                        @endif
                        <form role="form" class="custom-form" action="{{ route('staff_store_teacher') }}" method="POST" enctype="multipart/form-data" id="location-form">
                            {!! csrf_field() !!}
                            {{ method_field('POST') }}
                            <div class="notificationBox " style="background: white">

                                <div class="recruitmentRegistration">
                                    <p class="text-title font15Im">
                                        Thông tin kế toán thuế
                                    </p>
                                </div>
                                <div class="bodyBox">
                                    <div class="accountInfo">
                                        <div class="form-group row mgb10">
                                            <label class="col-12 text-left lable">Tên kế toán thuế<span>*</span> </label>
                                            <div class="col-12">
                                                <input type="text" name="teacher_name" value="{{old('teacher_name')}}"
                                                       class="form-control error_border_teacher_name" placeholder="Tên kế toán thuế" required>

                                                <div class="mess_notice_teacher_name clearfix note_text_teacher_name"></div>
                                                <div class="error_reg_mess clearfix error_text_teacher_name"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row mgb10">
                                            <label for="staticEmail" class="col-12 text-left lable">Địa chỉ kế toán thuế
                                                <span>*</span>
                                            </label>
                                            <div class="col-md-6 col-12 mgb10">
                                                <select class="form-control select22 error_border_province" name="province"
                                                        aria-label="Tỉnh/Thành phố" id="province" required>
                                                    <option value=""> -- Tất cả các tỉnh/thành phố --</option>
                                                    @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                        <option value="{{$province->province_id}}"
                                                                @if(!empty(old('province')) && old('province') == $province->province_id) selected @endif
                                                        >{{$province->province_name}}</option>
                                                    @endforeach
                                                </select>

                                                <div class="mess_notice_province clearfix note_text_province"></div>
                                                <div class="error_reg_mess clearfix error_text_province"></div>
                                            </div>
                                            <div class="col-md-6 col-12 mgb10">
                                                <select class="form-control select22 error_border_district" name="district"
                                                        aria-label="Quận/Huyện" id="district" required>
                                                    <option value=""> -- Tất cả các quận/huyện --</option>
                                                    @if(!empty(old('province')))
                                                        <?php
                                                        $list_district = \App\Entity\District::get_province_id(old('province'));
                                                        ?>
                                                    @else
                                                        <?php
                                                        $list_district = \App\Entity\District::orderBy('district_name')->get();
                                                        ?>
                                                    @endif
                                                    @foreach($list_district as $district)
                                                        <option value="{{$district->district_id}}"
                                                                @if(!empty(old('district')) && old('district') == $district->district_id) selected @endif
                                                        >{{$district->district_name}}</option>
                                                    @endforeach
                                                </select>

                                                <div class="mess_notice_district clearfix note_text_district"></div>
                                                <div class="error_reg_mess clearfix error_text_district"></div>

                                            </div>

                                            <div class="col-12">
                                                <input type="text" name="address" id="location-input"
                                                       class="form-control error_border_address" placeholder="Địa chỉ chi tiết" value="{{old('address')}}" required>

                                                <div class="mess_notice_address clearfix note_text_address"></div>
                                                <div class="error_reg_mess clearfix error_text_address"></div>
                                            </div>

                                        </div>

                                        <div class="form-group row mgb10">
                                            <label class="col-12 text-left lable">Số điện thoại<span>*</span>
                                            </label>
                                            <div class="col-12">
                                                <input type="number" name='phone' value="{{old('phone')}}"
                                                       class="form-control error_border_phone" placeholder="Số điện thoại liên hệ" required>

                                                <div class="mess_notice_phone clearfix note_text_phone"></div>
                                                <div class="error_reg_mess clearfix error_text_phone"></div>

                                            </div>
                                        </div>
                                        <div class="form-group row mgb10">
                                            <label class="col-12 text-left lable">Tài khoản Email<span>*</span> </label>
                                            <div class="col-12">
                                                <input type="text" name='email' value="{{old('email')}}"
                                                       class="form-control error_border_email" placeholder="Email là tài khoản đăng nhập" required>

                                                <div class="mess_notice_email clearfix note_text_email"></div>
                                                <div class="error_reg_mess clearfix error_text_email"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row mgb10">
                                            <label class="col-12 text-left lable">Mật khẩu (ít nhất 8 kí tự) <span>*</span> </label>
                                            <div class="col-12">
                                                <input type="password" name='password' class="form-control error_border_password"
                                                       placeholder="Mật khẩu" value="{{old('password')}}" required>

                                                <div class="mess_notice_password clearfix note_text_password"></div>
                                                <div class="error_reg_mess clearfix error_text_password"></div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group error">
                                        @if(!empty($errors->all()))
                                            @foreach($errors->all() as $erorr)
                                                <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                            @endforeach
                                        @endif

                                    </div>


                                    <div class="form-group row">
                                        <div class="col-12 ">
                                            <button type="submit" class="btn bgrBlueN white btn-loading" id="js_btnRegidit">Đăng ký ngay</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
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
                                $( "#location-form" ).validate({
                                    ignore: [],
                                    onkeyup: false,
                                    rules: {
                                        teacher_name: {
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
                                    },
                                    messages: {
                                        teacher_name: {
                                            required: 'Vui lòng nhập tên kế toán thuế.',
                                            minlength: 'Tên kế toán thuế phải tối thiểu 10 ký tự.',
                                        },
                                        province: {
                                            required: 'Vui lòng chọn tỉnh /thành phố.',
                                        },
                                        district: {
                                            required: 'Vui lòng chọn quận / huyện.',
                                        },
                                        address: {
                                            required: 'Vui lòng nhập địa chỉ.',
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
                                        // $('.btn-loading').attr('disabled', true)

                                    },
                                    success: function(label, element) {
                                        var name = $(element).attr("name");
                                        $('.note_text_' + name).show();
                                        $('.error_text_' + name).html('');
                                        $('.error_border_' + name).css("cssText", "border: 1px solid #e0e0e0  !important;");
                                    },
                                });
                            });
                            jQuery.validator.addMethod("checkEmail", function(value, element) {
                                var result = false;
                                $.ajax({
                                    async: false,
                                    url: '{!! route('check_email_employee') !!}',
                                    type: 'get',
                                    dataType: 'json',
                                    data: {
                                        email: value
                                    }
                                }).done(function(response) {
                                    result = response;
                                });
                                return result;
                            }, 'Email đã tồn tại.');
                            // validate check phone
                            jQuery.validator.addMethod("checkPhone", function(value, element){
                                var result = false;
                                var checkPhone = $("input[name=phone]").val().split('');
                                var dem = checkPhone.length;
                                if (checkPhone[0]==0 && dem==10 || dem==15) {
                                    result = true;
                                }else{

                                }
                                return result;
                            }, 'Số điện thoại không hợp lệ.');
                            // validate năm sinh
                            jQuery.validator.addMethod("checkBirthday", function(value, element) {
                                var result = false;
                                var now = new Date().getFullYear();
                                var birthday = $(element).val();
                                birthday = birthday.split("-");
                                var check = now - birthday[0];
                                if (check>=18) {
                                    result = true;
                                }
                                return result;
                            }, 'Bạn chưa đủ 18 tuổi.');
                            jQuery.validator.addMethod("checkBirthday_hople", function(){
                                var result = false;
                                var now = new Date().getFullYear();
                                var birthday = $("input[name=birthday]").val();
                                birthday = birthday.split("-");
                                var check = now - birthday[0];
                                if (check>=0) {
                                    result = true;
                                }else{

                                }
                                return result;
                            }, 'Năm sinh không hợp lệ.');

                            // function checkExtensionFile(e) {
                            //     let fileName = $(e).val();
                            //     if (fileName.search('.doc') == -1 && fileName.search('.docx') == -1 && fileName.search('.pdf') == -1) {
                            //         $('.js_error_cv').html('Bạn chỉ được tải CV với đuôi .doc, .docx hoặc .pdf')
                            //         console.log('Bạn chỉ được tải CV với đuôi .doc, .docx hoặc .pdf');
                            //     } else {
                            //         $('.js_error_cv').html('');
                            //     }
                            // }
                            jQuery.validator.addMethod("checkCV", function(){
                                var result = false;
                                var fileName = $("input[name=employee_cv]").val();
                                if (fileName.search('.doc') == -1 && fileName.search('.docx') == -1 && fileName.search('.pdf') == -1) {
                                    return false;
                                } else {
                                    return true;
                                }
                                return result;
                            }, 'Bạn chỉ được tải CV với đuôi .doc, .docx hoặc .pdf.');

                            // vaidate tên
                            jQuery.validator.addMethod("checkName", function(value, element){
                                var result = false;
                                var checkName = $(element).val();
                                var regex = /[^a-zA-Z]+$/;
                                if (checkName.search(regex)==-1) {
                                    result = true;
                                }else{
                                }
                                return result;
                            }, 'Họ và tên không hợp lệ.');
                            //vai date ngày nộp hồ sơ
                            $.validator.addMethod("minDate", function(value, element) {
                                var curDate = '{{ date('Y-m-d') }}';
                                var inputDate = $(element).val();
                                if (curDate < inputDate)
                                {
                                    return true;
                                }
                                else
                                {
                                    return false;
                                }
                            }, "Ngày nộp hồ sở phải lớn hơn ngày hiện tại");   // error message

                            //tao jquery load button



                        </script>


                        <style>
                            .error label {
                                background: #ef5050;
                                color: #fff;
                                padding: 5px;
                                margin-right: 5px;

                            }
                            .Register .select2-container .select2-selection--single .select2-selection__rendered {
                                border: none;
                            }
                        </style>
                    </div>
                </div>
            </section><!--end: #content-->


        </div>
    </div>
</div>
<script>
    $(function(){
        $('#province').change(function () {
                $.get('/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                })
            });
    })
</script>
@endsection
