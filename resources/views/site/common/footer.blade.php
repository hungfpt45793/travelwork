<section class="recruitmentNewsHandbook bgrGray " style="width: 100%;height: 15px">
</section>

<!-- AddThis Button END -->
<footer class="bgrBlueN none_in_hoso" id="footer_posi">

    <div class="underlineX h1x bgrWhite"></div>
    <div class="footerContent pdl40 pdr40 pdt20">
        <div class="row">
            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                <h4 class="fw6 textUpper f20 lg-f18 mgb0 mbf14">{{ isset($information['ten-cong-ty']) ?  $information['ten-cong-ty'] : '' }}</h4>
                <p class="mgb0">Địa chỉ: {{ isset($information['dia-chi']) ?  $information['dia-chi'] : '' }}</p>
                <p class="mgb0">Hotline: {{ isset($information['hotline']) ?  $information['hotline'] : '' }}</p>
                <p class="mgb0">Giấy phép kinh doanh
                    số: {{ isset($information['giay-phep-kinh-doanh']) ?  $information['giay-phep-kinh-doanh'] : '' }}</p>
                <div class="row">
                    <div class="social mgt10 md-mgt5 md-mgb20">
                        <a href="{{ isset($information['link-facebook']) ?  $information['link-facebook'] : '' }}"
                           target="_blank" class="solo-item noUnderLine" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ isset($information['link-google-plus']) ?  $information['link-google-plus'] : '' }}"
                           target="_blank" class="solo-item noUnderLine" title="Google Plus"><i
                                    class="fab fa-google-plus-g"></i></a>
                        <a href="{{ isset($information['link-youtube']) ?  $information['link-youtube'] : '' }}"
                           target="_blank" class="solo-item noUnderLine" title="Youtube"><i class="fab fa-youtube"></i></a>
                        <a href="{{ isset($information['link-zalo']) ?  $information['link-zalo'] : '' }}" target="_blank"
                           class="solo-item noUnderLine" title="Zalo"><i class=""><b>Z</b></i></a>
                    </div>

                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">

                <h3 class="fw6 textUpper f20 lg-f18 mgb0 mbf14">Tải ứng dụng Travelwork </h3>
                <p>Để tìm việc nhận tin nhanh nhất</p>
                <div class="dowload_app">
                    {{--<span class="d-sm-inline">Link tải App</span>--}}
                    <a class="d-sm-inline" href="{{ isset($information['link-tai-app-androi']) ?  $information['link-tai-app-androi'] : '' }}"><img class="lazy" data-src="{{ asset('assets/image/android.png') }}"></a>
                    <a class="d-sm-inline" href="{{ isset($information['link-tai-app-ios']) ?  $information['link-tai-app-ios'] : '' }}"><img class="lazy" data-src="{{ asset('assets/image/ios.png') }}"></a>
                </div>

            </div>
            <div class=" col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 sm-mgta15">
                <ul class="md-pdl15">
                    <?php  $public_footer = \App\Entity\Category::getDetailCategory('bai-viet-ve-san-ke-toan');
                    ?>
                    @foreach(\App\Entity\Post::categoryShowAsc('bai-viet-ve-san-ke-toan',6) as $post_footer)
                        <li class="">
                            <a href="{{ route('post', ['cate_slug' => $public_footer->slug, 'post_slug' => $post_footer->slug]) }}"
                               class="white hvWhite"
                               title="{{ isset($post_footer['title']) ? $post_footer['title'] : '' }}">{{ isset($post_footer['title']) ? $post_footer['title'] : '' }}</a>
                        </li>

                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="underlineX h1x bgrWhite"></div>
    <div class="buildWeb pd10 text-center">
        {{ isset($information['copy-right']) ?  $information['copy-right'] : '' }}
    </div>
</footer>
<div class="js_fixel_mobile_dowload fixel_mobile_dowload">
    <img class="lazy" data-src="{{ asset('assets/image/icon_logo.png') }}">
    <div class="content_fixel">
    {{--<img class="lazy" src="https://sanketoan.vn/public/library/images/logo/logo(1).png">--}}
    <h3>Tải ứng dụng Travelwork</h3>
    <p>Để tìm việc , nhận tin mới nhất</p>
    </div>
    <a data-toggle="modal" data-target="#modal_dowload_app">Tải App</a>
    <span id="close_fixel">×</span>
</div>

<div class="modal fade" id="modal_dowload_app" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tải ứng dụng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal_content_dowload_app">
                <a class="d-sm-inline" href="{{ isset($information['link-tai-app-androi']) ?  $information['link-tai-app-androi'] : '' }}"><img class="lazy" data-src="{{ asset('assets/image/android.png') }}"></a>
                <a class="d-sm-inline" href="{{ isset($information['link-tai-app-ios']) ?  $information['link-tai-app-ios'] : '' }}"><img class="lazy" data-src="{{ asset('assets/image/ios.png') }}"></a>
                </div>
            </div>

        </div>
    </div>
</div>
