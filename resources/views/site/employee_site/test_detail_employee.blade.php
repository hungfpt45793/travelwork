@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', 'Thông tin ứng viên'.isset($employee['employee_name']) ? $employee['employee_name'] : '')
@section('meta_description', 'Thông tin ứng viên'.isset($employee['employee_name']) ? $employee['employee_name'] : '')
@section('keywords','Thông tin ứng viên'.isset($employee['employee_name']) ? $employee['employee_name'] : '')

@section('meta_image', !empty($employee->employee_image) ? asset($employee->employee_image) :
asset($information['logo']) )

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/list_employee.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/detail_employee.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/preview_pdf.css"/>
@endsection
@section('content')
    <style>
        .icon_sendemail a i {
            margin-top: 6px;
        }
        .iframe_cv_employee
        {
            max-width: 100%;
            width: 100%;
            height: 90vh;
        }
        #appendToThis
        {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            border-left: 1px solid #ccc;
            border-right: 1px solid #ccc;
            border-radius: 5px;
        }
        @media (max-width: 500px) {
            .iframe_cv_employee
            {
                max-width: 100%;
                width: 100%;
                height: 60vh !important;
            }
            .box_item_cv {
                width: 100%;
                max-width: 100%;
                margin: 0 auto;
                overflow-x: scroll !important;
                overflow-y: scroll !important;
            }
            .div_append
            {
                height: 100% !important;
            }

        }
    </style>
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                <div class="col-lg-8 div_width pr-0" style="background-color: #fff;position:relative" id="">
                    <?php
                    $check_show_employee = '';
                    //xem co upload cv khong
                    $check_show_cv = \App\Entity\Employee_upload_cv::check_employee_cv_status($employee->employee_id); //kiểm tra trạng thái upload của cv xem có dung cv hay dùng cv đã tạo
                    //lay link cv upload
                    $link_html = '';
                    $cv_upload = \App\Entity\Employee_upload_cv::get_employee_link_cv($employee->employee_id);
                    if (!empty($cv_upload->employee_link_cv)) {
                        $link_cv_upload = str_replace('/public', '', $cv_upload->employee_link_cv);
                        $array = explode('/', $link_cv_upload);
                        $array1 = explode('/', $link_cv_upload);
                        $array_delete = array_pop($array1);  //xoa phan tu cuoi cung trong mang
                        $pre_link = implode('/', $array1);//lay ve duong dan thu muc luu cv
                        $name = end($array); //lấy về tên file
                        $array_name = explode('.', $name);
                        $name_file = current($array_name) . '-html';//lay đường dẫn html đến ẩn đi email phone
                        $link_html = $pre_link . '/' . $name_file . '.html'; //đường dẫn dùng js
                        if (!empty($cv_upload->employee_link_html)) {
                            $link_html = str_replace('/public', '', $cv_upload->employee_link_html);
                        }
                    }
                    if (Auth::check() && Auth::user()->role == 2) {
                        $employer = \App\Entity\Employer::get_employer_id(\Illuminate\Support\Facades\Auth::user()->id);
                        $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee->employee_id);
                    }
                    ?>
                    {{--//có cv upload--}}
                    @if(!empty($check_show_cv))
                        @if(!empty($check_show_employee))
                            <?php
                            $link_cv_upload_public = str_replace('/public', '', $cv_upload->employee_link_cv);
                            $link_cv_upload = asset($link_cv_upload_public);
                            ?>
                            {{--//nếu có cv upload thì show nếu k thì hiện cv mã hóa--}}

                            @if(file_exists(public_path($link_cv_upload_public)))
                                <iframe class="iframe_cv_employee" src="https://docs.google.com/gview?url={{ asset($link_cv_upload) }}&embedded=true" frameborder="0"></iframe>
                            @else
                                <img class="img_cv_employee" src="/public/image_cv_upload/cv_upload.jpg" alt=""
                                     style="width: 100%;">
                            @endif
                        @else
                            @if(file_exists(public_path($link_html)))
                                <p class="text-center text-danger text_code">Đây là CV đã được số hóa, Để xem CV đầy đủ
                                    mời mua điểm.
                                </p>
                                <div id="appendToThis"></div>
                                <!-- <iframe id="myFrame"  src="javascript:;" style="width: 100%; height: 90vh; "></iframe> -->
                            @else
                                <img class="img_cv_employee" src="/public/image_cv_upload/cv_upload.jpg" alt=""
                                     style="width: 100%;">
                            @endif
                        @endif
                    @else
                        <div id="appendToThis">
                            @if(!empty($check_show_employee))
                                <?php
                                $link_cv_upload = route('employer_exportpdf_cv_user_id', ['user_id' => $employee->user_id]);
                                ?>
                                <iframe class="iframe_cv_employee" src="https://docs.google.com/gview?url={{ asset($link_cv_upload) }}&embedded=true" frameborder="0"></iframe>
                            @else
                                <p class="text-center text-danger text_code">
                                    Đây là CV đã được số hóa, Để xem CV đầy đủ mời mua điểm.
                                </p>
                                @include('site.employee_site.partials.item_cv_template_employee', ['employee' =>$employee ,'check_show_employee'=>$check_show_employee])
                            @endif
                        </div>
                    @endif



                </div>

                <div class="col-lg-4">
                    <div class="content_left_info ">
                        <?php
                        // $carr = \App\Entity\Employee_career_categories::get_career_id($employee->employee_id);
                        // $carrer = \App\Entity\Career::getIdCareer($carr->career_category_id);
                        $cojn_view_profile = \App\Entity\Employee_career_categories::get_coin_view_profile($employee->employee_id);
                        ?>
                        @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role ==
                        2)
                            <?php
                            $employer = \App\Entity\Employer::getIdUser(\Illuminate\Support\Facades\Auth::user()->id);
                            $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee->employee_id);
                            ?>
                            <div class="accountInfo mgt10 mgb10 text-center">
                                <h5 class="mgb0">
                                    {{ isset($employer->enterprise_name) ? $employer->enterprise_name : ''}}
                                </h5>
                                <p class="mgb0">
                            <span class="clRed dsBlock mgt5 mgb5"> <span class="red"><i>(Nhà tuyển
                                        dụng)</i></span></span>
                                @if(!empty($employer->total_employer_coin))
                                    <p class="mgb0 clGreen">
                                        Điểm : {{ number_format($employer->employer_coin )}} điểm
                                        <span data-toggle="modal" data-target="#create_coin"
                                              class="btnOrange mg10-0 d-sm-inline-block  bdr3 mgf5"
                                              style="padding: 5px 15px;cursor: pointer">Nạp
                                điểm <i class="fas fa-coins"></i></span>
                                    </p>
                                @else
                                    <p class="mgb0 clGreen">
                                        <?php
                                        $coin_infomation = \App\Entity\Coin_type_information_employer::get_coin_info();
                                        $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);
                                        $coin_money = $coin_infomation['so-diem-mien-phi-theo-ngay'] - $history_coin;
                                        ?>
                                        Điểm miễn phí : {{ isset($coin_money) ? $coin_money : '0' }} điểm

                                        <span data-toggle="modal" data-target="#create_coin"
                                              class="btnOrange mg10-0 d-sm-inline-block mgb10 bdr3 mgf5"
                                              style="padding: 5px 15px;cursor: pointer">Nạp điểm <i
                                                    class="fas fa-coins"></i></span>
                                    </p>
                                @endif
                            </div>

                            @if(!empty($check_show_employee))
                                <h3 class="f20 fw6 clGreen">Thông tin liên hệ</h3>
                                <table class="table table-bordered table_info mgb5">
                                    <tbody class="info_contact">
                                    <tr>
                                        <td><span class="clRed fw6">Email</span></td>
                                        <td colspan="2"><span
                                                    class="clGreen fw6">{{ !empty($employee->email) ? $employee->email : '' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="clRed fw6">Số điện thoại</span></td>
                                        <td colspan="2"><span
                                                    class="clGreen fw6">{{ !empty($employee->phone) ? $employee->phone : '' }}</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            @else
                                <p></p>
                                <form class="d-flex justify-content-center" action="{{ route('show_info_employee') }}"
                                      method="post"
                                      id="submit_show_info_cv_detail_employee">
                                    <input type="hidden" name="employee_id" value="{{$employee->employee_id}}">
                                    <button type="button"
                                            class=" btn btn-sm btn-outline-danger submit_show_info_cv_detail_employee">
                                        <b> Xem hồ sơ đầy đủ( {{ !empty($cojn_view_profile) ? $cojn_view_profile : 0 }}
                                            điểm )</b>
                                    </button>
                                </form>

                            @endif
                        @else
                            <form class="d-flex justify-content-center" action="{{ route('show_info_employee') }}"
                                  method="post"
                                  id="submit_show_info_cv_detail_employee">
                                <input type="hidden" name="employee_id" value="{{$employee->employee_id}}">
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger submit_show_info_cv_detail_employee">
                                    <b>Xem hồ sơ đầy đủ( {{ !empty($cojn_view_profile) ? $cojn_view_profile : 0 }} điểm
                                        )</b>
                                </button>
                            </form>

                        @endif


                        <table class="js_info_different table table-bordered table_info mb-0">
                            <tbody class="info_different">
                            <tr>
                                <td>Họ và tên</td>
                                <td colspan="2 "><span
                                            class="fw6">{{ !empty($employee->employee_name) ? $employee->employee_name : '' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>TT công việc</td>
                                <td colspan="2">@if($employee->status == 1) Đã đi làm @else Chưa đi làm @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Mức lương</td>
                                <td colspan="2">{{ !empty($employee->description) ? $employee->description : '' }}</td>
                            </tr>


                            <tr>
                                <td>Điểm hồ sơ</td>
                                <td colspan="1" class="js_td_profile"><span class="clGreen fw6">
                                        {{ !empty($employee->profile) ? $employee->profile : '' }}
                                        điểm
                                    </span>
                                </td>
                                <td colspan="1" class=""> ID
                                    : {{ !empty($employee->employee_id) ? $employee->employee_id : '' }}</td>
                            </tr>
                            <tr>
                                <td>Ngày cập nhật</td>
                                <td colspan="1" class="">
                                    @if(!empty($employee->updated_at))
                                        <?php
                                        $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->updated_at);
                                        echo $date_facebook;
                                        ?>
                                    @else
                                        <?php
                                        $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->created_at);
                                        echo $date_facebook;
                                        ?>
                                    @endif
                                </td>
                                <td colspan="1" class=""><i
                                            class="far fa-eye mgr5"></i>{{ !empty($employee->views) ? $employee->views : '0' }}
                                </td>
                            </tr>
                            <tr>
                                <td>TT hôn nhân</td>
                                <td colspan="2" class="">@if(!empty($employee->marry)) Đã kết hôn @else Độc
                                    thân @endif</td>
                            </tr>
                            <tr>
                                <td>Kinh nghiệm</td>
                                <?php
                                $date_day = date_create();
                                $year_day = date_format($date_day, "Y") - $employee->time_to_work;
                                ?>
                                <td colspan="2"><i
                                            class="fas fa-clipboard-check mgr5"></i>{{ !empty($year_day) ? $year_day   : 1 }}
                                    năm
                                </td>
                            </tr>
                            <tr>

                                <td data-toggle="tooltip" title="Kinh nghiệm trong lĩnh vực"
                                    data-original-title="Kinh nghiệm trong lĩnh vực" colspan="3">
                                    <i class="fas fa-share-alt mgr5"></i>
                                    <?php
                                    $list_business_name = \App\Entity\Employee_business_type::get_array_name($employee->employee_id);
                                    ?>
                                    @if($list_business_name)
                                        @foreach($list_business_name as $id_b=>$business)
                                            @if($id_b == 0)
                                                <span> {{ $business->business_type_name }}</span>
                                            @else
                                                <span> | {{ $business->business_type_name }}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td data-toggle="tooltip" title="Vị trí công việc ứng viên cần tìm"
                                    data-original-title="Vị trí công việc ứng viên cần tìm" colspan="3">
                                    <i class="fas fa-certificate mgr5"></i>
                                    <?php
                                    $list_career_name = \App\Entity\Employee_career_categories::get_array_name($employee->employee_id);
                                    ?>
                                    @if(!empty($list_career_name))
                                        @foreach($list_career_name as $id_c=>$career)
                                            @if($id_c == 0)
                                                <span> {{ $career->career_category_name }}</span>
                                            @else
                                                <span> | {{ $career->career_category_name }}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td data-toggle="tooltip" title="Khu vực ứng viên mong muốn tìm việc"
                                    data-original-title="Khu vực ứng viên mong muốn tìm việc" colspan="3">
                                    <i class="fas fa-map-marker-alt"></i>
                                    @if(isset($employee->province_name))
                                        {{ $employee->province_name }}
                                    @endif
                                    {{--//danh sach quan huyen--}}
                                    <?php
                                    $list_district_name = \App\Entity\Employee_district::get_district_name($employee->employee_id);
                                    ?>
                                    @if(!empty($list_district_name))
                                        @foreach($list_district_name as $ids=>$district)
                                            <i> | {{ $district->district_name }}</i>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>


                        <table class="js_employee_coin table table-bordered table_info mgt5">
                            <tbody>
                            <tr>
                                <td data-toggle="tooltip" title="Thông tin cơ bản của ứng viên"
                                    data-original-title="Thông tin cơ bản của ứng viên">
                                    <b class="text-success" style="font-size:0.7rem">Điểm HS</b>
                                </td>
                                <td data-toggle="tooltip" title="Thông tin trên CV của ứng viên"
                                    data-original-title="Thông tin trên CV của ứng viên">
                                    <b class="text-success" style="font-size:0.7rem">Điểm CV</b>
                                </td>
                                <td data-toggle="tooltip" title="Travelwork đánh giá chất lượng hồ sơ"
                                    data-original-title="Travelwork đánh giá chất lượng hồ sơ">
                                    <b class="text-success" style="font-size:0.7rem">Điểm Travelwork</b>
                                </td>
                                <td data-toggle="tooltip" title="Điểm ứng viên đã tham gia khóa học của Travelwork"
                                    data-original-title="Điểm ứng viên đã tham gia khóa học của Travelwork">
                                    <b class="text-success" style="font-size:0.7rem">Điểm K/HỌC</b>
                                </td>
                                <td data-toggle="tooltip" title="Điểm trung bình các nhà tuyển dụng đánh giá ứng viên"
                                    data-original-title="Điểm trung bình các nhà tuyển dụng đánh giá ứng viên">
                                    <b class="text-success" style="font-size:0.7rem">Điểm NTD</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="table_coin_profile_info text-center">
                                    {{ !empty($employee_profile->profile_info) ? $employee_profile->profile_info  : 0 }}
                                </td>
                                <td class="table_coin_profile_cv text-center">
                                    {{ !empty($employee_profile->profile_cv) ? $employee_profile->profile_cv  : 0 }}
                                </td>
                                <td class="td_profile_staff text-center">
                                    {{ !empty($employee_profile->profile_staff) ? $employee_profile->profile_staff  : 0 }}
                                </td>
                                <td>
                                    {{ !empty($employee_profile->profile_course) ? $employee_profile->profile_course  : 0 }}
                                </td>
                                <td class="td_profile_avg text-center">
                                    {{ !empty($employee_profile->profile_avg) ? $employee_profile->profile_avg  : 0 }}
                                </td>
                            </tr>
                            </tbody>
                        </table>


                        <ul class="list-group ul_action">
                            <li class="list-group-item cus-list-group-item dsBlock">
                            <span class="btn_send_employee">
                                 <i class="fas fa-hand-spock text-success"></i>
                            <a class="js_apply_employee_job a_cursor">
                                Mời ứng tuyển
                            </a>
                            </span>
                            </li>
                            <li class="list-group-item cus-list-group-item dsBlock">
                             <span class="btn_ratting_employee">
                            <i class="fas fa-star text-warning"></i>
                            <span type="button" class="js_vote_employee a_cursor"
                                  data-employee-id="{{ $employee->employee_id }}">
                                Đánh giá ứng viên
                            </span>
                             </span>
                            </li>
                            <li class="list-group-item cus-list-group-item dsBlock">
                            <span class="btn_feedback_employee">
                            <i class="fas fa-reply-all text-success"></i>
                            <span type="button" class="js_response_employee a_cursor"
                                  data-employee-id="{{ $employee->employee_id }}">
                                Phản hồi chất lượng CV
                            </span>
                            </span>
                            </li>
                        </ul>
                        <div class="title_employer_response mt-2">
                            <div class="employer_response mt-2">
                                @if(Auth::check() && Auth::user()->role == 2)
                                    <?php
                                    $employer_id = \App\Entity\Employer::where('user_id', Auth::user()->id)->value('employer_id');
                                    $list_get_reponse_cv = \App\Entity\Employer_response_cv::get_reponse_cv($employee->employee_id, $employer_id);
                                    ?>
                                    @foreach($list_get_reponse_cv as $reponse_cv)
                                        <ul>
                                            <li><span>Ngày phản hồi: </span>
                                                <?php
                                                $date_create_at = date_create($reponse_cv->created_at);
                                                echo date_format($date_create_at, "d/m/Y");
                                                ?>
                                            </li>
                                            <?php
                                            $list_select_reponse = \App\Entity\Employer_select_response_cv::get_select_reponse_cv($reponse_cv->employer_response_cv_id);
                                            ?>
                                            <li><span> Phản hồi: </span>
                                                @foreach($list_select_reponse as $id_select=>$select_reponse)
                                                    @if($id_select == 0)
                                                        {{ $select_reponse->response }}
                                                    @else
                                                        | {{ $select_reponse->response }}
                                                    @endif
                                                @endforeach
                                            </li>
                                            <li>
                                                <span>Nội dung: </span>
                                                {{ !empty($reponse_cv->response_diff) ? $reponse_cv->response_diff : '' }}
                                            </li>
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
    </section>


    <?php $infomation_coin_employer = \App\Entity\Coin_type_information_employer::get_coin_info(); ?>
    @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)
        <?php
        $employer = \App\Entity\Employer::get_employer_id(\Illuminate\Support\Facades\Auth::user()->id);
        $list_apply_job = \App\Entity\Job::get_employer_job($employer->employer_id);
        $check_count_job = \App\Entity\Job::count_employer_job($employer->employer_id);
        ?>
        <div class="modal fade" id="create_coin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hướng dẫn nạp điểm</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! isset($infomation_coin_employer['huong-dan-nap-diem-xem-ho-so']) ?
                        $infomation_coin_employer['huong-dan-nap-diem-xem-ho-so'] : 'Đang cập nhật thông tin' !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>

                    </div>
                </div>
            </div>
        </div>
        <div id="employer_apply_employee" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form action="{{ route('send_job_employer') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title f18 fw6">Mời ứng tuyển công việc</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            @if(!empty($check_count_job))
                                @foreach($list_apply_job as $apply_job)
                                    <?php
                                    $check_employee_apply = \App\Entity\Coin_apply_employee::check_employer_contact_job_employee($employer->employer_id, $employee->employee_id, $apply_job->job_id);
                                    ?>
                                    @if(!empty($check_employee_apply))
                                        <label class="clGreen mgb0">
                                            <input type="checkbox" name="job_ids[]" value="{{ $apply_job->job_id  }}">
                                            {{ $apply_job->title }}
                                        </label>
                                        <sup>({{ !empty($apply_job->view_apply) ? $apply_job->view_apply : '' }}
                                            điểm)</sup>
                                        <p class="mgb0 f12 text-center">
                                            <i class="clRed">Tin tuyển dụng này bạn đã mời ứng tuyển</i>
                                        </p>
                                    @else
                                        <label>
                                            <input type="checkbox" name="job_ids[]" value="{{ $apply_job->job_id  }}">
                                            {{ $apply_job->title }}
                                        </label>
                                        <sup>({{ !empty($apply_job->view_apply) ? $apply_job->view_apply : '' }}
                                            điểm)</sup>
                                    @endif
                                @endforeach
                            @else
                                <p>Bạn không có đăng tin tuyển dụng nào</p>
                            @endif
                            <input type="hidden" name="employee_id" value="{{ $employee->employee_id }}">
                        </div>
                        <div class="modal-footer">
                            @if(!empty($check_count_job))
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                <button type="submit" class="box_btn_submit_profile btn btn-primary send_evaluate">Mời
                                    ứng tuyển
                                </button>
                            @else
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <div id="vote_employee" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form action="{{ route('vote_employee') }}" method="post" id="js_form_vote_employee">
                {!! csrf_field() !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Đánh giá ứng viên</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="employer_vote_star"></div>
                        <input type="hidden" name="vote_star" class="js_vote_star">
                        <input type="hidden" name="employee_id" value="{{ $employee->employee_id }}">
                        <i class="js_error_vote_star clRed"></i>
                        <!-- <span class="live-rating"></span> -->
                        <div class="form-group">
                            <label for="">Nhận xét</label>
                            <textarea name="comment" id="textarea_comment_star" cols="30" rows="5"
                                      class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="button" id="send_evaluate_star"
                                class="box_btn_submit_profile  btn btn-primary send_evaluate">Đánh giá
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="contac_employee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông tin liên hệ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Vui lòng đăng nhập tài khoản nhà tuyển dụng để xem thông tin liên hệ ứng viên ! <a href="#"
                                                                                                          data-target="#loginTiva">
                            Đăng nhập tại đây !</a></p>
                    <p>Nếu bạn chưa có tài khoản bạn có thể <a href="{{ route('employer_register') }}"> Đăng kí tại
                            đây</a></p>
                    {!! isset($infomation_coin_employer['huong-dan-nap-diem-xem-ho-so']) ?
                    $infomation_coin_employer['huong-dan-nap-diem-xem-ho-so'] : 'Đang cập nhật thông tin' !!}
                </div>

                <div class="modal-footer" style="text-align: center;display: block">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_response_employee" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form action="{{ route('response_employee') }}" method="post">
                {!! csrf_field() !!}
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
                            <input type="hidden" name="employee_id" value="{{ $employee->employee_id }}">
                        </div>
                        <div class="form-group">
                            <label for="">Nội dung</label>
                            <textarea name="response_diff" id="response_diff" cols="30" rows="5"
                                      class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="box_btn_submit_profile btn btn-primary send_response_cv">Phản hồi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
<script type="text/javascript" src="/public/assets/js/sweetalert.min.js"></script>
@section('show_js')
    <script>
        // A $( document ).ready() block.
        $( document ).ready(function() {
            console.log( "ready!" );
            var userAgent = navigator.userAgent || navigator.vendor || window.opera;
            var link_mobile_android = '{{ isset($information['link-tai-app-androi']) ?  $information['link-tai-app-androi'] : '' }}';
            var link_mobile_ios = '{{ isset($information['link-tai-app-ios']) ?  $information['link-tai-app-ios'] : '' }}';
            // iOS detection from: http://stackoverflow.com/a/9039885/177710
            if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
                //console.log( "ready! 2222" );
                $('#appendToThis').css("zoom","1");
                $('#appendToThis').css("height","45vh");
            }
        });


        @if(Auth::check() && Auth::user() -> role == 2)
        //xem thông tin liên hệ
        $('.submit_show_info_cv_detail_employee').click(function () {
            $('#submit_show_info_cv_detail_employee').submit();
        });
        //mời ứng tuyển
        $('.js_apply_employee_job').click(function () {
            $('#employer_apply_employee').modal('show');
        });
        //đánh giá ứng viên
        $('.js_vote_employee').click(function () {
            $('#vote_employee').modal('show');
        });
        //phản hồi cv ứng viên
        $('.js_response_employee').click(function () {
            $('#modal_response_employee').modal('show');
        });
        @else

        $('.submit_show_info_cv_detail_employee').click(function () {
            $('#contac_employee').modal('show');
        });
        $('.js_apply_employee_job').click(function () {
            swal({
                title: "Bạn cần đăng nhập tài khoản nhà tuyển dụng để thực hiện chưc năng này.",
                icon: "error",
                button: "Đóng",
            });
        });
        //đánh giá ứng viên
        $('.js_vote_employee').click(function () {
            swal({
                title: "Bạn cần đăng nhập tài khoản nhà tuyển dụng để thực hiện chưc năng này.",
                icon: "error",
                button: "Đóng",
            });
        });
        //phản hồi cv ứng viên
        $('.js_response_employee').click(function () {
            swal({
                title: "Bạn cần đăng nhập tài khoản nhà tuyển dụng để thực hiện chưc năng này.",
                icon: "error",
                button: "Đóng",
            });
        });
        @endif

        @if(session('error'))
        swal({
            title: "{{ session('error') }}.",
            icon: "error",
            button: "Đóng",
        });
        @endif
        @if(session('success'))
        swal({
            title: "{{ session('success') }}.",
            icon: "success",
            button: "Đóng",
        });
        @endif
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
                $('input[name="vote_star"]').attr('value', currentIndex);
            }
        });

        $('#send_evaluate_star').click(function () {
            var vote_star = $('.js_vote_star').val();
            if (vote_star != '') {
                $('#js_form_vote_employee').submit();
            }
            $('.js_error_vote_star').html('Vui lòng chọn sao đánh giá');
        });

                @if(!empty($link_html) && file_exists(public_path($link_html)))
        var replacement = `<b style="background: #d03737;font-weight: 400;color: #f3f32f;">Thông tin này đã được ẩn.</b>`;

        function replaceText(i, el) {
            if (el.nodeType === 3) {
                        @foreach(\App\Entity\Regex::get_regexs() as $key => $regex)
                var regex{{$key}} = {{ $regex->content }};
                if (regex{{$key}}.test(el.data)) {
                    $(el).replaceWith(el.data.replace(regex{{$key}}, replacement));
                }
                @endforeach
            } else {
                $(el).contents().each(replaceText);
            }
        }

        @endif

        @if(!empty($link_html) && file_exists(public_path($link_html)))
        $.get("{{$link_html}}", function (data) {
            // doc du lieu trang html
            $("#appendToThis").append(`<div class="div_append">${data}</div>`);
            var iContentBody = $("#appendToThis");
            $("#appendToThis").find('p:contains("facebook.com")').remove();
            $("#appendToThis").find('p:contains("fb.com")').remove();
            $("#appendToThis").find('p:contains("linkedin.com")').remove();
            $("#appendToThis").find('a[href^="mailto:"]').remove();
            $("#appendToThis").each(replaceText);

            let src_html = '<?php echo $link_html; ?>';
            let array_src_html = src_html.split('/');
            const lastItem = array_src_html[array_src_html.length - 1]
            arr_width = [];
            $('#appendToThis img').map(function () {
                let width = $(this).width();
                arr_width.push(width);
                let src = $(this).attr('src')
                if (src.indexOf('base64') == -1) {
                    let true_src = src_html.replace(lastItem, src);
                    $(this).attr('src', true_src);
                }
            });
            let max_width = Math.max(...arr_width)
            let min_width = $(".div_width").width()
            let zoom = min_width / max_width;
            if (min_width > 1100) {
                $("#appendToThis").css('zoom', '1.0');
            } else {
                $("#appendToThis").css('zoom', zoom);
            }
            $('#page1-div').css('margin', '0 auto');
            // $("*").not("i").css('font-family', 'Arial')
            // $("*").not("i").css('font-size', '14px')
        });
        @endif
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>
    <script>
        var myState = {
            pdf: null,
            currentPage: 1,
            zoom: 1
        }

        @if(!empty($check_show_cv))
        @if(!empty($check_show_employee))
        pdfjsLib.getDocument('{{ $link_cv_upload }}').then((pdf) => {
            myState.pdf = pdf;
            myState.pdf.getPage(myState.currentPage).then((page) => {
                var viewport = page.getViewport(myState.zoom);
                var viewport_width = viewport.width;
                var div_width = $('.div_width').width();

                var zoom_num = div_width / viewport_width;
            });
            render();
            $('.loading_cv').css('display', 'none')
        });
        @endif
        @else
        pdfjsLib.getDocument('{{ route('employer_exportpdf_cv_user_id',['user_id '=> $employee->user_id]) }}').then((pdf) => {
            myState.pdf = pdf;
            myState.pdf.getPage(myState.currentPage).then((page) => {
                var viewport = page.getViewport(myState.zoom);
                var viewport_width = viewport.width;
                var div_width = $('.div_width').width();

                var zoom_num = div_width / viewport_width;
                myState.zoom = zoom_num;
            });
            render();
            $('.loading_cv').css('display', 'none')
        });

        @endif

        function render() {
            myState.pdf.getPage(myState.currentPage).then((page) => {

                var canvas = document.getElementById("pdf_renderer");
                var ctx = canvas.getContext('2d');

                var viewport = page.getViewport(myState.zoom);

                canvas.width = viewport.width;
                canvas.height = viewport.height;

                page.render({
                    canvasContext: ctx,
                    viewport: viewport
                });
            });
        }

        document.getElementById('go_previous').addEventListener('click', (e) => {
            if (myState.pdf == null || myState.currentPage == 1)
                return;
            myState.currentPage -= 1;
            document.getElementById("current_page").value = myState.currentPage;
            render();
        });

        document.getElementById('go_next').addEventListener('click', (e) => {
            if (myState.pdf == null || myState.currentPage > myState.pdf._pdfInfo.numPages)
                return;
            myState.currentPage += 1;
            document.getElementById("current_page").value = myState.currentPage;
            render();
        });


        document.getElementById('zoom_in').addEventListener('click', (e) => {
            if (myState.pdf == null) return;
            myState.zoom += 0.2;
            render();
        });

        document.getElementById('zoom_out').addEventListener('click', (e) => {
            if (myState.pdf == null) return;
            myState.zoom -= 0.2;
            render();
        });

    </script>


@endsection
