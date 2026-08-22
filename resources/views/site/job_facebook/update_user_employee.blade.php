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

                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('show_step_profile_employee') }}" class=" f18 md-f14 mgb0">Cập nhật hồ sơ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Hoàn thiện hồ sơ</a>
                            </li>
                        </ul>
                    </div>
                @include('site.modum_sidebar.update_user_employee')
                </div>
            </div>
        </div>
    </section>
    <script>
        // chon thanh pho ra quan huyen

    </script>



@endsection