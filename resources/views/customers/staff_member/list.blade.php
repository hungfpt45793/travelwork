@extends('admin.layout.admin')
@section('title', 'Danh sách Cộng tác viên')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cộng tác viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Cộng tác viên</a></li>
            <li class="active"><a href="#">Danh sách</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @if (session('success'))
                    <div class="infoAlert">
                        <div class="alert alert-success">
                            <span>{{ session('success') }}</span>
                            <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                            </button>
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="infoAlert">
                        <div class="alert alert-warning">
                            <span>{{ session('error') }}</span>
                            <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                            </button>
                        </div>
                    </div>
                @endif
                <div class="box">

                    <div style="padding-top: 20px;padding-left: 20px">
                        <a href="{{ route('staff_member.create') }}"
                           style="color:#fff;background: orange;padding: 5px 10px" class="btnOrang">Thêm mới</a>
                    </div>
                    <div class="box-body">

                        <p>Tổng số : {{ $total }}</p>
                        @if(!empty($list_staff))
                            <table id="jobs" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Tên Cộng tác viên</th>
                                    <th>image</th>
                                    <th>Email</th>
                                    <th>SĐT</th>
                                    <th>Thao Tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list_staff as $staff)
                                    <tr>
                                        <td>{{ $staff->staff_member_id }}</td>
                                        <td>{{ $staff->staff_member_name }}</td>
                                        <td><img src="{{ $staff->staff_member_image }}" style="width: 50px"></td>
                                        <td>{{ $staff->staff_member_email }}</td>
                                        <td>{{ $staff->staff_member_phone }}</td>

                                        <td>
                                            <a href="{{ route('staff_member.edit',['staff_member_id' => $staff->staff_member_id]) }}">
                                                <button class="btn btn-primary" type="button"><i class="fa fa-pencil"
                                                                                                 aria-hidden="true"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('staff_member.destroy', ['staff_member_id' => $staff->staff_member_id]) }}"
                                               class="btn btn-danger btnDelete" data-toggle="modal"
                                               data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>

                            </table>
                            <div class="pull-right">{{ $list_staff->links() }}</div>
                        @endif
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
        {{--$(function() {--}}
        {{--$('#jobs').DataTable({--}}
        {{--processing: true,--}}
        {{--serverSide: true,--}}
        {{--type: 'GET',--}}
        {{--ajax: '{{route('dt_employee')}}',--}}
        {{--columns: [--}}
        {{--{ data: 'employee_id', name: 'employee_id' },--}}
        {{--{ data: 'employee_code', name: 'employee_code' },--}}
        {{--{ data: 'employee_name', name: 'employee_name' },--}}
        {{--{ data: 'employee_image', name: 'employee_image',--}}
        {{--render: function (data) {--}}
        {{--return '<img src="'+data+'" width="100" />';--}}
        {{--}--}}
        {{--},--}}
        {{--{ data: 'title', name: 'jobs.title' },--}}
        {{--{ data: 'name', name: 'users.name' },--}}
        {{--{ data: 'phone', name: 'phone' },--}}
        {{--{ data: 'email', name: 'email' },--}}
        {{--{ data: 'status', name: 'status' ,--}}
        {{--render: function (data) {--}}
        {{--if(data == 0){--}}
        {{--return 'Chưa đi làm';--}}
        {{--}--}}
        {{--if(data == 1){--}}
        {{--return  'Đã đi làm';--}}
        {{--}--}}
        {{--if (data == 2){--}}
        {{--return  'Đã nộp CV';--}}
        {{--}--}}
        {{--return 'Đã nghỉ làm';--}}
        {{--}},--}}
        {{--{ data: 'enterprise_name', name: 'employer.enterprise_name' },--}}
        {{--{ data: 'created_at', name: 'created_at' },--}}
        {{--{ data: 'action', name: 'action', searchable: false, orderable: false }--}}
        {{--]--}}
        {{--});--}}
        {{--});--}}

        $(document).ready(function () {
            $('#province').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                })
            })
        })
    </script>
@endpush
