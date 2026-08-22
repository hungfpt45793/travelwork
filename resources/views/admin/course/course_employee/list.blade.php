@extends('admin.layout.admin')

@section('title', '  Danh sách ứng viên đăng ký học' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách đơn hàng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Danh sách ứng viên đăng kí</a></li>
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
                        {{--<a href="{{ route('course_order.create') }}">--}}
                            {{--<button class="btn btn-primary" style="float: left">Thêm mới</button>--}}
                        {{--</a>--}}
                    </div>
                    <!-- /.box-header -->


                    <form role="search" action="" method="GET" id="submitForm">
                        <div class="box-body">
                            <div class="row">
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
                                        $course_code = '';
                                        if (isset($_GET['course_code'])) {
                                            $course_code = $_GET['course_code'];
                                        }
                                        ?>
                                        <input class="form-control" value="{{ !empty($course_code) ? $course_code : '' }}" name="course_code" placeholder="Mã khóa học">
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
                            <div class="row" style="margin-top: 10px">
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $employee_name = '';
                                        if (isset($_GET['employee_name'])) {
                                            $employee_name = $_GET['employee_name'];
                                        }
                                        ?>
                                        <input class="form-control" value="{{ !empty($employee_name) ? $employee_name : '' }}" name="employee_name" placeholder="Tên ứng viên">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $phone = '';
                                        if (isset($_GET['phone'])) {
                                            $phone = $_GET['phone'];
                                        }
                                        ?>
                                        <input class="form-control" value="{{ !empty($phone) ? $phone : '' }}" name="phone" placeholder="Số dt ứng viên">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $email = '';
                                        if (isset($_GET['email'])) {
                                            $email = $_GET['email'];
                                        }
                                        ?>
                                        <input class="form-control" value="{{ !empty($email) ? $email : '' }}" name="email" placeholder="Email ứng viên" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-center" style="margin-top: 20px">
                                <button type="submit" class="btn btn-success">Tìm Kiếm</button>
                            </div>

                        </div>
                    </form>


                    <div class="box-body">
                        <p> có tất cả {{ $list_employee->total() }} khóa học </p>
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Ngày đăng kí</th>
                                <th>Tên khóa học</th>
                                <th>Tên ứng viên</th>
                                <th>Email ứng viên</th>
                                <th>Số đt ứng viên</th>
                                <th>Mã kích hoạt</th>
                                <th>Tỉ lệ hoàn thành khóa học</th>
                                {{--<th>Giá khóa học</th>--}}
                                {{--<th>Thao tác</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_employee  as $employee)
                                <tr>
                                    <td>{{ $employee->course_employee_id }}</td>
                                    <td><?php
                                        $date = date_create($employee->created_at);
                                        echo date_format($date, "d/m/Y");
                                        ?></td>
                                    <td>{{ $employee->course_code }} - {{ $employee->course_title }}</td>
                                    <td>{{ $employee->employee_name }} </td>
                                    <td>{{ $employee->email }} </td>
                                    <td>{{ $employee->phone }} </td>
                                    <td><span style="color: white;background: green;padding: 5px 10px;">{{ $employee->activation_code }}</span></td>
                                    <td><span style="color: white;background: green;padding: 5px 10px;">{{ $employee->courde_profile }}</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pahe">
                            {{ $list_employee->links() }}
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
