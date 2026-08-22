@extends('admin.layout.admin')

@section('title', 'Quản lý mã giảm giá')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Mã giảm giá
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách mã giảm giá</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-3 col-md-3">
                                <input type="date" class="form-control" name="title" placeholder="Từ ngày" value="" required>
                            </div>
                            <div class="col-xs-3 col-md-3">
                                <input type="date" class="form-control" name="title" placeholder="Đến ngày" value="" required>
                            </div>
                            <div class="col-xs-3 col-md-3">
                                <button class="btn btn-primary">Tìm kiếm</button>
                            </div>
                            <div class="col-xs-3 col-md-3">
                                <a href="{{ route('coupon.create') }}"><button class="btn btn-warning" style="float:right;">Thêm mới</button></a>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="jobs" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Chương trình</th>
                                <th>Mô tả</th>
                                <th>Thời gian</th>
                                <th>Số lượng coupon</th>
                                <th>Số lần đã sử dụng</th>
                                <th>Giá trị</th>
                                <th>Người tạo</th>
                                <th>Ngày tạo</th>
                                <th>Thao Tác</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>tham gia chương trình 2</td>
                                    <td>ban sach</td>
                                    <td>
                                        21/02/2019<br>
                                        03/01/2019
                                    </td>
                                    <td>50</td>
                                    <td>30</td>
                                    <td>5%</td>
                                    <td>nguyễn xuân kết</td>
                                    <td>20/02/2019</td>
                                    <td>
                                        <a href="{{ route('coupon.create') }}">
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
                                <td>tham gia chương trình 2</td>
                                <td>ban sach</td>
                                <td>
                                    21/02/2019<br>
                                    03/01/2019
                                </td>
                                <td>50</td>
                                <td>30</td>
                                <td>5%</td>
                                <td>nguyễn xuân kết</td>
                                <td>20/02/2019</td>
                                <td>
                                    <a href="{{ route('coupon.create') }}">
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
