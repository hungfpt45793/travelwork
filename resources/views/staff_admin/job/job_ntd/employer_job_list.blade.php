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
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-start">
                                <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a>
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
                                                            <label class="label_date" for="validationDefault01">Từ ngày(phản hồi)</label>
                                                            @php
                                                                    $d=strtotime("-1 Months");
                                                                    $date = date("Y-m-d", $d)
                                                            @endphp
                                                            <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : $date }}" type="date" id="" name="date_search_start">
                                                            </div>
                                                        <div class="col-md-5 mb-3">
                                                            <label class="label_date" for="validationDefault02">Đến ngày(phản hồi)</label>
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
                            </div>
                            <div class="custom-paginate col-12 row mt-1">
                                {{ $jobs->links() }}
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
                                | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $jobs->total() }} bản ghi
                            </div>
                        </div>
                        <div class="col-md-12">
                            {{-- ô ấn nhiều --}}
                            <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" id="master"></p>
                                    </div>
                                    @foreach ($jobs as $job)
                                    <div class="cellWrap">
                                        <input type="checkbox" class="sub_chk" data-id="{{ $job->id }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <td class="lid_1"><p style="width:37px">ID<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td class="lid_7"><p style="width:60px">Mã tin<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>
                                            <td class="lid_12"><p style="width:129px">Người P/Hồi<button class="lockButton btn btn-sm btn-success" id="lid_12">L</button></p></td>
                                            <td class="lid_13" ><p style="width: 90px;">Ngày P/Hồi<button class="lockButton btn btn-sm btn-success" id="lid_13">L</button></p></td>
                                            <td class="lid_2"><p style="width:115px">Nội dung P/Hồi<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td class="lid_3"><p style="width:400px">Tên NTD<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td class="lid_9"><p style="width:300px">Tên việc<button class="lockButton btn btn-sm btn-success" id="lid_9">L</button></p></td>
                                            <td class="lid_6"><p style="width:55px">Duyệt<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                            <td class="lid_5"><p style="width:45px">Tin<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            <td class="lid_8"><p style="width:88px">Tin hết hạn<button class="lockButton btn btn-sm btn-success" id="lid_8">L</button></p></td>
                                            <td class="lid_10"><p style="width:100px">Hạn nộp đơn<button class="lockButton btn btn-sm btn-success" id="lid_10">L</button></p></td>
                                            <td class="lid_4"><p style="width:43px">Link<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jobs as $job)
                                        <tr>
                                            <td class="lid_1">
                                                {{ $job->job_id }}
                                            </td>
                                            <td class="lid_7">{{ $job->job_code }}</td>
                                            <td class="lid_12 crop">
                                                <?php
                                                    $check_job_handling = \App\Entity\Job_handling::select('job_handling.*','u.name as user_name')
                                                                            ->leftjoin('users as u','u.id','job_handling.user_id_handling')
                                                                            ->where('job_handling.job_id',$job->job_id)
                                                                            ->orderby('job_handling.id','desc')->first();
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
                                            <td class="lid_13 text-center">
                                                @if($check_job_handling != null)
                                                    {{date_format($check_job_handling->created_at,"d/m/Y")}}
                                                @endif
                                            </td>
                                            <td class="lid_2">
                                                <a class="content_feedback" data-id="{{ $job->job_id }}" data-toggle="modal" data-target="#content_feedback">
                                                    <p class="crop text-primary" style="width: 300px">
                                                        @if (isset($check_job_handling->feedback))
                                                            {{ $check_job_handling->feedback }}
                                                        @endif
                                                    </p>
                                                </a>
                                            </td>
                                            <td class="lid_3">
                                                <?php
                                                if(!isset($job['employer_id']))
                                                $job['employer_id'] = 0;
                                                $employer = \App\Entity\Employer::getIdemployer($job['employer_id']);
                                                ?>
                                                @if(isset($employer->employer_id))
                                                <a href="{{ route('staff_employer.edit',['employer_id'=>$employer->employer_id]) }}" target="_blank" rel="noopener noreferrer">
                                                    <p class="crop" style="width:400px">{{ $job->enterprise_name }}</p>
                                                </a>
                                                @endif
                                            </td>
                                            <td class="lid_9"><p class="crop" style="width:300px">{{ $job->title }}</p></td>
                                            <td class="lid_6" style="text-align:center">
                                                @if($job->active_job == 0)
                                                <i class="fas fa-times text-danger text-center"></i>
                                                @else <i class="fas fa-check text-success"></i>
                                                @endif
                                            </td>
                                            <td class="lid_5">
                                                @if($job->vip == 0)
                                                <span>Thường</span>
                                                @else
                                                <span style="color: red">Vip</span>
                                                @endif
                                            </td>
                                            <td class="lid_8 text-center">
                                                @if ($job->deadline_submit_profile <= date('Y-m-d'))
                                                    <i class="fas fa-check text-success">
                                                @else
                                                @endif
                                            </td>
                                            <td class="lid_10">
                                                <?php
                                                    $date = date_create($job->deadline_submit_profile);
                                                    echo date_format($date, "d/m/Y");
                                                ?>
                                            </td>
                                            <td class="lid_4"><a href="{{ route('job_detail',['slug'=> $job['slug']]) }}" target="_blank">Link </a></td>
                                            <!-- <td class="lid_11">
                                                <?php
                                                $check_delete = \App\Entity\Job_delete_request::where('job_id',$job->job_id)->first();
                                                ?>
                                                @if($check_delete == null)
                                                   <span style="color: green">Không</span>
                                                @else <span style="color: red">Có</span>
                                                @endif
                                            </td> -->
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
<div class="modal fade" id="content_feedback" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nội dung phản hồi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead style="background-color: #53b55a">
                        <tr>
                            <td style="width:94px">Ngày p/hồi</td>
                            <td>Người p/hồi</td>
                            <td>Nội dung p/hồi</td>
                            <td style="width:86px">Trạng thái</td>
                        </tr>
                    </thead>
                    <tbody class="foreach_feedback">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#content_feedback').on('hidden.bs.modal', function (e) {
        $('#content_feedback .foreach_feedback').html('')
    })
    $('.content_feedback').on('click', function() {
        var job_id = $(this).attr('data-id')
        $.ajax({
            'type': 'get',
            'url': "{{ route('show_modal_feedback') }}",
            'data': { job_id },
            'success': (req) => {
                var html =''
                req.forEach(element => {
                    let status = ''
                    let created_at = new Date(element.created_at)
                    let formatted_created_at = created_at.getDate() + "-" + (created_at
                    .getMonth() + 1) + "-" + created_at.getFullYear()
                    if (element.status == 1) {
                        status = `<span class="text-success">Đã duyệt</span>`
                    } else {
                        status = `<span class="text-danger">Chưa duyệt</span>`
                    }
                    html += `
                    <tr>
                        <td><p class="crop">${formatted_created_at}</p></td>
                        <td><p class="crop">${element.user_name}</p></td>
                        <td><p>${element.feedback}</p></td>
                        <td><p class="crop">${status}</p></td>
                    </tr>
                    `
                });
                $('#content_feedback .foreach_feedback').html(html)
            }
        })
    })
</script>
@endsection
