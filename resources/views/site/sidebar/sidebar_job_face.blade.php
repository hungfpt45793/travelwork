<?php $user = ''; ?>
@if (\Illuminate\Support\Facades\Auth::check())
    <?php $user = \Illuminate\Support\Facades\Auth::user(); ?>
@endif

<div class="dnav col-xl-3 col-lg-4 col-md-12 dsmbNone sidebar_show_hidden hidden_mb_curriculum" id="js_toogle_sidebar">

    <div class="d-toggle">

        <div id="body-row" class="side-bar-left formJobLarge  sidebarJobFacebook">
            <div class="createNew text-center bgrBlueN dnavnone" style="padding: 4px 0;">
                <a href="" data-toggle="modal"
                   data-target="@if (!\Illuminate\Support\Facades\Auth::check()) #loginTiva @endif"
                   class="createNewButton white">
                    <i class="fas disInBlock fa-paper-plane "></i>
                    <p class="disInBlock font20 fontBold ">Thông tin</p>
                </a>
            </div>
            @include('site.sidebar.item_info')
        </div>
        @include('site.sidebar.list_banner')

        @if(!empty($sidebar_job_fb))
            <div class="sidebat_job dnavnone">
                <h3 class="titleJob text-center">
                    Việc làm du lịch đã kiểm duyệt
                </h3>
                <?php
                $list_jobs = \App\Entity\Job::sidebar_job(10);
                ?>
                @foreach($list_jobs as $job)
                    <div class="col-xl-12 col-lg-12 pd0 bdBottomGray bdRightGray hvbgrClick">
                        <div class="JobInteresting pd hvBoxShadow">

                            <?php $distinct = \App\Entity\District::getId($job['district']) ?>
                            <?php $province = \App\Entity\Province::getId($job['province']) ?>

                            <div class="company @if($job->vip == 1) newVip @endif">
                                <a href="{{ route('job_detail',['slug' => $job->slug ]) }}"
                                   class="block pd15 noDecoration CutText100">
                            <span class="textCap black maxTitleVoucher dsBlock cutTitle"> @if($job->vip == 1)
                                    <img class="lazy" src="{{ asset('assets/image/vip1.png') }}" width="40px">
                                @else
                                @endif <b style="vertical-align: bottom;" class="cutTitle">
                                    {{ isset($job['title']) ? \App\Ultility\Ultility::textLimit($job['title'], 12) : '' }}
                                </b></span>
                                    <?php
                                    $employer_id = $job['employer_id'];
                                    $employer = \App\Entity\Employer::getIdemployer($employer_id);

                                    ?>
                                    <span class="block gray itemVoucher dsBlock cutTitle"><i
                                                class="cutTitle">{{ isset($employer['enterprise_name']) ? \App\Ultility\Ultility::textLimit($employer['enterprise_name'], 20) : '' }}
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
                                    <span class="block"><span class="black"><i
                                                    class="fas fa-hand-holding-usd money"></i>
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


{{-- <script>
    // $('#body-row').hide();

    $('#collapse-icon').addClass('fa-angle-double-left');
    $('[data-toggle=sidebar-colapse]').click(function() {
        $('#collapse-icon').toggleClass('fa-angle-double-left fa-angle-double-right')
        $('.menu-collapsed').toggleClass('d-none');
        $('.menu-collaps').toggleClass('d-none');
        // $('.dcontent').removeClass('col-xl-9 col-lg-8 col-md-12')

        $('.dnavnone').toggleClass("d-none");

        $('.dnav').toggleClass("col-xl-3 col-lg-4 col-md-12");
        $('.dnav').toggleClass("col-xl-1 col-lg-1 col-md-12 width-collapse");
        $('.dcontent').toggleClass('col-xl-9 col-lg-8 col-md-12')
        $('.dcontent').toggleClass('col-xl-11 col-lg-11 col-md-12')
    });





    $('[data-toggle="tooltip"]').tooltip();

</script> --}}
