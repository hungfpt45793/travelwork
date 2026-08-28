@extends('site.layout_site.site')
<?php
$slug = 'tuyen-thuc-tap-ke-toan/danh-sach-cong-ty';
$meta_exam= \App\Entity\Config_meta::getslug($slug);

?>
@section('type_meta', 'website')
@section('title', !empty($meta_exam->meta_title) ? $meta_exam->meta_title :'Thực tập về du lịch')
{{--//nối thêm chuoix tại thanh phố hoac--}}
@section('meta_description', !empty($meta_exam->meta_description) ? $meta_exam->meta_description :'Thực tập về du lịch')
@section('keywords', !empty($meta_exam->meta_keywords) ? $meta_exam->meta_keywords :'Thực tập về du lịch')
@section('meta_image', !empty($meta_exam->image) ? asset($meta_exam->image) : asset($information['logo']) )

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/web/css/tab_filter.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/intership.css"/>
@endsection

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">

                <div class="col-xl-9 col-lg-9 col-md-12 createProfileOnline ">

                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <?php
                                $link_url ='#';
                                $link_url = \App\Ultility\Ultility::getUrl();
                                ?>
                                <a href="{{ $link_url }}" class=""> <i class="fas fa-link white mgr5"></i> Cổng thực tập</a>
                            </li>
                        </ul>
                    </div>
                    @include('site.filter_site.filter_intership')


                    <section class="list_intership">
                        <div class="title_intership text-center">
                          <h1>Danh sách các công ty nhận thực tập về du lịch</h1>
                            {{--( {{ isset($total) ? $total : '0'  }} việc làm)--}}
                        </div>
                        <div class="content_intership">
                            <div class="row">
                                @foreach ($employers as $employer)
                                    @include('site.employer_site.item_employer')
                                @endforeach
                            </div>
                        </div>
                    </section>


                    <section class="page_intership">
                        <div class="row">
                            <div class="col-12 text-center">

                                @include('site.default.item_pani',['page_link' => $employers])

                            </div>

                        </div>
                    </section>


                    @include('site.employer_site.tab_filter_intership')
                    @include('site.module_index.dang-ky-tu-van')

                </div>


                {{--//sidebar_intership--}}
                @include('site.sidebar_site.sidebar_intership')
            </div>

        </div>
    </section>
	@include('site.employer_site.item_post_intership_new')
    @include('site.module_index.hotline')

@endsection
