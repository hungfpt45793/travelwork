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
                                <p>
                                    Mã kích hoạt của tài khoản không đúng , Vui lòng kiểm tra lại email kích hoạt tài
                                    khoản mới nhất !
                                </p>
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