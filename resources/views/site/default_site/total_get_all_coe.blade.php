<?php
$date = date_create($coe->created_at);
$career_category_name = \App\Entity\Career::where('career_category_id', $coe->career_category_id)->value('career_category_name');
$type_of_business_name = \App\Entity\TypeOfBusiness::where('type_of_business_id', $coe->type_of_business_id)->value('type_of_business_name');
$business_type_name = \App\Entity\Business::where('business_type_id', $coe->business_type_id)->value('business_type_name');
$literacy_name = \App\Entity\Literacy::where('literacy_id', $coe->literacy_id)->value('literacy_name');
$office_name = \App\Entity\Office_information::where('office_id', $coe->office_id)->value('office_name');
//                                    $exp_name = \App\Entity\Experience_postion::where('exp_id', $coe->exp_id)->value('exp_name');
$exp_bus_name = \App\Entity\Experience_business::where('exp_bus_id', $coe->exp_bus_id)->value('exp_bus_name');
$software_name = \App\Entity\Software::where('software_id', $coe->software_id)->value('software_name');
$lang_name = \App\Entity\LanguageLiteracy::where('lang_id', $coe->lang_id)->value('lang_name');
$soft_name = \App\Entity\SoftSkills::where('soft_id', $coe->soft_id)->value('soft_name');
$cer_name = \App\Entity\Certificate::where('cer_id', $coe->cer_id)->value('cer_name');
$work_name = \App\Entity\WorkPressure::where('work_id', $coe->work_id)->value('work_name');
$province_name = \App\Entity\Province::where('province_id', $coe->province_id)->value('province_name');
$com_name = \App\Entity\CommitCompany::where('com_id', $coe->com_id)->value('com_name');
$list_exp_name = \App\Entity\Coefficients_exp::select('experience_postion.exp_name')->where('coe_id', $coe->coe_id)->join('experience_postion', 'experience_postion.exp_id', '=', 'coefficients_exp.exp_id')->get();
$string_exp_name = '';
if (!empty($list_exp_name)) {
    foreach ($list_exp_name as $exp) {
        $string_exp_name .= $exp->exp_name . ',';
    }
}
//lời khuyên
$office_give = \App\Entity\Office_information::where('office_id', $coe->office_id)->value('office_give');
$software_give = \App\Entity\Software::where('software_id', $coe->software_id)->value('software_give');
$lang_give = \App\Entity\LanguageLiteracy::where('lang_id', $coe->lang_id)->value('lang_give');
$soft_give = \App\Entity\SoftSkills::where('soft_id', $coe->soft_id)->value('soft_give');
$com_give = \App\Entity\CommitCompany::where('com_id', $coe->com_id)->value('com_give');
?>

