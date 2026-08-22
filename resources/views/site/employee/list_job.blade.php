@extends('site.layout.site')

@section('title', 'Danh sách phần mềm bạn có thể đổi')
@section('meta_description', 'Danh sách phần mềm bạn có thể đổi')
@section('keywords', 'Danh sách phần mềm bạn có thể đổi')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">

                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20 mgb10">
                        <ul class="nav">
                            <li class="nav-item pd8">

                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">

                                <a href="{{ route('post_sale_employee') }}" class="f18 md-f14 blueDN hvBlueDN"> <i
                                            class="fas fa-donate mgr5"></i>Kiếm tiền từ chia sẻ bài</a>
                            </li>
                        </ul>
                    </div>
                    @include('site.employee.item_list_redeem')
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">

                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <div class="CV bgrWhite radius5 pd20 mbpd0 mgb20 pdb5">

                                        @include('site.employee.item_total_money')


                                    </div>

                                </div>


                            </div>
                        </div>
                    </section>
                    <section class="categoryPostSale">
                        <div class="container bg-white">
                            <div class="row">
                                <div class="col-lg-9 PostSaleLeft">
                                    <h1 class=" f22 lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb20 mgt20">
                                        Danh sách tin tuyển dụng chia sẻ kiếm tiền
                                    </h1>
                                    @if(!empty($list_jobs))
                                        @foreach($list_jobs as $job)
                                            <a href="{{ route('job_detail',['slug' => $job->slug ]) }}">
                                                <div class="row itemPostSale">
                                                    <?php $distinct = \App\Entity\District::getId($job['district']) ?>
                                                    <?php $province = \App\Entity\Province::getId($job['province']) ?>
                                                    <div class="col-md-12 contentPostSale">
                                                        <a href="{{ route('job_detail',['slug' => $job->slug ]) }}"
                                                           class="" title="{{ $job['title'] }}"><h3
                                                                    class="clorang f18 fw6"
                                                                    style="text-transform: unset">
                                                                @if($job->vip == 1)
                                                                    <img class="lazy" data-src="{{ asset('assets/image/vip1.png') }}" width="40px">
                                                                @else
                                                                @endif
                                                                {{ $job['title'] }}</h3>
                                                        </a>
                                                        <?php
                                                        $employer_id = $job['employer_id'];
                                                        $employer = \App\Entity\Employer::getIdemployer($employer_id);
                                                        ?>

                                                        <p class="mgb5"> Đăng bởi: <span
                                                                    class="fw6"> {{ isset($employer['enterprise_name']) ? \App\Ultility\Ultility::textLimit($employer['enterprise_name'], 15) : '' }} </span>
                                                        </p>

                                                        <p class="mgb5">
                                                          <span class="black">
                     <i>
                    <span class="block"><i class="fas fa-map-marker-alt blueN "></i>
                        @if(isset($distinct->district_name))
                            {{ $distinct->district_name }}
                        @endif
                        @if(!empty($distinct->district_name))
                            -
                        @endif
                        @if(isset($province->province_name))
                            {{ $province->province_name }}
                        @endif
                    </span>
            </i>
                </span>

                                                            <span class="block"><span class="black"><i
                                                                            class="fas fa-hand-holding-usd money"></i>
         Lương:
                        @if(!empty($job->salary_description))
                                                                        {{$job->salary_description}}
                                                                        &nbsp;&nbsp;&nbsp;
                                                                    @else
                                                                        Đang cập nhật
                                                                    @endif
         </span> <span class="sm-block pull-right float-right clorange"><i
                                                                            class="far fa-clock"></i> Ngày đăng tin: <?php

                                                                    $date_facebook = \App\Ultility\Ultility::getdateFacebook($job['updated_at']);
                                                                    echo $date_facebook;


                                                                    ?></span>
                                                        </span>

                                                        </p>
                                                        <p class="mgb5">
                                                            <?php
                                                            $total_sum_share = \App\Entity\Job_sale_statistical::getTotalShare($job->job_id);
                                                            //
                                                            $total_sum_view_share = \App\Entity\Job_sale_statistical::getTotalViewSale($job->job_id);
                                                            ?>


                                                            Lượt chia sẻ : <span
                                                                    class="fw6">{{ number_format($total_sum_share) }}</span>
                                                            <i class="fas fa-share"></i> - Lượt xem : <span
                                                                    class="fw6">{{ number_format($total_sum_view_share) }}</span>
                                                            <i class="far fa-eye"></i>
                                                        </p>

                                                        <a href="{{ route('job_detail',['slug' => $job->slug ]) }}"
                                                           class="link">Xem thêm</a>
                                                    </div>


                                                </div>
                                            </a>
                                        @endforeach
                                    @endif

                                    <div class="row pagePostSale">
                                        <div class="col-12 text-center">

                                            @include('site.default.item_pani',['page_link' => $list_jobs])

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 PostSaleRight">
                                    <h2 class=" f22 lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb20 mgt20">
                                        Danh sách tin tuyển dụng mới
                                    </h2>

                                    <div class="row itemPostSale">
                                        @if(!empty($list_jobs_new))
                                            @foreach($list_jobs_new as $job)
                                                <div class="col-xl-12 col-lg-12 pd0 bdBottomGray bdRightGray hvbgrClick">
                                                    <div class="JobInteresting pd hvBoxShadow">

                                                        <?php $distinct = \App\Entity\District::getId($job['district']) ?>
                                                        <?php $province = \App\Entity\Province::getId($job['province']) ?>

                                                        <div class="company @if($job->vip == 1) newVip @endif">
                                                            <a href="{{ route('job_detail',['slug' => $job->slug ]) }}"
                                                               class="block pd15 noDecoration CutText100"
                                                               title="{{ $job['title'] }}">
         <span class="textCap black maxTitleVoucher dsBlock   @if(!empty($image) && $image = 'job') mgRight50 @endif"> @if($job->vip == 1)
                 <img class="lazy" data-src="{{ asset('assets/image/vip1.png') }}" width="40px">
             @else
             @endif <b style="vertical-align: bottom;" class="cutTitle">
         {{ isset($job['title']) ? \App\Ultility\Ultility::textLimit($job['title'], 15) : '' }}
         </b>
             @if(!empty($image) && $image = 'job')
                 <img class="chuaxathuc chuaxacthucItemJob lazy" data-src="{{ asset('assets/image/xacthuc.jpg') }}"
                      title="Xác thực tại sanketoan.vn" alt="Xác thực tại sanketoan.vn">
             @endif
         </span>


                                                                <?php
                                                                $employer_id = $job['employer_id'];
                                                                $employer = \App\Entity\Employer::getIdemployer($employer_id);

                                                                ?>
                                                                <span class="block gray itemVoucher dsBlock @if(!empty($image) && $image = 'job') mgRight50 @endif"><i
                                                                            class="cutTitle ">{{ isset($employer['enterprise_name']) ? \App\Ultility\Ultility::textLimit($employer['enterprise_name'], 15) : '' }}
         </i></span>

                                                                <span class="black">
                     <i>
                    <span class="block"><i class="fas fa-map-marker-alt blueN "></i>
                        @if(isset($distinct->district_name))
                            {{ $distinct->district_name }}
                        @endif
                        @if(!empty($distinct->district_name))
                            -
                        @endif
                        @if(isset($province->province_name))
                            {{ $province->province_name }}
                        @endif
                    </span>
            </i>
                </span>

                                                                <span class="block"><span class="black"><i
                                                                                class="fas fa-hand-holding-usd money"></i>
         Lương:
                        @if(!empty($job->salary_description))
                                                                            {{$job->salary_description}}
                                                                            &nbsp;&nbsp;&nbsp;
                                                                        @else
                                                                            Đang cập nhật
                                                                        @endif
         </span> </span>
                                                                <span class="dsBlock mgt5 clorange"><i
                                                                            class="far fa-clock"></i> Ngày đăng tin: <?php

                                                                    $date_facebook = \App\Ultility\Ultility::getdateFacebook($job['updated_at']);
                                                                    echo $date_facebook;


                                                                    ?></span>

                                                                <a href="{{ route('job_detail',['slug' => $job->slug ]) }}"
                                                                   class="link" style="margin-top: 0;
    margin-left: 10px;
    margin-bottom: 10px;
display: inline-block;
    padding: 5px 30px;
    background: #009385;
    color: #fff;
    border-radius: 30px;" title="{{ $job['title'] }}">Xem thêm</a>

                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>


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
    <script src="{{ asset('adminstration/jquery.priceformat.js') }}"></script>
    <script>
        $('.formatPrice').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.'
        });
    </script>
    @include('site.partials.delete')


@endsection