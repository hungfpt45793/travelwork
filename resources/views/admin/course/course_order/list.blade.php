@extends('admin.layout.admin')

@section('title', '  Danh sách đơn hàng' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách đơn hàng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Danh sách đơn hàng</a></li>
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
                                        <input class="form-control" value="{{ !empty($activation_code) ? $activation_code : '' }}" name="activation_code" placeholder="Mã kích hoạt khóa học">
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
                                        <input class="form-control" value="{{ !empty($course_title) ? $course_title : '' }}" name="course_title" placeholder="Tên khóa học" >
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12 text-center" style="margin-top: 20px">
                                <button type="submit" class="btn btn-success">Tìm Kiếm</button>
                            </div>

                        </div>
                    </form>


                    <div class="box-body">
                        <p> có tất cả {{ $list_order->total() }} khóa học </p>
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Ngày đăng kí</th>
                                <th>Ứng viên giới thiệu</th>
                                <th>Tên khóa học</th>
                                <th>Giá khóa học</th>
                                <th>Trạng thái khóa học</th>
                                <th>Thông tin user đăng kí</th>

                                <th>Mã kích hoạt</th>
                                <th>Admin</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_order  as $order)
                                <tr>
                                    <td>{{ $order->course_order_id }}</td>
                                    <td><?php
                                        $date = date_create($order->created_at);
                                        echo date_format($date, "d/m/Y");
                                        ?></td>
                                    <td>
                                        <?php
                                        $employee = \App\Entity\Employee::getIdEmployee($order->employee_id);
                                        ?>
                                        {{ !empty($employee->employee_id) ? $employee->employee_id : '' }}
                                            </br>
                                        {{ !empty($employee->employee_name) ? $employee->employee_name : '' }}

                                    </td>
                                    <td>
                                        <?php
                                        $course_slug = \App\Course\Courses::get_couse_slug($order->course_id)
                                        ?>
                                        <a href="{{ route('course_showCourseDetail',['course_slug' => $course_slug]) }}">
                                            {{ $order->course_code }}
                                            </br>- {{ $order->course_title }}
                                        </a>
                                    </td>
                                    <td>{{ !empty($order->course_cost) ? number_format($order->course_cost) : '' }}đ
                                    </td>
                                    <td>
                                        @if($order->course_order_status == 0)
                                            <span style="color: white;background: red;padding: 5px 10px;">Chưa thanh toán</span>
                                        @else
                                            <span style="color: white;background: green;padding: 5px 10px;">Đã thanh toán</span>
                                        @endif
                                    </td>
                                    <td>
                                        Họ và tên: {{ !empty($order->course_name) ? $order->course_name : '' }}
                                        </br> -{{ !empty($order->course_phone) ? $order->course_phone : '' }} </br>- {{ !empty($order->course_email) ? $order->course_email : '' }}
                                    </td>
                                    <td>
                                        {{ $order->activation_code }}
                                        @if($order->activation_code_status == 0)
                                            <span style="color: white;background: red;padding: 5px 10px;">Chưa KH</span>
                                        @else
                                            <span style="color: white;background: green;padding: 5px 10px;">Đã KH</span>
                                        @endif

                                    </td>
                                    <td>
                                        <?php
                                        $user_admin = App\Entity\User::getIdNameUser($order->admin_id);
                                        ?>
                                            {{ !empty($user_admin->name) ? $user_admin->name  : '' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('course_order.edit',['course_order_id'=> $order->course_order_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('course_order.destroy',['course_order_id'=> $order->course_order_id]) }}"
                                           class="btn btn-danger btnDelete" data-toggle="modal"
                                           data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
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
