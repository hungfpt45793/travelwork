@extends('site.layout.site')

@section('title', 'Thông báo nhà tuyển dụng')
@section('meta_description', 'Thông báo nhà tuyển dụng')
@section('keywords', 'Thông báo nhà tuyển dụng')

@section('content')

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>--}}

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent createProfileOnline">
                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Thông báo</a>
                            </li>
                        </ul>
                    </div>


                    <div class="InfoCompanyJob bgrWhite mgt20 pd20">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="title mgb20">
                                    <h5 class="lt-f20  fw7 bdLeftBlueN5x pdl10 blueN mgb0 dsInline">
                                       Thông báo xác thực tài khoản
                                    </h5>
                                </div>
                                @if($user_confirm->status_email_account == 0)
                                    <div class="mgt20 js_resetButton">
                                        <p class="f16 mgb0">
                                            Tài khoản của bạn chưa được xác thực ? Bạn vui lòng kiểm tra email <span class="clHome">({{ isset($user_confirm->email) ? $user_confirm->email : '' }})</span> đã đăng ký để xác thực tài khoản !
                                        </p>
                                        <a href="{{ route('confrirm_email') }}" class="sendConfirmEmail js_send_confirm_email mgt10" id="load2"
                                           style="border: none;display: inline-block;padding: 5px 15px;text-transform: inherit;"> Xác thực email</a>


                                    </div>
                                @else
                                    <div class="mgt20 js_resetButton">
                                        <p class="f16 mgb0">
                                            Tài khoản của bạn đã được xác thực !
                                        </p>

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="InfoCompanyJob bgrWhite mgt20 pd20">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="title mgb20">
                                    <h5 class="lt-f20  fw7 bdLeftBlueN5x pdl10 blueN mgb0 dsInline">
                                        Hệ thống thông báo
                                    </h5>
                                </div>
                                <div class="mgt20 js_resetButton">
                                    <div class="box_info f16">
                                        @if(!empty($list_noti))
                                        <div class="item_notification">
                                            @foreach($list_noti as $id_noti=>$noti)
                                                <?php
                                                $time_noti = \App\Ultility\Ultility::getdateFacebook($noti->created_at)
                                                ?>

                                                <p class="mgb10 ajax_update_status" data_noti="{{$noti->id_noti}}"> <a  @if($noti->status_noti == 1) class="clxam" @else class="clblack" @endif href="{{ $noti->link_noti }}"> <i class="fas fa-arrow-right"></i>  {{ $noti->des_noti }} <sub class="clHome">({{ $time_noti }})</sub> </a>
                                                @if($noti->status_noti == 0)
                                                <sub class="clred"> | Thông báo mới </sub>
                                                    @endif
                                                    @if($noti->status_noti == 1)
                                                        <sub class="clgreen"> | Đã xem </sub>
                                                    @endif
                                                    <sub class="pointer delete_noti_js" data_noti="{{$noti->id_noti}}"> | Xóa </sub>
                                                </p>
                                            @endforeach
                                        </div>
                                            @else
                                            <p>Không có thông báo mới</p>
                                        @endif







                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @include('site.module_index.dang-ky-tu-van')
                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>
    <script>
        $('.delete_noti_js').click(function(){
            var id_noti = $(this).attr('data_noti');

            $.ajax({
                type: "get",
                url: '{!! route('ajax_delete_noti') !!}',
                data: {
                    id_noti: id_noti,
                },
                success: function (result) {

                },
                error: function (xhr, ajaxOptions, thrownError) {

                }
            });
            $(this).parent().hide();

        });
        $('.ajax_update_status').click(function(){
            var id_noti = $(this).attr('data_noti');

            $.ajax({
                type: "get",
                url: '{!! route('ajax_update_status') !!}',
                data: {
                    id_noti: id_noti,
                },
                success: function (result) {

                },
                error: function (xhr, ajaxOptions, thrownError) {

                }
            });
            return true;

        })

    </script>


@endsection