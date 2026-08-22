<?php
$num = '';
if(isset($_GET['num'])){
    $num = $_GET['num'];
}
?>
@extends('staff_admin.layouts.master')

@section('title', 'Danh sách ứng viên đã giao' )

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
                                <button type="button" class="close iconAlert" data-dismiss="alert"
                                    aria-label="Close">x</button>
                            </div>
                        </div>
                        @endif
                        @if (session('success'))
                        <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                            <div class="alert alert-success mg-b-0 ">
                                {{session('success')}}
                                <button type="button" class="close iconAlert" data-dismiss="alert"
                                    aria-label="Close">x</button>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="custom-order container-fluid">
                        <div class="custom-paginate first-order row mt-1">
                            {{ $employees->links() }}
                            số bản ghi của một trang:
                            <span class="input-submit">
                                <form action="" class="inline">
                                    <input type="submit" value="200" name="num"
                                        class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
                                    <input type="submit" value="50" name="num"
                                        class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
                                    <input type="submit" value="40" name="num"
                                        class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
                                    <input type="submit" value="30" name="num"
                                        class="{{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
                                    <input type="submit" value="20" name="num"
                                        class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
                                    <input type="submit" value="10" name="num"
                                        class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
                                </form>
                            </span>
                            | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $employees->total() }} bản ghi
                        </div>
                        <div class="second-order row d-flex justify-content-between"
                            style="width:-webkit-fill-available">
                            <div class="col-xs-12">
                                <!-- Large modal -->
                                <button type="button" class="btn btn-primary mr-1 btn-sm" data-toggle="modal"
                                    data-target="#timkiem">Tìm</button>
                                <div class="modal fade" id="timkiem" tabindex="-1" role="dialog"
                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <form action="" method="GET">
                                            <?php
                                        $profile_get = isset($_GET['profile']) ? $_GET['profile'] : '';
                                        $status_get = isset($_GET['status']) ? $_GET['status'] : '';
                                        $birthday_get = isset($_GET['birthday']) ? $_GET['birthday'] : '';
                                        $employee_name = isset($_GET['employee_name']) ? $_GET['employee_name'] : '';
                                        $email = isset($_GET['email']) ? $_GET['email'] : '';
                                        $employee_id = isset($_GET['employee_id']) ? $_GET['employee_id'] : '';
                                        $recipient_id = isset($_GET['recipient_id']) ? $_GET['recipient_id'] : '';
                                        $giver_id = isset($_GET['giver_id']) ? $_GET['giver_id'] : '';
                                        ?>
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center" id="exampleModalLongTitle">Tìm
                                                        kiếm ứng viên
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                 <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-dismiss="modal">Đóng</button>
                                                    <button type="submit " class="btn btn-primary btn-sm">Tìm
                                                        kiếm</button>
                                                    <input type="reset" class="btn btn-sm btn-success" value="Làm mới">
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        {{-- tim trang thai uv --}}
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-md-3 control-label mb-0 mt-2 text-right">Trạng
                                                                thái UV</label>
                                                            <div class="col-md-9">
                                                                <select name="status_employee"
                                                                    class="select2 form-control">
                                                                    <option value="" @if(isset($_GET['status_employee'])
                                                                        && $_GET['status_employee']=="" )selected
                                                                        @endif>
                                                                        --Trạng thái--</option>
                                                                    <option value="0"
                                                                        @if(isset($_GET['status_employee']) &&
                                                                        $_GET['status_employee']==0) selected @endif>
                                                                        --Chưa
                                                                        duyệt--</option>
                                                                    <option value="1"
                                                                        @if(isset($_GET['status_employee']) &&
                                                                        $_GET['status_employee']==1) selected @endif>
                                                                        --Đã
                                                                        duyệt--</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        {{-- tim nam sinh --}}
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-md-3 control-label mb-0 mt-2 text-right">Năm
                                                                sinh</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input name="birthday"
                                                                        placeholder="Năm sinh ứng viên"
                                                                        value="@if(!empty($birthday_get)){{$birthday_get}}@endif"
                                                                        class="form-control" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- tim ten uv --}}
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-md-3 control-label mb-0 mt-2 text-right">Tên
                                                                UV</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input name="employee_name"
                                                                        placeholder="Tên ứng viên"
                                                                        value="@if(!empty($employee_name)){{$employee_name}}@endif"
                                                                        class="form-control" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- tim email uv --}}
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-md-3 control-label mb-0 mt-2 text-right">Email
                                                                UV</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input name="email" placeholder="Email ứng viên"
                                                                        value="@if(!empty($email)){{$email}}@endif"
                                                                        class="form-control" type="email">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- tim id uv --}}
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-md-3 control-label mb-0 mt-2 text-right">ID
                                                                UV</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input name="employee_id" placeholder="ID ứng viên"
                                                                        value="@if(!empty($employee_id)){{$employee_id}}@endif"
                                                                        class="form-control" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- tim nguoi giao --}}
                                                        <?php
                                                            $staffs = \App\Entity\Staff::select('staff_id', 'staff_name')->get();
                                                        ?>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 control-label mb-0 mt-2 text-right">
                                                                Người giao
                                                            </label>
                                                            <div class="col-md-9">
                                                                <select name="giver_id"
                                                                    class="select2 form-control">
                                                                    <option value="">-- Chọn người giao --</option>
                                                                    @foreach($staffs as $staff)
                                                                        
                                                                        <option value="{{ $staff->staff_id }}"
                                                                        @if($staff->
                                                                        staff_id == $giver_id) selected @endif    
                                                                        >{{ $staff->staff_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        {{-- tim nguoi nhan --}}
                                                        <div class="form-group row">
                                                            <label class="col-md-3 control-label mb-0 mt-2 text-right">
                                                                Người nhận
                                                            </label>
                                                            <div class="col-md-9">
                                                                <select name="recipient_id"
                                                                    class="select2 form-control">
                                                                    <option value="">-- Chọn người nhận --</option>
                                                                    @foreach($staffs as $staff)
                                                                        
                                                                        <option value="{{ $staff->staff_id }}"
                                                                        @if($staff->
                                                                        staff_id == $recipient_id) selected @endif
                                                                        >{{ $staff->staff_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        {{-- chon ngay --}}
                                                        <div class="form-group row mb-0">
                                                            <div class="col-md-6">
                                                                <label for="validationDefault01">Từ ngày(Cập nhật)</label>
                                                                @php
                                                                $d=strtotime("-1 Months");
                                                                $date = date("Y-m-d", $d)
                                                                @endphp
                                                                <input class="form-control myDatetime" max="9999-12-31"
                                                                    value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : '' }}"
                                                                    type="date" name="date_search_start">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="validationDefault02">Đến ngày(Cập nhật)</label>
                                                                <input class="form-control myDatetime" max="9999-12-31"
                                                                    value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : '' }}"
                                                                    type="date" name="date_search_end">
                                                                <input type="hidden" name="num" value="{{$num}}">
                                                            </div>
                                                        </div>
                                                            {{-- chon ngay giao --}}
                                                        <div class="form-group row mb-0">
                                                            <div class="col-md-6">
                                                                <label for="validationDefault01">Từ ngày giao</label>
                                                                <input class="form-control myDatetime" max="9999-02-20T12:30:55"
                                                                    value="{{ isset($_GET['giver_day_start']) ? $_GET['giver_day_start'] : '' }}"
                                                                    type="datetime-local" name="giver_day_start">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="validationDefault02">Đến ngày giao</label>
                                                                <input class="form-control myDatetime" max="9999-02-20T12:30:55"
                                                                    value="{{ isset($_GET['giver_day_end']) ? $_GET['giver_day_end'] : '' }}"
                                                                    type="datetime-local" name="giver_day_end">
                                                            </div>
                                                        </div>
                                                        {{-- han hoan thanh --}}
                                                        <div class="form-group row mb-0">
                                                            <div class="col-md-6">
                                                                <label for="validationDefault01">Từ ngày(hạn ht)</label>
                                                                @php
                                                                $d=strtotime("-1 Months");
                                                                $date = date("Y-m-d", $d)
                                                                @endphp
                                                                <input class="form-control myDatetime" max="9999-02-20T12:30:55"
                                                                    value="{{ isset($_GET['finish_day_start']) ? $_GET['finish_day_start'] : '' }}"
                                                                    type="datetime-local" name="finish_day_start">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="validationDefault02">Đến ngày(hạn ht)</label>
                                                                <input class="form-control myDatetime" max="9999-02-20T12:30:55"
                                                                    value="{{ isset($_GET['finish_day_end']) ? $_GET['finish_day_end'] : '' }}"
                                                                    type="datetime-local" name="finish_day_end">
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <a href="{{ route('employee_task') }}"
                                    class="btn btn-sm btn-success mr-1 text-white">Làm tươi</a>
                                <button type="button" id="response" class="btn btn-sm btn-warning mr-1">Phản
                                    hồi</button>
                                <div id="myModal1" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        {!! csrf_field() !!}
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Phản hồi tới tất cả</h4>
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <textarea class="form-control error_border_feedback_all"
                                                    id="feedback_all" name="feedback_all" rows="6" cols="80"
                                                    placeholder="Nhập phản hồi" /></textarea>
                                                <div class="mess_notice_feedback_all clearfix note_text_feedback_all">
                                                </div>
                                                <div class="error_reg_mess clearfix error_text_feedback_all"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Đóng</button>
                                                <button type="button" class="btn btn-primary send1">Gửi</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-danger delete_all mr-1">Xóa</button>
                                <button type="submit"
                                    class="btn btn-sm btn-info approved_all_employee mr-1">Duyệt</button>
                                <button type="submit" class="btn btn-sm btn-info un_approved_all_employee mr-1">Bỏ
                                    duyệt</button>
                            </div>
                            <!-- form tim kiem theo id uv -->
                            <div class="col-xs-12">
                                <form action="" class="">
                                    <div class="group-form border border-primary">
                                        <input class="search_employee_id border-0 input-lg" type="text"
                                            name="employee_id" style="width:80px"
                                            value="{{ (!empty($_GET['employee_id'])) ? $_GET['employee_id'] : ''  }}"
                                            placeholder="ID ứng viên">
                                        <button class="search border-0" type="submit"><i class="fa fa-search "
                                                aria-hidden="true"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if (url()->current() == route('list_employee_no_approved'))
                    <div class="d-flex justify-content-start thirty-order">
                        <form action="">
                            <button type="submit" name="employee0to20" value="0to20"
                                class="btn btn-outline-primary btn-sm mt-1 {{ !empty($_GET['employee0to20']) ? 'annut' : '' }}"><span>0%
                                    <i class="fas fa-long-arrow-alt-right"></i> 20%</span></button>
                            <button type="submit" name="employee20to40" value="20to40"
                                class="btn btn-outline-primary btn-sm mt-1 ml-1 {{ !empty($_GET['employee20to40']) ? 'annut' : '' }}"><span>20%
                                    <i class="fas fa-long-arrow-alt-right"></i> 40%</span></button>
                            <button type="submit" name="employee40to60" value="40to60"
                                class="btn btn-outline-primary btn-sm mt-1 ml-1 {{ !empty($_GET['employee40to60']) ? 'annut' : '' }}"><span>40%
                                    <i class="fas fa-long-arrow-alt-right"></i> 60%</span></button>
                            <button type="submit" name="employee60toMax" value="40to60"
                                class="btn btn-outline-primary btn-sm mt-1 ml-1 {{ !empty($_GET['employee60toMax']) ? 'annut' : '' }}"><span>60%
                                    trở lên</span></button>
                            <button type="submit" name="interacted" value="interacted"
                                class="btn btn-outline-primary btn-sm mt-1 ml-1 {{ !empty($_GET['interacted']) ? 'annut' : '' }}"><span>Đã
                                    tương tác</span></button>
                        </form>
                    </div>
                    @endif
                    <div class="row mr-1">
                        <div class="col-md-12">
                            <div id="locker" data-fl-scrolls class="custom-table table-bordered table-striped"
                                style="overflow: scroll;height:100vh;padding-bottom:25vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                    </div>
                                    @foreach ($employees as $employee)
                                    <div class="cellWrap">
                                        <input type="checkbox" id_customer="{{$employee->employee_id}}"
                                            class="checkItem" name="list_id[]" value="{{$employee->employee_id}}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="table-wrapper tableFixHead" style="overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped"
                                    style="overflow: scroll;height:100vh;padding-bottom:25vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <td scope="col" class="lid_1">
                                                <p style="width:39px">id<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_1">L</button>
                                                </p>
                                            </td>
                                            <td scope="col" class="lid_2">
                                                <p style="width:150px">Tên ứng viên<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_2">L</button>
                                                </p>
                                            </td>
                                            <td scope="col" class="lid_3">
                                                <p style="width:90px">N/Giao<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_3">L</button>
                                                </p>
                                            </td>
                                            <td scope="col" class="lid_4">
                                                <p style="width:90px">Hạn HT<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_4">L</button>
                                                </p>
                                            </td>
                                            <td scope="col" class="lid_5">
                                                <p style="width:97px">Người giao<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_5">L</button>
                                                </p>
                                            </td>
                                            <td scope="col" class="lid_6">
                                                <p style="width:120px">Người nhận<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_6">L</button>
                                                </p>
                                            </td>
                                            <td scope="col" class="lid_7">
                                                <p style="width:80px">N/tạo<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_7">L</button>
                                                </p>
                                            </td>
                                            <td scope="col" class="lid_8">
                                                <p style="width:90px">N/Cập nhật<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_8">L</button>
                                                </p>
                                            </td>
                                            <td scope="col" class="lid_9">
                                                <p style="width:40px"><i class="fas fa-cog"></i><button
                                                        class="lockButton btn btn-sm btn-success" id="lid_9">L</button>
                                                </p>
                                            </td>
                                            <td scope="col" class="lid_10">
                                                <p style="width:39px">CV<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_10">L</button>
                                                </p>
                                            </td>
                                            <td scope="col" class="lid_11">
                                                <p style="width:43px">K/H<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_11">L</button>
                                                </p>
                                            </td>
                                            <td scope="col" class="lid_12">
                                                <p style="width:44px">Ảnh<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_12">L</button>
                                                </p>
                                            </td>
                                            
                                            <td scope="col" class="lid_13">
                                                <p style="width:150px">% H/Sơ<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_13">L</button>
                                                </p>
                                            </td>
                                            <td scope="col" class="lid_14">
                                                <p style="width:150px">T/Thái<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_14">L</button>
                                                </p>
                                            </td>
                                          
                                            <td scope="col" class="lid_21">
                                                <p style="width:250px">Email<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_21">L</button>
                                                </p>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $employee)
                                        <tr class="remove_clicked">
                                            <td class="lid_1 employee_id td_{{ $employee->employee_id }}">
                                                {{ $employee->employee_id }}</td>
                                            <td class="lid_2">
                                                <p class="crop">{{ $employee->employee_name }}</p>
                                            </td>
                                            <td class="lid_3">
                                                <?php
                                                    $giver_day=date_create($employee->giver_day);
                                                    if(!empty($employee->giver_day)){
                                                        echo date_format($giver_day,"d/m/Y");
                                                    }
                                                ?>
                                            </td>
                                            <td class="lid_4">
                                                <?php
                                                    $finish_day=date_create($employee->finish_day);
                                                    if(!empty($employee->finish_day)){
                                                        echo date_format($finish_day,"d/m/Y");
                                                    }
                                                ?>
                                            </td>
                                            <td class="lid_5">
                                                <p class="crop">
                                                    <?php
                                                        $giver_name = \App\Entity\Staff::where('staff_id', $employee->giver_id)->value('staff_name');
                                                        echo $giver_name
                                                    ?>
                                                </p>
                                            </td>
                                            <td class="lid_6">
                                                <p class="crop">
                                                    <?php
                                                        $recipient_name = \App\Entity\Staff::where('staff_id', $employee->recipient_id)->value('staff_name');
                                                        echo $recipient_name
                                                    ?>
                                                </p>
                                            </td>
                                            <td class="lid_7">
                                                <?php
                                                    $date=date_create($employee->created_at);
                                                    echo date_format($date,"d/m/Y");
                                                ?>
                                            </td>
                                            <td class="lid_8 text-center">
                                                <?php
                                                    $date=date_create($employee->updated_at);
                                                    echo date_format($date,"d/m/Y");
                                                ?>
                                            </td>
                                            <td class="lid_9">
                                                <a class="modal_cv text-success a_click" data-toggle="modal"
                                                    data-id="{{ $employee->employee_id }}" data-target="#detailEmployee"
                                                    href="#">
                                                    <i class="fas fa-eye"></i> CV
                                                </a>
                                            </td>
                                            <td class="text-center lid_10">
                                                @if (isset($employee->employee_cv_status) &&
                                                $employee->employee_cv_status == 1)
                                                <i class="fas fa-file-upload fa-lg text-primary"></i>
                                                @else
                                                @if(!empty(\App\Entity\Cv_employee::where('employee_id',
                                                $employee->employee_id)->first()))
                                                <i class="fas fa-file-medical fa-lg text-success"></i>
                                                @else
                                                @endif
                                                @endif

                                            </td>
                                            <td class="text-center lid_11">
                                                @php
                                                $courses = \App\Course\Course_employee::where('employee_id',
                                                $employee->employee_id)->first();
                                                @endphp
                                                @if (!empty($courses))
                                                <i class="fas fa-check-circle text-success"></i>
                                                @endif
                                            </td>
                                            <td class="lid_16 text-center lid_12">
                                                @if(!empty($employee->employee_image))
                                                <i class="fas fa-check-circle text-success"></i>
                                                @endif
                                            </td>
                                          
                                          
                                            <td class="lid_13 custom_table_td_profile profile text-center">
                                                {{ round($employee->profile) }}%
                                            </td>
                                            <td class="lid_14 status_employee">
                                                @if($employee->status_employee == 0)
                                                <p class="text-danger crop">Chưa duyệt</p>
                                                @else
                                                <p class="text-success crop">Đã duyệt</p>
                                                @endif
                                            </td>
                                            <td class="lid_21">
                                                <p class="crop">{{ $employee->email }}</p>
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
<!-- modal xem cv -->
<div class="modal detailEmployee fade" id="detailEmployee" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="container-fluid">
                <div class="row">
                    <div
                        class="col-xs-12 col-md-12 col-lg-8 col_pdf pl-0 d-flex justify-content-center align-items-center">
                        <h3 class="text-center loading_cv" style="display:none"><i class="fas fa-spinner fa-pulse"></i>
                            Đang tải CV...</h3>
                        <div class="show_cv" style="width:100%">
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-4 pl-0" style="overflow: scroll;height: 97vh">
                        <button style="background:#f7921a" class="btn btn-sm reload_cv">Tải lại cv</button>
                        <table class="table table-bordered table_info mb-0">
                            <tbody>

                            </tbody>
                        </table>
                        <table class="table table-bordered table_coin">
                            <tbody>

                            </tbody>
                        </table>
                        <ul class="list-group ul_action">
                            <li class="list-group-item cus-list-group-item">
                                <i class="fas fa-reply"></i>
                                <span type="button" class="response" data-toggle="modal" data-target="#response_cv">
                                    Gửi email ứng viên
                                </span>
                            </li>
                            <li
                                class="list-group-item cus-list-group-item li_status_employee d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="employee_status"
                                        id="radio_approved" value="1">
                                    <label class="form-check-label" for="radio_approved">
                                        Duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="employee_status"
                                        id="radio_un_approved" value="0">
                                    <label class="form-check-label" for="radio_un_approved">
                                        Không duyệt
                                    </label>
                                </div>
                            </li>
                            <!-- <li class="list-group-item cus-list-group-item li_employee_cv_status d-flex justify-content-between align-items-center">
							</li> -->
                            <li
                                class="list-group-item cus-list-group-item li_status_employee d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="follow_status" id="radio_follow"
                                        value="1">
                                    <label class="form-check-label" for="radio_follow">
                                        Theo dõi
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="follow_status"
                                        id="radio_un_follow" value="0">
                                    <label class="form-check-label" for="radio_un_follow">
                                        Không theo dõi
                                    </label>
                                </div>
                            </li>
                            <!-- <li class="list-group-item cus-list-group-item li_follow_employee">
                                <input type="checkbox" name="follow_status" id="follow_status">
                                <label for="follow_status" class="follow_status mb-0">Theo dõi</label>
							</li> -->
                            <li class="list-group-item cus-list-group-item">
                                <i class="fas fa-reply"></i>
                                <span type="button" class="evaluate" data-toggle="modal" data-target="#evaluate">
                                    Đánh giá
                                </span>
                            </li>
                            <li class="list-group-item cus-list-group-item">
                                <a target="_blank" class="text-dark link_edit_form">
                                    <i class="fas fa-pen"></i>
                                    <span>
                                        Chỉnh sửa thông tin
                                    </span>
                                </a>
                            </li>
                            <li class="list-group-item cus-list-group-item">
                                <a target="_blank" class="text-dark link_interactive">
                                    <i class="fas fa-sync"></i>
                                    <span>
                                        Tương tác
                                    </span>
                                </a>
                            </li>
                            <li class="list-group-item cus-list-group-item">
                                <i class="fas fa-calculator"></i>
                                <span type="button" class="calculator_profile" data-toggle="modal"
                                    data-target="#calculator_profile">
                                    Chỉnh sửa điểm hồ sơ
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal phan hoi uwng vien -->
<div id="response_cv" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! csrf_field() !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Phản hồi</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <textarea class="form-control error_border_feedback" name="feedback" id="feedback" rows="6" cols="80"
                    required placeholder="Nhập phản hồi" /></textarea>
                <div class="mess_notice_feedback clearfix note_text_feedback"></div>
                <div class="error_reg_mess clearfix error_text_feedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary send_response">Gửi</button>
            </div>
        </div>
    </div>
</div>
<!-- modal danh gia ung vien -->
<div id="evaluate" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! csrf_field() !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Đánh giá</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Điểm đánh giá hồ sơ</label>
                    <input type="number" name="coin_profile" min="0" max="15" placeholder="Điểm đánh giá hồ sơ"
                        class="form-control">
                    <div class="error_coin text-danger"></div>
                </div>
                <div class="form-group">
                    <label for="">Nhận xét</label>
                    <textarea class="form-control" name="content" id="content_evaluate" rows="6" cols="80" required
                        placeholder="Nhập đánh giá" />
                    </textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary send_evaluate">Đánh giá</button>
            </div>
        </div>
    </div>
</div>
<!-- modal tinh lai diem ho so ung vien -->
<div id="calculator_profile" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! csrf_field() !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Chỉnh sửa điểm hồ sơ ứng viên</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Điểm hồ sơ cơ bản</label>
                    <input type="number" name="profile_info" id="profile_info" data-name="Điểm hồ sơ cơ bản" min="0"
                        max="20" class="form-control">
                    <small>Error message</small>
                </div>
                <div class="form-group">
                    <label for="">Điểm CV</label>
                    <input type="number" name="profile_cv" id="profile_cv" data-name="Điểm CV" min="0" max="40"
                        class="form-control">
                    <small>Error message</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary send_caculator_profile">Chỉnh sửa</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/valina_validate.js') }}"></script>
@include('staff_admin.employee.list_js')
<script>
$(document).ready(function() {
    $(".a_click").click(function() {
        $(".remove_clicked").removeClass('current')
        $(this).parent().parent().addClass('current')
        $(this).parent().parent().addClass('current_text')
    })
    $(".placeholder_cv").select2({
        placeholder: "Chọn CV mong muốn..."
    });
    $(".placeholder_kn").select2({
        placeholder: "Chọn kinh nghiệm..."
    });
    $(".placeholder_tt").select2({
        // placeholder: "Chọn...",
        allowClear: true
    });
    $(".placeholder_qh").select2({
        placeholder: "Chọn Quận/ Huyện..."
    });
    $(".placeholder_ml").select2({
        placeholder: "Chọn mức lương...",
        allowClear: true,
        tags: true
    });
    $(".placeholder_trth").select2({
        placeholder: "Chọn trạng thái..."
    });
    $('#detailEmployee .col_pdf .show_cv').remove();
    $('#detailEmployee').on('hide.bs.modal', function() {
        $('#detailEmployee .col_pdf .show_cv').remove();
        $('#detailEmployee table.table_info tbody').html('');
        $('#detailEmployee table.table_coin tbody').html('');
        let li_status_employee = $('#detailEmployee .ul_action .li_status_employee');
        let li_delete_request = $('#detailEmployee .ul_action .li_delete_request');
        let li_follow_employee = $('#detailEmployee .ul_action .li_follow_employee');
        li_delete_request.find('input').prop('checked', false);
        li_status_employee.find('input').prop('checked', false);
        li_follow_employee.find('input').prop('checked', false);
    })
    //
    $('#province').change(function() {
        $.get('/admin/ajax-district/' + $(this).val(), function(data) {
            $('#district').html(data);
        })
    });

  
    $('.delete_all').click(function() {
        var x = confirm("Bạn có chắc chắc xóa?");
        if (x) {
            var Ids = [];
            $.each($(".checkItem:checked"), function() {
                Ids.push($(this).val());
            });

            if (Ids.length == 0) {
                var changeHtml2 = '';
                changeHtml2 += '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                changeHtml2 += '<div class="alert alert-danger mg-b-0 " role="alert">';
                changeHtml2 += 'Vui lòng chọn ứng viên';
                changeHtml2 +=
                    '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                changeHtml2 += '</div>';
                changeHtml2 += '</div>';
                $('.log_error').html(changeHtml2);
                event.preventDefault();
            } else {
                var content = $("#feedback_all").val();
                var changeHtml = '';
                $.ajax({
                    type: 'post',
                    url: '{{route("staff_employee_delete_all")}}',
                    data: 'Ids=' + Ids,
                    success: function(data) {
                        location.reload();
                        console.log(data);
                        if (data) {
                            swal({
                                title: 'Xóa thành công.',
                                icon: "success",
                                button: "Đóng",
                            })
                        }

                    },
                    error: function(err) {
                        swal({
                            title: 'Xóa không thành công.',
                            icon: "error",
                            button: "Đóng",
                        })
                    }
                });
            }
        } else
            return false;
    });
    $('.approved_all_employee').click(function() {
        var Ids = [];
        $.each($(".checkItem:checked"), function() {
            Ids.push($(this).val());
        });

        if (Ids.length == 0) {
            swal({
                title: 'Vui lòng chọn ứng viên.',
                icon: "error",
                button: "Đóng",
            })
            event.preventDefault();
        } else {
            var content = $("#feedback_all").val();
            var changeHtml = '';
            $.ajax({
                type: 'post',
                url: '{{route("approved_all_employee")}}',
                data: {
                    content: content,
                    Ids: Ids
                },
                success: function(data) {
                    swal({
                        title: 'Duyệt thành công.',
                        icon: "success",
                        button: "Đóng",
                    })
                    location.reload();
                },
                error: function(err) {
                    swal({
                        title: 'Duyệt không thành công.',
                        icon: "error",
                        button: "Đóng",
                    })
                }
            });
        }
    });
    $('.un_approved_all_employee').click(function() {
        var x = confirm("Bạn có chắc chắc muốn bỏ duyệt?");
        if (x) {
            var Ids = [];
            $.each($(".checkItem:checked"), function() {
                Ids.push($(this).val());
            });

            if (Ids.length == 0) {
                var changeHtml3 = '';
                changeHtml3 += '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                changeHtml3 += '<div class="alert alert-danger mg-b-0 " role="alert">';
                changeHtml3 += 'Vui lòng chọn ứng viên';
                changeHtml3 +=
                    '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                changeHtml3 += '</div>';
                changeHtml3 += '</div>';
                $('.log_error').html(changeHtml3);
                event.preventDefault();
            } else {
                var content = $("#feedback_all").val();
                var changeHtml = '';
                $.ajax({
                    type: 'post',
                    url: '{{route("un_approved_all_employee")}}',
                    data: {
                        content: content,
                        Ids: Ids
                    },
                    success: function(data) {
                        alert("Bỏ duyệt thành công.")
                        location.reload();
                    },
                    error: function(err) {
                        console.log(err);
                        changeHtml +=
                            '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                        changeHtml +=
                            '<div class="alert alert-danger mg-b-0 " role="alert">';
                        changeHtml += 'Bỏ duyệt không thành công';
                        changeHtml +=
                            '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                        changeHtml += '</div>';
                        changeHtml += '</div>';
                        $('.log_error').html(changeHtml);
                    }
                });
            }
        } else
            return false;
    });
    $('#checkAllSendMail').click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    $('#response').click(function() {
        var Ids = [];
        $.each($(".checkItem:checked"), function() {
            Ids.push($(this).val());
        });
        if (Ids.length == 0) {
            swal({
                title: 'Vui lòng chọn ứng viên.',
                icon: "error",
                button: "Đóng",
            })
            event.preventDefault();
        } else {
            $('#myModal1').modal('show');
        }
    });

    $('.send1').click(function() {
        if ($.trim($('#feedback_all').val()).length === 0) {
            $('.note_text_feedback_all').hide();
            $('.error_text_feedback_all').html(
                '<i class="error"><span class="error_reg_mess_icon">Vui lòng nhập phản hồi</span></i>'
            );
            $('.error_reg_mess_icon').css("color", "#ff0000");
            $('.error_border_feedback_all').css("cssText", "border: 1px solid #ff0000  !important;");
            event.preventDefault();
        } else {
            var Ids = [];
            $.each($(".checkItem:checked"), function() {
                Ids.push($(this).val());
            });
            console.log(Ids);
            var content = $("#feedback_all").val();
            var changeHtml = '';
            $.ajax({
                type: 'post',
                url: '{{route("SendFeedbackAllEmployee")}}',
                data: {
                    content: content,
                    Ids: Ids
                },
                success: function(data) {
                    console.log(data);
                    if (data) {
                        changeHtml +=
                            '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                        changeHtml += '<div class="alert alert-success mg-b-0 ">';
                        changeHtml += 'Phản hồi thành công';
                        changeHtml +=
                            '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                        changeHtml += '</div>';
                        changeHtml += '</div>';
                        $('.log_error').html(changeHtml);
                        $('#myModal1').modal('hide');
                    }

                },
                error: function(err) {
                    changeHtml +=
                        '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml += '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml += 'Phản hồi không thành công';
                    changeHtml +=
                        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                    changeHtml += '</div>';
                    changeHtml += '</div>';
                    $('.log_error').html(changeHtml);
                    $('#myModal1').modal('hide');
                }
            });

        }
    });
    // Xem chi tiết cv ứng viên
    $('.modal_cv').on('click', function() {
        console.log('hien thi');
        $('#detailEmployee').attr('data-employee-id', $(this).attr('data-id'));

        let link_interactive = "{{ route('detail_employee', ':id') }}";
        link_interactive = link_interactive.replace(':id', $(this).attr('data-id'));
        $('#detailEmployee .link_interactive').attr('href', link_interactive);

        let link_edit_form = "{{ route('staff_employee_edit_form', ':id') }}";
        link_edit_form = link_edit_form.replace(':id', $(this).attr('data-id'));
        $('#detailEmployee .link_edit_form').attr('href', link_edit_form);

        $.ajax({
            'type': 'get',
            'url': "{{ route('staff_detail_cv') }}",
            'data': {
                employee_id: $(this).attr('data-id')
            },
            beforeSend: function() {
                $('.loading_cv').css('display', 'block');
            },
            'success': function(res) {
                let col_pdf = $('#detailEmployee .col_pdf');
                let table_info = $('#detailEmployee table.table_info tbody');
                let table_coin = $('#detailEmployee table.table_coin tbody');
                let li_status_employee = $(
                    '#detailEmployee .ul_action .li_status_employee');
                let li_delete_request = $('#detailEmployee .ul_action .li_delete_request');
                let li_follow_employee = $(
                    '#detailEmployee .ul_action .li_follow_employee');
                // th co cv upload
                if (res.cv_upload) {
                    // hien thi cv upload
                    col_pdf.append(
                        `
                            <div class="show_cv" style="width:100%">
                                <iframe src="https://docs.google.com/gview?url=${res.url_cv_upload}&embedded=true#toolbar=0"
                                frameborder="0" style="width:100%;height:97vh"></iframe>
                            </div>
                        `
                    )
                } else {
                    if (res.check_employee_cv) {
                        col_pdf.html(`<div class="show_cv" style="width:100%">
                            <iframe src="/ung-vien/pdf/page-cv/${res.employee.user_id}#toolbar=0"
                                frameborder="0" style="width:100%;height:97vh"></iframe></div>
                        `);
                    } else {
                        col_pdf.html(
                            `<div class="show_cv" style="width:100%"><p style="font-size:2rem;text-align:center">Ứng viên chưa có CV.</p></div>`
                        )
                    }
                }
                $('.loading_cv').css('display', 'none');
                //in table
                let approved = "";
                let status_job = "";
                if (res.employee.status_employee == 1) {
                    approved =
                        `<span class="text-success">Đã duyệt <i class="fas fa-check-circle"></i></span>`;
                } else {
                    approved =
                        `<span class="text-danger">Chưa duyệt <i class="fas fa-times-circle"></i></span>`;
                }

                if (res.employee.status == 0) {
                    status_job =
                        `<span class="text-danger">Chưa đi làm <i class="fas fa-times-circle"></i></span>`;
                } else {
                    status_job =
                        `<span class="text-success">Đã đi làm <i class="fas fa-check-circle"></i></span>`;
                }
                //format ngay
                let created_at = new Date(res.employee.created_at);
                let formatted_created_at = created_at.getDate() + "-" + (created_at
                    .getMonth() + 1) + "-" + created_at.getFullYear();
                let updated_at = new Date(res.employee.updated_at);
                let formatted_updated_at = updated_at.getDate() + "-" + (updated_at
                    .getMonth() + 1) + "-" + updated_at.getFullYear()
                // xac dinh email dda xac thuc chua
                let employee_email = '';
                if (res.employee.status_email_account == 0) {
                    employee_email = `
                        <span class="text-danger">${res.employee.email} <i class="fas fa-times-circle"></i></span>
                    `;
                } else {
                    employee_email = `
                        <span class="text-success">${res.employee.email} <i class="fas fa-check-circle"></i></span>
                    `;
                }
                // xac dinh an hay hien thi ho so
                // 0 la hen thi 1 la an
                let show_hidden_profile = '';
                if (res.employee.show_hidden_profile == 0) {
                    show_hidden_profile = `
                        <span class="text-success">Hiện H/S <i class="fas fa-check-circle"></i></span>
                    `;
                } else {
                    show_hidden_profile = `
                        <span class="text-danger">Ẩn H/S <i class="fas fa-times-circle"></i></span>
                    `;
                }
                table_info.html(`
                    <tr>
                        <td>Họ và tên</td>
                        <td colspan="2">${res.employee.employee_name} - ${res.employee.phone}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td colspan="2">${employee_email}</td>
                    </tr>
                    <tr>
                        <td>Trạng thái</td>
                        <td class="duyet">${approved}</td>
                        <td class="display_disable_profile">${show_hidden_profile}</td>
                    </tr>
                    <tr>
                        <td>TT công việc</td>
                        <td colspan="2">${status_job}</td>
                    </tr>
                    <tr>
                        <td>Mức lương</td>
                        <td colspan="2">${res.employee.salary}</td>
                    </tr>
                    <tr>
                        <td>Điểm hồ sơ</td>
                        <td colspan="2" class="td_profile">${res.employee.profile}</td>
                    </tr>
                    <tr>
                        <td>${formatted_created_at}</td>
                        <td colspan="2">${formatted_updated_at}</td>
                    </tr>
                    <tr>
                        <td
                        data-toggle="tooltip" title="Vị trí công việc ứng viên cần tìm"
                        data-original-title="Vị trí công việc ứng viên cần tìm"
                         colspan="3">${res.employee.careers}</td>
                    </tr>
                    <tr>
                        <td
                        data-toggle="tooltip" title="Khu vực ứng viên mong muốn tìm việc"
                        data-original-title="Khu vực ứng viên mong muốn tìm việc"
                         colspan="3">${res.employee.areas}</td>
                    </tr>
                `);
                table_coin.html(`
                    <tr>
                        <td
                        data-toggle="tooltip" title="Thông tin cơ bản của ứng viên"
                        data-original-title="Thông tin cơ bản của ứng viên"
                        >
                            <b style="font-size:0.7rem">Điểm HS</b>
                        </td>
                        <td
                        data-toggle="tooltip" title="Thông tin trên CV của ứng viên"
                        data-original-title="Thông tin trên CV của ứng viên"
                        >
                            <b style="font-size:0.7rem">Điểm CV</b>
                        </td>
                        <td
                        data-toggle="tooltip" title="Sàn kế toán đánh giá chất lượng hồ sơ"
                        data-original-title="Sàn kế toán đánh giá chất lượng hồ sơ"
                        >
                            <b style="font-size:0.7rem">Điểm SKT</b>
                        </td>
                        <td
                        data-toggle="tooltip" title="Điểm ứng viên đã tham gia khóa học của sàn kế toán"
                        data-original-title="Điểm ứng viên đã tham gia khóa học của sàn kế toán"
                        >
                            <b style="font-size:0.7rem">Điểm K/HỌC</b>
                        </td>
                        <td
                        data-toggle="tooltip" title="Điểm trung bình các nhà tuyển dụng đánh giá ứng viên"
                        data-original-title="Điểm trung bình các nhà tuyển dụng đánh giá ứng viên"
                        >
                            <b style="font-size:0.7rem">Điểm NTD</b>
                        </td>
                    </tr>
                    <tr>
                        <td class="table_coin_profile_info">${res.employee_profile.profile_info}</td>
                        <td class="table_coin_profile_cv">${res.employee_profile.profile_cv}</td>
                        <td class="td_profile_staff">${res.employee_profile.profile_staff}</td>
                        <td>${res.employee_profile.profile_course}</td>
                        <td>${res.employee_profile.profile_avg}</td>
                    </tr>
                `);
                //check cac trang thai cua de nghi xoa, duyet, theo doi
                if (res.employee_delete_request) {
                    li_delete_request.find('input').prop('checked', true);
                } else {
                    li_delete_request.find('input').prop('checked', false);
                }
                if (res.employee.status_employee == 1) {
                    // li_status_employee.find('input').prop('checked', true);
                    $('#radio_approved').prop('checked', true);
                    $('#radio_un_approved').prop('checked', false);
                } else {
                    $('#radio_un_approved').prop('checked', true);
                    $('#radio_approved').prop('checked', false);
                }
                if (res.staff_follow && res.staff_follow.status_follow == 1) {
                    // li_follow_employee.find('input').prop('checked', true);
                    $('#radio_follow').prop('checked', true);
                    $('#radio_un_follow').prop('checked', false);
                } else {
                    $('#radio_follow').prop('checked', false);
                    $('#radio_un_follow').prop('checked', true);
                }
            }
        })
    })
    //Chức năng gửi phản hồi
    $('.send_response').click(function() {
        let employee_id = $('#detailEmployee').attr('data-employee-id')
        if ($.trim($('#feedback').val()).length === 0) {
            $('.note_text_feedback').hide();
            $('.error_text_feedback').html(
                '<i class="error"><span class="error_reg_mess_icon">Vui lòng nhập phản hồi</span></i>'
            );
            $('.error_reg_mess_icon').css("color", "#ff0000");
            $('.error_border_feedback').css("cssText", "border: 1px solid #ff0000  !important;");
            event.preventDefault();
        }
        let response_content = $('#response_cv textarea').val();
        $.ajax({
            'type': 'get',
            'url': "{{ route('SendFeedbackEmployee') }}",
            'data': {
                employee_id: employee_id,
                feedback: response_content
            },
            'success': function(res) {
                $('#response_cv').modal('hide')
                swal({
                    title: res,
                    icon: "success",
                    button: "Đóng",
                });
            }
        })
    });
    // Chức năng duyệt hồ sơ
    $("input[name='employee_status']").on('change', function() {
        // let checked = 0;
        let checked = $(this).val();
        let employee_id = $('#detailEmployee').attr('data-employee-id')
        // if($(this).is(":checked")){
        //     checked = 1;
        // }
        $.ajax({
            'type': 'get',
            'url': "{{ route('approved_employee') }}",
            'data': {
                employee_id: employee_id,
                status_employee: checked
            },
            'success': function(res) {
                if (res.status == 0) {
                    // $('.ul_action .li_status_employee input').prop('checked', false);
                    $('#radio_approved').prop('checked', false);
                    $('#radio_un_approved').prop('checked', true);
                    $('table.table_info .duyet').html(
                        `<span class="text-danger">Chưa duyệt <i class="fas fa-times-circle"></i></span>`
                    );
                } else {
                    // $('.ul_action .li_status_employee input').prop('checked', true);
                    $('#radio_approved').prop('checked', true);
                    $('#radio_un_approved').prop('checked', false);
                    $('table.table_info .duyet').html(
                        `<span class="text-success">Đã duyệt <i class="fas fa-check-circle"></i></span>`
                    );
                    $('.table_info .td_profile').html(res.profile);
                    $('.table_coin .table_coin_profile_cv').html(res.profile_cv);
                }
                swal({
                    title: res.mess,
                    icon: "success",
                    button: "Đóng",
                });
            }
        })
    })

    // Chức năng theo dõi
    $("input[name='follow_status']").on('change', function() {
        // let checked = 0;
        let checked = $(this).val();
        let employee_id = $('#detailEmployee').attr('data-employee-id')
        $.ajax({
            'type': 'get',
            'url': "{{ route('follow_employee') }}",
            'data': {
                employee_id: employee_id,
                follow_status: checked
            },
            'success': function(res) {
                if (res.follow == 0) {
                    // $('.ul_action .li_follow_employee input').prop('checked', false);
                    $('#radio_follow').prop('checked', false);
                    $('#radio_un_follow').prop('checked', true);
                } else {
                    // $('.ul_action .li_follow_employee input').prop('checked', true);
                    $('#radio_follow').prop('checked', true);
                    $('#radio_un_follow').prop('checked', false);
                }
                swal({
                    title: res.mess,
                    icon: "success",
                    button: "Đóng",
                });
            }
        })
    })
    //Chức năng đánh giá hồ sơ và cho điểm
    $('input[name="coin_profile"]').on('keyup', function() {
        if ($(this).val() > 15 || $(this).val() < 0) {
            $('.error_coin').html(`<p>0 <= Điểm đánh giá <= 15</p>`)
        } else {
            $('.error_coin').html(``)
        }
    });
    $('.send_evaluate').on('click', function() {
        let coin = $('input[name="coin_profile"]').val();
        let content = $('textarea#content_evaluate').val();
        let employee_id = $('#detailEmployee').attr('data-employee-id');
        if ((content.trim()).length == 0) {
            alert('Bạn chưa nhận xét gì cả.');
        }
        if ((coin.trim()).length == 0) {
            alert('Bạn chưa cho điểm.');
        }
        if (coin <= 15 && coin >= 0 && (content.trim()).length != 0 && (coin.trim()).length != 0) {
            $.ajax({
                'type': 'get',
                'url': '{{ route("evaluate_employee") }}',
                'data': {
                    employee_id: employee_id,
                    coin: coin,
                    content: content
                },
                'success': function(res) {
                    swal({
                        title: res.mess,
                        icon: "success",
                        button: "Đóng",
                    });
                    $('input[name="coin_profile"]').val("");
                    $('textarea#content_evaluate').val("");
                    $('.detailEmployee .td_profile').html(`${res.profile}`)
                    $('.detailEmployee .td_profile_staff').html(`${coin}`)
                    $('#evaluate').modal('hide');
                    $(`.td_${employee_id}`).parent().find('.custom_table_td_profile').html(
                        `${res.profile}%`);
                }
            })
        }
    })
    //danh gia lai diem ho so
    $('.calculator_profile').on('click', function() {
        let coin_info = $('.table_coin .table_coin_profile_info').text();
        let coin_cv = $('.table_coin .table_coin_profile_cv').text();
        console.log(coin_info);
        $('#calculator_profile input#profile_info').val(coin_info);
        $('#calculator_profile input#profile_cv').val(coin_cv);
    })
    $('.send_caculator_profile').on('click', function() {
        let profile_info = document.getElementById('profile_info');
        let profile_cv = document.getElementById('profile_cv');
        let employee_id = $('#detailEmployee').attr('data-employee-id')

        if (checkRange(profile_cv, 0, 40) && checkRange(profile_info, 0, 20)) {
            if (profile_info.value == '' && profile_cv.value == '') {
                alert('Chưa có sự thay đổi nào cả.')
            } else {
                $.ajax({
                    'type': 'get',
                    'url': '{{ route("caculator_profile") }}',
                    'data': {
                        employee_id: employee_id,
                        profile_info: profile_info.value,
                        profile_cv: profile_cv.value
                    },
                    'success': function(res) {
                        $('.table_coin_profile_info').html(res.profile_info);
                        $('.table_coin_profile_cv').html(res.profile_cv);
                        $('.td_profile').html(res.profile);
                        $('#calculator_profile').modal('hide')
                        swal({
                            title: res.mess,
                            icon: "success",
                            button: "Đóng",
                        });
                        $(`.td_${employee_id}`).parent().find('.custom_table_td_profile')
                            .html(`${res.profile}%`);
                    }
                })
            }
        }
    })
    // Chức năng tải lại CV
    $('.reload_cv').on('click', function() {
        $(document).ajaxStart(function() {
            $('.loading_cv').css('display', 'block');
        });
        let employee_id = $('#detailEmployee').attr('data-employee-id')
        $.ajax({
            'type': 'get',
            'url': "{{ route('staff_reload_cv') }}",
            'data': {
                employee_id: employee_id
            },
            'beforeSend': function() {
                $('#detailEmployee .col_pdf .show_cv').html('');
                $('.loading_cv').css('display', 'block');
            },
            'success': function(res) {
                if (res.link_cv) {
                    let col_pdf = $('#detailEmployee .col_pdf');
                    let iframe = document.createElement('iframe');
                    iframe.id = 'iframe_cv_employee';
                    iframe.src =
                        `https://docs.google.com/viewer?url=${res.link_cv}&embedded=true`;
                    iframe.loading = 'lazy';
                    iframe.style = 'width:100%;height:97vh;position:absolute;top:0';
                    iframe.frameborder = '0';
                    col_pdf.find('.show_cv').append(iframe);
                } else {
                    col_pdf.find('.show_cv').append('<h3>Ứng viên không có CV</h3>');
                }
            }
        })
    })
});
</script>
<script type="text/javascript" src="/public/assets/js/sweetalert.min.js"></script>
@endsection