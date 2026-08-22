@extends('admin.layout.admin')

@section('title', 'Danh sách công việc cần phê duyệt')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Công việc cần phê duyệt
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc làm</a></li>
            <li><a href="#">Việc làm cần phê duyệt</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="jobs" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Nhà tuyển dụng</th>
                                <th>Tên việc</th>
                                <th>Cần tuyển</th>
                                <th>Đã tuyển</th>
                                <th>Ngày đăng</th>
                                <th>Ngày nộp đơn cuối</th>
                                <th>Tồn</th>
                                <th>Gói bán hàng</th>
                                <th>Số người xem</th>
                                <th>Thao Tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Tiva.vn</td>
                                <td>Việc làm công nghệ thông tin</td>
                                <td>30</td>
                                <td>15</td>
                                <td>26/2/2019</td>
                                <td>28/2/2019</td>
                                <td>15</td>
                                <td><a href="{{ route('sale.create') }}">Gói bán hàng doanh nghiệp</a></td>
                                <td>40</td>
                                <td>
                                    <a href="{{ route('job.create') }}">
                                        <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                    </a>
                                    <a  href="" class="btn btn-danger btnDelete"
                                        data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Nhà tuyển dụng</th>
                                <th>Tên việc</th>
                                <th>Cần tuyển</th>
                                <th>Đã tuyển</th>
                                <th>Ngày đăng</th>
                                <th>Ngày nộp đơn cuối</th>
                                <th>Tồn</th>
                                <th>Gói bán hàng</th>
                                <th>Số người xem</th>
                                <th>Thao Tác</th>
                            </tr>
                            </tfoot>
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
                ajax: '{{route('dt_jobApproval')}}',
                columns: [
                    { data: 'job_id', name: 'job_id' },
                    { data: 'enterprise_name', name: 'enterprise_name' },
                    { data: 'title', name: 'title' },
                    { data: 'number_recruit', name: 'number_recruit' },
                    { data: 'number_recruited', name: 'number_recruited' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'deadline_submit_profile', name: 'deadline_submit_profile' },
                    { data: 'inventory', name: 'inventory' },
                    { data: 'sale_package_name', name: 'sale_package_name'
                    },
                    { data: 'people_seen', name: 'people_seen' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endpush
