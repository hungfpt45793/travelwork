<?php  $public_link_employee = \App\Entity\Category::getDetailCategory('ke-toan-di-tim-viec'); ?>
<div class="dnav col-xl-3 col-lg-4 col-md-12 sidebar_job active_show_sidebar" id="js_toogle_sidebar">
    <div class="d-toggle">
        <div id="body-row" class="side-bar-left formJobLarge  sidebarJobFacebook">
            <div class="sidebar_job_title text-center clWhite bgHome">
                <p class="f20 mgb0"><i class="fas disInBlock fa-paper-plane mgr5 "></i> Thông tin</p>
            </div>
            @include('site.sidebar_site.item_info_employer')
        </div>
        @include('site.sidebar_site.list_banner')
        @if(!empty($sidebar_jobs))
            <div class="sidebat_job">
                <h3 class="titleJob text-center">
                    Việc làm du lịch chưa kiểm duyệt
                </h3>
                <?php
                $list_jobFacebook = \App\Entity\JobFacebook::sidebar_job_fb(10);
                ?>
                @foreach($list_jobFacebook as $job)
                    <div class="col-xl-12 col-lg-12 pd0 bdBottomGray bdRightGray hvbgrClick">
                        <div class="JobInteresting pd hvBoxShadow">
                            <?php $distinct = \App\Entity\District::getId($job['district']) ?>
                            <?php $province = \App\Entity\Province::getId($job['province']) ?>

                            <div class="company @if($job->vip == 1) newVip @endif">
                                <a href="{{ route('detail_job_face',['slug' => $job->slug ]) }}"
                                   class="block pd15 noDecoration CutText100">
                            <span class="textCap black maxTitleVoucher dsBlock cutTitle"> @if($job->vip == 1)
                                    <img class="lazy" src="{{ asset('assets/image/vip1.png') }}" width="40px">
                                @else
                                @endif <b style="vertical-align: bottom;" class="cutTitle">
                                    {{ isset($job['title']) ? \App\Ultility\Ultility::textLimit($job['title'], 12) : '' }}
                                </b></span>

                                    <span class="block gray itemVoucher dsBlock cutTitle"><i
                                                class="cutTitle">{{ isset($job['company_name']) ? \App\Ultility\Ultility::textLimit($job['company_name'], 20) : 'Đối tác của Travelwork' }}
                                </i></span>

                                    <span class="black">
                                <i>
                                    <span class="block"><i class="fas fa-map-marker-alt blueN "></i>
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
                                    <span class="block"><span class="black"><i class="fas fa-hand-holding-usd money"></i>
                                    Lương:
                                    @if(!empty($job->salary_description))
                                                {{$job->salary_description}}
                                                &nbsp;&nbsp;&nbsp;
                                            @else
                                                Đang cập nhật
                                            @endif
                                </span> <span class="sm-block pull-right float-right clorange date_create"><i
                                                    class="far fa-clock"></i> Ngày đăng tin: <?php

                                            $date_facebook = \App\Ultility\Ultility::getdateFacebook($job['updated_at']);
                                            echo $date_facebook;

                                            ?></span></span>

                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

