<section class="list_post_hơme">
    <div class="container container_w_1200">
        <div class="row">
            <div class="col-md-12">
                <div class="box_post_home">
                    <div class="title_post_home text-center">
                        <h3>Cẩm nang nghề nghiệp</h3>
                    </div>
                    <div class="slide_post_new row">
                        @foreach(\App\Entity\Post::categoryShow('tin-tuc',4) as $post)
                        <div class="item_post_home">
                            <a href="{{ route('post', ['cate_slug' => 'tin-tuc' , 'post_slug' => $post->slug]) }}" title="{{ !empty($post['title']) ? $post['title'] : '' }}">
                                <div class="CropImg">
                                    <div class="thumbs">
                                        @php
                                            $postImage = !empty($post->image) ? ltrim($post->image, '/') : '';

                                            if (!empty($postImage)) {
                                                if (strpos($postImage, 'public/') === 0) {
                                                    $postImageFile = base_path($postImage);
                                                } else {
                                                    $postImageFile = public_path($postImage);
                                                }
                                            } else {
                                                $postImageFile = '';
                                            }

                                            $postImageUrl = (!empty($postImageFile) && file_exists($postImageFile))
                                                ? asset($post->image)
                                                : asset('images/no_image.png');
                                        @endphp

                                        <img class="lazy"
                                             data-src="{{ $postImageUrl }}"
                                             alt="{{ isset($post['title']) ? $post['title'] : '' }}"
                                             width="100%">
                                    </div>
                                </div>
                                <h5 class="item_title_home cutTitle2">{{ !empty($post['title']) ? $post['title'] : '' }}</h5>
                                <p class="item_desc_home cutTitle3">{{ !empty($post['description']) ? $post['description'] : '' }}</p>

                            </a>
                        </div>
                        @endforeach
                    </div>
                    <div class="readmore_post_home text-center">
                        <a href="{{ route('site_category_post',['slug_cate'=>'tin-tuc']) }}">Xem thêm <i class="fas fa-angle-double-right"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </div>

</section>
<script type="text/javascript">
    $('.slide_post_new').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 4,
                    infinite: true,
                }
            },
            {
                breakpoint: 1000,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 3
                }
            }, {
                breakpoint: 900,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 800,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
</script>