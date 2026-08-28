<section class="recruitmentNewsHandbook pd40 pdb0 bg-white">
    <div class="title">
        <?php  $public_link = \App\Entity\Category::getDetailCategory('tin-tuc');
        ?>
        <h4 class="textUpper text-center fw7 f32 xl-f28 lg-f23 red mgb20 mbf18 tile_home_index">{{ isset($public_link->title) ? $public_link->title : '' }}</h4>
    </div>
    <div class="slideNews">
        @foreach(\App\Entity\Post::categoryShow('tin-tuc',6) as $post)
            <div class="News pd20">
                <div class="CropImg">
                    <a href="{{ route('post', ['cate_slug' => $public_link->slug, 'post_slug' => $post->slug]) }}" class="thumbs">
                        <img data-original="{{ asset('assets/image/no_avatar.jpg') }}" class="lazy" data-src="{{$post->image}}" alt="{{ isset($post['title']) ? $post['title'] : '' }}" width="100%">
                    </a>
                </div>
                <div class="info">
                    <h5><a href="{{ route('post', ['cate_slug' => $public_link->slug , 'post_slug' => $post->slug]) }}" class="f18 hvBlueDN blueDN " title="{{ isset($post['title']) ? $post['title'] : '' }}">{{ isset($post['title']) ? \App\Ultility\Ultility::textLimit($post['title'], 10) : '' }}</a></h5>

                    <p>{{ isset($post['description']) ? \App\Ultility\Ultility::textLimit($post['description'], 25) : '' }}
                    </p>
                </div>
            </div>
        @endforeach
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
                breakpoint: 1500,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1100,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
        ]
    });

    // $('#show_notification').modal('show');
    // Nếu trình duyệt không hỗ trợ thông báo
    $(document).ready(function () {

    });
</script>