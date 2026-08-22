@extends('admin.layout.admin')

@section('title', 'Thêm mới Phân quyền')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật Phân quyền
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('role.update',['id_role'=> $role->id_role]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Phân quyền mong muốn</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên quyền</label>
                                <input type="text" class="form-control" name="name_role" placeholder="Tên quyền" value="{{ $role->name_role }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Role</label>
                                <input type="text" class="form-control" name="role" placeholder="role" value="{{ $role->role }}">
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-warning">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection