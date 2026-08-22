@extends('staff_admin.layouts.master')

@section('title', 'Sửa thông tin giáo viên' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.teacher')
        </div>

        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting pd15 col-f14 ">
                    <style>
                        .form-group {
                            margin-bottom: 10px;
                        }
                    </style>
                    <script src="{{ asset('adminstration/jquery.priceformat.js') }}"></script>
                    <div class="CV bgrWhite radius5 pd20  mgb20 pdb5 UpdateUserTab">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(session('suscess')) active @endif
                @if(!session('suscess_specialize') and !session('suscess_experience') and !session('suscess_course'))  active  @endif"
                                    id="home-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home"
                                    aria-selected="true">Thông
                                    tin giáo viên</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(session('suscess_specialize'))active @endif" id="profile-tab"
                                    data-toggle="tab" href="#tab2" role="tab" aria-controls="profile"
                                    aria-selected="false">Trình độ chuyên môn</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(session('suscess_experience'))active @endif" id="contact-tab"
                                    data-toggle="tab" href="#tab3" role="tab" aria-controls="contact"
                                    aria-selected="false">Kinh nghiệm làm việc</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(session('suscess_course'))active @endif" id="contact-tab"
                                    data-toggle="tab" href="#tab4" role="tab" aria-controls="contact"
                                    aria-selected="false">Công việc làm thêm</a>
                            </li>
                        </ul>
                        {{--TAB1--}}
                        <div class="tab-content " id="myTabContent">
                            <div class="tab-pane fade @if(session('suscess')) show active @endif  @if(!session('suscess_specialize') and !session('suscess_experience') and !session('suscess_course')) show active @endif "
                                id="tab1" role="tabpanel" aria-labelledby="home-tab">
                                <div class="CV bgrWhite radius5   mgb20 pdb5"
                                    style="border: 1px solid #ccc;border-top: none;">
                                    <div class="content">
                                        <div class="row">
                                            <div class="col-md-12  mgt15">

                                                <div class="title mgt20">
                                                    <div
                                                        class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock">
                                                    </div>
                                                    <div
                                                        class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 sm-w100 textCenter blueN ">
                                                        Thông
                                                        tin giáo viên
                                                    </div>
                                                    <div
                                                        class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock">
                                                    </div>
                                                </div>
                                                @if(session('suscess'))
                                                <div class="alert alert-success alert-dismissible fade show"
                                                    role="alert" style="margin-top: 15px;width: 100%">
                                                    <strong>{{ session('suscess') }}</strong>
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                @endif
                                                @if(session('erorr'))
                                                <div class="alert alert-warning alert-dismissible fade show"
                                                    role="alert" style="margin-top: 15px;width: 100%">
                                                    <strong>{{ session('erorr') }}</strong>
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                @endif

                                                @if(!empty($errors->all()))
                                                @foreach($errors->all() as $erorr)
                                                <span
                                                    style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                                @endforeach
                                                @endif
                                                <div class="col-xl-12 col-lg-12 left">
                                                    <form action="{{ route('staff_updateTeacher') }}" method="post"
                                                        enctype="multipart/form-data">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" class="form-control" id="inputName"
                                                               placeholder="Nhập tên giáo viên" name="teacher_id"
                                                               value="{{  isset($teacher->teacher_id) ? $teacher->teacher_id : '' }}">
                                                        <div class="form-row">
                                                            <div class="col-md-6">
                                                                <label for="inputAddress2" class="fw6">Tên giáo viên :
                                                                </label>
                                                                <input type="text" class="form-control" id="inputName"
                                                                    placeholder="Nhập tên giáo viên" name="teacher_name"
                                                                    value="{{  isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}">
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="inputAddress2" class="fw6">Ngày sinh :
                                                                </label>
                                                                <input type="date" class="form-control" id="inputName"
                                                                    placeholder="Ngày sinh" name="birthday"
                                                                    value="{{ isset($teacher->birthday) ? $teacher->birthday : '' }}">

                                                            </div>

                                                        </div>
                                                        <div class="form-row mgt20">
                                                            <div class="col-md-6">
                                                                <label for="inputAddress2" class="fw6">Nhập số điện
                                                                    thoại : </label>
                                                                <input type="number" class="form-control" id="inputName"
                                                                    placeholder="Nhập số điện thoại"
                                                                    name="teacher_phone"
                                                                    value="{{ isset($teacher->teacher_phone) ? $teacher->teacher_phone : '' }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="inputAddress2" class="fw6">Email <i
                                                                        style="font-weight: 500">(Tài
                                                                        khoản đăng nhập )</i></label>
                                                                <input type="email" class="form-control" id="inputName"
                                                                    placeholder="Nhập Email" name="teacher_email"
                                                                    value="{{ isset($teacher->teacher_email) ? $teacher->teacher_email : $user->email }}"
                                                                    readonly>
                                                            </div>
                                                        </div>

                                                        <div class="form-row mgt20 gruopRadio">
                                                            <div class="col-md-6">
                                                                <label for="inputAddress2" class="fw6"
                                                                    style="display: block;">Giới tính: </label>
                                                                <div class="form-check"
                                                                    style="display: inline-block; margin-right: 15px;">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="gender" id="exampleRadios2" value="1"
                                                                        @if($teacher->gender == 1) checked @endif>
                                                                    <label class="form-check-label"
                                                                        for="exampleRadios2">
                                                                        Nữ
                                                                    </label>
                                                                </div>
                                                                <div class="form-check"
                                                                    style="display: inline-block; margin-right: 15px;">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="gender" id="exampleRadios3" value="2"
                                                                        @if($teacher->gender == 2) checked @endif>
                                                                    <label class="form-check-label"
                                                                        for="exampleRadios3">
                                                                        Nam
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="inputAddress2" class="fw6">Hình ảnh giáo
                                                                    viên : </label> <a
                                                                    href="https://sanketoan.vn/ho-tro/huong-dan-tai-anh-dai-dien-vao-ho-so-giao-vien-ung-vien-nha-tuyen-dung"
                                                                    target="_blank">(Hướng dẫn chọn ảnh)</a>
                                                                <div class="">

                                                                    <div class="form-group">
                                                                        <input type="button"
                                                                            onclick="return uploadImage(this);"
                                                                            value="Chọn ảnh" size="20" />
                                                                        <img src="{{ isset($teacher->teacher_images) ? $teacher->teacher_images : '' }}"
                                                                            width="80" height="" />
                                                                        <input name="images" type="hidden"
                                                                            value="{{ isset($teacher->teacher_images) ? $teacher->teacher_images: '' }}" />
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>


                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <label for="inputAddress2" class="fw6">Địa chỉ giáo viên
                                                                    <i style="font-weight: 500"></i></label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group ">
                                                                    <label for="exampleInputEmail1">Tỉnh/Thành
                                                                        phố</label>
                                                                    <select class="form-control select22 "
                                                                        name="province" aria-label="Tỉnh/Thành phố"
                                                                        id="province">
                                                                        <option value="">-- Chọn Tỉnh/Thành phố --
                                                                        </option>
                                                                        @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                                        <option value="{{$province->province_id}}"
                                                                            @if($teacher->province ==
                                                                            $province->province_id) selected @endif
                                                                            >{{$province->province_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group ">
                                                                    <label for="exampleInputEmail1">Quận/Huyện</label>
                                                                    <select class="form-control select22 "
                                                                        name="district" aria-label="Quận/Huyện"
                                                                        id="district">
                                                                        <option value="">-- Chọn Quận/Huyện --</option>
                                                                        @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                                        <option value="{{$district->district_id }}"
                                                                            @if($teacher->district ==
                                                                            $district->district_id) selected @endif
                                                                            >{{$district->district_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group ">
                                                                    <label for="exampleInputEmail1">Địa chỉ cụ thể
                                                                    </label>
                                                                    <input type="text" class="form-control"
                                                                        id="inputName" placeholder="Địa chỉ "
                                                                        name="address"
                                                                        value="{{ isset($teacher->address) ? $teacher->address : '' }}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="form-group">


                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Lĩnh vực doanh nghiệp
                                                                    nhiều kinh nghiệm </label>
                                                                <select class="form-control select22"
                                                                    name="business_type_id" aria-label="Quận/Huyện"
                                                                    id="">
                                                                    <?php $business_type = \App\Entity\TypeOfBusiness::getAllTypeBusiness();
                                                    ?>

                                                                    <option value="" selected>-- Lĩnh vực doanh nghiệp
                                                                        --</option>
                                                                    @foreach($business_type as $business)
                                                                    <option value="{{$business->type_of_business_id }}"
                                                                        @if($teacher->business_type_id ==
                                                                        $business->type_of_business_id) selected @endif
                                                                        >{{$business->type_of_business_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <div class="form-group">

                                                            <div class="form-group borderSelect2 checkBox">
                                                                <strong><label for="exampleInputEmail1"> Công việc đăng
                                                                        kí công việc làm thêm:</label></strong>
                                                                <?php $jobgroups = \App\Entity\JobGroup::getAll()?>
                                                                <div class="box-body scrollGroup row gruopRadio ">

                                                                    @foreach($jobgroups as $jobgroup)
                                                                    <div class="col-md-6 ">
                                                                        <label class="form-check"
                                                                            style="color: #009385;font-weight: bold;">
                                                                            <input type="radio"
                                                                                value="{{$jobgroup->job_group_id}}"
                                                                                name="job_group_id[]"
                                                                                @if(in_array($jobgroup->job_group_id,$id_teacher_job))
                                                                            checked @endif
                                                                            class="form-check-input"
                                                                            >
                                                                            <span style="    margin-top: 3px;
        margin-left: 10px;
        display: inline-block;">{{$jobgroup->job_group_name}}</span>

                                                                        </label>

                                                                    </div>
                                                                    @endforeach


                                                                </div>
                                                            </div>

                                                        </div>
                                                        {{--teacher_job--}}
                                                        <div class="form-group mgt20">
                                                            <label for="inputAddress2" class="fw6">Giới thiệu về bản
                                                                thân :</label>
                                                            <textarea name="information_verifier" id="editor1" rows="5"
                                                                cols="100" class="w100 form-control editor"
                                                                style="width: 100%">{!!   isset($teacher->information_verifier) ? $teacher->information_verifier : ''  !!}</textarea>
                                                        </div>


                                                        <div class="form-group">
                                                            <!-- Google reCaptcha -->
                                                            <div class="g-recaptcha" id="feedback-recaptcha"
                                                                data-sitekey="{{ env('RE_CAPTCHA_HTML')  }}">
                                                            </div>
                                                            <!-- End Google reCaptcha -->
                                                        </div>
                                                        <div class="form-row mgt20">
                                                            <button type="submit"
                                                                class="pd10-30 whiteIm bgrBlueN fw7 radius5"
                                                                style="border:none">
                                                                Lưu
                                                                hồ sơ giáo viên
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
                            <div class="tab-pane fade @if(session('suscess_specialize')) show active @endif" id="tab2"
                                role="tabpanel" aria-labelledby="profile-tab">
                                <div class="CV bgrWhite radius5   mgb20 pdb5"
                                    style="border: 1px solid #ccc;border-top: none;">
                                    <div class="content">
                                        <div class="row">
                                            <div class="col-md-12  mgt15">
                                                <div class="title mgt20">
                                                    <div
                                                        class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile">
                                                    </div>
                                                    <div
                                                        class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter blueN sm-w100 sm-mgt20">
                                                        Trình độ chuyên môn
                                                    </div>
                                                    <div
                                                        class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile">
                                                    </div>
                                                </div>

                                                <div class="col-xl-12 col-lg-12 left">
                                                    <form action="{{ route('staff_update_Specialize_Teacher') }}"
                                                        method="post" enctype="multipart/form-data">
                                                        {!! csrf_field() !!}

                                                        <input type="hidden" class="form-control" id="inputName"
                                                               placeholder="Nhập tên giáo viên" name="teacher_id"
                                                               value="{{  isset($teacher->teacher_id) ? $teacher->teacher_id : '' }}">

                                                        @if(session('suscess_specialize'))
                                                        <div class="alert alert-success alert-dismissible fade show"
                                                            role="alert" style="margin-top: 15px;width: 100%">
                                                            <strong>{{ session('suscess_specialize') }}</strong>
                                                            <button type="button" class="close" data-dismiss="alert"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        @endif
                                                        {{--@if(session('erorr_specialize'))--}}
                                                        {{--<div class="alert alert-warning alert-dismissible fade show" role="alert"--}}
                                                        {{--style="margin-top: 15px;width: 100%">--}}
                                                        {{--<strong>{{ session('suscess_specialize') }}</strong>--}}
                                                        {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
                                                        {{--<span aria-hidden="true">&times;</span>--}}
                                                        {{--</button>--}}
                                                        {{--</div>--}}
                                                        {{--@endif--}}
                                                        {{--trinh do chuyên môn--}}
                                                        @if(!empty($specialize))
                                                        <div class="boxSchool" id="specialize">
                                                            @foreach($specialize as $id=>$spec)
                                                            <div class="deleteItemSpec">
                                                                <p class="clorange f18"
                                                                    style="font-weight: bold;margin-bottom: 10px;">Thời
                                                                    gian
                                                                    :
                                                                    {{ isset($spec->star_specialize_time) ? $spec->star_specialize_time : '' }}
                                                                    -
                                                                    {{ isset($spec->end_specialize_time) ? $spec->end_specialize_time : '' }}
                                                                </p>

                                                                <div class="form-row mgt20">
                                                                    <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                                        <label for="inputZip" class="fw6">Thời gian bắt
                                                                            đầu học -
                                                                            <i>tính theo năm</i> </label>
                                                                        <input type="year"
                                                                            name='specialize[{{ $id }}][star_specialize_time]'
                                                                            class="form-control" id="inputZip"
                                                                            placeholder="Ví dụ: 2015"
                                                                            value="{{ isset($spec->star_specialize_time) ? $spec->star_specialize_time : '' }}">
                                                                    </div>
                                                                    <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                                        <label for="inputZip" class="fw6">Thời gian kết
                                                                            thúc - <i>tính
                                                                                theo năm</i> </label>
                                                                        <input type="year"
                                                                            name='specialize[{{ $id }}][end_specialize_time]'
                                                                            class="form-control" id="inputZip"
                                                                            placeholder="Ví dụ:  2016"
                                                                            value="{{ isset($spec->end_specialize_time) ? $spec->end_specialize_time : '' }}">
                                                                    </div>

                                                                    <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                                        <label for="inputZip" class="fw6">Tên trường
                                                                        </label>
                                                                        <input type="text"
                                                                            name='specialize[{{ $id }}][school]'
                                                                            class="form-control" id="inputZip"
                                                                            placeholder="Ví dụ: Đại học kinh tế TPHCM"
                                                                            value="{{ isset($spec->school) ? $spec->school : '' }}">
                                                                    </div>
                                                                    <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                                        <label for="inputZip" class="fw6">Trình độ
                                                                        </label>
                                                                        <select name='specialize[{{ $id }}][leve]'
                                                                            id="ddlQualificationType"
                                                                            class="selectbox requiredbox form-control">
                                                                            <option value="0" selected>-- Chọn Bằng cấp
                                                                                --</option>
                                                                            @foreach(\App\Entity\Literacy::get() as $literacy)
                                                                            <option value="{{$literacy->literacy_id}}"
                                                                                {{ isset($spec->leve) && ($spec->leve == $literacy->literacy_id) ? 'selected' : ''}}>
                                                                                {{$literacy->literacy_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                                        <label for="inputZip" class="fw6">Ngành học
                                                                        </label>
                                                                        <input type="text"
                                                                            name='specialize[{{ $id }}][majors]'
                                                                            id="txtMajorContent"
                                                                            class="requiredbox form-control"
                                                                            value="{{ isset($spec->majors) ? $spec->majors : '' }}"
                                                                            placeholder="Ví dụ: Quản trị kinh doanh">

                                                                    </div>
                                                                    <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                                        <label for="inputZip" class="fw6">Tình trạng
                                                                        </label>
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
                                                                <a class="whiteIm bgrBlueN pd10 cursor"
                                                                    data-toggle="modal" data-target="#add_specialize"><i
                                                                        class="fas fa-plus"></i> Thêm trình
                                                                    độ </a>
                                                            </div>
                                                        </div>


                                                        <div class="form-row mgt20">
                                                            <button type="submit"
                                                                class="pd10-30 whiteIm bgrBlueN fw7 radius5"
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
                            <div class="tab-pane fade @if(session('suscess_experience')) show active @endif" id="tab3"
                                role="tabpanel" aria-labelledby="contact-tab">
                                <div class="CV bgrWhite radius5   mgb20 pdb5"
                                    style="border: 1px solid #ccc;border-top: none;">
                                    <div class="content">
                                        <div class="row">
                                            <div class="col-md-12  mgt15">
                                                <div class="title mgt20">
                                                    <div
                                                        class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile">
                                                    </div>
                                                    <div
                                                        class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter blueN sm-w100 sm-mgt20">
                                                        Kinh nghiệm làm việc
                                                    </div>
                                                    <div
                                                        class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile">
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 left">
                                                    <form action="{{ route('staff_update_Experience_Teacher') }}"
                                                        method="post" enctype="multipart/form-data">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" class="form-control" id="inputName"
                                                               placeholder="Nhập tên giáo viên" name="teacher_id"
                                                               value="{{  isset($teacher->teacher_id) ? $teacher->teacher_id : '' }}">

                                                        @if(session('suscess_experience'))
                                                        <div class="alert alert-success alert-dismissible fade show"
                                                            role="alert" style="margin-top: 15px;width: 100%">
                                                            <strong>{{ session('suscess_experience') }}</strong>
                                                            <button type="button" class="close" data-dismiss="alert"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        @endif
                                                        {{--@if(session('erorr_specialize'))--}}
                                                        {{--<div class="alert alert-warning alert-dismissible fade show" role="alert"--}}
                                                        {{--style="margin-top: 15px;width: 100%">--}}
                                                        {{--<strong>{{ session('suscess_specialize') }}</strong>--}}
                                                        {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
                                                        {{--<span aria-hidden="true">&times;</span>--}}
                                                        {{--</button>--}}
                                                        {{--</div>--}}
                                                        {{--@endif--}}
                                                        {{--trinh do chuyên môn--}}
                                                        @if(!empty($experience))
                                                        <div class="boxSchool" id="specialize">
                                                            @foreach($experience as $id_ex=>$exper)
                                                            <div class="deleteItemSpec">
                                                                <p class="clorange f18"
                                                                    style="font-weight: bold;margin-bottom: 10px;">Thời
                                                                    gian
                                                                    :
                                                                    {{ isset($exper->star_working_time) ? $exper->star_working_time : '' }}
                                                                    -
                                                                    {{ isset($exper->end_working_time) ? $exper->end_working_time : '' }}
                                                                </p>

                                                                <div class="form-row">
                                                                    <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                                                        <label for="inputZip" class="fw6">Công ty đã làm
                                                                            việc </label>
                                                                        <input type="text"
                                                                            name='experience[{{ $id_ex }}][company]'
                                                                            id="txtMajorContent"
                                                                            class="requiredbox form-control"
                                                                            value="{{ isset($exper->company) ? $exper->company : '' }}"
                                                                            placeholder="Ví dụ: Công ty cổ phần sắc màu">

                                                                    </div>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                                        <label for="inputZip" class="fw6">Thời gian bắt
                                                                            đầu làm việc
                                                                            - <i>tính theo năm</i> </label>
                                                                        <input type="year"
                                                                            name='experience[{{ $id_ex }}][star_working_time]'
                                                                            class="form-control" id="inputZip"
                                                                            placeholder="Ví dụ: 2015"
                                                                            value="{{ isset($exper->star_working_time	) ? $exper->star_working_time : '' }}">
                                                                    </div>
                                                                    <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                                        <label for="inputZip" class="fw6">Thời gian kết
                                                                            thúc - <i>tính
                                                                                theo năm</i> </label>
                                                                        <input type="year"
                                                                            name='experience[{{ $id_ex }}][end_working_time]'
                                                                            class="form-control" id="inputZip"
                                                                            placeholder="Ví dụ:  2016"
                                                                            value="{{ isset($exper->end_working_time	) ? $exper->end_working_time	 : '' }}">
                                                                    </div>
                                                                    <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                                        <label for="inputZip" class="fw6">Vị trí công
                                                                            việc </label>
                                                                        <input type="text"
                                                                            name='experience[{{ $id_ex }}][position]'
                                                                            id="txtMajorContent"
                                                                            class="requiredbox form-control"
                                                                            value="{{ isset($exper->position) ? $exper->position : '' }}"
                                                                            placeholder="Ví dụ: Kế toán">
                                                                    </div>

                                                                </div>


                                                                <div class="form-row">
                                                                    <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                                                        <label for="inputZip" class="fw6">Mô tả công
                                                                            việc </label>

                                                                        <textarea class="w100 editor"
                                                                            id="editordes{{$id_ex}}"
                                                                            name="experience[{{ $id_ex }}][des_position]"
                                                                            placeholder="Ví dụ: Công việc chủ yếu về kế toán"
                                                                            rows="5">{!! isset($exper->des_position) ? $exper->des_position : '' !!}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="col-lg-12"
                                                                        style="float: right;text-align: right;margin-right: 25px;">
                                                                        <a class="deleteItem_experience"
                                                                            style="    color: white;background: red;padding: 5px 14px;cursor: pointer">Xóa
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <hr class="bgrBlueN">
                                                            </div>
                                                            @endforeach


                                                            <div class="form-group textRight mgt15">
                                                                <a class="whiteIm bgrBlueN pd10 cursor"
                                                                    data-toggle="modal" data-target="#add_experience"><i
                                                                        class="fas fa-plus"></i> Thêm mới
                                                                    kinh nghiệm </a>
                                                            </div>
                                                        </div>


                                                        <div class="form-row mgt20">
                                                            <button type="submit"
                                                                class="pd10-30 whiteIm bgrBlueN fw7 radius5"
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
                            {{--TAB4--}}
                            <div class="tab-pane fade @if(session('suscess_course')) show active @endif" id="tab4"
                                role="tabpanel" aria-labelledby="contact-tab">
                                <div class="CV bgrWhite radius5   mgb20 pdb5"
                                    style="border: 1px solid #ccc;border-top: none;">

                                    <p class="mgt20 mgb0 text-center">Vui lòng cập nhật công việc làm thêm để ứng viên
                                        có thể đăng kí học với bạn</p>
                                    <div class="content">
                                        <div class="row">
                                            <div class="col-md-12  mgt15">
                                                <div>
                                                    @if(session('suscess_course'))
                                                    <div class="alert alert-success alert-dismissible fade show"
                                                        role="alert" style="margin-top: 15px;width: 100%">
                                                        <strong>{{ session('suscess_course') }}</strong>
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="title mgt20">
                                                    <div
                                                        class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile">
                                                    </div>
                                                    <div
                                                        class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter blueN sm-w100 sm-mgt20">
                                                        Công việc làm thêm
                                                    </div>
                                                    <div
                                                        class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile">
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 left">
                                                    <div class="content">

                                                        @if(!empty($errors->all()))
                                                        @foreach($errors->all() as $erorr)
                                                        <span
                                                            style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                                        @endforeach
                                                        @endif

                                                        @if(empty($course))
                                                        <form role="form" action="{{ route('staff_store_Course_Teacher') }}"
                                                            method="POST" class="" enctype="multipart/form-data">
                                                            {!! csrf_field() !!}
                                                            {{ method_field('POST') }}
                                                            @else
                                                            <form role="form"
                                                                action="{{ route('staff_update_Course_Teacher') }}"
                                                                method="POST" class="" enctype="multipart/form-data">
                                                                {!! csrf_field() !!}
                                                                {{ method_field('POST') }}
                                                                @endif

                                                                <input type="hidden" class="form-control" id="inputName"
                                                                       placeholder="Nhập tên giáo viên" name="teacher_id"
                                                                       value="{{  isset($teacher->teacher_id) ? $teacher->teacher_id : '' }}">

                                                                <div class="form-group mgt15">
                                                                    <label for="exampleInputEmail1">Tên công việc làm
                                                                        thêm</label>
                                                                    <input type="text" class="form-control"
                                                                        name="course_name"
                                                                        placeholder="Tên công việc làm thêm"
                                                                        value="{{ isset($course->course_name) ? $course->course_name : '' }}">
                                                                </div>
                                                                <div class="form-group mgt15">
                                                                    <label for="exampleInputEmail1">Thời gian công việc
                                                                        làm thêm</label>
                                                                    <input type="text" class="form-control"
                                                                        name="course_time"
                                                                        placeholder="Thời gian công việc làm thêm"
                                                                        value="{{ isset($course->course_time) ? $course->course_time : '' }}">
                                                                </div>

                                                                <div class="form-group Giá công việc làm thêm">
                                                                    <label for="exampleInputEmail1">Giá công việc làm
                                                                        thêm ( đ )</label>
                                                                    <input type="text" class="form-control formatPrice"
                                                                        name="course_price" placeholder="0" min="1"
                                                                        value="{{ isset($course->course_price) ? $course->course_price : '' }}">
                                                                </div>
                                                                <script>
                                                                    $('.formatPrice').priceFormat({
                                                            prefix: '',
                                                            centsLimit: 0,
                                                            thousandsSeparator: '.'
                                                        });
                                                                </script>
                                                                <div class="form-group">

                                                                    <label for="inputAddress2" class="fw6">Hình ảnh :
                                                                    </label> <a
                                                                        href="https://sanketoan.vn/ho-tro/huong-dan-tai-anh-dai-dien-vao-ho-so-giao-vien-ung-vien-nha-tuyen-dung"
                                                                        target="_blank">(Hướng dẫn chọn ảnh)</a>
                                                                    <div class="">

                                                                        <div class="form-group">
                                                                            <input type="button"
                                                                                onclick="return uploadImage(this);"
                                                                                value="Chọn ảnh" size="20" />
                                                                            <img src="{{ isset($course->course_image) ? $course->course_image : '' }}"
                                                                                width="80" height="" />
                                                                            <input name="images" type="hidden"
                                                                                value="{{ isset($course->course_image) ? $course->course_image : '' }}" />
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="exampleInputEmail1">Giới thiệu công việc
                                                                        làm thêm</label>

                                                                    <textarea name="course_intro" class="w-100" id=""
                                                                        rows="5"
                                                                        cols="80">{{ isset($course->course_intro) ? $course->course_intro : '' }}</textarea>

                                                                    {{--<textarea id="txtNote" name="content" rows="6" class="textarea col-12 bdLightGray radius5"></textarea>--}}
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="exampleInputEmail1">Mô tả công việc làm
                                                                        thêm</label>
                                                                    <textarea name="course_content" class="editor"
                                                                        id="editor3" rows="10"
                                                                        cols="80">{!!  isset($course->course_content) ? $course->course_content : '' !!}</textarea>
                                                                    {{--<textarea id="txtNote" name="content" rows="6" class="textarea col-12 bdLightGray radius5"></textarea>--}}
                                                                </div>


                                                                <div class="form-group">
                                                                    <!-- Google reCaptcha -->
                                                                    <div class="g-recaptcha" id="feedback-recaptcha"
                                                                        data-sitekey="{{ env('RE_CAPTCHA_HTML')  }}">
                                                                    </div>
                                                                    <!-- End Google reCaptcha -->
                                                                </div>
                                                                {{--@if ($errors->has('g-recaptcha-response'))--}}
                                                                {{--<div class="form-group">--}}
                                                                {{--<div class="alert alert-danger">--}}
                                                                {{--<i>Vui lòng xác minh tôi không phải người máy !</i>--}}
                                                                {{--</div>--}}
                                                                {{--</div>--}}
                                                                {{--@endif--}}




                                                                <div class="form-group">
                                                                    <button type="submit"
                                                                        class="btn btn-primary btnOrange">Lưu thay đổi
                                                                    </button>
                                                                </div>
                                                            </form>



                                                            <script type="text/javascript">
                                                                $(document).ready(function() {
                                                $('.select2').select2({
                                                    placeholder: "Chọn ngành nghề",
                                                    allowClear: true
                                                });
                                            });
                                                            </script>
                                                    </div>
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
                            <form action="{{ route('staff_store_Specialize_Teacher') }}" method="post"
                                enctype="multipart/form-data">
                                {!! csrf_field() !!}

                                <input type="hidden" class="form-control" id="inputName"
                                       placeholder="Nhập tên giáo viên" name="teacher_id"
                                       value="{{  isset($teacher->teacher_id) ? $teacher->teacher_id : '' }}">


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
                                                <label for="inputZip" class="fw6">Thời gian bắt đầu học - <i>tính theo
                                                        năm</i> </label>
                                                <input type="text" name='star_specialize_time' class="form-control"
                                                    id="inputZip" placeholder="Ví dụ: 2015">
                                            </div>
                                            <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính theo
                                                        năm</i> </label>
                                                <input type="text" name='end_specialize_time' class="form-control"
                                                    id="inputZip" placeholder="Ví dụ:  2016">
                                            </div>

                                            <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                <label for="inputZip" class="fw6">Tên trường </label>
                                                <input type="text" name='school' class="form-control" id="inputZip"
                                                    placeholder="Ví dụ: Đại học kinh tế TPHCM">
                                            </div>
                                            <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                <label for="inputZip" class="fw6">Trình độ </label>
                                                <select name='leve' id="ddlQualificationType"
                                                    class="selectbox requiredbox form-control">
                                                    <option value="0">-- Chọn Bằng cấp --</option>
                                                    @foreach(\App\Entity\Literacy::get() as $literacy)
                                                    <option value="{{$literacy->literacy_id}}"
                                                        {{ $literacy->literacy_id === old('literacy') && !isset($teacher->literacy)  ? 'selected' : ''}}
                                                        {{ isset($teacher->literacy) && ($teacher->literacy == $literacy->literacy_id) ? 'selected' : ''}}>
                                                        {{$literacy->literacy_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                <label for="inputZip" class="fw6">Ngành học </label>
                                                <input type="text" name='majors' id="txtMajorContent"
                                                    class="requiredbox form-control" value=""
                                                    placeholder="Ví dụ: Quản trị kinh doanh">

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
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary bgorang"
                                            style="border-color: orange">Lưu lại</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                    {{--kinh nghiem ung vien--}}
                    <div class="modal fade bd-example-modal-xl" id="add_experience" tabindex="-1" role="dialog"
                        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <form action="{{ route('staff_store_Experience_Teacher') }}" method="post"
                                enctype="multipart/form-data">
                                {!! csrf_field() !!}

                                <input type="hidden" class="form-control" id="inputName"
                                       placeholder="Nhập tên giáo viên" name="teacher_id"
                                       value="{{  isset($teacher->teacher_id) ? $teacher->teacher_id : '' }}">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Thêm mới kinh nghiệm làm việc
                                        </h5>
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
                                                <label for="inputZip" class="fw6">Thời gian bắt làm việc - <i>tính theo
                                                        năm</i> </label>
                                                <input type="text" name='star_working_time' class="form-control"
                                                    id="inputZip" placeholder="Ví dụ: 2015">
                                            </div>
                                            <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính theo
                                                        năm</i> </label>
                                                <input type="text" name='end_working_time' class="form-control"
                                                    id="inputZip" placeholder="Ví dụ:  2016">
                                            </div>


                                            <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                <label for="inputZip" class="fw6">Vị trí công việc </label>
                                                <input type="text" name='position' class="form-control" id="inputZip"
                                                    placeholder="Ví dụ: Kế toán">
                                            </div>
                                            <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                                <label for="inputZip" class="fw6">Mô tả công việc </label>

                                                <textarea name="des_position" id="editor2" rows="5" cols="100"
                                                    class="w100 form-control editor " style="width: 100%"></textarea>


                                            </div>


                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary bgorang"
                                            style="border-color: orange">Lưu lại</button>
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


                </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(document).ready(function(){
        $('#province').change(function () {
            console.log('ok ')
            $.get('/ajax-district/' + $(this).val(), function (data) {
                $('#district').html(data);
            })
        });
    })
</script>
@endsection
