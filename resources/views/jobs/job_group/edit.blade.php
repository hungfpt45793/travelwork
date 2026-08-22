@extends('admin.layout.admin')

@section('title', 'Cập nhật nhóm việc làm ' . $jobGroup->job_group_name)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật nhóm việc làm {{$jobGroup->job_group_name}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc làm</a></li>
            <li><a href="#">Ngành nghề</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <form role="form" action="{{ route('job-group.update',["job_group_id"=>$jobGroup->job_group_id]) }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
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
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nhóm việc làm</label>
                                <input type="text" class="form-control" name="job_group_name" placeholder="Nhóm việc làm" value="{{$jobGroup->job_group_name}}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" class="form-control" value="{{$jobGroup->slug}}" name="slug" placeholder="đường dẫn tĩnh" >
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung</label>
                                <textarea class="editor" id="content" name="content" placeholder="Nội dung">{{$jobGroup->content}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh nhóm công việc</label><br>
								<input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
									   size="20"/>
								<img src="{{ $jobGroup->image }}" width="80" height="70"/>
								<input name="image" type="hidden" value="{{ $jobGroup->image }}"/>
							</div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Icon</label>
                                <input type="text" class="form-control" name="icon" placeholder="Icon" value="{{ $jobGroup->icon }}" required>
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
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Hỗ trợ Seo</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ title</label>
                                <input type="text" class="form-control" name="meta_title" placeholder="Thẻ title" value="{{$jobGroup->meta_title}}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ description</label>
                                <input type="text" class="form-control" name="meta_description" placeholder="Thẻ description" value="{{$jobGroup->meta_description}}"/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ keyword</label>
                                <input type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword" value="{{$jobGroup->meta_keyword}}"/>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning">Cập nhật</button>
                    </div>
                    <!-- /.box -->

                </div>

            </form>
        </div>
    </section>
@endsection