@extends('admin.layout.admin')

@section('title', 'Cập nhật thẻ meta')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật thẻ meta
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhật thẻ meta</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('config_meta.update',['id_meta'=> $config->id_meta]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên trang(mô tả trang)</label>
                                <input type="text" class="form-control" name="title" placeholder="Tên trang" value="{{ $config->title }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug hiển thị(vi dụ trang-chu là hiển thị trên trang chủ )</label>
                                <input type="text" class="form-control" name="slug" placeholder="Slug trang" value="{{ $config->slug }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Meta_tile(có thể cộng với tiêu đề tin với chi tiết tin)</label>
                                <input type="text" class="form-control" name="meta_title" placeholder="Tiêu đề trang" value="{{ $config->meta_title }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Meta_description</label>
                                <textarea class="form-control" name="meta_description" placeholder="Mô tả trang">{{ $config->meta_description }}</textarea>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Meta_keyword</label>
                                <input type="text" class="form-control" name="meta_keywords" placeholder="Từ khóa" value="{{ $config->meta_keywords }}">
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class=" control-label">Ảnh mô tả trong trang(nếu không chọn thì ảnh mặc định là logo)<span class="red">(*)</span></label>

                                <div class="">
                                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                           size="20"/>
                                    <img src="{{ asset($config->image) }}" width="80" height="70"/>
                                    <input name="image" type="hidden" value="{{ $config->image }}"/>
                                </div>
                            </div>

                            {{--<div class="form-group">--}}

                                {{--<label for="inputEmail3" class=" control-label">Ảnh mô tả trong trang(nếu không chọn thì ảnh mặc định là logo)<span class="red">(*)</span></label>--}}

                                {{--<div class="">--}}
                                    {{--<input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"--}}
                                           {{--size="20"/>--}}
                                    {{--<img src="{{  $config->image }}" width="80" height="70"/>--}}
                                    {{--<input name="image" type="hidden" value="{{  $config->image }}"/>--}}
                                {{--</div>--}}
                            {{--</div>--}}
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