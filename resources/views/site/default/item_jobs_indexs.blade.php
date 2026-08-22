<section class="quickSearchForJobs  bgrWhite">

    <div class="title">
        <h2 class="text-center fw7 f32 xl-f28 lg-f23 sm-pdt25 red pdt40 mgb40 mbf18 tile_home_index">VIỆC LÀM TẠI SÀN KẾ TOÁN</h2>

    </div>
    <div class="formSearch pd0">
        <div class="form-group">
            {{--detail_job_facebook--}}
            <form id="searchBox" action="{{ route('submit_search_jobfb') }}" method="GET">
                <div class="content bd15white">
                    <div class="row mg0">
                        <div class="col-lg-3 col-md-6 col-sm-12 col-12 widthMh14 disInBlock pd0 bdLightGray noBorderRightIm sm-bdLightGrayIm">
                            <i class="fas fa-list-ul mgl15  lg-f12 mb_w15"></i>
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
                        <div class="col-lg-3 col-md-6 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 noBorderRightIm sm-bdLightGrayIm">
                            <i class="fas fa-map-marker-alt mgl15  lg-f12 mb_w15"></i>
                            <?php $province_get = isset($_GET['p']) ? $_GET['p'] : '';?>
                            <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                    name="province" aria-label="Tỉnh/Thành phố" id="city_slug">
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
                        <div class="col-lg-3 col-md-6 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 noBorderRightIm sm-bdLightGrayIm">
                            <i class="fas fa-map-marker-alt mgl15  lg-f12 mb_w15"></i>
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

                        <div class="col-lg-3 col-md-6 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 sm-bdLightGrayIm">
                            <i class="fas fa-hand-holding-usd money mgl15  lg-f12 mb_w15"></i>
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
                            <div class="col-lg-3 col-md-6 pd0">
                                <i class="fas fa-certificate money mgl15  lg-f12 mb_w15"></i>
                                <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                        name="vip">
                                    <option value="" @if($vip_get == '') selected @endif>Tất cả tin</option>
                                    <option @if($vip_get == '0') selected @endif  value="0">Tin thường</option>
                                    <option @if($vip_get == '1') selected
                                            @endif  value="1">Tin vip
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-7 col-md-6 pd0 borderLeftMobile" style="border-left: 1px solid #ccc;
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

</section>

<script>
    // chon thanh pho ra quan huyen
    $('#city_slug').change(function () {
        var city = $(this).val();
        $.get('/tim-kiem-slug/' + city, function (data) {
            $('#county').html('');
            $('#county').html(data);
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });
</script>
<section class="attractiveJobs pd40 pdt0">
    <div class="infoAttractiveJobs bdLightGray radius10 pd20 bgrWhite pdt10 pdb0">
        <div class="row">

            @foreach (App\Entity\Job::showJobVip() as $id => $job)
                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 bdBottomGray pd10 hvBoxShadow cursor hvbgrClick">
                    <a href=" {{ route('job_detail',['slug'=>$job->slug]) }}" class=" hvBlueDN textCap fw6 blueDN noDecoration">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="f18 cutTitle">{{$job->title}}</h3>
                                <p class="hvGrey mgb5 fw6 gray CutTextW300 cutTitle">{{$job->enterprise_name}}</p>
                            </div>

                            <div class="col-lg-12">
                                <p class="CutTextW300"><i
                                            class="fas fa-map-marker-alt address"></i>

                                    @if(isset($job->district_name))
                                        {{ $job->district_name }}
                                    @endif
                                    @if(!empty($job->district_name))
                                        -
                                    @endif
                                    @if(isset($job->province_name))
                                        {{ $job->province_name }}
                                    @endif
                                </p>
                            </div>
                            <div class="col-lg-12">
                                <p><span style="margin-right: 15px;display: inline-block"><i
                                                class="fas fa-hand-holding-usd money"></i> Lương: {{$job->salary_description}}</span>
                                    <?php
                                    $date = date_create($job->deadline_submit_profile);
                                    ?>
                                    <span class="hideOnMobile clorange"> <i
                                                class="fas fa-calendar-times clorange"></i>
                                        Hạn nộp: {{ date_format($date,"d/m/Y") }}</span></p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

            <div class="col-12 text-center pd10">
                {{--<a class="f18" href="{{route('list_cate_job')}}"><i class="fas fa-arrow-right"></i> 5.000 + việc làm khác</a>--}}
                <a class="f18" href="{{route('list_job_face')}}"><i class="fas fa-arrow-right"></i> 100.000 + việc làm
                    khác</a>
            </div>


        </div>
    </div>
</section>
<div class="underLineY h10x bgrGray"></div>