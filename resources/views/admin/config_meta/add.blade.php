@extends('admin.layout.admin')

@section('title', 'Thêm mới meta SEO')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới thẻ meta
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới thẻ meta</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('config_meta.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thêm mới</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên trang(mô tả trang)</label>
                                <input type="text" class="form-control" name="title" placeholder="Tên trang">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug hiển thị(vi dụ trang-chu là hiển thị trên trang chủ )</label>
                                <input type="text" class="form-control" name="slug" placeholder="Slug trang">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Meta_tile(có thể cộng với tiêu đề tin với chi tiết tin)</label>
                                <input type="text" class="form-control" name="meta_title" placeholder="Tiêu đề trang">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Meta_description</label>
                                <textarea class="form-control" name="meta_description" placeholder="Mô tả trang"></textarea>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Meta_keyword</label>
                                <input type="text" class="form-control" name="meta_keywords" placeholder="Từ khóa">
                            </div>
                            <div class="form-group">

                                <label for="inputEmail3" class=" control-label">Ảnh mô tả trong trang(nếu không chọn thì ảnh mặc định là logo)<span class="red">(*)</span></label>

                                <div class="">
                                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                           size="20"/>
                                    <img src="{{  old('image') }}" width="80" height="70"/>
                                    <input name="image" type="hidden" value="{{  old('image') }}"/>
                                </div>
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