<section class="tab_filter">
    <div class="row">

        <div class="col-lg-12">

            <ul class="nav nav-tabs mbdsNone" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                       role="tab" aria-controls="home" aria-selected="true">Ứng viên theo ngành
                        nghề</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile"
                       role="tab" aria-controls="profile" aria-selected="false">Ứng viên theo tỉnh /
                        thành phố</a>
                </li>


            </ul>
            <ul class="nav nav-tabs dsNone mbdsBlock" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                       role="tab" aria-controls="home" aria-selected="true">Ứng viên theo ngành
                        nghề</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile"
                       role="tab" aria-controls="profile" aria-selected="false">Ứng viên theo tỉnh /
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
                            $text_link_carrer = route('search_employee') . '?career_category_id='.$career->career_category_id;
                            ?>
                                <div class="col-lg-4 col-md-6 col-6">
                                    <a class="linkFillter" href="{{ $text_link_carrer }}">
                                        <p class="mgb10 js_sup_total_carrer_{{$career->career_category_id}}" data_id="{{$career->career_category_id}}"><i class="fas fa-list-ul f14 mgr5"></i>{{$career->career_category_name}}
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
                                $text_link_province = route('search_employee') . '?province=' . $province->province_id;
                                ?>

                                    <div class="col-lg-3 col-md-4 col-6">

                                        <a class="linkFillter" href="{{ $text_link_province }}">
                                            <p class=" mgb10 js_sup_total_province_{{$province->province_id}}" data_id="{{$province->province_id}}"><i  class="fas fa-map-marker-alt f14 mgr5"></i>{{$province->province_name}}
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
{{--//hien thị tổng số lượng ứng viên--}}
@include('site.employee_site.js_count_employee_province_carrer');