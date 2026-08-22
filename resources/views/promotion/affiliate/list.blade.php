@extends('admin.layout.admin')

@section('title', 'Danh sách công việc')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Công việc
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách công việc</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
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
                                        <li><a href="{{ route('affiliate-group.index') }}">Danh sách nhóm affiliate</a></li>
                                        <li><a href="{{ route('affiliate-setting.index') }}">Danh sách cài đặt affiliate</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="box-body">
                        <table id="jobs" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Mã giới thiệu</th>
                                    <th>Nhóm</th>
                                    <th>Số điện thoại</th>
                                    <th>Hoa hồng</th>
                                    <th>Trạng thái</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Anthony</td>
                                    <td>Sách</td>
                                    <td>0123.456.789</td>
                                    <td>Lê Văn Thiêm Hà Nội</td>
                                    <td>5%</td>
                                    <td>
                                        <a href="{{ route('affiliate.edit') }}">
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
                                    <td>Anthony</td>
                                    <td>Sách</td>
                                    <td>0123.456.789</td>
                                    <td>Lê Văn Thiêm Hà Nội</td>
                                    <td>5%</td>
                                    <td>
                                        <a href="{{ route('affiliate.edit') }}">
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
                                    <td>Anthony</td>
                                    <td>Sách</td>
                                    <td>0123.456.789</td>
                                    <td>Lê Văn Thiêm Hà Nội</td>
                                    <td>5%</td>
                                    <td>
                                        <a href="{{ route('affiliate.edit') }}">
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
