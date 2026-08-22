@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', 'Video kế toán trưởng')
@section('meta_description', 'Danh sách các video cần thiết cho kế toán trưởng')
@section('keywords', 'Video kế toán trưởng')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('canonical', 'https://sanketoan.vn/')
@section('meta_url', 'https://sanketoan.vn/')
@section('content')

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/hover.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/video_skt.css') }}"/>
    <div style="position: absolute!important;clip: rect(1px,1px,1px,1px)">
        <h1  class="">Video kế toán trưởng</h1>
    </div>

    <section class="diendan_video section_box_content section_box_content_new mgt20 job_detail_relative">
        <div class="container container_w_1200">
        <div class="header_box">
            <h2 class="title_box  fw6 f20 mgb0 col-f14">
                <i class="fas fa-play"></i> Video kế toán trưởng
            </h2>

        </div>
        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
            <div class="row">
                @foreach($posts as $video)
                    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                        <div class="item_video js_item_video">

                            <a href="{{ route('detail_video_skt',['slug' => $video->slug,]) }}">
                                <div class="icon_youtube">
                                    <img class="lazy" src="{{ asset('site/images/icon-youtube.png') }}">
                                </div>
                                <div class="hover14 column">
                                    <div class="CropImg CropImg90">
                                        <figure class="thumbs">
                                            <?php
                                            $link = 'https://skt.sanketoan.vn/';
                                            ?>
                                            <img src="{{ !empty($video->image) ? $link.$video->image  :asset($information['logo']) }}">
                                        </figure>
                                    </div>
                                </div>

                                <p class="item_title_video js_item_title_video cutTitle2 ">{{ !empty($video->title) ? $video->title : '' }}
                                </p>
                                <p class="item_title_icon_video text-center">
                                    <span class="text-left item_title_icon_video_left">
                                        Ngày đăng :
                                        <?php
                                        $date=date_create($video->created_at);
                                        echo date_format($date,"d/m/Y");
                                        ?>
                                    </span>
                                    <span class="text-right item_title_icon_video_right">
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{ !empty($$video['view']) ? $video['view'] : '' }}

                                    {{ !empty($video['view']) ? $video['view'] : 0 }}
                                    </span>
                                </p>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="customer_pani">
                        @include('site.default.item_pani',['page_link' => $posts])
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>





@endsection
@section('show_js')
    <script>
        $('.js_item_title_video').matchHeight();
        $('.js_item_video').matchHeight();
        $(document).ready(function(){
            $('.js_item_agency_content').matchHeight();
        })

    </script>
@endsection
