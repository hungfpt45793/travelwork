<div class="col-xl-3 col-lg-4 col-md-12 dsmbNone sidebar_show_hidden" id="js_toogle_sidebar">
    <div id="dismiss">
        <i class="fas fa-arrow-left"></i>
    </div>
    <div class="contentSidebar bg-white pdTop20 pdBottom20">


        <div class="sidebarFillter">
            <div class="fillterJobSubmit text-left">
                <h5 class="lt-f18 fw6 f20 bdLeftBlueN5x pdl10 blueN mgb20">
                    Tìm kiếm ứng viên
                </h5>

                <form action="{{ route('search_employee') }}" method="get" class="formSearchSidebar" id="submitSidebar">
                    <?php
                    //thành phố
                    $provice = isset($_GET['province']) ? $_GET['province'] : 0;
                    //                    $provice = \App\Entity\Province::getId($p);
                    //quân /huyện
                    $district = isset($_GET['district']) ? $_GET['district'] : 0;
                    //                    $district = \App\Entity\District::getId($q);

                    $array_career_get = isset($_GET['array_career']) ? $_GET['array_career'] : array();
                    $array_salary_get = isset($_GET['array_salary']) ? $_GET['array_salary'] : array();
                    $profile_get = isset($_GET['profile']) ? $_GET['profile'] : '';
                    $status_get = isset($_GET['status']) ? $_GET['status'] : '';
                    ?>
                    <input type="hidden" name="province" value="{{ $provice }}">
                    <input type="hidden" name="district" value="{{ $district }}">


                    <div class="">
                        <label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i> Tìm theo ngành nghề</label>
                    </div>

                    @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                        <div class="dsBlock">
                            <?php
                            $total_career_employee = 0;
                            $total_career_employee = \App\Entity\Employee::get_total_career_province_id($provice, $district, $career->career_category_id, 0);
                            ?>
                            <label class="f16 lpf14 js_submit_input">
                                <input type="checkbox" value="{{$career->career_category_id}}"
                                       class="checkboxFilter mgr5 " name="array_career[]"
                                       @if(in_array($career->career_category_id, $array_career_get)) checked @endif>
                                <span class="mgl5 dsInline">{{$career->career_category_name}}</span>


                                <sup class="clHome">({{ $total_career_employee }})</sup>

                            </label>

                        </div>
                    @endforeach
                    <hr>
                    <div class="">
                        <label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i> Tìm theo mức lương</label>
                    </div>


                    @foreach(\App\Entity\Salary::showAllSalary() as $salary)
                        <div class="dsBlock">
                            <?php
                            $total_career_employee = 0;
                            $total_career_employee = \App\Entity\Employee::get_total_career_province_id($provice, $district, 0, $salary->salary_id);
                            ?>
                            <label class="f16 lpf14 js_submit_input">
                                <input type="checkbox" value="{{$salary->salary_id}}" class="checkboxFilter mgr5 "
                                       name="array_salary[]"
                                       @if(in_array($salary->salary_id, $array_salary_get)) checked @endif >
                                <span class="mgl5 dsInline">{{$salary->description}}</span>


                                <sup class="clHome">({{ $total_career_employee }})</sup>

                            </label>

                        </div>
                    @endforeach


                    <hr>


                    <div class="">
                        <label class="f16 lpf14 fw6"><i class="fas fa-filter"></i> Tìm theo tỉ lệ % hồ sơ</label>
                    </div>


                    <div class="dsBlock">

                        <?php
                        $total_profile30 = 0;
                        $total_profile30 = \App\Entity\Employee::get_total_frofile($provice, $district, '0,30');
                        ?>
                        <label class="f16 lpf14">
                            <input type="radio" value="0,30" class="checkboxFilter mgr5 js_submit_input" name="profile"
                                   @if($profile_get == '0,30') checked @endif>
                            <span class="mgl5 dsInline">Dưới 30% </span>
                            <sup class="clHome">({{ $total_profile30 }})</sup>
                        </label>
                    </div>
                    <div class="dsBlock">
                        <?php
                        $total_profile3050 = 0;
                        $total_profile3050 = \App\Entity\Employee::get_total_frofile($provice, $district, '30,50');
                        ?>
                        <label class="f16 lpf14">
                            <input type="radio" value="30,50" class="checkboxFilter mgr5 js_submit_input" name="profile"
                                   @if($profile_get == '30,50') checked @endif>
                            <span class="mgl5 dsInline">Từ 30% - 50% </span>
                            <sup class="clHome">({{ $total_profile3050 }})</sup>
                        </label>
                    </div>
                    <div class="dsBlock">
                        <?php
                        $total_profile5070 = 0;
                        $total_profile5070 = \App\Entity\Employee::get_total_frofile($provice, $district, '50,70');
                        ?>
                        <label class="f16 lpf14">
                            <input type="radio" value="50,70" class="checkboxFilter mgr5 js_submit_input" name="profile"
                                   @if($profile_get == '50,70') checked @endif>
                            <span class="mgl5 dsInline">Từ 50% - 70% </span>
                            <sup class="clHome">({{ $total_profile5070 }})</sup>
                        </label>
                    </div>
                    <div class="dsBlock">
                        <?php
                        $total_profile70100 = 0;
                        $total_profile70100 = \App\Entity\Employee::get_total_frofile($provice, $district, '70,100');
                        ?>
                        <label class="f16 lpf14">
                            <input type="radio" value="70,100" class="checkboxFilter mgr5 js_submit_input"
                                   name="profile"
                                   @if($profile_get == '70,100') checked @endif>
                            <span class="mgl5 dsInline">Trên 70% </span>
                            <sup class="clHome">({{ $total_profile70100 }})</sup>
                        </label>
                    </div>

                    <div class="">
                        <label class="f16 lpf14 fw6"><i class="fas fa-filter"></i> Trạng thái hồ sơ</label>
                    </div>


                    <div class="dsBlock">

                        <?php
                        $total_status0 = 0;
                        $total_status0 = \App\Entity\Employee::get_total_status($provice, $district, '0');
                        ?>
                        <label class="f16 lpf14">
                            <input type="radio" value="0" class="checkboxFilter mgr5 js_submit_input" name="status"
                                   @if($status_get == '0') checked @endif>
                            <span class="mgl5 dsInline">Chưa đi làm </span>
                            <sup class="clHome">({{ $total_status0 }})</sup>
                        </label>
                    </div>
                    <div class="dsBlock">
                        <?php
                        $total_status1 = 0;
                        $total_status1 = \App\Entity\Employee::get_total_status($provice, $district, '1');
                        ?>
                        <label class="f16 lpf14">
                            <input type="radio" value="1" class="checkboxFilter mgr5 js_submit_input" name="status"
                                   @if($status_get == '1') checked @endif>
                            <span class="mgl5 dsInline">Đã đi làm</span>
                            <sup class="clHome">({{ $total_status1 }})</sup>
                        </label>
                    </div>

                    <div class="">
                        <label class="f16 lpf14 fw6"><i class="fas fa-filter"></i> Kinh nghiệm ứng viên</label>
                    </div>


                    <?php
                    $time_to_work_get = isset($_GET['time_to_work']) ? $_GET['time_to_work'] : '';
                    ?>
                    <div class="dsBlock">
                        <label class="f16 lpf14">
                            <input type="radio" value="0" class="checkboxFilter mgr5 js_submit_input"
                                   name="time_to_work"
                                   @if($time_to_work_get == '0') checked @endif>
                            <span class="mgl5 dsInline">Dưới 1 năm kinh nghiệm</span>
                            <?php
                            $total_time_word_0 = 0;
                            $total_time_word_0 = \App\Entity\Employee::get_total_time_word($provice, $district,0);
                            ?>
                            <sup class="clHome">({{ $total_time_word_0 }})</sup>
                        </label>
                    </div>
                    <div class="dsBlock">
                        <label class="f16 lpf14">
                            <input type="radio" value="1" class="checkboxFilter mgr5 js_submit_input"
                                   name="time_to_work"
                                   @if($time_to_work_get == '1') checked @endif>
                            <span class="mgl5 dsInline"> 1 năm kinh nghiệm</span>
                            <?php
                            $total_time_word_1 = 0;
                            $total_time_word_1 = \App\Entity\Employee::get_total_time_word($provice, $district,1);
                            ?>
                            <sup class="clHome">({{ $total_time_word_1 }})</sup>
                        </label>
                    </div>
                    <div class="dsBlock">
                        <label class="f16 lpf14">
                            <input type="radio" value="2" class="checkboxFilter mgr5 js_submit_input"
                                   name="time_to_work"
                                   @if($time_to_work_get == '2') checked @endif>
                            <span class="mgl5 dsInline"> 2 năm kinh nghiệm</span>
                            <?php
                            $total_time_word_2 = 0;
                            $total_time_word_2 = \App\Entity\Employee::get_total_time_word($provice, $district,2);
                            ?>
                            <sup class="clHome">({{ $total_time_word_2 }})</sup>
                        </label>
                    </div>
                    <div class="dsBlock">
                        <label class="f16 lpf14">
                            <input type="radio" value="3" class="checkboxFilter mgr5 js_submit_input"
                                   name="time_to_work"
                                   @if($time_to_work_get == '3') checked @endif>
                            <span class="mgl5 dsInline"> 3 năm kinh nghiệm</span>
                            <?php
                            $total_time_word_3 = 0;
                            $total_time_word_3 = \App\Entity\Employee::get_total_time_word($provice, $district,3);
                            ?>
                            <sup class="clHome">({{ $total_time_word_3 }})</sup>
                        </label>
                    </div>
                    <div class="dsBlock">
                        <label class="f16 lpf14">
                            <input type="radio" value="4" class="checkboxFilter mgr5 js_submit_input"
                                   name="time_to_work"
                                   @if($time_to_work_get == '4') checked @endif>
                            <span class="mgl5 dsInline"> 4 năm kinh nghiệm</span>
                            <?php
                            $total_time_word_4 = 0;
                            $total_time_word_4 = \App\Entity\Employee::get_total_time_word($provice, $district,4);
                            ?>
                            <sup class="clHome">({{ $total_time_word_4 }})</sup>
                        </label>
                    </div>
                    <div class="dsBlock"><label class="f16 lpf14">
                            <input type="radio" value="5" class="checkboxFilter mgr5 js_submit_input"
                                   name="time_to_work"
                                   @if($time_to_work_get == '5') checked @endif>
                            <span class="mgl5 dsInline"> 5 năm kinh nghiệm</span>
                            <?php
                            $total_time_word_5 = 0;
                            $total_time_word_5 = \App\Entity\Employee::get_total_time_word($provice, $district,5);
                            ?>
                            <sup class="clHome">({{ $total_time_word_5 }})</sup>
                        </label>
                    </div>
                    <div class="dsBlock"><label class="f16 lpf14">
                            <input type="radio" value="6" class="checkboxFilter mgr5 js_submit_input"
                                   name="time_to_work"
                                   @if($time_to_work_get == '6') checked @endif>
                            <span class="mgl5 dsInline">Trên  5 năm kinh nghiệm</span>
                            <?php
                            $total_time_word_6 = 0;
                            $total_time_word_6 = \App\Entity\Employee::get_total_time_word($provice, $district,6);
                            ?>
                            <sup class="clHome">({{ $total_time_word_6 }})</sup>
                        </label>
                    </div>


                    <div class="dsBlock mgt10">
                        <button type="submit" class="btnGreen" style="display: block;width: 100%;padding: 5px"
                                id="btnloading_frofile">Lọc ứng viên
                        </button>
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
                    // $('.').iCheck({
                    //     checkboxClass: 'icheckbox_square-red',
                    //     radioClass: 'iradio_square-red',
                    //     increaseArea: '20%' // optional
                    // });

                </script>
                <style>
                    .checkboxFilter {
                        width: 20px;
                        height: 20px;
                        position: relative;
                        top: 5px;
                    }
                </style>
            </div>
        </div>
    </div>
</div>