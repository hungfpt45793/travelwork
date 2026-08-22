<div class="col-xl-6 col-lg-6 item_job">
    <a href="{{ route('job_detail',['slug' => $job->slug ]) }}" class="CutText100">
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
                        <img class="chuaxathuc lazy chuaxacthucItemJob"
                             src="{{ asset('assets/image/xacthuc.jpg') }}"
                             title="Xác thực tại sanketoan.vn"
                             alt="Xác thực tại sanketoan.vn">
                    @endif
                </span>
                <?php
                $employer_id = $job['employer_id'];
                $employer = \App\Entity\Employer::getIdemployer($employer_id);
                $company_name = \App\Entity\Job_company::get_job_company_title($job->job_id);
                ?>
                <span class="block company_name @if(!empty($image) && $image = 'job') mgRight50 @endif">
                    <i class="cutTitle ">
                        {{ !empty($company_name) ? $company_name : $employer['enterprise_name'] }}
                    </i>
                </span>
                <span class="item_job_address">
                    <i>
                        <span class="block">
                            <i class="fas fa-map-marker-alt clHome "></i>
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
                <span class="item_job_salary  ">
                    <span class="pull-left float-left black">
                        <i class="fas fa-hand-holding-usd clOrange"></i>
                        Lương: @if(!empty($job->salary_description))
                            {{$job->salary_description}}
                        @else
                            Đang cập nhật
                        @endif
                    </span>
                    <span class="item_job_date pull-right float-right clOrange">
                        <i class="far fa-clock"></i>Ngày đăng tin:
                        <?php
                        $date_facebook = \App\Ultility\Ultility::getdateFacebook($job['updated_at']);
                        echo $date_facebook;
                        ?>
                    </span>
                </span>
            </div>
        </div>
    </a>
</div>