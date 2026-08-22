@extends('admin.layout.admin')

@section('title', 'Danh sách đơn hàng đã xóa')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Đơn hàng đã xóa
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách đơn hàng đã xóa</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="jobs" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Nhà tuyển dụng</th>
                                <th>Ứng viên</th>
                                <th>Công việc</th>
                                <th>Trạng thái</th>
                                <th>Lịch sử cuộc gọi</th>
                                <th>Giá</th>
                                <th>Thanh Toán</th>
                                <th>Ngày xóa</th>
                                <th>Thao Tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Nhà sách vì dân</td>
                                <td>Nguyễn Văn A</td>
                                <td>Nhân viên marketting</td>
                                <td>thất bại</td>
                                <td>
                                    <i class="fa fa-search" aria-hidden="true"></i> 26/2/2019 <br>
                                    <i class="fa fa-search" aria-hidden="true"></i> 28/2/2019 <br>
                                </td>
                                <td>4.000.000</td>
                                <td>3.000.000</td>
                                <td>28/02/2019</td>
                                <td class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars" aria-hidden="true"></i> <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('order.create') }}">Sửa</a></li>
                                        <li><a href="#">Xóa</a></li>
                                    </ul>
                                </td>
                            </tr>
                            </tbody>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>TIVA</td>
                                <td>Nguyễn Văn B</td>
                                <td>Nhân viên văn phòng</td>
                                <td>thất bại</td>
                                <td>
                                    <i class="fa fa-search" aria-hidden="true"></i> 26/2/2019 <br>
                                    <i class="fa fa-search" aria-hidden="true"></i> 28/2/2019 <br>
                                </td>
                                <td>4.000.000</td>
                                <td>3.000.000</td>
                                <td>28/02/2019</td>
                                <td class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars" aria-hidden="true"></i> <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('order.create') }}">Sửa</a></li>
                                        <li><a href="#">Xóa</a></li>
                                    </ul>
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
