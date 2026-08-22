<div class="col-xl-6 col-lg-6 pd0 bdBottomGray bdRightGray hvbgrClick">
    <div class="JobInteresting pd hvBoxShadow">

        <?php $distinct = \App\Entity\District::getId($job['district']) ?>
        <?php $province = \App\Entity\Province::getId($job['province']) ?>

        <div class="company @if($job->vip == 1) newVip @endif">
            <a href="{{ route('job_detail',['slug' => $job->slug ]) }}" class="block pd15 noDecoration CutText100">
         <span class="textCap black maxTitleVoucher dsBlock   @if(!empty($image) && $image = 'job') mgRight50 @endif" style="display: inherit !important;"> @if($job->vip == 1)
                 <img class="lazy" src="{{ asset('assets/image/vip1.png') }}" width="40px">
             @else
             @endif <b style="vertical-align: bottom;display: inherit !important;" class="cutTitle">
         {{ isset($job['title']) ? \App\Ultility\Ultility::textLimit($job['title'], 15) : '' }}
         </b>
             @if(!empty($image) && $image = 'job')
         <img class="chuaxathuc lazy chuaxacthucItemJob" src="{{ asset('assets/image/xacthuc.jpg') }}"
              title="Xác thực tại sanketoan.vn" alt="Xác thực tại sanketoan.vn">
                 @endif
         </span>




                <?php
                $employer_id = $job['employer_id'];
                $employer = \App\Entity\Employer::getIdemployer($employer_id);

                ?>
                <span class="block gray itemVoucher dsBlock @if(!empty($image) && $image = 'job') mgRight50 @endif"><i class="cutTitle ">{{ isset($employer['enterprise_name']) ? \App\Ultility\Ultility::textLimit($employer['enterprise_name'], 15) : '' }}
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
         </span> <span class="sm-block pull-right float-right clorange"><i
                                class="far fa-clock"></i> Ngày đăng tin: <?php

                        $date_facebook = \App\Ultility\Ultility::getdateFacebook($job['updated_at']);
                        echo $date_facebook;


                        ?></span></span>

            </a>
        </div>
    </div>
</div>