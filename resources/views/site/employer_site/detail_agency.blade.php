@extends('site.layout_site.site')
@section('title', isset($employer->enterprise_name) ? 'Đại lý Travelwork tại '.$employer->enterprise_name : 'Đại lý Travelwork')
<?php
$listtype = \App\Entity\TypeOfBusiness::getIdTypeBusiness($employer->type_of_business_id);
$meta_description = 'Đại lý Travelwork ' . $employer->enterprise_name;
if (!empty($employer->address)) {
    $meta_description .= ' tại ' . $employer->address;
}if (!empty($listtype->type_of_business_name)) {
    $meta_description .= ' trong loại hình doanh nghiệp ' . $listtype->type_of_business_name;
}
$meta_description = ucwords($meta_description);
?>
@section('meta_description') {{ $meta_description }} @endsection
@section('keywords', isset($employer->enterprise_name) ? 'Đại lý Travelwork tại '.$employer->enterprise_name : 'Đại lý Travelwork')
@section('meta_image', !empty($employer->image) ? asset($employer->image) : ''  )

@section('show_css')

    {{--<link rel="stylesheet" type="text/css" href="/public/assets/web/css/intership.css"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/css/intership.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/css/input_sale.css') }}"/>
    {{--<link rel="stylesheet" type="text/css" href="/public/assets/web/css/detail_job.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="/public/assets/web/css/input_sale.css"/>--}}
@endsection

@section('content')

    <section class="content bgrGray pdt5 detail_service_agency">
        <div class="container container_w_1200">
            <div class="row ">

                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="detailCompany bg-white mgt20 pd20" id="detailCompany">
                        <div class="row">

                            <div class="col-lg-2 col-md-3 col-12 mbdsNone">
                                <div class="logo mgb10">
                                    <div class="img_">
                                        <div class="CropImg CropImg70 CropImgMB60">
                                            <a class="thumbs" href=""
                                               title="{{ isset($employer->enterprise_name) ? $employer->enterprise_name : 'Công ty thực tập' }}">
                                                <img class=""
                                                     src="{{ isset($employer['image']) ? $employer['image'] : ''}}"
                                                     alt="{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}"/>
                                            </a>
                                        </div>
                                    </div>
                                    <p class="mgb5 text-center mgt10"><span
                                                class="fw6">Lượt xem : </span>{{ isset($employer->view) ? $employer->view : '' }}
                                    </p>
                                </div>
                            </div>


                            <div class="col-lg-7 col-md-6 col-12">
                                <h1 class="companyTitle f20 fw6 clhome mgb15 mbf18">{{ isset($employer->enterprise_name) ? $employer->enterprise_name : 'Công ty thực tập' }}</h1>

                                <div class="mgb15 companyDes">
                                    <div class="w100"><p class="mgb5"><span
                                                    class="fw6"><i class="fas fa-map mgr5 iconBuilding"></i> Địa chỉ : </span>{{ isset($employer->address) ? $employer->address : 'Đang cập nhật' }}
                                        </p></div>
                                    <div class="w100 mbw100">
                                        <p class="mgb5"><span
                                                    class="fw6"><i class="fa fa-phone" aria-hidden="true"></i> Số điện thoại :</span> {{ isset($employer->phone) ? $employer->phone : 'Đang cập nhật' }}
                                        </p>
                                    </div>
                                    <div class="w100 mbw100">
                                        <p class="mgb5"><span
                                                    class="fw6"> <i class="fas fa-building mgr5 iconBuilding"></i>Mã số thuế : </span> {{ isset($employer->tax_code) ? $employer->tax_code : 'Đang cập nhật' }}
                                        </p>


                                    </div>
                                    <div class="w100 mbw100">
                                        <p class="mgb5"><span  class="fw6"><i class="fas fa-map-marker-alt iconLocal"></i> Khu vực phụ trách : </span> {{ isset($employer->district_name) ? $employer->district_name : 'Đang cập nhật' }} - {{ isset($employer->province_name) ? $employer->province_name : 'Đang cập nhật' }}
                                        </p>


                                    </div>
                                    <div class="w100 mbw100">
                                        <p class="mgb5"><span
                                                    class="fw6"
                                                    style="color: black"><i class="fab fa-internet-explorer"></i> Website : </span> {{ isset($employer->website) ? $employer->website : 'Đang cập nhật' }}

                                        </p></div>

                                    <div class="w32 mbw49 dsInline dsNone mbdsBlock">
                                        <span class="fw6">Lượt xem : </span>{{ isset($employer->view) ? $employer->view : '' }}
                                    </div>



                                </div>

                            </div>
                            <div class="col-lg-3 col-md-3 col-12 service_agency">
                                <div class="logo w100">
                                    <div class="">
                                        <h3 class="companyTitle f20 fw6 clhome"><span class="pdl10 pdr10">Dịch vụ cung cấp</span></h3>
                                    </div>
                                    <div class="service_agency_content">
                                        {!! !empty($employer->service_agency) ? $employer->service_agency : '' !!}
                                    </div>
                                </div>


                            </div>



                        </div>


                    </div>

                    <div class="detailCompany bg-white mgt20 pd20 detailCompany_sticky">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="title">
                                    <h4 class="companyTitle f20 fw6 clhome text-center"><span
                                                class="pdl10 pdr10">Giới thiệu công ty</span></h4>
                                </div>
                                <div class="mgt20 mgb20 contentDetail js_remove_href_a">
                                    <div>
                                        <?php
                                        $content_reomove_script = '';
                                        if (!empty($employer->introduction)) {
                                            $content_reomove_script = App\Ultility\Ultility::preg_replace_script($employer->introduction);
                                        }
                                        ?>
                                        {!! !empty($content_reomove_script) ? $content_reomove_script : 'Đang cập nhật' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--//sidebar_intership--}}


            </div>
        </div>
    </section>

    @include('site.default_site.list_agency')
    @include('site.default_site.list_sale')


    {{--@include('site.employer_site.item_post_intership_new')--}}
    {{--@include('site.module_index.hotline')--}}


@endsection
@section('show_js')

@endsection
