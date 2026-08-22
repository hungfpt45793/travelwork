@extends('site.layout_site.site')
{{--@section('type_meta', 'website')--}}
@section('title','Thanh toán đơn hàng'.!empty($courses->course_title) ? $courses->course_title : '')
@section('meta_description','Thanh toán đơn hàng'.!empty($courses->course_title) ? $courses->course_title : '' )
@section('keywords','Thanh toán đơn hàng'.!empty($courses->course_title) ? $courses->course_title : '')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" href="/public/assets/css/course/teacher.css"/>
    <link rel="stylesheet" href="/public/assets/css/course/course.css"/>

@endsection

@section('content')
    {{--@php--}}
    {{--echo '<pre>';--}}
    {{--print_r($course_order);die;--}}
    {{--@endphp--}}

    <section class="course_payment my-5">
        <div class="container">
            <div class="payment_detail row noti_course_order">
                <h1 class="f24 fw6 text-center">{{!empty($course_order) ? 'Mời bạn thanh toán cho đơn hàng số #'.$course_order->course_order_id :  '' }} </h1>


                <div class="alert alert-danger text-center" role="alert" style="width: 100%">
                    <p class="f18 text-center w100 clRed mgb0">Vui lòng chờ Admin xét duyệt là mã kích hoạt khóa học sẽ về tài
                        khoản email của bạn đã đăng kí !</p>
                </div>


                @if(!\Illuminate\Support\Facades\Auth::check())
                    <div class="alert alert-info text-center" role="alert" style="width: 100%">
                        <p class="mgb0">
                            <a href="{{ route('employee_register') }}?url=kich-hoat-khoa-hoc" style="color: #0c5460">
                                Bạn vui lòng đăng ký tài khoản ứng viên trên travelwork.vn
                                để tham giá khóa học
                            </a>
                        </p>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-5">

                        <h3 class="col-12">Thông tin khóa học</h3>


                        <div class="col-12 mt-4 mgb20">
                            <div style="border-top: 1px solid #E0E0E0;"></div>
                        </div>
                        <div class="col-12">
                    <span>
                        <span class="f16">Khóa học:</span> <span class="f18 clGreen" style="color: green">{{ !empty($courses->course_code) ? $courses->course_code : ''  }} - {{ !empty($courses->course_title) ? $courses->course_title : ''  }}
                                        </span></span>
                        </div>

                        <div class="col-12">
                    <span>
                        <span class="f16">Cách học: </span><span class="f18 clGreen" style="color: green">{{ !empty($course_order->learn_title) ? $course_order->learn_title : ''  }}
                                        </span></span>
                        </div>
                        <div class="col-12">
                            <span class="f16">Tổng thanh toán:</span> <strong><b style="color:#EB5757; font-size: 1.25rem;">
                                    {{ !empty($course_order->course_cost) ? number_format($course_order->course_cost).'đ' :  'Đang cập nhật'}}
                                    </b>
                            </strong>
                        </div>

                        <h3 class="col-12 mgt20">Thông tin người thanh toán</h3>
                        <div class="col-12 mt-4 mgb20">
                            <div style="border-top: 1px solid #E0E0E0;"></div>
                        </div>
                        <div class="col-12 f16">
                            <span>Họ và tên:</span><span><b>
                                            <span class="btngreen"><strong>{{ !empty($course_order->course_name) ? $course_order->course_name : ''  }}</strong></span>
                                        </b></span>
                        </div>
                        <div class="col-12 f16">
                            <span>Email:</span><span><b>
                                    <span class="btngreen"><strong>{{ !empty($course_order->course_email) ? $course_order->course_email : ''  }}</strong></span>
                                        </b></span>
                        </div>
                        <div class="col-12 f16">
                            <span>Số điện thoại:</span><span><b>
                                    <span class="btngreen"><strong>{{ !empty($course_order->course_phone) ? $course_order->course_phone : ''  }}</strong></span>
                                        </b></span>
                        </div>
                        <div class="col-12 f16">
                            <span>Nội dung :</span> <span><b>
                                    <span class="btngreen"><strong>{{ !empty($course_order->course_messager) ? $course_order->course_messager : 'Đang cập nhật'  }}</strong></span>
                                        </b></span>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h3 class="col-12">Thông tin chuyển khoản</h3>
                        <div class="col-12">
                            <div class="col-12 mt-4">
                                <div style="border-top: 1px solid #E0E0E0;"></div>
                            </div>

                            <div class="col-12 mt-3">
                                <h5 class="font-weight-bold">Thông tin hướng dẫn chuyển khoản</h5>
                            </div>
                            <div class="col-md-12 col-12">
                                {!! !empty($information['thong-tin-thanh-toan-khoa-hoc']) ? $information['thong-tin-thanh-toan-khoa-hoc'] : 'Đang cập nhật' !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('show_js')

@endsection

