<!DOCTYPE html >
<html mlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#" class="no-js" xml:lang="vi" lang="vi">
<head>
    <?php
    $slug_pages_config = request()->path();
    $meta_config = \App\Entity\Config_meta::getslug($slug_pages_config);
    ?>
    @if(!empty($meta_config))
        <title>{{$meta_config->meta_title}}</title>
    @else
        <title>@yield('title')</title>
    @endif
<!-- meta -->
    {{--check url để robot cua google không tim thấy trang--}}
    @if((isset($id_job_fb) && isset($status_job) && route('submitFileJobFacebook',['id_job_fb'=>$id_job_fb,'status_job'=>$status_job]) == url()->current()) or (isset($slug) && route('apply_intership',['slug'=>$slug]) == url()->current()) or route('search_employee') == url()->current() or route('list_job_face') == url()->current() or Route::currentRouteName() == 'detail_employee_show')
        <meta name="ROBOTS" content="none"/>
        <meta name="googlebot" content="noindex">
    @else
        <meta name="ROBOTS" content="index, follow"/>
    @endif
    <meta name="google" content="nositelinkssearchbox"/>
    <meta http-equiv=”content-language” content=”vi”/>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8;application/json"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(!empty($meta_config))
        <meta name="title" content="{{$meta_config->meta_title}}">
        <meta name="description" content="{{$meta_config->meta_description}}"/>
        <meta name="keywords" content="{{$meta_config->meta_keywords}}"/>
        <meta property="og:title" content="{{$meta_config->meta_title}}"/>
        <meta property="og:description" content="{{$meta_config->meta_description}}"/>
    @else
        <meta name="title" content="@yield('title')">
        <meta name="description" content="@yield('meta_description')"/>
        <meta name="keywords" content="@yield('keywords')"/>
        <meta property="og:title" content="@yield('title')"/>
        <meta property="og:description" content="@yield('meta_description')"/>
    @endif
    <link rel="shortcut icon" href="{{ !empty($information['icon']) ?  asset($information['icon']) : '' }}"
          type="image/x-icon"/>
    @if (\Route::current()->getName() == 'job_detail' or \Route::current()->getName() == 'post' )
        <link rel="canonical" href="@yield('canonical')"/>
    @else
        @if (\Route::current()->getName() == 'home' )
            <link rel="canonical" href="https://sanketoan.vn/"/>
        @else
            <link rel="canonical" href="{{ \App\Ultility\Ultility::getUrl() }}"/>
        @endif
    @endif
    <meta property="og:image:type" content="image/jpeg"/>
    <meta property="og:locale" content="vi_VN"/>
    <meta property="og:type" content="@yield('type_meta')"/>
    {{--geturl dinh lỗi https://sanketoan.vn:443/--}}
    @if (\Route::current()->getName() == 'home' )
        <meta property="og:url" content="https://sanketoan.vn/"/>
    @else
        <meta property="og:url" content="{{ \App\Ultility\Ultility::getUrl() }}"/>
    @endif
    @if(request()->path()=='/')
        <meta property="og:image"
              content="{{ isset($information['og_image']) ?  asset($information['og_image']) : '' }}"/>
        <meta property="og:image:secure_url"
              content="{{ isset($information['og_image']) ?  asset($information['og_image']) : '' }}"/>
    @else
        <meta property="og:image" content="@yield('meta_image')"/>
        <meta property="og:image:secure_url" content="@yield('meta_image')"/>
    @endif
    <meta property="og:image:width" content="300"/>
    <meta property="og:image:height" content="300"/>
    <link rel="image_src" href="{{ isset($information['image_src']) ?  asset($information['image_src']) : '' }}">
    {{-- CSS tags --}}

    <link rel="stylesheet" href="{{ asset('assets/css/tags.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.css') }}">{{--font-awasome5--}}
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/web/css/extra.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/web/css/hotline.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/item_price.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/web/css/Style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('tracnghiem/') }}/css/star-rating-svg.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/style_new.css') }}">


    @yield('show_css')
    {!! isset($information['google-alynic']) ? $information['google-alynic'] : '' !!}
    {!! isset($information['facebook-pixel']) ? $information['facebook-pixel'] : '' !!}
    <meta name="google-site-verification" content="hmcYpVxVByBDyB0YMddcuCMzQ-oTqW6Kn6DfDpkHhUs"/>
    {{--js--}}

    <script src="{{ asset('assets/js/umd/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('tracnghiem/') }}/js/jquery.star-rating-svg.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://sp.zalo.me/plugins/sdk.js"></script>
    <script src="{{ asset('assets/js/jquery.matchHeight-min.js') }}"></script>

