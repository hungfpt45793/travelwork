<?php
    $num = '';
    if(isset($_GET['num'])){
        $num = $_GET['num'];
    }
    //2
    $date_search_start = '';
    if(isset($_GET['date_search_start'])){
        $date_search_start = $_GET['date_search_start'];
    }
    //3
    $date_search_end = '';
    if(isset($_GET['date_search_end'])){
        $date_search_end = $_GET['date_search_end'];
    }
    //4
    $career_category_id = '';
    if(isset($_GET['career_category_id'])){
        $career_category_id = $_GET['career_category_id'];
    }
    //5
    $employer_name = '';
    if(isset($_GET['employer_name'])){
        $employer_name = $_GET['employer_name'];
    }
    //6
    $title = '';
    if(isset($_GET['title'])){
        $title = $_GET['title'];
    }
    //7
    $literacy = '';
    if(isset($_GET['literacy'])){
        $literacy = $_GET['literacy'];
    }
    //8
    $active_job = '';
    if(isset($_GET['active_job'])){
        $active_job = $_GET['active_job'];
    }
    //9
    $province = '';
    if(isset($_GET['province'])){
        $province = $_GET['province'];
    }
    //10
    $email = '';
    if(isset($_GET['email'])){
        $email = $_GET['email'];
    }
    //11
    $district = '';
    if(isset($_GET['district'])){
        $district = $_GET['district'];
    }
    //12
    $vip = '';
    if(isset($_GET['vip'])){
        $vip = $_GET['vip'];
    }
    //13
    $job_code = '';
    if(isset($_GET['job_code'])){
        $job_code = $_GET['job_code'];
    }
?>
@extends('staff_admin.layouts.master')

@section('title', 'Danh sách nhà tuyển dụng' )

