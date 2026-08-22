@extends('staff_admin.layouts.master')
@section('title', 'Cập nhật phản hồi khóa học' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.courses')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <form id="form" class="custom-form" action="{{ route('courseFeedback.update', ['course_feedback_id'=> $course_feedback->course_feedback_id]) }}" method="POST">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}
                    <div class="contentJobsInteresting pd15 col-f14">
                        <h5 class="text-info">Cập nhật phản hồi khóa học</h5>
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                Mã phản hồi: <strong>#{{$course_feedback->course_feedback_id}}</strong><br><br>
                                Tên ứng viên phản hồi: <strong>{{$course_feedback->employee_name}}</strong><br><br>
                                Tên khóa học phản hồi: <strong>{{$course_feedback->course_title}}</strong><br><br>
                                Xếp hạng phản hồi: <strong>{{$course_feedback->ratings}} sao</strong><br><br>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nội dung phản hồi</label>
                                    <textarea class="form-control" rows="5" name="course_feedback_descript">{!!$course_feedback->course_feedback_descript!!}</textarea>
                                </div>
                                <label>Ẩn hiện nội dung phản hồi</label><br>
                                <label style="margin-right: 20px">
                                    <input type="radio" @if($course_feedback->course_feedback_status == 0) checked @endif name="course_feedback_status" value="0">Ẩn nội dung
                                </label>
                                <label>
                                    <input type="radio" @if($course_feedback->course_feedback_status == 1) checked @endif name="course_feedback_status" value="1">Hiện nội dung
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
