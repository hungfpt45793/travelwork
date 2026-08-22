@extends('admin.layout.admin')

@section('title', 'Cập nhật giáo viên')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật giáo viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhật giáo viên</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('educate_teacher.update',['edu_tea_id'=> $educate_teacher->edu_tea_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Chuyên mục giáo viên</h3>
                        </div>

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên giáo viên</label>
                                <input type="text" class="form-control" name="edu_tea_name" placeholder="Tên giáo viên" value="{{ isset($educate_teacher->edu_tea_name) ? $educate_teacher->edu_tea_name : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email giáo viên</label>
                                <input type="text" class="form-control" name="edu_tea_email"
                                       placeholder="Email giáo viên" value="{{ isset($educate_teacher->edu_tea_email) ? $educate_teacher->edu_tea_email : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại giáo viên</label>
                                <input type="text" class="form-control" name="edu_tea_phone"
                                       placeholder="Số điện thoại giáo viên" value="{{ isset($educate_teacher->edu_tea_phone) ? $educate_teacher->edu_tea_phone : '' }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh giáo viên</label><br>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{$educate_teacher->edu_tea_image}}" width="50" />
                                <input name="edu_tea_image" type="hidden" value="{{$educate_teacher->edu_tea_image}}"/>
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung chuyên mục</label>
                                <textarea class="form-control editor" id="edu_cate_content"
                                          name="edu_tea_content">{!! isset($educate_teacher->edu_tea_content) ? $educate_teacher->edu_tea_content : '' !!}</textarea>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection