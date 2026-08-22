<?php
    $num = '';
    if(isset($_GET['num'])){
        $num = $_GET['num'];
    }
?>
@extends('staff_admin.layouts.master')
@section('title', 'Chi tiết ứng viên nộp hồ sơ' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.report')
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
                            {{ $employees_submit_ntd->links() }}
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
                            | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '30' }}/{{ $employees_submit_ntd->total() }} bản ghi
                        </div>
                        <div class="d-flex justify-content-between second-order" style="width:-webkit-fill-available">
                            <div>
                            <a href="{{ route('application_details_ntd') }}" class="btn btn-sm btn-success mr-1 text-white">Làm tươi</a>
                            <button type="button" class="btn btn-primary mr-1 btn-sm" data-toggle="modal" data-target="#timkiem">Tìm</button>
                            <div class="modal fade" id="timkiem" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <form action="" method="GET">
                                    <?php
                                        $employee_name = isset($_GET['employee_name']) ? $_GET['employee_name'] : '';
                                        $title = isset($_GET['title']) ? $_GET['title'] : '';
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

                                                <div class="form-group row">
                                                    <label
                                                        class="col-md-3 control-label mb-0 mt-2 text-right">Tên ứng viên</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <input name="employee_name" placeholder="Tên ứng viên" value="@if(!empty($employee_name)){{$employee_name}}@endif" class="form-control" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label
                                                        class="col-md-3 control-label mb-0 mt-2 text-right">Công việc</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <input name="title" placeholder="Công việc" value="@if(!empty($title)){{$title}}@endif" class="form-control" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- chon ngay --}}
                                                <div class="form-group row mb-0">
                                                    <div class="col-md-6">
                                                        <label for="validationDefault01">Từ ngày(Ngày nộp hồ sơ)</label>
                                                        <input class="form-control myDatetime" max="9999-12-31"
                                                            value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : '' }}"
                                                            type="date" name="date_search_start">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="validationDefault02">Đến ngày(Ngày nộp hồ sơ)</label>
                                                        <input class="form-control myDatetime" max="9999-12-31"
                                                            value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : '' }}"
                                                            type="date" name="date_search_end">
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
                                    @foreach ($employees_submit_ntd as $employee)
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
                                                <td scope="col" class="lid_1"><p style="width:50px">ID<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                                <td scope="col" class="lid_2"><p style="width:80px">Ứng viên<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                                <td scope="col" class="lid_5"><p style="width:119px">Ngày nộp hồ sơ<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                                <td scope="col" class="lid_3"><p style="width:112px">Công việc<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                                <td scope="col" class="lid_4"><p style="width:101px">Slug<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employees_submit_ntd as $employee)
                                            <tr>
                                                <td scope="row" class="lid_1">{{ $employee->submit_job_fb_id }}</td>
                                                <td class="lid_2">
                                                    <span class="crop">
                                                        {{ $employee->employee_name }}
                                                    </span>
                                                </td>
                                                <td class="lid_5">
                                                    <?php
                                                        $date=date_create($employee->day_submit_job);
                                                        echo date_format($date,"d/m/Y");
                                                    ?>
                                                </td>
                                                <td class="lid_3">
                                                    <span class="crop">
                                                        {{ $employee->title }}
                                                    </span>
                                                </td>
                                                <td class="lid_4">
                                                    <p class="crop">
                                                        <a target="_blank" href="{{ route('job_detail', $employee->slug) }}">{{ $employee->title }}</a>
                                                    </p>
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
        </div>
    </div>
</div>
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
