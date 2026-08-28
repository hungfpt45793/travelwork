@extends('admin.layout.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chi tiết đơn hàng : {{ $order->course_order_id }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhật danh mục</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('course_order.update', ['course_order' => $order->course_order_id]) }}"
                  method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-5 col-md-5">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin đơn hàng</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group error">
                                @if(!empty($errors->all()))
                                    @foreach($errors->all() as $erorr)
                                        <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                    @endforeach
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã đơn hàng :
                                    <span><strong>#{{ $order->course_order_id }}</strong></span>
                                </label>
                                <input type="hidden" name="course_order_id" value="{{ $order->course_order_id }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Thông tin User đăng kí :
                                </label>
                                </br>
                                <span>
                                         - Họ và tên : <strong>{{ !empty($order->course_name) ? $order->course_name : '' }}</strong>
                                    </span>
                                </br>
                                <span>
                                        - Số điện thoại : <strong>{{ !empty($order->course_phone) ? $order->course_phone : '' }}</strong>
                                    </span>
                                </br>
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
                                <label for="exampleInputEmail1">Giá khóa học : <span><strong>{{ !empty($order->course_cost) ? number_format($order->course_cost).'đ' : 'Miễn phí' }}</strong></span></label>
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

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-7 col-md-7">
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin liên quan</h3>
                        </div>

                        <div class="box-body">
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

                                </br>
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
                                </br>
                                <i>Nếu là đơn hàng miễn phí thì mặc định là đã thanh toán</i>

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung thanh toán</label>
                                <textarea class="form-control editor" id="admin_messager"
                                          name="admin_messager">{!! $order->admin_messager !!}</textarea>
                            </div>


                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
