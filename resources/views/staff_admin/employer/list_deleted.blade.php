<?php
//1
$date_search_start = '';
if(isset($_GET['date_search_start'])){
    $date_search_start = $_GET['date_search_start'];
}
//2
$date_search_end = '';
if(isset($_GET['date_search_end'])){
    $date_search_end = $_GET['date_search_end'];
}
//3
$type_of_business_id = '';
if(isset($_GET['type_of_business_id'])){
    $type_of_business_id = $_GET['type_of_business_id'];
}
//4
$business = '';
if(isset($_GET['business'])){
    $business = $_GET['business'];
}
//5
$date_search_start = '';
if(isset($_GET['enterprise_name'])){
    $enterprise_name = $_GET['enterprise_name'];
}
//6
$date_search_start = '';
if(isset($_GET['status_agency'])){
    $status_agency = $_GET['status_agency'];
}
//7
$province = '';
if(isset($_GET['province'])){
    $province = $_GET['province'];
}
//8
$district = '';
if(isset($_GET['district'])){
    $district = $_GET['district'];
}
//9
$email = '';
if(isset($_GET['email'])){
    $email = $_GET['email'];
}
//10
$status_intership = '';
if(isset($_GET['status_intership'])){
    $status_intership = $_GET['status_intership'];
}
//11
$is_delete = '';
if(isset($_GET['is_delete'])){
    $is_delete = $_GET['is_delete'];
}
//12
$status_employer = '';
if(isset($_GET['status_employer'])){
    $status_employer = $_GET['status_employer'];
}
//13
$num = '';
if(isset($_GET['num'])){
    $num = $_GET['num'];
}
?>
@extends('staff_admin.layouts.master')

