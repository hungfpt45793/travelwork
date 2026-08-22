@extends('admin.layout.admin')

@section('title', 'Thêm mới khóa học')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới khóa học
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới khóa học</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('courses.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-7 col-md-7">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Danh sách khóa học</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group error">
                                @if(!empty($errors->all()))
                                    @foreach($errors->all() as $erorr)
                                        <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                    @endforeach
                                @endif
                            </div>



                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề khóa học</label>
                                <input type="text" class="form-control" name="course_title"
                                       placeholder="Tiêu đề khóa học" value="{{ old('course_title') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã khóa học</label>
                                <input type="text" class="form-control js_courses_code" name="course_code"
                                       placeholder="Mã khóa học" value="{{ old('course_code') }}">
                                <i class="js_courses_code_message red"></i>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh khóa học</label>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{ old('courses_code') }}" width="80" height="70"/>
                                <input name="course_image" type="hidden" value="{{ old('courses_code') }}"/>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả khóa học</label>
                                <textarea class="form-control" name="course_descript" rows="5"> {{ old('course_descript') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung khóa học</label>
                                <textarea class="form-control editor" id="course_content"
                                          name="course_content">{!! old('course_content') !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lọi ích khóa học</label>
                                <textarea class="form-control editor" id="course_benefit"
                                          name="course_benefit">{!! old('course_benefit') !!}</textarea>
                            </div>

                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-5 col-md-5">
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin liên quan</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã kích hoạt khóa học</label>
                                <input type="text" class="form-control" name="activation_code"
                                       placeholder="Mã kích hoạt khóa học" value="{{ old('activation_code') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá của khóa học</label>
                                <input type="text" class="form-control formatPrice" name="course_price"
                                       placeholder="Giá của khóa học" value="{{ old('course_price') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giảm giá khóa học</label>
                                <input type="text" class="form-control formatPrice" name="course_discount"
                                       placeholder="Giá của khóa học" value="{{ old('course_discount') }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Danh mục khóa học</label>
                                <select class="select2" name="category_course_id">
                                    @foreach($list_category as $category)
                                        <option value="{{ !empty($category->category_course_id) ? $category->category_course_id : '' }}" @if(old('category_course_id') == $category->category_course_id) selected @endif>{{ !empty($category->category_course_title) ? $category->category_course_title : '' }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giáo viên khóa học</label>
                                <select class="select2" name="teacher_id">
                                    @foreach($list_teacher as $teacher)
                                        <option value="{{ !empty($teacher->teacher_id) ? $teacher->teacher_id : '' }}"
                                                @if(old('teacher_id') == $teacher->teacher_id) selected @endif
                                        >{{ !empty($teacher->teacher_name) ? $teacher->teacher_name : '' }}
                                            - {{ !empty($teacher->teacher_email) ? $teacher->teacher_email : '' }}
                                            - {{ !empty($teacher->teacher_phone) ? $teacher->teacher_phone : '' }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái</label>
                                </br>
                                <label>
                                    <input type="radio" name="course_status" value="0"  style="width: 25px">Không duyệt
                                </label>
                                <label style="margin-left: 20px">
                                    <input type="radio" name="course_status" value="1" checked  style="width: 25px">Đã duyệt
                                </label>

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

