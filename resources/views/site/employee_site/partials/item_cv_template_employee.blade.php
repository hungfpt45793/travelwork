<link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/web/css/box_item_cv.css"/>
<link rel="stylesheet" href="{{ asset('employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/cv.css"type="text/css">

<div class="box_item_cv" id="">
    <?php
    $cv_employee = \App\Entity\Cv_employee::select('*')->where('employee_id', $employee->employee_id)->first();
    ?>
    @if(!empty($cv_employee))
        <?php
            $check_cv_employee = '';
            $check_cv_employee = \App\Entity\Cv_employee::check_cv_employee($employee->employee_id);
            ?>
    <div class="box_item_cv_content">
        <div class="box_cv_left bg_cv_home">
            <div class="box_cv_image">
                <img class="lazy" data-src="{{ $employee->employee_image }}" alt="">
            </div>
            <div class="box_cv_info item_content_left">
                <div class="item_cv_info bg_cv_info cl_cv_info text-center cv_info_input">
                    @if(!empty($check_show_employee)){{!empty($employee->email) ? $employee->email : ''  }}@else ********* @endif
                </div>
                <div class="item_cv_info bg_cv_info cl_cv_info text-center cv_info_input">
                    {{--//phone--}}
                    @if(!empty($check_show_employee)){{!empty($employee->phone) ? $employee->phone : ''  }} @else ********* @endif
                </div>
                <div class="item_cv_info bg_cv_info cl_cv_info text-center cv_info_input">
                    <?php
                    $date = '';
                    $date = date_create($employee->birthday);
                    ?>
                    {{ !empty($date) ? date_format($date,"d/m/Y") : '' }}
                </div>
                <div class="item_cv_info item_cv_info item_cv_info_textare bg_cv_info cl_cv_textarea">
                    <textarea disabled>{{!empty($employee->address) ? $employee->address : ''  }}</textarea>
                </div>
                <div class="item_cv_info item_cv_info item_cv_info_textare bg_cv_info cl_cv_textarea item_cv_link">
                    <textarea disabled>@if(!empty($check_show_employee)){{ isset($employee->my_facebook) ? $employee->my_facebook : '' }}@else ********* @endif</textarea>

                </div>
            </div>
            <?php
            $order_left = array();
            $order_left = explode(',', '0,1,2,3,4,5,6,7,8,9,10');
            if(!empty($cv_employee->cv_order))
                {
                    $order_left = explode(',', $cv_employee->cv_order);
                }
            $show_hidden_left = array();
            $show_hidden_left = explode(',', '0,1,2,3,4,5,6,7,8,9,10');
            if(!empty($cv_employee->show_hidden_cv_order))
                {
                    $show_hidden_left = explode(',', $cv_employee->show_hidden_cv_order);
                }




            ?>
            @foreach($order_left as $or_left)
                @if($or_left == 1)
                    <div class="item_content_left box_career_goals" @if(!empty($show_hidden_left[0])) style="display: none" @endif>
                        <div class="title_content_left title_career">
                            <h2 class="cl_box_title_left">{{!empty($cv_employee->cv_title_career_goals) ? $cv_employee->cv_title_career_goals : 'Mục tiêu nghề nghiệp' }}</h2>
                        </div>
                        <div class="content_content_left cl_box_content_left content_career">
                            <textarea class="left_content_textarea" disabled>{{!empty($cv_employee->cv_career_goals) ? $cv_employee->cv_career_goals : '' }}</textarea>
                        </div>
                    </div>
                @endif
                @if($or_left == 2)
                    <div class="item_content_left box_career_goals" @if(!empty($show_hidden_left[1])) style="display: none" @endif>
                        <div class="title_content_left title_career">
                            <h2 class="cl_box_title_left">{{!empty($cv_employee->title_cv_skills) ? $cv_employee->title_cv_skills : 'Kỹ năng' }}</h2>
                        </div>
                        <div class="content_content_left_skill content_content_left cl_box_content_left content_career">
                            <?php
                            $list_cv_skill = \App\Entity\Cv_skills::get_cv_id($cv_employee->cv_id);
                            ?>
                            @if(!empty($list_cv_skill))
                                @foreach($list_cv_skill as $id_skill=>$skill)
                                    <div class="box_item_skill">
                                        <label>{{ !empty($skill->cv_skill_title) ? $skill->cv_skill_title : '' }}</label>
                                        <div class="bar-exp">
                                            <div style="width: {{ !empty($skill->cv_skill_value) ? $skill->cv_skill_value : '50' }}%"></div>
                                        </div>
                                    </div>

                                @endforeach
                            @endif

                        </div>
                    </div>
                @endif
                @if($or_left == 3)
                    <div class="item_content_left box_career_goals " @if(!empty($show_hidden_left[2])) style="display: none" @endif>
                        <div class="title_content_left title_career">
                            <h2 class="cl_box_title_left">{{!empty($cv_employee->cv_title_prize) ? $cv_employee->cv_title_prize : 'Giải thưởng' }}</h2>
                        </div>
                        <div class="content_content_left cl_box_content_left content_career">
                            <textarea disabled class="left_content_textarea">{{!empty($cv_employee->cv_prize) ? $cv_employee->cv_prize : '' }}</textarea>
                        </div>
                    </div>
                @endif
                @if($or_left == 4)
                    <div class="item_content_left box_career_goals " @if(!empty($show_hidden_left[3])) style="display: none" @endif>
                        <div class="title_content_left title_career">
                            <h2 class="cl_box_title_left">{{!empty($cv_employee->cv_title_card) ? $cv_employee->cv_title_card : 'Chứng chỉ' }}</h2>
                        </div>
                        <div class="content_content_left cl_box_content_left content_career">
                            <textarea disabled class="left_content_textarea">{{!empty($cv_employee->cv_card) ? $cv_employee->cv_card : '' }}</textarea>
                        </div>
                    </div>
                @endif
                @if($or_left == 5)
                    <div class="item_content_left box_career_goals " @if(!empty($show_hidden_left[4])) style="display: none" @endif>
                        <div class="title_content_left title_career">
                            <h2 class="cl_box_title_left">{{!empty($cv_employee->cv_title_interests) ? $cv_employee->cv_title_interests : 'Sở thích' }}</h2>
                        </div>
                        <div class="content_content_left cl_box_content_left content_career">
                            <textarea disabled class="left_content_textarea">{{!empty($cv_employee->cv_interests) ? $cv_employee->cv_interests : '' }}</textarea>
                        </div>
                    </div>
                @endif
                @if($or_left == 6)
                    <div class="item_content_left box_career_goals " @if(!empty($show_hidden_left[5])) style="display: none" @endif>
                        <div class="title_content_left title_career">
                            <h2 class="cl_box_title_left">{{!empty($cv_employee->cv_title_reference_person) ? $cv_employee->cv_title_reference_person : 'Người tham chiếu' }}</h2>
                        </div>
                        <div class="content_content_left cl_box_content_left content_career">
                            <textarea disabled class="left_content_textarea">{{!empty($cv_employee->cv_reference_person) ? $cv_employee->cv_reference_person : '' }}</textarea>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="box_cv_right bg_cv_home" >
            <div class="pd_box_cv_right">

                <div class="box_cv_right_header">
                    <h1 class="cl_cv_name">
                        {{ !empty($employee->employee_name) ? $employee->employee_name : '' }}
                    </h1>
                    <div class="cv_right_career">
                        <?php
                        $career_category_name = '';
                        $list_career = \App\Entity\Employee_career_categories::get_array_name($employee->employee_id);
                        if (!empty($list_career)) {
                            foreach ($list_career as $id => $career) {
                                if ($id == 0) {
                                    $career_category_name = $career->career_category_name;
                                } else {
                                    $career_category_name .= ' | ' . $career->career_category_name;
                                }
                            }
                        }
                        ?>
                        <div class="cv-profile-job">
                            @foreach($list_career as $career)
                                <p style="font-size: 15px;
    margin-bottom: 5px;"> - {{ $career->career_category_name }}</p>
                                @endforeach
                        </div>
                            {{--<textarea id="cv-profile-job" name="cv_title_job" readonly--}}
                                      {{--contenteditable="true"--}}
                                      {{--placeholder="Vị trí công việc bạn muốn ứng tuyển" >@foreach($list_career as $career)--}}
                                    {{--- {{ $career->career_category_name }}--}}
                                {{--@endforeach </textarea>--}}
                        {{--<textarea id="cv-profile-job" name="cv_title_job" readonly contenteditable="true"  placeholder="Vị trí công việc bạn muốn ứng tuyển">--}}
                            {{--@foreach($list_career as $career)--}}
                                {{--- {{ $career->career_category_name }}--}}
                            {{--@endforeach--}}
                        {{--</textarea>--}}
                    </div>
                </div>
                <div class="box_cv_right_content">

                    <?php
                    $order_right = array();
                    $order_right = explode(',', $cv_employee->cv_order_join);
                    $show_hidden_right = array();
                    $show_hidden_right = explode(',', $cv_employee->show_hidden_cv_order_join);
                    ?>

                    @foreach($order_right as $or_right)
                        @if($or_right == 1)
                            <div class="box_cv_right_item" @if(!empty($show_hidden_right[0])) style="display: none" @endif>
                                <div class="box_cv_right_title">
                                    {{ !empty($cv_employee->title_cv_specialize) ? $cv_employee->title_cv_specialize : 'Trình độ học vấn' }}
                                </div>
                                <?php
                                $list_cv_spe = \App\Entity\Cv_specialize::get_cv_id($cv_employee->cv_id);
                                ?>
                                @if(!empty($list_cv_spe))
                                    @foreach($list_cv_spe as $id_spec=>$spec)
                                        <div class="box_cv_right_des">
                                            <div class="box_cv_right_company">
                                                {{ !empty($spec->cv_spec_title) ? $spec->cv_spec_title : 'Tên trường học' }}
                                            </div>
                                            <div class="box_cv_right_positon">
                                                {{ !empty($spec->cv_spec_name) ? $spec->cv_spec_name : 'Chuyên ngành' }}
                                            </div>
                                            <div class="box_cv_right_textarea">
                                                <textarea disabled>{{ !empty($spec->cv_spec_desc) ? $spec->cv_spec_desc : 'Mô tả chi tiết trong quá trình học làm việc.' }}</textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                        @if($or_right == 2)
                            <div class="box_cv_right_item" @if(!empty($show_hidden_right[1])) style="display: none" @endif>
                                <div class="box_cv_right_title">
                                    {{ !empty($cv_employee->title_cv_experience) ? $cv_employee->title_cv_experience : 'Kinh nghiệm làm việc' }}
                                </div>
                                <?php
                                $list_cv_ex = \App\Entity\Cv_experience::get_cv_id($cv_employee->cv_id);
                                ?>
                                @if(!empty($list_cv_ex))
                                    @foreach($list_cv_ex as $id_ex=>$ex)
                                        <div class="box_cv_right_des">
                                            <div class="box_cv_right_company">
                                                {{ !empty($ex->cv_ex_title) ? $ex->cv_ex_title : 'Tên công ty' }}
                                            </div>
                                            <div class="box_cv_right_positon">
                                                {{ !empty($ex->cv_ex_name) ? $ex->cv_ex_name : 'Vị trí công việ' }}
                                            </div>
                                            <div class="box_cv_right_textarea">
                                                <textarea disabled>{{ !empty($ex->cv_ex_desc) ? $ex->cv_ex_desc : 'Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.' }}</textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                        @if($or_right == 3)
                            <div class="box_cv_right_item" @if(!empty($show_hidden_right[2])) style="display: none" @endif>
                                <div class="box_cv_right_title">
                                    {{ !empty($cv_employee->title_cv_work) ? $cv_employee->title_cv_work : 'Hoạt động' }}
                                </div>
                                <?php
                                $list_cv_work = \App\Entity\Cv_work::get_cv_id($cv_employee->cv_id);
                                ?>
                                @if(!empty($list_cv_work))
                                    @foreach($list_cv_work as $id_work=>$work)
                                        <div class="box_cv_right_des">
                                            <div class="box_cv_right_company">
                                                {{ !empty($work->cv_work_title) ? $work->cv_work_title : 'Tên hoạt động' }}
                                            </div>
                                            <div class="box_cv_right_positon">
                                                {{ !empty($work->cv_work_name) ? $work->cv_work_name : 'Vị trí hoạt động' }}
                                            </div>
                                            <div class="box_cv_right_textarea">
                                                <textarea disabled>{{ !empty($work->cv_work_desc) ? $work->cv_work_desc : 'Mô tả hoạt động' }}</textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                        @if($or_right == 4)
                            <div class="box_cv_right_item" @if(!empty($show_hidden_right[3])) style="display: none" @endif>
                                <div class="box_cv_right_title">
                                    {{ !empty($cv_employee->title_cv_project) ? $cv_employee->title_cv_project : 'Dự án tham gia' }}
                                </div>
                                <?php
                                $list_cv_project = \App\Entity\Cv_project::get_cv_id($cv_employee->cv_id);
                                ?>
                                @if(!empty($list_cv_project))
                                    @foreach($list_cv_project as $id_project=>$project)
                                        <div class="box_cv_right_des">
                                            <div class="box_cv_right_company">
                                                {{ !empty($project->cv_project_title) ? $project->cv_project_title : 'Tên công ty' }}
                                            </div>
                                            <div class="box_cv_right_positon">
                                                {{ !empty($project->cv_project_name) ? $project->cv_project_name : 'Tên dự án' }}
                                            </div>
                                            <div class="box_cv_right_textarea">
                                                <textarea disabled>{{ !empty($project->cv_project_des) ? $project->cv_project_des : 'Mô tả dự án' }}</textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                        @if($or_right == 5)
                            <div class="box_cv_right_item" @if(!empty($show_hidden_right[4])) style="display: none" @endif>
                                <div class="box_cv_right_title">
                                    {{ !empty($cv_employee->title_cv_info) ? $cv_employee->title_cv_info : 'Thông tin thêm' }}
                                </div>
                                <?php
                                $list_cv_info = \App\Entity\Cv_info::get_cv_id($cv_employee->cv_id);
                                ?>
                                @if(!empty($list_cv_info))
                                    @foreach($list_cv_info as $id_info=>$info)
                                        <div class="box_cv_right_des">
                                            <div class="box_cv_right_company">
                                                {{ !empty($info->cv_info_title) ? $info->cv_info_title : 'Tên công ty' }}
                                            </div>
                                            <div class="box_cv_right_positon">
                                                {{ !empty($info->cv_info_name) ? $info->cv_info_name : 'Vị trí làm việc' }}
                                            </div>
                                            <div class="box_cv_right_textarea">
                                                <textarea disabled>{{ !empty($info->cv_info_des) ? $info->cv_info_des : 'Mô tả quá trình' }}</textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                    @endforeach


                </div>
            </div>
        </div>
    </div>
        @else
            <div class="box_item_cv_content">
                <h3 class="text-center" style="color: red">Không tìm thấy CV</h3>
            </div>
    @endif
</div>
@if(!empty($cv_employee))
<style>
    .content_content_left .left_content_textarea
    {
        color: #fff !important;
    }
</style>
<script>
        <?php
        $color = \App\Entity\Cv_color::get_cv_color_id($cv_employee->cv_color);
        $list_color_cv = array();
        $list_color_cv = explode(',', $color['order_color']);
        //            echo $color['order_color'];
        //            echo '<pre>';
        //            print_r($list_color_cv);die();
        ?>
    var cl_cv_1 = '{{ $list_color_cv[0] }}';
    var cl_cv_2 = '{{ $list_color_cv[1] }}';
    var cl_cv_3 = '{{ $list_color_cv[2] }}';
    var cl_cv_4 = '{{ $list_color_cv[3] }}';
    var cl_cv_5 = '{{ $list_color_cv[4] }}';
    var cl_cv_6 = '{{ $list_color_cv[5] }}';

    // $('.js_height_cv').height();
    $('.box_item_cv textarea').each(function () {
        this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
    }).on('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });



    $('.box_item_cv_content').css('border', 'solid 1px' + cl_cv_1);
    $('.bg_cv_home').css('background', cl_cv_1);
    $('.cl_cv_name').css('color', cl_cv_2);
    $('.box_cv_right_title').css('background-color', cl_cv_4);
    $('.box_cv_right_title').css('color', cl_cv_5);
    $('.cl_box_title_left').css('color', cl_cv_2);

    $('.left_content_textarea').css('color', cl_cv_6 + '!important');
    // $('.left_content_textarea').style('color', cl_cv_6);
    $('.box_item_skill label').css('color', cl_cv_6);

    $('#cv-profile-job').css('color', cl_cv_3);
</script>
@endif