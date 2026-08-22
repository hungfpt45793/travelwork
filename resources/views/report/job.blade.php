@extends('admin.layout.admin')

@section('title', 'Báo cáo công việc')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Báo cáo công việc
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Báo cáo</a></li>
            <li class="active"><a href="#">Báo cáo công việc</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-3 col-md-2">
                                <input type="date" class="form-control" name="title" placeholder="Từ ngày" value="" required>
                            </div>
                            <div class="col-xs-3 col-md-2">
                                <input type="date" class="form-control" name="title" placeholder="Đến ngày" value="" required>
                            </div>
                            <div class="col-xs-3 col-md-2">
                                <select class="form-control">
                                    <option>Danh mục việc làm</option>
                                    <option>Marketting giày</option>
                                    <option>Marketting sách</option>
                                </select>
                            </div>
                            <div class="col-xs-3 col-md-2">
                                <select class="form-control select2">
                                    <option>Lựa chọn khách hàng</option>
                                    <option>VN3C</option>
                                    <option>Tiva</option>
                                    <option>Sách vì dân</option>
                                    <option>Koma</option>
                                </select>
                            </div>
                            <div class="col-xs-3 col-md-1">
                                <button class="btn btn-primary">Lọc</button>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-header -->


                    <div class="box-body">
                        <table id="jobs" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">Mã công việc</th>
                                    <th>Tên công việc</th>
                                    <th>Nhà tuyển dụng</th>
                                    <th>Cần tuyển</th>
                                    <th>Đã tuyển</th>
                                    <th>Tồn</th>
{{--                                    <th>Giá</th>--}}
{{--                                    <th>Chiết khấu</th>--}}
{{--                                    <th>Lợi nhuận</th>--}}
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
            $('#jobs').DataTable({
                processing: true,
                serverSide: true,
                type: 'GET',
                ajax: '{{route('dt_report_job')}}',
                columns: [
                    { data: 'job_id', name: 'jobs.job_id' },
                    { data: 'title', name: 'jobs.title' },
                    { data: 'enterprise_name', name: 'employer.enterprise_name' },
                    { data: 'number_recruit', name: 'jobs.number_recruit' },
                    { data: 'number_recruited', name: 'jobs.number_recruited' },
                    { data: 'inventory', name: 'inventory' }
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
