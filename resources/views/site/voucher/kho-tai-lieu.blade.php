@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', !empty($cate_voucher->meta_title) ? $cate_voucher->meta_title : $cate_voucher->name_cate_voucher)

@section('meta_description', !empty($cate_voucher->meta_description) ? $cate_voucher->meta_description : 'Mô tả kho tài liệu')
@section('keywords', !empty($cate_voucher->meta_keyword) ? $cate_voucher->meta_keyword : $cate_voucher->name_cate_voucher)
@section('meta_image', ''  )
@section('meta_url', !empty($cate_voucher->slug_cate_voucher) ? route('getAllCategoryVoucher', ['slug_cate_voucher' => $cate_voucher->slug_cate_voucher]) : '')
@section('content')

<!--    --><?php
//    print_r($cate_child_voucher);die();
//    ?>
    <style>
        .MenudsNone
        {
            width: 100%;
            display: inline-flex;
            margin: 0 auto;
            text-align: center;
        }
        .MenudsBlock
        {
            display: none;
        }

        @media(max-width: 500px)
        {
            .MenudsNone
            {
                width: 100%;
                display: block !important;
                margin: 0 auto;
                text-align: center;
            }
            .MenudsBlock
            {
                display: none !important;
            }
        }


    </style>
    <section class="content pdt20 bgrGray">
        <div class="container">
            <div class="link bgrWhite md-mgt20">
                <ul class="nav">
                    <li class="nav-item pd8">
                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                    </li>
                    <li class="nav-item pd8">
                        <p class="mgt5 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                    </li>
                    <li class="nav-item pd8">
                        <a href="{{ route('getAllCategoryVoucher',['slugCategoryVoucher'=>$cate_voucher->slug_cate_voucher]) }}" class=" f18 md-f14 mgb0"><h1 class="f16" style="margin-bottom: 3px;">{{ $cate_voucher->name_cate_voucher }}</h1></a>
                    </li>
                </ul>


                <div class="searchVoucher bgrWhite">
                    <form class="mgr15 mgl15" method="GET" action="{{ route('searchVoucher') }}">
                        <div class="form-row">
                            <div class="form-group col-md-10">
                                <input type="text" class="form-control" id="inputEmail4"
                                       placeholder="Nhập tên tài liệu" name="name_voucher" required>
                            </div>
                            <div class="form-group col-md-2">
                                <button type="submit" class="btn btn-primary w100 bgrBlueN">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @foreach($cate_child_voucher as $cate_child)
            <div class="vouchers mgb20 bdLightGray">
                <div class="bgrBlueN">
                    {{--<a href="{{ route('post', ['cate_slug' =>  'tin-tuc', 'post_slug' => $post->slug]) }}" class="thumbs">--}}
                    <a href="{{ route('getChildVoucher',['slugChildVoucher'=>$cate_child->slug_cate_child]) }}"><h2 class="white pd10 fw7 mgb0 f18">{{ isset($cate_child['name_cate_child']) ? $cate_child['name_cate_child'] : '' }}</h2>
                    </a>
                </div>

                <div class="slideNews{{ $cate_child['id_cate_child'] }} bgrWhite bdBottomGray">
                    <?php
                    $list_voucher = \App\Entity\Voucher::getVoucherLimit($cate_child->id_cate_child,6);
                    ?>
                    @foreach($list_voucher as $voucher)
                        @include('site.voucher.item_voucher')
                    @endforeach

                </div>
                <div class="textCenter bgrWhite pd10">
                    <a href="{{ route('getChildVoucher',['slugChildVoucher'=>$cate_child->slug_cate_child]) }}" class="block seeMore">Xem tất cả</a>
                </div>
                <script type="text/javascript">
                    $('.slideNews{{ $cate_child['id_cate_child'] }}').slick({
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 2000,
                        responsive: [
                            {
                                breakpoint: 1200,
                                settings: {
                                    slidesToShow: 4,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 800,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 450,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1
                                }
                            },
                        ]
                    });
                </script>
            </div>
            @endforeach
        </div>
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


<script>

    $(document).ready(function () {

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

