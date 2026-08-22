<?php
$num = '';
if (isset($_GET['num'])) {
    $num = $_GET['num'];
}
//2
$date_search_start = '';
if (isset($_GET['date_search_start'])) {
    $date_search_start = $_GET['date_search_start'];
}
//3
$date_search_end = '';
if (isset($_GET['date_search_end'])) {
    $date_search_end = $_GET['date_search_end'];
}
//4
$career_category_id = '';
if (isset($_GET['career_category_id'])) {
    $career_category_id = $_GET['career_category_id'];
}
//5
$employer_name = '';
if (isset($_GET['employer_name'])) {
    $employer_name = $_GET['employer_name'];
}
//6
$title = '';
if (isset($_GET['title'])) {
    $title = $_GET['title'];
}
//7
$literacy = '';
if (isset($_GET['literacy'])) {
    $literacy = $_GET['literacy'];
}
//8
$active_job = '';
if (isset($_GET['active_job'])) {
    $active_job = $_GET['active_job'];
}
//9
$province = '';
if (isset($_GET['province'])) {
    $province = $_GET['province'];
}
//10
$email = '';
if (isset($_GET['email'])) {
    $email = $_GET['email'];
}
//11
$district = '';
if (isset($_GET['district'])) {
    $district = $_GET['district'];
}
//12
$vip = '';
if (isset($_GET['vip'])) {
    $vip = $_GET['vip'];
}
//13
$job_code = '';
if (isset($_GET['job_code'])) {
    $job_code = $_GET['job_code'];
}
?>
@extends('staff_admin.layouts.master')

@section('title', 'Danh sách nhà tuyển dụng' )

