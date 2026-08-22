<div class="col-md-12 bgrWhite show_info_employee">
    @if(session('suscess'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
             style="margin-top: 15px;width: 100%">
            <strong>{{ session('suscess') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('erorr'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert"
             style="margin-top: 15px;width: 100%">
            <strong>{{ session('erorr') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error_export'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert"
             style="margin-top: 15px;width: 100%">
            <strong>{{ session('error_export') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    @include('site.sidebar.item_coin_employer',['employer' => $employer])


</div>


<link rel="stylesheet" href="{{ asset('public/employee_cv') }}/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('public/employee_cv') }}/slick/slick.css" type="text/css">
<link rel="stylesheet" href="{{ asset('public/employee_cv') }}/slick/slick-theme.css" type="text/css">
<link rel="stylesheet" href="{{ asset('public/employee_cv') }}/style.css@v=57.css" type="text/css">
{{--<script src="{{ asset('public/employee_cv') }}/jquery.min.js"></script>--}}
<div id="btn-shadow"></div>
<style type="text/css">
    .none_in_hoso {
        display: none;
    }

    .blog-hd {
        display: table;
        width: 100%
    }

    #a {
        display: table;
        width: 100%
    }

    .menu_nncv .dm_more {
        z-index: 1;
    }

    #hoso-scroll {
        z-index: 0;
    }
</style>
<link rel="stylesheet" href="{{ asset('public/employee_cv') }}/roboto.css" type="text/css">
<link rel="stylesheet" href="{{ asset('public/employee_cv') }}/cvh.css" type="text/css">
<link rel="stylesheet" href="{{ asset('public/employee_cv') }}/cropper.css" type="text/css">

<link rel="stylesheet" href="{{ asset('public/employee_cv') }}/cuscv.css" type="text/css">


<script src="{{ asset('public/employee_cv') }}/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>



@if(\Illuminate\Support\Facades\Auth::user() && \Illuminate\Support\Facades\Auth::user()->role == 2)
    <?php
    $employer = \App\Entity\Employer::getIdUser(\Illuminate\Support\Facades\Auth::user()->id);
    $check_contact_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee->employee_id);
    ?>
@endif


    <section class="employer_export mgt10">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 bg-white text-center">
                    @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role ==2 )
                    <a  class="btnOrange mg10-0 d-sm-inline-block mgt10 mgb5 bdr3 dsInline" @if(!empty($check_contact_employee)) href="{{ route('employer_exportpdf_cv',['employee_id'=>$employee->employee_id]) }}" target="_blank" @else  href="#" @endif><i class="fas fa-download mgr5"></i> Tải CV</a>
                    <p class="mgb10"><i>Bạn phải xem thông tin liên hệ của ứng viên thì mới tải được CV</i></p>
                        @else
                        <a  class="btnOrange mg10-0 d-sm-inline-block mgt10 mgb5 bdr3 dsInline" href="#"><i class="fas fa-download mgr5"></i> Tải CV</a>
                        <p class="mgb10"><i>Bạn phải xem thông tin liên hệ của ứng viên thì mới tải được CV (bạn phải <a data-toggle="modal" class="fw6" data-target="#loginTiva">đăng nhập tài khoản nhà tuyển dụng</a> để xem thông tin liên hệ của ứng viên)</i></p>


                    @endif
                </div>
            </div>
        </div>
    </section>


<section class="create_cv_employee_container">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row sticky-top" id="cvo-toolbar1" style="z-index:0;display: none">
                    <div class="col-12">
                        <div class="toolbar-global-controls ">
                            <div class="ctr">

                                <div class="item" id="toolbar-color">
                                    <div class="title">Tông màu</div>
                                    <div class="options">
                                        <?php
                                        $cv_color = '';
                                        $cv_color = App\Entity\Cv_color::get_all($cv_template->cv_template_id);
                                        ?>
                                        @foreach($cv_color as $id_cl=>$color)
                                            <span class="color @if($color->cv_color_id == $cv_employee->cv_color) active @endif my_color_cv{{$id_cl + 1}}"
                                                  data_cl="{{ isset($color->cv_color_id) ? $color->cv_color_id : '' }}"
                                                  style="background-color:{{ isset($color->code_color) ? $color->code_color : '' }}"
                                                  data-color="{{ isset($color->code_color) ? $color->code_color : '' }}"><i
                                                        class="fa fa-check"></i></span>
                                            <input readonly type="radio" name="cv_color"
                                                   value="{{ isset($color->cv_color_id) ? $color->cv_color_id : '' }}"
                                                   @if($color->cv_color_id ==  $cv_employee->cv_color) checked
                                                   @endif id="checkked{{$color->cv_color_id }}"
                                                   style="display: none"
                                            >
                                        @endforeach
                                    </div>
                                </div>
                                <div class="item button" id="btn-edit-layout">
                                    <div class="title">Thêm mục</div>
                                    <i class="fa fa-plus-circle f24"></i>
                                </div>

                                <div class="show_hidden_employee_cv_desktop">
                                    <a class="btn_button_save mgt15 mgl10"
                                       href="{{ route('show_file_job_facebook') }}" style="background: red">
                                        <i class="fas fa-long-arrow-alt-left f26"
                                           style="vertical-align: middle;"></i><span> Quay Lại</span>
                                    </a>


                                    <button class="btn_button_save mgt15 mgl10" type="submit" id="" value="save"
                                            name="export">
											<span>Lưu CV
											</span>
                                        <i class="fa fa-floppy-o"></i>
                                    </button>

                                    <button class="btn_button_save mgt15 mgl10" type="submit" id=""
                                            value="save_next" name="export">
											<span>Lưu Và Tiếp Tục
											</span>
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </button>
                                    <button formtarget="_blank" type="submit" value="export" name="export"
                                            class="btn_button_save mgt15 mgl10">
											<span>Xuất CV
											</span>
                                        <i class="fas fa-file-export"></i>
                                    </button>

                                </div>
                                <div class="show_hidden_employee_cv_mobile">
                                    <a class="btn_button_save mgt15 mgl10"
                                       href="{{ route('show_file_job_facebook') }}" style="background: red">
                                        <i class="fas fa-long-arrow-alt-left f26"
                                           style="vertical-align: middle;"></i>
                                    </a>


                                    <button class="btn_button_save mgt15 mgl10" type="submit" id="" value="save"
                                            name="export">
                                        <i class="fas fa-download"></i>
                                    </button>

                                    <button class="btn_button_save mgt15 mgl10" type="submit" id=""
                                            value="save_next" name="export">

                                        <i class="fas fa-share"></i>
                                    </button>
                                    <button formtarget="_blank" type="submit" value="export" name="export"
                                            class="btn_button_save mgt15 mgl10">
                                        <i class="fas fa-file-export"></i>
                                    </button>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div style="width: 100%;overflow: auto" id="js_height_textarea">
                    <div class="blog-hd" id="page-taocv">
                        <div class="clr"></div>
                        <div id="cvo-toolbar">

                        </div>
                        <div class="ctr" id="scollProduct">
                            <!-- Giao dien mau thu-->
                            <link rel="stylesheet"
                                  href="{{ asset('public/employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/cv.css"
                                  type="text/css">
                            <link id="cv-color-css" rel="stylesheet"
                                  href="{{ asset('public/employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/colors/3a93a5.css@v=1.css"
                                  type="text/css">

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert"
                                     style="margin-top: 15px;width: 100%">
                                    <strong>{{ session('success') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                            @endif
                            @if(session('erorr'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert"
                                     style="margin-top: 15px;width: 100%">
                                    <strong>{{ session('erorr') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div id="page-cv" class="">
                                <input readonly type="hidden" name="cv_id" value="{{ $cv_employee->cv_id  }}">
                                <input readonly type="hidden" name="cv_template_id"
                                       value="{{ $cv_employee->cv_template_id  }}">
                                <input readonly type="hidden" name="cv_color_template" id="cv_color"
                                       value="{{ $cv_employee->cv_color  }}">
                                <input readonly id="cv-title" name="cv_title" class="non-printable" contenteditable=""
                                       cvo-validatable=""
                                       placeholder="Tiêu đề CV"
                                       value="{{!empty($cv_employee->cv_title) ? $cv_employee->cv_title : '' }}">
                                <div id="form-cv" class="">
                                    <div id="cv-top">
                                        <div id="cvo-profile">
                                            <div class="box-01">
                                                <div id="cvo-profile-avatar-wraper">
                                                    {{--<input readonly   type="button"--}}
                                                    {{--value="Chọn ảnh"--}}
                                                    {{--size="20" class="error_text_images"/>--}}
                                                    <img class="lazy"
                                                         data-src="{{ isset($cv_employee->cv_image) ? $cv_employee->cv_image : asset('public/assets/image/no_avatar.jpg') }}"
                                                         width="80" height=""/>

                                                </div>
                                                <div id="box-hvt" data_show="note_title_reference_person"
                                                     data_title="{{ 'Thông tin cá nhân' }}" class="js_click_box ">
                                                    <h1>
                                                        <span id="cv-profile-fullname">{{!empty($cv_employee->cv_name) ? $cv_employee->cv_name : '' }}</span>
                                                    </h1>
                                                    <h2>

                                                        <span id="cv-profile-job">{{!empty($cv_employee->cv_title_job) ? $cv_employee->cv_title_job : '' }}</span>
                                                    </h2>
                                                    <p><span id="cv-profile-about"></span></p>
                                                </div>
                                                <div class="clr"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="cv-main">
                                        <div id="cv-content">
                                            <div class="ir" id="sort_block">
                                                <?php
                                                $order_right = array();
                                                $order_right = explode(',', $cv_employee->cv_order_join);
                                                $show_hidden_right = array();
                                                $show_hidden_right = explode(',', $cv_employee->show_hidden_cv_order_join);
                                                ?>
                                                @foreach($order_right as $or_right)
                                                    @if($or_right == 1)
                                                        {{--trình độ học vấn--}}
                                                        <div id="block01" data_show="note_title_cv_specialize"
                                                             data_title="{{ !empty($cv_employee->title_cv_specialize) ? $cv_employee->title_cv_specialize : 'Trình độ học vấn' }}"
                                                             data_box="block01"
                                                             class="js_click_box cvo-block"
                                                             @if(!empty($show_hidden_right[0])) style="display: none" @endif >
                                                            <input readonly type="hidden" name="cv_order_join[]"
                                                                   value="1">
                                                            <input readonly type="hidden"
                                                                   name="show_hidden_cv_order_join[]"
                                                                   class="show_hidden_cv_order"
                                                                   @if(!empty($show_hidden_right[0])) value="1"
                                                                   @else value="0" @endif>

                                                            <p class="head">
                                                                <input readonly id="" class="block-title"
                                                                       placeholder="Tiêu đề mục lớn"

                                                                       value="{{ !empty($cv_employee->title_cv_specialize) ? $cv_employee->title_cv_specialize : 'Trình độ học vấn' }}"
                                                                       name="title_cv_specialize">
                                                            </p>
                                                            <div id="experience-table1">
                                                                <?php
                                                                $list_cv_spe = \App\Entity\Cv_specialize::get_cv_id($cv_employee->cv_id);
                                                                ?>
                                                                @if(!empty($list_cv_spe))
                                                                    @foreach($list_cv_spe as $id_spec=>$spec)
                                                                        <div id="exp{{ $id_spec + 1 }}"
                                                                             class="ctbx experience">

                                                                            <h3>
                                                                                <div readonly class="exp-title"

                                                                                     placeholder="Tên công ty"
                                                                                     name="cv_spec_title[]"
                                                                                     value="{{ !empty($spec->cv_spec_title) ? $spec->cv_spec_title : '' }}">{{ !empty($spec->cv_spec_title) ? $spec->cv_spec_title : '' }}</div>
                                                                            </h3>
                                                                            <p class="h3"><input readonly
                                                                                                 name="cv_spec_name[]"
                                                                                                 class="exp-subtitle"
                                                                                                 placeholder="Vị trí công việc"

                                                                                                 value="{{ !empty($spec->cv_spec_name) ? $spec->cv_spec_name : '' }}">
                                                                            </p>
                                                                            <textarea contenteditable="true"
                                                                                 class="exp-content div_textarea"
                                                                                 placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc." name="cv_spec_desc[]">{{ !empty($spec->cv_spec_desc) ? $spec->cv_spec_desc : '' }}</textarea>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($or_right == 2)
                                                        {{--kinh nghiệm làm việc--}}
                                                        <div id="block02" data_show="note_title_cv_experience"
                                                             data_title="{{ !empty($cv_employee->title_cv_experience) ? $cv_employee->title_cv_experience : 'Kinh nghiệm làm việc' }}"
                                                             data_box="block02"
                                                             class="js_click_box cvo-block"
                                                             @if(!empty($show_hidden_right[1])) style="display: none" @endif>
                                                            <input readonly type="hidden" name="cv_order_join[]"
                                                                   value="2">
                                                            <input readonly type="hidden"
                                                                   name="show_hidden_cv_order_join[]"
                                                                   class="show_hidden_cv_order"
                                                                   @if(!empty($show_hidden_right[1])) value="1"
                                                                   @else value="0" @endif>

                                                            <p class="head">
                                                                <input readonly id="" class="block-title"
                                                                       placeholder="Tiêu đề mục lớn"

                                                                       value="{{ !empty($cv_employee->title_cv_experience) ? $cv_employee->title_cv_experience : 'Kinh nghiệm làm việc' }}"
                                                                       name="title_cv_experience">
                                                            </p>
                                                            <div id="experience-table2">
                                                                <?php
                                                                $list_cv_ex = \App\Entity\Cv_experience::get_cv_id($cv_employee->cv_id);
                                                                ?>
                                                                @if(!empty($list_cv_ex))
                                                                    @foreach($list_cv_ex as $id_ex=>$ex)
                                                                        <div id="exp{{$id_ex + 1}}"
                                                                             class="ctbx experience">

                                                                            <h3>
                                                                                <div readonly class="exp-title"

                                                                                     placeholder="Tên công ty"
                                                                                     name="cv_ex_title[]"
                                                                                     value="{{ !empty($ex->cv_ex_title) ? $ex->cv_ex_title : '' }}">{{ !empty($ex->cv_ex_title) ? $ex->cv_ex_title : '' }}</div>
                                                                            </h3>
                                                                            <p class="h3"><input readonly
                                                                                                 class="exp-subtitle"
                                                                                                 placeholder="Vị trí công việc"

                                                                                                 name="cv_ex_name[]"
                                                                                                 value="{{ !empty($ex->cv_ex_name) ? $ex->cv_ex_name : '' }}">
                                                                            </p>
                                                                            <textarea readonly name="cv_ex_desc[]"
                                                                                 class="exp-content div_textarea"

                                                                                 placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">{{ !empty($ex->cv_ex_desc) ? $ex->cv_ex_desc : '' }}</textarea>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($or_right == 3)
                                                        {{--Hoạt động--}}
                                                        <div id="block03" data_show="note_title_cv_work"
                                                             data_title="{{ !empty($cv_employee->title_cv_work) ? $cv_employee->title_cv_work : 'Hoạt động' }}"
                                                             data_box="block03"
                                                             class="js_click_box cvo-block"
                                                             @if(!empty($show_hidden_right[2])) style="display: none" @endif>
                                                            <input readonly type="hidden" name="cv_order_join[]"
                                                                   value="3">
                                                            <input readonly type="hidden"
                                                                   name="show_hidden_cv_order_join[]"
                                                                   class="show_hidden_cv_order"
                                                                   @if(!empty($show_hidden_right[2])) value="1"
                                                                   @else value="0" @endif>

                                                            <p class="head">
                                                                <input readonly name="title_cv_work" id=""
                                                                       class="block-title"
                                                                       placeholder="Tiêu đề mục lớn"

                                                                       value="{{ !empty($cv_employee->title_cv_work) ? $cv_employee->title_cv_work : 'Hoạt động' }}">
                                                            </p>
                                                            <div id="experience-table3">
                                                                <?php
                                                                $list_cv_work = \App\Entity\Cv_work::get_cv_id($cv_employee->cv_id);
                                                                ?>
                                                                @if(!empty($list_cv_work))
                                                                    @foreach($list_cv_work as $id_work=>$work)
                                                                        <div id="exp{{ $id_work + 1 }}"
                                                                             class="ctbx experience">

                                                                            <h3>
                                                                                <input readonly class="exp-title"

                                                                                       placeholder="Tiêu đề"
                                                                                       name="cv_work_title[]"
                                                                                       value="{{ !empty($work->cv_work_title) ? $work->cv_work_title : '' }}">
                                                                            </h3>
                                                                            <p class="h3"><input readonly
                                                                                                 name="cv_work_name[]"
                                                                                                 class="exp-subtitle"
                                                                                                 placeholder="Mô tả vị trí"

                                                                                                 value="{{ !empty($work->cv_work_name) ? $work->cv_work_name : '' }}">
                                                                            </p>
                                                                            <textarea readonly
                                                                                 class="exp-content div_textarea"

                                                                                 placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc."
                                                                                 name="cv_work_desc[]">{{ !empty($work->cv_work_desc) ? $work->cv_work_desc : 'Nội dung hoạt động' }}</textarea>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($or_right == 4)
                                                        {{--dự án tham gia--}}
                                                        <div id="block04" data_show="note_title_cv_project"
                                                             data_title="{{ !empty($cv_employee->title_cv_project) ? $cv_employee->title_cv_project : 'Dự án tham gia' }}"
                                                             data_box="block04"
                                                             class="js_click_box cvo-block"
                                                             @if(!empty($show_hidden_right[3])) style="display: none" @endif>
                                                            <input readonly type="hidden" name="cv_order_join[]"
                                                                   value="4">
                                                            <input readonly type="hidden"
                                                                   name="show_hidden_cv_order_join[]"
                                                                   class="show_hidden_cv_order"
                                                                   @if(!empty($show_hidden_right[3])) value="1"
                                                                   @else value="0" @endif>

                                                            <p class="head">
                                                                <input readonly name="title_cv_project" id=""
                                                                       class="block-title"
                                                                       placeholder="Tiêu đề mục lớn"

                                                                       value="{{ !empty($cv_employee->title_cv_project) ? $cv_employee->title_cv_project : 'Dự án tham gia' }}">
                                                            </p>
                                                            <div id="experience-table4">
                                                                <?php
                                                                $list_cv_project = \App\Entity\Cv_project::get_cv_id($cv_employee->cv_id);
                                                                ?>
                                                                @if(!empty($list_cv_project))
                                                                    @foreach($list_cv_project as $id_project=>$project)
                                                                        <div id="exp{{ $id_project + 1 }}"
                                                                             class="ctbx experience">

                                                                            <h3>
                                                                                <input readonly
                                                                                       name="cv_project_title[]"
                                                                                       class="exp-title"

                                                                                       placeholder="Tiêu đề"
                                                                                       value="{{ !empty($project->cv_project_title) ? $project->cv_project_title : '' }}">
                                                                            </h3>
                                                                            <p class="h3"><input readonly
                                                                                                 name="cv_project_name[]"
                                                                                                 class="exp-subtitle"
                                                                                                 placeholder="Mô tả"

                                                                                                 value="{{ !empty($project->cv_project_name) ? $project->cv_project_name : '' }}">
                                                                            </p>
                                                                            <textarea readonly name="cv_project_des[]"
                                                                                 class="exp-content div_textarea"
                                                                                 placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">{{ !empty($project->cv_project_des) ? $project->cv_project_des : 'Nội dung' }}</textarea>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($or_right == 5)
                                                        {{--Thông tin thêm--}}
                                                        <div id="block05" data_show="note_title_cv_info"
                                                             data_title="{{ !empty($cv_employee->title_cv_info) ? $cv_employee->title_cv_info : 'Thông tin thêm' }}"
                                                             data_box="block05"
                                                             class="js_click_box cvo-block"
                                                             @if(!empty($show_hidden_right[4])) style="display: none" @endif>
                                                            <input readonly type="hidden" name="cv_order_join[]"
                                                                   value="5">
                                                            <input readonly type="hidden"
                                                                   name="show_hidden_cv_order_join[]"
                                                                   class="show_hidden_cv_order"
                                                                   @if(!empty($show_hidden_right[4])) value="1"
                                                                   @else value="0" @endif>

                                                            <p class="head">
                                                                <input readonly name="title_cv_info" id=""
                                                                       class="block-title"
                                                                       placeholder="Tiêu đề mục lớn"

                                                                       value="{{ !empty($cv_employee->title_cv_info) ? $cv_employee->title_cv_info : 'Thông tin thêm' }}">
                                                            </p>
                                                            <div id="experience-table5">
                                                                <?php
                                                                $list_cv_info = \App\Entity\Cv_info::get_cv_id($cv_employee->cv_id);
                                                                ?>
                                                                @if(!empty($list_cv_info))
                                                                    @foreach($list_cv_info as $id_info=>$info)
                                                                        <div id="exp{{ $id_info + 1 }}"
                                                                             class="ctbx experience">

                                                                            <h3>
                                                                                <input readonly name="cv_info_title[]"
                                                                                       class="exp-title"

                                                                                       placeholder="Tiêu đề"
                                                                                       value="{{ !empty($info->cv_info_title) ? $info->cv_info_title : '' }}">
                                                                            </h3>
                                                                            <p class="h3"><input readonly
                                                                                                 name="cv_info_name[]"
                                                                                                 class="exp-subtitle"
                                                                                                 placeholder="Mô tả"

                                                                                                 value="{{ !empty($info->cv_info_name) ? $info->cv_info_name : '' }}">
                                                                            </p>
                                                                            @if(!empty($check_contact_employee))
                                                                                <textarea readonly name="cv_info_des[]"
                                                                                     class="exp-content div_textarea"

                                                                                     placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">{{ !empty($info->cv_info_des) ? $info->cv_info_des : 'Nội dung' }}</textarea>
                                                                            @else
                                                                                <?php
                                                                                $replace_info_cv_info_des = \App\Ultility\Ultility::replace_phone($info->cv_info_des);
                                                                                ?>
                                                                                <textarea readonly name="cv_info_des[]"
                                                                                     class="exp-content div_textarea"

                                                                                     placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">{{ !empty($replace_info_cv_info_des) ? $replace_info_cv_info_des : 'Nội dung' }}</textarea>
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div id="cv-right">
                                            <div class="ir">
                                                <div id="sortable">
                                                    <div id="box01" data_box="box01"
                                                         data_show="note_title_reference_person"
                                                         data_title="{{ 'Thông tin cá nhân' }}"
                                                         class="js_click_box block cvo-block box-contact">
                                                        <p class="icoweb cvi-envelope-square">
                                                            @if(!empty($check_contact_employee))
                                                                <input readonly
                                                                       type="email"
                                                                       id="cv-profile-email"
                                                                       placeholder="Email"

                                                                       name="cv_email"
                                                                       value="{{!empty($cv_employee->cv_email) ? $cv_employee->cv_email : ''  }}">

                                                            @else
                                                                <input readonly
                                                                       type="email"
                                                                       id="cv-profile-email"
                                                                       placeholder="Email"

                                                                       name="cv_email"
                                                                       value="************">
                                                            @endif

                                                        </p>
                                                        <p class="icoweb cvi-phone">
                                                            @if(!empty($check_contact_employee))
                                                                <?php
                                                                $replace = \App\Ultility\Ultility::replace_phone($cv_employee->cv_phone);
                                                                ?>
                                                                <input readonly
                                                                       id="cv-profile-phone"
                                                                       placeholder="Điện thoại"
                                                                       name="cv_phone"
                                                                       value="{{!empty($cv_employee->cv_phone) ? $cv_employee->cv_phone : ''  }}">
                                                            @else
                                                                <input readonly
                                                                       id="cv-profile-phone"
                                                                       placeholder="Điện thoại"

                                                                       name="cv_phone"
                                                                       value="**********">
                                                            @endif
                                                        </p>
                                                        <p class="icoweb cvi-date"><input readonly
                                                                                          id="cv-profile-birthday"
                                                                                          placeholder="Ngày sinh"

                                                                                          name="cv_birthday"
                                                                                          value="{{!empty($cv_employee->cv_birthday) ? $cv_employee->cv_birthday : ''  }}">
                                                        </p>
                                                        <p class="icoweb cvi-map-marker div_input"
                                                           style="color: black !important;word-wrap: break-word;">{{!empty($cv_employee->cv_address) ? $cv_employee->cv_address : $employee->address  }}
                                                        </p>

                                                        @if(!empty($check_contact_employee))
                                                            <p class="icoweb cvi-info div_input"
                                                               style="color: black !important;word-wrap: break-word;">{{!empty($cv_employee->cv_facebook) ? $cv_employee->cv_facebook : $employee->my_facebook  }}
                                                            </p>
                                                        @else
                                                            <p class="icoweb cvi-info div_input"
                                                               style="color: black !important;word-wrap: break-word;">
                                                                ***************
                                                            </p>
                                                        @endif
                                                    </div>
                                                    {{--tinh từ khoi block 2--}}
                                                    <?php
                                                    $order_left = array();
                                                    $order_left = explode(',', $cv_employee->cv_order);

                                                    $show_hidden_left = array();
                                                    $show_hidden_left = explode(',', $cv_employee->show_hidden_cv_order);


                                                    ?>
                                                    @foreach($order_left as $or_left)
                                                        @if($or_left == 1)
                                                            <div id="box02" data_box="box02"
                                                                 data_show="note_cv_title_career_goals"
                                                                 data_title="{{ !empty($cv_employee->cv_title_career_goals) ? $cv_employee->cv_title_career_goals : 'Thông tin thêm' }}"
                                                                 class="js_click_box block cvo-block"
                                                                 @if(!empty($show_hidden_left[0])) style="display: none" @endif>
                                                                <input readonly type="hidden" name="cv_order[]"
                                                                       value="1">
                                                                <input readonly type="hidden"
                                                                       name="show_hidden_cv_order[]"
                                                                       class="show_hidden_cv_order"
                                                                       @if(!empty($show_hidden_left[0])) value="1"
                                                                       @else value="0" @endif>

                                                                <h3>
                                                                    <input readonly
                                                                           name="cv_title_career_goals"
                                                                           cv-form-field="true"

                                                                           placeholder="Mục tiêu nghề nghiệp"
                                                                           class="box-title input_title"
                                                                           value="{{!empty($cv_employee->cv_title_career_goals) ? $cv_employee->cv_title_career_goals : 'Mục tiêu nghề nghiệp' }}">
                                                                </h3>
                                                                <textarea readonly name="cv_career_goals"
                                                                     class="box-content div_textarea"
                                                                >{{!empty($cv_employee->cv_career_goals) ? $cv_employee->cv_career_goals : '' }}</textarea>
                                                            </div>
                                                        @endif
                                                        @if($or_left == 2)
                                                            <div id="box03" data_box="box03"
                                                                 data_show="note_title_cv_skills"
                                                                 data_title="{{!empty($cv_employee->title_cv_skills) ? $cv_employee->title_cv_skills : 'Kỹ năng' }}"
                                                                 class="js_click_box block cvo-block box-skills"
                                                                 @if(!empty($show_hidden_left[1])) style="display: none" @endif>
                                                                <input readonly type="hidden" name="cv_order[]"
                                                                       value="2">
                                                                <input readonly type="hidden"
                                                                       name="show_hidden_cv_order[]"
                                                                       class="show_hidden_cv_order"
                                                                       @if(!empty($show_hidden_left[1])) value="1"
                                                                       @else value="0" @endif>

                                                                <h3><input readonly name="title_cv_skills"
                                                                           cv-form-field="true"

                                                                           placeholder="Kỹ năng"
                                                                           class="box-title"
                                                                           value="{{!empty($cv_employee->title_cv_skills) ? $cv_employee->title_cv_skills : 'Kỹ năng' }}">
                                                                </h3>
                                                                <div class="exp content-edit skill">
                                                                    <?php
                                                                    $list_cv_skill = \App\Entity\Cv_skills::get_cv_id($cv_employee->cv_id);
                                                                    ?>
                                                                    @if(!empty($list_cv_skill))
                                                                        @foreach($list_cv_skill as $id_skill=>$skill)
                                                                            <div class="ctbx">

                                                                                <input readonly name="cv_skill_title[]"
                                                                                       class="skill-name"
                                                                                       cv-form-field="true"

                                                                                       value="{{ !empty($skill->cv_skill_title) ? $skill->cv_skill_title : '' }}">
                                                                                <div class="bar-exp">
                                                                                    <div style="width: {{ !empty($skill->cv_skill_value) ? $skill->cv_skill_value : '50' }}%"></div>
                                                                                </div>
                                                                                <div class="bar-value-exp"><input
                                                                                            readonly
                                                                                            name="cv_skill_value[]"
                                                                                            min="0"
                                                                                            max="100" type="text"
                                                                                            value="{{ !empty($skill->cv_skill_value) ? $skill->cv_skill_value : '50' }}">
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                    <div class="clr"></div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($or_left == 3)
                                                            <div id="box04" data_box="box04"
                                                                 data_show="note_cv_title_prize"
                                                                 data_title="{{!empty($cv_employee->cv_title_prize) ? $cv_employee->cv_title_prize : 'Giải thưởng' }}"
                                                                 class="js_click_box block cvo-block"
                                                                 @if(!empty($show_hidden_left[2])) style="display: none" @endif>
                                                                <input readonly type="hidden" name="cv_order[]"
                                                                       value="3">
                                                                <input readonly type="hidden"
                                                                       name="show_hidden_cv_order[]"
                                                                       class="show_hidden_cv_order"
                                                                       @if(!empty($show_hidden_left[2])) value="1"
                                                                       @else value="0" @endif>

                                                                <h3>
                                                                    <input readonly cv-form-field="true"

                                                                           placeholder="Giải thưởng" class="box-title"
                                                                           value="{{!empty($cv_employee->cv_title_prize) ? $cv_employee->cv_title_prize : 'Giải thưởng' }}"
                                                                           name="cv_title_prize">
                                                                </h3>
                                                                <p>
                                                                <textarea readonly class="box-content div_textarea"
                                                                     name="cv_interests"
                                                                     placeholder="Đang cập nhật thông tin"
                                                                >{{!empty($cv_employee->cv_interests) ? $cv_employee->cv_interests : '' }}</textarea>
                                                                </p>
                                                            </div>
                                                        @endif
                                                        @if($or_left == 4)
                                                            <div id="box05" data_box="box05"
                                                                 data_show="note_cv_title_card"
                                                                 data_title="{{!empty($cv_employee->cv_title_card) ? $cv_employee->cv_title_card : 'Chứng chỉ' }}"
                                                                 class="js_click_box block cvo-block"
                                                                 @if(!empty($show_hidden_left[3])) style="display: none" @endif>
                                                                <input readonly type="hidden" name="cv_order[]"
                                                                       value="4">
                                                                <input readonly type="hidden"
                                                                       name="show_hidden_cv_order[]"
                                                                       class="show_hidden_cv_order"
                                                                       @if(!empty($show_hidden_left[3])) value="1"
                                                                       @else value="0" @endif>

                                                                <h3>
                                                                    <input readonly cv-form-field="true"

                                                                           placeholder="Chứng chỉ" class="box-title"
                                                                           value="{{!empty($cv_employee->cv_title_card) ? $cv_employee->cv_title_card : 'Chứng chỉ' }}"
                                                                           name="cv_title_card">
                                                                </h3>
                                                                <p>
                                                                <textarea readonly name="cv_card"
                                                                     class="box-content div_textarea"
                                                                     placeholder="Đang cập nhật thông tin"
                                                                >{{!empty($cv_employee->cv_card) ? $cv_employee->cv_card : '' }} </textarea>
                                                                </p>
                                                            </div>
                                                        @endif
                                                        @if($or_left == 5)
                                                            <div id="box06" data_box="box06"
                                                                 data_show="note_cv_title_interests"
                                                                 data_title="{{!empty($cv_employee->cv_title_interests) ? $cv_employee->cv_title_interests : 'Sở thích' }}"
                                                                 class="js_click_box block cvo-block"
                                                                 @if(!empty($show_hidden_left[4])) style="display: none" @endif>
                                                                <input readonly type="hidden" name="cv_order[]"
                                                                       value="5">
                                                                <input readonly type="hidden"
                                                                       name="show_hidden_cv_order[]"
                                                                       class="show_hidden_cv_order"
                                                                       @if(!empty($show_hidden_left[4])) value="1"
                                                                       @else value="0" @endif>

                                                                <h3>
                                                                    <input readonly cv-form-field="true"

                                                                           placeholder="Sở thích" class="box-title"
                                                                           value="{{!empty($cv_employee->cv_title_interests) ? $cv_employee->cv_title_interests : 'Sở thích' }}"
                                                                           name="cv_title_interests">
                                                                </h3>
                                                                <p>
                                                                <textarea readonly name="cv_interests"
                                                                     class="box-content div_textarea"
                                                                     placeholder="Đang cập nhật thông tin"
                                                                >{{!empty($cv_employee->cv_interests) ? $cv_employee->cv_interests : '' }}</textarea>
                                                                </p>
                                                            </div>
                                                        @endif
                                                        @if($or_left == 6)
                                                            <div id="box07" data_box="box07"
                                                                 data_show="note_cv_title_reference_person"
                                                                 data_title="{{!empty($cv_employee->cv_title_reference_person) ? $cv_employee->cv_title_reference_person : 'Người tham chiếu' }}"
                                                                 class="js_click_box block cvo-block"
                                                                 @if(!empty($show_hidden_left[5])) style="display: none" @endif>
                                                                <input readonly type="hidden" name="cv_order[]"
                                                                       value="6">
                                                                <input readonly type="hidden"
                                                                       name="show_hidden_cv_order[]"
                                                                       class="show_hidden_cv_order"
                                                                       @if(!empty($show_hidden_left[5])) value="1"
                                                                       @else value="0" @endif>

                                                                <h3>
                                                                    <input readonly cv-form-field="true"

                                                                           placeholder="Người tham chiếu"
                                                                           class="box-title"
                                                                           value="{{!empty($cv_employee->cv_title_reference_person) ? $cv_employee->cv_title_reference_person : 'Người tham chiếu' }}"
                                                                           name="cv_title_reference_person">
                                                                </h3>
                                                                <p>
                                                                <textarea readonly name="cv_reference_person"
                                                                     class="box-content  div_textarea"
                                                                     id="cv_reference_person"
                                                                     placeholder="Đang cập nhật thông tin"
                                                                >{{!empty($cv_employee->cv_reference_person) ? $cv_employee->cv_reference_person : '' }}</textarea>
                                                                </p>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--//sidebar--}}

                        </div>
                        <div id="stop_cv"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<div class="clr"></div>
<!-- Crop img -->

<style>
</style>
<!-- <script src="js/jquery-ui.min.js" type="text/javascript"></script> -->
<!-- <script src="js/jquery.ui.touch-punch.min.js" type="text/javascript"></script> -->
<script src="{{ asset('public/employee_cv') }}/cropper.js" type="text/javascript"></script>
<script src="{{ asset('public/employee_cv') }}/jquery.validate.min.js"></script>
<script src="{{ asset('public/employee_cv') }}/html2canvas.js"></script>
<script src="{{ asset('public/employee_cv') }}/main.js@v=10"></script>
<script src="{{ asset('public/employee_cv') }}/cvh.js@v=20"></script>
<script src="{{ asset('public/employee_cv') }}/select2.min.js"></script>
<script src="{{ asset('public/employee_cv') }}/edit.js"></script>
<script src="{{ asset('public/employee_cv') }}/select2.min.js"></script>
{{--
<div id="loadjs"></div>
--}}
<script src="{{ asset('public/employee_cv') }}/html2canvas.js"></script>
<script src="{{ asset('public/employee_cv') }}/dist/jspdf.debug.js"></script>
<script src="{{ asset('public/employee_cv') }}/slick/slick.min.js"></script>
<link rel="stylesheet" href="{{ asset('public/employee_cv') }}/select2.min.css" media="print"
      onload="if(media!='all')media='all'">

<style>
    .select2-container--default .select2-selection--multiple, .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #e3e3e3;
        outline: 0
    }

    .select2-container .select2-selection--single {
        height: 40px;
        font-size: 14px
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        height: 38px;
        line-height: 38px
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 7px
    }

    .select2-container--default .select2-selection--single {
        border-radius: 4px !important;
        border-color: #e3e3e3
    }

    .select2-container .select2-selection--multiple {
        min-height: 40px
    }

    .select2-container .select2-search--inline .select2-search__field {
        font-size: 14px;
        line-height: normal;
        padding-top: 5px;
    }
</style>
<div class="" id="js_style_cv_color"></div>
<script src="{{ asset('public/employee_cv') }}/jquery.validate.min.js" async></script>
<script src="{{ asset('public/employee_cv') }}/cv.js@v=42" async></script>
{{--<script type="text/javascript"--}}
{{--src="https://mojotech.github.io/stickymojo/js/stickyMojo.js"></script>--}}
<script>
    $(document).ready(function () {
        $('.js_click_box').click(function () {
            var data_show = $(this).attr('data_show');
            var data_title = $(this).attr('data_title');

            $('.item_cv_note').css('display', 'none');
            $('.' + data_show).show();
            $('.item_title_gui_cv span').html(data_title);


            console.log(data_show);
            console.log(data_title);
        });

        $(window).scroll(function () {
            if ($(this).scrollTop() > 180) {
                $('#sidebar').css('top', '90px');
            } else {
                $('#sidebar').css('top', 'inherit');
            }
        });
    });


</script>

<script type="text/javascript">
    if ($(window).width() < 1180) {
        $("footer,.hd_top").css("width", "1170");
    }
</script>
<link rel="stylesheet" href="{{ asset('public/assets/css') }}/cusStyle_cv.css">
{{--
<link rel="stylesheet" href="{{ asset('public/employee_cv') }}/fonts/font_css.css" media="print" onload="if(media!='all')media='all'">
--}}
<script>
    $(document).ready(function () {
        $('#js_height_textarea textarea').each(function () {
            this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
        }).on('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

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

        $('#box-hvt').css('background', cl_cv_1);
        $('#sortable').css('background', cl_cv_1);
        $('#cvo-profile-avatar-wraper').css('background', cl_cv_1);
        $('#form-cv').css('border', 'solid 1px' + cl_cv_1);
        $('#cv-right').css('background', 'solid 1px' + cl_cv_1);
        $('#cv-right h3 input').css('color', cl_cv_2);
        $('h1 span').css('color', cl_cv_2);
        $('#cv-top h2').css('color', cl_cv_3);
        $('#cv-content .head').css('background-color', cl_cv_4);
        $('#cv-content .head input').css('color', cl_cv_5);
        $('#ctbx .exp-title').css('color', cl_cv_1);
        $('.div_textarea.box-content').css('color', cl_cv_6);
        $('input.skill-name').css('color', cl_cv_6);


        @foreach($cv_color as $id_cl=>$color)
        $('.my_color_cv{{$id_cl + 1}}').click(function () {
                <?php
                $list_color = array();
                $list_color = explode(',', $color->order_color);
                ?>
            var checkked_radio = $(this).attr('data_cl');
            $('#checkked' + checkked_radio).prop("checked", true);
            var cl_1 = '{{ $list_color[0] }}';
            var cl_2 = '{{ $list_color[1] }}';
            var cl_3 = '{{ $list_color[2] }}';
            var cl_4 = '{{ $list_color[3] }}';
            var cl_5 = '{{ $list_color[4] }}';
            var cl_6 = '{{ $list_color[5] }}';

            $('#box-hvt').css('background', cl_1);
            $('#sortable').css('background', cl_1);
            $('#cvo-profile-avatar-wraper').css('background', cl_1);
            $('#form-cv').css('border', 'solid 1px' + cl_1);
            $('#cv-right').css('background', 'solid 1px' + cl_1);
            $('#cv-right h3 input').css('color', cl_2);
            $('#cv-top h2').css('color', cl_3);
            $('h1 input').css('color', cl_2);
            $('#cv-content .head').css('background-color', cl_4);
            $('#cv-content .head input').css('color', cl_5);
            $('#ctbx .exp-title').css('color', cl_1);
            $('textarea.box-content').css('color', cl_6);
            $('input.skill-name').css('color', cl_6);
        });
        @endforeach



    });
</script>
<style>
    #cv-top h1 {
        text-transform: inherit;
    }

    .cvo-block .blockControls {
        font-family: arial, sans-serif;
        position: absolute;
        z-index: -9999;
        height: 36px;
        top: -36px;
        left: 0;
        text-align: center;
        padding: 0 8px;
        text-shadow: none;
        display: none;
        border: none;
        background-color: #ccc;
        opacity: 1;
        border-radius: 4px 4px 0 0;
        -moz-border-radius: 4px 4px 0 0;
        -webkit-border-radius: 4px 4px 0 0;
    }

    .fieldgroup_controls {
        text-align: right;
        position: absolute;
        display: none;
        top: -34px;
        right: 0;
        text-shadow: none;
        min-width: 200px;
        font-family: arial, sans-serif;
        z-index: -111;
    }

    input:hover {
        border: none;
    }

    textarea:hover {
        border: none;
    }

    .div_input {
        color: black !important;
    }
</style>
<!-- Modal -->
@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)
    @if(!empty($relate_employee))
        <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20 mgb20">
            <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                Ứng viên đã xem
                {{--( {{ theo bảng thong ke so tiền }} việc làm)--}}
            </div>
            <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                <div class="row">
                    @foreach($relate_employee as $relate)
                        @include('site.employee.item_employee_contact',['employee' => $relate])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endif







