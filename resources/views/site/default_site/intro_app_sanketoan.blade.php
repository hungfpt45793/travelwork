@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', 'Giới thiệu App Travelwork')

@section('meta_description', 'Giới thiệu App Travelwork')
@section('keywords', 'Giới thiệu App Travelwork')
@section('meta_image', 'Giới thiệu App Travelwork')

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/css/intro_app_sanketoan.css"/>
@endsection

@section('content')
    @include('site.partials.slider_new')
    <section class="intro_box_feature intro_app">
        <div class="container ">
            <div class="row">
                <div class="col-md-12 intro_title">
                    <h3>TÍNH NĂNG NỔI BẬT</h3>
                    <p>Những tính năng của ứng dụng SANKETOAN giúp ứng viên dễ dàng ứng tuyển, nâng cao trải nghiệm tìm việc
                        trong kỷ nguyên số</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-12">
                    @foreach(\App\Entity\SubPost::showSubPost('tinh-nang-noi-bat-app',4,'asc') as $id_fea => $fea)
                    <div class="item_feature js_item_feature @if($id_fea==0) active_feature @endif"  data_src="{{ !empty($fea['image']) ? asset($fea['image']) : '' }}">
                        <div class="icon_title_item_feature">
                            <span class="icon_item_feature">{!! !empty($fea['icon-app']) ? $fea['icon-app'] : '' !!}</span>
                            <span class="title_item_feature">{{ !empty($fea['title']) ? $fea['title'] : '' }}</span>

                        </div>
                        <p>
                            {{ !empty($fea['description']) ? $fea['description'] : '' }}
                        </p>
                        <div class="img_item_feature text-center dsNone dsBlock_991">
                            <img src="{{ !empty($fea['image']) ? asset($fea['image']) : '' }}">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-lg-4 col-md-12 dsNone_991 js_data_src">
                    @foreach(\App\Entity\SubPost::showSubPost('tinh-nang-noi-bat-app',4,'asc') as $id_fea => $fea)
                        @if($id_fea==0)
                            <img src="{{ !empty($fea['image']) ? asset($fea['image']) : '' }}">
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="intro_box_number intro_app">
        <div class="container ">
            <div class="row">
                <div class="col-md-12 intro_title">
                    <h3>NHỮNG CON SỐ BIẾT NÓI</h3>
                    <p>Những con số nổi bật mà ứng dụng SANKETOAN đã đạt được</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-12 dsNone dsBlock_1000">
                    <div class="box-content_image middle-box">
                        <img src="{{ !empty($information['banner-trang-gioi-thieu-app']) ? asset($information['banner-trang-gioi-thieu-app']) : asset('assets/image/new/SKT.png') }}">
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    @foreach(\App\Entity\SubPost::showSubPost('nhung-con-so-biet-noi-app',4,'asc') as $id_sta => $start)
                        @if($id_sta < 2)
                    <div class="box-content start-box">
                        <span class="icon">{{ $id_sta + 1 }}</span>
                        <h5 class="title">{{ !empty($start['title']) ? $start['title'] : '' }}</h5>
                        <p class="contet">{{ !empty($start['description']) ? $start['description'] : '' }}</p>
                    </div>
                        @endif
                    @endforeach
                </div>
                <div class="col-lg-4 col-12 dsNone_1000_implotar">
                    <div class="box-content_image middle-box">
                        <img src="{{ !empty($information['banner-trang-gioi-thieu-app']) ? asset($information['banner-trang-gioi-thieu-app']) : asset('assets/image/new/SKT.png') }}">
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    @foreach(\App\Entity\SubPost::showSubPost('nhung-con-so-biet-noi-app',4,'asc') as $id_sta => $start)
                        @if($id_sta > 1)
                            <div class="box-content end-box">
                                <span class="icon">{{ $id_sta + 1 }}</span>
                                <h5 class="title">{{ !empty($start['title']) ? $start['title'] : '' }}</h5>
                                <p class="contet">{{ !empty($start['description']) ? $start['description'] : '' }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>

            </div>
        </div>
    </section>
    <section class="intro_box_slider intro_app">
        <div class="container ">
            <div class="row">
                <div class="col-md-12 intro_title">
                    <h3>KIẾN TẠO SỰ NGHIỆP CỦA RIÊNG BẠN VỚI ỨNG DỤNG "TẤT CẢ TRONG MỘT" SANKETOAN</h3>
                    <p>Trải nghiệm tạo CV, tìm việc, ứng tuyển và hơn thế nữa - chỉ với một ứng dụng duy nhất. Bắt đầu
                        ngay hôm nay!</p>
                </div>
            </div>
            <div class="row slide_list_image">
                @foreach(\App\Entity\SubPost::showSubPost('slider-gioi-thieu-app',6,'asc') as $id_sl => $sl)
                    <div class="item_list_image">
                        <a href="{{ !empty($sl['link-gioi-thieu-app']) ? $sl['link-gioi-thieu-app'] : '#' }}">
                            <img src="{{ !empty($sl['image']) ? asset($sl['image']) : '' }}">
                        </a>
                    </div>
                @endforeach

            </div>

            <div class="row">
                <div class="col-lg-12 col-12 text-center intro_dowload">
                    <p class="">Tải ứng dụng ngay</p>
                    <div class="intro_dowload_app">  <a class="d-sm-inline" href="{{ isset($information['link-tai-app-androi']) ?  $information['link-tai-app-androi'] : '' }}"><img src="{{ asset('assets/image/android.png') }}" class="lazy" data-src="{{ asset('assets/image/android.png') }}"></a>
                        <a class="d-sm-inline" href="{{ isset($information['link-tai-app-ios']) ?  $information['link-tai-app-ios'] : '' }}"><img src="{{ asset('assets/image/ios.png') }}" class="lazy" data-src="{{ asset('assets/image/ios.png') }}"></a></div>
                </div>
            </div>
        </div>
    </section>


    <script src="/assets/js/slick.min.js"></script>
    <script type="text/javascript">
        $('.js_item_feature').click(function(){
            var data_src = $(this).attr('data_src');
            $('.js_data_src img').attr('src',data_src);
            $('.js_item_feature').removeClass('active_feature');
            $(this).addClass('active_feature');
        });
        $('.slide_list_image').slick({
            centerMode: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 4,
                        infinite: true,
                    }
                },
                {
                    breakpoint: 1000,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                }, {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }, {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }, {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    </script>
@endsection
