<section class="quickSearchForJobs mgt20 bgrWhite">
    <div class="formSearch pd0">
        <div class="form-group">
            {{--detail_job_facebook--}}
            <form id="searchBox" action="{{ route('submit_search') }}" method="GET">
                <div class="content bd15white">
                    <div class="row mg0">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 widthMh14 disInBlock pd0 bdLightGray noBorderRightIm sm-bdLightGrayIm">
                            <i class="fas fa-list-ul mgl15  lg-f12"></i>
                            <?php $career_get = isset($_GET['c']) ? $_GET['c'] : '';?>
                            <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                    name="career">
                                <option value="0" selected>Tất cả ngành nghề</option>
                                @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                    <option value="{{$career->career_category_slug}}"
                                            @if($career->career_category_id == $career_get) selected @endif>{{$career->career_category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 noBorderRightIm sm-bdLightGrayIm">
                            <i class="fas fa-map-marker-alt mgl15  lg-f12"></i>
                            <?php $province_get = isset($_GET['p']) ? $_GET['p'] : '';?>
                            <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
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
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 noBorderRightIm sm-bdLightGrayIm">
                            <i class="fas fa-map-marker-alt mgl15  lg-f12"></i>
                            <?php $district_get = isset($_GET['q']) ? $_GET['q'] : '';?>
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
                                            @endif value="{{ $district->district_slug }}">{{$district->district_name}}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 sm-bdLightGrayIm">
                            <i class="fas fa-hand-holding-usd money mgl15  lg-f12"></i>
                            <?php $salary_get = isset($_GET['l']) ? $_GET['l'] : '';?>
                            <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                    name="salary">
                                <option value="0" selected>Mức lương</option>
                                @foreach(\App\Entity\Salary::showAllSalary() as $salary)
                                    <option @if($salary->salary_id == $salary_get) selected
                                            @endif  value="{{$salary->salary_id}}">{{$salary->description}}</option>
                                @endforeach
                            </select>


                        </div>
                    </div>

                    <div class="searchInput bdLightGray noBorderTopIm">
                        <div class="row mg0">
                            <?php
                            $vip_get = isset($_GET['v']) ? $_GET['v'] : '';
                            ?>
                            <div class="col-lg-3 pd0">

                                <i class="fas fa-certificate money mgl15  lg-f12"></i>

                                <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                        name="vip">
                                    <option value="" @if($vip_get == '') selected @endif>Tất cả tin</option>
                                    <option @if($vip_get == '0') selected @endif  value="0">Tin thường</option>
                                    <option @if($vip_get == '1') selected
                                            @endif  value="1">Tin vip
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-7 pd0" style="border-left: 1px solid #ccc;
    border-radius: 0;">
                                <?php $word_get = isset($_GET['w']) ? $_GET['w'] : '';?>
                                <input class="width85 h35x noBorder w100 pd15" type="text" name="word"
                                       placeholder="Nhập tiêu đề công việc..." value="{{ $word_get }}">
                            </div>
                            <button class="col-lg-2 text-center mg block bgrBlueN pd6 cursor whiteIm noBorder"
                                    type="submit">Tìm kiếm
                            </button>
                        </div>
                    </div>


                </div>
            </form>
        </div>

    </div>
    <!--    --><?php //$province_get = isset($_GET['province']) ? $_GET['province'] : 0;?>

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

</section>

