@extends('admin.layout.admin')

@section('title', 'Danh sách nhóm đơn xin việc' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Danh sách nhóm đơn xin việc
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh sách độ tuổi</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">

                        @if (session('success'))
                            <div class="infoAlert">
                                <div class="alert alert-success">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="infoAlert">
                                <div class="alert alert-warning">
                                    <span>{{ session('error') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif



                        <a href="{{ route('job_app.create') }}"><button class="btn btn-primary" style="float: right">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <p>Tổng số mẫu đơn xin việc {{ $total }}</p>
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên đơn xin việc</th>
                                <th>Nhóm xin việc</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_job_app  as $job)
                                <tr>
                                    <td>{{ $job->job_app_id }}</td>
                                    <td>{{ $job->job_app_name }}</td>
                                    <?php
                                    $caree = \App\Entity\Career::getIdCareer($job->career_category_id);
                                    ?>
                                    <td>{{ isset($caree->career_category_name) ? $caree->career_category_name  : ''}}</td>
                                    <td>
                                        <a href="{{ route('job_app.edit',['job_app_id'=> $job->job_app_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('job_app.destroy',['job_app_id'=> $job->job_app_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection
