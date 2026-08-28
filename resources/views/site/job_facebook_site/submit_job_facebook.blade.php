@extends('site.layout_site.site')

@section('title', 'Ứng viên nộp hồ sơ')
@section('meta_description', 'Ứng viên nộp hồ sơ')
@section('keywords', 'Ứng viên nộp hồ sơ')

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/tab_filter.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/detail_job.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/preview_pdf.css"/>
@endsection
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
                        <article>
                            <div class="job_detail">
                                <div class="main">
                                    <div class="box_job_detail js_remove_href_a">
                                        <div class="bodyBox ">
                                            <div class="box_job_detail_title">
                                                <div class="w90">
                                                    <?php
                                                    $date = date_create($jobFacebook->date_end);
                                                    $date_end = date_format($date, "d-m-Y");
                                                    $today = date('d-m-Y');
                                                    ?>
                                                    @if(strtotime($today) > strtotime($date_end))
                                                        <p class="clRed f16 fw6">
                                                            Công việc này đã hết hạn nộp hồ sơ rồi !
                                                        </p>
                                                    @else
                                                    @endif
                                                    <h1 class="title_job mgb10">{{ $jobFacebook->title }}</h1>
                                                </div>
                                                <div class="w10">
                                                    @if($jobFacebook->vip == 1)
                                                        <img
                                                                class="chuaxathuc lazy"
                                                                src="{{ asset('assets/image/xacthuc.jpg') }}"
                                                                title="{{ $jobFacebook->title }}"
                                                                alt="{{ $jobFacebook->title }}">
                                                    @else
                                                        <img
                                                                class="chuaxathuc lazy"
                                                                src="{{ asset('assets/image/chuaxacthuc.png') }}"
                                                                title="{{ $jobFacebook->title }}"
                                                                alt="{{ $jobFacebook->title }}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row box_save_des">
                                                <div class="col-xl-12 col-lg-12 col-md-12 showMobileDesJob">
                                                    {{--kiem tra việc làm lưu bởi user--}}
                                                    <?php
                                                    $save_job_fb = 0;
                                                    $teacher_save_job_fb = 0;
                                                    ?>
                                                    <span class="sm-block sm-mgt10">
                                                Lượt xem: {{ !empty($jobFacebook->view ) ? $jobFacebook->view  : '1' }}
                                                <i class="fas fa-eye"></i>
                                            </span>
                                                </div>
                                                <div class="col-md-6 disOnLaptopMini">
                                                    <!--<a href="" class="pd10-30 fontBold white noDecoration hvWhite bgrBlueN">NỘP HỒ SƠ</a>-->
                                                </div>
                                            </div>
                                            <div class="row lg-mgb15 IconDetailJob">
                                                <div class="col-md-12 ">
                                                    @if(!empty($jobFacebook->company_name) )
                                                        <p class="mgb10" style="margin-top: 15px;">
                                                            <i class="far fa-building blueN"></i> Tên công ty :
                                                            <strong class="clHome">{{ $jobFacebook->company_name }}</strong>
                                                        </p>
                                                    @endif
                                                    <p class="mgb10">
                                                        <i class="fas fa-location-arrow blueN"></i> Vị trí cần tuyển :
                                                        <strong class="clHome">{{ $jobFacebook->career_category_name }}</strong>
                                                    </p>
                                                    <p class="mgb10">
                                                        <i class="far fa-clock blueN"></i> Ngày đăng tin :
                                                        <strong class="clHome"> {{ $date_facebook }}</strong>
                                                    </p>
                                                </div>
                                                <div class="col-md-12 showMobileSalary">
                                                    <p class="mgb10" style="display: inline-block;margin-right: 30px;">
                                                        <i class="far fa-money-bill-alt blueN"></i>
                                                        Mức lương : {{ $jobFacebook->salary_description }}
                                                    </p>
                                                    <p class="mgb10" style="display: inline-block">
                                                        <i class="fas fa-map-marker-alt blueN"></i> Địa chỉ
                                                        : {{ $jobFacebook->district_name }}
                                                        @if(!empty($jobFacebook->district_name))
                                                            -
                                                        @endif
                                                        {{ $jobFacebook->province_name }}
                                                    </p>
                                                </div>

                                                <div class="col-md-12 showMobileSalary show_a">
                                                    <div class="mgb10 DetailJobListCareer">
                                                        <i class="fa fa-tags blueN"></i>
                                                        <a class="tag-title fw6" href="{{ route('list_type_job') }}"
                                                           target="_blank" style="color:black;">
                                                            Danh sách từ khóa:
                                                        </a>
                                                        @if (!empty($jobFacebook->tags))
                                                            <ul class="tags">
                                                                @php
                                                                    $tags = explode(',',$jobFacebook->tags)
                                                                @endphp
                                                                @foreach ($tags as $tag)
                                                                    @php
                                                                        $tag_slug = str_slug($tag, '-');
                                                                    @endphp
                                                                    <li>
                                                                        <a href="{{ route('detail_type_job',['tag_slug'=>$tag_slug]) }}"
                                                                           style="color: #fff !important;">
                                                                            {{ $tag }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="showOnLaptopMinii mgb10">
                                                <!--<a href="" class="pd10-30 fontBold white noDecoration hvWhite bgrBlueN">NỘP HỒ SƠ</a>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="main box_job_detail_content">
                                    <div class="box_job_detail bkwhite formJobLarge sm-f14 ">
                                        <div class="bodyBox">
                                            <div class="title_box_content">
                                                <h2 class="">Mô tả nội dung tuyển dụng</h2>
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
                                            <div class="row mgb10 showMobileFrofile pdt15">
                                                <div class="col-lg-4 col-md-12 itemProfile">
                                                    <p class="clOrange">
                                                        <b><i class="far fa-clock"></i> Hạn nộp hồ sơ
                                                            : {{ date_format($date,"d/m/Y") }}</b>
                                                    </p>
                                                </div>


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

                        <div class="job_submit_form_cv" style="border: 1px solid #ccc;">

                            <div class="content">

                                <div class="row">
                                    <div class="col-md-12">
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
                                                                    @if($item_job_app->career_category_id == $jobFacebook->career_category_id) selected @endif
                                                            >{{ isset($item_job_app->career_category_name) ? $item_job_app->career_category_name : '' }} </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <h3 class="">Đơn xin việc</h3>
                                            @foreach($list_job_app as $id_job=>$item_job_app)
                                                <div id="show{{ $item_job_app->career_category_id }}"
                                                     class="js_hidden_job_app @if($jobFacebook->career_category_id == $item_job_app->career_category_id) show_item_job_app @else hidden_item_job_app @endif"
                                                >
                                            <textarea class="textarea w100 form-control editor_basic"
                                                      name="show{{ $item_job_app->career_category_id }}"
                                                      id="editor_job_app_content{{ $item_job_app->career_category_id }}"
                                                      style="width: 50%;">{!!   isset($item_job_app->job_app_content) ? $item_job_app->job_app_content : ''  !!}</textarea>
                                                </div>
                                            @endforeach

                                            <h3 class="">CV của bạn</h3>
                                            <?php
//                                            $check_link_employee = App\Entity\Employee_upload_cv::get_employee_link_cv($employee->employee_id);
                                            $check_show_cv = \App\Entity\Employee_upload_cv::check_employee_cv_status($employee->employee_id);
                                            $check_show_employee = 1;
                                            $cv_upload = \App\Entity\Employee_upload_cv::get_employee_link_cv($employee->employee_id);
                                            ?>

                                            @if(!empty($check_show_cv))
                                                <?php
                                                $link_cv_upload = str_replace('/public', '', $cv_upload->employee_link_cv);
                                                $link_cv_upload = asset($link_cv_upload);
                                                ?>
                                                <div class="detail_employee_cv">
                                                    <iframe class="iframe_cv_employee"
                                                            src="{{ $link_cv_upload }}#view=fitH"
                                                            style="width: 100%; height: 60vh; " type="application/pdf">
                                                    </iframe>
                                                </div>
                                            @else
                                                <div class="detail_employee_cv">
                                                    @include('site.employee_site.partials.item_cv_template_employee', ['employee' =>$employee ,'check_show_employee'=>$check_show_employee])
                                                </div>
                                            @endif



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
                                                    <i class="clRed">Vì hồ sơ của bạn không đủ thông tin nên chưa được
                                                        duyệt , bạn vui lòng
                                                        bổ sung thêm thông tin hồ sơ hoặc liên hệ với admin sanketoan để
                                                        duyệt hồ sơ của
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

@endsection

@section('show_js')
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
    <script src="/assets/ckeditor_easy/ckeditor.js"></script>
    <script>

        $('.editor_basic').each(function (e) {
            CKEDITOR.replace(this.id);
        });
        $('.select2').select2({
            width: '100%',
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>
    <script>
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
            $("#appendToThis").css('zoom', zoom)
            // $("*").not("i").css('font-family', 'Arial')
            // $("*").not("i").css('font-size', '14px')
        });
        @endif
    </script>
@endsection
