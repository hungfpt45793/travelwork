<div class="col-xl-3 col-lg-4 col-md-12 dsmbNone sidebar_show_hidden" id="js_toogle_sidebar">
    <div id="dismiss">
        <i class="fas fa-arrow-left"></i>
    </div>
    <div class="contentSidebar bg-white pdTop20 pdBottom20">


        <div class="sidebarFillter">
            <div class="fillterJobSubmit text-left">
                <h5 class="lt-f18 fw6 f20 bdLeftBlueN5x pdl10 blueN mgb20">
                    Tìm kiếm việc làm
                </h5>

                <form action="" method="get" class="formSearchSidebar" id="submitSidebar">
                    <?php
                    //thành phố
                    $p = isset($_GET['p']) ? $_GET['p'] : 0;
                    $provice = \App\Entity\Province::getId($p);
                    //quân /huyện
                    $q = isset($_GET['q']) ? $_GET['q'] : 0;
                    $district = \App\Entity\District::getId($q);

                    ?>
                    <input type="hidden" name="p" value="{{ $p }}">
                    <input type="hidden" name="q" value="{{ $q }}">


                    <div class="">
                        <label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i> Tìm theo ngành nghề</label>
                    </div>

                    <?php $array_career_get = isset($_GET['array_career']) ? $_GET['array_career'] : array()?>
                    @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                        <div class="dsBlock">
                            <?php
                            $total_career = 0;
                            $total_career_job = \App\Entity\Job::get_total_career_province_id($career->career_category_id,$p,$q);
                            $total_career_job_facebook = \App\Entity\JobFacebook::get_total_career_province($career->career_category_id,$p,$q);
                            $total_career = $total_career_job + $total_career_job_facebook;
                            ?>
                            <label class="f16 lpf14 js_submit_input">
                                <input type="checkbox" value="{{$career->career_category_id}}" class="checkboxFilter mgr5 " name="array_career[]"  @if(in_array($career->career_category_id, $array_career_get)) checked @endif>
                                <span class="mgl5 dsInline">{{$career->career_category_name}}</span>


                                    <sup class="clHome">({{ $total_career }})</sup>

                            </label>

                        </div>
                    @endforeach
                    <hr>
                    <div class="">
                        <label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i> Tìm theo mức lương</label>
                    </div>

                        <?php
                        $array_salary_get = isset($_GET['array_salary']) ? $_GET['array_salary'] : array()
                        ?>
                    @foreach(\App\Entity\Salary::showAllSalary() as $salary)
                        <div class="dsBlock">
                            <?php
                            $total_salary = 0;
                            $total_salary_job = \App\Entity\Job::get_total_salary_id($salary->salary_id,$p,$q);
                            $total_salary_job_facebook = \App\Entity\JobFacebook::get_total_salary_id($salary->salary_id,$p,$q);
                            $total_salary = $total_salary_job + $total_salary_job_facebook;
                            ?>
                            <label class="f16 lpf14 js_submit_input">
                                <input type="checkbox" value="{{$salary->salary_id}}" class="checkboxFilter mgr5 " name="array_salary[]"
                                @if(in_array($salary->salary_id, $array_salary_get)) checked @endif     >
                                <span class="mgl5 dsInline">{{$salary->description}}</span>


                                <sup class="clHome">({{ $total_salary }})</sup>

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
                    <?php
                        $total_date_all = '';
                        $total_date_all_job = \App\Entity\Job::get_total_date(0,$p,$q);
                        $total_date_all_job_fb = \App\Entity\JobFacebook::get_total_date(0,$p,$q);
                       $total_date_all = $total_date_all_job + $total_date_all_job_fb;
                        ?>
                        <label class="f16 lpf14 js_submit_input">
                            <input type="radio" value="0" class="checkboxFilter mgr5" name="date_create" data_date_create="0"
                                   @if($date_create_get == '0') checked @endif >
                            <span class="mgl5 dsInline">Tất cả</span>


                            <sup class="clHome">({{ $total_date_all }})</sup>

                        </label>

                    </div>
                    <div class="dsBlock">
                        <?php
                        $total_date = 0;
                        $total_yesterday_job = \App\Entity\Job::get_total_date($yesterday,$p,$q);
                        $total_yesterday_job_fb = \App\Entity\JobFacebook::get_total_date($yesterday,$p,$q);
                        $total_date = $total_yesterday_job + $total_yesterday_job_fb;
