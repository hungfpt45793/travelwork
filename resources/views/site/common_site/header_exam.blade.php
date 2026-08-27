@php
    $public_exam = \App\Entity\Category::getDetailCategory('cuoc-thi-trac-nghiem');
    $public_test = \App\Entity\Category::getDetailCategory('huong-dan-trac-nghiem');
    $public_exam_slug = data_get($public_exam, 'slug');
    $public_test_slug = data_get($public_test, 'slug');
    $public_exam_url = $public_exam_slug
        ? route('site_category_post', ['slug_cate' => $public_exam_slug])
        : route('getAllExam');
    $public_test_url = $public_test_slug
        ? route('site_category_post', ['slug_cate' => $public_test_slug])
        : route('getTestAllExam');
    $public_exam_title = data_get($public_exam, 'title', 'Cuộc thi trắc nghiệm');
    $public_test_title = data_get($public_test, 'title', 'Hướng dẫn trắc nghiệm');
@endphp
<header class="header_new_pc dsNone_900">
    <div class="container container_w_1200">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="hd_left">
                    <div class="hd_logo">
                        <a href="/">
                            <img class="lazy" src="{{ !empty($information['logo-pc-new']) ? asset($information['logo-pc-new']) : asset('assets/image/new/Logo.png') }}" alt="" width="100%">
                        </a>
                    </div>
                </div>
                <div class="hd_right">
                    <div class="hd_category">
                        <div class="hd_menu">
                            <ul>
                                <a href="{{ $public_exam_url }}" title="{{ $public_exam_title }}">
                                    <li>
                                        <i class="fas fa-compress-arrows-alt"></i>
                                        <h2>{{ $public_exam_title }}</h2>
                                    </li>
                                </a>
                                <a  href="{{ route('getRomAll') }}" title="Phòng thi">
                                    <li>
                                        <i class="fab fa-chromecast"></i>
                                        <h2>Phòng thi</h2>
                                    </li>
                                </a>
                                <a href="{{ route('getAllExam') }}" title="Tất cả đề thi">
                                    <li>
                                        <i class="fas fa-question"></i>
                                        <h2> Tất cả đề thi</h2>
                                    </li>
                                </a>
                                <a href="{{ route('getTestAllExam') }}" title="Đề thi thử">
                                    <li>
                                        <i class="fas fa-text-width"></i>
                                        <h2> Đề thi thử</h2>
                                    </li>
                                </a>
                                <a target="_blank" href="{{ $public_test_url }}" title="{{ $public_test_title }}">
                                    <li>
                                        <i class="fab fa-slideshare"></i>
                                        <h2> {{ $public_test_title }}</h2>
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
                    <a href="{{ route('portEmployer') }}" title="Đăng tuyển & tìm hồ sơ">
                    <i class="fas fa-user-plus"></i>
                    Đăng tuyển & tìm hồ sơ</a>
                </div>
            </div>
            <div class="col-4 cus_mobile_new">
                @if (!\Illuminate\Support\Facades\Auth::check())
                    <div class="header_new_mobile_center">
                        <a href="/">
                            <img class="lazy" src="{{ !empty($information['logo-mobile-new']) ? asset($information['logo-mobile-new']) : asset('assets/image/new/logo_mobile.png') }}" alt="" width="100%">
                        </a>
                    </div>

                @else
                    @include('site.common_site.item_login_new')
                @endif
            </div>
            <div class="col-4">
                <div class="header_new_mobile_right text-center">
                    <div class="header_new_mobile_button js_header_new_mobile_button">
                        <img src="{{ asset('assets/image/new/Menu.png') }}">
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-12 header_new_mobile_box_menu dsNone js_header_new_mobile_box_menu">
                <div class="menu_mobile_logo">
                    <a href="/"> <img src="{{ !empty($information['logo-mobile-new']) ? asset($information['logo-mobile-new']) : asset('assets/image/new/logo_mobile.png') }}"></a>
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
                                <a href="{{ route('site_category_post',['slug_cate'=> 'ho-tro']) }}" class="showsupport mobile_button_question" id="showsupport"><i class="fas fa-question"></i></a>
                            </li>
                        </ul>
                    @else
                        <ul>
                            <li class="hd_button_res">
                                <a style="width: 100%;border-radius: 0px" href="{{ route('site_category_post',['slug_cate'=> 'ho-tro']) }}" class="showsupport mobile_button_question" id="showsupport">Câu hỏi hỗ trợ <i class="fas fa-question"></i></a>
                            </li>
                        </ul>
                    @endif

                </div>
                <div class="menu_mobile_list">
                    <ul>
                        <a href="{{ $public_exam_url }}" title="{{ $public_exam_title }}">
                            <li>
                                <i class="fas fa-compress-arrows-alt"></i>
                                <span>{{ $public_exam_title }}</span>
                            </li>
                        </a>
                        <a  href="{{ route('getRomAll') }}" title="Phòng thi">
                            <li>
                                <i class="fab fa-chromecast"></i>
                                <span>Phòng thi</span>
                            </li>
                        </a>
                        <a href="{{ route('getAllExam') }}" title="Tất cả đề thi">
                            <li>
                                <i class="fas fa-question"></i>
                                <span> Tất cả đề thi</span>
                            </li>
                        </a>
                        <a href="{{ route('getTestAllExam') }}" title="Đề thi thử">
                            <li>
                                <i class="fas fa-text-width"></i>
                                <span> Đề thi thử</span>
                            </li>
                        </a>
                        <a target="_blank" href="{{ $public_test_url }}" title="{{ $public_test_title }}">
                            <li>
                                <i class="fab fa-slideshare"></i>
                                <span> {{ $public_test_title }}</span>
                            </li>
                        </a>
{{--                        <a target="_blank" ref="nofollow" href="https://skt.sanketoan.vn/" title="MXH kế toán">--}}
{{--                            <li>--}}
{{--                                <i class="fas fa-user-friends"></i>--}}
{{--                                <span>MXH kế toán</span>--}}
{{--                            </li>--}}
{{--                        </a>--}}
                        <a href="{{ route('list_price') }}" title="Bảng giá">
                            <li>
                                <i class="fas fa-crown"></i>
                                <span>Bảng giá</span>
                            </li>
                        </a>
                        <a href="{{ route('portEmployer') }}" title="Đăng tuyển và tìm hồ sơ">
                            <li>
                                <i class="fas fa-user-plus"></i>
                                <span>Đăng tuyển và tìm hồ sơ</span>
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
{{--                            <a href="/"> <img src="{{ asset('assets/image/new/SKT.png') }}" title="Mạng xã hội kế toán & Tài chính">--}}
{{--                                <span>Mạng xã hội kế toán & Tài chính</span>--}}
{{--                            </a>--}}
{{--                        </div>--}}
                        <div class="footer_new_dowload_app">
                            <a class="d-sm-inline"
                               href="{{ isset($information['link-tai-app-androi']) ?  $information['link-tai-app-androi'] : '' }}" ref="nofollow">
                                <img src="{{ asset('assets/image/android.png') }}" class="lazy" data-src="{{ asset('assets/image/android.png') }}"></a>
                            <a class="d-sm-inline"  href="{{ isset($information['link-tai-app-ios']) ?  $information['link-tai-app-ios'] : '' }}" ref="nofollow">
                                <img src="{{ asset('assets/image/ios.png') }}" class="lazy" data-src="{{ asset('assets/image/ios.png') }}"></a>
                        </div>
                    </div>
                    <div class="footer_new_fb_zalo">
                        <p>Theo dõi với chúng tôi</p>
                        <ul>
                            <li>
                                <a target="_blank"
                                   href="{{ isset($information['link-facebook']) ?  $information['link-facebook'] : '' }}" ref="nofollow"><img
                                            src="{{ asset('assets/image/new/Facebook.png') }}">
                                </a>
                            </li>
                            <li>
                                <a target="_blank"
                                   href="{{ isset($information['link-youtube']) ?  $information['link-youtube'] : '' }}" ref="nofollow"><img
                                            src="{{ asset('assets/image/new/YouTube.png') }}">
                                </a>
                            </li>
                            <li>
                                <a target="_blank"
                                   href="{{ isset($information['link-zalo']) ?  $information['link-zalo'] : '' }}" ref="nofollow"><img
                                            src="{{ asset('assets/image/new/Zalo.png') }}">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


