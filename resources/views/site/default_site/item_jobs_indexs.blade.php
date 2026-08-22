<section class="quickSearchForJobs js_quickSearchForJobs bgrWhite pdt20 mbdsNone">
    <div class="formSearch pd0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="form_search_home">
                        <span class="clWhite dsNone mbdsBlock js_hidden_search" aria-hidden="true">×</span>
                        <p>{{ isset($information['tieu-de-tim-cong-viec']) ?  $information['tieu-de-tim-cong-viec'] : 'Travelwork  tự hào làm cầu nối cho hơn 15 triệu lượt tuyển dụng và tìm việc thành công' }}</p>
                        <form id="searchBox" action="{{ route('submit_search_jobfb') }}" method="GET">
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="search_input"><i class="fas fa-list-ul mgl15  lg-f12 mb_w15"></i><select
                                                class="select2_w90"
                                                name="career">
                                            <option value="0" selected>Tất cả ngành nghề</option>
                                            @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                                <option value="{{$career->career_category_slug}}">{{$career->career_category_name}}</option>
                                            @endforeach
                                        </select></div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="search_input">
                                        <i class="fas fa-map-marker-alt mgl15  lg-f12 mb_w15"></i>
                                        <select class="select2_w90"
                                                name="province" aria-label="Tỉnh/Thành phố" id="city_slug">
                                            <option value="0" selected> Tất cả tỉnh/thành phố</option>
                                            <?php
                                            $getAllProvince = \App\Entity\Province::GetAllProvinces();
                                            ?>
                                            @foreach($getAllProvince as $province)
                                                <i class="fas fa-map-marker-alt mgl15  lg-f12 mb_w15"></i>
                                                <option value="{{$province->province_slug}}">{{$province->province_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 ">
                                    <div class="search_input"><i class="fas fa-map-marker-alt mgl15  lg-f12 mb_w15"></i>
                                        <select class="select2_w90"
                                                name="district" aria-label="Quận/Huyện" id="county">
                                            <option value="0" selected> Tất cả quận/huyện</option>
                                        </select></div>
                                </div>
                                <div class="col-lg-3 col-md-6 pdl0 custom_col_button">
                                    <div class="search_button">
                                        <button class="" type="submit"><i class="fas fa-search"></i> Tìm việc ngay
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


    </div>
    <!--    --><?php //$province_get = isset($_GET['province']) ? $_GET['province'] : 0;?>

</section>

<section class="attractiveJobs">
    <div class="infoAttractiveJobs">
        <div class="row">
            <?php
                $isMobile = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
                |fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
                , $_SERVER["HTTP_USER_AGENT"]);
                if($isMobile == 1){
                    $limit_job = 8;
                }
                else{
                    $limit_job = 9;
                }
            ?>
            @foreach (App\Entity\Job::showJobVipLimit($limit_job) as $id => $job)
                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 item_job_home">
                    <a href=" {{ route('job_detail',['slug'=>$job->slug]) }}"
                       class=" hvBlueDN textCap fw6 blueDN noDecoration">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="f18 cutTitle">{{$job->title}}</h3>
                                <p class="item_job_enterprise_name fw6 cutTitle">{{$job->enterprise_name}}</p>
                            </div>

                            <div class="col-lg-12">
                                <p class="CutTextW300 item_job_address"><i
                                            class="fas fa-map-marker-alt address"></i>

                                    @if(isset($job->district_name))
                                        {{ $job->district_name }}
                                    @endif
                                    @if(!empty($job->district_name))
                                        -
                                    @endif
                                    @if(isset($job->province_name))
                                        {{ $job->province_name }}
                                    @endif
                                </p>
                            </div>
                            <div class="col-lg-12">
                                <p><span class="item_job_salary">
                                        <i class="fas fa-hand-holding-usd money"></i>
                                        <span class="mbdsNone">   Lương: </span>
                                        {{$job->salary_description}}
                                    </span>
                                    <?php
                                    $date = date_create($job->deadline_submit_profile);
                                    ?>
                                    <span class="item_job_date">
                                        <i class="fas fa-calendar-times clorange"></i>
                                        <span class="mbdsNone">  Hạn nộp: </span>
                                        {{ date_format($date,"d/m/Y") }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

            <div class="col-12 text-center pd10">
                {{--<a class="f18" href="{{route('list_cate_job')}}"><i class="fas fa-arrow-right"></i> 5.000 + việc làm khác</a>--}}
                <a class="f18" href="{{route('list_job_face')}}"><i class="fas fa-arrow-right"></i> 1.000 + việc làm
                    khác</a>
            </div>


        </div>
    </div>
</section>
<div class="underLineY h10x bgrGray"></div>
