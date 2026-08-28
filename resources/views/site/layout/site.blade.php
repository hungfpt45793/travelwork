<!DOCTYPE html >
<html mlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://ogp.me/ns/fb#" class="no-js" xml:lang="vi" lang="vi">
<head>
    {{--{!!  isset($information['google-manager-tag']) ?  $information['google-manager-tag'] : '' !!}--}}
    @if(!empty($meta_config))
        <title>{{$meta_config->meta_title}}</title>
    @else
        <title>@yield('title')</title>
    @endif
<!-- meta -->
    {{--check url để robot cua google không tim thấy trang--}}
    @if((isset($id_job_fb) && isset($status_job) && route('submitFileJobFacebook',['id_job_fb'=>$id_job_fb,'status_job'=>$status_job]) == url()->current()) or (isset($slug) && route('apply_intership',['slug'=>$slug]) == url()->current()) or route('search_employee') == url()->current())
        <meta name="ROBOTS" content="none"/>
    @else
        <meta name="ROBOTS" content="index, follow"/>
    @endif
    <meta name="google" content="nositelinkssearchbox"/>
    <meta http-equiv=”content-language” content=”vi”/>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8;application/json"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="google-site-verification" content="v5i-wa8W0iZnl34HrLGjcsA-LqujLrS_cRdEuyEOPSk"/>

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

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- facebook gooogle -->
    <meta name="google-site-verification" content="hmcYpVxVByBDyB0YMddcuCMzQ-oTqW6Kn6DfDpkHhUs"/>
    <!-- <meta property="fb:app_id" content="" />
    <meta property="fb:admins" content=""> -->
    @yield('show_css')
    <link rel="icon" href="{{ asset('assets/image/new/Logo.png') }}" type="image/png"/>
    @if (\Route::current()->getName() == 'job_detail' or \Route::current()->getName() == 'post' )
        <link rel="canonical" href="@yield('canonical')"/>
    @else
        <link rel="canonical" href="{{ \App\Ultility\Ultility::getUrl() }}"/>
    @endif
    <meta property="og:image:type" content="image/jpeg"/>
    <meta property="og:locale" content="vi_VN"/>

    <meta property="og:type" content="@yield('type_meta')"/>
    <meta property="og:url" content="{{ \App\Ultility\Ultility::getUrl() }}"/>
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




    {{--<link rel="stylesheet" href="{{ asset('tracnghiem/') }}/css/star-rating-svg.css" type="text/css">--}}
    {{--<link rel="stylesheet" href="{{ asset('tracnghiem/') }}/css/styles.css" type="text/css">--}}
    {{--<link rel="stylesheet" type="text/css" href="/assets/css/style_new.css"/>--}}
    {{--<link rel="stylesheet" href="http ://tracnghiem.local/adminstration/plugins/iCheck/all.css">--}}
    {{--<link rel="stylesheet" type="text/css" href="/adminstration/plugins/iCheck/all.css"/>--}}
    {{-- them moi --}}
    {{--<link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="/assets/css/list_price.css"/>--}}



    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/extra.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/hotline.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/item_price.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pretty-checkbox.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customStyle.css') }}">

    <link rel="stylesheet" href="{{ asset('tracnghiem/css/star-rating-svg.css') }}">
    <link rel="stylesheet" href="{{ asset('tracnghiem/css/styles.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style_new.css') }}">
    <link rel="stylesheet" href="{{ asset('adminstration/plugins/iCheck/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sitebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/list_price.css') }}">




    {{-- het them moi --}}

    <script src="{{ asset('assets/js/umd/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/loadingoverlay.min.js') }}"></script>

    <script src="{{ asset('assets/js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>

    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.matchHeight-min.js') }}"></script>


    <?php
    $route_name = \Route::currentRouteName();
    //    var_dump($name);
    //    ?>
    @if( $route_name != 'submitFileJobFacebook' && $route_name != 'home')
        @if (\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->role) == 3 && (\Illuminate\Support\Facades\Auth::user()->status_teacher_sc) == 1 )

            <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
        @else
            <script src="{{ asset('adminstration/ckeditor/ckeditor.js') }}"></script>
        @endif
    @endif


    <script src="{{ asset('tracnghiem/') }}/js/jquery.star-rating-svg.js"></script>
    {{--google recapchar--}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    {!! isset($information['google-alynic']) ? $information['google-alynic'] : '' !!}
    {!! isset($information['facebook-pixel']) ? $information['facebook-pixel'] : '' !!}

    {{--<script src="{{ asset('tracnghiem/') }}/js/emojionearea.js"></script>--}}




    <script type="text/javascript"   src="{{ asset('/tracnghiem/js/rAF.js') }}"></script>
    <script type="text/javascript"   src="{{ asset('/tracnghiem/js/ResizeSensor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/tracnghiem/js/sticky-sidebar.js') }}"></script>
    {{--<script src="http://tracnghiem.local/adminstration/plugins/iCheck/icheck.min.js"></script>--}}


    <script src="{{ asset('adminstration/plugins/iCheck/icheck.min.js') }}"></script>
</head>


<body class="preloading">
<!-- Hiệu ứng load -->
<!-- <div class="load">
	<img src="loader.gif">
</div> -->
<div class="loader">

    <img src="{{ asset('assets/image/loader.gif') }}" class="image_lazy_load">

    {{--<span class="fas fa-spinner xoay icon"></span>--}}
</div>
{!!  isset($information['google-tag-mannager-script']) ?  $information['google-tag-mannager-script'] : '' !!}

{{--<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>--}}
<!-- Load Facebook SDK for JavaScript -->
<div class="mobile_bottom_60px"></div>
@if($menuTopsite == 'menuwebsite')
    @include('site.common_site.header_new')
@endif
@if($menuTopsite == 'voucher')
    @include('site.common.header_voucher')
@endif
@if ($menuTopsite == 'exam')
    @include('site.common_site.header_exam')
@endif
@if ($menuTopsite == 'teacher')
    @include('site.common_site.header_teacher')
    {{--@include('site.common_site.header_exam')--}}
@endif
@if ($menuTopsite == 'employer')
    @include('site.common.header_employer')
@endif

@yield('content')
@include('site.common_site.footer_new')
@include('site.partials.form_login')
<div class="overlay">

</div>

@if(\Request::route()->getName() != 'home')
    @include('site.default.adv')
@endif
<!-- Button trigger modal -->
<!-- Modal -->
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
                <div class="contentMessage"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnOrange" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="show_notification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="notification">Cho phép nhận thông báo từ Travelwork</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnOrange" data-dismiss="modal" id="submit_notication">
                    Đóng
                </button>
            </div>

        </div>
    </div>
</div>

@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)
    <?php
    $infomation_coin_employer = \App\Entity\Coin_type_information_employer::get_coin_info();
    ?>
    <div class="modal fade" id="create_coin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hướng dẫn nạp điểm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! isset($infomation_coin_employer['huong-dan-nap-diem-xem-ho-so']) ? $infomation_coin_employer['huong-dan-nap-diem-xem-ho-so'] : 'Đang cập nhật thông tin' !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>

                </div>
            </div>
        </div>
    </div>
