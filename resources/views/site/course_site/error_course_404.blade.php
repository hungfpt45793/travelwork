@extends('site.layout_site.site')

{{--@section('type_meta', 'website')--}}
@section('title','Thanh toán đơn hàng')
@section('meta_description','Thanh toán đơn hàng')
@section('keywords','Thanh toán đơn hàng')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>
    <link rel="stylesheet" href="/assets/css/course/course.css"/>
@endsection
@section('content')
    <section class="course_payment my-5">
        <div class="container">
            <h1 style="color: red">Không tìm thấy khóa học này !</h1>
            <p>{{ isset($message)?$message:'' }}</p>
        </div>
    </section>
@endsection

