@extends('admin.layout.admin')

@section('title', '  Cấu hình CV')

@section('content')
    <form role="form" action="{{ route('update_config_cv') }}" method="POST">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Cấu hình CV
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Cài đặt</a></li>
                <li class="active">Thêm mới CV</li>
            </ol>
        </section>
        {!! csrf_field() !!}
        {{ method_field('POST') }}


        <link rel="stylesheet" href="{{ asset('public/employee_cv') }}/font-awesome.min.css">
        <link rel="stylesheet" href="{{ asset('public/employee_cv') }}/slick/slick.css" type="text/css">
        <link rel="stylesheet" href="{{ asset('public/employee_cv') }}/slick/slick-theme.css" type="text/css">


        <link rel="stylesheet" href="{{ asset('public/employee_cv') }}/style.css@v=57.css" type="text/css">
        {{--<script src="{{ asset('public/employee_cv') }}/jquery.min.js"></script>--}}

        <div id="btn-shadow"></div>

        <style type="text/css">
            .blog-hd {
                display: table;
                width: 100%
            }

            #a {
                display: table;
                width: 100%
            }

            .menu_nncv .dm_more {
                z-index: 9999;
            }

            #hoso-scroll {
                z-index: 0;
            }
        </style>
        <link rel="stylesheet" href="{{ asset('public/employee_cv') }}/roboto.css" type="text/css">
        <link rel="stylesheet" href="{{ asset('public/employee_cv') }}/cvh.css" type="text/css">
        <link rel="stylesheet" href="{{ asset('public/employee_cv') }}/cropper.css" type="text/css">
        <script src="{{ asset('public/employee_cv') }}/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>


        {{--<section>--}}
        {{--<form action="{{ route('exportpdf_cv') }}" method="get">--}}
        {{--<div>--}}
        {{--<button type="submit" class="btn btn-primary">tai xuong PDF</button>--}}
        {{--</div>--}}
        {{--</form>--}}

        <div class="blog-hd" id="page-taocv">

            <!-- 	<div class="head">
               <div class="ctr">
                   <a href="https://timviec365.vn/cv365/mau-cv-thiet-ke-co-dien"><i class="img back1"></i>Quay lại danh sách CV</a>
                   <h2>Bạn đang dùng mẫu CV Thiết kế cổ điển</h2>
               </div>
               </div> -->

            <div class="clr"></div>

            <div class="ctr">
                <!-- Giao dien mau thu-->
                <link rel="stylesheet" href="{{ asset('public/employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/cv.css"
                      type="text/css">
                <link id="cv-color-css" rel="stylesheet"
                      href="{{ asset('public/employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/colors/3a93a5.css@v=1.css"
                      type="text/css">
                {{--<link id="cv-font" rel="stylesheet" href="{{ asset('public/employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/fonts/Roboto.css" type="text/css">--}}
                {{--<link id="cv-font-size" rel="stylesheet" href="{{ asset('public/employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/font-size/normal.css" type="text/css">--}}
                {{--<link id="cv-cpacing-css" rel="stylesheet" href="{{ asset('public/employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/font-spacing/normal.css" type="text/css">--}}

                <div id="page-cv">
                    <input type="hidden" name="cv_id" value="{{ $cv_employee->cv_id  }}">
                    <input type="hidden" name="cv_color" id="cv_color" value="{{ $cv_employee->cv_color  }}">
                    <input id="cv-title" name="cv_title" class="non-printable" contenteditable="true" cvo-validatable=""
                           placeholder="Tiêu đề CV"
                           value="{{!empty($cv_employee->cv_title) ?  $cv_employee->cv_title : '' }}">

                    <div id="form-cv">
                        <div id="cv-top">
                            <div id="cvo-profile">
                                <div class="box-01">
                                    <div id="cvo-profile-avatar-wraper">
                                        <input type="button" onclick="return uploadImage(this);" style="color: #fff"
                                               value="Chọn ảnh tại đây !"
                                               size="20" class="error_text_images"/>
                                        <img src="{{ isset($cv_employee->cv_image) ? $cv_employee->cv_image : asset('public/assets/image/avatar4x6.png') }}"
                                             width="80" height=""/>
                                        <input name="images" type="text"
                                               value="{{ isset($cv_employee->cv_image) ? $cv_employee->cv_image : asset('public/assets/image/avatar4x6.png') }}"
                                               style="border:none !important;color: #fff !important;position: absolute;left: 0;width: 84px;z-index: -9;"/>

                                    </div>
                                    <div id="box-hvt">
                                        <h1><input id="cv-profile-fullname" name="cv_name" placeholder="Họ tên"
                                                   contenteditable="true"
                                                   value="{{!empty($cv_employee->cv_name) ? $cv_employee->cv_name : '' }}">
                                        </h1>
                                        <h2>
                                            <?php
                                            $career = '';
                                            if (!empty($employee->career_category_id)) {
                                                $career = \App\Entity\Career::getIdCareer($employee->career_category_id);
                                            }
                                            ?>
                                            <input id="cv-profile-job" name="cv_title_job" contenteditable="true"
                                                   placeholder="Vị trí công việc bạn muốn ứng tuyển"
                                                   value="{{!empty($cv_employee->cv_title_job) ? $cv_employee->cv_title_job : '' }}">
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
                                            <div id="block01" class="cvo-block">
                                                <div class="blockControls">
                                                    <div title="Di chuyển khối" class="show-layout-editor"><i
                                                                class="fa fa-bars"></i></div>
                                                    <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                    <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                    <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn
                                                    </div>
                                                </div>
                                                <p class="head">
                                                    <input id="cvo-experience-blocktitle" class="block-title"
                                                           placeholder="Tiêu đề mục lớn" contenteditable="true"
                                                           value="{{ !empty($cv_employee->title_cv_specialize) ? $cv_employee->title_cv_specialize : 'Trình độ học vấn' }}"
                                                           name="title_cv_specialize">
                                                </p>
                                                <div id="experience-table">

                                                    <?php
                                                    $list_cv_spe = \App\Entity\Cv_specialize::get_template_id($cv_employee->cv_template_id);
                                                    $total_spec = \App\Entity\Cv_specialize::get_template_count($cv_employee->cv_template_id);
                                                    ?>
                                                    @if(!empty($list_cv_spe) && $total_spec > 0)
                                                        @foreach($list_cv_spe as $id_spec=>$spec)
                                                            <div id="exp{{ $id_spec + 1 }}" class="ctbx experience">
                                                                <div class="fieldgroup_controls">
                                                                    <div class="clone"><i class="fa fa-plus"></i> Thêm
                                                                    </div>
                                                                    <div class="remove"><i class="fa fa-minus"></i> Xóa
                                                                    </div>
                                                                </div>

                                                                <h3>
                                                                    <input class="exp-title" contenteditable="true"
                                                                           placeholder="Tên công ty"
                                                                           name="cv_spec_title[]"
                                                                           value="{{ !empty($spec->cv_spec_title) ? $spec->cv_spec_title : '' }}">
                                                                </h3>
                                                                <p class="h3"><input name="cv_spec_name[]"
                                                                                     class="exp-subtitle"
                                                                                     placeholder="Vị trí công việc"
                                                                                     contenteditable="true"
                                                                                     value="{{ !empty($spec->cv_spec_name) ? $spec->cv_spec_name : '' }}">
                                                                </p>
                                                                <textarea class="exp-content" contenteditable="true"
                                                                          placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc."
                                                                          name="cv_spec_desc[]">{{ !empty($spec->cv_spec_desc) ? $spec->cv_spec_desc : '' }}</textarea>

                                                            </div>
                                                        @endforeach



                                                    @else
                                                        <div id="exp1" class="ctbx experience">
                                                            <div class="fieldgroup_controls">
                                                                <div class="clone"><i class="fa fa-plus"></i> Thêm
                                                                </div>
                                                                <div class="remove"><i class="fa fa-minus"></i> Xóa
                                                                </div>
                                                            </div>

                                                            <h3>
                                                                <input class="exp-title" contenteditable="true"
                                                                       placeholder="Tên công ty"
                                                                       name="cv_spec_title[]"
                                                                       value="Dự án sanketoan.vn (2014 - 2015)">
                                                            </h3>
                                                            <p class="h3"><input name="cv_spec_name[]"
                                                                                 class="exp-subtitle"
                                                                                 placeholder="Vị trí công việc"
                                                                                 contenteditable="true"
                                                                                 value="Khách hàng :Công ty cổ phần thanh toán Sắc màu.">
                                                            </p>
                                                            <textarea class="exp-content" contenteditable="true"
                                                                      placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc."
                                                                      name="cv_spec_desc[]">- Tham gia nghiên cứu khoa học cấp trường tổ chức
  Đề tài: Kế toán quản trị chi phí  tại Công ty cổ phần thanh toán Sắc màu.
