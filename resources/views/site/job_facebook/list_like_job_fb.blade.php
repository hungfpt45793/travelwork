@extends('site.layout.site')

@section('title', 'Việc làm trên Facebook')
@section('meta_description', 'Việc làm trên Facebook')
@section('keywords', 'Việc làm trên Facebook')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')

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
                                <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> Danh sách việc làm yêu thích</a>
                            </li>

                        </ul>
                    </div>
                    @include('site.filter.filter_job_face')
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>

                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14">
                             Việc làm yêu thích ( {{ isset($total) ? $total : '0'  }} việc làm)
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                @foreach ($jobFacebooks as $jobFacebook)
                                    <div class="col-xl-6 col-lg-6 pd0 bdBottomGray bdRightGray hvbgrClick">
                                        <div class="JobInteresting pd hvBoxShadow">
                                            <div class="company">
                                                <a href="{{ route('detail_job_face', ['slug' => $jobFacebook->slug]) }}"
                                                   class="block pd15 noDecoration CutText100">
                                                    <span class=" black" style="display: block"><b>
                                                             {{ isset($jobFacebook->title) ? \App\Ultility\Ultility::textLimit($jobFacebook->title, 12) : '' }}

                                                          </b></span>

                                                    <?php $distinct = \App\Entity\District::getId($jobFacebook['district']) ?>
                                                    <?php $province = \App\Entity\Province::getId($jobFacebook['province']) ?>
                                                    <i> <span class="block gray"><i
                                                                    class="fas fa-map-marker-alt"></i>
                                                            @if(isset($distinct->district_name))
                                                                {{ $distinct->district_name }} -
                                                            @endif
                                                            @if(isset($province->province_name))
                                                                {{ $province->province_name }}
                                                            @endif


                                                    </span>
                                                    </i>

                                                    <span class="black">
                                                          <i class="fas fa-hand-holding-usd money"></i>
                                                          Lương: {{ $jobFacebook->salary_description }}&nbsp;
                                                      </span>


                                                    <span class="text-right clorange fright">
                                                        <i class="far fa-clock"></i>
                                                        <?php
                                                        $date = date_create($jobFacebook->date_end);
                                                        ?>Hạn nộp: {{ date_format($date,"d/m/Y") }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                                <div class="col-12 text-center">
                                    {{ $jobFacebooks->links() }}
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