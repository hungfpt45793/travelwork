@extends('admin.layout.admin')

@section('title', 'Chỉnh sửa '.$theme->title )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa theme {{ $theme->title }}
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
            <form role="form" action="{{ route('themes.update', ['theme_id' => $theme->theme_id]) }}" method="POST">
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
                                <select class="form-control select2" name="group_id">
                                    @foreach($groupThemes as $groupTheme)
                                        <option value="{{ $groupTheme->group_id }}"
                                                @if($groupTheme->group_id == $theme->group_id) selected @endif>{{ $groupTheme->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="is_sale" value="1" class="flat-red" {{ ($theme->is_sale == 1) ? 'checked' : '' }}/>
                                    Có Bán hàng
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên theme</label>
                                <input type="text" class="form-control" name="name" placeholder="Tên theme"
                                       value="{{ $theme->name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã theme</label>
                                <input type="text" class="form-control" name="code" placeholder="Mã theme"
                                       value="{{ $theme->code }}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Đường dẫn dùng thử</label>
                                <input type="text" class="form-control" name="url_test" placeholder="Đường dẫn dùng thử"
                                       value="{{ $theme->url_test }}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea rows="4" class="form-control" name="description" placeholder="">{{ $theme->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá</label>
                                <input type="text" class="form-control" name="price" placeholder="Giá" value="{{ $theme->price }}" />
                            </div>

                            <div class="form-group">
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{ $theme->image }}" width="80" height="70"/>
                                <input name="image" type="hidden" value="{{ $theme->image }}"/>
                            </div>

                            <div class="form-group">
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh hiển thị điên thoại"
                                       size="20"/>
                                <img src="{{ $theme->image_phone }}" width="80" height="70"/>
                                <input name="image_phone" type="hidden" value="{{ $theme->image_phone }}"/>
                            </div>

                            <div class="form-group" style="color: red;">
                                @if ($errors->has('name'))
                                    <label for="exampleInputEmail1">{{ $errors->first('name') }}</label>
                                @endif
                                @if ($errors->has('code'))
                                    <label for="exampleInputEmail1">{{ $errors->first('code') }}</label>
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

