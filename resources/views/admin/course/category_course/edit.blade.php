@extends('admin.layout.admin')

@section('title', 'Cập nhật danh mục')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật danh mục
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhật danh mục</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('category_course.update',['id'=> $category_course->category_course_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Danh mục đào tạo</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề danh mục</label>
                                <input type="text" class="form-control" name="category_course_title" placeholder="Tiêu đề danh mục" value="{{ isset($category_course->category_course_title) ? $category_course->category_course_title : ''  }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả chuyên mục</label>
                                <textarea class="form-control" name="category_course_desc" rows="5">{{ isset($category_course->category_course_desc) ? $category_course->category_course_desc : ''  }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung chuyên mục</label>
                                <textarea class="form-control editor" id="category_course_content" name="category_course_content">{!! isset($category_course->category_course_content) ? $category_course->category_course_content : '' !!}</textarea>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </section>
@endsection