@extends('staff_admin.layouts.master')
@section('title', 'Cập nhật đơn hàng' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.courses')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 " style="border: 1px solid #ccc;
    padding: 15px;">
                <form id="form" class="custom-form" action="{{ route('courseOrder.update', ['course_order_id'=> $order->course_order_id]) }}" method="POST">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}
                    <div class="contentJobsInteresting pd15 col-f14">
                        <h5 class="text-info">Cập nhật đơn hàng #{{ $order->course_order_id }}</h5>
                        <div class="row">
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mã đơn hàng :
                                        <span><strong>#{{ $order->course_order_id }}</strong></span>
                                    </label>
                                    <input type="hidden" name="course_order_id" value="{{ $order->course_order_id }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Thông tin User đăng kí :
                                    </label>
                                    <br>
                                    <span>
                                        - Họ và tên : <strong>{{ !empty($order->course_name) ? $order->course_name : '' }}</strong>
                                    </span>
                                    <br>
                                    <span>
                                        - Số điện thoại : <strong>{{ !empty($order->course_phone) ? $order->course_phone : '' }}</strong>
                                    </span>
                                    <br>
                                    <span>
                                        - Email : <strong>{{ !empty($order->course_email) ? $order->course_email : '' }}</strong>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ngày đăng kí :
                                        <span>
                                            <strong><?php
                                                $date = date_create($order->created_at);
                                                echo date_format($date, "d/m/Y");
                                                ?>
                                            </strong>
                                        </span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên khóa học :
                                        <span>
                                            <strong>
                                                 <?php
                                                $course_slug = \App\Course\Courses::get_couse_slug($order->course_id)
                                                ?>
                                                <a href="{{ route('course_showCourseDetail',['course_slug' => $course_slug]) }}">
                                                    {{ $order->course_code }} - {{ $order->course_title }}
                                                </a>
                                            </strong>
                                        </span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá khóa học : <span><strong>{{ !empty($order->course_cost) ? number_format($order->course_cost) : '' }}đ</strong></span></label>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mã kích hoạt khóa học : <span><strong> {{ $order->activation_code }}
                                                @if($order->activation_code_status == 0)
                                                    <span style="color: white;background: red;padding: 5px 10px;">Chưa kích hoạt</span>
                                                @else
                                                    <span style="color: white;background: green;padding: 5px 10px;">Đã kích hoạt</span>
                                                @endif</strong></span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">
                                        Thông tin đào tạo
                                        <?php
                                        $learn = \App\Entity\Learn_training::where('learn_id',$order->learn_id)->first();
                                        $list_training_1000 = \App\Entity\Learn_training_content::get_list_training($order->learn_id);
                                        ?>
                                    </label>
                                    <p>Cách học : {{ !empty($learn->learn_title) ? $learn->learn_title : '' }} </p>

                                    <div class="col-12 ul_list_train_pay_price">
                                        @if(!empty($list_training_1000))
                                            <ul>
                                                @foreach($list_training_1000 as $trai_1000)
                                                    <li>
                                                        - {{ !empty($trai_1000->trai_title) ? $trai_1000->trai_title : '' }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tin nhắn :
                                        <span><strong>{{ $order->course_messager }}</strong></span></label>
                                </div>
                            </div>
                            <div class="col-md-7 col-xs-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Admin cập nhật :
                                        <span>
                                            <strong> <?php
                                                $user_admin = App\Entity\User::getIdNameUser($order->admin_id);
                                                ?>
                                                {{ !empty( $user_admin->name) ?  $user_admin->name : '' }}
                                            </strong>
                                        </span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Thanh toán đơn hàng</label>
                                    <br>
                                    <label>
                                        <input type="radio" name="course_order_status" value="0"
                                               @if($order->course_order_status == 0) checked @endif style="width: 25px">Chưa
                                        thanh toán
                                    </label>
                                    <label style="margin-left: 20px">
                                        <input type="radio" name="course_order_status" value="1"
                                               @if($order->course_order_status == 1) checked @endif style="width: 25px">Đã
                                        thanh toán
                                    </label>

                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nội dung thanh toán</label>
                                    <textarea class="form-control editor" id="admin_messager"
                                              name="admin_messager">{!! $order->admin_messager !!}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@include('staff_admin.courses.cdn.index')
<script>
    $('#form').parsley();
</script>
@endsection
