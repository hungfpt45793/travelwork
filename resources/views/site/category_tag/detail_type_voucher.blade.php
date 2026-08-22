@extends('site.layout.site')

@section('title', isset($category_tag->tag_title) ? $category_tag->tag_title : 'từ khóa tài liệu')
@section('meta_description', isset($category_tag->tag_description) ? $category_tag->tag_description : 'từ khóa tài liệu')
@section('keywords', isset($category_tag->tag_keyword) ? $category_tag->tag_keyword : 'từ khóa tài liệu')

@section('content')

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container">
            <div class="row ">

                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline">
                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_type_voucher') }}" class=" f18 md-f14 mgb0">Danh sách từ khóa
                                    tài liệu</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#"
                                   class=" f18 md-f14 mgb0">{{ isset($category_tag->tag_title) ? $category_tag->tag_title : 'từ khóa tài liệu' }}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="List_cateegory_tag">
                        <div class="main">
                            <div class="notificationBox bkwhite formJobLarge sm-f14">
                                <div class="bodyBox">
                                    <div class="row">
                                        <div class="col-12">
                                            <h1 class="f22 fw6 clhome mgb20">{{ isset($category_tag->tag_title) ? $category_tag->tag_title : 'từ khóa tài liệu' }}</h1>
                                            <div class="content_tag">
                                                {{ isset($category_tag->tag_description) ? $category_tag->tag_description : 'từ khóa tài liệu' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @if(!empty($list_voucher) && $total > 0)
                                            @foreach($list_voucher as $voucher)
                                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 pd0">
                                                    @include('site.voucher.item_voucher')
                                                </div>
                                            @endforeach
                                            <nav aria-label="Page navigation example">

                                                {{ $list_voucher->links() }}

                                            </nav>
                                        @else
                                            <div class="col-xl-12 mgt15">
                                            <p class="clred f16">Không tìm thấy tài liệu phù hợp</p>
                                            </div>
                                        @endif


                                        @if(!empty($list_voucher_new))
                                            <div class="col-12">
                                                <hr>
                                                <h2 class="f22 fw6 clhome mgb15">Danh sách tài liệu mới nhất</h2>
                                            </div>
                                            @foreach($list_voucher_new as $voucher)
                                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 pd0">
                                                    @include('site.voucher.item_voucher')
                                                </div>
                                            @endforeach

                                        @endif


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    @include('site.module_index.dang-ky-tu-van')
                </div>


            </div>
        </div>
        @include('site.module_index.hotline')
        </div>
    </section>

@endsection
