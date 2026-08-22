@extends('site.layout.site')

<?php
    $title = 'Tuyển kế toán';
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
@section('meta_image', isset($infomation['logo']) ? asset($infomation['logo']) : '')


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
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                            <h1 class="f18 fw7 mgb0">{{ $title }}</h1>
                            {{--( {{ $total_jobs }} việc làm)--}}
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                @foreach($jobs as $job)
                                    @include('site.jobs.item_job',['job'=>$job])
                                @endforeach

                            </div>
                        </div>
                    </section>

                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="row">
                            <div class="col-12 text-center">
                                {{$jobs->links()}}
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