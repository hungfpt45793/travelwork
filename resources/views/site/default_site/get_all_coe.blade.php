@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', 'Bảng phân tích mức lương theo năng lực của nhân viên du lịch')
@section('meta_description', 'Bảng phân tích mức lương theo năng lực của nhân viên du lịch')
@section('keywords', 'Bảng phân tích mức lương theo năng lực của nhân viên du lịch')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('canonical', 'https://travelwork.vn/')
@section('meta_url', 'https://travelwork.vn/')
@section('content')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/coe_salary.css"/>
    <section class="coe_salary">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-md-12">
                    <div class="title_coe_salary text-center">
                        <div class="row">
                            <div class="col-md-12">
                                <h1>Bảng phân tích mức lương theo năng lực của nhân viên du lịch </h1>
                                <p><i>(Vui lòng chọn các danh mục để tính hệ số lương bạn nhận được) (* là bắt buộc phải chọn)</i></p>
                            </div>
                        </div>
                    </div>
                    <div class="box_coe_salary">
                        <form action="{{ route('post_sum_coe') }}" method="post" id="location-form">
                            {!! csrf_field() !!}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="item_coe_salary">
                                    <div class="item_coe_title">
                                        <h3>1.Thành phố làm việc(*)</h3>
                                    </div>
                                    <div class="box_coe_title">
                                        <select class="form-control select2 error_border_province"
                                                name="province_id"
                                                aria-label="Tỉnh/Thành phố" id="province">
                                            <option value=""> -- Danh sách các tỉnh/thành phố --</option>
                                            @foreach(\App\Entity\Province::getAllProvince() as $province)
                                                <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                                            @endforeach
                                        </select>

                                        <div class="mess_notice_province_id clearfix note_text_province_id"></div>
                                        <div class="error_reg_mess clearfix error_text_province_id"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item_coe_salary">
                                    <div class="item_coe_title">
                                        <h3>2.Vị trí công việc(*)</h3>
                                    </div>
                                    <div class="box_coe_title">
                                        <select class="form-control select2 error_border_province"
                                                name="career_category_id"
                                                aria-label="Vị trí công việc" id="career_category_id">
                                            <option value=""> -- Vị trí công việc --</option>
                                            @foreach(\App\Entity\Career::get() as $carr)
                                                <option value="{{$carr->career_category_id}}">{{$carr->career_category_name}}</option>
                                            @endforeach
                                        </select>

                                        <div class="mess_notice_career_category_id clearfix note_text_career_category_id"></div>
                                        <div class="error_reg_mess clearfix error_text_career_category_id"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item_coe_salary">
                                    <div class="item_coe_title">
                                        <h3>3.Loại hình doanh nghiệp(*)</h3>
                                    </div>
                                    <div class="box_coe_title">
                                        <select class="form-control select2 error_border_province"
                                                name="type_of_business_id"
                                                aria-label="Loại hình doanh nghiệp" id="type_of_business_id">
                                            <option value=""> -- Loại hình doanh nghiệp --</option>
                                            @foreach(\App\Entity\TypeOfBusiness::get() as $type)
                                                <option value="{{$type->type_of_business_id}}">{{$type->type_of_business_name}}</option>
                                            @endforeach

                                        </select>

                                        <div class="mess_notice_type_of_business_id clearfix note_text_type_of_business_id"></div>
                                        <div class="error_reg_mess clearfix error_text_type_of_business_id"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item_coe_salary">
                                    <div class="item_coe_title">
                                        <h3>4.Kinh nghiệm loại hình doanh nghiệp(*)</h3>
                                    </div>
                                    <div class="box_coe_title">
                                        <select class="form-control select2 error_border_province"
                                                name="exp_bus_id"
                                                aria-label="Kinh nghiệm loại hình doanh nghiệp" id="exp_bus_id">
                                            <option value=""> -- Kinh nghiệm loại hình doanh nghiệp --</option>
                                            @foreach(\App\Entity\Experience_business::get() as $ex_bus)
                                                <option value="{{$ex_bus->exp_bus_id}}">{{$ex_bus->exp_bus_name}}</option>
                                            @endforeach
                                        </select>

                                        <div class="mess_notice_exp_bus_id clearfix note_text_exp_bus_id"></div>
                                        <div class="error_reg_mess clearfix error_text_exp_bus_id"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="item_coe_salary">
                                    <div class="item_coe_title">
                                        <h3>5.Trình độ học vấn</h3>
                                    </div>
                                    <div class="box_coe_title">
                                        <select class="form-control select2 error_border_province"
                                                name="literacy_id"
                                                aria-label="Trình độ học vấn" id="literacy_id">
                                            <option value=""> -- Trình độ học vấn --</option>
                                            @foreach(\App\Entity\Literacy::get() as $lite)
                                                <option value="{{$lite->literacy_id}}">{{$lite->literacy_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="item_coe_salary">
                                    <div class="item_coe_title">
                                        <h3>6.Tin học văn phòng</h3>
                                    </div>
                                    <div class="box_coe_title">
                                        <select class="form-control select2 error_border_province"
                                                name="office_id"
                                                aria-label="Tin học văn phòng" id="office_id">
                                            <option value=""> -- Tin học văn phòng --</option>
                                            @foreach(\App\Entity\Office_information::get() as $off)
                                                <option value="{{$off->office_id}}">{{$off->office_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item_coe_salary">
                                    <div class="item_coe_title">
                                        <h3>7.Kinh nghiệm vị trí khác</h3>
                                    </div>
                                    <div class="box_coe_title">
                                        <select class="form-control select2 error_border_province" multiple
                                                name="exp_id[]"
                                                aria-label="Kinh nghiệm vị trí khác" id="exp_id">
                                            <option value=""> -- Kinh nghiệm vị trí khác --</option>
                                            @foreach(\App\Entity\Experience_postion::get() as $ex_pos)
                                                <option value="{{$ex_pos->exp_id}}">{{$ex_pos->exp_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="item_coe_salary">
                                    <div class="item_coe_title">
                                        <h3>8.Loại hình kinh doanh </h3>
                                    </div>
                                    <div class="box_coe_title">
                                        <select class="form-control select2 error_border_province"
                                                name="business_type_id"
                                                aria-label="Loại hình kinh doanh" id="business_type_id">
                                            <option value=""> -- Loại hình kinh doanh --</option>
                                            @foreach(\App\Entity\Business::get() as $bus)
                                                <option value="{{$bus->business_type_id}}">{{$bus->business_type_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item_coe_salary">
                                    <div class="item_coe_title">
                                        <h3>9.Phần mềm du lịch</h3>
                                    </div>
                                    <div class="box_coe_title">
                                        <select class="form-control select2 error_border_province"
                                                name="software_id"
                                                aria-label="Phần mềm du lịch" id="software_id">
                                            <option value=""> -- Phần mềm du lịch --</option>
                                            @foreach(\App\Entity\Software::get() as $softwave)
                                                <option value="{{$softwave->software_id}}">{{$softwave->software_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item_coe_salary">
                                    <div class="item_coe_title">
                                        <h3>10.Trình độ ngoại ngữ</h3>
                                    </div>
                                    <div class="box_coe_title">
                                        <select class="form-control select2 error_border_province"
                                                name="lang_id"
                                                aria-label="Trình độ ngoại ngữ" id="lang_id">
                                            <option value=""> -- Trình độ ngoại ngữ --</option>
                                            @foreach(\App\Entity\LanguageLiteracy::get() as $lang)
                                                <option value="{{$lang->lang_id}}">{{$lang->lang_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item_coe_salary">
                                    <div class="item_coe_title">
                                        <h3>11.Kỹ năng mềm</h3>
                                    </div>
                                    <div class="box_coe_title">
                                        <select class="form-control select2 error_border_province"
                                                name="soft_id"
                                                aria-label="Kỹ năng mềm" id="soft_id">
                                            <option value=""> -- Kỹ năng mềm --</option>
                                            @foreach(\App\Entity\SoftSkills::get() as $skill)
                                                <option value="{{$skill->soft_id}}">{{$skill->soft_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item_coe_salary">
                                    <div class="item_coe_title">
                                        <h3>12.Chứng chỉ nghề nghiệp</h3>
                                    </div>
                                    <div class="box_coe_title">
                                        <select class="form-control select2 error_border_province"
                                                name="cer_id"
                                                aria-label="Chứng chỉ nghề nghiệp" id="cer_id">
                                            <option value=""> -- Chứng chỉ nghề nghiệp --</option>
                                            @foreach(\App\Entity\Certificate::get() as $cer)
                                                <option value="{{$cer->cer_id}}">{{$cer->cer_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item_coe_salary">
                                    <div class="item_coe_title">
                                        <h3>13.Khả năng chịu áp lực công việc</h3>
                                    </div>
                                    <div class="box_coe_title">
                                        <select class="form-control select2 error_border_province"
                                                name="work_id"
                                                aria-label="Khả năng chịu áp lực công việc" id="work_id">
                                            <option value=""> -- Khả năng chịu áp lực công việc--</option>
                                            @foreach(\App\Entity\WorkPressure::get() as $work)
                                                <option value="{{$work->work_id}}">{{$work->work_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item_coe_salary">
                                    <div class="item_coe_title">
                                        <h3>14.Cam kết gắn bó với công ty</h3>
                                    </div>
                                    <div class="box_coe_title">
                                        <select class="form-control select2 error_border_province"
                                                name="com_id"
                                                aria-label="Cam kết gắn bó với công ty" id="com_id">
                                            <option value=""> -- Cam kết gắn bó với công ty --</option>
                                            @foreach(\App\Entity\CommitCompany::get() as $com)
                                                <option value="{{$com->com_id}}">{{$com->com_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="item_coe_salary">
                                    <div class="item_coe_title">
                                        <h3>Vui lòng tích chọn ' Tôi không phải người máy ' hoặc ' I'm not a robot '</h3>
                                        <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{{ env('RE_CAPTCHA_HTML')  }}"></div>
                                        <div class="error error_g-captcha"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item_sum_total">
                                    <button id="js_btnRegidit" type="submit">Xem mức lương
                                    </button>
                                </div>
                            </div>

                        </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
    @include('site.partials_site.fixel_mobile_bottom')
@endsection
@section('show_js')
    <script>
        $('.item_coe_salary').matchHeight();
    </script>
    <script src="/public/assets/js/jquery.validate.min.js"></script>
    @include('site.layout_site.from')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#location-form").validate({
                ignore: [],
                onkeyup: false,
                rules: {
                    province_id: {
                        required: true,
                    },
                    career_category_id: {
                        required: true,
                    },
                    type_of_business_id: {
                        required: true,
                    },
                    exp_bus_id: {
                        required: true,
                    },
                },
                messages: {
                    province_id: {
                        required: 'Vui lòng chọn thành phố làm việc.',
                    },
                    career_category_id: {
                        required: 'Vui lòng chọn vị trí công việc.',
                    },
                    type_of_business_id: {
                        required: 'Vui lòng chọn loại hình doanh nghiệp.',
                    },
                    exp_bus_id: {
                        required: 'Vui lòng chọn kinh nghiệm loại hình doanh nghiệp.',
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
                    // $('.btn-loading').attr('disabled', true)

                },
                success: function (label, element) {
                    var name = $(element).attr("name");
                    $('.note_text_' + name).show();
                    $('.error_text_' + name).html('');
                    $('.error_border_' + name).css("cssText", "border: 1px solid #e0e0e0  !important;");
                },
            });
        });

        $('#js_btnRegidit').click(function() {
            if ($('#location-form').valid()) {
                if (grecaptcha.getResponse() == ""){
                    $('.error_g-captcha').text("Vui lòng tích chọn ' Tôi không phải người máy ' hoặc ' I'm not a robot '");
                    $('.error_g-captcha').css('margin-bottom','5px');
                    return false;
                }
                else
                {
                    $('.error_g-captcha').text("");
                }
                $(this).html( '<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang xử lý...');
                $btn.attr('disabled', false);
            }
            else {
            }
        });

    </script>
@endsection
