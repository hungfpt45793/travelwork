@extends('admin.layout.admin')

@section('title', 'Danh sách gói bán hàng')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gói bán hàng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Bán hàng</a></li>
            <li><a href="#">Gói bán hàng</a></li>
            <li class="active"><a href="#">Danh sách</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-3 col-md-3">
{{--                                <input type="date" class="form-control" name="title" placeholder="Từ ngày" value="" required>--}}
                            </div>
                            <div class="col-xs-3 col-md-3">
{{--                                <input type="date" class="form-control" name="title" placeholder="Đến ngày" value="" required>--}}
                            </div>
                            <div class="col-xs-3 col-md-3">
{{--                                <button class="btn btn-primary">Tìm kiếm</button>--}}
                            </div>
                            <div class="col-xs-3 col-md-3">
                                <a href="{{ route('sale.create') }}" class="btn btn-info" style="float:right;">Thêm mới</a>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="sales" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Gói bán hàng</th>
                                <th>Ngày đăng</th>
                                <th>Nhà tuyển dụng</th>
                                <th>Phụ Trách</th>
                                <th>Số lượng cần tuyển</th>
                                <th>Đã tuyển</th>
                                <th>Chiết khấu</th>
                                <th>Tổng tiền</th>
                                <th>Thanh Toán</th>
                                <th>Trạng thái</th>
                                <th>Ghi Chú</th>
                                <th>Thao Tác</th>
                            </tr>
                            </thead>
							<tbody>
							<tr>
                                <th width="5%">ID</th>
                                <th>Gói bán hàng</th>
                                <th>Ngày đăng</th>
                                <th>Nhà tuyển dụng</th>
                                <th>Phụ Trách</th>
                                <th>Số lượng cần tuyển</th>
                                <th>Đã tuyển</th>
                                <th>Chiết khấu</th>
                                <th class ="currencyField">1000000</th>
                                <th>Thanh Toán</th>
                                <th>Trạng thái</th>
                                <th>Ghi Chú</th>
                                <th>Thao Tác</th>
                            </tr></tbody>
                            <tfoot>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Gói bán hàng</th>
                                <th>Ngày đăng</th>
                                <th>Nhà tuyển dụng</th>
                                <th>Phụ Trách</th>
                                <th>Số lượng cần tuyển</th>
                                <th>Đã tuyển</th>
                                <th>Chiết khấu</th>
                                <th>Tổng tiền</th>
                                <th>Thanh Toán</th>
                                <th>Trạng thái</th>
                                <th>Ghi Chú</th>
                                <th>Thao Tác</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
@endsection
@push('scripts')
    <script>
			$(function() {
            $('#sales').DataTable({
                processing: true,
                serverSide: true,
                type: 'GET',
                ajax: '{{route('dt_sale')}}',
                columns:[
                    { data: 'sale_package_id', name: 'sale_package_id' },
                    { data: 'sale_package_name', name: 'sale_package_name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'enterprise_name', name: 'employer.enterprise_name' },
                    { data: 'name', name: 'users.name' },
                    { data: 'recruit_number', name: 'recruit_number' ,
                        render: function (data) {
                            return numeral(data).format('0,0');
                        }
                    },
                    { data: 'recruited', name: 'recruited' ,
                        render: function (data) {
                            return numeral(data).format('0,0');
                        }
                    },
                    { data: 'discount', name: 'discount' },
                    { data: 'price', name: 'price' ,
                        render: function (data) {
                            return '<b>' + numeral(data).format('0,0') + " VNĐ </b>";
                        }},
                    { data: 'paid', name: 'paid',
                        render: function (data) {
                            return '<b>' + numeral(data).format('0,0') + " VNĐ </b>";
                        } 
					},
                    { data: 'status', name: 'status' ,
                        render: function (data) {
                            if(data == 0){
                                return 'Chưa xác định';
                            }
                            if(data == 1){
                                return 'Đang chăm sóc';
                            }
                            if(data == 2){
                                return 'Thất bại';
                            }
                            return 'Thành công';
                        }},
                    { data: 'description', name: 'description' },
                    { data: 'action', name: 'action', searchable: false, orderable: false },
                ]
				});
			});
		
    </script>
@endpush
