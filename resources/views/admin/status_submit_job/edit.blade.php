@extends('admin.layout.admin')

@section('title', 'Sửa trạng thái')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật trạng thái
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhật trạng thái</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('status_submit_job.update',['id_status'=> $status_submit_job->id_status]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Trạng thái hồ sơ</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái hồ sơ</label>
                                <input type="text" class="form-control" name="name_status" placeholder="Trạng thái hồ sơ" value="{{ $status_submit_job->name_status }}">
                            </div>
                        </div>
                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Sắp xếp hồ sơ</label>
                                <input type="text" class="form-control" name="status_order" placeholder="Sắp xếp hồ sơ" value="{{ $status_submit_job->status_order }}">
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