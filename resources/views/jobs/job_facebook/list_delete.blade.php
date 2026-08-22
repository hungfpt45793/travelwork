@extends('admin.layout.admin')
@section('title', 'Danh sách công việc từ Facebook đã xóa')
@section('content')
    <!-- Content Header (Page header) -->
    <style>
        .btn{
            min-width: 25%;
        }
    </style>
    <section class="content-header">
        <h1>
            Công việc facebook đã xóa
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc làm</a></li>
            <li><a href="#">Công việc từ Facebook đã xóa</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <form role="search" method="get" action="">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="col-xs-12 col-md-12">
                                            <select class="form-control select2" name="career_category_id"
                                                    aria-label="Danh mục ngành nghề">
                                                <option value="" selected> -- Danh mục ngành nghề --</option>
                                                <?php $career_category_id_get = isset($_GET['career_category_id']) ? $_GET['career_category_id'] : '';
                                                ?>
                                                @foreach(\App\Entity\Career::get() as $career)
                                                    <option value="{{$career->career_category_id}}"
                                                            @if($career->career_category_id == $career_category_id_get) selected
                                                            @endif
                                                    >{{$career->career_category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="col-xs-12 col-md-12">
                                            <?php $salary_get = isset($_GET['salary']) ? $_GET['salary'] : '01';
                                            ?>
                                            <select class="form-control select2" name="salary" aria-label="Mức lương">
                                                <option value="" selected> -- Mức lương --</option>
                                                @foreach(\App\Entity\Salary::orderBy('salary_from')->get() as $salary)
                                                    <option value="{{$salary->salary_id}}"
                                                            @if($salary->salary_id == $salary_get) selected
                                                            @endif>{{$salary->salary_from}} VNĐ
                                                        - {{$salary->salary_to}} VNĐ
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-xs-12 col-md-12">
                                            <?php $vip_get = isset($_GET['vip']) ? $_GET['vip'] : '';
                                            ?>
                                            <select class="form-control select2" name="vip" aria-label="Quận/Huyện"
                                                    id="">
                                                <option value="" selected> -- Loại tin --</option>
                                                <option value="0" @if($vip_get == '0') selected @endif > Tin thường </option>
                                                <option value="1" @if($vip_get == '1') selected @endif > Tin Vip </option>

                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="row" style="margin-top: 15px">

                                    <div class="col-md-4">
                                        <div class="col-xs-12 col-md-12">
                                            <?php $province_get = isset($_GET['province']) ? $_GET['province'] : '';
                                            ?>
                                            <select class="form-control select2" name="province" aria-label="Tỉnh/Thành phố"
                                                    id="province">
                                                <option value="" selected> -- Tất cả các tỉnh/thành phố --</option>
                                                @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                    <option value="{{$province->province_id}}"
                                                            @if($province->province_id == $province_get) selected
                                                            @endif
                                                    >{{$province->province_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-xs-12 col-md-12">
                                            <?php $district_get = isset($_GET['district']) ? $_GET['district'] : '';
                                            ?>
                                            <select class="form-control select2" name="district" aria-label="Quận/Huyện"
                                                    id="district">
                                                <option value="" selected> -- Tất cả các quận/huyện --</option>
                                                @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                    <option value="{{$district->district_id}}"
                                                            @if($district->district_id == $district_get) selected
                                                            @endif
                                                    >{{$district->district_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-xs-12 col-md-12">
                                            <?php $title_get = isset($_GET['title']) ? $_GET['title'] : '';
                                            ?>
                                            <input type="text" style="height: 28px" placeholder="Tên việc làm" class="form-control" name="title" value="{{ $title_get }}">
                                        </div>
                                    </div>

                                </div>

                                <div class="row" style="margin-top: 15px">
                                    <div class="col-md-4">
                                        <div class="col-xs-12 col-md-12">

                                            <select class="form-control select2" name="employer_id" aria-label="Quận/Huyện"
                                                    id="">
                                                <option value="" selected> -- Nhà tuyển dụng --</option>
                                                <?php $employer = \App\Entity\Employer::getselectNameId();
                                                $employer_id_get = isset($_GET['employer_id']) ? $_GET['employer_id'] : '';
                                                print_r($employer_id_get);
                                                ?>
                                                @foreach($employer as $eplo)
                                                    <option value="{{ $eplo->employer_id }}" @if($employer_id_get == $eplo->employer_id ) selected @endif > {{ $eplo->enterprise_name }} </option>
                                                @endforeach


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-xs-12 col-md-12">
                                            <?php $email_get = isset($_GET['email']) ? $_GET['email'] : '';
                                            ?>
                                            <input type="text" style="height: 28px" placeholder="Email nhà tuyển dụng" class="form-control" name="email" value="{{ $email_get }}">
                                        </div>


                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-xs-12 col-md-12">
                                            <?php $email_job_fb_get = isset($_GET['email_job_fb']) ? $_GET['email_job_fb'] : '';
                                            ?>
                                            <input type="text" style="height: 28px" placeholder="Email nhận hồ sơ" class="form-control" name="email_job_fb" value="{{ $email_job_fb_get }}">
                                        </div>
                                    </div>
                                </div>




                                <div class="col-md-12 text-center" style="margin-top: 20px">
                                    <button type="submit" class="btn btn-success">Tìm Kiếm</button>
                                </div>

                                <div style="display: inline-block;margin-bottom: 10px;">
                                    <a href="{{ route('update_job_facebook') }}" style="color:#fff;background: orange;padding: 5px 10px" class="btnOrang">cập nhật mã tin facebook</a>
                                </div>
                                <div>
                                    <a href="{{ route('job-facebook.create') }}" style="color:#fff;background: orange;padding: 5px 10px" class="btnOrang">Thêm mới việc làm facebook</a>
                                </div>



                            </div>
                        </form>
                    </div>

                    <div class="box-body">
                        @if(!empty($jobFacebooks)) <h3>Tổng số công việc ( <span class="red">{{ $total_job }}</span>)
                        </h3> @endif

                        <table id="jobs" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Mã tin</th>
                                <th>Nhà tuyển dụng</th>
                                <th>Email NTD</th>

                                <th>Tên việc</th>

                                <th>Email nhận hồ sơ</th>


                                <th>Mức lương</th>
                                <th>Địa chỉ (quận - thành phố)</th>
                                <th>Thời gian đăng tin</th>
                                <th>Số người xem</th>
                                <th>Loại tin</th>
                                <th>Báo tin sai(3)</th>

                                <th>Thao Tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($jobFacebooks))
                                @foreach($jobFacebooks as $job)
                                    <tr>
                                        <td>{{ $job['job_facebook_id'] }}</td>
                                        <td>{{ $job['job_facebook_code'] }}</td>
                                        <td>
                                            <?php
                                            $empoyer = \App\Entity\Employer::getIdemployer($job['employer_id']);
                                            ?>
                                            {{ $empoyer['enterprise_name'] }}</td>
                                        <td>{{ $job['emailNTD'] }}</td>
                                        <td>{{ $job['title'] }}</td>
                                        <td>{{ $job['email'] }}</td>
                                        <td>
                                            <?php
                                            $salary = \App\Entity\Salary::getIdSalary($job['salary_id']);
                                            ?>
                                            {{ isset($salary->description) ? $salary->description : '' }}
                                        </td>
                                        <td>
                                            <?php
                                            $province = \App\Entity\Province::getId($job['province']);
                                            $district = \App\Entity\District::getId($job['district']);
                                            ?>
                                            {{ $district['district_name'] }}
                                            </br>
                                            {{ $province['province_name'] }}

                                        </td>
                                        <td>
                                            <?php
                                            $date_submit = date_create($job['created_at']);
                                            echo date_format($date_submit, "d/m/Y");
                                            ?>
                                            -
                                            <?php
                                            $date_end = date_create($job['date_end']);
                                            echo date_format($date_end, "d/m/Y");
                                            ?>

                                        </td>

                                        <td>{{ $job['view'] }}</td>
                                        <td>
                                            @if($job['vip'] == 0)
                                                <span>Tin thường</span>
                                            @else
                                                <span style="color: red">Tin vip</span>
                                            @endif
                                        </td>
                                        <td>{{ $job['warning_job_fb'] }}</td>


                                        <td>
                                            <a href="{{ route('Job_facebook_srestore', ['job_facebook_id' => $job['job_facebook_id']]) }}">
                                                <button class="btn btn-primary"><i class="fa fa-share xoayicon mgr5" aria-hidden="true"></i> Khôi phục</button>
                                            </a>
                                            <a  href="{{ route('Job_facebook_ForceDelete', ['job_facebook_id' => $job['job_facebook_id']]) }}" class="">
                                                <button class="btn btn-danger btnDelete"> <i class="fa fa-trash-o mgr5" aria-hidden="true"></i> Xóa vĩnh viễn</button>

                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                            </tbody>

                        </table>
                        <div class="col-12 text-center">
                            {{$jobFacebooks->links()}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
@endsection