@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', 'Bảng kết quả mức lương tương ứng với năng lực của '.$career_category_name.' thời gian thực hiện '.date_format($date,"H:i").' ngày '.date_format($date,"d-m-Y"))
@section('meta_description', 'Tham khảo lương tương ứng với năng lực của '.$career_category_name.' tại '.$province_name.' trong công ty '.$type_of_business_name)
@section('keywords', 'Bảng kết quả mức lương tương ứng với năng lực của bạn thời gian thực hiện '.date_format($date,"H:i").' ngày '.date_format($date,"d-m-Y"))
@section('meta_image', isset($information['banner-chia-se-he-so-luong']) ?  asset($information['banner-chia-se-he-so-luong']) : asset($information['logo']))
@section('canonical', 'https://sanketoan.vn/')
@section('meta_url', 'https://sanketoan.vn/')
@section('content')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" href="/public/assets/css/course/teacher.css"/>
    <link rel="stylesheet" href="/public/assets/css/course/course.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/css/coe_salary.css"/>
    <section class="coe_salary">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-md-12">
                    <div class="title_coe_salary text-center">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box_res_coe">
                                    <div class="res_title_coe">
                                        <p>Bảng kết quả mức lương tương ứng với năng lực của bạn</p>
                                    </div>
                                    <div class="res_time_coe">

                                        <p>Thời gian thực hiện : <span
                                                    class="clred">{{ date_format($date,"H:i") }} ngày {{ date_format($date,"d-m-Y") }}</span>
                                        </p>
                                        <p class="mgb15" style="margin-bottom: 15px !important;">Đơn vị phân tích : <a>travelwork.vn
                                                - Website chuyên về tuyển dụng việc làm du lịch</a></p>
                                    </div>
                                    <div class="res_title_info">
                                        <p class="fw6 f18">Thông tin về năng lực hiện tại của bạn</p>
                                    </div>


                                    <div class="res_coe_content">
                                        <p>Vị trí công việc : <span
                                                    class="clred">{{ !empty($career_category_name) ? $career_category_name : '' }}</span>
                                        </p>
                                        <p>Loại hình doanh nghiệp : <span
                                                    class="clred">{{ !empty($type_of_business_name) ? $type_of_business_name : '' }}</span>
                                        </p>
                                        <p>Vị trí tỉnh thành : <span
                                                    class="clred">{{ !empty($province_name) ? $province_name : '' }}</span>
                                        </p>
                                        <p>Kinh nghiệm của bạn : <span
                                                    class="clred">{{ !empty($exp_bus_name) ? $exp_bus_name : '' }}</span>
                                        </p>
                                        @if(!empty($literacy_name))
                                            <p>Trình độ học vấn : <span class="clred">{{ $literacy_name }}</span></p>
                                        @endif
                                        @if(!empty($office_name))
                                            <p>Tin học văn phòng: <span class="clred"> {{ $office_name }}</span></p>
                                        @endif
                                        @if(!empty($string_exp_name))
                                            <p>Kinh nghiệm vị trí khác: <span
                                                        class="clred"> {{ $string_exp_name }}</span></p>
                                        @endif
                                        @if(!empty($business_type_name))
                                            <p>Loại hình kinh doanh: <span
                                                        class="clred">{{ $business_type_name }}</span></p>
                                        @endif
                                        @if(!empty($software_name))
                                            <p>Phần mềm du lịch: <span class="clred"> {{ $software_name }}</span></p>
                                        @endif
                                        @if(!empty($lang_name))
                                            <p>Trình độ ngoại ngữ: <span class="clred">{{ $lang_name }}</span></p>
                                        @endif
                                        @if(!empty($soft_name))
                                            <p>Kỹ năng mềm: <span class="clred">{{ $soft_name }}</span></p>
                                        @endif
                                        @if(!empty($cer_name))
                                            <p>Chứng chỉ nghề nghiệp: <span class="clred">{{ $cer_name }}</span></p>
                                        @endif
                                        @if(!empty($work_name))
                                            <p>Khả năng chịu áp lực: <span class="clred">{{ $work_name }}</span></p>
                                        @endif
                                        @if(!empty($com_name))
                                            <p>Cam kết gắn bó với công ty: <span class="clred">{{ $com_name }}</span>
                                            </p>
                                        @endif
                                    </div>
                                    <div class="res_coe_salary">
                                        <p>Với những thông tin trên , mức lương dự kiến bạn sẽ được hưởng là :</p>
                                        <?php
                                        $coe_salary = round($coe->total_salary, 1);
                                        //                                        $coe_salary = $coe->total_salary;
                                        ?>
                                        <p><span class="clred">{{ $coe_salary }} triệu </span></p>
                                    </div>
                                    <div class="res_give_advice">
                                        <p>Để có mức lương tốt hơn , lời khuyên chúng tôi dành cho bạn là :</p>
                                        <ul>
                                            @if(empty($office_name))
                                                <li>{{ !empty($information['loi-khuyen-tin-hoc-van-phong']) ?  $information['loi-khuyen-tin-hoc-van-phong'] : '' }}</li>
                                            @else
                                                <li> {{ !empty($office_give) ? $office_give : '' }}</li>
                                            @endif
                                            @if(empty($software_name))
                                                <li>{{ !empty($information['loi-khuyen-phan-mem-ke-toan']) ?  $information['loi-khuyen-phan-mem-ke-toan'] : '' }}</li>
                                            @else
                                                <li> {{ !empty($software_give) ? $software_give : '' }}</li>
                                            @endif
                                            @if(empty($lang_name))
                                                <li>{{ !empty($information['loi-khuyen-trinh-do-ngoai-ngu']) ?  $information['loi-khuyen-trinh-do-ngoai-ngu'] : '' }}</li>
                                            @else
                                                <li> {{ !empty($lang_give) ? $lang_give : '' }}</li>
                                            @endif
                                            @if(empty($soft_name))
                                                <li>{{ !empty($information['loi-khuyen-ky-nang-mem']) ?  $information['loi-khuyen-ky-nang-mem'] : '' }}</li>
                                            @else
                                                <li> {{ !empty($soft_give) ? $soft_give : '' }}</li>
                                            @endif
                                            @if(empty($com_name))
                                                <li>{{ !empty($information['loi-khuyen-cam-ket-gan-bo-voi-cong-ty']) ?  $information['loi-khuyen-cam-ket-gan-bo-voi-cong-ty'] : '' }}</li>
                                            @else
                                                <li> {{ !empty($com_give) ? $com_give : '' }}</li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="res_share_fb">
                                        <div id="fb-root"></div>
                                        <script async defer crossorigin="anonymous"
                                                src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0">
                                        </script>
                                        <div class="fb-share-button"
                                             data-href="{{ route('total_get_all_coe',['career_category_slug'=>$career_category_slug,'coe_id'=>$coe->coe_id ]) }}"
                                             data-layout="button" data-size="large">
                                            <a target="_blank"
                                               href="https://www.facebook.com/sharer/sharer.php?u={{ route('total_get_all_coe',['career_category_slug'=>$career_category_slug,'coe_id'=>$coe->coe_id ]) }}&amp;src=sdkpreparse"
                                               class="fb-xfbml-parse-ignore js_add_employee_money share_facebook">
                                                <i class="fas fa-dollar-sign"></i> Chia sẻ lên facebook
                                            </a>
                                        </div>

                                        <div class="zalo-share-button"
                                             data-href="{{ route('total_get_all_coe',['career_category_slug'=>$career_category_slug,'coe_id'=>$coe->coe_id ]) }}"
                                             data-oaid="579745863508352884" data-layout="3" data-color="blue"
                                             data-customize="false" style="height: 40px;
    vertical-align: top;">
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <section class="courses ">
        <div id="" class="course_list_course container-fluid container_xl container_xxl style_tab_course">
            <div class="res_title_info">
                <p class="fw6 f18">Các khóa học gợi ý</p>
            </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                       aria-controls="home" aria-selected="true">Tất cả</a>
                </li>
                @if(!empty($course_categorise))
                    @foreach($course_categorise as $cou_cate)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-toggle="tab"
                               href="#{{$cou_cate['category_course_slug']}}" role="tab" aria-controls="profile"
                               aria-selected="false">{{$cou_cate['category_course_title']}}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
            <div class="tab-content" id="myTabContent">
                @if(!empty($list_course))
                    <?php
                    $id = 0;
                    ?>
                    @foreach($list_course as $cat_slug => $cous)
                        <div class="tab-pane fade show @if($id == 0) active @endif" @if($id == 0) id="home"
                             @else id="{{$cat_slug}}" @endif
                             role="tabpanel" aria-labelledby="home-tab">
                            <?php
                            $id = 1;
                            ?>
                            <div class="row mx-auto ">
                                @if(empty($cous))
                                    <div class="col-12  col-md-6 col-lg-3 my-3 d-flex flex-column justify-content-center ">
                                        <h1>Khóa học</h1>
                                        <p class="text-secondary">Hãy cùng hơn 100,000 học viên lựa chọn khóa học tốt
                                            nhất tại
                                            Sanketoan.vn
                                        </p>
                                    </div>
                                @else
                                    @foreach($cous as $cou)
                                        @include('site.course_site.item_course',['course' =>$cou])
                                    @endforeach
                                @endif
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <a href="{{ route('course_categoryCourse',['category_slug'=>$cat_slug]) }}"
                                   class="mx-auto btn-viewmore cust_link">Xem Thêm</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>


    <section class="list_job_home_new">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-md-12 title_new_home">
                    <h3><p>Việc làm phù hợp với bạn</p></h3>
                    <a href="{{route('list_job_face')}}">Xem tất cả</a>
                </div>
            </div>
            <div class="row">
                @foreach (App\Entity\Job::showJobVipLimit_salary(12,$coe->province_id,$coe->career_category_id) as $id => $job)
                    <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                        <a href="{{ route('job_detail',['slug'=>$job->slug]) }}">
                            <div class="item_job_home_new">
                                <div class="item_new_title cutTitle">
                                    <span class=""><h4>{{ !empty($job->title) ? $job->title : '' }}</h4></span>
                                </div>
                                <div class="item_new_bussnise cutTitle">
                                    <i class="far fa-building"></i>
                                    <span>{{ !empty($job->enterprise_name) ? $job->enterprise_name : '' }}</span>
                                </div>
                                <div class="item_new_local">
                                    <i class="fas fa-map-marker-alt"></i> <span>
                                {{ !empty($job->district_name) ? $job->district_name.' - ' : '' }}
                                        {{ !empty($job->province_name) ? $job->province_name : '' }}
                            </span>
                                </div>
                                <div class="item_new_salary_dateline">
                            <span class="text-left item_new_salary">
                              <span class="icon_salary_new"><i class="fas fa-dollar-sign"></i></span>  Lương : {{ !empty($job->salary_description) ? $job->salary_description : '' }}
                            </span>
                                    <span class="text-right item_new_dateline">
                                <?php
                                        $date = date_create($job->deadline_submit_profile);
                                        ?>
                              <i class="far fa-calendar-alt"></i>  Hạn nộp :  {{ date_format($date,"d/m/Y") }}
                            </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
@section('show_js')
    <script>
        $('.item_coe_salary').matchHeight();
    </script>
@endsection
