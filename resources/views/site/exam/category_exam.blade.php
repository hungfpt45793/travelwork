@extends('site.layout.site')

<?php
$slug = 'danh-muc/tat-ca-de-thi-ke-toan';
$meta_exam = \App\Entity\Config_meta::getslug($slug);
?>

@section('type_meta', 'website')
@section('title', !empty($meta_exam->meta_title) ? $meta_exam->meta_title :'Tất cả đề thi')
@section('meta_description', !empty($meta_exam->meta_description) ? $meta_exam->meta_description :'Tất cả đề thi')
@section('keywords', !empty($meta_exam->meta_keywords) ? $meta_exam->meta_keywords :'Tất cả đề thi')
@section('meta_image', !empty($meta_exam->image) ?  asset($meta_exam->image) : asset($information['logo'])  )



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

