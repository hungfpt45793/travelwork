@extends('site.layout_site.site')
<?php
$meta_jobfacebook = \App\Entity\Config_meta::getslug('chi-tiet-tin-tuyen-dung-facebook');
//print_r($meta_jobfacebook);die();
?>
@section('type_meta', 'website')
@section('title', $jobFacebook->title)
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
@section('meta_description'){{ $meta_description }}@endsection
@section('keywords', $jobFacebook->title)
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : ''  )

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/tab_filter.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/detail_job.css"/>
@endsection

@section('content')
    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row">
                {{--@include('site.sidebar_site.sidebar_job_face',['sidebar_job_fb'=>'sidebar_job_fb'])--}}
                @include('site.sidebar_site.sidebar_job',['sidebar_job_fb'=>'sidebar_job_fb'])

                <div class="col-xl-9 col-lg-8 col-md-12 dcontent createProfileOnline">

                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ </a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_job_face') }}" class="">Việc làm Facebook</a>
                            </li>
                        </ul>
                    </div>
                    <div class="btn_show_sidebar dsNone mbdsBlock" id="js_filter_job_face">
                        <ul class="nav">
                            <li class="nav-item">
                                <a style="color: #fff" class=" js_show_sidebar clWhite">
                                    <i class="fas fa-bars"></i> Menu
                                    <i class="fas fa-angle-up js_closed_open"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="mbdsNone js_filter_job_face" id="">
                        @include('site.filter_site.filter_job_face',['detail_job_facebook'=> 'detail_job_facebook'])
                        {{--@include('site.filter.filter_job_face',['detail_job_facebook'=> 'detail_job_facebook'])--}}
                    </div>
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

                                    </div>
                                    <div class="row box_save_des">
                                        <div class="col-xl-12 col-lg-12 col-md-12 showMobileDesJob">
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
                                                    <button
                                                        class="box_save_joby"
                                                        id="deletesaveJobFacebook"
                                                        style="color: orange;border: 1px solid;">
                                                        <i
                                                            class="fas fa-star"
                                                            style="margin-right: 5px">
                                                        </i>Hủy việc làm đã lưu
                                                    </button>
                                                @else
                                                    <button
                                                        class="box_save_job"
                                                        id="saveJobFacebook">
                                                        <i
                                                            class="far hoverYellow fa-star">
                                                        </i> Lưu việc làm
                                                    </button>
                                                @endif
                                            @else
                                                <button
                                                    class="box_save_job"
                                                    id="saveJobFacebook">
                                                        <i
                                                            class="far hoverYellow fa-star blueN">
                                                        </i> Lưu việc làm
                                                </button>
                                            @endif
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
                                                <i class="fas fa-map-marker-alt blueN"></i> Địa chỉ : {{ $jobFacebook->district_name }}
                                                @if(!empty($jobFacebook->district_name))
                                                    -
                                                @endif
                                                {{ $jobFacebook->province_name }}
                                            </p>
                                        </div>
                                        <div class="col-md-12 showMobileSalary">
                                            @if(!empty($jobFacebook->address))
                                                <p class="mgb15" style="display: inline-block">
                                                    <i class="fas fa-map-marker-alt blueN ">
                                                    </i> Địa chỉ làm việc : {{ $jobFacebook->address }}
                                                </p>
                                            @endif
                                            @if($save_submit_fb > 0 && \Illuminate\Support\Facades\Auth::check()
                                            && (\Illuminate\Support\Facades\Auth::user()->role) == 1 )
                                                <p class="mgb10" style="display: inline-block">
                                                    <span
                                                        class="sm-block sm-mgt10"
                                                        style="margin-left: 15px">
                                                        <i class="fas fa-phone blueN "></i>
                                                        Số điện thoại: {{ isset($jobFacebook->phone) ? $jobFacebook->phone : '' }}
                                                    </span>
                                                </p>
                                            @endif
                                        </div>

                                        <div class="lib_btn_share">
                                            <div class="box_btn_share js_box_btn_share">
                                                <i class="fas fa-share"></i>
                                                Chia sẻ tin tuyển dụng hữu ích
                                            </div>
                                            <div class="show_hidden_btn_share js_show_hidden_btn_share">
                                                <div class="click_show_hiden js_click_show_hiden">
                                                    <i class="fas fa-times"></i>
                                                </div>
                                                <p class="text_fb_zalo">Chia sẻ thông tin hữu ích</p>
                                                <div class="btn_share_facebook">
                                                    <div id="fb-root"></div>
                                                    <script async defer crossorigin="anonymous"
                                                            src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v18.0&appId=423707121644549&autoLogAppEvents=1"
                                                            nonce="eJnkMwgL"></script>
                                                    <div class="fb-share-button"
                                                         data-href="{{ route('detail_job_face', ['slug' => $jobFacebook->slug]) }}" data-layout="" data-size=""><a target="_blank"  href="https://www.facebook.com/sharer/sharer.php?u={{ route('detail_job_face', ['slug' => $jobFacebook->slug]) }}&amp;src=sdkpreparse"
                                                                                                                                                                                                                                    class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                                                </div>
                                                <div class="btn_share_zalo">
                                                    <div class="zalo-share-button"
                                                         data-href="{{ route('detail_job_face', ['slug' => $jobFacebook->slug]) }}"
                                                         data-oaid="579745863508352884" data-layout="3" data-color="blue"
                                                         data-customize="false" style="height: 40px;
    vertical-align: top;">
                                                    </div>
                                                </div>

                                                <div class="input-group-append">
                                                    <button onclick="myFunction()"
                                                            class="btn btn-outline-secondary copylink js_add_employee_money">
                                                        Copy link
                                                    </button>
                                                </div>
                                                <div class="input-group mb-3 copy_link_post">
                                                    <input type="text"
                                                           value="{{ route('detail_job_face', ['slug' => $jobFacebook->slug]) }}"
                                                           id="myInput"
                                                           class="form-control js_add_employee_money css_no_copy"
                                                           placeholder="copy link chia sẻ"
                                                           readonly style="">


                                                </div>
                                            </div>
                                        </div>




                                        <div class="col-md-12 showMobileSalary show_a">
                                            <div class="mgb10 DetailJobListCareer">
                                                <i class="fa fa-tags blueN"></i>
                                                <a class="tag-title fw6" href="{{ route('list_type_job') }}" target="_blank" style="color:black;">
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
                                                            <a href="{{ route('detail_type_job',['tag_slug'=>$tag_slug]) }}" style="color: #fff !important;">
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
                                                $content = App\Ultility\Ultility::preg_replace_script($content);
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
                                                <b><i class="far fa-clock"></i> Hạn nộp hồ sơ : {{ date_format($date,"d/m/Y") }}</b>
                                            </p>
                                            <!--<a href="" class="pd10-30 fontBold white noDecoration hvWhite bgrBlueN">NỘP HỒ SƠ</a> -->
                                        </div>
                                        <div class="col-lg-4 col-md-12 itemProfileSubmit text-center">
                                            @if(!empty($jobFacebook->email))
                                                @if(\Illuminate\Support\Facades\Auth::check())
                                                    @if($save_submit_fb > 0 && (\Illuminate\Support\Facades\Auth::user()->role) == 1 )
                                                        <a  class="box_btn_submit_profile"
                                                            style="margin-left: 10px;border: none;color: #fff" id=""
                                                            disabled>ĐÃ NỘP HỒ SƠ
                                                        </a>
                                                    @elseif (\Illuminate\Support\Facades\Auth::check() && $teacher_save_submit_fb > 0 && (\Illuminate\Support\Facades\Auth::user()->role) == 3)
                                                        <a  class="box_btn_submit_profile"
                                                            id=""
                                                            disabled>ĐÃ NỘP HỒ SƠ
                                                        </a>
                                                    @else
                                                        <a  class="box_btn_submit_profile"
                                                            href="{{ route('submitFileJobFacebook',['id_job_fb'=> $jobFacebook->job_facebook_id,'status_job'=>0]) }}"
                                                            id="submit_file">NỘP HỒ SƠ
                                                        </a>
                                                    @endif
                                                @else
                                                    <a  class="box_btn_submit_profile"
                                                        data-toggle="modal"
                                                        data-target="#loginTiva" >NỘP HỒ SƠ
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <a  id="checkUser"
                                                class="btnOrange float-right clWhite text-right f14 mbdsNone">
                                                <i class="fas fa-exclamation-triangle"></i> Báo tin sai
                                            </a>
                                        </div>

                                        <div class="col-lg-12 text-center mbdsmgt10">
                                            <p class="mg0">Vui lòng bấm nút
                                                <strong>"Nộp hồ sơ"</strong>
                                                để ứng tuyển vào vị trí công việc này."
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main box_job_detail_content">
                            <div class="box_job_detail bkwhite formJobLarge sm-f14 js_remove_href_a">
                                <div class="bodyBox ">
                                    <div class="title_box_content">
                                        <h2>THÔNG TIN THAM KHẢO</h2>
                                    </div>
                                    <hr>
                                    <div class="row infoContact js-tangetA">
                                        <div class=" col-xl-12">
                                            <p class="mg0 js_word_break">
                                                <b>{!! !empty($jobFacebook->job_info_contact) ? $jobFacebook->job_info_contact : 'Đang cập nhật...' !!}</b>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="section_box_content section_box_content_new mgt20 job_detail_relative">

                        <div class="header_box">
                            <h2 class="title_box  fw6 f20 mgb0 col-f14">
                                Việc làm tương tự
                            </h2>

                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                @foreach ($jobFacebookRelatives as $jobFacebookRelative)
                                    @include('site.jobs_site.item_job_facebook_new',['job'=> $jobFacebookRelative])
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-12 text-center pdt15 pdb15">
                                    <a  href="{{route('list_job_face')}}"
                                        class="block hvWhite pd10">Xem tất cả việc làm
                                    </a>
                                </div>
                            </div>
                        </div>

                    </section>
                    @include('site.module_index_site.dang-ky-tu-van')
                </div>
            </div>
            @include('site.module_index_site.hotline')
        </div>
    </section>
    @include('site.mobile_bottom_site.fixel_bottom_category_job')
