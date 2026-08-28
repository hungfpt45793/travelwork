@extends('admin.layout.admin')

@section('title', ' Thêm mới  mẫu CV')

@section('content')
    <form role="form" action="{{ route('cv_template.store') }}" method="POST">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Thêm mới  mẫu CV
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Cài đặt</a></li>
                <li class="active">Thêm mới CV</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <!-- form start -->

                {!! csrf_field() !!}
                {{ method_field('POST') }}



            </div>
        </section>



        <link rel="stylesheet" href="{{ asset('employee_cv') }}/font-awesome.min.css">
        <link rel="stylesheet" href="{{ asset('employee_cv') }}/slick/slick.css" type="text/css">
        <link rel="stylesheet" href="{{ asset('employee_cv') }}/slick/slick-theme.css" type="text/css">


        <link rel="stylesheet" href="{{ asset('employee_cv') }}/style.css@v=57.css" type="text/css">
        {{--<script src="{{ asset('employee_cv') }}/jquery.min.js"></script>--}}

        <div id="btn-shadow"></div>

        <style type="text/css">
            .blog-hd{display: table;width: 100%}
            #a{display: table;width: 100%}
            .menu_nncv .dm_more{z-index: 9999;}
            #hoso-scroll{z-index: 0;}
        </style>
        <link rel="stylesheet" href="{{ asset('employee_cv') }}/roboto.css" type="text/css">
        <link rel="stylesheet" href="{{ asset('employee_cv') }}/cvh.css" type="text/css">
        <link rel="stylesheet" href="{{ asset('employee_cv') }}/cropper.css" type="text/css">
        <script src="{{ asset('employee_cv') }}/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>



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
                <link rel="stylesheet" href="{{ asset('employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/cv.css" type="text/css">
                <link id="cv-color-css" rel="stylesheet" href="{{ asset('employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/colors/3a93a5.css@v=1.css" type="text/css">
                {{--<link id="cv-font" rel="stylesheet" href="{{ asset('employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/fonts/Roboto.css" type="text/css">--}}
                {{--<link id="cv-font-size" rel="stylesheet" href="{{ asset('employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/font-size/normal.css" type="text/css">--}}
                {{--<link id="cv-cpacing-css" rel="stylesheet" href="{{ asset('employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/font-spacing/normal.css" type="text/css">--}}

                <div id="page-cv">
                    <p>Một số thông tin cơ bản của ứng sẽ tự động nhập vào CV</p>
                    <input id="cv-title" name="cv_title" class="non-printable" contenteditable="true" cvo-validatable="" placeholder="Tiêu đề CV">

                    <div id="form-cv">
                        <div id="cv-top">
                            <div id="cvo-profile">
                                <div class="box-01">
                                    <div id="cvo-profile-avatar-wraper">
                                        <img id="cvo-profile-avatar_employee" cvo-form-field="true" src="" onclick="return uploadImage(this);">

                                        <input name="images" type="text"
                                               value=""
                                               style="border:none !important;color: #fff !important;position: absolute;left: 0;width: 84px;z-index: -9;"/>

                                    </div>
                                    <div id="box-hvt">
                                        <h1><input id="cv-profile-fullname" name="cv_name"  placeholder="Họ tên" contenteditable="true" value="" ></h1>
                                        <h2>
                                            <!--                                            --><?php
                                            //                                            $career = '';
                                            //                                            $career = \App\Entity\Career::getIdCareer($employee->career_category_id);
                                            //                                            ?>
                                            {{--<input id="cv-profile-job" name="cv_title_job" contenteditable="true" placeholder="Vị trí công việc bạn muốn ứng tuyển" value="{{!empty($cv_employee->cv_title_job) ? $cv_employee->cv_title_job : $career->career_category_name }}"> --}}
                                            <input id="cv-profile-job" name="cv_title_job" contenteditable="true" placeholder="Vị trí công việc bạn muốn ứng tuyển" value="" style="width: 100%">
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

                                    <div id="block01" class="cvo-block">
                                        <input type="hidden" name="cv_order_join[]" value="1">
                                        <div class="blockControls">
                                            <div title="Di chuyển khối" class="show-layout-editor"><i class="fa fa-bars"></i></div>
                                            <div title="Chuyển mục này lên trên" class="up">▲</div>
                                            <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                            <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn</div>
                                        </div>
                                        <p class="head">
                                            <input id="cvo-experience-blocktitle" class="block-title" placeholder="Tiêu đề mục lớn" contenteditable="true" value="Trình độ học vấn" name="title_cv_specialize">
                                        </p>
                                        <div id="experience-table">
                                            <div id="exp1" class="ctbx experience">
                                                <div class="fieldgroup_controls">
                                                    <div class="clone"><i class="fa fa-plus"></i> Thêm</div>
                                                    <div class="remove"><i class="fa fa-minus"></i> Xóa</div>
                                                </div>
                                                <h3>
                                                    <input class="exp-title" contenteditable="true" placeholder="Tên công ty" name="cv_spec_title[]" value="Đại học Sàn kế toán"></input>
                                                </h3>
                                                <p class="h3"><input name="cv_spec_name[]" class="exp-subtitle" placeholder="Vị trí công việc" contenteditable="true" value="Chuyên ngành: Kế toán (10/2010 - 05/2014)">
                                                </p>
                                                <textarea class="exp-content" contenteditable="true" placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc." name="cv_spec_desc[]">Xếp loại: Giỏi </textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="block02" class="cvo-block" >
                                        <input type="hidden" name="cv_order_join[]" value="2">
                                        <div class="blockControls">
                                            <div title="Di chuyển khối" class="show-layout-editor"><i class="fa fa-bars"></i></div>
                                            <div title="Chuyển mục này lên trên" class="up">▲</div>
                                            <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                            <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn</div>
                                        </div>
                                        <p class="head">
                                            <input id="cvo-experience-blocktitle" class="block-title" placeholder="Tiêu đề mục lớn" contenteditable="true" value="Kinh nghiệm làm việc" name="title_cv_experience">
                                        </p>
                                        <div id="experience-table">
                                            <div id="exp1" class="ctbx experience">
                                                <div class="fieldgroup_controls">
                                                    <div class="clone"><i class="fa fa-plus"></i> Thêm</div>
                                                    <div class="remove"><i class="fa fa-minus"></i> Xóa</div>
                                                </div>
                                                <h3>
                                                    <input class="exp-title" contenteditable="true" placeholder="Tên công ty" name="cv_ex_title[]" value="Công ty cổ phần Sắc màu">
                                                </h3>
                                                <p class="h3"><input class="exp-subtitle" placeholder="Vị trí công việc" contenteditable="true" name="cv_ex_name[]" value="Vị trí: Kế toán tổng hợp">
                                                </p>
                                                <textarea name="cv_ex_desc[]" class="exp-content" contenteditable="true"  placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">- Tổng hợp doanh thu và toàn bộ các hoạt động sản xuất kinh doanh của Công ty.
