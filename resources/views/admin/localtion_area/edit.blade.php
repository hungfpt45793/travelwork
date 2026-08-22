@extends('admin.layout.admin')
@section('title',  isset($local->title) ? $local->title : '')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sửa {{ isset($local->title) ? $local->title : '' }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active"> Sửa {{ isset($local->title) ? $local->title : '' }}</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->

            <form role="form" action="{{ route('location_area.update',['local_id'=> $local->local_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}

                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin khu vực</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên khu vực </label>
                                <input type="text" class="form-control" name="title" placeholder="Tên khu vực" value="{{ isset($local->title) ? $local->title : '' }}">
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