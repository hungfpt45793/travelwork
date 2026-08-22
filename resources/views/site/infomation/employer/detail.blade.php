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
                                <a href="#" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                        </ul>
                    </div>

                    <div class="InfoCompanyJob mgt20">
                        <div class="main">
                            <div class="notificationBox bkwhite formJobLarge ">
                                <div class="bodyBox row">
                                    <div class="col-xl-3">
                                        <img src="{!! isset($employer->image) ? $employer->image : '/CV/noimage.png' !!}"
                                             alt="" class="w100">
                                    </div>
                                    <div class="col-xl-9">
                                        <h1 class="fontBold f20"> {{$employer->enterprise_name}}</h1>
                                        <p class="mgb5"><i class="fas fa-map-marker-alt"></i> Địa
                                            chỉ:{{$employer->address}}</p>

                                        <p class="mgb5"><i class="fas fa-phone"></i> Hotline: {{$employer->phone}}</p>
                                        <p class="mgb5"><i class="far fa-envelope"></i> Email: {{$employer->email}}</p>

                                        <p class="mg0">{!!$employer->introduction!!}</p>

                                        <div class="jsSocial mgb10">
                                            <script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js"></script>
                                            <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                                                <a class="addthis_button_facebook"></a>
                                                <a class="addthis_button_twitter"></a>
                                                <a class="addthis_button_email"></a>
                                                <a class="addthis_button_pinterest_share"></a>
                                                <a class="addthis_button_compact"></a>
                                                <a class="addthis_counter addthis_bubble_style"></a>
                                            </div>
                                        </div>
                                        <div class="ContentPost">
                                            <div style="display: inline-block;">
                                                <script src="https://sp.zalo.me/plugins/sdk.js"></script>
                                                <div class="zalo-share-button" data-href="{{ \App\Ultility\Ultility::getUrl() }}" data-oaid="579745863508352884" data-layout="2" data-color="blue" data-customize=true style="background: #03a3fb;color: #fff;padding: 1px 10px;"><img src="{{ asset('assets/image/logozalo.jpg') }}" style="width: 30px;" >Chia sẻ Zalo</div>
                                            </div>
                                        </div>

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

                    </div>
                </div>
                @include('site.module_index.hotline')
            </div>
        </div>
    </section>


@endsection

