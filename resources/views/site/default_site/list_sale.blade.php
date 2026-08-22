<section class="list_agency list_sale list_job_home_new">
    <div class="container container_w_1200">
        <div class="row">
            <div class="col-md-12 ">
                <div class="title_new_sale">
                    <h3><p><i class="fas fa-phone"></i> Sale hỗ trợ nhà Tuyển dụng</p></h3>


                    <div class="row box_list_sale">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                            <div class="item_agency item_sale">
                                <div class="item_agency_head">
                                    <div class="agency_head_left">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span class="agency_head_title">
                            Sales hỗ trợ NTD Miền Bắc
                            </span>
                                    </div>
                                </div>
                                @foreach(\App\Entity\SubPost::showSubPost('sale-mien-bac',10,'asc') as $id => $sale_mb)
                                    <div class="item_agency_content item_sale_content">
                                        <p>
                                            <i class="fas fa-user"></i>
                                            <span>Tên nhóm :</span><strong>{{ !empty($sale_mb['title']) ? $sale_mb['title'] : '' }}</strong>
                                        </p>
                                        <p>
                                            <i class="fas fa-phone"></i> <span>Số điện thoại :</span><strong class="phone"><a href="tel:{{ !empty($sale_mb['so-dien-thoai']) ? $sale_mb['so-dien-thoai'] : '' }}"  class="clRed phone">{{ !empty($sale_mb['so-dien-thoai']) ? $sale_mb['so-dien-thoai'] : '' }}</a></strong>
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                            <div class="item_agency item_sale">
                                <div class="item_agency_head">
                                    <div class="agency_head_left">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span class="agency_head_title">
                           Sales hỗ trợ NTD Miền Nam
                            </span>
                                    </div>
                                </div>
                                @foreach(\App\Entity\SubPost::showSubPost('sale-mien-nam',10,'asc') as $id => $sale_mb)
                                    <div class="item_agency_content item_sale_content">
                                        <p>
                                            <i class="fas fa-user"></i>
                                            <span>Tên nhóm :</span><strong>{{ !empty($sale_mb['title']) ? $sale_mb['title'] : '' }}</strong>
                                        </p>
                                        <p>
                                            <i class="fas fa-phone"></i> <span>Số điện thoại :</span><strong class="phone"><a href="tel:{{ !empty($sale_mb['so-dien-thoai']) ? $sale_mb['so-dien-thoai'] : '' }}"  class="clRed phone">{{ !empty($sale_mb['so-dien-thoai']) ? $sale_mb['so-dien-thoai'] : '' }}</a></strong>
                                        </p>
                                    </div>
                                @endforeach
                            </div>

                        </div>


                        <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                            <div class="item_agency item_sale">
                                <div class="item_agency_head">
                                    <div class="agency_head_left">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span class="agency_head_title">
                            CSKH & khiếu nại dịch vụ
                            </span>
                                    </div>
                                </div>
                                @foreach(\App\Entity\SubPost::showSubPost('khieu-nai-dich-vu',10,'asc') as $id => $sale_mb)
                                    <div class="item_agency_content item_sale_content">
                                        <p>
                                            <i class="fas fa-user"></i>
                                            <span>Tên nhóm :</span><strong>{{ !empty($sale_mb['title']) ? $sale_mb['title'] : '' }}</strong>
                                        </p>
                                        <p>
                                            <i class="fas fa-phone"></i> <span>Số điện thoại :</span><strong class="phone"><a href="tel:{{ !empty($sale_mb['so-dien-thoai']) ? $sale_mb['so-dien-thoai'] : '' }}"  class="clRed phone">{{ !empty($sale_mb['so-dien-thoai']) ? $sale_mb['so-dien-thoai'] : '' }}</a></strong>
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>





                    </div>


                </div>

            </div>
        </div>

    </div>

</section>