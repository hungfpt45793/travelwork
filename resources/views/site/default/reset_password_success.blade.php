@extends('site.layout.site')

@section('type_meta', 'Quên mật khẩu')
@section('title','Quên mật khẩu')
@section('meta_description','Quên mật khẩu' )

@section('content')
    <section class="PagesNewsContent bkxam pdb20 pdt20">
        <div class="container pd0 ">
            <div class="link bgrWhite mgb20">
                <ul class="nav">
                    <li class="nav-item pd8">
                        <a href="#" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                    </li>
                    <li class="nav-item pd8">
                        <p class="mgb0 md-f13 md-mgt2 blueDN clorange"><i class="fas fa-chevron-right"></i></p>
                    </li>
                    <li class="nav-item pd8">
                        <p class=" f18 md-f14 mgb0 clorange ">Quên mật khẩu</p>
                    </li>

                </ul>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="bgrWhite" style="padding: 20px;">
                        <h1 class="title_contact f24" style="margin-bottom: 15px;">Quên mật khẩu</h1>
                        <div class="contact-info ">
                            @if (session('success'))
                                <span class="help-block">
                                <strong> {{ session('success') }}</strong>
                            </span>
                            @endif
                                <p style="color: red;display: inline-block;text-align: center;font-size: 20px;font-weight: 700">Bạn đã kích hoạt mật khẩu mới thành công !</p>
                        </div><!--end: .contact-info-->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

