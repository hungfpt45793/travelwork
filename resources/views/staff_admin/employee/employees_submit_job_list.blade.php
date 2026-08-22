<?php
//1
    $date_search_start = '';
    if(isset($_GET['date_search_start'])){
        $date_search_start = $_GET['date_search_start'];
    }
//2
    $date_search_end = '';
    if(isset($_GET['date_search_end'])){
        $date_search_end = $_GET['date_search_end'];
    }

    $employee_name = '';
    if(isset($_GET['employee_name'])){
        $employee_name = $_GET['employee_name'];
    }
//9
    $email = '';
    if(isset($_GET['email'])){
        $email = $_GET['email'];
    }

//11
    $num = '';
    if(isset($_GET['num'])){
        $num = $_GET['num'];
    }

?>
@extends('staff_admin.layouts.master')

@section('title', 'Chi tiết hồ sơ')

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
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
                        <div class="custom-paginate first-order row mt-1 ml-1">
                            {{ $employees_submit->links() }}
                            số bản ghi của một trang:
                            <span class="input-submit">
                                <form action="" class="inline">
                                    <input type="submit" value="200" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
                                    <input type="submit" value="50" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
                                    <input type="submit" value="40" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
                                    <input type="submit" value="30" name="num" class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
                                    <input type="submit" value="20" name="num"  class="{{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
                                    <input type="submit" value="10" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
                                    <input type="hidden" name="date_search_start" value="{{ $date_search_start }}">
                                    <input type="hidden" name="date_search_end" value="{{ $date_search_end }}">
                                    <input type="hidden" name="employee_name" value="{{ $employee_name }}">
                                    <input type="hidden" name="email" value="{{ $email }}">
                                </form>
                            </span>
                            | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '30' }}/{{$total + $total_fb}} bản ghi
                        </div>
                        <div class="d-flex justify-content-start second-order">
                            {{-- <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a> --}}
                            <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                    <form action="" method="GET">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm ứng viên</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row employee-search ">
                                                    <div class="col-md-5 mb-3">
                                                        <label for="validationDefault01">Từ ngày(ngày update)</label>
                                                        @php
                                                              $d=strtotime("-1 Months");
                                                              $date = date("Y-m-d", $d)
                                                        @endphp
                                                        <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : $date }}" type="date" id="" name="date_search_start">
                                                    </div>
                                                    <div class="col-md-5 mb-3">
                                                        <label for="validationDefault02">Đến ngày(ngày update)</label>
                                                        <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : date("Y-m-d") }}" type="date" id="" name="date_search_end">
                                                        <input type="hidden" name="num" value="{{$num}}">
                                                    </div>
                                                      <!-- myDatetime -->
                                                    <div class="col-md-2 mb-3">
                                                      <label for="validationDefault2" class="text-light">sd</label>
                                                        <input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày"></input>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <div class="form-group">
                                                            <?php
                                                            $employee_name_get ='';
                                                            if (isset($_GET['employee_name'])) {
                                                                $employee_name_get = $_GET['employee_name'];
                                                            }
                                                            ?>
                                                            <input type="text"
                                                            placeholder="Tên ứng viên" class="form-control "
                                                            name="employee_name"
                                                            value="@if(!empty($employee_name_get)){{$employee_name_get}}@endif">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6  ">
                                                        <div class="form-group">
                                                            <?php
                                                            $email_get ='';
                                                            if (isset($_GET['email'])) {
                                                                $email_get = $_GET['email'];
                                                            }
                                                            ?>
                                                            <input type="text"
                                                            placeholder="Email ứng viên" class="form-control "
                                                            name="email"
                                                            value="@if(!empty($email_get)){{$email_get}}@endif">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="submit " class="btn btn-primary">Tìm kiếm</button>
                                                <input type="reset" class="btn btn-sm btn-success" value="Reset">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <a href="{{ route('list_staff_employee_submit_job', $employee->employee_id) }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                            {{-- <button class="btn btn-sm btn-info export_excel">Excel</button> --}}
                        </div>
                    </div>

                    <div class="row mr-1">

                        <div class="col-md-12">
                            <form action="{{route('exportExcelEmployee')}}" method="get" id="form_export_excel">
                                    {{ csrf_field() }}
                            <div id="locker" data-fl-scrolls class="custom-table table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                    </div>
                                    {{-- hoi anh --}}
                                    @foreach ($employees_submit as $employee)
                                    <div class="cellWrap">
                                        <input type="checkbox" id_customer="{{$employee->submit_job_fb_id}}" class="checkItem" name="list_id[]"
                                        value="{{$employee->submit_job_fb_id}}">
                                    </div>
                                    @endforeach
                                    @foreach ($employees_submit_fb as $employee)
                                    <div class="cellWrap">
                                        <input type="checkbox" id_customer="{{$employee->submit_job_fb_id}}" class="checkItem" name="list_id[]"
                                        value="{{$employee->submit_job_fb_id}}">
                                    </div>
                                    @endforeach
                                    <input type="hidden" name="date_search_start" value="{{ (isset($_GET['date_search_start'])) ? $_GET['date_search_start'] : '' }}">
                                    <input type="hidden" name="date_search_end" value="{{ (isset($_GET['date_search_end'])) ? $_GET['date_search_end'] : '' }}">
                                    <input type="hidden" name="employee_name" value="{{ (isset($_GET['employee_name'])) ? $_GET['employee_name'] : '' }}">
                                    <input type="hidden" name="email" value="{{ (isset($_GET['email'])) ? $_GET['email'] : '' }}">
                                </div>
                            </div>
                            </form>
                                <div class="table-wrapper tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table  data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            {{-- <td scope="col">
                                                <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                            </td> --}}
                                            <td scope="col" class="lid_1"><p style="width:50px">ID<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td scope="col" class="lid_2"><p style="width:80px">Ứng viên<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td scope="col" class="lid_3"><p style="width:112px">Công việc<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td scope="col" class="lid_4"><p style="width:101px">Slug<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td scope="col" class="lid_5"><p style="width:119px">Ngày nộp hồ sơ<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees_submit as $employee)
                                        <tr>
                                            <td scope="row" class="lid_1">{{ $employee->submit_job_fb_id }}</td>
                                            <td class="lid_2">{{ $employee->employee_name }}</td>
                                            <td class="lid_3">{{ $employee->title }}</td>
                                            <td class="lid_4">
                                                <a target="_blank" href="{{ route('job_detail', $employee->slug) }}">{{ $employee->title }}</a>
                                            </td>
                                            <td class="lid_5">
                                                <?php
                                                    $date=date_create($employee->day_submit_job);
                                                    echo date_format($date,"d/m/Y");
                                                ?>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @foreach ($employees_submit_fb as $employee_fb)
                                        <tr>
                                            <td scope="row" class="lid_1">{{ $employee_fb->submit_job_fb_id }}</td>
                                            <td class="lid_2">{{ $employee_fb->employee_name }}</td>
                                            <td class="lid_3">{{ $employee_fb->title }}</td>
                                            <td class="lid_4">
                                                <a target="_blank" href="{{ route('job_detail', $employee_fb->slug) }}">{{ $employee_fb->title }}</a>
                                            </td>
                                            <td class="lid_5">
                                                <?php
                                                    $date=date_create($employee_fb->day_submit_job);
                                                    echo date_format($date,"d/m/Y");
                                                ?>
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
            <!-- The Modal -->
        </div>
    </div>
