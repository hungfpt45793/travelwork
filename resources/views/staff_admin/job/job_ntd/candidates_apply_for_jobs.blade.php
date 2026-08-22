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
                            {{ $jobs->links() }}
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
                            | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '30' }}/{{ $jobs->total() }} bản ghi
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
                                                            <label class="col-md-3 control-label mb-0 mt-2 text-right">Mã tin</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="{{ isset($_GET['job_code']) ? $_GET['job_code'] : '' }}" name="job_code" placeholder="Mã tin..." >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 control-label mb-0 mt-2 text-right">Tên tin</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="{{ isset($_GET['title']) ? $_GET['title'] : '' }}" name="title" placeholder="Tên tin..." >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 control-label mb-0 mt-2 text-right">Tên NTD</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="{{ isset($_GET['enterprise_name']) ? $_GET['enterprise_name'] : '' }}" name="enterprise_name" placeholder="Tên NTD..." >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 control-label mb-0 mt-2 text-right">SĐT NTD</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="{{ isset($_GET['phone']) ? $_GET['phone'] : '' }}" name="phone" placeholder="SĐT NTD..." >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-md-3 control-label mb-0 mt-2 text-right">Loại tin</label>
                                                            <div class="col-md-9">
                                                                <select name="vip" class="select2 form-control">
                                                                    <option value="" @if(isset($_GET['vip']) && $_GET['vip']==="" )selected @endif>--Loại tin--</option>
                                                                    <option value="1" @if(isset($_GET['vip']) && $_GET['vip']==="1") selected @endif>--Tin Vip--</option>
                                                                    <option value="0" @if(isset($_GET['vip']) && $_GET['vip']==="0") selected @endif>--Tin thường--</option>
                                                                </select>
                                                            </div>
                                                        </div>
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
                            <a href="{{ route('candidates_apply_for_jobs') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
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
                                    @foreach ($jobs as $employee)
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
                                            <td scope="col" class="lid_3"><p style="width:65px">Mã tin<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td scope="col" class="lid_4"><p>Tên tin tuyển dụng<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td scope="col" class="lid_5"><p style="width:80px">Lượt xem<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td scope="col" class="lid_6"><p style="width:115px">Lượt nộp hồ sơ<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            <td scope="col" class="lid_7"><p style="width:110px">Ngày đăng tin<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                            <td scope="col" class="lid_7"><p style="width:110px">Hạn đăng tin<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                            <td scope="col" class="lid_7"><p style="width:70px">Loại tin<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                            <td scope="col" class="lid_7"><p>Tên nhà tuyển dụng<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                            <td scope="col" class="lid_7"><p style="width:145px">SĐT nhà tuyển dụng<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jobs as $job)
                                        <tr>
                                            <td class="lid_1">{{ $job->job_id }}</td>
                                            <td class="lid_1">{{ $job->job_code }}</td>
                                            <td class="lid_1 crop">{{ $job->title }}</td>
                                            <td class="lid_1 text-center">{{ $job->views }}</td>
                                            <td class="lid_5">
                                                <p class="crop">
                                                    <a target="_blank" href="{{ route('staff_employee.index') }}?job_id={{$job->job_id}}" class="text-primary">
                                                        @php
                                                            $UV = \App\Entity\Employee_submit_job_faacebook::where('id_job_fb', $job->job_id)->where('status_job', 1)->count();
                                                            echo 'Danh sách UV('.$UV.')';
                                                        @endphp
                                                    </a>
                                                </p>
                                            </td>
                                            <td class="lid_5 text-center">
                                                @php
                                                    $date = date_create($job->date_submit);
                                                    echo date_format($date, "d/m/Y");
                                                @endphp
                                            </td>
                                            <td class="lid_5 text-center">
                                                @php
                                                    $date = date_create($job->date_end);
                                                    echo date_format($date, "d/m/Y");
                                                @endphp
                                            </td>
                                            <td class="lid_6 text-center">
                                                @if ($job->vip == 1)
                                                    <span class="text-danger">Vip</span>
                                                @elseif ($job->vip == 0)
                                                <span class="text-success">Thường</span>
                                                @endif
                                            </td>
                                            <td class="lid_1 crop">{{ $job->enterprise_name }}</td>
                                            <td class="lid_1 text-center">{{ $job->phone }}</td>

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
