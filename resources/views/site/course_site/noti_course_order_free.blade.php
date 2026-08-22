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
            <div class="payment_detail row noti_course_order row">
                <h1 class="f24 fw6 text-center">Mã kích hoạt khóa học đã được gửi đến email của bạn </h1>
                <br>
                <hr style="width: 100%;">

                    <div class="col-md-12">

                        <h3 class="col-12">Thông tin khóa học</h3>
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

                        <div class="col-12 mt-4 mgb20">
                            <div style="border-top: 1px solid #E0E0E0;"></div>
                        </div>
                        <div class="col-12">
                    <span>Khóa học:
                                            <span class="f18 clGreen" style="color: green">{{ !empty($courses->course_code) ? $courses->course_code : ''  }} - {{ !empty($courses->course_title) ? $courses->course_title : ''  }}
                                        </span></span>
                        </div>


                        <div class="col-12">
                            <span>Tổng thanh toán:</span> <strong><span
                                        style="color:#EB5757; font-size: 1.25rem;font-weight: 600">
                                    {{ !empty($course_order->course_cost) ? number_format($course_order->course_cost).'đ' :  'Miễn phí'}}
                                    </span>
                            </strong>
                        </div>

                        <h3 class="col-12 mgt20">Thông tin người thanh toán</h3>
                        <div class="col-12 mt-4 mgb20">
                            <div style="border-top: 1px solid #E0E0E0;"></div>
                        </div>
                        <div class="col-12">
                            <span>Họ và tên:</span><span><b>
                                            <span class="btngreen">{{ !empty($course_order->course_name) ? $course_order->course_name : ''  }}</span>
                                        </b></span>
                        </div>

                        <div class="col-12">
                            <span>Nội dung :</span> <span><b>
                                            <span class="btngreen">{{ !empty($course_order->course_messager) ? $course_order->course_messager : 'Đang cập nhật'  }}</span>
                                        </b></span>
                        </div>
                    </div>

            </div>
        </div>
    </section>

@endsection

@section('show_js')

@endsection