</div>
<div id="myModal2" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {{-- <form role="form" action=""  method="POST" id="send_feedback_all_teacher"> --}}
      <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Trình độ ứng viên</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="CV bgrWhite radius5   mgb20 pdb5">
                        <div class="content">
                            <div class="row">
                                <?php
                                    // $specialize = \App\Entity\Employee_specialize::select('*')->where('employee_id', $id)->orderBy('specialize_id', 'asc')->get();
                                ?>
                                <div class="col-md-12 mgt15">
                                    {{-- @if(!empty($specialize)) --}}
                                        <div class="col-xl-12 col-lg-12 left">
                                            <div class="boxSchool" id="specialize">


                                            </div>


                                        </div>
                                    {{-- @endif --}}

                                </div>

                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        {{-- </form> --}}


    </div>
  </div>
  <div id="myModal3" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {{-- <form role="form" action=""  method="POST" id="send_feedback_all_teacher"> --}}
      <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kinh nghiệm ứng viên</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                        <div class="content">
                            <div class="row">

                                <div class="col-md-12  mgt15">
                                    {{-- <div class="title mgt20">
                                        <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter  sm-w100 sm-mgt20 clred">
                                            Kinh nghiệm làm việc
                                        </div>
                                    </div> --}}
                                    <div class="col-xl-12 col-lg-12 left">
                                        {{-- @if(!empty($experience)) --}}
                                            <div class="boxSchool" id="experience">

                                            </div>

                                        {{-- @endif --}}

                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        {{-- </form> --}}


    </div>
  </div>
  <script>
    $(document).ready(function(){
 //
 $('#province').change(function () {
     $.get('/admin/ajax-district/' + $(this).val(), function (data) {
         $('#district').html(data);
     })
 });
});
</script>
    <script>
        $('.xem_spec').click(function(){

            var id = $(this).attr('employee_id');
            var changeHtml = '';
            $.ajax({
                type: 'post',
                url: '{{route("staff_look_spec_employee")}}',
                data: {id: id},
                success: function (data) {
                    let specialize = data.specialize;
                    let literacy   = data.literacy;
                    console.log(data.specialize);
                // changHtml += '<div class="" id="getDataByCategory">';
                for (var i = 0; i < specialize.length; i++) {
                    changeHtml += '<div class="deleteItemSpec">';
                    changeHtml +=    '<p class="clorange f18" style="font-weight: bold;margin-bottom: 10px;">Thời gian: '+specialize[i].star_specialize_time+'-'+specialize[i].end_specialize_time +'</p>';
                    changeHtml +=    '<div class="form-row ">';
                    changeHtml +=        '<div class="col-lg-6 pdr2p lg-pd0Im">';
                    changeHtml +=             '<label for="inputZip" class="fw6">Tên trường : <span class="clhome">'+specialize[i].school+'</span></label>';
                    changeHtml +=        '</div>';
                    changeHtml +=        '<div class="col-lg-6 pdr2p lg-pd0Im">';
                    changeHtml +=            '<label for="inputZip" class="fw6">Trình độ : <span class="clhome">';
                    for (var j = 0; j < literacy.length; j++) {
                        if(specialize[i].leve == literacy[j].literacy_id)  {
                            changeHtml += literacy[j].literacy_name;
                        }
                    }
                    changeHtml += '</span></label>';

                    changeHtml += '    </div>';
                    changeHtml += '</div>';
                    changeHtml +=    '<div class="form-row">';
                    changeHtml +=        '<div class="col-lg-6 pdr2p lg-pd0Im">';
                    changeHtml +=             '<label for="inputZip" class="fw6">Ngành học : <span class="clhome">' + specialize[i].majors+'</span></label>';
                    changeHtml += '    </div>';
                    changeHtml += '        <div class=" col-lg-6 pdr2p lg-pd0Im">';
                    changeHtml += '            <label for="inputZip" class="fw6">Tình trạng : <span  class="clhome">' + specialize[i].specialize_status+'</span></label>';
                    changeHtml += '    </div>';
                    changeHtml += '</div>';
                    changeHtml +=     '<hr class="" style="border-top: 1px dotted #ccc">';
                    changeHtml +=     '</div>';
                }
                $('#specialize').html(changeHtml);

    // $('#myModal2').modal('show');
                $('#myModal2').modal('show');
                },
                error: function (err) {
                    changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml+=        'Đã có lỗi xảy ra';
                    changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                    changeHtml+=    '</div>';
                    changeHtml+= '</div>';
                    $('.log_error').html(changeHtml);
                }
            });
        });
        $('.xem_exp').click(function(){
            var id = $(this).attr('employee_id');
            var changeHtml = '';
            $.ajax({
                type: 'post',
                url: '{{route("staff_look_exp_employee")}}',
                data: {id: id},
                success: function (data) {
                    var experience = data.experience;
                    var literacy   = data.literacy;
                    console.log(data);
                // changHtml += '<div class="" id="getDataByCategory">';
                for (var i = 0; i < experience.length; i++) {
                    changeHtml += '<div class="deleteItemSpec">';
                    changeHtml +=    '<p class="clorange f18" style="font-weight: bold;margin-bottom: 10px;">Thời gian: '+experience[i].star_working_time+'-'+experience[i].end_working_time +'</p>';
                    changeHtml +=    '<div class="form-row ">';
                    changeHtml +=        '<div class="col-lg-12 pdr2p lg-pd0Im">';
                    changeHtml +=             '<label for="inputZip" class="fw6">Công ty đã làm việc : <span class="clhome">'+experience[i].company+'</span></label>';
                    changeHtml +=        '</div>';
                    changeHtml +=        '<div class="col-lg-12 pdr2p lg-pd0Im">';
                    changeHtml +=            '<label for="inputZip" class="fw6">Vị trí công việc :<span class="clhome">'+experience[i].position;
                    changeHtml += '</span></label>';
                    changeHtml += '    </div>';
                    changeHtml +=        '<div class="col-lg-12 pdr2p lg-pd0Im">';
                    changeHtml +=             '<label for="inputZip" class="fw6">Mô tả công việc : <span class="clhome">' + experience[i].des_position+'</span></label>';
                    changeHtml += '    </div>';
                    changeHtml += '</div>';
                    changeHtml +=     '<hr class="" style="border-top: 1px dotted #ccc">';
                    changeHtml +=     '</div>';
                }
                $('#experience').html(changeHtml);
                $('#myModal3').modal('show')    ;
                },
                error: function (err) {
                    changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml+=        'Đã có lỗi xảy ra';
                    changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                    changeHtml+=    '</div>';
                    changeHtml+= '</div>';
                    $('.log_error').html(changeHtml);
                }
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
                        url: '{{route("staff_employee_delete_all_request")}}',
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
        $('.approved_all_employee').click(function(){
            var x = confirm("Bạn có chắc chắc muốn duyệt?");
            if (x){
                var Ids = [];
                $.each($(".checkItem:checked"), function () {
                    Ids.push($(this).val());
                });

                if(Ids.length == 0){
                    var changeHtml3 = '';
                    changeHtml3+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                    changeHtml3+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                    changeHtml3+=        'Vui lòng chọn ứng viên';
                    changeHtml3+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                    changeHtml3+=    '</div>';
                    changeHtml3+= '</div>';
                    $('.log_error').html(changeHtml3);
                    event.preventDefault();
                }
                else{
                    var content = $("#feedback_all").val();
                    var changeHtml = '';
                    $.ajax({
                        type: 'post',
                        url: '{{route("approved_all_employee")}}',
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

    $('#checkAllSendMail').click(function () {
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
                var content = $("#feedback_all").val();
                var changeHtml = '';
                $.ajax({
                    type: 'post',
                    url: '{{route("SendFeedbackAllEmployee")}}',
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
    });
    $('.export_excel').click(function () {
        $('form#form_export_excel').submit();
    })
    </script>
@endsection
