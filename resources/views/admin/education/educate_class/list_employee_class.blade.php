@extends('admin.layout.admin')

@section('title', ' Danh sách lớp đào tạo'.$educate_class->edu_class_name )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách lớp đào tạo
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#"> {{ $educate_class->edu_class_name }}</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        @if (session('success'))
                            <div class="infoAlert">
                                <div class="alert alert-success">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert"
                                            aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="infoAlert">
                                <div class="alert alert-warning">
                                    <span>{{ session('error') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert"
                                            aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <p> có tất cả {{ $total }} ứng viên đào tạo</p>
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID ứng viên</th>
                                <th>Tên ứng viên</th>
                                <th>Email ứng viên</th>
                                <th>Số điện thoại</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_employee_class  as $employee)
                                <tr>
                                    <td>{{ isset($employee->employee_id) ? $employee->employee_id : '' }}</td>
                                    <td>{{ isset($employee->employee_name) ? $employee->employee_name : '' }}</td>
                                    <td>{{ isset($employee->email) ? $employee->email : '' }}</td>
                                    <td>{{ isset($employee->phone) ? $employee->phone : '' }}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection
