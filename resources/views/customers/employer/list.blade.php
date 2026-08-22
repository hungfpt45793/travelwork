@extends('admin.layout.admin')

@section('title', 'Danh sách nhà tuyển dụng')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Nhà tuyển dụng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Nhà tuyển dụng</a></li>
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
                            <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="infoAlert">
                        <div class="alert alert-warning">
                            <span>{{ session('error') }}</span>
                            <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                        </div>
                    </div>
                @endif


                <div class="box">
                    <form role="search" action="" method="GET" id="submitForm">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $type_of_business_id_get = '';
                                        if(isset($_GET['type_of_business_id']))
                                        {
                                            $type_of_business_id_get = $_GET['type_of_business_id'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="type_of_business_id">
                                            <option value="">-- Loại hình doanh nghiệp --</option>
                                            @foreach(\App\Entity\TypeOfBusiness::orderBy('type_of_business_name')->get() as $type)
                                                <option value="{{$type->type_of_business_id}}"
                                                  @if($type->type_of_business_id == $type_of_business_id_get) selected @endif
                                                >{{$type->type_of_business_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $business_get = '';
                                        if(isset($_GET['business']))
                                        {
                                            $business_get = $_GET['business'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="business">
                                            <option value="">-- Loại hình kinh doanh --</option>
                                            @foreach(\App\Entity\Business::get() as $business)
                                                <option value="{{$business->business_type_id}}"
                                                        @if($business->business_type_id == $business_get) selected @endif
                                                >{{$business->business_type_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $enterprise_name_get = '';
                                        if(isset($_GET['enterprise_name']))
                                        {
                                            $enterprise_name_get = $_GET['enterprise_name'];
                                        }
                                        ?>
                                        <input style="height: 28px;" type="text" placeholder="Tên nhà tuyển dụng" class="form-control" name="enterprise_name" value="@if(!empty($enterprise_name_get)) {{$enterprise_name_get}} @endif">
                                    </div>
                                </div>

                            </div>

                            <div class="row" style="margin-top: 1%">
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $province_get = '';
                                        if(isset($_GET['province']))
                                        {
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
                                        if(isset($_GET['district']))
                                        {
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
                                <div class="col-md-4">

                                    <div class="col-md-12">
                                        <?php
                                        $email_get = '';
                                        if(isset($_GET['email']))
                                        {
                                            $email_get = $_GET['email'];
                                        }
                                        ?>
                                        <input style="height: 28px;" type="text" placeholder="Email nhà tuyển dụng" class="form-control" name="email" value="@if(!empty($email_get)) {{$email_get}} @endif">
                                    </div>
                                </div>


                            </div>

                            <div class="row" style="margin-top: 1%">

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $status_intership_get = '';
                                        if(isset($_GET['status_intership']))
                                        {
                                            $status_intership_get = $_GET['status_intership'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="status_intership">
                                            <option value="" selected>-- Cổng thực tập --</option>

                                            <option value="0"
                                                    @if($status_intership_get == '0') selected @endif
                                            > Không tuyển thực tập</option>
                                            <option value="1"
                                                    @if($status_intership_get == '1') selected @endif
                                            >  Đang tuyển thực tập</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $status_agency_get = '';
                                        if(isset($_GET['status_agency']))
                                        {
                                            $status_agency_get = $_GET['status_agency'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="status_agency">
                                            <option value="" selected>-- Đại lý --</option>

                                            <option value="0"
                                                    @if($status_agency_get == '0') selected @endif
                                            > Không phải đại lý</option>
                                            <option value="1"
                                                    @if($status_agency_get == '1') selected @endif
                                            > Là đại lý</option>

                                        </select>
                                    </div>
                                </div>


                            </div>



                            <div class="col-md-12 text-center" style="margin-top: 20px">
                                <button type="submit" class="btn btn-success">Tìm Kiếm</button>
                            </div>

                            <a class="btn btn-success" id="exportExcel" href="{{ route('exportToExcel') }}?type_of_business_id={{$type_of_business_id_get}}&business={{$business_get}}&enterprise_name={{ $enterprise_name_get }}&province={{$province_get}}&district={{$district_get}}&email={{$email_get}}&status_intership={{$status_intership_get}}&status_agency={{$status_agency_get}}" style="margin-bottom: 20px;">Xuất File excel : {{ $total }} dòng </a>

                            <div>
                                <a href="{{ route('employer.create') }}" style="color:#fff;background: orange;padding: 5px 10px" class="btnOrang">Thêm mới nhà tuyển dụng</a>
                            </div>
                        </div>
                    </form>

                    <div class="box-body">
                        <p>Tổng số : {{ $total }}</p>

                        {{--<form role="search" action="" method="GET">--}}
                        {{--<div style="margin-bottom: 10px;">--}}
                            {{--<label style="margin-right: 20px;display: inline-block"><input type="checkbox" id="checkAll">Check All</label> <button type="submit" style="background: red;color: #fff;border: none;padding: 3px 10px;">Xóa hết</button>--}}
                        {{--</div>--}}
                            @if(!empty($employers))
                        <table id="employers" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                {{--<th>Check All</th>--}}
                                <th>ID</th>
                                <th>Nhà tuyển dụng</th>
                                <th>Email - Số điện thoại</th>
                                <th>Logo</th>
                                <th>Loại hình doanh nghiệp</th>
                                <th>Loại hình kinh doanh</th>
                                <th>Tỉnh / thành phố</th>
                                <th>Quận / huyện</th>
                                <th>Số tin tuyển dụng(facebook)</th>
                                <th>Số tin tuyển dụng(NTD)</th>
                                <th style="width: 120px">Tuyển thực tập</th>
                                <th>Thao tác</th>

                            </tr>
                            </thead>
                            <tbody>

                                @foreach($employers as $employer)
                                    <tr>
                                        <td>{{ isset($employer['employer_id']) ? $employer['employer_id'] : '' }}</td>
                                        <td>
                                            {{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : '' }}
                                            @if($employer['status_agency'] == 1)
                                                <p style="margin-bottom: 0">Mã giới thiệu :  {{ isset($employer['code_intro']) ? $employer['code_intro'] : '' }} </p>

                                                @endif

                                            <p class="clgreen text-center green" style="margin-bottom: 0">
                                                <span>@if($employer['status_agency'] == 1) Đại lý @else Không phải đại lý @endif -- </span>
                                                {{ isset($employer['employer_coin']) ? $employer['employer_coin'] : '' }} xu  <span class="clgreen text-center red" style="margin-bottom: 0"> @if(!empty($employer['employer_vip'])) - Vip(hr đăng tuyển) @endif </span> </p>

                                        </td>
                                        <td>{{ isset($employer['email']) ? $employer['email'] : '' }} - {{ isset($employer['phone']) ? $employer['phone'] : '' }}</td>
                                        <td><img src="{{ isset($employer['image']) ? $employer['image'] : '' }}" width="50px;"></td>
                                        <td>{{ isset($employer['type_of_business_name']) ? $employer['type_of_business_name'] : '' }}</td>
                                        <td>{{ isset($employer['business_type_name']) ? $employer['business_type_name'] : '' }}</td>

                                        <td>
                                            <?php $provice = \App\Entity\Province::getId($employer['province']) ?>
                                            {{ isset($provice['province_name']) ? $provice['province_name'] : '' }}</td>

                                        <td>
                                            <?php $district = \App\Entity\District::getId($employer['district']) ?>
                                            {{ isset($district['district_name']) ? $district['district_name'] : '' }}

                                        </td>

                                        <td>
                                            <?php
                                            $totalJob = 0;
                                            $totalJob = \App\Entity\Job::getAllJobEmployer($employer['employer_id']);
                                            ?>
                                             {{ $totalJob }} (tin Facebook)
                                        </td>


                                        <td>
                                            <?php
                                            $totalJobfacebook = 0;
                                            $totalJobfacebook = \App\Entity\JobFacebook::getAllJobFacebookEmployer($employer['employer_id']);
                                            ?>
                                            {{ $totalJobfacebook }} (tin NTD)
                                        </td>
                                        <td style="width: 120px">
                                            @if($employer->status_intership == 0)
                                                <span style="color: white;background: red;padding: 5px 10px;">Không tuyển</span>
                                            @else
                                                <span style="color: white;background: green;padding: 5px 10px;">Đang tuyển</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('employer.edit',['employer_id' => $employer->employer_id]) }}">
                                                <button class="btn btn-primary" type="button"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                            </a>
                                            <a href="{{ route('employer.destroy',['employer_id' => $employer->employer_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                            <a class="mgt5" href="{{ route('list_intership',['employer_id' => $employer->employer_id]) }}" style="display: block">
                                                <button style="margin-top: 5px;" class="btn btn-success" type="button"><i class="fa fa-list" aria-hidden="true"></i>
                                              thực tập</button>
                                            </a>

                                            <a class="mgt5" href="{{ route('show_employer_angency',['employer_id' => $employer->employer_id]) }}" style="display: block">
                                                <button style="margin-top: 5px;background: orange;color: #fff" class="btn btn-orange" type="button"><i class="fa fa-list" aria-hidden="true"></i>
                                                    Đại lý</button>
                                            </a>
                                        </td>

                                    </tr>
                                    @endforeach
                            </tbody>

                        </table>
                                <div class="pull-right">{{ $employers->links() }}</div>
                                @endif

                        {{--</form>--}}

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
            {{--$('#employers').dataTable({--}}
                {{--processing: true,--}}
                {{--serverSide: true,--}}
                {{--type: 'GET',--}}
                {{--ajax: '{{route('dt_employer')}}',--}}
                {{--columns :[--}}
                    {{--{ data: 'id', name: 'employer.id',render:function (data) {--}}
                            {{--return '<input type="checkbox" id="checkItem" name="delete_id[]" value="'+data+'">';--}}
                        {{--}--}}
                     {{--},--}}
                    {{--{ data: 'employer_id', name: 'employer.employer_id' },--}}
                    {{--{ data: 'enterprise_name', name: 'enterprise_name' },--}}
                    {{--{ data: 'image', name: 'image' ,--}}
                        {{--render: function (data) {--}}
                            {{--return '<img src="'+data+'" width="100" alt="NTD" />';--}}
                        {{--}--}}
                    {{--},--}}
                    {{--{ data: 'type_of_business_name', name: 'type_of_business.type_of_business_name' },--}}
                    {{--{ data: 'business_type_name', name: 'business_type.business_type_name' },--}}
                    {{--{ data: 'status', name: 'status',--}}
                        {{--render: function (data) {--}}
                           {{--if(data == 0){--}}
                               {{--return 'Chưa có nhu cầu';--}}
                           {{--}else if (data == 1){--}}
                               {{--return 'Có nhu cầu';--}}
                           {{--}else if (data == 2){--}}
                               {{--return 'Đã lên đơn hàng';--}}
                           {{--}--}}
                        {{--}--}}
                    {{--},--}}
                    {{--{ data: 'total_money', name: 'total_money' ,--}}
                        {{--render: function (data) {--}}
                            {{--return '<b>' + numeral(data).format('0,0') + " VNĐ </b>";--}}
                        {{--}--}}
                    {{--},--}}
                    {{--{ data: 'number_recruit_require', name: 'number_recruit_require' ,--}}
                        {{--render: function (data) {--}}
                            {{--return numeral(data).format('0,0');--}}
                        {{--}--}}
                    {{--},--}}
                    {{--{ data: 'recruited', name: 'recruited' ,--}}
                        {{--render: function (data) {--}}
                            {{--return numeral(data).format('0,0');--}}
                        {{--}--}}
                    {{--},--}}
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
            {{--$('#exportExcel').click(function(){--}}
                {{--$('#submitForm').attr('action','{{ route('exportToExcel') }}')--}}
                {{--return false;--}}
            {{--})--}}
        })
        //chell all het checkbox
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
    <style>
        input[type=checkbox]
        {
            width: 15px;
            height: 15px;
        }
    </style>
@endpush
