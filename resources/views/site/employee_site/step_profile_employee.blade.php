@extends('site.layout_site.site')
@section('title', 'Quản lý hồ sơ ứng viên')
@section('meta_description', 'Quản lý hồ sơ ứng viên')
@section('keywords', 'Quản lý hồ sơ ứng viên')

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/employee_profile.css"/>
@endsection


@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar_site.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent col-12 col-12">
                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('show_step_profile_employee') }}">Cập nhật hồ sơ</a>
                            </li>
                        </ul>
                    </div>

                    <section class="section_box_content mgt20 bgWhite">
                        <div class="header_box">
                            <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14 clWhite">
                                <i class="fas fa-pencil-alt mgr5"></i>Cập nhật hồ sơ
                            </div>
                        </div>
                        <div class="sc_maneger_profile pd15">
                            <p>Để thu hút Nhà Tuyển Dụng và giúp cho việc nộp đơn ứng tuyển dễ dàng. Hãy bắt đầu bằng
                                cách hoàn thành hồ sơ.Mỗi 1 điểm hồ sơ tương ứng với tỷ lệ hoàn thành hồ sơ của bạn</p>
                            <h5 class="lt-f20  fw7 bdLeftBlueN5x pdl10 blueN mgb0 dsInline">
                                Các bước tạo hồ sơ
                            </h5>

                            @if(session('suscess'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert"
                                     style="margin-top: 15px;width: 100%">
                                    <strong>{{ session('suscess') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if(session('erorr'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert"
                                     style="margin-top: 15px;width: 100%">
                                    <strong>{{ session('erorr') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <div class="row mgt15">
                                <div class="col-md-4">
                                    <p class="text-center clGreen">
                                        Điểm hồ sơ : {{ !empty($employee->profile) ? $employee->profile : '10' }} điểm
                                    </p>
                                    <p class="text-center">
                                        <i class="f12">
                                            Lưu ý : Điểm hồ sơ của bạn sẽ được cộng thêm nếu thông tin của bạn chính xác
                                            được xét duyệt bởi sanketoan.vn
                                        </i>
                                    </p>
                                    <img src="{{ asset('public/assets/image/resume-icon.png') }}"
                                         class="img-thumbnail mbds_none_500">

                                    @if($employee->status_employee == 1)
                                        <h4 class="text-success mgt10"><i class="fas fa-check-circle"></i>
                                            <i class="f16"> Hồ sơ của bạn đã được duyệt</i>
                                        </h4>
                                    @else
                                        <h4 class="text-danger mgt10"><i class="fas fa-times-circle"></i>
                                            <i class="f16">Hồ sơ của bạn chưa được duyệt</i>
                                        </h4>
                                    @endif

                                </div>
                                <div class="col-md-8 step_right_profile">

                                    @if(!empty($status_email_account))
                                        <span>
                                            <img src="{{ asset('assets/image/check_png.png') }}" width="45px">
                                        </span>
                                        <h4 class="clGreen dsInline"> Xác thực email đăng ký <span class="f12"> (+ 5 điểm hồ sơ)</span>
                                        </h4>
                                        <p class="mgt15">
                                            <span class="mgl5 clGreen"><i>(Đã xác thực)</i></span>
                                        </p>
                                    @else
                                        <span><i class="fas fa-check  step_icon"></i></span>
                                        <h4 class="clOrange dsInline"> Xác thực email đăng ký <span class="f12"> (+ 5 điểm hồ sơ)</span>
                                        </h4>
                                        <p class="mgt15">
                                            <a class="btnOrange" href="{{ route('management_account') }}">Bắt
                                                đầu</a> <span class="mgl5 clRed"><i>(Chưa xác thực)</i></span>
                                        </p>
                                    @endif

                                    <hr>

                                        <?php
                                        $profile_info_account = !empty($status_email_account) ? 5  : 0;
                                        ?>
                                    @if(($employee_profile->profile_info - $profile_info_account) == 15)
                                        <span>
                                            <img src="{{ asset('assets/image/check_png.png') }}" width="45px">
                                        </span>
                                        <h4 class=" clGreen dsInline">Hoàn thiện hồ sơ
                                            <span class="f12">( + 15 điểm hồ sơ )</span>
                                        </h4>
                                        <p class="mgt15">
                                            <a class="btnOrange" href="{{ route('show_file_job_facebook') }}">
                                                Bắt đầu
                                            </a>
                                        </p>

                                    @else
                                        <span><i class="fas fa-users step_icon"></i></span>
                                        <h4 class=" clOrange dsInline">
                                            Hoàn thiện hồ sơ
                                            <span class="f12">( + 15 điểm hồ sơ )</span>
                                        </h4>
                                        <p class="mgt15">
                                            <a class="btnOrange" href="{{ route('show_file_job_facebook') }}">
                                                Bắt đầu
                                            </a>
                                            <span class="mgl5 clRed">
                                                <i>
                                                    (Mới hoàn thiện
                                                    ({{ !empty($employee_profile->profile_info - $profile_info_account) ? $employee_profile->profile_info - $profile_info_account : '10' }} điểm)
                                                </i>
                                            </span>
                                        </p>
                                    @endif

                                    <hr>

                                    @if(!empty($check_cv))
                                        <span>
                                             <img src="{{ asset('assets/image/check_png.png') }}" width="45px">
                                        </span>
                                        <h4 class="clGreen  dsInline">
                                            Tạo CV <span class="f12 clGreen"> (+ 40  điểm hồ sơ )</span>
                                        </h4>
                                    @else
                                        <span><i class="fas fa-id-card step_icon"></i></span>
                                        <h4 class="dsInline clOrange">
                                            Tạo CV <span class="f12"> (+ 40  điểm hồ sơ )</span>
                                        </h4>

                                    @endif

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p class="mgt15">
                                                <a class="btnOrange" href="{{ route('create_emplyee_cv') }}">
                                                    Tạo CV
                                                </a>
                                                @if(!empty($check_cv))
                                                    <span class="mgl5 clGreen">
                                                        <i>(Đã tạo CV)</i>
                                                    </span>
                                                @else
                                                    <span class="mgl5 clRed">
                                                        <i>(Chưa tạo CV)</i>
                                                    </span>

                                                @endif
                                            </p>
                                            <i class="f12">Hồ sơ sẽ được duyệt tự động (nếu bạn tạo hồ sơ)</i>
                                            @if(($employee_profile->profile_info - 5) < 15)
                                            </br>
                                            <i class="f12 clRed">Vui lòng hoàn thiện hồ sơ trước mới được tạo cv</i>
                                            @endif

                                        </div>
                                        <div class="col-lg-6">
                                            <p class="mgt15">
                                                <a class="btnOrange" href="{{ route('view_emplyee_cv') }}">
                                                    Tải CV
                                                </a>
                                                @if(!empty($check_file_cv))
                                                    <span class="mgl5 clGreen">
                                                        <i>(Đã tải CV)</i>
                                                    </span>
                                                @else
                                                    <span class="mgl5 clRed">
                                                        <i>(Chưa tải CV)</i>
                                                    </span>
                                                @endif
                                            </p>
                                            <i class="f12">Hồ sơ sẽ được duyệt trong vòng 24h (nếu bạn tải CV)</i>
                                        </div>
                                    </div>
                                    <hr>

                                    @if(!empty($check_course ))
                                        <span>
                                             <img src="{{ asset('assets/image/check_png.png') }}" width="45px">
                                         </span>
                                        <h4 class="clGreen  dsInline">
                                            Khóa học <span class="f12 clGreen"> (+ 10  điểm hồ sơ )</span>
                                        </h4>
                                        <p class="mgt15">
                                            <a class="btnOrange" href="{{ route('course_index') }}">
                                                Bắt đầu</a>
                                        </p>
                                    @else
                                        <span>
                                              <i class="fab fa-discourse step_icon"></i>
                                             </span>
                                        <h4 class=" clOrange dsInline">
                                            Chứng chỉ học của sanketoan.vn <span class="f12"> (+ 10  điểm hồ sơ )</span>
                                        </h4>
                                        <p class="mgt15">
                                            <a class="btnOrange" href="{{ route('course_index') }}">
                                                Bắt đầu</a>
                                            <span class="mgl5 clRed"><i>(Chưa đăng ký khóa học nào)</i></span>
                                        </p>
                                    @endif

                                    <hr>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="rs_video">
                            <h3>Video hướng dẫn đăng ký và tạo tài khoản trên sanketoan.vn</h3>
                            {!! isset($information['video-huong-dan-dang-ky']) ?  $information['video-huong-dan-dang-ky'] : ' <iframe width="100%" height="100%" src="https://www.youtube.com/embed/h-cE5diGutU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' !!}

                        </div>
                    </section>


                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <a class="" href="{{ route('create_emplyee_cv') }}">
                            <img src="{{ asset('assets/image/bg_cv2.jpg') }}" style="border: 1px solid orange">
                        </a>
                    </section>


                </div>
            </div>
        </div>
    </section>
    <script>
        // chon thanh pho ra quan huyen

    </script>

@endsection
@section('show_js')
@endsection