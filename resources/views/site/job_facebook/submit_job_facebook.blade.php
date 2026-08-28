@extends('site.layout.site')

@section('title', 'Ứng viên nộp hồ sơ')
@section('meta_description', 'Ứng viên nộp hồ sơ')
@section('keywords', 'Ứng viên nộp hồ sơ')
<?php $meta_description = $jobFacebook->title . ' tại ' . $jobFacebook->province_name;
if (!empty($jobFacebook->district_name)) {
    $meta_description .= ' , ' . $jobFacebook->district_name;
}
if (!empty($jobFacebook->salary_description)) {
    $meta_description .= ' với mức lương ' . $jobFacebook->salary_description;
}
$meta_description = ucwords($meta_description);
?>
<?php
$save_submit_fb = 0;
$teacher_save_submit_fb = 0;
?>
@if(\Illuminate\Support\Facades\Auth::check()  && (\Illuminate\Support\Facades\Auth::user()->role) == 1 )
    <?php
    $id_user = \Illuminate\Support\Facades\Auth::user()->id;
    $employee = \App\Entity\Employee::getEmployee_id($id_user);
    if (!empty($employee)) {
        $save_submit_fb = \App\Entity\Employee_submit_job_faacebook::checkSubmitJobFacebook($employee->employee_id, $jobFacebook->job_facebook_id, 0);
    }
    $teacher = \App\Entity\Teacher::getTeacher_id($id_user);
    if (!empty($teacher)) {
        $teacher_save_submit_fb = \App\Entity\Teacher_submit_job_faacebook::checkSubmitJobFacebook($teacher->teacher_id, $jobFacebook->job_facebook_id, 0);
    }
    ?>
@else

