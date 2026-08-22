@extends('site.layout_site.site')

@section('canonical',  route('apply_job',['slug'=>$job->slug]) )

@section('type_meta', 'website')

@section('title', 'Ứng tuyển ngay '.$job->title)
<?php
$district = \App\Entity\District::getId($job->district);
$province = \App\Entity\Province::getId($job->province);
$ca = \App\Entity\Career::getIdCareer($job->career_category_id);
$age = \App\Entity\Age::getIdAge($job->age_id);
$meta_description = 'Ứng tuyển ngay ' . $job->title;
if (!empty($province->province_name)) {
    $meta_description .= ' tại ' . $province->province_name;
}
if (!empty($district->district_name)) {
    $meta_description .= ' ' . $district->district_name;
}
if (!empty($ca->career_category_name)) {
    $meta_description .= ' với vị trí công việc ' . $ca->career_category_name;
}
if (!empty($job->salary_description)) {
    $meta_description .= ' với mức lương ' . $job->salary_description;
}
if (!empty($age)) {
    $meta_description .= ' và độ tuổi ' . $age->name_age;
}if (!empty($job->experience)) {
    $meta_description .= ' và kinh nghiệm ' . $job->experience;
} else {
    $meta_description .= ' và không yêu cầu kinh nghiệm';
}
$meta_description = ucwords($meta_description);
?>
@section('meta_description'){{ $meta_description }}@endsection

@section('keywords', $job->title)

@section('meta_image', !empty($job->employer_image) ?  asset($job->employer_image) : asset('assets/image/anh-vuong.jpg'))

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/tab_filter.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/detail_job.css"/>
@endsection

