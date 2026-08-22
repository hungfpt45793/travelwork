@extends('site.layout.site')

@section('title', 'Việc làm từ nhà tuyển dụng')
@section('meta_description', 'Việc làm từ nhà tuyển dụng')
@section('keywords', 'Việc làm từ nhà tuyển dụng')

@section('content')
    <style>
        .form-group {
            margin-bottom: 10px;
        }
    </style>
    <section class="content bgrGray pdt5 UpdateUserTab">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs f18 white  pd10-20 col-f14">
                            <div class="link bgrWhite md-mgt20 disOnMobile">
                                <ul class="nav">
                                    <li class="nav-item pd8">
                                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                                    </li>
                                    <li class="nav-item pd8">
                                        <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                                    </li>
                                    <li class="nav-item pd8">
                                        <?php
                                        $link_url = '#';
                                        $link_url = \App\Ultility\Ultility::getUrl();
                                        ?>
                                        <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> Thêm mới tin tuyển dụng</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <div class="CV bgrWhite radius5 pd20  mgb20 pdb5 pdt10">
                                        <div class="arror bgrWhite radius5 pd5 bdLightGray  mgb15 pd10">
                                            <p class="mg0 fw6 red">Lưu ý : Để đảm bảo đăng tin tuyển dụng hợp lệ </p>
                                            <p class="mg0 clback">1.Vui lòng nhập đầy đủ thông tin tuyển dụng </p>
                                            <p class="mg0 clback">2.Thông tin tài khoản phải được xác thực</p>
                                        </div>
                                        {{--<p class="mgb5">--}}
                                            {{--<a href="{{ route('getAllUser') }}"--}}
                                               {{--class="btnOrange mgb15 d-sm-inline-block bdr3">Danh sách tin tuyển--}}
                                                {{--dụng</a>--}}
                                        {{--</p>--}}
                                        <div class="title">
                                            <h5 class="fw6 f20 bdLeftBlueN5x pdl10 blueN mgb0">
                                                Thêm mới tin tuyển dụng
                                            </h5>
                                        </div>
                                        <hr class="mgt10 mgb10">
                                        <div class="supporter textCenter radius5 pd5 bdLightGray mgb10">
                                            <p class="mg0">Nếu gặp bất kỳ khó khăn nào vui lòng liên hệ Hotline hỗ trợ
                                                <span class="clred">({{ isset($information['hotline']) ?  $information['hotline'] : '' }})</span>
                                            </p>
                                            <p class="mg0"> Các trường <span class="red fw6">(*)</span> bắt buộc phải nhập</p>
                                        </div>
                                        <div class="content">
                                            @if(!empty($errors->all()))
                                                @foreach($errors->all() as $erorr)
                                                    <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                                @endforeach
                                            @endif
                                            <form role="form" action="{{ route('job-user.store') }}" method="POST"
                                                  class="" id="form_creat_store_jobs">
                                                {!! csrf_field() !!}
                                                {{ method_field('POST') }}
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="fw6">Tên Việc Làm <span
                                                                class="red">(*)</span></label>
                                                    <input type="text" class="form-control error_border_title"
                                                           name="title" placeholder="Tên Việc Làm"
                                                           value="{{old('title')}}">
                                                    <div class="error_message">
                                                        <div class="mess_notice_title clearfix note_text_title"></div>
                                                        <div class="error_reg_mess clearfix error_text_title"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group borderSelect2 row">
                                                    <div class="col-md-4">
                                                        <label for="exampleInputEmail1" class="fw6">Vị trí cần tuyển
                                                            <span class="red">(*)</span></label>
                                                        <select class="js-example-basic-single select2 form-control error_border_career_category_id"
                                                                name="career_category_id" id="career_category_id">
                                                            <option value=""
                                                                @if(old('career_category_id') == 0) selected @endif>
                                                                -- Chọn vị trí --
                                                            </option>
                                                            @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                                                <option value="{{$career->career_category_id}}"
                                                                        @if($career->career_category_id == old('career_category_id')) selected @endif
                                                                >{{$career->career_category_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_message">
                                                            <div class="mess_notice_career_category_id clearfix note_text_career_category_id"></div>
                                                            <div class="error_reg_mess clearfix error_text_career_category_id"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group borderSelect2">
                                                            <label for="exampleInputEmail1" class="fw6">Độ tuổi yêu cầu
                                                                <span class="red">(*)</span></label>
                                                            <select class="form-control select2 error_border_age_id"
                                                                    name="age_id">
                                                                <option value=""> -- Chọn độ tuổi --</option>
                                                                <option value="0">Không yêu cầu</option>
                                                                <?php $ages = \App\Entity\Age::getAllAge()?>
                                                                @foreach($ages as $age)
                                                                    <option value="{{ $age->id_age }}" {{$age->id_age == old('age_id') ? 'selected' : ''}}>{{ $age->name_age }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="error_message">
                                                            <div class="mess_notice_age_id clearfix note_text_age_id"></div>
                                                            <div class="error_reg_mess clearfix error_text_age_id"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 gruopRadio">
                                                        <label for="inputAddress2" class="fw6" style="display: block;">Giới tính </label>
                                                        <div class="form-check"
                                                             style="display: inline-block; margin-right: 15px;">
                                                            <input class="form-check-input" type="radio" name="gender"
                                                                   id="exampleRadios2"
                                                                   value="1" @if(old('gender') == 1) checked @endif>
                                                            <label class="form-check-label" for="exampleRadios2">
                                                                Nữ
                                                            </label>
                                                        </div>
                                                        <div class="form-check"
                                                             style="display: inline-block; margin-right: 15px;">
                                                            <input class="form-check-input" type="radio" name="gender"
                                                                   id="exampleRadios3"
                                                                   value="2" @if(old('gender') == 2) checked @endif>
                                                            <label class="form-check-label" for="exampleRadios3">
                                                                Nam
                                                            </label>
                                                        </div>
                                                        <div class="form-check"
                                                             style="display: inline-block; margin-right: 15px;">
                                                            <input class="form-check-input" type="radio" name="gender"
                                                                   id="exampleRadios3"
                                                                   value="3" @if(old('gender') == 3) checked @endif>
                                                            <label class="form-check-label" for="exampleRadios3">
                                                                Cả nam và nữ
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{--lấy độ tuổi từ bảng age--}}
                                                <div class="form-group borderSelect2 row">
                                                    <div class="col-md-4">
                                                        <div class="form-group borderSelect2">
                                                            <label class="fw6">Mức lương <span class="red">(*)</span>
                                                            </label>
                                                            <select class="js-example-basic-single select2 form-control error_border_salary_id "
                                                                    name="salary_id">
                                                                <option value=""> -- Chọn mức lương --</option>
                                                                @foreach($salaries as $salary)
                                                                    <option value="{{$salary->salary_id}}"
                                                                            {{$salary->salary_id == old('salary_id') ? 'selected' : ''}}>
                                                                            {{$salary->description}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_message">
                                                                <div class="mess_notice_salary_id clearfix note_text_salary_id"></div>
                                                                <div class="error_reg_mess clearfix error_text_salary_id"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group borderSelect2">
                                                            <label class="fw6">Kinh nghiệm <span class="red">(*)</span></label>
                                                            <select class="form-control select2 error_border_experience_id"
                                                                    name='experience_id'>
                                                                <?php
                                                                $experience = \App\Entity\Experience::getAllEx();
                                                                ?>
                                                                <option value=""> -- Chọn kinh nghiệm --</option>
                                                                <option value="0">Không yêu cầu</option>
                                                                @foreach ($experience as $ex)
                                                                    <option value="{{ $ex->experience_id }}" {{$ex->experience_id == old('experience_id') ? 'selected' : ''}}>{{ $ex->experience_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_message">
                                                                <div class="mess_notice_experience_id clearfix note_text_experience_id"></div>
                                                                <div class="error_reg_mess clearfix error_text_experience_id"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group borderSelect2">
                                                            <label class="fw6">Phần mềm yêu cầu <span
                                                                        class="red">(*)</span></label>
                                                            <?php
                                                            $softwares = \App\Entity\Software::getAll();
                                                            ?>
                                                            <select class="form-control select2 error_border_software"
                                                                    name="software">
                                                                <option value="" selected>-- Chọn phần mềm --</option>
                                                                @foreach($softwares as $software)
                                                                    <option value="{{$software->software_id}}"
                                                                            {{$software->software_id == old('software_id') ? 'selected' : ''}}
                                                                    >{{$software->software_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_message">
                                                                <div class="mess_notice_software clearfix note_text_software"></div>
                                                                <div class="error_reg_mess clearfix error_text_software"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group borderSelect2 row">
                                                    <div class="col-md-4">
                                                        <div class="form-group borderSelect2">
                                                            <label class="fw6">Trình độ học vấn <span
                                                                        class="red">(*)</span></label>
                                                            <?php
                                                            $literacies = \App\Entity\Literacy::getAll();
                                                            ?>
                                                            <select class="form-control select2 error_border_literacy_id"
                                                                    name="literacy_id">
                                                                <option value=""> -- Chọn trình độ học vấn --</option>
                                                                @foreach($literacies as $literacy)
                                                                    <option value="{{$literacy->literacy_id}}" {{$literacy->literacy_id == old('literacy_id') ? 'selected' : ''}} >
                                                                        {{$literacy->literacy_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_message">
                                                                <div class="mess_notice_literacy_id clearfix note_text_literacy_id"></div>
                                                                <div class="error_reg_mess clearfix error_text_literacy_id"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group borderSelect2">
                                                            <label class="fw6">Hạn nộp hồ sơ <span
                                                                        class="red">(*)</span></label>
                                                            <input type="date"
                                                                   class="form-control error_border_deadline_submit_profile"
                                                                   name="deadline_submit_profile"
                                                                   value="{{ old('deadline_submit_profile') }}" placeholder="yyyy-mm-dd"  max="9999-12-31"/>
                                                            <div class="error_message">
                                                                <div class="mess_notice_deadline_submit_profile clearfix note_text_deadline_submit_profile"></div>
                                                                <div class="error_reg_mess clearfix error_text_deadline_submit_profile"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group borderSelect2">
                                                            <label class="fw6">Số lượng cần tuyển </label>
                                                            <input type="number" class="form-control"
                                                                   name="number_recruit"
                                                                   placeholder="Số lượng cần tuyển "
                                                                   value="{{ old('number_recruit') }}"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <div class="form-group borderSelect2">
                                                            <label for="exampleInputEmail1">Khu vực tuyển dụng</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group borderSelect2">
                                                            <label for="exampleInputEmail1" class="fw6">Tỉnh/Thành phố
                                                                <span class="red">(*)</span></label>
                                                            <select class="form-control select2 error_border_province"
                                                                    name="province" aria-label="Tỉnh/Thành phố"
                                                                    id="city">
                                                                <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                                                @foreach(\App\Entity\Province::GetAllProvinces() as $province)
                                                                    <option value="{{$province->province_id}}"
                                                                            {{$province->province_id == $employer->province ? 'selected' : ''}}
                                                                    >{{$province->province_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_message">
                                                                <div class="mess_notice_province note_text_province"></div>
                                                                <div class="error_reg_mess clearfix error_text_province"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group borderSelect2">
                                                            <label for="exampleInputEmail1" class="fw6">Quận/Huyện <span
                                                                        class="red">(*)</span></label>
                                                            <select class="form-control select2 error_border_district"
                                                                    name="district" aria-label="Quận/Huyện" id="county">
                                                                <option value="">-- Chọn Quận/Huyện --</option>
                                                                @if(!empty($employer->province))
                                                                    @foreach(\App\Entity\District::get_province_id($employer->province) as $district)
                                                                        <option value="{{$district->district_id}}"
                                                                                {{$district->district_id == $employer->district ? 'selected' : ''}}
                                                                        >{{$district->district_name}}</option>
                                                                    @endforeach
                                                                    @else
                                                                @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                                    <option value="{{$district->district_id}}"
                                                                            {{$district->district_id == $employer->district ? 'selected' : ''}}
                                                                    >{{$district->district_name}}</option>
                                                                @endforeach
                                                                    @endif
                                                            </select>
                                                            <div class="error_message">
                                                                <div class="mess_notice_district note_text_district"></div>
                                                                <div class="error_reg_mess clearfix error_text_district"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="exampleInputEmail1" class="fw6">Địa chỉ nơi làm việc
                                                            <span class="red">(*)</span></label>
                                                        <textarea rows="2"
                                                                  class="form-control error_border_address_work"
                                                                  name="address_work"
                                                                  placeholder="Địa chỉ nơi làm việc">{{ $employer->address }}</textarea>
                                                        <div class="error_message">
                                                            <div class="mess_notice_address_work note_text_address_work"></div>
                                                            <div class="error_reg_mess clearfix error_text_address_work"></div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="fw6">Mô tả vị trí công việc
                                                        <span class="red">(*)</span></label>

                                                    <textarea name="description" class="editor" id="description"
                                                              rows="5" cols="80">{!!   old('description') !!}</textarea>

                                                    <div class="error_message">
                                                        <div class="mess_notice_description note_text_description"></div>
                                                        <div class="error_reg_mess clearfix error_text_description"></div>
                                                    </div>
                                                    {{--<textarea id="txtNote" name="content" rows="6" class="textarea col-12 bdLightGray radius5"></textarea>--}}
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="fw6">Yêu cầu công việc <span
                                                                class="red">(*)</span></label>
                                                    <textarea name="content" class="editor" id="content" rows="5"
                                                              cols="80">{!!   old('content') !!}</textarea>

                                                    <div class="error_message">
                                                        <div class="mess_notice_content clearfix note_text_content"></div>
                                                        <div class="error_reg_mess clearfix error_text_content"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="fw6">Phúc lợi công việc <span
                                                        class="red">(*)</span></label>

                                                    <textarea name="welfare" class="editor" id="welfare"
                                                        rows="10" cols="80">{!!   old('welfare')  !!}</textarea>

                                                    <div class="error_message">
                                                        <div class="mess_notice_welfare note_text_welfare"></div>
                                                        <div class="error_reg_mess clearfix error_text_welfare"></div>
                                                    </div>
                                                </div>
                                                {{-- từ khóa --}}
                                                @php
                                                    foreach ($input_tags as $tag) {
                                                        $tag_type = $tag['tag_type'];
                                                    }
                                                @endphp
                                                @include('site.layout.themtukhoa_site')
                                                {{-- END từ khóa --}}
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btnOrange"
                                                            id="btnloading">Lưu tin tuyển dụng
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    @include('site.module_index.dang-ky-tu-van')
                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>
    <script>
        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });
    </script>
    <script type="text/javascript">
        $('.select2').select2({
            width: '100%'
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
    </style>

    <script>
        $(document).ready(function () {
            $("#form_creat_store_jobs").validate({
                ignore: [],
                onkeyup: false,
                change: false,
                rules: {
                    title: {
                        required: true,
                    },
                    career_category_id: {
                        required: true,
                    },
                    age_id: {
                        required: true,
                    },
                    salary_id: {
                        required: true,
                    },
                    experience_id: {
                        required: true,
                    },
                    software: {
                        required: true,
                    },
                    literacy_id: {
                        required: true,
                    },
                    deadline_submit_profile: {
                        required: true,
                        minDate: true,
                    },
                    province: {
                        required: true,
                    },
                    district: {
                        required: true,
                    },
                    address_work: {
                        required: true,
                    },
                    tags: {
                        required: true,
                    },
                    description: {
                        required: function () {
                            CKEDITOR.instances.description.updateElement();
                        },
                        minlength: 10
                    },
                    content: {
                        required: function () {
                            CKEDITOR.instances.content.updateElement();
                        },
                        minlength: 10
                    }
                    ,welfare: {
                        required: function () {
                            CKEDITOR.instances.welfare.updateElement();
                        },
                        minlength: 10
                    },
                },
                messages: {
                    title: {
                        required: 'Tên việc làm không được để trống.',
                        // checkName: 'Tên công ty được chứa số và ký tự đặc biệt.',
                    },
                    career_category_id: {
                        required: 'Vui lòng chọn vị trí cần tuyển.',
                        // checkPhone: 'Số điện thoại không hợp lệ',
                    },
                    age_id: {
                        required: 'Vui lòng chọn độ tuổi yêu cầu.',
                    },
                    salary_id: {
                        required: 'Vui lòng chọn mức lương',
                    },
                    experience_id: {
                        required: 'Vui lòng chọn kinh nghiệm cần tuyển',
                    },
                    software: {
                        required: 'Vui lòng chọn phần mềm yêu cầu',
                    },
                    literacy_id: {
                        required: 'Vui lòng chọn trình độ học vấn',
                    },
                    deadline_submit_profile: {
                        required: 'Vui lòng chọn hạn nộp hồ sơ',
                        minDate: 'Hạn nộp hồ sơ phải lớn hơn ngày hiện tại',
                    },
                    province: {
                        required: 'Vui lòng chọn thành phố',
                    },
                    district: {
                        required: 'Vui lòng chọn quận huyện',
                    },
                    address_work: {
                        required: 'Địa chỉ làm việc không được để trống',
                    },
                    tags: {
                        required: 'vui lòng chọn từ khóa',
                    },
                    description: {
                        required: "Mô tả vị trí công việc không được để trống",
                        minlength: "Mô tả vị trí công việc phải lớn hơn 10 kí tự"
                    },
                    content: {
                        required: "Yêu cầu công việc không được để trống",
                        minlength: "Yêu cầu công việc phải lớn hơn 10 kí tự"
                    },
                    welfare: {
                        required: "Phúc lợi công việc không được để trống",
                        minlength: "Phúc lợi công việc phải lớn hơn 10 kí tự"
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
                    $('#btnloading').button('reset');
                },
                success: function (label, element) {
                    var name = $(element).attr("name");
                    $('.note_text_' + name).show();
                    $('.error_text_' + name).html('');
                    $('.error_border_' + name).css("cssText", "border: 1px solid #e0e0e0  !important;");
                    $('#btnloading').attr('disabled', false);

                },
                submitHandler: function (form) {
                    form.submit();
                }
            });

        });
        $('#btnloading').click(function() {
            if ($('#form_creat_store_jobs').valid()) {
                $(this).html( '<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lưu tin tuyển dụng...');
                $btn.attr('disabled', false);
            }
            else {
            }
        });

        // select2 required 
        $(document).ready(function() {
            // Init all select2 elements
            $('.js-select2').select2();
        
            $('form').on('submit', function(e) {
            var $select2 = $('.js-select2', $(this));
            
            // Reset
            $select2.parents('.form-group').removeClass('is-invalid');
            
            if ($select2.val() === '') {
                
                // Add is-invalid class when select2 element is required
                $select2.parents('.form-group').addClass('is-invalid');
                
                // Stop submiting
                e.preventDefault();
                return false;
            }
            });
        });
    </script>
    

@endsection