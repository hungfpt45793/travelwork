<section class="filter_form_search mgt20">
    <div class="form_search_job">
        <div class="">
            <form id="searchBox" action="{{ route('submit_search_jobfb') }}" method="GET" class="form_search_job_border">
                <div class="content bd15white">
                    <div class="row mg0">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 item_search">
                            <i class="fas fa-list-ul mgl15  lg-f12"></i>
                            <?php $career_get = isset($_GET['c']) ? $_GET['c'] : '';?>
                            <select class="select2_w90 select2"
                                    name="career">
                                <option value="0" selected>Tất cả ngành nghề</option>
                                @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                    <option value="{{$career->career_category_slug}}"
                                            @if($career->career_category_id == $career_get) selected @endif>{{$career->career_category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 item_search">
                            <i class="fas fa-map-marker-alt mgl15  lg-f12"></i>
                            <?php $province_get = isset($_GET['p']) ? $_GET['p'] : '';?>
                            <select class="select2_w90 select2"  name="province" aria-label="Tỉnh/Thành phố" id="city_slug">
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
                    </div>
                    <div class="searchInput bdLightGray noBorderTopIm">
                        <div class="row mg0">
                            <div class="col-xl-10 col-lg-6 col-md-6 item_search">
                                <?php $word_get = isset($_GET['w']) ? $_GET['w'] : '';?>
                                <input class="input_s_word" type="text" name="word"
                                       placeholder="Nhập tiêu đề công việc..." value="{{ $word_get }}">
                            </div>
                            <button class="col-lg-2 text-center item_search btn_submit_search"
                                    type="submit">Tìm kiếm
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

