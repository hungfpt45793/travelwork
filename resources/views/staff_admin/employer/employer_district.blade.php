@extends('staff_admin.layouts.master')

@section('title', 'Thống kê giáo viên huyện' )

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
                    <h5>Tỉnh {{ $province_name }}</h5>
                    <ul class="ul-province">
                        @foreach ($districts as $district)
                        <?php
                            $count = App\Http\Controllers\Staff\EmployerController::countEmployerD($district->district_id);
                        ?>
                        {{-- <form action="{{ route('staff_employer.index') }}" method="get">
                            <input type="hidden" value="{{ $district->district_id }}" name="district">
                            <input type="hidden" value="{{ $province_id }}" name="province"> --}}
                            <li>
                                <a href="{{ route('staff_employer.index') }}?district={{ $district->district_id }}&&province={{ $province_id }}"  @if($count == 0) style="color: red" @endif>
                                    {{ $district->district_name }}({{ $count }})
                                </a>
                            </li>
                        {{-- </form> --}}
                        @endforeach
                    </ul>
                </div>
                @if(!empty($name_district))
                <div class="col-sm-12 col-md-12">
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4  style="margin: auto">Biểu đồ số lượng NTD của tỉnh {{ $province_name}}</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
                <script>
                var name_district = <?php echo json_encode($name_district); ?>;
                var count_district = <?php echo json_encode($count_district); ?>;

                    var max = Math.max(...count_district) +10


                var chartHeight = count_district.length * 50;
                chartHeight = chartHeight + 150;
          	    $("#myChart").height(chartHeight);
                var ctx = document.getElementById('myChart');
                var myChart = new Chart(ctx, {
                    type: 'horizontalBar',
                    data: {
                        labels: name_district,
                        datasets: [{
                            label: 'nhà tuyển dụng',
                            data: count_district,
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
                                    beginAtZero: true,
                                    max: max,
                                    autoSkipPadding:100
                                },
                                textStrokeWidth: 100
                            }],
                        },
                        responsive: true,
                        maintainAspectRatio: false,
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
                @endif
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
@endsection
