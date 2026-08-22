@extends('site.layout.site')
@section('title', isset($category->title) ? $category->title : '')
@section('meta_description',  isset($category->description) ? $category->description : '' )
@section('keywords', '')
@section('content')
<div class="container mgt20">
<div class="row">

<section class="col-xl-12 col-lg-12 col-md-12 jobsNew bgrWhite bdLightGray radius5  createProfileOnline" >
    <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
       Tìm kiếm việc làm 
    </div>

    @include('site.module_index.filter')
    <div class="contentJobsNew col-f14">

     @foreach($jobs as $job)
        <div class="bdBottomGray hvbgrClick hvBoxShadow">
            <a href="/cong-viec/{{$job->slug}}" class="noDecoration">
                <div class="row pdt10">
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 image block mg textCenter md-textLeft">
                        <img data-src="{{isset($job->image) ? $job->image : '$job->employer_image'}}" alt="mb" class="w65 lazy lg-w100 sm-w50">
                    </div>
                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12 info">
                        <p class="fontBold textCap black mgb0 CutText100"> {{$job->title}}</p>
                        <p class="nameCompany mgb5 gray CutText100"><i>{{$job->enterprise_name}}</i>
                        </p>
                        <p class="black"><span><i class="fas fa-hand-holding-usd money"></i> Lương:
                                {{$job->salary_description}} &nbsp;&nbsp;&nbsp;</span> <span class="col-block"><i class="far fa-clock"></i> Hạn nộp: {{$job->date_end}}
                                &nbsp;&nbsp;&nbsp;</span> <span class="lg-block"><i class="fas fa-map-marker-alt address"></i> {{$job->district_name}} -
                                {{$job->province_name}} </span></p>
                    </div>
                </div>
            </a>
        </div>

      @endforeach
   
    </div>
</section>
</div>
</div>
@endsection