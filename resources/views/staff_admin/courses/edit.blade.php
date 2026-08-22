@extends('staff_admin.layouts.master')
@section('title', 'Cập nhật khóa học' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.courses')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <form id="form" class="custom-form" action="{{ route('coursesStaff.update', ['course_id'=> $course->course_id]) }}" method="POST">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}
                    <div class="contentJobsInteresting pd15 col-f14">
                        <h5 class="text-info">Cập nhật khóa học : {{ $course->course_title }}</h5>
                        <div class="row">
                            <div class="col-md-7 col-xs-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tiêu đề khóa học</label>
                                    <input type="text" value="{{ $course->course_title }}" class="form-control" data-parsley-required-message="Giá trị này là bắt buộc." required name="course_title" placeholder="Tiêu đề khóa học">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug khóa học</label>
                                    <input type="text" value="{{ $course->course_slug }}" readonly class="form-control" data-parsley-required-message="Giá trị này là bắt buộc." required name="course_slug" placeholder="Slug khóa học">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mã khóa học</label>
                                    <input type="text" value="{{ $course->course_code }}" readonly class="form-control js_courses_code" data-parsley-required-message="Giá trị này là bắt buộc." required name="course_code" placeholder="Mã khóa học">
                                    <i class="js_courses_code_message red"></i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh khóa học</label>
                                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh" size="20"/>
                                    <img src="{{ $course->course_image }}" width="80"/>
                                    <input name="course_image" type="hidden" value="{{ $course->course_image  }}"/>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả khóa học</label>
                                    <textarea class="form-control" data-parsley-required-message="Giá trị này là bắt buộc." required name="course_descript" rows="5">{{ $course->course_descript }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Khóa học này dành cho ai</label>
                                    <textarea class="form-control editor" id="course_content" name="course_content">{!! $course->course_content !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Lợi ích khóa học</label>
                                    <textarea class="form-control editor" id="course_benefit" name="course_benefit">{!! $course->course_benefit !!}</textarea>
                                </div>
                            </div>
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mã kích hoạt khóa học</label>
                                    <input type="text" class="form-control" name="activation_code" value="{{ $course->activation_code }}" placeholder="Mã kích hoạt khóa học">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Danh mục khóa học</label>
                                    <select class="select22" name="category_course_id">
                                        @foreach($list_category as $category)
                                            <option value="{{ !empty($category->category_course_id) ? $category->category_course_id : '' }}" @if($course->category_course_id == $category->category_course_id) selected @endif>{{ !empty($category->category_course_title) ? $category->category_course_title : '' }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giáo viên khóa học</label>
                                    <select class="select22" name="teacher_id">
                                        @foreach($list_teacher as $teacher)
                                            <option value="{{ !empty($teacher->teacher_id) ? $teacher->teacher_id : '' }}" @if($course->teacher_id == $teacher->teacher_id) selected @endif>
                                                {{ !empty($teacher->teacher_name) ? $teacher->teacher_name : '' }}
                                                - {{ !empty($teacher->teacher_email) ? $teacher->teacher_email : '' }}
                                                - {{ !empty($teacher->teacher_phone) ? $teacher->teacher_phone : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Từ khóa</label>
                                    <select class="select22" name="tag_id[]" multiple>
                                        @foreach($list_tag as $tags)
                                            <option @if(in_array($tags['tag_id'], $tag)) selected @endif   value="{{ !empty($tags->tag_id) ? $tags->tag_id : '' }}">{{ !empty($tags->tag_title) ? $tags->tag_title : '' }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá của khóa học</label>
                                    <input type="text" class="form-control formatPrice" name="course_price" value="{{ $course->course_price }}" placeholder="Giá của khóa học">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giảm giá khóa học</label>
                                    <input type="text" class="form-control formatPrice" name="course_discount" value="{{ $course->course_discount }}" placeholder="Giá của khóa học">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Trạng thái</label>
                                    <br>
                                    <label>
                                        <input type="radio" name="course_status" value="0" @if($course->course_status == 0) checked @endif style="width: 25px">Không duyệt
                                    </label>
                                    <label style="margin-left: 20px">
                                        <input type="radio" name="course_status" value="1" @if($course->course_status == 1) checked @endif style="width: 25px">Đã duyệt
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@include('staff_admin.courses.cdn.index')
<script>
    $('#form').parsley();
</script>
@endsection
