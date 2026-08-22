@extends('admin.layout.admin')

@section('title', 'Danh sách đơn hàng')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Đơn hàng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"></a>Đơn hàng</li>
            <li><a href="#"></a>Đơn hàng</li>
            <li><a href="#">Danh sách đơn hàng</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-header">
                        <a href="{{ route('order.create') }}" class="btn btn-info" style="float:right;">Thêm mới</a>
                    </div>

                    @if($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                <strong>{{ $error }}</strong>
                            </div>
                        @endforeach
                    @endif

                    <div class="box-body">
                        <table id="orders" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Nhà tuyển dụng</th>
                                <th>Ứng viên</th>
                                <th>Nhân viên PT</th>
                                <th>Công việc</th>
                                <th>Trạng thái</th>
                                <th>Lịch sử cuộc gọi</th>
                                <th>Giá</th>
                                <th>Thanh Toán</th>
                                <th>Ghi chú</th>
                                <th>Thao Tác</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Nhà tuyển dụng</th>
                                <th>Ứng viên</th>
                                <th>Nhân viên PT</th>
                                <th>Công việc</th>
                                <th>Trạng thái</th>
                                <th>Lịch sử cuộc gọi</th>
                                <th>Giá</th>
                                <th>Thanh Toán</th>
                                <th>Ghi chú</th>
                                <th>Thao Tác</th>
                            </tr>
                            </tfoot>
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
            $('#orders').DataTable({
                processing: true,
                serverSide: true,
                type: 'GET',
                ajax: '{{route('dt_order')}}',
                columns: [
                    { data: 'order_id', name: 'order_id' },
                    { data: 'enterprise_name', name: 'employer.enterprise_name' },
                    { data: 'employee_name', name: 'employees.employee_name' },
                    { data: 'name', name: 'users.name' },
                    { data: 'title', name: 'jobs.title' },
                    { data: 'status', name: 'status' ,
                        render: function (data) {
                            if(data == 0){
                                return 'Chưa xác định';
                            }
                            if(data == 1){
                                return 'Gửi CV';
                            }
                            if (data == 2){
                                return 'Thất bại';
                            }
                            if (data == 3){
                                return 'Đã phỏng vấn';
                            }
                            if (data == 4){
                                return 'Thành công';
                            }
                            return 'Đã đi làm';
                        }},
                    { data: 'history', name: 'history' },
                    {
                        data: 'total_price', name: 'total_price',
                        render: function (data) {
                            return '<b>' + numeral(data).format('0,0') + " VNĐ </b>";
                        }
                    },
                    { data: 'paid', name: 'paid' ,
                        render: function (data) {
                            return '<b>' + numeral(data).format('0,0') + " VNĐ </b>";
                        }
                    },
                    { data: 'note_admin', name: 'note_admin' },
                    { data: 'action', name: 'action', searchable: false, orderable: false }
                ]
            });
        });
    </script>
@endpush
