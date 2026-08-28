@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', !empty($meta_employee->meta_title) ? $meta_employee->meta_title :'Tải CV ứng viên')
@section('meta_description', !empty($meta_employee->meta_description) ? $meta_employee->meta_description :'Tải CV ứng viên')
@section('keywords', !empty($meta_employee->meta_keywords) ? $meta_employee->meta_keywords :'Tải CV ứng viên')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : ''  )

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/css/nortification.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/employee_profile.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/upload_employee_cv.css"/>
@endsection
@section('content')
    <style>
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
    <div class="InfoCompanyJob bgrWhite  pd20" style="border-bottom: 1px solid #ccc">

        <div class="row step_center_block">
            <div class="item_step">
            <?php
            //xác thực tài khoản
            $check_status_email_account = '';
            $check_status_email_account = \App\Entity\User::check_status_email_account(\Illuminate\Support\Facades\Auth::user()->id)
            //status_email_account
            ?>
            @if(!empty($check_status_email_account))
                <!-- <a class="clgreen " href="#" data-toggle="modal" data-target="#step_status_acoount">
                        <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                        <span class="clgreen f16"> Xác thực tài khoản</span>
                    </a> -->
                    <a class="clgreen " href="{{ route('management_account') }}">
                        <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                        <span class="clgreen f16"> Xác thực tài khoản</span>
                    </a>
            @else
                <!-- <a class="clorang  item_no_success" href="#" data-toggle="modal" data-target="#step_status_acoount">
                        <span><i class="fas fa-check  step_icon "></i></span>
                        <span class="clorang f16"> Xác thực tài khoản</span>
                    </a> -->
                    <a class="clorang  item_no_success" href="{{ route('management_account') }}">
                        <span><i class="fas fa-check  step_icon "></i></span>
                        <span class="clorang f16"> Xác thực tài khoản</span>
                    </a>
                @endif
                <img class="next_step" src="{{ asset('assets/image/next.png') }}">
                <div class="modal fade" id="step_status_acoount" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Xác thực tài khoản</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <a>Lưu ý : Nếu bạn thay đổi thông tin CV thì bạn vui lòng lưu CV trước khi quay lại bước
                                    xác thực tài khoản</a>
                            </div>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-secondary" data-dismiss="modal"
                                   style="    padding: .375rem .75rem;;color: #fff">Đóng</a>
                                <a type="button" class="btn btn-primary" href="{{ route('management_account') }}"
                                   style="    padding: .375rem .75rem;">Quay lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="item_step">
            <?php
            //check ti le hoan thien tho so
            $check_info_profile = '';
            $check_info_profile = \App\Entity\Employee::check_info_profile(\Illuminate\Support\Facades\Auth::user()->id);
            ?>
            @if(!empty($check_info_profile))
                <!-- <a class="clgreen" href="#" data-toggle="modal" data-target="#step_update_profile">
                        <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                        <span class="clgreen  f16"> Hoàn thiện hồ sơ</span>
                    </a> -->
                    <a class="clgreen" href="{{ route('show_file_job_facebook') }}">
                        <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                        <span class="clgreen  f16"> Hoàn thiện hồ sơ</span>
                    </a>
            @else
                <!-- <a class="clorange " href="#" data-toggle="modal" data-target="#step_update_profile">

                        <span><i class="fas fa-users step_icon"></i></span>
                        <span class=" clorange f16"> Hoàn thiện hồ sơ</span>
                    </a> -->
                    <a class="clorange" href="{{ route('show_file_job_facebook') }}">
                        <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                        <span class="clorange  f16"> Hoàn thiện hồ sơ</span>
                    </a>
                @endif

                <img class="next_step" src="{{ asset('assets/image/next.png') }}">
                <div class="modal fade" id="step_update_profile" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Hoàn thiện hồ sơ</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <a>Lưu ý : Nếu bạn thay đổi thông tin CV thì bạn vui lòng lưu CV trước khi quay lại bước
                                    hoàn thiện hồ sơ</a>
                            </div>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-secondary" data-dismiss="modal"
                                   style="    padding: .375rem .75rem;;color: #fff">Đóng</a>
                                <a type="button" class="btn btn-primary" href="{{ route('show_file_job_facebook') }}"
                                   style="    padding: .375rem .75rem;">Quay lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="item_step">
                <?php
                //xác thực tài khoản
                $employee_id_cv = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
                $check_cv_employee = '';
                $check_cv_employee = \App\Entity\Cv_employee::check_cv_employee($employee_id_cv->employee_id);
                ?>
                @if(!empty($check_cv_employee))
                    <a class="clgreen step_active_link_success">
                        <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                        <span class=" clgreen f16"> Tạo CV</span>
                    </a>
                @else
                    <a class="clorange step_active_link item_no_success">
                        <span><i class="fas fa-id-card step_icon"></i></span>
                        <span class=" clorange f16"> Tạo CV</span>
                    </a>
                @endif

                <img class="next_step" src="{{ asset('assets/image/next.png') }}">
            </div>


            <div class="item_step">
                <!-- <a class=" clgreen " href="#" data-toggle="modal" data-target="#step_syll">
                    <span> <i class="fab fa-discourse step_icon"></i></span>
                    <span class=" clgreen f16">Khóa học sandev</span>
                </a> -->
                <a class="clgreen" href="{{ route('course_index') }}">
                    <span> <i class="fab fa-discourse step_icon"></i></span>
                    <span class=" clgreen f16">Khóa học sanketoan</span>
                </a>
                <div class="modal fade" id="step_syll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Khóa học của sandev.vn</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <a>Lưu ý : Nếu bạn thay đổi thông tin CV thì bạn vui lòng lưu CV trước khi chuyển sang
                                    bước tiếp theo</a>
                            </div>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-secondary" data-dismiss="modal"
                                   style="padding: .375rem .75rem;;color: #fff">Đóng</a>
                                <a type="button" class="btn btn-primary" href="{{ route('course_index') }}"
                                   style="    padding: .375rem .75rem;">Tiếp tục</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>

    <section class="section_box_content mgt20 bgWhite" style="border: none">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-md-12">
                    <div class="header_box">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14 clWhite"><i
                                    class="fas fa-pencil-alt mgr5"></i>Cập nhật hồ sơ
                        </div>


                    </div>
                    <div class="sc_maneger_profile pd15">
                        <h5 class="lt-f20  fw7 bdLeftBlueN5x pdl10 blueN mgb0 dsInline"> CV của ứng viên </h5>


                        @if(session('suscess'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert"
                                 style="margin-top: 15px;width: 100%">
                                <strong>{{ session('suscess') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert"
                                 style="margin-top: 15px;width: 100%">
                                <strong>{{ session('error') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="box_from_appply_now">
                            <hr>
                            <form name="contact-form" id="form_register" enctype="multipart/form-data"
                                  action="{{ route('ajax_upload_emplyee_cv') }}" method="POST">
                                {!! csrf_field() !!}
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group app-label mgb0">
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
                                    <div class="col-lg-12 mt-2 text-center">


                                        <button type="submit" class="box_btn_submit_profile_cv f16 btn-info form_button"
                                                id="js_btnRegidit"> Lưu CV
                                        </button>

                                    </div>
                                </div>
                            </form>

                            <div style="width: 100%" class="cv_affter_upload text-center">
                                @if(!empty($employee_cv->employee_link_cv))
                                    <?php
                                    $link_cv_upload_public = str_replace('/public', '', $employee_cv->employee_link_cv);
                                    $link_cv_upload = asset($link_cv_upload_public);
                                    ?>
                                    @if(file_exists(public_path($link_cv_upload_public)))
                                        <p class="text-center mgb0 mgt10" style="color: green">File CV bạn được upload trước đó</p>
                                        <a target="_blank" href="{{ $link_cv_upload_public }}"
                                           class="pd10 radius5 white noDecoration hvWhite bgrDownload mgt10 dsInline js_add_upload_href"
                                           style="background-color: orange;margin-top: 6px;padding: 6px 10px;vertical-align: text-bottom;color: #fff"
                                           id="dowloadVoucher"><i class="fas fa-cloud-download-alt"></i> Xem cv đã upload</a>
                                        {{--<embed style="width: 100%;height: 550px"--}}
                                        {{--src="{{ $link_cv_upload }}#toolbar=0&view=fitH"--}}
                                        {{--type="application/pdf"/>--}}
                                    @else
                                        <p class="text-center" style="color: red">File CV Chưa được upload</p>
                                    @endif
                                @else
                                    <p class="text-center" style="color: red">File CV Chưa được upload</p>
                                @endif

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@section('show_js')
    <script type="text/javascript" src="/assets/js/sitebar.js"></script>
    <script src="/assets/js/jquery.validate.min.js"></script>
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
                    file: {
                        required: true,
                    },
                },
                messages: {
                   file: {
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
                $('#js_btnRegidit').html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang Lưu CV...');
                $btn.attr('disabled', false);
            } else {
            }
        });
    </script>


@endsection
