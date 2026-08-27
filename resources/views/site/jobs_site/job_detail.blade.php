@extends('site.layout_site.site')

@section('canonical',  route('job_detail',['slug'=>$job->slug]) )

@section('type_meta', 'website')

@section('title', $job->title)
<?php
$district = \App\Entity\District::getId($job->district);
$province = \App\Entity\Province::getId($job->province);
$ca = \App\Entity\Career::getIdCareer($job->career_category_id);
$age = \App\Entity\Age::getIdAge($job->age_id);
$meta_description = $job->title;
if (!empty($province->province_name)) {
    $meta_description .= ' tại ' . $province->province_name;
}
if (!empty($district->district_name)) {
    $meta_description .= ' ' . $district->district_name;
}
if (!empty($ca->career_category_name)) {
    $meta_description .= ' với vị trí công việc ' . $ca->career_category_name;
}
if (!empty($job->salary_description)) {
    $meta_description .= ' với mức lương ' . $job->salary_description;
}
if (!empty($age)) {
    $meta_description .= ' và độ tuổi ' . $age->name_age;
}if (!empty($job->experience)) {
    $meta_description .= ' và kinh nghiệm ' . $job->experience;
} else {
    $meta_description .= ' và không yêu cầu kinh nghiệm';
}
$meta_description = ucwords($meta_description);
?>
@section('meta_description'){{ $meta_description }}@endsection

@section('keywords', $job->title)

@section('meta_image', !empty($job->employer_image) ?  asset($job->employer_image) : asset('assets/image/anh-vuong.jpg'))

@section('show_css')
    {{--<link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>--}}
    {{----}}
   {{----}}
    {{----}}
    {{--<link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="/assets/web/css/tab_filter.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="/assets/web/css/detail_job.css"/>--}}


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/sitebar.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/css/side_bar_job.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/css/tab_filter.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/web/css/detail_job.css') }}"/>
@endsection

@section('content')

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row ">
                @include('site.sidebar_site.sidebar_job',['sidebar_jobs'=>'sidebar_jobs'])
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline">
                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_job_face') }}" class="">Danh sách việc làm</a>
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
                        @include('site.filter_site.filter_job_face')
                    </div>

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
                                            @if(\Illuminate\Support\Facades\Auth::check())
                                                @if((\Illuminate\Support\Facades\Auth::user()->role) == 1 || (\Illuminate\Support\Facades\Auth::user()->role) == 3 )
                                                    <?php
                                                    $id_user = \Illuminate\Support\Facades\Auth::user()->id;
                                                    $employee = \App\Entity\Employee::getEmployee_id($id_user);
                                                    if (!empty($employee)) {
                                                        $save_job_fb = \App\Entity\Employees_save_job_facebook::checkSaveJobFacebook($employee->employee_id, $job->job_id, 1);
                                                    }
                                                    $teacher = \App\Entity\Teacher::getTeacher_id($id_user);
                                                    if (!empty($teacher)) {
                                                        $teacher_save_job_fb = \App\Entity\Teacher_save_job_facebook::checkSaveJobFacebook($teacher->teacher_id, $job->job_id, 1);
                                                    }
                                                    ?>
                                                @endif

                                                @if(\Illuminate\Support\Facades\Auth::check() && $save_job_fb > 0 && (\Illuminate\Support\Facades\Auth::user()->role) == 1)
                                                    <button class="box_save_job"
                                                            id="deletesaveJob"
                                                            style="color: orange;border: 1px solid;"><i
                                                                class="fas fa-star"
                                                                style="margin-right: 5px"></i>Hủy việc làm đã lưu
                                                    </button>
                                                @else
                                                    <button class="box_save_job"
                                                            id="saveJob"><i
                                                                class="far hoverYellow fa-star"></i> Lưu việc làm
                                                    </button>
                                                @endif
                                            @else
                                                <button class="box_save_job"
                                                        id="saveJob"><i
                                                            class="far hoverYellow fa-star"></i> Lưu việc làm
                                                </button>
                                            @endif
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
                                            <p class="mgb10"><i class="fas fa-users blueN"></i>Số lượng cần tuyển :
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
                                            <p class="mgb10"><i class="fas fa-birthday-cake blueN"></i>Độ tuổi :
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
                                        <div class="col-md-12">
                                            @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 && $job->sale_money == 1)
                                                <?php
                                                $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
                                                ?>
                                            @endif

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
                                                                 data-href="{{ route('job_detail',['slug'=>$job->slug]) }}@if(!empty($employee->employee_id))?user_id_sale={{$employee->employee_id}}@endif" data-layout="" data-size=""><a target="_blank"  href="https://www.facebook.com/sharer/sharer.php?u={{ route('job_detail',['slug'=>$job->slug]) }}@if(!empty($employee->employee_id))?user_id_sale={{$employee->employee_id}}@endif&amp;src=sdkpreparse"
                                                                                 class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                                                        </div>
                                                        <div class="btn_share_zalo">
                                                            <div class="zalo-share-button"
                                                                 data-href="{{ route('job_detail',['slug'=>$job->slug]) }}@if(!empty($employee->employee_id))?user_id_sale={{$employee->employee_id}}@endif"
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
                                                                   value="{{ route('job_detail',['slug'=>$job->slug]) }}@if(!empty($employee->employee_id))?user_id_sale={{$employee->employee_id}}@endif"
                                                                   id="myInput"
                                                                   class="form-control js_add_employee_money css_no_copy"
                                                                   placeholder="copy link chia sẻ"
                                                                   readonly style="">


                                                        </div>
                                                    </div>
                                                </div>


                                        </div>
                                    </div>


                                    <div class="row lg-mgb15 IconDetailJob">
                                        <div class="col-md-12">
                                            <div class="mgb10 DetailJobListCareer">
                                                <i class="fa fa-tags blueN"></i>
                                                <a class="tag-title fw6" href="{{ route('list_type_job') }}"
                                                   target="_blank" style="color:black;">
                                                    Danh sách từ khóa:
                                                </a>
                                                @if (!empty($job->tags))
                                                    <ul class="tags">
                                                        @php
                                                            $tags = explode(',',$job->tags)
                                                        @endphp
                                                        @foreach ($tags as $tag)
                                                            @php
                                                                $tag_slug = str_slug($tag, '-');
                                                            @endphp
                                                            <li>
                                                                <a href="{{ route('detail_type_job',['tag_slug'=>$tag_slug]) }}">
                                                                    {{ $tag }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    @if(!\Illuminate\Support\Facades\Auth::check())
                                    <div class="row lg-mgb15 IconDetailJob div_box_btn_submit_profile_cv">
                                        <div class="col-md-12 text-center">
                                            <a class="box_btn_submit_profile_cv" href="{{ route('apply_job',['slug'=>$job->slug]) }}">
                                                <i class="fas fa-location-arrow blueN"></i>
                                                ỨNG TUYỂN NHANH
                                            </a>
                                            <div class="text-center mgt20">
                                                <p class="mg0 ">Vui lòng bấm nút
                                                    <strong>"ỨNG TUYỂN NHANH"</strong>
                                                    để ứng tuyển vào vị trí công việc này.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                        @endif
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
                                                $description_reomove_script = App\Ultility\Ultility::preg_replace_script($job->description);
                                                $description_replace = preg_replace('/(?<=@.)[a-zA-Z0-9-]*(?=(?:[.]|$))/', '*', $description_reomove_script);
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
                                            $content_reomove_script = App\Ultility\Ultility::preg_replace_script($job->content);
                                            $content_replace = preg_replace('/(?<=@)[a-zA-Z0-9-]*(?=(?:[.]|$))/', '******', $content_reomove_script);
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
                                                $welfare_reomove_script = App\Ultility\Ultility::preg_replace_script($job->welfare);
                                                $welfare_replace = preg_replace('/(?<=@.)[a-zA-Z0-9-]*(?=(?:[.]|$))/', '*', $welfare_reomove_script);
                                                ?>
                                                <?= $welfare_replace ?>
                                            @else
                                                <p>Đang cập nhật thông tin</p>
                                            @endif
                                            <hr>
                                            {{--<div class="jsSocial mgt10 mgb10">--}}
                                                {{--<script type="text/javascript"--}}
                                                        {{--src="https://s7.addthis.com/js/300/addthis_widget.js">--}}
                                                {{--</script>--}}
                                                {{--<div class="addthis_toolbox addthis_default_style addthis_32x32_style">--}}
                                                    {{--<a class="addthis_button_facebook"></a>--}}
                                                    {{--<a class="addthis_button_twitter"></a>--}}
                                                    {{--<a class="addthis_button_email"></a>--}}
                                                    {{--<a class="addthis_button_pinterest_share"></a>--}}
                                                    {{--<a class="addthis_button_compact"></a>--}}
                                                    {{--<a class="addthis_counter addthis_bubble_style"></a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mgb10">
                                        <p class="clOrange mgl15 dsBlock">
                                            <b><i class="far fa-clock"></i> Hạn nộp hồ
                                                sơ: {{ date_format($date_line,"d/m/Y") }}</b>
                                        </p>
                                        <div class="col-md-12 text-center">
                                            <?php
                                            $save_submit_fb = 0; //kiểm tra xem ứng viên đã nộp hồ sơ chưa
                                            $teacher_save_submit_fb = 0;
                                            ?>
                                            @if(\Illuminate\Support\Facades\Auth::check())
                                                @if((\Illuminate\Support\Facades\Auth::user()->role) == 1 || (\Illuminate\Support\Facades\Auth::user()->role) == 3 )
                                                    <?php
                                                    $id_user = \Illuminate\Support\Facades\Auth::user()->id;
                                                    $employee = \App\Entity\Employee::getEmployee_id($id_user);
                                                    if (!empty($employee)) {
                                                        $save_submit_fb = \App\Entity\Employee_submit_job_faacebook::checkSubmitJobFacebook($employee->employee_id, $job->job_id, 1);
                                                    }
                                                    $teacher = \App\Entity\Teacher::getTeacher_id($id_user);
                                                    if (!empty($teacher)) {
                                                        $teacher_save_submit_fb = \App\Entity\Teacher_submit_job_faacebook::checkSubmitJobFacebook($teacher->teacher_id, $job->job_id, 1);
                                                    }
                                                    ?>
                                                @endif
                                                @if($save_submit_fb > 0 && (\Illuminate\Support\Facades\Auth::user()->role) == 1 )
                                                    <a class="box_btn_submit_profile"
                                                       disabled>ĐÃ NỘP HỒ SƠ
                                                    </a>
                                                @elseif (\Illuminate\Support\Facades\Auth::check() && $teacher_save_submit_fb > 0 && (\Illuminate\Support\Facades\Auth::user()->role) == 3)
                                                    <a class="box_btn_submit_profile"
                                                       disabled>ĐÃ NỘP HỒ SƠ
                                                    </a>
                                                @else

                                                    <a class="box_btn_submit_profile"
                                                       href="{{ route('submitFileJobFacebook',['id_job_fb'=> $job->job_id,'status_job'=>1]) }}"
                                                       id="submit_file">NỘP HỒ SƠ
                                                    </a>
                                                @endif
                                                    <div class="text-center mgt20">
                                                        <p class="mg0 ">Vui lòng bấm nút
                                                            <strong>"Nộp hồ sơ"</strong>
                                                            để ứng tuyển vào vị trí công việc này.
                                                        </p>
                                                    </div>
                                            @else
                                                    <a class="box_btn_submit_profile"
                                                    data-toggle="modal"
                                                    data-target="#loginTiva">NỘP HỒ SƠ
                                                    </a>

                                                    <div class="text-center mgt20">
                                                        <p class="mg0 ">Vui lòng bấm nút
                                                            <strong>"NỘP HỒ SƠ"</strong>
                                                            để ứng tuyển vào vị trí công việc này.
                                                        </p>
                                                    </div>
                                                {{--@if($job->status_exam == 1)--}}
                                                {{--<a class="pd10-30 fontBold white  noDecoration  bgrBlueN mgb10"--}}
                                                {{--href="{{ route('submitExamJob',['id_job_fb'=> $job->job_id]) }}"--}}
                                                {{--style="margin-left: 10px;border: none;color: #fff"--}}
                                                {{--id="submit_file">NỘP HỒ SƠ</a>--}}
                                                {{--@else--}}
                                                {{--<a class="box_btn_submit_profile"--}}
                                                   {{--data-toggle="modal"--}}
                                                   {{--data-target="#loginTiva">NỘP HỒ SƠ--}}
                                                {{--</a>--}}
                                                {{--@endif--}}
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="main pdt30">
                            <div class="box_job_detail js_remove_href_a">
                                <div class="bodyBox ">
                                    <div class="title_box_content">
                                        <h2 class="">THÔNG TIN THAM KHẢO</h2>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xl-2 col-md-2 col-sm-4 col-4">
                                            <p clas="textUpper mgb0" style="text-align: right; margin-bottom: 0">
                                                Địa chỉ liên hệ:
                                            </p>
                                        </div>
                                        <div class=" col-xl-10 col-md-10 col-sm-8 col-8">
                                            <p class="mg0">
                                                <b>{{$employer->address}}</b>
                                            </p>
                                        </div>
                                    </div>
                                    <hr>
                                    {{--<div class="row">--}}
                                    {{--<div class="col-xl-2 col-md-2 col-sm-4 col-4">--}}
                                    {{--<p clas="textUpper mgb0" style="text-align: right; margin-bottom: 0">:</p>--}}
                                    {{--</div>--}}
                                    {{--<div class=" col-xl-10 col-md-10 col-sm-8 col-8">--}}
                                    {{--<p class="mg0"><b></b></p>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    @if(!empty($employer->my_facebook))
                                        <div class="row">
                                            <div class="col-xl-2 col-md-2 col-sm-3 col-3">
                                                <p clas="textUpper mgb0" style="text-align: right; margin-bottom: 0">
                                                    <i class="fab fa-facebook-square"></i>
                                                    Fanpage:
                                                </p>
                                            </div>
                                            <div class=" col-xl-10 col-md-10 col-sm-9 col-9 js_word_break">
                                                <p class="mg0 mb_word_break" style=";">
                                                    <b class="cutTitle">
                                                        <a class="dsInline cutTitle"
                                                           href="
                                                            @if(strstr($employer['my_facebook'], 'http'))
                                                           {{ $employer['my_facebook'] }}
                                                           @else
                                                                   http://{{ $employer['my_facebook'] }}
                                                           @endif"
                                                           target="_blank">
                                                            {{$employer->my_facebook}}
                                                        </a>
                                                    </b>
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                    @if(!empty($employer->my_zalo))
                                        <div class="row">
                                            <div class="col-xl-2 col-md-2 col-sm-3 col-3">
                                                <p clas="textUpper mgb0" style="text-align: right; margin-bottom: 0">
                                                    Zalo:
                                                </p>
                                            </div>
                                            <div class=" col-xl-10 col-md-10 col-sm-9 col-9 js_word_break">
                                                <p class="mg0 mb_word_break">
                                                    <b class="cutTitle">
                                                        <a class="dsInline cutTitle"
                                                           href="
                                                            @if(strstr($employer['my_zalo'], 'http'))
                                                           {{ $employer['my_zalo'] }}
                                                           @else
                                                                   http://{{ $employer['my_zalo'] }}
                                                           @endif"
                                                           target="_blank">
                                                            {{$employer->my_zalo}}
                                                        </a>
                                                    </b>
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                    @if(!empty($employer->website))
                                        <div class="row">
                                            <div class="col-xl-2 col-md-2 col-sm-3 col-3">
                                                <p clas="textUpper mgb0" style="text-align: right; margin-bottom: 0">
                                                    Website:
                                                </p>
                                            </div>
                                            <div class=" col-xl-10 col-md-10 col-sm-9 col-9 js_word_break">
                                                <p class="mg0 mb_word_break">
                                                    <b class="cutTitle">
                                                        <a class="dsInline cutTitle"
                                                           href="
                                                                @if(strstr($employer['website'], 'http'))
                                                           {{ $employer['website'] }}
                                                           @else
                                                                   http://{{ $employer['website'] }}
                                                           @endif"
                                                           target="_blank">
                                                            <span class="green  f14 dsInline mgr10">
                                                                {{ $employer['website'] }}
                                                            </span>
                                                        </a>
                                                    </b>
                                                </p>
                                            </div>
                                        </div>
                                    @endif
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
                                @foreach ($jobRelations as $allJobRelative)
                                    @include('site.jobs_site.item_job_new',['job'=> $allJobRelative])
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


                    {{--//google search--}}
                    {{--//su dung api google--}}
                    @if(strtotime($today) > strtotime($date_end))
                        <p class="clOrange">
                            Công việc này đã hết hạn nộp hồ sơ rồi !
                        </p>
                    @else
                    @endif
                    @include('site.module_index_site.dang-ky-tu-van')
                </div>
            </div>
            @include('site.module_index_site.hotline')
        </div>
    </section>


    <!-- Button trigger modal -->
    <!-- Modal -->
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


    @include('site.mobile_bottom_site.fixel_bottom_category_job')
@endsection

@section('show_js')
    <script type="text/javascript" src="/assets/js/sitebar.js"></script>
    <script>
        $('.js_remove_href_a a').removeAttr("href");

        $('.js_show_search_job').click(function () {
            $('.js_filter_job_face').toggle();
        });
        $('.js_show_sidebar').click(function () {
            $('#js_toogle_sidebar').toggle();
            $('.js_closed_open').toggle();
        });
    </script>

    <?php
    $date_create_at = date_create($job->updated_at);
    ?>
    <link href="{{ \App\Ultility\Ultility::getUrl() }}" rel="canonical" type="text/html"/>
    @if(strtotime($today) <= strtotime($date_end))
        @php
            $literacy1 = \App\Entity\Literacy::getIdLi($job->literacy_id);
        @endphp

        <script type="application/ld+json">
                    {
                       "@context":"http://schema.org",
                       "@type":"JobPosting",
                       "title" : "{{ $job->title }}",
                       "name":"{{ $job->title }}",
                       "identifier":{
                       "@type":"PropertyValue",
                       "name":"{{ !empty($job->enterprise_name) ? $job->enterprise_name : ''}}",
                       "value":{{ !empty($job->employer_id) ? $job->employer_id : ''}}
                        },
                       "datePosted" : "{{ date_format($date_create_at,"Y-m-d") }}",
                        <?php $description_reomove_script = App\Ultility\Ultility::preg_replace_script($job->description);?>
                        <?php $description_remove_style = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>', $description_reomove_script);?>
                        <?php $content_reomove_script = App\Ultility\Ultility::preg_replace_script($job->content);?>
                        <?php $content_remove_style = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>', $content_reomove_script);?>
                        <?php $welfare_reomove_script = App\Ultility\Ultility::preg_replace_script($job->welfare);?>
                        <?php $welfare_remove_style = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>', $welfare_reomove_script);?>

                     "description":  "<div class='title_box_content'><h2 class=''>Mô tả công việc</h2></div>{!! $description_remove_style !!} {{ "," }} <div class='title_box_content'><h2 class=''>Yêu cầu công việc</h2></div>{!! $content_remove_style !!} {{ "," }} <div class='title_box_content'><h2 class=''>Phúc lợi xã hội</h2></div> {!! $welfare_remove_style !!}",
                        "hiringOrganization":{
                        "@type":"Organization",
                        "name":"{{ $job->enterprise_name }}",
                        "sameAs":"{{route('detail_employer',['id' => $employer->slug])}}",
                        @if(!empty($job->employer_image))
                          "logo": "{{ !empty($job->employer_image) ? asset($job->employer_image) : '' }}"
                        @else
                         "logo": "{{ !empty($information['logo']) ?  asset($information['logo']) : '' }}"
                         @endif

                    },
                        "validThrough":"{{ date_format($date_line,"Y-m-d") }}T23:59:59+07:00",
                        "baseSalary":{
                        "@type":"MonetaryAmount",
                        "currency":"VND",
                          "value":{
                             "@type":"QuantitativeValue",
                             "minValue":{{ $job->salary_from }},
                             "maxValue":{{ $job->salary_to }},
                             "value":{{ $job->salary_to }},
                             "unitText":"MONTH"
                          }
                        },
                       "employmentType":"FULL_TIME",
                       @if (!empty($job_experience->experience_month))
                        "experienceRequirements" : {
                        "@type" : "OccupationalExperienceRequirements",
                        "monthsOfExperience" : "{{ $job_experience->experience_month }}"
                            },
                        @endif
                        @if (!empty($literacy1->description))
                        "educationRequirements" : {
                            "@type" : "EducationalOccupationalCredential",
                            "credentialCategory" : "{{ $literacy1->description }}"
                            },
                        @endif
                        "industry":"Du lịch",
                        "employerOverview" : "{!! $description_remove_style !!}",
                        "occupationalCategory" : "{{ !empty($ca['career_category_name']) ? $ca['career_category_name'] : 'Nhân viên du lịch' }}" ,
                        "jobLocation":{
                            "@type":"Place",
                            "address":{
                                "@type":"PostalAddress",
                                "streetAddress":"{{ $job->address_work }}",
                                  "addressLocality":"{{ $job->district_name }}",
                                 "addressRegion":"{{ $job->province_name }}",
                                 "addressCountry":"VN",
                                 "postalCode":"{{ $job->postalcode }}"
                              }
                        }
                    }
        </script>
    @endif
    <script>

        $(document).ready(function () {
            $('#saveJob').click(function () {
                @if(\Illuminate\Support\Facades\Auth::check())
                @if ((\Illuminate\Support\Facades\Auth::user()->role) == 1)
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: '{!! route('saveJob',['job_id'=>$job->job_id]) !!}',
                    data: {
                        id_job: '{{ $job->job_id }}',
                        // status_job 1 là việc nhà tuyển dung ; 0 là việc facebook
                        status_job: 1,
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
            $('#deletesaveJob').click(function () {
                @if(\Illuminate\Support\Facades\Auth::check())
                @if ((\Illuminate\Support\Facades\Auth::user()->role) == 1)
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: '{!! route('deletesaveJob',['job_id'=>$job->job_id]) !!}',
                    data: {
                        id_job: '{{ $job->job_id }}',
                        // status_job 1 là việc nhà tuyển dung ; 0 là việc facebook
                        status_job: 1,
                    },
                    success: function (result) {
                        alert('Hủy việc làm đã lưu thành công!');
                    },
                    error: function (result) {
                        alert('Hủy việc làm đã lưu thất bại');
                    }
                });
                @else
                //luu loi hien thi taij dang nhap
                $('#InfoWarning').html('Hủy việc làm đã lưu thất bại');
                $('#loginTiva').modal('show');
                @endif
                @else
                //luu loi hien thi taij dang nhap
                $('#InfoWarning').html('Hủy việc làm đã lưu thất bại');
                $('#loginTiva').modal('show');
                @endif
            });


        });

    </script>


    <script>
        $(document).ready(function () {
            //xoas hre cua
            $('#content_remove_a a').removeAttr("href");
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
                    console.log("Thêm thất bại ");
                }
            });
            @endif
        });

    </script>
    {{--chia se tin tuyển dung--}}
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
    @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 && $job->sale_money == 1)
        <?php $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id); ?>
        <script>
            $(document).ready(function () {
                $('.js_add_employee_money').click(function () {
                    $.ajax({
                        url: "{!! route('create_employee_share_job') !!}", // gửi ajax đến file result.php
                        type: "get", // chọn phương thức gửi là get
                        dateType: "json", // dữ liệu trả về dạng text
                        data: { // Danh sách các thuộc tính sẽ gửi đi
                            employee_id: '{{ $employee->employee_id }}',
                            job_id: '{{ $job->job_id }}',
                        },
                        success: function (result) {
                            // Sau khi gửi và kết quả trả về thành công thì gán nội dung trả về
                            // đó vào thẻ div có id = result
                            console.log("Thêm thành công");
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            // When AJAX call has failed
                            console.log('Thêm thất bại');
                        },
                    });
                });
            });
        </script>
    @endif

    {{--$post_id,$employee_id,$ip_sale--}}
    @if(!empty($_GET['user_id_sale']))
        <?php
        $employee_id = $_GET['user_id_sale'];
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        ?>
        <script>
            $(document).ready(function () {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{!! route('add_ajax_sale_money_job') !!}", // gửi ajax đến file result.php
                    type: "post", // chọn phương thức gửi là post
                    dateType: "text", // dữ liệu trả về dạng text
                    data: { // Danh sách các thuộc tính sẽ gửi đi
                        job_id: '{{ $job->job_id }}',
                        employee_id: '{{ $employee_id }}',
                        ip_sale: "{{ $ip }}"
                    },
                    success: function (result) {
                        // Sau khi gửi và kết quả trả về thành công thì gán nội dung trả về
                        // đó vào thẻ div có id = result
                        console.log("Thêm thành công");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // When AJAX call has failed
                        console.log('Thêm thất bại');
                    },
                });
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{!! route('delete_post_sale_money_job') !!}", // gửi ajax đến file result.php
                    type: "get", // chọn phương thức gửi là post
                    dateType: "json", // dữ liệu trả về dạng text
                    data: {},
                    success: function (result) {
                        // Sau khi gửi và kết quả trả về thành công thì gán nội dung trả về
                        // đó vào thẻ div có id = result
                        console.log("Xóa thành công");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // When AJAX call has failed
                        console.log('Xóa thất bại');
                    },
                });
            });
        </script>
    @endif
    <script>
        $('.js_itemsteep').matchHeight()
    </script>

@endsection
