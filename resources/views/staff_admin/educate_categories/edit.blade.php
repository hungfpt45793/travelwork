@extends('staff_admin.layouts.master')
@section('title', 'Thêm mới chuyên mục' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.courses')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <form id="form" class="custom-form" action="{{ route('educateCategories.update', ['id'=> $educate_categorie->edu_cate_id]) }}" method="POST">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}
                    <div class="contentJobsInteresting pd15 col-f14">
                        <h5 class="text-info">Thêm mới chuyên mục</h5>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-group">
                                    <label for="tag_title">Tiêu đề chuyên mục</label>
                                    <input type="text" value="{{ isset($educate_categorie->edu_cate_title) ? $educate_categorie->edu_cate_title : ''  }}" class="form-control" onkeyup="ChangeToSlug();" id="slug" placeholder="Tiêu đề chuyên mục" data-parsley-required-message="Giá trị này là bắt buộc." required name="edu_cate_title">
                                </div>
                                <div class="form-group">
                                    <label for="tag_title">Slug chuyên mục</label>
                                    <input type="text" value="{{ isset($educate_categorie->edu_cate_slug) ? $educate_categorie->edu_cate_slug : ''  }}" class="form-control" id="convert_slug" placeholder="Slug chuyên mục" data-parsley-required-message="Giá trị này là bắt buộc." required name="edu_cate_slug">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả chuyên mục</label>
                                    <textarea class="form-control" name="edu_cate_des"  data-parsley-required-message="Giá trị này là bắt buộc." required>{{ isset($educate_categorie->edu_cate_des) ? $educate_categorie->edu_cate_des : ''  }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nội dung chuyên mục</label>
                                    <textarea class="form-control editor" id="edu_cate_content" name="edu_cate_content">{!! isset($educate_categorie->edu_cate_content) ? $educate_categorie->edu_cate_content : '' !!}</textarea>
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
