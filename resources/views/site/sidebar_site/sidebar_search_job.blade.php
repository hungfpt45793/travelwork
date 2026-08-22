<div class="dnav col-xl-3 col-lg-4 col-md-12 sidebar_job active_show_sidebar" id="js_toogle_sidebar">


    {{--<div id="dismiss">--}}
    {{--<i class="fas fa-arrow-left"></i>--}}
    {{--</div>--}}
    <div class="contentSidebar">
        <div class="sidebarFillter">
            <div class="box_header_sidebar text-left">
                <h5>
                    Tìm kiếm việc làm
                </h5>

                <form action="" method="get" class="formSearchSidebar" id="submitSidebar">
                    <?php
                    //thành phố
                    $p = isset($_GET['p']) ? $_GET['p'] : 0;
                    $provice = \App\Entity\Province::getId($p);
                    //quân /huyện
                    //                    $q = isset($_GET['q']) ? $_GET['q'] : 0;
                    //                    $district = \App\Entity\District::getId($q);

                    ?>
                    {{--<input type="hidden" name="p" value="{{ $p }}">--}}
                    {{--<input type="hidden" name="q" value="{{ $q }}">--}}

                    <div class="">
                        <label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i> Tìm theo thành phố</label>
                    </div>

                    <select class="select2" name="p" aria-label="Tỉnh/Thành phố" id="search_city">
                        <option value="0" selected> Tất cả tỉnh/thành phố</option>
                        <?php
                        $getAllProvince = \App\Entity\Province::GetAllProvinces();
                        ?>
                        @foreach($getAllProvince as $province)
                            <option @if($province->province_id == $p) selected
                                    @endif value="{{$province->province_id}}">{{$province->province_name}}</option>
                        @endforeach
                    </select>
                    <hr>
                    <div class="">
                        <label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i> Tìm theo quận/huyện</label>
                    </div>
                    <?php
                    $array_district_get = isset($_GET['district_id']) ? $_GET['district_id'] : array();
                    ?>

                    <select class="select2" name="district_id[]" multiple id="search_county">
                        @if(!empty($provice))
                            @foreach(\App\Entity\District::get_province_id($provice->province_id) as $district)
                                <option @if(in_array($district->district_id, $array_district_get)) selected @endif
                                value="{{$district->district_id}}">
                                    {{$district->district_name}}
                                </option>
                            @endforeach
                        @endif
                    </select>


                    <hr>

                    <div class="">
                        <label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i> Tìm theo ngành nghề</label>
                    </div>


                        <?php $career_get = isset($_GET['c']) ? $_GET['c'] : '';?>
                        <select class=" select2"
                                name="c">
                            <option value="0" selected>Tất cả ngành nghề</option>
                            @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                <option value="{{$career->career_category_id}}"
                                        @if($career->career_category_id == $career_get) selected @endif>{{$career->career_category_name}}</option>
                            @endforeach
                        </select>


                    <hr>
                    <div class="">
                        <label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i> Tìm theo mức lương</label>
                    </div>

                    <?php
                    $array_salary_get = isset($_GET['array_salary']) ? $_GET['array_salary'] : array()
                    ?>
                    @foreach(\App\Entity\Salary::showAllSalaryStatus() as $salary)
                        <div class="dsBlock">

                            <label class="f16 lpf14 js_submit_input">
                                <input type="checkbox" value="{{$salary->salary_id}}" class="checkboxFilter mgr5 "
                                       name="array_salary[]"
                                       @if(in_array($salary->salary_id, $array_salary_get)) checked @endif >
                                <span class="mgl5 dsInline">{{$salary->description}}</span>

                            </label>

                        </div>
                    @endforeach


                    <hr>

                    <?php
                    // Lấy ngày hiện tại
                    $today = date('Y-m-d');
                    //                        Ngày hôm qua
                    $yesterday = strtotime(date("Y-m-d", strtotime($today)) . " - 1 day");
                    $yesterday = strftime("%Y-%m-%d", $yesterday);

                    //                       3 ngày qua
                    $three_day = strtotime(date("Y-m-d", strtotime($today)) . " - 3 day");
                    $three_day = strftime("%Y-%m-%d", $three_day);

                    // Tuần qua
                    $last_week = strtotime(date("Y-m-d", strtotime($today)) . " - 1 week");
                    $last_week = strftime("%Y-%m-%d", $last_week);

                    // tháng qua
                    $last_month = strtotime(date("Y-m-d", strtotime($today)) . " -1 month");
                    $last_month = strftime("%Y-%m-%d", $last_month);

                    ?>

                    <?php $date_create_get = isset($_GET['date_create']) ? $_GET['date_create'] : ''?>
                    <div class="">
                        <label class="f16 lpf14 fw6"><i class="fas fa-filter"></i> Tìm theo ngày đăng tin</label>
                    </div>

                    <div class="dsBlock">

                        <label class="f16 lpf14 js_submit_input">
                            <input type="radio" value="0" class="checkboxFilter mgr5" name="date_create"
                                   data_date_create="0"
                                   @if($date_create_get == '0') checked @endif >
                            <span class="mgl5 dsInline">Tất cả</span>


                        </label>

                    </div>
                    <div class="dsBlock">

                        <label class="f16 lpf14 js_submit_input">
                            <input type="radio" value="{{ $yesterday }}" class="checkboxFilter mgr5 " name="date_create"
                                   data_date_create="1"
                                   @if($date_create_get == $yesterday) checked @endif>
                            <span class="mgl5 dsInline">Ngày qua</span>
                        </label>

                    </div>
                    <div class="dsBlock">

                        <label class="f16 lpf14 js_submit_input">
                            <input type="radio" value="{{ $three_day }}" class="checkboxFilter mgr5 " name="date_create"
                                   data_date_create="3"
                                   @if($date_create_get == $three_day) checked @endif>
                            <span class="mgl5 dsInline">3 ngày qua</span>
                        </label>

                    </div>
                    <div class="dsBlock">
                        <label class="f16 lpf14">
                            <input type="radio" value="{{ $last_week }}" class="checkboxFilter mgr5 js_submit_input"
                                   name="date_create" data_date_create="7"
                                   @if($date_create_get == $last_week) checked @endif>
                            <span class="mgl5 dsInline">Tuần qua</span>
                        </label>

                    </div>
                    <div class="dsBlock">

                        <label class="f16 lpf14">
                            <input type="radio" value="{{ $last_month }}" class="checkboxFilter mgr5 js_submit_input"
                                   name="date_create" data_date_create="30"
                                   @if($date_create_get == $last_month) checked @endif>
                            <span class="mgl5 dsInline">Tháng qua </span>
                        </label>

                    </div>
                    @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 )
                        <label class="f14 lpf14 clred">
                            <?php
                            $save_fillter_job_get = isset($_GET['save_fillter_job']) ? $_GET['save_fillter_job'] : '';
                            ?>
                            <input type="checkbox" value="1" class="checkboxFilter mgr5 js_submit_input"
                                   name="save_fillter_job" style="width: 15px;height: 15px"
                                   @if($save_fillter_job_get == 1) checked @endif >
                            Lưu vào tủ hồ sơ trong việc làm mong muốn
                        </label>
                    @endif

                    <hr>

                    <div class="">
                        <label class="f16 lpf14 fw6"><i class="fas fa-filter"></i> Tin Víp</label>
                    </div>

                    <div class="dsBlock">

                        <?php
                        $vip_get = isset($_GET['v']) ? $_GET['v'] : '';
                        ?>

                        <select class="select2" name="vip">
                            <option value="" @if($vip_get == '') selected @endif>Tất cả tin</option>
                            <option @if($vip_get == '0') selected @endif  value="0">Tin thường</option>
                            <option @if($vip_get == '1') selected
                                    @endif  value="1">Tin vip
                            </option>
                        </select>
                    </div>
                    <hr>
                    <div class="">
                        <label class="f16 lpf14 fw6"><i class="fas fa-filter"></i> Tìm theo tên</label>
                    </div>

                    <div class="dsBlock">
                        <?php $word_get = isset($_GET['w']) ? $_GET['w'] : '';?>
                        <input class="input_s_word" type="text" name="word" style="width: 100%"
                               placeholder="Nhập tiêu đề công việc..." value="{{ $word_get }}">
                    </div>


                    <hr>


                        <div class="dsBlock mgt10 js_sd_fixel_bottom js_remove_fixel" style="min-width: 300px">
                            <button type="submit" class="btn_submit_job_search_sidebar" id="btnloading_frofile">Lọc việc làm </button>
                        </div>




                </form>


                <script>
                    $('input[type=checkbox]').click(function () {
                        $('#submitSidebar').submit();
                    });
                    $('input[type=radio]').click(function () {
                        $('#submitSidebar').submit();
                    });
                    $('#btnloading_frofile').click(function () {
                        $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lọc việc làm...');
                        $btn.attr('disabled', false);
                    });
                </script>

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