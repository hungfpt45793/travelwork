@extends('staff_admin.layouts.master')

@section('title', 'Danh sách việc làm NTD vip' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
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
                    {{-- <form role="form" action="{{ route('approved_all_job') }}" method="POST"> --}}
                    <div class="row ">
                        <div class="col-md-12">

                            <div class="d-flex justify-content-start">
                                <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a>
                                <a href="{{ route('staff_job_ntd_job_vip') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                                <button  type="button" class="btn btn-sm btn-danger delete_request mr-1">Đề nghị xóa</button>
                                <a href="{{ route('update_job_code_with_staff') }}" class="btn btn-warning mr-1 btn-sm ">Cập nhập mã tin</a>
                                <a href="{{ route('form_create_job') }}" class="btn btn-success btn-sm mr-1 ">Thêm mới</a>
                                <button  type="button" class="btn btn-sm mr-1 btn-warning" id="response">Phản hồi</button>
                                <button class="btn btn-sm mr-1 btn-info approved_all_job">Duyệt</button>
                                <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                        <form action="">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm ứng viên đăng ký tư vấn</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">

                                                    <div class="form-row employee-search ">
                                                        <div class="col-md-5 mb-3">
                                                            <label for="validationDefault01">Từ ngày(update)</label>
                                                            @php
                                                                  $d=strtotime("-1 Months");
                                                                  $date = date("Y-m-d", $d)
                                                            @endphp
                                                            <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : $date }}" type="date" id="" name="date_search_start">
                                                          </div>
                                                          <div class="col-md-5 mb-3">
                                                            <label for="validationDefault02">Đến ngày(update)</label>
                                                            <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : date("Y-m-d") }}" type="date" id="" name="date_search_end">
                                                          </div>
                                                          <!-- myDatetime -->
                                                    <div class="col-md-2 mb-3">
                                                            <label for="validationDefault2" class="text-light">sd</label>
                                                            <input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày"></input>
                                                        </div>
                                                        <div class="col-md-4 col-xs-6  ">
                                                            <div class="form-group">
                                                                <select class="js-example-basic-single form-control select2" name="career_category_id">
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
                                                                <select class="js-example-basic-single form-control select2" name="jobGroup">
                                                                    <option value="">--Nhóm việc làm--</option>
                                                                    <?php $jobGroup_get = isset($_GET['jobGroup']) ? $_GET['jobGroup'] : '';?>
                                                                    @foreach(\App\Entity\JobGroup::orderBy('job_group_name')->get() as $jobGroup)
                                                                        <option value="{{$jobGroup->job_group_id}}"
                                                                                @if($jobGroup->job_group_id == $jobGroup_get) selected
                                                                                @endif >{{$jobGroup->job_group_name	}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <select class="js-example-basic-single form-control select2" name="employer_id">
                                                                    <option value="">--Nhà tuyển dụng--</option>
                                                                    <?php $employer = \App\Entity\Employer::getselectNameId();
                                                                        $employer_id_get = isset($_GET['employer_id']) ? $_GET['employer_id'] : '';
                                                                        print_r($employer_id_get);
                                                                        ?>
                                                                        @foreach($employer as $eplo)
                                                                        <option value="{{ $eplo->employer_id }}" @if($employer_id_get == $eplo->employer_id ) selected @endif > {{ $eplo->enterprise_name }} </option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <?php $title_get = isset($_GET['title']) ? $_GET['title'] : '';?>
                                                                <input type="text "  placeholder="Tên việc làm" class="form-control form-control-sm" name="title" value="{{ $title_get }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-xs-6 ">
                                                            <div class="form-group">
                                                                <select class="js-example-basic-single form-control select2" name="literacy ">
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
                                                                <select class="js-example-basic-single form-control select2" name="sale ">
                                                                    <option value="">--Gói bán hàng--</option>
                                                                    <?php $sale_get = isset($_GET['sale']) ? $_GET['sale'] : '';?>
                                                                    @foreach(\App\Entity\Sale::orderBy('sale_package_name')->get() as $sale)
                                                                        <option value="{{$sale->sale_package_id}}"
                                                                                @if($sale->sale_package_id == $sale_get) selected
                                                                                @endif
                                                                        >{{$sale->sale_package_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <select class="js-example-basic-single form-control select2" name="province">
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
                                                                <?php $email_get = isset($_GET['email']) ? $_GET['email'] : ''; ?>
                                                                <input type="email " placeholder="Email nhà tuyển dụng " class="form-control form-control-sm " name="email" value="{{ $email_get }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-xs-6 ">
                                                            <div class="form-group">
                                                                <select class="js-example-basic-single form-control select2" name="district">
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
                                                                <select class="js-example-basic-single form-control select2" name="active_job"
                                                                    id="active_job">
                                                                    <option value="" @if(isset($_GET['active_job']) &&
                                                                    $_GET['active_job']=="")selected @endif>--Trạng thái--</option>
                                                                    <option value="0" @if(isset($_GET['active_job']) &&
                                                                        $_GET['active_job']==0) selected @endif>--Chưa duyệt--</option>
                                                                    <option value="1" @if(isset($_GET['active_job']) &&
                                                                        $_GET['active_job']==1) selected @endif>--Đã duyệt--</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <?php $vip_get = isset($_GET['vip']) ? $_GET['vip'] : '';?>
                                                                <select class="form-control js-example-basic-single select2" name="vip" id="">
                                                                    <option value="" selected> -- Loại tin --</option>
                                                                    <option value="0" @if($vip_get == '0') selected @endif > Tin thường </option>
                                                                    <option value="1" @if($vip_get == '1') selected @endif > Tin Vip </option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <?php $job_code_get = isset($_GET['job_code']) ? $_GET['job_code'] : '';?>
                                                                <input type="text" placeholder="Mã tin" class="form-control form-control-sm" name="job_code" value="{{ $job_code_get }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit " class="btn btn-primary">Tìm kiếm</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                            <div class="custom-paginate row mt-1 ml-1">
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
                                | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $total_job }} bản ghi
                            </div>
                        </div>
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
                                        <p> <input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                    </div>
                                    @foreach ($jobs as $job)
                                    <div class="cellWrap">
                                        <input type="checkbox" id_customer="{{$job->job_id}}" class="checkItem" name="list_id[]"
                                                    value="{{$job->job_id}}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            {{-- <td scope="col ">
                                                <input type="checkbox" class="btn btn-primary" id="checkAllSendMail">
                                            </td> --}}
                                            <td class="lid_1"><p style="width: 90px;">Mã tin<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td class="lid_2"><p style="width: 80px;">Thao tác<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td class="lid_3"><p style="width: 80px;">Update<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td class="lid_4"><p style="width: 350px;">Tên NTD<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td class="lid_9"><p style="width: 50px;">Link<button class="lockButton btn btn-sm btn-success" id="lid_9">L</button></p></td>
                                            <td class="lid_10"><p style="width:70px;">TT<button class="lockButton btn btn-sm btn-success" id="lid_10">L</button></p></td>
                                            <td class="lid_5"><p style="width: 250px;">Email<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            <td class="lid_6"><p style="width: 300px;">Tên việc<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                            <td class="lid_7"><p style="width: 104px;">Hạn nộp đơn<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>
                                            <td class="lid_8"><p style="width: 70px;"><i class="fas fa-eye"></i><button class="lockButton btn btn-sm btn-success" id="lid_8">L</button></p></td>


                                            <td class="lid_11"><p style="width: 104px;">Người TT<button class="lockButton btn btn-sm btn-success" id="lid_11">L</button></p></td>
                                            <td class="lid_12"><p style="width: 190px;">Ngày TT<button class="lockButton btn btn-sm btn-success" id="lid_12">L</button></p></td>
                                            {{-- <td scope="col ">Thao tác</td> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jobs as $job)
                                        <tr>
                                            {{-- <td data-title="Tích chọn phản hồi" class="numeric">
                                                <input type="checkbox" id_customer="{{$job->job_id}}" class="checkItem" name="list_id[]"
                                                    value="{{$job->job_id}}">
                                            </td> --}}
                                            <td class="lid_1">{{ $job->job_code }}</td>
                                            {{-- <td class="lid_1" scope="col ">
                                                <input type="checkbox" class="btn btn-primary" id="checkAllSendMail">
                                            </td> --}}
                                            <td class="lid_2">
                                                <div class="button-group">
                                                    <div class="button-group">
                                                        <div class="button-group">
                                                            <a href="{{ route('detail_job_with_staff_admin', $job->job_id) }}">
                                                                <button type="button" class="btn btn-sm btn-info">Thao tác</button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="lid_3">
                                                <!-- @if(!empty($job->updated_at)) -->
                                                {{ date_format(date_create($job->updated_at),"d/m/Y") }}
                                                <!-- @else

                                                {{ date_format(date_create($job->created_at),"d/m/Y") }}
                                                @endif -->
                                            </td>
                                            <td class="lid_4">
                                                <?php
                                                $employer = \App\Entity\Employer::getIdemployer($job['employer_id']);
                                                ?>
                                                @if(isset($employer['enterprise_name']))
                                                <p class="crop" style="width:350px">{{ $employer['enterprise_name'] }}</p>
                                                @endif
                                            </td>
                                            <td class="lid_9"><a href="{{ route('job_detail',['slug'=> $job['slug']]) }}" target="_blank">Link </a></td>
                                            <td class="lid_10">
                                                @if($job->active_job == 0)
                                                   <p class="crop text-danger">Chưa duyệt</p>
                                                @else <p class="crop text-success">Đã duyệt</p>
                                                @endif
                                            </td>
                                            <td class="lid_5">
                                                <p class="crop" style="width:250px">{{ $job->email }}</p>
                                            </td>
                                            <td class="lid_6"><p class="crop" style="width:300px">{{ $job->title }}</p></td>
                                            <td class="lid_7">
                                            <?php
                                                $date = date_create($job->deadline_submit_profile);
                                                echo date_format($date, "d/m/Y");
                                            ?>
                                            </td>
                                            <td class="lid_8">{{ $job->views }}</td>



                                            <td class="lid_11">
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
                                            <td class="lid_12">
                                                @if($check_job_handling != null)
                                                    {{$check_job_handling->created_at}}
                                                @endif
                                            </td>

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
                            console.log(data)
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
            if(Ids.length == 0){
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
</script>
@endsection
