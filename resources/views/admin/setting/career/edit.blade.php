@extends('admin.layout.admin')

@section('title', 'Cập nhật Danh mục ngành nghề' . $career->career_category_name)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật Danh mục ngành nghề {{$career->career_category_name}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc làm</a></li>
            <li><a href="#">Danh mục ngành nghề</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('career.update',['career_category_id'=>$career->career_category_id]) }}" method="POST">
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

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Danh mục ngành nghề</label>
                                <input type="text" class="form-control" name="career_category_name" placeholder="Danh mục ngành nghề"
                                       value="{{$career->career_category_name}}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trọng số lương(thập phân)</label>
                                <input type="number"  step="0.01" class="form-control" name="career_category_salary" placeholder="đường dẫn tĩnh"
                                       value="{{$career->career_category_salary}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" class="form-control" name="slug" value="{{$career->slug}}" placeholder="đường dẫn tĩnh" >
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung</label>
                                <textarea class="" id="content" name="content" placeholder="Nội dung" style="width: 100%;padding: 10px" rows="3">{{$career->content}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh danh mục việc làm</label><br>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{$career->image}}" width="80" height="70"/>
                                <input name="image" type="hidden" value="{{$career->image}}"/>
                            </div>


                        </div>


                            <div class="box-header with-border">
                                <h3 class="box-title">Cấu hình phần xem hồ sơ(trừ xu của nhà tuyển dụng)</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Xem hồ sơ</label>
                                    <input type="number" class="form-control" name="view_profile" placeholder="xem hồ sơ" min="0" value="{{$career->view_profile}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mời ứng tuyển</label>
                                    <input type="number" class="form-control" name="view_apply" placeholder="Mời ứng tuyển" min="0" value="{{$career->view_apply}}" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Xuất hiện (Trang chủ)</label>
                                    <label class="form-control"><input type="radio" name="status_show" value="0" style="margin-right: 10px" @if($career->status_show == 0) checked @endif>Xuất hiện</label>
                                    <label class="form-control"><input type="radio" name="status_show" value="1" style="margin-right: 10px" @if($career->status_show == 1) checked= @endif>Ẩn</label>
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
                                    <option value="default"><a href="{{route('career.index')}}" target="_blank">Sang tab mới</a> </option>
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
                                <input type="text" class="form-control" name="meta_title" placeholder="Thẻ title" value="{{$career->meta_title}}"/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ description</label>
                                <input type="text" class="form-control" name="meta_description" placeholder="Thẻ description" value="{{$career->meta_description}}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ keyword</label>
                                <input type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword" value="{{$career->meta_keyword}}" />
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

