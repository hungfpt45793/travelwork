@extends('admin.layout.admin')
@section('title', 'Danh sách ứng viên bị xóa')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ứng viên bị đề nghị xóa
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Ứng viên</a></li>
            <li class="active"><a href="#">Danh sách bị xóa</a></li>
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
                    <form role="search" method="GET" action="">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $career_category_id_get = '';
                                        if (isset($_GET['career_category_id'])) {
                                            $career_category_id_get = $_GET['career_category_id'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="career_category_id">
                                            <option value="">-- Chọn công việc --</option>
                                            <?php
                                            $career = \App\Entity\Career::getAllCareer();
                                            ?>
                                            @foreach($career as $car)
                                                <option value="{{$car->career_category_id}}"
                                                        @if($car->career_category_id == $career_category_id_get) selected @endif
                                                >{{$car->career_category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $province_get = '';
                                        if (isset($_GET['province'])) {
                                            $province_get = $_GET['province'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="province" id="province">
                                            <option value="">-- Tỉnh/Thành phố --</option>
                                            @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                <option value="{{$province->province_id}}"
                                                        @if($province->province_id == $province_get) selected @endif
                                                >{{$province->province_name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $district_get = '';
                                        if (isset($_GET['district'])) {
                                            $district_get = $_GET['district'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="district" id="district">
                                            <option value="">-- Quận/Huyện --</option>
                                            @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                <option value="{{$district->district_id}}"
                                                        @if($district->district_id == $district_get) selected @endif
                                                >{{$district->district_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row" style="margin-top: 1%">
                                <div class="col-md-4">

                                    <div class="col-md-12">
                                        <?php
                                        $salary_id_get = '';
                                        if (isset($_GET['salary_id'])) {
                                            $salary_id_get = $_GET['salary_id'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="salary_id">
                                            <option value="">-- Chọn mức lương --</option>
                                            @foreach(\App\Entity\Salary::get() as $salary)
                                                <option value="{{$salary->salary_id}}"
                                                        @if($salary->salary_id == $salary_id_get) selected @endif
                                                >{{$salary->salary_from}} VNĐ
                                                    - {{$salary->salary_to}} VNĐ
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <?php
                                    $employee_name_get ='';
                                    if (isset($_GET['employee_name'])) {
                                        $employee_name_get = $_GET['employee_name'];
                                    }
                                    ?>
                                    <div class="col-md-12">
                                        <input style="height: 28px" type="text"
                                               placeholder="Tìm kiếm theo từ khóa (Tên ứng viên)" class="form-control"
                                               name="employee_name"
                                               value="@if(!empty($employee_name_get)){{$employee_name_get}}@endif">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <?php
                                    $email_get ='';
                                    if (isset($_GET['email'])) {
                                        $email_get = $_GET['email'];
                                    }
                                    ?>
                                    <div class="col-md-12">
                                        <input style="height: 28px" type="text"
                                               placeholder="Email ứng viên" class="form-control"
                                               name="email"
                                               value="@if(!empty($email_get)){{$email_get}}@endif">
                                    </div>
                                </div>


                            </div>

                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                <button class="btn btn-success" type="submit">Tìm Kiếm</button>
                            </div>


                            <div>
                                <a href="{{ route('employee.create') }}"
                                   style="color:#fff;background: orange;padding: 5px 10px" class="btnOrang">Thêm mới ứng
                                    viên</a>
                            </div>


                        </div>
                    </form>

                    <div class="box-body">
                        <p>Tổng số : {{ $total }}</p>
                        @if(!empty($employees))
                            <table id="jobs" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Tên ứng viên</th>
                                    <th>Avatar</th>
                                    <th>Email</th>
                                    <th>Công việc mong muốn</th>
                                    <th>Mức lương mong muốn</th>
                                    <th>Tỉnh / thành phố</th>
                                    <th>Quận / huyện</th>
                                    <th>Thao Tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->employee_id }}</td>
                                        <td>{{ $employee->employee_name }}</td>
                                        <td><img src="{{ $employee->employee_image }}" style="width: 50px"></td>
                                        <td>{{ $employee->email }}</td>
                                        <td>
                                            @if(!empty($employee->career_category_id))
                                            <?php $career = \App\Entity\Career::getIdCareer($employee->career_category_id);?>
                                            {{ !empty($career['career_category_name']) ? $career['career_category_name'] : '' }}
                                                @endif
                                        </td>
                                        <td>
                                            @if(!empty($employee->salary_id))
                                            <?php
                                            $salary = \App\Entity\Salary::getIdSalary($employee->salary_id);
                                            ?>
                                            {{ $salary['description'] }}
                                                @endif

                                        </td>
                                        <td>
                                            @if(!empty($employee->province))
                                            <?php
                                            $province = \App\Entity\Province::getId($employee->province);
                                            ?>
                                            {{ $province['province_name'] }}
                                                @endif
                                        </td>
                                        <td>
                                            @if(!empty($employee->district))
                                            <?php
                                            $district = \App\Entity\District::getId($employee->district);
                                            ?>
                                            {{ $district['district_name'] }}
                                                @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('Employeerestore', ['id' => $employee->user_id]) }}">
                                                <button class="btn btn-primary"><i class="fa fa-share xoayicon mgr5" aria-hidden="true"></i> Khôi phục</button>
                                            </a>
                                            <a  href="{{ route('EmployeeForceDelete', ['id' => $employee->user_id]) }}" class="">
                                                <button class="btn btn-danger btnDelete"> <i class="fa fa-trash-o mgr5" aria-hidden="true"></i> Xóa vĩnh viễn</button>

                                            </a>
                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>

                            </table>
                            <div class="pull-right">{{ $employees->links() }}</div>
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
