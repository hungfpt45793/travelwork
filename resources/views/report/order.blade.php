@extends('admin.layout.admin')

@section('title', 'Báo cáo đơn hàng')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Báo cáo đơn hàng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Báo cáo</a></li>
            <li class="active"><a href="#">Báo cáo đơn hàng</a></li>
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
                            <h3 class="box-title">Báo cáo đơn hàng theo thời gian</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body chart-responsive">
                            <div class="chart" id="bar-chart" style="height: 300px;"></div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <div class="box-body">
                        <table id="jobs" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="2">Thời gian</th>
                                    <th colspan="4">Tổng đơn</th>
                                    <th colspan="6">Đơn thành công (tạo)</th>
                                    <th colspan="4">Đơn thành công (giao)</th>
                                </tr>

                                <tr>
                                    <!-- tổng đơn -->
                                    <th>Đơn</th>
                                    <th>Phí trả HVC</th>
                                    <th>Doanh thu</th>
                                    <th>Lợi nhuận</th>
                                    <!-- Đơn thành công (tạo) -->
                                    <th>Đơn</th>
                                    <th>Phí trả HVC</th>
                                    <th>Phí thu của khách</th>
                                    <th>Doanh thu</th>
                                    <th>Lợi nhuận</th>
                                    <th>CVR (%)</th>
                                    <!-- Đơn thành công (giao) -->
                                    <th>Đơn</th>
                                    <th>Phí trả HVC</th>
                                    <th>Phí thu khách hàng</th>
                                    <th>Doanh thu</th>
                                    <th>Lợi nhuận</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01/03/2019</td>
                                    <!-- tong don -->
                                    <td>7</td>
                                    <td>212.600</td>
                                    <td>955.500</td>
                                    <td>607.246	</td>
                                    <!-- Đơn thành công (tạo) -->
                                    <td>3</td>
                                    <td>104.500</td>
                                    <td>66.000</td>
                                    <td>565.500</td>
                                    <td>334.046</td>
                                    <td>42,9</td>
                                    <!-- Đơn thành công (giao) -->
                                    <td>3</td>
                                    <td>99.000</td>
                                    <td>97.300</td>
                                    <td>148.300</td>
                                    <td>57.209</td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td>01/03/2019</td>
                                    <!-- tong don -->
                                    <td>7</td>
                                    <td>212.600</td>
                                    <td>955.500</td>
                                    <td>607.246	</td>
                                    <!-- Đơn thành công (tạo) -->
                                    <td>3</td>
                                    <td>104.500</td>
                                    <td>66.000</td>
                                    <td>565.500</td>
                                    <td>334.046</td>
                                    <td>42,9</td>
                                    <!-- Đơn thành công (giao) -->
                                    <td>3</td>
                                    <td>99.000</td>
                                    <td>97.300</td>
                                    <td>148.300</td>
                                    <td>57.209</td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td>01/03/2019</td>
                                    <!-- tong don -->
                                    <td>7</td>
                                    <td>212.600</td>
                                    <td>955.500</td>
                                    <td>607.246	</td>
                                    <!-- Đơn thành công (tạo) -->
                                    <td>3</td>
                                    <td>104.500</td>
                                    <td>66.000</td>
                                    <td>565.500</td>
                                    <td>334.046</td>
                                    <td>42,9</td>
                                    <!-- Đơn thành công (giao) -->
                                    <td>3</td>
                                    <td>99.000</td>
                                    <td>97.300</td>
                                    <td>148.300</td>
                                    <td>57.209</td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td>01/03/2019</td>
                                    <!-- tong don -->
                                    <td>7</td>
                                    <td>212.600</td>
                                    <td>955.500</td>
                                    <td>607.246	</td>
                                    <!-- Đơn thành công (tạo) -->
                                    <td>3</td>
                                    <td>104.500</td>
                                    <td>66.000</td>
                                    <td>565.500</td>
                                    <td>334.046</td>
                                    <td>42,9</td>
                                    <!-- Đơn thành công (giao) -->
                                    <td>3</td>
                                    <td>99.000</td>
                                    <td>97.300</td>
                                    <td>148.300</td>
                                    <td>57.209</td>
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
