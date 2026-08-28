<?php  $public_link = \App\Entity\Category::getDetailCategory($cate_slug);
?>
@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', !empty($post->meta_title) ? $post->meta_title : '')
@section('meta_description', !empty($post->meta_description) ? $post->meta_description : '')
@section('keywords', !empty($post->meta_keyword) ? $post->meta_keyword : ''  )
@section('meta_image', !empty($post->image) ?asset($post->image) : ''  )
@section('meta_url', !empty($post->slug) ? route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post->slug]) : ''  )


@section('content')
    <section class="PagesNewsContent bkxam pdb20 pdt20">
        <div class="container">
            <div class="link bgrWhite mgb20">
                <ul class="nav">
                    <li class="nav-item pd8">
                        <a href="#" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i>Trang chủ</a>
                    </li>
                    @if(!empty($public_link))
                        <li class="nav-item pd8">
                            <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                        </li>
                        <li class="nav-item pd8">
                            <a href="{{ route('site_category_post',['slug_cate'=>$public_link['slug']]) }}">{{ isset($public_link->title) ? $public_link->title : '' }}</a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <div class="contentInfoNews bkwhite pd20 bdLightGray">
                        <h1 class="title fontBold mgb10 blueN f18">{{ isset($post->title) ? $post->title : '' }}</h1>
                        <div class="ContentPost">
                            {!! isset($post->content) ? $post->content : '' !!}
                        </div>
                    </div>
                </div>
                {{--//Sider bar--}}
                @include('site.sidebar.sidebar_support')
            </div>
        </div>
    </section>
@endsection
{{--tao cau hoi trong search tim kiem cua google--}}
@if(!empty($post->post_id))
    <?php
        $mainEntity = \App\Entity\Post_question::get_question($post->post_id);
        $count_mainEntity = 0;
        $count_mainEntity = \App\Entity\Post_question::get_total_question($post->post_id)
        //ham tra ve ket qua cuoi cung cua mang
        //            echo $count_mainEntity;
    ?>

    @if(!empty($mainEntity) && $post->post_question == 1)
        <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [@foreach($mainEntity as $id_main=>$main)<?php if($id_main < ($count_mainEntity - 1)){?>{
            "@type": "Question",
            "name": "{{ isset($main->post_ques) ? $main->post_ques : '' }}",
            "acceptedAnswer": {
            "@type": "Answer",
            "text": "{!!  isset($main->post_answer) ? $main->post_answer : '' !!}"
            }
        },<?php }else {?> {
            "@type": "Question",
            "name": "{{ isset($main->post_ques) ? $main->post_ques : '' }}",
            "acceptedAnswer": {
            "@type": "Answer",
            "text": "{!!  isset($main->post_answer) ? $main->post_answer : '' !!}"
            }
        }<?php }?>@endforeach]
        }
        </script>
    @endif
@endif

<div class="noti_mobile_show">
    <div class="modal fade" id="message_noti_mobile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="contentNoti">
                    <div class="close_modal" data-dismiss="modal" >Đóng <i class="far fa-times-circle mgl5"></i></div>
                    <img class="lazy" data-src="{{ asset('assets/image/thongbao.png') }}">
                    <div class="modal_dowload_title">
                        <h3>Tải ứng dụng Travelwork</h3>
                        <p>Để tìm việc , nhận tin mới nhất</p>
                    </div>
                    <div class="modal_dowload">
                        <a class="d-sm-inline" href="{{ isset($information['link-tai-app-androi']) ?  $information['link-tai-app-androi'] : '' }}"><img class="lazy" data-src="{{ asset('assets/image/android.png') }}"></a>
                        <a class="d-sm-inline" href="{{ isset($information['link-tai-app-ios']) ?  $information['link-tai-app-ios'] : '' }}"><img class="lazy" data-src="{{ asset('assets/image/ios.png') }}"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        var user=getCookie("modal_noti");
        console.log(user);
        if (user != 'modal_noti_hide') {
            if ($(window).width() <= 500) {
                $('#message_noti_mobile').modal('show');
                $('.close_modal').click(function(){
                    setCookie("modal_noti", 'modal_noti_hide', 30);

                    $('#message_noti_mobile').modal('hide');
                });
            }
        }
    });

    function setCookie(cname,cvalue,exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

</script>