- Dự án “ Ngày tết quê em năm 2018”  Địa điểm: Sơn Tây, Hà Nội
Vai trò: Quản lý thu – chi của dự án, liên hệ và làm việc với các mạnh thường quân.</textarea>

                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        @if($or_right == 2)
                                            {{--kinh nghiệm làm việc--}}
                                            <div id="block02" class="cvo-block">
                                                <div class="blockControls">
                                                    <div title="Di chuyển khối" class="show-layout-editor"><i
                                                                class="fa fa-bars"></i></div>
                                                    <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                    <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                    <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn
                                                    </div>
                                                </div>

                                                <p class="head">
                                                    <input id="cvo-experience-blocktitle" class="block-title"
                                                           placeholder="Tiêu đề mục lớn" contenteditable="true"
                                                           value="{{ !empty($cv_employee->title_cv_experience) ? $cv_employee->title_cv_experience : 'Kinh nghiệm làm việc' }}"
                                                           name="title_cv_experience">
                                                </p>
                                                <div id="experience-table">
                                                    <?php
                                                    $list_cv_ex = \App\Entity\Cv_experience::get_template_id($cv_employee->cv_template_id);
                                                    $total_ex = \App\Entity\Cv_experience::get_template_total($cv_employee->cv_template_id);

                                                    ?>
                                                    @if(!empty($list_cv_ex) && $total_ex > 0)
                                                        @foreach($list_cv_ex as $id_ex=>$ex)
                                                            <div id="exp{{$id_ex + 1}}" class="ctbx experience">
                                                                <div class="fieldgroup_controls">
                                                                    <div class="clone"><i class="fa fa-plus"></i> Thêm
                                                                    </div>
                                                                    <div class="remove"><i class="fa fa-minus"></i> Xóa
                                                                    </div>
                                                                </div>
                                                                <h3>
                                                                    <input class="exp-title" contenteditable="true"
                                                                           placeholder="Tên công ty"
                                                                           name="cv_ex_title[]"
                                                                           value="{{ !empty($ex->cv_ex_title) ? $ex->cv_ex_title : '' }}">
                                                                </h3>
                                                                <p class="h3"><input class="exp-subtitle"
                                                                                     placeholder="Vị trí công việc"
                                                                                     contenteditable="true"
                                                                                     name="cv_ex_name[]"
                                                                                     value="{{ !empty($ex->cv_ex_name) ? $ex->cv_ex_name : '' }}">
                                                                </p>
                                                                <textarea name="cv_ex_desc[]" class="exp-content"
                                                                          contenteditable="true"
                                                                          placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">{{ !empty($ex->cv_ex_desc) ? $ex->cv_ex_desc : '' }} </textarea>
                                                            </div>
                                                        @endforeach

                                                    @else
                                                        <div id="exp1" class="ctbx experience">
                                                            <div class="fieldgroup_controls">
                                                                <div class="clone"><i class="fa fa-plus"></i> Thêm
                                                                </div>
                                                                <div class="remove"><i class="fa fa-minus"></i> Xóa
                                                                </div>
                                                            </div>
                                                            <h3>
                                                                <input class="exp-title" contenteditable="true"
                                                                       placeholder="Tên công ty"
                                                                       name="cv_ex_title[]"
                                                                       value="Công ty TNHH cổ phần Sắc màu">
                                                            </h3>
                                                            <p class="h3"><input class="exp-subtitle"
                                                                                 placeholder="Vị trí công việc"
                                                                                 contenteditable="true"
                                                                                 name="cv_ex_name[]"
                                                                                 value="Vị trí: Kế toán tổng hợp">
                                                            </p>
                                                            <textarea name="cv_ex_desc[]" class="exp-content"
                                                                      contenteditable="true"
                                                                      placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">- Tổng hợp doanh thu và toàn bộ các hoạt động sản xuất kinh doanh của Công ty.
- Lập báo cáo tài chính, báo cáo quản trị, báo cáo thuế theo đúng quy định pháp luật và yêu cầu của công ty.
- Chịu trách nhiệm thực hiện các công việc liên quan đến thuế: Giải trình số liệu, làm việc với cơ quan thuế…
- Kiểm soát thu – chi và chi phí
- Hỗ trợ Giám đốc thực hiện các giao dịch (các vấn đề phát sinh) với ngân hàng. </textarea>
                                                        </div>

                                                        <div id="exp1" class="ctbx experience">
                                                            <div class="fieldgroup_controls">
                                                                <div class="clone"><i class="fa fa-plus"></i> Thêm
                                                                </div>
                                                                <div class="remove"><i class="fa fa-minus"></i> Xóa
                                                                </div>
                                                            </div>
                                                            <h3>
                                                                <input class="exp-title" contenteditable="true"
                                                                       placeholder="Tên công ty"
                                                                       name="cv_ex_title[]"
                                                                       value="Công ty cổ phần Sắc màu">
                                                            </h3>
                                                            <p class="h3"><input class="exp-subtitle"
                                                                                 placeholder="Vị trí công việc"
                                                                                 contenteditable="true"
                                                                                 name="cv_ex_name[]"
                                                                                 value="Vị trí: Nhân viên kế toán">
                                                            </p>
                                                            <textarea name="cv_ex_desc[]" class="exp-content"
                                                                      contenteditable="true"
                                                                      placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">- Kế toán tiền lương và bảo hiểm của các nhân viên trong công ty
- Theo dõi, kiểm tra và tổng hợp chứng từ kế toán
- Quản lý Thu – Chi, tổng hợp và báo cáo quỹ tiền mặt mỗi ngày lên BGĐ
- Hỗ trợ giải quyết các vấn đề phát sinh khác trong quá trình làm việc dưới sự chỉ đạo của kế toán trưởng </textarea>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                        @endif
                                        @if($or_right == 3)
                                            {{--Hoạt động--}}
                                            <div id="block03" class="cvo-block">
                                                <div class="blockControls">
                                                    <div title="Di chuyển khối" class="show-layout-editor"><i
                                                                class="fa fa-bars"></i></div>
                                                    <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                    <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                    <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn
                                                    </div>
                                                </div>
                                                <p class="head">
                                                    <input name="title_cv_work" id="cvo-experience-blocktitle"
                                                           class="block-title" placeholder="Tiêu đề mục lớn"
                                                           contenteditable="true"
                                                           value="{{ !empty($cv_employee->title_cv_work) ? $cv_employee->title_cv_work : 'Hoạt động' }}">
                                                </p>
                                                <div id="experience-table">
                                                    <?php
                                                    $list_cv_work = \App\Entity\Cv_work::get_template_id($cv_employee->cv_template_id);
                                                    $total_work = \App\Entity\Cv_work::get_template_total($cv_employee->cv_template_id);
                                                    ?>
                                                    @if(!empty($list_cv_work) && $total_work > 0)
                                                        @foreach($list_cv_work as $id_work=>$work)
                                                            <div id="exp{{ $id_work + 1 }}" class="ctbx experience">
                                                                <div class="fieldgroup_controls">
                                                                    <div class="clone"><i class="fa fa-plus"></i> Thêm
                                                                    </div>
                                                                    <div class="remove"><i class="fa fa-minus"></i> Xóa
                                                                    </div>
                                                                </div>
                                                                <h3>
                                                                    <input class="exp-title" contenteditable="true"
                                                                           placeholder="Tên công ty"
                                                                           name="cv_work_title[]"
                                                                           value="{{ !empty($work->cv_work_title) ? $work->cv_work_title : '' }}">
                                                                </h3>
                                                                <p class="h3"><input name="cv_work_name[]"
                                                                                     class="exp-subtitle"
                                                                                     placeholder="Vị trí công việc"
                                                                                     contenteditable="true"
                                                                                     value="{{ !empty($work->cv_work_name) ? $work->cv_work_name : '' }}">
                                                                </p>
                                                                <textarea class="exp-content" contenteditable="true"
                                                                          placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc."
                                                                          name="cv_work_desc[]"> {{ !empty($work->cv_work_desc) ? $work->cv_work_desc : '' }}</textarea>
                                                            </div>
                                                        @endforeach

                                                    @else
                                                        <div id="exp1" class="ctbx experience">
                                                            <div class="fieldgroup_controls">
                                                                <div class="clone"><i class="fa fa-plus"></i> Thêm
                                                                </div>
                                                                <div class="remove"><i class="fa fa-minus"></i> Xóa
                                                                </div>
                                                            </div>
                                                            <h3>
                                                                <input class="exp-title" contenteditable="true"
                                                                       placeholder="Tên công ty"
                                                                       name="cv_work_title[]"
                                                                       value="Nhóm tình nguyện Sàn kế toán 1">
                                                            </h3>
                                                            <p class="h3"><input name="cv_work_name[]"
                                                                                 class="exp-subtitle"
                                                                                 placeholder="Vị trí công việc"
                                                                                 contenteditable="true"
                                                                                 value="Tình nguyện viên">
                                                            </p>
                                                            <textarea class="exp-content" contenteditable="true"
                                                                      placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc."
                                                                      name="cv_work_desc[]">  - Tham gia CLB Hiến máu tình nguyện 4 năm liên tiếp tại trường Đại học
- Bánh trưng ngày tết quê em năm 2018,2019</textarea>
                                                        </div>

                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        @if($or_right == 4)
                                            {{--dự án tham gia--}}
                                            <div id="block04" class="cvo-block">
                                                <div class="blockControls">
                                                    <div title="Di chuyển khối" class="show-layout-editor"><i
                                                                class="fa fa-bars"></i></div>
                                                    <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                    <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                    <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn
                                                    </div>
                                                </div>
                                                <p class="head">
                                                    <input name="title_cv_project" id="cvo-experience-blocktitle"
                                                           class="block-title" placeholder="Tiêu đề mục lớn"
                                                           contenteditable="true"
                                                           value="{{ !empty($cv_employee->title_cv_project) ? $cv_employee->title_cv_project : 'Dự án tham gia' }}">
                                                </p>
                                                <div id="experience-table">
                                                    <?php
                                                    $list_cv_project = \App\Entity\Cv_project::get_template_id($cv_employee->cv_template_id);
                                                    $total_project = \App\Entity\Cv_project::get_template_total($cv_employee->cv_template_id);
                                                    ?>
                                                    @if(!empty($list_cv_project) && $total_project > 0)
                                                        @foreach($list_cv_project as $id_project=>$project)
                                                            <div id="exp{{ $id_project + 1 }}" class="ctbx experience">
                                                                <div class="fieldgroup_controls">
                                                                    <div class="clone"><i class="fa fa-plus"></i> Thêm
                                                                    </div>
                                                                    <div class="remove"><i class="fa fa-minus"></i> Xóa
                                                                    </div>
                                                                </div>
                                                                <h3>
                                                                    <input name="cv_project_title[]" class="exp-title"
                                                                           contenteditable="true"
                                                                           placeholder="Tên công ty"
                                                                           value="{{ !empty($project->cv_project_title) ? $project->cv_project_title : '' }}">
                                                                </h3>
                                                                <p class="h3"><input name="cv_project_name[]"
                                                                                     class="exp-subtitle"
                                                                                     placeholder="Vị trí công việc"
                                                                                     contenteditable="true"
                                                                                     value="{{ !empty($project->cv_project_name) ? $project->cv_project_name : '' }}">
                                                                </p>
                                                                <textarea name="cv_project_des[]" class="exp-content"
                                                                          contenteditable="true"
                                                                          placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">{{ !empty($project->cv_project_des) ? $project->cv_project_des : '' }}
                                        </textarea>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div id="exp1" class="ctbx experience">
                                                            <div class="fieldgroup_controls">
                                                                <div class="clone"><i class="fa fa-plus"></i> Thêm
                                                                </div>
                                                                <div class="remove"><i class="fa fa-minus"></i> Xóa
                                                                </div>
                                                            </div>
                                                            <h3>
                                                                <input name="cv_project_title[]" class="exp-title"
                                                                       contenteditable="true"
                                                                       placeholder="Tên công ty"
                                                                       value="Dự án sanketoan.vn (2014 - 2015)">
                                                            </h3>
                                                            <p class="h3"><input name="cv_project_name[]"
                                                                                 class="exp-subtitle"
                                                                                 placeholder="Vị trí công việc"
                                                                                 contenteditable="true"
                                                                                 value="Khách hàng :Công ty cổ phần thanh toán Sắc màu.">
                                                            </p>
                                                            <textarea name="cv_project_des[]" class="exp-content"
                                                                      contenteditable="true"
                                                                      placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">- Tham gia nghiên cứu khoa học cấp trường tổ chức
  Đề tài: Kế toán quản trị chi phí  tại Công ty cổ phần thanh toán Sắc màu.
