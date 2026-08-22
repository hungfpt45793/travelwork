@extends('admin.layout.admin')

@section('title', 'Thêm mới nhóm việc làm')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới nhóm việc làm
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc làm</a></li>
            <li><a href="#">Nhóm việc làm</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('job-group.store') }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-8">
                    <div class="box box-primary">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nhóm việc làm</label>
                                <input type="text" class="form-control" name="job_group_name" placeholder="Nhóm việc làm" value="{{old('job_group_name')}}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" class="form-control" name="slug" placeholder="đường dẫn tĩnh" value="{{old('slug')}}" >
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung</label>
                                <textarea class="editor" id="content" name="content" rows="10" cols="80"/>{{old('content')}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh nhóm công việc</label><br>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{old('image')}}" width="80" height="70"/>
                                <input name="image" type="hidden" value="{{old('image')}}"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Icon</label>
                                <input type="text" class="form-control" name="icon" placeholder="Icon" value="{{old('icon')}}" required>
                            </div>
                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-4">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Chọn giao diện hiển thị</label>
                                <select class="form-control" name="template">
                                    <option value="default">Mặc định</option>
                                    <option value="default"><a href="#" target="_blank">Sang tab mới</a> </option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Hỗ trợ Seo</h3>
                        </div>

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ title</label>
                                <input type="text" class="form-control" name="meta_title" placeholder="Thẻ title" value="{{old('meta_title')}}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ description</label>
                                <input type="text" class="form-control" name="meta_description" placeholder="Thẻ description" value="{{old('meta_description')}}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ keyword</label>
                                <input type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword" value="{{old('meta_keyword')}}"/>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection