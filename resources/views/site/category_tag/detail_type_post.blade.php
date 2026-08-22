@extends('site.layout.site')

@section('title', isset($category_tag->tag_title) ? $category_tag->tag_title : 'từ khóa bài viết')
@section('meta_description', isset($category_tag->tag_description) ? $category_tag->tag_description : 'từ khóa bài viế')
@section('keywords', isset($category_tag->tag_keyword) ? $category_tag->tag_keyword : 'từ khóa bài viết')

@section('content')

    <section class="PagesNewsContent bkxam pdt20 categoryPostSale">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 PostSaleLeft bgrWhite">
                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN">
                                    <i class="fas fa-home"></i>Trang chủ
                                </a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN">
                                    <i class="fas fa-chevron-right"></i>
                                </p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_type_post') }}" class=" f18 md-f14 mgb0">
                                    Danh sách từ khóa bài viết
                                </a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('detail_type_post',['tag_slug'=>$category_tag->tag_slug]) }}" 
                                    class=" f18 md-f14 mgb0">
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

                    <div class="col-xl-12">
                        <h2 class="f22 fw6 clhome mgb20 mgt15">Bài viết mới nhất</h2>
                    </div>
                    
                    @if(!empty($post_new))
                        @foreach($post_new as $post)
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
                                           class=""><h3
                                                    class="clorang f20 fw6">{{ isset($post->title) ? $post->title : '' }}</h3>
                                        </a>
                                        <p class="mgb5">
                                            Đăng bởi: <span class="fw6"> Admin </span>
                                            - Ngày đăng : <span class="fw6"><?php
                                                $date = date_create($post->updated_at);
                                                echo date_format($date, "d/m/Y");
                                                ?></span>
                                        </p>
                                        <div class="descriptionPostSale">
                                            {{ isset($post->title) ? \App\Ultility\Ultility::textLimit($post->title,40) : '' }}
                                        </div>
                                        <a href="{{ route('post', ['tin-tuc', 'post_slug' => $post->slug]) }}"
                                           class="link">Xem thêm</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    
                    <div class="row pagePostSale">
                        <div class="col-12 text-center">
                            @include('site.default.item_pani',['page_link' => $post_new])
                        </div>
                    </div>
                </div>
                {{--//Sider bar--}}
                @include('site.sidebar.sidebar_new')
            </div>
        </div>
    </section>
@endsection

