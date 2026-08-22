@extends('admin.layout.admin')

@section('title', ' Thêm mới  mẫu CV')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
         Thêm mới  mẫu CV
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới CV</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('cv_template.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin</h3>
                        </div>

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề</label>
                                <input type="text" class="form-control" name="cv_template_title" placeholder="Tiêu đề">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mẫu CV(tao mẫu sẵn)</label>
                                <input type="text" class="form-control" name="cv_template_view" placeholder="Tiêu đề">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"  style="color: #000">Danh mục nghề nghiệp</label>
                                <select class="select2" name="cv_career_category_id">
                                    @foreach(\App\Entity\Career::get() as $career)
                                        <option value="{{$career->career_category_id}}" >
                                            {{$career->career_category_name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">

                                <label for="inputEmail3" class=" control-label" style="color: #000">Hình ảnh<span class="red">(*)</span></label>

                                <div class="">
                                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                           size="20" style="color: #000"/>
                                    <img src="{{  old('cv_template_image') }}" width="80" height="70"/>
                                    <input name="cv_template_image" type="hidden" value="{{  old('cv_template_image') }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"  style="color: #000">Mô tả cv</label>
                                <textarea class="editor" id="editor" name="cv_template_content"></textarea>
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