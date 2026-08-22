@extends('staff_admin.layouts.master')
@section('title', 'Danh sách đơn hàng tuyển dụng' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.order')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if (session('danger'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting col-f14 ">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="">
                                <a class="btn btn-sm btn-secondary mr-1 text-white" data-toggle="modal"
                                    data-target="#timkiem"><i class="fas fa-search text-primary"></i> Tìm</a>
                                <div class="modal fade" id="timkiem" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                        <form action="" style="width:100%;height:100%">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm đơn hàng
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">

                                                        {{-- tim trang thai uv --}}
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-md-3 control-label mb-0 mt-2 text-right">Trạng
                                                                thái TT(1)</label>
                                                            <div class="col-md-9">
                                                                <select name="advance_status_pay"
                                                                    class="select2 form-control">
                                                                    <option value=""
                                                                        @if(isset($_GET['advance_status_pay']) &&
                                                                        $_GET['advance_status_pay']=="" )selected
                                                                        @endif>
                                                                        --Trạng thái--</option>
                                                                    <option value="0"
                                                                        @if(isset($_GET['advance_status_pay']) &&
                                                                        $_GET['advance_status_pay']==0) selected
                                                                        @endif>
                                                                        --Chưa thanh toán--</option>
                                                                    <option value="1"
                                                                        @if(isset($_GET['advance_status_pay']) &&
                                                                        $_GET['advance_status_pay']==1) selected
                                                                        @endif>
                                                                        --Đã thanh toán--</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-md-3 control-label mb-0 mt-2 text-right">Trạng
                                                                thái TT(2)</label>
                                                            <div class="col-md-9">
                                                                <select name="all_status_pay"
                                                                    class="select2 form-control">
                                                                    <option value=""
                                                                        @if(isset($_GET['all_status_pay']) &&
                                                                        $_GET['all_status_pay']=="" )selected
                                                                        @endif>
                                                                        --Trạng thái--</option>
                                                                    <option value="0"
                                                                        @if(isset($_GET['all_status_pay']) &&
                                                                        $_GET['all_status_pay']==0) selected
                                                                        @endif>
                                                                        --Chưa thanh toán--</option>
                                                                    <option value="1"
                                                                        @if(isset($_GET['all_status_pay']) &&
                                                                        $_GET['all_status_pay']==1) selected
                                                                        @endif>
                                                                        --Đã thanh toán--</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        {{-- tim ten uv --}}
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-md-3 control-label mb-0 mt-2 text-right">Tên
                                                                nhà tuyển dụng</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <select name="employer_id" id="select2_employer"
                                                                        class="">
                                                                        <option value="">--Chọn nhà tuyển dụng--
                                                                        </option>
                                                                        <?php
                                                                        if(!empty($_GET['employer_id']))
                                                                        {
                                                                            $employer = \App\Entity\Employer::select(
                                                                                'enterprise_name','employer_id','email'
                                                                            )
                                                                            ->where('employer_id', $_GET['employer_id'])->first();
                                                                            echo 
                                                                            '<option selected value="'.$employer->employer_id.'">'.
                                                                            $employer->enterprise_name.'-'.$employer->email.'
                                                                            </option>';
                                                                        }
                                                                    ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- chon ngay --}}
                                                        <div class="form-group row mb-0">
                                                            <div class="col-md-6">
                                                                <label for="validationDefault01">Từ ngày tạo</label>
                                                                @php
                                                                $d=strtotime("-1 Months");
                                                                $date = date("Y-m-d", $d)
                                                                @endphp
                                                                <input class="form-control myDatetime" max="9999-12-31"
                                                                    value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : '' }}"
                                                                    type="date" name="date_search_start">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="validationDefault02">Đến ngày tạo</label>
                                                                <input class="form-control myDatetime" max="9999-12-31"
                                                                    value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : '' }}"
                                                                    type="date" name="date_search_end">
                                                                <input type="hidden" name="num"
                                                                    value="{{ isset($_GET['num']) ? $_GET['num'] : '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit " class="btn btn-primary btn-sm">Tìm kiếm</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <a href="{{ route('request_orders_deleted') }}"
                                    class="btn btn-sm btn-secondary mr-1 text-white"><i
                                        class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                            </div>
                            <div class="custom-paginate row mt-1 ml-1">
                                {{ $order_requests->links() }}
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
                                | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $order_requests->total() }}
                                bản
                                ghi
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped"
                                style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" id="master"></p>
                                    </div>
                                    @foreach ($order_requests as $key => $order_request)
                                    <div class="cellWrap">
                                        <input type="checkbox" class="sub_chk"
                                            data-id="{{ $order_request->order_request_id }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped"
                                    style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <td class="lid_1">
                                                <p style="width:70px">Mã ĐH<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_1">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_2">
                                                <p style="width:90px">Ngày tạo<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_2">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_3">
                                                <p style="width:120px"><i class="fas fa-cog"></i><button
                                                        class="lockButton btn btn-sm btn-success" id="lid_3">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_4">
                                                <p style="width:70px">Giá<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_4">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_5">
                                                <p style="width:110px">Giá sau giảm<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_5">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_6">
                                                <p style="width:140px">Trạng thái TT(L1)<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_6">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_7">
                                                <p style="width:140px">Trạng thái TT(L2)<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_7">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_8">
                                                <p style="width:120px">Hạn B/Hành<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_8">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_9">
                                                <p style="width:140px">Thời gian bắt đầu<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_9">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_10">
                                                <p style="width:200px">NTDụng<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_10">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_11">
                                                <p style="width:110px">Đơn Đặt hàng<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_11">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_12">
                                                <p style="width:150px">Vị trí TD<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_12">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_13">
                                                <p style="width:110px">Thời gian TD<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_13">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_14">
                                                <p style="width:110px">Mô tả<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_14">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_15">
                                                <p style="width:110px">Yêu cầu<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_15">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_16">
                                                <p style="width:110px">Phúc lợi xã hội<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_16">L</button>
                                                </p>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order_requests as $key => $order_request)
                                        <tr>
                                            <td class="lid_1">
                                                {{ $order_request->order_request_code }}
                                            </td>
                                            <td class="lid_2">
                                                @php
                                                if($order_request->created_at)
                                                {
                                                $date = date_create($order_request->created_at);
                                                echo date_format($date,"d/m/Y");
                                                }
                                                @endphp
                                            </td>
                                            <td class="lid_3">
                                                <a href="{{ route('restore_request_orders_deleted', $order_request->order_request_id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    Khôi phục
                                                </a>
                                                <a href="{{ route('request_orders_deleted_force', $order_request->order_request_id) }}" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </td>
                                            <td class="lid_4">
                                                <b class="float-right align-middle">
                                                    {{ number_format($order_request->order_request_price, 0, '', ',') }}
                                                </b>
                                            </td>
                                            <td class="lid_5">
                                                <b class="float-right align-middle">
                                                    {{ number_format($order_request->order_request_discount, 0, '', ',') }}
                                                </b>
                                            </td>
                                            <td class="lid_6">
                                                @if ($order_request->advance_status_pay == 1)
                                                <i class="fa fa-check text-success"></i> Đã thanh toán
                                                @else
                                                <i class="fa fa-times text-danger"></i> Chưa thanh toán
                                                @endif
                                            </td>
                                            <td class="lid_7">
                                                @if ($order_request->all_status_pay == 1)
                                                <i class="fa fa-check text-success"></i> Đã thanh toán
                                                @else
                                                <i class="fa fa-times text-danger"></i> Chưa thanh toán
                                                @endif
                                            </td>
                                            <td class="lid_8">
                                                {{ $order_request->guarantee_time }}
                                            </td>
                                            <td class="lid_9">
                                                @php
                                                if($order_request->start_time)
                                                {
                                                $start_time = date_create($order_request->start_time);
                                                echo date_format($start_time,"d/m/Y");
                                                }
                                                @endphp
                                            </td>
                                            <td class="lid_10">
                                                <div class="crop" style="width:200px">
                                                    <?php
                                                        $employer_name = \App\Entity\Employer::where('employer_id', $order_request->employer_id)->value('enterprise_name')
                                                    ?>
                                                    <a
                                                        href="{{ route('detail_employer_with_staff_admin', $order_request->employer_id) }}">{{ $employer_name }}</a>
                                                </div>
                                            </td>
                                            <td class="lid_11">
                                                @if(!empty($order_request->hunter_regis_id))
                                                <div class="crop" style="width:50px">
                                                    <a target="_blank"
                                                        href="{{ route('staff_hunter_order.edit', $order_request->hunter_regis_id) }}">Link</a>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="lid_12">
                                                <div class="crop" style="width:150px">{{$order_request->hunter_pos}}</div>
                                            </td>
                                            <td class="lid_13">
                                                <div class="crop" style="width:110px">{{$order_request->hunter_time}}</div>
                                            </td>
                                            <td class="lid_14">
                                                @if(!empty($order_request->job_description))
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#job_description">
                                                    Mô tả
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="job_description" tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel"> Mô tả công việc</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {!! $order_request->job_description !!}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Đóng</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="lid_15">
                                            @if(!empty($order_request->job_requirements))
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#job_requirements">
                                                    Yêu cầu
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="job_requirements" tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Yêu cầu công việc</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {!! $order_request->job_requirements !!}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Đóng</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="lid_16">
                                                @if(!empty($order_request->welfare))
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#welfare">
                                                    Yêu cầu
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="welfare" tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Phúc lợi xã hội</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>  
                                                            <div class="modal-body">
                                                                {!! $order_request->welfare !!}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Đóng</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
@include('staff_admin.partials.popup_delete')
@endsection