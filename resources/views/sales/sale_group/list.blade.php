@extends('admin.layout.admin')

@section('title', 'Danh sách nhóm gói bán hàng')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Nhóm gói bán hàng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách nhóm gói bán hàng</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <a href="{{route('saleGroup.create')}}"><button class="btn btn-info" style="float:right;">Thêm mới</button></a>
                            </div>
                        </div>
                    </div>

                    <div class="box-body">
                        <table id="saleGroups" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên nhóm gói bán hàng</th>
                                <th>Số lượng</th>
                                <th class="currencyField">Tổng giá</th>
                                <th>Đã thanh toán</th>
                                <th>Mô tả</th>
                                <th>Thao Tác</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên nhóm gói bán hàng</th>
                                <th>Số lượng</th>
                                <th>Tổng giá</th>
                                <th>Đã thanh toán</th>
                                <th>Mô tả</th>
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
    <script>
        $(document).ready(function () {
            $('.currencyField').formatCurrency();
        })
    </script>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#saleGroups').DataTable({
                processing: true,
                serverSide: true,
                type: 'GET',
                ajax: '{{route('dt_sale_group')}}',
                columns: [
                    { data: 'list_sales_packages_id', name:'list_sales_packages_id' },
                    { data: 'list_sales_packages_name', name:'list_sales_packages_name' },
                    { data: 'quantity', name:'quantity' ,
                        render: function (data) {
                            return '<b>' + numeral(data).format('0,0') + '</b>';
                        }
                    },
                    { data: 'total_costs', name:'total_costs' ,
                        render: function (data) {
                            return '<b>' + numeral(data).format('0,0') + ' VNĐ</b>';
                        }
                    },
                    { data: 'paid', name: 'paid' ,
                        render: function (data) {
                            return '<b>' + numeral(data).format('0,0') + ' VNĐ</b>';
                        }
                    },
                    { data: 'description', name:'description' },
                    { data: 'action', name: 'action', searchable: false, orderable: false }
                ]
            });
        });
    </script>
@endpush
