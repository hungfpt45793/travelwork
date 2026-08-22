<?php
$link = 'https://skt.sanketoan.vn/';
?>
@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', !empty($post->title) ? $post->title : '')
@section('meta_description', !empty($post->description) ? $post->description  : '')
@section('keywords', !empty($post->tags) ? $post->tags : $post->title)
@section('meta_image', !empty($post->image) ?  $link.$post->image : asset($information['logo']))
@section('canonical', 'https://sanketoan.vn/')
@section('meta_url', 'https://sanketoan.vn/')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/hover.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/video_skt.css') }}"/>
    <div style="position: absolute!important;clip: rect(1px,1px,1px,1px)">
        <h1 class="">{{ !empty($post->title) ? $post->title : '' }}</h1>
    </div>
    <section class="detail_diendan_video">
        <div class="container container_w_1200">
            <div class="row justify-content-md-center">
                <div class="col-xl-8 col-lg-8 col-md-12 col-12">
                    <div class="detail_link_video">
                        {!! isset($post->content_video) ? $post->content_video : '' !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="detail_video">


                        <h1 class="js_title" style="">  {{ !empty($post->title) ? $post->title : '' }}</h1>

                        <p class="strong mb-0">
                            <span class="mbdsNone">Đăng bởi: <strong>{{ isset($post['tac-gia']) ? $post['tac-gia'] :
                                    'Admin' }}</strong> - </span>

                            Ngày đăng:
                            <strong>
                                <?php
                                $date = date_create($post['created_at']);
                                echo date_format($date, "d/m/Y");
                                ?>
                            </strong> - Lượt xem :
                            <strong>{{ isset($post['view']) ? $post['view'] : '0' }}</strong> <i class="fa fa-eye"
                                                                                                 aria-hidden="true"></i>
                        </p>

                        @if(!empty($post->day_create))
                            <p class="mb-0">
                                <?php
                                $day_create = date_create(!empty($post->day_create) ? $post->day_create : '');
                                ?>
                                <span>Ban hành: <span>{{ !empty(date_format($day_create,"Y-m-d")) ? date_format($day_create,"d/m/Y") : '' }}</span></span>
                            </p>
                        @endif
                        @if(!empty($post->day_active))
                            <p class="mb-0">
                                <?php
                                $day_active = date_create(!empty($post->day_active) ? $post->day_active : '');
                                ?>
                                <span>Hiệu lực: <span>{{ !empty(date_format($day_active,"Y-m-d")) ? date_format($day_active,"d/m/Y") : '' }}</span></span>
                            </p>
                        @endif


                        <div class="lib_btn_share">
                            <div class="box_btn_share js_box_btn_share">
                                <i class="fas fa-share"></i>
                                Chia sẻ bài viết hữu ích
                            </div>
                            <div class="show_hidden_btn_share js_show_hidden_btn_share">
                                <div class="click_show_hiden js_click_show_hiden">
                                    <i class="fas fa-times"></i>
                                </div>
                                <p class="text_fb_zalo">Chia sẻ thông tin hữu ích</p>
                                <div class="btn_share_facebook">
                                    <div id="fb-root"></div>
                                    <script async defer crossorigin="anonymous"
                                            src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v18.0&appId=423707121644549&autoLogAppEvents=1"
                                            nonce="eJnkMwgL"></script>
                                    <div class="fb-share-button"
                                         data-href="{{ route('detail_video_skt',['slug'=>$post->slug]) }}"
                                         data-layout=""
                                         data-size=""><a target="_blank"
                                                         href="https://www.facebook.com/sharer/sharer.php?u={{ route('detail_video_skt',['slug'=>$post->slug]) }}&amp;src=sdkpreparse"
                                                         class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                                </div>
                                <div class="btn_share_zalo">
                                    <div class="zalo-share-button"
                                         data-href="{{ route('detail_video_skt',['slug'=>$post->slug]) }}"
                                         data-oaid="579745863508352884" data-layout="3" data-color="blue"
                                         data-customize="false" style="height: 40px;
    vertical-align: top;">
                                    </div>
                                </div>

                                <div class="input-group-append">
                                    <button onclick="myFunction()"
                                            class="btn btn-outline-secondary copylink js_add_employee_money">
                                        Copy link
                                    </button>
                                </div>
                                <div class="input-group mb-3 copy_link_post">
                                    <input type="text"
                                           value="{{ route('detail_video_skt',['slug'=>$post->slug]) }}"
                                           id="myInput"
                                           class="form-control js_add_employee_money css_no_copy"
                                           placeholder="copy link chia sẻ"
                                           readonly style="">


                                </div>
                            </div>
                        </div>

                        <div>
                            <a target="_blank" href="https://www.youtube.com/@Sanketoan" style="background: #009385;
    color: #fff;
    padding: 5px 24px;margin-bottom: 10px">Đăng ký theo dõi kênh</a>
                        </div>


                        @if(!empty($post->status_doc))
                            <p class="mb-0">
                                <span>Tình trạng: <span class="text-success">{{ $post->status_doc }}</span></span>
                            </p>
                        @endif

                        <h2 class="js_title" style=""> Nội dung tóm tắt</h2>
                        {!! isset($post->content_summary) ? $post->content_summary : '' !!}

                    </div>


                </div>
            </div>

        </div>
    </section>


    <section class="diendan_video section_box_content section_box_content_new mgt20 job_detail_relative">
        <div class="container container_w_1200">
            <div class="header_box">
                <h2 class="title_box  fw6 f20 mgb0 col-f14">
                    <i class="fas fa-play"></i> Video liên quan
                </h2>

            </div>
            <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                <div class="row">
                    @foreach (\App\Entity\Diendan_posts::relativeProduct($post->slug,12) as $id => $video)
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
                                        $date = date_create($video->created_at);
                                        echo date_format($date, "d/m/Y");
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

            </div>
        </div>
    </section>

@endsection
@section('show_js')
    <script>
        $('.js_item_title_video').matchHeight();
        $('.js_item_video').matchHeight();

        $('.js_click_show_hiden').click(function () {
            $('.show_hidden_btn_share').hide();
        });
        $('.js_box_btn_share').click(function () {
            $('.show_hidden_btn_share').show();
        });

        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            document.execCommand("copy");
            // alert("Copied the text: " + copyText.value);
        }
    </script>
    <script>
        // $(window).scroll(function () {
        //     if ($(window).width() <= 500) {
        //         $('.detail_link_video iframe').addClass("sticky_video");
        //         var windowpos = $(window).scrollTop();
        //         var pos = $('.stickyhome').position();
        //         if (windowpos > 300) {
        //             $('.detail_link_video iframe').addClass("sticky_video");
        //         } else {
        //             $('.detail_link_video iframe').removeClass("sticky_video");
        //         }
        //     }
        // });
        // expandedImg
        $('.list_album_img .column img').click(function () {
            var data_src = $(this).attr('data_src');
            var data_title = $(this).attr('data_title');
            $('#video_url').attr('src', data_src);
            $('.js_title').html(data_title);


        });


    </script>
@endsection
