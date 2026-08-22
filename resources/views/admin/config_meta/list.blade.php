@extends('admin.layout.admin')

@section('title', 'Danh sách độ tuổi' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Danh sách cấu hình thẻ meta SEO
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#"> Danh sách cấu hình thẻ meta SEO</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('config_meta.create') }}"><button class="btn btn-primary" style="float: right">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên trang</th>
                                <th>Slug</th>
                                <th>Meta_tile</th>
                                <th>Meta_description</th>
                                <th>Meta_keyword</th>
                                <th>Ảnh</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($configs  as $config)
                                <tr>
                                    <td>{{ $config->id_meta }}</td>
                                    <td>{{ $config->title }}</td>
                                    <td>{{ $config->slug }}</td>
                                    <td>{{ $config->meta_title }}</td>
                                    <td>{{ $config->meta_description }}</td>
                                    <td>{{ $config->meta_keywords }}</td>
                                    <td><img src="{{ $config->image }}" style="width: 70px"></td>
                                    <td>
                                        <a href="{{ route('config_meta.edit',['id_meta'=> $config->id_meta]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('config_meta.destroy',['id_meta'=> $config->id_meta]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
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
