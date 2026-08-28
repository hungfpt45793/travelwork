@extends('admin.layout.admin')

@section('title', 'Danh sách thông tin dịch vụ' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách thông tin dịch vụ
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh sách thông tin dịch vụ</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('information_service.create') }}"><button class="btn btn-primary" style="float: left">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Slug</th>
                                <th>Hình ảnh</th>
                                <th>Mô tả</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($info_service  as $info)
                                <tr>
                                    <td>{{ $info->service_id }}</td>
                                    <td>{{ isset($info->title) ? $info->title : ''  }}</td>
                                    <td>{{ isset($info->slug) ? $info->slug : ''  }}</td>
                                    <td><div style="background: #009385;text-align: center"><img src="{{ isset($info->images) ? $info->images : ''  }}" alt=""></div></td>
                                    <td>{!! isset($info->description) ? $info->description : ''  !!}</td>
                                    <td>
                                        <a href="{{ route('information_service.edit',['information_service'=> $info->service_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('information_service.destroy',['information_service'=> $info->service_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
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
