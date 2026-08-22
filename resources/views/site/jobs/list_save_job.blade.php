@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Việc làm đã lưu')

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
                                <a href="#" class=" f18 md-f14 mgb0">Việc làm đã lưu</a>
                            </li>

                        </ul>
                    </div>
                    {{--@include('site.filter.filter_job')--}}
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>

                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14">
                            Việc làm đã lưu từ công việc du lịch (đã kiểm duyệt)
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                @if(!empty($jobs))
                                @foreach($jobs as $job)
                                        <div class="col-xl-6 col-lg-6 pd0 bdBottomGray bdRightGray hvbgrClick">
                                            <div class="JobInteresting pd hvBoxShadow">

                                                <?php $distinct = \App\Entity\District::getId($job['district']) ?>
                                                <?php $province = \App\Entity\Province::getId($job['province']) ?>

                                                <div class="company @if($job->vip == 1) newVip @endif">
                                                    <a href="{{ route('job_detail',['slug' => $job->slug ]) }}" class="block pd15 noDecoration CutText100">
         <span class="textCap black maxTitleVoucher dsBlock   @if(!empty($image) && $image = 'job') mgRight50 @endif"> @if($job->vip == 1)
                 <img class="lazy" src="{{ asset('assets/image/vip1.png') }}" width="40px">
             @else
             @endif <b style="vertical-align: bottom;" class="cutTitle">
         {{ isset($job['title']) ? \App\Ultility\Ultility::textLimit($job['title'], 15) : '' }}
         </b>
             @if(!empty($image) && $image = 'job')
                 <img class="chuaxathuc lazy chuaxacthucItemJob" src="{{ asset('assets/image/xacthuc.jpg') }}"
                      title="Xác thực tại sanketoan.vn" alt="Xác thực tại sanketoan.vn">
             @endif
         </span>




                                                        <?php
                                                        $employer_id = $job['employer_id'];
                                                        $employer = \App\Entity\Employer::getIdemployer($employer_id);

                                                        ?>
                                                        <span class="block gray itemVoucher dsBlock @if(!empty($image) && $image = 'job') mgRight50 @endif"><i class="cutTitle ">{{ isset($employer['enterprise_name']) ? \App\Ultility\Ultility::textLimit($employer['enterprise_name'], 15) : '' }}
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

                                                        <span class="block"><span class="black"><i class="fas fa-hand-holding-usd money"></i>
         Lương:
                                                                @if(!empty($job->salary_description))
                                                                    {{$job->salary_description}}
                                                                    &nbsp;&nbsp;&nbsp;
                                                                @else
                                                                    Đang cập nhật
                                                                @endif
         </span> <span class="sm-block pull-right float-right clorange"><i
                                                                        class="far fa-clock"></i> Hạn nộp:
                                                                <?php
                                                                $deadline=date_create($job['deadline_submit_profile']);
                                                                echo date_format($deadline,"d/m/Y");
                                                                ?>
                                                            </span></span>

                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </section>


                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs fw6 f20 white bgrBlueN pd10-20 col-f14">
                            Việc làm đã lưu từ công việc du lịch (chưa kiểm duyệt)
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                @foreach ($jobFacebooks as $jobFacebook)

                                    <div class="col-xl-6 col-lg-6 pd0 bdBottomGray bdRightGray hvbgrClick">
                                        <div class="JobInteresting pd hvBoxShadow ">
                                            <?php $distinct = \App\Entity\District::getId($jobFacebook['district']) ?>
                                            <?php $province = \App\Entity\Province::getId($jobFacebook['province']) ?>



                                            <div class="company @if($jobFacebook->vip == 1) newVip @endif">
                                                <a href="{{ route('detail_job_face', ['slug' => $jobFacebook->slug]) }}"
                                                   class="block pd15 noDecoration CutText100">

                 <span class="textCap black maxTitleVoucher dsBlock @if(!empty($image) && $image = 'job_fb') mgRight50 @endif"> @if($jobFacebook->vip == 1)
                         <img class="lazy" src="{{ asset('assets/image/vip1.png') }}" width="40px">
                     @else
                     @endif <b style="vertical-align: bottom;" class="cutTitle">
         {{ isset($jobFacebook->title) ? \App\Ultility\Ultility::textLimit($jobFacebook->title, 15) : '' }}
         </b></span>
                                                    @if(!empty($image) && $image = 'job_fb')
                                                        @if($jobFacebook->vip == 1)
                                                            <img class="chuaxathuc lazy chuaxacthucItemJob" src="{{ asset('assets/image/xacthuc.jpg') }}"
                                                                 title="{{ $jobFacebook->title }}" alt="{{ $jobFacebook->title }}">
                                                        @else
                                                            <img class="chuaxathuc lazy chuaxacthucItemJob"
                                                                 src="{{ asset('assets/image/chuaxacthuc.png') }}"
                                                                 title="{{ $jobFacebook->title }}" alt="{{ $jobFacebook->title }}">
                                                        @endif
                                                    @endif


                                                    <span class="block gray itemVoucher dsBlock @if(!empty($image) && $image = 'job_fb') mgRight50 @endif"><i class="cutTitle ">
                        {{ isset($jobFacebook['company_name']) ? \App\Ultility\Ultility::textLimit($jobFacebook['company_name'], 15) : 'Đối tác của Travelwork ' }}
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
                                                    <span class="black">
         <i class="fas fa-hand-holding-usd money"></i>
         Lương: {{ $jobFacebook->salary_description }}&nbsp;
         </span>
                                                    <span class="text-right clorange fright">
                    <i class="far fa-clock"></i>
                    Ngày đăng tin: <?php
                                                        $date = date_create($jobFacebook->date_end);
                                                        ?>Hạn nộp: {{ date_format($date,"d/m/Y") }}
                </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>



                                @endforeach

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
