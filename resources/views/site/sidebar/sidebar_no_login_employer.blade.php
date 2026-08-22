<?php $user = ''; ?>
<div class="col-xl-3 col-lg-4 col-md-12 dnav dsmbNone sidebar_show_hidden" id="js_toogle_sidebar">
    <div class="d-toggle">


        <div class="side-bar-left formJobLarge  sidebarJobFacebook">
            <div class="createNew text-center bgrBlueN dnavnone" style="padding: 4px 0;">
                <a href="" data-toggle="modal"
                   data-target="@if (!\Illuminate\Support\Facades\Auth::check()) #loginTiva @endif"
                   class="createNewButton white">
                    <i class="fas disInBlock fa-paper-plane"></i>
                    <p class="disInBlock font20 fontBold ">Thông tin</p>
                </a>
            </div>
            @include('site.sidebar.item_no_login_employer')
        </div>
        @include('site.sidebar.list_banner')
        {{--nếu là trang chi tiết của công việc thì show công việc facebook và ngược lại--}}
        @if(!empty($sidebar_jobs))
            <div class="sidebat_job">
                <h3 class="titleJob text-center">
                    Việc làm về du lịch chưa kiểm duyệt
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
