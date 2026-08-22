@extends('admin.layout.admin')

@section('title', 'Thêm mới trạng thái giáo viên')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới trạng thái giáo viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('teacher_status.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Trạng thái giáo viên</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái giáo viên</label>
                                <input type="text" class="form-control" name="teacher_status_name" placeholder="Trạng thái giáo viên">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả giáo viên</label>
                                <textarea type="text" class="form-control editor" id="teacher_status_des" name="teacher_status_des" placeholder="Mô tả giáo viên">
                                </textarea>
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