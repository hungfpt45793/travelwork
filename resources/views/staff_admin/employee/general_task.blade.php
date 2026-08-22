<?php
$num = '';
if(isset($_GET['num'])){
    $num = $_GET['num'];
}
?>
@extends('staff_admin.layouts.master')

@section('title', 'Tổng hợp giao việc' )
<style>
    .table_in_table tr:first-child td{
        border-top:none;
    }
    .table_in_table tr:last-child td{
        border-bottom:none;
    }
    .table_in_table tr td:first-child{
        border-left:none;
    }
    .table_in_table tr td:last-child{
        border-right:none;
    }
</style>
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
                            {{ $array_date->links() }}
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
                            | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}
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
                                        $recipient_id = isset($_GET['recipient_id']) ? $_GET['recipient_id'] : '';
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
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                    {{-- tim nguoi nhan --}}
                                                    <?php
                                                            $staffs = \App\Entity\Staff::select('staff_id', 'staff_name')->get();
                                                        ?>
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
                                                            {{-- chon ngay giao --}}
                                                        <div class="form-group row mb-0">
                                                            <div class="col-md-6">
                                                                <label for="validationDefault01">Từ ngày giao</label>
                                                                <input class="form-control myDatetime" max="9999-02-20T12:30:55"
                                                                    value="{{ isset($_GET['giver_day_start']) ? $_GET['giver_day_start'] : '' }}"
                                                                    type="date" name="giver_day_start">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="validationDefault02">Đến ngày giao</label>
                                                                <input class="form-control myDatetime" max="9999-02-20T12:30:55"
                                                                    value="{{ isset($_GET['giver_day_end']) ? $_GET['giver_day_end'] : '' }}"
                                                                    type="date" name="giver_day_end">
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
                                <a href="{{ route('general_task') }}"
                                    class="btn btn-sm btn-success mr-1 text-white">Làm tươi</a>
                            </div>
                            <!-- form tim kiem theo id uv -->
                            <div class="col-xs-12">
                            </div>
                        </div>
                    </div>
                    <div class="row mr-1">
                        <div class="col-md-12">
                            <div class="tableFixHead">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <td class="text-center"><b>Ngày giao việc</b></td>
                                        <td style="padding:0">
                                            <table class="table_in_table" style="width:100%">
                                                <tr>
                                                    <td class="text-center" style="width:70%"><b>Nhân viên nhận</b></td>
                                                    <td class="text-center"><b>Số lượng uv</b></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </thead>
                                @foreach($array_date as $key => $date)
                                <?php $date = $date->groupBy('recipient_id'); ?>
                                <tr>
                                    <td class="text-center align-middle">
                                        <?php
                                        $giver_day=date_create($key);
                                        echo date_format($giver_day,"d/m/Y");
                                        ?>
                                    </td>
                                    <td class="text-center" style="padding:0">
                                        <table class="table_in_table" style="width:100%">
                                            @foreach($date as $day)
                                            <tr>
                                                <td  style="width:70%">
                                                    <?php
                                                        echo \App\Entity\Staff::where('staff_id', $day[0]->recipient_id)->value('staff_name');
                                                    ?>
                                                </td>
                                                <td class="text-center">{{ count($day) }}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
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
@endsection