@endsection

@section('show_js')
    <script type="text/javascript" src="/assets/js/sitebar.js"></script>
    <script>
        $('.js_click_show_hiden').click(function(){
            $('.show_hidden_btn_share').hide();
        });
        $('.js_box_btn_share').click(function(){
            $('.show_hidden_btn_share').show();
        });
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            document.execCommand("copy");
            // alert("Copied the text: " + copyText.value);
        }
    </script>
    <script>
        $( "#show_a" ).odd().removeClass( "js_remove_href_a" );
        $('.js_remove_href_a a').removeAttr("href");
        $('.js_show_search_job').click(function(){
            $('.js_filter_job_face').toggle();
        });
        $('.js_show_sidebar').click(function(){
            $('#js_toogle_sidebar').toggle();
            $('.js_closed_open').toggle();
        });
    </script>
    {{--//google search--}}
    <?php
        $date_create = date_create($jobFacebook->created_at);
    ?>

        {{-- chỉnh lại Job Posting --}}
        <script type="application/ld+json">
        {
            "@context" : "https://schema.org/",
            "@type" : "JobPosting",
            "title" : "{{ $jobFacebook->title }}",
            <?php
                $content_remove_style = 'Tuyển dụng du lịch';
                $content_remove_style = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>', $jobFacebook->content);
                 $content_remove_style = App\Ultility\Ultility::preg_replace_script($content_remove_style);
            ?>
            "description": "<div class='title_box_content'><h2 class=''>Mô tả nội dung tuyển dụng</h2></div>{!! $content_remove_style !!}",
            "datePosted" : "{{ date_format($date_create,"Y-m-d") }}",
            "validThrough" : "{{ date_format($date,"Y-m-d") }}T23:59:59+07:00",
            "employmentType" : "FULL_TIME",
            "hiringOrganization" : {
                "@type" : "Organization",
                @if(!empty($jobFacebook->company_name))
                    "name": "{{ $jobFacebook->company_name }}",
                @else
                    "name": "Khách hàng của Travelwork",
                @endif
                "sameAs" : "{{route('home')}}",
                "logo": "{{ !empty($information['logo']) ?  asset($information['logo']) : '' }}"
            },
             "industry":"Du lịch",
             "employerOverview" : "{!! $content_remove_style !!}",
             "occupationalCategory" : "{{ !empty($jobFacebook->career_category_name) ? $jobFacebook->career_category_name : 'Nhân viên du lịch' }}" ,
            "jobLocation": {
            "@type": "Place",
                "address": {
                "@type": "PostalAddress",
                "streetAddress": "{{ $jobFacebook->district_name }},{{ $jobFacebook->province_name }}",
                 "addressLocality":"{{ $jobFacebook->district_name }}",
                "addressRegion":"{{ $jobFacebook->province_name }}",
                "postalCode": "{{ $jobFacebook->postalcode }}",
                "addressCountry": "VN"
                }
            },
            "baseSalary": {
                "@type": "MonetaryAmount",
                "currency": "VND",
                "value": {
                    "@type": "QuantitativeValue",
                    "value": {{ $jobFacebook->salary_to }}.0,
                    "minValue":{{ $jobFacebook->salary_from }}.0,
                    "maxValue":{{ $jobFacebook->salary_to }}.0,
                    "unitText": "MONTH"
                }
            }
        }
        </script>
        {{-- END chỉnh lại Job Posting --}}


    <script>
        $(document).ready(function () {
            $( "#show_a" ).odd().removeClass( "js_remove_href_a" );
            //xoa href cua a
            $('.js_remove_href_a a').removeAttr("href");
            $('#checkUser').click(function () {
                @if (\Illuminate\Support\Facades\Auth::check())
                @if (\Illuminate\Support\Facades\Auth::user()->role == 1 || \Illuminate\Support\Facades\Auth::user()->role == 3 )
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: '{!! route('addWarning',['job_facebook_id'=>$jobFacebook->job_facebook_id]) !!}',
                    data: {
                        id_job_fb: '{{ $jobFacebook->job_facebook_id }}',
                        status_job: 0,
                    },
                    success: function (result) {
                        alert('Cảm ơn bạn báo tin sai cho chúng tôi!');
                    }
                });
                @else
                //luu loi hien thi taij dang nhap
                $('#InfoWarning').html('Vui lòng đăng nhập tài khoản ứng viên để báo tin sai');
                $('#loginTiva').modal('show');
                @endif
                @else
                //luu loi hien thi taij dang nhap
                $('#InfoWarning').html('Vui lòng đăng nhập tài khoản ứng viên để báo tin sai');
                $('#loginTiva').modal('show');
                @endif
            });

            $('#saveJobFacebook').click(function () {
                @if(\Illuminate\Support\Facades\Auth::check())
                @if (\Illuminate\Support\Facades\Auth::user()->role == 1)
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: '{!! route('saveJobFacebook',['job_facebook_id'=>$jobFacebook->job_facebook_id]) !!}',
                    data: {
                        id_job_fb: '{{ $jobFacebook->job_facebook_id }}',
                        // status_job 1 là việc nhà tuyển dung ; 0 là việc facebook
                        status_job: 0,
                    },
                    success: function (result) {
                        alert('Đã lưu việc làm thành công!');
                    },
                    error: function (result) {
                        alert('Lưu việc làm thất bại');
                    }
                });
                @else
                //luu loi hien thi taij dang nhap
                $('#InfoWarning').html('Vui lòng đăng nhập tài khoản ứng viên để lưu việc làm');
                $('#loginTiva').modal('show');
                @endif
                @else
                //luu loi hien thi taij dang nhap
                $('#InfoWarning').html('Vui lòng đăng nhập tài khoản ứng viên để lưu việc làm');
                $('#loginTiva').modal('show');
                @endif
            });
            $('#deletesaveJobFacebook').click(function () {
                @if(\Illuminate\Support\Facades\Auth::check())
                @if (\Illuminate\Support\Facades\Auth::user()->role == 1)
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: '{!! route('deletesaveJobFacebook',['job_facebook_id'=>$jobFacebook->job_facebook_id]) !!}',
                    data: {
                        id_job_fb: '{{ $jobFacebook->job_facebook_id }}',
                        // status_job 1 là việc nhà tuyển dung ; 0 là việc facebook
                        status_job: 0,
                    },
                    success: function (result) {
                        alert('Hủy lưu việc làm thành công!');
                    },
                    error: function (result) {
                        alert('Hủy lưu việc làm thất bại');
                    }
                });
                @else
                //luu loi hien thi taij dang nhap
                $('#InfoWarning').html('Vui lòng đăng nhập tài khoản ứng viên để hủy lưu việc làm');
                $('#loginTiva').modal('show');
                @endif
                @else
                //luu loi hien thi taij dang nhap
                $('#InfoWarning').html('Vui lòng đăng nhập tài khoản ứng viên để hủy lưu việc làm');
                $('#loginTiva').modal('show');
                @endif
            });

            @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1)
            $.ajax({
                type: "get",
                dataType: 'json',
                url: '{!! route('updateStatiscal_view_job',['val' => 'total_view_job']) !!}',
                data: {
                    val: 'total_view_job'
                },
                success: function (result) {
                    console.log("Thêm thành công");
                },
                error: function (result) {
                    console.log("Thêm thất bại  ");
                }
            });
            @endif
        });
    </script>
@endsection
