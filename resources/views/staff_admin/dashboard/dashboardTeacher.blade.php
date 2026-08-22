@extends('staff_admin.layouts.master')
@section('title', 'Dashboard' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull mt-1 col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.teacher')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content col-content">
            <div class="content">
                <div class="container-fluid px-0 pt-4">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body d-flex">
                                    <i class="fas fa-chalkboard-teacher fa-3x mt-1 ml-2" style="color: #00c292;"></i>
                                    <div class="text-left ml-5">
                                        <div class="h5" style="color: #455a64">{{$teacher_all}}</div>
                                        <div class="h6" style="color: #99abb4;">Giáo viên</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body d-flex">
                                    <i class="fas fa-paper-plane fa-3x mt-1 ml-2" style="color: #03a9f3;"></i>
                                    <div class="text-left ml-5">
                                        <div class="h5" style="color: #455a64">{{$teacher_tt}}</div>
                                        <div class="h6" style="color: #99abb4;">GV tương tác</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body d-flex">
                                    <i class="fas fa-sync-alt fa-3x mt-1 ml-2" style="color: #ab8ce4;"></i>
                                    <div class="text-left ml-5">
                                        <div class="h5" style="color: #455a64">{{$teacher_chuyen}}</div>
                                        <div class="h6" style="color: #99abb4;">GV chuyển TK</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body d-flex">
                                    <i class="fas fa-trash-alt fa-3x mt-1 ml-2" style="color: #fb9678;"></i>
                                    <div class="text-left ml-5">
                                        <div class="h5" style="color: #455a64">{{$teacher_xoa}}</div>
                                        <div class="h6" style="color: #99abb4;">GV đã xóa</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div id="highChartsCol"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('staff_admin.dashboard.js.index')
<script type="text/javascript">
    var teacherData= <?php echo json_encode($teacherData) ?>;
    var teacherXoaData= <?php echo json_encode($teacherXoaData) ?>;
    var teacherActData= <?php echo json_encode($teacherActData) ?>;
    var teacherCTK= <?php echo json_encode($teacherCTK) ?>;
    Highcharts.chart('highChartsCol', {
        chart: {
            type: 'column'
        },
        title: {
            text: null
        },
        subtitle: {
            text: 'Biểu đồ: Giáo viên theo tháng'
        },
        xAxis: {
            categories: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Số lượng giáo viên'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} GV</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
            {
                name: 'Tổng GV',
                data: teacherData
            }, {
                name: 'Tương tác GV',
                data: teacherActData
            }, {
                name: 'GV CTK',
                data: teacherCTK

            }, {
                name: 'GV xóa',
                data: teacherXoaData

            }
        ]
    });
</script>
@endsection
