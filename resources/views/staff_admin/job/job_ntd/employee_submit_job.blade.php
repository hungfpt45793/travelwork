<?php
    $num = '';
    if(isset($_GET['num'])){
        $num = $_GET['num'];
    }
    $employee_name = '';
    if (isset($_GET['employee_name'])) {
        $employee_name = $_GET['employee_name'];
    }
    $title_job = '';
    if (isset($_GET['title_job'])) {
        $title_job = $_GET['title_job'];
    }
    $title_job_fb = '';
    if (isset($_GET['title_job_fb'])) {
        $title_job_fb = $_GET['title_job_fb'];
    }
?>
@extends('staff_admin.layouts.master')
@section('title', 'Danh sách ứng viên nộp hồ sơ' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.job')
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
                        <div class="custom-paginate first-order ml-1 mt-1 row">
                            {{ $submit_job->links() }}
                            số bản ghi của một trang:
                            <span class="input-submit">
                                <form action="" class="inline">
                                    <input type="submit" value="200" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
                                    <input type="submit" value="50" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
                                    <input type="submit" value="40" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
                                    <input type="submit" value="30" name="num" class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
                                    <input type="submit" value="20" name="num"  class="{{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
                                    <input type="submit" value="10" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
                                </form>
                            </span>
                            | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '30' }}/{{ $submit_job->total() }} bản ghi
                        </div>
                        <div class="d-flex justify-content-between second-order" style="width:-webkit-fill-available">
                            <div>
                            <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a>
                            <div class="modal fade" id="timkiem" tabindex="-1" role="dialog"
                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <form action="" method="GET">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center" id="exampleModalLongTitle">Tìm kiếm</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <div class="form-group row">
                                                            <label class="col-md-3 control-label mb-0 mt-2 text-right">Tên ứng viên</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="{{ !empty($employee_name) ? $employee_name : '' }}" name="employee_name" placeholder="Tên ứng viên..." >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(!empty(url()->current() == route('employee_submit_job_ntd')))
                                                        <div class="form-group row">
                                                            <label class="col-md-3 control-label mb-0 mt-2 text-right">Tên công việc</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="{{ !empty($title_job) ? $title_job : '' }}" name="title_job" placeholder="Tên công việc..." >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if(!empty(url()->current() == route('employee_submit_job_fb')))
                                                        <div class="form-group row">
                                                            <label class="col-md-3 control-label mb-0 mt-2 text-right">Tên công việc</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="{{ !empty($title_job_fb) ? $title_job_fb : '' }}" name="title_job_fb" placeholder="Tên công việc..." >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Đóng</button>
                                                    <button type="submit " class="btn btn-primary btn-sm">Tìm kiếm</button>
                                                    <input type="reset" class="btn btn-sm btn-success" value="Làm mới">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <a href="{{ route('courseOrder.index') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                            {{-- <a href="{{ route('courseOrder.create') }}" class="btn btn-sm btn-success mr-1 text-white">Thêm mới</a> --}}
                            </div>
                            <!-- form tim kiem theo id kh -->
                            <div>
                                <form action="" class="">
                                    <div class="group-form border border-primary">
                                        <input class="border-0 input-lg" type="text"
                                            name="course_id" style="width:83px"
                                            value="{{ (!empty($_GET['course_id'])) ? $_GET['course_id'] : ''  }}"
                                            placeholder="ID Hồ sơ">
                                        <button class="search border-0" type="submit"><i class="fa fa-search "
                                                aria-hidden="true"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row mr-1">
                        <div class="col-md-12">
                            <div id="locker" data-fl-scrolls class="custom-table table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                    </div>
                                    @foreach ($submit_job as $employee)
                                    <div class="cellWrap">
                                        <input type="checkbox" id_customer="{{$employee->course_id}}" class="checkItem" name="list_id[]"
                                        value="{{$employee->course_id}}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                                <div class="table-wrapper tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table  data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <td scope="col" class="lid_1"><p style="width:33px">ID<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td scope="col" class="lid_3"><p style="width:105px">Ngày đăng ký<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td scope="col" class="lid_4"><p style="width:150px">Ứng viên<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>

                                            <td scope="col" class="lid_5"><p style="width:370px">Tên công việc<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>

                                            <td scope="col" class="lid_6"><p style="width:220px">Sơ yếu lý lịch<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            <td scope="col" class="lid_7"><p style="width:95px">Đơn xin việc<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($submit_job as $order)
                                        <tr>
                                            <td scope="row" class="lid_1">{{ $order->submit_job_fb_id }}</td>
                                            <td class="lid_5 text-center">
                                                @php
                                                    $date = date_create($order->day_submit_job);
                                                    echo date_format($date, "d/m/Y");
                                                @endphp
                                            </td>
                                            <td class="lid_5 text-center">
                                                <span class="crop">
                                                    <a target="_blank" href="{{ route('staff_employee.show', $order->employee_id) }}">{{ $order->employee_name }}</a>
                                                </span>
                                            </td>
                                            @if(!empty(url()->current() == route('employee_submit_job_ntd')))
                                            <td class="lid_2">
                                                <span class="crop">
                                                    {{ $order->title_job }}
                                                </span>
                                            </td>
                                            @endif
                                            @if(!empty(url()->current() == route('employee_submit_job_fb')))
                                            <td class="lid_2">
                                                <span class="crop">
                                                    {{ $order->title_job_fb }}
                                                </span>
                                            </td>
                                            @endif
                                            <td class="lid_6 text-center">
                                                @if ($order->status_syll == 1)
                                                    Cho phép xem sơ yếu lý lịch
                                                @elseif ($order->status_syll == 0)
                                                    Không cho phép xem sơ yếu lý lịch
                                                @endif
                                            </td>
                                            <td>
                                                <a class="interactive" data-job-id="{{ $order->submit_job_fb_id }}" data-toggle="modal" data-target="#interactive">
                                                    <p class="crop text-primary text-center">
                                                        Xem
                                                    </p>
                                                </a>
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
            <div class="modal fade" id="interactive" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nội dung đơn</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped">
                                <tbody class="foreach_interactive">

                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#interactive').on('hidden.bs.modal', function (e) {
        $('#interactive .foreach_interactive').html('')
    })
    $('.interactive').on('click', function() {
        var job_id = $(this).data('job-id')
        $.ajax({
            'type': 'get',
            'url': "{{ route('show_modal_interactive_job') }}",
            'data': {
                job_id
            },
            'success': (req) => {
                let html =''
                req.forEach(element => {
                    html += `
                        ${element.job_app_content}
                    `
                });
                $('#interactive .foreach_interactive').html(html)
            }
        })
    })
</script>
    <script>
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

    $('#checkAllSendMail').click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>
@endsection
