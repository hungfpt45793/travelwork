@extends('admin.layout.admin')

@section('title', 'Cập nhật môn học')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật môn học
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('school_subject.update',['sub_id'=> $sub->sub_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">


                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã môn học</label>
                                <input type="text" class="form-control" name="sub_code" placeholder="Mã môn học" value="{{ $sub->sub_code }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên môn học</label>
                                <input type="text" class="form-control" name="sub_name" placeholder="Tên môn học" value="{{ $sub->sub_name }}">
                            </div>
                        </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-warning">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection