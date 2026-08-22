<div class="CV bgrWhite radius5 pd20  mgb20 pdb5 UpdateUserTab">
    <p class="text-center clorange mgb5">Kiểm tra lại thông tin hồ sơ rồi ứng tuyển ngay công việc này </p>
    <p class="text-center clorange">Vui lòng hoàn thiện hồ sơ của bạn trên 70% thì mới ứng tuyển được công việc này !</p>
</div>
<div class="CV bgrWhite radius5 pd20  mgb20 pdb5 UpdateUserTab">
    <ul class="nav nav-tabs tabSteep" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link arrowLine @if(session('suscess')) active @endif @if(!session('suscess_specialize') and !session('suscess_experience') and !session('suscess_file')) active @endif"
               id="home-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true">1.Thông
                tin ứng viên
                <div class="triangle_left"></div>
            </a>

        </li>
        <li class="nav-item">
            <a class="nav-link arrowLine @if(session('suscess_specialize'))active @endif" id="profile-tab"
               data-toggle="tab"
               href="#tab2" role="tab" aria-controls="profile" aria-selected="false">2.Trình độ ứng viên
                <div class="triangle_left"></div>
            </a>

        </li>
        <li class="nav-item">
            <a class="nav-link arrowLine @if(session('suscess_experience'))active @endif" id="contact-tab"
               data-toggle="tab"
               href="#tab3" role="tab" aria-controls="contact" aria-selected="false">3.Kinh nghiệm làm việc
                <div class="triangle_left"></div>
            </a>

        </li>
    </ul>
    {{--TAB1--}}
    <div class="tab-content " id="myTabContent">
        <div class="tab-pane fade @if(session('suscess')) show active @endif  @if(!session('suscess_specialize') and !session('suscess_experience') and !session('suscess_file')) show active @endif "
             id="tab1" role="tabpanel" aria-labelledby="home-tab">
            <div class="CV bgrWhite radius5 mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                <div class="content">


                    <div class="row">


                        <div class="col-md-12  mgt15">

                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 sm-w100 textCenter blueN ">Thông
                                    tin ứng viên
                                </div>
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                            </div>
                            @if(session('suscess_job'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert"
                                     style="margin-top: 15px;width: 100%">
                                    <strong>{{ session('suscess_job') }}</strong>
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
                                <form action="{{ route('updateEmployeeSubmit') }}" method="post" class="mbformUpdateEmployee"
                                      enctype="multipart/form-data" id="form_update_user">
                                    {!! csrf_field() !!}

                                    <div class="form-row mgt20 gruopRadio">
                                        <div class="col-md-12 text-center">
                                            <a href="{{  route('show_employee') }}?email={{isset($employee->email) ? $employee->email : ''}}"
                                               class="btnOrange" style="padding: 5px 20px;">Xem hồ sơ</a>
                                        </div>
                                    </div>


                                    <div class="form-group row mgb5 mgt15">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Hoàn thiện hồ sơ :
                                        </label>
                                        <div class="col-sm-9 mgt10 pdLeft0">
                                            <div class="progress lgw60">
                                                <div class="progress-bar progress-bar-striped bg-success"
                                                     role="progressbar" style="width: {{ round($employee->profile) }}%;"
                                                     aria-valuenow="{{ round($employee->profile) }}" aria-valuemin="0"
                                                     aria-valuemax="100">{{ round($employee->profile) }}%
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Trạng thái ứng viên :
                                        </label>
                                        <div class="col-sm-9 gruopRadio pdLeft0">
                                            <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                <input class="form-check-input lgw60" type="radio" name="status"
                                                       id="exampleRadios0"
                                                       value="0" @if($employee->status == 0) checked @endif>
                                                <label class="form-check-label" for="exampleRadios0">
                                                    Đang tìm việc
                                                </label>
                                            </div>
                                            <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                <input class="form-check-input" type="radio" name="status"
                                                       id="exampleRadios1"
                                                       value="1" @if($employee->status == 1) checked @endif>
                                                <label class="form-check-label" for="exampleRadios1">
                                                    Đã đi làm
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Chú ý :
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0">
                                            <span class="clred fw5" id="">(*)</span>
                                            <i style="font-weight: 500">trường thông tin không được để trống</i>
                                        </div>
                                    </div>
                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Họ và tên <span class="clred fw5" id="">(*)</span>
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0">
                                            <input type="text" class="form-control error_border_employee_name lgw60"
                                                   placeholder="Nhập tên ứng viên"
                                                   name="employee_name" id="employee_name"
                                                   value="{{  isset($employee->employee_name) ? $employee->employee_name : '' }}">

                                            <div class="error_message dsBlock">
                                                <div class="mess_notice_employee_name clearfix note_text_employee_name"></div>
                                                <div class="error_reg_mess clearfix error_text_employee_name"></div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Ngày sinh <span class="clred fw5" id="">(*)</span>
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0">
                                            <input type="date" class="form-control error_border_birthday lgw60"
                                                   placeholder="Ngày sinh"
                                                   name="birthday" id="birthday"
                                                   value="{{ isset($employee->birthday) ? $employee->birthday : ''
                                                    }}" max="{{ date("Y-m-d") }}">
                                            <div class="error_message">
                                                <div class="mess_notice_birthday clearfix note_text_birthday"></div>
                                                <div class="error_reg_mess clearfix error_text_birthday"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Email <span class="clred fw5" id="">(*)</span>
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0">
                                            <input type="email" class="form-control lgw60"
                                                   placeholder="Nhập Email"
                                                   name="email"
                                                   value="{{ isset($employee->email) ? $employee->email : $user->email }}"
                                                   readonly>
                                            <i class="mgLeft5 dsBlock"> (Tài khoản đăng nhập ! Đổi tài khoản <a
                                                        href="{{ route('management_account') }}">Tại đây</a> )</i>
                                        </div>
                                    </div>
                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Số điện thoại <span class="clred fw5" id="">(*)</span>
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0">
                                            <input type="number" class="form-control error_border_phone lgw60"
                                                   placeholder="Nhập số điện thoại"
                                                   name="phone" id="phone"
                                                   value="{{ isset($employee->phone) ? $employee->phone : '' }}">
                                            <div class="error_message">
                                                <div class="mess_notice_phone clearfix note_text_phone"></div>
                                                <div class="error_reg_mess clearfix error_text_phone"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Giới tính <span class="clred fw5" id="">(*)</span>
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0">
                                            <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                <input class="form-check-input error_border_gender" type="radio"
                                                       name="gender"
                                                       id="exampleRadios2"
                                                       value="1" @if($employee->gender == 1) checked @endif>
                                                <label class="form-check-label " for="exampleRadios2">
                                                    Nữ
                                                </label>
                                            </div>
                                            <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                <input class="form-check-input error_border_gender" type="radio"
                                                       name="gender"
                                                       id="exampleRadios3"
                                                       value="2" @if($employee->gender == 2) checked @endif>
                                                <label class="form-check-label" for="exampleRadios3">
                                                    Nam
                                                </label>
                                            </div>

                                            <div class="error_message dsBlock">
                                                <div class="mess_notice_gender clearfix note_text_gender"></div>
                                                <div class="error_reg_mess clearfix error_text_gender"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Hình ảnh <span class="clred fw5" id="">(*)</span>
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0">

                                            <div class="form-group">
                                                <input type="button" onclick="return uploadImage(this);"
                                                       value="Chọn ảnh"
                                                       size="20" class="error_text_images"/>
                                                <img src="{{ isset($employee->employee_image) ? $employee->employee_image : '' }}"
                                                     width="80" height=""/>
                                                <input name="images" type="text"
                                                       value="{{ isset($employee->employee_image) ? $employee->employee_image: '' }}"
                                                       style="border:none !important;color: #fff !important;position: absolute;left: 0;width: 84px;z-index: -9;"/>

                                                <a href="https://sanketoan.vn/ho-tro/huong-dan-tai-anh-dai-dien-vao-ho-so-giao-vien-ung-vien-nha-tuyen-dung"
                                                   target="_blank">(Hướng dẫn chọn ảnh)</a>
                                            </div>
                                            <div class="mess_notice_images clearfix note_text_images"></div>
                                            <div class="error_reg_mess clearfix error_text_images"></div>
                                        </div>
                                    </div>

                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Địa chỉ ứng viên :
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0">
                                            <i style="font-weight: 500">Vui lòng chọn đúng địa điểm để tìm việc dễ
                                                hơn</i>
                                        </div>
                                    </div>


                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Địa chỉ cụ thể <span class="clred fw5" id="">(*)</span>
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0">
                                            <input type="text" class="form-control  error_border_address lgw60"
                                                   placeholder="Địa chỉ "
                                                   name="address"
                                                   value="{{ isset($employee->address) ? $employee->address : '' }}">
                                            <div class="error_message">
                                                <div class="mess_notice_address clearfix note_text_address"></div>
                                                <div class="error_reg_mess clearfix error_text_address"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Tỉnh/Thành phố <span class="clred fw5" id="">(*)</span>
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                            <div class="col-md-12 lgw60 pdLeft0 pdRight0">
                                                <select class="form-control select2 error_border_province"
                                                        name="province"
                                                        aria-label="Tỉnh/Thành phố" id="city">
                                                    <option value=""> -- Tất cả các tỉnh/thành phố --</option>
                                                    @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                        <option value="{{$province->province_id}}"
                                                                @if($employee->province == $province->province_id) selected @endif
                                                        >{{$province->province_name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                            <div class="error_message">
                                                <div class="mess_notice_province clearfix note_text_province"></div>
                                                <div class="error_reg_mess clearfix error_text_province"></div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Quận/Huyện <span class="clred fw5" id="">(*)</span>
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                            <div class="col-md-12 lgw60 pdLeft0 pdRight0">
                                                <select class="form-control col-md-6 select2 error_border_district"
                                                        name="district"
                                                        aria-label="Quận/Huyện"
                                                        id="county">
                                                    <option value="">-- Chọn Quận/Huyện --</option>
                                                    @if(!empty($employee->province))
                                                        @foreach(\App\Entity\District::get_province_id($employee->province) as $district)
                                                            <option value="{{$district->district_id }}"
                                                                    @if($employee->district == $district->district_id) selected @endif
                                                            >{{$district->district_name}}</option>
                                                        @endforeach
                                                    @else
                                                        @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                            <option value="{{$district->district_id }}"
                                                                    @if($employee->district == $district->district_id) selected @endif
                                                            >{{$district->district_name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="error_message">
                                                <div class="mess_notice_district clearfix note_text_district"></div>
                                                <div class="error_reg_mess clearfix error_text_district"></div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Công việc <span class="clred fw5" id="">(*)</span>
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                            <div class="col-md-12 lgw60 pdLeft0 pdRight0">
                                                <select class="form-control col-md-6 select2 error_border_career_category_i"
                                                        name="career_category_id"
                                                        aria-label="Quận/Huyện"
                                                        id="">
                                                    <?php $careers = \App\Entity\Career::getAllCareer(); ?>
                                                    <option value="" selected>-- Công việc bạn mong muốn --</option>
                                                    @foreach($careers as $career)
                                                        <option value="{{$career->career_category_id }}"
                                                                @if($employee->career_category_id == $career->career_category_id) selected @endif
                                                        >{{$career->career_category_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="error_message">
                                                <div class="mess_notice_career_category_id clearfix note_text_career_category_id"></div>
                                                <div class="error_reg_mess clearfix error_text_career_category_id"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Mức lương <span class="clred fw5" id="">(*)</span>
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                            <div class="col-md-12 lgw60 pdLeft0 pdRight0">
                                                <select class="form-control col-md-6 select2 error_border_salary_id"
                                                        name="salary_id"
                                                        aria-label="Quận/Huyện"
                                                        id="">
                                                    <?php $salarys = \App\Entity\Salary::showAllSalary(); ?>
                                                    <option value="" selected>-- Mức lương bạn mong muốn --</option>
                                                    @foreach($salarys as $salary)
                                                        <option value="{{$salary->salary_id }}"
                                                                @if($employee->salary_id == $salary->salary_id) selected @endif
                                                        >{{$salary->description}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="error_message">
                                                <div class="mess_notice_salary_id clearfix note_text_salary_id"></div>
                                                <div class="error_reg_mess clearfix error_text_salary_id"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Trình độ <span class="clred fw5" id="">(*)</span>
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                            <div class="col-md-12 lgw60 pdLeft0 pdRight0">
                                                <select name='employee_level_id' id="ddlQualificationType"
                                                        class="selectbox requiredbox form-control col-md-6 select2 error_border_employee_level_id">
                                                    <option value="0" selected>-- Chọn Bằng cấp --</option>
                                                    @foreach(\App\Entity\Literacy::get() as $literacy)
                                                        <option value="{{$literacy->literacy_id}}"
                                                                @if($employee->employee_level_id == $literacy->literacy_id) selected @endif >{{$literacy->literacy_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="error_message">
                                                <div class="mess_notice_employee_level_id clearfix note_text_employee_level_id"></div>
                                                <div class="error_reg_mess clearfix error_text_employee_level_id"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Kinh nghiệm <span class="clred fw5" id="">(*)</span>
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                            <div class="col-md-12 lgw60 pdLeft0 pdRight0">
                                                <select class="form-control col-md-6 select2 error_border_experience_id"
                                                        name='experience_id'>
                                                    <?php $experience_site = \App\Entity\Experience::getAllEx(); ?>
                                                    <option value="0" selected>-- Không yêu cầu --</option>
                                                    @foreach ($experience_site as $ex)

                                                        <option value="{{ $ex->experience_id }}"
                                                                @if($employee->experience_id == $ex->experience_id) selected
                                                                @endif >{{ $ex->experience_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="error_message">
                                                <div class="mess_notice_experience clearfix note_text_experience_id"></div>
                                                <div class="error_reg_mess clearfix error_text_experience_id"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Giới thiệu về bản thân <span class="clred fw5" id="">(*)</span>
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                            <textarea class="textarea w100 form-control editor"
                                                      name="information_verifier" id="editor_verifier"
                                                      style="width: 50%;">{!!   isset($employee->information_verifier) ? $employee->information_verifier : ''  !!}</textarea>

                                            <div class="error_message">
                                                <div class="mess_notice_information_verifier clearfix note_text_information_verifier"></div>
                                                <div class="error_reg_mess clearfix error_text_information_verifier"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Link facebook <span class="clred fw5" id="">(*)</span>
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0">
                                            <input type="text" class="form-control  error_border_address lgw60"
                                                   placeholder="Link facebook của ứng viên "
                                                   name="my_facebook"
                                                   value="{{ isset($employee->my_facebook) ? $employee->my_facebook : '' }}">

                                        </div>
                                    </div>

                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                            Bổ sung :
                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                            <button id="btnAdditional" type="button"
                                                    class="whiteIm bgrBlueN fw7 radius5"
                                                    style="border:none;padding: 5px 20px"><i
                                                        class="fas fa-plus-square "></i></button>
                                        </div>
                                    </div>

                                    <div id="additional">
                                        <div class="form-group row mgb5">
                                            <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                                Mã giới thiệu
                                            </label>
                                            <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                                <input type="text" class="form-control input lgw60"
                                                       placeholder="Nhập mã"
                                                       title="Nhập mã giới thiệu (nếu có từ nhà tuyển dụng)"
                                                       name="code_intro"
                                                       value="{{ isset($employee->code_intro) ? $employee->code_intro : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group row mgb5">
                                            <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                                Chứng minh thư
                                            </label>
                                            <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                                <input type="number" class="form-control input lgw60"
                                                       placeholder="Nhập chưng minh thư nhân dân" name="cmt"
                                                       value="{{ isset($employee->cmt) ? $employee->cmt : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group row mgb5">
                                            <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                                Ngày cấp
                                            </label>
                                            <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                                <input type="date"
                                                       class="form-control input lgw60 error_border_cmt_date"
                                                       placeholder="Nhập ngày cấp"
                                                       name="cmt_date"
                                                       value="{{ isset($employee->cmt_date) ? $employee->cmt_date : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group row mgb5">
                                            <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                                Nơi cấp
                                            </label>
                                            <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                                <input type="text"
                                                       class="form-control input lgw60 error_border_cmt_local"
                                                       placeholder="Nhập nơi cấp"
                                                       name="cmt_local"
                                                       value="{{ isset($employee->cmt_local) ? $employee->cmt_local : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group row mgb5">
                                            <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                                Hôn nhân
                                            </label>
                                            <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                                <div class="form-check"
                                                     style="display: inline-block; margin-right: 10px;">
                                                    <input class="form-check-input error_border_marry" type="radio"
                                                           name="marry"
                                                           id="exampleRadios4"
                                                           value="0" @if($employee->marry == 0) checked @endif>
                                                    <label class="form-check-label" for="exampleRadios4">
                                                        Độc thân
                                                    </label>
                                                </div>
                                                <div class="form-check"
                                                     style="display: inline-block; margin-right: 10px;">
                                                    <input class="form-check-input error_border_marry" type="radio"
                                                           name="marry"
                                                           id="exampleRadios5"
                                                           value="1" @if($employee->marry == 1) checked @endif>
                                                    <label class="form-check-label" for="exampleRadios5">
                                                        Đã kết hôn
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">

                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0">
                                            <div class="g-recaptcha" id="feedback-recaptcha"
                                                 data-sitekey="{{ '6Le9trIUAAAAALrCbKEVd_fFCOjZm13bNMk9DmZP'  }}"></div>
                                            <!-- End Google reCaptcha -->
                                            <div class="error error_g-captcha"></div>
                                            {{--//thong tin tin tuyen tuyen dung--}}
                                            <input type="hidden" name="id_job_fb" value="{{ $id_job_fb }}"/>
                                            <input type="hidden" name="status_job" value="{{ $status_job }}"/>
                                        </div>
                                    </div>

                                    <div class="form-group row mgb5">
                                        <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">

                                        </label>
                                        <div class="col-sm-9 gruopRadio mgt5 pdLeft0">
                                            <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5"
                                                    style="border:none" id="btnloading"> Ứng tuyển ngay
                                            </button>
                                        </div>
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
                                                                    class="selectbox requiredbox form-control"
                                                                    style="height: 35px">
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
                                                    style="border:none" id="btn_specialize">
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

                                                    <div class="form-group  borderSelect2">
                                                        <label for="inputAddress2" class="fw6">Loại hình doanh nghiệp :
                                                            <span
                                                                    class="red">(*)</span></label>

                                                        <select class="form-control select2 error_border_type_of_business_id"
                                                                name='experience[{{ $id_ex }}][type_of_business_id]'
                                                                aria-label="Loại hình doanh nghiệp" id=""
                                                        >
                                                            <option value="" selected>-- Chọn loại hình doanh nghiệp
                                                                --
                                                            </option>
                                                            <?php
                                                            $listtype = \App\Entity\TypeOfBusiness::getAllTypeBusiness();
                                                            ?>
                                                            @foreach($listtype as $type)
                                                                <option value="{{ $type->type_of_business_id }}"
                                                                        @if($exper->type_of_business_id == $type->type_of_business_id) selected @endif
                                                                >{{ $type->type_of_business_name }}</option>
                                                            @endforeach
                                                        </select>



                                                    </div>
                                                    <div class="form-group mgt20 borderSelect2">
                                                        <label for="inputAddress2" class="fw6">Loại hình kinh doanh :
                                                            <span
                                                                    class="red">(*)</span></label>
                                                        <select class="form-control select2 error_border_business"
                                                                aria-label="Loại hình kinh doanh"
                                                                name='experience[{{ $id_ex }}][business]' id=""
                                                        >
                                                            <option value="" selected>-- Chọn loại hình kinh doanh --
                                                            </option>
                                                            <?php
                                                            $business = \App\Entity\Business::getALLSite();
                                                            ?>
                                                            @foreach($business as $busines)
                                                                <option value="{{ $busines->business_type_id }}"
                                                                        @if($exper->business == $busines->business_type_id) selected @endif
                                                                >{{ $busines->business_type_name }}</option>
                                                            @endforeach
                                                        </select>




                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Thời gian bắt đầu
                                                                - <i>tính theo năm</i> </label>
                                                            <input type="year"
                                                                   name='experience[{{ $id_ex }}][star_working_time]'
                                                                   class="form-control" id="inputZip"
                                                                   placeholder="Ví dụ: 2015"
                                                                   value="{{ isset($exper->star_working_time  ) ? $exper->star_working_time : '' }}">
                                                        </div>
                                                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính
                                                                    theo năm</i> </label>
                                                            <input type="year"
                                                                   name='experience[{{ $id_ex }}][end_working_time]'
                                                                   class="form-control" id="inputZip"
                                                                   placeholder="Ví dụ:  2016"
                                                                   value="{{ isset($exper->end_working_time ) ? $exper->end_working_time   : '' }}">
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
                                                    style="border:none" id="btn_experience">
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
        <form action="{{ route('store_Specialize_Employee') }}" method="post" enctype="multipart/form-data"
              id="update_store_specialze_employee">
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
                            <input type="text" name='star_specialize_time'
                                   class="form-control error_border_star_specialize_time" id="inputZip"
                                   placeholder="Ví dụ: 2015">

                            <div class="mess_notice_star_specialize_time clearfix note_text_star_specialize_time"></div>
                            <div class="error_reg_mess clearfix error_text_star_specialize_time"></div>
                        </div>
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính theo năm</i> </label>
                            <input type="text" name='end_specialize_time'
                                   class="form-control error_border_end_specialize_time" id="inputZip"
                                   placeholder="Ví dụ:  2016">


                            <div class="mess_notice_end_specialize_time_time clearfix note_text_end_specialize_time"></div>
                            <div class="error_reg_mess clearfix error_text_end_specialize_time"></div>
                        </div>

                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Tên trường </label>
                            <input type="text" name='school' class="form-control error_border_school" id="inputZip"
                                   placeholder="Ví dụ: Đại học kinh tế TPHCM">

                            <div class="mess_notice_school clearfix note_text_school"></div>
                            <div class="error_reg_mess clearfix error_text_school"></div>
                        </div>
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Trình độ </label>
                            <select name='leve' id="ddlQualificationType"
                                    class="selectbox requiredbox form-control error_border_leve" style="height: 35px">
                                <option value="">-- Chọn Bằng cấp --</option>
                                @foreach(\App\Entity\Literacy::get() as $literacy)
                                    <option value="{{$literacy->literacy_id}}"
                                            {{ $literacy->literacy_id === old('literacy') && !isset($employee->literacy)  ? 'selected' : ''}}
                                            {{ isset($employee->literacy) && ($employee->literacy == $literacy->literacy_id) ? 'selected' : ''}}
                                    >{{$literacy->literacy_name}}</option>
                                @endforeach
                            </select>

                            <div class="mess_notice_leve clearfix note_text_leve"></div>
                            <div class="error_reg_mess clearfix error_text_leve"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Ngành học </label>
                            <input type="text" name='majors' id="txtMajorContent"
                                   class="requiredbox form-control error_border_majors"
                                   value="" placeholder="Ví dụ: Quản trị kinh doanh">


                            <div class="mess_notice_majors_time_time clearfix note_text_majors"></div>
                            <div class="error_reg_mess clearfix error_text_majors"></div>

                        </div>
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Tình trạng </label>
                            <input type="text" id="txtCertificate" name='specialize_status'
                                   class="requiredbox form-control error_text_specialize_status" value=""
                                   placeholder="Ví dụ: Đã tốt nghiệp hoặc chưa tốt nghiệp">

                            <div class="mess_notice_specialize_status_time_time clearfix note_text_specialize_status"></div>
                            <div class="error_reg_mess clearfix error_text_specialize_status"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn whiteIm bgrBlueN fw7" data-dismiss="modal"
                            style="border: none;padding: 4px 15px;">Đóng
                    </button>

                    <button type="submit" class="btn whiteIm bgrBlueN fw7 radius5"
                            style="border: none;padding: 4px 15px;" id="btn_update_store_specialze_employee">
                        Lưu lại
                    </button>


                </div>

            </div>
        </form>
    </div>
</div>

{{--kinh nghiem ung vien--}}
<div class="modal fade bd-example-modal-xl" id="add_experience" tabindex="-1" role="dialog"
     aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('store_Experience_Employee') }}" method="post" enctype="multipart/form-data"
              id="store_Experience_Employee">
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
                            <input type="text" name='company' class="form-control error_border_company" id="inputZip"
                                   placeholder="Ví dụ: Công ty cổ phần sắc màu Việt Nam">

                            <div class="mess_notice_company clearfix note_text_company"></div>
                            <div class="error_reg_mess clearfix error_text_company"></div>
                        </div>

                        <div class="form-group  borderSelect2 row" style="padding: 0 5px;">
                            <div class="col-md-6">
                                <label for="inputAddress2" class="fw6">Loại hình doanh nghiệp : <span
                                            class="red">(*)</span></label>

                                <select class="form-control select2 error_border_type_of_business_id"
                                        name="type_of_business_id" id="type_of_business_id"
                                        aria-label="Loại hình doanh nghiệp"
                                >
                                    <option value="" selected>-- Chọn loại hình doanh nghiệp --</option>
                                    <?php
                                    $listtype = \App\Entity\TypeOfBusiness::getAllTypeBusiness();
                                    ?>
                                    @foreach($listtype as $type)
                                        <option value="{{ $type->type_of_business_id }}"

                                        >{{ $type->type_of_business_name }}</option>
                                    @endforeach
                                </select>

                                <div class="error_message">
                                    <div class="mess_notice_type_of_business_id clearfix note_text_type_of_business_id"></div>
                                    <div class="error_reg_mess clearfix error_text_type_of_business_id"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputAddress2" class="fw6">Loại hình kinh doanh : <span
                                            class="red">(*)</span></label>
                                <select class="form-control select2 error_border_business" name="business"
                                        aria-label="Loại hình kinh doanh" id="business"
                                >
                                    <option value="" selected>-- Chọn loại hình kinh doanh --</option>
                                    <?php
                                    $business = \App\Entity\Business::getALLSite();
                                    ?>
                                    @foreach($business as $busines)
                                        <option value="{{ $busines->business_type_id }}"

                                        >{{ $busines->business_type_name }}</option>
                                    @endforeach
                                </select>

                                <div class="error_message dsBlock">
                                    <div class="mess_notice_business clearfix note_text_business"></div>
                                    <div class="error_reg_mess clearfix error_text_business"></div>
                                </div>
                            </div>


                        </div>


                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Thời gian bắt làm việc - <i>tính theo năm</i> </label>
                            <input type="text" name='star_working_time'
                                   class="form-control error_border_star_working_time" id="inputZip"
                                   placeholder="Ví dụ: 2015">
                            <div class="mess_notice_star_working_time clearfix note_text_star_working_time"></div>
                            <div class="error_reg_mess clearfix error_text_star_working_time"></div>
                        </div>
                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính theo năm</i> </label>
                            <input type="text" name='end_working_time'
                                   class="form-control error_border_end_working_time" id="inputZip"
                                   placeholder="Ví dụ:  2016">

                            <div class="mess_notice_end_working_time clearfix note_text_end_working_time"></div>
                            <div class="error_reg_mess clearfix error_text_end_working_time"></div>
                        </div>


                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Vị trí công việc </label>
                            <input type="text" name='position' class="form-control error_border_position" id="inputZip"
                                   placeholder="Ví dụ: Du lịch">
                            <div class="mess_notice_position clearfix note_text_position"></div>
                            <div class="error_reg_mess clearfix error_text_position"></div>
                        </div>
                        <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Mô tả công việc </label>

                            <textarea name="des_position" id="editor2" rows="5" cols="100"
                                      class="w100 form-control editor "
                                      style="width: 100%"></textarea>
                            <div class="mess_notice_des_position clearfix note_text_des_position"></div>
                            <div class="error_reg_mess clearfix error_text_des_position"></div>


                        </div>


                    </div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn whiteIm bgrBlueN fw7" data-dismiss="modal"
                            style="border: none;padding: 4px 15px;">Đóng
                    </button>

                    <button type="submit" class="btn whiteIm bgrBlueN fw7 radius5"
                            style="border: none;padding: 4px 15px;" id="btn_store_Experience_Employee">
                        Lưu lại
                    </button>


                </div>

            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#form_update_user").validate({
            ignore: [],
            onkeyup: false,
            rules: {
                employee_name: {
                    required: true,
                    minlength: 5,
                    checkName: true,
                },
                birthday: {
                    required: true,
                    checkBirthday: true,
                    checkBirthday_hople: true,
                    max: "{{ date('Y-m-d') }}",
                },
                phone: {
                    required: true,
                    checkPhone: true,
                },
                gender: {
                    required: true,
                },
                images: {
                    required: true,
                },
                province: {
                    required: true,
                },
                district: {
                    required: true,
                },
                address: {
                    required: true,
                },
                career_category_id: {
                    required: true,
                },
                salary_id: {
                    required: true,
                },
                employee_level_id: {
                    required: true,
                },
                experience_id: {
                    required: true,
                },
            },
            messages: {
                employee_name: {
                    required: 'Vui lòng nhập vào họ và tên.',
                    minlength: 'Họ và tên phải tối thiểu 5 ký tự.',
                    checkName: 'Họ và tên không được chứa số và ký tự đặc biệt.',
                },
                birthday: {
                    required: 'Vui lòng nhập vào ngày tháng năm sinh.',
                    checkBirthday: 'Bạn chưa đủ 18 tuổi.',
                    checkBirthday_hople: 'Năm sinh không hợp lệ.',
                    max: 'Năm sinh không hợp lệ',
                },
                phone: {
                    required: 'Số điện thoại phải là số và không được để trống.',
                    checkPhone: 'Số điện thoại không hợp lệ',
                },
                gender: {
                    required: 'Vui lòng chọn giới tính.',
                },
                images: {
                    required: 'Vui lòng chọn ảnh đại diện.',
                },
                province: {
                    required: 'Vui lòng chọn tỉnh / thành phố.',
                },
                district: {
                    required: 'Vui lòng chọn quận / huyện.',
                },
                address: {
                    required: 'Vui lòng nhập địa chỉ cụ thể.',
                },
                career_category_id: {
                    required: 'Vui lòng chọn công việc bạn mong muốn.',
                },
                salary_id: {
                    required: 'Vui lòng chọn mức lương bạn mong muốn.',
                },
                employee_level_id: {
                    required: 'Vui lòng chọn trình độ.',
                },
                experience_id: {
                    required: 'Vui lòng chọn kinh nghiệm làm việc.',
                },
            },
            onfocusout: function (element) {
                $(element).valid();
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                $('.note_text_' + name).hide();
                $('.error_text_' + name).html('<i class="error"><span class="error_reg_mess_icon"></span>' + error.text() + '</i>');
                $('#note_' + name).hide();
                $('.error_border_' + name).css("cssText", "border: 1px solid #ff0000  !important;");
                $('.btn-loading').button('reset');

            },
            success: function (label, element) {
                var name = $(element).attr("name");
                $('.note_text_' + name).show();
                $('.error_text_' + name).html('');
                $('.error_border_' + name).css("cssText", "border: 1px solid #e0e0e0  !important;");
                $('#js_btnRegidit').attr('disabled', false);

            },
            submitHandler: function (form) {
                form.submit();
            }

        });

    });
    //tao jquery load button
    $('#btnloading').click(function () {
        if ($('#form_update_user').valid()) {
            if (grecaptcha.getResponse() == "") {
                $('.error_g-captcha').text("Vui lòng tích chọn tôi không phải người máy");
                $('.error_g-captcha').css('margin-bottom', '5px');
                return false;
            }
            else {
                $('.error_g-captcha').text("");
            }


            $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang nộp hồ sơ ứng tuyển ...');
            $btn.attr('disabled', false);
        }
        else {
        }
    });


</script>
{{--trình độ ứng viên--}}
<script>
    $(document).ready(function () {
        //validate
        $("#update_store_specialze_employee").validate({
            ignore: [],
            onkeyup: false,
            rules: {
                star_specialize_time: {
                    required: true,
                },
                end_specialize_time: {
                    required: true,
                },
                school: {
                    required: true,
                },
                leve: {
                    required: true,
                },
                majors: {
                    required: true,
                },
                specialize_status: {
                    required: true,
                },

            },
            messages: {
                star_specialize_time: {
                    required: 'Vui lòng nhập thời gian bắt đầu học - tính theo năm.',
                },
                end_specialize_time: {
                    required: 'Vui lòng nhập thời gian kết thúc - tính theo năm.',
                },
                school: {
                    required: 'Vui lòng nhập tên trường.',
                },
                leve: {
                    required: 'Vui lòng chọn trình độ.',
                },
                majors: {
                    required: 'Vui lòng nhập ngành học.',
                },
                specialize_status: {
                    required: 'Vui lòng nhập tình trạng.',
                },

            },
            onfocusout: function (element) {
                $(element).valid();
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                $('.note_text_' + name).hide();
                $('.error_text_' + name).html('<i class="error"><span class="error_reg_mess_icon"></span>' + error.text() + '</i>');
                $('.error_border_' + name).css("cssText", "border: 1px solid #ff0000  !important;");
                $('.btn-loading').button('reset');
            },
            success: function (label, element) {
                var name = $(element).attr("name");
                $('.note_text_' + name).show();
                $('.error_text_' + name).html('');
                $('.error_border_' + name).css("cssText", "border: 1px solid #e0e0e0  !important;");
                $('#js_btnRegidit').attr('disabled', false);

            },
            submitHandler: function (form) {
                form.submit();
            }

        });
    });
    $('#btn_update_store_specialze_employee').click(function () {
        if ($('#update_store_specialze_employee').valid()) {
            $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lưu trình độ ứng viên ...');
            $btn.attr('disabled', false);

        }
        else {
        }
    });
</script>
<script>
    $(document).ready(function () {
        $('.select2').select2();

        //validate
        $("#store_Experience_Employee").validate({
            ignore: [],
            onkeyup: false,
            rules: {
                company: {
                    required: true,
                },
                type_of_business_id: {
                    required: true,
                },
                business: {
                    required: true,
                },
                star_working_time: {
                    required: true,
                },
                end_working_time: {
                    required: true,
                },
                position: {
                    required: true,
                },
            },
            messages: {
                company: {
                    required: 'Vui lòng nhập tên công ty đã làm việc',
                },
                type_of_business_id: {
                    required: 'Loại hình doanh nghiệp không được để trống',
                },
                business: {
                    required: 'Loại hình kinh doanh không được để trống',
                },
                star_working_time: {
                    required: 'Vui lòng nhập thời gian bắt làm việc - tính theo năm.',
                },
                end_working_time: {
                    required: 'Vui lòng nhập thời gian kết thúc - tính theo năm.',
                },
                position: {
                    required: 'Vui lòng nhập vị trí công việc.',
                },
            },
            onfocusout: function (element) {
                $(element).valid();
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                $('.note_text_' + name).hide();
                $('.error_text_' + name).html('<i class="error"><span class="error_reg_mess_icon"></span>' + error.text() + '</i>');
                $('.error_border_' + name).css("cssText", "border: 1px solid #ff0000  !important;");
                $('.btn-loading').button('reset');
            },
            success: function (label, element) {
                var name = $(element).attr("name");
                $('.note_text_' + name).show();
                $('.error_text_' + name).html('');
                $('.error_border_' + name).css("cssText", "border: 1px solid #e0e0e0  !important;");
                $('#js_btnRegidit').attr('disabled', false);

            },
            submitHandler: function (form) {
                form.submit();
            }

        });
    });
    $('#btn_store_Experience_Employee').click(function () {
        if ($('#store_Experience_Employee').valid()) {
            $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lưu ...');
            $btn.attr('disabled', false);
        }
        else {
        }
    });
    $('#btn_specialize').click(function () {

        $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lưu ...');
        $btn.attr('disabled', false);

    });
    $('#btn_experience').click(function () {

        $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lưu ...');
        $btn.attr('disabled', false);

    });

</script>

<script>
    // chon thanh pho ra quan huyen
    $('#city').change(function () {
        var city = $(this).val();
        $.get('/tim-kiem-huyen/' + city, function (data) {
            $('#county').html('');
            $('#county').html(data);
        });
    });

    $('.deleteItem').click(function () {
        var success_remove = '';
        success_remove = confirm("Bạn có muốn xóa  thời gian này không ! Vui lòng chọn lưu thay đổi để xác nhận .");
        if (success_remove) {
            $(this).parent().parent().parent().remove();
        }
    });
    $('.deleteItem_experience').click(function () {
        var success_remove = '';
        success_remove = confirm("Bạn có muốn xóa  thời gian này không ! Vui lòng chọn lưu thay đổi để xác nhận .");
        if (success_remove) {
            $(this).parent().parent().parent().remove();
        }

    });

</script>

<script type="text/javascript">
    $('.select2').select2({
        width: '100%'
    });
    $('#additional').hide();
    $("#btnAdditional").click(function () {
        $('#additional').slideToggle('slow');
    });
</script>


<div class="modal fade notification" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal_bg">
                <h5 class="modal-title" id="exampleModalLabel">Chú ý</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal_close" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body fw6">
                @if(session('suscess'))
                    Cập nhật thông tin ứng viên thành công! Ấn tiếp tục để cập nhật thêm trình độ ứng viên.
                @endif
                @if(session('suscess_specialize'))
                    Cập nhật trình độ ứng viên thành công! Ấn tiếp tục để cập nhật thêm kinh nghiệm làm việc.
                @endif
                @if(session('suscess_experience'))
                    Cảm ơn bạn đã cập nhật đầy đủ thông tin! sanketoan.vn chúc bạn sớm có công việc phù hợp.
                @endif
            </div>
            <div class="modal-footer">
                @if(session('suscess_experience'))
                    <button type="button" class="btn modal_bg" data-dismiss="modal">OK</button>
                @endif
                @if(session('suscess_specialize') || session('suscess'))
                    <button type="button" class="btn js_success" data-dismiss="modal">Để sau</button>
                    <button type="button" class="btn modal_bg continue">Tiếp tục</button>
                @endif
            </div>
        </div>
    </div>
</div>

@if(session('suscess'))
    <script type="text/javascript">
        $('.notification').modal('show');
        $('.continue').click(function (event) {
            /* Act on the event */
            $('.notification').modal('hide');
            $('#home-tab').removeClass('active show');
            $('#home-tab').attr('aria-selected', false);
            $('#tab1').removeClass('active show');
            $('#profile-tab').addClass('active show');
            $('#profile-tab').attr('aria-selected', true);
            $('#tab2').addClass('show active');

        });
    </script>
@endif
@if(session('suscess_specialize'))
    <script type="text/javascript">
        $('.notification').modal('show');
        $('.continue').click(function (event) {
            /* Act on the event */
            $('.notification').modal('hide');
            $('#profile-tab').removeClass('active show');
            $('#profile-tab').attr('aria-selected', false);
            $('#tab2').removeClass('show active');
            $('#contact-tab').addClass('active show');
            $('#contact-tab').attr('aria-selected', true);
            $('#tab3').addClass('show active');

        });
    </script>
@endif
@if(session('suscess_experience'))
    <script type="text/javascript">
        $('.notification').modal('show');
        $('.continue').click(function (event) {
            /* Act on the event */

        });
    </script>
@endif

<style>
    .select2-container {
        width: 100% !important;
        padding: 0;
    }

    span.select2 {
        display: table;
        table-layout: fixed;
        width: 100% !important;
    }
    .notification button
    {
        background:#009385;
        color: #fff;
    }
</style>
