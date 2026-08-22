<section class="tab_filter">
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs mbdsNone" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                       role="tab" aria-controls="home" aria-selected="true">Việc làm theo ngành
                        nghề</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile"
                       role="tab" aria-controls="profile" aria-selected="false">Việc làm theo tỉnh /
                        thành phố</a>
                </li>
            </ul>
            <ul class="nav nav-tabs dsNone mbdsBlock" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                       role="tab" aria-controls="home" aria-selected="true">Việc làm theo ngành
                        nghề</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile"
                       role="tab" aria-controls="profile" aria-selected="false">Việc làm theo tỉnh /
                        thành phố</a>
                </li>
            </ul>
            <div class="tab-content pd20" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel"
                     aria-labelledby="home-tab">
                    <div class="row">
                        <?php
                        $list_career = \App\Entity\Career::orderBy('career_category_name')->get();
                        ?>
                        @foreach($list_career as $career)
                            <?php
                            $text_link = route('seacrh_job_facebook', ['slug' => 'tuyen-' . $career->career_category_slug . '?c=' . $career->career_category_id]);
                            ?>
                            <div class="col-lg-4 col-md-6 col-6">
                                <a class="linkFillter" href="{{ $text_link }}"><p
                                            class=" mgb10"><i
                                                class="fas fa-list-ul f14 mgr5"></i>{{$career->career_category_name}}
                                    </p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade " id="profile" role="tabpanel"
                     aria-labelledby="profile-tab">
                    <div class="remoreBusiness">
                        <div class="row">
                            <?php
                            $getAllProvince = \App\Entity\Province::GetAllProvinces();
                            ?>
                            @foreach($getAllProvince as $province)
                                <?php
                                $text_link = route('seacrh_job_facebook', ['slug' => 'tuyen-' . $province->province_slug . '?p=' . $province->province_id]);
                                ?>
                                <div class="col-lg-3 col-md-4 col-6">

                                    <a class="linkFillter" href="{{ $text_link }}">
                                        <p class=" mgb10"><i
                                                    class="fas fa-map-marker-alt f14 mgr5"></i>{{$province->province_name}}

                                        </p>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
