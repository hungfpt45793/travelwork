<?php
$num = '';
if (isset($_GET['num'])) {
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
@section('title', 'Danh sách ứng viên nộp hồ sơ nhanh' )
@section('content')
    <style>
        .link_page {
            background: #fff;
            border-right: 5px;
        }
        .pagination .active {
            background: #009385;
            color: #fff;
        }
        .pagination li {
            padding: 5px 15px;
            color: #333;
            border: 1px solid #eee;
            margin: 5px;
            cursor: pointer;
        }
    </style>
    <div class="container-fluid">
        <div class="row row-content">
            <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
                @include('staff_admin.sidebars.job')
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
                <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                    <div class="contentJobsInteresting  col-f14 ">

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
                                                                <?php
                                                                    $employee_name = !empty($_GET['employee_name']) ? $_GET['employee_name'] : '';
                                                                ?>
                                                                <input type="text" class="form-control" value="{{ !empty($employee_name) ? $employee_name : '' }}" name="employee_name" placeholder="Tên ứng viên..." >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 control-label mb-0 mt-2 text-right">Email ứng viên</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <?php
                                                                $email = !empty($_GET['email']) ? $_GET['email'] : '';
                                                                ?>
                                                                <input type="text" class="form-control" value="{{ !empty($email) ? $email : '' }}" name="email" placeholder="Email ứng viên..." >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 control-label mb-0 mt-2 text-right">Phone ứng viên</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <?php
                                                                $phone = !empty($_GET['phone']) ? $_GET['phone'] : '';
                                                                ?>
                                                                <input type="text" class="form-control" value="{{ !empty($phone) ? $phone : '' }}" name="phone" placeholder="Phone ứng viên..." >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 control-label mb-0 mt-2 text-right">Xác thực show CV</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <?php
                                                                $status_show_cv = !empty($_GET['status_show_cv']) ? $_GET['status_show_cv'] : 0;
                                                                ?>
                                                                <select name="status_show_cv">
                                                                    <option value="0" @if($status_show_cv == 0) selected @endif>Chưa xác thực</option>
                                                                    <option value="1" @if($status_show_cv == 1) selected @endif>Đã xác thực</option>
                                                                </select>
                                                            </div>
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
                        </div>
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
                            <div class="row mr-1">
                                <div class="col-md-12">
                                    <div id="locker" data-fl-scrolls class="custom-table table-bordered table-striped"
                                         style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    </div>
                                    <div class="table-wrapper tableFixHead"
                                         style="padding-bottom:30px;overflow-x:auto;">
                                        <table data-fl-scrolls
                                               class="custom-table table-scroll table-bordered table-striped"
                                               style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                            <thead>
                                            <tr>
                                                <td scope="col" class="lid_1">
                                                    <p style="width:33px">ID
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_1">L
                                                        </button>
                                                    </p>
                                                </td>
                                                <td scope="col" class="lid_3">
                                                    <p style="width:105px">Ngày đăng ký
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_1">L
                                                        </button>
                                                    </p>
                                                </td>
                                                <td scope="col" class="lid_4">
                                                    <p style="width:150px">Ứng viên
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_2">L
                                                        </button>
                                                    </p>
                                                </td>

                                                <td scope="col" class="lid_5">
                                                    <p style="width:370px">Tên công việc
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_3">L
                                                        </button>
                                                    </p>
                                                </td>
                                                <td scope="col" class="lid_6">
                                                    <p style="width:100px">Xác thực show CV
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_3">L
                                                        </button>
                                                    </p>
                                                </td>
                                                <td scope="col" class="lid_8">
                                                    <p style="width:100px">Email xác thực
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_3">L
                                                        </button>
                                                    </p>
                                                </td>
                                                <td scope="col" class="lid_7">
                                                    <p style="width:95px">Show CV
                                                        <button class="lockButton btn btn-sm btn-success" id="lid_6">L
                                                        </button>
                                                    </p>
                                                </td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($list_employees as $employee)
                                                <tr>
                                                    <td scope="row" class="lid_1">{{ $employee->employee_id }}</td>
                                                    <td class="lid_5 text-center">
                                                        @php
                                                            $date = date_create($employee->created_at);
                                                            echo date_format($date, "d/m/Y");
                                                        @endphp
                                                    </td>
                                                    <td class="lid_5 text-center">
                                                        {{ $employee->employee_name }} -
                                                        {{ $employee->email }} -
                                                        {{ $employee->phone }}
                                                    </td>

                                                    <td class="lid_2">
                                                        <a href="{{ route('job_detail',['slug'=>$employee->slug]) }}"
                                                           target="_blank">{{ !empty($employee->title) ? $employee->title : '' }}</a>
                                                    </td>
                                                    <td class="lid_6">
                                                        @if($employee->status_show_cv == 0)
                                                            <span style="color: red">Chưa xác thực </span>
                                                            @else
                                                            <span style="color: green">Đã xác thực </span>
                                                        @endif
                                                    </td>
                                                    <td class="lid_6">
                                                        <?php
                                                        $email_xacthuc = \App\User::check_status_email_account($employee->user_id);
                                                        ?>
                                                        @if(!empty($email_xacthuc))
                                                            <span style="color: red">Chưa xác thực </span>
                                                            @else
                                                            <span style="color: green">Đã xác thực </span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal{{ $employee->employee_id }}">
                                                            Xem CV
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>

                        <section class="link_page bgWhite mgt20">
                            <div class="row">
                                <div class="col-12 text-center">
                                    @include('site.default.item_pani',['page_link' => $list_employees])
                                </div>
                            </div>
                        </section>
                    </div>
                </section>
                @foreach ($list_employees as $employee)
                    <form method="POST" action="{{ route('post_submit_apply_job') }}">
                    <!-- Modal -->
                        <div class="modal fade" id="modal{{ $employee->employee_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Show CV</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="box_iframe">
                                          <?php
                                          $link_cv_upload_public = str_replace('/public', '', $employee->employee_link_cv);
                                          $link_cv_upload = asset($link_cv_upload_public);
                                          ?>
                                          {{--//nếu có cv upload thì show nếu k thì hiện cv mã hóa--}}

                                          @if(file_exists(public_path($link_cv_upload_public)))
                                              <iframe style="width: 100%;height: 60vh" class="iframe_cv_employee" src="https://docs.google.com/gview?url={{ asset($link_cv_upload) }}&embedded=true" frameborder="0"></iframe>
                                          @endif
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                        <input type="hidden" name="employee_id" value="{{ $employee->employee_id }}">
                                        <input type="hidden" name="id_job_fb" value="{{ $employee->id_job_fb }}">
                                        <button type="submit" class="btn btn-primary">Duyệt hồ sơ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
@endsection
