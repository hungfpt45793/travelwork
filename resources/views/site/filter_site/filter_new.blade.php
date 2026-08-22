<section class="filter_new">
    <div class="container container_w_1200">
        <div class="row">
            <div class="col-md-12">
                <p>{{ isset($information['tieu-de-tim-cong-viec']) ?  $information['tieu-de-tim-cong-viec'] : 'Travelwork tự hào làm cầu nối cho hơn 15 triệu lượt tuyển dụng và tìm việc thành công' }}</p>
            </div>
            <div class="col-md-12">
                <div class="filter_new_form">
                    <form class="filter_form_search" action="{{ route('submit_search_jobfb') }}" method="GET">
                        <div class="filter_item_carerr">
                            <i class="fas fa-list-ul mgl15 mgr15 lg-f12"></i>
                            <div class="select_div">
                                <select class="select2_w90" name="career">
                                    <option value="">Tất cả Ngành nghề</option>
                                    @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                        <option value="{{$career->career_category_slug}}">{{$career->career_category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="filter_item_button dsNone_implotar dsBlock_900 filter_item_button2">
                            <button type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div class="filter_item_carerr filter_item_carerr_border">
                            <i class="fas fa-map-marker-alt mgl15 mgr15 lg-f12"></i>
                            <div class="select_div">
                                <select class="select2_w90"
                                        name="province" aria-label="Tỉnh/Thành phố" id="city_slug">
                                    <option value="0" selected> Tất cả Tỉnh/Thành phố</option>
                                    <?php
                                    $getAllProvince = \App\Entity\Province::GetAllProvinces();
                                    ?>
                                    @foreach($getAllProvince as $province)
                                        <i class="fas fa-map-marker-alt mgl15  lg-f12 mb_w15"></i>
                                        <option value="{{$province->province_slug}}">{{$province->province_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="filter_item_carerr">
                            <i class="fas fa-map-marker-alt mgl15 mgr15 lg-f12"></i>
                            <div class="select_div">
                                <select class="select2_w90"
                                        name="district" aria-label="Quận/Huyện" id="county">
                                    <option value="0" selected> Tất cả Quận/Huyện</option>
                                </select>
                            </div>
                        </div>
                        <div class="filter_item_button dsNone_900_implotar">
                            <button type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</section>
