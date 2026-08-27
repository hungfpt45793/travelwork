<header class="header_new_pc dsNone_900">
    <div class="container container_w_1200">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="hd_left">
                    <div class="hd_logo">
                        <a href="/">
                            <img class="lazy"
                                 src="{{ \App\Ultility\Ultility::assetUrl(data_get($information, 'logo-pc-new'), 'assets/image/new/Logo.png') }}"
                                 data-src="{{ \App\Ultility\Ultility::assetUrl(data_get($information, 'logo-pc-new'), 'assets/image/new/Logo.png') }}"
                                 alt="" width="100%">
                        </a>
                    </div>
                </div>
                <div class="hd_right">
                    <div class="hd_category">
                        <div class="hd_menu">
                            <ul>
                                <?php
                                $categoryVouchers = \App\Entity\VoucherCategories::getALlCategorieVoucher();
                                ?>
                                @foreach ($categoryVouchers as $categoryVoucher)
                                    <a class=""
                                       href="{{ route('getAllCategoryVoucher',['slugCategoryVoucher'=> $categoryVoucher['slug_cate_voucher']]) }}"
                                       title="{{ isset($categoryVoucher['name_cate_voucher']) ? $categoryVoucher['name_cate_voucher'] : '' }}">
                                        <li>
                                            {!! isset($categoryVoucher['icon']) ? $categoryVoucher['icon'] : '' !!}
                                            <h2>{{ isset($categoryVoucher['name_cate_voucher']) ? $categoryVoucher['name_cate_voucher'] : '' }}
                                 </h2>
                                        </li>
                                    </a>
                                @endforeach
                                    <a>
                                        <li class="box_postion">
                                            <span class="box_border_left"></span>
                                        </li>
                                    </a>
                                    <a href="{{ route('portEmployer') }}" title="Tìm hồ sơ">
                                        <li>
                                            <i class="fas fa-user-plus"></i>
                                            <h2>Tìm hồ sơ</h2>
                                        </li>
                                    </a>
                                    <a href="{{ route('list_price_free') }}" title="Gói đăng tuyển miễn phí">
                                        <li>
                                            <i class="fas fa-crown"></i>
                                            <h2>Gói đăng tuyển miễn phí</h2>
                                        </li>
                                    </a>
                            </ul>


                        </div>
                    </div>
                    <div class="hd_login">
                        @include('site.common_site.item_login_new')
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>
<header class="header_new_mobile dsNone dsBlock_900">
    <div class="container container_w_1200">
        <div class="row">
            <div class="col-4">
                <div class="header_new_mobile_left text-center">
                    <a href="{{ route('portEmployer') }}" title="Tìm hồ sơ">
                    <i class="fas fa-user-plus"></i>
                    Tìm hồ sơ</a>
                </div>
            </div>
            <div class="col-4 cus_mobile_new">
                @if (!\Illuminate\Support\Facades\Auth::check())
                    <div class="header_new_mobile_center">
                        <a href="/">
                            <img
                                 class="lazy" src="{{ \App\Ultility\Ultility::assetUrl(data_get($information, 'logo-mobile-new'), 'assets/image/new/logo_mobile.png') }}" data-src="{{ \App\Ultility\Ultility::assetUrl(data_get($information, 'logo-mobile-new'), 'assets/image/new/logo_mobile.png') }}"
                                 alt="" width="100%">
                        </a>
                    </div>

                @else
                    @include('site.common_site.item_login_new')
                @endif
            </div>
            <div class="col-4">
                <div class="header_new_mobile_right text-center">
                    <div class="header_new_mobile_button js_header_new_mobile_button">
                        <img class="lazy" data-src="{{ asset('assets/image/new/Menu.png') }}">
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-12 header_new_mobile_box_menu dsNone js_header_new_mobile_box_menu">
                <div class="menu_mobile_logo">
                    <a href="/"> <img
                                class="lazy" src="{{ \App\Ultility\Ultility::assetUrl(data_get($information, 'logo-mobile-new'), 'assets/image/new/logo_mobile.png') }}" data-src="{{ \App\Ultility\Ultility::assetUrl(data_get($information, 'logo-mobile-new'), 'assets/image/new/logo_mobile.png') }}"></a>
                    <a class="menu_mobile_closed js_menu_mobile_closed"><i class="fas fa-times-circle"></i></a>
                </div>
                <div class="menu_mobile_login">
                    @if (!\Illuminate\Support\Facades\Auth::check())
                        <ul>
                            <li class="hd_button_login">
                                <a class="modal_moblie" data-toggle="modal"
                                   data-target="#loginTiva">Đăng nhập</a>
                            </li>
                            <li class="hd_button_res">
                                <a class="mobile_register" href="{{ route('register')}}">Đăng ký</a>
                                <a href="{{ route('site_category_post',['slug_cate'=> 'ho-tro']) }}"
                                   class="showsupport mobile_button_question" id="showsupport"><i
                                            class="fas fa-question"></i></a>
                            </li>
                        </ul>
                    @else
                        <ul>
                            <li class="hd_button_res">
                                <a style="width: 100%;border-radius: 0px"
                                   href="{{ route('site_category_post',['slug_cate'=> 'ho-tro']) }}"
                                   class="showsupport mobile_button_question" id="showsupport">Câu hỏi hỗ trợ <i
                                            class="fas fa-question"></i></a>
                            </li>
                        </ul>
                    @endif

                </div>
                <div class="menu_mobile_list">
                    <ul>

                        @foreach ($categoryVouchers as $categoryVoucher)
                            <a class=""
                               href="{{ route('getAllCategoryVoucher',['slugCategoryVoucher'=> $categoryVoucher['slug_cate_voucher']]) }}"
                               title="{{ isset($categoryVoucher['name_cate_voucher']) ? $categoryVoucher['name_cate_voucher'] : '' }}">
                                <li>
                                    {!! isset($categoryVoucher['icon']) ? $categoryVoucher['icon'] : '' !!}
                                    <span>{{ isset($categoryVoucher['name_cate_voucher']) ? $categoryVoucher['name_cate_voucher'] : '' }}
                                 </span>
                                </li>
                            </a>
                        @endforeach
                        <a href="{{ route('list_price_free') }}" title="Gói đăng tuyển miễn phí">
                            <li>
                                <i class="fas fa-crown"></i>
                                <span>Gói đăng tuyển miễn phí</span>
                            </li>
                        </a>
                        <a href="{{ route('portEmployer') }}" title="Tìm hồ sơ">
                            <li>
                                <i class="fas fa-user-plus"></i>
                                <span>Tìm hồ sơ</span>
                            </li>
                        </a>

                        <a href="/mau-chung-tu/kho-tai-lieu" title="Kho tài liệu">
                            <li>
                                <i class="fas fa-book"></i>
                                <span>Kho tài liệu</span>
                            </li>
                        </a>
                        <a class="" href="{{ route('getTestAllExam') }}" title="Trắc nghiệm">
                            <li class="">
                                <i class="far fa-question-circle"></i>
                                <span class="">Trắc nghiệm </span>
                            </li>
                        </a>
                    </ul>
                </div>
                <div class="menu_mobile_footer">
                    <div class="footer_new_dowload">
{{--                        <div class="footer_new_box_logo">--}}
{{--                            <a href="/"> <img data-src="{{ asset('assets/image/new/SKT.png') }}">--}}
{{--                                <span>Mạng xã hội kế toán & Tài chính</span>--}}
{{--                            </a>--}}
{{--                        </div>--}}
                        <div class="footer_new_dowload_app">
                            <a class="d-sm-inline"
                               href="{{ isset($information['link-tai-app-androi']) ?  $information['link-tai-app-androi'] : '' }}" ref="nofollow"><img
                                         class="lazy"
                                        data-src="{{ asset('assets/image/android.png') }}"></a>
                            <a class="d-sm-inline"
                               href="{{ isset($information['link-tai-app-ios']) ?  $information['link-tai-app-ios'] : '' }}" ref="nofollow"><img
                                        class="lazy"
                                        data-src="{{ asset('assets/image/ios.png') }}"></a>
                        </div>
                    </div>
                    <div class="footer_new_fb_zalo">
                        <p>Theo dõi với chúng tôi</p>
                        <ul>
                            <li>
                                <a target="_blank"
                                   href="{{ isset($information['link-facebook']) ?  $information['link-facebook'] : '' }}" ref="nofollow"><img
                                            class="lazy" data-src="{{ asset('assets/image/new/Facebook.png') }}">
                                </a>
                            </li>
                            <li>
                                <a target="_blank"
                                   href="{{ isset($information['link-youtube']) ?  $information['link-youtube'] : '' }}" ref="nofollow"><img
                                            class="lazy" data-src="{{ asset('assets/image/new/YouTube.png') }}">
                                </a>
                            </li>
                            <li>
                                <a target="_blank"
                                   href="{{ isset($information['link-zalo']) ?  $information['link-zalo'] : '' }}" ref="nofollow"><img
                                            class="lazy" data-src="{{ asset('assets/image/new/Zalo.png') }}">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
