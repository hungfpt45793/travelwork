{{--quickSearchIntership // bo lọc ben thuc tập--}}
<section class="quickSearchForJobs mgt20 bgrWhite quickSearchIntership">
    <div class="formSearch pd0">
        <div class="form-group">
            {{--detail_job_facebook--}}
            <form id="searchBox" action="{{ route('list_employer') }}" method="GET">
                <div class="content bd15white">
                    <div class="row mg0">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 sm-bdLightGrayIm">
                            <i class="fas fa-list-ul mgl15  lg-f12"></i>
                            <?php $type_of_business_id_get = isset($_GET['type_of_business_id']) ? $_GET['type_of_business_id'] : '';?>
                            <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                    name="type_of_business_id">
                                <option value="0" selected>Loại hình doanh nghiệp</option>

                                <?php
                                $listtype = \App\Entity\TypeOfBusiness::getAllTypeBusiness();
                                ?>
                                @foreach($listtype as $type)
                                    <option value="{{ $type->type_of_business_id }}"
                                            @if($type_of_business_id_get == $type->type_of_business_id) selected @endif
                                    >{{ $type->type_of_business_name }}</option>

                                @endforeach
                            </select>


                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 noBorderRightIm sm-bdLightGrayIm">
                            <i class="fas fa-map-marker-alt mgl15  lg-f12"></i>

                            <?php $province_get = isset($_GET['province']) ? $_GET['province'] : '';?>
                            <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                    name="province" aria-label="Tỉnh/Thành phố" id="city">
                                <option value="0" selected> Tất cả tỉnh/thành phố</option>
                                <?php
                                $getAllProvince = \App\Entity\Province::GetAllProvinces();
                                ?>
                                @foreach($getAllProvince as $province)
                                    <option @if($province->province_id == $province_get) selected
                                            @endif value="{{$province->province_id}}">{{$province->province_name}}</option>
                                @endforeach
                            </select>



                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 noBorderRightIm sm-bdLightGrayIm">
                            <i class="fas fa-map-marker-alt mgl15  lg-f12"></i>
                            <?php $district_get = isset($_GET['district']) ? $_GET['district'] : '';?>
                            <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
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
                                            @endif value="{{ $district->district_id }}">{{$district->district_name}}</option>
                                @endforeach

                            </select>
                        </div>


                    </div>




                    <div class="searchInput bdLightGray noBorderTopIm">
                        <div class="row mg0">
                            <div class="col-lg-4 col-md-4 pd0">

                                <i class="fas fa-list-ul mgl15  lg-f12"></i>
                                <?php $business_get = isset($_GET['business']) ? $_GET['business'] : 0;?>
                                <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                        name="business">
                                    <option value="0" selected>Loại hình kinh doanh</option>
                                    <?php
                                    $business = \App\Entity\Business::getALLSite();
                                    ?>
                                    @foreach($business as $busines)
                                        <option value="{{ $busines->business_type_id }}"
                                                @if($business_get == $busines->business_type_id) selected @endif
                                        >{{ $busines->business_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-8 pd0 border-left-0 mb_border_top_1" style="border-left: 1px solid #ccc;
    border-radius: 0;">
                                <?php $word_get = isset($_GET['word']) ? $_GET['word'] : '';?>
                                <input class="width85 h35x noBorder w100 pd15" type="text" name="word"
                                       placeholder="Nhập tên công ty..." value="{{ $word_get }}">
                            </div>
                            <button class=" col-md-12 col-lg-2 text-center mg block bgrBlueN pd6 cursor whiteIm noBorder"
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
        $.get('/tim-kiem-huyen/' + city, function (data) {
            $('#county').html('');
            $('#county').html(data);
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.js-example-basic-single').select2_auto();
    });
</script>