@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', !empty($post->meta_title) ? $post->meta_title : $post->title) 
@section('meta_description', !empty($post->meta_description) ? $post->meta_description : $post->description) @section('keywords', $post->meta_keyword) @section('meta_image', asset($post->image) ) 
@section('meta_url', route('page', [ 'post_slug' => $post->slug]) )
@section('meta_image', asset($post->image) ? $post->image : '' )
@section('meta_url', route('page', ['post_slug' => $post->slug]) )

@section('content')
    <div class="slide1 text-center">
        <div style="padding:100px">
            <b style="font-size: 200%;color: #802390">TIVA</b>
        </div>
    </div>
    <div class="infoNewsss mgb20">
        <div class="linkk bgrWhite">
            <div class="container">
                <nav class="nav pd15-0">
                    <p><a class=" black noDecoration" href="#"><i class="fas fa-home"></i> Trang chủ &nbsp</a></p>
                    <p class=""> <i class="fas fa-chevron-right"></i></p>
                    <p><a class=" black noDecoration" href="#">&nbsp Tin tức &nbsp</a></p>
                    <p class=""> <i class="fas fa-chevron-right"></i></p>
                    <p><a class=" black noDecoration" href="#">&nbsp {{ $post->title }}</a></p>
                </nav>
            </div>
        </div>
        <div class="container" style="padding-top:20px;">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                    <div class="row">
                        <div class="contentInfoNews font18 text-justify lineHeight25 bgrWhite pd15 borderLight borderRadius10">
                            <h1 class="fontBold Tim font20 lineHeight25">{{ $post->title }}</h1>
                            <p class="font14 mgb20"><b>Đăng bởi:</b> <span>Admin</span> &nbsp &nbsp <span><i class="fas fa-user-clock"></i>
                            <?php
                                    $date=date_create($post->created_at);
                                    echo date_format($date,"d-m-Y H:i");
                                    ?></span>
                            </p>
                            {!! $post->content !!}

                            {!! $post['opin-form-getfly'] !!}
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="recentPost bgrWhite">
                        <div class="header">
                            <p class="title textUpper mgb0">Tin mới nhất</p>
                            <hr class="mgt10">
                        </div>

                        <div class="list">
                            <ul>
                                @foreach (\App\Entity\Post::newPost() as $postNew)
                                    <li class="post">
                                        <div class="post-cate">
                                            <a href="{{ route('post', ['cate_slug' =>  'tin-tuc', 'post_slug' => $postNew->slug]) }}"><img class="lazy" data-src="{{ asset($postNew->image) }}" width="100%" height="100%"></a>
                                        </div>
                                        <div class="post-content">
                                            <div class="post-title">
                                                <a href="{{ route('post', ['cate_slug' =>  'tin-tuc', 'post_slug' => $postNew->slug]) }}" >{{ $postNew->title }}</a>
                                            </div>
                                            <div class=" postby">
                                                <i class="fas fa-clock"></i><span>&nbsp;</span>
                                                <?php
                                                $date=date_create($postNew->created_at);
                                                echo date_format($date,"d-m-Y H:i");
                                                ?>
                                            </div>
                                            <p>{{ $postNew->description }}</p>
                                        </div>
                                    </li>
                                    <hr>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection