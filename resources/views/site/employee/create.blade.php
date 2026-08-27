@extends('site.layout.site')
@section('title','Ứng viên Đăng ký')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')
@section('content')
    <section class="main-ctn pd15-0">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20 mgb10">
                        <ul class="nav">
                            <li class="nav-item pd8">

                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <?php
                                $link_url = '#';
                                $link_url = \App\Ultility\Ultility::getUrl();
                                ?>
                                <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> <i
                                            class="fas fa-users mgr5"></i>Ứng viên đăng ký</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <section id="contact-content" class="create_res_employee">
                <div class="container">
                    <form action="{{ route('createEmployee') }}" method="post" class="dang-ky-tuyen-dung"
                          id="form_register">
                        {!! csrf_field() !!}

                        <div class="row">
                            <div class="col-lg-12 p_alert_0">
                                <div class="alert alert-info" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    {!! !empty($information['huong-dan-dang-ki-tai-khoan-ung-vien']) ? $information['huong-dan-dang-ki-tai-khoan-ung-vien'] : '' !!}
                                </div>
                                @if(!empty($_GET['url']))
                                <div class="alert alert-danger" role="alert">
                                    <p class="clRed">
                                        Bạn phải đăng ký tài khoản ứng viên trước mới kích hoạt được khóa học
                                    </p>
                                </div>
                                @endif
                            </div>

                        </div>
                        <div class="row mgt15">
                            <div class="col-md-6">
                                <div class="card bg-light mb-3">
                                    <div class="card-header bg-dark text-white">Thông tin tài khoản</div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i
                                                                class="far fa-user"></i></span>
                                                </div>
                                                <input class="form-control error_border_name" name="name"
                                                       placeholder="Họ tên của bạn" type="text"
                                                       value="{{ old('name') }}" required>
                                            </div>
                                            <div class="mess_notice_name clearfix note_text_name"></div>
                                            <div class="error_reg_mess clearfix error_text_name"></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i
                                                                class="fas fa-phone-alt"></i></span>
                                                </div>
                                                <input class="form-control error_border_phone" name="phone"
                                                       placeholder="Số điện thoại" type="number"
                                                       value="{{ old('phone') }}" required>
                                            </div>

                                            <div class="mess_notice_phone clearfix note_text_phone"></div>
                                            <div class="error_reg_mess clearfix error_text_phone"></div>

                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i
                                                                class="far fa-envelope"></i></span>
                                                </div>
                                                <input value="{{ old('email') }}" class="form-control error_border_email"
                                                       id="js_val_email" type="email" name="email"
                                                       placeholder="Địa chỉ email" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-danger" id="js_check_email_create" type="button">KIỂM TRA EMAIL</button>
                                                </div>
                                            </div>
                                            <div class="mess_notice_email clearfix note_text_email"></div>
                                            <div class="error_reg_mess clearfix error_text_email"></div>
                                            <div class="alert alert-danger alert_error_email" style="display: none" role="alert">
                                                <strong>Thông báo: </strong><span class="alert_note_email"></span>
                                            </div>
                                            <div class="alert alert-success alert_success_email" style="display: none" role="alert">
                                                <strong>Chúc mừng! </strong><span class="alert_note_email"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i
                                                                class="fas fa-key"></i></span>
                                                </div>
                                                <input class="form-control error_border_password"
                                                       value="{{ old('password') }}" name="password"
                                                       placeholder="Mật khẩu đăng nhập" type="password" required>
                                            </div>
                                            <div class="mess_notice_password clearfix note_text_password"></div>
                                            <div class="error_reg_mess clearfix error_text_password"></div>
                                        </div>


                                        <div class="form-group error">
                                            @if(!empty($errors->all()))
                                                @foreach($errors->all() as $erorr)
                                                    <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                                @endforeach
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="text-center mgt20">
                                    {{--validate nếu chua chon công việc cần tìm--}}
                                    <div class="mess_notice_career_category_id clearfix note_text_career_category_id"></div>
                                    <div class="error_reg_mess clearfix error_text_career_category_id"></div>

                                    {{--validate nếu chua chon thành phố cần tìm--}}
                                    <div class="mess_notice_province clearfix note_text_province"></div>
                                    <div class="error_reg_mess clearfix error_text_province"></div>
                                    {{--validate nếu chua chon quận huyên--}}
                                    <div class="mess_notice_district clearfix note_text_district"></div>
                                    <div class="error_reg_mess clearfix error_text_district"></div>

                                    <button type="submit" class="btn bgrBlueN white btn-loading js_btnRegidit">
                                        HOÀN TẤT ĐĂNG KÝ
                                    </button>

                                    {{--<button type="submit" id="btnDangKy" class="btn btn-danger" disabled="">HOÀN TẤT ĐĂNG KÝ</button>--}}

                                    <div class="form-group w-100 text-center">
                                        <small class="form-text text-dark text-center mbdsNone">
                                            (
                                            Bằng việc nhấn nút Đăng ký, bạn đã đọc và đồng ý với các
                                            <a href="/bai-viet-ve-san-ke-toan/chinh-sach-bao-mat" target="_blank"
                                               class="font-weight-bold text-dark">Chính sách bảo mật</a>)

                                        </small>

                                        <small class="form-text text-dark text-center mbf10 dsNone mbdsBlock">
                                            (Bằng việc nhấn nút Đăng ký, bạn đã đồng ý với
                                            <a href="/bai-viet-ve-san-ke-toan/chinh-sach-bao-mat" target="_blank"
                                               class="font-weight-bold text-dark">Chính sách bảo mật</a>)

                                        </small>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light mb-3">
                                    <div class="card-header bg-dark text-white">
                                        <span>Chọn tối đã 3 vị trí</span>
                                        <span style="float: right" class="mbdsNone">Khu vực cần tìm việc</span>
                                    </div>
                                    <div class="card-body pd15 list-linhvuc">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="f16 fw6">Công việc cần tìm<i
                                                            style="color: red">(*)</i></label>
                                                @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                                    <div class="form-group">
                                                        <label class="answerRadio">
                                                            <input type="checkbox" name="career_category_id[]"
                                                                   value="{{$career->career_category_id}}"
                                                                   id="{{$career->career_category_id}}"
                                                                    class="flat-red resetchecked js_check_category_carrer_max_3"
                                                                    @if(in_array($career->career_category_id, old('career_category_id', []))) checked @endif>
                                                            {{$career->career_category_name}}
                                                        </label>
                                                    </div>
                                                @endforeach


                                            </div>
                                            <div class="col-md-7">
                                                <label class="f16 fw6">Khu vực cần tìm việc <i
                                                            style="color: red">(*)</i></label>
                                                <p>
                                                    <i>Vui lòng chọn tỉnh /thành phố -> sau đó chọn quận / huyện</i>
                                                </p>
                                                <select class="form-control select2 error_border_province"
                                                        name="province"
                                                        aria-label="Tỉnh/Thành phố" id="province">
                                                    <option value=""> -- Danh sách các tỉnh/thành phố --</option>
                                                    @foreach(\App\Entity\Province::getAllProvince() as $province)
                                                        <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                                                    @endforeach
                                                </select>

                                                <label class="f16 fw6 mgt15">Chọn tối đa 3 quận / huyện <i
                                                            style="color: red">(*)</i></label>
                                                <div class="search_province_district ">

                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="rs_video">
                                <h3>Video hướng dẫn đăng ký và tạo tài khoản trên sanketoan.vn</h3>
                                {!! isset($information['video-huong-dan-dang-ky']) ?  $information['video-huong-dan-dang-ky'] : ' <iframe width="100%" height="100%" src="https://www.youtube.com/embed/h-cE5diGutU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' !!}

                            </div>
                        </div>
                    </div>
                </div>

            </section>


        </div>
    </section>



    <style>
        .select2-selection__rendered {
            border: 1px solid green;
        }
    </style>

    <script>
        function limitCareerChoices() {
            var careerCheckboxes = $('.js_check_category_carrer_max_3');
            var checkedCareerCheckboxes = careerCheckboxes.filter(':checked');

            checkedCareerCheckboxes.slice(3).each(function () {
                $(this).iCheck('uncheck');
            }
            checkedCareerCheckboxes = careerCheckboxes.filter(':checked');

            careerCheckboxes.each(function () {
                if (this.checked || checkedCareerCheckboxes.length < 3) {
                    $(this).iCheck('enable');
                } else {
                    $(this).iCheck('disable');
                }
            });
        }

        $(document).on('ifChanged', '.js_check_category_carrer_max_3', function () {
            limitCareerChoices();
        });

        $(document).on('ifClicked', '.js_check_category_carrer_max_3', function () {
            var checkedCareerCount = $('.js_check_category_carrer_max_3').filter(function () {
                return $(this).parent().hasClass('checked');
            }).length;

            if (!$(this).parent().hasClass('checked') && checkedCareerCount >= 3) {
                var checkbox = this;
                setTimeout(function () {
                    $(checkbox).iCheck('uncheck');
                }, 0);
            }
        });

        $(document).ready(function () {
            limitCareerChoices();
        });

        $(document).on('ifChanged', '.js_check_category_carrer_max_2', function () {
            if ($('.js_check_category_carrer_max_2:checked').length > 3) {
                $(this).iCheck('uncheck');
            }
        });

        $(document).on('ifChanged', '.js_check_category_carrer_max_2', function () {
            if ($('.js_check_category_carrer_max_2:checked').length > 3) {
                $(this).iCheck('uncheck');
            }
        });

        $('#form_register').on('submit', function (event) {
            if ($('.js_check_category_carrer_max_3:checked').length > 3
                || $('.js_check_category_carrer_max_2:checked').length > 3) {
                event.preventDefault();
                alert('Bạn chỉ được chọn tối đa 3 mục.');
            }
        });
    </script>

    <script>
        function searchAjax(e) {
            var word = $(e).val();
            $('.search .bodySearch ').empty();
            return true;
        }

        $(document).ready(function () {
            $('#province').change(function () {
                $('.search_province_district').html('');
                $.ajax({
                    type: "get",
                    url: '/ajax-district_radio/' + $(this).val(),
                    data: {
                        province: $(this).val(),
                    },
                    success: function (result) {
                        $('.search_province_district').html('');
                        var obj = jQuery.parseJSON(result);
                        // $('.search .bodySearch ').empty();
                        $.each(obj.districts, function (index, element) {
                            var html = '<div class="form-group" style="width: 50%;display: inline-block">';
                            html += '<label class="answerRadio">';
                            html += '<input type="checkbox" id="' + element.district_id + '" name="district[]" value="' + element.district_id + '"class="flat-red resetchecked mgr5 js_check_category_carrer_max_2">';
                            html += element.district_name;
                            html += '</label>';
                            html += '</div>';

                            $('.search_province_district').append(html);

                        });
                    }
                });

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $.validator.addMethod('strictEmail', function (value, element) {
                return this.optional(element) || /^[^\s@.](?:[^\s@]*[^\s@.])?@(?:[A-Za-z0-9](?:[A-Za-z0-9-]*[A-Za-z0-9])?\.)+[A-Za-z]{2,}$/.test(value)
                    && !/\.\./.test(value);
            }, 'Vui lòng nhập một địa chỉ Email hợp lệ !');

            $('#js_check_email_create').click(function () {
                var email = $('#js_val_email').val().trim();
                if (!/^[^\s@.](?:[^\s@]*[^\s@.])?@(?:[A-Za-z0-9](?:[A-Za-z0-9-]*[A-Za-z0-9])?\.)+[A-Za-z]{2,}$/.test(email)
                    || /\.\./.test(email)) {
                    $('.alert_success_email').hide();
                    $('.alert_error_email').show().find('.alert_note_email').text('Vui lòng nhập một địa chỉ Email hợp lệ !');
                    return;
                }

                $.get('{{ route('check_email_employee') }}', {email: email})
                    .done(function (response) {
                        $('.alert_error_email').hide();
                        $('.alert_success_email').show().find('.alert_note_email').text(response.email || 'Email có thể sử dụng.');
                    })
                    .fail(function (xhr) {
                        $('.alert_success_email').hide();
                        $('.alert_error_email').show().find('.alert_note_email').text(
                            xhr.responseJSON && xhr.responseJSON.message
                                ? xhr.responseJSON.message
                                : 'Email đã tồn tại hoặc không thể sử dụng.'
                        );
                    });
            });

            $("#form_register").validate({
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
                        strictEmail: true
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
                    province: {
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
                        strictEmail: 'Vui lòng nhập một địa chỉ Email hợp lệ !'
                    },
                    phone: {
                        required: 'Số điện thoại phải là số và không được để trống.',
                        checkPhone: 'Số điện thoại không hợp lệ',
                    },
                    password: {
                        required: 'Vui lòng nhập vào mật khẩu.',
                        minlength: 'Mật khẩu tối thiểu 8 ký tự'
                    },
                    province: {
                        required: 'Vui lòng chọn tỉnh /thành phố.',
                    },
                },
                onfocusout: function (element) {
                    $(element).valid();
                },
                errorPlacement: function (error, element) {

                    var name = $(element).attr("name");
                    $('.alert_error_' + name).css('display', 'block');
                    $('.alert_success_' + name).css('display', 'none');
                    $('.alert_note_' + name).html(error.text());

                    $('.note_text_' + name).hide();
                    $('.error_text_' + name).html('<i class="error"><span class="error_reg_mess_icon"></span>' + error.text() + '</i>');
                    $('.error_border_' + name).css("cssText", "border: 1px solid #ff0000  !important;");
                    $('.btn-loading').button('reset');
                },
                success: function (label, element) {
                    var name = $(element).attr("name");
                    $('.alert_error_' + name).css('display', 'none');
                    $('.alert_success_' + name).css('display', 'block');
                    $('.alert_note_' + name).html('Bạn có thể tiếp tục đăng ký thông tin cho email này.');

                    $('.note_text_' + name).show();
                    $('.error_text_' + name).html('');
                    $('.error_border_' + name).css("cssText", "border: 1px solid #e0e0e0  !important;");
                    $('.js_btnRegidit').attr('disabled', false);

                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
            //tao jquery load button
            $('.js_btnRegidit').click(function () {

                if ($('#form_register').valid()) {
                    $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'ĐANG HOÀN TẤT ĐĂNG KÍ...');
                    $btn.attr('disabled', false);
                } else {
                }
            });

        });


    </script>
@endsection
@section('show_js')

@endsection
