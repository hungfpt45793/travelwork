@extends('site.layout.site')

@section('title', 'Quản lý hồ sơ ứng viên')
@section('meta_description', 'Quản lý hồ sơ ứng viên')
@section('keywords', 'Quản lý hồ sơ ứng viên')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                <script>
                    // location.reload();
                </script>
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent col-12 col-12">
                    <div class="link bgrWhite md-mgt20">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Cập nhật hồ sơ</a>
                            </li>

                        </ul>
                    </div>
                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14">
                            <i class="fas fa-pencil-alt mgr5"></i>Cập nhật hồ sơ
                        </div>
                        <div class="bgrWhite pd15">
                            <p>Để thu hút Nhà Tuyển Dụng và giúp cho việc nộp đơn ứng tuyển dễ dàng. Hãy bắt đầu bằng
                                cách hoàn thành hồ sơ.Mỗi 1 điểm hồ sơ tương ứng với tỷ lệ hoàn thành hồ sơ của bạn</p>
                            <h5 class="lt-f20  fw7 bdLeftBlueN5x pdl10 blueN mgb0 dsInline">
                                Các bước tạo hồ sơ
                            </h5>
                            <div class="row mgt15">
                                <div class="col-md-4">
                                    {{-- <p class="text-center clred"> điểm hồ sơ : 20  điểm</p>
                                    <img data-src="{{ asset('assets/image/resume-icon.png') }}" class="img-thumbnail"> --}}
                                    <?php
                                    $id = \Illuminate\Support\Facades\Auth::user()->id;
                                    $employee_profile = \App\Entity\Employee::get_profile($id);
                                    ?>
                                    <p class="text-center clred">Điểm hồ sơ
                                        : {{ !empty($employee_profile->profile) ? $employee_profile->profile : '20' }}
                                        điểm</p>
                                    <img src="{{ asset('assets/image/resume-icon.png') }}"
                                         class="img-thumbnail mbds_none_500">


                                    @if($status_employee == 1)
                                        <h4 class="text-success mgt10"><i class="fas fa-check-circle"></i> Hồ sơ của bạn đã
                                            được duyệt</h4>
                                    @else
                                        <h4 class="text-danger mgt10"><i class="fas fa-times-circle"></i> Hồ sơ của bạn chưa
                                            được duyệt</h4>
                                    @endif

                                </div>
                                <div class="col-md-8 step_right_profile">

                                    <?php
                                    //xác thực tài khoản
                                    $check_status_email_account = '';
                                    $check_status_email_account = \App\Entity\User::check_status_email_account(\Illuminate\Support\Facades\Auth::user()->id)
                                    //status_email_account
                                    ?>
                                    @if(!empty($check_status_email_account))
                                        <span>
                                            <img src="{{ asset('assets/image/check_png.png') }}" width="45px">
                                            {{--<i class="fas fa-check   step_icon_success  "></i>--}}
                                        </span>
                                        <h4 class="clgreen dsInline"> Xác thực thông tin tài khoản <span class="f12"> (+ 5 điểm hồ sơ)</span>
                                        </h4>
                                        <p class="mgt15">
                                            <span class="mgl5 clgreen"><i>(Đã xác thực)</i></span>
                                        </p>
                                    @else
                                        <span><i class="fas fa-check  step_icon "></i></span>
                                        <h4 class="clorange dsInline"> Xác thực thông tin tài khoản <span class="f12"> (+ 5 điểm hồ sơ)</span>
                                        </h4>
                                        <p class="mgt15">
                                            <a class="btn bgorang clwhite" href="{{ route('management_account') }}">Bắt
                                                đầu</a> <span class="mgl5 clred"><i>(Chưa xác thực)</i></span>
                                        </p>
                                    @endif

                                    <hr>


                                    @if(!empty($employee_profile->profile))
                                        <span>
                                            <img src="{{ asset('assets/image/check_png.png') }}" width="45px">
                                            {{--<i class="fas fa-check   step_icon_success  "></i>--}}
                                        </span>
                                        <h4 class=" clgreen dsInline">Hoàn thiện hồ sơ <span
                                                    class="f12">( + 15 điểm hồ sơ )</span></h4>
                                        <p class="mgt15"><a class="btn bgorang clwhite"
                                                            href="{{ route('show_file_job_facebook') }}">Bắt
                                                đầu</a></p>

                                    @else

                                        <span><i class="fas fa-users step_icon"></i></span>
                                        <h4 class=" clorange dsInline">Hoàn thiện hồ sơ <span
                                                    class="f12">( + 18 điểm hồ sơ )</span></h4>
                                        <p class="mgt15"><a class="btn bgorang clwhite"
                                                            href="{{ route('show_file_job_facebook') }}">Bắt
                                                đầu</a> <span class="mgl5 clred"><i>(Mới hoàn thiện ({{ !empty($employee_profile->profile) ? $employee_profile->profile : '20' }} điểm)</i></span>
                                        </p>
                                    @endif

                                    <hr>
                                    <?php
                                    //cv ung vien
                                    $employee_id_cv = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
                                    $check_cv_employee = '';
                                    $check_cv_employee = \App\Entity\Cv_employee::check_cv_employee($employee_id_cv->employee_id);
                                    $link_file_cv =  \App\Entity\Employee_upload_cv::employee_link_cv($employee_id_cv->employee_id);
                                    ?>

                                    @if(!empty($check_cv_employee))
                                        <span>
                                             <img src="{{ asset('assets/image/check_png.png') }}" width="45px">
                                        </span>
                                        <h4 class="clgreen  dsInline">Tạo CV <span class="f12 clgreen"> (+ 40  điểm hồ sơ )</span>
                                        </h4>
                                    @else
                                        <span><i class="fas fa-id-card step_icon"></i></span>
                                        <h4 class="dsInline">Tạo CV <span class="f12"> (+ 40  điểm hồ sơ )</span></h4>

                                    @endif



                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p class="mgt15">
                                                <a class="btn bgorang clwhite" href="{{ route('create_emplyee_cv') }}">
                                                    Tạo CV
                                                </a>
                                                @if(!empty($check_cv_employee))
                                                    <span class="mgl5 clgreen">
                                                        <i>(Đã tạo CV)</i>
                                                    </span>
                                                @else
                                                    <span class="mgl5 clred">
                                                        <i>(Chưa tạo CV)</i>
                                                    </span>
                                                @endif
                                            </p>
                                            <i>Hồ sơ sẽ được duyệt tự động (nếu bạn tạo hồ sơ)</i>

                                        </div>
                                        <div class="col-lg-6">
                                            <p class="mgt15">
                                                <a class="btn bgorang clwhite" href="{{ route('view_emplyee_cv') }}">
                                                    Tải CV
                                                </a>
                                                @if(!empty($link_file_cv))
                                                    <span class="mgl5 clgreen">
                                                        <i>(Đã tải CV)</i>
                                                    </span>
                                                @else
                                                    <span class="mgl5 clred">
                                                        <i>(Chưa tải CV)</i>
                                                    </span>
                                                @endif
                                            </p>
                                            <i>Hồ sơ sẽ được duyệt trong vòng 24h (nếu bạn tải CV)</i>
                                        </div>
                                    </div>

                                    <hr>
                                    <span><i class="fas fa-info step_icon"></i></span>
                                    <h4 class=" clorange dsInline">Chứng chỉ học của sanketoan.vn <span
                                                class="f12"> (+ 10  điểm hồ sơ )</span></h4>
                                    <p class="mgt15">
                                        <a class="btn bgorang clwhite"
                                           href="{{ route('course_index') }}">Bắt
                                            đầu</a> <span class="mgl5 clred"><i>(Chưa đăng ký khóa học nào)</i></span>
                                    </p>

                                    <hr>
                                </div>
                            </div>
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