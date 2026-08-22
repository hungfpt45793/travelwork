@extends('site.layout.site')
<?php
$title = 'Danh sách đề thi du lịch ';
    if (!empty($_GET['t'])) {
        $type_of_business = \App\Entity\TypeOfBusiness::getIdTypeBusiness($_GET['t']);
        $title .= 'cho ' . $type_of_business->type_of_business_name .' ';
    }
    if (!empty($_GET['c'])) {
        $career = \App\Entity\Career::getIdCareer($_GET['c']);
        $title .= 'với vị trí '. $career['career_category_name'];
    }

$title = ucwords($title);
?>
{{--@section('type_meta', 'website')--}}
@section('title', $title)
@section('meta_description','Tổng hợp '. $title.' tại sanketoan.vn')
@section('keywords', $title)
@section('meta_image', !empty($category->image) ?  asset($category->image) : asset($information['logo']) )
{{--@section('meta_url', '/danh-muc/'.$category->slug)--}}
@section('content')

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline">
                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgt5 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>

                            <li class="nav-item pd8">
                                <?php
                                $link_url ='#';
                                $link_url = \App\Ultility\Ultility::getUrl();
                                ?>
                                <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> Danh sách đề thi</a>
                            </li>

                        </ul>
                    </div>

                    @include('site.filter.filter_exam')
                    <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                        Tất cả đề thi
                    </div>
                    <div class="categoryQuestion">
                        <div class="main">
                            <div class="notificationBox bkwhite formJobLarge sm-f14">
                                <div class="bodyBox ">
                                    <div class="row">
                                        @if(!empty($exams))
                                            @foreach($exams as $exam)
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    @include('site.partials_exam.item_exam')
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="col-lg-12">
                                            <nav aria-label="Page navigation example" class="text-center">

                                                @include('site.default.item_pani',['page_link' => $exams])
                                            </nav>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>



                    @include('site.module_index.dang-ky-tu-van')


                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>



@endsection

