@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', !empty($cate_voucher->meta_title) ? $cate_voucher->meta_title : $cate_voucher->name_cate_voucher)
@section('meta_description', !empty($cate_voucher->meta_description) ? $cate_voucher->meta_description : 'Mô tả kho tài liệu')
@section('keywords', !empty($cate_voucher->meta_keyword) ? $cate_voucher->meta_keyword : $cate_voucher->name_cate_voucher)
@section('meta_image', ''  )
@section('meta_url', !empty($cate_voucher->slug_cate_voucher) ? route('getAllCategoryVoucher', ['slug_cate_voucher' => $cate_voucher->slug_cate_voucher]) : '')
@section('show_css')

    <link rel="stylesheet" type="text/css" href="/public/assets/css/slick.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/css/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/voucher.css"/>
@endsection
@section('content')
    <section class="content pdt20 bgrGray">
        <div class="container container_w_1200">

            <div class="link_breakcrum mbdsNone">
                <ul class="nav">
                    <li class="nav-item">
                        <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                    </li>
                    <li class="nav-item ">
                        <span><i class="fas fa-chevron-right"></i></span>
                    </li>
                    <li class="nav-item pd8">
                        <a href="{{ route('getAllCategoryVoucher',['slugCategoryVoucher'=>$cate_voucher->slug_cate_voucher]) }}">{{ $cate_voucher->name_cate_voucher }}</a>
                    </li>
                </ul>
            </div>
            <div class="">
                <div class="searchVoucher bgrWhite">
                    <form class="mgr15 mgl15" method="GET" action="{{ route('searchVoucher') }}">
                        <div class="form-row mgb0">
                            <div class="form-group col-md-10 mgb0">
                                <input type="text" class="form-control" id="inputEmail4"
                                       placeholder="Nhập tên tài liệu" name="name_voucher" required>
                            </div>
                            <div class="form-group col-md-2 mgb0">
                                <button type="submit" class="btn btn-primary w100 bgrBlueN">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @foreach($cate_child_voucher as $cate_child)
            <section class="section_box_content mgt20">
                <div class="header_box">
                    <h2 class="title_box  fw6 f20 mgb0 col-f14">
                        <a href="{{ route('getChildVoucher',['slugChildVoucher'=>$cate_child->slug_cate_child]) }}">
                            {{ isset($cate_child['name_cate_child']) ? $cate_child['name_cate_child'] : '' }}
                        </a>
                    </h2>

                </div>
                <div class="content_box">
                    <div class="slideNews{{ $cate_child['id_cate_child'] }} bgrWhite bdBottomGray">
                        <?php
                        $list_voucher = \App\Entity\Voucher::getVoucherLimit($cate_child->id_cate_child,6);
                        ?>
                        @foreach($list_voucher as $voucher)
                            @include('site.voucher_site.item_voucher')
                        @endforeach

                    </div>
                    <div class="btn_href_voucher">
                        <a href="{{ route('getChildVoucher',['slugChildVoucher'=>$cate_child->slug_cate_child]) }}" class="block seeMore">Xem tất cả</a>
                    </div>
                </div>

            </section>
            @endforeach
        </div>
		 <div class="list_re_voucher vouchers mgb20 bdLightGray section_box_content mgt20" >
    </section>
<!-- Phần nội dung -->
<div class="noti_mobile_show">
    <div class="modal fade" id="message_noti_mobile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">


                <div class="contentNoti">
                    <div class="close_modal" data-dismiss="modal" >Đóng <i class="far fa-times-circle mgl5"></i></div>
                    <img src="{{ asset('assets/image/thongbao.png') }}">
                    <div class="modal_dowload_title">
                        <h3>Tải ứng dụng Travelwork</h3>
                        <p>Để tìm việc , nhận tin mới nhất</p>
                    </div>
                    <div class="modal_dowload">
                        <a class="d-sm-inline" href="{{ isset($information['link-tai-app-androi']) ?  $information['link-tai-app-androi'] : '' }}"><img src="{{ asset('assets/image/android.png') }}"></a>
                        <a class="d-sm-inline" href="{{ isset($information['link-tai-app-ios']) ?  $information['link-tai-app-ios'] : '' }}"><img src="{{ asset('assets/image/ios.png') }}"></a>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


    @include('site.partials_site.fixel_mobile_bottom')
@endsection
@section('show_js')
    <script src="/public/assets/js/slick.min.js"></script>
    @foreach($cate_child_voucher as $cate_child)
        <script type="text/javascript">
            $('.slideNews{{ $cate_child['id_cate_child'] }}').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 10000,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4,
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
                        breakpoint: 900,
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
    @endforeach
    <script>

        $(document).ready(function () {
            $('.js_matchHeight_title_voucher').matchHeight();
            var user=getCookie("modal_noti");
            console.log(user);
            if (user != 'modal_noti_hide') {
                if ($(window).width() <= 500) {
                    $('#message_noti_mobile').modal('show');
                    $('.close_modal').click(function(){
                        setCookie("modal_noti", 'modal_noti_hide', 30);

                        $('#message_noti_mobile').modal('hide');
                    });
                }
            }
        });

        function setCookie(cname,cvalue,exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires=" + d.toGMTString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

    </script>
@endsection

