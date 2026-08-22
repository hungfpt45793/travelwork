@extends('admin.layout.admin')

@section('title', 'Chỉnh sửa '.$helpVideo->title)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa video hướng dẫn {{ $helpVideo->title }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt thông tin</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('help-video.update', ['help_video_id' => $helpVideo->help_video_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-6">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label>Chọn nhóm theme</label>
                                <select class="form-control select2" name="group_help_video">
                                    @foreach($groupHelpVideos as $groupHelpVideo)
                                        <option value="{{ $groupHelpVideo->group_id }}"
                                                @if($groupHelpVideo->group_id == $helpVideo->group_help_video) selected @endif>{{ $groupHelpVideo->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Têu đề</label>
                                <input type="text" class="form-control" name="title" placeholder="Tên theme"
                                       value="{{ $helpVideo->title }}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Đường dẫn youtube</label>
                                <textarea rows="4" class="form-control" name="embbed_video" placeholder="">{{ $helpVideo->embbed_video }}</textarea>
                            </div>

                            <div class="form-group">
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{ $theme->image }}" width="80" height="70"/>
                                <input name="image" type="hidden" value="{{ $theme->image }}"/>
                            </div>

                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                    <!-- /.box -->

                </div>
                
            </form>
        </div>
    </section>
@endsection

