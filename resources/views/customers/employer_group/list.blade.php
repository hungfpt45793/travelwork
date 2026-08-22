@extends('admin.layout.admin')

@section('title', 'Danh sách loại hình doanh nghiệp')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Loại hình doanh nghiệp
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Loại hình DN</a></li>
            <li><a href="#" class="active">Danh sách</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <a href="{{route('typeOfBusiness.create')}}"><button class="btn btn-info" style="float:right;">Thêm mới</button></a>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="type-of-business" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Loại hình doanh nghiệp</th>
                                <th>slug doanh nghiệp</th>
                                <th class="currencyField">Trọng số lương</th>
                                <th class="currencyField">Tổng số tiền</th>
                                <th>Cần tuyển</th>
                                <th>Đã tuyển</th>
                                <th>Thao Tác</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Loại hình doanh nghiệp</th>
                                <th>slug doanh nghiệp</th>
                                <th class="currencyField">Trọng số lương</th>
                                <th>Tổng số tiền</th>
                                <th>Cần tuyển</th>
                                <th>Đã tuyển</th>
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
    <script>
        $(document).ready(function () {
            $('.currencyField').formatCurrency();
        })
    </script>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#type-of-business').DataTable({
                processing: true,
                serverSide: true,
                type: 'GET',
                ajax: '{{route('dt_type_business')}}',
                columns: [
                    { data: 'type_of_business_id', name:'type_of_business_id' },
                    { data: 'type_of_business_name', name:'type_of_business_name' },
                    { data: 'type_of_business_slug', name:'type_of_business_slug' },
                    { data: 'type_of_business_salary', name:'type_of_business_salary' },
                    { data: 'total_money', name:'total_money' ,
                        render: function (data) {
                            return '<b>' + numeral(data).format('0,0') + " VNĐ </b>";
                        }
                    },
                    { data: 'recruit', name:'recruit' ,
                        render: function (data) {
                            return numeral(data).format('0,0');
                        }
                    },
                    { data: 'recruited', name: 'recruited' ,
                        render: function (data) {
                            return numeral(data).format('0,0');
                        }
                    },
                    { data: 'action', name: 'action', searchable: false, orderable: false }
                ]
            });
        });
    </script>
@endpush