</head>
<body>
<div class="mobile_bottom_60px"></div>
{!!  isset($information['google-tag-mannager-script']) ?  $information['google-tag-mannager-script'] : '' !!}
@if($menuTopsite == 'menuwebsite')
    @include('site.common_site.header_new')
@endif
@if($menuTopsite == 'voucher')
    @include('site.common_site.header_voucher')
@endif
@if ($menuTopsite == 'exam')
    {{--@include('site.common_site.header_exam')--}}
    @include('site.common_site.header_new')
@endif
@if ($menuTopsite == 'teacher')
    @include('site.common_site.header_teacher')
@endif
@if ($menuTopsite == 'employer')
    @include('site.common_site.header_employer')
@endif
@yield('content')
@include('site.common_site.footer_new')
@include('site.partials_site.form_login')
<div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="contentMessage">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="call_table_price">
    <div class="box_table_price">
        <a href="{{ route('detail_list_price',['slug'=>'goi-dich-vu-loc-ho-so']) }}#href_table_combo_profile" target="_blank">
            <span class="icon_table_price"><i class="fas fa-crown"></i></span>

            <span class="icon_xoay_table_price">
                <i class="fas fa-reply"></i>
           </span>
            <span class="text_table_price">XEM BẢNG GIÁ</span>
        </a>

    </div>

</div>
<div class="call_phone">
    <div class="hotline-phone-ring-wrap">
        <div class="hotline-phone-ring">
            <div class="hotline-phone-ring-circle"></div>
            <div class="hotline-phone-ring-circle-fill"></div>
            <div class="hotline-phone-ring-img-circle">
                <a href="tel:{{ isset($information['hotline']) ?  $information['hotline'] : '' }}" class="pps-btn-img">
                    <img src="{{ asset('assets/image/icon-call-nh.png') }}" alt="Gọi điện thoại"
                         width="50">
                </a>
            </div>
        </div>
        <div class="hotline-bar">
            <a href="tel:{{ isset($information['hotline']) ?  $information['hotline'] : ''}}">
                <span class="text-hotline">{{ isset($information['hotline']) ?  $information['hotline'] : '' }}</span>
            </a>
        </div>
    </div>
</div>
<div class="send_email_contact js_send_email_contact">
    <div class="icon_sendemail">
        <a target="_blank"
           href="{{ isset($information['link-hom-thu-gop-y']) ?  $information['link-hom-thu-gop-y'] : '' }}">
            <i class="fas fa-envelope-open-text" style="color: #fff !important;"></i>
        </a>
    </div>
    <div class="arrow-up"></div>
    <div class="box_send_email">
        <a target="_blank"
           href="{{ isset($information['link-hom-thu-gop-y']) ?  $information['link-hom-thu-gop-y'] : '' }}">
            Đăng ký tư vấn
        </a>
        <span class="js_span_closed">x</span>
    </div>
</div>
{{-- lazy load img --}}
<script src="{{ asset('assets/js/jquery.lazy.min.js') }}"></script>

{{--<script type="text/javascript" src="/assets/js/jquery.lazy.min.js"></script>--}}
<script>
    $(function () {
        $('img.lazy').Lazy({
            effect: 'fadeIn',
            onError: function (element) {
                console.log('error loading ' + element.data('src'));
            }
        });
    });
