@extends('admin.layout.admin')

@section('title', 'Tìm kiếm ứng viên')

@section('content')
    <section class="content-header">
        <h1>
            Ứng viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Ứng viên</a></li>
            <li class="active"><a href="#">Tìm kiếm</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <form role="search" method="GET" action="{{route('searchEmployee')}}">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Công việc mong muốn</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="job">
                                            <option value="">-- Chọn công việc --</option>
                                            @foreach(\App\Entity\Job::orderBy('title')->get() as $job)
                                                <option value="{{$job->job_id}}"
                                                {{$job->job_id == $jobSearch ? 'selected' : ''}}
                                                >{{$job->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Trình độ học vấn</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="literacy">
                                            <option value="">-- Chọn trình độ học vấn --</option>
                                            @foreach(\App\Entity\Literacy::orderBy('literacy_name')->get() as $literacy)
                                                <option value="{{$literacy->literacy_id}}"
                                                {{$literacy->literacy_id == $literacySearch ? 'selected' : ''}}
                                                >{{$literacy->literacy_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-2 col-md-2">
                                    <a href="{{route('employee.create')}}"><button class="btn btn-info" style="float:right;" type="button">Thêm mới</button></a>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 1%">
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Mức lương</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="salary">
                                            <option value="">-- Chọn mức lương --</option>
                                            @foreach(\App\Entity\Salary::get() as $salary)
                                                <option value="{{$salary->salary_id}}"
                                                {{$salary->salary_id == $salarySearch ? 'selected' : ''}}
                                                >{{$salary->salary_from}} VNĐ - {{$salary->salary_to}} VNĐ</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Tỉnh/Thành phố</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="province" id="province">
                                            <option value="">-- Tỉnh/Thành phố --</option>
                                            @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                <option value="{{$province->province_id}}"
                                                {{$province->province_id == $provinceSearch ? 'selected' : ''}}
                                                >{{$province->province_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-2 col-md-2">

                                </div>
                            </div>

                            <div class="row" style="margin-top: 1%">
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Kinh nghiệm</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <input type="text" placeholder="Kinh nghiệm" class="form-control" name="experience" value="{{$experienceSearch}}">
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Quận/Huyện</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="district" id="district">
                                            <option value="">-- Quận/Huyện --</option>
                                            @foreach(\App\Entity\District::where('province_id', $provinceSearch)->orderBy('district_name')->get() as $district)
                                                <option value="{{$district->district_id}}"
                                                {{$district->district_id == $districtSearch ? 'selected' : ''}}
                                                >{{$district->district_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-2 col-md-2">

                                </div>
                            </div>

                            <div class="row" style="margin-top: 1%">
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Trạng thái ứng viên</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="status">
                                            <option value="-1">-- Trạng thái ứng viên --</option>
                                            <option value="0" {{$statusSearch == 0 ? 'selected' : ''}}>Chưa đi làm</option>
                                            <option value="1" {{$statusSearch == 1 ? 'selected' : ''}}>Đã đi làm</option>
                                            <option value="2" {{$statusSearch == 2 ? 'selected' : ''}}>Đã nộp cv</option>
                                            <option value="3" {{$statusSearch == 3 ? 'selected' : ''}}>Đã nghỉ làm</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Kỹ năng mềm</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <input type="text" placeholder="Kỹ năng mềm" class="form-control" name="skill" value="{{$skillSearch}}">
                                    </div>
                                </div>
                                <div class="col-xs-2 col-md-2">

                                </div>
                            </div>

                            <div class="row" style="margin-top: 1%">
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Tìm kiếm theo từ khóa (Tên ứng viên)</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <input type="text" placeholder="Tên ứng viên" class="form-control" name="keyword" value="{{$keyword}}">
                                    </div>
                                </div>

                                <div class="col-xs-5 col-md-5">
                                    <button class="btn btn-success" type="submit">Tìm Kiếm</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="box-body">
                        <table id="jobs" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Mã ứng viên</th>
                                <th>Tên ứng viên</th>
                                <th>Avatar</th>
                                <th>Việc làm</th>
                                <th>Người phụ trách</th>
                                <th>Điện thoại</th>
                                <th>Email</th>
                                <th>Trạng thái đi làm</th>
                                <th>Công ty</th>
                                <th>Ngày ứng tuyển</th>
                                <th colspan="2">Thao Tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td width="5%">{{$employee->employee_id}}</td>
                                    <td>{{$employee->employee_code}}</td>
                                    <td>{{$employee->employee_name}}</td>
                                    <td><img src="{{$employee->employee_image}}" width="100" alt="avatar"></td>
                                    <td>{{$employee->title}}</td>
                                    <td>{{$employee->name}}</td>
                                    <td>{{$employee->employee_phone}}</td>
                                    <td>{{$employee->employee_email}}</td>
                                    <td>
                                        @if($employee->status ==0)
                                            Chưa đi làm
                                        @elseif($employee->status == 1)
                                            Đã đi làm
                                        @elseif($employee->status == 2)
                                            Đã nộp CV
                                        @else
                                            Đã nghỉ làm
                                        @endif
                                    </td>
                                    <td>{{$employee->enterprise_name}}</td>
                                    <td>{{$employee->created_at}}</td>
                                    <td>
                                        <a href="{{route('employee.edit',['employee_id' => $employee->employee_id])}}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('employee.destroy', ['employee_id' => $employee->employee_id])}}" class="btn btn-danger btnDelete"
                                           data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Mã ứng viên</th>
                                <th>Tên ứng viên</th>
                                <th>Avatar</th>
                                <th>Việc làm</th>
                                <th>Người phụ trách</th>
                                <th>Điện thoại</th>
                                <th>Email</th>
                                <th>Trạng thái đi làm</th>
                                <th>Công ty</th>
                                <th>Ngày ứng tuyển</th>
                                <th colspan="2">Thao Tác</th>
                            </tr>
                            </tfoot>
                        </table>
                        {{$employees->links()}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#province').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                })
            })
        })
    </script>
@endpush