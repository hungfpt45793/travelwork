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
    $career_category_id = '';
    if(isset($_GET['career_category_id'])){
        $career_category_id = $_GET['career_category_id'];
    }
//4
    $salary_id = '';
    if(isset($_GET['salary_id'])){
        $salary_id = $_GET['salary_id'];
    }
//5
    $is_delete = '';
    if(isset($_GET['is_delete'])){
        $is_delete = $_GET['is_delete'];
    }
//6
    $province = '';
    if(isset($_GET['province'])){
        $province = $_GET['province'];
    }
//7
    $district = '';
    if(isset($_GET['district'])){
        $district = $_GET['district'];
    }
//8
    $employee_name = '';
    if(isset($_GET['employee_name'])){
        $employee_name = $_GET['employee_name'];
    }
//9
    $email = '';
    if(isset($_GET['email'])){
        $email = $_GET['email'];
    }
//10
    $status_employee = '';
    if(isset($_GET['status_employee'])){
        $status_employee = $_GET['status_employee'];
    }
//11
    $num = '';
    if(isset($_GET['num'])){
        $num = $_GET['num'];
    }
    $birthday = '';
    if(isset($_GET['birthday'])){
        $birthday = $_GET['birthday'];
    }
?>
@extends('staff_admin.layouts.master')