- Lập báo cáo tài chính, báo cáo quản trị, báo cáo thuế theo đúng quy định pháp luật và yêu cầu của công ty.
- Chịu trách nhiệm thực hiện các công việc liên quan đến thuế: Giải trình số liệu, làm việc với cơ quan thuế…
- Kiểm soát thu – chi và chi phí
- Hỗ trợ Giám đốc thực hiện các giao dịch (các vấn đề phát sinh) với ngân hàng. </textarea>
                                            </div>
                                            <div id="exp2" class="ctbx experience">
                                                <div class="fieldgroup_controls">
                                                    <div class="clone"><i class="fa fa-plus"></i> Thêm</div>
                                                    <div class="remove"><i class="fa fa-minus"></i> Xóa</div>
                                                </div>
                                                <h3>
                                                    <input class="exp-title" contenteditable="true" placeholder="Tên công ty" name="cv_ex_title[]" value="Công ty cổ phần Sắc màu">
                                                </h3>
                                                <p class="h3"><input class="exp-subtitle" placeholder="Vị trí công việc" contenteditable="true" name="cv_ex_name[]" value="Vị trí: Kế toán tổng hợp">
                                                </p>
                                                <textarea name="cv_ex_desc[]" class="exp-content" contenteditable="true"  placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">- Tổng hợp doanh thu và toàn bộ các hoạt động sản xuất kinh doanh của Công ty.
