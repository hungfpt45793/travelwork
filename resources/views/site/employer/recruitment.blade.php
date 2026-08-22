@extends('site.layout.site')

@section('title', 'Cẩm nang tuyển dụng')
@section('meta_description', 'Cẩm nang tuyển dụng')
@section('keywords', 'Cẩm nang tuyển dụng')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container ">
            <div class="row ">

                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20 mgb10">
                        <ul class="nav">
                            <li class="nav-item pd8">

                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            {{-- <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">

                                <a href="{{ route('post_sale_employee') }}" class="f18 md-f14 blueDN hvBlueDN"> <i
                                            class="fas fa-donate mgr5"></i>Kiếm tiền từ chia sẻ bài</a>
                            </li> --}}
                        </ul>
                    </div>

                    <section class="categoryPostSale">
                        <div class="container bg-white">
                            <div class="row">
                                <div class="col-lg-9 PostSaleLeft">
                                    {{-- <h1 class=" f22 lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb20 mgt20">
                                        Danh sách bài viết chia sẻ kiếm tiền
                                    </h1> --}}
                                    @if(!empty($list_post_new))
                                        @foreach($list_post_new as $post_sale)
                                            <div class="row itemPostSale">
                                                <div class="col-lg-3">
                                                    <div class="imagePostSale">
                                                        <a class="z-depth-1"
                                                           href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post_sale->slug]) }}"
                                                           title="{{ isset($post_sale->title) ? $post_sale->title : '' }}">
                                                            <div class="CropImg CropImg60 CropImgMB60">
                                                                <div class="thumbs">
                                                                    <img class="responsive-img lazy"
                                                                         src="{{ isset($post_sale->image) ? $post_sale->image : '' }}"
                                                                         alt="{{ isset($post_sale->title) ? $post_sale->title : '' }}"
                                                                         title="{{ isset($post_sale->title) ? $post_sale->title : '' }}">
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="contentPostSale">
                                                        <a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post_sale->slug]) }}" class=""><h3 class="clorang f20 fw6">{{ isset($post_sale->title) ? $post_sale->title : '' }}</h3>
                                                        </a>
                                                        <p class="mgb5">
                                                            <?php
                                                            $total_sum_share = \App\Entity\Post_sale_statistical::getTotalShare($post_sale->post_id);
                                                            //
                                                            $total_sum_view_share = \App\Entity\Post_sale_statistical::getTotalViewSale($post_sale->post_id);
                                                            ?>
                                                            Đăng bởi: <span class="fw6"> Admin </span>
                                                            - Ngày đăng : <span class="fw6"><?php
                                                                $date=date_create($post_sale->updated_at);
                                                                echo date_format($date,"d/m/Y");
                                                                ?></span> - Lượt
                                                            chia sẻ : <span class="fw6">{{ number_format($total_sum_share) }}</span> <i class="fas fa-share"></i> - Lượt xem : <span
                                                                    class="fw6">{{ number_format($total_sum_view_share) }}</span> <i class="far fa-eye"></i>
                                                        </p>
                                                        <div class="descriptionPostSale">
                                                            {{ isset($post_sale->meta_description) ? \App\Ultility\Ultility::textLimit($post_sale->meta_description,40) : '' }}
                                                        </div>
                                                        <a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post_sale->slug]) }}" class="link">Xem thêm</a>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="row pagePostSale">
                                        <div class="col-12 text-center">

                                            @include('site.default.item_pani',['page_link' => $list_post_new])

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 PostSaleRight">
                                    {{-- <h2 class=" f22 lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb20 mgt20">
                                        Danh sách bài viết
                                    </h2> --}}
                                    @if(!empty($list_post))
                                        @foreach($list_post as $post_s)
                                            <?php $post_view = \App\Entity\Post::get_post_id($post_s->post_id)?>
                                            <div class="row itemPostSale">
                                                <div class="col-lg-3">
                                                    <div class="imagePostSale">
                                                        <a class="z-depth-1"
                                                           href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post_view->slug]) }}"
                                                           title="{{ isset($post_view->title) ? $post_view->title : '' }}">
                                                            <div class="CropImg CropImg60 CropImgMB60">
                                                                <div class="thumbs">
                                                                    <img class="responsive-img lazy"
                                                                         src="{{ isset($post_view->image) ? $post_view->image : '' }}"
                                                                         alt="{{ isset($post_view->title) ? $post_view->title : '' }}"
                                                                         title="{{ isset($post_view->title) ? $post_view->title : '' }}">
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <?php
                                                        $total_sum_share = \App\Entity\Post_sale_statistical::getTotalShare($post_view->post_id);
                                                        //
                                                        $total_sum_view_share = \App\Entity\Post_sale_statistical::getTotalViewSale($post_view->post_id);
                                                        ?>
                                                        <p class="mgb0 text-center">
                                                            <span class="dsNone mbdsInBlock">Lượt chia sẻ : </span>
                                                            <span class="fw6 mgr5">{{ number_format($total_sum_share) }}</span>
                                                            <i class="fas fa-share"></i>
                                                        </p>
                                                        <p class="mgb0  text-center">
                                                            <span class="dsNone mbdsInBlock">Lượt xem : </span>
                                                            <span class="fw6 mgr5">{{ number_format($total_sum_view_share) }}</span><i class="far fa-eye"></i>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="contentPostSale">
                                                        <a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post_view->slug]) }}" class=""><h3 class="clorang f20 fw6">{{ isset($post_view->title) ? $post_view->title : '' }}</h3></a>

                                                        <div class="descriptionPostSale">
                                                            {{ isset($post_view->meta_description) ? \App\Ultility\Ultility::textLimit($post_view->meta_description,15) : '' }}
                                                        </div>
                                                        <p class="mgb0">
                                                            Ngày đăng : <span class="fw6"><?php
                                                                $date=date_create($post_view->updated_at);
                                                                echo date_format($date,"d/m/Y");
                                                                ?></span>
                                                        </p>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    </section>

                    @include('site.module_index.dang-ky-tu-van')

                </div>
            </div>

        </div>
    </section>
    @include('site.module_index.hotline')
    <script src="{{ asset('adminstration/jquery.priceformat.js') }}"></script>
    <script>
        $('.formatPrice').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.'
        });
    </script>
    @include('site.partials.delete')


@endsection
