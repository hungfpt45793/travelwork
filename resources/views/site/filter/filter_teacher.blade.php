<div class="trainingProcess mgb20">

    <?php
    $adv_noti = \App\Entity\Adv_noti::get_adv_noti();
    ?>
    @if(!empty($adv_noti))
        <a href="{{$adv_noti->adv_link  }}" target="_blank" class="content_modal_noti_adv dsNone mbdsBlock">
            <div class="commitments mgb20">

                <div class="title bgrBlueN pdt15 pdb15 pdl10 radiusTopLeft5 radiusTopRight5">
                    <h3 class="white fw7 textUpper mgb0 text-center f18 ">{{ !empty($adv_noti->adv_title) ? $adv_noti->adv_title : '' }}</h3>
                </div>
                <div class="listTranning content_modal_noti_adv">
                    {!! !empty($adv_noti->adv_content) ? $adv_noti->adv_content : '' !!}
                </div>

            </div>
        </a>
    @endif

    <div class="row textCenter">

        <?php  $cate_steps = \App\Entity\Category::getDetailCategory('cac-buoc-chon-giao-vien');
        ?>
        <div class="col-md-12"><h3
                    class="mgb20 clhome fw6">{{ isset($cate_steps->title) ? $cate_steps->title : '' }}</h3>
        </div>

        @foreach(\App\Entity\Post::categoryShowAsc('cac-buoc-chon-giao-vien',6) as $post_steps)
            <div class="col-md-4 mgb5 maxHeightFilter">


                <a href="{{ route('detail_new', ['cate' => $cate_steps->slug, 'post_teacher' => $post_steps->slug]) }}"
                   title="{{ isset($post_steps['title']) ? $post_steps['title'] : '' }}">
                    <div class="step step textCenter bgorang white radius10 pdt10 pdb10">
                        <p class="mgb0 fw7">{{ isset($post_steps['title']) ? $post_steps['title'] : '' }}</p>
                        <p class="mgb0">{{ isset($post_steps['description']) ? $post_steps['description'] : '' }}</p>
                    </div>
                </a>

            </div>
        @endforeach

        <div class="col-md-12">
            <div class="bg-white pd-20 pd-010 filterTeacher">

                <div class="formSearch pd0">
                    <div class="form-group">
                        <form action="{{ route('submitTeacher') }}" method="GET" id="searchBox">
                            <div class="content bd15white">
                                <div class="row mg0">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 widthMh14 disInBlock pd0 bdLightGray noBorderRightIm sm-bdLightGrayIm">

                                        <i class="fas fa-building mgl15 lg-f12"></i>
                                        <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                                name="type_of_business_id"
                                                aria-label="Lĩnh vực doanh nghiệp"
                                                id="">
                                            <option value="0" selected>Lĩnh vực doanh nghiệp</option>
                                            <?php
                                            $type_of_business_id_get = isset($_GET['t']) ? $_GET['t'] : '';
                                            $listtype = \App\Entity\TypeOfBusiness::getAllTypeBusiness();
                                            ?>
                                            @foreach($listtype as $type)
                                                <option value="{{ $type->type_of_business_slug }}"
                                                        @if($type_of_business_id_get == $type->type_of_business_id) selected @endif
                                                >{{ $type->type_of_business_name }}</option>

                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 noBorderRightIm sm-bdLightGrayIm">
                                        <i class="fas fa-map-marker-alt mgl15  lg-f12"></i>
                                        <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto "
                                                name="province"
                                                aria-label="Tỉnh/Thành phố"
                                                id="city">
                                            <?php $province_get = isset($_GET['p']) ? $_GET['p'] : '';?>
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
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 noBorderRightIm sm-bdLightGrayIm">
                                        <i class="fas fa-map-marker-alt mgl15  lg-f12"></i>
                                        <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto "
                                                name="district"
                                                aria-label="Quận/Huyện"
                                                id="county">
                                            <?php $district_get = isset($_GET['q']) ? $_GET['q'] : '';?>
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
                                        <?php $word_get = isset($_GET['w']) ? $_GET['w'] : ''?>
                                        <div class="col-lg-10 pd0">
                                            <input class="width85 h35x noBorder w100 pd15" type="text"
                                                   name="word" placeholder="Nhập tên giáo viên..."
                                                   value="{{ $word_get }}">
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
            </div>

        </div>
    </div>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('.js-example-basic-single').select2_auto();
        });
    </script>
</div>
