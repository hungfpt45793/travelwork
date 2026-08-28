@extends('admin.layout.admin')

@section('title', 'Danh sách công việc')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Công việc
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc làm</a></li>
            <li class="active"><a href="#">Tất cả</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
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
                                        <?php $literacy_get = isset($_GET['literacy']) ? $_GET['literacy'] : '';
                                        ?>
                                        <select class="form-control select2" name="literacy"
                                                aria-label="Trình độ yêu cầu">
                                            <option value="" selected> -- Trình độ yêu cầu --</option>
                                            @foreach(\App\Entity\Literacy::orderBy('literacy_name')->get() as $literacy)
                                                <option value="{{$literacy->literacy_id}}"
                                                        @if($literacy->literacy_id == $literacy_get) selected
                                                        @endif>{{$literacy->literacy_name}}</option>
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
                            </div>
                            <div class="row" style="margin-top: 15px">
                                <div class="col-md-4">
                                    <div class="col-xs-12 col-md-12">
                                        <?php $jobGroup_get = isset($_GET['jobGroup']) ? $_GET['jobGroup'] : '';
                                        ?>
                                        <select class="form-control select2" name="jobGroup" aria-label="Nhóm việc làm">
                                            <option value="" selected> -- Nhóm việc làm --</option>
                                            @foreach(\App\Entity\JobGroup::orderBy('job_group_name')->get() as $jobGroup)
                                                <option value="{{$jobGroup->job_group_id}}"
                                                        @if($jobGroup->job_group_id == $jobGroup_get) selected
                                                        @endif >{{$jobGroup->job_group_name	}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-xs-12 col-md-12">
                                        <?php $sale_get = isset($_GET['sale']) ? $_GET['sale'] : '';
                                        ?>
                                        <select class="form-control select2" name="sale" aria-label="Gói bán hàng">
                                            <option value="" selected> -- Gói bán hàng --</option>
                                            @foreach(\App\Entity\Sale::orderBy('sale_package_name')->get() as $sale)
                                                <option value="{{$sale->sale_package_id}}"
                                                        @if($sale->sale_package_id == $sale_get) selected
                                                        @endif
                                                >{{$sale->sale_package_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
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

                            </div>
                            <div class="row" style="margin-top: 15px">
                                <div class="col-md-4">
                                    <div class="col-xs-12 col-md-12">
                                        <?php $title_get = isset($_GET['title']) ? $_GET['title'] : '';
                                        ?>
                                        <input type="text" style="height: 28px" placeholder="Tên việc làm" class="form-control" name="title" value="{{ $title_get }}">
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
                                        <?php $job_code_get = isset($_GET['job_code']) ? $_GET['job_code'] : '';
                                        ?>
                                        <input type="text" style="height: 28px" placeholder="Mã tin" class="form-control" name="job_code" value="{{ $job_code_get }}">
                                    </div>
                                </div>
                            </div>




                            <div class="col-md-12 text-center" style="margin-top: 20px">
                                <button type="submit" class="btn btn-success">Tìm Kiếm</button>
                            </div>


                        </div>
                    </form>

                    <div>
                        <a href="{{ route('job.create') }}" style="color:#fff;background: orange;padding: 5px 10px" class="btnOrang">Thêm mới việc làm NTD</a>
                    </div>






                    <div class="box-body">
                        @if(!empty($jobs)) <h3>Tổng số công việc ( <span class="red">{{ $total_job }}</span>)
                        </h3> @endif

                        <table id="jobs" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">Mã tin</th>
                                <th>Nhà tuyển dụng</th>
                                <th>Email NTD</th>
                                <th>Tên việc</th>
                                <th>Ngày nộp đơn cuối</th>
                                <th>Số người xem</th>
                                <th>Loại tin</th>
                                <th>Link tin</th>
                                <th>Thao Tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($jobs))
                                @foreach($jobs as $job)
                                    <tr>
                                        <td>{{ $job['job_code'] }}</td>
                                        <td>
                                            <?php
                                            $empoyer = \App\Entity\Employer::getIdemployer($job['employer_id']);
                                            ?>
                                            {{ $empoyer['enterprise_name'] }}</td>
                                        <td>{{ $job['email'] }}</td>
                                        <td>{{ $job['title'] }}</td>

                                        <td>
                                            <?php
                                            $date = date_create($job['deadline_submit_profile']);
                                            echo date_format($date, "d/m/Y");
                                            ?>
                                        </td>
                                        <td>{{ $job['views'] }}</td>
                                        <td>
                                            @if($job['vip'] == 0)
                                                <span>Tin thường</span>
                                            @else
                                                <span style="color: red">Tin vip</span>
                                            @endif
                                        </td>
                                        <td><a href="{{ route('job_detail',['slug'=> $job['slug']]) }}" target="_blank">Link </a></td>
                                        <td>
                                            <a href="{{ route('job.edit',['job' => $job->job_id]) }}">
                                                <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                                   aria-hidden="true"></i></button>
                                            </a>
                                            <a href="{{ route('job.destroy',['job' => $job->job_id]) }}"
                                               class="btn btn-danger btnDelete" data-toggle="modal"
                                               data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                            </tbody>

                        </table>
                        <div class="col-12 text-center">
                            {{$jobs->links()}}
                        </div>

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
        $(function () {
            {{--$('#jobs').DataTable({--}}
            {{--processing: true,--}}
            {{--serverSide: true,--}}
            {{--type: 'GET',--}}
            {{--ajax: '{!! route("dt_job") !!}',--}}
            {{--columns: [--}}
            {{--{ data: 'job_id', name: 'jobs.job_id' },--}}
            {{--{ data: 'enterprise_name', name: 'employer.enterprise_name' },--}}
            {{--{ data: 'title', name: 'title' },--}}
            {{--{ data: 'number_recruit', name: 'number_recruit' ,--}}
            {{--render: function (data) {--}}
            {{--return numeral(data).format('0,0');--}}
            {{--}--}}
            {{--},--}}
            {{--{ data: 'applicants', name: 'applicants' ,--}}
            {{--render: function (data) {--}}
            {{--return numeral(data).format('0,0');--}}
            {{--}--}}
            {{--},--}}
            {{--{ data: 'number_recruited', name: 'number_recruited' ,--}}
            {{--render: function (data) {--}}
            {{--return numeral(data).format('0,0');--}}
            {{--}--}}
            {{--},--}}
            {{--{ data: 'date_submit', name: 'date_submit' },--}}
            {{--{ data: 'inventory', name: 'inventory' ,--}}
            {{--render: function (data) {--}}
            {{--return numeral(data).format('0,0');--}}
            {{--}--}}
            {{--},--}}
            {{--{ data: 'sale_package_name', name: 'sale_package.sale_package_name'},--}}
            {{--{ data: 'people_seen', name: 'people_seen' ,--}}
            {{--render: function (data) {--}}
            {{--return numeral(data).format('0,0');--}}
            {{--}--}}
            {{--},--}}
            {{--{ data: 'action', name: 'action', orderable: false, searchable: false },--}}
            {{--]--}}
            {{--});--}}
        });

        $(document).ready(function () {
            $('#province').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                });
            });
        })
    </script>
@endpush
