<div class="col-lg-3 col-md-12 siderbar_new active_show_sidebar" id="js_toogle_sidebar">
    <div class="UvNew bgrWhite">
        <div class="title_box_sidebar">
            Tin tuyển dụng từ Facebook
        </div>
        <div class="contentsUvNew bdLightGray">

            <?php $listJobFacebook = \App\Entity\JobFacebook::getAllFacebook(7); ?>
            @foreach ($listJobFacebook as $jobFacebook)
                <a href="{{ route('detail_job_face', ['slug' => $jobFacebook->slug]) }}"
                   class="NoDecoration job_post_sidebar">
                    <div class="item_job_post">
                        <p class="title_job_post">{{ isset($jobFacebook->title) ? \App\Ultility\Ultility::textLimit($jobFacebook->title, 6) : '' }}</p>
                        <?php
                        $salary = \App\Entity\Salary::getIdSalary($jobFacebook->salary_id)
                        ?>
                        <p class="mgb5 salary_black"><i
                                    class="fas fa-coins money clOrange"></i> {{ isset($salary->description) ?$salary->description : '' }}
                            &nbsp; &nbsp;</p>
                        <?php $distinct = \App\Entity\District::getId($jobFacebook['district']) ?>
                        <?php $province = \App\Entity\Province::getId($jobFacebook['province']) ?>
                        <p class="mgb5"><i
                                    class="fas fa-map-marker-alt address"></i> @if(isset($distinct->district_name))
                                {{ $distinct->district_name }} -
                            @endif
                            @if(isset($province->province_name))
                                {{ $province->province_name }}
                            @endif</p>
                    </div>
                </a>
            @endforeach
            <a href="{{ route('list_job_face') }}" class="link_show_sidebar">Xem thêm</a>
        </div>
    </div>
    <div class="UvNew bgrWhite mgt25">
        <div class="title_box_sidebar">
            Tin tuyển dụng từ NTD
        </div>
        <div class="contentsUvNew bdLightGray">

            <?php $listJob = \App\Entity\Job::getAllJob(7); ?>
            @foreach ($listJob as $job)
                <a href="{{ route('job_detail',['slug' => $job->slug ]) }}" class="NoDecoration job_post_sidebar">
                    <div class="item_job_post">
                        <p class="title_job_post">{{ isset($job->title) ? \App\Ultility\Ultility::textLimit($job->title, 6) : '' }}</p>
                        <?php
                        $salary_job = \App\Entity\Salary::getIdSalary($job->salary_id)
                        ?>
                        <p class="mgb5 black"><i
                                    class="fas fa-coins money clOrange"></i> {{ isset($salary_job->description) ? $salary_job->description : '' }}
                            &nbsp; &nbsp;</p>
                        <?php $distinct_job = \App\Entity\District::getId($job['district']) ?>
                        <?php $province_job = \App\Entity\Province::getId($job['province']) ?>
                        <p class="mgb5"><i
                                    class="fas fa-map-marker-alt address"></i> @if(isset($distinct_job->district_name))
                                {{ $distinct_job->district_name }} -
                            @endif
                            @if(isset($province_job->province_name))
                                {{ $province_job->province_name }}
                            @endif</p>
                    </div>
                </a>
            @endforeach
            <a href="{{ route('list_job_face') }}" class="link_show_sidebar">Xem thêm</a>

        </div>

    </div>
</div>