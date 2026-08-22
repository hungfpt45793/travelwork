@extends('staff_admin.layouts.master')
@section('title', 'Thêm mới danh mục' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.courses')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <form id="form" class="custom-form" action="{{ route('categoryCourse.store') }}" method="POST">
                    <div class="contentJobsInteresting pd15 col-f14">
                        <h5 class="text-info">Thêm mới danh mục</h5>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-group">
                                    <label for="category_course_title">Tiêu đề danh mục</label>
                                    <input type="text" class="form-control" onkeyup="ChangeToSlug();" id="slug" placeholder="Tiêu đề danh mục" data-parsley-required-message="Giá trị này là bắt buộc." required name="category_course_title">
                                </div>
                                <div class="form-group">
                                    <label for="category_course_slug">Slug danh mục</label>
                                    <input type="text" class="form-control" id="convert_slug" placeholder="Slug danh mục" data-parsley-required-message="Giá trị này là bắt buộc." required name="category_course_slug">
                                </div>
                                <div class="form-group">
                                    <label for="category_course_desc">Mô tả danh mục</label>
                                    <textarea class="form-control" name="category_course_desc" rows="5"  data-parsley-required-message="Giá trị này là bắt buộc." required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="category_course_content">Nội dung danh mục</label>
                                    <textarea class="form-control editor" id="category_course_content" name="category_course_content"></textarea>
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
