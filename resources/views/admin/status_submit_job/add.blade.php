@extends('admin.layout.admin')

@section('title', 'Thêm mới Trạng thái hồ sơ')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới Trạng thái hồ sơ
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới Trạng thái hồ sơ</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('status_submit_job.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Trạng thái hồ sơ</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái hồ sơ</label>
                                <input type="text" class="form-control" name="name_status" placeholder="Trạng thái hồ sơ">
                            </div>
                        </div>
                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Sắp xếp hồ sơ</label>
                                <input type="text" class="form-control" name="status_order" placeholder="Sắp xếp hồ sơ">
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