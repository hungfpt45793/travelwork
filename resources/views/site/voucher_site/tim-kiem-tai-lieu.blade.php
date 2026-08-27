@extends('site.layout_site.site')
@section('title', 'tim-kiem-tai-lieu')
@section('meta_description', 'tim-kiem-tai-lieu')
@section('keywords', 'tim-kiem-tai-lieu')
@section('show_css')

    <link rel="stylesheet" type="text/css" href="/assets/css/slick.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/voucher.css"/>
@endsection
@section('content')
    <section class="content pdt20 bgrGray">
        <section class="container container_w_1200">
            <div class="link bgrWhite md-mgt20">
                <div class="link_breakcrum mbdsNone">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                        </li>
                        <li class="nav-item ">
                            <span><i class="fas fa-chevron-right"></i></span>
                        </li>
                        <li class="nav-item pd8">
                            <a href="#">Tìm kiếm</a>
                        </li>
                    </ul>
                </div>
                <div class="">
                    <div class="searchVoucher bgrWhite">
                        <form class="mgr15 mgl15" method="GET" action="{{ route('searchVoucher') }}">
                            <div class="form-row mgb0">
                                <div class="form-group col-md-10 mgb0">
                                    <input type="text" class="form-control" id="inputEmail4"
                                           placeholder="Nhập tên tài liệu" name="name_voucher" value="{{ isset($_GET['name_voucher']) ? $_GET['name_voucher'] : '' }}" required>
                                </div>
                                <div class="form-group col-md-2 mgb0">
                                    <button type="submit" class="btn btn-primary w100 bgrBlueN">Tìm kiếm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <section class="section_box_content mgt20">
                <div class="header_box">
                    <h1 class="title_box  fw6 f20 mgb0 col-f14">
                        <a>
                            Từ khóa tìm kiếm :  {{ isset($_GET['name_voucher']) ? $_GET['name_voucher'] : '' }}
                        </a>
                    </h1>
                </div>
                <div class="content_box">
                    <div class="row">
                        @foreach($vouchers as $voucher)
                            <div class="col-lg-3 col-md-3 col-sm-6 col-12 pd0">
                                @include('site.voucher_site.item_voucher')
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <nav aria-label="Page navigation example">

                                {{ $vouchers->links() }}

                            </nav>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </section>
    <div class="noti_mobile_show">
        <div class="modal fade" id="message_noti_mobile" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="contentNoti">
                        <div class="close_modal" data-dismiss="modal">Đóng <i class="far fa-times-circle mgl5"></i>
                        </div>
                        <img src="{{ asset('assets/image/thongbao.png') }}">
                        <div class="modal_dowload_title">
                            <h3>Tải ứng dụng Travelwork</h3>
                            <p>Để tìm việc , nhận tin mới nhất</p>
                        </div>
                        <div class="modal_dowload">
                            <a class="d-sm-inline"
                               href="{{ isset($information['link-tai-app-androi']) ?  $information['link-tai-app-androi'] : '' }}"><img
                                        src="{{ asset('assets/image/android.png') }}"></a>
                            <a class="d-sm-inline"
                               href="{{ isset($information['link-tai-app-ios']) ?  $information['link-tai-app-ios'] : '' }}"><img
                                        src="{{ asset('assets/image/ios.png') }}"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('show_js')
    <script>
        $(document).ready(function () {
            $('.js_matchHeight_title_voucher').matchHeight();
            var user = getCookie("modal_noti");
            console.log(user);
            if (user != 'modal_noti_hide') {
                if ($(window).width() <= 500) {
                    $('#message_noti_mobile').modal('show');
                    $('.close_modal').click(function () {
                        setCookie("modal_noti", 'modal_noti_hide', 30);

                        $('#message_noti_mobile').modal('hide');
                    });
                }
            }
        });

        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toGMTString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
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


