@extends('site.layout_site.site')
@section('title',  'Nhà tuyển dụng ')
@section('meta_description', 'Danh sách nhà tuyển dụng')
@section('keywords', 'nhà tuyển dụng')
@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/css/list_price.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/list_employee.css"/>
@endsection
@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <?php $user = \Illuminate\Support\Facades\Auth::user() ?>
                     @include('site.sidebar_site.sidebar_job',['user'=>$user])
                @else
                    @include('site.sidebar_site.sidebar_no_login_employer')
                @endif
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <?php
                                $link_url ='#';
                                $link_url = \App\Ultility\Ultility::getUrl();
                                ?>
                                <a class=""
                                   href="{{ $link_url }}"><i class="fas fa-link white mgr5"></i> Nhà tuyển dụng</a>
                            </li>
                        </ul>
                    </div>
                    <div class="notificationBox bkwhite formJobLarge mgt20">
                        <div class="bodyBox ">
                            <div class="accountInfo w-100 disInBlock text-center">
                                <div class="disInBlock ">
                                    <p class="disInBlock f20">Có tất cả  <span class="clRed fw6">{{ number_format($total_employee ,0) }}</span> hồ sơ đang
                                        tìm việc trên <span class="clhome">Travelwork </span></p>
                                </div>
                                <div class="disInBlock text-right  float-right">
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
                                    <p class="disInBlock f20">Có tất cả <span class="clRed fw6">{{ number_format($total_employer ,0) }}</span> doanh nghiệp đang tìm kiếm ứng viên trên <span class="clhome">Travelwork </span></p>
                                </div>
                                <div class="disInBlock text-right fright float-right ">
                                    <a href="{{ route('list_employer') }}"
                                       class="pd10 fontBold bgrBlueN text-right white disInBlock">BẤM XEM
                                        NGAY</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="contentPage mgt20">
                        <div class="underlineL disInBlock"></div>
                        <div class="box_employer_title">
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
                                                <select class="form-control select2" name="career_category_id">
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
                                                <button type="submit" ><i class="fas fa-search"></i> Tìm kiếm hồ sơ
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
                                        <div class="title text-center">
                                            <h3 class="text-uppercase">Travelwork</h3>
                                            <p></p>
                                        </div>
                                        <div class="peopleRecruitment text-center">
                                            <div class="people_icon disInBlock mgr10">
                                                <img class="lazy" src="assets/image/icon1.png" alt="">
                                                <p class="people_title">{{ number_format($total_employee ,0)  }}</p>
                                                <p class="people_des">HỒ SƠ ỨNG
                                                    VIÊN</p>
                                            </div>
                                            <div class="people_icon disInBlock">
                                                <img class="lazy" src="assets/image/icon2.png" alt="">
                                                <p class="people_title">{{ number_format($total_employer ,0) }}</p>
                                                <p class="people_des">DOANH NGHIỆP</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    @include('site.module_index.hotline')
                    <section class="section_box_content mgt20">
                        <div class="header_box">
                            <h3 class="title_box  fw6 f20 mgb0 col-f14">
                                Ứng viên nổi bật
                            </h3>
                        </div>
                        <?php
                        $list_employee = \App\Entity\Employee::get_employee(10);
                        ?>
                        <div class="content_box_employee">
                            @foreach($list_employee as $employee)
                                @include('site.employee_site.item_employee_new',['employee' => $employee])
                            @endforeach
                        </div>
                        <div class="text-center" style="display: block; padding: 20px 0px;">
                            <a href="{{ route('show_employee') }}" style="color: #fff;
                    background-color: #07aa74;
                    border: none;
                    padding: 10px 15px;
                    border-radius: 7px;
                    font-size: 14px;">
                                Xem thêm</a></div>
                    </section>

                    @include('site.module_index.dang-ky-tu-van')
                </div>
            </div>
            {{--@include('site.module_index.hotline')--}}
        </div>
    </section>
    @include('site.mobile_bottom.fixel_bottom_list_employer')
@endsection
@section('show_js')
    <script>
        // chon thanh pho ra quan huyen
        $('#city').change(function () {
            var city = $(this).val();
            $.get('/tim-kiem-huyen/' + city , function (data) {
                $('#county').html('');
                $('#county').html(data);
            });
        });
        $('#service_show_on_small>ul>li').css({"width":"50%"});
        $('.js_height_employer_grade').matchHeight();
        $('.js_title_goi_tin').matchHeight();
        $('.js_detail_box').matchHeight();
    </script>
@endsection

