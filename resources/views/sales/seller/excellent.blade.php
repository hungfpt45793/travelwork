@extends('admin.layout.admin')

@section('title', 'Người bán hàng giỏi nhất')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Người bán hàng giỏi nhất
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Người bán hàng giỏi nhất</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-8">
                                <div id="line-chart" style="height: 300px;"></div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="box box-widget widget-user">
                                    <!-- Add the bg color to the header using any of the bg-* classes -->
                                    <div class="widget-user-header bg-yellow">
                                        <h3 class="widget-user-username">Nguyễn Văn A</h3>
                                        <h5 class="widget-user-desc">Phòng hành chính nhân sự</h5>
                                    </div>
                                    <div class="widget-user-image">
                                        <img class="img-circle" src="/adminstration/img/user1-128x128.jpg" alt="User Avatar">
                                    </div>
                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-sm-4 border-right">
                                                <div class="description-block">
                                                    <h5 class="description-header">TOP</h5>
                                                    <span class="description-text">1</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4 border-right">
                                                <div class="description-block">
                                                    <h5 class="description-header">13.000.000</h5>
                                                    <span class="description-text">Doanh số</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4">
                                                <div class="description-block">
                                                    <h5 class="description-header">35</h5>
                                                    <span class="description-text">Gói bán hàng</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                </div>


                                <div class="box box-widget widget-user">
                                    <!-- Add the bg color to the header using any of the bg-* classes -->
                                    <div class="widget-user-header bg-aqua-active">
                                        <h3 class="widget-user-username">Nguyễn Văn B</h3>
                                        <h5 class="widget-user-desc">Phòng kinh doanh</h5>
                                    </div>
                                    <div class="widget-user-image">
                                        <img class="img-circle" src="/adminstration/img/user1-128x128.jpg" alt="User Avatar">
                                    </div>
                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-sm-4 border-right">
                                                <div class="description-block">
                                                    <h5 class="description-header">TOP</h5>
                                                    <span class="description-text">2</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4 border-right">
                                                <div class="description-block">
                                                    <h5 class="description-header">11.000.000</h5>
                                                    <span class="description-text">Doanh số</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4">
                                                <div class="description-block">
                                                    <h5 class="description-header">34</h5>
                                                    <span class="description-text">Gói bán hàng</span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
    <script src="{{ asset('adminstration/Flot/jquery.flot.js') }}"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="{{ asset('adminstration/Flot/jquery.flot.resize.js') }}"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="{{ asset('adminstration/Flot/jquery.flot.pie.js') }}"></script>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#jobs').DataTable();
        });
        var sin = [], cos = []
        for (var i = 0; i < 14; i += 0.5) {
            sin.push([i, Math.sin(i)])
            cos.push([i, Math.cos(i)])
        }
        var line_data1 = {
            data : sin,
            color: '#3c8dbc'
        }
        var line_data2 = {
            data : cos,
            color: '#00c0ef'
        }
        $(function () {
            $.plot('#line-chart', [line_data1], {
                grid: {
                    hoverable: true,
                    borderColor: '#f3f3f3',
                    borderWidth: 1,
                    tickColor: '#f3f3f3'
                },
                series: {
                    shadowSize: 0,
                    lines: {
                        show: true
                    },
                    points: {
                        show: true
                    }
                },
                lines: {
                    fill: false,
                    color: ['#3c8dbc', '#f56954']
                },
                yaxis: {
                    show: true
                },
                xaxis: {
                    show: true
                }
            });
        });
    </script>
@endpush