</script>
{{--google recapchar--}}
<script>
    $('.js_header_new_mobile_button').click(function () {
        $('.js_header_new_mobile_box_menu').show();
    });
    $('.js_menu_mobile_closed').click(function () {
        $('.js_header_new_mobile_box_menu').hide();
    });
    $(this).scrollTop(0);
    var s1 = $("header.header_new_pc");
    var s2 = $(".submenu1");
    var pos = s1.position();
    var posheight = s1.height();
    var heightbody = $('body').height();
    var heightwindow = $(window).height();
    $(window).scroll(function () {
        var windowpos = $(window).scrollTop();
        if (windowpos > pos.top && ((heightbody - posheight) > heightwindow)) {
            s1.addClass("stickyhome");
            $('.top ').css('display', 'none')
        } else {
            s1.removeClass("stickyhome");
            $('.top ').css('display', 'block')
        }
        if (windowpos > (pos.top)) {
            s2.addClass("ds-none");
            $('.submenuPC').click(function () {
                s2.removeClass("ds-none")
            });
            $('.Mbsubmenu .Mobilemenu .navbar').css('margin-top', '0')
        } else {
            s2.removeClass("ds-none");
            $('.Mbsubmenu .Mobilemenu .navbar').css('margin-top', '50px')
        }
    });
    $('.js_showHidenMenu').click(function () {
        $('.js_toggle_menu_laptop').toggle(500)
    });
    $('.showsupport').click(function () {
        $('.dropSupport').addClass('show')
    });
    $('.removeSupport').click(function () {
        $('.dropSupport').removeClass('show')
    });
    $('.DropContent a').click(function () {
        var dataid = $(this).attr('data-id');
        $('.DropContentItem .DropItem').empty();
        $.ajax({
            type: "get",
            url: '{!! route('ajax_post_content') !!}',
            data: {
                dataid: dataid,
            },
            success: function (result) {
                var obj = jQuery.parseJSON(result);
                $('.DropContentItem .DropItem').empty();
                var html = '<div class="DropItem">';
                html += '<h3 class="f20 mgt15 fw6">' + obj.post.title + '</h3>';
                html += obj.post.content;
                html += ' </div>';
                html += '<a href="/ho-tro/' + obj.post.slug + '" class="dropItemTitle" target="_blank">';
                html += 'Mở trong cửa số mới <i class="fas fa-caret-right"></i><a>';
                $('.DropContentItem').append(html);
                $('.DropContent').hide();
                $('.DropContentItem').show();
                $('.showAjax').show();
                $('.search .bodySearch ').append('<button class="btn btn-danger" onclick="return submitSearch(this);">Xem tất cả</button>')
            }
        })
    });
    $('.showAjax').click(function () {
        $('.DropContentItem .DropItem').remove();
        $('.DropContentItem .dropItemTitle').remove();
        $('.DropContent').show();
        $('.DropContentItem').hide();
        $('.showAjax').hide()
    });

    $('.js_matchHeight_title_voucher').matchHeight();
    $('.maxHeight_box_ql_combo').matchHeight();

    $('.list_box_price ').matchHeight();
    $('.item_benefit ').matchHeight();

    $('.js_matchHeight_title_info_new').matchHeight();

    $('.maxHeight_service_feature').matchHeight();
    $('.box_advise').matchHeight();
    $(document).ready(function () {
        @if(session('success_dvisory'))
        $('#message').modal('show');
        $('.contentMessage').html('{{ session('
        success_dvisory') }}');
        @endif
    })
    $('#city_slug').change(function () {
        var city = $(this).val();
        $.get('/tim-kiem-slug/' + city, function (data) {
            $('#county').html('');
            $('#county').html(data);
        });
    });
    $('.select2').select2({
        width: '100%',
    });
    $('.select2_auto').select2();
    $('.select2_w90').select2({width: '85%',});
    $('.select2_w90_muti').select2({width: '85%',});
    $('#js_show_search_home').click(function () {
        $('.js_quickSearchForJobs').toggle(500);
    });
    $('.js_hidden_search').click(function () {
        $('.js_quickSearchForJobs').hide();
    });
    @if(session('mesage_modal'))
    $('#message').modal('show');
    $('.contentMessage').html('{!! session('mesage_modal') !!}');
    @endif
</script>
{{--//set cookie cho nút tải xuống mobile--}}
<script>
    $(document).ready(function () {
        // $('.item_agency_content').matchHeight();
        $('.js_agency_head_right').click(function () {
            $(this).parent().parent().find('.item_agency_content').show();

        });


        var user = getCookie("modal_mobile_dowload");
        // console.log(user)
        if (user != 'modal_mobile_hide') {
            if ($(window).width() <= 500) {
                $('.js_box_mobile_bottom2').show();
                setTimeout(function () {
                    $('.js_box_mobile_bottom_closed2').click(function () {
                        setCookie("modal_mobile_dowload", 'modal_mobile_hide', 30);
                        $('.js_box_mobile_bottom2').hide();
                    });
                }, 4000);

                // $('.detail_video iframe').addClass("sticky_video");
            }
        } else {
            $('.js_box_mobile_bottom2').hide();
        }
    })
    ;

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
</script>

@yield('show_js')
</body>
</html>