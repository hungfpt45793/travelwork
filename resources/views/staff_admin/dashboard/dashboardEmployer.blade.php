@extends('staff_admin.layouts.master')
@section('title', 'Dashboard' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull mt-1 col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employer')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content col-content">
            <div class="content">
                <div class="container-fluid px-0 pt-4">
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-gradient-primary border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <p class="h6 card-title text-uppercase mb-0 text-white">NTD Chưa duyệt</p>
                                            <span class="h5 font-weight-bold mb-0 text-white">{{ $employer_chua_duyet }}/{{ $countemployer }}</span>
                                            <div class="progress progress-xs mt-3 mb-0" style="height: 7px">
                                                @php
                                                   $result_1 = round(($employer_chua_duyet*100)/$countemployer);
                                                @endphp
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$result_1}}%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <b><a href="{{ Route('staff_employer.index') }}?status_employer=0" class="text-white custom_a">Xem chi tiết</a></b>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-gradient-info border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <p class="h6 card-title text-uppercase mb-0 text-white">NTD đã duyệt</p>
                                            <span class="h5 font-weight-bold mb-0 text-white">{{ $employer_da_duyet }}/{{ $countemployer }}</span>
                                            <div class="progress progress-xs mt-3 mb-0" style="height: 7px">
                                                @php
                                                   $result_2 = round(($employer_da_duyet*100)/$countemployer);
                                                @endphp
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$result_2}}%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <b><a href="{{ Route('staff_employer.index') }}?status_employer=1" class="text-white custom_a">Xem chi tiết</a></b>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-gradient-danger border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <p class="h6 card-title text-uppercase mb-0 text-white">NTD đã xóa</p>
                                            <span class="h5 font-weight-bold mb-0 text-white">{{ $employer_xoa }}/{{ $countemployer }}</span>
                                            <div class="progress progress-xs mt-3 mb-0" style="height: 7px">
                                                @php
                                                    $result_3 = ceil(($employer_xoa*100)/$countemployer);
                                                @endphp
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $result_3 }}%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <b><a href="{{ Route('staff_employer_list_deleted') }}" class="text-white custom_a">Xem chi tiết</a></b>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-gradient-default border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <p class="h6 card-title text-uppercase mb-0 text-white">Việc làm NTD</p>
                                            <span class="h5 font-weight-bold mb-0 text-white">{{ $job_duyet }}/{{ $countJob }}</span>
                                            <div class="progress progress-xs mt-3 mb-0" style="height: 7px">
                                                @php
                                                    $result_4 = ceil(($job_duyet*100)/$countJob);
                                                @endphp
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$result_4}}%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <b><a href="{{ Route('staff_job-ntd.index') }}" class="text-white custom_a">Xem chi tiết</a></b>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div id="highChartsLine"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('staff_admin.dashboard.js.index')
<script type="text/javascript">
    var employerDaDuyetData= <?php echo json_encode($employerDaDuyetData) ?>;
    var employerChuaDuyetData= <?php echo json_encode($employerChuaDuyetData) ?>;
    var employerDaXoaData= <?php echo json_encode($employerDaXoaData) ?>;
    Highcharts.chart('highChartsLine', {
        title: {
            text: null
        },

        subtitle: {
            text: 'Biều đồ: NTD theo tháng '
        },

        yAxis: {
            title: {
                text: 'Số lượng NTD'
            }
        },

        xAxis: {
            categories: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12']
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
            }
        },
        credits: {
            enabled: false
        },
        series: [
            {
                name: 'NTD đã duyệt',
                data: employerDaDuyetData
            },
            {
                name: 'NTD chưa duyệt',
                data: employerChuaDuyetData
            },
            {
                name: 'NTD đã xóa',
                data: employerDaXoaData
            }
        ],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });
</script>
@endsection
