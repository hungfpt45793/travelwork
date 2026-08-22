<div class="col-xl-6 col-lg-6 col-md-6 col-12">
    <a href="{{ route('job_detail',['slug'=>$job->slug]) }}">
        <?php $distinct = \App\Entity\District::getId($job['district']) ?>
        <?php $province = \App\Entity\Province::getId($job['province']) ?>
        <div class="item_job_home_new">
            <div class="item_new_title cutTitle">
                <span class=""><h4> {{ isset($job['title']) ? \App\Ultility\Ultility::textLimit($job['title'], 15) : '' }}</h4></span>
            </div>
            <?php
            $employer_id = $job['employer_id'];
            $employer = \App\Entity\Employer::getIdemployer($employer_id);
            $company_name = \App\Entity\Job_company::get_job_company_title($job->job_id);
            ?>
            <div class="item_new_bussnise cutTitle">
                <i class="far fa-building"></i> <span>{{ !empty($company_name) ? $company_name : $employer['enterprise_name'] }}</span>
            </div>

            <div class="item_new_local">
                <i class="fas fa-map-marker-alt"></i> <span>
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
            </div>
            <div class="item_new_salary_dateline">
                            <span class="text-left item_new_salary">
                              <span class="icon_salary_new"><i class="fas fa-dollar-sign"></i></span>  Lương : {{ !empty($job->salary_description) ? $job->salary_description : '' }}
                            </span>
                <span class="text-right item_new_dateline">
                    <i class="far fa-clock"></i> <span class="dsmbNonedate">Ngày đăng tin  :</span>
                                        <?php
                    $date_facebook = \App\Ultility\Ultility::getdateFacebook($job['updated_at']);
                    echo $date_facebook;
                    ?>
                            </span>
            </div>
        </div>
    </a>
</div>