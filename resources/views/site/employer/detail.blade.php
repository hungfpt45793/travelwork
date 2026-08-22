@extends('site.layout.site')
@section('title', $employer->enterprise_name)
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')
@section('meta_image', $information['logo'] )

@section('content')

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
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
                                <p class=" f18 md-f14 mgb0">Cổng quản lý</p>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <p class=" f18 md-f14 mgb0">{{$employer->enterprise_name}}</p>
                            </li>
                        </ul>
                    </div>

                    <div class="InfoCompanyJob mgt20">
                        <div class="main">
                            <div class="notificationBox bkwhite formJobLarge ">
                                <div class="bodyBox row">
                                    <div class="col-xl-3">
                                        <img class="lazy" data-src="{!! isset($employer->image) ? $employer->image : '/CV/noimage.png' !!}"
                                             alt="" class="w100">
                                    </div>
                                    <div class="col-xl-9">
                                        <h5 class="fontBold"> {{$employer->enterprise_name}}</h5>
                                        <p><i class="fas fa-map-marker-alt"></i> Địa chỉ:{{$employer->address}}</p>

                                        <p><i class="fas fa-phone"></i> Hotline: {{$employer->phone}}</p>
                                        {{--<p><i class="fab fa-internet-explorer"></i> Email: {{$employer->email}}</p>--}}

                                        <p class="mg0">{!!$employer->introduction!!}</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <section class="jobsSimilar bgrWhite bdLightGray radius5 mgt20">
                            <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                                VIỆC LÀM CÙNG NHÀ TUYỂN dụng
                            </div>
                            <div class="contentJobsSimilar pdl10 pdr10 col-f14">

                                @foreach(App\Entity\Job::showJobWithEmployerId($employer->employer_id, 20) as $allJobRelative)
                                    <div class="bdBottomGray hvbgrClick">
                                        <a href="/cong-viec/{{$allJobRelative->slug}}"
                                           class="noDecoration block  pdl10 pdr10 hvBoxShadow">
                                            <div class="row pdt10 lg-pd10 col-f12">
                                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="infoSimilar inBlock CutText101 pdl6p xl-pdl8p sm-pdl12p">
                                                        <p class="fontBold textCap black mgb0"> {{isset($allJobRelative->title) ? $allJobRelative->title :''}}</p>
                                                        <p class="nameCompany mgb5 gray">
                                                            <i>{{isset($employer->enterprise_name) ? $employer->enterprise_name :''}}</i>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 black textCenter lg-textLeft lg-mg lg-block">
                                                    <span class="lg-inBlockIm"><i
                                                                class="fas fa-hand-holding-usd money"></i> Lương</span>
                                                    <span class="block lg-inBlockIm">{{isset($allJobRelative->salary_description) ? $allJobRelative->salary_description :'Đang cập nhật'}}</span>
                                                </div>
                                                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 black textCap textCenter lg-textLeft lg-mg lg-block">
                                                    <span class="block lg-inBlockIm">{{$allJobRelative->district_name}}
                                                        - <span class="block lg-inBlockIm">{{$allJobRelative->province_name}}</span></span>
                                                </div>
                                                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 black textCenter lg-textLeft lg-mg lg-block">
                                                    <span class="lg-inBlockIm"><i
                                                                class="fas fa-clock"></i> Hạn nộp</span>
                                                    <span class="block lg-inBlockIm">{{$allJobRelative->deadline_submit_profile}}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach

                                <div class="col-12 text-center hvbgrBlueN">
                                    <a href="{{route('list_cate_job')}}" class="block hvWhite pd10">Xem tất cả việc
                                        làm</a>
                                </div>
                            </div>
                        </section>
                        <div class="main mgt20">
                            <div class="notificationBox bkwhite formJobLarge ">
                                <div class="bodyBox">
                                    <p class="font600">Bạn đang xem các danh sách công việc của: <span class="blueDN">Công ty Golden
                                 Gate</span></p>
                                    <div class="text-center">
                                        <p class="mg0 mgr20 disInBlock">Bạn có muốn nhận thông báo việc làm mới nhất từ
                                            Nhà tuyển
                                            dụng này?</p>
                                        <a href="" class="pd10-30 fontBold white noDecoration hvWhite bgrBlueN">Nhận
                                            thông báo</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @include('site.module_index.dang-ky-tu-van')
                        @include('site.module_index.hotline')
                    </div>
                </div>
            </div>
    </section>


@endsection

