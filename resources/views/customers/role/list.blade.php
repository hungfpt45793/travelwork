@extends('admin.layout.admin')

@section('title', 'Danh sáchPhân quyền' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Phân quyền
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh sách Phân quyền</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('role.create') }}"><button class="btn btn-primary" style="float: right">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên quyền</th>
                                <th>Role</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($role  as $r)
                                <tr>
                                    <td>{{ $r->id_role }}</td>
                                    <td>{{ $r->name_role }}</td>
                                    <td>{{ $r->role }}</td>
                                    <td>
                                        <a href="{{ route('role.edit',['id_role'=> $r->id_role]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('role.destroy',['id_role'=> $r->id_role]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
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
