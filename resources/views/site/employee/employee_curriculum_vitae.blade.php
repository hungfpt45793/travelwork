@extends('site.layout.site')

@section('title', 'Sơ yếu lý lịch')
@section('meta_description', 'Sơ yếu lý lịch')
@section('keywords', 'Sơ yếu lý lịch')

@section('content')


<link rel="stylesheet" type="text/css" href="/public/assets/css/so-yeu-ly-lich.css" />
<style>
    .none_in_hoso{
        display:none;
    }
    input,textarea{
        color:rgb(26, 77, 172);
    }
    input:focus,textarea:focus{
        color:rgb(26, 77, 172);
    } 
</style>
<?php
//      echo '<pre>';
//      print_r($employee_curriculum);die();
//
//?>
<section class="content bgrGray pdt5 curriculum">
    <div class="container-fluid ">
        <div class="row ">
            @include('site.sidebar.sidebar_job_face')
            <div class="col-xl-9 col-lg-8 col-md-12">
                {{--<div class="link bgrWhite md-mgt20 disOnMobile">--}}
                    {{--<ul class="nav">--}}
                        {{--<li class="nav-item pd8">--}}
                            {{--<a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item pd8">--}}
                            {{--<p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item pd8">--}}
                            {{--<a href="{{ route('show_step_profile_employee') }}" class=" f18 md-f14 mgb0">Cập nhật hồ sơ</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item pd8">--}}
                            {{--<p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item pd8">--}}
                            {{--<a href="#" class=" f18 md-f14 mgb0">Sơ yếu lý lịch</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}

                <div class="InfoCompanyJob bgrWhite mgt20 pd20">
                    <div class="row step_center_block">
                        <div class="item_step">
                            <?php
                            //xác thực tài khoản
                            $check_status_email_account = '';
                            $check_status_email_account = \App\Entity\User::check_status_email_account(\Illuminate\Support\Facades\Auth::user()->id)
                            //status_email_account
                            ?>
                            @if(!empty($check_status_email_account))
                                <a class="clgreen " href="#" data-toggle="modal" data-target="#step_status_acoount">
                                    <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                                    <span class="clgreen f16"> Xác thực tài khoản</span>
                                </a>
                            @else
                                <a class="clorang  item_no_success" href="#" data-toggle="modal" data-target="#step_status_acoount">
                                    <span><i class="fas fa-check  step_icon "></i></span>
                                    <span class="clorang f16"> Xác thực tài khoản</span>
                                </a>
                            @endif
                            <img class="next_step" src="{{ asset('assets/image/next.png') }}">
                            <div class="modal fade" id="step_status_acoount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Xác thực tài khoản</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Lưu ý : Nếu bạn thay đổi thông tin sơ yếu lý lịch thì bạn vui lòng lưu thay đổi trước khi quay lại bước xác thực tài khoản</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a type="button" class="btn btn-secondary" data-dismiss="modal" style="    padding: .375rem .75rem;;color: #fff">Đóng</a>
                                            <a type="button" class="btn btn-primary" href="{{ route('management_account') }}" style="    padding: .375rem .75rem;">Quay lại</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item_step">
                            <?php
                            //check ti le hoan thien tho so
                            $check_info_profile = '';
                            $check_info_profile = \App\Entity\Employee::check_info_profile(\Illuminate\Support\Facades\Auth::user()->id);
                            ?>
                            @if(!empty($check_info_profile))
                                <a class="clgreen" href="#" data-toggle="modal" data-target="#step_update_profile">
                                    <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                                    <span class="clgreen  f16"> Hoàn thiện hồ sơ</span>
                                </a>
                            @else
                                <a class="clorange " href="#" data-toggle="modal" data-target="#step_update_profile">

                                    <span><i class="fas fa-users step_icon"></i></span>
                                    <span class=" clorange f16"> Hoàn thiện hồ sơ</span>
                                </a>
                            @endif

                            <img class="next_step" src="{{ asset('assets/image/next.png') }}">
                            <div class="modal fade" id="step_update_profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hoàn thiện hồ sơ</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Lưu ý : Nếu bạn thay đổi thông tin sơ yếu lý lịch thì bạn vui lòng lưu thay đổi trước khi quay lại bước hoàn thiện hồ sơ</p>

                                        </div>
                                        <div class="modal-footer">
                                            <a type="button" class="btn btn-secondary" data-dismiss="modal" style="    padding: .375rem .75rem;;color: #fff">Đóng</a>
                                            <a type="button" class="btn btn-primary" href="{{ route('show_file_job_facebook') }}" style="    padding: .375rem .75rem;">Quay lại</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="item_step">
                            <?php
                            //xác thực tài khoản
                            $employee_id_cv = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
                            $check_cv_employee = '';
                            $check_cv_employee = \App\Entity\Cv_employee::check_cv_employee($employee_id_cv->employee_id);
                            ?>
                            @if(!empty($check_cv_employee))
                                <a class="clgreen" href="#" data-toggle="modal" data-target="#step_create_CV">
                                    <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                                    <span class=" clgreen f16"> Tạo CV</span>
                                </a>
                            @else
                                <a class="clorange item_no_success" href="#" data-toggle="modal" data-target="#step_create_CV">

                                    <span><i class="fas fa-id-card step_icon"></i></span>
                                    <span class=" clorange f16"> Tạo CV</span>
                                </a>
                            @endif

                            <img class="next_step" src="{{ asset('assets/image/next.png') }}">
                                <div class="modal fade" id="step_create_CV" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Tạo CV</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Lưu ý : Nếu bạn thay đổi thông tin sơ yếu lý lịch thì bạn vui lòng lưu thay đổi trước khi quay lại bước Tạo CV</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a type="button" class="btn btn-secondary" data-dismiss="modal" style="    padding: .375rem .75rem;;color: #fff">Đóng</a>
                                                <a type="button" class="btn btn-primary" href="{{ route('create_emplyee_cv') }}" style="    padding: .375rem .75rem;">Quay lại</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>

                        <div class="item_step">
                            <?php
                            //so yeu ly lich ung vien
                            $employee_id_cv = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
                            $check_syll_employee = '';
                            $check_syll_employee = \App\Entity\Employee_curriculum::check_syll_employee($employee_id_cv->employee_id);
                            ?>
                            @if(!empty($check_syll_employee))
                                <a class=" clgreen step_active_link_success "
                                   href="#">
                                    <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                                    <span class=" clgreen f16">Sơ yếu lý lịch</span>
                                </a>
                            @else
                                <a class=" clorange  step_active_link item_no_success"
                                   href="#">

                                    <span><i class="fas fa-info step_icon"></i></span>
                                    <span class=" clorange f16">Sơ yếu lý lịch</span>
                                </a>
                            @endif

                        </div>

                    </div>
                </div>


                <div class="bgrWhite mgt20 pdb15">
                    <p id="letter-title" class="non-printable pd20 pdb0 clgreen f18 mgb0">
                        Mẫu sơ yếu lý lịch
                    </p>
                    <div class="pdl20 pdr20 pdb0 pdt5 clred f14 mgb10">Lưu ý : Một số thông tin trong phần sơ yếu
                        lý lịch sẽ được lấy theo thông tin hồ sơ mà bạn đã cập nhật trước đó ! Nếu bạn muốn
                        thay đổi các thông tin này? Vui lòng thay đổi trong phần quản lý hồ sơ
                    </div>

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
                </div>
                <form action="{{ route('post_employee_curriculum_vitae') }}" method="post" id="formcv" class="mbformUpdateEmployee"
                    enctype="multipart/form-data" id="form_update_user">
                    {!! csrf_field() !!}
                    <div class="col-6 js_fixcel" style="    margin: auto;
                    position: fixed;
                    bottom: 60px;
                    width:30%;
                    right: 0px!important;
                    z-index: 999999;">
                        <div class="show_hiddel_mobile" style="display:inline-block;float:right">
                            <a href="{{ route('create_emplyee_cv') }}" class="btn js_btn_loading_curri" style="display:inline-block;background-color: #02b5e1;color:#fff"> <i class="fas fa-long-arrow-alt-left"></i> Quay lại</a>

                            <button type="submit" id="" class="btn js_btn_loading_curri" style="display:inline-block;background-color: #02b5e1;color:#fff">Lưu thay đổi</button>
                            <button type="submit" formtarget="_blank" value="export" name="export" style="display:inline-block;background-color: #02b5e1;color:#fff" class="btn">Xuất PDF</button>
                        </div>
                    </div>
                    <div id="scollProduct">
                        <div class="maxHeight_employee_curri">
                            <div class="content_curriculum bgrWhite">

                                <div id="page-letter">

                                    <div id="form-letter">
                                        <div id="page1">
                                            <div class="page_ctr">
                                                <p class="p1-head">
                                                    CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM<br>Độc lập - Tự do - Hạnh phúc
                                                </p>
                                                <div id="cvo-profile-avatar-wraper">

                                                    {{--<input type="button" onclick="return uploadImage(this);"--}}
                                                    {{--value="Chọn ảnh"--}}
                                                    {{--size="20" class="error_text_images"/>--}}
                                                    {{--<img src="{{ isset($employee->employee_image) ? $employee->employee_image : '' }}"--}}
                                                    {{--width="80" height=""/>--}}
                                                    {{--<input name="images" type="text"--}}
                                                    {{--value="{{ isset($employee->employee_image) ? $employee->employee_image: '' }}"--}}
                                                    {{--style="border:none !important;color: #fff !important;position: absolute;left: 0;width: 84px;z-index: -9;"/>--}}





                                                    <input type="button" onclick="return uploadImage(this);"
                                                        value="Chọn ảnh 4x6" size="20" class=""
                                                        style="margin-left: 40px" />

                                                    @if (isset($employee_curriculum->anh4x6))
                                                        <img class="lazy" id="cvo-profile-avatar" cvo-form-field="true"
                                                        onclick="return uploadImage(this);"
                                                        data-src="{{ $employee_curriculum->anh4x6 }}">

                                                    @elseif(isset($employee->employee_image))
                                                    <img class="lazy" id="cvo-profile-avatar" cvo-form-field="true"
                                                    onclick="return uploadImage(this);"
                                                    data-src="{{ $employee->employee_image }}">
                                                    @else
                                                    <img class="lazy" id="cvo-profile-avatar" cvo-form-field="true"
                                                    onclick="return uploadImage(this);"
                                                    data-src="{{ asset('public/assets/image/no_avatar.jpg') }} ">
                                                    @endif

                                                    <input name="anh4x6" type="text"
                                                        value="{{ isset($employee_curriculum->anh4x6) ? $employee_curriculum->anh4x6 : $employee->employee_image }}"
                                                        style="border:none !important;color: #fff !important;position: absolute;left: 0;width: 84px;z-index: -9;" />


                                                </div>
                                                <p class="h1">SƠ YẾU LÝ LỊCH<br><i>TỰ THUẬT</i></p>
                                                <div class="p1-d1">
                                                    <div class="tx_nm hvt">Họ và tên:</div>
                                                    <input id="hoten" class="line" cvo-placeholder="" maxlength="50"
                                                        value="{{ isset($employee_curriculum->hoten) ? $employee_curriculum->hoten : $employee->employee_name }}">
                                                    <div class="tx_nm gioitinh">Nam, Nữ:</div>
                                                    <input id="gioitinh" name="gioitinh" class="line" cvo-placeholder=""
                                                        @if(empty($employee_curriculum->gioitinh))
                                                    @if($employee->gender == 1) value="Nữ"
                                                    @endif
                                                    @if($employee->gender == 2) value="Nam"
                                                    @endif
                                                    @else
                                                    value="{{ $employee_curriculum->gioitinh }}"
                                                    @endif
                                                    >

                                                </div>
                                                <?php
                                                    $date_birdth = '';
                                                    if (!empty($employee->birthday)) {
                                                        $date_birdth = date_create($employee->birthday);
                                                        $ngaysinh = $date_birdth->format('d');
                                                        $thangsinh = $date_birdth->format('m');
                                                        $namsinh = $date_birdth->format('Y');
                                                    }
                                                    else {
                                                        $ngaysinh = '';
                                                        $thangsinh = '';
                                                        $namsinh = '';
                                                    }
                                                    $date_birdth = '';
                                                    $ns_ngay = !empty($employee_curriculum->ns_ngay) ?  $employee_curriculum->ns_ngay : $ngaysinh ;
                                                    $ns_thang = !empty($employee_curriculum->ns_thang) ?  $employee_curriculum->ns_thang :  $thangsinh ;
                                                    $ns_nam = !empty($employee_curriculum->ns_nam) ?  $employee_curriculum->ns_nam : $namsinh ;
                                                    ?>

                                                <div class="p1-d1 h20">
                                                    <div class="tx_nm ns_ngay">Sinh ngày</div>
                                                    <input id="ns_ngay" name="ns_ngay" class="line" type="number"
                                                        cvo-placeholder="" contenteditable="" value="{{ !empty($ns_ngay) ? $ns_ngay : '' }}">
                                                    <div class="tx_nm ns_thang">tháng</div>
                                                    <input id="ns_thang" name="ns_thang" class="line" type="number"
                                                        cvo-placeholder="" contenteditable=""  value="{{ (!empty($ns_thang)) ? $ns_thang : '' }}">
                                                    <div class="tx_nm ns_nam">năm</div>
                                                    <input id="ns_nam" name="ns_nam" class="line" type="number"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ (!empty($ns_nam)) ? $ns_nam : '' }}">&nbsp;
                                                </div>


                                                <div class="p1-d1">
                                                    <div class="tx_nm dk_tt">Nơi ở đăng ký hộ khẩu thường trú hiện nay:
                                                    </div>
                                                    <textarea id="dk_tt" class="d2 line" cvo-placeholder=""
                                                        contenteditable="" rows="2"
                                                        name="dk_tt">{!! !empty($employee_curriculum->dk_tt) ? $employee_curriculum->dk_tt : '' !!} </textarea>
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm cmtnd">Chứng minh thư nhân dân số:</div>
                                                    <input id="cmtnd" name="cmtnd" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ isset($employee_curriculum->cmtnd) ? $employee_curriculum->cmtnd : $employee->cmt }}">&nbsp;
                                                    <div class="tx_nm noicap">Nơi cấp:</div>
                                                    <input id="noicap" name="noicap" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ isset($employee_curriculum->noicap) ? $employee_curriculum->noicap : $employee->cmt_local }} ">&nbsp;
                                                </div>
                                                <?php

                                                    $datecmtnd = '';
                                                    if (!empty($employee->cmt_date)) {
                                                        $datecmtnd = date_create($employee->cmt_date);
                                                    }

                                                    $cm_ngay = !empty($employee_curriculum->cm_ngay) ?  $employee_curriculum->cm_ngay : '' ;
                                                    $cm_thang = !empty($employee_curriculum->cm_thang) ?  $employee_curriculum->cm_thang : '' ;
                                                    $cm_nam = !empty($employee_curriculum->cm_nam) ?  $employee_curriculum->cm_nam : '' ;


                                                    ?>
                                                <div class="p1-d1 h20">
                                                    <div class="tx_nm cm_ngay">Ngày</div>
                                                    <input id="cm_ngay" name="cm_ngay" class="line" cvo-placeholder=""
                                                        contenteditable="" value="{{ $cm_ngay }}">&nbsp;
                                                    <div class="tx_nm cm_thang">tháng</div>
                                                    <input id="cm_thang" name="cm_thang" class="line" cvo-placeholder=""
                                                        contenteditable="" value="{{ $cm_thang }}">&nbsp;
                                                    <div class="tx_nm cm_nam">năm</div>
                                                    <input id="cm_nam" name="cm_nam" class="line" cvo-placeholder=""
                                                        contenteditable="" value="{{ $cm_nam }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm dt_home">Số Điện thoại liên hệ: Nhà riêng</div>
                                                    <input id="dt_home" name="dt_home" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->dt_home)  ? $employee_curriculum->dt_home : '' }}">
                                                    <div class="tx_nm mobile">Di động</div>
                                                    <input id="mobile" name="mobile" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ isset($employee->phone) ? $employee->phone: '' }}">
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm baotin">Khi cần báo tin cho ai? ở đâu?:</div>
                                                    <textarea id="baotin" name="baotin" class="line d3"
                                                        cvo-placeholder="" contenteditable=""
                                                        rows="3">{!! !empty($employee_curriculum->baotin)  ? $employee_curriculum->baotin : '' !!}</textarea>
                                                </div>
                                                <div class="p1-d2">
                                                    <div class="ct_center">
                                                        <div class="tx_nm sohieu">Số hiệu:</div>
                                                        <input id="sohieu" name="sohieu" class="line" cvo-placeholder=""
                                                            contenteditable=""
                                                            value="{{ !empty($employee_curriculum->sohieu)  ? $employee_curriculum->sohieu : '' }}">
                                                    </div>
                                                    <div class="ct_center">
                                                        <div class="tx_nm kyhieu">Ký hiệu:</div>
                                                        <input id="kyhieu" name="kyhieu" class="line" cvo-placeholder=""
                                                            contenteditable=""
                                                            value="{{ !empty($employee_curriculum->kyhieu)  ? $employee_curriculum->kyhieu : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="page2">
                                            <div class="page_ctr">
                                                <div class="p1-d1">
                                                    <div class="tx_nm hoten_p2">Họ và tên:</div>
                                                    <input id="hoten_p2" name="hoten_p2" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->hoten_p2)  ? $employee_curriculum->hoten_p2 : $employee->employee_name }}">
                                                    <div class="tx_nm bidanh">Bí danh:</div>
                                                    <input id="bidanh" name="bidanh" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->bidanh)  ? $employee_curriculum->bidanh : '' }}">
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm tenthuonggoi">Tên thường gọi:</div>
                                                    <input id="tenthuonggoi" name="tenthuonggoi" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tenthuonggoi)  ? $employee_curriculum->tenthuonggoi : '' }}">
                                                </div>
                                                <div class="p1-d1 h20">
                                                    <div class="tx_nm ns_ngay_p2">Sinh ngày</div>
                                                    <input id="ns_ngay_p2" name="ns_ngay_p2" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->ns_ngay_p2)  ? $employee_curriculum->ns_ngay_p2 : $ngaysinh }}">
                                                    <div class="tx_nm ns_thang_p2">tháng</div>
                                                    <input id="ns_thang_p2" name="ns_thang_p2" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->ns_thang_p2)  ? $employee_curriculum->ns_thang_p2 :  $thangsinh }}">
                                                    <div class="tx_nm ns_nam_p2">năm</div>
                                                    <input id="ns_nam_p2" name="ns_nam_p2" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->ns_nam_p2)  ? $employee_curriculum->ns_nam_p2 :  $namsinh }}">&nbsp;
                                                    <div class="tx_nm tai_p2">Tại</div>
                                                    <input id="tai_p2" name="tai_p2" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tai_p2)  ? $employee_curriculum->tai_p2 : '' }}">
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm hoten">Nguyên quán:</div>
                                                    <input id="nguyenquan" name="nguyenquan" class="line d1"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->nguyenquan)  ? $employee_curriculum->nguyenquan : '' }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm hoten">Nơi ở đăng ký thường trú hiện nay:</div>
                                                    <input id="dk_tt_p2" name="dk_tt_p2" class="line d1"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->dk_tt_p2)  ? $employee_curriculum->dk_tt_p2 : '' }}">
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm dantoc">Dân tộc</div>
                                                    <input id="dantoc" name="dantoc" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->dantoc)  ? $employee_curriculum->dantoc : '' }}">&nbsp;
                                                    <div class="tx_nm tongiao">Tôn giáo</div>
                                                    <input id="tongiao" name="tongiao" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tongiao)  ? $employee_curriculum->tongiao : '' }}">
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm thanhphan_gd">Thành phần gia đình sau cải cách
                                                        ruộng
                                                        đất (hoặc cải tạo công thương nghiệp):
                                                    </div>
                                                    <input id="thanhphan_gd" name="thanhphan_gd" class="line d1"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->thanhphan_gd)  ? $employee_curriculum->thanhphan_gd : '' }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm thanhphan_bt">Thành phần bản thân hiện nay:</div>
                                                    <input id="thanhphan_bt" name="thanhphan_bt" class="line"
                                                        cvo-placeholder="" contenteditable="true"
                                                        value="{{ !empty($employee_curriculum->thanhphan_bt)  ? $employee_curriculum->thanhphan_bt : '' }}">
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm vanhoa">Trình độ văn hoá:</div>
                                                    <input id="vanhoa" name="vanhoa" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->vanhoa)  ? $employee_curriculum->vanhoa : '' }}">&nbsp;
                                                    <div class="tx_nm ngoaingu">Ngoại ngữ:</div>
                                                    <input id="ngoaingu" name="ngoaingu" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->ngoaingu)  ? $employee_curriculum->ngoaingu : '' }}">
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm chuyenmon">Trình độ chuyên môn:</div>
                                                    <input id="chuyenmon" name="chuyenmon" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->chuyenmon)  ? $employee_curriculum->chuyenmon : '' }}">
                                                    <div class="tx_nm loaihinh_dt">Loại hình đào tạo:</div>
                                                    <input id="loaihinh_dt" name="loaihinh_dt" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->loaihinh_dt)  ? $employee_curriculum->loaihinh_dt : '' }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm chuyennganh_dt">Chuyên ngành đào tạo:</div>
                                                    <input id="chuyennganh_dt" name="chuyennganh_dt" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->chuyennganh_dt)  ? $employee_curriculum->chuyennganh_dt : '' }}">&nbsp;
                                                    </input>
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm dang_ngay">Kết nạp Đảng cộng sản Việt Nam ngày
                                                    </div>
                                                    <input id="dang_ngay" name="dang_ngay" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->dang_ngay)  ? $employee_curriculum->dang_ngay : '' }}">
                                                    <div class="tx_nm dang_thang">tháng</div>
                                                    <input id="dang_thang" name="dang_thang" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->dang_thang)  ? $employee_curriculum->dang_thang : '' }}">&nbsp;
                                                    <div class="tx_nm dang_nam">năm</div>
                                                    <input id="dang_nam" name="dang_nam" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->dang_nam)  ? $employee_curriculum->dang_nam : '' }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm dang_ketnap">Nơi kết nạp:</div>
                                                    <input id="dang_ketnap" name="dang_ketnap" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->dang_ketnap)  ? $employee_curriculum->dang_ketnap : '' }}">
                                                </div>
                                                <div class="p1-d1 h20">
                                                    <div class="tx_nm doan_ngay">Ngày vào Đoàn TNCSHCM ngày</div>
                                                    <input id="doan_ngay" name="doan_ngay" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->doan_ngay)  ? $employee_curriculum->doan_ngay : '' }}">
                                                    <div class="tx_nm doan_thang">tháng</div>
                                                    <input id="doan_thang" name="doan_thang" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->doan_thang)  ? $employee_curriculum->doan_thang : '' }}">&nbsp;
                                                    <div class="tx_nm doan_nam">năm</div>
                                                    <input id="doan_nam" name="doan_nam" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->doan_nam)  ? $employee_curriculum->doan_nam : '' }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm doan_ketnap">Nơi kết nạp:</div>
                                                    <input id="doan_ketnap" name="doan_ketnap" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->doan_ketnap)  ? $employee_curriculum->doan_ketnap : '' }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm suckhoe">Tình hình sức khoẻ:</div>
                                                    <input id="suckhoe" name="suckhoe" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->suckhoe)  ? $employee_curriculum->suckhoe : '' }}">
                                                    <div class="tx_nm cao">Cao</div>
                                                    <input id="cao" name="cao" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->cao)  ? $employee_curriculum->cao : '' }}">
                                                    <div class="tx_nm can_nang">Cân nặng</div>
                                                    <input id="can_nang" name="can_nang" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->can_nang)  ? $employee_curriculum->can_nang : '' }}">
                                                    <div class="tx_nm can_nang2">kg</div>
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm nghenghiep_chuyenmon">Nghề nghiệp hoặc trình độ
                                                        chuyên
                                                        môn:
                                                    </div>
                                                    <input id="nghenghiep_chuyenmon" name="nghenghiep_chuyenmon"
                                                        class="line" cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->nghenghiep_chuyenmon)  ? $employee_curriculum->nghenghiep_chuyenmon : '' }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm capbac">Cấp bậc:</div>
                                                    <input id="capbac" name="capbac" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->capbac)  ? $employee_curriculum->capbac : '' }}">
                                                    <div class="tx_nm luongchinh">Lương chính hiện nay</div>
                                                    <input id="luongchinh" name="luongchinh" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->luongchinh)  ? $employee_curriculum->luongchinh : '' }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm ngaynhapngu">Ngày nhập ngũ:</div>
                                                    <input id="ngaynhapngu" name="ngaynhapngu" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->ngaynhapngu)  ? $employee_curriculum->ngaynhapngu : '' }}">&nbsp;
                                                    <div class="tx_nm ngayxuatngu">Ngày xuất ngũ:</div>
                                                    <input id="ngayxuatngu" name="ngayxuatngu" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->ngayxuatngu)  ? $employee_curriculum->ngayxuatngu : '' }}">
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm lydo_p2">Lý do</div>
                                                    <input id="lydo_p2" name="lydo_p2" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->lydo_p2)  ? $employee_curriculum->lydo_p2 : '' }}">&nbsp;
                                                </div>
                                                <p class="p-head">Hoàn cảnh gia đình</p>
                                                <div class="p1-d1 h20">
                                                    <div class="tx_nm htbo">Họ và tên bố:</div>
                                                    <input id="htbo" name="htbo" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->htbo)  ? $employee_curriculum->htbo : '' }}">&nbsp;
                                                    <div class="tx_nm tuoibo">Tuổi</div>
                                                    <input id="tuoibo" name="tuoibo" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tuoibo)  ? $employee_curriculum->tuoibo : '' }}">
                                                    <div class="tx_nm nn_bo">Nghề nghiệp</div>
                                                    <input id="nn_bo" name="nn_bo" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->nn_bo)  ? $employee_curriculum->nn_bo : '' }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm bo_thang8">Trước cách mạng tháng 8 làm gì? Ở đâu?

                                                    </div>
                                                    <textarea id="bo_thang8" name="bo_thang8" class="line d2"
                                                        cvo-placeholder=""
                                                        contenteditable="">&nbsp;{!! !empty($employee_curriculum->bo_thang8)  ? $employee_curriculum->bo_thang8 : '' !!} </textarea>
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm hoten">Trong kháng chiến chống thực dân Pháp làm
                                                        gì? Ở
                                                        đâu?
                                                    </div>
                                                    <textarea id="bo_khangphap" name="bo_khangphap" class="line d2"
                                                        cvo-placeholder="" contenteditable=""
                                                        rows="2">{!! !empty($employee_curriculum->bo_khangphap)  ? $employee_curriculum->bo_khangphap : '' !!}</textarea>
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm bo_1955">Từ năm 1955 đến nay làm gì? Ở đâu? (Ghi
                                                        rõ
                                                        tên cơ quan, xí nghiệp hiện nay đang làm)
                                                    </div>
                                                    <textarea id="bo_1955" name="bo_1955" class="line d2"
                                                        cvo-placeholder="" contenteditable=""
                                                        rows="2">{!! !empty($employee_curriculum->bo_1955)  ? $employee_curriculum->bo_1955 : '' !!}</textarea>
                                                </div>

                                            </div>
                                        </div>
                                        <div id="page3">
                                            <div class="page_ctr">
                                                <div class="p1-d1 h20">
                                                    <div class="tx_nm htme">Họ và tên mẹ:</div>
                                                    <input id="htme" name="htme" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->htme)  ? $employee_curriculum->htme : '' }}">&nbsp;
                                                    <div class="tx_nm tuoime">Tuổi</div>
                                                    <input id="tuoime" name="tuoime" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tuoime)  ? $employee_curriculum->tuoime : '' }}">&nbsp;
                                                    <div class="tx_nm nn_me">Nghề nghiệp</div>
                                                    <input id="nn_me" name="nn_me" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->nn_me)  ? $employee_curriculum->nn_me : '' }}">&nbsp;</input>
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm me_thang8">Trước cách mạng tháng 8 làm gì? Ở đâu?
                                                    </div>
                                                    <textarea id="me_thang8" name="me_thang8" class="line d2"
                                                        cvo-placeholder="" contenteditable=""
                                                        rows="2">{!! !empty($employee_curriculum->me_thang8)  ? $employee_curriculum->me_thang8 : '' !!}</textarea>
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm me_khangphap">Trong kháng chiến chống thực dân
                                                        Pháp
                                                        làm gì? Ở đâu?
                                                    </div>
                                                    <textarea id="me_khangphap" name="me_khangphap" class="line d2"
                                                        cvo-placeholder="" contenteditable=""
                                                        rows="2">{!! !empty($employee_curriculum->me_khangphap)  ? $employee_curriculum->me_khangphap : '' !!}</textarea>
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm me_1955">Từ năm 1955 đến nay làm gì? Ở đâu? (Ghi
                                                        rõ
                                                        tên cơ quan, xí nghiệp hiện nay đang làm)
                                                    </div>
                                                    <textarea id="me_1955" name="me_1955" class="line d4"
                                                        cvo-placeholder="" contenteditable=""
                                                        rows="3">{!! !empty($employee_curriculum->me_1955)  ? $employee_curriculum->me_1955 : '' !!}</textarea>
                                                </div>
                                                <p class="p-head">
                                                    Họ và tên anh chị em ruột<br><i>(Ghi rõ tên, tuổi, chỗ ở, nghề
                                                        nghiệp và
                                                        trình độ chính trị của từng người)</i>
                                                </p>
                                                <textarea id="giadinh" name="giadinh" class="dn" cvo-placeholder=""
                                                    contenteditable=""
                                                    rows="20">{!! !empty($employee_curriculum->giadinh)  ? $employee_curriculum->giadinh : '' !!}</textarea>
                                            </div>
                                        </div>
                                        <div id="page4">
                                            <div class="page_ctr">
                                                <div class="p1-d1">
                                                    <div class="tx_nm hotenvc">Họ và tên vợ hoặc chồng:</div>
                                                    <input id="hotenvc" name="hotenvc" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->hotenvc)  ? $employee_curriculum->hotenvc : '' }}">
                                                    <div class="tx_nm tuoivc">Tuổi</div>
                                                    <input id="tuoivc" name="tuoivc" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tuoivc)  ? $employee_curriculum->tuoivc : '' }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm nn_vc">Nghề nghiệp</div>
                                                    <input id="nn_vc" name="nn_vc" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->nn_vc)  ? $employee_curriculum->nn_vc : '' }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm noi_nn_vc">Nơi làm việc:</div>
                                                    <input id="noi_nn_vc" name="noi_nn_vc" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->noi_nn_vc)  ? $employee_curriculum->noi_nn_vc : '' }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm noio_vc">Chỗ ở hiện nay:</div>
                                                    <input id="noio_vc" name="noio_vc" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->noio_vc)  ? $employee_curriculum->noio_vc : '' }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    Họ và tên các con:
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm tencon1">1)</div>
                                                    <input id="tencon1" name="tencon1" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tencon1)  ? $employee_curriculum->tencon1 : '' }}">
                                                    <div class="tx_nm tuoicon1">Tuổi</div>
                                                    <input id="tuoicon1" name="tuoicon1" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tuoicon1)  ? $employee_curriculum->tuoicon1 : '' }}">
                                                    <div class="tx_nm nn_con1">Nghề nghiệp</div>
                                                    <input id="nn_con1" name="nn_con1" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->nn_con1)  ? $employee_curriculum->nn_con1 : '' }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm tencon1">2)</div>
                                                    <input id="tencon2" name="tencon2" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tencon2)  ? $employee_curriculum->tencon2 : '' }}">
                                                    <div class="tx_nm tuoicon2">Tuổi</div>
                                                    <input id="tuoicon2" name="tuoicon2" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tuoicon2)  ? $employee_curriculum->tuoicon2 : '' }}">
                                                    <div class="tx_nm nn_con2">Nghề nghiệp</div>
                                                    <input id="nn_con2" name="nn_con2" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->nn_con2)  ? $employee_curriculum->nn_con2 : '' }}">
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm tencon1">3)</div>
                                                    <input id="tencon3" name="tencon3" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tencon3)  ? $employee_curriculum->tencon3 : '' }}">
                                                    <div class="tx_nm tuoicon3">Tuổi</div>
                                                    <input id="tuoicon3" name="tuoicon3" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tuoicon3)  ? $employee_curriculum->tuoicon3 : '' }}">
                                                    <div class="tx_nm nn_con3">Nghề nghiệp</div>
                                                    <input id="nn_con3" name="nn_con3" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->nn_con3)  ? $employee_curriculum->nn_con3 : '' }}">&nbsp;
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm tencon1">4)</div>
                                                    <input id="tencon4" name="tencon4" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tencon4)  ? $employee_curriculum->tencon4 : '' }}">
                                                    <div class="tx_nm tuoicon4">Tuổi</div>
                                                    <input id="tuoicon4" name="tuoicon4" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tuoicon4)  ? $employee_curriculum->tuoicon4 : '' }}">&nbsp;
                                                    <div class="tx_nm nn_con4">Nghề nghiệp</div>
                                                    <input id="nn_con4" name="nn_con4" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->nn_con4)  ? $employee_curriculum->nn_con4 : '' }}">
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm tencon1">5)</div>
                                                    <input id="tencon5" name="tencon5" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tencon5)  ? $employee_curriculum->tencon5 : '' }}">
                                                    <div class="tx_nm tuoicon5">Tuổi</div>
                                                    <input id="tuoicon5" name="tuoicon5" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->tuoicon5)  ? $employee_curriculum->tuoicon5 : '' }}">&nbsp;
                                                    <div class="tx_nm nn_con5">Nghề nghiệp</div>
                                                    <input id="nn_con5" name="nn_con5" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->nn_con5)  ? $employee_curriculum->nn_con5 : '' }}">
                                                </div>
                                                <p class="p-head small">Quy trình hoạt động của bản thân</p>
                                                <table cellpadding="0" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <td width="17%">Từ tháng năm<br>đến tháng năm</td>
                                                            <td width="30%">Làm công tác gì</td>
                                                            <td width="23%">Ở đâu</td>
                                                            <td width="20%">Giữ chức vụ gì?</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <textarea id="ht_day" name="ht_day"
                                                                    class="d5 line cus_line" cvo-placeholder=""
                                                                    contenteditable=""
                                                                    rows="5">{!! !empty($employee_curriculum->ht_day)  ? $employee_curriculum->ht_day : '' !!}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea id="ht_congtac" name="ht_congtac"
                                                                    class="d5 line cus_line" cvo-placeholder=""
                                                                    contenteditable=""
                                                                    rows="5">{!! !empty($employee_curriculum->ht_congtac)  ? $employee_curriculum->ht_congtac : '' !!}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea id="ht_odau" name="ht_odau"
                                                                    class="d5 line cus_line" cvo-placeholder=""
                                                                    contenteditable=""
                                                                    rows="5">{!! !empty($employee_curriculum->ht_odau)  ? $employee_curriculum->ht_odau : '' !!}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea id="ht_chucvu" name="ht_chucvu"
                                                                    class="line cus_line" cvo-placeholder=""
                                                                    contenteditable=""
                                                                    rows="5">{!! !empty($employee_curriculum->ht_chucvu)  ? $employee_curriculum->ht_chucvu : '' !!}</textarea>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <p class="p-head">Khen thưởng và kỷ luật</p>
                                                <div class="p1-d1">
                                                    <div class="tx_nm khenthuong">Khen thưởng:</div>
                                                    <input id="khenthuong" name="khenthuong" class="line"
                                                        cvo-placeholder="" contenteditable=""
                                                        value="{{ !empty($employee_curriculum->khenthuong)  ? $employee_curriculum->khenthuong : '' }}">
                                                </div>
                                                <div class="p1-d1">
                                                    <div class="tx_nm kyluat">Kỷ luật:</div>
                                                    <input id="kyluat" name="kyluat" class="line" cvo-placeholder=""
                                                        contenteditable=""
                                                        value="{{ !empty($employee_curriculum->kyluat)  ? $employee_curriculum->kyluat : '' }}">&nbsp;
                                                </div>
                                                <p class="p-head small">Lời cam đoan</p>
                                                <div class="p1-d1" style="text-indent: 40px">
                                                    Tôi xin cam đoan những lời khai trên là đúng sự thực và chịu trách
                                                    nhiệm
                                                    về những lời khai đó. Nếu sau này cơ quan có thẩm quyền phát hiện
                                                    vấn đề
                                                    gì không đúng. Tôi xin chấp hành biện pháp xử lý theo quy định./.
                                                </div>
                                                <div class="p1-d1 l">
                                                    <strong>Xác nhận của Thủ trưởng Cơ quan,<br>Xí nghiệp, Chủ tịch UBND
                                                        Xã,
                                                        Phường</strong>
                                                    <textarea id="xacnhan" name="xacnhan" class="line d3"
                                                        cvo-placeholder="" contenteditable=""
                                                        rows="3">&nbsp;{!!  !empty($employee_curriculum->xacnhan)  ? $employee_curriculum->xacnhan : ''  !!}</textarea>
                                                </div>
                                                <div class="p1-d1 r">
                                                    <div class="w100">
                                                        <input id="local" name="local" class="line" cvo-placeholder=""
                                                            contenteditable=""
                                                            value="{{ !empty($employee_curriculum->local)  ? $employee_curriculum->local : '' }}">
                                                        <div class="tx_nm local_ngay">,Ngày</div>
                                                        <input id="local_ngay" name="local_ngay" class="line"
                                                            cvo-placeholder="" contenteditable=""
                                                            value="{{ !empty($employee_curriculum->local_ngay)  ? $employee_curriculum->local_ngay : '' }}">
                                                        <div class="tx_nm local_thang">tháng</div>
                                                        <input id="local_thang" name="local_thang" class="line"
                                                            cvo-placeholder="" contenteditable=""
                                                            value="{{ !empty($employee_curriculum->local_thang)  ? $employee_curriculum->local_thang : '' }}">
                                                        <div class="tx_nm local_nam">năm</div>
                                                        <input id="local_nam" name="local_nam" class="line"
                                                            cvo-placeholder="" contenteditable=""
                                                            value="{{ !empty($employee_curriculum->local_nam)  ? $employee_curriculum->local_nam : '' }}">
                                                    </div>
                                                    <p><strong>Người khai ký tên</strong><br>
                                                        <i>(Ký và ghi rõ họ tên)</i>
                                                    </p>
                                                </div>
                                            </div>


                                        </div>


                                    </div>

                                    <div class="btn_submit_curri">


                                        <div>
                                            <a href="{{ route('create_emplyee_cv') }}" class="btn js_btn_loading_curri" style="display:inline-block;background-color: #02b5e1;color:#fff"> <i class="fas fa-long-arrow-alt-left"></i> Quay lại</a>

                                            <button type="submit" id="" class="btn js_btn_loading_curri" style="display:inline-block;background-color: #02b5e1;color:#fff">Lưu thay đổi</button>
                                            <button type="submit" formtarget="_blank" value="export" name="export" style="display:inline-block;background-color: #02b5e1;color:#fff" class="btn">Xuất PDF</button>
                                        </div>
                                    </div>

                                </div>


                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="none_in_hoso">
            @include('site.module_index.hotline')
        </div>
    </div>
</section>
<style>
    .js_btn_loading_curri {
        cursor: pointer;
    }
    .js_btn_loading_pdf{
        cursor: pointer;
    }
</style>


<script>
  var height_scroll = $( window ).height();
  var position = $('.btn_submit_curri').position();
  console.log(position);

  $(window).scroll(function () {
      if ($(this).scrollTop() > 4100) {
          $('.js_fixcel').hide();
      } else {
          $('.js_fixcel').show();
      }
  });
    $('.js_btn_loading_curri').click(function () {
               $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lưu thay đổi...');
               $btn.attr('disabled', false);
       });
       $('.js_btn_loading_pdf').click(function () {
               $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang xuất pdf...');
               $btn.attr('disabled', false);
       });
</script>


@endsection