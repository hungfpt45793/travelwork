@extends('site.layout.site')
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
@section('content')

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row">
                @include('site.sidebar.sidebar_job_face',['sidebar_job_fb'=>'sidebar_job_fb'])

                <div class="col-xl-9 col-lg-8 col-md-12 dcontent createProfileOnline">

                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgt5 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_job_face') }}" class=" f18 md-f14 mgb0">Việc làm Facebook</a>
                            </li>


                        </ul>
                    </div>
                    <div class="mbdsNone">
                        @include('site.filter.filter_job_face',['detail_job_facebook'=> 'detail_job_facebook'])
                    </div>


                    <section class="quickSearchForJobs mgt20 bgrWhite">

                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('.js-example-basic-single').select2();
                            });
                        </script>
                    </section>

                    <div class="InfoCompanyJob">
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
                                    <div class="showOnLaptopMinii mgb10">
                                        <!--<a href="" class="pd10-30 fontBold white noDecoration hvWhite bgrBlueN">NỘP HỒ SƠ</a>-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="main pdt30">
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
                                            <div class="jsSocial mgt10 mgb10 ">
                                                <script type="text/javascript"
                                                        src="https://s7.addthis.com/js/300/addthis_widget.js"></script>
                                                <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                                                    <a class="addthis_button_facebook"></a>
                                                    <a class="addthis_button_twitter"></a>
                                                    <a class="addthis_button_email"></a>
                                                    <a class="addthis_button_pinterest_share"></a>
                                                    <a class="addthis_button_compact"></a>
                                                    <a class="addthis_counter addthis_bubble_style"></a>
                                                </div>
                                            </div>

                                            <div style="display: inline-block;">
                                                <script src="https://sp.zalo.me/plugins/sdk.js"></script>
                                                <div class="zalo-share-button"
                                                     data-href="{{ route('detail_job_face', ['slug' => $jobFacebook->slug]) }}"
                                                     data-oaid="579745863508352884" data-layout="2" data-color="blue"
                                                     data-customize=true
                                                     style="background: #03a3fb;color: #fff;padding: 1px 10px;"><img
                                                            src="{{ asset('assets/image/logozalo.jpg') }}"
                                                            class="lazy"
                                                            title="{{ $jobFacebook->title }}"
                                                            alt="{{ $jobFacebook->title }}"
                                                            style="width: 30px;">Chia sẻ Zalo
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mgb10 showMobileFrofile">
                                        <div class="col-lg-4 col-md-12 itemProfile">
                                            <p class="clorange"><b><i class="far fa-clock"></i> Hạn nộp hồ
                                                    sơ: {{ date_format($date,"d/m/Y") }}</b></p>

                                            <!--<a href="" class="pd10-30 fontBold white noDecoration hvWhite bgrBlueN">NỘP HỒ SƠ</a> -->
                                        </div>
                                        <div class="col-lg-4 col-md-12 itemProfileSubmit text-center">
                                            @if(!empty($jobFacebook->email))

                                                @if(\Illuminate\Support\Facades\Auth::check())

                                                    @if($save_submit_fb > 0 && (\Illuminate\Support\Facades\Auth::user()->role) == 1 )
                                                        <a class="pd10-30 fontBold white noDecoration  bgrBlueN mgb10"
                                                           style="margin-left: 10px;border: none;color: #fff" id=""
                                                           disabled>ĐÃ
                                                            NỘP HỒ SƠ</a>

                                                    @elseif (\Illuminate\Support\Facades\Auth::check() && $teacher_save_submit_fb > 0 && (\Illuminate\Support\Facades\Auth::user()->role) == 3)
                                                        <a class="pd10-30 fontBold white noDecoration  bgrBlueN mgb10"
                                                           style="margin-left: 10px;border: none;color: #fff" id=""
                                                           disabled>ĐÃ
                                                            NỘP HỒ SƠ</a>
                                                    @else
                                                        <a class="pd10-30 fontBold white  noDecoration  bgrBlueN mgb10"
                                                           href="{{ route('submitFileJobFacebook',['id_job_fb'=> $jobFacebook->job_facebook_id,'status_job'=>0]) }}"
                                                           style="margin-left: 10px;border: none;color: #fff"
                                                           id="submit_file">NỘP
                                                            HỒ SƠ</a>
                                                    @endif
                                                @else
                                                    <a class="pd10-30 fontBold white  noDecoration  bgrBlueN mgb10"
                                                       href="{{ route('submitFileJobFacebook',['id_job_fb'=> $jobFacebook->job_facebook_id,'status_job'=>0]) }}"
                                                       style="margin-left: 10px;border: none;color: #fff"
                                                       id="submit_file">NỘP
                                                        HỒ SƠ</a>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <a id="checkUser" class="btnOrange fright text-right f14 mbdsNone"
                                               style="padding: 3px 5px;cursor: pointer"><i
                                                        class="fas fa-exclamation-triangle"></i> Báo tin sai </a>
                                        </div>

                                        <div class="col-lg-12 text-center">
                                            <p class="mg0">Vui lòng bấm nút <strong>"Nộp hồ sơ"</strong> để ứng tuyển
                                                vào vị
                                                trí công việc này."</p>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main pdt30">
                            <div class="notificationBox bkwhite formJobLarge sm-f14 js_remove_href_a">
                                <div class="bodyBox ">
                                    <div>
                                        <h3 class="font18 fontBold sm-f15">THÔNG TIN THAM KHẢO
                                            <a id="checkUser" class="btnOrange fright text-right f14 dsNone mbdsBlock"
                                               style="padding: 3px 5px;cursor: pointer"><i
                                                        class="fas fa-exclamation-triangle"></i> Báo tin sai </a>
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
                    </div>

                    <section class="jobsSimilar bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                            <h3 class="fw7 f18 white bgrBlueN mgb0">VIỆC LÀM TƯƠNG TỰ</h3>
                        </div>
                        <div class="contentJobsSimilar col-f14 mobileRelative">
                            @foreach ($jobFacebookRelatives as $jobFacebookRelative)
                                <div class="bdBottomGray hvbgrClick">
                                    <a href="{{ route('detail_job_face',['slug'=> $jobFacebookRelative->slug]) }}"
                                       class="noDecoration block  pdl10 pdr10 hvBoxShadow">
                                        <div class="row pdt10 lg-pd10 col-f12">
                                            <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12">

                                                {{--<p class="inBlock pdr10 lg-mgb0 w6 top10x "></p>--}}
                                                <div class="infoSimilar inBlock CutText101 pdl6p xl-pdl8p sm-pdl12p w88 ">
                                                    <h4 class="fontBold textCap black mgb0 f14 cutTitle"><i
                                                                class="far fa-star f28 col-f15 blueN w10 mgr10 "></i>{{ $jobFacebookRelative->title }}
                                                    </h4>
                                                    <p class="nameCompany mgb5 gray"><i class="cutTitle">
                                                            {{ $jobFacebookRelative->company_name }}</i></p>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12 col-12 black textCenter lg-textLeft lg-mg lg-block">
                                                <span class="lg-inBlockIm"><i class="fas fa-hand-holding-usd money"></i> Lương</span>
                                                <span class="block lg-inBlockIm">{{ $jobFacebookRelative->salary_description }}</span>
                                            </div>
                                            <div class="col-xl-3 col-lg-5 col-md-4 col-sm-12 col-12 black textCap textCenter lg-textLeft lg-mg lg-block">
                                                <i class="fas fa-map-marker-alt blueN dsNone mbdsInBlock"></i>
                                                <span class="block lg-inBlockIm">{{ $jobFacebookRelative->district_name }} </span>

                                                <span class="block lg-inBlockIm">{{ $jobFacebookRelative->province_name }}</span>
                                            </div>
                                            <?php
                                            $date = date_create($jobFacebookRelative->date_end);
                                            ?>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 black textCenter lg-textLeft lg-mg lg-block">
                                                <span class="lg-inBlockIm clorang"><i class="fas fa-clock"></i> Ngày đăng tin</span>
                                                <span class="block lg-inBlockIm clorang"><?php

                                                    $date_facebook = \App\Ultility\Ultility::getdateFacebook($jobFacebookRelative['created_at']);
                                                    echo $date_facebook;

                                                    ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach


                            <div class="col-12 text-center hvbgrBlueN">
                                <a href="{{ route('list_job_face') }}" class="block hvWhite pd10">Xem tất cả việc
                                    làm</a>
                            </div>
                        </div>
                    </section>


                </div>

            </div>

        </div>

    </section>

    <link href="{{ \App\Ultility\Ultility::getUrl() }}" rel="canonical" type="text/html"/>
    {{--//google search--}}
    <?php
    $date_create = date_create($jobFacebook->created_at);
    ?>

    @if(strtotime($today) <= strtotime($date_end))
        <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "JobPosting",
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
        },
        "industry": "Phần mềm du lịch",
        "hiringOrganization": {
                            "@type": "Organization",
                            @if(!empty($jobFacebook->company_name))
                "name": "{{ $jobFacebook->company_name }}",
                            @else
                "name": "Khách hàng của Travelwork",
@endif
            "logo": "{{ !empty($information['icon']) ?  asset($information['icon']) : '' }}"
                            },
        "datePosted": "{{ date_format($date_create,"Y-m-d") }}",
           <?php
            $content_remove_style = 'tuyển dụng du lịch';
            $content_remove_style = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>', $jobFacebook->content);?>
            "description": "{!! $content_remove_style !!}",

        "employmentType": "Full-time",
        "experienceRequirements": "{!! $content_remove_style !!}",
        "jobLocation": {
            "@type": "Place",
            "address": {
              "@type": "PostalAddress",
        "streetAddress": "{{ $jobFacebook->district_name }},{{ $jobFacebook->province_name }}",
        "addressLocality": "{{ $jobFacebook->province_name }}",
        "addressRegion": "{{ $jobFacebook->district_name }},{{ $jobFacebook->province_name }}",
        "postalCode": "{{ $jobFacebook->postalcode }}",
        "addressCountry": "VN"
      }
    },
  "salaryCurrency": "VND",
  "title": "{{ $jobFacebook->title }}",
    "validThrough": " {{ date_format($date,"Y-m-d") }}T23:59:59+07:00"
}


        </script>
    @endif

    <script>
        $(document).ready(function () {
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
    @include('site.module_index.dang-ky-tu-van')
    @include('site.module_index.hotline')
    @include('site.default.fixel_bottom_job')
@endsection
