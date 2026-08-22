@extends('admin.layout.admin')

@section('title', 'Danh sách độ tuổi' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Giảng viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh sách độ tuổi</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    @if (session('success'))
                        <div class="infoAlert">
                            <div class="alert alert-success">
                                <span>{{ session('success') }}</span>
                                <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                            </div>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="infoAlert">
                            <div class="alert alert-warning">
                                <span>{{ session('error') }}</span>
                                <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                            </div>
                        </div>
                    @endif
                        <div class="box-header text-left floatLeft">
                        <a href="{{ route('teacher_school.create') }}"><button class="btn btn-primary" style="float: right">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên giáo viên </th>
                                <th>Email giáo viên </th>
                                <th>Số điện thọai </th>
                                <th>User đăng kí</th>
                                <th>Ngày đăng kí</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($teacher_schools  as $teacher)
                                <tr>
                                    <td>{{ $teacher->teacher_sc_id }}</td>
                                    <td>{{ $teacher->teacher_sc_name }}</td>
                                    <td>{{ $teacher->teacher_sc_email }}</td>
                                    <td>{{ $teacher->teacher_sc_phone }}</td>
                                    <td>{{ $teacher->user_id }}</td>
                                    <td>
                                        <?php
                                        echo date_format($teacher->created_at,"d/m/Y");
                                        ?>
                                    </td>
                                    <td>
                                        <a href="{{ route('teacher_school.edit',['id_age'=> $teacher->teacher_sc_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('teacher_school.destroy',['id_age'=> $teacher->teacher_sc_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
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
