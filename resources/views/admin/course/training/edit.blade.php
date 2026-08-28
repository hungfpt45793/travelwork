@extends('admin.layout.admin')

@section('title', 'Cập nhật danh mục '.$training->trai_title)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật nội dung : {{ $training->trai_title }}
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
            <form role="form" action="{{ route('training.update', ['training' => $training->trai_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-7 col-md-7">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Cập nhật khóa học : {{ $training->trai_title }}</h3>
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
                                       placeholder="Tiêu đề nội dung" value="{{ $training->trai_title }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Chọn Khóa học</label>
                                <select name="course_id" class="select2">
                                    <option value="0" @if($training->course_id == 0) selected @endif>--Tất cả khóa học--</option>
                                    @foreach($list_course as $course)
                                        <option value="{{ $course->course_id }}" @if($training->course_id == $course->course_id) selected @endif>--{{ $course->course_title }}--</option>
                                    @endforeach
                                </select>
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
