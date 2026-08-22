@extends('site.layout.site')

<?php
$title = 'Tuyển nhân viên du lịch';
$caneer_id = isset($_GET['c']) ? $_GET['c'] : '';
$caneer = \App\Entity\Career::getIdCareer($caneer_id);
if(!empty($caneer))
{
    $title = 'Tuyển '.$caneer->career_category_name;
}
$province_id = isset($_GET['p']) ? $_GET['p'] : '';
$province = \App\Entity\Province::getId($province_id);
if(!empty($province))
{
    $title .= ' tại '.$province->province_name;
}
$title = ucwords($title);
?>
@section('type_meta', 'website')
@section('title', $title)
@section('meta_description', $title.' Từ Các Công Ty Uy Tín Trên sanketoan.vn')
@section('keywords',$title)
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')


@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">

                @include('site.sidebar.sidebar_search_job')

                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgt5 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_job_face') }}" class=" f18 md-f14 mgb0">Danh sách việc làm</a>
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
                            <h1 class="titleJobs  fw6 f20 mgb0 col-f14">
                                Việc làm du lịch
                            </h1>

                            {{--( {{ isset($total) ? $total : '0'  }} việc làm)--}}
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                {{--//truyen bien hien thi image trng serach de biet tin la tin gi--}}
                                @foreach($list_jobs as $job)
                                    @include('site.jobs.item_job',['image'=>'job'])
                                @endforeach

                                @foreach ($list_job_fb as $jobFacebook)
                                    @include('site.job_facebook.item_job_facebook',['image'=>'job_fb'])
                                @endforeach
                            </div>
                        </div>



                    </section>
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="row">
                            <div class="col-12 text-center">
                                @if($total_jobs < 10 && $total_job_fb < 10)
                                @elseif($total_jobs >= $total_job_fb && $total_jobs == 0)
                                    @include('site.default.item_pani',['page_link' => $total_jobs])
                                    @else
                                    @include('site.default.item_pani',['page_link' => $list_job_fb])
                                    @endif

                            </div>
                        </div>
                    </section>



                    <section class="tabfillter bgrWhite mgt20 mgb20  mbdsNone">
                        <div class="row">

                            <div class="col-lg-12">

                                <ul class="nav nav-tabs mbdsNone" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Việc làm theo ngành nghề</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Việc làm theo tỉnh / thành phố</a>
                                    </li>



                                </ul>
                                <ul class="nav nav-tabs dsNone mbdsBlock" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Việc làm theo ngành nghề</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Việc làm theo tỉnh / thành phố</a>
                                    </li>



                                </ul>
                                <div class="tab-content pd20" id="myTabContent">

                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                        <div class="row">
                                            <?php
                                            $list_career = \App\Entity\Career::orderBy('career_category_name')->get();
                                            ?>
                                            @foreach($list_career as $career)
                                                <?php
                                                $text_link = route('seacrh_job_facebook',['slug'=>'tuyen-'.$career->career_category_slug.'?c='.$career->career_category_id]);
                                                //                                                    echo $text;
                                                $total_career = 0;
                                                $total_career_job =  \App\Entity\Job::get_total_career($career->career_category_id);
                                                $total_career_job_facebook =  \App\Entity\JobFacebook::get_total_career($career->career_category_id);
                                                $total_career = $total_career_job + $total_career_job_facebook;
                                                ?>
                                                @if($total_career != 0)
                                                    <div class="col-lg-4 col-md-6 col-6">


                                                        <a class="linkFillter" href="{{ $text_link }}"> <p class=" mgb10"><i class="fas fa-list-ul f14 mgr5"></i>{{$career->career_category_name}} <sup class="blueN fw6">({{ $total_career }})</sup>
                                                            </p>
                                                        </a>
                                                    </div>
                                                @endif

                                            @endforeach
                                        </div>

                                    </div>
                                    <div class="tab-pane fade " id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="remoreBusiness">
                                            <div class="row">
                                                <?php
                                                $getAllProvince = \App\Entity\Province::GetAllProvinces();
                                                ?>
                                                @foreach($getAllProvince as $province)
                                                    <?php
                                                    $text_link = route('seacrh_job_facebook',['slug'=>'tuyen-'.$province->province_slug.'?p='.$province->province_id]);
                                                    //                                                    echo $text;
                                                    $total_province = 0;
                                                    $total_province_job =  \App\Entity\Job::get_total_province($province->province_id);
                                                    $total_province_job_facebook =  \App\Entity\JobFacebook::get_total_province($province->province_id);
                                                    $total_province = $total_province_job + $total_province_job_facebook;
                                                    ?>
                                                    @if($total_province != 0)

                                                        <div class="col-lg-3 col-md-4 col-6">

                                                            <a class="linkFillter" href="{{ $text_link }}">
                                                                <p class=" mgb10"><i class="fas fa-map-marker-alt f14 mgr5"></i>{{$province->province_name}} <sup class="blueN fw6">({{ $total_province }})</sup>
                                                                </p>
                                                            </a>
                                                        </div>
                                                    @endif

                                                @endforeach


                                            </div>
                                        </div>
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

    @include('site.mobile_bottom.fixel_bottom_category_job')

@endsection
