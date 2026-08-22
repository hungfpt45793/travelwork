@extends('admin.layout.admin')

@section('title', 'Thêm mới nội dung đào tạo')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới nội dung đào tạo
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới nội dung đào tạo</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('training.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-7 col-md-7">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung đào tạo</h3>
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
                                <label for="exampleInputEmail1">Tiêu đề nội dung</label>
                                <input type="text" class="form-control" name="trai_title"
                                       placeholder="Tiêu đề khóa học" value="{{ old('trai_title') }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Chọn Khóa học</label>
                                <select name="course_id" class="select2">
                                    <option value="0">--Tất cả khóa học--</option>
                                    @foreach($list_course as $course)
                                    <option value="{{ $course->course_id }}">--{{ $course->course_title }}--</option>
                                    @endforeach
                                </select>
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

