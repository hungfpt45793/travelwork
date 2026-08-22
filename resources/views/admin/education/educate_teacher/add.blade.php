@extends('admin.layout.admin')

@section('title', 'Thêm mới giáo viên ')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới giáo viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới giáo viên</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('educate_teacher.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Giáo viên</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên giáo viên</label>
                                <input type="text" class="form-control" name="edu_tea_name" placeholder="Tên giáo viên">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email giáo viên</label>
                                <input type="text" class="form-control" name="edu_tea_email"
                                       placeholder="Email giáo viên">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại giáo viên</label>
                                <input type="text" class="form-control" name="edu_tea_phone"
                                       placeholder="Số điện thoại giáo viên">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh giáo viên</label><br>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{old('edu_tea_image')}}" width="80" height="70"/>
                                <input name="edu_tea_image" type="hidden" value="{{old('edu_tea_image')}}"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung chuyên mục</label>
                                <textarea class="form-control editor" id="edu_tea_content"
                                          name="edu_tea_content"></textarea>
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