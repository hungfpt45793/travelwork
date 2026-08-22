<section class="quickSearchForJobs mgt20 bgrWhite">
    <div class="formSearch pd0">
        <div class="form-group">
            {{--detail_job_facebook--}}
            <form id="searchBox" action="{{ route('submit_category_Exam') }}" method="GET">
                <div class="content bd15white">
                    {{--<div class="row mg0">--}}
                    {{--<div class="col-lg-3 col-md-3 col-sm-12 col-12 widthMh14 disInBlock pd0 bdLightGray noBorderRightIm sm-bdLightGrayIm">--}}

                    {{--<i class="fas fa-question mgl15 mgr15 lg-f12"></i>--}}
                    {{--<input class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 pd15" type="number" name="word"--}}
                    {{--placeholder="Nhập số câu hỏi..." value="">--}}
                    {{--</div>--}}
                    {{--<div class="col-lg-3 col-md-3 col-sm-12 col-12 widthMh14 disInBlock pd0 bdLightGray noBorderRightIm sm-bdLightGrayIm">--}}

                    {{--<i class="far fa-clock mgl15 mgr15 lg-f12"></i>--}}
                    {{--<input class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 pd15" type="number" name="word"--}}
                    {{--placeholder="Nhập số phút.." value="">--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    <div class="searchInput bdLightGray noBorderTopIm">
                        <div class="row mg0">
                            <?php $type_of_business_id_get = isset($_GET['t']) ? $_GET['t'] : '';
                            ?>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 widthMh14 disInBlock pd0  sm-bdLightGrayIm"
                                     style="border-top: 1px solid #ccc;border-right: 1px solid #ccc;">
                                    <i class="fas fa-list-ul mgl15 mgr15 lg-f12"></i>
                                    <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
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


                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 widthMh14 disInBlock pd0  sm-bdLightGrayIm"
                                     style="border-top: 1px solid #ccc;border-right: 1px solid #ccc;">
                                    <i class="fas fa-list-ul mgl15 mgr15 lg-f12"></i>
                                    <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87 select2_auto"
                                            name="career_category_id">
                                        <option value="0" selected> Vị trí công việc</option>

                                        {{--career--}}
                                        <?php $career_get = isset($_GET['c']) ? $_GET['c'] : '';?>

                                        @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                            <option value="{{$career->career_category_slug}}"
                                                    @if($career->career_category_id == $career_get) selected @endif>{{$career->career_category_name}}</option>
                                        @endforeach



                                    </select>
                                </div>





                        </div>
                        <div class="row mg0">

                            <div class="col-lg-10 pd0" style="border-top: 1px solid #ccc;">
                                <?php $word_get = isset($_GET['w']) ? $_GET['w'] : '';?>
                                <input class="width85 h35x noBorder w100 pd15" type="text" name="word"
                                       placeholder="Nhập tên đề thi..." value="{{ $word_get }}">
                            </div>
                            <button class="col-lg-2 text-center  block bgrBlueN pd6 cursor whiteIm noBorder"
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
            $.get('/tim-kiem-huyen/' + city, function (data) {
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
</section>

