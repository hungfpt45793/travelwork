{{--cac buoc tao ho so--}}
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
                            <a>Lưu ý : Nếu bạn thay đổi thông tin hồ sơ thì bạn vui lòng lưu hồ sơ trước khi quay lại bước xác thực tài khoản</a>
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
                <a class="clgreen step_active_link_success"
                   >
                    <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                    <span class="clgreen  f16"> Hoàn thiện hồ sơ</span>
                </a>
            @else
                <a class="clorange step_active_link item_no_success ">

                    <span><i class="fas fa-users step_icon"></i></span>
                    <span class=" clorange f16"> Hoàn thiện hồ sơ</span>
                </a>
            @endif

            <img class="next_step" src="{{ asset('assets/image/next.png') }}">
        </div>

        <div class="item_step">
            <?php
            //xác thực tài khoản
            $employee_id_cv = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
            $check_cv_employee = '';
            $check_cv_employee = \App\Entity\Cv_employee::check_cv_employee($employee_id_cv->employee_id);
            ?>
            @if(!empty($check_cv_employee))
                <a class="clgreen"
                   href="#" data-toggle="modal" data-target="#step_create_CV">
                    <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                    <span class=" clgreen f16"> Tạo CV</span>
                </a>
            @else
                <a class="clorange item_no_success"
                   href="#" data-toggle="modal" data-target="#step_create_CV">

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
                               <a>Lưu ý : Nếu bạn thay đổi thông tin hồ sơ thì bạn vui lòng lưu hồ sơ trước khi chuyển sang bước tiếp theo</a>
                            </div>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-secondary" data-dismiss="modal" style="    padding: .375rem .75rem;;color: #fff">Đóng</a>
                                <a type="button" class="btn btn-primary" href="{{ route('create_emplyee_cv') }}" style="    padding: .375rem .75rem;">Tiếp tục</a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>


        <div class="item_step">
            <a class=" clgreen " href="#" data-toggle="modal" data-target="#step_syll">
                <span> <i class="fab fa-discourse step_icon"></i></span>
                <span class=" clgreen f16">Khóa học sanketoan</span>
            </a>
            <div class="modal fade" id="step_syll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Khóa học của sanektoan.vn</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <a>Lưu ý : Nếu bạn thay đổi thông tin CV thì bạn vui lòng lưu CV trước khi chuyển sang bước tiếp theo</a>
                        </div>
                        <div class="modal-footer">
                            <a type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: .375rem .75rem;;color: #fff">Đóng</a>
                            <a type="button" class="btn btn-primary" href="{{ route('course_index') }}" style="    padding: .375rem .75rem;">Tiếp tục</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>


