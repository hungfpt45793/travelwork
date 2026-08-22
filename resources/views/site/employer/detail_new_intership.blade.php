@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', !empty($post->meta_title) ? $post->meta_title : $post->title)
@section('meta_description', !empty($post->meta_description) ? $post->meta_description : $post->description) @section('keywords', $post->meta_keyword ) @section('meta_image', asset($post->image) )
@section('meta_url', route('post', ['cate_slug' => $cate_slug, 'post_slug' => $post->slug]) )
@section('meta_image', asset($post->image) ? $post->image : '' )
@section('meta_url', route('post', ['cate_slug' =>  $cate_slug, 'post_slug' => $post->slug]) )
@section('content')
    <?php  $public_link = \App\Entity\Category::getDetailCategory($category->slug);
    ?>
    <section class="teacher" style='background: url("{{ asset('assets/image/bgr.jpg') }}") no-repeat;'>
        <div class="bannerTeacher white">
            <div class="bgread">
                <div class="name pdl40 pdt15">
                    <p class="fw7 mgb0">
                        {{ $post->title }}
                    </p>
                    <p class="mgb0">

                    </p>
                </div>
            </div>
        </div> <!-- bannerTeacher white -->

        <div class="contentTeacher bgrGray pdt20">
            <div class="infoTeacher container-fluid">
                <div class="row">
                    <div class="col-xl-9 col-lg-8 infomartionTeacher">
                        <div class="contentInfoNews bkwhite pd20 bdLightGray">
                            <h1 class="title fontBold mgb10 blueN f18">{{ isset($post->title) ? $post->title : '' }}</h1>
                            <div class="ContentPost">
                                {!! isset($post->content) ? $post->content : 'Đang cập nhật' !!}
                            </div>

                        </div>


                        <!-- col-lg-8 infomartionTeacher -->
                    </div>

                    {{--//sidebar khóa hoc--}}

                        @include('site.sidebar.sidebar_intership');

                <!-- row -->
                </div>
                <!-- infoTeacher -->
            </div>
            <!-- contentTeacher -->
        </div>
    </section>

    <section class="recruitmentNewsHandbook pd15 pdt10 pdb0 bgrGray" style="padding-top: 0">
        <div class="container-fluid bg-white pdt20 pdb20 ">
            <div class="row">


                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="title">
                        <?php  $public_link = \App\Entity\Category::getDetailCategory('thuc-tap-ke-toan');
                        ?>
                            <h4 class="textUpper text-center fw7 f22 xl-f22 lg-f22 red mgb20">Tin thực tập về du lịch</h4>
                    </div>
                    <div class="slideNews">
                        @foreach (\App\Entity\Post::relativeProduct($post->slug ,10) as $id => $post)
                            <div class="News pd20">
                                <div class="CropImg">
                                    <a href="{{ route('detail_new_intership', ['cate_slug_intership' => 'tin-thuc-tap-ke-toan' , 'post_slug' => $post->slug]) }}"
                                       class="thumbs">
                                        <img class="lazy" data-src="{{$post->image}}"
                                             alt="{{ isset($post['title']) ? $post['title'] : '' }}"
                                             width="100%">
                                    </a>
                                </div>
                                <div class="info">
                                    <h5>
                                        <a href="{{ route('detail_new_intership', ['cate_slug_intership' => 'tin-thuc-tap-ke-toan' , 'post_slug' => $post->slug]) }}"
                                           class="f18 hvBlueDN blueDN "
                                           title="{{ isset($post['title']) ? $post['title'] : '' }}">{{ isset($post['title']) ? \App\Ultility\Ultility::textLimit($post['title'], 10) : '' }}</a>
                                    </h5>

                                    <p>{{ isset($post['description']) ? \App\Ultility\Ultility::textLimit($post['description'], 25) : '' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script type="text/javascript">
        $('.slideNews').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 450,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
            ]
        });
    </script>




@endsection
