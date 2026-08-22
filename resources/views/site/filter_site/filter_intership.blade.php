{{--Jobquick là chỉnh phần facebook--}}
<section class="filter_form_search mgt20">
    <div class="form_search_job">
        <div class="">
            {{--detail_job_facebook--}}
            <form id="searchBox" action="{{ route('submit_intership') }}" method="GET" class="form_search_job_border">
                <div class="content bd15white">
                    <div class="row mg0">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 item_search">
                            <i class="fas fa-list-ul mgl15  lg-f12"></i>

                            <?php $type_of_business_id_get = isset($_GET['t']) ? $_GET['t'] : '';?>
                            <select class="select2_w90 select2"
                                    name="type_of_business_id">
                                <option value="0" selected>Loại hình doanh nghiệp</option>

                                <?php
                                $listtype = \App\Entity\TypeOfBusiness::getAllTypeBusiness();
                                ?>
                                @foreach($listtype as $type)
                                    <option value="{{ $type->type_of_business_slug }}"
                                            @if($type_of_business_id_get == $type->type_of_business_id) selected @endif
                                    >{{ $type->type_of_business_name }}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 item_search">
                            <i class="fas fa-map-marker-alt mgl15  lg-f12"></i>

                            <?php $province_get = isset($_GET['p']) ? $_GET['p'] : '';?>
                            <select class="select2_w90 select2"
                                    name="province" aria-label="Tỉnh/Thành phố" id="city">
                                <option value="0" selected> Tất cả tỉnh/thành phố</option>
                                <?php
                                $getAllProvince = \App\Entity\Province::GetAllProvinces();
                                ?>
                                @foreach($getAllProvince as $province)
                                    <option @if($province->province_id == $province_get) selected
                                            @endif value="{{$province->province_slug}}">{{$province->province_name}}</option>
                                @endforeach
                            </select>


                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 item_search">
                            <i class="fas fa-map-marker-alt mgl15  lg-f12"></i>
                            <?php $district_get = isset($_GET['q']) ? $_GET['q'] : '';?>
                            <select class="select2_w90 select2"
                                    name="district" aria-label="Quận/Huyện" id="county">
                                <option value="0" selected> Tất cả quận/huyện</option>
                                <?php
                                $districts = '';
                                if (!empty($province_get)) {
                                    $districts = \App\Entity\District::get_province_id($province_get);
                                } else {
                                    $districts = \App\Entity\District::getAllDistrict();
                                }
                                ?>
                                @foreach( $districts as $district)
                                    <option @if($district->district_id == $district_get) selected
                                            @endif value="{{ $district->district_slug }}">{{$district->district_name}}</option>
                                @endforeach

                            </select>
                        </div>


                    </div>

                    <div class="searchInput bdLightGray noBorderTopIm">
                        <div class="row mg0">
                            <div class="col-lg-4 col-md-6 item_search">
                                <i class="fas fa-list-ul mgl15  lg-f12"></i>
                                <?php $business_get = isset($_GET['b']) ? $_GET['b'] : 0;?>
                                <select class="select2_w90 select2"
                                        name="business">
                                    <option value="0" selected>Loại hình kinh doanh</option>
                                    <?php
                                    $business = \App\Entity\Business::getALLSite();
                                    ?>
                                    @foreach($business as $busines)
                                        <option value="{{ $busines->business_type_slug }}"
                                                @if($business_get == $busines->business_type_id) selected @endif
                                        >{{ $busines->business_type_name }}</option>
                                    @endforeach
                                </select>


                            </div>
                            <div class="col-lg-6 col-md-6 item_search">
                                <?php $word_get = isset($_GET['w']) ? $_GET['w'] : '';?>
                                <input class="input_s_word" type="text" name="word"
                                       placeholder="Nhập tên công ty..." value="{{ $word_get }}">

                            </div>

                            <button class=" col-lg-2 text-center item_search btn_submit_search"
                                    type="submit">Tìm kiếm
                            </button>



                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</section>



    <script>
        // chon thanh pho ra quan huyen
        $('#city').change(function () {
            var city = $(this).val();
            $.get('/tim-kiem-slug/' + city, function (data) {
                $('#county').html('');
                $('#county').html(data);
            });
        });
    </script>
