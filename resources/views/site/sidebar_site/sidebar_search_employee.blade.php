<div class="dnav col-xl-3 col-lg-4 col-md-12 sidebar_job active_show_sidebar" id="js_toogle_sidebar">

    <div class="contentSidebar">
        <div class="sidebarFillter">
            <div class="box_header_sidebar text-left">
                <h5>
                    Tìm kiếm ứng viên
                </h5>
                <form action="{{ route('search_employee') }}" method="get" class="formSearchSidebar search_sidebar_border_select" id="submitSidebar">
                    <?php
                    //thành phố
                    $provice = isset($_GET['province']) ? $_GET['province'] : 0;
                    //                    $provice = \App\Entity\Province::getId($p);
                    //quân /huyện
                    $district_get = isset($_GET['district_id']) ? $_GET['district_id'] : '';
                    //                    $district = \App\Entity\District::getId($q);
                    $salary_get = isset($_GET['salary_id']) ? $_GET['salary_id'] : array();
                    $profile_get = isset($_GET['profile']) ? $_GET['profile'] : '';
                    $status_get = isset($_GET['status']) ? $_GET['status'] : '';
                    $career_category_id_get = isset($_GET['career_category_id']) ? $_GET['career_category_id'] : '';
                    ?>
                    <div class="">
                        <label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i> Tìm theo thành phố</label>
                    </div>
                    <select class="select2" name="province" aria-label="Tỉnh/Thành phố" id="search_city">
                        <option value="0" selected> Tất cả tỉnh/thành phố</option>
                        <?php
                        $getAllProvince = \App\Entity\Province::GetAllProvinces();
                        ?>
                        @foreach($getAllProvince as $province)
                            <option @if($province->province_id == $provice) selected
                                    @endif value="{{$province->province_id}}">{{$province->province_name}}</option>
                        @endforeach
                    </select>
                    <hr>


                    {{--//tìm theo quân, huyện--}}
                    <div class="">
                        <label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i> Tìm theo quận/huyện</label>
                    </div>

                    <select class="select2" name="district_id"  id="search_county">
                        <option
                                value="0">
                            Chọn quận huyện
                        </option>
                        @if(!empty($provice))
                            @foreach(\App\Entity\District::get_province_id($provice) as $district)
                                <option @if($district_get == $district->district_id)) selected @endif
                                value="{{$district->district_id}}">
                                    {{$district->district_name}}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <hr>

                    {{--//tìm theo quân, huyện--}}
                    <div class="">
                        <label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i> Tìm theo công việc</label>
                    </div>
                    <select class="select2" name="career_category_id" >
                        <option
                        value="0">
                            Chọn công việc
                        </option>
                        @foreach(\App\Entity\Career::get_all_career() as $career)
                            <option @if($career_category_id_get == $career->career_category_id) selected @endif
                            value="{{$career->career_category_id}}">
                                {{$career->career_category_name}}
                            </option>
                        @endforeach
                    </select>
                    <hr>
                    {{--//tìm theo quân, huyện--}}

                    {{--<div class="">--}}
                        {{--<label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i> Tìm theo mức lương</label>--}}
                    {{--</div>--}}


                    {{--@foreach(\App\Entity\Salary::showAllSalary() as $salary)--}}
                        {{--<div class="dsBlock">--}}

                            {{--<label class="f16 lpf14 js_submit_input">--}}
                                {{--<input type="radio" value="{{$salary->salary_id}}" class="checkboxFilter mgr5 "--}}
                                       {{--name="salary_id"--}}
                                       {{--@if($salary_get == $salary->salary_id) checked @endif >--}}
                                {{--<span class="mgl5 dsInline">{{$salary->description}}</span>--}}

                            {{--</label>--}}

                        {{--</div>--}}
                    {{--@endforeach--}}

                    {{--<hr>--}}


                    {{--<div class="">--}}
                        {{--<label class="f16 lpf14 fw6"><i class="fas fa-filter"></i> Tìm theo % hồ sơ</label>--}}
                    {{--</div>--}}


                    {{--<div class="dsBlock">--}}
{{--{{ $profile_get }}--}}

                        {{--<label class="f16 lpf14">--}}
                            {{--<input type="radio" value="40,50" class="checkboxFilter mgr5 js_submit_input" name="profile"--}}
                                   {{--@if($profile_get == '40,50') checked @endif>--}}
                            {{--<span class="mgl5 dsInline">Từ 40 % - 50 % </span>--}}

                        {{--</label>--}}
                    {{--</div>--}}
                    {{--<div class="dsBlock">--}}

                        {{--<label class="f16 lpf14">--}}
                            {{--<input type="radio" value="50,60" class="checkboxFilter mgr5 js_submit_input" name="profile"--}}
                                   {{--@if($profile_get == '50,60') checked @endif>--}}
                            {{--<span class="mgl5 dsInline">Từ 50 % - 60 % </span>--}}

                        {{--</label>--}}
                    {{--</div>--}}
                    {{--<div class="dsBlock">--}}

                        {{--<label class="f16 lpf14">--}}
                            {{--<input type="radio" value="60,70" class="checkboxFilter mgr5 js_submit_input" name="profile"--}}
                                   {{--@if($profile_get == '60,70') checked @endif>--}}
                            {{--<span class="mgl5 dsInline">Từ 60 % - 70 % </span>--}}

                        {{--</label>--}}
                    {{--</div>--}}
                    {{--<div class="dsBlock">--}}

                        {{--<label class="f16 lpf14">--}}
                            {{--<input type="radio" value="70,100" class="checkboxFilter mgr5 js_submit_input"--}}
                                   {{--name="profile"--}}
                                   {{--@if($profile_get == '70,100') checked @endif>--}}
                            {{--<span class="mgl5 dsInline">Trên 70 %N </span>--}}

                        {{--</label>--}}
                    {{--</div>--}}

                    {{--<div class="">--}}
                        {{--<label class="f16 lpf14 fw6"><i class="fas fa-filter"></i> Trạng thái hồ sơ</label>--}}
                    {{--</div>--}}


                    {{--<div class="dsBlock">--}}


                        {{--<label class="f16 lpf14">--}}
                            {{--<input type="radio" value="0" class="checkboxFilter mgr5 js_submit_input" name="status"--}}
                                   {{--@if($status_get == '0') checked @endif>--}}
                            {{--<span class="mgl5 dsInline">Chưa đi làm </span>--}}

                        {{--</label>--}}
                    {{--</div>--}}
                    {{--<div class="dsBlock">--}}

                        {{--<label class="f16 lpf14">--}}
                            {{--<input type="radio" value="1" class="checkboxFilter mgr5 js_submit_input" name="status"--}}
                                   {{--@if($status_get == '1') checked @endif>--}}
                            {{--<span class="mgl5 dsInline">Đã đi làm</span>--}}

                        {{--</label>--}}
                    {{--</div>--}}

                    <div class="">
                        <label class="f16 lpf14 fw6"><i class="fas fa-filter"></i> Kinh nghiệm ứng viên</label>
                    </div>


                    <?php
                    $time_to_work_get = isset($_GET['time_to_work']) ? $_GET['time_to_work'] : '';
                    ?>
                    <div class="dsBlock">
                        <label class="f16 lpf14">
                            <input type="radio" value="1" class="checkboxFilter mgr5 js_submit_input"
                                   name="time_to_work"
                                   @if($time_to_work_get == '1') checked @endif>
                            <span class="mgl5 dsInline"> 1 năm kinh nghiệm</span>

                        </label>
                    </div>
                    <div class="dsBlock">
                        <label class="f16 lpf14">
                            <input type="radio" value="2" class="checkboxFilter mgr5 js_submit_input"
                                   name="time_to_work"
                                   @if($time_to_work_get == '2') checked @endif>
                            <span class="mgl5 dsInline"> 2 năm kinh nghiệm</span>

                        </label>
                    </div>
                    <div class="dsBlock">
                        <label class="f16 lpf14">
                            <input type="radio" value="3" class="checkboxFilter mgr5 js_submit_input"
                                   name="time_to_work"
                                   @if($time_to_work_get == '3') checked @endif>
                            <span class="mgl5 dsInline"> 3 năm kinh nghiệm</span>

                        </label>
                    </div>
                    <div class="dsBlock">
                        <label class="f16 lpf14">
                            <input type="radio" value="4" class="checkboxFilter mgr5 js_submit_input"
                                   name="time_to_work"
                                   @if($time_to_work_get == '4') checked @endif>
                            <span class="mgl5 dsInline"> 4 năm kinh nghiệm</span>

                        </label>
                    </div>
                    <div class="dsBlock"><label class="f16 lpf14">
                            <input type="radio" value="5" class="checkboxFilter mgr5 js_submit_input"
                                   name="time_to_work"
                                   @if($time_to_work_get == '5') checked @endif>
                            <span class="mgl5 dsInline"> 5 năm kinh nghiệm</span>

                        </label>
                    </div>
                    <div class="dsBlock"><label class="f16 lpf14">
                            <input type="radio" value="6" class="checkboxFilter mgr5 js_submit_input"
                                   name="time_to_work"
                                   @if($time_to_work_get == '6') checked @endif>
                            <span class="mgl5 dsInline">Trên  5 năm kinh nghiệm</span>

                        </label>
                    </div>
                    <hr>

                    <div class="dsBlock mgt10 js_sd_fixel_bottom js_remove_fixel" style="min-width: 300px">
                        <button type="submit" class="btn_submit_job_search_sidebar"
                                id="btnloading_frofile_search">Lọc ứng viên
                        </button>
                    </div>


                </form>

                <style>
                    .checkboxFilter {
                        width: 20px;
                        height: 20px;
                    }
                </style>
            </div>
        </div>
    </div>
</div>
