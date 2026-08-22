<?php
//tỉnh tỉ lệ hoàn thiện cv
$percent = 0;
//tinh ti le hoan thien cv
$total_comlum = 17;
$total_percent = 0;
if (!empty($employee['birthday'])) {
    $total_percent = $total_percent + 1;  //
}if (!empty($employee['employee_image'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['phone'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['province'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['district'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['address'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['career_category_id'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['salary_id'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['employee_level_id'])) {
    $total_percent = $total_percent + 1;
}if (!empty($employee['experience_id'])) {
    $total_percent = $total_percent + 1;
}if (!empty($employee['information_verifier'])) {
    $total_percent = $total_percent + 1;
}if (!empty($employee['gender'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['cmt'])) {
    $total_percent = $total_percent + 1;
}if (!empty($employee['cmt_date'])) {
    $total_percent = $total_percent + 1;
}if (!empty($employee['cmt_local'])) {
    $total_percent = $total_percent + 1;
}if (isset($employee['status'])) {
    $total_percent = $total_percent + 1;  //
}if (isset($employee['marry'])) {
    $total_percent = $total_percent + 1; //
}
if (!empty($employee['status_employees_experience'])) {
    $percent = $percent + 20;
}if (!empty($employee['status_employee_degree'])) {
    $percent = $percent + 20;
}
$percent_comlum = ($total_percent / $total_comlum)*60;
$total = 0;
$total = $percent_comlum + $percent;
?>
<div class="CV bgrWhite radius5 pd20  mgb20 pdb5 UpdateUserTab">

    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 15px;width: 100%">
        <strong class="clred">Bạn đã hoàn thành bài thi trắc nghiệm thành công ! Vui lòng xem lại thông tin trước khi nộp hồ sơ</strong>

    </div>


    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if(session('suscess')) active @endif @if(!session('suscess_specialize') and !session('suscess_experience') and !session('suscess_file')) active @endif"
               id="home-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true">Thông
                tin ứng viên</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(session('suscess_specialize'))active @endif" id="profile-tab" data-toggle="tab"
               href="#tab2" role="tab" aria-controls="profile" aria-selected="false">Trình độ ứng viên</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(session('suscess_experience'))active @endif" id="contact-tab" data-toggle="tab"
               href="#tab3" role="tab" aria-controls="contact" aria-selected="false">Kinh nghiệm làm việc</a>
        </li>
    </ul>
    {{--TAB1--}}
    <div class="tab-content " id="myTabContent">


        <div class="tab-pane fade @if(session('suscess')) show active @endif  @if(!session('suscess_specialize') and !session('suscess_experience')) show active @endif " id="tab1" role="tabpanel" aria-labelledby="home-tab">
            <div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                <div class="content">
                    <div class="row">
                        <div class="col-md-12  mgt15">

                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 sm-w100 textCenter blueN ">Thông tin ứng viên</div>
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                            </div>

                            @if(session('success_create'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert"
                                     style="margin-top: 15px;width: 100%">
                                    <strong>{{ session('success_create') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


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

                            @if(!empty($errors->all()))
                                @foreach($errors->all() as $erorr)
                                    <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                @endforeach
                            @endif
                            <div class="col-xl-12 col-lg-12 left">
                                <form action="{{ route('updateEmployeeSubmit') }}" method="post" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6">Tên ứng viên : </label>
                                            <input type="text" class="form-control" id="inputName" placeholder="Nhập tên ứng viên"
                                                   name="employee_name"
                                                   value="{{  isset($employee->employee_name) ? $employee->employee_name : '' }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6">Ngày sinh : </label>
                                            <input type="date" class="form-control" id="inputName" placeholder="Ngày sinh"
                                                   name="birthday"
                                                   value="{{ isset($employee->birthday) ? $employee->birthday : '' }}">

                                        </div>

                                    </div>
                                    <div class="form-row mgt20">
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6">Nhập số điện thoại : </label>
                                            <input type="number" class="form-control" id="inputName"
                                                   placeholder="Nhập số điện thoại"
                                                   name="phone" value="{{ isset($employee->phone) ? $employee->phone : '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6">Email <i style="font-weight: 500">(Tài khoản đăng nhập )</i></label>
                                            <input type="email" class="form-control" id="inputName" placeholder="Nhập Email"
                                                   name="" value="{{ isset($employee->email) ? $employee->email : $user->email }}" readonly>
                                        </div>
                                    </div>

                                    <div class="form-row mgt20 gruopRadio">
                                        <div class="col-md-4">
                                            <label for="inputAddress2" class="fw6" style="display: block;">Giới tính: </label>
                                            <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                <input class="form-check-input" type="radio" name="gender" id="exampleRadios2"
                                                       value="1" @if($employee->gender == 1) checked @endif>
                                                <label class="form-check-label" for="exampleRadios2">
                                                    Nữ
                                                </label>
                                            </div>
                                            <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                <input class="form-check-input" type="radio" name="gender" id="exampleRadios3"
                                                       value="2" @if($employee->gender == 2) checked @endif>
                                                <label class="form-check-label" for="exampleRadios3">
                                                    Nam
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputAddress2" class="fw6" style="display: block;">Tình trạng hôn
                                                nhân: </label>

                                            <div class="form-check" style="display: inline-block; margin-right: 10px;">
                                                <input class="form-check-input" type="radio" name="marry" id="exampleRadios4"
                                                       value="0" @if($employee->marry == 0) checked @endif>
                                                <label class="form-check-label" for="exampleRadios4">
                                                    Độc thân
                                                </label>
                                            </div>
                                            <div class="form-check" style="display: inline-block; margin-right: 10px;">
                                                <input class="form-check-input" type="radio" name="marry" id="exampleRadios5"
                                                       value="1" @if($employee->marry == 1) checked @endif>
                                                <label class="form-check-label" for="exampleRadios5">
                                                    Đã kết hôn
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputAddress2" class="fw6">Hình ảnh ứng viên : </label>

                                            <div class="">

                                                <div class="form-group">
                                                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                                           size="20"/>
                                                    <img src="{{ isset($employee->employee_image) ? $employee->employee_image : '' }}" width="80" height=""/>
                                                    <input name="images" type="hidden" value="{{ isset($employee->employee_image) ? $employee->employee_image: '' }}"/>

                                                </div>


                                                {{--,--}}

                                            </div>
                                        </div>

                                    </div>





                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="inputAddress2" class="fw6">Địa chỉ ứng viên <i style="font-weight: 500">(vui lòng chọn đúng địa điểm để tìm việc dễ hơn)</i></label>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group borderSelect2">
                                                <label for="exampleInputEmail1">Tỉnh/Thành phố</label>
                                                <select class="form-control select2 " name="province"
                                                        aria-label="Tỉnh/Thành phố"
                                                        id="city">
                                                    <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                                    @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                        <option value="{{$province->province_id}}"
                                                                @if($employee->province == $province->province_id) selected @endif
                                                        >{{$province->province_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group borderSelect2">
                                                <label for="exampleInputEmail1">Quận/Huyện</label>
                                                <select class="form-control select2 " name="district" aria-label="Quận/Huyện"
                                                        id="county">
                                                    <option value="">-- Chọn Quận/Huyện --</option>
                                                    @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                        <option value="{{$district->district_id }}"
                                                                @if($employee->district == $district->district_id) selected @endif
                                                        >{{$district->district_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group borderSelect2">
                                                <label for="exampleInputEmail1">Địa chỉ cụ thể </label>
                                                <input type="text" class="form-control" id="inputName"
                                                       placeholder="Địa chỉ "
                                                       name="address"
                                                       value="{{ isset($employee->address) ? $employee->address : '' }}">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">


                                        <div class="form-group borderSelect2">
                                            <label for="exampleInputEmail1">Công việc yêu thích </label>
                                            <select class="form-control select2" name="career_category_id" aria-label="Quận/Huyện"
                                                    id="">
                                                <?php $careers = \App\Entity\Career::getAllCareer(); ?>
                                                <option value="" selected>-- Chọn ngành nghề --</option>
                                                @foreach($careers as $career)
                                                    <option value="{{$career->career_category_id }}"
                                                            @if($employee->career_category_id == $career->career_category_id) selected @endif
                                                    >{{$career->career_category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group mgt20">
                                        <label for="inputAddress2" class="fw6">Giới thiệu về bản thân :</label>
                                        <textarea name="information_verifier" id="editor1" rows="5" cols="100"
                                                  class="w100 form-control editor"
                                                  style="width: 100%">{!!   isset($employee->information_verifier) ? $employee->information_verifier : ''  !!}</textarea>

                                    </div>



                                    <div class="form-row mgt20">
                                        <div class="col-md-4">
                                            <label for="inputAddress2" class="fw6">Chứng minh thư nhân dân: </label>
                                            <input type="text" class="form-control" id="inputName"
                                                   placeholder="Chứng minh thư nhân dân"
                                                   name="cmt"
                                                   value="{{ isset($employee->cmt) ? $employee->cmt : '' }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputAddress2" class="fw6">Ngày cấp: </label>
                                            <input type="date" class="form-control" id="inputName" placeholder="Ngày cấp"
                                                   name="cmt_date"
                                                   value="{{ isset($employee->cmt_date) ? $employee->cmt_date : '' }}">
                                        </div>
                                        <div class="col-md-4"><label for="inputAddress2" class="fw6">Nơi cấp: </label>
                                            <input type="text" class="form-control" id="inputName" placeholder="Nơi cấp"
                                                   name="cmt_local"
                                                   value="{{ isset($employee->cmt_local) ? $employee->cmt_local : '' }}"></div>
                                    </div>


                                    <div class="form-group mgt15">
                                        <!-- Google reCaptcha -->
                                        <div class="g-recaptcha" id="feedback-recaptcha"
                                             data-sitekey="{{ '6Le9trIUAAAAALrCbKEVd_fFCOjZm13bNMk9DmZP'  }}"></div>
                                        <!-- End Google reCaptcha -->
                                        <input type="hidden" name="id_job_fb" value="{{ $id_job_fb }}"/>
                                        <input type="hidden" name="status_job" value="1"/>

                                    </div>


                                    <div class="form-row mgt20">
                                        <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5" style="border:none">
                                            Ứng tuyển ngay
                                        </button>

                                    </div>
                                </form>
                            </div>

                        </div>


                    </div>
                </div>



            </div>
        </div>
        {{--TAB2--}}
        <div class="tab-pane fade @if(session('suscess_specialize')) show active @endif" id="tab2" role="tabpanel"
             aria-labelledby="profile-tab">
            <div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                <div class="content">
                    <div class="row">
                        <div class="col-md-12  mgt15">
                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter blueN sm-w100 sm-mgt20">
                                    Trình độ chuyên môn
                                </div>
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                            </div>

                            <div class="col-xl-12 col-lg-12 left">
                                <form action="{{ route('update_Specialize_Employee') }}" method="post"
                                      enctype="multipart/form-data">
                                    {!! csrf_field() !!}

                                    @if(session('suscess_specialize'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                                             style="margin-top: 15px;width: 100%">
                                            <strong>{{ session('suscess_specialize') }}</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    {{--trinh do chuyên môn--}}
                                    @if(!empty($specialize))
                                        <div class="boxSchool" id="specialize">
                                            @foreach($specialize as $id=>$spec)
                                                <div class="deleteItemSpec">
                                                    <p class="clorange f18"
                                                       style="font-weight: bold;margin-bottom: 10px;">Thời gian
                                                        : {{ isset($spec->star_specialize_time) ? $spec->star_specialize_time : '' }}
                                                        - {{ isset($spec->end_specialize_time) ? $spec->end_specialize_time : '' }} </p>

                                                    <div class="form-row mgt20">
                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Thời gian bắt đầu học -
                                                                <i>tính theo năm</i> </label>
                                                            <input type="year"
                                                                   name='specialize[{{ $id }}][star_specialize_time]'
                                                                   class="form-control" id="inputZip"
                                                                   placeholder="Ví dụ: 2015"
                                                                   value="{{ isset($spec->star_specialize_time) ? $spec->star_specialize_time : '' }}">
                                                        </div>
                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính
                                                                    theo năm</i> </label>
                                                            <input type="year"
                                                                   name='specialize[{{ $id }}][end_specialize_time]'
                                                                   class="form-control" id="inputZip"
                                                                   placeholder="Ví dụ:  2016"
                                                                   value="{{ isset($spec->end_specialize_time) ? $spec->end_specialize_time : '' }}">
                                                        </div>

                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Tên trường </label>
                                                            <input type="text" name='specialize[{{ $id }}][school]'
                                                                   class="form-control" id="inputZip"
                                                                   placeholder="Ví dụ: Đại học kinh tế TPHCM"
                                                                   value="{{ isset($spec->school) ? $spec->school : '' }}">
                                                        </div>
                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Trình độ </label>
                                                            <select name='specialize[{{ $id }}][leve]'
                                                                    id="ddlQualificationType"
                                                                    class="selectbox requiredbox form-control">
                                                                <option value="0" selected>-- Chọn Bằng cấp --</option>
                                                                @foreach(\App\Entity\Literacy::get() as $literacy)
                                                                    <option value="{{$literacy->literacy_id}}"
                                                                            {{ isset($spec->leve) && ($spec->leve == $literacy->literacy_id) ? 'selected' : ''}}
                                                                    >{{$literacy->literacy_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Ngành học </label>
                                                            <input type="text" name='specialize[{{ $id }}][majors]'
                                                                   id="txtMajorContent" class="requiredbox form-control"
                                                                   value="{{ isset($spec->majors) ? $spec->majors : '' }}"
                                                                   placeholder="Ví dụ: Quản trị kinh doanh">

                                                        </div>
                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Tình trạng </label>
                                                            <input type="text" id="txtCertificate"
                                                                   name='specialize[{{ $id }}][specialize_status]'
                                                                   class="requiredbox form-control"
                                                                   value="{{ isset($spec->specialize_status) ? $spec->specialize_status : '' }}"
                                                                   placeholder="Ví dụ: Đã tốt nghiệp hoặc chưa tốt nghiệp">
                                                        </div>
                                                        <div class="col-lg-12"
                                                             style="float: right;text-align: right;padding-right: 25px;">
                                                            <a class="deleteItem"
                                                               style="    color: white;background: red;padding: 5px 14px;cursor: pointer;">Xóa</a>
                                                        </div>
                                                    </div>
                                                    <hr class="bgrBlueN">
                                                </div>
                                            @endforeach


                                            <div class="form-group textRight mgt15">
                                                <a class="whiteIm bgrBlueN pd10 cursor" data-toggle="modal"
                                                   data-target="#add_specialize"><i class="fas fa-plus"></i> Thêm trình
                                                    độ </a>
                                            </div>
                                        </div>


                                        <div class="form-row mgt20">
                                            <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5"
                                                    style="border:none">
                                                Lưu thay đổi
                                            </button>

                                        </div>
                                    @endif

                                </form>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
        {{--TAB3--}}
        <div class="tab-pane fade @if(session('suscess_experience')) show active @endif" id="tab3" role="tabpanel"
             aria-labelledby="contact-tab">
            <div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                <div class="content">
                    <div class="row">
                        <div class="col-md-12  mgt15">
                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter blueN sm-w100 sm-mgt20">
                                    Kinh nghiệm làm việc
                                </div>
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                            </div>
                            <div class="col-xl-12 col-lg-12 left">
                                <form action="{{ route('update_Experience_Employee') }}" method="post"
                                      enctype="multipart/form-data">
                                    {!! csrf_field() !!}

                                    @if(session('suscess_experience'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                                             style="margin-top: 15px;width: 100%">
                                            <strong>{{ session('suscess_experience') }}</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    {{--trinh do chuyên môn--}}
                                    @if(!empty($experience))
                                        <div class="boxSchool" id="specialize">
                                            @foreach($experience as $id_ex=>$exper)
                                                <div class="deleteItemSpec">
                                                    <p class="clorange f18"
                                                       style="font-weight: bold;margin-bottom: 10px;">Thời gian
                                                        : {{ isset($exper->star_working_time) ? $exper->star_working_time : '' }}
                                                        - {{ isset($exper->end_working_time) ? $exper->end_working_time : '' }} </p>

                                                    <div class="form-row">
                                                        <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Công ty đã làm
                                                                việc </label>
                                                            <input type="text" name='experience[{{ $id_ex }}][company]'
                                                                   id="txtMajorContent" class="requiredbox form-control"
                                                                   value="{{ isset($exper->company) ? $exper->company : '' }}"
                                                                   placeholder="Ví dụ: Công ty cổ phần sắc màu">

                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Thời gian bắt đầu làm việc
                                                                - <i>tính theo năm</i> </label>
                                                            <input type="year"
                                                                   name='experience[{{ $id_ex }}][star_working_time]'
                                                                   class="form-control" id="inputZip"
                                                                   placeholder="Ví dụ: 2015"
                                                                   value="{{ isset($exper->star_working_time	) ? $exper->star_working_time : '' }}">
                                                        </div>
                                                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính
                                                                    theo năm</i> </label>
                                                            <input type="year"
                                                                   name='experience[{{ $id_ex }}][end_working_time]'
                                                                   class="form-control" id="inputZip"
                                                                   placeholder="Ví dụ:  2016"
                                                                   value="{{ isset($exper->end_working_time	) ? $exper->end_working_time	 : '' }}">
                                                        </div>
                                                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Vị trí công việc </label>
                                                            <input type="text" name='experience[{{ $id_ex }}][position]'
                                                                   id="txtMajorContent" class="requiredbox form-control"
                                                                   value="{{ isset($exper->position) ? $exper->position : '' }}"
                                                                   placeholder="Ví dụ: Du lịch">
                                                        </div>

                                                    </div>


                                                    <div class="form-row">
                                                        <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Mô tả công việc </label>

                                                            <textarea class="w100 editor" id="editordes{{ $id_ex }}"
                                                                      name="experience[{{ $id_ex }}][des_position]"
                                                                      placeholder="Ví dụ: Công việc chủ yếu về du lịch"
                                                                      rows="5"> {!! isset($exper->des_position) ? $exper->des_position : '' !!}  </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-lg-12"
                                                             style="float: right;text-align: right;margin-right: 25px;">
                                                            <a class="deleteItem_experience"
                                                               style="    color: white;background: red;padding: 5px 14px;cursor: pointer">Xóa </a>
                                                        </div>
                                                    </div>
                                                    <hr class="bgrBlueN">
                                                </div>
                                            @endforeach


                                            <div class="form-group textRight mgt15">
                                                <a class="whiteIm bgrBlueN pd10 cursor" data-toggle="modal"
                                                   data-target="#add_experience"><i class="fas fa-plus"></i> Thêm mới
                                                    kinh nghiệm </a>
                                            </div>
                                        </div>


                                        <div class="form-row mgt20">
                                            <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5"
                                                    style="border:none">
                                                Lưu thay đổi
                                            </button>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--modal  trinh do ung vien--}}
<div class="modal fade bd-example-modal-xl" id="add_specialize" tabindex="-1" role="dialog"
     aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('store_Specialize_Employee') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm mới trình độ ứng viên</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-row mgt20">
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Thời gian bắt đầu học - <i>tính theo năm</i> </label>
                            <input type="text" name='star_specialize_time' class="form-control" id="inputZip"
                                   placeholder="Ví dụ: 2015">
                        </div>
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính theo năm</i> </label>
                            <input type="text" name='end_specialize_time' class="form-control" id="inputZip"
                                   placeholder="Ví dụ:  2016">
                        </div>

                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Tên trường </label>
                            <input type="text" name='school' class="form-control" id="inputZip"
                                   placeholder="Ví dụ: Đại học kinh tế TPHCM">
                        </div>
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Trình độ </label>
                            <select name='leve' id="ddlQualificationType" class="selectbox requiredbox form-control">
                                <option value="0">-- Chọn Bằng cấp --</option>
                                @foreach(\App\Entity\Literacy::get() as $literacy)
                                    <option value="{{$literacy->literacy_id}}"
                                            {{ $literacy->literacy_id === old('literacy') && !isset($employee->literacy)  ? 'selected' : ''}}
                                            {{ isset($employee->literacy) && ($employee->literacy == $literacy->literacy_id) ? 'selected' : ''}}
                                    >{{$literacy->literacy_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Ngành học </label>
                            <input type="text" name='majors' id="txtMajorContent" class="requiredbox form-control"
                                   value="" placeholder="Ví dụ: Quản trị kinh doanh">

                        </div>
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Tình trạng </label>
                            <input type="text" id="txtCertificate" name='specialize_status'
                                   class="requiredbox form-control" value=""
                                   placeholder="Ví dụ: Đã tốt nghiệp hoặc chưa tốt nghiệp">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary bgorang" style="border-color: orange">Lưu lại</button>
                </div>

            </div>
        </form>
    </div>
</div>

{{--kinh nghiem ung vien--}}
<div class="modal fade bd-example-modal-xl" id="add_experience" tabindex="-1" role="dialog"
     aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('store_Experience_Employee') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm mới kinh nghiệm làm việc</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-row mgt20">
                        <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Tên công ty đã làm việc </label>
                            <input type="text" name='company' class="form-control" id="inputZip"
                                   placeholder="Ví dụ: Công ty cổ phần sắc màu Việt Nam">
                        </div>
                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Thời gian bắt làm việc - <i>tính theo năm</i> </label>
                            <input type="text" name='star_working_time' class="form-control" id="inputZip"
                                   placeholder="Ví dụ: 2015">
                        </div>
                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính theo năm</i> </label>
                            <input type="text" name='end_working_time' class="form-control" id="inputZip"
                                   placeholder="Ví dụ:  2016">
                        </div>


                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Vị trí công việc </label>
                            <input type="text" name='position' class="form-control" id="inputZip"
                                   placeholder="Ví dụ: Du lịch">
                        </div>
                        <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Mô tả công việc </label>

                            <textarea name="information_verifier" id="editor2" rows="5" cols="100"
                                      class="w100 form-control editor "
                                      style="width: 100%"></textarea>


                        </div>


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary bgorang" style="border-color: orange">Lưu lại</button>
                </div>

            </div>
        </form>
    </div>
</div>
<script>
    $('.deleteItem').click(function () {
        var success_remove = '';
        success_remove = confirm("Bạn có muốn xóa thời gian này không !");
        if (success_remove) {
            $(this).parent().parent().parent().remove();
        }

    });
    $('.deleteItem_experience').click(function () {
        var success_remove = '';
        success_remove = confirm("Bạn có muốn xóa  thời gian này không !");
        if (success_remove) {
            $(this).parent().parent().parent().remove();
        }

    });
</script>
<script>
    //var sticky = new Sticky('[data-sticky]');
    $(document).ready(function () {
        var id = 'time' + '<?php echo  $id_exam . \Illuminate\Support\Facades\Auth::user()->id; ?>';
        localStorage.removeItem(id);
        // Optimalisation: Store the references outside the event handler:
        var $window = $(window);

        var windowsize = $window.width();
        if (windowsize >= 1000) {
            var stickySidebar = new StickySidebar('#sidebar', {
                topSpacing: 50,
                bottomSpacing: 40,
                containerSelector: '#scollProduct',
                innerWrapperSelector: '.sidebar__inner'
            });
        }
    });
</script>



