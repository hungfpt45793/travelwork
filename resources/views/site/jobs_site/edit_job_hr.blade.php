@extends('site.layout_site.site')

@section('title', 'Chỉnh sửa tin tuyển dụng'.$job->title)
@section('meta_description', 'Chỉnh sửa tin tuyển dụng'.$job->title)
@section('keywords', 'Chỉnh sửa tin tuyển dụng'.$job->title)


@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/form.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/employer_job.css"/>
@endsection

@section('content')
    <section class="content bgrGray pdt5 UpdateUserTab">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar_site.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs">

                            <div class="link_breakcrum mbdsNone">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                                    </li>
                                    <li class="nav-item ">
                                        <span><i class="fas fa-chevron-right"></i></span>
                                    </li>
                                    <li class="nav-item pd8">
                                        <a href="{{ route('get_job_all_vip') }}">HR danh sách tin tuyển dụng</a>
                                    </li>
                                </ul>
                            </div>


                        </div>
                        <div class="employer_create_job">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <div class="CV bgrWhite radius5 pd20  mgb20 pdb5 pdt10">
                                        <div class="box_guide">
                                            <p class="mg0 fw6 red">Lưu ý : Để đảm bảo đăng tin tuyển dụng hợp lệ </p>
                                            <p class="mg0 clback">1.Vui lòng nhập đầy đủ thông tin tuyển dụng </p>
                                            <p class="mg0 clback">2.Thông tin tài khoản phải được xác thực</p>
                                            <p class="mg0 clback">3.Tin của bạn sẽ được hiển thị khi admin duyệt tin
                                                tuyển dụng của bạn</p>
                                        </div>
                                        {{--<p class="mgb5">--}}
                                        {{--<a href="{{ route('getAllUser') }}"--}}
                                        {{--class="btnOrange mgb15 d-sm-inline-block bdr3">Danh sách tin tuyển--}}
                                        {{--dụng</a>--}}
                                        {{--</p>--}}

                                        <div class="title">
                                            <h1 class="">
                                                Cập nhật tin tuyển dụng : {{ $job->title }}
                                            </h1>
                                        </div>
                                        <hr class="mgt10 mgb10">
                                        <div class="supporter text-center">
                                            <p class="mg0">Nếu gặp bất kỳ khó khăn nào vui lòng liên hệ Hotline hỗ trợ
                                                <span class="clRed">({{ isset($information['hotline']) ?  $information['hotline'] : '' }})</span>
                                            </p>
                                            <p class="mg0"> Các trường <span class="clRed fw6">(*)</span> bắt buộc phải
                                                nhập</p>
                                        </div>
                                        <div class="content">
                                            @if(!empty($errors->all()))
                                                @foreach($errors->all() as $erorr)
                                                    <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                                @endforeach
                                            @endif

                                            <form role="form" action="{{ route('update_job_all_vip') }}" method="POST"
                                                  class="form_validate" id="form_creat_store_jobs">
                                                {!! csrf_field() !!}
                                                {{ method_field('POST') }}

                                                <input type="hidden" name="job_id" value="{{ $job->job_id }}">
                                                <div class="form-group borderSelect2 row mgb0">
                                                    <div class="col-md-12">
                                                        <div class="form-group borderSelect2 mgb0">
                                                            <label for="exampleInputEmail1 " class="f18 fw6"
                                                                   style="color: #009385">Thông tin tuyển dụng</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="exampleInputEmail1" class="fw6">Vị trí cần tuyển
                                                            <span class="clRed">(*)</span></label>
                                                        <select class="js-example-basic-single select2 form-control error_border_career_category_id"
                                                                name="career_category_id" id="career_category_id">
                                                            <option value=""
                                                                    @if(old('career_category_id') == 0) selected @endif>
                                                                -- Chọn vị trí --
                                                            </option>
                                                            @foreach(\App\Entity\Career::orderBy('career_category_id')->get() as $career)
                                                                <option value="{{$career->career_category_id}}"
                                                                        @if($career->career_category_id == $job->career_category_id) selected @endif
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
                                                            <label class="fw6">Mức lương <span class="clRed">(*)</span>
                                                            </label>
                                                            <select class="js-example-basic-single select2 form-control error_border_salary_id "
                                                                    name="salary_id">
                                                                <option value=""> -- Chọn mức lương --</option>
                                                                @foreach($salaries as $salary)
                                                                    <option value="{{$salary->salary_id}}"
                                                                            {{$salary->salary_id == $job->salary_id ? 'selected' : ''}}
                                                                    >{{$salary->description}}</option>
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
                                                            <label class="fw6">Kinh nghiệm <span
                                                                        class="clRed">(*)</span></label>
                                                            <select class="form-control select2 error_border_experience_id"
                                                                    name='experience_id'>
                                                                <?php
                                                                $experience = \App\Entity\Experience::getAllEx();
                                                                ?>
                                                                <option value=""> -- Chọn kinh nghiệm --</option>
                                                                <option value="0">Không yêu cầu</option>
                                                                @foreach ($experience as $ex)
                                                                    <option value="{{ $ex->experience_id }}" {{$ex->experience_id == $job->experience_id ? 'selected' : ''}}>{{ $ex->experience_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_message">
                                                                <div class="mess_notice_experience_id clearfix note_text_experience_id"></div>
                                                                <div class="error_reg_mess clearfix error_text_experience_id"></div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="form-group borderSelect2 row mgb0">
                                                    <div class="col-md-4">
                                                        <div class="form-group borderSelect2">
                                                            <label class="fw6">Hạn nộp hồ sơ <span
                                                                        class="clRed">(*)</span></label>
                                                            <?php
                                                            $date_month = date_create($job->deadline_submit_profile);

                                                            ?>
                                                            <input type="date"
                                                                   class="form-control error_border_deadline_submit_profile"
                                                                   name="deadline_submit_profile"
                                                                   value="{{ date_format($date_month,"Y-m-d") }}"/>
                                                            <div class="error_message">
                                                                <div class="mess_notice_deadline_submit_profile clearfix note_text_deadline_submit_profile"></div>
                                                                <div class="error_reg_mess clearfix error_text_deadline_submit_profile"></div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group borderSelect2">
                                                            <label class="fw6">Số lượng cần tuyển <span
                                                                        class="clRed">(*)</span></label>
                                                            <input type="number" class="form-control"
                                                                   name="number_recruit" min="1"
                                                                   placeholder="Số lượng cần tuyển "
                                                                   value="{{ !empty($job->number_recruit) ? $job->number_recruit  : 1 }}"/>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group borderSelect2">
                                                            <label class="fw6">Trình độ học vấn <span
                                                                        class="clRed">(*)</span></label>
                                                            <?php
                                                            $literacies = \App\Entity\Literacy::getAll();
                                                            ?>
                                                            <select class="form-control select2 error_border_literacy_id"
                                                                    name="literacy_id">
                                                                <option value=""> -- Chọn trình độ học vấn --</option>
                                                                @foreach($literacies as $literacy)
                                                                    <option value="{{$literacy->literacy_id}}" {{$literacy->literacy_id == $job->literacy_id ? 'selected' : ''}} >
                                                                        {{$literacy->literacy_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_message">
                                                                <div class="mess_notice_literacy_id clearfix note_text_literacy_id"></div>
                                                                <div class="error_reg_mess clearfix error_text_literacy_id"></div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row mgb0">
                                                    <div class="col-md-12">
                                                        <div class="form-group borderSelect2 mgb0">
                                                            <label for="exampleInputEmail1 " class="f18 fw6"
                                                                   style="color: #009385">Khu vực tuyển dụng</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group borderSelect2">
                                                            <label for="exampleInputEmail1" class="fw6">Tỉnh/Thành phố
                                                                <span class="clRed">(*)</span></label>
                                                            <select class="form-control select2 error_border_province"
                                                                    name="province" aria-label="Tỉnh/Thành phố"
                                                                    id="city">
                                                                <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                                                @foreach(\App\Entity\Province::GetAllProvinces() as $province)
                                                                    <option value="{{$province->province_id}}"
                                                                            {{$province->province_id == $job->province ? 'selected' : ''}}
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
                                                                        class="clRed">(*)</span></label>
                                                            <select class="form-control select2 error_border_district"
                                                                    name="district" aria-label="Quận/Huyện" id="county">
                                                                <option value="">-- Chọn Quận/Huyện --</option>
                                                                @if(!empty($job->province))
                                                                    @foreach(\App\Entity\District::get_province_id($job->province) as $district)
                                                                        <option value="{{$district->district_id}}"
                                                                                {{$district->district_id == $job->district ? 'selected' : ''}}
                                                                        >{{$district->district_name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                                        <option value="{{$district->district_id}}"
                                                                                {{$district->district_id == $job->district ? 'selected' : ''}}
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
                                                            <span class="clRed">(*)</span></label>
                                                        <textarea rows="2"
                                                                  class="form-control error_border_address_work"
                                                                  name="address_work"
                                                                  placeholder="Địa chỉ nơi làm việc">{{ $job->address_work }}</textarea>
                                                        <div class="error_message">
                                                            <div class="mess_notice_address_work note_text_address_work"></div>
                                                            <div class="error_reg_mess clearfix error_text_address_work"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row mgb0">
                                                    <div class="col-md-12">
                                                        <div class="form-group borderSelect2 mgb0">
                                                            <label for="exampleInputEmail1 "
                                                                   class="icon_show_hidden js_icon_show_hidden f18 fw6 mgt15"
                                                                   style="color: #009385">Thêm các yêu cầu khác <span><i
                                                                            class="fas fa-angle-double-down"></i></span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="js_hidden_show">
                                                    <div class="form-group borderSelect2 row">
                                                        <div class="col-md-4">
                                                            <div class="form-group borderSelect2">
                                                                <label for="exampleInputEmail1" class="fw6">Độ tuổi yêu
                                                                    cầu
                                                                </label>
                                                                <select class="form-control select2 error_border_age_id"
                                                                        name="age_id">
                                                                    <option value=""> -- Chọn độ tuổi --</option>
                                                                    <option value="0">Không yêu cầu</option>
                                                                    <?php $ages = \App\Entity\Age::getAllAge()?>
                                                                    @foreach($ages as $age)
                                                                        <option value="{{ $age->id_age }}" {{$age->id_age == $job->age_id ? 'selected' : ''}}>{{ $age->name_age }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group borderSelect2">
                                                                <label class="fw6">Phần mềm yêu cầu </label>
                                                                <?php
                                                                $softwares = \App\Entity\Software::getAll();
                                                                ?>
                                                                <select class="form-control select2 error_border_software"
                                                                        name="software">
                                                                    <option value="" selected>-- Chọn phần mềm --
                                                                    </option>
                                                                    @foreach($softwares as $software)
                                                                        <option value="{{$software->software_id}}"
                                                                                {{$software->software_id == $job->software_id ? 'selected' : ''}}
                                                                        >{{$software->software_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 gruopRadio">
                                                            <label for="inputAddress2" class="fw6"
                                                                   style="display: block;">Giới tính </label>
                                                            <div class="form-check"
                                                                 style="display: inline-block; margin-right: 15px;">
                                                                <input class="form-check-input" type="radio"
                                                                       name="gender"
                                                                       id="exampleRadios2"
                                                                       value="1"
                                                                       @if($job->gender == 1) checked @endif>
                                                                <label class="form-check-label" for="exampleRadios2">
                                                                    Nữ
                                                                </label>
                                                            </div>
                                                            <div class="form-check"
                                                                 style="display: inline-block; margin-right: 15px;">
                                                                <input class="form-check-input" type="radio"
                                                                       name="gender"
                                                                       id="exampleRadios3"
                                                                       value="2"
                                                                       @if($job->gender == 2 ) checked @endif>
                                                                <label class="form-check-label" for="exampleRadios3">
                                                                    Nam
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="fw6">Mô tả vị trí công việc
                                                        <span class="clRed">(*)</span></label>

                                                    <textarea name="description" class="editor_basic" id="description"
                                                              rows="5" cols="80">{!!  $job->description !!}</textarea>
                                                    <div class="error_message">
                                                        <div class="mess_notice_description note_text_description"></div>
                                                        <div class="error_reg_mess clearfix error_text_description"></div>
                                                    </div>

                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="fw6">Yêu cầu công việc <span
                                                                class="clRed">(*)</span></label>

                                                    <textarea name="content" class="editor_basic" id="content" rows="5"
                                                              cols="80">{!!   $job->content !!}</textarea>

                                                    <div class="error_message">
                                                        <div class="mess_notice_content clearfix note_text_content"></div>
                                                        <div class="error_reg_mess clearfix error_text_content"></div>
                                                    </div>


                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="fw6">Phúc lợi công việc <span
                                                                class="clRed">(*)</span></label>

                                                    <textarea name="welfare" class="editor_basic" id="welfare"
                                                              rows="10" cols="80">{!!   $job->welfare  !!}</textarea>

                                                    <div class="error_message">
                                                        <div class="mess_notice_welfare note_text_welfare"></div>
                                                        <div class="error_reg_mess clearfix error_text_welfare"></div>
                                                    </div>


                                                </div>

                                                <div class="form-group row mgb0">
                                                    <div class="col-md-12">
                                                        <div class="form-group borderSelect2 mgb0">
                                                            <label for="exampleInputEmail1 " class="f18 fw6"
                                                                   style="color: #009385">Thông tin nhà tuyển
                                                                dụng</label>
                                                        </div>
                                                    </div>

                                                    {{--@if(!empty($job_company))--}}
                                                    {{--<label class="col-12 fw6"> Danh sách các công ty đã đăng tuyển--}}
                                                    {{--trước đó (tin đã tuyển)</label>--}}
                                                    {{--<div class="col-12 mgb10">--}}
                                                    {{--<select class="form-control select2 error_border_age_id js_job_company_id"--}}
                                                    {{--name="job_company_id">--}}
                                                    {{--<option value=""> -- Chọn công ty --</option>--}}
                                                    {{--@foreach($job_company as $company)--}}
                                                    {{--<option value="{{ $company->job_company_id }}"  tax_code ="{{ $company->tex_code }}" {{$company->job_company_id == old('job_company_id') ? 'selected' : ''}}>{{ $company->job_company_title }} - {{ $company->title }}</option>--}}
                                                    {{--@endforeach--}}
                                                    {{--</select>--}}
                                                    {{--</div>--}}
                                                    {{--@endif--}}


                                                    <label class="col-12 fw6"> Mã số thuế </label>
                                                    <div class="col-6">
                                                        <input type="number" name="tax_code"
                                                               value="{{ !empty($job_company->tax_code) ? $job_company->tax_code : '' }}"
                                                               class="form-control error_border_name js_tax_code"
                                                               placeholder="Mã số thuế">
                                                        <i class="f12 js_check_tax_code_error clRed"></i>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="js_check_tax_code"
                                                              style="display: inline-block;color: #fff;background: orange;padding: 10px;cursor: pointer">Lấy thông tin</span>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label for="exampleInputEmail1" class="fw6">Tên công ty</label>
                                                        <input class="form-control js_name_company" name="name_company"
                                                               value="{{ !empty($job_company->job_company_title) ? $job_company->job_company_title : '' }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group borderSelect2">
                                                            <label for="exampleInputEmail1" class="fw6">Tỉnh/Thành phố
                                                            </label>
                                                            <select class="form-control select2 error_border_province"
                                                                    name="province_company" aria-label="Tỉnh/Thành phố"
                                                                    id="city_company">
                                                                <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                                                @foreach(\App\Entity\Province::GetAllProvinces() as $province)
                                                                    <option value="{{$province->province_id}}"
                                                                            @if($job_company->province_id == $province->province_id) selected @endif>{{$province->province_name}}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group borderSelect2">
                                                            <label for="exampleInputEmail1"
                                                                   class="fw6">Quận/Huyện</label>
                                                            <select class="form-control select2 error_border_district"
                                                                    name="district_company" aria-label="Quận/Huyện"
                                                                    id="county_company">
                                                                <option value="">-- Chọn Quận/Huyện --</option>

                                                                @foreach(\App\Entity\District::getAllDistrict() as $district)
                                                                    <option value="{{$district->district_id}}"
                                                                            @if($job_company->district_id == $district->district_id) selected @endif
                                                                    >{{$district->district_name}}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="exampleInputEmail1" class="fw6">Địa chỉ công
                                                            ty</label>
                                                        <textarea rows="2"
                                                                  class="form-control js_address"
                                                                  name="address_company"
                                                                  placeholder="Địa chỉ công ty">{{ !empty($job_company->address) ? $job_company->address : '' }}</textarea>

                                                    </div>

                                                    <div class="col-md-12">
                                                        <label for="exampleInputEmail1" class="fw6">Giới thiệu về công
                                                            ty </label>

                                                        <textarea name="introduction_company" class="editor_basic"
                                                                  id="introduction"
                                                                  rows="10"
                                                                  cols="80">{!!   !empty($job_company->introduction) ? $job_company->introduction : ''  !!}</textarea>


                                                    </div>
                                                </div>


                                                <div class="form-group borderSelect2 mgb10">
                                                    <label for="exampleInputEmail1">
                                                        <label for="exampleInputEmail1" class="fw6">
                                                            Từ khóa
                                                        </label>
                                                    </label>
                                                    <select style="width: 100%;" name="tags[]"
                                                            class="form-control select2 error_border_tags js-select2"
                                                            multiple="multiple" id="select-tag" required>
                                                        <?php
                                                        $tag_array = array();
                                                        if (!empty($job->tags)) {
                                                            $tag_array = explode(',', $job->tags);
                                                        }

                                                        ?>
                                                        @if (!empty($input_tags))
                                                            @foreach ($input_tags as $job_tag)
                                                                <option value="{{ $job_tag->tag_title }}"
                                                                        @if(in_array($job_tag->tag_title, $tag_array)) selected @endif>
                                                                    {{ $job_tag->tag_title }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                        {{-- END dùng cho công việc --}}
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btnOrange"
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
                </div>
            </div>

        </div>
    </section>

@endsection




@section('show_js')
    <script src="/assets/ckeditor_full/ckeditor.js"></script>
    @include('site.layout_site.from')
    <script>

        $('.editor_basic').each(function (e) {
            CKEDITOR.replace(this.id);
        });
        // CKEDITOR.instances.description.updateElement('1111111111111111111');
        $('.select2').select2({
            width: '100%',
        });
    </script>
    <script>

        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });

    </script>
    <script src="/assets/js/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.js_icon_show_hidden').click(function () {
                $('.js_hidden_show').toggle();
            });

            $('.js_job_company_id').change(function () {
                var job_company_id = $(this).val();
                $.ajax({
                    'type': 'get',
                    'url': "{{ route('ajax_get_company_id') }}",
                    'data': {
                        job_company_id: job_company_id,
                    },
                    dataType: 'json',
                    'success': function (res) {
                        $('.js_tax_code').val(res.job_company.tax_code);
                        $('.js_name_company').val(res.job_company.job_company_title);
                        $('.js_address').val(res.job_company.address);


                        // if (res.job_company.job_company_title != '') {
                        $('#county_company').val(res.job_company.province_id); // Select the option with a value of '1'
                        $('#county_company').trigger('change'); // Notify any JS components that the value changed

                        $('#city_company').val(res.job_company.district_id); // Select the option with a value of '1'
                        $('#city_company').trigger('change'); // Notify any JS components that the value changed
                        // }
                        $('#introduction').val(res.job_company.introduction);
                    },
                    'error': function () {

                    }
                });
            });

            $('.js_check_tax_code').click(function () {
                var tax_code = $('.js_tax_code').val();
                console.log(tax_code);
                $.ajax({
                    'type': 'get',
                    'url': "{{ route('check_tax_code') }}",
                    'data': {
                        tax_code: tax_code,
                    },
                    dataType: 'json',
                    'success': function (res) {
                        console.log(res.district_id);
                        console.log(res.DiaChiCongTy);
                        $('.js_name_company').val(res.Title);
                        $('.js_address').val(res.DiaChiCongTy);
                        if (res.DiaChiCongTy != '') {
                            $('#county_company').val(res.district_id); // Select the option with a value of '1'
                            $('#county_company').trigger('change'); // Notify any JS components that the value changed

                            $('#city_company').val(res.province_id); // Select the option with a value of '1'
                            $('#city_company').trigger('change'); // Notify any JS components that the value changed
                        }
                        $('.js_check_tax_code_error').html('');
                    },
                    'error': function () {
                        $('.js_check_tax_code_error').html('Mã số thuế này không tìm thấy trên hệ thống daonh nghiệp nhà nước');
                    }
                })
            });

            $('#city_company').change(function () {
                console.log(1);
                if ($('#county_company').val() == '') {
                    $.get('/ajax-district/' + $(this).val(), function (data) {
                        $('#county_company').html(data);
                    });
                }
            });


            $("#form_creat_store_jobs").validate({
                ignore: [],
                onkeyup: false,
                change: false,
                rules: {
                    career_category_id: {
                        required: true,
                    },
                    salary_id: {
                        required: true,
                    },
                    experience_id: {
                        required: true,
                    },
                    deadline_submit_profile: {
                        required: true,
                        minDate: true,
                    },
                    number_recruit: {
                        required: true,
                        min: 1,
                    },
                    literacy_id: {
                        required: true,
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
                    description: {
                        required: function () {
                            CKEDITOR.instances.description.updateElement();
                        },
                        minlength: 20
                    },
                    content: {
                        required: function () {
                            CKEDITOR.instances.content.updateElement();
                        },
                        minlength: 20
                    }
                    , welfare: {
                        required: function () {
                            CKEDITOR.instances.welfare.updateElement();
                        },
                        minlength: 20
                    },
                },
                messages: {

                    career_category_id: {
                        required: 'Vui lòng chọn vị trí cần tuyển.',
                    },
                    salary_id: {
                        required: 'Vui lòng chọn mức lương',
                    },
                    experience_id: {
                        required: 'Vui lòng chọn kinh nghiệm cần tuyển',
                    },
                    deadline_submit_profile: {
                        required: 'Vui lòng chọn hạn nộp hồ sơ',
                        minDate: 'Hạn nộp hồ sơ phải lớn hơn ngày hiện tại',
                    },
                    number_recruit: {
                        required: 'Số lượng cần tuyển không được để trống',
                        min: 'Số lượng cần tuyển phải lớn hơn hoặc bằng 1',
                    },
                    literacy_id: {
                        required: 'Vui lòng chọn trình độ học vấn',
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
                    description: {
                        required: "Mô tả vị trí công việc không được để trống",
                        minlength: "Mô tả vị trí công việc phải lớn hơn 20 kí tự"
                    },
                    content: {
                        required: "Yêu cầu công việc không được để trống",
                        minlength: "Yêu cầu công việc phải lớn hơn 20 kí tự"
                    },
                    welfare: {
                        required: "Phúc lợi công việc không được để trống",
                        minlength: "Phúc lợi công việc phải lớn hơn 20 kí tự"
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


        $('#btnloading').click(function () {

            if ($('#form_creat_store_jobs').valid()) {
                $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lưu tin tuyển dụng...');
                $btn.attr('disabled', false);
            } else {
            }
        });
    </script>


@endsection