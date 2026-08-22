{{--Jobquick là chỉnh phần facebook--}}
<section class="filter_form_search mgt20">
    <div class="form_search_job">
        <div class="">
            {{--detail_job_facebook--}}
            <form id="searchBox" action="{{ route('search_employee') }}" method="GET" class="form_search_job_border">
                <div class="content bd15white">
                    <div class="row mg0">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 item_search">
                            <i class="fas fa-list-ul mgl15  lg-f12"></i>
                            <?php $career_category_id = isset($_GET['career_category_id']) ? $_GET['career_category_id'] : array();?>
                            <select class="select2_w90 select2"
                                    name="career_category_id">
                                <option value="">Công việc cần tìm</option>
                                @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                    <option value="{{$career->career_category_id}}"
                                            @if(in_array($career->career_category_id, $career_category_id)) selected @endif>{{$career->career_category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 item_search">
                            <i class="fas fa-map-marker-alt mgl15  lg-f12"></i>
                            <?php $province_get = isset($_GET['province']) ? $_GET['province'] : 0;?>
                            <select class="select2_w90 select2"
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
                    </div>

                    <div class="searchInput bdLightGray noBorderTopIm">
                        <div class="row mg0">
                            <div class="col-lg-10 col-md-6 item_search">
                                <?php $word_get = isset($_GET['word']) ? $_GET['word'] : '';?>
                                <input class="input_s_word" type="text" name="word"
                                       placeholder="Nhập tên ứng viên ..." value="{{ $word_get }}">
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


