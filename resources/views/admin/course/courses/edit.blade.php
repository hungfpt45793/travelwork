@extends('admin.layout.admin')

@section('title', 'Cập nhật danh mục '.$course->course_title)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật khóa học : {{ $course->course_title }}
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
            <form role="form" action="{{ route('courses.update',['course_id'=> $course->course_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-7 col-md-7">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Cập nhật khóa học : {{ $course->course_title }}</h3>
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
                                       placeholder="Tiêu đề khóa học" value="{{ $course->course_title }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã khóa học</label>
                                <input type="text" class="form-control js_courses_code" name="course_code"
                                       placeholder="Mã khóa học" value="{{ $course->course_code }}" readonly>
                                <i class="js_courses_code_message red"></i>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug khóa học</label>
                                <input type="text" class="form-control" name="show_dlug"
                                       placeholder="Tiêu đề khóa học" value="{{ $course->course_slug }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh khóa học</label>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{ $course->course_image }}" width="80" height="70"/>
                                <input name="course_image" type="hidden" value="{{ $course->course_image  }}"/>
                            </div>



                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả khóa học</label>
                                <textarea class="form-control" name="course_descript" rows="5"> {{ $course->course_descript }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Khóa học này dành cho ai</label>
                                <textarea class="form-control editor" id="course_content"
                                          name="course_content">{!! $course->course_content !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lọi ích khóa học</label>
                                <textarea class="form-control editor" id="course_benefit"
                                          name="course_benefit">{!! $course->course_benefit !!}</textarea>
                            </div>

                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
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
                                       placeholder="Mã kích hoạt khóa học" value="{{ $course->activation_code }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá của khóa học</label>
                                <input type="text" class="form-control formatPrice" name="course_price"
                                       placeholder="Giá của khóa học" value="{{ $course->course_price }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giảm giá khóa học</label>
                                <input type="text" class="form-control formatPrice" name="course_discount"
                                       placeholder="Giá của khóa học" value="{{ $course->course_discount }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Danh mục khóa học</label>
                                <select class="select2" name="category_course_id">
                                    @foreach($list_category as $category)
                                        <option value="{{ !empty($category->category_course_id) ? $category->category_course_id : '' }}" @if($course->category_course_id == $category->category_course_id) selected @endif>{{ !empty($category->category_course_title) ? $category->category_course_title : '' }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giáo viên khóa học</label>
                                <select class="select2" name="teacher_id">
                                    @foreach($list_teacher as $teacher)
                                        <option value="{{ !empty($teacher->teacher_id) ? $teacher->teacher_id : '' }}"
                                                @if($course->teacher_id == $teacher->teacher_id) selected @endif
                                        >{{ !empty($teacher->teacher_name) ? $teacher->teacher_name : '' }}
                                            - {{ !empty($teacher->teacher_email) ? $teacher->teacher_email : '' }}
                                            - {{ !empty($teacher->teacher_phone) ? $teacher->teacher_phone : '' }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Từ khóa</label>
                                <select class="select2" name="tag_id[]" multiple>
                                    @foreach($list_tag as $tags)
                                        <option @if(in_array($tags['tag_id'], $tag)) selected @endif   value="{{ !empty($tags->tag_id) ? $tags->tag_id : '' }}">{{ !empty($tags->tag_title) ? $tags->tag_title : '' }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái</label>
                                </br>
                                <label>
                                    <input type="radio" name="course_status" value="0" @if($course->course_status == 0) checked @endif style="width: 25px">Không duyệt
                                </label>
                                <label style="margin-left: 20px">
                                    <input type="radio" name="course_status" value="1" @if($course->course_status == 1) checked @endif style="width: 25px">Đã duyệt
                                </label>

                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề mô tả 1</label>
                                <input type="text" class="form-control" name="title_detail1"
                                       placeholder="Đăng ký học ngay" value="{{ !empty($course->title_detail1) ? $course->title_detail1 : 'Đăng ký học ngay' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề mô tả 2</label>
                                <input type="text" class="form-control" name="title_detail2"
                                       placeholder="Sở hữu khóa học trọn đời" value="{{ !empty($course->title_detail2) ? $course->title_detail2 : 'Sở hữu khóa học trọn đời' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề mô tả 3</label>
                                <input type="text" class="form-control" name="title_detail3"
                                       placeholder="Khoá học này dành cho" value="{{ !empty($course->title_detail3) ? $course->title_detail3 : 'Khoá học này dành cho' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề mô tả 4</label>
                                <input type="text" class="form-control" name="title_detail4"
                                       placeholder="Bạn sẽ nhận được gì nếu đăng ký khóa học này" value="{{ !empty($course->title_detail4) ? $course->title_detail4 : 'Bạn sẽ nhận được gì nếu đăng ký khóa học này' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề mô tả 5</label>
                                <input type="text" class="form-control" name="title_detail5"
                                       placeholder="Nội dung khoá học" value="{{ !empty($course->title_detail5) ? $course->title_detail5 : 'Nội dung khoá học' }}">
                            </div>

                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection