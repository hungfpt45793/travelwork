@extends('staff_admin.layouts.master')

@section('title', 'Thống kê giáo viên 12 tháng' )

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

                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4  style="margin: auto">Biểu đồ số lượng NTD theo tháng</h4>
                            </div>
                            <form method="get" id="search_year">
                                <div class="form-row align-items-center">
                                    <div class="col-auto">
                                        <input type="text" value="{{ (isset($_GET['year'])) ? $_GET['year'] : '' }}" class="form-control mb-2 numbers" name="year" id="inlineFormInput" placeholder="Chọn năm">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary mb-2">Chọn năm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if(isset($arr_employer))
                        <div class="panel-body">
                            <canvas id="myChart"></canvas>
                        </div>
                        <script>

                        var arr_employer = <?php echo json_encode($arr_employer) ?>;
                        console.log(arr_employer)
                        var chartHeight = arr_employer.length * 50;
                        chartHeight = chartHeight + 150;
                        $("#myChart").height(chartHeight);
                        var ctx = document.getElementById('myChart');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                                datasets: [{
                                    label: 'nhà tuyển dụng',
                                    data: arr_employer,
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
                                        ctx.fillText(data, bar._model.x, bar._model.y - 15);
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
                    </div>
                </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
<script>
    $(".numbers").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) &&e.which !=13) {
            return false;
        }
        if (e.which == 13) {
            $('#search_year').submit();
            return false;
        }
    });
</script>
@endsection