- Lập báo cáo tài chính, báo cáo quản trị, báo cáo thuế theo đúng quy định pháp luật và yêu cầu của công ty.
- Chịu trách nhiệm thực hiện các công việc liên quan đến thuế: Giải trình số liệu, làm việc với cơ quan thuế…
- Kiểm soát thu – chi và chi phí
- Hỗ trợ Giám đốc thực hiện các giao dịch (các vấn đề phát sinh) với ngân hàng. </textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="block03" class="cvo-block" >
                                        <input type="hidden" name="cv_order_join[]" value="3">
                                        <div class="blockControls">
                                            <div title="Di chuyển khối" class="show-layout-editor"><i class="fa fa-bars"></i></div>
                                            <div title="Chuyển mục này lên trên" class="up">▲</div>
                                            <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                            <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn</div>
                                        </div>
                                        <p class="head">
                                            <input name="title_cv_work" id="cvo-experience-blocktitle" class="block-title" placeholder="Tiêu đề mục lớn" contenteditable="true" value="Hoạt động">
                                        </p>
                                        <div id="experience-table">
                                            <div id="exp1" class="ctbx experience">
                                                <div class="fieldgroup_controls">
                                                    <div class="clone"><i class="fa fa-plus"></i> Thêm</div>
                                                    <div class="remove"><i class="fa fa-minus"></i> Xóa</div>
                                                </div>
                                                <h3>
                                                    <input class="exp-title" contenteditable="true" placeholder="Tên công ty" name="cv_work_title[]" value="Nhóm tình nguyện Sàn kế toán">
                                                </h3>
                                                <p class="h3"><input name="cv_work_name[]" class="exp-subtitle" placeholder="Vị trí công việc" contenteditable="true" value="Tình nguyện viên">
                                                </p>
                                                <textarea class="exp-content" contenteditable="true" placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc." name="cv_work_desc[]"> - Tham gia CLB Hiến máu tình nguyện 4 năm liên tiếp tại trường Đại học
- Bánh trưng ngày tết quê em năm 2018
                                        </textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="block04" class="cvo-block" >
                                        <input type="hidden" name="cv_order_join[]" value="4">
                                        <div class="blockControls">
                                            <div title="Di chuyển khối" class="show-layout-editor"><i class="fa fa-bars"></i></div>
                                            <div title="Chuyển mục này lên trên" class="up">▲</div>
                                            <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                            <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn</div>
                                        </div>
                                        <p class="head">
                                            <input name="title_cv_project" id="cvo-experience-blocktitle" class="block-title" placeholder="Tiêu đề mục lớn" contenteditable="true" value="Dự án tham gia">
                                        </p>
                                        <div id="experience-table">
                                            <div id="exp1" class="ctbx experience">
                                                <div class="fieldgroup_controls">
                                                    <div class="clone"><i class="fa fa-plus"></i> Thêm</div>
                                                    <div class="remove"><i class="fa fa-minus"></i> Xóa</div>
                                                </div>
                                                <h3>
                                                    <input name="cv_project_title[]" class="exp-title" contenteditable="true" placeholder="Tên công ty" value="Sunny Way (2014 - 2015)">
                                                </h3>
                                                <p class="h3"><input name="cv_project_name[]" class="exp-subtitle" placeholder="Vị trí công việc" contenteditable="true" value="Khách hàng :Công ty cổ phần thanh toán Hưng Hà.">
                                                </p>
                                                <textarea name="cv_project_des[]" class="exp-content" contenteditable="true" placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">- Tham gia nghiên cứu khoa học cấp trường tổ chức
  Đề tài: Kế toán quản trị chi phí  tại Công ty cổ phần thanh toán Hưng Hà.
