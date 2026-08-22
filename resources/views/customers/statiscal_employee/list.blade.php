@extends('admin.layout.admin')
@section('title', 'Danh sách thống kê ứng viên')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ứng viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Ứng viên</a></li>
            <li class="active"><a href="#">Danh sách</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div style="margin-bottom: 15px;">
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
                </div>
                <div class="box">
                    <form role="search" method="GET" action="">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <?php $money_get = isset($_GET["money"]) ? $_GET["money"] : "";
                                    ?>
                                    <select class="form-control select2" name="money">
                                        <option value="">-- Số tiền ứng trước --</option>
                                        <option value="asc" @if($money_get == "asc")  selected @endif>-- Từ thấp đến cao --</option>
                                        <option value="desc" @if($money_get == "desc")  selected @endif>-- Từ cao đến thấp --</option>
                                    </select>

                                </div>
                                <div class="col-md-4">
                                    <?php $total_teacher_get = isset($_GET["total_teacher"]) ? $_GET["total_teacher"] : ""?>
                                    <select class="form-control select2" name="total_teacher">
                                        <option value="">-- Tổng số giáo viên --</option>
                                        <option value="asc" @if($total_teacher_get == "asc") selected @endif>-- Từ thấp đến cao --</option>
                                        <option value="desc" @if($total_teacher_get == "desc") selected @endif>-- Từ cao đến thấp --</option>
                                    </select>

                                </div>
                                <div class="col-md-4">
                                    <?php $total_exam_get = isset($_GET["total_exam"]) ? $_GET["total_exam"] : ""?>
                                    <select class="form-control select2" name="total_exam">
                                        <option value="">-- Số lần thi trắc nghiệm --</option>
                                        <option value="asc" @if($total_exam_get == "asc")  selected @endif>-- Từ thấp đến cao --</option>
                                        <option value="desc" @if($total_exam_get == 'desc')  selected @endif>-- Từ cao đến thấp --</option>
                                    </select>

                                </div>
                            </div>


                            <div class="row" style="margin-top: 1%">
                                <div class="col-md-4">

                                    <?php
                                    $total_dowload_voucher_get = "";
                                    if(isset($_GET["total__dowload_voucher"]))
                                    {
                                        $total_dowload_voucher_get = $_GET["total__dowload_voucher"];
                                    }
                                    ?>
                                    <select class="form-control select2" name="total__dowload_voucher">
                                        <option value="">-- Số lần tải tài liệu --</option>
                                        <option value="asc" @if($total_dowload_voucher_get == "asc") selected @endif>-- Từ thấp đến cao --</option>
                                        <option value="desc" @if($total_dowload_voucher_get == "desc") selected @endif>-- Từ cao đến thấp --</option>
                                    </select>

                                </div>
                                <div class="col-md-4">
                                    <?php $total_view_voucher_get = isset($_GET["total_view_voucher"]) ? $_GET["total_view_voucher"] : ""?>
                                    <select class="form-control select2" name="total_view_voucher">
                                        <option value="">-- Số lần xem tài liệu --</option>
                                        <option value="asc" @if($total_view_voucher_get == "asc") selected @endif>-- Từ thấp đến cao --</option>
                                        <option value="desc" @if($total_view_voucher_get == "desc") selected @endif>-- Từ cao đến thấp --</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <?php $total_view_job_get = isset($_GET["total_view_job"]) ? $_GET["total_view_job"] : ""?>
                                    <select class="form-control select2" name="total_view_job">
                                        <option value="">-- Số lần xem tin tuyển dụng --</option>
                                        <option value="asc" @if($total_view_job_get == "asc") selected @endif>-- Từ thấp đến cao --</option>
                                        <option value="desc" @if($total_view_job_get == "desc") selected @endif>-- Từ cao đến thấp --</option>
                                    </select>
                                </div>


                            </div>
                            <div class="row" style="margin-top: 1%">
                                <div class="col-md-4">
                                    <?php $total_cv_get = isset($_GET["total_cv"]) ? $_GET["total_cv"] : ""?>
                                    <select class="form-control select2" name="total_cv">
                                        <option value="">-- Số lần cập nhật CV --</option>
                                        <option value="asc" @if($total_cv_get == "asc") selected @endif>-- Từ thấp đến cao --</option>
                                        <option value="desc" @if($total_cv_get == "desc") selected @endif>-- Từ cao đến thấp --</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <?php $email_get = isset($_GET["email"]) ? $_GET["email"] : ""?>
                                    <input style="height: 28px;" type="text" placeholder="Email ứng viên"
                                           class="form-control" name="email" value="{{ $email_get }}">
                                </div>
                                <div class="col-md-4">
                                    <?php $phone_get = isset($_GET["phone"]) ? $_GET["phone"] : ""?>
                                    <input style="height: 28px;" type="text" placeholder="Số điện thoại ứng viên"
                                           class="form-control" name="phone" value="{{ $phone_get }}">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 1%">
                                <div class="col-md-12">
                                    <?php $name_get = isset($_GET["name"]) ? $_GET["name"] : ""?>
                                    <input style="height: 28px;" type="text" placeholder="Tên ứng viên"
                                           class="form-control" name="name" value="{{$name_get}}">
                                </div>
                            </div>

                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                <button class="btn btn-success" type="submit">Tìm Kiếm</button>
                            </div>


                            <div>
                                <a href="{{ route('statiscal.create') }}"
                                   style="color:#fff;background: orange;padding: 5px 10px" class="btnOrang">Thêm mới
                                    thống kê ứng
                                    viên</a>
                            </div>


                        </div>
                    </form>

                    <div class="box-body">
                        <p>Tổng số : {{ $total }}</p>
                        @if(!empty($statiscal))
                            <table id="jobs" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Tên ứng viên</th>
                                    <th>SĐT</th>
                                    <th>Email</th>
                                    <th>Số tiền ứng trước</th>
                                    <th>Số giáo viên đã học</th>
                                    <th>Số lần thi trắc nghiệm</th>
                                    <th>Số lượt tải tài liệu</th>
                                    <th>Số lượt xem tài liệu</th>
                                    <th>Số lượt xem tin tuyển dụng</th>
                                    <th>Số lần hoàn thành CV</th>
                                    <th>Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($statiscal as $statis)
                                    <tr>
                                        <td>{{ isset($statis['id_statistical']) ? $statis['id_statistical'] : '' }}</td>
                                        <?php $employee = \App\Entity\Employee::getIdEmployee($statis['employees_id']);?>
                                        <td>{{ isset($employee['employee_name']) ? $employee['employee_name'] : '' }}</td>
                                        <td>{{ isset($employee['phone']) ? $employee['phone'] : '' }}</td>
                                        <td>{{ isset($employee['email']) ? $employee['email'] : '' }}</td>
                                        <td>{{ isset($statis['money']) ? number_format($statis['money']) : '' }}</td>
                                        <td>{{ isset($statis['total_teacher']) ? $statis['total_teacher'] : '' }}</td>
                                        <td>{{ isset($statis['total_exam']) ? $statis['total_exam'] : '' }}</td>
                                        <td>{{ isset($statis['total__dowload_voucher']) ? $statis['total__dowload_voucher'] : '' }}</td>
                                        <td>{{ isset($statis['total_view_voucher']) ? $statis['total_view_voucher'] : '' }}</td>
                                        <td>{{ isset($statis['total_view_job']) ? $statis['total_view_job'] : '' }}</td>
                                        <td>{{ isset($statis['total_cv']) ? $statis['total_cv'] : '' }}</td>

                                        <td>
                                            <a href="{{ route('statiscal.edit',['id_statistical' => $statis->id_statistical]) }}">
                                                <button class="btn btn-primary" type="button"><i class="fa fa-pencil"
                                                                                                 aria-hidden="true"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('statiscal.destroy', ['id_statistical' => $statis->id_statistical]) }}"
                                               class="btn btn-danger btnDelete" data-toggle="modal"
                                               data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>

                            </table>
                            <div class="pull-right">{{ $statiscal->links() }}</div>
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
