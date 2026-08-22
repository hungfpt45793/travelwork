@extends('admin.layout.admin')

@section('title', 'Danh sách loại hình kinh doanh')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Loại hình kinh doanh
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Loại hình KD</a></li>
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
                                <a href="{{route('business.create')}}"><button class="btn btn-info" style="float:right;">Thêm mới</button></a>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="type_business" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Loại hình kinh doanh</th>
                                    <th>slug kinh doanh</th>
                                    <th>Trọng số lương</th>
                                    <th>Tổng tiền</th>
                                    <th>Cần tuyển</th>
                                    <th>Đã tuyển</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Loại hình kinh doanh</th>
                                    <th>slug kinh doanh</th>
                                    <th>Trọng số lương</th>
                                    <th>Tổng tiền</th>
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
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#type_business').DataTable({
                processing: true,
                serverSide: true,
                type: 'GET',
                ajax: '{{route('dt_business')}}',
                columns: [
                    { data: 'business_type_id', name:'business_type_id' },
                    { data: 'business_type_name', name:'business_type_name' },
                    { data: 'business_type_slug', name:'business_type_slug' },
                    { data: 'business_type_salary', name:'business_type_salary' },
                    { data: 'total_costs', name:'total_costs' ,
                        render: function (data) {
                            return '<b>' + numeral(data).format('0,0') + " VNĐ </b>";
                        }
                    },
                    { data: 'recruit', name:'recruit' ,
                        render: function (data) {
                            return numeral(data).format('0,0');
                        }
                    },
                    { data: 'recruited', name:'recruited' ,
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
