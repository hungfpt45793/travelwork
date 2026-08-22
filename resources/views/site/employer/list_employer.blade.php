@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Danh sách công ty tại Travelwork')
@section('meta_description', 'Danh sách công ty tại Travelwork')
@section('keywords', 'Danh sách công ty tại Travelwork')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : ''  )

@section('content')
    <section class="content bgrGray pdt5">
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
                                <?php
                                $link_url ='#';
                                $link_url = \App\Ultility\Ultility::getUrl();
                                ?>
                                <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN">  Danh sách công ty</a>
                            </li>

                        </ul>
                    </div>
                    @include('site.filter.filter_employer')
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                            Danh sách doanh nghiệp
                            {{--( {{ theo bảng thong ke so tiền }} việc làm)--}}
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                @foreach($list_employer as $employer)
                                    @include('site.employer.item_list_employer')
                                @endforeach

                            </div>
                            <div class="row">
                                <div class="col-12 text-center">

                                    @include('site.default.item_pani',['page_link' => $list_employer])


                                    {{--{{ $list_employer->onEachSide(5)->links() }}--}}
                                    {{--{{ $list_employer->links()--}}

                                     {{--}}--}}
                                </div>
                            </div>
                        </div>
                    </section>

                    @include('site.module_index.dang-ky-tu-van')

                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>


@endsection
