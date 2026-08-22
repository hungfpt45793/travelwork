@extends('staff_admin.layouts.master')
@section('title', 'Cập nhật bình luận khóa học' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.courses')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <form id="form" class="custom-form" action="{{ route('courseQuestions.update', ['course_comments_id'=> $course_questions->course_comments_id]) }}" method="POST">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}
                    <div class="contentJobsInteresting pd15 col-f14">
                        <h5 class="text-info">Cập nhật bình luận khóa học</h5>
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                Mã bình luận: <strong>#{{$course_questions->course_comments_id}}</strong><br><br>
                                Tên ứng viên bình luận: <strong>{{$course_questions->name}}</strong><br><br>
                                Tên khóa học bình luận: <strong>{{$course_questions->course_title}}</strong><br><br>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nội dung bình luận</label>
                                    <textarea class="form-control" rows="5" name="course_comments_content">{!!$course_questions->course_comments_content!!}</textarea>
                                </div>
                                <label>Ẩn hiện nội dung bình luận</label><br>
                                <label style="margin-right: 20px">
                                    <input type="radio" @if($course_questions->course_comments_status == 0) checked @endif name="course_comments_status" value="0">Ẩn nội dung
                                </label>
                                <label>
                                    <input type="radio" @if($course_questions->course_comments_status == 1) checked @endif name="course_comments_status" value="1">Hiện nội dung
                                </label><br>
                                <button type="submit" class="btn btn-primary">Lưu lại</button>
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
