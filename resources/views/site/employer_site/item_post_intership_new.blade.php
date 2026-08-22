<section class="recruitmentNewsHandbook pdt20">
    <div class="title">
        <?php $slug_cate = 'thuc-tap-ke-toan';
        $public_link = \App\Entity\Category::getDetailCategory($slug_cate);
        ?>
        <h4 class="title_home">Tin tức thực tập về du lịch</h4>
    </div>
    <div class="voucherNew">
        <div class="container container_w_1200">
            <div class="row">
                    @foreach(\App\Entity\Post::categoryShow($slug_cate,4) as $post)
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 pd0">
                        <div class="News pd20">
                            <div class="news_border">
                                <div class="CropImg">
                                    <a href="{{ route('post', ['cate_slug' => $slug_cate, 'post_slug' => $post->slug]) }}"
                                       class="thumbs">
                                        <img src="{{$post->image}}"
                                             data-src="{{$post->image}}"
                                             alt="{{ isset($post['title']) ? $post['title'] : '' }}" width="100%">
                                    </a>
                                </div>
                                <div class="info js_matchHeight_title_info_new ">
                                    <h5>
                                        <a href="{{ route('post', ['cate_slug' => $slug_cate , 'post_slug' => $post->slug]) }}"
                                           class="f18 hvBlueDN blueDN cutTitle2"
                                           title="{{ isset($post['title']) ? $post['title'] : '' }}">{{ isset($post['title']) ? $post['title'] : '' }}</a>
                                    </h5>

                                    <p class="cutTitle3 clBlack">{{ isset($post['description']) ? $post['description'] : '' }}
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
                        <a class="" href="{{ route('site_category_post',['slug_cate'=>$public_link->slug]) }}">
                            <span class="btnHome">Xem thêm</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