@section('content')
    <style>
        /*just bg and body style*/

        #top {
            margin-top: 20px;
        }

        .btn-container {
            background: #fff;
            border-radius: 5px;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .white {
            color: white;
        }

        /*these two are set to not display at start*/
        .imgupload.ok {
            display: none;
            color: green;
        }

        .imgupload.stop {
            display: none;
            color: red;
        }

        .file_upload {
            position: relative;
        }

        /*this sets the actual file input to overlay our button*/
        .fileup_js {
            opacity: 0;
            -moz-opacity: 0;
            filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0);
            width: 400px;
            height: 200px;
            cursor: pointer;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: -100px;
            background: red;
        }

        /*switch between input and not active input*/
        #submitbtn {
            padding: 10px 15px;
            display: none;
        }


        /*www.emilianocostanzo.com*/
        #sign {
            color: #1E2832;
            position: fixed;
            right: 10px;
            bottom: 10px;
            text-shadow: 0px 0px 0px #1E2832;
            transition: all .3s;
        }

        #sign:hover {
            color: #1E2832;
            text-shadow: 0px 0px 5px #1E2832;
        }

        .form_button {
            font-size: 14px;
            padding: 10px 15px;
            border: none;
            margin-top: -2px;
            border-radius: 0px;
        }

        .form_button_submit {
            font-size: 14px;
            padding: 10px 35px;
            background-color: #009385 !important;
            color: #fff !important;
            position: relative;
            z-index: 9;
        }

        .box_input_upload {
            background: #f5f7f9;
            border: 1px dashed #d3d6da;
            padding: 15px 0px;
            border-radius: 4px;
        }

        .lblUpload {
            font-style: normal;
            font-weight: bold;
            font-size: 16px;
            line-height: 20px;
            text-align: center;
            color: #f47421;
            text-decoration: underline;
        }

        .box_from_appply_now form label {
            font-weight: 600;
            font-size: 16px;
        }

        .error_reg_mess .error {
            color: red;
        }
    </style>

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row ">
                @include('site.sidebar_site.sidebar_job',['sidebar_jobs'=>'sidebar_jobs'])
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline">
                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('job_detail',['slug'=>$job->slug]) }}" class="">Việc làm</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class="">Ứng tuyển ngay</a>
                            </li>
                        </ul>
                    </div>

                    <div class="job_detail">
                        <div class="main">
                            <div class="box_job_detail">
                                <div class="bodyBox ">
                                    <div class="mgb10 box_job_detail_title">
                                        <div class="w90">
                                            <?php
                                            $date = date_create($job->deadline_submit_profile);
                                            $date_end = date_format($date, "d-m-Y");
                                            $today = date('d-m-Y');
                                            ?>
                                            @if(strtotime($today) > strtotime($date_end))
                                                <p class="clRed f16 fw6">
                                                    Công việc này đã hết hạn nộp hồ sơ rồi !
                                                </p>
                                            @else
                                            @endif
                                            <p class="mgb0 f16 clgray">Bạn đang ứng tuyển ngay cho vị trí công việc</p>
                                            <h1 class="title_job">{{$job->title}}</h1>
                                        </div>
                                    </div>
                                    <div class="box_from_appply_now">
                                        <hr>
                                        <form name="contact-form" id="form_register" enctype="multipart/form-data"
                                              action="{{ route('apply_job_now') }}" method="POST">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="hidden" value="{{ $job->job_id }}" name="job_id">
                                                    <input type="hidden" name="status_job" value="1">
                                                    {!! csrf_field() !!}
                                                    <div class="form-group app-label mgb0">
                                                        <label class="">Họ tên ứng viên <span class="clRed">(*)</span>
                                                        </label>
                                                        <input id="" name="name" type="text" value=""
                                                               class="form-control error_border_name"
                                                               placeholder="Nhập đầy đủ họ &amp; tên">
                                                        <div class="mess_notice_name clearfix note_text_name"></div>
                                                        <div class="error_reg_mess clearfix error_text_name"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <div class="form-group app-label mgb0">
                                                        <label class="">Email (đăng nhập) <span class="clRed">(*)</span>
                                                        </label>
                                                        <input id="" name="email" type="email" value=""
                                                               class="form-control error_border_email"
                                                               placeholder="Nhập email của bạn">
                                                        <div class="mess_notice_email clearfix note_text_email"></div>
                                                        <div class="error_reg_mess clearfix error_text_email"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group app-label mgb0">
                                                        <label class="">Số điện thoại <span class="clRed">(*)</span>
                                                        </label>
                                                        <input id="" name="phone" type="text" value=""
                                                               class="form-control error_border_phone"
                                                               placeholder="Nhập số điện thoại của bạn">
                                                        <div class="mess_notice_phone clearfix note_text_phone"></div>
                                                        <div class="error_reg_mess clearfix error_text_phone"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <div class="form-group app-label mgb0">
                                                        <label class="">Hồ sơ (CV) <span class="clRed">(*)</span>
                                                        </label>
                                                        <div class="box_input_upload error_border_file">
                                                            <div class="group-upload upload-area" id="uploadfile">
                                                            </div>
                                                            <div class="text-center">
                                                                <i class="fas fa-upload f24"></i>
                                                                <p class="text-upload mgb0 fw6">
                                                                    Tải lên hồ sơ của bạn
                                                                </p>
                                                                <i><span class="namefile_js"></span></i>
                                                                <i><span class="namesize_js"></span></i>
                                                                <p class="mgb0">Kéo thả tập tin CV của bạn vào đây để
                                                                    tải lên hoặc bấm
                                                                    <label for="uploadfile-apply" id="btnup"
                                                                           class="lblUpload">
                                                                        Upload
                                                                    </label>
                                                                </p>
                                                                <div class="file_upload">
                                                                    {{--<button type="button" id="btnup" class="btn-info form_button"><i--}}
                                                                    {{--class="fas fa-paperclip"></i> Tải CV đính kèm--}}
                                                                    {{--</button>--}}
                                                                    <input type="file" value="" accept="application/pdf"
                                                                           name="file" id="fileup" class="fileup_js"
                                                                           required>

                                                                </div>
                                                                (Định dạng: .pdf. Không vượt quá 10Mb)

                                                            </div>
                                                        </div>
                                                        <div class="mess_notice_file clearfix note_text_file"></div>
                                                        <div class="error_reg_mess clearfix error_text_file"></div>
                                                    </div>
                                                    <div class="group-uploaded d-none" id="uploadfiled">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <div class="form-group app-label mgb0">
                                                        <label class="">Giới thiệu
                                                        </label>
                                                        <textarea id="description" name="information_verifier" rows="4"
                                                                  class="form-control resume"
                                                                  placeholder="Mô tả ngắn gọn về bản thân (kỹ năng, kinh nghiệm làm việc...)"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <div class="form-group app-label mgb0">
                                                        <p class="mgb0"><i class="clRed">(Vui lòng tích chọn ' Tôi không phải người máy ' hoặc ' I'm not a robot ')</i></p>
                                                        <!-- Google reCaptcha -->
                                                        <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{{ env('RE_CAPTCHA_HTML')  }}"></div>
                                                        <div class="error error_g-captcha"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <div class="form-group error mgb0">
                                                        @if(!empty($errors->all()))
                                                            @foreach($errors->all() as $erorr)
                                                                <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12 mt-2">


                                                    <button type="submit" class="box_btn_submit_profile_cv f16"
                                                            id="js_btnRegidit"> Ứng Tuyển Nhanh
                                                    </button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('site.mobile_bottom_site.fixel_bottom_category_job')
    <div class="ctrl_nortification_success d-none">
        <span class="nortification success"><i class="fas fa-check-circle"></i> <span
                    class="nortification_content"></span></span>
    </div>
    <div class="ctrl_nortification_danger d-none">
        <span class="nortification danger"><i class="fas fa-times-circle"></i> <span
                    class="nortification_content"></span></span>
    </div>

@endsection
@section('show_js')
    <script type="text/javascript" src="/public/assets/js/sitebar.js"></script>
    <script src="/public/assets/js/jquery.validate.min.js"></script>
    @include('site.layout_site.from')
    <script>
        $('.fileup_js').change(function () {
//here we take the file extension and set an array of valid extensions
//             var res = $('.fileup_js').val();
            var res = $(this).val();
            var arr = res.split("\\");
            var filename = arr.slice(-1)[0];
            filextension = filename.split(".");
            filext = "." + filextension.slice(-1)[0];

            // alert(filename + '--------' + filext);
            valid = [".pdf"];
//if file is not valid we show the error icon, the red alert, and hide the submit button
            //this.files[0].size tinh bang = bytes 1m = 1 000 000 bytes giới hạn 10M 10000000
            var filesize = Math.floor(this.files[0].size / 1000) + 'KB';
            if (valid.indexOf(filext.toLowerCase()) == -1 || this.files[0].size >= 10000000) {
                $(".imgupload").hide("slow");
                $(".imgupload.ok").hide("slow");
                $(".imgupload.stop").show("slow");
                $(".name_file_cv").hide("slow");
                $("#submitbtn").hide();
                $("#fakebtn").show();
                //upload thất bại
                $('.namefile_js').css({"color": "red", "font-weight": 700});
                $('.namefile_js').html("File tải lên của bạn vượt quá dung lượng hoặc không dúng định dạng  PDF");
                $('#upload_cv_ok').modal('hide');
                $('#upload_cv_error').modal('show');
            } else {
                //if file is valid we show the green alert and show the valid submit
                $(".imgupload").hide("slow");
                $(".imgupload.stop").hide("slow");
                $(".imgupload.ok").show("slow");
                $(".name_file_cv").hide("slow");

                $("#submitbtn").show();
                $("#fakebtn").hide();
                //upload thành công
                $('.namefile_js').css({"color": "green", "font-weight": 700});
                $('.namesize_js').css({"color": "green", "font-weight": 700});
                $('.namefile_js').html(filename);
                $('.namesize_js').html('(' + filesize + ')');
                $('#upload_cv_error').modal('hide');
                $('#upload_cv_ok').modal('show');
            }
        });
        // $('.form_button_submit_js').click(function () {
        //     $('.form_submit_js').submit();
        // });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
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
                        checkEmail: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        number: true,
                        checkPhone: true,
                    }, file: {
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
                        checkEmail: 'Địa chỉ email đã tồn tại trên hệ thống ! Vui lòng nhập một địa chỉ email mới.',
                        email: 'Vui lòng nhập một địa chỉ Email hợp lệ !'
                        // checkEmail của jquery layout site
                    },
                    phone: {
                        required: 'Số điện thoại phải là số và không được để trống.',
                        checkPhone: 'Số điện thoại không hợp lệ',
                    }, file: {
                        required: 'Vui lòng chọn file CV'
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
                    $('#js_btnRegidit').attr('disabled', false);

                },
                submitHandler: function (form) {
                    form.submit();
                }
            });

        });
        //tao jquery load button
        $('#js_btnRegidit').click(function () {
            if ($('#form_register').valid()) {
                if (grecaptcha.getResponse() == ""){
                    $('.error_g-captcha').text("Vui lòng tích chọn ' Tôi không phải người máy ' hoặc ' I'm not a robot '");
                    $('.error_g-captcha').css('margin-bottom','5px');
                    return false;
                }
                else
                {
                    $('.error_g-captcha').text("");
                }
                $('#js_btnRegidit').html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang Gửi Ứng Tuyển Nhanh...');
                $btn.attr('disabled', false);
            } else {
            }
        });
    </script>


@endsection
