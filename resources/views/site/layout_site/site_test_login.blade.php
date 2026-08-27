<!DOCTYPE html >
<html mlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://ogp.me/ns/fb#" class="no-js" xml:lang="vi" lang="vi">
<head>
    {{--{!!  isset($information['google-manager-tag']) ?  $information['google-manager-tag'] : '' !!}--}}
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
    @if((isset($id_job_fb) && isset($status_job) && route('submitFileJobFacebook',['id_job_fb'=>$id_job_fb,'status_job'=>$status_job]) == url()->current()) or (isset($slug) && route('apply_intership',['slug'=>$slug]) == url()->current()) or route('search_employee') == url()->current() or route('list_job_face') == url()->current())
        <meta name="ROBOTS" content="none"/>
    @else
        <meta name="ROBOTS" content="index, follow"/>
    @endif
    <meta name="google" content="nositelinkssearchbox"/>
    <meta http-equiv=”content-language” content=”vi”/>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8;application/json"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<meta property="fb:app_id"   content="423707121644549" />--}}
<!-- <meta property="fb:app_id" content="" />
    <meta property="fb:admins" content=""> -->

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
    <link rel="stylesheet" href="/assets/css/tags.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/all.css">{{--font-awasome5--}}
    <link href="/assets/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/extra.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/hotline.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/item_price.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/Style.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/slick.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/slick-theme.css"/>

    <link rel="stylesheet" href="{{ asset('tracnghiem/') }}/css/star-rating-svg.css" type="text/css">
    @yield('show_css')
    {!! isset($information['google-alynic']) ? $information['google-alynic'] : '' !!}
    {!! isset($information['facebook-pixel']) ? $information['facebook-pixel'] : '' !!}
    <meta name="google-site-verification" content="hmcYpVxVByBDyB0YMddcuCMzQ-oTqW6Kn6DfDpkHhUs"/>

    {{--js--}}
    <script src="/assets/js/umd/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/umd/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/select2.min.js"></script>
    <script src="/assets/js/jquery.matchHeight-min.js"></script>
    <script src="/assets/js/slick.min.js"></script>
    <script src="{{ asset('tracnghiem/') }}/js/jquery.star-rating-svg.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script src="https://sp.zalo.me/plugins/sdk.js"></script>
</head>
<body>
{!!  isset($information['google-tag-mannager-script']) ?  $information['google-tag-mannager-script'] : '' !!}
@if($menuTopsite == 'menuwebsite')
    @include('site.common_site.header')
@endif
@if($menuTopsite == 'voucher')
    @include('site.common_site.header_voucher')
@endif
@if ($menuTopsite == 'exam')
    @include('site.common_site.header_exam')
@endif
@if ($menuTopsite == 'teacher')
    @include('site.common_site.header_teacher')
@endif
@if ($menuTopsite == 'employer')
    @include('site.common_site.header_employer')
@endif

@include('site.common.login')
@yield('content')

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{your-app-id}',
      cookie     : true,
      xfbml      : true,
      version    : '{api-version}'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>


</body>
</html>
