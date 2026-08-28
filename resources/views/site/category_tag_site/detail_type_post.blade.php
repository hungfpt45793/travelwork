@extends('site.layout_site.site')
<?php  $category = \App\Entity\Category::getDetailCategory($slug_cate);
?>
@section('title', isset($category_tag->tag_title) ? $category_tag->tag_title : 'từ khóa bài viết')
@section('meta_description', isset($category_tag->tag_description) ? $category_tag->tag_description : 'từ khóa bài viế')
@section('keywords', isset($category_tag->tag_keyword) ? $category_tag->tag_keyword : 'từ khóa bài viết')

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/tab_filter.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/post.css"/>
@endsection

@section('content')
    <section class="categoryPostSale PagesNewsContent bkxam pdt20">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-lg-9 PostSaleLeft bgrWhite">
                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('list_type_post') }}" class="">
                                    Danh sách từ khóa bài viết
                                </a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('detail_type_post',['tag_slug'=>$category_tag->tag_slug]) }}" 
                                    class="">
                                   {{ isset($category_tag->tag_title) ? $category_tag->tag_title : 'từ khóa bài viết' }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <h1 class="f22 fw6 clhome mgb20 mgt15">{{ isset($category_tag->tag_title) ? $category_tag->tag_title : 'từ khóa tài liệu' }}</h1>
                    <div class="content_tag mgb15">
                        {{ isset($category_tag->tag_description) ? $category_tag->tag_description : 'từ khóa tài liệu' }}
                    </div>
                    
                    @if(!empty($posts))
                        @foreach($posts as $post)
                            <div class="row itemPostSale">
                                <div class="col-lg-3">
                                    <div class="imagePostSale">
                                        <a class="z-depth-1"
                                           href="{{ route('post', ['tin-tuc', 'post_slug' => $post->slug]) }}"
                                           title="{{ isset($post->title) ? $post->title : '' }}">
                                            <div class="CropImg CropImg60 CropImgMB60">
                                                <div class="thumbs">
                                                    <img class="responsive-img"
                                                        src="{{ isset($post->image) ? asset($post->image)  : ''  }}"
                                                        alt="{{ isset($post->title) ? $post->title : '' }}">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="contentPostSale">
                                        <a href="{{ route('post', ['tin-tuc', 'post_slug' => $post->slug]) }}"
                                            class="">
                                            <h3 class="clOrange f20 fw6">
                                                {{ isset($post->title) ? $post->title : '' }}
                                            </h3>
                                        </a>
                                        <p class="mgb5">
                                            Đăng bởi: <span class="fw6">Admin</span>
                                            - Ngày đăng : 
                                            <span class="fw6">
                                                <?php
                                                    $date = date_create($post->updated_at);
                                                    echo date_format($date, "d/m/Y");
                                                ?>
                                            </span>
                                        </p>
                                        <div class="descriptionPostSale">
                                            {{ isset($post->title) ? \App\Ultility\Ultility::textLimit($post->title,40) : '' }}
                                        </div>
                                        <a href="{{ route('post', ['tin-tuc', 'post_slug' => $post->slug]) }}"
                                           class="link_show">Xem thêm</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    

                    <div class="row pagePostSale">
                        <div class="col-12 text-center">
                            @include('site.default.item_pani',['page_link' => $posts])
                        </div>
                    </div>

                    <div class="btn_show_sidebar dsNone mbdsBlock" id="js_filter_job_face">
                        <ul class="nav">
                            <li class="nav-item">
                                <a style="color: #fff" class=" js_show_sidebar clWhite">
                                    <i class="fas fa-bars"></i> Danh sách tin tuyển dụng 
                                    <i class="fas fa-angle-up js_closed_open"></i> </a>
                            </li>
                        </ul>
                    </div>
                </div>
                {{--//Sider bar--}}
                @include('site.sidebar_site.sidebar_new')
            </div>
        </div>
    </section>
@endsection

@section('show_js')
    <script type="text/javascript" src="/assets/js/sitebar.js"></script>
    <script>
        $('.js_show_search_job').click(function(){
            $('.js_filter_job_face').toggle();
        });
        $('.js_show_sidebar').click(function(){
            $('#js_toogle_sidebar').toggle();
            $('.js_closed_open').toggle();
        });
    </script>
@endsection