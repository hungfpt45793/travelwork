@extends('site.layout.site')

@section('title', 'Danh sách phần mềm bạn có thể đổi')
@section('meta_description', 'Danh sách phần mềm bạn có thể đổi')
@section('keywords', 'Danh sách phần mềm bạn có thể đổi')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">

                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20 mgb10">
                        <ul class="nav">
                            <li class="nav-item pd8">

                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">

                                <a href="{{ route('post_sale_employee') }}" class="f18 md-f14 blueDN hvBlueDN"> <i
                                            class="fas fa-donate mgr5"></i>Kiếm tiền từ chia sẻ bài</a>
                            </li>
                        </ul>
                    </div>
                    @include('site.employee.item_list_redeem')
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">

                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <div class="CV bgrWhite radius5 pd20 mbpd0 mgb20 pdb5">

                                        @include('site.employee.item_total_money')


                                    </div>

                                </div>


                            </div>
                        </div>
                    </section>
                    <section class="categoryPostSale">
                        <div class="container bg-white">
                            <div class="row">
                                <div class="col-lg-9 PostSaleLeft">
                                    <h1 class=" f22 lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb20 mgt20">
                                        Danh sách bài viết chia sẻ kiếm tiền
                                    </h1>
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
                                                                    data-src="{{ isset($post_sale->image) ? $post_sale->image : '' }}"
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
                                            {{$list_post_new->links()}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 PostSaleRight">
                                    <h2 class=" f22 lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb20 mgt20">
                                        Danh sách bài viết
                                    </h2>
                                    @if(!empty($list_post))
                                        @foreach($list_post as $post_s)
                                            <div class="row itemPostSale">
                                                <div class="col-lg-3">
                                                    <div class="imagePostSale">
                                                        <a class="z-depth-1"
                                                           href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post_s->slug]) }}"
                                                           title="{{ isset($post_s->title) ? $post_s->title : '' }}">
                                                            <div class="CropImg CropImg60 CropImgMB60">
                                                                <div class="thumbs">
                                                                    <img class="responsive-img lazy"
                                                                    data-src="{{ isset($post_s->image) ? $post_s->image : '' }}"
                                                                         alt="{{ isset($post_s->title) ? $post_s->title : '' }}"
                                                                         title="{{ isset($post_s->title) ? $post_s->title : '' }}">
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <?php
                                                        $total_sum_share = \App\Entity\Post_sale_statistical::getTotalShare($post_s->post_id);
                                                        //
                                                        $total_sum_view_share = \App\Entity\Post_sale_statistical::getTotalViewSale($post_s->post_id);
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
                                                        <a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post_s->slug]) }}" class=""><h3 class="clorang f20 fw6">{{ isset($post_s->title) ? $post_s->title : '' }}</h3></a>

                                                        <div class="descriptionPostSale">
                                                            {{ isset($post_s->meta_description) ? \App\Ultility\Ultility::textLimit($post_s->meta_description,15) : '' }}
                                                        </div>
                                                        <p class="mgb0">
                                                            Ngày đăng : <span class="fw6"><?php
                                                                $date=date_create($post_s->updated_at);
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
            @include('site.module_index.hotline')
        </div>
    </section>
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