@extends('staff_admin.layouts.master')
@section('title', 'Dashboard' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull mt-1 col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.report')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content col-content">
            <div class="content">
                <div class="row">
                    <p class="col-md-3">Từ ngày <input type="date" class="form-control" id="begin-date"></p>
                    <p class="col-md-3">Đến ngày <input type="date" class="form-control" id="end-date"></p>
                    <button class="btn btn-outline-success" id="button-setData" style="height: 40px; margin-top:20px">Lọc ngày</button>
                </div>
                <div class="container-fluid px-0 pt-4">
                    <div id="chart_report"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('staff_admin.dashboard.js.index')
    {{-- <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script> --}}
<script>
$(function () {
    var chart
    $(document).ready(function() {
        var data10dayntd= <?php echo json_encode($data10dayntd) ?>;
        var data10dayfb= <?php echo json_encode($data10dayfb) ?>;
        var date= <?php echo json_encode($date) ?>;
        chart = new Highcharts.chart('chart_report', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: 'Biểu đồ ứng viên nộp hồ sơ'
            },
            xAxis: {
                categories: date,
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
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                pointPadding: 0.3,
                borderWidth: 0
                }
            },
            series: [{
                name: 'H/sơ NTD',
                data: data10dayntd
            }, {
                name: 'H/sơ FB',
                data: data10dayfb
            }]
        });
        $('#button-setData').click(function() {
            var begin = $('#begin-date').val()
            var end = $('#end-date').val()
            $.ajax({
                url: "{{ route('loc_ngay') }}",
                method: "POST",
                data: {
                    begin, end
                },
                success: function(data){
                    chart.series[0].setData(data.data10dayntd);
                    chart.series[1].setData(data.data10dayfb);
                    chart.xAxis[0].update({categories: data.date});
                }
            })
        });
    });
});
</script>
@endsection
