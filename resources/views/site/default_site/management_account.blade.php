@extends('site.layout_site.site')

@section('title', 'Quản lý tài khoản')
@section('meta_description', 'Quản lý tài khoản')
@section('keywords', 'Quản lý tài khoản')

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/employee_profile.css"/>
@endsection

@section('content')

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>--}}

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row ">
                @include('site.sidebar_site.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent createProfileOnline">

                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            @if(\Illuminate\Support\Facades\Auth::user()->role == 1)
                                <li class="nav-item pd8">
                                    <a href="{{ route('show_step_profile_employee') }}">Cập nhật hồ sơ</a>
                                </li>
                            @endif
                            @if(\Illuminate\Support\Facades\Auth::user()->role == 2)
                                <li class="nav-item pd8">
                                    <a href="{{ route('show_file_job_facebook') }}" >Cập nhật hồ sơ</a>
                                </li>
                            @endif
                        </ul>
                    </div>

                    @if(\Illuminate\Support\Facades\Auth::user()->role == 1)
                    <div class="InfoCompanyJob bgrWhite mgt20 pd20">
                        <div class="row step_center_block">
                            <div class="item_step">
                                <?php
                                //xác thực tài khoản
                                $check_status_email_account = '';
                                $check_status_email_account = \App\Entity\User::check_status_email_account(\Illuminate\Support\Facades\Auth::user()->id)
                                //status_email_account
                                ?>
                                @if(!empty($check_status_email_account))
                                    <a class="clgreen step_active_link_success" href="{{ route('management_account') }}">
                                        <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                                        <span class="clgreen f16"> Xác thực tài khoản</span>
                                    </a>
                                @else
                                    <a class="clorang step_active_link item_no_success" href="{{ route('management_account') }}">
                                        <span><i class="fas fa-check  step_icon "></i></span>
                                        <span class="clorang f16"> Xác thực tài khoản</span>
                                    </a>
                                @endif
                                <img class="next_step" src="{{ asset('assets/image/next.png') }}">
                            </div>

                            <div class="item_step">
                                <?php
                                //check ti le hoan thien tho so
                                $check_info_profile = '';
                                $check_info_profile = \App\Entity\Employee::check_info_profile(\Illuminate\Support\Facades\Auth::user()->id);
                                ?>
                                @if(!empty($check_info_profile))
                                    <a class="clgreen "
                                       href="{{ route('show_file_job_facebook') }}">
                                        <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                                        <span class="clgreen  f16"> Hoàn thiện hồ sơ</span>
                                    </a>
                                @else
                                    <a class="clorange item_no_success "
                                       href="{{ route('show_file_job_facebook') }}">

                                        <span><i class="fas fa-users step_icon"></i></span>
                                        <span class=" clorange f16"> Hoàn thiện hồ sơ</span>
                                    </a>
                                @endif

                                <img class="next_step" src="{{ asset('assets/image/next.png') }}">
                            </div>

                            <div class="item_step">
                                <?php
                                //xác thực tài khoản
                                $employee_id_cv = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
                                $check_cv_employee = '';
                                $check_cv_employee = \App\Entity\Cv_employee::check_cv_employee($employee_id_cv->employee_id);
                                ?>
                                @if(!empty($check_cv_employee))
                                    <a class="clgreen"
                                       href="{{ route('create_emplyee_cv') }}">
                                        <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                                        <span class=" clgreen f16"> Tạo CV</span>
                                    </a>
                                @else
                                    <a class="clorange item_no_success"
                                       href="{{ route('create_emplyee_cv') }}">

                                        <span><i class="fas fa-id-card step_icon"></i></span>
                                        <span class=" clorange f16"> Tạo CV</span>
                                    </a>
                                @endif

                                <img class="next_step" src="{{ asset('assets/image/next.png') }}">
                            </div>

                            <div class="item_step">

                                    <a class=" clgreen "
                                       href="{{ route('course_index') }}">
                                        <span> <i class="fab fa-discourse step_icon"></i></span>
                                        <span class=" clgreen f16">Khóa học sanketoan.vn</span>
                                    </a>


                            </div>

                        </div>
                    </div>
                    @endif

                    <div class="InfoCompanyJob bgrWhite mgt20 pd20">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="title mgb20">
                                    <h5 class="lt-f20  fw7 bdLeftBlueN5x pdl10 blueN mgb0 dsInline">
                                        Xác thực tài khoản
                                    </h5>
                                </div>
                                @if($user_confirm->status_email_account == 0)
                                <div class="mgt20 js_resetButton">
                                    <p class="f16 mgb0">
                                        Tài khoản của bạn chưa được xác thực ? Bạn vui lòng kiểm tra email <span class="clHome">({{ isset($user_confirm->email) ? $user_confirm->email : '' }})</span> đã đăng ký để xác thực tài khoản !
                                    </p>
                                    <a href="{{ route('confrirm_email') }}" class="sendConfirmEmail js_send_confirm_email mgt10" id="load2"
                                       style="border: none;display: inline-block;padding: 5px 15px;text-transform: inherit;"> Xác thực email</a>


                                </div>
                                    @else
                                    <div class="mgt20 js_resetButton">
                                        <p class="f16 mgb0">
                                            Tài khoản của bạn đã được xác thực !
                                        </p>

                                    </div>
                                @endif


                                <div class="mgt15">
                                    <a href="{{ route('show_step_profile_employee') }}" class="btnGreen"><i class="fas fa-long-arrow-alt-left"></i> Quay lại </a>
                                    <a href="{{ route('show_file_job_facebook') }}" class="btnGreen"> Tiếp tục <i class="fas fa-long-arrow-alt-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="InfoCompanyJob bgrWhite mgt20 pd20">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="title mgb20">
                                    <h5 class="lt-f20  fw7 bdLeftBlueN5x pdl10 blueN mgb0 dsInline">
                                        Thông tin tài khoản

                                    </h5>
                                </div>
                                <div class="mgt20 js_resetButton">
                                    <div class="box_info f16">
                                        <div class="list-items mb_4">
                                            <label>Email đăng ký : <span><strong>{{ isset($user_confirm->email) ? $user_confirm->email : '' }}</strong></span></label>
                                            <a class="btnOrange_small mgl5 js_toggle_changle_email bdr5"><i class="fas fa-pen"></i> Đổi Email</a>
                                        </div>

                                        <div id="" class="email-moi mt15 box_change_email js_box_change_email pd10 mgt10 mgb20 ">
                                            <form class="form_submit_loading" id="is_change_email" name="change_email"
                                                  method="post" action="{{ route('change_email_confirm') }}">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="f16 fw6">Vui lòng nhập email mới
                                                        <span class="red">(*)</span></label>
                                                    <input type="email" name="email" class="form-control error_border_email"
                                                           id="txt_email"
                                                           aria-describedby="emailHelp" placeholder="Nhập vào email của bạn"
                                                           value="{{ old('email') }}" required>

                                                    <div class="mess_notice_email clearfix note_text_email"></div>
                                                    <div class="error_reg_mess clearfix error_text_email"></div>
                                                    <i>Lưu ý : Khi bạn đổi lại email thì phải xác thực lại tài khoản</i>
                                                </div>
                                                <div class="form-group">
                                                    <!-- Google reCaptcha -->
                                                    <div class="g-recaptcha" id="feedback-recaptcha"
                                                         data-sitekey="{{ '6Le9trIUAAAAALrCbKEVd_fFCOjZm13bNMk9DmZP'  }}"></div>
                                                    <!-- End Google reCaptcha -->
                                                </div>

                                                <button id="btn_changeEmail" class="button_change_email">
                                                    Đổi Email
                                                </button>
                                            </form>
                                        </div>
                                        <div class="list-items mb_4">
                                            <label>Mật khẩu: : <span><strong>********</strong></span></label>
                                            <a href="{{ route('show_user_job_facebook') }}" class="btnOrange_small mgl5 bdr5">
                                                <i class="fas fa-pen"></i> Đổi mật khẩu
                                            </a>
                                        </div>




                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="InfoCompanyJob bgrWhite mgt20 pd20">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="title mgb20">
                                    <h5 class="lt-f20  fw7 bdLeftBlueN5x pdl10 blueN mgb0 dsInline">
                                        Thông tin cá nhân

                                    </h5>
                                </div>
                                @if(!empty($employee))
                                <div class="mgt20 js_resetButton">
                                    <div class="box_info f16">
                                        <div class="list-items mb_4">
                                            <label>Họ và tên : <span><strong>{{ isset($employee->employee_name) ? $employee->employee_name  : '' }}</strong></span></label>

                                        </div>
                                        <div class="list-items mb_4">
                                            <label>Email : <span><strong>{{ isset($employee->email) ? $employee->email  : '' }}</strong></span></label>

                                        </div>
                                        <div class="list-items mb_4">
                                            <label>Số điện thoại : <span><strong>{{ isset($employee->phone) ? $employee->phone  : '' }}</strong></span></label>

                                        </div>
                                        <div class="list-items mb_4">
                                            <label>Địa chỉ : <span><strong>{{ isset($employee->address) ? $employee->address  : '' }}</strong></span></label>

                                        </div>
                                    </div>

                                </div>
                                    @endif

                                @if(!empty($employer))
                                    <div class="mgt20 js_resetButton">
                                        <div class="box_info f16">
                                            <div class="list-items mb_4">
                                                <label>Tên công ty : <span><strong>{{ isset($employer->enterprise_name) ? $employer->enterprise_name  : '' }}</strong></span></label>

                                            </div>
                                            <div class="list-items mb_4">
                                                <label>Email : <span><strong>{{ isset($employer->email) ? $employer->email  : '' }}</strong></span></label>

                                            </div>
                                            <div class="list-items mb_4">
                                                <label>Số điện thoại : <span><strong>{{ isset($employer->phone) ? $employer->phone  : '' }}</strong></span></label>

                                            </div>
                                            <div class="list-items mb_4">
                                                <label>Địa chỉ : <span><strong>{{ isset($employer->address) ? $employer->address  : '' }}</strong></span></label>

                                            </div>
                                        </div>


                                    </div>
                                @endif


                                @if(!empty($teacher))
                                    <div class="mgt20 js_resetButton">
                                        <div class="box_info f16">
                                            <div class="list-items mb_4">
                                                <label>Họ và tên : <span><strong>{{ isset($teacher->teacher_name) ? $teacher->teacher_name  : '' }}</strong></span></label>

                                            </div>
                                            <div class="list-items mb_4">
                                                <label>Email : <span><strong>{{ isset($teacher->teacher_email) ? $teacher->teacher_email  : '' }}</strong></span></label>

                                            </div>
                                            <div class="list-items mb_4">
                                                <label>Số điện thoại : <span><strong>{{ isset($teacher->teacher_phone) ? $teacher->teacher_phone  : '' }}</strong></span></label>

                                            </div>
                                            <div class="list-items mb_4">
                                                <label>Địa chỉ : <span><strong>{{ isset($teacher->address) ? $teacher->address  : '' }}</strong></span></label>

                                            </div>
                                        </div>


                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @include('site.module_index_site.dang-ky-tu-van')


                </div>
            </div>
        </div>
    </section>


@endsection
@section('show_js')
    <script src="/assets/js/jquery.validate.min.js"></script>
<script>
    $('.js_box_change_email').hide();
    $(".js_toggle_changle_email").click(function () {
        $(".js_box_change_email").toggle(500);
    });
    $("#is_change_email").validate({
        ignore: [],
        onkeyup: false,
        rules: {
            email: {
                required: true,
                checkEmail: true,
                email: true
            },
        },
        messages: {
            email: {
                required: 'Vui lòng nhập địa chỉ Email.',
                checkEmail: 'Email đã tồn tại.',
                email: 'Vui lòng nhập một địa chỉ Email hợp lệ !'
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

    $('#btn_changeEmail').click(function() {
        if ($('#is_change_email').valid()) {
            $(this).html( '<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang đổi email...');
            $btn.attr('disabled', false);
        }
        else {
        }
    });

</script>
@endsection