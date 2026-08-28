@extends('site.layout.site')

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

@section('meta_image', asset('assets/image/anh-vuong.jpg')  )

@section('content')
    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row ">
                @include('site.sidebar.sidebar_job',['sidebar_jobs'=>'sidebar_jobs'])
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline">
                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_job_face') }}" class=" f18 md-f14 mgb0">Danh sách việc làm</a>
                            </li>
                        </ul>
                    </div>
                    <div class="mbdsNone">
                        @include('site.filter.filter_job_face')
                    </div>

                    <div class="InfoCompanyJob">
                        <div class="main">
                            <div class="notificationBox bkwhite formJobLarge sm-f14">
                                <div class="bodyBox ">
                                    <div class="mgb10 postionImg">
                                        <div class="w90">

                                            <?php
                                            $date = date_create($job->deadline_submit_profile);
                                            $date_end = date_format($date, "d-m-Y");
                                            $today = date('d-m-Y');
                                            ?>

                                            @if(strtotime($today) > strtotime($date_end))
                                                <p class="clred f16 fw6">
                                                    Công việc này đã hết hạn nộp hồ sơ rồi !
                                                </p>
                                            @else

                                            @endif


                                            <h1 class="fontBold blueDN mgb0 f23 lg-f20 sm-f15">{{$job->title}}</h1>

                                            @if(isset($employer->enterprise_name))
                                                <a href="{{route('detail_employer',['slug' => $employer->slug])}}"
                                                   class="xam font18 sm-f15 clorange mgt15 titleCompanyName"
                                                   style="display: inline-block">{{ isset($employer->enterprise_name) ? $employer->enterprise_name : ''}}</a>
                                            @endif



                                        </div>
                                        <div class="w10">
                                            <img class="chuaxathuc lazy" src="{{ asset('assets/image/xacthuc.jpg') }}"
                                                 title="Xác thực tại sanketoan.vn" alt="Xác thực tại sanketoan.vn">
                                        </div>
                                    </div>


                                    <div class="row">
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
                                                    <button class="pd5-10 mgr20 bkwhite BorderLightGray"
                                                            id="deletesaveJob"
                                                            style="color: orange;border: 1px solid;"><i
                                                                class="fas fa-star blueN"
                                                                style="margin-right: 5px"></i>Hủy việc
                                                        làm đã lưu
                                                    </button>
                                                @else
                                                    <button class="pd5-10 mgr20 bkwhite BorderLightGray"
                                                            id="saveJob"><i
                                                                class="far hoverYellow fa-star blueN"></i> Lưu việc làm
                                                    </button>
                                                @endif
                                            @else
                                                <button class="pd5-10 mgr20 bkwhite BorderLightGray"
                                                        id="saveJob"><i
                                                            class="far hoverYellow fa-star blueN"></i> Lưu việc làm
                                                </button>
                                            @endif
                                            <span class="sm-block sm-mgt10"><i
                                                        class="far fa-clock blueN"></i> Ngày đăng tin : {{ $date_facebook }}</span>


                                            <span class="sm-block sm-mgt10"
                                                  style="margin-left: 20px"><i
                                                        class="fas fa-eye blueN"></i> Lượt xem: {{$job->views}}
                                                </span>

                                            <span class="sm-block sm-mgt10"
                                                  style="margin-left: 20px"> <i
                                                        class="fas fa-code blueN"></i> Mã tin: {{$job->job_code}}
                                                   </span>
                                        </div>


                                    </div>
                                    <p></p>
                                    <div class="row lg-mgb15 IconDetailJob">
                                        <div class="col-md-6">
                                            <p class="mgb10"><i class="far fa-money-bill-alt blueN"></i>Mức lương
                                                : {{isset($job->salary_description) ? $job->salary_description : 'Đang cập nhật '}}
                                            </p>
                                            <p class="mgb10"><i class="fas fa-clipboard-check blueN"></i>Kinh nghiệm :
											 <?php
                                            $job_experience = \App\Entity\Experience::getIdEx($job->experience_id);
                                            ?>
                                                {{isset($job_experience->experience_des) ? $job_experience->experience_des : 'Không yêu cầu'}}
                                            </p>
                                            <p class="mgb10"><i class="fas fa-graduation-cap blueN"></i>Trình độ :
                                                {{isset($job->literacy_name) ? $job->literacy_name : 'Không yêu cầu'}}
                                            </p>

                                            <p class="mgb10"><i class="fab fa-microsoft blueN"></i>Phần mềm yêu cầu :
                                                <?php
                                                $software = \App\Entity\Software::getId($job->software_id)
                                                ?>
                                                {{isset($software->software_name) ? $software->software_name : 'Không yêu cầu'}}
                                            </p>
                                            <?php
                                            $job_career = \App\Entity\JobCareer::getIdJob($job->job_id);
                                            ?>
                                            <div class="mgb10 DetailJobListCareer"><i class="fas fa-user-tie blueN"></i>Vị
                                                trí
                                                công việc :

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

                                            <p class="mgb10"><i class="fas fa-venus-mars blueN"></i>Giới tính :
                                                @if($job->gender == 0)
                                                    Không yêu cầu giới tính
                                                @elseif($job->gender == 1)
                                                    Nữ
                                                @elseif($job->gender == 2)
                                                    Nam
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
                                            <p class="mgb10"><i class="fas fa-map-marker-alt blueN"></i>Địa chỉ : <?php
                                                $district = \App\Entity\District::getId($job->district);
                                                $province = \App\Entity\Province::getId($job->province);
                                                ?>{{ isset($district->district_name) ? $district->district_name : '' }}
                                                @if(!empty($district->district_name))
                                                    -
                                                @endif
                                                {{ isset($province->province_name) ? $province->province_name : '' }}
                                            </p>
                                            @if(isset($job->address_work))
                                                <p class="mgb10"><i class="fas fa-map-marker-alt blueN"></i>Địa điểm làm
                                                    việc
                                                    : {{isset($job->address_work) ? $job->address_work : '' }}</p>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 && $job->sale_money == 1)
                                                <?php $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id); ?>
                                                <div class="mgb15">
                                                    <div id="fb-root"></div>
                                                    <script async defer crossorigin="anonymous"
                                                            src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0"></script>
                                                    <div class="fb-share-button"
                                                         data-href="{{ route('job_detail',['slug'=>$job->slug]) }}?user_id_sale={{$employee->employee_id}}"
                                                         data-layout="button" data-size="large"><a target="_blank"
                                                                                                   href="https://www.facebook.com/sharer/sharer.php?u={{ route('job_detail',['slug'=>$job->slug]) }}?user_id_sale={{$employee->employee_id}}&amp;src=sdkpreparse"
                                                                                                   class="fb-xfbml-parse-ignore js_add_employee_money share_facebook"><i class="fas fa-dollar-sign"></i> Chia sẻ lên
                                                            facebook</a>
                                                    </div>

                                                    <div class="input-group mb-3 copy_link_post">
                                                        <input type="text"
                                                               value="{{ route('job_detail',['slug'=>$job->slug]) }}?user_id_sale={{$employee->employee_id}}"
                                                               id="myInput" class="form-control js_add_employee_money css_no_copy" placeholder="copy link chia sẻ" readonly
                                                               style="width: 100%;">

                                                        <div class="input-group-append">
                                                            <button onclick="myFunction()" class="btn btn-outline-secondary copylink js_add_employee_money">Copy
                                                                link tuyển dụng
                                                            </button>

                                                        </div>
                                                    </div>




                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="main pdt30">
                            <div class="notificationBox bkwhite formJobLarge sm-f14">
                                <div class="bodyBox ">
                                    <div>
                                        <h2 class="font18 fontBold textUpper sm-f15">Mô tả công việc</h2>
                                    </div>
                                    <hr>
                                    <div class="row sm-pd10">

                                        <div class="col-md-12 contentResetCss" id="content_remove_a">
                                            @if(!empty($job->description))
                                                <?php
                                                $description = App\Ultility\Ultility::ReplaceContent($job->description);
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
                                    <div>
                                        <h2 class="font18 fontBold textUpper sm-f15">Yêu cầu công việc</h2>
                                    </div>
                                    <hr>
                                    <div class="row sm-pd10">

                                        <div class="col-md-12 contentResetCss" id="content_remove_a">
                                            <?php
                                            $content = App\Ultility\Ultility::ReplaceContent($job->content);
                                            $content_replace = preg_replace('/(?<=@)[a-zA-Z0-9-]*(?=(?:[.]|$))/', '******', $content);
                                            //                                            $content_replace = preg_replace('/^[a-z0-9_-]{3,15}$/', '****', $content);
                                            ?>
                                            <?= $content_replace ?>


                                        </div>
                                    </div>
                                    <hr>

                                </div>

                                <div class="bodyBox ">
                                    <div>
                                        <h2 class="font18 fontBold textUpper sm-f15">Phúc lợi xã hội</h2>
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
                                            <div class="jsSocial mgt10 mgb10">
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
                                                     data-href="{{ \App\Ultility\Ultility::getUrl() }}"
                                                     data-oaid="579745863508352884" data-layout="2" data-color="blue"
                                                     data-customize=true
                                                     style="background: #03a3fb;color: #fff;padding: 1px 10px;"><img
                                                            src="{{ asset('assets/image/logozalo.jpg') }}"
                                                            class="lazy"
                                                            title="Chia sẻ zalo trên sanketoan.vn"
                                                            alt="Chia sẻ zalo trên sanketoan.vn"
                                                            style="width: 30px;">Chia sẻ Zalo
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row mgb10">
                                        <p class="clorange mgl15 dsBlock"><b><i class="far fa-clock"></i> Hạn nộp hồ
                                                sơ: {{ date_format($date_line,"d/m/Y") }}</b></p>
                                        <div class="col-md-12 text-center">


                                            <h3 class="f24 text-left">Các bước nộp hồ sơ</h3>

                                            <div class="row Step">
                                                @foreach(\App\Entity\SubPost::showSubPost('cac-buoc-tao-ho-so', 4) as $id => $steep)
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="itemsteep
@if($id == 0) bgOrangeSteep @endif @if($id == 1) bgBlueSteep @endif @if($id == 2) bgRedSteep @endif @if($id == 3) bgGreenSteep @endif">

                                                            <div class="contentsteep"><span
                                                                        class="">{{ isset($steep['title']) ? $steep['title'] : '' }}</span>
                                                                : {{ isset($steep['description']) ? $steep['description'] : '' }}
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach


                                            </div>

                                            <div class="mgt20"></div>
                                            <?php
                                            $save_submit_fb = 0;
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
                                                    <a class="pd10-30 fontBold white noDecoration  bgrBlueN mgb10 submitFrofile"
                                                       disabled>ĐÃ NỘP HỒ SƠ</a>
                                                @elseif (\Illuminate\Support\Facades\Auth::check() && $teacher_save_submit_fb > 0 && (\Illuminate\Support\Facades\Auth::user()->role) == 3)
                                                    <a class="pd10-30 fontBold white noDecoration  bgrBlueN mgb10"
                                                       disabled>ĐÃ NỘP HỒ SƠ</a>
                                                @else

                                                    <a class="pd10-30 fontBold white  noDecoration  bgrBlueN mgb10 submitFrofile"
                                                       href="{{ route('submitFileJobFacebook',['id_job_fb'=> $job->job_id,'status_job'=>1]) }}"
                                                       id="submit_file">NỘP HỒ SƠ</a>


                                                @endif
                                            @else
                                                {{--@if($job->status_exam == 1)--}}
                                                {{--<a class="pd10-30 fontBold white  noDecoration  bgrBlueN mgb10"--}}
                                                {{--href="{{ route('submitExamJob',['id_job_fb'=> $job->job_id]) }}"--}}
                                                {{--style="margin-left: 10px;border: none;color: #fff"--}}
                                                {{--id="submit_file">NỘP HỒ SƠ</a>--}}
                                                {{--@else--}}
                                                <a class="pd10-30 fontBold white noDecoration  bgrBlueN mgb10 submitFrofile"
                                                   data-toggle="modal" data-target="#loginTiva" >NỘP
                                                    HỒ SƠ</a>
                                                {{--@endif--}}
                                            @endif





                                        </div>

                                    </div>
                                    <div class="text-center mgt20">
                                        <p class="mg0 ">Vui lòng bấm nút <strong>"Nộp hồ sơ"</strong> để ứng tuyển vào
                                            vị
                                            trí công việc này."</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="main pdt30">
                            <div class="notificationBox bkwhite formJobLarge sm-f14 js_remove_href_a">
                                <div class="bodyBox ">
                                    <div>
                                        <h3 class="font18 fontBold sm-f15">THÔNG TIN THAM KHẢO</h3>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xl-2 col-md-2 col-sm-4 col-4">
                                            <p clas="textUpper mgb0" style="text-align: right; margin-bottom: 0">Địa chỉ
                                                liên hệ:</p>
                                        </div>
                                        <div class=" col-xl-10 col-md-10 col-sm-8 col-8">
                                            <p class="mg0"><b>{{$employer->address}}</b></p>
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
                                        <div class="col-xl-2 col-md-2 col-sm-4 col-4">
                                            <p clas="textUpper mgb0" style="text-align: right; margin-bottom: 0"><i class="fab fa-facebook-square"></i> Fanpage:</p>
                                        </div>
                                        <div class=" col-xl-10 col-md-10 col-sm-8 col-8">
                                            <p class="mg0 mb_word_break" style=";"><b class="cutTitle"><a class="dsInline cutTitle" href="@if(strstr($employer['my_facebook'], 'http')) {{ $employer['my_facebook'] }} @else http://{{ $employer['my_facebook'] }} @endif " target="_blank">{{$employer->my_facebook}}</a></b></p>
                                        </div>
                                    </div>
                                    @endif
                                    @if(!empty($employer->my_zalo))
                                    <div class="row">
                                        <div class="col-xl-2 col-md-2 col-sm-4 col-4">
                                            <p clas="textUpper mgb0" style="text-align: right; margin-bottom: 0">Zalo:</p>
                                        </div>
                                        <div class=" col-xl-10 col-md-10 col-sm-8 col-8">
                                            <p class="mg0 mb_word_break"><b class="cutTitle"><a class="dsInline cutTitle" href="@if(strstr($employer['my_zalo'], 'http')) {{ $employer['my_zalo'] }} @else http://{{ $employer['my_zalo'] }} @endif " target="_blank">{{$employer->my_zalo}} </a></b></p>
                                        </div>
                                    </div>
                                        @endif
                                    @if(!empty($employer->website))
                                        <div class="row">
                                            <div class="col-xl-2 col-md-2 col-sm-4 col-4">
                                                <p clas="textUpper mgb0" style="text-align: right; margin-bottom: 0">Website:</p>
                                            </div>
                                            <div class=" col-xl-10 col-md-10 col-sm-8 col-8">
                                                <p class="mg0 mb_word_break"><b class="cutTitle"> <a class="dsInline cutTitle" href="@if(strstr($employer['website'], 'http')) {{ $employer['website'] }} @else http://{{ $employer['website'] }} @endif " target="_blank">
                                                            <span class="green  f14 dsInline mgr10"> {{ $employer['website'] }}</span>
                                                        </a></b></p>
                                            </div>
                                        </div>
                                    @endif



                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="jobsSimilar bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                            <h3 class="f18 white bgrBlueN mgb0 fw7">VIỆC LÀM TƯƠNG TỰ</h3>
                        </div>
                        <div class="contentJobsSimilar col-f14 mobileRelative">
                            @foreach($jobRelations as $allJobRelative)
                                <div class="bdBottomGray hvbgrClick">
                                    <a href="{{ route('job_detail',['slug'=>$allJobRelative->slug]) }}"
                                       class="noDecoration block  pdl10 pdr10 hvBoxShadow">
                                        <div class="row pdt10 lg-pd10 col-f12">
                                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 itemJobRelative">
                                                <div class="infoSimilar inBlock CutText101 pdl6p xl-pdl8p sm-pdl12p">
                                                    <h4 class="fontBold textCap black mgb0 f14 cutTitle"><i
                                                                class="far fa-star f28 col-f15 blueN  mgr5"></i> {{isset($allJobRelative->title) ? $allJobRelative->title :''}}
                                                    </h4>
                                                    <?php
                                                    $empoyer = \App\Entity\Employer::getIdemployer($allJobRelative->employer_id)
                                                    ?>
                                                    <p class="nameCompany mgb5 gray cutTitle">
                                                        <i>{{isset($empoyer->enterprise_name) ? $empoyer->enterprise_name :''}}</i>
                                                    </p>

                                                    {{--<div class="infoSimilar inBlock CutText101 pdl6p xl-pdl8p sm-pdl12p w88">--}}
                                                    {{--<p class="fontBold textCap black mgb0"> {{ $jobFacebookRelative->title }}</p>--}}
                                                    {{--<p class="nameCompany mgb5 gray"><i>--}}
                                                    {{--{{ $jobFacebookRelative->employer }}</i></p>--}}
                                                    {{--</div>--}}
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 black textCenter lg-textLeft lg-mg lg-block">
                                                <span class="lg-inBlockIm"><i class="fas fa-hand-holding-usd money"></i> Lương</span>
                                                <?php
                                                $salary = \App\Entity\Salary::getIdSalary($allJobRelative->salary_id);
                                                ?>
                                                <span class="block lg-inBlockIm">{{isset($salary->description) ? $salary->description :'Đang cập nhật'}}</span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 black textCap textCenter lg-textLeft lg-mg lg-block">
                                                <i class="fas fa-map-marker-alt blueN dsNone mbdsInBlock"></i>
                                                <?php
                                                $district = \App\Entity\District::getId($allJobRelative->district);
                                                $province = \App\Entity\Province::getId($allJobRelative->province);
                                                ?>

                                                <span class="block lg-inBlockIm">{{$district['district_name']}}


                                                    <span class="block lg-inBlockIm">{{$province['province_name']}}</span>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 black textCenter lg-textLeft lg-mg lg-block">
                                                <span class="lg-inBlockIm clorang"><i class="fas fa-clock"></i> Ngày đăng tin </span>


                                                <span class="block lg-inBlockIm clorang"><?php
                                                    $date_facebook = \App\Ultility\Ultility::getdateFacebook($allJobRelative['updated_at']);
                                                    echo $date_facebook;
                                                    ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                            <div class="col-12 text-center hvbgrBlueN mgt5">
                                <a href="{{route('list_job_face')}}" class="block hvWhite pd10">Xem tất cả việc làm</a>
                            </div>
                        </div>
                    </section>
                    {{--//google search--}}
                    {{--//su dung api google--}}

                    @if(strtotime($today) > strtotime($date_end))
                        <p class="clred f16 fw6">
                            Công việc này đã hết hạn nộp hồ sơ rồi !
                        </p>
                    @else

                    @endif


                    <?php
                    $date_create_at = date_create($job->updated_at);
                    ?>
                    <link href="{{ \App\Ultility\Ultility::getUrl() }}" rel="canonical" type="text/html"/>
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
            "value": {{ $job->salary_to }}.0,
            "minValue":{{ $job->salary_from }}.0,
            "maxValue":{{ $job->salary_to }}.0,
            "unitText": "MONTH"
          }
        },

        @if(!empty($job->welfare))
                                <?php $welfare_remove_style = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $job->welfare);?>
                                "jobBenefits": "{{ $welfare_remove_style }}",
         @endif
                            "datePosted": "{{ date_format($date_create_at,"Y-m-d") }}",
          @if(!empty($job->description))
                                <?php $description_remove_style = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $job->description);?>
                                "description": "{!! $description_remove_style !!}",
         @else
                                <?php $content_remove_style = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $job->content);?>
                                "description": "{!! $content_remove_style !!}",
              @endif
                            "educationRequirements": "{{isset($job->literacy_name) ? $job->literacy_name : 'Không yêu cầu'}}",
         "employmentType": "Full-time",
          <?php $content_remove_style = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $job->content);?>
                            "experienceRequirements": "{!! $content_remove_style !!}",
         "industry": "{{isset($software->software_name) ? $software->software_name : 'Phần mềm du lịch'}}",
         "hiringOrganization": {
                              "@type": "Organization",
                              "name": "{{ $job->enterprise_name }}",
                              "sameAs": "{{ $job->employer_website }}",
                               <?php $external_link = asset($employer['image']);?>
                            @if(@GetImageSize($external_link))
                                "logo": "{{ asset($job->employer_image) }}"
                                @else
                                "logo": "{{ !empty($information['icon']) ?  asset($information['icon']) : '' }}"
                                 @endif

                            },
         "jobLocation": {
                            "@type": "Place",
                            "address": {
                             "@type": "PostalAddress",
                             "streetAddress": "{{ $job->address_work }}",
                             "addressLocality": "{{ $job->province_name }}",
                             "addressRegion": "{{ $job->district_name }},{{ $job->province_name }}",
                             "postalCode": "{{ $job->postalcode }}",
                             "addressCountry": "VN"
                      }
                      },
         "salaryCurrency": "VND",
         "skills": "{{isset($software->software_name) ? $software->software_name : 'Phần mềm du lịch'}}",
         "title": "{{ $job->title }}",
          "validThrough": " {{ date_format($date_line,"Y-m-d") }}T23:59:59+07:00"
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
                                    url: '{!! route('saveJob', ['id_job' => $job->job_id]) !!}',
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
                                    url: '{!! route('deletesaveJob', ['id_job' => $job->job_id]) !!}',
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
                    @include('site.module_index.dang-ky-tu-van')


                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>

    {{--chia se tin tuyển dung--}}
    <script>
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
                $('.js_add_employee_money').click(function(){
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
                $('.js_remove_href_a a').removeAttr("href");
                {{--console.log("{{  $post->post_id }}");--}}
                {{--console.log("{{ $employee_id }}");--}}
                {{--console.log("{{ $ip }}");--}}

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
                    data: {
                    },
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
    @include('site.mobile_bottom.fixel_bottom_detail_job')
@endsection
