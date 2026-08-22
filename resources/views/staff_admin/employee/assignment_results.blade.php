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
                                <a href="{{ route('assignment_results') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                                <div class="modal fade" id="timkiem" tabindex="-1" role="dialog"
                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <form action="" method="GET">
                                            <?php
                                                $mon_yea = isset($_GET['mon_yea']) ? $_GET['mon_yea'] : '';
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
                                                        {{-- tim tháng và năm --}}
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-md-3 control-label mb-0 mt-2 text-right">Chọn tháng/năm</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="month" class="form-control" id="mon_yea"  name="mon_yea" value="@if(!empty($mon_yea)){{$mon_yea}}@endif" min="2021-01" max="9999-12">
                                                                </div>
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
                                {{ $results->links() }}
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
                                | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/ {{ $results->total() }} bản ghi
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="tableFixHead">
                                <table data-fl-scrolls class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <td class="text-center px-4 py-2">Ngày giao</td>
                                            <td class="p-0">
                                                <table class="table_in_table text-center"  style="width: 100%">
                                                    <tr>
                                                        <td class="px-4 py-2" style="width:19%">Người nhận</td>
                                                        <td class="px-4 py-2" style="width:13%">Số lượng UV</td>
                                                        <td class="px-4 py-2" style="width:11%">Đã duyệt</td>
                                                        <td class="px-4 py-2" style="width:20%">T/Đổi, Chưa duyệt</td>
                                                        <td class="px-4 py-2" style="width:22%">Chưa T/Đổi, Chưa duyệt</td>
                                                        <td class="px-4 py-2" style="width:9%">Đã loại</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $key => $date)
                                            <tr>
                                                <td class="text-center align-middle px-4 py-2">
                                                    @php
                                                        $giver_day=date_create($key);
                                                        echo date_format($giver_day,"d/m/Y");
                                                    @endphp
                                                </td>
                                                <td class="p-0 text-center">
                                                    @php
                                                        $date = $date->groupBy('recipient_id');
                                                    @endphp
                                                    <table class="table_in_table" style="width: 100%">
                                                        @foreach($date as $day)
                                                        @php
                                                            $da_duyet = $day->where('status_employee', 1);

                                                            $thay_doi = $day->filter(function ($value, $key)
                                                            {
                                                                if ($value->hs_td != $value->hs_e) {
                                                                    return $value->hs_td != $value->hs_e;
                                                                }
                                                                if ($value->removed == 1) {
                                                                    return $value->removed == 1;
                                                                }
                                                            });

                                                            $thay_doi_chua_duyet = $thay_doi->where('status_employee', 0);

                                                            $chua_thay_doi_chua_duyet = $day->where('status_employee', 0)->where('removed', null)->filter(function ($value, $key)
                                                            {
                                                                return $value->hs_td == $value->hs_e;
                                                            });

                                                            $da_loai = $day->where('removed', 1);
                                                        @endphp
                                                        <tr>
                                                            <td class="text-left" style="width:19%">
                                                                <?php
                                                                    echo \App\Entity\Staff::where('staff_id', $day[0]->recipient_id)->value('staff_name');
                                                                ?>
                                                            </td>
                                                            <td style="width:13%">{{ count($day) }}</td>
                                                            <td style="width:11%">{{ count($da_duyet) }}</td>
                                                            <td style="width:20%">{{ count($thay_doi_chua_duyet) }}</td>
                                                            <td style="width:22%">{{ count($chua_thay_doi_chua_duyet) }}</td>
                                                            <td style="width:9%">{{ count($da_loai) }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </table>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
