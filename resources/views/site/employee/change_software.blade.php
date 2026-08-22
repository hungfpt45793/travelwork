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
                                    <div class="CV bgrWhite radius5 pd20 mgt20 mgb20 pdb5">

                                        @include('site.employee.item_total_money')

                                        <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb10 mgt0">
                                            Danh sách phần mềm đổi số dư
                                        </h5>
                                        @if(!empty($list_products))
                                        <div class="row chang_list_product">
                                            @foreach($list_products as $product)
                                            <div class="col-xl-3 col-md-4 minxl20">
                                                <div class="item_list_product">
                                                    <a class="dsBlock pd5" href="{{ route('change_software_slug',['slug' => $product->product_slug]) }}">
                                                        <div class="CropImg CropImg60">
                                                            <div class="thumbs">
                                                                <img class="lazy" data-src="{{ asset($product->product_image) }}">
                                                            </div>
                                                        </div>
                                                    </a>
                                                        <div class="title_product js_maxHeight">
                                                            <a href="{{ route('change_software_slug',['slug' => $product->product_slug]) }}">
                                                            <h3 class="f16 mgt5 fw6">{{ isset($product->product_name) ? $product->product_name : '' }}</h3>
                                                            </a>
                                                            <p class="f16 text-center">
                                                                    @if(!empty($product->product_discount))

                                                                <span class="price_discount">{{ isset($product->product_discount) ? number_format($product->product_discount) : '' }} vnđ</span>
                                                                @else
                                                                    <span class="price_discount">{{ isset($product->product_price) ? number_format($product->product_price) : '' }} vnđ</span>
                                                                        @endif


                                                                <a class="linkchange" href="{{ route('change_software_slug',['slug' => $product->product_slug]) }}"> <span class="btnGreen chang_software js_chang_software"  data-id = "{{ $product->product_id }}"> Đổi phần mềm</span>
                                                                </a>
                                                            </p>

                                                        </div>

                                                </div>
                                            </div>



                                                @endforeach


                                        </div>
                                            @endif

                                        <div class="col-12 text-center">
                                            {{$list_products->links()}}
                                        </div>
                                    </div>

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