@extends('admin.layout.admin')

@section('title', '  Thống kê đơn hàng đã thanh toán' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thống kê đơn hàng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Thống kê đơn hàng</a></li>
            <li><a href="#">Danh mục</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        @if (session('success'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger text-center" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <a href="{{ route('course_order.create') }}">
                            <button class="btn btn-primary" style="float: left">Thêm mới</button>
                        </a>
                    </div>
                    <!-- /.box-header -->


                    <form role="search" action="" method="GET" id="submitForm">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $course_order_status = '';
                                        if (isset($_GET['course_order_status'])) {
                                            $course_order_status = $_GET['course_order_status'];
                                        }
                                        ?>

                                        <select class="form-control select2" name="course_order_status">
                                            <option value="" selected>-- Trạng thái đơn hàng --</option>
                                            <option value="0" @if($course_order_status == '0') selected @endif
                                            >-- Chưa thanh toán --
                                            </option>
                                            <option value="1" @if($course_order_status == '1') selected @endif
                                            >-- Đã thanh toán --
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $activation_code = '';
                                        if (isset($_GET['activation_code'])) {
                                            $activation_code = $_GET['activation_code'];
                                        }
                                        ?>
                                        <input class="form-control"
                                               value="{{ !empty($activation_code) ? $activation_code : '' }}"
                                               name="activation_code" placeholder="Mã kích hoạt khóa học">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $course_title = '';
                                        if (isset($_GET['course_title'])) {
                                            $course_title = $_GET['course_title'];
                                        }
                                        ?>
                                        <input class="form-control"
                                               value="{{ !empty($course_title) ? $course_title : '' }}"
                                               name="course_title" placeholder="Tên khóa học">
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12 text-center" style="margin-top: 20px">
                                <button type="submit" class="btn btn-success">Tìm Kiếm</button>
                            </div>

                        </div>
                    </form>


                    <div class="box-body">
                        {{--<p> có tất cả {{ $list_order->total() }} khóa học </p>--}}
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Khóa học</th>
                                <th>Hình thức học</th>
                                <th>Giá khóa học(lúc mua)</th>
                                <th>Chiết khấu ứng viên</th>
                                <th>Chiết khấu giáo viên</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sum_order_employee = 0;
                            $sum_order_teacher = 0;
                            ?>
                            @foreach($list_order  as $order)
                                <tr>
                                    <td>{{ $order->course_order_id }}</td>
                                    <td>
                                        {{ $order->course_code }} -
                                        </br>
                                        {{ $order->course_title }}
                                    </td>
                                    <td>
                                        {{ $order->course_formality_title }}
                                    </td>

                                    <td>
                                        {{ !empty($order->course_cost) ? number_format($order->course_cost) : 0 }} đ
                                    </td>
                                    <td>
                                        {{ !empty($order->course_price_employee) ? number_format($order->course_price_employee) : 0 }}
                                        đ
                                        <?php
                                        $sum_order_employee += $order->course_price_employee;
                                        ?>
                                    </td>
                                    <td>
                                        {{ !empty($order->course_price_teacher) ? number_format($order->course_price_teacher) : 0 }}
                                        đ
                                        <?php
                                        $sum_order_teacher += $order->course_price_teacher;
                                        ?>
                                    </td>

                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="6" class="text-right">
                                    <span style="font-size: 20px;color: red">
                                          Chiết khấu ứng viên : {{ !empty($sum_order_employee) ? number_format($sum_order_employee) :  0 }} đ
                                    </span>
                                </td>
                            </tr>
                            <tr>

                                <td colspan="6" class="text-right">
                                    <span style="font-size: 20px;color: red">
                                          Chiết khấu giáo viên : {{ !empty($sum_order_teacher) ? number_format($sum_order_teacher) :  0 }} đ
                                    </span>
                                </td>
                            </tr>
                            <tr>

                                <td colspan="6" class="text-right">
                                    <span style="font-size: 20px;color: red">
                                          Tổng giá trị đơn hàng : {{ !empty($sum_order) ? number_format($sum_order) :  0 }} đ
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right">
                                    <span style="font-size: 20px;color: red;font-weight: bold">
                                        <?php
                                        $sum_order_static = $sum_order - ($sum_order_employee + $sum_order_teacher);
                                        ?>
                                          Doanh thu : {{ !empty($sum_order_static) ? number_format($sum_order_static) :  0 }} đ
                                    </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="pahe">
                            {{ $list_order->links() }}
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection
