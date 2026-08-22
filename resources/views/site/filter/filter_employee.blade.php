<section class="quickSearchForJobs mgt20 bgrWhite">
    <div class="formSearch pd0">
        <div class="form-group">
            {{--detail_job_facebook--}}
            <form id="searchBox" action="{{ route('search_employee') }}" method="GET">
                <div class="content bd15white">
                    <div class="row mg0">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 widthMh14 disInBlock pd0 bdLightGray noBorderRightIm sm-bdLightGrayIm">
                            <i class="fas fa-list-ul mgl15  lg-f12"></i>
                            <?php $career_get = isset($_GET['career']) ? $_GET['career'] : 0;?>
                            <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                    name="career">
                                <option value="0" selected>Công việc cần tìm</option>
                                @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                    <option value="{{$career->career_category_id}}"
                                            @if($career->career_category_id == $career_get) selected @endif>{{$career->career_category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 noBorderRightIm sm-bdLightGrayIm">
                            <i class="fas fa-map-marker-alt mgl15  lg-f12"></i>
                            <?php $province_get = isset($_GET['province']) ? $_GET['province'] : 0;?>
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
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 noBorderRightIm sm-bdLightGrayIm">
                            <i class="fas fa-map-marker-alt mgl15  lg-f12"></i>
                            <?php $district_get = isset($_GET['district']) ? $_GET['district'] : '';?>
                            <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                    name="district" aria-label="Quận/Huyện" id="county">
                                <option value="0" selected> Tất cả quận/huyện</option>
                                @if(!empty($_GET['province']))
                                    @foreach(\App\Entity\District::get_province_id($_GET['province']) as $district)
                                        <option @if($district->district_id == $district_get) selected
                                                @endif value="{{ $district->district_id }}">{{$district->district_name}}</option>
                                    @endforeach
                                    @else
                                    @foreach(\App\Entity\District::getAllDistrict() as $district)
                                        <option @if($district->district_id == $district_get) selected
                                                @endif value="{{ $district->district_id }}">{{$district->district_name}}</option>
                                    @endforeach
                                    @endif



                            </select>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 sm-bdLightGrayIm">
                            <i class="fas fa-hand-holding-usd money mgl15  lg-f12"></i>
                            <?php $salary_get = isset($_GET['salary_id']) ? $_GET['salary_id'] : '';?>
                            <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                    name="salary_id">
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
                            $time_to_work_get = isset($_GET['time_to_work']) ? $_GET['time_to_work'] : '';
                            ?>
                            <div class="col-lg-3 col-md-6 pd0">

                                {{--<i class="fas fa-certificate money mgl15  lg-f12"></i>--}}
                                <i class="fas fa-running f14 mgl15  lg-f12"></i>

                                <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                        name="time_to_work">
                                    <option value="" @if($time_to_work_get == '') selected @endif>Kinh nghệm của ứng viên</option>
                                    <option @if($time_to_work_get == '0') selected @endif  value="0">Dưới 1 năm kinh nghiệm</option>
                                    <option @if($time_to_work_get == '1') selected @endif  value="1">1 năm kinh nghiệm</option>
                                    <option @if($time_to_work_get == '2') selected @endif  value="2">2 năm kinh nghiệm</option>
                                    <option @if($time_to_work_get == '3') selected @endif  value="3">3 năm kinh nghiệm</option>
                                    <option @if($time_to_work_get == '4') selected @endif  value="4">4 năm kinh nghiệm</option>
                                    <option @if($time_to_work_get == '5') selected @endif  value="5">5 năm kinh nghiệm</option>
                                    <option @if($time_to_work_get >= '6') selected @endif  value="6">Trên 5 năm kinh nghiệm</option>

                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-7 col-md-6 pd0 borderLeftMobile" style="border-left: 1px solid #ccc;
    border-radius: 0;">
                                <?php $word_get = isset($_GET['word']) ? $_GET['word'] : '';?>
                                <input class="width85 h35x noBorder w100 pd15" type="text" name="word"
                                       placeholder="Nhập tên ứng viên ..." value="{{ $word_get }}">
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

    <script>
        // chon thanh pho ra quan huyen
        $('#city').change(function () {
            var city = $(this).val();
            $.get('/tim-kiem-huyen/' + city , function (data) {
                $('#county').html('');
                $('#county').html(data);
            });
        });
    </script>
</section>

