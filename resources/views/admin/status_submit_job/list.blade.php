@extends('admin.layout.admin')

@section('title', 'Danh sách Cấu hình' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cấu hình
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh sách cấu hình </a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('status_submit_job.create') }}"><button class="btn btn-primary" style="float: right">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên</th>
                                <th>thứ tự</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($status_submit_job  as $status)
                                <tr>
                                    <td>{{ $status->id_status }}</td>

                                    <td>{{ $status->name_status }}</td>
                                    <td>{{ $status->status_order }}</td>
                                    <td>
                                        <a href="{{ route('status_submit_job.edit',['id_status'=> $status->id_status]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('status_submit_job.destroy',['id_status'=> $status->id_status]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
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
