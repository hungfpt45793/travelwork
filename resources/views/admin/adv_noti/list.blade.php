@extends('admin.layout.admin')

@section('title', 'Danh sách quản cáo trang chủ' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            quản cáo trang chủ
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh sách quản cáo trang chủ</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('adv_noti.create') }}"><button class="btn btn-primary" style="float: left">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Link quảng cáo</th>
                                <th>Thời gian hiện quảng cáo</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($adv  as $id=>$ad)
                                <tr>
                                    <td>{{ $id  + 1 }}</td>
                                    <td>{{ $ad->adv_title }}</td>
                                    <td><a href="{{ $ad->adv_link }}" target="_blank">Link</a></td>
                                    <td>{{ $ad->adv_time }}</td>
                                    <td>
                                        <a href="{{ route('adv_noti.edit', ['adv_noti' => $ad->adv_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('adv_noti.destroy', ['adv_noti' => $ad->adv_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
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
