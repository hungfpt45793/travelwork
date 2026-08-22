@extends('admin.layout.admin')

@section('title', 'Báo cáo doanh thu')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Báo cáo doanh thu
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Báo cáo</a></li>
            <li class="active"><a href="#">Báo cáo doanh thu</a></li>
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
                            <div class="col-xs-3 col-md-1">
                                <button class="btn btn-primary">Lọc</button>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-header -->
                    <!-- BAR CHART -->
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Báo cáo doanh thu theo thời gian</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body chart-responsive">
                            <div class="chart" id="bar-chart" style="height: 300px;"></div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <div class="box-body">
                        <table id="revenues" class="table table-bordered table-striped">
                            <thead>
                            <tr>
{{--                                <th width="5%">STT</th>--}}
                                <th>Thời gian</th>
                                <th>Cần đơn thành công</th>
{{--                                <th>Chiết khấu</th>--}}
{{--                                <th>Doanh thu</th>--}}
                                <th>Giá vốn</th>
{{--                                <th>Lợi nhuận</th>--}}
                            </tr>
                            </thead>
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
            $('#revenues').DataTable({
                processing: true,
                serverSide: true,
                type: 'GET',
                ajax: '{{route('dt_revenue')}}',
                columns: [
                    { data: 'date_order', name: 'orders.date_order' },
                    { data: 'order_number', name: 'order_number' },
                    { data: 'total_cost', name: 'total_cost' }
                ]
            });

            var bar = new Morris.Bar({
                element: 'bar-chart',
                resize: true,
                data: [
                    {y: '2006', a: 100, b: 90},
                    {y: '2007', a: 75, b: 65},
                    {y: '2008', a: 50, b: 40},
                    {y: '2009', a: 75, b: 65},
                    {y: '2010', a: 50, b: 40},
                    {y: '2011', a: 75, b: 65},
                    {y: '2012', a: 100, b: 90}
                ],
                barColors: ['#00a65a', '#f56954'],
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['CPU', 'DISK'],
                hideHover: 'auto'
            });
        });
    </script>
@endpush
