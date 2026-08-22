@extends('staff_admin.layouts.master')

@section('title', 'Thống kê giáo viên 63 tỉnh thành' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employer')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting pd15 col-f14 ">
                    <h5 class="text-info">Danh sách các tỉnh</h5>
                    <ul class="ul-province">

                        @foreach ($provinces as $province)
                        <?php
                            $count = App\Http\Controllers\Staff\EmployerController::countEmployerP($province->province_id);
                        ?>

                        <li ><a href="{{ route('staff_employer_district',['province_id'=>$province->province_id]) }}" @if($count == 0) style="color: 1" @endif>{{ $province->province_name }}({{ $count }})</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4  style="margin: auto">Biểu đồ số lượng NTD của mỗi tỉnh</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
                <script>
                var name_province = <?php echo json_encode($name_province); ?>;
                var count_province = <?php echo json_encode($count_province); ?>;
                var chartHeight = count_province.length * 50;
                chartHeight = chartHeight + 150;
          	    $("#myChart").height(chartHeight);
                var ctx = document.getElementById('myChart');
                var myChart = new Chart(ctx, {
                    type: 'horizontalBar',
                    data: {
                        labels: name_province,
                        datasets: [{
                            label: 'nhà tuyển dụng',
                            data: count_province,
                            backgroundColor: 'rgb(183 10 27)',
                            borderColor: 'rgb(0 123 255 / 30%)',
                            borderWidth: 1,
                            maxBarThickness: 30,
                        }]
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        responsive: true,
                        legend: {
                            position: 'bottom',
                            display: true,

                        },
                        "hover": {
                        "animationDuration": 0
                        },
                        "animation": {
                            "duration": 1,
                        "onComplete": function() {
                            var chartInstance = this.chart,
                            ctx = chartInstance.ctx;

                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';

                            this.data.datasets.forEach(function(dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function(bar, index) {
                                var data = dataset.data[index];
                                ctx.fillText(data, bar._model.x +15, bar._model.y +5);
                            });
                            });
                        }
                        },
                        title: {
                            display: false,
                            text: ''
                        },
                    }
                });
                </script>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
@endsection
