<section class="slider_new">
    <div class="container container_w_1200">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div id="demo" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach(\App\Entity\SubPost::showSubPost('slider',10,'asc') as $id => $banner)
                        <div class="carousel-item @if($id==0) active @endif">
                            <div class="row sl_bg">
                                <div class="col-lg-12 col-12">
                                    <a target="_blank" @if(!empty($banner['link-ref-nofollow'])) ref="nofollow" @endif href="{{ !empty($banner['link-bai-viet'])?$banner['link-bai-viet'] : '#' }}" title="{{ !empty($banner['title'])?$banner['title']:'' }}">
                                        <img class="lazy" style="width: 100%" src="{{ asset(!empty($banner['image'])?$banner['image']:'') }}" alt="{{ !empty($banner['title'])?$banner['title']:'' }}"></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#demo" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#demo" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
