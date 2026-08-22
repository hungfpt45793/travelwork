<?php  $public_link_employee = \App\Entity\Category::getDetailCategory('ke-toan-di-tim-viec'); ?>
<div class="dnav col-xl-3 col-lg-4 col-md-12 sidebar_job active_show_sidebar" id="js_toogle_sidebar">
    <div class="d-toggle">
        <div id="body-row" class="side-bar-left formJobLarge  sidebarJobFacebook">
            <div class="sidebar_job_title text-center clWhite bgHome">
                <p class="f20 mgb0"><i class="fas disInBlock fa-paper-plane mgr5 "></i> Thông tin</p>
            </div>
            @include('site.sidebar_site.item_info')
        </div>
        @include('site.sidebar_site.list_banner')
        @if(!empty($sidebar_jobs))
            <div class="sidebat_job">
                <h3 class="titleJob text-center">
                    Việc làm du lịch mới
                </h3>
                <?php
                $list_jobFacebook = \App\Entity\JobFacebook::sidebar_job_fb(10);
                ?>
                @foreach($list_jobFacebook as $job)
                    <div class="col-xl-12 item_job">
                        <a href="{{ route('detail_job_face', ['slug' => $job->slug]) }}" class="CutText100">
                            <div class="content_item_job">
                                <?php $distinct = \App\Entity\District::getId($job['district']) ?>
                                <?php $province = \App\Entity\Province::getId($job['province']) ?>
                                <div class="company @if($job->vip == 1) newVip @endif">
                                    <span class="@if(!empty($image) && $image = 'job') mgRight50 @endif">
                                         @if($job->vip == 1)
                                         <img class="lazy" src="{{ asset('assets/image/vip1.png') }}" width="40px">
                                         @else
                                         @endif
                                    <span class="cutTitle item_job_title" style="display: inherit !important;">
                                        {{ isset($job['title']) ? \App\Ultility\Ultility::textLimit($job['title'], 15) : '' }}
                                    </span>
                                     @if(!empty($image) && $image = 'job')
                                         <img class="chuaxathuc lazy chuaxacthucItemJob" src="{{ asset('assets/image/xacthuc.jpg') }}"
                                              title="Xác thực tại sanketoan.vn" alt="Xác thực tại sanketoan.vn">
                                     @endif
                                    </span>
                                    <span class="block company_name"><i class="cutTitle ">
                                            {{ isset($job['company_name']) ? \App\Ultility\Ultility::textLimit($job['company_name'], 15) : 'Đối tác của Travelwork' }}
                                        </i>
                                    </span>
                                    <span class="item_job_address">
                                        <i>
                                            <span class="block"><i class="fas fa-map-marker-alt clHome "></i>
                                                @if(isset($distinct->district_name))
                                                    {{ $distinct->district_name }}
                                                @endif
                                                @if(!empty($distinct->district_name))
                                                    -
                                                @endif
                                                @if(isset($province->province_name))
                                                    {{ $province->province_name }}
                                                @endif
                                            </span>
                                       </i>
                                    </span>
                                    <span class="item_job_salary"><i class="fas fa-hand-holding-usd clOrange"></i>
                                     Lương:
                                        @if(!empty($job->salary_description))
                                            {{$job->salary_description}}
                                        @else
                                            Đang cập nhật
                                        @endif
                                     </span>
                                     <span class="item_job_date pull-right float-right clOrange">
                                         <i class="far fa-clock"></i> Ngày đăng tin:
                                         <?php
                                         $date_facebook = \App\Ultility\Ultility::getdateFacebook($job['updated_at']);
                                         echo $date_facebook;
                                         ?>
                                     </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        @if(!empty($sidebar_job_fb))
            <div class="sidebat_job">
                <h3 class="titleJob text-center">
                    Việc làm du lịch đã kiểm duyệt
                </h3>
                <?php
                $list_jobFacebook = \App\Entity\Job::sidebar_job(10);
                ?>
                @foreach($list_jobFacebook as $job)
                    <div class="col-xl-12 item_job">
                        <a href="{{ route('job_detail', ['slug' => $job->slug]) }}" class="CutText100">
                            <div class="content_item_job">
                                <?php $distinct = \App\Entity\District::getId($job['district']) ?>
                                <?php $province = \App\Entity\Province::getId($job['province']) ?>
                                <div class="company @if($job->vip == 1) newVip @endif">
                                    <span class="@if(!empty($image) && $image = 'job') mgRight50 @endif">
                                     @if($job->vip == 1)
                                         <img class="lazy" src="{{ asset('assets/image/vip1.png') }}" width="40px">
                                     @else
                                     @endif
                                     <span class="cutTitle item_job_title" style="display: inherit !important;">
                                        {{ isset($job['title']) ? \App\Ultility\Ultility::textLimit($job['title'], 15) : '' }}
                                     </span>
                                     @if(!empty($image) && $image = 'job')
                                         <img class="chuaxathuc lazy chuaxacthucItemJob" src="{{ asset('assets/image/xacthuc.jpg') }}"
                                              title="Xác thực tại sanketoan.vn" alt="Xác thực tại sanketoan.vn">
                                     @endif
                                    </span>
                                    <?php
                                    $employer_id = $job->employer_id;
                                    $employer = \App\Entity\Employer::getIdemployer($employer_id);
                                    $company_name = \App\Entity\Job_company::get_job_company_title($job->job_id);
                                    ?>
                                    <span class="block company_name">
                                        <i class="cutTitle ">
                                            {{ !empty($company_name) ? \App\Ultility\Ultility::textLimit($company_name) : \App\Ultility\Ultility::textLimit($employer['enterprise_name']) }}
                                        </i>
                                    </span>
                                    <span class="item_job_address">
                                         <i>
                                            <span class="block"><i class="fas fa-map-marker-alt clHome "></i>
                                                @if(isset($distinct->district_name))
                                                    {{ $distinct->district_name }}
                                                @endif
                                                @if(!empty($distinct->district_name))
                                                    -
                                                @endif
                                                @if(isset($province->province_name))
                                                    {{ $province->province_name }}
                                                @endif
                                            </span>
                                        </i>
                                    </span>

                                    <span class="item_job_salary">
                                        <i class="fas fa-hand-holding-usd clOrange"></i>
                                        Lương:
                                        @if(!empty($job->salary_description))
                                            {{$job->salary_description}}
                                        @else
                                            Đang cập nhật
                                        @endif
                                    </span>
                                    <span class="item_job_date pull-right float-right clOrange">
                                        <i class="far fa-clock"></i> Ngày đăng :
                                        <?php
                                        $date_facebook = \App\Ultility\Ultility::getdateFacebook($job['updated_at']);
                                        echo $date_facebook;
                                        ?>
                                    </span>

                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

