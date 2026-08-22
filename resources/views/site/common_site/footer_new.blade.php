<section class="register_user_new">
    <div class="container container_w_1200">
        <div class="row">
            <div class="col-md-12">
                <div class="box_register_user_new"
                     style="background: url('{{ asset('assets/image/new/DKTuvan.png') }}');background-size: 100%;background-position: left;">
                    <p>Để tuyển dụng hoặc tìm việc hiệu quả . Vui lòng ĐĂNG KÝ TÀI KHOẢN hoặc ĐĂNG KÝ TƯ VẤN để được hỗ
                        trợ ngay !</p>
                    <div class="row box_button_register_user">
                        <div class="col-md-6 col-12">
                            <a href="{{ route('employer_register') }}">Nhà tuyển dụng đăng ký tài khoản</a>
                        </div>
                        <div class="col-md-6 col-12">
                            <a href="{{ route('employee_register') }}">Người tìm việc đăng ký tài khoản</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</section>

<footer class="footer_new">
    <div class="container container_w_1200">
        <div class="row">
            <div class="col-md-8 footer_new_left">
                <h4 class="footer_new_company">{{ isset($information['ten-cong-ty']) ?  $information['ten-cong-ty'] : '' }}</h4>
                <p class="footer_new_address">Địa
                    chỉ: {{ isset($information['dia-chi']) ?  $information['dia-chi'] : '' }}</p>
                <p class="footer_new_hotline">
                    Hotline: {{ isset($information['hotline']) ?  $information['hotline'] : '' }}</p>
                <p class="footer_new_bussine">Giấy phép kinh doanh
                    số: {{ isset($information['giay-phep-kinh-doanh']) ?  $information['giay-phep-kinh-doanh'] : '' }}</p>
                <div class="footer_new_fb_zalo">
                    <p>Theo dõi với chúng tôi</p>
                    <ul>
                        <li>
                            <a target="_blank"
                               href="{{ isset($information['link-facebook']) ?  $information['link-facebook'] : '' }}" ref="nofollow">
                                <img class="lazy" src="{{ asset('assets/image/new/Facebook.png') }}">
                            </a>
                        </li>
                        <li>
                            <a target="_blank"
                               href="{{ isset($information['link-youtube']) ?  $information['link-youtube'] : '' }}" ref="nofollow">
                                <img class="lazy" src="{{ asset('assets/image/new/YouTube.png') }}">
                            </a>
                        </li>
                        <li>
                            <a target="_blank"
                               href="{{ isset($information['link-zalo']) ?  $information['link-zalo'] : '' }}" ref="nofollow">
                                <img class="lazy" src="{{ asset('assets/image/new/Zalo.png') }}">
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="footer_new_dowload">
                    <div class="footer_new_box_logo">
                        <a href="/">
                            <img class="lazy" src="{{ !empty($information['logo-footer-new']) ? asset($information['logo-footer-new']) : asset('assets/image/new/SKT.png') }}">
                            <span>Tìm việc - Nghe Podcast - Trắc nghiệm</span>
                        </a>
                    </div>
                    <div class="footer_new_dowload_app">
                        <a class="d-sm-inline"
                           href="{{ isset($information['link-tai-app-androi']) ?  $information['link-tai-app-androi'] : '' }}" ref="nofollow">
                            <img src="{{ asset('assets/image/android.png') }}" class="lazy"
                                 data-src="{{ asset('assets/image/android.png') }}">
                        </a>
                        <a class="d-sm-inline"
                           href="{{ isset($information['link-tai-app-ios']) ?  $information['link-tai-app-ios'] : '' }}" ref="nofollow">
                            <img src="{{ asset('assets/image/ios.png') }}" class="lazy"
                                 data-src="{{ asset('assets/image/ios.png') }}">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 footer_new_right">
                <ul class="footer_new_menu">
                    <?php  $public_footer = \App\Entity\Category::getDetailCategory('bai-viet-ve-san-ke-toan');
                    ?>
                    @foreach(\App\Entity\Post::categoryShowAsc('bai-viet-ve-san-ke-toan',6) as $post_footer)
                        <li class="">
                            <a href="{{ route('post', ['cate_slug' => $public_footer->slug, 'post_slug' => $post_footer->slug]) }}"
                               class="white hvWhite"
                               title="{{ isset($post_footer['title']) ? $post_footer['title'] : '' }}">
                                <h6>
                                    {{ isset($post_footer['title']) ? $post_footer['title'] : '' }}
                                </h6>
                            </a>
                        </li>
                    @endforeach
                    <li class="">
                        <a href="/mau-chung-tu/kho-tai-lieu" class="white hvWhite" title="Kho tài liệu">
                            <h6>
                                Kho tài liệu
                            </h6>
                        </a>
                    </li>
                        <li class="">
                        <a href="{{ route('intership') }}" class="white hvWhite" title="Thực tập về du lịch">
                            <h6>
                                Thực tập về du lịch
                            </h6>
                        </a>
                    </li>

                    <li class="">
                        <a href="{{ route('getTestAllExam') }}" class="white hvWhite" title="Trắc nghiệm">
                            <h6>
                                Trắc nghiệm
                            </h6>
                        </a>
                    </li>
                        <li class="">
                        <a href="https://skt.sanketoan.vn/" class="white hvWhite" title=" MXH kế toán">
                            <h6>
                               MXH du lịch
                            </h6>
                        </a>
                    </li>


                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="footer_mew_copy_right">
                    <p class="text-left">
                        {{ isset($information['copy-right']) ?  $information['copy-right'] : '' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>



<section class="dsNone mbdsBlock show_mobile_bottom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="box_mobile_bottom" style="display: none">
{{--                    <div class="box_mobile_bottom_closed js_box_mobile_bottom_closed">--}}
{{--                        <i class="fas fa-times-circle"></i>--}}
{{--                    </div>--}}
{{--                    <div class="box_mobile_bottom_title">--}}
{{--                        Tìm và nhận việc ở bất cứ nơi đâu bạn muốn , miễn phí với ứng dụng <strong>SKT - Mạng xã hội kế--}}
{{--                            toán & tài chính</strong> đã có sẵn trên IOS và Adroid--}}
{{--                    </div>--}}
                    <div class="box_mobile_bottom_content">
                        <div class="box_mobile_bottom_image">
                            <a href="/"> <img class="lazy" data-src="{{ !empty($information['logo-footer-new']) ? asset($information['logo-footer-new']) : asset('assets/image/new/SKT.png') }}"
                                        ></a>
                        </div>
                        <div class="box_mobile_bottom_rate">
                            <h5>Mạng xã hội du lịch</h5>
                            <p>
                                Tuyển dụng việc làm du lịch lớn nhất Việt Nam
                            </p>
                            <div>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                (10.5K)
                            </div>
                        </div>

                    </div>
                    <a href="#" class="box_mobile_bottom_dowload js_box_mobile_bottom_dowload">
                        Cài đặt ứng ứng dụng
                    </a>
                </div>


                <div class="box_mobile_bottom2 js_box_mobile_bottom2" style="display: none">
                    <div class="box_mobile_bottom_closed2 js_box_mobile_bottom_closed2">
                        <i class="fas fa-times-circle f18"></i>
                    </div>
                    <div class="box_mobile_bottom_content2">
                        <div class="box_mobile_bottom_image">
                            <a href="/"><img class="lazy" data-src="{{ !empty($information['logo-footer-new']) ? asset($information['logo-footer-new']) : asset('assets/image/new/SKT.png') }}"
                                        ></a>
                        </div>
                        <div class="box_mobile_bottom_rate2">
                            <h5>App riêng cho KẾ TOÁN</h5>
                            <p>
                                Tìm việc - nghe Podcast - trắc nghiệm
                            </p>
                        </div>
                        {{--<a href="#" class="box_mobile_bottom_content_dowload2 js_box_mobile_bottom_dowload">--}}
                        {{--Tải xuống--}}
                        {{--</a>--}}
                        <div class="box_mobile_bottom_content_dowload2">
                            <a class="js_box_mobile_bottom_dowload" href="#"> Tải xuống</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    $('.js_box_mobile_bottom_closed').click(function () {
        $('.box_mobile_bottom').hide();
    });
    $('.js_box_mobile_bottom_content_dowload2').click(function () {
        $('.box_mobile_bottom').show();
    });
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    var link_mobile_android = '{{ isset($information['link-tai-app-androi']) ?  $information['link-tai-app-androi'] : '' }}';
    var link_mobile_ios = '{{ isset($information['link-tai-app-ios']) ?  $information['link-tai-app-ios'] : '' }}';
    if (/android/i.test(userAgent)) {
        $('.js_box_mobile_bottom_dowload').attr('href', link_mobile_android)
    }
    // iOS detection from: http://stackoverflow.com/a/9039885/177710
    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        $('.js_box_mobile_bottom_dowload').attr('href', link_mobile_ios)
    }

</script>
