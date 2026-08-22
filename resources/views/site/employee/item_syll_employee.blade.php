
<?php
$employee = \App\Entity\Employee::get_detail_id($employee->employee_id);
$employee_curriculum ='';
$employee_curriculum = \App\Entity\Employee_curriculum::get_detail_syll($employee->employee_id);
?>
@if(!empty($employee_curriculum))
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

                                {{--<input readonly  type="button" onclick="return uploadImage(this);"--}}
                                {{--value="Chọn ảnh"--}}
                                {{--size="20" class="error_text_images"/>--}}
                                {{--<img src="{{ isset($employee->employee_image) ? $employee->employee_image : '' }}"--}}
                                {{--width="80" height=""/>--}}
                                {{--<input readonly  name="images" type="text"--}}
                                {{--value="{{ isset($employee->employee_image) ? $employee->employee_image: '' }}"--}}
                                {{--style="border:none !important;color: #fff !important;position: absolute;left: 0;width: 84px;z-index: -9;"/>--}}





                                @if (isset($employee_curriculum->anh4x6))
                                    <img class="lazy" id="cvo-profile-avatar" cvo-form-field="true"
                                         data-src="{{ $employee_curriculum->anh4x6 }}">

                                @elseif(isset($employee->employee_image))
                                    <img class="lazy" id="cvo-profile-avatar" cvo-form-field="true"
                                         data-src="{{ $employee->employee_image }}">
                                @else
                                    <img class="lazy" id="cvo-profile-avatar" cvo-form-field="true"
                                         data-src="{{ asset('public/assets/image/no_avatar.jpg') }} ">
                                @endif

                                <input readonly  name="anh4x6" type="text"
                                       value="{{ isset($employee_curriculum->anh4x6) ? $employee_curriculum->anh4x6 : $employee->employee_image }}"
                                       style="border:none !important;color: #fff !important;position: absolute;left: 0;width: 84px;z-index: -9;" />


                            </div>
                            <p class="h1">SƠ YẾU LÝ LỊCH<br><i>TỰ THUẬT</i></p>
                            <div class="p1-d1">
                                <div class="tx_nm hvt">Họ và tên:</div>
                                <input readonly  id="hoten" class="line" cvo-placeholder="" maxlength="50"
                                       value="{{ isset($employee_curriculum->hoten) ? $employee_curriculum->hoten : $employee->employee_name }}">
                                <div class="tx_nm gioitinh">Nam, Nữ:</div>
                                <input readonly  id="gioitinh" name="gioitinh" class="line" cvo-placeholder=""
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
                                <input readonly  id="ns_ngay" name="ns_ngay" class="line" type="number"
                                       cvo-placeholder="" contenteditable="" value="{{ !empty($ns_ngay) ? $ns_ngay : '' }}">
                                <div class="tx_nm ns_thang">tháng</div>
                                <input readonly  id="ns_thang" name="ns_thang" class="line" type="number"
                                       cvo-placeholder="" contenteditable=""  value="{{ (!empty($ns_thang)) ? $ns_thang : '' }}">
                                <div class="tx_nm ns_nam">năm</div>
                                <input readonly  id="ns_nam" name="ns_nam" class="line" type="number"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ (!empty($ns_nam)) ? $ns_nam : '' }}">&nbsp;
                            </div>


                            <div class="p1-d1">
                                <div class="tx_nm dk_tt">Nơi ở đăng ký hộ khẩu thường trú hiện nay:
                                </div>
                                <textarea readonly  id="dk_tt" class="d2 line" cvo-placeholder=""
                                          contenteditable="" rows="2"
                                          name="dk_tt">{!! !empty($employee_curriculum->dk_tt) ? $employee_curriculum->dk_tt : '' !!} </textarea>
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm cmtnd">Chứng minh thư nhân dân số:</div>
                                <input readonly  id="cmtnd" name="cmtnd" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ isset($employee_curriculum->cmtnd) ? $employee_curriculum->cmtnd : $employee->cmt }}">&nbsp;
                                <div class="tx_nm noicap">Nơi cấp:</div>
                                <input readonly  id="noicap" name="noicap" class="line" cvo-placeholder=""
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
                                <input readonly  id="cm_ngay" name="cm_ngay" class="line" cvo-placeholder=""
                                       contenteditable="" value="{{ $cm_ngay }}">&nbsp;
                                <div class="tx_nm cm_thang">tháng</div>
                                <input readonly  id="cm_thang" name="cm_thang" class="line" cvo-placeholder=""
                                       contenteditable="" value="{{ $cm_thang }}">&nbsp;
                                <div class="tx_nm cm_nam">năm</div>
                                <input readonly  id="cm_nam" name="cm_nam" class="line" cvo-placeholder=""
                                       contenteditable="" value="{{ $cm_nam }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm dt_home">Số Điện thoại liên hệ: Nhà riêng</div>
                                <input readonly  id="dt_home" name="dt_home" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->dt_home)  ? $employee_curriculum->dt_home : '' }}">
                                <div class="tx_nm mobile">Di động</div>
                                <input readonly  id="mobile" name="mobile" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ isset($employee->phone) ? $employee->phone: '' }}">
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm baotin">Khi cần báo tin cho ai? ở đâu?:</div>
                                <textarea readonly  id="baotin" name="baotin" class="line d3"
                                          cvo-placeholder="" contenteditable=""
                                          rows="3">{!! !empty($employee_curriculum->baotin)  ? $employee_curriculum->baotin : '' !!}</textarea>
                            </div>
                            <div class="p1-d2">
                                <div class="ct_center">
                                    <div class="tx_nm sohieu">Số hiệu:</div>
                                    <input readonly  id="sohieu" name="sohieu" class="line" cvo-placeholder=""
                                           contenteditable=""
                                           value="{{ !empty($employee_curriculum->sohieu)  ? $employee_curriculum->sohieu : '' }}">
                                </div>
                                <div class="ct_center">
                                    <div class="tx_nm kyhieu">Ký hiệu:</div>
                                    <input readonly  id="kyhieu" name="kyhieu" class="line" cvo-placeholder=""
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
                                <input readonly  id="hoten_p2" name="hoten_p2" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->hoten_p2)  ? $employee_curriculum->hoten_p2 : $employee->employee_name }}">
                                <div class="tx_nm bidanh">Bí danh:</div>
                                <input readonly  id="bidanh" name="bidanh" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->bidanh)  ? $employee_curriculum->bidanh : '' }}">
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm tenthuonggoi">Tên thường gọi:</div>
                                <input readonly  id="tenthuonggoi" name="tenthuonggoi" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->tenthuonggoi)  ? $employee_curriculum->tenthuonggoi : '' }}">
                            </div>
                            <div class="p1-d1 h20">
                                <div class="tx_nm ns_ngay_p2">Sinh ngày</div>
                                <input readonly  id="ns_ngay_p2" name="ns_ngay_p2" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->ns_ngay_p2)  ? $employee_curriculum->ns_ngay_p2 : $ngaysinh }}">
                                <div class="tx_nm ns_thang_p2">tháng</div>
                                <input readonly  id="ns_thang_p2" name="ns_thang_p2" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->ns_thang_p2)  ? $employee_curriculum->ns_thang_p2 :  $thangsinh }}">
                                <div class="tx_nm ns_nam_p2">năm</div>
                                <input readonly  id="ns_nam_p2" name="ns_nam_p2" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->ns_nam_p2)  ? $employee_curriculum->ns_nam_p2 :  $namsinh }}">&nbsp;
                                <div class="tx_nm tai_p2">Tại</div>
                                <input readonly  id="tai_p2" name="tai_p2" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->tai_p2)  ? $employee_curriculum->tai_p2 : '' }}">
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm hoten">Nguyên quán:</div>
                                <input readonly  id="nguyenquan" name="nguyenquan" class="line d1"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->nguyenquan)  ? $employee_curriculum->nguyenquan : '' }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm hoten">Nơi ở đăng ký thường trú hiện nay:</div>
                                <input readonly  id="dk_tt_p2" name="dk_tt_p2" class="line d1"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->dk_tt_p2)  ? $employee_curriculum->dk_tt_p2 : '' }}">
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm dantoc">Dân tộc</div>
                                <input readonly  id="dantoc" name="dantoc" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->dantoc)  ? $employee_curriculum->dantoc : '' }}">&nbsp;
                                <div class="tx_nm tongiao">Tôn giáo</div>
                                <input readonly  id="tongiao" name="tongiao" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->tongiao)  ? $employee_curriculum->tongiao : '' }}">
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm thanhphan_gd">Thành phần gia đình sau cải cách
                                    ruộng
                                    đất (hoặc cải tạo công thương nghiệp):
                                </div>
                                <input readonly  id="thanhphan_gd" name="thanhphan_gd" class="line d1"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->thanhphan_gd)  ? $employee_curriculum->thanhphan_gd : '' }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm thanhphan_bt">Thành phần bản thân hiện nay:</div>
                                <input readonly  id="thanhphan_bt" name="thanhphan_bt" class="line"
                                       cvo-placeholder="" contenteditable="true"
                                       value="{{ !empty($employee_curriculum->thanhphan_bt)  ? $employee_curriculum->thanhphan_bt : '' }}">
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm vanhoa">Trình độ văn hoá:</div>
                                <input readonly  id="vanhoa" name="vanhoa" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->vanhoa)  ? $employee_curriculum->vanhoa : '' }}">&nbsp;
                                <div class="tx_nm ngoaingu">Ngoại ngữ:</div>
                                <input readonly  id="ngoaingu" name="ngoaingu" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->ngoaingu)  ? $employee_curriculum->ngoaingu : '' }}">
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm chuyenmon">Trình độ chuyên môn:</div>
                                <input readonly  id="chuyenmon" name="chuyenmon" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->chuyenmon)  ? $employee_curriculum->chuyenmon : '' }}">
                                <div class="tx_nm loaihinh_dt">Loại hình đào tạo:</div>
                                <input readonly  id="loaihinh_dt" name="loaihinh_dt" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->loaihinh_dt)  ? $employee_curriculum->loaihinh_dt : '' }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm chuyennganh_dt">Chuyên ngành đào tạo:</div>
                                <input readonly  id="chuyennganh_dt" name="chuyennganh_dt" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->chuyennganh_dt)  ? $employee_curriculum->chuyennganh_dt : '' }}">&nbsp;
                                </input>
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm dang_ngay">Kết nạp Đảng cộng sản Việt Nam ngày
                                </div>
                                <input readonly  id="dang_ngay" name="dang_ngay" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->dang_ngay)  ? $employee_curriculum->dang_ngay : '' }}">
                                <div class="tx_nm dang_thang">tháng</div>
                                <input readonly  id="dang_thang" name="dang_thang" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->dang_thang)  ? $employee_curriculum->dang_thang : '' }}">&nbsp;
                                <div class="tx_nm dang_nam">năm</div>
                                <input readonly  id="dang_nam" name="dang_nam" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->dang_nam)  ? $employee_curriculum->dang_nam : '' }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm dang_ketnap">Nơi kết nạp:</div>
                                <input readonly  id="dang_ketnap" name="dang_ketnap" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->dang_ketnap)  ? $employee_curriculum->dang_ketnap : '' }}">
                            </div>
                            <div class="p1-d1 h20">
                                <div class="tx_nm doan_ngay">Ngày vào Đoàn TNCSHCM ngày</div>
                                <input readonly  id="doan_ngay" name="doan_ngay" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->doan_ngay)  ? $employee_curriculum->doan_ngay : '' }}">
                                <div class="tx_nm doan_thang">tháng</div>
                                <input readonly  id="doan_thang" name="doan_thang" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->doan_thang)  ? $employee_curriculum->doan_thang : '' }}">&nbsp;
                                <div class="tx_nm doan_nam">năm</div>
                                <input readonly  id="doan_nam" name="doan_nam" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->doan_nam)  ? $employee_curriculum->doan_nam : '' }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm doan_ketnap">Nơi kết nạp:</div>
                                <input readonly  id="doan_ketnap" name="doan_ketnap" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->doan_ketnap)  ? $employee_curriculum->doan_ketnap : '' }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm suckhoe">Tình hình sức khoẻ:</div>
                                <input readonly  id="suckhoe" name="suckhoe" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->suckhoe)  ? $employee_curriculum->suckhoe : '' }}">
                                <div class="tx_nm cao">Cao</div>
                                <input readonly  id="cao" name="cao" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->cao)  ? $employee_curriculum->cao : '' }}">
                                <div class="tx_nm can_nang">Cân nặng</div>
                                <input readonly  id="can_nang" name="can_nang" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->can_nang)  ? $employee_curriculum->can_nang : '' }}">
                                <div class="tx_nm can_nang2">kg</div>
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm nghenghiep_chuyenmon">Nghề nghiệp hoặc trình độ
                                    chuyên
                                    môn:
                                </div>
                                <input readonly  id="nghenghiep_chuyenmon" name="nghenghiep_chuyenmon"
                                       class="line" cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->nghenghiep_chuyenmon)  ? $employee_curriculum->nghenghiep_chuyenmon : '' }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm capbac">Cấp bậc:</div>
                                <input readonly  id="capbac" name="capbac" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->capbac)  ? $employee_curriculum->capbac : '' }}">
                                <div class="tx_nm luongchinh">Lương chính hiện nay</div>
                                <input readonly  id="luongchinh" name="luongchinh" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->luongchinh)  ? $employee_curriculum->luongchinh : '' }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm ngaynhapngu">Ngày nhập ngũ:</div>
                                <input readonly  id="ngaynhapngu" name="ngaynhapngu" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->ngaynhapngu)  ? $employee_curriculum->ngaynhapngu : '' }}">&nbsp;
                                <div class="tx_nm ngayxuatngu">Ngày xuất ngũ:</div>
                                <input readonly  id="ngayxuatngu" name="ngayxuatngu" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->ngayxuatngu)  ? $employee_curriculum->ngayxuatngu : '' }}">
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm lydo_p2">Lý do</div>
                                <input readonly  id="lydo_p2" name="lydo_p2" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->lydo_p2)  ? $employee_curriculum->lydo_p2 : '' }}">&nbsp;
                            </div>
                            <p class="p-head">Hoàn cảnh gia đình</p>
                            <div class="p1-d1 h20">
                                <div class="tx_nm htbo">Họ và tên bố:</div>
                                <input readonly  id="htbo" name="htbo" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->htbo)  ? $employee_curriculum->htbo : '' }}">&nbsp;
                                <div class="tx_nm tuoibo">Tuổi</div>
                                <input readonly  id="tuoibo" name="tuoibo" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->tuoibo)  ? $employee_curriculum->tuoibo : '' }}">
                                <div class="tx_nm nn_bo">Nghề nghiệp</div>
                                <input readonly  id="nn_bo" name="nn_bo" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->nn_bo)  ? $employee_curriculum->nn_bo : '' }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm bo_thang8">Trước cách mạng tháng 8 làm gì? Ở đâu?

                                </div>
                                <textarea readonly  id="bo_thang8" name="bo_thang8" class="line d2"
                                          cvo-placeholder=""
                                          contenteditable="">&nbsp;{!! !empty($employee_curriculum->bo_thang8)  ? $employee_curriculum->bo_thang8 : '' !!} </textarea>
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm hoten">Trong kháng chiến chống thực dân Pháp làm
                                    gì? Ở
                                    đâu?
                                </div>
                                <textarea readonly  id="bo_khangphap" name="bo_khangphap" class="line d2"
                                          cvo-placeholder="" contenteditable=""
                                          rows="2">{!! !empty($employee_curriculum->bo_khangphap)  ? $employee_curriculum->bo_khangphap : '' !!}</textarea>
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm bo_1955">Từ năm 1955 đến nay làm gì? Ở đâu? (Ghi
                                    rõ
                                    tên cơ quan, xí nghiệp hiện nay đang làm)
                                </div>
                                <textarea readonly  id="bo_1955" name="bo_1955" class="line d2"
                                          cvo-placeholder="" contenteditable=""
                                          rows="2">{!! !empty($employee_curriculum->bo_1955)  ? $employee_curriculum->bo_1955 : '' !!}</textarea>
                            </div>

                        </div>
                    </div>
                    <div id="page3">
                        <div class="page_ctr">
                            <div class="p1-d1 h20">
                                <div class="tx_nm htme">Họ và tên mẹ:</div>
                                <input readonly  id="htme" name="htme" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->htme)  ? $employee_curriculum->htme : '' }}">&nbsp;
                                <div class="tx_nm tuoime">Tuổi</div>
                                <input readonly  id="tuoime" name="tuoime" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->tuoime)  ? $employee_curriculum->tuoime : '' }}">&nbsp;
                                <div class="tx_nm nn_me">Nghề nghiệp</div>
                                <input readonly  id="nn_me" name="nn_me" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->nn_me)  ? $employee_curriculum->nn_me : '' }}">&nbsp;</input>
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm me_thang8">Trước cách mạng tháng 8 làm gì? Ở đâu?
                                </div>
                                <textarea readonly  id="me_thang8" name="me_thang8" class="line d2"
                                          cvo-placeholder="" contenteditable=""
                                          rows="2">{!! !empty($employee_curriculum->me_thang8)  ? $employee_curriculum->me_thang8 : '' !!}</textarea>
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm me_khangphap">Trong kháng chiến chống thực dân
                                    Pháp
                                    làm gì? Ở đâu?
                                </div>
                                <textarea readonly  id="me_khangphap" name="me_khangphap" class="line d2"
                                          cvo-placeholder="" contenteditable=""
                                          rows="2">{!! !empty($employee_curriculum->me_khangphap)  ? $employee_curriculum->me_khangphap : '' !!}</textarea>
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm me_1955">Từ năm 1955 đến nay làm gì? Ở đâu? (Ghi
                                    rõ
                                    tên cơ quan, xí nghiệp hiện nay đang làm)
                                </div>
                                <textarea readonly  id="me_1955" name="me_1955" class="line d4"
                                          cvo-placeholder="" contenteditable=""
                                          rows="3">{!! !empty($employee_curriculum->me_1955)  ? $employee_curriculum->me_1955 : '' !!}</textarea>
                            </div>
                            <p class="p-head">
                                Họ và tên anh chị em ruột<br><i>(Ghi rõ tên, tuổi, chỗ ở, nghề
                                    nghiệp và
                                    trình độ chính trị của từng người)</i>
                            </p>
                            <textarea readonly  id="giadinh" name="giadinh" class="dn" cvo-placeholder=""
                                      contenteditable=""
                                      rows="20">{!! !empty($employee_curriculum->giadinh)  ? $employee_curriculum->giadinh : '' !!}</textarea>
                        </div>
                    </div>
                    <div id="page4">
                        <div class="page_ctr">
                            <div class="p1-d1">
                                <div class="tx_nm hotenvc">Họ và tên vợ hoặc chồng:</div>
                                <input readonly  id="hotenvc" name="hotenvc" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->hotenvc)  ? $employee_curriculum->hotenvc : '' }}">
                                <div class="tx_nm tuoivc">Tuổi</div>
                                <input readonly  id="tuoivc" name="tuoivc" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->tuoivc)  ? $employee_curriculum->tuoivc : '' }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm nn_vc">Nghề nghiệp</div>
                                <input readonly  id="nn_vc" name="nn_vc" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->nn_vc)  ? $employee_curriculum->nn_vc : '' }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm noi_nn_vc">Nơi làm việc:</div>
                                <input readonly  id="noi_nn_vc" name="noi_nn_vc" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->noi_nn_vc)  ? $employee_curriculum->noi_nn_vc : '' }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm noio_vc">Chỗ ở hiện nay:</div>
                                <input readonly  id="noio_vc" name="noio_vc" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->noio_vc)  ? $employee_curriculum->noio_vc : '' }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                Họ và tên các con:
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm tencon1">1)</div>
                                <input readonly  id="tencon1" name="tencon1" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->tencon1)  ? $employee_curriculum->tencon1 : '' }}">
                                <div class="tx_nm tuoicon1">Tuổi</div>
                                <input readonly  id="tuoicon1" name="tuoicon1" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->tuoicon1)  ? $employee_curriculum->tuoicon1 : '' }}">
                                <div class="tx_nm nn_con1">Nghề nghiệp</div>
                                <input readonly  id="nn_con1" name="nn_con1" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->nn_con1)  ? $employee_curriculum->nn_con1 : '' }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm tencon1">2)</div>
                                <input readonly  id="tencon2" name="tencon2" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->tencon2)  ? $employee_curriculum->tencon2 : '' }}">
                                <div class="tx_nm tuoicon2">Tuổi</div>
                                <input readonly  id="tuoicon2" name="tuoicon2" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->tuoicon2)  ? $employee_curriculum->tuoicon2 : '' }}">
                                <div class="tx_nm nn_con2">Nghề nghiệp</div>
                                <input readonly  id="nn_con2" name="nn_con2" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->nn_con2)  ? $employee_curriculum->nn_con2 : '' }}">
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm tencon1">3)</div>
                                <input readonly  id="tencon3" name="tencon3" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->tencon3)  ? $employee_curriculum->tencon3 : '' }}">
                                <div class="tx_nm tuoicon3">Tuổi</div>
                                <input readonly  id="tuoicon3" name="tuoicon3" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->tuoicon3)  ? $employee_curriculum->tuoicon3 : '' }}">
                                <div class="tx_nm nn_con3">Nghề nghiệp</div>
                                <input readonly  id="nn_con3" name="nn_con3" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->nn_con3)  ? $employee_curriculum->nn_con3 : '' }}">&nbsp;
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm tencon1">4)</div>
                                <input readonly  id="tencon4" name="tencon4" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->tencon4)  ? $employee_curriculum->tencon4 : '' }}">
                                <div class="tx_nm tuoicon4">Tuổi</div>
                                <input readonly  id="tuoicon4" name="tuoicon4" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->tuoicon4)  ? $employee_curriculum->tuoicon4 : '' }}">&nbsp;
                                <div class="tx_nm nn_con4">Nghề nghiệp</div>
                                <input readonly  id="nn_con4" name="nn_con4" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->nn_con4)  ? $employee_curriculum->nn_con4 : '' }}">
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm tencon1">5)</div>
                                <input readonly  id="tencon5" name="tencon5" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->tencon5)  ? $employee_curriculum->tencon5 : '' }}">
                                <div class="tx_nm tuoicon5">Tuổi</div>
                                <input readonly  id="tuoicon5" name="tuoicon5" class="line" cvo-placeholder=""
                                       contenteditable=""
                                       value="{{ !empty($employee_curriculum->tuoicon5)  ? $employee_curriculum->tuoicon5 : '' }}">&nbsp;
                                <div class="tx_nm nn_con5">Nghề nghiệp</div>
                                <input readonly  id="nn_con5" name="nn_con5" class="line" cvo-placeholder=""
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
                                                                <textarea readonly  id="ht_day" name="ht_day"
                                                                          class="d5 line cus_line" cvo-placeholder=""
                                                                          contenteditable=""
                                                                          rows="5">{!! !empty($employee_curriculum->ht_day)  ? $employee_curriculum->ht_day : '' !!}</textarea>
                                    </td>
                                    <td>
                                                                <textarea readonly  id="ht_congtac" name="ht_congtac"
                                                                          class="d5 line cus_line" cvo-placeholder=""
                                                                          contenteditable=""
                                                                          rows="5">{!! !empty($employee_curriculum->ht_congtac)  ? $employee_curriculum->ht_congtac : '' !!}</textarea>
                                    </td>
                                    <td>
                                                                <textarea readonly  id="ht_odau" name="ht_odau"
                                                                          class="d5 line cus_line" cvo-placeholder=""
                                                                          contenteditable=""
                                                                          rows="5">{!! !empty($employee_curriculum->ht_odau)  ? $employee_curriculum->ht_odau : '' !!}</textarea>
                                    </td>
                                    <td>
                                                                <textarea readonly  id="ht_chucvu" name="ht_chucvu"
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
                                <input readonly  id="khenthuong" name="khenthuong" class="line"
                                       cvo-placeholder="" contenteditable=""
                                       value="{{ !empty($employee_curriculum->khenthuong)  ? $employee_curriculum->khenthuong : '' }}">
                            </div>
                            <div class="p1-d1">
                                <div class="tx_nm kyluat">Kỷ luật:</div>
                                <input readonly  id="kyluat" name="kyluat" class="line" cvo-placeholder=""
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
                                <textarea readonly  id="xacnhan" name="xacnhan" class="line d3"
                                          cvo-placeholder="" contenteditable=""
                                          rows="3">&nbsp;{!!  !empty($employee_curriculum->xacnhan)  ? $employee_curriculum->xacnhan : ''  !!}</textarea>
                            </div>
                            <div class="p1-d1 r">
                                <div class="w100">
                                    <input readonly  id="local" name="local" class="line" cvo-placeholder=""
                                           contenteditable=""
                                           value="{{ !empty($employee_curriculum->local)  ? $employee_curriculum->local : '' }}">
                                    <div class="tx_nm local_ngay">,Ngày</div>
                                    <input readonly  id="local_ngay" name="local_ngay" class="line"
                                           cvo-placeholder="" contenteditable=""
                                           value="{{ !empty($employee_curriculum->local_ngay)  ? $employee_curriculum->local_ngay : '' }}">
                                    <div class="tx_nm local_thang">tháng</div>
                                    <input readonly  id="local_thang" name="local_thang" class="line"
                                           cvo-placeholder="" contenteditable=""
                                           value="{{ !empty($employee_curriculum->local_thang)  ? $employee_curriculum->local_thang : '' }}">
                                    <div class="tx_nm local_nam">năm</div>
                                    <input readonly  id="local_nam" name="local_nam" class="line"
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


            </div>


        </div>

    </div>
</div>
    @else
    <div class="col-md-12 bgrWhite mgt20 pd20">
    <p class="clred mgb0">Ứng viên này chưa tạo Sơ yếu lý lịch !</p>
    </div>
@endif