@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', !empty($information_service->title) ? $information_service->title : '')

@section('meta_description', !empty($information_service->title) ? $information_service->title : '')
@section('keywords', !empty($information_service->title) ? $information_service->title : '')
@section('meta_image', !empty($information_service->title) ? $information_service->title : '')
@section('meta_url',!empty($information_service->title) ? $information_service->title : '' )


@section('content')
    <section class="PagesNewsContent bkxam pdb20 pdt20">
        <div class="container">
            <div class="link bgrWhite mgb20">
                <ul class="nav">
                    <li class="nav-item pd8">

                        <a href="#" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                    </li>

                </ul>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="contentInfoNews bkwhite pd20 bdLightGray">
                        <h1 class="title fontBold mgb10 blueN f18">{{ isset($information_service->title) ? $information_service->title : '' }}</h1>
                        <div class="ContentPost">
                            {!! isset($information_service->content) ? $information_service->content : '' !!}
                        </div>

                    </div>
                </div>
                {{--//Sider bar--}}
                {{--@include('site.sidebar.sidebar_new')--}}
            </div>
        </div>
    </section>

    <div class="noti_mobile_show">
        <div class="modal fade" id="message_noti_mobile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">


                    <div class="contentNoti">
                        <div class="close_modal" data-dismiss="modal" >Đóng <i class="far fa-times-circle mgl5"></i></div>
                        <img class="lazy" data-src="{{ asset('assets/image/thongbao.png') }}">
                        <div class="modal_dowload_title">
                            <h3>Tải ứng dụng Travelwork</h3>
                            <p>Để tìm việc , nhận tin mới nhất</p>
                        </div>
                        <div class="modal_dowload">
                            <a class="d-sm-inline" href="{{ isset($information['link-tai-app-androi']) ?  $information['link-tai-app-androi'] : '' }}"><img class="lazy" data-src="{{ asset('assets/image/android.png') }}"></a>
                            <a class="d-sm-inline" href="{{ isset($information['link-tai-app-ios']) ?  $information['link-tai-app-ios'] : '' }}"><img class="lazy" data-src="{{ asset('assets/image/ios.png') }}"></a>
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
