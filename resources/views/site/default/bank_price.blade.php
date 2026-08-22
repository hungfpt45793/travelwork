@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', !empty($information_service->title) ? $information_service->title : 'Thanh toán dịch vụ')

@section('meta_description', !empty($information_service->title) ? $information_service->title : '')
@section('keywords', !empty($information_service->title) ? $information_service->title : '')
@section('meta_image', !empty($information_service->title) ? $information_service->title : '')
@section('meta_url',!empty($information_service->title) ? $information_service->title : '' )


@section('content')
<section class="PagesNewsContent bkxam pdb20 pdt20 pay_price" id="bank_price">
    <div class="container d-container">
        <div class="link bgrWhite mgb20 p-3 hide_mobile">
            <ul class="nav">
                <li class="nav-item pd8">
                    <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                </li>
                <li class="nav-item pd8">
                    <p class="mgt5 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                </li>
                <li class="nav-item pd8">
                    <a href="{{ route('list_price') }}" class=" f18 md-f14 mgb0">Bảng giá dịch vụ</a>
                </li>
                <li class="nav-item pd8">
                    <p class="mgt5 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                </li>
                @if(isset($_GET['hunter_price_id']))
                <li class="nav-item pd8">
                    <a href="{{ route('registration_hunter') }}?hunter_price_id={{ $_GET['hunter_price_id'] }}"
                        class=" f18 md-f14 mgb0">Đăng ký dịch vụ</a>
                </li>
                @endif
                @if(isset($_GET['service_price'])&&isset($_GET['service_table_price']))
                <li class="nav-item pd8">
                    <a href="{{ route('pay_price') }}?service={{ $_GET['service_price'] }}&service_package={{ $_GET['service_table_price'] }}"
                        class=" f18 md-f14 mgb0">Đăng ký dịch vụ</a>
                </li>
                @endif
            </ul>
        </div>
        <div class="link bgrWhite mgb20 p-3">
            <div class="row">
                <div class="col-12 mb-2 fw6 f20 white bgrBlueN pd10-20 col-f14">
                    <p id="bank_title" class="fw6 f20 mgb0 col-f14">CHUYỂN TIỀN QUA INTERNET BANKING - MỜI BẠN CHỌN NGÂN
                        HÀNG</p>
                </div>

                <div class="service_show_on_big">
                    <div class="box_nh row">
                        <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                            @foreach ($pay_prices2first as $pay_price2first)
                            <div class="logo_nh" id="logo_nh{{ $pay_price2first->service_bank_id }}" >
                                <img class="lazy" data-src="{{ $pay_price2first->service_bank_image }}" alt="">
                            </div>
                            @endforeach
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 box_tt_nh  border border-secondary">
                            @foreach ($pay_prices2first as $pay_price2first)
                            <div class="row box_tt_bank pt-2" data="logo_nh{{ $pay_price2first->service_bank_id }}">
                                <div class="col-8">
                                    <p class="text-uppercase text-primary">THÔNG TIN TÀI KHOẢN
                                        {{ $pay_price2first->service_bank_name }}</p>
                                    <p>Số Tài Khoản: {{ $pay_price2first->service_bank_number }}</p>
                                    <p>Chủ Tài Khoản: {{ $pay_price2first->service_bank_own }}</p>
                                </div>
                                <div class="col-4">
                                    <img class="lazy" data-src="{{ $pay_price2first->service_bank_image }}" alt="">
                                </div>
                                <div class="col-12">
                                    <p>Chi Nhánh: {{ $pay_price2first->service_bank_branch }}</p>
                                    <p>Lưu ý: Nội dung ghi rõ: thanh toán cho đơn hàng <b
                                            class="text-danger">{!! $_GET['order_code'] !!}</b> </p>
                                    <span>{!! $pay_price2first->service_bank_content !!} </span>
                                </div>
                            </div>
                            @endforeach
                            @foreach ($pay_prices2next as $pay_price2next)
                            <div class="row box_tt_bank pt-2" data="logo_nh{{ $pay_price2next->service_bank_id }}">
                                <div class="col-8">
                                    <p class="text-uppercase text-primary">THÔNG TIN TÀI KHOẢN
                                        {{ $pay_price2next->service_bank_name }}</p>
                                    <p>Số Tài Khoản: {{ $pay_price2next->service_bank_number }}</p>
                                    <p>Chủ Tài Khoản: {{ $pay_price2next->service_bank_own }}</p>
                                </div>
                                <div class="col-4">
                                    <img class="lazy" data-src="{{ $pay_price2next->service_bank_image }}" alt="">
                                </div>
                                <div class="col-12">
                                    <p>Chi Nhánh: {{ $pay_price2first->service_bank_branch }}</p>
                                    <p>Lưu ý: Nội dung ghi rõ: thanh toán cho đơn hàng <b
                                            class="text-danger">{!! $_GET['order_code'] !!}</b></p>
                                    <span>{!! $pay_price2first->service_bank_content !!} </span>
                                </div>
                            </div>
                            @endforeach
                            @foreach ($pay_pricesend as $pay_priceend)
                            <div class="row box_tt_bank pt-2" data="logo_nh{{ $pay_priceend->service_bank_id }}">
                                <div class="col-8">
                                    <p class="text-uppercase text-primary">THÔNG TIN TÀI KHOẢN
                                        {{ $pay_priceend->service_bank_name }}</p>
                                    <p>Số Tài Khoản: {!! $pay_priceend->service_bank_number !!}</p>
                                    <p>Chủ Tài Khoản: {!! $pay_priceend->service_bank_own !!}</p>
                                </div>
                                <div class="col-4">
                                    <img class="lazy" data-src="{{ $pay_priceend->service_bank_image }}" alt="">
                                </div>
                                <div class="col-12">
                                    <p>Chi Nhánh: {{ $pay_price2first->service_bank_branch }}</p>
                                    <p>Lưu ý: Nội dung ghi rõ: thanh toán cho đơn hàng <b
                                            class="text-danger">{!! $_GET['order_code'] !!}</b></p>
                                    <span>{!! $pay_price2first->service_bank_content !!} </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                            @foreach ($pay_prices2next as $pay_price2next)
                            <div class="logo_nh" id="logo_nh{{ $pay_price2next->service_bank_id }}">
                                <img class="lazy" data-src="{{ $pay_price2next->service_bank_image }}" alt="">
                            </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="box2_nh row ">
                        @foreach ($pay_pricesend as $pay_priceend)
                        <div class="col-3 col-sm-3 col-md-3 col-lg-3">
                            <div class="logo_nh" id="logo_nh{{ $pay_priceend->service_bank_id }}">
                                <img class="lazy" data-src="{{ $pay_priceend->service_bank_image }} " alt="">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>


                <div class="service_show_on_small mb-3">
                    <div class="row">
                        <div class="col-4 col-sm-3 col-md-3 col-lg-3">
                            @foreach ($pay_prices2first as $pay_price2first)
                            <div class="logo_nh" id="logo_nh{{ $pay_price2first->service_bank_id }}">
                                <img class="lazy" data-src="{{ $pay_price2first->service_bank_image }}" alt="">
                            </div>
                            @endforeach
                            @foreach ($pay_prices2next as $pay_price2next)
                            <div class="logo_nh" id="logo_nh{{ $pay_price2next->service_bank_id }}">
                                <img class="lazy" data-src="{{ $pay_price2next->service_bank_image }}" alt="">
                            </div>
                            @endforeach
                        </div>
                        <div class="col-8 col-sm-8 col-md-8 col-lg-8 border box_tt_nh ">
                            @foreach ($pay_prices2first as $pay_price2first)
                            <div class="row box_tt_bank pt-2 mr-1 mb-1 " data="logo_nh{{ $pay_price2first->service_bank_id }}">
                                <div class="col-8">
                                    <p class="text-uppercase text-primary">THÔNG TIN TÀI KHOẢN
                                        {{ $pay_price2first->service_bank_name }}</p>
                                </div>
                                <div class="col-4" style="padding: 0px;">
                                    <img class="lazy" data-src="{{ $pay_price2first->service_bank_image }}" alt="">
                                </div>

                                <div class="col-12">
                                    <p>Số Tài Khoản: {{ $pay_price2first->service_bank_number }}</p>
                                    <p>Chủ Tài Khoản: {{ $pay_price2first->service_bank_own }}</p>
                                    <p>Chi Nhánh: {{ $pay_price2first->service_bank_branch }}</p>
                                    <p>Lưu ý: Nội dung ghi rõ: thanh toán cho đơn hàng <b
                                            class="text-danger">{!! $_GET['order_code'] !!}</b> </p>
                                    <span>{!! $pay_price2first->service_bank_content !!} </span>
                                </div>
                            </div>
                            @endforeach
                            @foreach ($pay_prices2next as $pay_price2next)
                            <div class="row box_tt_bank pt-2 mr-1 mb-1 " data="logo_nh{{ $pay_price2next->service_bank_id }}">
                                <div class="col-8">
                                    <p class="text-uppercase text-primary">THÔNG TIN TÀI KHOẢN
                                        {{ $pay_price2next->service_bank_name }}</p>
                                </div>
                                <div class="col-4"  style="padding: 0px;">
                                    <img class="lazy" data-src="{{ $pay_price2next->service_bank_image }}" alt="">
                                </div>
                                <div class="col-12">
                                    <p>Số Tài Khoản: {{ $pay_price2next->service_bank_number }}</p>
                                    <p>Chủ Tài Khoản: {{ $pay_price2next->service_bank_own }}</p>
                                    <p>Chi Nhánh: {{ $pay_price2first->service_bank_branch }}</p>
                                    <p>Lưu ý: Nội dung ghi rõ: thanh toán cho đơn hàng <b
                                            class="text-danger">{!! $_GET['order_code'] !!}</b></p>
                                    <span>{!! $pay_price2first->service_bank_content !!} </span>
                                </div>
                            </div>
                            @endforeach
                            @foreach ($pay_pricesend as $pay_priceend)
                            <div class="row box_tt_bank pt-2 mr-1 mb-1 " data="logo_nh{{ $pay_priceend->service_bank_id }}">
                                <div class="col-8">
                                    <p class="text-uppercase text-primary">THÔNG TIN TÀI KHOẢN
                                        {{ $pay_priceend->service_bank_name }}</p>

                                </div>
                                <div class="col-4"  style="padding: 0px;">
                                    <img class="lazy" data-src="{{ $pay_priceend->service_bank_image }}" alt="">
                                </div>
                                <div class="col-12">
                                    <p>Số Tài Khoản: {!! $pay_priceend->service_bank_number !!}</p>
                                    <p>Chủ Tài Khoản: {!! $pay_priceend->service_bank_own !!}</p>
                                    <p>Chi Nhánh: {{ $pay_price2first->service_bank_branch }}</p>
                                    <p>Lưu ý: Nội dung ghi rõ: thanh toán cho đơn hàng <b
                                            class="text-danger">{!! $_GET['order_code'] !!}</b></p>
                                    <span>{!! $pay_price2first->service_bank_content !!} </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                @foreach ($pay_pricesend as $pay_priceend)
                                <div class="col-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="logo_nh" id="logo_nh{{ $pay_priceend->service_bank_id }}">
                                        <img class="lazy" data-src="{{ $pay_priceend->service_bank_image }} " alt="">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-8 col-md-8 col-lg-8">
                    <div class="infoAlert">
                    </div>
                </div>
                <div class="col-md-12 col-12 float-right">
                    <div class="infoAlert">
                        <div class="alert alert-success text-center">
                            <span>Đã đăng ký sử dụng dịch vụ thành công, bạn vui lòng thanh toán để đơn hàng được thực hiện</span>
                            <button type="button" class="close iconAlert" data-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                        <a href="{{ route('list_price') }}" class="btn btn-success f18 md-f14 mgb0 flaot-right">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<script>
    $(function() {
    $('.box_tt_nh .box_tt_bank').addClass('d-none');
    $('.box_tt_nh .box_tt_bank:first-child').removeClass('d-none');
    $data = $('.box_tt_nh .box_tt_bank:first-child').attr('data');
    console.log($data)
    $('#'+$data+' img').css({"background":"#e9eb97"})
    $('.logo_nh').click(function(){
        $('.logo_nh img').css({"background":"#fff"});
        $id = $(this).attr('id');
        $('#'+$id+' img').css({"background":"#e9eb97"})
        $('.box_tt_nh .box_tt_bank').addClass('d-none');
        $('div[data='+$id+']').removeClass('d-none');
    })

    $('.btn-edit-tt').click(function(){
        $('.isset-employer input').prop('disabled', function () {
            return ! $(this).prop('disabled');
        });
    })
})
</script>
@endsection