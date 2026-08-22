@extends('admin.layout.admin')

@section('title', 'Thêm mới môn học')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới môn học
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới môn học</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('school_subject.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thêm mới môn học</h3>
                        </div>
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert"
                                     style="padding: 5px;margin: 2px;display: inline-block;">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã môn học</label>
                                <input type="text" class="form-control" name="sub_code" placeholder="Mã môn học">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên môn học</label>
                                <input type="text" class="form-control" name="sub_name" placeholder="Tên môn học">
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