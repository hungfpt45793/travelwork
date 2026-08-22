<div class="col-xl-6 col-lg-6 pd0 bdBottomGray bdRightGray hvbgrClick">
    <div class="JobInteresting pd hvBoxShadow ">
        <?php $distinct = \App\Entity\District::getId($jobFacebook['district']) ?>
        <?php $province = \App\Entity\Province::getId($jobFacebook['province']) ?>



        <div class="company @if($jobFacebook->vip == 1) newVip @endif">
            <a href="{{ route('detail_job_face', ['slug' => $jobFacebook->slug]) }}"
               class="block pd15 noDecoration CutText100">

                 <span class="textCap black maxTitleVoucher dsBlock @if(!empty($image) && $image = 'job_fb') mgRight50 @endif"> @if($jobFacebook->vip == 1)
                         <img class='lazy' src="{{ asset('assets/image/vip1.png') }}" width="40px">
                     @else
                     @endif <b style="vertical-align: bottom;" class="cutTitle">
         {{ isset($jobFacebook->title) ? \App\Ultility\Ultility::textLimit($jobFacebook->title, 15) : '' }}
         </b></span>
                @if(!empty($image) && $image = 'job_fb')
                    @if($jobFacebook->vip == 1)
                        <img class="chuaxathuc lazy chuaxacthucItemJob" src="{{ asset('assets/image/xacthuc.jpg') }}"
                             title="{{ $jobFacebook->title }}" alt="{{ $jobFacebook->title }}">
                    @else
                        <img class="chuaxathuc lazy chuaxacthucItemJob"
                             src="{{ asset('assets/image/chuaxacthuc.png') }}"
                             title="{{ $jobFacebook->title }}" alt="{{ $jobFacebook->title }}">
                    @endif
                @endif


                <span class="block gray itemVoucher dsBlock @if(!empty($image) && $image = 'job_fb') mgRight50 @endif"><i class="cutTitle ">
                        {{ isset($jobFacebook['company_name']) ? \App\Ultility\Ultility::textLimit($jobFacebook['company_name'], 15) : 'Đối tác của Travelwork' }}
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
                <span class="black">
         <i class="fas fa-hand-holding-usd money"></i>
         Lương: {{ $jobFacebook->salary_description }}&nbsp;
         </span>
                <span class="text-right clorange fright">
                    <i class="far fa-clock"></i>
                    Ngày đăng tin:  <?php

                    $date_facebook = \App\Ultility\Ultility::getdateFacebook($jobFacebook['updated_at']);
                    echo $date_facebook;

                    ?>
                </span>
            </a>
        </div>
    </div>
</div>