- Dự án “ Ngày tết quê em năm 2018” <br>– Địa điểm: Sơn Tây, Hà Nội<br>Vai trò: Quản lý thu – chi của dự án, liên hệ và làm việc với các mạnh thường quân.
                                        </textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="block05" class="cvo-block" >
                                        <input type="hidden" name="cv_order_join[]" value="5">
                                        <div class="blockControls">
                                            <div title="Di chuyển khối" class="show-layout-editor"><i class="fa fa-bars"></i></div>
                                            <div title="Chuyển mục này lên trên" class="up">▲</div>
                                            <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                            <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn</div>
                                        </div>
                                        <p class="head">
                                            <input name="title_cv_info" id="cvo-experience-blocktitle" class="block-title" placeholder="Tiêu đề mục lớn" contenteditable="true" value="Thông tin thêm">
                                        </p>
                                        <div id="experience-table">
                                            <div id="exp1" class="ctbx experience">
                                                <div class="fieldgroup_controls">
                                                    <div class="clone"><i class="fa fa-plus"></i> Thêm</div>
                                                    <div class="remove"><i class="fa fa-minus"></i> Xóa</div>
                                                </div>
                                                <h3>
                                                    <input name="cv_info_title[]" class="exp-title" contenteditable="true" placeholder="Tên công ty" value="Đại học sàn kế toán">
                                                </h3>
                                                <p class="h3"><input name="cv_info_name[]" class="exp-subtitle" placeholder="Vị trí công việc" contenteditable="true" value="Thêm những thông tin khác ( nếu cần )">
                                                </p>
                                                <textarea name="cv_info_des[]" class="exp-content" contenteditable="true" placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">
                                        </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="cv-right">
                                <div class="ir">
                                    <div id="sortable">
                                        <div id="box01" class="block cvo-block box-contact">
                                            <p class="icoweb cvi-envelope-square"><input type="email" id="cv-profile-email" placeholder="Email" contenteditable="true" name="cv_email" value=""></p>
                                            <p class="icoweb cvi-phone"><input id="cv-profile-phone" placeholder="Điện thoại" contenteditable="true" name="cv_phone" value=""></p>
                                            <!--                                            --><?php
                                            //                                            $date = '';
                                            //                                            $date=date_create($employee->birthday);
                                            //                                            ?>
                                            <p class="icoweb cvi-date"><input id="cv-profile-birthday" placeholder="Ngày sinh" contenteditable="true" name="cv_birthday" value=""></p>
                                            <p class="icoweb cvi-map-marker"><input id="cv-profile-address" placeholder="Địa chỉ" contenteditable="true" name="cv_address" value="" ></p>
                                            <p class="icoweb cvi-info"><input id="cv-profile-face" placeholder="Website" contenteditable="true" name="cv_facebook" value=""></p>
                                        </div>

                                        <div id="box02" class="block cvo-block">
                                            <input type="hidden" name="cv_order[]" value="2">
                                            <div class="blockControls">
                                                <div title="Di chuyển khối" class="show-layout-editor"><i class="fa fa-bars"></i></div>
                                                <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn</div>
                                            </div>
                                            <h3>
                                                <input id="cv-boxtitle" name="cv_title_career_goals" cv-form-field="true" contenteditable="true" placeholder="Mục tiêu nghề nghiệp" class="box-title input_title" value="Mục tiêu nghề nghiệp">
                                            </h3>
                                            <textarea name="cv_career_goals" class="box-content" contenteditable="true" > Mục tiêu ngắn hạn:Tìm được môi trường làm việc mới phù hợp, với những kiến thức và kinh nghiệm có được về công việc kế toán. Tôi mong muốn rằng sẽ đóng góp trong sự phát triển của công ty trong tương lai.
