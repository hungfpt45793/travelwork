@extends('site.layout_site.site')
{{--@section('type_meta', 'website')--}}
@if(!empty($courses))
    @section('title','Thanh toán đơn hàng'.!empty($courses->$courses) ? $courses->course_title : '')
@section('meta_description','Thanh toán đơn hàng'.!empty($courses->course_title) ? $courses->course_title : '' )
@section('keywords','Thanh toán đơn hàng'.!empty($courses->course_title) ? $courses->course_title : '')
@else
    @section('title','Thanh toán đơn hàng')
@section('meta_description','Thanh toán đơn hàng' )
@section('keywords','Thanh toán đơn hàng')
@endif
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>
    <link rel="stylesheet" href="/assets/css/course/teacher.css"/>
    <link rel="stylesheet" href="/assets/css/course/course.css"/>
@endsection

@section('content')
    <section class="course_payment my-5">
        <div class="container">
            <h1>Chọn phương thức thanh toán</h1>

            <div class="">

                {{--<div class="nav ">--}}
                {{--<div class="payment_method pointer mr-3" data-toggle="tab" href="#payment_momo">--}}
                {{--<div>--}}
                {{--<img src="https://img.mservice.io/momo-payment/icon/images/logo512.png" style="width: 24px;"--}}
                {{--alt="">--}}
                {{--<span class="pr-3">Ví điện tử MoMo--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<i class="fas fa-check text-success d-none"></i>--}}

                {{--</div>--}}
                {{--<div class="payment_method pointer  mr-3" data-toggle="tab" href="#payment_vnpay">--}}
                {{--<div>--}}
                {{--<img style="width: 24px;"--}}
                {{--src="https://tekoventures.vn/wp-content/uploads/2018/09/vnpay-logo.jpg" alt="">--}}
                {{--<span class="pr-3">VNPAY--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<i class="fas fa-check text-success d-none"></i>--}}

                {{--</div>--}}
                {{--<div class="payment_method pointer active mr-3" data-toggle="tab" href="#payment_banking">--}}
                {{--<div>--}}
                {{--<i class="fas fa-money-check-alt"></i>--}}
                {{--<span class="pr-3">Chuyển khoản ngân hàng--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<i class="fas fa-check text-success"></i>--}}

                {{--</div>--}}

                {{--</div>--}}
                <div class="">
                    <div class="tab-content" id="nav-tabContent " style="min-height: 40rem;">
                        <div class="tab-pane fade show active" id="payment_banking" role="tabpanel">
                            <div class="payment_detail row">

                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <div style="border-top: 1px solid #E0E0E0;"></div>
                                        </div>
                                        <div class="col-12">
                                            <h5 class="font-weight-bold">Thông tin đơn hàng</h5>
                                        </div>
                                        <div class="col-4 mt-3">
                                            <span>Khóa học:</span>
                                        </div>
                                        <div class="col-8 mt-3">
                                    <span><b>
                                            <span class="btngreen">{{ !empty($courses->course_code) ? $courses->course_code : ''  }}</span> - {{ !empty($courses->course_title) ? $courses->course_title : ''  }}
                                        </b></span><br>
                                        </div>
                                        <div class="col-4 mt-3">
                                            <span>Tổng thanh toán:</span>
                                        </div>
                                        <div class="col-8 mt-3">
                                            <strong><b style="color:#EB5757; font-size: 1.25rem;"
                                                       class="js_course_discount">
                                                    Miễn phí
                                                </b>
                                            </strong>
                                            <p>Vui lòng nhập đầy đủ thông tin , mã kích hoạt sẽ gửi đến email khóa học
                                                của bạn</p>
                                        </div>


                                    </div>
                                </div>

                                <div class="col-12 col-md-7">
                                    <div style="border-top: 1px solid #E0E0E0;"></div>
                                    <form method="post" action="{{ route('payment_course_free') }}" style="width: 100%">
                                        {!! csrf_field() !!}
                                        <div class="col-12 mt-3">
                                            <h5 class="font-weight-bold">Thông tin khách hàng nhận mã kích hoạt</h5>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-4">
                                                <span>Họ và tên:</span> <b class="clRed">(*)</b>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" class="form-control color_plal f14"
                                                       name="course_name"
                                                       aria-describedby="name" placeholder="Họ và tên" required
                                                       value="{{ !empty(\Illuminate\Support\Facades\Auth::user()->name) ? \Illuminate\Support\Facades\Auth::user()->name : '' }}"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <div class="col-4 ">
                                                <span>Số điện thoại:</span> <b class="clRed">(*)</b>
                                            </div>
                                            <div class="col-8">
                                                <input type="number" class="form-control color_pla f14"
                                                       name="course_phone"
                                                       aria-describedby="Số điện thoại" placeholder="Số điện thoại"
                                                       required
                                                       value="{{ !empty(\Illuminate\Support\Facades\Auth::user()->phone) ? \Illuminate\Support\Facades\Auth::user()->phone : '' }}"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-4 ">
                                                <span>Email:</span> <b class="clRed">(*)</b>
                                            </div>
                                            <div class="col-8 ">
                                                <input type="email" class="form-control color_pla f14"
                                                       name="course_email"
                                                       aria-describedby="Email" placeholder="Email" required
                                                       value="{{ !empty(\Illuminate\Support\Facades\Auth::user()->email) ? \Illuminate\Support\Facades\Auth::user()->email : '' }}"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4 ">
                                                <span>Nội dung</span>
                                            </div>
                                            <div class="col-md-8 mt-md-3 ">
                                    <textarea class="form-control input-custom-gray color_pla f14"
                                              placeholder="Nội dung" rows="2" name="course_messager"
                                              cols="50"></textarea>
                                            </div>
                                        </div>
                                        @if(!empty($courses->course_id))
                                        <div class="form-group row select2_border">
                                            <div class="col-md-4 ">
                                                <span style="margin-top: 22px;display: inline-block;">Hình thức học</span>
                                            </div>
                                            <div class="col-md-8 mt-md-3 ">
                                                <select class="select2 custom-select custom-select-sm  select2_border js_course_formality_id"
                                                        name="course_formality_id">
                                                    <?php
                                                    $list_course_formality = \App\Course\Course_formality::get_formality($courses->course_id);
                                                    $course_formality_id = 1;
                                                    if (!empty($_GET['course_formality_id'])) {
                                                        $course_formality_id = $_GET['course_formality_id'];
                                                    }
                                                    ?>
                                                    <option id="course_formality_1" value="1"
                                                            @if($course_formality_id == 1) selected @endif>Tự học
                                                    </option>
                                                    @foreach($list_course_formality as $id=>$formality)
                                                        <option id="course_formality_{{ $formality->course_formality_id }}"
                                                                value="{{ $formality->course_formality_id }}"
                                                                @if($course_formality_id == $formality->course_formality_id) selected @endif
                                                        >{{ isset($formality['course_formality_title']) ? $formality['course_formality_title']: 'Tự học' }}</option>@endforeach
                                                </select>
                                                <p class="f14 mgt10 mgb10">
                                                <span class="js_course_formality_des">
                                                    {{ !empty($courses->course_formality_des) ? $courses->course_formality_des : ''  }}
                                                </span>
                                                </p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="course_id"
                                               value="{{ !empty($courses->course_id) ? $courses->course_id : 0 }}">
                                        @endif
                                        @if(!empty($_GET['employee_id']))
                                            <input type="hidden" name="employee_id" value="{{ $_GET['employee_id'] }}">
                                        @endif
                                        <div class="form-group row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-8 text-md-left text-center ">
                                                <button class="button_custom btn text-uppercase"
                                                        id="Cart_Button_ThanhtoanChuyenkhoan">hoàn thành
                                                </button>
                                                <div class="text-left mgt20">
                                                    <span>Chúng tôi sẽ gửi mã kích hoạt khóa gọc qua email ngay sau khi bạn nhập đầy đủ thông tin .</span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="payment_momo" role="tabpanel">
                            <div class="payment_detail row">
                                <div style="height:20rem;">
                                    <h1>Dịch vụ này hiện chưa hỗ trợ</h1>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="payment_vnpay" role="tabpanel">
                            <div class="payment_detail row">
                                <div style="height:20rem;">
                                    <h1>Dịch vụ này hiện chưa hỗ trợ</h1>
                                </div>
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

