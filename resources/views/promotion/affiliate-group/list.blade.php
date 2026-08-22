@extends('admin.layout.admin')

@section('title', 'Quản lý Nhóm Affiliate')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Nhóm Affiliate
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách nhóm Affiliate</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6 col-md-2 col-lg-1">
                                <div class="dropdown">
                                    <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li><a href="{{ route('affiliate-group.create') }}">Thêm nhóm affiliate</a></li>
                                        <li><a href="{{ route('affiliate-setting.create') }}">Thêm cài đặt affiliate</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-6 col-md-2 col-lg-1">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fa fa-cogs" aria-hidden="true"></i> Hành động
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li><a href="{{ route('affiliate.index') }}">Danh sách affiliate</a></li>
                                        <li><a href="{{ route('affiliate-setting.index') }}">Danh sách cài đặt affiliate</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="jobs" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên nhóm</th>
                                <th>Mô tả</th>
                                <th>Nguời tạo</th>
                                <th>ngày tạo</th>
                                <th width="10%">Thao Tác</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Nhóm sách</td>
                                    <td>sách buôn</td>
                                    <td>nguyễn xuân kết</td>
                                    <td>20/02/2019</td>
                                    <td>
                                        <a href="{{ route('affiliate-group.create') }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a  href="" class="btn btn-danger btnDelete"
                                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Nhóm koma</td>
                                <td>Giày</td>
                                <td>nguyễn xuân kết</td>
                                <td>20/02/2019</td>
                                <td>
                                    <a href="{{ route('affiliate-group.create') }}">
                                        <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                    </a>
                                    <a  href="" class="btn btn-danger btnDelete"
                                        data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
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
    @include('admin.partials.visiable')
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#jobs').DataTable();
        });
    </script>
@endpush
