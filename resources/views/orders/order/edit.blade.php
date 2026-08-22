@extends('admin.layout.admin')

@section('title', 'Cập nhật Đơn hàng ')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật Đơn hàng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Bán hàng</a></li>
            <li><a href="#">Đơn hàng</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('order.update',['order_id'=>$order->order_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-6">

                    <div class="box box-primary">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nhà tuyển dụng</label>
                                <select class="form-control select2" id="employer" name="employer_id">
                                    <option value="0">-- Chọn nhà tuyển dụng --</option>
                                    @foreach($employers as $employer)
                                        <option value="{{$employer->employer_id}}"
                                        {{$employer->employer_id == $order->employer_id ? 'selected' : ''}}
                                        >{{$employer->enterprise_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" id="detailEmployer">
                                <label>{{\App\Entity\Employer::where('employer_id', $order->employer_id)->first()->enterprise_name}}</label>
                                <p>Địa chỉ: {{\App\Entity\Employer::join('district','district.district_id','=','employer.district')
                                            ->where('employer_id', $order->employer_id)->first()->district_name . ' - ' .
                                            \App\Entity\Employer::join('province','province.province_id','=','employer.province')
                                            ->where('employer_id', $order->employer_id)->first()->province_name}}</p>
                                <p>Hotline: {{\App\Entity\Employer::where('employer_id', $order->employer_id)->first()->phone}}</p>
                                <p>Người đại diện: {{\App\Entity\EmployerRepresentative::where('employer_id', $order->employer_id)->first()->representative_name}}</p>
                                <p>Doanh nghiệp: {{\App\Entity\Employer::where('employer_id', $order->employer_id)->first()->enterprise_name}}</p>
                            </div>
                        </div>
                    </div>


                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Chi tiết đơn hàng</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Công việc</label>
                                <select class="form-control select2" name="job_id" id="job">
                                    <option value="0"> -- Chọn công việc -- </option>
                                    @foreach(\App\Entity\Job::get() as $job)
                                        <option value="{{$job->job_id}}"
                                        {{$order->job_id == $job->job_id ? 'selected' : ''}}>{{$job->title}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá</label>
                                <input type="text" class="form-control" name="total_price" placeholder="Giá" value="{{$order->total_price}}"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Thanh toán</label>
                                <input type="text" class="form-control" name="paid" placeholder="Thanh toán" value="{{$order->paid}}" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ngày đặt hàng</label>
                                <input type="date" class="form-control" name="date_order" value="{{$order->date_order}}" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái đơn hàng</label>
                                <select class="form-control select2" name="status">
                                    <option value="0" {{$order->status == 0 ? 'selected' : ''}}>Chưa xác định</option>
                                    <option value="1" {{$order->status == 1 ? 'selected' : ''}}>Gửi CV</option>
                                    <option value="2" {{$order->status == 2 ? 'selected' : ''}}>Thất bại</option>
                                    <option value="3" {{$order->status == 3 ? 'selected' : ''}}>Đã phỏng vấn</option>
                                    <option value="4" {{$order->status == 4 ? 'selected' : ''}}>Thành công</option>
                                    <option value="5" {{$order->status == 5 ? 'selected' : ''}}>Đã đi làm</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Đánh giá</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Ứng viên</th>
                                    <th>Ứng viên đánh giá</th>
                                    <th>Ngày đánh giá</th>
                                    <th>Phê duyệt</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </td>
                                    <td><div class="form-group">
                                            <select class="form-control">
                                                <option>Nguyên Văn A</option>
                                                <option>Nguyễn Văn B</option>
                                                <option>Nguyễn Văn C</option>
                                            </select>
                                        </div></td>
                                    <td><div class="form-group">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right" id="datepicker">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                    </td>
                                    <td style="text-align: center;"><div class="form-group">
                                            <label>
                                                <input type="checkbox" name="parents[]" value="" class="flat-red" >
                                            </label>
                                        </div></td>
                                </tr>
                                </tbody>
                            </table>
                            <br>
                            <div class="form-group">
                                <textarea rows="4" class="form-control" name="description"
                                          placeholder="Review của ứng viên"></textarea>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Ứng viên</label>
                                <select class="form-control select2" id="employee" name="employee_id">
                                    <option value="0"> -- Chọn ứng viên -- </option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->employee_id}}"
                                        {{$employee->employee_id == $order->employee_id ? 'selected' : ''}}
                                        >{{$employee->employee_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="detailEmployee">
                                <label>{{\App\Entity\Employee::where('employee_id', $order->employee_id)->first()->employee_name}}</label>
                                <p>Địa chỉ thường trú: {{\App\Entity\Employee::where('employee_id', $order->employee_id)->first()->address}}</p>
                                <p>SĐT: {{\App\Entity\Employee::where('employee_id', $order->employee_id)->first()->phone}}</p>
                                <p>Họ và tên: {{\App\Entity\Employee::where('employee_id', $order->employee_id)->first()->employee_name}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nhân viên phụ trách</label>
                                <select class="form-control select2" id="staff" name="user_id">
                                    <option value="0"> -- Chọn nhân viên phụ trách </option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}"
                                        {{$user->id == $order->user_id ? 'selected' : ''}}
                                        >{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="detailStaff">
                                <label>Họ và tên: {{\App\Entity\User::where('id', $order->user_id)->first()->name}}</label>
                                <p>Địa chỉ: {{\App\Entity\User::where('id', $order->user_id)->first()->address}}</p>
                                <p>Hotline: {{\App\Entity\User::where('id', $order->user_id)->first()->phone}}</p>
                                <p>Họ và tên: {{\App\Entity\User::where('id', $order->user_id)->first()->name}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-body">
                            @foreach(\App\Entity\NoteOrders::where('order_id', $order->order_id)->get() as $note)
                                <div class="form-group">
                                    <p>- {{$note->note}} .</p>
                                </div>
                            @endforeach
                            <div class="form-group" id="noteContent">
                            </div>
                            <div class="form-group">
                                <label>Ghi chú</label>
                                <textarea rows="4" class="form-control" name="note"
                                          id="note-order" placeholder="Ghi chú"></textarea>

                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="note">Ghi</button>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Lịch sử cuộc gọi</h3>
                        </div>
                        <!-- Đoạn này làm bằng ajax để lưu thông tin ghi chú -->
                        <div class="box-body">
                            <div class="form-group">
                                <p>
                                    <button class="btn btn-success">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                    cuộc gọi thứ 2- 16h00 03/01/2019
                                </p>
                            </div>
                            <div class="form-group">
                                <p>
                                    <button class="btn btn-success">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                    cuộc gọi thứ 1- 14h00 28/02/2019
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Đánh giá</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Nhà tuyển dụng đánh giá</th>
                                    <th>Ngày đánh giá</th>
                                    <th>Trạng thái của ứng viên</th>
                                    <th>Phê duyệt</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                        </div>
                                    </td>
                                    <td><div class="form-group">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right" id="datepicker1">
                                            </div>
                                        </div></td>
                                    <td><div class="form-group">
                                            <select class="form-control">
                                                <option>Đã nộp CV</option>
                                                <option>Đã phỏng vấn</option>
                                                <option>Đã đi làm</option>
                                                <option>Đã nghỉ</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td style="text-align: center;"><div class="form-group">
                                            <label>
                                                <input type="checkbox" name="parents[]" value="" class="flat-red" >
                                            </label>
                                        </div></td>
                                </tr>
                                </tbody>
                            </table>
                            <br>
                            <div class="form-group">
                                <textarea rows="4" class="form-control" name="description"
                                          placeholder="Review của nhà tuyển dụng"></textarea>

                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning">Cập nhật</button>
                    </div>
                    <!-- /.box -->

                </div>

            </form>
        </div>
    </section>
    <script type="text/javascript">
        $('#datepicker').datepicker({
            autoclose: true
        });
        $('#datepicker1').datepicker({
            autoclose: true
        })
    </script>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#employer').change(function () {
                $.get('/admin/ajax-employer/' + $(this).val(), function (result) {
                    $('#detailEmployer').html(result);
                });

                $.get('/admin/ajax-job/' + $(this).val(), function (data) {
                    $('#job').html(data);
                })
            });
            $('#employee').change(function () {
                $.get('/admin/ajax-employee/' + $(this).val(), function (result) {
                    $('#detailEmployee').html(result);
                })
            });
            $('#staff').change(function () {
                $.get('/admin/ajax-staff/' + $(this).val(), function (result) {
                    $('#detailStaff').html(result);
                })
            });
        })
    </script>
@endpush