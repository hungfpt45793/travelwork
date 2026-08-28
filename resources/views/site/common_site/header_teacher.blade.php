<?php $jobgroups = \App\Entity\JobGroup::getAll() ?>
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
                                <a class="" href="/mau-chung-tu/kho-tai-lieu" title="Kho tìa liệu">
                                    <li class="">
                                        <i class="fas fa-book"></i>
                                        <h2 class="">Kho tài liệu</h2>
                                    </li>
                                </a>
                                <a class="" href="{{ route('getTestAllExam') }}" title="Trắc nghiệm">
                                    <li class="">
                                        <i class="far fa-question-circle"></i>
                                        <h2 class="">Trắc nghiệm </h2>
                                    </li>
                                </a>
                                <?php
                                $category_post = \App\Entity\Category::getDetaicolumDetail('blog-khoa-hoc');
                                ?>
                                <a href="{{ route('site_category_post',['slug_cate'=>$category_post->slug]) }}"
                                   title="{{ !empty($category_post->title) ? $category_post->title : ''  }}">
                                    <li>
                                        <i class="fas fa-blog"></i>
                                        <h2>{{ !empty($category_post->title) ? $category_post->title : ''  }}
                                        </h2>
                                    </li>
                                </a>

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
                        @include('site.common_site.item_login_teacher_new')
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
                    <a href="{{ route('portEmployer') }}">
                    <i class="fas fa-user-plus"></i>
                   Tìm hồ sơ</a>
                </div>
            </div>
            <div class="col-4 cus_mobile_new">
                @if (!\Illuminate\Support\Facades\Auth::check())
                    <div class="header_new_mobile_center">
                        <a href="/">
                            <img class="lazy"
                                 src="{{ \App\Ultility\Ultility::assetUrl(data_get($information, 'logo-mobile-new'), 'assets/image/new/logo_mobile.png') }}"
                                 data-src="{{ \App\Ultility\Ultility::assetUrl(data_get($information, 'logo-mobile-new'), 'assets/image/new/logo_mobile.png') }}"
                                 alt="" width="100%">
                        </a>
                    </div>
                @endif
                    @include('site.common_site.item_login_teacher_new')
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
                    <a href="/"> <img class="lazy" src="{{ \App\Ultility\Ultility::assetUrl(data_get($information, 'logo-mobile-new'), 'assets/image/new/logo_mobile.png') }}" data-src="{{ \App\Ultility\Ultility::assetUrl(data_get($information, 'logo-mobile-new'), 'assets/image/new/logo_mobile.png') }}"></a>
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

                        <a class="" href="/mau-chung-tu/kho-tai-lieu" title="Kho tìa liệu">
                            <li class="">
                                <i class="fas fa-book"></i>
                                <span class="">Kho tài liệu</span>
                            </li>
                        </a>
                        <a class="" href="{{ route('getTestAllExam') }}" title="Trắc nghiệm">
                            <li class="">
                                <i class="far fa-question-circle"></i>
                                <span class="">Trắc nghiệm </span>
                            </li>
                        </a>
                        <?php
                        $category_post = \App\Entity\Category::getDetaicolumDetail('blog-khoa-hoc');
                        ?>
                        <a href="{{ route('site_category_post',['slug_cate'=>$category_post->slug]) }}"
                           title="{{ !empty($category_post->title) ? $category_post->title : ''  }}">
                            <li>
                                <i class="fas fa-blog"></i>
                                <span>{{ !empty($category_post->title) ? $category_post->title : ''  }}
                                        </span>
                            </li>
                        </a>

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

{{--                        <a target="_blank" ref="nofollow" href="https://skt.sanketoan.vn/" title="MXH kế toán">--}}
{{--                            <li>--}}
{{--                                <i class="fas fa-user-friends"></i>--}}
{{--                                <span>MXH kế toán</span>--}}
{{--                            </li>--}}
{{--                        </a>--}}
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
{{--                            <a href="/"> <img src="{{ asset('assets/image/new/SKT.png') }}">--}}
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
<!-- Modal hiển thị kích hoạt -->

<div class="modal fade modal_show_active_course" id="show_active_course" tabindex="-1"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="show_active_course" action="{{ route('employee_active_course') }}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">KÍCH HOẠT KHÓA HỌC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control input-custom-gray text-center text-uppercase"
                               required="required"
                               placeholder="Nhập mã kích hoạt" name="activation_code" type="text">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-custom-second text-upercase w-100 button_submit_active"
                                type="submit">Kích hoạt
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </form>
    </div>
</div>