- Dự án “ Ngày tết quê em năm 2018”  Địa điểm: Sơn Tây, Hà Nội
Vai trò: Quản lý thu – chi của dự án, liên hệ và làm việc với các mạnh thường quân. </textarea>
                                                        </div>

                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        @if($or_right == 5)
                                            {{--Thông tin thêm--}}
                                            <div id="block05" class="cvo-block">
                                                <div class="blockControls">
                                                    <div title="Di chuyển khối" class="show-layout-editor"><i
                                                                class="fa fa-bars"></i></div>
                                                    <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                    <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                    <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn
                                                    </div>
                                                </div>
                                                <p class="head">
                                                    <input name="title_cv_info" id="cvo-experience-blocktitle"
                                                           class="block-title" placeholder="Tiêu đề mục lớn"
                                                           contenteditable="true"
                                                           value="{{ !empty($cv_employee->title_cv_info) ? $cv_employee->title_cv_info : 'Thông tin thêm' }}">
                                                </p>
                                                <div id="experience-table">
                                                    <?php
                                                    $list_cv_info = \App\Entity\Cv_info::get_template_id($cv_employee->cv_template_id);
                                                    $total_info = \App\Entity\Cv_info::get_template_total($cv_employee->cv_template_id);
                                                    ?>
                                                    @if(!empty($list_cv_info) && $total_info > 0)
                                                        @foreach($list_cv_info as $id_info=>$info)
                                                            <div id="exp{{ $id_info + 1 }}" class="ctbx experience">
                                                                <div class="fieldgroup_controls">
                                                                    <div class="clone"><i class="fa fa-plus"></i> Thêm
                                                                    </div>
                                                                    <div class="remove"><i class="fa fa-minus"></i> Xóa
                                                                    </div>
                                                                </div>
                                                                <h3>
                                                                    <input name="cv_info_title[]" class="exp-title"
                                                                           contenteditable="true"
                                                                           placeholder="Tên công ty"
                                                                           value="{{ !empty($info->cv_info_title) ? $info->cv_info_title : '' }}">
                                                                </h3>
                                                                <p class="h3"><input name="cv_info_name[]"
                                                                                     class="exp-subtitle"
                                                                                     placeholder="Vị trí công việc"
                                                                                     contenteditable="true"
                                                                                     value="{{ !empty($info->cv_info_name) ? $info->cv_info_name : '' }}">
                                                                </p>
                                                                <textarea name="cv_info_des[]" class="exp-content"
                                                                          contenteditable="true"
                                                                          placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">{{ !empty($info->cv_info_des) ? $info->cv_info_des : '' }}</textarea>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div id="exp1" class="ctbx experience">
                                                            <div class="fieldgroup_controls">
                                                                <div class="clone"><i class="fa fa-plus"></i> Thêm
                                                                </div>
                                                                <div class="remove"><i class="fa fa-minus"></i> Xóa
                                                                </div>
                                                            </div>
                                                            <h3>
                                                                <input name="cv_info_title[]" class="exp-title"
                                                                       contenteditable="true"
                                                                       placeholder="Tên công ty"
                                                                       value="Thêm thông tin nếu cần">
                                                            </h3>
                                                            <p class="h3"><input name="cv_info_name[]"
                                                                                 class="exp-subtitle"
                                                                                 placeholder="Vị trí công việc"
                                                                                 contenteditable="true"
                                                                                 value="Thêm thông tin nếu cần">
                                                            </p>
                                                            <textarea name="cv_info_des[]" class="exp-content"
                                                                      contenteditable="true"
                                                                      placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">Thêm thông tin nếu cần</textarea>
                                                        </div>

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


                                        <div id="box01" class="block cvo-block box-contact">
                                            <p class="icoweb cvi-envelope-square"><input type="email"
                                                                                         id="cv-profile-email"
                                                                                         placeholder="Email"
                                                                                         contenteditable="true"
                                                                                         name="cv_email"
                                                                                         value="{{!empty($cv_employee->cv_email) ? $cv_employee->cv_email : ''  }}">
                                            </p>
                                            <p class="icoweb cvi-phone"><input id="cv-profile-phone"
                                                                               placeholder="Điện thoại"
                                                                               contenteditable="true" name="cv_phone"
                                                                               value="{{!empty($cv_employee->cv_phone) ? $cv_employee->cv_phone : '' }}">
                                            </p>
                                            <?php
                                            $date = '';
                                            $date = date_create($cv_employee->cv_birthday);
                                            ?>
                                            <p class="icoweb cvi-date"><input id="cv-profile-birthday"
                                                                              placeholder="Ngày sinh"
                                                                              contenteditable="true" name="cv_birthday"
                                                                              value="{{!empty($cv_employee->cv_birthday) ? $cv_employee->cv_birthday : '' }}">
                                            </p>
                                            <p class="icoweb cvi-map-marker"><input id="cv-profile-address"
                                                                                    placeholder="Địa chỉ"
                                                                                    contenteditable="true"
                                                                                    name="cv_address"
                                                                                    value="{{!empty($cv_employee->cv_address) ? $cv_employee->cv_address : '' }}">
                                            </p>
                                            <p class="icoweb cvi-info"><input id="cv-profile-face" placeholder="Website"
                                                                              contenteditable="true" name="cv_facebook"
                                                                              value="{{!empty($cv_employee->cv_facebook) ? $cv_employee->cv_facebook : '' }}">
                                            </p>
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
                                                <div id="box02" class="block cvo-block">
                                                    <div class="blockControls">
                                                        <div title="Di chuyển khối" class="show-layout-editor"><i
                                                                    class="fa fa-bars"></i></div>
                                                        <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                        <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                        <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i>
                                                            Ẩn
                                                        </div>
                                                    </div>
                                                    <h3>
                                                        <input id="cv-boxtitle" name="cv_title_career_goals"
                                                               cv-form-field="true" contenteditable="true"
                                                               placeholder="Mục tiêu nghề nghiệp"
                                                               class="box-title input_title"
                                                               value="{{!empty($cv_employee->cv_title_career_goals) ? $cv_employee->cv_title_career_goals : 'Mục tiêu nghề nghiệp' }}">
                                                    </h3>
                                                    <textarea name="cv_career_goals" class="box-content"
                                                              contenteditable="true">{{!empty($cv_employee->cv_career_goals) ? $cv_employee->cv_career_goals : 'Mục tiêu ngắn hạn:Tìm được môi trường làm việc mới phù hợp, với những kiến thức và kinh nghiệm có được về công việc kế toán. Tôi mong muốn rằng sẽ đóng góp trong sự phát triển của công ty trong tương lai.
Mục tiêu dài hạn: Trở thành kiểm toán viên' }}</textarea>


                                                </div>
                                            @endif
                                            @if($or_left == 2)
                                                <div id="box03" class="block cvo-block box-skills">
                                                    <div class="blockControls">
                                                        <div title="Di chuyển khối" class="show-layout-editor"><i
                                                                    class="fa fa-bars"></i></div>
                                                        <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                        <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                        <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i>
                                                            Ẩn
                                                        </div>
                                                    </div>
                                                    <h3><input id="cv-boxtitle" name="title_cv_skills"
                                                               cv-form-field="true"
                                                               contenteditable="true" placeholder="Tiêu đề"
                                                               class="box-title"
                                                               value="{{!empty($cv_employee->title_cv_skills) ? $cv_employee->title_cv_skills : 'KỸ NĂNG' }}">
                                                    </h3>
                                                    <div class="exp content-edit skill">
                                                        <?php
                                                        $list_cv_skill = \App\Entity\Cv_skills::get_template_id($cv_employee->cv_template_id);
                                                        $total_skill = \App\Entity\Cv_skills::get_template_total($cv_employee->cv_template_id);
                                                        ?>
                                                        @if(!empty($list_cv_skill) && $total_skill > 0)
                                                            @foreach($list_cv_skill as $id_skill=>$skill)
                                                                <div class="ctbx">
                                                                    <div class="fieldgroup_controls">
                                                                        <div class="clone"><i class="fa fa-plus"></i>
                                                                            Thêm
                                                                        </div>
                                                                        <div class="edit js-edit-content"> Sửa</div>
                                                                        <div class="remove"><i class="fa fa-minus"></i>
                                                                            Xóa
                                                                        </div>
                                                                    </div>
                                                                    <input name="cv_skill_title[]" class="skill-name"
                                                                           cv-form-field="true" contenteditable="true"
                                                                           value="{{ !empty($skill->cv_skill_title) ? $skill->cv_skill_title : '' }}">
                                                                    <div class="bar-exp">
                                                                        <div style="width: {{ !empty($skill->cv_skill_value) ? $skill->cv_skill_value : '50' }}%"></div>
                                                                    </div>
                                                                    <div class="bar-value-exp"><input
                                                                                name="cv_skill_value[]" min="0"
                                                                                max="100" type="text"
                                                                                value="{{ !empty($skill->cv_skill_value) ? $skill->cv_skill_value : '50' }}">
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="ctbx">
                                                                <div class="fieldgroup_controls">
                                                                    <div class="clone"><i class="fa fa-plus"></i>
                                                                        Thêm
                                                                    </div>
                                                                    <div class="edit js-edit-content"> Sửa</div>
                                                                    <div class="remove"><i class="fa fa-minus"></i>
                                                                        Xóa
                                                                    </div>
                                                                </div>
                                                                <input name="cv_skill_title[]" class="skill-name"
                                                                       cv-form-field="true" contenteditable="true"
                                                                       value="Tin học văn phòng">
                                                                <div class="bar-exp">
                                                                    <div style="width: {{ !empty($skill->cv_skill_value) ? $skill->cv_skill_value : '50' }}%"></div>
                                                                </div>
                                                                <div class="bar-value-exp"><input
                                                                            name="cv_skill_value[]" min="0"
                                                                            max="100" type="text"
                                                                            value="50">
                                                                </div>
                                                            </div>
                                                            <div class="ctbx">
                                                                <div class="fieldgroup_controls">
                                                                    <div class="clone"><i class="fa fa-plus"></i>
                                                                        Thêm
                                                                    </div>
                                                                    <div class="edit js-edit-content"> Sửa</div>
                                                                    <div class="remove"><i class="fa fa-minus"></i>
                                                                        Xóa
                                                                    </div>
                                                                </div>
                                                                <input name="cv_skill_title[]" class="skill-name"
                                                                       cv-form-field="true" contenteditable="true"
                                                                       value="Tiếng Anh giao tiếp">
                                                                <div class="bar-exp">
                                                                    <div style="width: {{ !empty($skill->cv_skill_value) ? $skill->cv_skill_value : '50' }}%"></div>
                                                                </div>
                                                                <div class="bar-value-exp"><input
                                                                            name="cv_skill_value[]" min="0"
                                                                            max="100" type="text"
                                                                            value="80">
                                                                </div>
                                                            </div>

                                                        @endif
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($or_left == 3)
                                                <div id="box04" class="block cvo-block">
                                                    <div class="blockControls">
                                                        <div title="Di chuyển khối" class="show-layout-editor"><i
                                                                    class="fa fa-bars"></i></div>
                                                        <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                        <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                        <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i>
                                                            Ẩn
                                                        </div>
                                                    </div>
                                                    <h3>
                                                        <input id="cv-boxtitle" cv-form-field="true"
                                                               contenteditable="true"
                                                               placeholder="Tiêu đề" class="box-title"
                                                               value="{{!empty($cv_employee->cv_title_prize) ? $cv_employee->cv_title_prize : 'GIẢI THƯỞNG' }}"
                                                               name="cv_title_prize">
                                                    </h3>
                                                    <p><textarea class="box-content" name="cv_interests"
                                                                 placeholder="Nội dung"
                                                                 contenteditable="true">{{!empty($cv_employee->cv_interests) ? $cv_employee->cv_interests : '- Giải ba đề tài nghiên cứu khoa học sinh viên cấp trường.
- Bằng khen của Đoàn trường, Thành Đoàn Hà Nội vì có thành tích xuất sắc trong quá trình tham gia công tác đoàn đội tại trường đại học.' }}</textarea>
                                                    </p>
                                                </div>
                                            @endif
                                            @if($or_left == 4)
                                                <div id="box05" class="block cvo-block">

                                                    <div class="blockControls">
                                                        <div title="Di chuyển khối" class="show-layout-editor"><i
                                                                    class="fa fa-bars"></i></div>
                                                        <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                        <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                        <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i>
                                                            Ẩn
                                                        </div>
                                                    </div>
                                                    <h3>
                                                        <input id="cv-boxtitle" cv-form-field="true"
                                                               contenteditable="true"
                                                               placeholder="Tiêu đề" class="box-title"
                                                               value="{{!empty($cv_employee->cv_title_card) ? $cv_employee->cv_title_card : 'CHỨNG CHỈ' }}"
                                                               name="cv_title_card">
                                                    </h3>
                                                    <p><textarea name="cv_card" class="box-content"
                                                                 placeholder="Nội dung"
                                                                 contenteditable="true">{{!empty($cv_employee->cv_card) ? $cv_employee->cv_card : '- Chứng chỉ kế toán tổng hợp
- Chứng chỉ ứng dụng công nghệ thông tin cơ bản
- Chứng chỉ tiếng anh B1' }} </textarea>
                                                    </p>
                                                </div>
                                            @endif
                                            @if($or_left == 5)

                                                <div id="box06" class="block cvo-block">
                                                    <div class="blockControls">
                                                        <div title="Di chuyển khối" class="show-layout-editor"><i
                                                                    class="fa fa-bars"></i></div>
                                                        <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                        <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                        <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i>
                                                            Ẩn
                                                        </div>
                                                    </div>
                                                    <h3>
                                                        <input id="cv-boxtitle" cv-form-field="true"
                                                               contenteditable="true"
                                                               placeholder="Tiêu đề" class="box-title"
                                                               value="{{!empty($cv_employee->cv_title_interests) ? $cv_employee->cv_title_interests : 'SỞ THÍCH' }}"
                                                               name="cv_title_interests">
                                                    </h3>
                                                    <p><textarea name="cv_interests" class="box-content"
                                                                 placeholder="Nội dung"
                                                                 contenteditable="true">{{!empty($cv_employee->cv_interests) ? $cv_employee->cv_interests : '- Đọc sách
- Xem phim
- Chụp ảnh
- Tình nguyện' }}</textarea>
                                                    </p>
                                                </div>
                                            @endif
                                            @if($or_left == 6)

                                                <div id="box07" class="block cvo-block">
                                                    <div class="blockControls">
                                                        <div title="Di chuyển khối" class="show-layout-editor"><i
                                                                    class="fa fa-bars"></i></div>
                                                        <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                        <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                        <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i>
                                                            Ẩn
                                                        </div>
                                                    </div>
                                                    <h3>
                                                        <input id="cv-boxtitle" cv-form-field="true"
                                                               contenteditable=""
                                                               placeholder="Tiêu đề" class="box-title"
                                                               value="{{!empty($cv_employee->cv_title_reference_person) ? $cv_employee->cv_title_reference_person : 'NGƯỜI THAM CHIẾU' }}"
                                                               name="cv_title_reference_person">
                                                    </h3>
                                                    <p><textarea name="cv_reference_person" class="box-content "
                                                                 id="cv_reference_person" placeholder="Nội dung"
                                                                 contenteditable="true">{{!empty($cv_employee->cv_reference_person) ? $cv_employee->cv_reference_person : 'Nguyễn Thị B
– Kế toán trưởng
Công ty CP Sắc Màu
SĐT: 0123456789' }}</textarea>
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

                <div class="col-xs-12 col-md-3" style="background: #fff;padding: 20px;margin-left: 20px;">
                   <h3>Cấu hình màu sắc</h3>(chỉ admin cấu hình coment cv_color trong update)
                    <p style="font-size: 12px;">Có tất cả 5 dải màu</p>
                    <div class="js_appent_setting_color">
                        <?php
                        $list_cv_color = \App\Entity\Cv_color::get_template_id($cv_employee->cv_template_id);
                        $total_color = \App\Entity\Cv_color::get_template_total($cv_employee->cv_template_id);
                        ?>
                        @if(!empty($list_cv_color) && $total_color > 0)
                            @foreach($list_cv_color as $color)
                        <div class="setting_color">
                          <div style="width: 100%;height: 25px;">
                            <button class="js_delete delete_cv" type="button">
                                Xóa mã màu này
                            </button>
                          </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên màu</label>
                                <input type="text" name="cv_title_color[]" placeholder="Tên màu" class="form-control" value="{{ $color->cv_title }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã màu</label>
                                <input type="text" name="code_color[]" placeholder="Mã màu hiển thị"
                                       class="form-control" value="{{ $color->code_color }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sắp xếp màu (cách nhau bằng dấu phẩy)</label>
                                <input type="text" name="order_color[]" placeholder="Sắp xếp mẫu" class="form-control" value="{{ $color->order_color }}">
                            </div>
                        </div>
                                @endforeach
                            @else
                                <div class="setting_color">
                                    <div style="width: 100%;height: 25px;">
                                        <button class="js_delete delete_cv" type="button">
                                            Xóa mã màu này
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên màu</label>
                                        <input type="text" name="cv_title_color[]" placeholder="Tên màu" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mã màu</label>
                                        <input type="text" name="code_color[]" placeholder="Mã màu hiển thị"
                                               class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Sắp xếp màu (cách nhau bằng dấu phẩy)</label>
                                        <input type="text" name="order_color[]" placeholder="Sắp xếp mẫu" class="form-control">
                                    </div>
                                </div>
                        @endif

                    </div>
                    <div class="add_color_cv">
                        <button type="button" id="js_add_color_cv" class="add_cv add_cv_orange">
                            Thêm mã màu mới
                        </button>
                    </div>


                    <hr>
                    <div class="add_color_cv" style="margin-top: 30px">
                        <button type="submit" id="" class="add_cv">
                            Lưu CV
                        </button>
                    </div>

                </div>


                <div id="editor"></div>


            </div>
        </div>
        </div>

        <input type="hidden" name="cv_template_id" value="{{ $cv_employee->cv_template_id }}">
    </form>
    <div class="clr"></div>
    <!-- Crop img -->

    <div id="layout-editor-container">
        <div id="layout-editor">
            <div class="group">
                <div class="block active" blockmain="menu" blockkey="box01">
                    <div class="selector"><i class="fa fa-check"></i></div>
                    <span>Thông tin liên hệ</span>
                    <i class="fa fa-bars icon-order"></i>
                </div>
                <div class="block active" blockmain="menu" blockkey="box02">
                    <div class="selector"><i class="fa fa-check"></i></div>
                    <span>Mục tiêu nghề nghiệp</span>
                    <i class="fa fa-bars icon-order"></i>
                </div>
                <div class="block active" blockmain="menu" blockkey="box03">
                    <div class="selector"><i class="fa fa-check"></i></div>
                    <span>Kỹ năng</span>
                    <i class="fa fa-bars icon-order"></i>
                </div>
                <div class="block active" blockmain="menu" blockkey="box04">
                    <div class="selector"><i class="fa fa-check"></i></div>
                    <span>Giải thưởng</span>
                    <i class="fa fa-bars icon-order"></i>
                </div>
                <div class="block active" blockmain="menu" blockkey="box05">
                    <div class="selector"><i class="fa fa-check"></i></div>
                    <span>Chứng chỉ</span>
                    <i class="fa fa-bars icon-order"></i>
                </div>
                <div class="block active" blockmain="menu" blockkey="box06">
                    <div class="selector"><i class="fa fa-check"></i></div>
                    <span>Sở thích</span>
                    <i class="fa fa-bars icon-order"></i>
                </div>
                <div class="block active" blockmain="menu" blockkey="box07">
                    <div class="selector"><i class="fa fa-check"></i></div>
                    <span>Người tham chiếu</span>
                    <i class="fa fa-bars icon-order"></i>
                </div>
            </div>
            <div class="group">
                <div class="block active" blockmain="experiences" blockkey="block01">
                    <div class="selector"><i class="fa fa-check"></i></div>
                    <span>Trình độ học vấn</span>
                    <i class="fa fa-bars icon-order"></i>
                </div>
                <div class="block active" blockmain="experiences" blockkey="block02">
                    <div class="selector"><i class="fa fa-check"></i></div>
                    <span>Kinh nghiệm làm việc</span>
                    <i class="fa fa-bars icon-order"></i>
                </div>
                <div class="block active" blockmain="experiences" blockkey="block03">
                    <div class="selector"><i class="fa fa-check"></i></div>
                    <span>Hoạt động</span>
                    <i class="fa fa-bars icon-order"></i>
                </div>
                <div class="block active" blockmain="experiences" blockkey="block04">
                    <div class="selector"><i class="fa fa-check"></i></div>
                    <span>Dự án tham gia</span>
                    <i class="fa fa-bars icon-order"></i>
                </div>
                <div class="block active" blockmain="experiences" blockkey="block05">
                    <div class="selector"><i class="fa fa-check"></i></div>
                    <span>Thông tin thêm</span>
                    <i class="fa fa-bars icon-order"></i>
                </div>
            </div>
            <div class="text-center action-bar">
                <button type="button" class="btn-cvo btn-primary btn-finish">Cập nhật</button>
            </div>
        </div>
    </div>


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
    {{--<div id="loadjs"></div>--}}

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
    <script src="{{ asset('public/employee_cv') }}/jquery.validate.min.js" async></script>
    <script src="{{ asset('public/employee_cv') }}/cv.js@v=42" async></script>

    <script type="text/javascript">
        if ($(window).width() < 1180) {
            $("footer,.hd_top").css("width", "1170");
        }
    </script>
    <link rel="stylesheet" href="{{ asset('public/assets/css') }}/cusStyle_cv.css">
    {{--<link rel="stylesheet" href="{{ asset('public/employee_cv') }}/fonts/font_css.css" media="print" onload="if(media!='all')media='all'">--}}






    <script>
        $('textarea').each(function () {
            this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
        }).on('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        $('#js_add_color_cv').click(function () {
            var html = '<div class="setting_color">';
                html += '<div style="width: 100%;height: 25px;">';
                html += '<button class="js_delete delete_cv" type="button">';
                html += 'Xóa mã màu này';
                html += '</button>';
                html += '</div>';
                html += '<div class="form-group">';
                html += '<label for="exampleInputEmail1">Tên màu</label>';
                html += '<input type="text" name="cv_title_color[]" placeholder="Tên màu" class="form-control">';
                html += '</div>';
                html += '<div class="form-group">';
                html += '<label for="exampleInputEmail1">Mã màu</label>';
                html += '<input type="text" name="code_color[]" placeholder="Mã màu hiển thị" class="form-control">';
                html += '</div>';
                html += '<div class="form-group">';
                html += '<label for="exampleInputEmail1">Sắp xếp màu (cách nhau bằng dấu phẩy)</label>';
                html += '<input type="text" name="order_color[]" placeholder="Sắp xếp mẫu" class="form-control">';
                html += '</div>';
                html += '</div>';

            $('.js_appent_setting_color').append(html)
        });
        $(document).ready(function(){
            $('.js_delete').click(function(){
               var delete_cv = $(this).parent().parent();
               console.log(delete_cv);
                delete_cv.remove();
            });
        });
    </script>

    <style>
        .ctr {
            width: 100%;
            margin: auto;
            padding: 20px;
        }
        .delete_cv
        {
            display: block;
            color: #fff;
            background: red;
            border: 1px solid red;
            padding: 2px 10px;
            text-align: right;
            float: right;
            margin-bottom: 5px;
        }
        .add_cv
        {
                     color: #fff;
                     background: green;
                     border: 1px solid green;
                     padding: 3px 10px;
        }
        .add_cv_orange
        {
            background: orange;
            border: 1px solid orange;
        }
        input[name=cv_title_job] {
            width: 100%;
        }

    </style>
@endsection