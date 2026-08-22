@extends('staff_admin.layouts.master')
@section('title', 'Cập nhật từ khóa khóa học' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.courses')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <form id="form" class="custom-form" action="{{ route('courseTag.update', ['tag_id'=> $course_tag->tag_id]) }}" method="POST">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}
                    <div class="contentJobsInteresting pd15 col-f14">
                        <h5 class="text-info">Cập nhật từ khóa khóa học</h5>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-group">
                                    <label for="tag_title">Từ khóa khóa học</label>
                                    <input type="text" value="{{ $course_tag->tag_title }}" class="form-control" onkeyup="ChangeToSlug();" id="slug" placeholder="Từ khóa khóa học" data-parsley-required-message="Giá trị này là bắt buộc." required name="tag_title">
                                </div>
                                <div class="form-group">
                                    <label for="tag_slug">Slug từ khóa khóa học</label>
                                    <input type="text" value="{{ $course_tag->tag_slug }}" class="form-control" id="convert_slug" placeholder="Slug từ khóa khóa học" data-parsley-required-message="Giá trị này là bắt buộc." required name="tag_slug">
                                </div>
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
