@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Đào tạo du lịch')
@section('meta_description', 'Đào tạo du lịch')
@section('keywords', 'Đào tạo du lịch')
@section('meta_image', ''  )

@section('content')

    <section class="content pdt20 bgrGray">
        <div class="container">
            <div class="link bgrWhite md-mgt20 mbdsNone">
                <ul class="nav ">
                    <li class="nav-item pd8">
                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                    </li>
                    <li class="nav-item pd8">
                        <p class="mgt5 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                    </li>
                    <li class="nav-item pd8">
                        <a href="{{ route('list_edu_categories') }}" class=" f18 md-f14 mgb0"><h1 class="f16" style="margin-bottom: 3px;">Đào tạo du lịch</h1></a>
                    </li>
                </ul>


                {{--<div class="searchVoucher bgrWhite">--}}
                    {{--<form class="mgr15 mgl15" method="GET" action="{{ route('searchVoucher') }}">--}}
                        {{--<div class="form-row">--}}
                            {{--<div class="form-group col-md-10">--}}
                                {{--<input type="text" class="form-control" id="inputEmail4"--}}
                                       {{--placeholder="Nhập tên tài liệu" name="name_voucher" required>--}}
                            {{--</div>--}}
                            {{--<div class="form-group col-md-2">--}}
                                {{--<button type="submit" class="btn btn-primary w100 bgrBlueN">Tìm kiếm</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            </div>

            @foreach($list_edu_categories as $categoriies)
                <div class="vouchers mgb20 bdLightGray">
                    <div class="bgrBlueN">
                        {{--<a href="{{ route('post', ['cate_slug' =>  'tin-tuc', 'post_slug' => $post->slug]) }}" class="thumbs">--}}
                        <a href="{{ route('edu_categories',['slug'=>$categoriies->edu_cate_slug]) }}"><h2 class="white pd10 fw7 mgb0 f18">{{ isset($categoriies['edu_cate_title']) ? $categoriies['edu_cate_title'] : '' }}</h2>
                        </a>
                    </div>

                    <div class="slideNews{{ $categoriies['edu_cate_id'] }} bgrWhite bdBottomGray">
                        <?php
                        $list_cate_class = \App\Entity\Educate_class::get_all_slug($categoriies->edu_cate_slug,8);
//                        print_R($list_cate_class);
                        ?>
                        @foreach($list_cate_class as $cate_class)
                                @include('site.educate.item_categories')
                            @endforeach

                    </div>
                    <div class="textCenter bgrWhite pd10">
                        <a href="{{ route('edu_categories',['slug'=>$categoriies->edu_cate_slug]) }}" class="block seeMore">Xem tất cả</a>
                    </div>
                    <script type="text/javascript">
                        $('.slideNews{{ $categoriies['edu_cate_id'] }}').slick({
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
                    </script>
                </div>
            @endforeach
        </div>
    </section>
    @include('site.module_index.hotline')
    <!-- Phần nội dung -->
@endsection

