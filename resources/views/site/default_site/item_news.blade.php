<section class="recruitmentNewsHandbook pdt20">
    <div class="title">
        <h4 class="title_home">TIN TỨC TRAVELWORK</h4>
    </div>
    <div class="voucherNew">
        <div class="container container_w_1200">
            <div class="row">
                @foreach(\App\Entity\Post::categoryShow('tin-tuc',4) as $post)
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 pd0">
                        <div class="News pd20">
                            <div class="news_border">
                                <div class="CropImg">
                                    <a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post->slug]) }}"
                                       class="thumbs">
                                        <img src="{{$post->image}}"
                                             data-src="{{$post->image}}"
                                             alt="{{ isset($post['title']) ? $post['title'] : '' }}" width="100%">
                                    </a>
                                </div>
                                <div class="info js_matchHeight_title_info_new ">
                                    <h5>
                                        <a href="{{ route('post', ['cate_slug' => 'tin-tuc' , 'post_slug' => $post->slug]) }}"
                                           class="f18 hvBlueDN blueDN "
                                           title="{{ isset($post['title']) ? $post['title'] : '' }}">{{ isset($post['title']) ? \App\Ultility\Ultility::textLimit($post['title'], 10) : '' }}</a>
                                    </h5>

                                    <p>{{ isset($post['description']) ? \App\Ultility\Ultility::textLimit($post['description'], 25) : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="redmove text-center mgt10">
                        <a class="" href="{{ route('site_category_post',['slug_cate'=>'tin-tuc']) }}">
                            <span class="btnHome">Xem thêm</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="underLineY h10x bgrGray"></div>