Mục tiêu dài hạn: Trở thành kiểm toán viên </textarea>


                                        </div>

                                        <div id="box03" class="block cvo-block box-skills">
                                            <input type="hidden" name="cv_order[]" value="3">
                                            <div class="blockControls">
                                                <div title="Di chuyển khối" class="show-layout-editor"><i class="fa fa-bars"></i></div>
                                                <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn</div>
                                            </div>
                                            <h3><input id="cv-boxtitle" name="title_cv_skills" cv-form-field="true" contenteditable="true" placeholder="Tiêu đề" class="box-title" value="Kỹ năng">
                                            </h3>
                                            <div class="exp content-edit skill">
                                                <div class="ctbx">
                                                    <div class="fieldgroup_controls">
                                                        <div class="clone"><i class="fa fa-plus"></i> Thêm</div>
                                                        <div class="edit js-edit-content"> Sửa</div>
                                                        <div class="remove"><i class="fa fa-minus"></i> Xóa</div>
                                                    </div>
                                                    <input name="cv_skill_title[]" class="skill-name" cv-form-field="true" contenteditable="true" value="Tin học văn phòng">
                                                    <div class="bar-exp">
                                                        <div style="width: 50%"></div>
                                                    </div>
                                                    <div class="bar-value-exp"><input name="cv_skill_value[]" min="0" max="100" type="text" value="50"></div>
                                                </div>
                                                <div class="ctbx">
                                                    <div class="fieldgroup_controls">
                                                        <div class="clone"><i class="fa fa-plus"></i> Thêm</div>
                                                        <div class="edit js-edit-content"> Sửa</div>
                                                        <div class="remove"><i class="fa fa-minus"></i> Xóa</div>
                                                    </div>
                                                    <input name="cv_skill_title[]" class="skill-name" cv-form-field="true" contenteditable="true" value="Tiếng Anh giao tiếp">
                                                    <div class="bar-exp">
                                                        <div style="width: 80%"></div>
                                                    </div>
                                                    <div class="bar-value-exp"><input min="0" max="100" type="text" value="80" name="cv_skill_value[]"></div>
                                                </div>
                                                <div class="clr"></div>
                                            </div>
                                        </div>

                                        <div id="box04" class="block cvo-block">
                                            <input type="hidden" name="cv_order[]" value="4">
                                            <div class="blockControls">
                                                <div title="Di chuyển khối" class="show-layout-editor"><i class="fa fa-bars"></i></div>
                                                <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn</div>
                                            </div>
                                            <h3>
                                                <input id="cv-boxtitle" cv-form-field="true" contenteditable="true" placeholder="Tiêu đề" class="box-title" value="Giải thưởng" name="cv_title_prize">
                                            </h3>
                                            <p><textarea class="box-content" name="cv_interests" placeholder="Nội dung" contenteditable="true">
- Giải ba đề tài nghiên cứu khoa học sinh viên cấp trường.
- Bằng khen của Đoàn trường, Thành Đoàn Hà Nội vì có thành tích xuất sắc trong quá trình tham gia công tác đoàn đội tại trường đại học.</textarea>
                                            </p>
                                        </div>

                                        <div id="box05" class="block cvo-block">
                                            <input type="hidden" name="cv_order[]" value="5">
                                            <div class="blockControls">
                                                <div title="Di chuyển khối" class="show-layout-editor"><i class="fa fa-bars"></i></div>
                                                <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn</div>
                                            </div>
                                            <h3>
                                                <input id="cv-boxtitle" cv-form-field="true" contenteditable="true" placeholder="Tiêu đề" class="box-title" value="Chứng chỉ" name="cv_title_card">
                                            </h3>
                                            <p><textarea name="cv_card" class="box-content" placeholder="Nội dung" contenteditable="true">
- Chứng chỉ kế toán tổng hợp
- Chứng chỉ ứng dụng công nghệ thông tin cơ bản
- Chứng chỉ tiếng anh B1 </textarea>
                                            </p>
                                        </div>

                                        <div id="box06" class="block cvo-block">
                                            <input type="hidden" name="cv_order[]" value="6">
                                            <div class="blockControls">
                                                <div title="Di chuyển khối" class="show-layout-editor"><i class="fa fa-bars"></i></div>
                                                <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn</div>
                                            </div>
                                            <h3>
                                                <input id="cv-boxtitle" cv-form-field="true" contenteditable="true" placeholder="Tiêu đề" class="box-title" value="Sở thích" name="cv_title_interests">
                                            </h3>
                                            <p><textarea name="cv_interests" class="box-content" placeholder="Nội dung" contenteditable="true">
