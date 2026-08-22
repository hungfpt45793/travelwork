@extends('site.layout.site')

@section('title', 'Kích hoạt tài khoản')
@section('meta_description', 'Kích hoạt tài khoản')
@section('keywords', 'Kích hoạt tài khoản')

@section('content')
    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row ">

                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline">
                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Kích hoạt tài khoản</a>
                            </li>
                        </ul>
                    </div>

                    <div class="InfoCompanyJob bgrWhite mgt20 pd10">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="titleConfirm text-center">
                                    <h1 class="f24 clhome text-uppercase fw6 mgt20">Xác thực email thành công</h1>
                                </div>
                                @if(!empty($user_link_active))
                                <div class="contentConfirm">
                                    <p>
                                        Xin chào ,<span class="fw6 f16"> {{ isset($user_link_active->name) ? $user_link_active->name : '' }} </span>
                                    </p>
                                    <p class="mgb10">
                                        Tài khoản đã được xác thực trên <a href="/">sanketoan.vn</a>
                                    </p>
                                    <p class="mgb10">
                                        Tài khoản của bạn kích hoạt bởi email : <span class="fw6"> {{ isset($user_link_active->email) ? $user_link_active->email : '' }} </span>
                                    </p>

                                </div>
                                @else
                                    <p>
                                       Tài khoản này của bạn đã được xác thực ! Bạn có thể đăng nhập bằng email bạn vừa xác thực để sử dụng chức năng của sanketoan.vn
                                    </p>
                                    @endif
                                @if (! \Illuminate\Support\Facades\Auth::check())
                                <div class="mgb20"><a class="btn bgrBlueN white" data-toggle="modal" data-target="#loginTiva" style="color: white">Bạn có thể đăng nhập tài khoản  tại đây !</a></div>
                                    @endif

                                <div class="">
                                    <a href="{{ route('show_step_profile_employee') }}" class="link_back"><i class="fas fa-long-arrow-alt-left"></i> Quay lại </a>
                                    <a href="{{ route('show_file_job_facebook') }}" class="link_back"> Tiếp tục <i class="fas fa-long-arrow-alt-right"></i></a>
                                </div>


                                </div>

                            </div>
                        </div>
                    </div>




                </div>
            @include('site.module_index.dang-ky-tu-van')
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>
@endsection