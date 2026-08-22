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
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
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
                                <a class="btn btn-sm btn-success mr-1 text-white"
                                    href="{{ route('staff_order_job.create') }}">Thêm mới</a>
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
                                                                <select name="order_job_statu_pay"
                                                                    class="select2 form-control">
                                                                    <option value=""
                                                                        @if(isset($_GET['order_job_statu_pay']) &&
                                                                        $_GET['order_job_statu_pay']=="" )selected
                                                                        @endif>
                                                                        --Trạng thái--</option>
                                                                    <option value="0"
                                                                        @if(isset($_GET['order_job_statu_pay']) &&
                                                                        $_GET['order_job_statu_pay']==0) selected
                                                                        @endif>
                                                                        --Chưa thanh toán--</option>
                                                                    <option value="1"
                                                                        @if(isset($_GET['order_job_statu_pay']) &&
                                                                        $_GET['order_job_statu_pay']==1) selected
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
                                                                <select name="order_job_status_pay_all"
                                                                    class="select2 form-control">
                                                                    <option value=""
                                                                        @if(isset($_GET['order_job_status_pay_all']) &&
                                                                        $_GET['order_job_status_pay_all']=="" )selected
                                                                        @endif>
                                                                        --Trạng thái--</option>
                                                                    <option value="0"
                                                                        @if(isset($_GET['order_job_status_pay_all']) &&
                                                                        $_GET['order_job_status_pay_all']==0) selected
                                                                        @endif>
                                                                        --Chưa thanh toán--</option>
                                                                    <option value="1"
                                                                        @if(isset($_GET['order_job_status_pay_all']) &&
                                                                        $_GET['order_job_status_pay_all']==1) selected
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
                                <a href="{{ route('staff_order_job.index') }}"
                                    class="btn btn-sm btn-secondary mr-1 text-white"><i
                                        class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                            </div>
                            <div class="custom-paginate row mt-1 ml-1">
                                {{ $order_jobs->links() }}
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
                                | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $order_jobs->total() }}
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
                                    @foreach ($order_jobs as $key => $order_job)
                                    <div class="cellWrap">
                                        <input type="checkbox" class="sub_chk"
                                            data-id="{{ $order_job->order_job_id }}">
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
                                                <p style="width:140px">Ngày KH bảo hành<button
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
                                                <p style="width:110px">Yêu cầu ĐH<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_12">L</button>
                                                </p>
                                            </td>
                                            <td class="lid_14">
                                                <p style="width:200px">Mô tả<button
                                                        class="lockButton btn btn-sm btn-success" id="lid_14">L</button>
                                                </p>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order_jobs as $key => $order_job)
                                        <tr>
                                            <td class="lid_1">
                                                {{ $order_job->order_job_code }}
                                            </td>
                                            <td class="lid_2">
                                                @php
                                                if($order_job->created_at)
                                                {
                                                $date = date_create($order_job->created_at);
                                                echo date_format($date,"d/m/Y");
                                                }
                                                @endphp
                                            </td>
                                            <td class="lid_3">
                                                <a href="{{ route('restore_job_orders_deleted', $order_job->order_job_id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    Khôi phục
                                                </a>
                                                <a href="{{ route('job_orders_deleted_force', $order_job->order_job_id) }}" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </td>
                                            <td class="lid_4">
                                                <b class="float-right align-middle">
                                                    {{ number_format($order_job->order_job_price, 0, '', ',') }}
                                                </b>
                                            </td>
                                            <td class="lid_5">
                                                <b class="float-right align-middle">
                                                    {{ number_format($order_job->order_job_discount, 0, '', ',') }}
                                                </b>
                                            </td>
                                            <td class="lid_6">
                                                @if ($order_job->order_job_statu_pay == 1)
                                                <i class="fa fa-check text-success"></i> Đã thanh toán
                                                @else
                                                <i class="fa fa-times text-danger"></i> Chưa thanh toán
                                                @endif
                                            </td>
                                            <td class="lid_7">
                                                @if ($order_job->order_job_status_pay_all == 1)
                                                <i class="fa fa-check text-success"></i> Đã thanh toán
                                                @else
                                                <i class="fa fa-times text-danger"></i> Chưa thanh toán
                                                @endif
                                            </td>
                                            <td class="lid_8">
                                                {{ $order_job->order_job_guarantee }}
                                            </td>
                                            <td class="lid_9">
                                                @php
                                                if($order_job->order_job_guarantee_date)
                                                {
                                                $order_job_guarantee_date = date_create($order_job->order_job_guarantee_date);
                                                echo date_format($order_job_guarantee_date,"d/m/Y");
                                                }
                                                @endphp
                                            </td>
                                            <td class="lid_10">
                                                <div class="crop" style="width:200px">
                                                    <?php
                                                        $employer_name = \App\Entity\Employer::where('employer_id', $order_job->employer_id)->value('enterprise_name')
                                                    ?>
                                                    <a
                                                        href="{{ route('detail_employer_with_staff_admin', $order_job->employer_id) }}">{{ $employer_name }}</a>
                                                </div>
                                            </td>
                                            <td class="lid_11">
                                                @if(!empty($order_job->hunter_regis_id))
                                                <div class="crop" style="width:50px">
                                                    <a target="_blank"
                                                        href="{{ route('staff_hunter_order.edit', $order_job->hunter_regis_id) }}">Link</a>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="lid_12">
                                                @if(!empty($order_job->order_request_id))
                                                <div class="crop" style="width:50px">
                                                    <a target="_blank"
                                                        href="{{ route('staff_order_request.edit', $order_job->order_request_id) }}">Link</a>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="lid_14">
                                                @if(!empty($order_job->order_job_des))
                                                <div type="button" data-toggle="modal"
                                                    data-target="#job_description{{$order_job->order_job_code}}">
                                                    <div class="crop" style="width:200px">{!! $order_job->order_job_des !!}</div>
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="job_description{{$order_job->order_job_code}}" tabindex="-1" role="dialog"
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
                                                                {!! $order_job->order_job_des !!}
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