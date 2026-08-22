@extends('site.layout.site')
<?php
$meta_list_job_facebook = \App\Entity\Config_meta::getslug('viec-lam-facebook');
?>
@section('type_meta', 'website')
@section('title', isset($meta_list_job_facebook['meta_title']) ? $meta_list_job_facebook['meta_title'] : 'Danh sách tin tuyển dụng')
@section('meta_description')<?php $meta_descript = isset($meta_list_job_facebook->meta_description) ? \App\Ultility\Ultility::textLimit($meta_list_job_facebook->meta_description, 150) : 'Danh sách tin tuyển dụng'; ?>{{ $meta_descript }}
@endsection
@section('keywords', isset($meta_list_job_facebook['meta_keyword']) ? $meta_list_job_facebook['meta_keyword'] : '')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : ''  )

@section('content')


    <style>
        .d-dangkiform input,
        .d-dangkiform textarea {
            border: 2px solid #009385;
        }
    </style>
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                <div class="col-xl-12 col-lg-12 col-md-12 dcontent">
                    <div class="search_job_view_mobile">
                        {{--Jobquick là chỉnh phần facebook--}}
                        <section class="Jobquick quickSearchForJobs mgt20 bgrWhite">
                            <div class="formSearch pd0">
                                <div class="form-group">
                                    {{--detail_job_facebook--}}
                                    <form id="searchBox" class="form_search_job_mobile" action="" method="GET">
                                        <div class="content bd15white">
                                            <div class="row mg0">
                                                <div class="col-md-12">
                                                    <h5 class="fw6 f20 bdLeftBlueN5x pdl10 blueN mgb15"> Tìm kiếm việc
                                                        làm </h5>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="item_search_job_mobile">
                                                        <i class="fas fa-list-ul mgl15  lg-f12 mb_w15"></i>
                                                        <?php $career_get = isset($_GET['career']) ? $_GET['career'] : '';?>
                                                        <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"  name="career">
                                                            <option value="0" selected>Tất cả ngành nghề</option>
                                                            @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                                                <option value="{{$career->career_category_id}}"
                                                                        @if($career->career_category_id == $career_get) selected @endif>{{$career->career_category_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="item_search_job_mobile">
                                                        <i class="fas fa-map-marker-alt mgl15  lg-f12 mb_w15"></i>
                                                        <?php $province_get = isset($_GET['province']) ? $_GET['province'] : '';?>
                                                        <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                                                name="province" aria-label="Tỉnh/Thành phố" id="city">
                                                            <option value="0" selected> Tất cả tỉnh/thành phố</option>
                                                            <?php
                                                            $getAllProvince = \App\Entity\Province::GetAllProvinces();
                                                            ?>
                                                            @foreach($getAllProvince as $province)
                                                                <option @if($province->province_id == $province_get) selected
                                                                        @endif value="{{$province->province_id}}">{{$province->province_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="item_search_job_mobile">
                                                        <i class="fas fa-map-marker-alt mgl15  lg-f12 mb_w15"></i>
                                                        <?php $district_get = isset($_GET['district']) ? $_GET['district'] : '';?>
                                                        <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                                                name="district" aria-label="Quận/Huyện" id="county">
                                                            <option value="0" selected> Tất cả quận/huyện</option>
                                                            <?php
                                                            $districts = '';
                                                            if (!empty($province_get)) {
                                                                $districts = \App\Entity\District::get_province_id($province_get);
                                                            } else {
                                                                $districts = \App\Entity\District::getAllDistrict();
                                                            }
                                                            ?>
                                                            @foreach( $districts as $district)
                                                                <option @if($district->district_id == $district_get) selected
                                                                        @endif value="{{ $district->district_id }}">{{$district->district_name}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="item_search_job_mobile">
                                                        <i class="fas fa-hand-holding-usd money mgl15  lg-f12 mb_w15"></i>
                                                        <?php $salary_get = isset($_GET['salary']) ? $_GET['salary'] : '';?>
                                                        <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                                                name="salary">
                                                            <option value="0" selected>Mức lương</option>
                                                            @foreach(\App\Entity\Salary::showAllSalary() as $salary)
                                                                <option @if($salary->salary_id == $salary_get) selected
                                                                        @endif  value="{{$salary->salary_id}}">{{$salary->description}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="item_search_job_mobile">
                                                        <i class="fas fa-certificate money mgl15  lg-f12 mb_w15"></i>

                                                        <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                                                name="vip">
                                                            <?php
                                                            $vip_get = isset($_GET['vip']) ? $_GET['vip'] : '';
                                                            ?>
                                                            <option value="" @if($vip_get == '') selected @endif>Tất cả
                                                                tin
                                                            </option>
                                                            <option @if($vip_get == '0') selected @endif  value="0">Tin
                                                                thường
                                                            </option>
                                                            <option @if($vip_get == '1') selected
                                                                    @endif  value="1">Tin vip
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="item_search_job_mobile">
                                                        <?php $word_get = isset($_GET['word']) ? $_GET['word'] : '';?>
                                                        <input class="width85 h35x noBorder w100 pd15" type="text"
                                                               name="word"
                                                               placeholder="Nhập tiêu đề công việc..."
                                                               value="{{ $word_get }}">
                                                    </div>
                                                    <div class="item_search_job_mobile">
                                                        <button class="col-lg-2 text-center mg block bgrBlueN pd6 cursor whiteIm noBorder"
                                                                type="submit"><i class="fas fa-search mgr5"></i> Tìm
                                                            kiếm
                                                        </button>
                                                    </div>

                                                </div>


                                            </div>


                                        </div>
                                    </form>
                                </div>

                            </div>
                            <!--    --><?php //$province_get = isset($_GET['province']) ? $_GET['province'] : 0;?>


                            <script>
                                // chon thanh pho ra quan huyen
                                $('#city').change(function () {
                                    var city = $(this).val();
                                    $.get('/tim-kiem-huyen/' + city , function (data) {
                                        $('#county').html('');
                                        $('#county').html(data);
                                    });
                                });
                            </script>

                        </section>


                    </div>
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>
                    @if(!empty($list_jobs))
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14">
                            <h1 class="titleJobs  fw6 f20 mgb0 col-f14">
                                Việc làm du lịch đã kiểm duyệt
                            </h1>


                        </div>

                            <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                                <div class="row">

                                    @foreach($list_jobs as $job)
                                        @include('site.jobs.item_job')
                                    @endforeach
                                </div>
                            </div>

                    </section>

                        <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                            <div class="row">
                                <div class="col-12 text-center">
                                    @include('site.default.item_pani',['page_link' => $list_jobs])
                                </div>
                            </div>
                        </section>
                    @endif

                    @if(!empty($list_job_fb))
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14">
                            <h2 class="titleJobs  fw6 f20 mgb0 col-f14">
                                Việc làm du lịch chưa kiểm duyệt
                            </h2>
                        </div>

                            <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                                <div class="row">
                                    @foreach ($list_job_fb as $jobFacebook)
                                        @include('site.job_facebook.item_job_facebook')
                                    @endforeach
                                </div>
                            </div>

                    </section>


                        <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                            <div class="row">
                                <div class="col-12 text-center">
                                    @include('site.default.item_pani',['page_link' => $list_job_fb])
                                </div>
                            </div>
                        </section>
                    @endif



                    @include('site.module_index.dang-ky-tu-van')

                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>
    @include('site.mobile_bottom.fixel_bottom_category_job')
@endsection