@endif
@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                <script>
                    // location.reload();
                </script>
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent col-12 col-12">

                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Nộp hồ sơ</a>
                            </li>
                        </ul>
                    </div>

                    <div class="InfoCompanyJob mgt20">
                        <article>
                        <div class="main">
                            <div class="notificationBox bkwhite formJobLarge sm-f14 mobileNotificationBox js_remove_href_a">
                                <div class="bodyBox ">
                                    <div class="mgb10 postionImg">
                                        <div class="w90 sm-w70">

                                            <?php
                                            $date = date_create($jobFacebook->date_end);
                                            $date_end = date_format($date, "d-m-Y");
                                            $today = date('d-m-Y');
                                            ?>
                                            @if(strtotime($today) > strtotime($date_end))
                                                <p class="clred f16 fw6">
                                                    Công việc này đã hết hạn nộp hồ sơ rồi !
                                                </p>
                                            @else

                                            @endif

                                            <h1 class="fontBold blueDN mgb0 f23 lg-f20 sm-f15 titleDetailJobfb">{{ $jobFacebook->title }}</h1>
                                        </div>
                                        <div class="w10">
                                            @if($jobFacebook->vip == 1)
                                                <img class="chuaxathuc lazy" src="{{ asset('assets/image/xacthuc.jpg') }}"
                                                     title="{{ $jobFacebook->title }}" alt="{{ $jobFacebook->title }}">
                                            @else
                                                <img class="chuaxathuc lazy"
                                                     src="{{ asset('assets/image/chuaxacthuc.png') }}"
                                                     title="{{ $jobFacebook->title }}" alt="{{ $jobFacebook->title }}">
                                            @endif


                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12">

                                            {{--kiem tra việc làm lưu bởi user--}}
                                            <?php
                                            $save_job_fb = 0;
                                            $teacher_save_job_fb = 0;
                                            ?>
                                            @if(\Illuminate\Support\Facades\Auth::check())
                                                @if( \Illuminate\Support\Facades\Auth::user()->role == 1)
                                                    <?php
                                                    $id_user = \Illuminate\Support\Facades\Auth::user()->id;
                                                    $employee = \App\Entity\Employee::getEmployee_id($id_user);
                                                    if (!empty($employee)) {
                                                        $save_job_fb = \App\Entity\Employees_save_job_facebook::checkSaveJobFacebook($employee->employee_id, $jobFacebook->job_facebook_id, 0);
                                                    }
                                                    $teacher = \App\Entity\Teacher::getTeacher_id($id_user);
                                                    if (!empty($teacher)) {
                                                        $teacher_save_job_fb = \App\Entity\Teacher_save_job_facebook::checkSaveJobFacebook($teacher->teacher_id, $jobFacebook->job_facebook_id, 0);
                                                    }
                                                    ?>
                                                @endif
                                            @endif

                                            @if(\Illuminate\Support\Facades\Auth::check())
                                                @if($save_job_fb > 0 && (\Illuminate\Support\Facades\Auth::user()->role) == 1)
                                                    <button class="pd5-10 mgr20 bkwhite BorderLightGray"
                                                            id="deletesaveJobFacebook"
                                                            style="color: orange;border: 1px solid;"><i
                                                                class="fas fa-star"
                                                                style="margin-right: 5px"></i>Hủy việc
                                                        làm đã lưu
                                                    </button>
                                                @else
                                                    <button class="pd5-10 mgr20 bkwhite BorderLightGray"
                                                            id="saveJobFacebook"><i
                                                                class="far hoverYellow fa-star"></i> Lưu việc làm
                                                    </button>
                                                @endif
                                            @else
                                                <button class="pd5-10 mgr20 bkwhite BorderLightGray"
                                                        id="saveJobFacebook"><i
                                                            class="far hoverYellow fa-star blueN"></i> Lưu việc làm
                                                </button>
                                            @endif


                                            <span class="sm-block sm-mgt10"> Lượt xem: {{ !empty($jobFacebook->view ) ? $jobFacebook->view  : '1' }} <i
                                                        class="fas fa-eye"></i></span>


                                            {{--<a href="http://sanketoan.local/ung-tuyen-ngay/97" class="pd10-30 fontBold white noDecoration hvWhite bgrBlueN">NỘP HỒ SƠ</a>--}}


                                        </div>
                                        <div class="col-md-6 disOnLaptopMini">
                                            <!--<a href="" class="pd10-30 fontBold white noDecoration hvWhite bgrBlueN">NỘP HỒ SƠ</a>-->
                                        </div>
                                    </div>


                                    <div class="row lg-mgb15">
                                        <div class="col-md-12 ">
                                            @if(!empty($jobFacebook->company_name) )

                                                <p class="mgb10 " style="margin-top: 15px;">
                                                    <i class="far fa-building blueN mgr5"></i> Tên công ty : <strong
                                                            class="clhome">{{ $jobFacebook->company_name }}</strong>
                                                </p>

                                            @endif
                                            <p class="mgb10">
                                                <i class="fas fa-location-arrow blueN mgr5"></i> Vị trí cần tuyển :
                                                <strong
                                                        class="clhome">{{ $jobFacebook->career_category_name }}</strong>
                                            </p>
                                            <p class="mgb10">
                                                <i class="far fa-clock blueN mgr5"></i> Ngày đăng tin :
                                                <strong class="clhome"> {{ $date_facebook }}</strong>
                                            </p>


                                        </div>
                                        <div class="col-md-12 showMobileSalary">
                                            <p class="mgb10" style="display: inline-block;margin-right: 30px;"><i
                                                        class="far fa-money-bill-alt blueN mgr5"></i> Mức lương
                                                : {{ $jobFacebook->salary_description }}</p>

                                            <p class="mgb10" style="display: inline-block"><i
                                                        class="fas fa-map-marker-alt blueN mgr5"></i> Địa chỉ
                                                :
                                                {{ $jobFacebook->district_name }}
                                                @if(!empty($jobFacebook->district_name))
                                                    -
                                                @endif
                                                {{ $jobFacebook->province_name }}</p>




                                        </div>

                                        <div class="col-md-12 showMobileSalary">
                                            @if(!empty($jobFacebook->address))
                                                <p class="mgb15" style="display: inline-block"><i
                                                            class="fas fa-map-marker-alt blueN mgr5"></i> Địa chỉ làm
                                                    việc
                                                    :
                                                    {{ $jobFacebook->address }}
                                                </p>
                                            @endif
                                            @if($save_submit_fb > 0 && \Illuminate\Support\Facades\Auth::check()
                                          && (\Illuminate\Support\Facades\Auth::user()->role) == 1 )
                                                <p class="mgb10" style="display: inline-block">  <span
                                                            class="sm-block sm-mgt10"
                                                            style="margin-left: 20px"> <i class="fas fa-phone blueN mgr5"></i> Số điện thoại: {{ isset($jobFacebook->phone) ? $jobFacebook->phone : '' }}
                                                   </span></p>
                                            @endif



                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                            <div class="main pdb15 ">
                                <div class="notificationBox bkwhite formJobLarge sm-f14 ">
                                    <div class="bodyBox ">
                                        <div>
                                            <h2 class="font18 fontBold sm-f15 textUpper">Mô tả nội dung tuyển dụng</h2>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12 contentResetCss" id="content_remove_a">


                                                <?php

                                                $content = preg_replace('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/i', '(***)', $jobFacebook->content); // extract email
                                                ?>
                                                @if(\Illuminate\Support\Facades\Auth::check())

                                                @else
                                                    <?php
                                                    $content = preg_replace('/(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?/', '(*******)', $content); // extract phonenumber
                                                    ?>
                                                @endif
                                                {!! $content !!}



                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="main pdb15 ">
                                <div class="notificationBox bkwhite formJobLarge sm-f14 js_remove_href_a">
                                    <div class="bodyBox ">
                                        <div>
                                            <h3 class="font18 fontBold sm-f15">THÔNG TIN THAM KHẢO

                                            </h3>

                                        </div>
                                        <hr>

                                        <div class="row infoContact js-tangetA">


                                            <div class=" col-xl-12">
                                                <p class="mg0">
                                                    <b>{!! !empty($jobFacebook->job_info_contact) ? $jobFacebook->job_info_contact : 'Đang cập nhật...' !!}</b>
                                                </p>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </article>

                    </div>

                    <form action="{{ route('submit_apply_now') }}" method="post"
                          enctype="multipart/form-data" id="submit_apply_now">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id_job_fb" value="{{ $jobFacebook->job_facebook_id }}"/>
                        <input type="hidden" name="status_job" value="{{ $status_job }}"/>

                        <div class="CV bgrWhite radius5 mgt20 mgb20 pdb5 pdt10" style="border: 1px solid #ccc;">

                            <div class="content">


                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="content_detail_job_submit pd20">

                                            <?php

                                            $list_job_app = \App\Entity\Job_application::get_all();
                                            $list_join_job_app = \App\Entity\Job_application::get_join_all();
                                            ?>
                                            <div class="form-group row  borderSelect2 mgb0">
                                                <label for="staticEmail" class="col-lg-2 col-md-3 col-sm-3 col-5 col-form-label">Chọn mẫu đơn xin
                                                    việc</label>
                                                <div class="cl-lg-10 col-md-9 col-sm-9 col-7" style="width: 250px">
                                                    <select class="form-control select2 error_border_province js_select_2_change"
                                                            name="list_job_app"
                                                            aria-label="Năm bắt đầu đi làm việc" id="list_job_app">
                                                        @foreach($list_join_job_app as $item_job_app)
                                                            <option value="show{{ $item_job_app->career_category_id }}"
                                                                    @if($item_job_app->career_category_id == $jobFacebook->career_category_id) selected @endif
                                                            >{{ isset($item_job_app->career_category_name) ? $item_job_app->career_category_name : '' }} </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <h3 class="inBlock fw7 f18 ">Đơn xin việc</h3>


                                            @foreach($list_job_app as $item_job_app)
                                                <div id="show{{ $item_job_app->career_category_id }}"
                                                     class="js_hidden_job_app @if($jobFacebook->career_category_id == $item_job_app->career_category_id) show_item_job_app @else hidden_item_job_app @endif">
                                            <textarea class="textarea w100 form-control editor_basic"
                                                      name="show{{ $item_job_app->career_category_id }}"
                                                      id="editor_job_app_content{{ $item_job_app->career_category_id }}"
                                                      style="width: 50%;">{!!   isset($item_job_app->job_app_content) ? $item_job_app->job_app_content : ''  !!}</textarea>
                                                </div>
                                            @endforeach

                                            <h3 class="inBlock fw7 f18   mgt15">Hồ sơ xin việc</h3>
                                            <div class="popup-tcv mgt10">

                                                <div class="slideNews submit_job_slide">
                                                    <div class="text-center">
                                                        <label class="clgreen f16 fw6"><input type="checkbox" class="form-check-input" id="exampleCheck1" name="" checked value="1" disabled>Hồ sơ ứng viên</label>
                                                        <div class="submit_job_img">
                                                            <img class="js_max_height_img mg_0_auto" src="{{ asset('assets/image/item_hs1.jpg') }}">
                                                            <a target="_blank" href="{{ route('show_file_job_facebook') }}">Cập nhật hồ sơ</a>
                                                        </div>


                                                    </div>
                                                    <div class="text-center">
                                                        <label class="clgreen f16 fw6"><input type="checkbox" class="form-check-input" id="exampleCheck1" name="" checked value="1" disabled> CV ứng viên</label>
                                                        <div class="submit_job_img">
                                                            <img class="js_max_height_img mg_0_auto" src="{{ asset('assets/image/item_cv.jpg') }}">
                                                            <a target="_blank" href="{{ route('create_emplyee_cv') }}">Cập nhật CV</a>
                                                        </div>

                                                    </div>
                                                    <div class="text-center">
                                                        {{--<label class="clgreen f16 fw6"><input type="checkbox" class="form-check-input" id="exampleCheck1" name="status_syll" checked value="1"> Sơ yếu lý lịch</label>--}}

                                                        <label class="clgreen f16 fw6"><input type="checkbox" class="form-check-input" id="exampleCheck1" name="status_syll" checked value="1">Sơ yếu lý lịch</label>

                                                        <div class="submit_job_img">
                                                            <img class="js_max_height_img mg_0_auto" src="{{ asset('assets/image/item_syll.jpg') }}">
                                                            <a target="_blank" href="{{ route('employee_curriculum_vitae') }}">Cập nhật sơ yếu lý lịch</a>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-check mgt5 mgb5 pdf0">

                                                <label class="form-check-label" for="exampleCheck1">Lưu ý : Hồ sơ ứng viên  và CV ứng viên mặc định sẽ được gửi kèm cùng đơn xin việc</label>


                                            </div>




                                            <script type="text/javascript">
                                                $('.slideNews').slick({
                                                    slidesToShow: 3,
                                                    slidesToScroll: 1,
                                                    autoplay: true,
                                                    autoplaySpeed: 2000,
                                                    responsive: [
                                                        {
                                                            breakpoint: 1500,
                                                            settings: {
                                                                slidesToShow: 3,
                                                                slidesToScroll: 1
                                                            }
                                                        },
                                                        {
                                                            breakpoint: 1100,
                                                            settings: {
                                                                slidesToShow: 3,
                                                                slidesToScroll: 1
                                                            }
                                                        },
                                                        {
                                                            breakpoint: 800,
                                                            settings: {
                                                                slidesToShow: 2,
                                                                slidesToScroll: 1
                                                            }
                                                        },
                                                        {
                                                            breakpoint: 501,
                                                            settings: {
                                                                slidesToShow: 1,
                                                                slidesToScroll: 1
                                                            }
                                                        },
                                                    ]
                                                });

                                                // $('#show_notification').modal('show');
                                                // Nếu trình duyệt không hỗ trợ thông báo
                                                $(document).ready(function () {

                                                });
                                            </script>




                                            <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5 js_btn_loading"
                                                    value="btn_save" style="border:none" id="btnloading"
                                                    name="submit_form"> Ứng tuyển ngay
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>

                    <script>
                        $('#list_job_app').change(function () {
                            var show_category_id = $(this).val();
                            $('.js_hidden_job_app').hide();
                            $('#' + show_category_id).show();
                            console.log(show_category_id);
                        });
                        $('#is_click_appen').click(function () {
                            $('#show_hidden').hide();
                        });


                        $('.js_btn_loading').click(function () {
                            $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang Ứng tuyển ...');
                            $btn.attr('disabled', false);
                        });
                    </script>
                </div>
            </div>
        </div>
    </section>
    <script>
        // chon thanh pho ra quan huyen

    </script>
    <style>
        article {
            max-height: 300px; /* (4 * 1.5 = 6) */
        }

        .redmore {
            margin-top: 15px;
            text-align: center;
            padding: 5px 10px;
            font-size: 15px;
        }

        .redmore:hover {
            /*background: #009385;*/
            /*color: white;*/
        }

        .redmore span {
            background: #009385;
            border: 1px solid #009385;
            color: white;
            padding: 5px 10px;
        }
    </style>

    <script src="/assets/js/ajax_redmore_jquery.min.js"></script>
    <script src="/assets/js/readmore.js"></script>
    <script>
        $('article').readmore({
            speed: 1000,
            moreLink: '<a title="Xem thêm" class="redmore" href="#"> <span> Xem thêm <i class="fas fa-angle-double-down"></i> </span></a>',
            lessLink: '<a title="Thu gọn" class="redmore" href="#">   <span> Thu gọn <i class="fas fa-angle-double-up"></i> </span> </a>',
        });
    </script>
    <script src="/assets/ckeditor_easy/ckeditor.js"></script>
    <script>

        $('.editor_basic').each(function (e) {
            CKEDITOR.replace(this.id);
        });
        $('.select2').select2({
            width: '100%',
        });
    </script>
@endsection