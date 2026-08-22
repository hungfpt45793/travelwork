<section class="list_job_home_new" style="margin-top: 30px;">
    <div class="container container_w_1200">
        <div class="row">
            <div class="col-md-12 title_new_home">
                <h3><p>Việc làm du lịch mới</p></h3>
                <a href="{{route('list_job_face')}}">Xem tất cả</a>
            </div>
        </div>
        <div class="row">

            @foreach (App\Entity\Job::showJobVip2Home(12) as $id => $job)
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <a href="{{ route('job_detail',['slug'=>$job->slug]) }}">
                        <div class="item_job_home_new">
                            <div class="item_new_title cutTitle">
                                <span class=""><h4>{{ !empty($job->title) ? $job->title : '' }}</h4></span>
                            </div>
                            <div class="item_new_bussnise cutTitle">
                                <i class="far fa-building"></i> <span>{{ !empty($job->enterprise_name) ? $job->enterprise_name : '' }}</span>
                            </div>
                            <div class="item_new_local">
                                <i class="fas fa-map-marker-alt"></i> <span>
                                {{ !empty($job->district_name) ? $job->district_name.' - ' : '' }}
                                    {{ !empty($job->province_name) ? $job->province_name : '' }}
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
            @endforeach


        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="{{ route('list_job_face') }}" class="get_all_job_kt">Xem tất cả việc làm du lịch</a>
            </div>
        </div>

    </div>
</section>
