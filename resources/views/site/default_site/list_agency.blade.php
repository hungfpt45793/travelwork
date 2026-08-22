<section class="list_agency list_job_home_new">
    <div class="container container_w_1200">
        <div class="row">
            <div class="col-md-12 title_new_home">
                <h3><p> Hệ thống đại lý của Travelwork</p></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                <div class="item_agency">
                    <div class="item_agency_head">
                        <div class="agency_head_left">
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="agency_head_title">
                            Khu vực miền Bắc
                            </span>
                        </div>
                        <div class="agency_head_right js_agency_head_right">
                            Xem tất cả <span><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <?php
                    $list_agency = \App\Entity\Employer::get_province_local(1);
                    ?>
                    @foreach($list_agency as $agency)
                        <div class="item_agency_content js_item_agency_content">
                            <p>
                                <i class="fas fa-building"></i>
                               <a href="{{ route('detail_agency',['slug'=> $agency->slug]) }}" title="{{ !empty($agency->enterprise_name) ? $agency->enterprise_name : '' }}"> <strong class="title_company">{{ !empty($agency->enterprise_name) ? $agency->enterprise_name : '' }}</strong></a>
                            </p>
                            <p>
                                <i class="fas fa-map-marker-alt"></i><strong>{{ !empty($agency->district_name) ? $agency->district_name : '' }} - {{ !empty($agency->province_name) ? $agency->province_name : '' }} </strong>
                            </p>
                            <p>
                                <i class="fab fa-internet-explorer"></i> <strong><a rel="nofollow" href="{{ !empty($agency->website) ? $agency->website : '' }}">{{ !empty($agency->website) ? $agency->website : 'Đang cập nhật' }}</a></strong>
                            </p>
                            <p>
                                <i class="fas fa-phone"></i> <strong>{{ !empty($agency->phone) ? $agency->phone : '' }}</strong>
                            </p>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                <div class="item_agency">
                    <div class="item_agency_head">
                        <div class="agency_head_left">
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="agency_head_title">
                            Khu vực miền Trung
                            </span>
                        </div>
                        <div class="agency_head_right js_agency_head_right">
                            Xem tất cả <span><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <?php
                    $list_agency = \App\Entity\Employer::get_province_local(2);
                    ?>
                    @foreach($list_agency as $agency)
                        <div class="item_agency_content js_item_agency_content">
                            <p>
                                <i class="fas fa-building"></i>
                               <a href="{{ route('detail_agency',['slug'=> $agency->slug]) }}" title="{{ !empty($agency->enterprise_name) ? $agency->enterprise_name : '' }}"> <strong class="title_company">{{ !empty($agency->enterprise_name) ? $agency->enterprise_name : '' }}</strong></a>
                            </p>
                            <p>
                                <i class="fas fa-map-marker-alt"></i><strong>{{ !empty($agency->district_name) ? $agency->district_name : '' }} - {{ !empty($agency->province_name) ? $agency->province_name : '' }} </strong>
                            </p>
                            <p>
                                <i class="fab fa-internet-explorer"></i> <strong><a rel="nofollow" href="{{ !empty($agency->website) ? $agency->website : '' }}">{{ !empty($agency->website) ? $agency->website : 'Đang cập nhật' }}</a></strong>
                            </p>
                            <p>
                                <i class="fas fa-phone"></i> <strong>{{ !empty($agency->phone) ? $agency->phone : '' }}</strong>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                <div class="item_agency">
                    <div class="item_agency_head">
                        <div class="agency_head_left">
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="agency_head_title">
                            Khu vực miền Nam
                            </span>
                        </div>
                        <div class="agency_head_right js_agency_head_right">
                            Xem tất cả <span><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <?php
                    $list_agency = \App\Entity\Employer::get_province_local(3);
                    ?>
                    @foreach($list_agency as $agency)
                        <div class="item_agency_content js_item_agency_content">
                            <p>
                                <i class="fas fa-building"></i>
                               <a href="{{ route('detail_agency',['slug'=> $agency->slug]) }}" title="{{ !empty($agency->enterprise_name) ? $agency->enterprise_name : '' }}"> <strong class="title_company">{{ !empty($agency->enterprise_name) ? $agency->enterprise_name : '' }}</strong></a>
                            </p>
                            <p>
                                <i class="fas fa-map-marker-alt"></i><strong>{{ !empty($agency->district_name) ? $agency->district_name : '' }} - {{ !empty($agency->province_name) ? $agency->province_name : '' }} </strong>
                            </p>
                            <p>
                                <i class="fab fa-internet-explorer"></i> <strong><a rel="nofollow" href="{{ !empty($agency->website) ? $agency->website : '' }}">{{ !empty($agency->website) ? $agency->website : 'Đang cập nhật' }}</a></strong>
                            </p>
                            <p>
                                <i class="fas fa-phone"></i> <strong>{{ !empty($agency->phone) ? $agency->phone : '' }}</strong>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</section>
