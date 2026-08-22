@extends('site.layout.site')

@section('type_meta', 'website')

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

                        </ul>
                    </div>
                    @include('site.filter.filter_job')
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>

                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14">
                            Việc làm yêu thích từ nhà tuyển dụng ( {{ $total_jobs }} việc làm)
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                @if(!empty($jobs))
                                @foreach($jobs as $job)

                                    <div class="col-xl-6 col-lg-6 pd0 bdBottomGray bdRightGray hvbgrClick">
                                        <div class="JobInteresting pd hvBoxShadow">
                                            <div class="company">
                                                <a href="{{ route('job_detail',['slug' => $job->slug ]) }}" class="block pd15 noDecoration CutText100">
                                                    <span class="textCap black maxTitleVoucher dsBlock"><b>
                                                            {{ isset($job['title']) ? \App\Ultility\Ultility::textLimit($job['title'], 10) : '' }}
                                                          </b></span>

                                                    <?php
                                                    $employer_id = $job['employer_id'];
                                                    $employer = \App\Entity\Employer::getIdemployer($employer_id);

                                                    ?>
                                                    <span class="block gray itemVoucher dsBlock"><i>{{ isset($employer['enterprise_name']) ? \App\Ultility\Ultility::textLimit($employer['enterprise_name'], 10) : '' }}
                                                            </i></span>

                                                    <span class="block"><span class="black"><i class="fas fa-hand-holding-usd money"></i>
                                                        Lương:
                                                            @if(!empty($job->salary_description))
                                                                {{$job->salary_description}}
                                                                triệu &nbsp;&nbsp;&nbsp;
                                                            @else
                                                                Đang cập nhật
                                                            @endif
                                                     </span> <span class="sm-block pull-right float-right clorange"><i class="far fa-clock"></i> Hạn nộp: <?php
                                                            $deadline=date_create($job['deadline_submit_profile']);
                                                            echo date_format($deadline,"d/m/Y");
                                                            ?></span></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-12 text-center">
                                    {{$jobs->links()}}
                                </div>
                                    @endif
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