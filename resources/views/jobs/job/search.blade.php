@extends('admin.layout.admin')

@section('title', 'Tìm kiếm công việc')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Công việc
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc làm</a></li>
            <li class="active"><a href="#"> Tìm kiếm</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <form role="search" method="GET" action="{{route('searchJob')}}">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Danh mục ngành nghề</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="career" aria-label="Danh mục ngành nghề">
                                            <option value=""> -- Danh mục ngành nghề -- </option>
                                            @foreach(\App\Entity\Career::get() as $career)
                                                <option value="{{$career->career_category_id}}"
                                                {{isset($careerSearch) ? (($career->career_category_id == $careerSearch) ? 'selected' : '') : ''}}
                                                >{{$career->career_category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Trình độ yêu cầu</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="literacy" aria-label="Trình độ yêu cầu">
                                            <option value=""> -- Trình độ yêu cầu -- </option>
                                            @foreach(\App\Entity\Literacy::orderBy('literacy_name')->get() as $literacy)
                                                <option value="{{$literacy->literacy_id}}"
                                                {{isset($literacySearch) ? (($literacy->literacy_id == $literacySearch) ? 'selected' : '') : ''}}
                                                >{{$literacy->literacy_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-2 col-md-2">
                                    <a href="{{route('job.create')}}"><button class="btn btn-info" style="float:right;" type="button">Thêm mới</button></a>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 1%">
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Mức lương</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="salary" aria-label="Mức lương">
                                            <option value=""> -- Mức lương -- </option>
                                            @foreach(\App\Entity\Salary::orderBy('salary_from')->get() as $salary)
                                                <option value="{{$salary->salary_id}}"
                                                {{isset($salarySearch) ? (($salary->salary_id ==  $salarySearch) ? 'selected' : '') : ''}}
                                                >{{$salary->salary_from}} VNĐ - {{$salary->salary_to}} VNĐ</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Nhóm việc làm</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="jobGroup" aria-label="Nhóm việc làm">
                                            <option value=""> -- Nhóm việc làm -- </option>
                                            @foreach(\App\Entity\JobGroup::orderBy('job_group_name')->get() as $jobGroup)
                                                <option value="{{$jobGroup->job_group_id}}"
                                                {{isset($jobGroupSearch) ? (($jobGroup->job_group_id == $jobGroupSearch) ? 'selected' : '') : ''}}
                                                >{{$jobGroup->job_group_name	}}</option>
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
                                        <label>Gói bán hàng</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="sale" aria-label="Gói bán hàng">
                                            <option value=""> -- Gói bán hàng -- </option>
                                            @foreach(\App\Entity\Sale::orderBy('sale_package_name')->get() as $sale)
                                                <option value="{{$sale->sale_package_id}}"
                                                    {{isset($saleSearch) ? (($sale->sale_package_id == $saleSearch) ? 'selected' : '') : '' }}
                                                >{{$sale->sale_package_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Tỉnh/Thành phố</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="province" aria-label="Tỉnh/Thành phố" id="province">
                                            <option value=""> -- Tất cả các tỉnh/thành phố -- </option>
                                            @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                <option value="{{$province->province_id}}"
                                                {{isset($provinceSearch) ? (($province->province_id == $provinceSearch) ? 'selected' : '') : ''}}
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
                                        <label>Ngày đăng</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <div class="row">
                                            <div class="col-xs-6 col-md-6">
                                                <input type="date" class="form-control" name="start_at"
                                                value="{{isset($startSearch) ? $startSearch : ''}}"
                                                >
                                            </div>
                                            <div class="col-xs-6 col-md-6">
                                                <input type="date" class="form-control" name="end_at"
                                                value="{{isset($endSearch) ? $endSearch : ''}}"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Quận/Huyện</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="district" aria-label="Quận/Huyện" id="district">
                                            <option value=""> -- Tất cả các quận/huyện --</option>
                                            @foreach(\App\Entity\District::where('province_id', $provinceSearch)
                                            ->orderBy('district_name')->get() as $district)
                                                <option value="{{$district->district_id}}"
                                                {{isset($districtSearch) ? (($district->district_id == $districtSearch) ? 'selected' : '') : ''}}
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
                                        <label>Tìm kiếm theo từ khóa</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <input type="text" placeholder="Từ Khóa" class="form-control" name="title" value="{{isset($title) ? $title : ''}}">
                                    </div>
                                </div>

                                <div class="col-xs-5 col-md-5">
                                    <button type="submit" class="btn btn-success">Tìm Kiếm</button>
                                </div>

                            </div>
                        </div>
                    </form>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="jobs" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Nhà tuyển dụng</th>
                                <th>Tên việc</th>
                                <th>Cần tuyển</th>
                                <th>Ứng tuyển</th>
                                <th>Đã tuyển</th>
                                <th>Ngày nộp đơn cuối</th>
                                <th>Tồn</th>
                                <th>Gói bán hàng</th>
                                <th>Số người xem</th>
                                <th colspan="2">Thao Tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($jobs as $job)
                                <tr>
                                    <td>{{$job->job_id}}</td>
                                    <td>{{$job->enterprise_name}}</td>
                                    <td>{{$job->title}}</td>
                                    <td class="quantityNumber">{{$job->number_recruit}}</td>
                                    <td class="quantityNumber">{{$job->applicants}}</td>
                                    <td class="quantityNumber">{{$job->number_recruited}}</td>
                                    <td>{{$job->deadline_submit_profile}}</td>
                                    <td class="quantityNumber">{{$job->number_recruit - $job->number_recruited}}</td>
                                    <td>{{$job->sale_package_name}}</td>
                                    <td>{{$job->people_seen}}</td>
                                    <td><a href="{{route('job.edit',['job' => $job->job_id])}}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('job.destroy', ['job' => $job->job_id])}}" class="btn btn-danger btnDelete"
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
                                <th>Nhà tuyển dụng</th>
                                <th>Tên việc</th>
                                <th>Cần tuyển</th>
                                <th>Ứng tuyển</th>
                                <th>Đã tuyển</th>
                                <th>Ngày nộp đơn cuối</th>
                                <th>Tồn</th>
                                <th>Gói bán hàng</th>
                                <th>Số người xem</th>
                                <th>Thao Tác</th>
                            </tr>
                            </tfoot>
                        </table>
                        {{$jobs->links()}}
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
                $.get('/admin/ajax-district/'+ $(this).val(), function (data) {
                    $('#district').html(data);
                });
            });
            numeral($('.quantityNumber').val()).format('0,0');
        })
    </script>
@endpush
