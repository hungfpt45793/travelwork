@extends('staff_admin.layouts.master')
@section('title', 'Dashboard' )
@push('styles')
<style>
    #highChartsMap {
    height: 450px;
    }
    .loading {
        margin-top: 10em;
        text-align: center;
        color: gray;
    }
</style>
@endpush
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull mt-1 col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employee')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content col-content">
            <div class="content">
                <div class="container-fluid px-0 pt-4">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card custom_card">
                                <div class="card-header position-relative pb-3">
                                    <div class="card-icon d-flex justify-content-center align-items-center position-absolute"
                                    style="background: linear-gradient(60deg ,#ffa726,#fb8c00);
                                    --mau_box_show: rgba(255, 166, 0, 0.3);"
                                    >
                                        <i class="fas fa-users text-white fa-2x"></i>
                                    </div>
                                    <div class="text-right">
                                        <h4 class="card-title mb-0">
                                            @php
                                                $uv = App\Entity\Employee::count();
                                                echo $uv;

                                                $h=strtotime("-24 hours");
                                                $Minus24Hours = date("Y-m-d", $h);

                                                $dataMinus24Hours = App\Entity\Employee::where('created_at', '>=', $Minus24Hours)
                                                ->count();
                                            @endphp
                                        </h4>
                                        <p class="card-category mb-0">Ứng viên</p>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <i class="fas fa-history text-warning"></i>
                                    <span>24 giờ qua: <i>{{ $dataMinus24Hours }} uv mới</i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card custom_card">
                                <div class="card-header position-relative pb-3">
                                    <div class="card-icon d-flex justify-content-center align-items-center position-absolute" style="
                                        background: linear-gradient(60deg ,#66bb6a,#43a047);
                                        --mau_box_show: rgba(0, 128, 0, 0.3);"
                                    >
                                        <i class="far fa-newspaper text-white fa-2x"></i>
                                    </div>
                                    <div class="text-right">
                                        <h4 class="card-title mb-0">
                                            @php
                                                $employees_submit = App\Entity\Employee::join('employee_submit_job_facebook', 'employees.employee_id', 'employee_submit_job_facebook.employee_id')
                                                ->groupBy('employee_submit_job_facebook.employee_id')->pluck('employee_submit_job_facebook.employee_id')->toArray();
                                                echo count($employees_submit);
                                            @endphp
                                        </h4>
                                        <p class="card-category mb-0">UV nộp hồ sơ</p>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <i class="fas fa-location-arrow text-success"></i>
                                    <a href="{{ Route('staff_employee_submit_job') }}">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card custom_card">
                                <div class="card-header position-relative pb-3">
                                    <div class="card-icon d-flex justify-content-center align-items-center position-absolute"
                                    style="background: linear-gradient(60deg, #26c6da,#00acc1);;
                                    --mau_box_show: rgba(0, 0, 255, 0.3);"
                                    >
                                        <i class="fab fa-joomla text-white fa-2x"></i>
                                    </div>
                                    <div class="text-right">
                                        <h4 class="card-title mb-0">
                                            @php
                                                $uv_di_lam = App\Entity\employee::where('status', 1)->count();
                                                $uv_chua_di_lam = App\Entity\employee::where('status', 0)->orWhere('status', null)->count();
                                                $uv_all = App\Entity\employee::count();
                                                echo $uv_di_lam;
                                            @endphp
                                        </h4>
                                        <p class="card-category mb-0">Ứng viên đã đi làm</p>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <i class="fas fa-arrow-alt-circle-right text-primary"></i>
                                    <a href="{{ Route('staff_employee.index') }}?status=0"><?php echo $uv_chua_di_lam; ?> ứng viên chưa đi làm</a>
                                </div>
                                {{-- <div class="card-footer" style="padding-top: 12.4px;padding-bottom: 12.4px;">
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar" style="width: {{$uv_di_lam}}%; background: #66bb6a;" role="progressbar" data-toggle="tooltip" data-placement="top" title="{{$uv_di_lam}} uv đi làm"></div>
                                        <div class="progress-bar" style="width: {{$uv_chua_di_lam}}%; background: #ef5350;" role="progressbar" data-toggle="tooltip" data-placement="top" title="{{$uv_chua_di_lam}} uv chưa đi làm"></div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card custom_card">
                                <div class="card-header position-relative pb-3">
                                    <div class="card-icon d-flex justify-content-center align-items-center position-absolute"
                                    style="background: linear-gradient(60deg,#ef5350,#e53935);
                                    --mau_box_show: rgba(255, 0, 0, 0.3);"
                                    >
                                        <i class="fa fa-folder-open text-white fa-2x"></i>
                                    </div>
                                    <div class="text-right">
                                        <h4 class="card-title mb-0">
                                            @php
                                                $employees_task = App\Entity\Task_detail::groupBy('employee_id')->pluck('employee_id')->toArray();
                                                $employees_not_task = App\Entity\Employee::whereNotIn('employees.employee_id', $employees_task)->pluck('employee_id')->toArray();
                                                echo count($employees_task);
                                            @endphp
                                        </h4>
                                        <p class="card-category mb-0">Ứng viên đã giao</p>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <i class="fas fa-arrow-alt-circle-right text-danger"></i>
                                    <a href="{{ Route('employee_no_task') }}"><?php echo count($employees_not_task); ?> ứng viên chưa giao</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <div id="highChartsArea"></div>
                        </div>
                        <div class="col-md-4">
                            <div id="highChartsMap"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="highChartsColumn1"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="highChartsColumn2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('staff_admin.dashboard.js.index')
<script type="text/javascript">
    var employeeData= <?php echo json_encode($employeeData) ?>;
    Highcharts.chart('highChartsArea', {
        chart: {
            type: 'area'
        },
        credits: {
            enabled: false
        },
        exporting: false,
        title: {
            text:null
        },
        subtitle: {
            text: 'Biểu đồ: Ứng viên theo tháng'
        },
        xAxis: {
            categories: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12']
        },
        yAxis: {
            title: {
                text: "Số lượng ứng viên"
            }
        },
        series: [{
            name: "Ứng viên",
            data: employeeData
        }],
    });
</script>
<script type="text/javascript">
    var data = <?php echo json_encode($arr) ?>;

    Highcharts.mapChart('highChartsMap', {
        chart: {
            map: 'countries/vn/vn-all'
        },
        credits: {
            enabled: false
        },
        exporting: false,
        title: {
            text:null
        },
        subtitle: {
            text: 'Biểu đồ: Ứng viên theo tỉnh'
        },
        mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'bottom'
            }
        },

        colorAxis: {
            min: 0
        },

        series: [{
            data: data,
            name: 'Tỉnh',
            states: {
                hover: {
                    color: '#BADA55'
                }
            },
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }]
    });
</script>
<script type="text/javascript">
    var employeeNotApproved= <?php echo json_encode($employeeNotApproved) ?>;
    var employeeApproved= <?php echo json_encode($employeeApproved) ?>;
    Highcharts.chart('highChartsColumn1', {
        chart: {
            type: 'column'
        },
        title: {
            text: null
        },
        subtitle: {
            text: 'Biểu đồ: So sánh UV duyệt và chưa duyệt'
        },
        xAxis: {
            categories: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Số lượng ứng viên'
            }
        },
        credits: {
            enabled: false
        },
        tooltip: {
            headerFormat: '<span style="font-size:12px">{point.key}</span><table>',
            pointFormat: '<tr><td style="font-size:12px;color:{series.color};padding:0" class="crop">{series.name}: </td>' +
                '<td style="font-size:12px;padding:0" class="crop"><b>{point.y:.1f} ứng viên</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Đã duyệt',
            data: employeeApproved

        }, {
            name: 'Chưa duyệt',
            data: employeeNotApproved

        }]
    });