@section('content')
    <style>
        .cutTitle {
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            -webkit-line-clamp: 1 !important;
            display: -webkit-box !important;
            -webkit-box-orient: vertical !important;
        }
    </style>
    <div class="container-fluid">
        <div class="row row-content">
            {{-- sitebar --}}
            <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
                @include('staff_admin.sidebars.job')
            </div>

            <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
                <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                    <div class="contentJobsInteresting col-f14 ">
                        <div class="log_error">
                            @if (session('error'))
                                <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                                    <div class="alert alert-danger mg-b-0 " role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="close iconAlert" data-dismiss="alert"
                                                aria-label="Close">x
                                        </button>
                                    </div>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                                    <div class="alert alert-success mg-b-0 ">
                                        {{session('success')}}
                                        <button type="button" class="close iconAlert" data-dismiss="alert"
                                                aria-label="Close">x
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="custom-order">
                            <div class="custom-paginate first-order ml-1 mt-1 row">
                                {{ $vip_employee->links() }}
                                số bản ghi của một trang:
                                <span class="input-submit">
                                <form action="" class="inline">
                                    <input type="hidden" name="date_search_start" value="{{ $date_search_start }}">
                                    <input type="hidden" name="date_search_end" value="{{ $date_search_end }}">
                                    <input type="hidden" name="career_category_id" value="{{ $career_category_id }}">
                                    <input type="hidden" name="employer_name" value="{{ $employer_name }}">
                                    <input type="hidden" name="title" value="{{ $title }}">
                                    <input type="hidden" name="literacy" value="{{ $literacy }}">
                                    <input type="hidden" name="literacy" value="{{ $literacy }}">
                                    <input type="hidden" name="active_job" value="{{ $active_job }}">
                                    <input type="hidden" name="province" value="{{ $province }}">
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <input type="hidden" name="vip" value="{{ $vip }}">
                                    <input type="hidden" name="job_code" value="{{ $job_code }}">
                                    <input type="hidden" name="district" value="{{ $district }}">

                                    <input type="submit" value="200" name="num"
                                           class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
                                    <input type="submit" value="50" name="num"
                                           class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
                                    <input type="submit" value="40" name="num"
                                           class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
                                    <input type="submit" value="30" name="num"
                                           class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
                                    <input type="submit" value="20" name="num"
                                           class="{{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
                                    <input type="submit" value="10" name="num"
                                           class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
                                </form>
                            </span>
                            </div>
                            <div class="d-flex justify-content-between second-order">
                                <div>
                                    <button id="button-timkiem" class="btn btn-sm btn-secondary mr-1 text-white"
                                            data-toggle="modal" data-target="#timkiem"><i
                                                class="fas fa-search text-warning"></i> Tìm
                                    </button>

                                    <div class="modal fade" id="timkiem" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <form action="" method="get">
                                            <div class="modal-dialog custom-modal-dialog modal-dialog-centered"
                                                 role="document">

                                                <?php
                                                //thành phố
                                                $provice = isset($_GET['province']) ? $_GET['province'] : 0;
                                                //                    $provice = \App\Entity\Province::getId($p);
                                                //quân /huyện
                                                $district_get = isset($_GET['district_id']) ? $_GET['district_id'] : '';
                                                //                    $district = \App\Entity\District::getId($q);
                                                $salary_get = isset($_GET['salary_id']) ? $_GET['salary_id'] : array();
                                                $profile_get = isset($_GET['profile']) ? $_GET['profile'] : '';
                                                $status_get = isset($_GET['status']) ? $_GET['status'] : '';
                                                $career_category_id_get = isset($_GET['career_category_id']) ? $_GET['career_category_id'] : '';
                                                ?>
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Lọc ứng
                                                            viên</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="row employee-search ">
                                                            <div class="col-md-6 col-lg-6  ">
                                                                <div class="form-group">
                                                                    <label class="f16 lpf14 fw6"> <i
                                                                                class="fas fa-filter"></i> Tìm theo
                                                                        thành phố</label>
                                                                    <select class="select2" name="province"
                                                                            aria-label="Tỉnh/Thành phố" id="province">
                                                                        <option value="0" selected> Tất cả tỉnh/thành
                                                                            phố
                                                                        </option>
                                                                        <?php
                                                                        $getAllProvince = \App\Entity\Province::GetAllProvinces();
                                                                        ?>
                                                                        @foreach($getAllProvince as $province)
                                                                            <option @if($province->province_id == $provice) selected
                                                                                    @endif value="{{$province->province_id}}">{{$province->province_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-6  ">
                                                                <div class="form-group">
                                                                    <label class="f16 lpf14 fw6"> <i
                                                                                class="fas fa-filter"></i> Tìm theo
                                                                        quận/huyện</label>
                                                                    <select class="select2" name="district_id"
                                                                            id="district">
                                                                        <option value="0">
                                                                            Chọn quận huyện
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row employee-search ">
                                                            <div class="col-md-6 col-lg-6 ">
                                                                <div class="form-group">
                                                                    <label class="f16 lpf14 fw6"> <i
                                                                                class="fas fa-filter"></i> Tìm theo công
                                                                        việc</label>
                                                                    <select class="select2" name="career_category_id">
                                                                        <option value="0"> Chọn công việc
                                                                        </option>
                                                                        @foreach(\App\Entity\Career::get_all_career() as $career)
                                                                            <option @if($career_category_id_get == $career->career_category_id) selected
                                                                                    @endif
                                                                                    value="{{$career->career_category_id}}">
                                                                                {{$career->career_category_name}}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-6  ">
                                                                <div class="form-group">
                                                                    <label class="f16 lpf14 fw6"> <i
                                                                                class="fas fa-filter"></i> Tìm theo mức
                                                                        lương</label>
                                                                    <select class="select2" name="salary_id">
                                                                        <option
                                                                                value="0">
                                                                            Chọn mức lương
                                                                        </option>
                                                                        @foreach(\App\Entity\Salary::showAllSalary() as $salary)
                                                                            <option @if($salary_get == $salary->salary_id) checked
                                                                                    @endif
                                                                                    value="{{$salary->salary_id}}">
                                                                                {{$salary->description}}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row employee-search ">
                                                            <div class="col-md-6 col-lg-6  ">
                                                                <div class="form-group">
                                                                    <label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i>Phần trăm hồ sơ</label>
                                                                    <input type="text " placeholder="Phần trăm hồ sơ" class="form-control " name="profile" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-6  ">
                                                                <div class="form-group">
                                                                    <label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i>Số lượng ứng viên cần tìm</label>
                                                                    <input type="text " placeholder="Số lượng ứng viên cần tìm" class="form-control" name="limit_employee" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Close
                                                        </button>
                                                        <button type="submit " class="btn btn-primary">Tìm kiếm</button>
                                                        <input type="reset" class="btn btn-success" value="Reset">
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    <!-- <button  type="button" class="btn btn-danger delete_request btn-sm mr-1">Đề nghị xóa</button> -->
                                </div>
                                <!-- form tim kiem theo id vc lam -->
                            </div>

                        </div>

                        <div class="row ">

                            <form action="{{ route('post_send_email_job') }}" method="post" class="inline">
                                <input type="hidden" name="job_id" value="{{ $job->job_id }}">
                                <div class="col-md-12">
                                    <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped"
                                         style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                        <div class="lockedWrap lockedWrap-first">
                                            <div class="cellWrap cellWrap-first">
                                                <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail">
                                                </p>
                                            </div>
                                            @foreach ($vip_employee as $emplo)
                                                <div class="cellWrap">
                                                    <input type="checkbox" id_customer="{{$emplo->employee_id}}"
                                                           class="checkItem sub_chk" name="list_id[]"
                                                           value="{{$emplo->employee_id}}"
                                                           data-id="{{$emplo->employee_id}}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tableFixHead" style="padding-bottom:10px;overflow-x:auto;">
                                        <table data-fl-scrolls
                                               class="custom-table table-scroll table-bordered table-striped"
                                               style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                            <thead>
                                            <tr>
                                                {{-- <td>
                                                    <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                                </td> --}}
                                                <td class="lid_1">
                                                    <p style="width:34px">ID
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_2">L
                                                        </button>
                                                    </p>
                                                </td>
                                                <td class="lid_3">
                                                    <p style="width:70px">Tên ứng viên
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_3">L
                                                        </button>
                                                    </p>
                                                </td>
                                                <td class="lid_2">
                                                    <p style="width:70px">Email
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_2">L
                                                        </button>
                                                    </p>
                                                </td>
                                                <td class="lid_4">
                                                    <p style="width:70px">Phone
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_4">L
                                                        </button>
                                                    </p>
                                                </td>
                                                <td class="lid_5">
                                                    <p style="width:45px">Hồ sơ
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_10">
                                                            L
                                                        </button>
                                                    </p>
                                                </td>
                                                <td class="lid_8">
                                                    <p style="width:60px">Tỉnh/ thành
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_1">L
                                                        </button>
                                                    </p>
                                                </td>
                                                <td class="lid_6">
                                                    <p style="width:50px">Công việc
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_9">L
                                                        </button>
                                                    </p>
                                                </td>
                                                <td class="lid_7">
                                                    <p style="width:60px">Lĩnh vực
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_12">
                                                            L
                                                        </button>
                                                    </p>
                                                </td>
                                                <td class="lid_10">
                                                    <p style="width:55px">Mức lương
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_12">
                                                            L
                                                        </button>
                                                    </p>
                                                </td>

                                                {{-- <td class="lid_1">Người duyệt</td> --}}
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($vip_employee as $emplo)
                                                <tr>
                                                    {{-- <td data-title="Tích chọn phản hồi" class="numeric">
                                                        <input type="checkbox" id_customer="{{$job->job_id}}" class="checkItem" name="list_id[]"
                                                            value="{{$job->job_id}}">
                                                    </td> --}}
                                                    <td class="lid_1">{{ $emplo->employee_id }}</td>
                                                    <td class="lid_3"><a
                                                                href="{{ route('detail_employee_show',['employee_slug'=> $emplo['employee_slug']]) }}"
                                                                target="_blank">{{ $emplo->employee_name }}</a></td>
                                                    <td class="lid_2">
                                                        {{ $emplo->email }}
                                                    </td>
                                                    <td class="lid_4">
                                                        {{ $emplo->phone }}
                                                    </td>
                                                    <td class="lid_5">
                                                        {{ $emplo->profile }}
                                                    </td>
                                                    <td class="lid_8">
                                                        <p class="cutTitle">
                                                            @if(isset($emplo->province_name))
                                                                {{ $emplo->province_name }}
                                                            @endif
                                                            {{--//danh sach quan huyen--}}
                                                            <?php
                                                            $list_district_name = \App\Entity\Employee_district::get_district_name($emplo->employee_id);
                                                            ?>
                                                            @if(!empty($list_district_name))
                                                                @foreach($list_district_name as $ids=>$district)
                                                                    <i> | {{ $district->district_name }}</i>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                    </td>
                                                    <td class="lid_6">
                                                        <p class="cutTitle">
                                                            <?php
                                                            $list_career_name = \App\Entity\Employee_career_categories::get_array_name($emplo->employee_id);
                                                            ?>
                                                            @if(!empty($list_career_name))
                                                                <i class="fas fa-certificate mgr5"></i>

                                                                @foreach($list_career_name as $id_c=>$career)
                                                                    @if($id_c == 0)
                                                                        <span> {{ $career->career_category_name }}</span>
                                                                    @else
                                                                        <span> | {{ $career->career_category_name }}</span>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                    </td>
                                                    <td class="lid_7" style="text-align:center">
                                                        <p class="cutTitle">
                                                            <?php
                                                            $list_business_name = \App\Entity\Employee_business_type::get_array_name($emplo->employee_id);
                                                            ?>
                                                            @foreach($list_business_name as $id_b=>$business)
                                                                @if($id_b == 0)
                                                                    <span> {{ $business->business_type_name }}</span>
                                                                @else
                                                                    <span> | {{ $business->business_type_name }}</span>
                                                                @endif
                                                            @endforeach
                                                        </p>
                                                    </td>
                                                    <td class="lid_12 text-center">{{ isset($employee['description']) ? $employee['description'] : 'Thỏa thuận'  }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding-bottom: 50px">
                                    <button class="btn btn-sm btn-secondary mr-1 text-white" type="submit"> Mời ứng
                                        tuyển
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <!-- The Modal -->
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#province').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                })
            });
        });
        $('.delete_request').click(function () {
            var x = confirm("Bạn có chắc chắc đề nghị xóa?");
            if (x) {
                var Ids = [];
                $.each($(".checkItem:checked"), function () {
                    Ids.push($(this).val());
                });

                if (Ids.length == 0) {
                    var changeHtml2 = '';
                    changeHtml2 += '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml2 += '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml2 += 'Vui lòng chọn việc làm';
                    changeHtml2 += '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                    changeHtml2 += '</div>';
                    changeHtml2 += '</div>';
                    $('.log_error').html(changeHtml2);
                    event.preventDefault();
                } else {
                    var content = $("#feedback_all").val();
                    var changeHtml = '';
                    $.ajax({
                        type: 'post',
                        url: '{{route("staff_job_delete_all_request")}}',
                        data: {content: content, Ids: Ids},
                        success: function (data) {
                            console.log(data);
                            if (data) {
                                changeHtml += '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                                changeHtml += '<div class="alert alert-success mg-b-0 ">';
                                changeHtml += 'Đề nghị xóa thành công';
                                changeHtml += '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                                changeHtml += '</div>';
                                changeHtml += '</div>';
                                $('.log_error').html(changeHtml);
                            }

                        },
                        error: function (err) {
                            console.log(err);
                            changeHtml += '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                            changeHtml += '<div class="alert alert-danger mg-b-0 " role="alert">';
                            changeHtml += 'Đề nghị xóa không thành công';
                            changeHtml += '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                            changeHtml += '</div>';
                            changeHtml += '</div>';
                            $('.log_error').html(changeHtml);
                        }
                    });
                }
            } else
                return false;
        });
        $('.approved_all_job').click(function () {
            var x = confirm("Bạn có chắc chắc duyệt?");
            if (x) {
                var Ids = [];
                $.each($(".checkItem:checked"), function () {
                    Ids.push($(this).val());
                });

                if (Ids.length == 0) {
                    var changeHtml2 = '';
                    changeHtml2 += '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml2 += '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml2 += 'Vui lòng chọn việc làm';
                    changeHtml2 += '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                    changeHtml2 += '</div>';
                    changeHtml2 += '</div>';
                    $('.log_error').html(changeHtml2);
                    event.preventDefault();
                } else {
                    var content = $("#feedback_all").val();
                    var changeHtml = '';
                    $.ajax({
                        type: 'post',
                        url: '{{route("approved_all_job_2")}}',
                        data: {content: content, Ids: Ids},
                        success: function (data) {
                            console.log(data);
                            if (data) {
                                changeHtml += '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                                changeHtml += '<div class="alert alert-success mg-b-0 ">';
                                changeHtml += 'Duyệt thành công';
                                changeHtml += '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                                changeHtml += '</div>';
                                changeHtml += '</div>';
                                $('.log_error').html(changeHtml);
                            }

                        },
                        error: function (err) {
                            console.log(err);
                            changeHtml += '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                            changeHtml += '<div class="alert alert-danger mg-b-0 " role="alert">';
                            changeHtml += 'Duyệt không thành công';
                            changeHtml += '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                            changeHtml += '</div>';
                            changeHtml += '</div>';
                            $('.log_error').html(changeHtml);
                        }
                    });
                }
            } else
                return false;
        });
        $('.unapproved_all_job').click(function () {
            var x = confirm("Bạn có chắc chắc bỏ duyệt?");
            if (x) {
                var Ids = [];
                $.each($(".checkItem:checked"), function () {
                    Ids.push($(this).val());
                });

                if (Ids.length == 0) {
                    var changeHtml2 = '';
                    changeHtml2 += '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml2 += '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml2 += 'Vui lòng chọn việc làm';
                    changeHtml2 += '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                    changeHtml2 += '</div>';
                    changeHtml2 += '</div>';
                    $('.log_error').html(changeHtml2);
                    event.preventDefault();
                } else {
                    var content = $("#feedback_all").val();
                    var changeHtml = '';
                    $.ajax({
                        type: 'post',
                        url: '{{route("unapproved_all_job_2")}}',
                        data: {content: content, Ids: Ids},
                        success: function (data) {
                            console.log(data);
                            if (data) {
                                changeHtml += '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                                changeHtml += '<div class="alert alert-success mg-b-0 ">';
                                changeHtml += 'Bỏ duyệt thành công';
                                changeHtml += '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                                changeHtml += '</div>';
                                changeHtml += '</div>';
                                $('.log_error').html(changeHtml);
                            }

                        },
                        error: function (err) {
                            console.log(err);
                            changeHtml += '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                            changeHtml += '<div class="alert alert-danger mg-b-0 " role="alert">';
                            changeHtml += 'Bỏ duyệt không thành công';
                            changeHtml += '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                            changeHtml += '</div>';
                            changeHtml += '</div>';
                            $('.log_error').html(changeHtml);
                        }
                    });
                }
            } else
                return false;
        });
        $('#checkAllSendMail').on("click", function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        $('#response').click(function () {
            var Ids = [];
            $.each($(".checkItem:checked"), function () {
                Ids.push($(this).val());
            });
            if (Ids.length == 0) {
                var changeHtml2 = '';
                changeHtml2 += '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                changeHtml2 += '<div class="alert alert-danger mg-b-0 " role="alert">';
                changeHtml2 += 'Vui lòng chọn việc làm';
                changeHtml2 += '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                changeHtml2 += '</div>';
                changeHtml2 += '</div>';
                $('.log_error').html(changeHtml2);
                event.preventDefault();
            } else {
                $('#myModal1').modal('show');
            }
        });
        $('.send1').click(function () {
            if ($.trim($('#feedback_all').val()).length === 0) {
                $('.note_text_feedback_all').hide();
                $('.error_text_feedback_all').html('<i class="error"><span class="error_reg_mess_icon">Vui lòng nhập phản hồi</span></i>');
                $('.error_reg_mess_icon').css("color", "#ff0000");
                $('.error_border_feedback_all').css("cssText", "border: 1px solid #ff0000  !important;");
                event.preventDefault();
            } else {
                var Ids = [];
                $.each($(".checkItem:checked"), function () {
                    Ids.push($(this).val());
                });
                console.log(Ids);
                if (Ids.length == 0) {
                    // alert('đã vào');
                    var changeHtml2 = '';
                    changeHtml2 += '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml2 += '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml2 += 'Vui lòng chọn việc làm';
                    changeHtml2 += '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                    changeHtml2 += '</div>';
                    changeHtml2 += '</div>';
                    $('.log_error').html(changeHtml2);
                    $('#myModal1').modal('hide');
                    event.preventDefault();
                } else {
                    var content = $("#feedback_all").val();
                    var changeHtml = '';
                    $.ajax({
                        type: 'post',
                        url: '{{route("SendFeedbackAllJob")}}',
                        data: {content: content, Ids: Ids},
                        success: function (data) {
                            console.log(data);
                            if (data) {
                                changeHtml += '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                                changeHtml += '<div class="alert alert-success mg-b-0 ">';
                                changeHtml += 'Phản hồi thành công';
                                changeHtml += '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                                changeHtml += '</div>';
                                changeHtml += '</div>';
                                $('.log_error').html(changeHtml);
                                $('#myModal1').modal('hide');
                            }

                        },
                        error: function (err) {
                            console.log(err);
                            changeHtml += '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                            changeHtml += '<div class="alert alert-danger mg-b-0 " role="alert">';
                            changeHtml += 'Phản hồi không thành công';
                            changeHtml += '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                            changeHtml += '</div>';
                            changeHtml += '</div>';
                            $('.log_error').html(changeHtml);
                            $('#myModal1').modal('hide');
                        }
                    });
                }
            }
        });
        $('.delete_all').on('click', function (e) {
            var allVals = [];
            $(".sub_chk:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });


            if (allVals.length <= 0) {
                alert("Bạn chưa chọn bản ghi nào.");
            } else {


                var check = confirm("Bạn có chắc muốn xóa?");
                if (check == true) {


                    var join_selected_values = allVals.join(",");
                    console.log(join_selected_values)

                    $.ajax({
                        url: '{{ route('delete_all_job_ntd') }}',
                        type: 'get',
                        data: 'ids=' + join_selected_values,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function () {
                                    $(this).parents("tr").remove();
                                });
                                location.reload()
                                alert(data['success'])
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });


                    $.each(allVals, function (index, value) {
                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                    });
                }
            }
        });

        $('.delete_all_hard').on('click', function (e) {
            var allVals = [];
            $(".sub_chk:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });


            if (allVals.length <= 0) {
                alert("Bạn chưa chọn bản ghi nào.");
            } else {


                var check = confirm("Bạn có chắc muốn xóa?");
                if (check == true) {


                    var join_selected_values = allVals.join(",");
                    console.log(join_selected_values)

                    $.ajax({
                        url: '{{ route('delete_all_job_ntd_hard') }}',
                        type: 'get',
                        data: 'ids=' + join_selected_values,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function () {
                                    $(this).parents("tr").remove();
                                });
                                location.reload();
                                alert(data['success'])
                            } else {
                                alert('Đã xảy ra lỗi. không xóa được!!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });


                    $.each(allVals, function (index, value) {
                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                    });
                }
            }
        });


    </script>
@endsection