//                        $total_salary_job_facebook = \App\Entity\JobFacebook::get_total_salary_id($salary->salary_id,$p,$q);
//                        $total_salary = $total_salary_job + $total_salary_job_facebook;
                        ?>
                        <label class="f16 lpf14 js_submit_input">
                            <input type="radio" value="{{ $yesterday }}" class="checkboxFilter mgr5 " name="date_create" data_date_create="1"
                                   @if($date_create_get == $yesterday) checked @endif>
                            <span class="mgl5 dsInline">Ngày qua</span>
                            <sup class="clHome">({{ $total_date }})</sup>
                        </label>

                    </div>
                    <div class="dsBlock">
                    <?php
                        $total_three = 0;
                        $total_three_job = \App\Entity\Job::get_total_date($three_day,$p,$q);
                        $total_three_job_fb = \App\Entity\JobFacebook::get_total_date($three_day,$p,$q);
                        $total_three = $total_three_job + $total_three_job_fb;
                        ?>
                        <label class="f16 lpf14 js_submit_input">
                            <input type="radio" value="{{ $three_day }}" class="checkboxFilter mgr5 " name="date_create" data_date_create="3"
                                   @if($date_create_get == $three_day) checked @endif>
                            <span class="mgl5 dsInline">3 ngày qua</span>
                            <sup class="clHome">({{ $total_three }})</sup>
                        </label>

                    </div>
                    <div class="dsBlock">
                        <?php
                        $total_last_week = 0;
                        $total_last_week_job = \App\Entity\Job::get_total_date($last_week,$p,$q);
                        $total_last_week_job_fb = \App\Entity\JobFacebook::get_total_date($last_week,$p,$q);
                       $total_last_week = $total_last_week_job + $total_last_week_job_fb;
                        ?>
                        <label class="f16 lpf14">
                            <input type="radio" value="{{ $last_week }}" class="checkboxFilter mgr5 js_submit_input" name="date_create"   data_date_create="7"
                                   @if($date_create_get == $last_week) checked @endif>
                            <span class="mgl5 dsInline">Tuần qua</span>
                            <sup class="clHome">({{ $total_last_week }})</sup>
                        </label>

                    </div>
                    <div class="dsBlock">
                        <?php
                        $total_last_month = 0;
                        $total_last_month_job = \App\Entity\Job::get_total_date($last_month,$p,$q);
                        $total_last_month_job_fb = \App\Entity\JobFacebook::get_total_date($last_month,$p,$q);
                       $total_last_month = $total_last_month_job + $total_last_month_job_fb;
                        ?>
                        <label class="f16 lpf14">
                            <input type="radio" value="{{ $last_month }}" class="checkboxFilter mgr5 js_submit_input" name="date_create" data_date_create="30"
                                   @if($date_create_get == $last_month) checked @endif>
                            <span class="mgl5 dsInline">Tháng qua </span>
                            <sup class="clHome">({{ $total_last_month }})</sup>
                        </label>

                    </div>
                        @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 )
                        <label class="f14 lpf14 clred">
                            <?php
                            $save_fillter_job_get = isset($_GET['save_fillter_job']) ? $_GET['save_fillter_job'] : '';
                            ?>
                            <input type="checkbox" value="1" class="checkboxFilter mgr5 js_submit_input" name="save_fillter_job" style="width: 15px;height: 15px" @if($save_fillter_job_get == 1) checked @endif >
                            Lưu vào tủ hồ sơ trong việc làm mong muốn
                        </label>
                        @endif

                        <div class="dsBlock mgt10">
                            <button type="submit" class="btnGreen" style="display: block;width: 100%;padding: 5px"
                                    id="btnloading_frofile">Lọc việc làm
                            </button>
                        </div>



                </form>


                <script>
                    $('input[type=checkbox]').click(function (){
                        $('#submitSidebar').submit();
                    });
                    $('input[type=radio]').click(function (){
                        $('#submitSidebar').submit();
                    });
                    $('#btnloading_frofile').click(function () {
                        $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lọc việc làm...');
                        $btn.attr('disabled', false);
                    });
                    // $('.').iCheck({
                    //     checkboxClass: 'icheckbox_square-red',
                    //     radioClass: 'iradio_square-red',
                    //     increaseArea: '20%' // optional
                    // });

                </script>
                <style>
                    .checkboxFilter
                    {
                        width: 20px;
                        height: 20px;
                    }
                </style>
            </div>
        </div>
    </div>
</div>