<div class="CV bgrWhite radius5 mgt20 mgb20 pdb5 pdt10" style="border: 1px solid #ccc;">

    <div class="content">


        <div class="row mgt20">


            <div class="col-md-12">

                <div class="title ">
                    <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                    <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 sm-w100 textCenter blueN ">Hồ sơ ứng viên
                    </div>
                    <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                </div>
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

                    <form action="{{ route('updateEmployee') }}" method="post"
                          class="mbformUpdateEmployee form_color_input"
                          enctype="multipart/form-data" id="form_update_user">
                        {!! csrf_field() !!}




                        {{--<div class="form-group row mgb5 mgt15">--}}
                        {{--<label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">--}}
                        {{--Hoàn thiện hồ sơ :--}}
                        {{--</label>--}}
                        {{--<div class="col-sm-9 mgt10 pdLeft0">--}}
                        {{--<div class="progress lgw60">--}}
                        {{--<div class="progress-bar progress-bar-striped bg-success"--}}
                        {{--role="progressbar" style="width: {{ round($employee->profile) }}%;"--}}
                        {{--aria-valuenow="{{ round($employee->profile) }}" aria-valuemin="0"--}}
                        {{--aria-valuemax="100">{{ round($employee->profile) }}%--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}


                        <div class="form-group row mgb5">
                            <label for="staticEmail" class="col-sm-12 col-form-label fw6 text-left">
                                Chú ý : <span class="clred fw5" id="">(*)</span>
                                <i style="font-weight: 500">trường thông tin không được để trống</i>
                            </label>


                        </div>
                        <div class="form-group row mgb5">
                            <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right ">
                                Năm bắt đầu đi làm việc : <span class="clred fw5" id="">(*)</span>
                                <br>
                                <span>

                                 <i class="f12 fw5">(hệ thống sẽ tính năm KN theo thời gian thực)</i>
                            </span>
                            </label>

                            <div class="col-sm-4 gruopRadio mgt5 pdLeft0 borderSelect2 ">
                                <div class="col-md-12  pdLeft0 pdRight0">
                                    <?php
                                    $date_today = date_create();
                                    $year_today = date_format($date_today, "Y");
                                    ?>
                                    {{--time_to_work--}}
                                    <div class="col-md-12  pdLeft0 pdRight0 ">

                                        <select class="form-control select2 error_border_province js_select_2_change"
                                                name="time_to_work"
                                                aria-label="Năm bắt đầu đi làm việc" id="time_to_work">
                                            @for($year_today; $year_today >= 1950 ; $year_today--)
                                                <option value="{{ $year_today }}"
                                                        @if($employee->time_to_work == $year_today) selected @endif
                                                >Năm {{ $year_today }} </option>
                                            @endfor

                                        </select>
                                        <i><span class="js_result_year_ex f12 clred"></span></i>

                                    </div>


                                    <div class="error_message">
                                        <div class="mess_notice_time_to_work clearfix note_text_time_to_work"></div>
                                        <div class="error_reg_mess clearfix error_text_time_to_work"></div>
                                    </div>

                                </div>


                            </div>
                            <div class="col-sm-4">


                                <div class="form-group mgb0">

                                    <div class="form-group">
                                        <input type="button" onclick="return uploadImage(this);"
                                               value="Chọn ảnh"
                                               size="20" class="error_text_image"/>
                                        <img src="{{ isset($employee->employee_image) ? $employee->employee_image : '' }}"
                                             width="80" height=""/>
                                        <input name="images" type="text"
                                               value="{{ isset($employee->employee_image) ? $employee->employee_image: '' }}"
                                               style="border:none !important;color: #fff !important;position: absolute;left: 0;width: 84px;z-index: -9;"/>

                                        <a href="https://sanketoan.vn/ho-tro/huong-dan-tai-anh-dai-dien-vao-ho-so-giao-vien-ung-vien-nha-tuyen-dung"
                                           target="_blank">(Hướng dẫn chọn ảnh)</a>
                                    </div>

                                    {{--<input type="button" onclick="return uploadImage(this);"--}}
                                    {{--value="Chọn ảnh"--}}
                                    {{--size="20" class="error_text_images"/>--}}
                                    {{--<img src="{{ isset($employee->employee_image) ? $employee->employee_image : '' }}"--}}
                                    {{--width="80" height=""/>--}}
                                    {{--<input name="images" type="text" id="images"--}}
                                    {{--value="{{ isset($employee->employee_image) ? $employee->employee_image: '' }}"--}}
                                    {{--style="border:none !important;color: #fff !important;position: absolute;left: 0;width: 84px;z-index: -9;"/>--}}

                                </div>
                                <div class="mess_notice_images clearfix note_text_images"></div>
                                <div class="error_reg_mess clearfix error_text_images"></div>
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
                                Trình độ cao nhất<span class="clred fw5" id="">(*)</span>
                            </label>
                            <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                <div class="col-md-12 lgw60 pdLeft0 pdRight0">
                                    <select name='employee_level_id' id="ddlQualificationType"
                                            class="selectbox requiredbox form-control col-md-6 select2 error_border_employee_level_id">
                                        <option value="" selected>-- Chọn Bằng cấp --</option>
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
                                Mức lương mong muốn <span class="clred fw5" id="">(*)</span>
                            </label>
                            <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                <div class="col-md-12 lgw60 pdLeft0 pdRight0">
                                    <select class="form-control col-md-6 select2 error_border_salary_id"
                                            name="salary_id"
                                            aria-label="Mức lương mong muốn"
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
                                Giới tính <span class="clred fw5" id="">(*)</span>
                            </label>
                            <div class="col-sm-9 gruopRadio mgt5 pdLeft0">
                                <div class="form-check cus_check_radio">
                                    <label class="form-check-label label_radio">
                                    <input class="form-check-input error_border_gender" type="radio"
                                           name="gender"
                                           id="exampleRadios2"
                                           value="1" @if($employee->gender == 1) checked @endif>

                                        Nữ
                                    </label>
                                </div>
                                <div class="form-check cus_check_radio ">
                                    <label class="form-check-label label_radio">
                                    <input class="form-check-input error_border_gender" type="radio"
                                           name="gender"
                                           id="exampleRadios3"
                                           value="2" @if($employee->gender == 2) checked @endif>

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
                                Hôn nhân
                            </label>
                            <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                <div class="form-check cus_check_radio \">
                                    <label class="form-check-label label_radio">
                                    <input class="form-check-input error_border_marry" type="radio"
                                           name="marry"
                                           id="exampleRadios4"
                                           value="0" @if($employee->marry == 0) checked @endif>

                                        Độc thân
                                    </label>
                                </div>
                                <div class="form-check cus_check_radio ">
                                    <label class="form-check-label label_radio">
                                    <input class="form-check-input error_border_marry" type="radio"
                                           name="marry"
                                           id="exampleRadios5"
                                           value="1" @if($employee->marry == 1) checked @endif>

                                        Đã kết hôn
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mgb5">
                            <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                Mã giới thiệu (nếu có)
                            </label>
                            <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                <input type="text" class="form-control input lgw60"
                                       placeholder=" Mã giới thiệu (nếu có)"
                                       title="Nhập mã giới thiệu (nếu có từ nhà tuyển dụng)"
                                       name="code_intro"
                                       value="{{ isset($employee->code_intro) ? $employee->code_intro : '' }}">
                            </div>
                        </div>

                        <div class="title mgt20 mgb15">
                            <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                            <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 sm-w100 textCenter blueN ">Thông tin đã
                                đăng kí
                            </div>
                            <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                        </div>
                        <div class="form-group row mgb5">
                            <div class="col-md-6">
                                <div class="form-group row mgb5">
                                    <label for="staticEmail" class="col-sm-4 col-form-label fw6 text-right">
                                        Họ và tên <span class="clred fw5" id="">(*)</span>
                                    </label>
                                    <div class="col-sm-8 gruopRadio mgt5 pdLeft0">
                                        <input type="text" class="form-control error_border_employee_name"
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
                                    <label for="staticEmail" class="col-sm-4 col-form-label fw6 text-right">
                                        Email <span class="clred fw5" id="">(*)</span>
                                    </label>
                                    <div class="col-sm-8 gruopRadio mgt5 pdLeft0">
                                        <input type="email" class="form-control"
                                               placeholder="Nhập Email"
                                               name="email"
                                               value="{{ isset($employee->email) ? $employee->email : $user->email }}"
                                               readonly>

                                    </div>
                                </div>
                                <div class="form-group row mgb5">
                                    <label for="staticEmail" class="col-sm-4 col-form-label fw6 text-right">
                                        Số điện thoại <span class="clred fw5" id="">(*)</span>
                                    </label>
                                    <div class="col-sm-8 gruopRadio mgt5 pdLeft0">
                                        <input type="number" class="form-control error_border_phone"
                                               placeholder="Nhập số điện thoại"
                                               name="phone" id="phone"
                                               value="{{ isset($employee->phone) ? $employee->phone : '' }}">
                                        <div class="error_message">
                                            <div class="mess_notice_phone clearfix note_text_phone"></div>
                                            <div class="error_reg_mess clearfix error_text_phone"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group row mgb5">
                                    <label for="staticEmail" class="col-sm-4 col-form-label fw6 text-right">
                                        Công việc cần tìm<span class="clred fw5" id="">(*)</span>
                                    </label>
                                    <div class="col-sm-8 gruopRadio mgt5 pdLeft0 borderSelect2">
                                        <div class="col-md-12 pdLeft0 pdRight0">
                                            <select class="form-control col-md-6  select2_muti error_border_career_category_i"
                                                    name="career_category_id[]" multiple
                                                    id="">
                                                <?php $careers = \App\Entity\Career::getAllCareer();
                                                $carre_array = \App\Entity\Employee_career_categories::get_array_career_id($employee->employee_id);
//                                                echo '----------------------';
//                                                print_r($carre_array);die;
                                                ?>
                                                @foreach($careers as $career)
                                                    <option value="{{$career->career_category_id }}"
                                                            @if(in_array($career->career_category_id,$carre_array)) selected @endif
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
                                    <label for="staticEmail" class="col-sm-4 col-form-label fw6 text-right">
                                        Kinh nghiệm làm việc<span class="clred fw5" id="">(*)</span>
                                    </label>
                                    <div class="col-sm-8 gruopRadio mgt5 pdLeft0 borderSelect2">
                                        <div class="col-md-12 pdLeft0 pdRight0">
                                            <select class="form-control col-md-6   select2_muti error_border_career_category_i"
                                                    name="business_type_id[]" multiple
                                                    id="">
                                                <?php $business = \App\Entity\Business::get_all_buiness();
                                                $carre_business = \App\Entity\Employee_business_type::get_array_business_id($employee->employee_id);
//                                                echo '----------------------';
//                                                print_r($carre_array);die;
                                                ?>
                                                @foreach($business as $bui)
                                                    <option value="{{$bui->business_type_id }}"
                                                            @if(in_array($bui->business_type_id,$carre_business)) selected @endif
                                                    >{{$bui->business_type_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="error_message">
                                            <div class="mess_notice_business_type_id clearfix note_text_business_type_id"></div>
                                            <div class="error_reg_mess clearfix error_text_business_type_id"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mgb5">
                                    <label for="staticEmail" class="col-sm-4 col-form-label fw6 text-right">
                                        Tỉnh/Thành phố <span class="clred fw5" id="">(*)</span>
                                    </label>
                                    <div class="col-sm-8 gruopRadio mgt5 pdLeft0 borderSelect2">
                                        <div class="col-md-12 pdLeft0 pdRight0">
                                            <select class="form-control select2 error_border_province"
                                                    name="province"
                                                    aria-label="Tỉnh/Thành phố" id="city">
                                                <option value=""> -- Tất cả các tỉnh/thành phố --</option>
                                                @foreach(\App\Entity\Province::getAllProvince() as $province)
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
                                    <label for="staticEmail" class="col-sm-4 col-form-label fw6 text-right">
                                        Quận/Huyện <span class="clred fw5" id="">(*)</span>
                                    </label>
                                    <div class="col-sm-8 gruopRadio mgt5 pdLeft0 borderSelect2">
                                        <div class="col-md-12  pdLeft0 pdRight0">
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
                            </div>
                        </div>

                        <div class="form-group row mgb5">
                            <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                <?php
                                //check xac thuc tai khoan
                                $check_status_account = \App\Entity\User::check_status_email_account(\Illuminate\Support\Facades\Auth::user()->id)
                                ?>
                                @if(!empty($check_status_account->status_email_account))
                                    <a href="{{ route('show_step_profile_employee') }}" class="link_back"><i
                                                class="fas fa-long-arrow-alt-left"></i> Quay lại </a>
                                @else
                                    <a href="{{ route('management_account') }}" class="link_back"><i
                                                class="fas fa-long-arrow-alt-left"></i> Quay lại </a>
                                @endif


                            </label>
                            <div class="col-sm-9 gruopRadio mgt5 pdLeft0">


                                <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5" value="btn_save"
                                        style="border:none" id="btnloading" name="submit_form"> Lưu hồ sơ ứng viên
                                </button>
                                <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5 "
                                        value="btn_save_next"
                                        style="border:none" id="btnloading_next" name="submit_form"> Lưu tiếp tục <i
                                            class="fas fa-long-arrow-alt-right"></i>
                                </button>


                            </div>
                        </div>
                    </form>
                </div>

            </div>


        </div>
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
                }, time_to_work: {
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
                    required: 'Vui lòng chọn trình độ cao nhất.',
                }, time_to_work: {
                    required: 'Vui lòng chọn năm bắt đầu đi làm.',
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
            } else {
                $('.error_g-captcha').text("");
            }
            var is_check_upload_file = $('.js_checkUploadFile').is(":checked");

            $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lưu hồ sơ ...');
            $btn.attr('disabled', false);
        } else {
        }
    });
    $('#btnloading_next').click(function () {
        if ($('#form_update_user').valid()) {
            if (grecaptcha.getResponse() == "") {
                $('.error_g-captcha').text("Vui lòng tích chọn tôi không phải người máy");
                $('.error_g-captcha').css('margin-bottom', '5px');
                return false;
            } else {
                $('.error_g-captcha').text("");
            }
            var is_check_upload_file = $('.js_checkUploadFile').is(":checked");

            $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lưu hồ sơ ...');
            $btn.attr('disabled', false);
        } else {
        }
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

    $(document).ready(function () {
        var year_input = $('.js_select_2_change').val();
        var d = new Date();
        var year = d.getFullYear();
        var year_ex = year - year_input;
        if (year_ex == 0) {
            $('.js_result_year_ex').html(' ( dưới 1 năm kinh nghiệm ) ');
        } else {
            $('.js_result_year_ex').html(' ( ' + year_ex + ' năm kinh nghiệm ) ');
        }
        console.log(year_input);
        $('.js_select_2_change').change(function () {
            var year_input = $(this).val();
            // lay ngay hien taih
            var d = new Date();
            var year = d.getFullYear();
            var year_ex = year - year_input;
            if (year_ex == 0) {
                $('.js_result_year_ex').html(' ( dưới 1 năm kinh nghiệm ) ');
            } else {
                $('.js_result_year_ex').html(' (' + year_ex + ' năm kinh nghiệm ) ');
            }
        });

    });

</script>
<script type="text/javascript">

</script>
<script type="text/javascript">
    $('.select2_muti').select2({
        width: '100%',
        maximumSelectionLength: 3
    });
</script>


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

    .notification button {
        background: #009385;
        color: #fff;
    }
    .form_color_input input {
        color: green;
        font-weight: 600;
    }

    .form_color_input select {
        color: green;
        font-weight: 600;
    }
    .form_color_input .label_radio {
        color: green;
        font-weight: 600;
    }
    .form_color_input .select2-search input {
        color: green;
        font-weight: 600;
    }
    .form_color_input .borderSelect2 .select2-container .select2-selection--single .select2-selection__rendered {
        border: 1px solid #ccc;
        border-radius: 5px;
        color: green;
        font-weight: 600;
    }
</style>