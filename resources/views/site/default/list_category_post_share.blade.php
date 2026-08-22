@extends('site.layout.site')

@section('title','Danh mục chia sẻ')
@section('meta_description', 'Danh mục chia sẻ')
@section('keywords',  'Danh mục chia sẻ')

@section('content')
    <section class="content " style="background:#eeeeee;padding-top:20px; ">
        <div class="container">
            <div class="row ">
                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20 mgb10">
                        <ul class="nav">
                            <li class="nav-item pd8">

                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <?php
                                $link_url ='#';
                                $link_url = \App\Ultility\Ultility::getUrl();
                                ?>
                                <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> <i class="fas fa-users mgr5"></i>Danh mục tốp chia sẻ</a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="col-xl-12 col-lg-12 col-md-12 JobSeeker">
                    <div class="main">
                        <div class="notificationBox">
                            <h1 class="blueN textUpper fw7 bdLeftBlueN5x pdl10 f20">
                                Danh mục Tốp chia sẻ
                            </h1>
                            <hr>

                            <ul class="nav justify-content-center">
                                <li class="nav-item">
                                    <a class="nav-link textUpper bgrBlueN white hvWhite fw5 pd15" href="{{route('list_post_share')}}"><i class="fas fa-share f18"></i> Tốp bài viết chia sẻ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link textUpper bgrBlueN white hvWhite fw5 pd15 mgl20 mgr20" href="{{route('list_job_share')}}"> <i class="fas fa-share f18"></i> Tốp tin tuyển dụng chia sẻ</a>
                                </li>
                            </ul>
                            <hr>
                        </div>

                    </div>

                    <section class="Support bgrWhite pd40 mgt30 mgb30">
                        <div class="notificationBox formJobLarge mt30" style="background: #f6eecc">
                            <div class="">
                                <p
                                        class="supportTitle text-center fontBold f23 lg-f25 blueDN pdt0 mgb20 lg-mgb10 lg-f23 md-f17 sm-f16">
                                    TỔNG ĐÀI TƯ VẤN <span class="sm-block">CHĂM SÓC KHÁCH HÀNG</span></p>
                            </div>
                            <div class="row">
                                @foreach(\App\Entity\SubPost::showSubPost('hotline', 3) as $id => $hotline)
                                    <div class="col-lg-4 col-md-4 text-center">
                                        <span class="lg-f16 md-f14">{{$hotline->title}}:</span> <span class="red fw7 f30 lg-f23 md-f15">&nbsp;{{$hotline->description}}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </section>
    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <button type="button" class="close" data-dismiss="modal" style="position:absolute;right:10px;z-index:999;top:5px;">&times;</button>
                <div class="col-xl-12 col-lg-12 col-md-12 JobSeeker EmployerRegistration mgb20 pd15-0">
                    <div class="main">
                        <form onSubmit="return contact(this);" class="wpcf7-form dangkiform" id="contact_form" method="post" action="{{route('sub_contact')}} ">
                            {!! csrf_field() !!}
                            <input type="hidden" name="is_json" <div class="notificationBox mgt30">
                                <p class="text-title font15Im mgt0Im">
                                    đăng ký nhận tư vấn
                                </p>
                                <hr>
                                <div class="bodyBox">
                                    <div class="accountInfo">
                                        <div class="form-group row">
                                            <label class="col-12 text-left lable">Họ và tên<span>*</span> </label>
                                            <div class="col-12">
                                                <input type="text" name="name" class="form-control" placeholder="Họ và tên">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-12 text-left lable">Email<span>*</span>
                                            </label>
                                            <div class="col-12">
                                                <input type="text" id="location-input" name="email" class="form-control" placeholder="Email">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-12 text-left lable">Số điện thoại<span>*</span> </label>
                                            <div class="col-12">
                                                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-12 text-left lable">Địa chỉ<span>*</span> </label>
                                            <div class="col-12">
                                                <input type="text" name="address" class="form-control" placeholder="Địa chỉ">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-12 text-left lable">Lời nhắn </label>
                                            <div class="col-12">
                                                <textarea class="form-control" name="message" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-12 text-ct">
                                                <button type="submit" class="btn">ĐĂNG KÝ</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <style>
                            .error label {
                                background: #ef5050;
                                color: #fff;
                                padding: 5px;
                                margin-right: 5px;
                            }
                        </style>

                    </div>

                </div>
            </div>
        </div>

@endsection
