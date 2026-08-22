@extends('admin.layout.admin')

@section('title', 'Danh sách trạng thái giáo viên' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Trạng thái giáo viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh sách trạng thái giáo viên</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('teacher_status.create') }}"><button class="btn btn-primary" style="float: right">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên trạng thái</th>
                                <th>Slug trạng thái</th>
                                <th>Mô tả trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teacher_status  as $status)
                                <tr>
                                    <td>{{ $status->teacher_status_id }}</td>
                                    <td>{{ $status->teacher_status_name }}</td>
                                    <td>{{ $status->teacher_status_slug }}</td>
                                    <td>{{ $status->teacher_status_des }}</td>
                                    <td>{{ $status->name_age }}</td>
                                    <td>
                                        <a href="{{ route('teacher_status.edit',['teacher_status_id'=> $status->teacher_status_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('teacher_status.destroy',['teacher_status_id'=> $status->teacher_status_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
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