@section('title', 'Danh sách nhà tuyển dụng' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employer')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="log_error">
                    @if (session('error'))
                        <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                            <div class="alert alert-danger mg-b-0 " role="alert">
                                {{ session('error') }}
                                <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                            </div>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                            <div class="alert alert-success mg-b-0 ">
                                {{session('success')}}
                                <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="contentJobsInteresting  col-f14 ">
                    <div class="custom-order">
                        <div class="custom-paginate first-order row mt-1 ml-1">
                            {{ $employers->links() }}
                            số bản ghi của một trang:
                            <span class="input-submit">
                                <form action="" class="inline">
                                    <input type="submit" value="200" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
                                    <input type="submit" value="50" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
                                    <input type="submit" value="40" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
                                    <input type="submit" value="30" name="num" class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
                                    <input type="submit" value="20" name="num"  class="{{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
                                    <input type="submit" value="10" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
                                    <input type="hidden" name="date_search_start" value="{{ $date_search_start }}">
                                    <input type="hidden" name="date_search_end" value="{{ $date_search_end }}">
                                    <input type="hidden" name="type_of_business_id" value="{{ $type_of_business_id }}">
                                    <input type="hidden" name="business" value="{{ $business }}">
                                    <input type="hidden" name="date_search_start" value="{{ $date_search_start }}">
                                    <input type="hidden" name="date_search_start" value="{{ $date_search_start }}">
                                    <input type="hidden" name="province" value="{{ $province }}">
                                    <input type="hidden" name="district" value="{{ $district }}">
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <input type="hidden" name="status_intership" value="{{ $status_intership }}">
                                    <input type="hidden" name="is_delete" value="{{ $is_delete }}">
                                    <input type="hidden" name="status_employer" value="{{ $status_employer }}">
                                </form>
                            </span>
                            | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '30' }}/{{ $total }} bản ghi
                        </div>
                        <div class="d-flex justify-content-start second-order">
                            <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-primary"></i> Tìm</a>
                            <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                    <form action="">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm nhà tuyển dụng                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-5 mb-3">
                                                        <label for="validationDefault01">Từ ngày(ngày xóa)</label>
                                                        @php
                                                              $d=strtotime("-1 Months");
                                                              $date = date("Y-m-d", $d)
                                                        @endphp
                                                        <input class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : $date }}" type="date" id="" name="date_search_start">
                                                      </div>
                                                      <div class="col-md-5 mb-3">
                                                        <label for="validationDefault02">Đến ngày(ngày xóa)</label>
                                                        <input class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : date("Y-m-d") }}" type="date" id="" name="date_search_end">
                                                        <input type="hidden" name="num" value="{{ $num }}">
                                                      </div>
                                                      <!-- myDatetime -->
                                                      <div class="col-md-2 mb-3">
                                                      <label for="validationDefault2" class="text-light">sd</label>
                                                        <input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày"></input>
                                                      </div>
                                                    <div class="col-md-4">
                                                            <?php
                                                            $type_of_business_id_get = '';
                                                            if(isset($_GET['type_of_business_id']))
                                                            {
                                                                $type_of_business_id_get = $_GET['type_of_business_id'];
                                                            }
                                                            ?>
                                                        <div class="form-group">
                                                            <select class="form-control js-example-basic-single select2" name="type_of_business_id">
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
                                                        <?php
                                                        $business_get = '';
                                                        if(isset($_GET['business']))
                                                        {
                                                            $business_get = $_GET['business'];
                                                        }
                                                        ?>
                                                        <div class="form-group">
                                                            <select class="form-control js-example-basic-single select2" name="business">
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
                                                        <?php
                                                        $enterprise_name_get = '';
                                                        if(isset($_GET['enterprise_name']))
                                                        {
                                                            $enterprise_name_get = $_GET['enterprise_name'];
                                                        }
                                                        ?>
                                                        <div class="form-group">
                                                            <input type="text" placeholder="Tên nhà tuyển dụng" class="form-control " name="enterprise_name" value="@if(!empty($enterprise_name_get)) {{$enterprise_name_get}} @endif">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                            <?php
                                                            $status_agency_get = '';
                                                            if(isset($_GET['status_agency']))
                                                            {
                                                                $status_agency_get = $_GET['status_agency'];
                                                            }
                                                            ?>
                                                        <div class="form-group">
                                                            <select class="form-control js-example-basic-single select2" name="status_agency">
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
                                                    <div class="col-md-4">
                                                        <?php
                                                        $province_get = '';
                                                        if(isset($_GET['province']))
                                                        {
                                                            $province_get = $_GET['province'];
                                                        }
                                                        ?>
                                                        <div class="form-group">
                                                            <select class="js-example-basic-single form-control select2" id="province" name="province">
                                                                <option value="">--Tỉnh/Thành phố--</option>
                                                                @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                                <option value="{{$province->province_id}}" @if(isset($_GET['province']) && $_GET['province'] == $province->province_id) selected @endif>
                                                                    {{$province->province_name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                            <?php
                                                            $district_get = '';
                                                            if (isset($_GET['district'])) {
                                                                $district_get = $_GET['district'];
                                                            }
                                                        ?>
                                                    <select class="js-example-basic-single form-control select2" name="district" id="district">
                                                        <option value="">--Chọn quận/huyện</option>
                                                        @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                        <option value="{{$district->district_id}}"
                                                            @if(isset($_GET['district']) &&
                                                            $_GET['district']==$district->district_id) selected @endif>
                                                            {{$district->district_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                    <div class="col-md-4">

                                                            <?php
                                                            $email_get = '';
                                                            if(isset($_GET['email']))
                                                            {
                                                                $email_get = $_GET['email'];
                                                            }
                                                            ?>
                                                            <input type="text" placeholder="Email nhà tuyển dụng" class="form-control " name="email" value="@if(!empty($email_get)) {{$email_get}} @endif">
                                                    </div>
                                                    <div class="col-md-4">
                                                            <?php
                                                            $status_intership_get = '';
                                                            if(isset($_GET['status_intership']))
                                                            {
                                                                $status_intership_get = $_GET['status_intership'];
                                                            }
                                                            ?>
                                                            <select class="form-control js-example-basic-single select2" name="status_intership">
                                                                <option value="" selected>-- Cổng thực tập --</option>

                                                                <option value="0"
                                                                        @if($status_intership_get == '0') selected @endif
                                                                > Không tuyển thực tập</option>
                                                                <option value="1"
                                                                        @if($status_intership_get == '1') selected @endif
                                                                >  Đang tuyển thực tập</option>

                                                            </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                            <div class="form-group">
                                                                <select class="js-example-basic-single form-control select2" name="is_delete"
                                                                    id="is_delete">
                                                                    <option value="">--Đề nghị xóa--</option>
                                                                    <option value="1" @if(isset($_GET['is_delete']) &&
                                                                        $_GET['is_delete']==1) selected @endif>--Không--</option>
                                                                    <option value="2" @if(isset($_GET['is_delete']) &&
                                                                        $_GET['is_delete']==2) selected @endif>--Có--</option>
                                                                </select>
                                                            </div>
                                                    </div>
                                                    <div class="col-md-4 ">
                                                        <div class="form-group">
                                                            <select class="js-example-basic-single form-control select2" name="status_employer"
                                                                id="status_employer">
                                                                <option value="" @if(isset($_GET['status_employer']) &&
                                                                $_GET['status_employer']=="")selected @endif>--Trạng thái--</option>
                                                                <option value="0" @if(isset($_GET['status_employer']) &&
                                                                    $_GET['status_employer']==0) selected @endif>--Chưa duyệt--</option>
                                                                <option value="1" @if(isset($_GET['status_employer']) &&
                                                                    $_GET['status_employer']==1) selected @endif>--Đã duyệt--</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="submit " class="btn btn-primary">Tìm kiếm</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <a href="{{ route('staff_employer.index') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>

                            <button  type="button" class="btn btn-sm btn-danger delete_all mr-1">Xóa</button>

                        </div>
                    </div>
                        <div class="row ">

                            <div class="col-md-12">
                                <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <div class="lockedWrap lockedWrap-first">
                                        <div class="cellWrap cellWrap-first">
                                            <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                        </div>
                                        @foreach ($employers as $employer)
                                        <div class="cellWrap">
                                            <input type="checkbox" id_customer="{{$employer->employer_id}}" class="checkItem" name="list_id[]"
                                                        value="{{$employer->employer_id}}">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                        <thead>
                                            <tr>
                                                {{-- <td scope="col ">
                                                    <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                                </td> --}}
                                                <td scope="col " class="lid_1"><p style="width: 50px;">id<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>

                                                <td scope="col " class="lid_2"><p style="width: 100px;">Thao tác<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                                <td scope="col " class="lid_3"><p style="width:100px">Ngày xóa<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                                <td scope="col " class="lid_4"><p style="width:350px">Tên NTD<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                                <td scope="col " class="lid_10"><p style="width:80px">TT<button class="lockButton btn btn-sm btn-success" id="lid_10">L</button></p></td>
                                                <td scope="col " class="lid_5"><p style="width:300px">Địa chỉ<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                                <td scope="col " class="lid_6"><p style="width:80px">Số tin TD<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                                <td scope="col " class="lid_7"><p style="width:130px">Số tin TD/Fb<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>
                                                <td scope="col " class="lid_8"><p style="width: 70px;">ĐN/xóa<button class="lockButton btn btn-sm btn-success" id="lid_8">L</button></p></td>
                                                {{-- <td scope="col ">Liên lc</td> --}}
                                                <td scope="col " class="lid_9"><p style="width: 80px;">Tuyển/TT<button class="lockButton btn btn-sm btn-success" id="lid_9">L</button></p></td>

                                                <td scope="col " class="lid_11"><p style="width:150px">Người TT<button class="lockButton btn btn-sm btn-success" id="lid_11">L</button></p></td>
                                                <td scope="col " class="lid_12"><p style="width: 160px;">Ngày TT<button class="lockButton btn btn-sm btn-success" id="lid_12">L</button></p></td>
                                                {{-- <th scope="col ">Người duyệt</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employers as $employer)
                                            <tr>
                                                {{-- <td data-title="Tích chọn phản hồi" class="numeric">
                                                    <input type="checkbox" id_customer="{{$employer->employer_id}}" class="checkItem" name="list_id[]"
                                                        value="{{$employer->employer_id}}">
                                                </td> --}}
                                                <td class="lid_1" scope="row ">{{ $employer->employer_id }}</td>

                                                <td class="lid_2">
                                                    <a href="{{ route('delete_hard_employer', $employer->employer_id) }}" onclick="confirm('Bạn chắc chắn muốn xóa!')" class="btn btn-sm btn-danger">Xóa</a>
                                                    <a href="{{ route('reset_employer', $employer->employer_id) }}" class="btn btn-sm btn-success">RS</a>
                                                </td>
                                                <td class="lid_3">
                                                    @if (!empty($employer->deleted_at))
                                                        @php
                                                            $date = date_create($employer->deleted_at);
                                                            echo date_format($date,"d/m/Y");
                                                        @endphp
                                                    @endif
                                                </td>
                                                {{-- <td class="lid_32">
                                                    {{ isset($employer->created_at) ? date_format($employer->created_at,"d/m/Y") : '--' }}
                                                </td> --}}
                                                <td class="lid_4">
                                                    <p class="crop" style="width: 350px">
                                                        {{ $employer->enterprise_name }}
                                                    </p>
                                                </td>
                                                <td  class="lid_10" width="200px">
                                                    @if($employer->status_employer == 0)
                                                        <p class="text-danger crop">Chưa duyệt</p>
                                                    @else <p class="text-success crop">Đã duyệt</p>
                                                    @endif
                                                </td>
                                                <td class="lid_5">
                                                    @php
                                                        $province_name = App\Entity\Province::where('province_id', $employer->province)->value('province_name');
                                                        $district_name = App\Entity\District::where('district_id', $employer->district)->value('district_name');
                                                    @endphp
                                                    <p class="crop">
                                                        {{ $province_name }} | {{ $district_name }}
                                                    </p>
                                                </td>
                                                <td class="lid_6">
                                                    <?php
                                                    $totalJob = 0;
                                                    $totalJob = \App\Entity\Job::getAllJobEmployer($employer['employer_id']);

                                                    $jobs = \App\Entity\Job::getJobEmployer($employer['employer_id']);
                                                    ?>
                                                    @if ($totalJob>0)
                                                    <a class=" text-success" target="_blank" href="{{ route('staff_job-ntd.index') }}?employer_id={{ $employer['employer_id'] }}">
                                                        <p class="crop" data-toggle="modal" data-target="#myModal{{ $employer['employer_id'] }}">
                                                            {{ $totalJob }} (tin NTD)
                                                        </p>
                                                    </a>
                                                    @else
                                                    <p class="crop">
                                                        {{ $totalJob }} (tin NTD)
                                                    </p>
                                                    @endif
                                                </td>
                                                <td class="lid_7"  width="300px">
                                                    <?php
                                                    $totalJobfacebook = 0;
                                                    $totalJobfacebook = \App\Entity\JobFacebook::getAllJobFacebookEmployer($employer['employer_id']);
                                                    ?>
                                                    {{ $totalJobfacebook }} (tin FB)
                                                </td>
                                                <td class="lid_8">
                                                    <?php
                                                    $check_delete = \App\Entity\Employer_delete_request::where('employer_id',$employer['employer_id'])->first();
                                                    ?>
                                                    @if($check_delete == null)
                                                    <span style="color: green">Không</span>
                                                    @else <span style="color: red">Có</span>
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    <div class="button-group">
                                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#lienlac{{ $employer->employer_id }}">Liên lạc</button>
                                                        <div class="modal fade" id="lienlac{{ $employer->employer_id }}" role="dialog">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <p>email: {{ $employer->email }}</p>
                                                                        <p>sdt: {{ $employer->phone }}</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td> --}}
                                                <td class="lid_9">
                                                    @if($employer->status_intership == 0)
                                                    <i class="fas fa-times btn btn-sm btn-danger"></i>
                                                    @elseif($employer->status_intership == 1)
                                                    <i class="fas fa-check btn btn-sm btn-success"></i>
                                                    @endif
                                                </td>

                                                <td class="lid_11">
                                                    <?php
                                                    $check_employer_handling = \App\Entity\Interactive_history_employer::select('interactive_history_employer.*','u.name as user_name')
                                                                                ->leftjoin('users as u','u.id','interactive_history_employer.user_id')
                                                                                ->where('interactive_history_employer.employer_id',$employer->employer_id)
                                                                                ->orderby('interactive_history_employer.id','desc')->first();
                                                    ?>
                                                    @if($check_employer_handling != null)
                                                        {{$check_employer_handling->user_name}}
                                                    @elseif($check_employer_handling == null && $employer->status_employer == 1)
                                                        Admin
                                                    @endif
                                                </td>
                                                <td class="lid_12">
                                                    @if($check_employer_handling != null)
                                                        {{ date_format($check_employer_handling->created_at,"d/m/Y H:i:s") }}
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    @if($employer->user_name == null && $employer->status_employer == 1)
                                                        Admin
                                                    @elseif($employer->user_name != null) {{$employer->user_name}}
                                                    @else Chưa có
                                                    @endif
                                                </td> --}}
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
<script>
    $('.delete_all').click(function(){
            var x = confirm("Bạn có chắc Xóa?");
            if (x){
                var Ids = [];
                $.each($(".checkItem:checked"), function () {
                    Ids.push($(this).val());
                });

                if(Ids.length == 0){
                    var changeHtml2 = '';
                    changeHtml2+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml2+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml2+=        'Vui lòng chọn NTD';
                    changeHtml2+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                    changeHtml2+=    '</div>';
                    changeHtml2+= '</div>';
                    $('.log_error').html(changeHtml2);
                    event.preventDefault();
                }
                else{
                    var content = $("#feedback_all").val();
                    var changeHtml = '';
                    $.ajax({
                        type: 'post',
                        url: '{{route("delete_all_hard_employer")}}',
                        data: 'Ids='+Ids,
                        success: function (data) {
                            location.reload();
                            if (data) {
                                changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                                changeHtml+=    '<div class="alert alert-success mg-b-0 ">';
                                changeHtml+=        'Xóa thành công';
                                changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                                changeHtml+=    '</div>';
                                changeHtml+= '</div>';
                                $('.log_error').html(changeHtml);
                            }

                        },
                        error: function (err) {
                            console.log(err);
                            changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                            changeHtml+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                            changeHtml+=        'Đề nghị xóa không thành công';
                            changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                            changeHtml+=    '</div>';
                            changeHtml+= '</div>';
                            $('.log_error').html(changeHtml);
                        }
                    });
                }
            }
            else
                return false;
        });
        $('.approved_all_employer').click(function(){
            var x = confirm("Bạn có chắc chắc duyệt?");
            if (x){
                var Ids = [];
                $.each($(".checkItem:checked"), function () {
                    Ids.push($(this).val());
                });

                if(Ids.length == 0){
                    var changeHtml3 = '';
                    changeHtml3+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml3+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml3+=        'Vui lòng chọn NTD';
                    changeHtml3+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                    changeHtml3+=    '</div>';
                    changeHtml3+= '</div>';
                    $('.log_error').html(changeHtml3);
                    event.preventDefault();
                }
                else{
                    var content = $("#feedback_all").val();
                    var changeHtml = '';
                    $.ajax({
                        type: 'post',
                        url: '{{route("approved_all_employer")}}',
                        data: {  content: content,Ids: Ids},
                        success: function (data) {
                            console.log(data);
                            if (data) {
                                changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                                changeHtml+=    '<div class="alert alert-success mg-b-0 ">';
                                changeHtml+=        'Duyệt thành công';
                                changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                                changeHtml+=    '</div>';
                                changeHtml+= '</div>';
                                $('.log_error').html(changeHtml);
                            }

                        },
                        error: function (err) {
                            console.log(err);
                            changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                            changeHtml+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                            changeHtml+=        'Duyệt không thành công';
                            changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                            changeHtml+=    '</div>';
                            changeHtml+= '</div>';
                            $('.log_error').html(changeHtml);
                        }
                    });
                }
            }
            else
                return false;
        });
     $('#province').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                })
            });
    //
    $('.form-plus').hide();
            $('.expan-form').click(function(){
                $('.form-plus').show();
                $('.form-short').hide();
            });
            $('.notexpan-form').click(function(){
                $('.form-plus').hide();
                $('.form-short').show();
            });
    $('#checkAllSendMail').click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    $('.response').click(function() {
        var Ids = [];
            $.each($(".checkItem:checked"), function () {
                Ids.push($(this).val());
            });
        if(Ids.length == 0){
            var changeHtml2 = '';
                changeHtml2+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                changeHtml2+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                changeHtml2+=        'Vui lòng chọn giáo viên';
                changeHtml2+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                changeHtml2+=    '</div>';
                changeHtml2+= '</div>';
                $('.log_error').html(changeHtml2);
        }
        else
        $('#myModal1').modal('show');
    })
    $('.send1').click(function(){
        if($.trim($('#feedback_all').val()).length === 0){
            $('.note_text_feedback_all').hide();
            $('.error_text_feedback_all').html('<i class="error"><span class="error_reg_mess_icon">Vui lòng nhập phản hồi</span></i>');
            $('.error_reg_mess_icon').css("color", "#ff0000");
            $('.error_border_feedback_all').css("cssText", "border: 1px solid #ff0000  !important;");
            event.preventDefault();
        }
        else{
        var Ids = [];
        $.each($(".checkItem:checked"), function () {
            Ids.push($(this).val());
        });
        console.log(Ids);
        if(Ids.length == 0){
            var changeHtml2 = '';
            changeHtml2+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
            changeHtml2+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
            changeHtml2+=        'Vui lòng chọn NTD';
            changeHtml2+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
            changeHtml2+=    '</div>';
            changeHtml2+= '</div>';
            $('.log_error').html(changeHtml2);
            $('#myModal1').modal('hide');
            event.preventDefault();
        }
        else{
            var content = $("#feedback_all").val();
            var changeHtml = '';
                $.ajax({
                    type: 'post',
                    url: '{{route("SendFeedbackAllEmployer")}}',
                    data: {  content: content,Ids: Ids},
                    success: function (data) {
                        console.log(data);
                        if (data) {
                            changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                            changeHtml+=    '<div class="alert alert-success mg-b-0 ">';
                            changeHtml+=        'Phản hồi thành công';
                            changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                            changeHtml+=    '</div>';
                            changeHtml+= '</div>';
                            $('.log_error').html(changeHtml);
                            $('#myModal1').modal('hide');
                        }

                    },
                    error: function (err) {
                        changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                        changeHtml+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                        changeHtml+=        'Phản hồi không thành công';
                        changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                        changeHtml+=    '</div>';
                        changeHtml+= '</div>';
                        $('.log_error').html(changeHtml);
                        $('#myModal1').modal('hide');
                    }
                });
            }
        }
    });

</script>
@endsection