@section('content')
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

                                    <input type="submit" value="200" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
                                    <input type="submit" value="50" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
                                    <input type="submit" value="40" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
                                    <input type="submit" value="30" name="num" class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
                                    <input type="submit" value="20" name="num"  class="{{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
                                    <input type="submit" value="10" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
                                </form>
                            </span>
                            | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '30' }}/{{ $total_job }} bản ghi
                        </div>
                        <div class="d-flex justify-content-between second-order" style="width:-webkit-fill-available">
                            <div>
                            <button id="button-timkiem" class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</button>
                            <button class="btn btn-sm btn-secondary mr-1 ">  <a href="{{ route('staff_job-ntd.index') }}" class="text-white"><i class="fas fa-sync-alt text-success"></i>Làm tươi</a></button>
                            <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                    <form action="">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm việc làm nhà tuyển dụng</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="row employee-search ">
                                                    <div class="col-md-5 mb-3">
                                                        <label class="label_date" for="validationDefault01">Từ ngày(update)</label>
                                                        @php
                                                                $d=strtotime("-1 Months");
                                                                $date = date("Y-m-d", $d)
                                                        @endphp
                                                        <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : $date }}" type="date" id="" name="date_search_start">
                                                        </div>
                                                    <div class="col-md-5 mb-3">
                                                        <label class="label_date" for="validationDefault02">Đến ngày(update)</label>
                                                        <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : date("Y-m-d") }}" type="date" id="" name="date_search_end">
                                                    </div>
                                                    <!-- myDatetime -->
                                                    <div class="col-md-2 mb-3">
                                                            <label for="validationDefault2" class="text-light">sd</label>
                                                            <input type="hidden" value="{{$num}}" name="num">
                                                            <input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày"></input>
                                                        </div>
                                                    <div class="col-md-4 col-xs-6  ">
                                                        <div class="form-group">
                                                            <select class=" form-control select2" name="career_category_id">
                                                                <option value="">--Danh mục nghành nghề--</option>
                                                                <?php $career_category_id_get = isset($_GET['career_category_id']) ? $_GET['career_category_id'] : '';?>
                                                                @foreach(\App\Entity\Career::get() as $career)
                                                                <option value="{{$career->career_category_id}}"
                                                                        @if($career->career_category_id == $career_category_id_get) selected
                                                                        @endif
                                                                >{{$career->career_category_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <?php $employer_name = isset($_GET['employer_name']) ? $_GET['employer_name'] : '';?>
                                                            <input type="text" placeholder="Tên nhà tuyển dụng" class="form-control " name="employer_name" value="{{ $employer_name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <?php $title_get = isset($_GET['title']) ? $_GET['title'] : '';?>
                                                            <input type="text "  placeholder="Tên việc làm" class="form-control " name="title" value="{{ $title_get }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6 ">
                                                        <div class="form-group">
                                                            <select class="form-control select2" name="literacy">
                                                                <option value="">--Trình độ yêu cầu--</option>
                                                                <?php $literacy_get = isset($_GET['literacy']) ? $_GET['literacy'] : '';?>
                                                                @foreach(\App\Entity\Literacy::orderBy('literacy_name')->get() as $literacy)
                                                                        <option value="{{$literacy->literacy_id}}"
                                                                            @if($literacy->literacy_id == $literacy_get) selected
                                                                            @endif>{{$literacy->literacy_name}}
                                                                        </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <?php
                                                                if(isset($_GET['active_job']) && $_GET['active_job']==null){
                                                                    $active_job = 3;
                                                                }else if(isset($_GET['active_job']) && $_GET['active_job']==1){
                                                                    $active_job = 1;
                                                                }else if(isset($_GET['active_job']) && $_GET['active_job']==0){
                                                                    $active_job = 0;
                                                                }
                                                                else  $active_job = 3;
                                                            ?>
                                                            <select class=" form-control select2" name="active_job"
                                                                id="active_job">
                                                                <option value="" selected>--Trạng thái--</option>
                                                                <option value="0" {{ ($active_job == 0) ? 'selected' : '' }}>--Chưa duyệt--</option>
                                                                <option value="1" {{ ($active_job == 1) ? 'selected' : '' }}>--Đã duyệt--</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <?php $email_get = isset($_GET['email']) ? $_GET['email'] : ''; ?>
                                                            <input type="email " placeholder="Email nhà tuyển dụng " class="form-control " name="email" value="{{ $email_get }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6 ">
                                                        <div class="form-group">
                                                            <select class=" form-control select2" id="province" name="province">
                                                                <option value="">--Chọn Tỉnh/Thành phố--</option>
                                                                <?php $province_get = isset($_GET['province']) ? $_GET['province'] : '';?>
                                                                @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                                    <option value="{{$province->province_id}}"
                                                                            @if($province->province_id == $province_get) selected
                                                                            @endif
                                                                    >{{$province->province_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <select class=" form-control select2" id="district" name="district">
                                                                <option value="">--Chọn Quận huyện--</option>
                                                                <?php $district_get = isset($_GET['district']) ? $_GET['district'] : '';?>
                                                                @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                                    <option value="{{$district->district_id}}"
                                                                            @if($district->district_id == $district_get) selected
                                                                            @endif
                                                                    >{{$district->district_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <?php $vip_get = isset($_GET['vip']) ? $_GET['vip'] : '';?>
                                                            <select class="form-control select2" name="vip" id="">
                                                                <option value="" selected> -- Loại tin --</option>
                                                                <option value="0" @if($vip_get == '0') selected @endif > Tin thường </option>
                                                                <option value="1" @if($vip_get == '1') selected @endif > Tin Vip </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group form-group">
                                                            <?php $job_code_get = isset($_GET['job_code']) ? $_GET['job_code'] : '';?>
                                                            <input type="text" placeholder="Mã tin" class="form-control " name="job_code" value="{{ $job_code_get }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="submit " class="btn btn-primary">Tìm kiếm</button>
                                                <input type="reset" class="btn btn-success" value="Reset">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                           <button class="btn btn-warning  btn-sm mr-1 "> <a href="{{ route('update_job_code_with_staff') }}" class="text-white" >Cập nhập mã tin</a></button>
                            <!-- <button  type="button" class="btn btn-danger delete_request btn-sm mr-1">Đề nghị xóa</button> -->
                            @if(url()->current() != route('job_ntd_deleted'))
                            <button  type="button" class="btn btn-danger delete_all btn-sm mr-1">Xóa</button>
                            @endif
                            <button class="btn btn-success  btn-sm mr-1"><a href="{{ route('form_create_job') }}" class="text-white">Thêm mới</a></button>
                            <button  type="button" id="response" class="btn text-white btn-warning btn-sm mr-1">Phản hồi</button>
                            <button  type="submit" class="btn btn-info approved_all_job mr-1">Duyệt</button>
                            <button  type="submit" class="btn btn-info unapproved_all_job mr-1">Bỏ duyệt</button>
                            @if(url()->current() == route('job_ntd_deleted'))
                            <button  type="button" class="btn btn-danger delete_all_hard btn-sm mr-1">Xóa Hẳn</button>
                            @endif
                        </div>
                        <!-- form tim kiem theo id vc lam -->
                        <div>
                            <form action="" class="">
                                <div class="group-form border border-primary">
                                    <input class="border-0 input-lg" type="text"
                                        name="job_id" style="width:80px"
                                        value="{{ (!empty($_GET['job_id'])) ? $_GET['job_id'] : ''  }}"
                                        placeholder="ID Job NTD">
                                    <button class="search border-0" type="submit"><i class="fa fa-search "
                                            aria-hidden="true"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>

                    <div class="row ">
                        <div id="myModal1" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                {{-- <form role="form" action=""  method="POST" id="send_feedback_all_teacher"> --}}
                                    {!! csrf_field() !!}
                              <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Phản hồi tới tất cả</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <textarea class="form-control error_border_feedback_all" id="feedback_all" name="feedback_all" rows="6" cols="80" placeholder="Nhập phản hồi"/></textarea>
                                            <div class="mess_notice_feedback_all clearfix note_text_feedback_all"></div>
                                            <div class="error_reg_mess clearfix error_text_feedback_all"></div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn btn-primary send1">Gửi</button>
                                        </div>
                                    </div>
                                {{-- </form> --}}


                            </div>
                          </div>

                        <div class="col-md-12">
                            <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                    </div>
                                    @foreach ($jobs as $job)
                                    <div class="cellWrap">
                                        <input type="checkbox" id_customer="{{$job->job_id}}" class="checkItem sub_chk" name="list_id[]"
                                                    value="{{$job->job_id}}" data-id="{{$job->job_id}}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            {{-- <td>
                                                <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                            </td> --}}
                                            <td class="lid_1"><p style="width:34px">ID<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td class="lid_3"><p style="width:70px">Update<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td class="lid_2"><p style="width:70px">TT<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td class="lid_4"><p style="width:400px">Tên NTD<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td class="lid_5"><p style="width:45px">Link<button class="lockButton btn btn-sm btn-success" id="lid_10">L</button></p></td>
                                            <td class="lid_8"><p style="width:60px">Mã tin<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td class="lid_6"><p style="width:50px">Tin<button class="lockButton btn btn-sm btn-success" id="lid_9">L</button></p></td>
                                            <td class="lid_7"><p style="width:55px">Duyệt<button class="lockButton btn btn-sm btn-success" id="lid_12">L</button></p></td>
                                            <td class="lid_12"><p style="width:34px;"><i class="fas fa-eye"></i><button class="lockButton btn btn-sm btn-success" id="lid_8">L</button></p></td>
                                            <td class="lid_10"><p style="width:350px">Tên việc<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                            <td class="lid_11"><p style="width:100px">Hạn nộp đơn<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>
                                            <td class="lid_9"><p style="width:250px">Email<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            <!-- <td class="lid_11"><p style="width:70px">ĐN/xóa<button class="lockButton btn btn-sm btn-success" id="lid_11">L</button></p></td> -->
                                            <td class="lid_13"><p style="width:100px">Người TT<button class="lockButton btn btn-sm btn-success" id="lid_13">L</button></p></td>
                                            <td class="lid_14" ><p style="width:70px;">Ngày TT<button class="lockButton btn btn-sm btn-success" id="lid_14">L</button></p></td>
                                            {{-- <td class="lid_1">Người duyệt</td> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jobs as $job)
                                        <tr>
                                            {{-- <td data-title="Tích chọn phản hồi" class="numeric">
                                                <input type="checkbox" id_customer="{{$job->job_id}}" class="checkItem" name="list_id[]"
                                                    value="{{$job->job_id}}">
                                            </td> --}}
                                            <td class="lid_1">{{ $job->job_id }}</td>
                                            <td class="lid_3">{{ date_format(date_create($job->updated_at),"d/m/Y") }}</td>
                                            <td class="lid_2">
                                                @if(url()->current() == route('job_ntd_deleted'))
                                                    <a href="{{ route('delete_job_ntd_hard', $job->job_id) }}">
                                                        <button type="button" class="btn btn-sm btn-danger">Xóa</button>
                                                    </a>
                                                    <a href="{{ route('staff_job_ntd_restore', $job->job_id) }}">
                                                        <button type="button" class="btn btn-sm btn-success">KP</button>
                                                    </a>
                                                @else
                                                    <a href="{{ route('detail_job_with_staff_admin', $job->job_id) }}">
                                                        <button type="button" class="btn btn-sm btn-info">Thao tác</button>
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="lid_4">
                                                <?php
                                                    if(!isset($job['employer_id']))
                                                    $job['employer_id'] = 0;
                                                    $employer = \App\Entity\Employer::getIdemployer($job['employer_id']);
                                                ?>
                                                @if(isset($employer->employer_id))
                                                    <a href="{{ route('staff_employer.edit',['staff_employer'=>$employer->employer_id]) }}" target="_blank" rel="noopener noreferrer">
                                                        <p class="crop" style="width:400px">{{ $job->enterprise_name }}</p>
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="lid_5">
                                                <a href="{{ route('job_detail',['slug'=> $job['slug']]) }}" target="_blank">Link</a>
                                            </td>
                                            <td class="lid_8">{{ $job->job_code }}</td>
                                            <td class="lid_6">
                                                @if($job->vip == 0)
                                                    <span>Thường</span>
                                                @else
                                                    <span style="color: red">Vip</span>
                                                @endif
                                            </td>
                                            <td class="lid_7" style="text-align:center">
                                                @if($job->active_job == 0)
                                                    <i class="fas fa-times text-danger text-center"></i>
                                                @else
                                                    <i class="fas fa-check text-success"></i>
                                                @endif
                                            </td>
                                            <td class="lid_12 text-center">{{ $job->views }}</td>
                                            <td class="lid_10"><p class="crop">{{ $job->title }}</p></td>
                                            <td class="lid_11 text-center">
                                                <?php
                                                    $date = date_create($job->deadline_submit_profile);
                                                    echo date_format($date, "d/m/Y");
                                                ?>
                                            </td>
                                            <td class="lid_9">
                                                <p class="crop">{{ $job->email }}</p>
                                            </td>
                                            <!-- <td class="lid_11">
                                                <?php
                                                $check_delete = \App\Entity\Job_delete_request::where('job_id',$job->job_id)->first();
                                                ?>
                                                @if($check_delete == null)
                                                   <span style="color: green">Không</span>
                                                @else <span style="color: red">Có</span>
                                                @endif
                                            </td> -->
                                            <td class="lid_13 crop">
                                                <?php
                                                    $check_job_handling = \App\Entity\Job_handling::select('job_handling.*','u.name as user_name')
                                                    ->leftjoin('users as u','u.id','job_handling.user_id_handling')
                                                    ->where('job_handling.job_id',$job->job_id)
                                                    ->orderby('job_handling.id','desc')
                                                    ->first();
                                                ?>
                                                @if($check_job_handling != null)
                                                    {{$check_job_handling->user_name}}
                                                @elseif($check_job_handling == null )
                                                <?php
                                                    $name = \App\Entity\User::where('id', $job->user_id)->value('name');
                                                ?>
                                                    {{$name}}
                                                @endif
                                            </td>
                                            <td class="lid_14 crop">
                                                @if($check_job_handling != null)
                                                    {{-- {{date_format($check_job_handling->created_at,"d/m/Y")}} --}}
                                                    <?php
                                                        $date = date_create($check_job_handling->created_at);
                                                        echo date_format($date, "d/m/Y");
                                                    ?>
                                                @endif
                                            </td>
                                            {{-- <td>
                                                @if($job->user_name == null && $job->active_job == 1)
                                                    Admin
                                                @elseif($job->user_name != null) {{$job->user_name}}
                                                @else Chưa có
                                                @endif
                                            </td> --}}
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
<script>
    $( document ).ready(function() {
        $('#province').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#district').html(data);
            })
        });
    });
    $('.delete_request').click(function(){
            var x = confirm("Bạn có chắc chắc đề nghị xóa?");
            if (x){
                var Ids = [];
                $.each($(".checkItem:checked"), function () {
                    Ids.push($(this).val());
                });

                if(Ids.length == 0){
                    var changeHtml2 = '';
                    changeHtml2+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml2+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml2+=        'Vui lòng chọn việc làm';
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
                        url: '{{route("staff_job_delete_all_request")}}',
                        data: {  content: content,Ids: Ids},
                        success: function (data) {
                            console.log(data);
                            if (data) {
                                changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                                changeHtml+=    '<div class="alert alert-success mg-b-0 ">';
                                changeHtml+=        'Đề nghị xóa thành công';
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
                            changeHtml+=        'Đề nghị xóa không thành công';
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
        $('.approved_all_job').click(function(){
            var x = confirm("Bạn có chắc chắc duyệt?");
            if (x){
                var Ids = [];
                $.each($(".checkItem:checked"), function () {
                    Ids.push($(this).val());
                });

                if(Ids.length == 0){
                    var changeHtml2 = '';
                    changeHtml2+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml2+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml2+=        'Vui lòng chọn việc làm';
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
                        url: '{{route("approved_all_job_2")}}',
                        data: {  content: content,Ids: Ids},
                        success: function (data) {
                            console.log(data);
                            if (data) {
                                changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                                changeHtml+=    '<div class="alert alert-success mg-b-0 ">';
                                changeHtml+=        'Duyệt thành công';
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
                            changeHtml+=        'Duyệt không thành công';
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
        $('.unapproved_all_job').click(function(){
            var x = confirm("Bạn có chắc chắc bỏ duyệt?");
            if (x){
                var Ids = [];
                $.each($(".checkItem:checked"), function () {
                    Ids.push($(this).val());
                });

                if(Ids.length == 0){
                    var changeHtml2 = '';
                    changeHtml2+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml2+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml2+=        'Vui lòng chọn việc làm';
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
                        url: '{{route("unapproved_all_job_2")}}',
                        data: {  content: content,Ids: Ids},
                        success: function (data) {
                            console.log(data);
                            if (data) {
                                changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                                changeHtml+=    '<div class="alert alert-success mg-b-0 ">';
                                changeHtml+=        'Bỏ duyệt thành công';
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
                            changeHtml+=        'Bỏ duyệt không thành công';
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
    $('#checkAllSendMail').on("click", function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    $('#response').click(function(){
        var Ids = [];
            $.each($(".checkItem:checked"), function () {
                Ids.push($(this).val());
            });
        if(Ids.length == 0){
            var changeHtml2 = '';
                    changeHtml2+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml2+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml2+=        'Vui lòng chọn việc làm';
                    changeHtml2+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                    changeHtml2+=    '</div>';
                    changeHtml2+= '</div>';
                    $('.log_error').html(changeHtml2);
                    event.preventDefault();
        }
        else{
            $('#myModal1').modal('show');
        }
    });
    $('.send1').click(function(){
        if($.trim($('#feedback_all').val()).length === 0){
            $('.note_text_feedback_all').hide();
            $('.error_text_feedback_all').html('<i class="error"><span class="error_reg_mess_icon">Vui lòng nhập phản hồi</span></i>');
            $('.error_reg_mess_icon').css("color", "#ff0000");
            $('.error_border_feedback_all').css("cssText", "border: 1px solid #ff0000  !important;");
            event.preventDefault();
        }
        else{
            var Ids = [];
            $.each($(".checkItem:checked"), function () {
                Ids.push($(this).val());
            });
            console.log(Ids);
            if(Ids.length == 0){
                // alert('đã vào');
                var changeHtml2 = '';
                changeHtml2+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                changeHtml2+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                changeHtml2+=        'Vui lòng chọn việc làm';
                changeHtml2+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                changeHtml2+=    '</div>';
                changeHtml2+= '</div>';
                $('.log_error').html(changeHtml2);
                $('#myModal1').modal('hide');
                event.preventDefault();
            }
            else{
                var content = $("#feedback_all").val();
                var changeHtml = '';
                $.ajax({
                    type: 'post',
                    url: '{{route("SendFeedbackAllJob")}}',
                    data: {  content: content,Ids: Ids},
                    success: function (data) {
                        console.log(data);
                        if (data) {
                            changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                            changeHtml+=    '<div class="alert alert-success mg-b-0 ">';
                            changeHtml+=        'Phản hồi thành công';
                            changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                            changeHtml+=    '</div>';
                            changeHtml+= '</div>';
                            $('.log_error').html(changeHtml);
                            $('#myModal1').modal('hide');
                        }

                    },
                    error: function (err) {
                        console.log(err);
                        changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                        changeHtml+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                        changeHtml+=        'Phản hồi không thành công';
                        changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                        changeHtml+=    '</div>';
                        changeHtml+= '</div>';
                        $('.log_error').html(changeHtml);
                        $('#myModal1').modal('hide');
                    }
                });
            }
        }
    });
$('.delete_all').on('click', function(e) {
    var allVals = [];
    $(".sub_chk:checked").each(function() {
        allVals.push($(this).attr('data-id'));
    });


    if(allVals.length <=0)
    {
        alert("Bạn chưa chọn bản ghi nào.");
    }  else {


        var check = confirm("Bạn có chắc muốn xóa?");
        if(check == true){


            var join_selected_values = allVals.join(",");
            console.log(join_selected_values)

            $.ajax({
                url: '{{ route('delete_all_job_ntd') }}',
                type: 'get',
                data: 'ids='+join_selected_values,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $(".sub_chk:checked").each(function() {
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


        $.each(allVals, function( index, value ) {
            $('table tr').filter("[data-row-id='" + value + "']").remove();
        });
        }
    }
});

$('.delete_all_hard').on('click', function(e) {
    var allVals = [];
    $(".sub_chk:checked").each(function() {
        allVals.push($(this).attr('data-id'));
    });


    if(allVals.length <=0)
    {
        alert("Bạn chưa chọn bản ghi nào.");
    }  else {


        var check = confirm("Bạn có chắc muốn xóa?");
        if(check == true){


            var join_selected_values = allVals.join(",");
            console.log(join_selected_values)

            $.ajax({
                url: '{{ route('delete_all_job_ntd_hard') }}',
                type: 'get',
                data: 'ids='+join_selected_values,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $(".sub_chk:checked").each(function() {
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


        $.each(allVals, function( index, value ) {
            $('table tr').filter("[data-row-id='" + value + "']").remove();
        });
        }
    }
});


</script>
@endsection
