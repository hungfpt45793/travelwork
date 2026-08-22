@extends('site.layout_site.site')
<?php
$meta_employee = \App\Entity\Config_meta::getslug('danh-sach-ung-vien');
?>
@section('type_meta', 'website')
@section('title', !empty($meta_employee->meta_title) ? $meta_employee->meta_title :'Danh sách ứng viên')
@section('meta_description', !empty($meta_employee->meta_description) ? $meta_employee->meta_description :'Danh sách ứng viên')
@section('keywords', !empty($meta_employee->meta_keywords) ? $meta_employee->meta_keywords :'Danh sách ứng viên')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : ''  )

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/tab_filter.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/list_employee.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/modal_detail_cv_employee.css"/>

@endsection
@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">

                @if(\Illuminate\Support\Facades\Auth::check())
                    @include('site.sidebar_site.sidebar_job')
                @else
                    @include('site.sidebar_site.sidebar_no_login_employer')
                @endif

                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a class=""
                                   href="{{ route('show_employee') }}">Danh sách ứng viên</a>
                            </li>
                        </ul>
                    </div>

                    <div class="btn_show_sidebar dsNone mbdsBlock" id="js_filter_job_face">
                        <ul class="nav">
                            <li class="nav-item">
                                <a style="color: #fff" class="js_show_sidebar clWhite"><i class="fas fa-bars"></i> Menu
                                    <i class="fas fa-angle-up js_closed_open"></i> </a>
                            </li>

                        </ul>
                    </div>

                    <div class="mbdsNone js_filter_job_face">
                        @include('site.filter_site.filter_search_employee')
                    </div>

                    <section class="section_box_content mgt20">
                        <div class="header_box">
                            <h1 class="title_box  fw6 f20 mgb0 col-f14">
                                Ứng viên nổi bật
                            </h1>

                        </div>
                        <div class="content_box_employee">
                            @foreach($vip_employee as $employee)
                                @include('site.employee_site.item_employee_new',['employee' => $employee])
                            @endforeach
                        </div>
                    </section>

                    <section class=" bgWhite mgt20">
                        <div class="row">
                            <div class="col-12 text-center">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php
                                        $link_back = 1;
                                        $link_next = 2;
                                        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
                                        if ($page > 1) {
                                            $link_back = $page - 1;
                                            $link_next = $page + 1;
                                        }
                                        ?>
                                        <li class="page-item">
                                            <a style="background: #28a745;color: #fff;" class="page-link"
                                               href="{{ url()->current().'?page='.$link_back }}">Quay lại</a>
                                        </li>
                                        <li class="page-item"><a style="background: #28a745;color: #fff;"
                                                                 class="page-link"
                                                                 href="{{ url()->current().'?page='.$link_next }}">Tiếp
                                                theo</a>
                                        </li>
                                    </ul>
                                </nav>
                                {{--@include('site.default.item_pani',['page_link' => $vip_employee])--}}
                            </div>
                        </div>
                    </section>

                    {{--@include('site.jobs_site.item_filter_employee')--}}
                </div>
            </div>
        </div>
    </section>


    <?php $infomation_coin_employer = \App\Entity\Coin_type_information_employer::get_coin_info(); ?>
    {{--//truong hop chua dang nhap--}}
    <!-- modal cv ung vien -->
    @foreach($vip_employee as $employee)
        <div class="modal detailEmployee fade" id="js_employee_{{ $employee->employee_id }}" tabindex="-1"
             role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12 col-12 col-md-12 col-lg-8 col-xl-8 col_pdf pl-0 order-sm-12 order-12 order-md-12 order-lg-1 order-xl-1 d-flex justify-content-center align-items-center">
                                <h3 class="text-center loading_cv" style="display:none">
                                    <i class="fas fa-spinner fa-pulse"></i> Đang tải CV...
                                </h3>
                                <?php
                                $check_show_cv = '';
                                $check_show_employee = '';
                                if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)
                                {
                                    $employer = \App\Entity\Employer::get_employer_id(\Illuminate\Support\Facades\Auth::user()->id);
                                    $check_show_cv = \App\Entity\Employee_upload_cv::check_employee_cv_status($employee->employee_id);
                                    $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee->employee_id);
                                }

                                ?>
                                @if(!empty($check_show_cv))
                                    @if(!empty($check_show_employee))
                                        <?php
                                        $link_cv_upload = str_replace('/public', '', $cv_upload->employee_link_cv);
                                        $link_cv_upload = asset($link_cv_upload);
                                        ?>
                                        <iframe class="iframe_cv_employee"
                                                src="https://docs.google.com/viewer?url={{ $link_cv_upload }}&amp;embedded=true#toolbar=0"
                                                loading=""
                                                style="width: 100%; height: 95vh; position: absolute; top: 0px;">
                                        </iframe>
                                    @else
                                        <img class="img_cv_employee" src="/public/image_cv_upload/cv_upload.jpg" alt="" style="height:95vh">
                                    @endif
                                @else
                                    @if(!empty($check_show_employee))
                                        <iframe  class="iframe_cv_employee"
                                                 src="https://docs.google.com/viewer?url={{ route('exportpdf_cv_user_id',['user_id'=> $employee->user_id]) }}&amp;embedded=true#toolbar=0"
                                                 loading=""
                                                 style="width: 100%; height: 95vh; position: absolute; top: 0px;">

                                        </iframe>
                                    @else
                                        <iframe  class="iframe_cv_employee"
                                                 src="https://docs.google.com/viewer?url={{ route('employer_exportpdf_cv_user_id',['user_id'=> $employee->user_id]) }}&amp;embedded=true#toolbar=0"
                                                 loading=""
                                                 style="width: 100%; height: 95vh; position: absolute; top: 0px;">

                                        </iframe>
                                    @endif
                                @endif
                                <div class="show_cv_2" style="width:100%">

                                </div>
                            </div>
                            <div class="col-sm-12 col-12 col-md-12 col-lg-4 col-xl-4 pl-0 col_info order-1 order-xl-12 order-md-1 order-xs-1 order-lg-12"
                                 style="overflow: scroll">
                                <button style="background:#f7921a; color:#fff" class="btn btn-sm reload_cv disOnMobile">
                                    Tải lại cv
                                </button>
                                <div class="js_content_appen"></div>
                                <ul class="list-group ul_action">
                                    <li class="list-group-item cus-list-group-item">
                                        <i class="fas fa-hand-spock text-success"></i>
                                        <!-- <span type="button" class="invite_employee" data-toggle="modal"
                                            data-target="#invite_employee">
                                            Mời ứng tuyển
                                        </span> -->
                                        <a class="js_apply_employee_job"  href="#">
                                            Mời ứng tuyển
                                        </a>
                                    </li>
                                    <li class="list-group-item cus-list-group-item">
                                        <i class="fas fa-star text-warning"></i>
                                        <span type="button" class="js_vote_employee"
                                              data-employee-id="{{ $employee->employee_id }}">
                                    Đánh giá ứng viên
                                </span>
                                    </li>
                                    <li class="list-group-item cus-list-group-item">
                                        <i class="fas fa-reply-all text-success"></i>
                                        <span type="button" class="js_response_employee"
                                              data-employee-id="{{ $employee->employee_id }}">
                                    Phản hồi chất lượng CV
                                </span>
                                    </li>
                                </ul>
                                <div class="title_employer_response mt-2">
                                    <div class="employer_response mt-2">
                                        @if(Auth::check() && Auth::user()->role == 2)
                                            <?php
                                            $employer_id = \App\Entity\Employer::where('user_id',Auth::user()->id)->value('employer_id');
                                            $list_get_reponse_cv = \App\Entity\Employer_response_cv::get_reponse_cv($employee->employee_id, $employer_id);
                                            ?>
                                            @foreach($list_get_reponse_cv as $reponse_cv)
                                                <ul>
                                                    <li> <span>Ngày phản hồi: </span>
                                                        <?php
                                                        $date_create_at=date_create($reponse_cv->created_at);
                                                        echo date_format($date_create_at,"d/m/Y");
                                                        ?>
                                                    </li>
                                                    <?php
                                                    $list_select_reponse = \App\Entity\Employer_select_response_cv::get_select_reponse_cv($reponse_cv->employer_response_cv_id);
                                                    ?>
                                                    <li> <span> Phản hồi: </span>
                                                        @foreach($list_select_reponse as $id_select=>$select_reponse)
                                                            @if($id_select == 0)
                                                                {{ $select_reponse->response }}
                                                            @else
                                                                | {{ $select_reponse->response }}
                                                            @endif
                                                        @endforeach
                                                    </li>
                                                    <li> <span>Nội dung: </span> {{ !empty($reponse_cv->response_diff) ? $reponse_cv->response_diff : '' }}</li>
                                                </ul>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)
        <?php
        $employer = \App\Entity\Employer::get_employer_id(\Illuminate\Support\Facades\Auth::user()->id);
        $list_apply_job = \App\Entity\Job::get_employer_job($employer->employer_id);
        ?>

        <div id="employer_apply_employee" class="modal fade" role="dialog">
            <div class="modal-dialog">
                {!! csrf_field() !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Mời ứng tuyển công việc</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        @foreach($list_apply_job as $apply_job)
                            <label>
                                <input type="checkbox" name="job_id[]" value="{{ $apply_job->job_id  }}">
                                {{ $apply_job->title }}
                            </label>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary send_evaluate">Đánh giá</button>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <div id="vote_employee" class="modal fade" role="dialog">
        <div class="modal-dialog">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Đánh giá ứng viên</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="employer_vote_star"></div>
                    <input type="hidden" name="vote_star">
                    <!-- <span class="live-rating"></span> -->
                    <div class="form-group">
                        <label for="">Nhận xét</label>
                        <textarea name="comment" id="textarea_comment_star" cols="30" rows="5"
                                  class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary send_evaluate">Đánh giá</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="contac_employee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông tin liên hệ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Vui lòng đăng nhập tài khoản nhà tuyển dụng để xem thông tin liên hệ ứng viên ! <a href="#"  data-toggle="modal"  data-target="#loginTiva">
                            Đăng nhập tại đây !</a></p>
                    <p>Nếu bạn chưa có tài khoản bạn có thể <a href="{{ route('employer_register') }}"> Đăng kí tại
                            đây</a></p>
                    {!! isset($infomation_coin_employer['huong-dan-nap-diem-xem-ho-so']) ? $infomation_coin_employer['huong-dan-nap-diem-xem-ho-so'] : 'Đang cập nhật thông tin' !!}
                </div>

                <div class="modal-footer" style="text-align: center;display: block">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_response_employee" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Phản hồi chất lượng CV</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Chọn phản hồi</label>
                        <select name="response[]" id="response" class="select2 form-control" multiple="multiple">
                            <?php $responses = \App\Entity\Employer_select_response::all(); ?>
                            @foreach($responses as $response)
                                <option value="{{ $response->employer_select_response_id }}">
                                    {{ $response->response }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Nội dung</label>
                        <textarea name="response_diff" id="response_diff" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary send_response_cv">Phản hồi</button>
                </div>
            </div>
        </div>
    </div>







    {{--@include('site.mobile_bottom.fixel_bottom_list_employer')--}}
    @include('site.mobile_bottom_site.fixel_bottom_category_job')
    {{--@include('site.employee_site.modal_detail_cv_employee')--}}
    {{--@include('site.employee_site.modal_detail_cv_employee_js')--}}



@endsection

@section('show_js')
    <script>
        // $('#detailEmployeeCv').modal('show');
    </script>
    <script type="text/javascript" src="/public/assets/js/sitebar.js"></script>
    <script type="text/javascript" src="/public/assets/js/sweetalert.min.js"></script>

    <script>
        $('.js_show_intro_employee').on('click', function () {
            var employee_id = $(this).attr('data-id');
            var data_show_check = $(this).attr('data_show_check');
            if (data_show_check == 0) {
                var check_info = $(this).find('.js_check_employee').attr('data_check_employee');

                        @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)
                var html_contact =
                    `<table class="table table-bordered table_info mgb5">
                        <tbody class="info_contact">
                        <tr> <td colspan="3"> <a class="text-light btn btn-sm btn-success submit_show_info_cv_detail_employee" data_employee_id='` + employee_id + `'> Xem Thông tin liên hệ của ứng viên( 1 điểm ) </a> </td> </tr>
                    </tr>
                    </tbody>
                    </table>`;
                        @else
                var html_contact =
                    `<table class="table table-bordered table_info mgb5">
                        <tbody class="info_contact">
                        <tr> <td colspan="3"> <a class="text-light btn btn-sm btn-success" data_employee_id='` + employee_id + `' data-toggle="modal" data-target="#contac_employee"> Xem Thông tin liên hệ của ứng viên( 1 điểm ) </a> </td> </tr>
                    </tr>
                    </tbody>
                    </table>`;
                @endif


                if (check_info == 1) {
                    var email = $(this).find('.js_check_employee').attr('data_email');
                    var phone = $(this).find('.js_check_employee').attr('data_phone');
                    html_contact =
                        `<table class="table table-bordered table_info mgb5">
                        <tbody class="info_contact">
                             <tr>
                                <td>Email</td>
                                <td colspan="2">` + email + `</td>
                            </tr>
                            <tr>
                                <td>Số điện thoại</td>
                                <td colspan="2">` + phone + `</td>
                            </tr>
                        </tbody>
                    </table>`;
                }

                var name = $(this).find('.js_name').html();
                var status = $(this).attr('data-status');
                var p_status = `<span class="text-danger"> <i class="fas fa-times-circle"></i>Chưa đi làm </span>`;
                if (status == 1) {
                    p_status = `<span class="text-success"> <i class="fas fa-check-circle"></i>Đã đi làm </span>`;
                }
                var salary = $(this).find('.js_salary').html();
                var profile = $(this).find('.js_profile').html();
                var date_submit = $(this).find('.js_date').html();
                var view = $(this).attr('data_view') + 1;
                var marry = $(this).attr('data_marry');
                var p_marry = `Độc thân`;
                if (marry == 1) {
                    p_marry = `Đã kết hôn`;
                }
                var year_ex = $(this).find('.js_year').html();
                var business_name = $(this).find('.js_business_name').html();
                var career_name = $(this).find('.js_career_name').html();
                var provice_district = $(this).find('.js_provice_district').html();

                var html_info =
                    `<table class="js_info_different table table-bordered table_info mb-0">
                    <tbody class="info_different">
                        <tr>
                            <td>Họ và tên</td>
                            <td colspan="2">` + name + `</td>
                        </tr>
                        <tr>
                            <td>TT công việc</td>
                           <td colspan="2">` + p_status + `
                            </td>
                        </tr>
                        <tr>
                        <td>Mức lương</td>
                        <td colspan="2">` + salary + `</td>
                        </tr>
                        <tr>
                        <td>Điểm hồ sơ</td>
                        <td colspan="1" class="js_td_profile">` + profile + `</td>
                            <td colspan="1" class="">Mã ứng viên:` + employee_id + `</td>
                        </tr>
                        <tr>
                        <td>Ngày cập nhật</td>
                        <td colspan="1" class="">` + date_submit + `</td>
                        <td colspan="1" class=""><i class="far fa-eye mgr5"></i>:` + view + `</td>
                        </tr>
                        <tr>
                        <td>TT hôn nhân</td>
                        <td colspan="2" class="">` + p_marry + `</td>
                        </tr>
                        <tr>
                        <td>Kinh nghiệm</td>
                        <td colspan="2">` + year_ex + ` năm </td>
                        </tr>
                        <tr>
                        <td data-toggle="tooltip" title="Kinh nghiệm trong lĩnh vực"
                        data-original-title="Kinh nghiệm trong lĩnh vực" colspan="3">
                          ` + business_name + `
                        </td>
                            </tr>
                            <tr>
                            <td data-toggle="tooltip" title="Vị trí công việc ứng viên cần tìm"
                        data-original-title="Vị trí công việc ứng viên cần tìm" colspan="3">
                           ` + career_name + `
                        </td>
                        </tr>
                        <tr>
                        <td data-toggle="tooltip" title="Khu vực ứng viên mong muốn tìm việc"
                        data-original-title="Khu vực ứng viên mong muốn tìm việc" colspan="3">` + provice_district + `
                        </td>
                        </tr>
                    </tbody>
                </table>`;
                $('#js_employee_' + employee_id).find('.js_content_appen').append(html_contact);
                $('#js_employee_' + employee_id).find('.js_content_appen').append(html_info);
                // $('.js_content_appen_+employee_id').append(html_contact);
                // $('.js_content_appen_+employee_id').append(html_info);
                $.ajax({
                    'type': 'get',
                    'url': "{{ route('modal_detail_coin') }}",
                    'data': {
                        employee_id: employee_id
                    },
                    'success': function (res) {
                        var html_coin =
                            `<table class="js_employee_coin table table-bordered table_info mgt5">
                        <tbody>
                            <tr>
                                <td
                                data-toggle="tooltip" title="Thông tin cơ bản của ứng viên"
                                data-original-title="Thông tin cơ bản của ứng viên">
                                    <b class="text-success" style="font-size:0.7rem">Điểm HS</b>
                                </td>
                                <td
                                data-toggle="tooltip" title="Thông tin trên CV của ứng viên"
                                data-original-title="Thông tin trên CV của ứng viên">
                                    <b class="text-success" style="font-size:0.7rem">Điểm CV</b>
                                </td>
                                <td
                                data-toggle="tooltip" title="Travelwork đánh giá chất lượng hồ sơ"
                                data-original-title="Travelwork đánh giá chất lượng hồ sơ">
                                    <b class="text-success" style="font-size:0.7rem">Điểm Travelwork</b>
                                </td>
                                <td
                                data-toggle="tooltip" title="Điểm ứng viên đã tham gia khóa học của Travelwork"
                                data-original-title="Điểm ứng viên đã tham gia khóa học của Travelwork">
                                    <b class="text-success" style="font-size:0.7rem">Điểm K/HỌC</b>
                                </td>
                                <td
                                data-toggle="tooltip" title="Điểm trung bình các nhà tuyển dụng đánh giá ứng viên"
                                data-original-title="Điểm trung bình các nhà tuyển dụng đánh giá ứng viên">
                                    <b class="text-success" style="font-size:0.7rem">Điểm NTD</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0 .4rem; text-align:center" class="table_coin_profile_info">
                                    ${res.view_profile.profile_info}
                                </td>
                                <td style="padding: 0 .4rem; text-align:center" class="table_coin_profile_cv">
                                    ${res.view_profile.profile_cv}
                                </td>
                                <td style="padding: 0 .4rem; text-align:center" class="td_profile_staff">
                                    ${res.view_profile.profile_staff}
                                </td>
                                <td style="padding: 0 .4rem; text-align:center">
                                    ${res.view_profile.profile_course}
                                </td>
                                <td style="padding: 0 .4rem; text-align:center" class="td_profile_avg">
                                    ${res.view_profile.profile_avg}
                                </td>
                            </tr>
                        </tbody>
                    </table>`;
                        $('#js_employee_' + employee_id).find('.js_content_appen').append(html_coin);
                    }
                });
                $(this).attr('data_show_check', 1);
            }
            var html_item_employee =  $(this).find('.js_check_employee');
            $('.submit_show_info_cv_detail_employee').on('click', function () {
                var employee_id = $(this).attr('data_employee_id');
                $.ajax({
                    'type': 'get',
                    'url': "{{ route('ajax_show_info_cv_detail_employee') }}",
                    'data': {
                        employee_id: employee_id
                    },
                    'success': function (res) {
                        let col_pdf = $('#detailEmployeeCv .col_pdf');
                        let table_info = $('#detailEmployeeCv table.table_info');
                        $('#detailEmployeeCv .col_pdf .show_cv').html('');
                        if (res.status == 'error') {
                            swal({
                                title: res.mess,
                                icon: "error",
                                button: "Đóng",
                            });
                        } else {
                            html_contact =
                                `<tr>
                                            <td>Email</td>
                                            <td colspan="2">`+res.employee_contact.email+`</td>
                                     </tr>
                                     <tr>
                                            <td>Số điện thoại</td>
                                            <td colspan="2">`+res.employee_contact.phone+`</td>
                                     </tr>`;
                            html_item_employee.html('<i class="far fa-eye mgr5"></i> Đã xem ');
                            $('#js_employee_' + employee_id).find('.info_contact').html();
                            $('#js_employee_' + employee_id).find('.info_contact').append(html_contact);
                            $('#js_employee_' + employee_id).find('.submit_show_info_cv_detail_employee').hide();


                            $('#js_employee_' + employee_id).find('.iframe_cv_employee').attr('src','https://docs.google.com/viewer?url='+res.link_cv_upload+'&amp;embedded=true#toolbar=0');
                            $('#js_employee_' + employee_id).find('.img_cv_employee').hide();


                        }
                    }
                })
            });
            //đánh giá của nhà tuyển dụng
            var employee_id = $(this).attr('data-id');
            $('#vote_employee .send_evaluate').on('click', function(){
                let vote_star = $('#vote_employee input[name="vote_star"]').val();
                let comment = $('#vote_employee textarea#textarea_comment_star').val();
                $.ajax({
                    'type': 'get',
                    'url': "{{ route('employer_avaluate_employee') }}",
                    'data': {
                        employee_id: employee_id,
                        comment: comment,
                        vote_star: vote_star
                    },
                    'success': function(res) {
                        $('#vote_employee').modal('hide');
                        swal({
                            title: res.mess,
                            icon: "success",
                            button: "Đóng",
                        });
                        $('#js_employee_' + employee_id).find('.js_td_profile').html(`<i class="fas fa-id-badge mgr5"></i>`+res.profile + ' điểm');
                        $('#js_employee_' + employee_id).find('.td_profile_avg').html(res.avg);
                    }
                })
            });


            @if(Auth::check() && Auth::user()->role == 2)
            //mòi ứng tuyển của nhà tuyển dụng
            $('.js_apply_employee_job').on('click', function(){
                $('#employer_apply_employee').modal('show');
            });

            //phản hồi của nhà tuyển dụng
            $('.js_response_employee').on('click', function(){
                $.ajax({
                    'type': 'get',
                    'url': "{{ route('check_employer_can_response_cv') }}",
                    'data': {
                        employee_id: employee_id
                    },
                    'success': function(res){
                        if(res.status == 'success'){
                            $('#modal_response_employee').modal('show');
                        }
                        else{
                            swal({
                                title: res.mess,
                                icon: "error",
                                button: "Đóng",
                            });
                        }
                    }
                })

            })
            var employer_response =  $('#js_employee_' + employee_id).find('.employer_response');
            $('#modal_response_employee .send_response_cv').on('click', function() {
                let response_diff = $('#modal_response_employee textarea#response_diff').val();
                let response = $('#modal_response_employee select#response').val();

                $.ajax({
                    'type': 'get',
                    'url': "{{ route('response_cv') }}",
                    'data': {
                        employee_id: employee_id,
                        response_diff: response_diff,
                        response: response
                    },
                    'success': function(res) {
                        $('#modal_response_employee').modal('hide');

                        var html_employer_response =
                            `
                            <ul>
                                <li> <span>Ngày phản hồi: </span> ${res.list_reponse_cv.date} </li>
                                <li> <span> Phản hồi: </span> ${res.list_reponse_cv.select} </li>
                                <li> <span>Nội dung: </span> ${res.list_reponse_cv.response_diff}</li>
                            </ul>
                            `;
                        employer_response.append(html_employer_response);
                        console.log(res);
                        swal({
                            title: res.mess,
                            icon: "success",
                            button: "Đóng",
                        });
                    }
                })
            })
            @else
            //mòi ứng tuyển của nhà tuyển dụng
            $('.js_apply_employee_job').on('click', function(){
                swal({
                    title: "Bạn cần đăng nhập tài khoản nhà tuyển dụng để thực hiện chưc năng này.",
                    icon: "error",
                    button: "Đóng",
                });
            });

            $('.js_response_employee').on('click', function(){
                swal({
                    title: "Bạn cần đăng nhập tài khoản nhà tuyển dụng để thực hiện chưc năng này.",
                    icon: "error",
                    button: "Đóng",
                });
            })

            @endif

        });
        $('.js_vote_employee').on('click', function () {

            var employee_id = $(this).attr('data-employee-id');
            let textarea_comment = $('#vote_employee #textarea_comment_star');
            $.ajax({
                'type': 'get',
                'url': "{{ route('get_employer_avaluate_employee') }}",
                'data': {
                    employee_id: employee_id
                },
                'success': function (res) {
                    if (res.status == 'error') {
                        swal({
                            title: res.mess,
                            icon: "error",
                            button: "Đóng",
                        });
                    } else {
                        $('#vote_employee').modal('show');
                        $(".employer_vote_star").starRating('setRating', res.employer_rating_employee.rating_start);
                        textarea_comment.val(res.employer_rating_employee.rating_content);
                    }
                }
            });
        });



    </script>
    <script>
        $(".employer_vote_star").starRating({
            starSize: 30,
            totalStars: 5,
            useFullStars: true,
            disableAfterRate: false,
            starShape: 'rounded',
            activeColor: 'orange',
            ratedColor: 'orange',
            hoverColor: 'orange',
            callback: function (currentIndex, $el) {
                var showText = '';
                $('.live-rating').removeClass('hide');
                $('.live-rating').text(showText);
                $('.form-rating').addClass('show');
                $('.live-rating').addClass('show');
                $('.form-rating').removeClass('hide');
                // console.log(currentIndex);
                $('input[name="vote_star"]').attr('value', currentIndex);
            }
        });
    </script>

    <script>
        $('#city').change(function () {
            var city = $(this).val();
            $.get('/tim-kiem-huyen/' + city, function (data) {
                $('#county').html('');
                $('#county').html(data);
            });
        });
        $('.js_show_search_job').click(function () {
            $('.js_filter_job_face').toggle();
        });
        $('.js_show_sidebar').click(function () {
            console.log('aaa');
            $('#js_toogle_sidebar').toggle();
            $('.js_closed_open').toggle();
        });
    </script>
@endsection
