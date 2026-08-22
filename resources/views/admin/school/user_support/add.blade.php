@extends('admin.layout.admin')

@section('title', 'Thêm mới giảng viên')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới giảng viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới giảng viên</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('teacher_school.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thêm mới giảng viên</h3>
                        </div>
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert"
                                     style="padding: 5px;margin: 2px;display: inline-block;">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên giáo viên</label>
                                <input type="text" class="form-control" name="teacher_sc_name" placeholder="Tên giáo viên">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email giáo viên</label>
                                <input type="email" class="form-control" name="email" placeholder="Email giáo viên">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mật khẩu </label>
                                <input type="password" class="form-control" name="password" placeholder="Mật khẩu giáo viên">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại giáo viên</label>
                                <input type="text" class="form-control" name="teacher_sc_phone" placeholder="Số điện thoại giáo viên">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trường học</label>
                                <input type="text" class="form-control" name="teacher_school" placeholder="Trường học">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Logo trường học</label>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="" width="80" height="70"/>
                                <input name="image" type="hidden" value=""/>

                            </div>
                        </div>



                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection