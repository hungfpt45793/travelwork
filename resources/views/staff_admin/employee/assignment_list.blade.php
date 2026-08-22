<?php
$num = '';
if(isset($_GET['num'])){
    $num = $_GET['num'];
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
                <div class="contentJobsInteresting col-f14 ">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-start">
                                <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a>
                                <a href="{{ route('assignment_list') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                                <div class="modal fade" id="timkiem" tabindex="-1" role="dialog"
                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <form action="" method="GET">
                                            <?php
                                                $employee_name = isset($_GET['employee_name']) ? $_GET['employee_name'] : '';
                                                $giver_name = isset($_GET['giver_name']) ? $_GET['giver_name'] : '';
                                                $recipient_name = isset($_GET['recipient_name']) ? $_GET['recipient_name'] : '';
                                            ?>
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center" id="exampleModalLongTitle">
                                                        Tìm kiếm báo cáo
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
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
                                                        {{-- tim tên người giao --}}
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-md-3 control-label mb-0 mt-2 text-right">Tên
                                                                người giao</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input name="giver_name"
                                                                        placeholder="Tên người giao"
                                                                        value="@if(!empty($giver_name)){{$giver_name}}@endif"
                                                                        class="form-control" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- tim tên người nhận --}}
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-md-3 control-label mb-0 mt-2 text-right">Tên
                                                                người nhận</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input name="recipient_name"
                                                                        placeholder="Tên người nhận"
                                                                        value="@if(!empty($recipient_name)){{$recipient_name}}@endif"
                                                                        class="form-control" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- chon ngay --}}
                                                        <div class="form-group row mb-0">
                                                            <div class="col-md-6">
                                                                <label for="validationDefault01">Từ ngày(ngày giao)</label>
                                                                @php
                                                                $d=strtotime("-1 Months");
                                                                $date = date("Y-m-d", $d)
                                                                @endphp
                                                                <input class="form-control myDatetime" max="9999-12-31"
                                                                    value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : '' }}"
                                                                    type="date" name="date_search_start">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="validationDefault02">Đến ngày(ngày giao)</label>
                                                                <input class="form-control myDatetime" max="9999-12-31"
                                                                    value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : '' }}"
                                                                    type="date" name="date_search_end">
                                                                <input type="hidden" name="num" value="{{$num}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-dismiss="modal">Đóng</button>
                                                    <button type="submit " class="btn btn-primary btn-sm">Tìm
                                                        kiếm</button>
                                                    <input type="reset" class="btn btn-sm btn-success" value="Làm mới">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="custom-paginate row mt-1 ml-1">
                                @if ($assignment_list_has_not_changed->total() >= $assignment_list_has_changed->total())
                                    {{ $assignment_list_has_not_changed->links() }}
                                @else
                                    {{ $assignment_list_has_changed->links() }}
                                @endif
                                số bản ghi của một trang:
                                <span class="input-submit">
                                    <form action="" class="inline">
                                        <input type="submit" value="200" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
                                        <input type="submit" value="50" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
                                        <input type="submit" value="40" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
                                        <input type="submit" value="30" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
                                        <input type="submit" value="20" name="num"  class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
                                        <input type="submit" value="10" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
                                    </form>
                                </span>
                                | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/
                                @if ($assignment_list_has_not_changed->total() >= $assignment_list_has_changed->total())
                                    {{ $assignment_list_has_not_changed->total() }}
                                @else
                                    {{ $assignment_list_has_changed->total() }}
                                @endif
                                bản ghi
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table id="locker" class="custom-table tableFixHead table-bordered table-striped" data-fl-scrolls style="overflow: scroll;height:100vh;display:block;table-layout:fixed;"></table>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <div class="row">
                                    <div class="col-md-6 border-right border-dark">
                                        <h5>Chưa thay đổi</h5>
                                        <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                            <thead>
                                                <tr>
                                                    <td class="lid_1"><p style="width:32px">ID<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                                    <td class="lid_1"><p style="width:82px">Ngày giao<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                                    <td class="lid_3"><p style="width:91px">Ứng viên<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                                    <td class="lid_2"><p style="width:88px">Người giao<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                                    <td class="lid_4"><p style="width:128px">Người nhận<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                                    <td class="lid_5"><p style="width:61px">%H/Sơ<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                                    <td class="lid_6"><p style="width:71px">T/Thái<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                                    <td colspan="3" class="lid_7"><p style="width:231px">Kết quả<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($assignment_list_has_not_changed as $assignment)
                                                    <tr>
                                                        <td class="lid_1">{{ $assignment->task_detail_id }}</td>
                                                        <td class="lid_1">
                                                            @php
                                                                $date=date_create($assignment->giver_day);
                                                                echo date_format($date,"d/m/Y");
                                                            @endphp
                                                        </td>
                                                        <td class="lid_2 crop">{{ $assignment->employee_name }}</td>
                                                        <td class="lid_3 crop">{{ $assignment->giver_name }}</td>
                                                        <td class="lid_4 crop">{{ $assignment->recipient_name }}</td>
                                                        <td class="lid_5 text-center">{{ $assignment->profile_td }}%</td>
                                                        <td class="lid_6">
                                                            @if($assignment->approved == 0)
                                                                <span class="text-danger">Chưa duyệt</span>
                                                            @else
                                                                <span class="text-success">Đã duyệt</span>
                                                            @endif
                                                        </td>
                                                        <td class="lid_7 text-center">{{ $assignment->profile_result }}%</td>
                                                        <td class="lid_8 crop">
                                                            @if($assignment->status_employee == 0)
                                                                <span class="text-danger">Chưa duyệt</span>
                                                            @else
                                                                <span class="text-success">Đã duyệt</span>
                                                            @endif
                                                        </td>
                                                        <td class="lid_9 crop">
                                                            @if ($assignment->removed == 0)
                                                                <span class="text-danger">Không loại</span>
                                                            @else
                                                                <span class="text-success">Loại</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Đã thay đổi</h5>
                                        <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                            <thead>
                                                <tr>
                                                    <td class="lid_1"><p style="width:32px">ID<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                                    <td class="lid_1"><p style="width:82px">Ngày giao<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                                    <td class="lid_3"><p style="width:91px">Ứng viên<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                                    <td class="lid_2"><p style="width:88px">Người giao<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                                    <td class="lid_4"><p style="width:128px">Người nhận<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                                    <td class="lid_5"><p style="width:61px">%H/Sơ<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                                    <td class="lid_6"><p style="width:71px">T/Thái<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                                    <td colspan="3" class="lid_7"><p style="width:231px">Kết quả<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($assignment_list_has_changed as $assignment)
                                                    <tr>
                                                        <td class="lid_1">{{ $assignment->task_detail_id }}</td>
                                                        <td class="lid_1">
                                                            <?php
                                                                $date=date_create($assignment->giver_day);
                                                                echo date_format($date,"d/m/Y");
                                                            ?>
                                                        </td>
                                                        <td class="lid_2 crop">{{ $assignment->employee_name }}</td>
                                                        <td class="lid_3 crop">{{ $assignment->giver_name }}</td>
                                                        <td class="lid_4 crop">{{ $assignment->recipient_name }}</td>
                                                        <td class="lid_5 text-center">{{ $assignment->profile_td }}%</td>
                                                        <td class="lid_6">
                                                            @if($assignment->approved == 0)
                                                                <span class="text-danger">Chưa duyệt</span>
                                                            @else
                                                                <span class="text-success">Đã duyệt</span>
                                                            @endif
                                                        </td>
                                                        {{-- kết quả --}}
                                                        <td class="lid_7 text-center">{{ $assignment->profile_result }}%</td>
                                                        <td class="lid_8 crop">
                                                            @if($assignment->status_employee == 0)
                                                                <span class="text-danger">Chưa duyệt</span>
                                                            @else
                                                                <span class="text-success">Đã duyệt</span>
                                                            @endif
                                                        </td>
                                                        <td class="lid_9 crop">
                                                            @if ($assignment->removed == 0)
                                                                <span class="text-danger">Không loại</span>
                                                            @else
                                                                <span class="text-success">Loại</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
@endsection
