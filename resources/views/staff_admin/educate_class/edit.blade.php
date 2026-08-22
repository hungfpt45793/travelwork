@extends('staff_admin.layouts.master')
@section('title', 'Cập nhật lớp đào tạo' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.courses')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <form id="form" class="custom-form" action="{{ route('educateClass.update', ['edu_class_id'=> $educate_class->edu_class_id]) }}" method="POST">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}
                    <div class="contentJobsInteresting pd15 col-f14">
                        <h5 class="text-info">Cập nhật lớp đào tạo</h5>
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="tag_title">Tên lớp đào tạo</label>
                                    <input type="text" value="{{ isset($educate_class->edu_class_name) ? $educate_class->edu_class_name : '' }}" class="form-control" onkeyup="ChangeToSlug();" id="slug" placeholder="Tên lớp đào tạo" data-parsley-required-message="Giá trị này là bắt buộc." required name="edu_class_name">
                                </div>
                                <div class="form-group">
                                    <label for="tag_slug">Slug lớp đào tạo</label>
                                    <input type="text" value="{{ isset($educate_class->edu_class_slug) ? $educate_class->edu_class_slug : '' }}" class="form-control" id="convert_slug" placeholder="Slug lớp đào tạo" data-parsley-required-message="Giá trị này là bắt buộc." required name="edu_class_slug">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ảnh lớp đào tạo</label><br>
                                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh" size="20"/>
                                    <img src="{{$educate_class->educate_class_image}}" width="50"/>
                                    <input name="educate_class_image" type="hidden" value="{{$educate_class->educate_class_image}}"/>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả đào tạo</label>
                                    <textarea class="form-control" id="edu_class_des" name="edu_class_des" rows="3">{{ isset($educate_class->edu_class_des) ? $educate_class->edu_class_des : '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tống số ứng viên</label>
                                    <input type="number" value="{{ isset($educate_class->edu_total_employee) ? $educate_class->edu_total_employee : '' }}" class="form-control" name="edu_total_employee" placeholder="Tống số ứng viên">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hạn đăng kí</label>
                                    <?php
                                        $date_edu = date_create($educate_class->edu_date_end);
                                    ?>
                                    <input type="date" value="{{ date_format($date_edu, "Y-m-d") }}" class="form-control" name="edu_date_end" placeholder="Hạn đăng kí">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nội dung đào tạo</label>
                                    <textarea class="form-control editor" id="edu_class_content" name="edu_class_content">{!! isset($educate_class->edu_class_content) ? $educate_class->edu_class_content : ''  !!}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Link nhóm group Zalo</label>
                                    <input type="text" value="{{ isset($educate_class->edu_class_link_zalo) ? $educate_class->edu_class_link_zalo : '' }}" class="form-control" name="edu_class_link_zalo" placeholder="Link nhóm group Zalo">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Video</label>
                                    <textarea class="form-control" id="edu_class_video" name="edu_class_video">{!! isset($educate_class->edu_class_video) ? $educate_class->edu_class_video : '' !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chuyên mục đào tạo</label>
                                    <?php
                                    $list_cate = \App\Entity\Educate_categories::getAll();
                                    ?>
                                    <select class="form-control select22" name="edu_cate_id">
                                        @foreach($list_cate as $cate)
                                            <option value="{{ isset($cate->edu_cate_id) ? $cate->edu_cate_id  : '' }}" @if($educate_class->edu_cate_id == $cate->edu_cate_id) selected @endif>
                                                --- {{ isset($cate->edu_cate_title) ? $cate->edu_cate_title  : '' }} ---
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên giáo viên</label>
                                    <input type="text" value="{{ isset($educate_class->teacher_name) ? $educate_class->teacher_name : '' }}" class="form-control" name="teacher_name" placeholder="Tên giáo viên">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Link giáo viên</label>
                                    <input type="text" value="{{ isset($educate_class->teacher_link) ? $educate_class->teacher_link : '' }}" class="form-control" name="teacher_link" placeholder="Link giáo viên">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Quy định đăng kí</label>
                                    <textarea class="form-control editor" id="edu_class_regulations" name="edu_class_regulations">{!! isset($educate_class->edu_class_regulations) ? $educate_class->edu_class_regulations : ''  !!}</textarea>
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
