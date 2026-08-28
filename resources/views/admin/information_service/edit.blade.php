@extends('admin.layout.admin')

@section('title', 'Sửa thông tin dịch vụ')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sửa {{ isset($info->title) ? $info->title : '' }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('information_service.update',['information_service'=> $info->service_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin dịch vụ</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề</label>
                                <input type="text" class="form-control" name="title" placeholder="Tiêu đề" value="{{ isset($info->title) ? $info->title : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh</label>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{ isset($info->images) ? $info->images : '' }}" width="80" height="70"/>
                                <input name="images" type="hidden" value="{{ isset($info->images) ? $info->images : '' }}"/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea rows="4" class="form-control editor" name="description"
                                          placeholder="" id="description">{!! isset($info->description) ? $info->description : '' !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung(hiển thị ở trang chi tiết)</label>
                                <textarea rows="4" class="form-control editor" name="content"
                                          placeholder="" id="content">{!! isset($info->content) ? $info->content : '' !!}</textarea>
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
