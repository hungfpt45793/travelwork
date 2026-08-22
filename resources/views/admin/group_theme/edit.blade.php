@extends('admin.layout.admin')

@section('title', 'Chỉnh sửa nhóm theme '.$groupTheme->title)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa nhóm theme{{ $groupTheme->title }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt nhóm theme</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('group-theme.update', ['group_id' => $groupTheme->group_id]) }}" method="POST">
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
                                <label for="exampleInputEmail1">Tên nhóm</label>
                                <input type="text" class="form-control" name="name" placeholder="Tên nhóm"
                                       value="{{ $groupTheme->name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea rows="4" class="form-control" name="description"
                                          placeholder="">{{ $groupTheme->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{ $groupTheme->image }}" width="80" height="70"/>
                                <input name="image" type="hidden" value="{{ $groupTheme->image }}"/>
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

