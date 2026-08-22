@extends('site.layout.site')
<?php
$meta_employee = \App\Entity\Config_meta::getslug('danh-sach-ung-vien');
?>
@section('type_meta', 'website')
@section('title', !empty($meta_employee->meta_title) ? $meta_employee->meta_title :'Danh sách ứng viên')
@section('meta_description', !empty($meta_employee->meta_description) ? $meta_employee->meta_description :'Danh sách ứng viên')
@section('keywords', !empty($meta_employee->meta_keywords) ? $meta_employee->meta_keywords :'Danh sách ứng viên')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : ''  )

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @if(\Illuminate\Support\Facades\Auth::check())
                    @include('site.sidebar.sidebar_job')
                @else
                    @include('site.sidebar.sidebar_no_login_employer')
                @endif


                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a class="f18 md-f14 mgb0 clorange"
                                   href="{{ route('show_employee') }}">Danh sách ứng viên</a>
                            </li>

                        </ul>
                    </div>

                    <div class="mbdsNone js_filter_job_face" id="">
                        @include('site.filter.filter_employee')
                    </div>
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                            Ứng viên nổi bật
                            {{--( {{ theo bảng thong ke so tiền }} việc làm)--}}
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                @foreach($vip_employee as $employee)
                                    @include('site.employee.item_employee_list')
                                @endforeach

                            </div>
                            <div class="row">
                                <div class="col-12 text-center">

                                    @include('site.default.item_pani',['page_link' => $vip_employee])
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                            Ứng viên mới
                            {{--( {{ theo bảng thong ke ứng viên đã làm bài thi trắc nghiệm }} việc làm)--}}
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                @foreach($employee_new as $emp_new)
                                    @include('site.employee.item_employee_list',['employee'=>$emp_new])
                                @endforeach

                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    @include('site.default.item_pani',['page_link' => $employee_new])

                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="tabfillter bgrWhite mgt20 mgb20  mbdsNone">
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="nav nav-tabs mbdsNone" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                           role="tab" aria-controls="home" aria-selected="true">Ứng viên theo ngành
                                            nghề</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile"
                                           role="tab" aria-controls="profile" aria-selected="false">Ứng viên theo tỉnh /
                                            thành phố</a>
                                    </li>
                                </ul>
                                </ul>
                                <div class="tab-content pd20" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel"
                                         aria-labelledby="home-tab">
                                        <div class="row">

                                            <?php
                                            $list_career = \App\Entity\Career::orderBy('career_category_name')->get();
                                            ?>
                                            @foreach($list_career as $career)
                                                <?php
                                                $text_link_carrer = route('search_employee') . '?career=' . $career->career_category_id;
                                                //                                                    echo $text;
                                                $total_career_employee = 0;
                                                $total_career_employee = \App\Entity\Employee::get_total_career_id($career->career_category_id);
                                                ?>
                                                @if($total_career_employee > 0)
                                                    <div class="col-lg-4 col-md-6 col-6">
                                                        <a class="linkFillter" href="{{ $text_link_carrer }}"><p
                                                                    class=" mgb10"><i
                                                                        class="fas fa-list-ul f14 mgr5"></i>{{$career->career_category_name}}
                                                                <sup class="blueN fw6">({{ $total_career_employee }}
                                                                    )</sup>
                                                            </p>
                                                        </a>
                                                    </div>
                                                @endif

                                            @endforeach
                                        </div>

                                    </div>
                                    <div class="tab-pane fade " id="profile" role="tabpanel"
                                         aria-labelledby="profile-tab">
                                        <div class="remoreBusiness">
                                            <div class="row">
                                                <?php
                                                $getAllProvince = \App\Entity\Province::GetAllProvinces();
                                                ?>
                                                @foreach($getAllProvince as $province)
                                                    <?php
                                                    $text_link_province = route('search_employee') . '?province=' . $province->province_id;
                                                    //                                                    echo $text;
                                                    $total_province_employee = 0;
                                                    $total_province_employee = \App\Entity\Employee::get_total_province($province->province_id);
                                                    ?>
                                                    @if($total_province_employee > 0)

                                                        <div class="col-lg-3 col-md-4 col-6">

                                                            <a class="linkFillter" href="{{ $text_link_province }}">
                                                                <p class=" mgb10"><i
                                                                            class="fas fa-map-marker-alt f14 mgr5"></i>{{$province->province_name}}
                                                                    <sup class="blueN fw6">({{ $total_province_employee }}
                                                                        )</sup>
                                                                </p>
                                                            </a>
                                                        </div>
                                                    @endif

                                                @endforeach


                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </section>

                    @include('site.module_index.dang-ky-tu-van')


                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>
    @include('site.mobile_bottom.fixel_bottom_list_employer')

@endsection