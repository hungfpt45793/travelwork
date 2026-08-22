{{--@extends('admin.layout.admin')--}}

{{--@section('title', 'Thêm mới chương cho khóa học')--}}

{{--@section('content')--}}
    {{--<!-- Content Header (Page header) -->--}}
    {{--<section class="content-header">--}}
        {{--<h1>--}}
            {{--Thêm mới chương cho khóa học--}}
        {{--</h1>--}}
        {{--<ol class="breadcrumb">--}}
            {{--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
            {{--<li><a href="#">Cài đặt</a></li>--}}
            {{--<li class="active">Thêm mới chương cho khóa học</li>--}}
        {{--</ol>--}}
    {{--</section>--}}
    {{--<section class="content">--}}
        {{--<div class="row">--}}
            {{--<!-- form start -->--}}
            {{--<form role="form" action="{{ route('store_course_chapter') }}" method="POST">--}}
                {{--{!! csrf_field() !!}--}}
                {{--{{ method_field('POST') }}--}}
                {{--<div class="col-xs-7 col-md-12">--}}
                    {{--<!-- Nội dung thêm mới -->--}}
                    {{--<div class="box box-primary">--}}

                        {{--<div class="box-header with-border">--}}
                            {{--<h3 class="box-title">Thêm chương cho khóa học : {{ $course->course_code }}--}}
                                {{--- {{ $course->course_title }}</h3>--}}
                        {{--</div>--}}

                        {{--<div class="box-body">--}}


                            {{--<div class="form-group error">--}}
                                {{--@if(!empty($errors->all()))--}}
                                    {{--@foreach($errors->all() as $erorr)--}}
                                        {{--<span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>--}}
                                    {{--@endforeach--}}
                                {{--@endif--}}
                            {{--</div>--}}



                            {{--<div class="form-group">--}}
                                {{--<label for="exampleInputEmail1">Tiêu đề chương khóa học</label>--}}
                                {{--<input type="text" class="form-control" name="course_chapter_name"--}}
                                       {{--placeholder="Tiêu đề chương khóa học" value="{{ old('course_chapter_name') }}">--}}
                            {{--</div>--}}

                            {{--<div class="form-group">--}}
                                {{--<label for="exampleInputEmail1">Hình ảnh chương khóa học</label>--}}
                                {{--<input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"--}}
                                       {{--size="20"/>--}}
                                {{--<img src="{{ old('course_chapter_image') }}" width="80" height="70"/>--}}
                                {{--<input name="course_chapter_image" type="hidden" value="{{ old('course_chapter_image') }}"/>--}}

                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<label for="exampleInputEmail1">Mô tả chương khóa học</label>--}}
                                {{--<textarea class="form-control" name="course_chapter_descript" rows="5"> {{ old('course_chapter_descript') }}</textarea>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<label for="exampleInputEmail1">Nội dung chương khóa học</label>--}}
                                {{--<textarea class="form-control editor" id="course_chapter_content"--}}
                                          {{--name="course_chapter_content">{!! old('course_chapter_content') !!}</textarea>--}}
                            {{--</div>--}}


                        {{--</div>--}}

                        {{--<div class="box-footer">--}}
                            {{--<button type="submit" class="btn btn-primary">Thêm mới</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</form>--}}
        {{--</div>--}}
    {{--</section>--}}


{{--@endsection--}}

