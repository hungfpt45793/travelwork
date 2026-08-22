
@extends('site.layout.site')

@section('title', 'Lỗi 404')
@section('meta_description', 'Lỗi 404')
@section('keywords', 'Lỗi 404')

@section('content')

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row ">
                @include('site.sidebar.sidebar_job',['sidebar_jobs'=>'sidebar_jobs'])
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
                                <a href="#" class=" f18 md-f14 mgb0">Lỗi 404</a>
                            </li>
                        </ul>
                    </div>

                    <div class="List_cateegory_tag">
                        <div class="main">
                            <div class="notificationBox bkwhite formJobLarge sm-f14">
                                <div class="bodyBox">
                                    <div class="row">
                                        <div class="col-12">
                                            <h1 class="f22 fw6 clhome mgb20">Lỗi 404 . Không tìm thấy trang</h1>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    @include('site.module_index.dang-ky-tu-van')
                </div>





            </div>
        </div>
        @include('site.module_index.hotline')
        </div>
    </section>

@endsection
