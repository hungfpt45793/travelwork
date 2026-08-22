@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', !empty($cate_child_voucher->meta_title) ? $cate_child_voucher->meta_title : $cate_child_voucher->name_cate_child)
@section('meta_description', isset($cate_child_voucher['meta_description']) ? $cate_child_voucher['meta_description'] : $cate_child_voucher['des_cate_child'])
@section('keywords', isset($cate_child_voucher['meta_keyword']) ? $cate_child_voucher['meta_keyword'] : $cate_child_voucher['name_cate_child'])
@section('meta_image', ''  )
@section('meta_url', !empty($cate_child_voucher['slug_cate_child']) ? route('getChildVoucher', ['slugChildVoucher' => $cate_child_voucher['slug_cate_child']]) : '')


@section('content')
    <style>
        .pagination li {
            padding: 4px 12px;
            color: #333;
            border: 1px solid #eee;
            margin: 5px;
            cursor: pointer;
        }
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
        <section class="container">
            <div class="link bgrWhite md-mgt20">
                <ul class="nav">
                    <li class="nav-item pd8">
                        <a href="/" class="md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                    </li>

                    @if(!empty($cate_voucher->id_cate_voucher))
                        <li class="nav-item pd8">
                            <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                        </li>
                    <li class="nav-item pd8">
                        <a href="{{ route('getAllCategoryVoucher',['slugCategoryVoucher'=> $cate_voucher->slug_cate_voucher]) }}" class=" md-f14 blueDN hvBlueDN">{{ isset($cate_voucher->name_cate_voucher) ? $cate_voucher->name_cate_voucher : '' }}</a>
                    </li>
                    @endif

                    <li class="nav-item pd8">
                        <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                    </li>
                    <li class="nav-item pd8">
                        <a href="#" class=" md-f14 blueDN hvBlueDN">{{ isset($cate_child_voucher->name_cate_child) ? $cate_child_voucher->name_cate_child : '' }}</a>
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
    </section>
    <section class="content pdt20 bgrGray">
        <div class="container">
            <div class="bgrWhite pdl15 pdr15">
            <div class="row"style="padding-bottom: 30px">
                <div class="col-12">
                    <h1 class="white fw7 mgb0 f24" style="color: #009385;padding: 15px 0">{{ isset($cate_child_voucher->name_cate_child) ? $cate_child_voucher->name_cate_child : '' }}</h1>
                </div>
                @foreach($vouchers as $voucher)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12 pd0">
                        @include('site.voucher.item_voucher')
                    </div>
                @endforeach


            </div>
            <div class="row">
                <div class="col-12 pull-right text-right">
                    <nav aria-label="Page navigation example">

                            {{ $vouchers->links() }}

                    </nav>
                </div>
            </div>


            </div>

        </div>
    </section>
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