</script>
<script type="text/javascript">
    var profileStatus= <?php echo json_encode($profileStatus) ?>;
    var profileNotStatus= <?php echo json_encode($profileNotStatus) ?>;
    var hoSoMoi= <?php echo json_encode($hoSoMoi) ?>;
    var hoSoCu= <?php echo json_encode($hoSoCu) ?>;
    Highcharts.chart('highChartsColumn2', {
        chart: {
            type: 'column'
        },
        title: {
            text: null
        },
        subtitle: {
            text: 'Biểu đồ: So sánh đi làm, chưa đi làm'
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            crosshair: true
        },
        yAxis: [
            {
            min: 0,
            title: {
                // text: 'Số lượng h/sơ cũ và h/sơ mới'
                text: null
            }
        },
        {
            title: {
                text: 'Số lượng h/sơ đã đi làm và h/sơ chưa đi làm'
            },
            opposite: true
        }],
        legend: {
            shadow: false
        },
        tooltip: {
            shared: true
        },
        plotOptions: {
            column: {
                grouping: false,
                shadow: false,
                borderWidth: 0
            }
        },
        series: [
        //     {
        //     name: 'H/Sơ cũ',
        //     color: 'rgba(165,170,217,1)',
        //     data: hoSoCu,
        //     tooltip: {
        //         valueSuffix: ' hồ sơ'
        //     },
        //     pointPadding: 0.3,
        //     pointPlacement: -0.2
        // }, {
        //     name: 'H/Sơ mới',
        //     color: 'rgba(126,86,134,.9)',
        //     data: hoSoMoi,
        //     tooltip: {
        //         valueSuffix: ' hồ sơ'
        //     },
        //     pointPadding: 0.4,
        //     pointPlacement: -0.2
        // },
        {
            name: 'H/Sơ đi làm',
            color: 'rgba(248,161,63,1)',
            data: profileStatus,
            tooltip: {
                valueSuffix: ' hồ sơ'
            },
            pointPadding: 0.3,
            pointPlacement: 0.2,
            yAxis: 1
        }, {
            name: 'H/Sơ chưa đi làm',
            color: 'rgba(186,60,61,.9)',
            data: profileNotStatus,
            tooltip: {
                valueSuffix: ' hồ sơ'
            },
            pointPadding: 0.4,
            pointPlacement: 0.2,
            yAxis: 1
        }]
    });
</script>
@endsection