- Đọc sách
- Xem phim
- Chụp ảnh
- Tình nguyện </textarea>
                                            </p>
                                        </div>

                                        <div id="box07" class="block cvo-block">
                                            <input type="hidden" name="cv_order[]" value="7">
                                            <div class="blockControls">
                                                <div title="Di chuyển khối" class="show-layout-editor"><i class="fa fa-bars"></i></div>
                                                <div title="Chuyển mục này lên trên" class="up">▲</div>
                                                <div title="Chuyển mục này xuống dưới" class="down">▼</div>
                                                <div title="Ẩn mục này" class="hide"><i class="fa fa-minus"></i> Ẩn</div>
                                            </div>
                                            <h3>
                                                <input id="cv-boxtitle" cv-form-field="true" contenteditable="true" placeholder="Tiêu đề" class="box-title" value="Người tham chiếu" name="cv_title_reference_person"></input>
                                            </h3>
                                            <p><textarea name="cv_reference_person" class="box-content editor" id="cv_reference_person" placeholder="Nội dung" contenteditable="true">
 - Nguyễn Thị B
 – Kế toán trưởng
 - Công ty CP CV365
 - SĐT: 0123456789</textarea>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="editor"></div>
            {{--<form method="POST" enctype="multipart/form-data" action="https://timviec365.vn/cv365/render.php" id="myForm">--}}
            {{--<input type="hidden" name="_token" id="token" value="jtLmAMkVjRI6kEeOCTuF" />--}}
            {{--<input type="hidden" name="img_val" id="img_val" value="" />--}}
            {{--<input type="hidden" id="uid_cv" name="uid" value="" />--}}
            {{--<input type="hidden" id="ckcook" name="ckcook" value="0" />--}}
            {{--<input type="hidden" name="name_img" value="kế toán 9">--}}
            {{--</form>--}}
            <!--End giao dien mau thu -->

            </div>
        </div>
        </div>
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
    <script src="{{ asset('employee_cv') }}/cropper.js" type="text/javascript"></script>
    <script src="{{ asset('employee_cv') }}/jquery.validate.min.js"></script>
    <script src="{{ asset('employee_cv') }}/html2canvas.js"></script>
    <script src="{{ asset('employee_cv') }}/main.js@v=10"></script>
    <script src="{{ asset('employee_cv') }}/cvh.js@v=20"></script>
    <script src="{{ asset('employee_cv') }}/select2.min.js"></script>
    <script src="{{ asset('employee_cv') }}/edit.js"></script>




    <script src="{{ asset('employee_cv') }}/select2.min.js"></script>
    {{--<div id="loadjs"></div>--}}

    <script src="{{ asset('employee_cv') }}/html2canvas.js"></script>
    <script src="{{ asset('employee_cv') }}/dist/jspdf.debug.js"></script>
    <script src="{{ asset('employee_cv') }}/slick/slick.min.js"></script>
    <link rel="stylesheet" href="{{ asset('employee_cv') }}/select2.min.css" media="print" onload="if(media!='all')media='all'">
    <style>
        .select2-container--default .select2-selection--multiple,.select2-container--default.select2-container--focus .select2-selection--multiple{border-color:#e3e3e3;outline:0}.select2-container .select2-selection--single{height:40px;font-size:14px}.select2-container--default .select2-selection--single .select2-selection__rendered{height:38px;line-height:38px}.select2-container--default .select2-selection--single .select2-selection__arrow{top:7px}.select2-container--default .select2-selection--single{border-radius:4px!important;border-color:#e3e3e3}.select2-container .select2-selection--multiple{min-height:40px}.select2-container .select2-search--inline .select2-search__field{font-size: 14px;line-height: normal;padding-top: 5px;}
    </style>
    <script src="{{ asset('employee_cv') }}/jquery.validate.min.js" async></script>
    <script src="{{ asset('employee_cv') }}/cv.js@v=42" async></script>

    <script type="text/javascript">
        if ($( window ).width() < 1180) {$("footer,.hd_top").css("width","1170");}
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css') }}/cusStyle_cv.css">
    {{--<link rel="stylesheet" href="{{ asset('employee_cv') }}/fonts/font_css.css" media="print" onload="if(media!='all')media='all'">--}}
    <script>
        $('textarea').each(function () {
            this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
        }).on('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    </script>

@endsection