@section('title', 'Danh sách ứng viên' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employee')
            </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting  col-f14 ">
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
                    <div class="custom-order">
                        <div class="custom-paginate first-order">
                            {{ $employees->links() }}
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
                                    <input type="hidden" name="career_category_id" value="{{ $career_category_id }}">
                                    <input type="hidden" name="salary_id" value="{{ $salary_id }}">
                                    <input type="hidden" name="is_delete" value="{{ $is_delete }}">
                                    <input type="hidden" name="province" value="{{ $province }}">
                                    <input type="hidden" name="district" value="{{ $district }}">
                                    <input type="hidden" name="employee_name" value="{{ $employee_name }}">
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <input type="hidden" name="status_employee" value="{{ $status_employee }}">
                                    <input type="hidden" name="birthday" value="{{ $birthday }}">
                                </form>
                            </span>
                            | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '30' }}/{{ $total }} bản ghi
                        </div>
                        <div class="d-flex justify-content-start second-order">
                            <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a>
                            <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                    <form action="" method="GET">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm ứng viên</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row employee-search ">
                                                    <div class="col-md-5 mb-3">
                                                        <label for="validationDefault01">Từ ngày(ngày update)</label>
                                                        @php
                                                              $d=strtotime("-1 Months");
                                                              $date = date("Y-m-d", $d)
                                                        @endphp
                                                        <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : $date }}" type="date" id="" name="date_search_start">
                                                    </div>
                                                    <div class="col-md-5 mb-3">
                                                        <label for="validationDefault02">Đến ngày(ngày update)</label>
                                                        <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : date("Y-m-d") }}" type="date" id="" name="date_search_end">
                                                        <input type="hidden" name="num" value="{{$num}}">
                                                    </div>
                                                      <!-- myDatetime -->
                                                    <div class="col-md-2 mb-3">
                                                      <label for="validationDefault2" class="text-light">sd</label>
                                                        <input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày"></input>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6  ">
                                                        <div class="form-group">
                                                            <?php
                                                                $career_category_id_get = '';
                                                                if (isset($_GET['career_category_id'])) {
                                                                    $career_category_id_get = $_GET['career_category_id'];
                                                                }
                                                                ?>
                                                            <select class=" form-control select2" name="career_category_id">
                                                                <option value="">-- CV mong muốn --</option>
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
                                                        <div class="form-group">
                                                            <?php
                                                                $salary_id_get = '';
                                                                if (isset($_GET['salary_id'])) {
                                                                    $salary_id_get = $_GET['salary_id'];
                                                                }
                                                                ?>
                                                            <select class=" form-control select2" name="salary_id">
                                                                <option value="">-- Mức lương mong muốn --</option>
                                                                    @foreach(\App\Entity\Salary::get() as $salary)
                                                                        <option value="{{$salary->salary_id}}"
                                                                                @if($salary->salary_id == $salary_id_get) selected @endif
                                                                        >{{$salary->salary_from}} VNĐ
                                                                            - {{$salary->salary_to}} VNĐ
                                                                        </option>
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <select class=" form-control select2" name="is_delete"
                                                                id="is_delete">
                                                                <option value="">--Đề nghị xóa--</option>
                                                                <option value="1" @if(isset($_GET['is_delete']) &&
                                                                    $_GET['is_delete']==1) selected @endif>--Không--</option>
                                                                <option value="2" @if(isset($_GET['is_delete']) &&
                                                                    $_GET['is_delete']==2) selected @endif>--Có--</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="form-group">
                                                            <select class=" form-control select2" id="province" name="province">
                                                                <option value="">--Tỉnh/Thành phố--</option>
                                                                @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                                <option value="{{$province->province_id}}" @if(isset($_GET['province']) && $_GET['province'] == $province->province_id) selected @endif>
                                                                    {{$province->province_name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <?php
                                                                $district_get = '';
                                                                if (isset($_GET['district'])) {
                                                                    $district_get = $_GET['district'];
                                                                }
                                                            ?>
                                                           <select class=" form-control select2" name="district" id="district">
                                                            <option value="">--Chọn quận/huyện</option>
                                                            @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                            <option value="{{$district->district_id}}"
                                                                @if(isset($_GET['district']) &&
                                                                $_GET['district']==$district->district_id) selected @endif>
                                                                {{$district->district_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <?php
                                                            $birthday_get ='';
                                                            if (isset($_GET['birthday'])) {
                                                                $birthday_get = $_GET['birthday'];
                                                            }
                                                            ?>
                                                            <input type="text"
                                                            placeholder="Năm sinh" class="form-control"
                                                            name="birthday"
                                                            value="@if(!empty($birthday_get)){{$birthday_get}}@endif">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6  ">
                                                        <div class="form-group">
                                                            <?php
                                                            $employee_name_get ='';
                                                            if (isset($_GET['employee_name'])) {
                                                                $employee_name_get = $_GET['employee_name'];
                                                            }
                                                            ?>
                                                            <input type="text"
                                                            placeholder="Tên ứng viên" class="form-control "
                                                            name="employee_name"
                                                            value="@if(!empty($employee_name_get)){{$employee_name_get}}@endif">
                                                        </div>
                                                        <div class="form-group">
                                                            <?php
                                                            $email_get ='';
                                                            if (isset($_GET['email'])) {
                                                                $email_get = $_GET['email'];
                                                            }
                                                            ?>
                                                            <input type="text"
                                                            placeholder="Email ứng viên" class="form-control "
                                                            name="email"
                                                            value="@if(!empty($email_get)){{$email_get}}@endif">
                                                        </div>
                                                        <div class="form-group">
                                                            <select class=" form-control select2" name="status_employee"
                                                                id="status_employee">
                                                                <option value="" @if(isset($_GET['status_employee']) &&
                                                                $_GET['status_employee']=="")selected @endif>--Trạng thái--</option>
                                                                <option value="0" @if(isset($_GET['status_employee']) &&
                                                                    $_GET['status_employee']==0) selected @endif>--Chưa duyệt--</option>
                                                                <option value="1" @if(isset($_GET['status_employee']) &&
                                                                    $_GET['status_employee']==1) selected @endif>--Đã duyệt--</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="submit " class="btn btn-primary">Tìm kiếm</button>
                                                <input type="reset" class="btn btn-sm btn-success" value="Reset">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <a href="{{ route('employee20To40') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                            <a href="{{ route('staff_employee.create') }}" class="btn btn-sm btn-success mr-1 text-white"> Thêm mới</a>
                            <button  type="button" id="response" class="btn btn-sm btn-warning mr-1">Phản hồi</button>
                            <div id="myModal1" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    {{-- <form role="form" action=""  method="POST" id="send_feedback_all_teacher"> --}}
                                        {!! csrf_field() !!}
                                <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Phản hồi tới tất cả</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <textarea class="form-control error_border_feedback_all" id="feedback_all" name="feedback_all" rows="6" cols="80" placeholder="Nhập phản hồi"/></textarea>
                                                <div class="mess_notice_feedback_all clearfix note_text_feedback_all"></div>
                                                <div class="error_reg_mess clearfix error_text_feedback_all"></div>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                            <button type="button" class="btn btn-primary send1">Gửi</button>
                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                            <!-- <button  type="button" class="btn btn-sm btn-danger delete_request mr-1">Đề nghị xóa</button> -->
                            <button  type="button" class="btn btn-sm btn-danger delete_all mr-1">Xóa</button>
                            <button  type="submit" class="btn btn-sm btn-info approved_all_employee">Duyệt</button>
                        </div>
                    </div>

                    <div class="row mr-1">

                        <div class="col-md-12">
                            <div id="locker" data-fl-scrolls class="custom-table table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                    </div>
                                    @foreach ($employees as $employee)
                                    <div class="cellWrap">
                                        <input type="checkbox" id_customer="{{$employee->employee_id}}" class="checkItem" name="list_id[]"
                                        value="{{$employee->employee_id}}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                                <div class="table-wrapper tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table  data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            {{-- <td scope="col">
                                                <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                            </td> --}}
                                            <td scope="col" class="lid_1"><p style="width:50px">id<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td scope="col" class="lid_2"><p style="width:80px">Thao tác<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td scope="col" class="lid_32"><p style="width:80px">N/tạo<button class="lockButton btn btn-sm btn-success" id="lid_32">L</button></p></td>
                                            <td scope="col" class="lid_4"><p style="width:150px">Tên ứng viên<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td scope="col" class="lid_6"><p style="width:70px">% H/Sơ<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                            <td scope="col" class="lid_10"><p style="width:80px">T/Thái<button class="lockButton btn btn-sm btn-success" id="lid_10">L</button></p></td>
                                            <td scope="col" class="lid_5"><p style="width:250px">Địa chỉ<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            <td scope="col" class="lid_15"><p style="width:250px">Email<button class="lockButton btn btn-sm btn-success" id="lid_15">L</button></p></td>
                                            <td scope="col" class="lid_7"><p style="width:120px">CV mong muốn<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>
                                            <td scope="col" class="lid_8"><p style="width:180px">Mức lương mong muốn<button class="lockButton btn btn-sm btn-success" id="lid_8">L</button></p></td>
                                            <td scope="col" class="lid_13"><p style="width:80px">T/độ<button class="lockButton btn btn-sm btn-success" id="lid_13">L</button></p></td>
                                            <td scope="col" class="lid_14"><p style="width:80px">K/N<button class="lockButton btn btn-sm btn-success" id="lid_14">L</button></p></td>
                                            <td scope="col" class="lid_16"><p style="width:140px">Năm sinh<button class="lockButton btn btn-sm btn-success" id="lid_16">L</button></p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $employee)
                                        <tr>
                                            {{-- <td data-title="Tích chọn phản hồi" class="numeric">
                                                <input type="checkbox" id_customer="{{$employee->employee_id}}" class="checkItem" name="list_id[]"
                                                    value="{{$employee->employee_id}}">
                                            </td> --}}
                                            <td scope="row" class="lid_1">{{ $employee->employee_id }}</td>
                                            <td class="lid_2">
                                                <a href="{{ route('detail_employee', $employee->employee_id) }}">
                                                    <button type="button" class="btn btn-sm btn-info">Thao tác</button>
                                                </a>
                                            </td>
                                            <td class="lid_32">
                                                <?php
                                                $date=date_create($employee->created_at);
                                                echo date_format($date,"d/m/Y");
                                                ?>
                                            </td>
                                            <td class="lid_4"><p class="crop">{{ $employee->employee_name }}</p></td>
                                            <td class="lid_6">{{ round($employee->profile) }}%</td>
                                            <td class="lid_10">
                                                @if($employee->status_employee == 0)
                                                    <p class="text-danger crop">Chưa duyệt</p>
                                                @else
                                                <p class="text-success crop">Đã duyệt</p>
                                                @endif
                                            </td>
                                            <td class="lid_5">
                                                @php
                                                    $province_name = App\Entity\Province::where('province_id', $employee->province)->value('province_name');
                                                    $district_name = App\Entity\District::where('district_id', $employee->district)->value('district_name');
                                                @endphp
                                                <p class="crop">{{ $province_name }} | {{ $district_name }}</p>
                                            </td>
                                            <td class="lid_15">
                                                <p class="crop">{{ $employee->email }}</p>
                                            </td>
                                            <td class="lid_7">
                                                <?php $career = \App\Entity\Career::where('career_category_id',$employee->career_category_id)->value('career_category_name');?>
                                                <p class="crop">{{ $career }}</p>
                                            </td>
                                            <td class="lid_8">
                                                <?php
                                                $salary = \App\Entity\Salary::where('salary_id',$employee->salary_id)->value('description');
                                                ?>
                                                <p class="crop">{{ $salary }}</p>
                                            </td>
                                            <td class="lid_13">
                                                @php
                                                    $specialize = App\Entity\Employee_specialize::select('*')->where('employee_id', $employee->employee_id)->orderBy('specialize_id', 'asc')->first();
                                                @endphp
                                                @if (!empty($specialize))
                                                <button  type="button" class="btn btn-sm btn-primary xem_spec" employee_id="{{$employee->employee_id}}">Xem</button>
                                                @endif
                                            </td>
                                            <td class="lid_14">
                                                @php
                                                    $experience = App\Entity\Employee_experience::select('*')->where('employee_id', $employee->employee_id)->orderBy('experience_id', 'asc')->first();
                                                @endphp
                                                @if (!empty($experience))
                                                <button  type="button" class="btn btn-sm btn-primary xem_exp" employee_id="{{$employee->employee_id}}">Xem</button>
                                                @endif
                                            </td>
                                            <td class="lid_16">
                                                <?php
                                                    $date=date_create($employee->birthday);
                                                    echo date_format($date,"d/m/Y");
                                                ?>
                                            </td>
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
<div id="myModal2" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {{-- <form role="form" action=""  method="POST" id="send_feedback_all_teacher"> --}}
      <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Trình độ ứng viên</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="CV bgrWhite radius5   mgb20 pdb5">
                        <div class="content">
                            <div class="row">
                                <?php
                                    // $specialize = \App\Entity\Employee_specialize::select('*')->where('employee_id', $id)->orderBy('specialize_id', 'asc')->get();
                                ?>
                                <div class="col-md-12 mgt15">
                                    {{-- @if(!empty($specialize)) --}}
                                        <div class="col-xl-12 col-lg-12 left">
                                            <div class="boxSchool" id="specialize">


                                            </div>


                                        </div>
                                    {{-- @endif --}}

                                </div>

                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        {{-- </form> --}}


    </div>
  </div>
  <div id="myModal3" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {{-- <form role="form" action=""  method="POST" id="send_feedback_all_teacher"> --}}
      <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kinh nghiệm ứng viên</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                        <div class="content">
                            <div class="row">

                                <div class="col-md-12  mgt15">
                                    {{-- <div class="title mgt20">
                                        <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter  sm-w100 sm-mgt20 clred">
                                            Kinh nghiệm làm việc
                                        </div>
                                    </div> --}}
                                    <div class="col-xl-12 col-lg-12 left">
                                        {{-- @if(!empty($experience)) --}}
                                            <div class="boxSchool" id="experience">

                                            </div>

                                        {{-- @endif --}}

                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        {{-- </form> --}}


    </div>
  </div>
  <script>
    $(document).ready(function(){
 //
 $('#province').change(function () {
     $.get('/admin/ajax-district/' + $(this).val(), function (data) {
         $('#district').html(data);
     })
 });
});
</script>
    <script>
        $('.xem_spec').click(function(){

            var id = $(this).attr('employee_id');
            var changeHtml = '';
            $.ajax({
                type: 'post',
                url: '{{route("staff_look_spec_employee")}}',
                data: {id: id},
                success: function (data) {
                    let specialize = data.specialize;
                    let literacy   = data.literacy;
                    console.log(data.specialize);
                // changHtml += '<div class="" id="getDataByCategory">';
                for (var i = 0; i < specialize.length; i++) {
                    changeHtml += '<div class="deleteItemSpec">';
                    changeHtml +=    '<p class="clorange f18" style="font-weight: bold;margin-bottom: 10px;">Thời gian: '+specialize[i].star_specialize_time+'-'+specialize[i].end_specialize_time +'</p>';
                    changeHtml +=    '<div class="form-row ">';
                    changeHtml +=        '<div class="col-lg-6 pdr2p lg-pd0Im">';
                    changeHtml +=             '<label for="inputZip" class="fw6">Tên trường : <span class="clhome">'+specialize[i].school+'</span></label>';
                    changeHtml +=        '</div>';
                    changeHtml +=        '<div class="col-lg-6 pdr2p lg-pd0Im">';
                    changeHtml +=            '<label for="inputZip" class="fw6">Trình độ : <span class="clhome">';
                    for (var j = 0; j < literacy.length; j++) {
                        if(specialize[i].leve == literacy[j].literacy_id)  {
                            changeHtml += literacy[j].literacy_name;
                        }
                    }
                    changeHtml += '</span></label>';

                    changeHtml += '    </div>';
                    changeHtml += '</div>';
                    changeHtml +=    '<div class="form-row">';
                    changeHtml +=        '<div class="col-lg-6 pdr2p lg-pd0Im">';
                    changeHtml +=             '<label for="inputZip" class="fw6">Ngành học : <span class="clhome">' + specialize[i].majors+'</span></label>';
                    changeHtml += '    </div>';
                    changeHtml += '        <div class=" col-lg-6 pdr2p lg-pd0Im">';
                    changeHtml += '            <label for="inputZip" class="fw6">Tình trạng : <span  class="clhome">' + specialize[i].specialize_status+'</span></label>';
                    changeHtml += '    </div>';
                    changeHtml += '</div>';
                    changeHtml +=     '<hr class="" style="border-top: 1px dotted #ccc">';
                    changeHtml +=     '</div>';
                }
                $('#specialize').html(changeHtml);

    // $('#myModal2').modal('show');
                $('#myModal2').modal('show');
                },
                error: function (err) {
                    changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml+=        'Đã có lỗi xảy ra';
                    changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                    changeHtml+=    '</div>';
                    changeHtml+= '</div>';
                    $('.log_error').html(changeHtml);
                }
            });
        });
        $('.xem_exp').click(function(){
            var id = $(this).attr('employee_id');
            var changeHtml = '';
            $.ajax({
                type: 'post',
                url: '{{route("staff_look_exp_employee")}}',
                data: {id: id},
                success: function (data) {
                    var experience = data.experience;
                    var literacy   = data.literacy;
                    console.log(data);
                // changHtml += '<div class="" id="getDataByCategory">';
                for (var i = 0; i < experience.length; i++) {
                    changeHtml += '<div class="deleteItemSpec">';
                    changeHtml +=    '<p class="clorange f18" style="font-weight: bold;margin-bottom: 10px;">Thời gian: '+experience[i].star_working_time+'-'+experience[i].end_working_time +'</p>';
                    changeHtml +=    '<div class="form-row ">';
                    changeHtml +=        '<div class="col-lg-12 pdr2p lg-pd0Im">';
                    changeHtml +=             '<label for="inputZip" class="fw6">Công ty đã làm việc : <span class="clhome">'+experience[i].company+'</span></label>';
                    changeHtml +=        '</div>';
                    changeHtml +=        '<div class="col-lg-12 pdr2p lg-pd0Im">';
                    changeHtml +=            '<label for="inputZip" class="fw6">Vị trí công việc :<span class="clhome">'+experience[i].position;
                    changeHtml += '</span></label>';
                    changeHtml += '    </div>';
                    changeHtml +=        '<div class="col-lg-12 pdr2p lg-pd0Im">';
                    changeHtml +=             '<label for="inputZip" class="fw6">Mô tả công việc : <span class="clhome">' + experience[i].des_position+'</span></label>';
                    changeHtml += '    </div>';
                    changeHtml += '</div>';
                    changeHtml +=     '<hr class="" style="border-top: 1px dotted #ccc">';
                    changeHtml +=     '</div>';
                }
                $('#experience').html(changeHtml);
                $('#myModal3').modal('show')    ;
                },
                error: function (err) {
                    changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml+=        'Đã có lỗi xảy ra';
                    changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                    changeHtml+=    '</div>';
                    changeHtml+= '</div>';
                    $('.log_error').html(changeHtml);
                }
            });
        });
        $('.delete_request').click(function(){
            var x = confirm("Bạn có chắc chắc đề nghị xóa?");
            if (x){
                var Ids = [];
                $.each($(".checkItem:checked"), function () {
                    Ids.push($(this).val());
                });

                if(Ids.length == 0){
                    var changeHtml2 = '';
                    changeHtml2+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml2+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml2+=        'Vui lòng chọn ứng viên';
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
                        url: '{{route("staff_employee_delete_all_request")}}',
                        data: {  content: content,Ids: Ids},
                        success: function (data) {
                            console.log(data);
                            if (data) {
                                changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                                changeHtml+=    '<div class="alert alert-success mg-b-0 ">';
                                changeHtml+=        'Đề nghị xóa thành công';
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
        $('.delete_all').click(function(){
            var x = confirm("Bạn có chắc chắc xóa?");
            if (x){
                var Ids = [];
                $.each($(".checkItem:checked"), function () {
                    Ids.push($(this).val());
                });

                if(Ids.length == 0){
                    var changeHtml2 = '';
                    changeHtml2+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml2+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml2+=        'Vui lòng chọn ứng viên';
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
                        url: '{{route("staff_employee_delete_all")}}',
                        data: 'Ids='+Ids,
                        success: function (data) {
                            location.reload();
                            console.log(data);
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
                            changeHtml+=        'Xóa không thành công';
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
        $('.approved_all_employee').click(function(){
            var x = confirm("Bạn có chắc chắc muốn duyệt?");
            if (x){
                var Ids = [];
                $.each($(".checkItem:checked"), function () {
                    Ids.push($(this).val());
                });

                if(Ids.length == 0){
                    var changeHtml3 = '';
                    changeHtml3+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml3+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml3+=        'Vui lòng chọn ứng viên';
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
                        url: '{{route("approved_all_employee")}}',
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

    $('#checkAllSendMail').click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    $('#response').click(function(){
        var Ids = [];
            $.each($(".checkItem:checked"), function () {
                Ids.push($(this).val());
            });
        if(Ids.length == 0){
            var changeHtml2 = '';
                    changeHtml2+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml2+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml2+=        'Vui lòng chọn việc làm';
                    changeHtml2+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                    changeHtml2+=    '</div>';
                    changeHtml2+= '</div>';
                    $('.log_error').html(changeHtml2);
                    event.preventDefault();
        }
        else{
            $('#myModal1').modal('show');
        }
    });
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
                var content = $("#feedback_all").val();
                var changeHtml = '';
                $.ajax({
                    type: 'post',
                    url: '{{route("SendFeedbackAllEmployee")}}',
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
    });
    </script>
@endsection
