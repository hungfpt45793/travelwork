@extends('site.layout.site')
@section('title',  'Nhà tuyển dụng ')
@section('meta_description', 'Danh sách nhà tuyển dụng')
@section('keywords', 'nhà tuyển dụng')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                <?php $user = \Illuminate\Support\Facades\Auth::user() ?>
                @include('site.sidebar.sidebar_job',['user'=>$user])

                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20">
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
                                <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> <i class="fas fa-link white mgr5"></i> Nhà tuyển dụng</a>
                            </li>

                        </ul>
                    </div>
                    <div class="notificationBox bkwhite formJobLarge mgt20">
                        <div class="bodyBox ">
                            <div class="accountInfo w-100 disInBlock text-center">
                                <div class="disInBlock ">
                                    <p class="disInBlock f20">Có tất cả  <span class="clred fw6">{{ number_format($total_employee ,0) }}</span> hồ sơ đang
                                        tìm việc trên <span class="clhome">Travelwork </span></p>
                                </div>
                                <div class="disInBlock text-right fright frightmb ">
                                    <a href="{{ route('show_employee') }}"
                                       class="pd10 fontBold bgrBlueN text-right white disInBlock">BẤM XEM
                                        NGAY</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="notificationBox bkwhite formJobLarge mgt20">
                        <div class="bodyBox ">
                            <div class="accountInfo w-100 disInBlock text-center">
                                <div class="disInBlock ">
                                    <p class="disInBlock f20">Có tất cả <span class="clred fw6">{{ number_format($total_employer ,0) }}</span> doanh nghiệp đang tìm kiếm ứng viên trên <span class="clhome">Travelwork</span></p>
                                </div>
                                <div class="disInBlock text-right fright frightmb ">
                                    <a href="{{ route('list_employer') }}"
                                       class="pd10 fontBold bgrBlueN text-right white disInBlock">BẤM XEM
                                        NGAY</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="contentPage mgt20">
                        <div class="underlineL disInBlock"></div>
                        <div class="tittleC textUpper disInBlock text-center blueN">
                            CỔNG DÀNH CHO NHÀ TUYỂN DỤNG
                        </div>
                        <div class="underlineR disInBlock"></div>
                    </div>
                    <div class="notificationBox  formJobLarge mgt20 pd0"
                         style="margin-bottom:30px;background-color: #fff9f4; ">
                        <div class="row">

                            <div class="col-lg-4 pd15-0-15-3 col-sm-12">
                                <div class="formSearchKey" style="background-color: #fff;">
                                    <form action="{{ route('search_employee') }}" method="get">

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="career">
                                                    <option value="0" selected>Công việc cần tìm</option>
                                                    @foreach(\App\Entity\Career::get_all_career() as $career)
                                                        <option value="{{$career->career_category_id}}">{{$career->career_category_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <select class="form-control select2"
                                                        name="province" aria-label="Tỉnh/Thành phố" id="city">
                                                    <option value="0" selected> Tất cả tỉnh/thành phố</option>
                                                    <?php
                                                    $getAllProvince = \App\Entity\Province::GetAllProvinces();
                                                    ?>
                                                    @foreach($getAllProvince as $province)
                                                        <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <button type="submit"
                                                        class="btn btn-warning w100 fontBold font18 white"><i class="fas fa-search"></i> Tìm kiếm hồ sơ
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <style>
                                        .select2 {
                                            border: 1px solid #ced4da;
                                        }
                                    </style>
                                </div>
                            </div>
                            <div class="col-lg-8 col-sm-12">
                                <div style="">
                                    <div class="contentImage  left25p top5p mh14-left10 mh10-Left8Right8"
                                         style="background-color: #fff9f4;">
                                        <div class="title">
                                            <h3 class="text-uppercase">Travelwork</h3>
                                            <p></p>
                                        </div>
                                        <div class="PeopleRecruitment text-center">
                                            <div class="icon1 disInBlock  mh10-mg0 mh42-w45 mgr20">
                                                <img class="lazy" src="assets/image/icon1.png" alt="">
                                                <p class="mg0 text-center fontBold font23 mh42-font18 red">{{ number_format($total_employee ,0)  }}</p>
                                                <p class="text-center fontBold font23 blue mh42-font18">HỒ SƠ ỨNG
                                                    VIÊN</p>
                                            </div>
                                            <div class="icon2 disInBlock  ">
                                                <img class="lazy" src="assets/image/icon2.png" alt="">
                                                <p class="mg0 text-center fontBold font23 mh42-font18 red">{{ number_format($total_employer ,0) }}</p>
                                                <p class="text-center fontBold font23 blue mh42-font18">DOANH NGHIỆP</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                        <div class="contentPage mgt20">
                            <div class="link bgrWhite mgb20" id="price_list">
                                <div id="service_show_on_big">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h1>Bảng giá dịch vụ</h1>
                                        </div>
                                    </div>
                                    <div class="row title_price_list">
                                        @foreach ($list_prices as $list_price)
                                        <div class="col-md-6 col-xl-3 mb-3  col-sm-3 total_box">
                                            {{-- <div class="shadow"></div> --}}
                                            <div class="grade">
                                                <div class="maxHieght_service">
                                                    <div class="img d-center"><img class="lazy d-center" src="{{ $list_price->image }}" alt="">
                                                    </div>
                                                    <div class="title_goi_tin d-center">
                                                        <h3 class="name_box d-center">
                                                            @php
                                                            echo title_case($list_price->service_price_title);
                                                            @endphp
                                                        </h3>
                                                    </div>
                                                    <div class="detail_box pl-2">
                                                        <span style="line-height: 1em">{!! $list_price->feature !!}</span>
                                                    </div>
                                                </div>
                                                <div class="button_more d-center">
                                                        <a href="{{ route('table_price_employer', ['slug'=> $list_price->service_price_slug]) }}" class="ct_button_more ct_button_more1 d-center">Xem
                                                        chi tiết</a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div id="service_show_on_small">
                                    <h2>Bảng giá dịch vụ</h2>
                                    <ul class="nav nav-pills mb-3 bg-info" id="d-pills-tab" role="tablist">
                                        @foreach($list_prices as $list_price)

                                        <li class="nav-item d-nav-item" data="pills-{{ $list_price->service_price_id }}">

                                            <p class="font425_12">
                                                <a style="border:unset;background:none!important" href="{{ route('table_price_employer', ['slug'=> $list_price->service_price_slug]) }}">
                                                @php
                                                echo title_case($list_price->service_price_title);
                                                @endphp
                                                  </a>
                                            </p>
                                        </li>

                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @include('site.module_index.dang-ky-tu-van')
                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>
    @include('site.mobile_bottom.fixel_bottom_list_employer')
    <script>
        // chon thanh pho ra quan huyen
        $('#city').change(function () {
            var city = $(this).val();
            $.get('/tim-kiem-huyen/' + city , function (data) {
                $('#county').html('');
                $('#county').html(data);
            });
        });
        $('#service_show_on_small>ul>li').css({"width":"50%"})
    </script>


@endsection
