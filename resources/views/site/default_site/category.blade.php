@extends('site.layout_site.site')
<?php  $category = \App\Entity\Category::getDetailCategory($slug_cate);
?>
@section('title',  isset($category->title) ? $category->title : '' )
@section('meta_description', isset($category->description) ? $category->description : 'Danh sách tin tức tại sanketoan.vn' )
@section('keywords', isset($category->title) ? $category->title : '' )
@section('meta_image',isset($category->image) ? asset($category->image) : '' )
@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/tab_filter.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/post.css"/>
@endsection
@section('content')
    <section class="categoryPostSale">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-lg-9 PostSaleLeft bgrWhite">
                    <h1 class="title_border_left">
                        {{ isset($category->title) ? $category->title : '' }}
                    </h1>
                    <form id="searchBox" class="mgb20" action="" method="GET">
                        <div class="content ">
                            <div class="searchInput ">
                                <div class="row mg0">
                                    <div class="col-lg-10 pd0">
                                        <?php $word = isset($_GET['word']) ? $_GET['word'] : ''?>
                                        <input class="w100" 
                                            type="text" 
                                            name="word" 
                                            placeholder="Nhập tên tìm kiếm ..."
                                            value="{{ $word }}" 
                                            style="height: 33px; padding: 0 10px;">
                                    </div>
                                    <button class="col-lg-2"
                                            type="submit">Tìm kiếm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @if(!empty($posts))
                        @foreach($posts as $post)
                            <div class="row itemPostSale">
                                <div class="col-lg-3">
                                    <div class="imagePostSale">
                                        <a class="z-depth-1"
                                           href="{{ route('post', ['cate_slug' => $slug_cate, 'post_slug' => $post->slug]) }}"
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
                                        <a href="{{ route('post', ['cate_slug' => $slug_cate, 'post_slug' => $post->slug]) }}"
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
                                        <a href="{{ route('post', ['cate_slug' => $slug_cate, 'post_slug' => $post->slug]) }}"
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
                </div>
                {{--//Sider bar--}}
                @include('site.sidebar_site.sidebar_course_new')
            </div>
        </div>
    </section>
    @include('site.partials_site.fixel_mobile_bottom')
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
