@extends('site.layout_site.site')

@section('title', 'Ứng viên nộp hồ sơ')
@section('meta_description', 'Ứng viên nộp hồ sơ')
@section('keywords', 'Ứng viên nộp hồ sơ')


<link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
<link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
<link rel="stylesheet" type="text/css" href="/public/assets/web/css/tab_filter.css"/>
<link rel="stylesheet" type="text/css" href="/public/assets/web/css/detail_job.css"/>
<link rel="stylesheet" type="text/css" href="/public/assets/web/css/preview_pdf.css"/>

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                <script>
                    // location.reload();
                </script>
                @include('site.sidebar_site.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent col-12 col-12">

                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class="">Nộp hồ sơ</a>
                            </li>
                        </ul>
                    </div>


                    <div class="InfoCompanyJob mgt20">
                        <div class="main">
                            <article>
                                <div class="job_detail">
                                    <div class="main">
                                        <div class="box_job_detail">
                                            <div class="bodyBox ">
                                                <div class="mgb10 box_job_detail_title">
                                                    <div class="w90">
                                                        <?php
                                                        $date = date_create($job->deadline_submit_profile);
                                                        $date_end = date_format($date, "d-m-Y");
                                                        $today = date('d-m-Y');
                                                        ?>
                                                        @if(strtotime($today) > strtotime($date_end))
                                                            <p class="clRed f16 fw6">
                                                                Công việc này đã hết hạn nộp hồ sơ rồi !
                                                            </p>
                                                        @else
                                                        @endif
                                                        <h1 class="title_job">{{$job->title}}</h1>

                                                            @if(!empty($job->status_select_job) && $job->status_select_job == 1)
                                                                <?php
                                                                $company = \App\Entity\Job_company::get_post_id($job->job_id);
                                                                $company_name = $company->job_company_title;
                                                                ?>
                                                                <a data-toggle="modal" data-target="#exampleModal"
                                                                   class="titleCompanyName cutTitle "
                                                                   style="display: inline-block;cursor: pointer">{{ !empty($company_name) ? $company_name : ''  }}
                                                                </a>
                                                            @else
                                                                <a href="{{route('detail_employer',['id' => $employer->slug])}}"
                                                                   class="titleCompanyName cutTitle"
                                                                   style="display: inline-block">{{ isset($employer->enterprise_name) ? $employer->enterprise_name : ''}}
                                                                </a>

                                                            @endif

                                                    </div>
                                                    <div class="w10">
                                                        <img class="chuaxathuc lazy"
                                                             src="{{ asset('assets/image/xacthuc.jpg') }}"
                                                             title="Xác thực tại sanketoan.vn"
                                                             alt="Xác thực tại sanketoan.vn">
                                                    </div>
                                                </div>
                                                <div class="row box_save_des">
                                                    <?php
                                                    $date = date_create($job->updated_at);
                                                    $date_line = date_create($job->deadline_submit_profile);
                                                    ?>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 showMobileDesJob">
                                                        <?php
                                                        $save_job_fb = 0;
                                                        $teacher_save_job_fb = 0;
                                                        ?>
                                                        <span class="mgr20 job_detail_date">
                                                    <i class="far fa-clock clHome"></i> Ngày đăng tin : {{ $date_facebook }}
                                                </span>
                                                        <span class="mgr20">
                                                    <i class="fas fa-eye clHome"></i> Lượt xem: {{$job->views}}
                                                </span>
                                                        <span class="">
                                                    <i class="fas fa-code clHome"></i> Mã tin: {{$job->job_code}}
                                                </span>
                                                    </div>
                                                </div>
                                                <p></p>
                                                <div class="row lg-mgb15 IconDetailJob">
                                                    <div class="col-md-6">
                                                        <p class="mgb10">
                                                            <i class="far fa-money-bill-alt blueN"></i>
                                                            Mức lương
                                                            : {{isset($job->salary_description) ? $job->salary_description : 'Đang cập nhật '}}
                                                        </p>
                                                        <p class="mgb10"><i class="fas fa-clipboard-check blueN"></i>
                                                            Kinh nghiệm :
                                                            <?php
                                                            $job_experience = \App\Entity\Experience::getIdEx($job->experience_id);
                                                            ?>
                                                            {{isset($job_experience->experience_des) ? $job_experience->experience_des : 'Không yêu cầu'}}
                                                        </p>
                                                        <p class="mgb10">
                                                            <i class="fas fa-graduation-cap blueN"></i>
                                                            Trình độ
                                                            : {{isset($job->literacy_name) ? $job->literacy_name : 'Không yêu cầu'}}
                                                        </p>
                                                        <p class="mgb10">
                                                            <i class="fab fa-microsoft blueN"></i>
                                                            Phần mềm yêu cầu :
                                                            <?php
                                                            $software = \App\Entity\Software::getId($job->software_id)
                                                            ?>
                                                            {{isset($software->software_name) ? $software->software_name : 'Không yêu cầu'}}
                                                        </p>
                                                        <?php
                                                        $job_career = \App\Entity\JobCareer::getIdJob($job->job_id);
                                                        ?>
                                                        <div class="mgb10 DetailJobListCareer">
                                                            <i class="fas fa-user-tie blueN"></i>
                                                            Vị trí công việc :
                                                            <?php
                                                            $ca = \App\Entity\Career::getIdCareer($job->career_category_id);
                                                            ?>
                                                            @if(!empty($ca))
                                                                <span>{{ $ca['career_category_name'] }}</span>
                                                            @else
                                                                <span></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="mgb10"><i class="fas fa-users blueN"></i>Số lượng cần
                                                            tuyển :
                                                            {{isset($job->number_recruit) ? $job->number_recruit : 'Đang cập nhật '}}
                                                        </p>

                                                        <p class="mgb10">
                                                            <i class="fas fa-venus-mars blueN"></i>
                                                            Giới tính :
                                                            @if($job->gender == 0)
                                                                Không yêu cầu giới tính
                                                            @elseif($job->gender == 1)
                                                                Nữ
                                                            @elseif($job->gender == 2)
                                                                Nam
                                                            @elseif($job->gender == 3)
                                                                Cả nam và nữ
                                                            @endif
                                                        </p>
                                                        <p class="mgb10"><i class="fas fa-birthday-cake blueN"></i>Độ
                                                            tuổi :
                                                            <?php
                                                            $age = \App\Entity\Age::getIdAge($job->age_id);
                                                            ?>
                                                            @if(!empty($age))
                                                                {{ $age->name_age }}
                                                            @else
                                                                Không yêu cầu
                                                            @endif
                                                        </p>
                                                        <p class="mgb10">
                                                            <i class="fas fa-map-marker-alt blueN"></i>
                                                            Địa chỉ :
                                                            <?php
                                                            $district = \App\Entity\District::getId($job->district);
                                                            $province = \App\Entity\Province::getId($job->province);
                                                            ?>
                                                            {{ isset($district->district_name) ? $district->district_name : '' }}
                                                            @if(!empty($district->district_name))
                                                                -
                                                            @endif
                                                            {{ isset($province->province_name) ? $province->province_name : '' }}
                                                        </p>
                                                        @if(isset($job->address_work))
                                                            <p class="mgb10">
                                                                <i class="fas fa-map-marker-alt blueN"></i>
                                                                Địa điểm làm việc
                                                                : {{isset($job->address_work) ? $job->address_work : '' }}
                                                            </p>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main box_job_detail_content">
                                        <div class="box_job_detail bkwhite formJobLarge sm-f14">
                                            <div class="bodyBox ">
                                                <div class="title_box_content">
                                                    <h2 class="">Mô tả công việc</h2>
                                                </div>
                                                <hr>
                                                <div class="row sm-pd10">
                                                    <div class="col-md-12 contentResetCss" id="content_remove_a">
                                                        @if(!empty($job->description))
                                                            <?php
                                                            $description = App\Ultility\Ultility::ReplaceContent($job->description);
                                                            $description_replace = '';
                                                            $description_replace = preg_replace('/(?<=@.)[a-zA-Z0-9-]*(?=(?:[.]|$))/', '*', $description);
                                                            ?>
                                                            <?= $description_replace ?>
                                                        @else
                                                            <p>Đang cập nhật thông tin</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="bodyBox ">
                                                <div class="title_box_content">
                                                    <h2 class="">Yêu cầu công việc</h2>
                                                </div>
                                                <hr>
                                                <div class="row sm-pd10">
                                                    <div class="col-md-12 contentResetCss" id="content_remove_a">
                                                        <?php
                                                        $content = App\Ultility\Ultility::ReplaceContent($job->content);
                                                        $content_replace = preg_replace('/(?<=@)[a-zA-Z0-9-]*(?=(?:[.]|$))/', '******', $content);
                                                        //$content_replace = preg_replace('/^[a-z0-9_-]{3,15}$/', '****', $content);
                                                        ?>
                                                        <?= $content_replace ?>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="bodyBox ">
                                                <div class="title_box_content">
                                                    <h2 class="">Phúc lợi xã hội</h2>
                                                </div>
                                                <hr>
                                                <div class="row sm-pd10">
                                                    <div class="col-md-12 contentResetCss" id="content_remove_a">
                                                        @if(!empty($job->welfare))
                                                            <?php
                                                            $welfare = App\Ultility\Ultility::ReplaceContent($job->welfare);
                                                            $welfare_replace = preg_replace('/(?<=@.)[a-zA-Z0-9-]*(?=(?:[.]|$))/', '*', $welfare);
                                                            ?>
                                                            <?= $welfare_replace ?>
                                                        @else
                                                            <p>Đang cập nhật thông tin</p>
                                                        @endif
                                                        <hr>

                                                    </div>
                                                </div>

                                                <div class="row mgb10">
                                                    <p class="clOrange mgl15 dsBlock">
                                                        <b><i class="far fa-clock"></i> Hạn nộp hồ
                                                            sơ: {{ date_format($date_line,"d/m/Y") }}</b>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>


                    </div>


                    <form action="{{ route('submit_apply_now') }}" method="post"
                          enctype="multipart/form-data" id="submit_apply_now">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id_job_fb" value="{{ $id_job_fb }}"/>
                        <input type="hidden" name="status_job" value="{{ $status_job }}"/>

                        <div class="job_submit_form_cv" style="border: 1px solid #ccc;">

                            <div class="content">

                                <div class="row">
                                    <div class="col-md-12 div_width">
                                        <div class="content_detail_job_submit pd20">
                                            <?php
                                            $list_job_app = \App\Entity\Job_application::get_all();
                                            $list_join_job_app = \App\Entity\Job_application::get_join_all();
                                            ?>
                                            <div class="form-group row  borderSelect2 mgb0">
                                                <label for="staticEmail"
                                                       class="col-lg-2 col-md-3 col-sm-3 col-5 col-form-label">Chọn mẫu
                                                    đơn xin
                                                    việc</label>
                                                <div class="cl-lg-10 col-md-9 col-sm-9 col-7" style="width: 250px">
                                                    <select class="form-control select2 error_border_province js_select_2_change"
                                                            name="list_job_app"
                                                            aria-label="Năm bắt đầu đi làm việc" id="list_job_app">
                                                        @foreach($list_join_job_app as $item_job_app)
                                                            <option value="show{{ $item_job_app->career_category_id }}"
                                                                    @if($item_job_app->career_category_id == $job->career_category_id) selected @endif
                                                            >{{ isset($item_job_app->career_category_name) ? $item_job_app->career_category_name : '' }} </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <h3 class="">Đơn xin việc</h3>
                                            @foreach($list_job_app as $id_job=>$item_job_app)
                                                <div id="show{{ $item_job_app->career_category_id }}"
                                                     class="js_hidden_job_app @if($job->career_category_id == $item_job_app->career_category_id) show_item_job_app @else hidden_item_job_app @endif"
                                                    >
                                            <textarea class="textarea w100 form-control editor_basic"
                                                      name="show{{ $item_job_app->career_category_id }}"
                                                      id="editor_job_app_content{{ $item_job_app->career_category_id }}"
                                                      style="width: 50%;">{!!   isset($item_job_app->job_app_content) ? $item_job_app->job_app_content : ''  !!}</textarea>
                                                </div>
                                            @endforeach

                                                <h3 class="">CV của bạn</h3>


                                                <?php
                                                $link_cv = route('self_exportpdf_cv_user_id', ['user_id' => $employee->user_id]);
                                                $check_link_employee = App\Entity\Employee_upload_cv::get_employee_link_cv($employee->employee_id);
                                                if (!empty($check_link_employee)) {
                                                    $link_cv = asset($check_link_employee->employee_link_cv);
                                                }
                                                ?>
                                                <iframe class="iframe_cv_employee"
                                                        src="{{ $link_cv }}#view=fitH"
                                                        style="width: 100%; height: 90vh; " type="application/pdf">
                                                </iframe>

                                                {{--@include('site.employee_site.partials.preview_employee', ['link_cv' => $link_cv])--}}


                                            <p>
                                                <i class="clRed">Lưu ý : Hồ sơ ứng viên và CV ứng viên mặc định sẽ được
                                                    gửi kèm cùng đơn xin việc</i>
                                            </p>

                                            <p>
                                            @if($employee->status_employee == 1)
                                                <h4 class="text-success mgt10"><i class="fas fa-check-circle"></i>
                                                    <i class="f16"> Hồ sơ của bạn đã được duyệt</i>
                                                </h4>
                                                <button type="submit" class=" js_btn_loading button_submit_green"
                                                        value="btn_save" style="border:none" id="btnloading"
                                                        name="submit_form"> Ứng tuyển ngay
                                                </button>
                                            @else
                                                <h4 class="text-danger mgt10"><i class="fas fa-times-circle"></i>
                                                    <i class="f16">Hồ sơ của bạn chưa được duyệt</i>
                                                </h4>
                                                <p>
                                                    <i class="clRed">Vì hồ sơ của bạn không đủ thông tin nên chưa được duyệt , bạn vui lòng
                                                        bổ sung thêm thông tin hồ sơ hoặc liên hệ với admin sanketoan để duyệt hồ sơ của
                                                        bạn</i>
                                                </p>

                                                <a href="{{ route('show_step_profile_employee') }}" class="btnOrange">
                                                    Cập nhập thông tin
                                                </a>

                                                @endif
                                                </p>


                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>


                </div>
            </div>
        </div>
    </section>
    @if(!empty($job->status_select_job) && $job->status_select_job == 1)
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thông tin công ty</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="md_employer">
                            <h3 class="f20 fw6">{{ !empty($company->job_company_title) ? $company->job_company_title : '' }}</h3>
                            <p class="mgb5"><i class="fas fa-code"></i>
                                Mã số thuế : {{ !empty($company->tax_code) ? $company->tax_code : '' }}
                            </p>
                            <?php
                            $province = \App\Entity\Province::getId($company->province_id);
                            $district = \App\Entity\District::getId($company->district_id);
                            ?>
                            @if(!empty($province))
                                <p class="mgb5"><i class="fas fa-map-marker-alt"></i>
                                    {{ !empty($province->province_name) ? $province->province_name : '' }} -
                                    {{ !empty($district->district_name) ? $district->district_name: '' }}
                                </p>

                            @endif
                            <p class="mgb5"><i class="fas fa-map-marker-alt"></i> Địa
                                chỉ:{{ !empty($company->address) ? $company->address : '' }}</p>
                            <div class="md_employer_content">
                                {!! !empty($company->introduction) ? $company->introduction : 'Đang cập nhật' !!}
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

    @endif

@endsection
@section('show_js')
    <script>
        $('#list_job_app').change(function () {
            var show_category_id = $(this).val();
            $('.js_hidden_job_app').hide();
            $('#' + show_category_id).show();
        });
        $('#is_click_appen').click(function () {
            $('#show_hidden').hide();
        });


        $('.js_btn_loading').click(function () {
            $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang ứng tuyển ...');
            $btn.attr('disabled', false);
        });
    </script>
    <script src="/assets/js/ajax_redmore_jquery.min.js"></script>
    <script src="/assets/js/readmore.js"></script>
    <script>
        $('article').readmore({
            speed: 1000,
            collapsedHeight: 400,
            moreLink: '<a title="Xem thêm" class="redmore" href="#"> <span> Xem thêm <i class="fas fa-angle-double-down"></i> </span></a>',
            lessLink: '<a title="Thu gọn" class="redmore" href="#">   <span> Thu gọn <i class="fas fa-angle-double-up"></i> </span> </a>',
        });
    </script>
    <script src="/public/assets/ckeditor_easy/ckeditor.js"></script>
    <script>

        $('.editor_basic').each(function (e) {
            CKEDITOR.replace(this.id);
        });
        $('.select2').select2({
            width: '100%',
        });
    </script>
@endsection