@endif

@include('site.default.jquery')



{{--xem thông tin ứng viên với quyền nhà tuyển dụng và ứng viên--}}
@if (URL::current() != route('home'))
    <script type="text/javascript" src="/assets/js/sitebar.js"></script>
@endif

{{-- lazy load img --}}
<script type="text/javascript" src="/assets/js/jquery.lazy.min.js"></script>
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
<script>
    $('.js_header_new_mobile_button').click(function () {
        $('.js_header_new_mobile_box_menu').show();
    });
    $('.js_menu_mobile_closed').click(function () {
        $('.js_header_new_mobile_box_menu').hide();
    });
    $(document).ready(function () {
        @if(session('error_employee_show'))
        $('#message').modal('show');
        $('.contentMessage').html('{{ session('error_employee_show') }}');
        @endif

        @if(session('mesage_modal'))
        $('#message').modal('show');
        $('.contentMessage').html('{!! session('mesage_modal') !!}');
        @endif
    });
</script>

{{-- het lazy load img --}}
{{-- scrip để thêm từ khóa --}}
<script>
    // Initialize tooltip component
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    // Initialize popover component
    $(function () {
        $('[data-toggle="popover"]').popover()
    })

    // ajax thêm từ khóa
    $(document).ready(function () {
        $('button.LuuTuKhoa').on('click', function () {
            $.ajax({
                type: 'GET',
                url: "{{ route('them_tu_khoa_ajax') }}",
                data: {
                    tag_type: $('input[name="tag_type"]').val(),
                    tag_title: $('input[name="tag_title"]').val(),
                    tag_description: $('textarea[name="tag_description"]').val()
                },
                success: function (res) {
                    let html = '';
                    let tags = res.input_tags_reload;
                    tags.forEach(element => {
                        html += `<option value="${element.tag_title}">
                                    ${element.tag_title}
                                </option>`
                    });
                    $('#select-tag').html(html);
                    alert('Thêm từ khóa thành công');
                }
            })
        })
    })
</script>
{{-- END scrip để thêm từ khóa --}}
@yield('show_js')
</body>
</html>
