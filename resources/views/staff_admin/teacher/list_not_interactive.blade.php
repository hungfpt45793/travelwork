@extends('staff_admin.layouts.master')

@section('title', 'Danh sách giáo viên' )

@section('content')
<div id="tbody"></div>
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.teacher')
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

                    {{-- <form role="form" action="{{ route('send_post_content_teacher') }}" method="POST" enctype="multipart/form-data" id="form_register"> --}}
                        {{-- {!! csrf_field() !!}
                        {{ method_field('POST') }} --}}
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-start">
                                <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a>

                                <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                        <form action="">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm giáo viên chưa tương tác</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">

                                                    <div class="row">

                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                            <label for="validationDefault01">Từ ngày</label>
                                                            @php
                                                                    $d=strtotime("-1 Months");
                                                                    $date = date("Y-m-d", $d)
                                                            @endphp
                                                            <input value="{{ $date }}" class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : '' }}" type="date" id="" name="date_search_start">
                                                            </div>
                                                        </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                            <label for="validationDefault02">Đến ngày</label>
                                                            <input value="{{ date("Y-m-d") }}" class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : '' }}" type="date" id="" name="date_search_end">
                                                            </div>
                                                        </div>
                                                        <!-- myDatetime -->
                                                        <div class="col-md-2 mb-3">
                                                            <label for="validationDefault2" class="text-light">sd</label>
                                                            <input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày"></input>
                                                        </div>
                                                        <div class="col-md-4 col-xs-6 ">
                                                            <div class="form-group">
                                                                <?php
                                                                    $career_category_id_get = '';
                                                                    if (isset($_GET['career_category_id'])) {
                                                                        $career_category_id_get = $_GET['career_category_id'];
                                                                    }
                                                                    ?>
                                                                <select class="js-example-basic-single form-control select2" id="career_category_id"
                                                                    name="career_category_id">
                                                                    <option value="">--chọn công việc--</option>
                                                                    <?php
                                                                        $career = \App\Entity\Career::getAllCareer();
                                                                    ?>
                                                                    @foreach($career as $car)
                                                                    <option value="{{$car->career_category_id}}" @if($car->career_category_id ==
                                                                        $career_category_id_get) selected @endif
                                                                        >{{$car->career_category_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <select class="js-example-basic-single form-control select2" name="status_accounting"
                                                                    id="status_accounting">
                                                                    <option value="">--Chuyển tài khoản--</option>
                                                                    <option value="0" @if(isset($_GET['status_accounting']) &&
                                                                        $_GET['status_accounting']==0 && $_GET['status_accounting'] != '') selected @endif>--Chưa chuyển--</option>
                                                                    <option value="1" @if(isset($_GET['status_accounting']) &&
                                                                        $_GET['status_accounting']==1) selected @endif>--Đã chuyển--</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <select class="js-example-basic-single form-control select2" name="is_delete"
                                                                    id="is_delete">
                                                                    <option value="">--Đề nghị xóa--</option>
                                                                    <option value="1" @if(isset($_GET['is_delete']) &&
                                                                        $_GET['is_delete']==1) selected @endif>--Không--</option>
                                                                    <option value="2" @if(isset($_GET['is_delete']) &&
                                                                        $_GET['is_delete']==2) selected @endif>--Có--</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-xs-6">
                                                            <div class="form-group">
                                                                <select class="js-example-basic-single form-control select2" id="province"
                                                                    name="province">
                                                                    <option value="">--Tỉnh/Thành phố--</option>
                                                                    @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                                    <option value="{{$province->province_id}}" @if(isset($_GET['province']) &&
                                                                        $_GET['province']==$province->province_id) selected @endif>
                                                                        {{$province->province_name}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <?php
                                                                $district_get = '';
                                                                if (isset($_GET['district'])) {
                                                                    $district_get = $_GET['district'];
                                                                }
                                                                ?>
                                                                <select class="js-example-basic-single form-control select2" name="district"
                                                                    id="district">
                                                                    <option value="0">--Chọn quận/huyện</option>
                                                                    @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                                    <option value="{{$district->district_id}}" @if(isset($_GET['district']) &&
                                                                        $_GET['district']==$district->district_id) selected @endif>
                                                                        {{$district->district_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-4 col-xs-6 ">
                                                            <div class="form-group">
                                                                <input type="text " placeholder="Tên giáo viên" class="form-control form-control-sm"
                                                                    id="teacher_name" name="teacher_name" @if(isset($_GET['teacher_name']))
                                                                    value="{{ $_GET['teacher_name'] }}" @endif>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="email " placeholder="Email giáo viên" class="form-control form-control-sm"
                                                                    id="email" name="email" @if(isset($_GET['email']))
                                                                    value="{{ $_GET['email'] }}" @endif>
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
                                <a href="{{ route('getListTeacher_not_interactive') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                                <a href="{{ route('staff_teacher.create') }}"><button class="btn btn-sm mr-1 btn-success">Thêm mới</button></a>
                                <button  type="button" class="btn btn-sm mr-1 btn-warning" data-toggle="modal" data-target="#myModal1">Phản hồi</button>
                                <button  type="button" class="btn btn-sm mr-1 btn-danger delete_request">Đề nghị xóa</button>
                            </div>
                            <div class="custom-paginate row mt-1 ml-1">
                                {{ $teachers->links() }}
                                số bản ghi của một trang:
                                <span class="input-submit">
                                    <form action="{{ route('staff_advisory_employee.index') }}" class="inline">
                                        <input type="submit" value="200" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
                                        <input type="submit" value="50" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
                                        <input type="submit" value="40" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
                                        <input type="submit" value="30" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
                                        <input type="submit" value="20" name="num"  class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
                                        <input type="submit" value="10" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
                                    </form>
                                </span>
                                | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $total }} bản ghi
                            </div>
                        </div>
                        {{-- <div class="col-md-12 space-b">
                            @if(isset($_GET['district']))
                            @php
                                $district_name = App\Entity\District::where('district_id',$_GET['district'])->value('district_name');
                            @endphp
                            <b class="">Danh sách giáo viên huyện {{ $district_name }}( <span
                            style="color: rgb(220, 53, 69)">{{ App\Http\Controllers\Staff\TeacherController::countTeacherD($_GET['district']) }}</span>
                        )</b>
                        @endif

                    </div> --}}
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
                                        <textarea class="form-control error_border_feedback_all" id="feedback_all" name="feedback_all" rows="6" cols="80" required placeholder="Nhập phản hồi"/></textarea>
                                        <div class="mess_notice_feedback_all clearfix note_text_feedback_all"></div>
                                        <div class="error_reg_mess clearfix error_text_feedback_all"></div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary send1" id="js_btnRegidit">Gửi</button>
                                    </div>
                                </div>
                            {{-- </form> --}}


                        </div>
                      </div>

                    <div class="col-md-12 col-12">
                        <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                            <div class="lockedWrap lockedWrap-first">
                                <div class="cellWrap cellWrap-first">
                                    <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                </div>
                                @foreach ($teachers as $teacher)
                                <div class="cellWrap">
                                    <input type="checkbox" id_customer="{{ $teacher->teacher_id }}" class="checkItem js_checkbox_checked" value="{{ $teacher->teacher_id }}" name="teacher_id[]">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                            <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                            <thead>
                                <tr>
                                    {{-- <td>
                                        <input type="checkbox" class="btn btn-primary" id="checkAllSendMail">
                                    </td> --}}
                                    <td class="lid_1"><p style="width:60px">id<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                    <td class="lid_2"><p style="width:100px">Thao tác<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                    <td class="lid_3"><p style="width:100px">Ngày tạo<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                    <td class="lid_4"><p style="width:250px">Tên giáo viên<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                    <td class="lid_5"><p style="width:250px">Địa chỉ<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                    <td class="lid_6"><p style="width:250px">Khu vực<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                    <td class="lid_7"><p style="width:60px">CTK<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>
                                    <td class="lid_8"><p style="width:70px">ĐN/xóa<button class="lockButton btn btn-sm btn-success" id="lid_8">L</button></p></td>
                                    <td class="lid_9"><p style="width:50px">KN<button class="lockButton btn btn-sm btn-success" id="lid_9">L</button></p></td>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @foreach ($teachers as $teacher)
                                <tr>
                                    {{-- <td>
                                        <input type="checkbox" id_customer="{{ $teacher->teacher_id }}" class="checkItem js_checkbox_checked" value="{{ $teacher->teacher_id }}" name="teacher_id[]">
                                    </td> --}}
                                    <td class="lid_1">
                                        {{ $teacher->teacher_id }}
                                    </td>
                                    <td class="lid_2">
                                        <a  href="{{ route('interactive_index', ['teacher_id' => $teacher->teacher_id]) }}" class="btn btn-sm btn-info" >Thao tác</a>
                                    </td>
                                    <td class="lid_3">

                                        {{ date_format($teacher->created_at,'d/m/Y') }}
                                    </td>
                                    <td class="lid_4">
                                        {{ $teacher->teacher_name }}
                                    </td>
                                    <td class="lid_5">
                                        {{ $teacher->province_name }}
                                    </td>
                                    <td class="lid_6">
                                        {{ $teacher->district_name }}
                                    </td>
                                    <td class="lid_7">
                                        @if ($teacher->status_accounting == 1)
                                            <i class="fas fa-check text-success"></i>
                                        @else
                                        <i class="fas fa-times text-danger"></i>
                                        @endif
                                    </td>
                                    <td class="lid_8">
                                        @php
                                            $check = App\Entity\Teacher_delete_request::where('teacher_id', $teacher->teacher_id)->first();
                                            if ($check != null) {
                                                echo '<i class="fas fa-check text-success"></i>';
                                            } else {
                                                echo '<i class="fas fa-times text-danger"></i>';
                                            }
                                        @endphp
                                    </td>
                                    <td class="lid_9">
                                        @php
                                             $nowYear = date("Y");
                                            $listExp = App\Entity\Teacher_experience::select('*')
                                                ->where('teacher_id', $teacher->teacher_id)
                                                ->get();


                                            $exp = [];
                                            $exp[$teacher->teacher_id] = null;

                                            if (count($listExp) > 0) {
                                                $minYear = $nowYear;
                                                foreach ($listExp as $key => $value) {
                                                    $star_year = (int)$value['star_working_time'];
                                                    if ($star_year == 0) {
                                                        $minYear = $nowYear;
                                                    } else {
                                                        if ($minYear > $star_year) {
                                                            $minYear = $star_year;
                                                        }
                                                    }
                                                }
                                                $exp[$teacher->teacher_id] = $nowYear - $minYear;
                                            }
                                            if ($exp[$teacher->teacher_id] != null && $exp[$teacher->teacher_id] > 0) {
                                                $string2 = $exp[$teacher->teacher_id];
                                            } else {
                                                $string2 = '0';
                                            }
                                        @endphp
                                        {{ $string2 }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- </div> --}}
                    </div>
                </div>
                    {{-- </form> --}}
        </div>
        </section>
        <!-- The Modal -->
    </div>
</div>
</div>

<script>

    $(function() {
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });
    // var table = $('#example_notiiii').DataTable({
    //     "order": [[ 3, "desc" ]],
    //     "lengthMenu": [
    //         [20, 30, 50, 75, 100, 300, -1],
    //         [20, 30, 50, 75, 100, 300, "ALL"]
    //     ],
    //     processing: true,
    //     serverSide: true,
    //     ajax: {
    //         url: '{!! route('datatable_getListTeacher_not_interactive') !!}',
    //         type: 'GEt',
    //         data: function(d) {
    //             d.province = $('#province').val();
    //             d.status_accounting = $('#status_accounting').val();
    //             d.teacher_name = $('#teacher_name').val();
    //             d.career_category_id = $('#career_category_id').val();
    //             d.district = $('#district').val();
    //             d.email = $('#email').val();
    //             d.is_delete = $('#is_delete').val();
    //         }
    //     },
    //     columns: [{
    //             data: 'teacher_id',
    //             name: 'teacher_id'
    //         },
    //         {
    //             data: 'check_box',
    //             name: 'check_box',
    //             orderable: false,
    //             render: function(data) {
    //                 var id = data.toString();
                    // return id;
            //         return '<input type="checkbox" id_customer="' + id + '" class="checkItem js_checkbox_checked" value="'+ id +'" name="teacher_id[]">';
            //     }
            // },
            // {
            //         data: 'action',
            //         name: 'action',
            //         orderable: false,
            //         searchable: false
            //     },
            // {
            //     data: 'created_at',
            //     name: 'created_at',
            //     render: function(data) {
            //         const date = new Date(data)
            //         const dateTimeFormat = new Intl.DateTimeFormat('en', {
            //             year: 'numeric',
            //             month: '2-digit',
            //             day: '2-digit'
            //         })
            //         const [{
            //             value: month
            //         }, , {
            //             value: day
            //         }, , {
            //             value: year
            //         }] = dateTimeFormat.formatToParts(date)

            //         return (`${day}-${month}-${year }`)

            //     },
            // },
            // {
            //     data: 'teacher_name',
            //     name: 'teacher_name',

            // },
            // {
            //     data: 'province_name',
            //     name: 'province_name'
            // },
            // {
            //     data: 'district_name',
            //     name: 'district_name',

            // },
            // {
            //     data: 'status_accounting',
            //     name: 'status_accounting',

            //     render: function(data) {
            //         if (data == 1) {

            //             return '<i class="fas fa-check text-success"></i>';
            //         } else {
            //             return '<i class="fas fa-times text-danger"></i>';
            //         }

            //     }

            // },
            // {
            //         data: 'is_delete',
            //         name: 'is_delete',
            //         orderable: false,
            //         searchable: false,
            //         render: function(data) {
            //             if (data == 1) {

            //                 return '<span style="color: red">Có</span>';
            //             } else {
            //                 return '<span style="color: green">Không</span>';
            //             }
            //         }
            //     },
            // {
            //         data: 'exp',
            //         name: 'exp',
            //         orderable: false,
            //         searchable: false
            //     },
            // {
            //     data: 'teacher_id',
            //     name: 'teacher_id',

            //     render: function(data) {
            //         return `
            //             <div class="button-group">
            //                 <button type="button" class="btn btn-info" data-toggle="modal"
            //                     data-target="#lienlac${ data }">Liên lạc</button>

            //             </div>

            //             `
            //     }

            // },

        // ],
    //     "oLanguage": {
    //         "sProcessing": "Đang xử lý...",
    //         "sLengthMenu": "Xem _MENU_ mục",
    //         "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
    //         "sInfo": "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
    //         "sInfoEmpty": "Đang xem 0 đến 0 trong tổng số 0 mục",
    //         "sInfoFiltered": "(được lọc từ _MAX_ mục)",
    //         "sInfoPostFix": "",
    //         "sSearch": "Tìm:",
    //         "sUrl": "",
    //         "oPaginate": {
    //             "sFirst": "Đầu",
    //             "sPrevious": "Trước",
    //             "sNext": "Tiếp",
    //             "sLast": "Cuối"
    //         }
    //     }

    // });
    // end datatable
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
                    changeHtml2+=        'Vui lòng chọn giáo viên';
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
                        url: '{{route("staff_teacher_delete_all_request")}}',
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
    $('.d-card').hide();
    $('.d-plus').click(function() {
        $('.d-card').fadeToggle();
    })


    //
    $('.searchplus').click(function() {
        $('#example_notiiii').DataTable().draw(true);
    });
    $('#btnFiterSubmitSearch').click(function() {
        $('#laravel_datatable').DataTable().draw(true);
    });


    $('#province').change(function() {
        $.get('/admin/ajax-district/' + $(this).val(), function(data) {
            $('#district').html(data);
        })
    });
    $('#checkAllSendMail').click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
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
                changeHtml2+=        'Vui lòng chọn giáo viên';
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
                        url: '{{route("SendFeedbackAllTeacher")}}',
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
        }
    });
});

</script>
@endsection
