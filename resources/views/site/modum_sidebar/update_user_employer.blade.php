@if(\Illuminate\Support\Facades\Auth::check()  && (\Illuminate\Support\Facades\Auth::user()->role) == 2)
    <div class="CV bgrWhite radius5 pd20  mgb20 pdb5 UpdateUserTab">
        <div class="title">
            <h5 class="lt-f18 textUpper fw7 bdLeftBlueN5x pdl10 blueN mgb0">
                Quản lý hồ sơ nhà tuyển dụng
            </h5>
        </div>
        <hr class="mgt10 mgb10">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
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



                        @if(session('error_status_job'))
                        <div class="arror bgrWhite radius5 pd5 bdLightGray  mgb15 pd10">
                            <p class="mg0 fw6 red">Lưu ý : Để đảm bảo đăng tin tuyển dụng hợp lệ </p>
                            <p class="mg0 clback">2.Hồ sơ của nhà tuyển dụng phải được hoàn thiện >= 70 % trong phần quản lý hồ sơ</p>
                            <p class="mg0 clback">3.Thông tin tài khoản phải được xác thực</p>
                        </div>

                        @endif
                            @if($employer->profile >= 70)
                                <div class="arror bgrWhite radius5 pd5 bdLightGray  mgb15 pd10">
                                    <p class="mg0 fw6 clgreen"><i class="fas fa-check"></i> Hồ sơ của bạn đủ điều kiện để đăng tin </p>
                                </div>

                            @else
                                <div class="arror bgrWhite radius5 pd5 bdLightGray  mgb15 pd10">
                                    <p class="mg0 fw6 red"><i class="fas fa-exclamation"></i> Hồ sơ của bạn chưa đủ điều kiện để đăng tin ! Bạn phải hoàn thiện hồ sơ trên 70% </p>
                                </div>
                            @endif

                        {{--<form action="{{ route('updateEmployer') }}" method="post" enctype="multipart/form-data" id="form_update_employer">--}}

                        <form action="{{ route('updateEmployer') }}" method="post" class="mbformUpdateEmployee"
                              enctype="multipart/form-data" id="form_update_user">
                            {!! csrf_field() !!}

                            <div class="form-group row mgb5 mgt15">
                                <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                    Hoàn thiện hồ sơ :
                                </label>
                                <div class="col-sm-9 mgt10 pdLeft0">
                                    <div class="progress lgw60">
                                        <div class="progress-bar progress-bar-striped bg-success"
                                             role="progressbar" style="width: {{ round($employer->profile) }}%;"
                                             aria-valuenow="{{ round($employer->profile) }}" aria-valuemin="0"
                                             aria-valuemax="100">{{ round($employer->profile) }}%
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress2" class="fw6">Tên công ty : <span
                                            class="red">(*)</span></label>
                                <input type="text" class="form-control error_border_enterprise_name"
                                       placeholder="Nhập tên công ty"
                                       name="enterprise_name" id="enterprise_name"
                                       value="{{ isset($employer->enterprise_name) ? $employer->enterprise_name : '' }}">
                                <div class="error_message">
                                    <div class="mess_notice_enterprise_name clearfix note_text_enterprise_name"></div>
                                    <div class="error_reg_mess clearfix error_text_enterprise_name"></div>
                                </div>
                            </div>
                            <div class="form-group mgt20">
                                <label for="inputAddress2" class="fw6">Số điện thoại : <span
                                            class="red">(*)</span></label>
                                <input type="number" class="form-control error_border_phone"
                                       placeholder="Nhập số điện thoại"
                                       name="phone" value="{{ isset($employer->phone) ? $employer->phone : '' }}"
                                       id="phone">
                                <div class="error_message">
                                    <div class="mess_notice_phone clearfix note_text_phone"></div>
                                    <div class="error_reg_mess clearfix error_text_phone"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress2" class="fw6">Logo công ty : <span
                                            class="red">(*)</span></label>

                                <div class="form-group">
                                    <input type="button" onclick="return uploadImage(this);"
                                           value="Chọn ảnh"
                                           size="20" class="error_text_image"/>
                                    <img src="{{ isset($employer->image) ? $employer->image : '' }}"
                                         width="80" height=""/>
                                    <input name="image" type="text"
                                           value="{{ isset($employer->image) ? $employer->image: '' }}"
                                           style="border:none !important;color: #fff !important;position: absolute;left: 0;width: 84px;z-index: -9;"/>

                                    <a href="https://sanketoan.vn/ho-tro/huong-dan-tai-anh-dai-dien-vao-ho-so-giao-vien-ung-vien-nha-tuyen-dung"
                                       target="_blank">(Hướng dẫn chọn ảnh)</a>
                                </div>
                                <div class="error_message">
                                    <div class="mess_notice_image clearfix note_text_image"></div>
                                    <div class="error_reg_mess clearfix error_text_image"></div>
                                </div>


                            </div>


                            <div class="form-group">
                                <label for="inputAddress2" class="fw6">Hình ảnh công ty :</label>

                                <div class="form-group">
                                    <label>Danh sách hình ảnh</label>
                                    <input type="button" onclick="return openKCFinder(this);" value="Chọn ảnh"
                                           size="20"/>

                                    <div class="images_list">
                                        @if(!empty($employer->images_list))
                                            @foreach(explode(',',$employer->images_list) as $image)
                                                <img src="{{$image}}" width="80" height=""
                                                     style="margin-left: 10px; margin-bottom: 5px;"/>
                                            @endforeach
                                        @endif
                                    </div>
                                    <input name="images_list" type="hidden" value="{{$employer->images_list}}"/>


                                </div>


                            </div>
                            <div class="form-group mgt20">
                                <label for="inputAddress2" class="fw6">Email đăng nhập: <span
                                            class="red">(*)</span></label>
                                <input type="email" class="form-control" placeholder="Nhập Email"
                                       name="email" value="{{ isset($employer->email) ? $employer->email : '' }}"
                                       readonly>
                            </div>


                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="inputAddress2" class="fw6">Địa chỉ công ty <span
                                                class="red">(*)</span></label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group borderSelect2">
                                        <label for="exampleInputEmail1">Tỉnh/Thành phố</label>
                                        <select class="form-control select2 error_border_province " name="province"
                                                aria-label="Tỉnh/Thành phố"
                                                id="city">
                                            <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                            @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                <option value="{{$province->province_id}}"
                                                        @if($employer->province == $province->province_id) selected @endif
                                                >{{$province->province_name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="error_message">
                                            <div class="mess_notice_province clearfix note_text_province"></div>
                                            <div class="error_reg_mess clearfix error_text_province"></div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-6">
                                    <div class="form-group borderSelect2">
                                        <label for="exampleInputEmail1">Quận/Huyện</label>
                                        <select class="form-control select2 error_border_district " name="district"
                                                aria-label="Quận/Huyện"
                                                id="county">
                                            <option value="">-- Chọn Quận/Huyện --</option>
                                            @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                <option value="{{$district->district_id }}"
                                                        @if($employer->district == $district->district_id) selected @endif
                                                >{{$district->district_name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="mess_notice_district clearfix note_text_district"></div>
                                        <div class="error_reg_mess clearfix error_text_district"></div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="form-group borderSelect2">
                                        <label for="exampleInputEmail1">Địa chỉ làm việc</label>
                                        <input type="text" class="form-control error_border_address"
                                               placeholder="Địa chỉ làm việc" id="address"
                                               name="address"
                                               value="{{ isset($employer->address) ? $employer->address : '' }}">
                                    </div>
                                    <div class="error_message">
                                        <div class="mess_notice_address clearfix note_text_address"></div>
                                        <div class="error_reg_mess clearfix error_text_address"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group  borderSelect2">
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
                                                @if($employer->type_of_business_id == $type->type_of_business_id) selected @endif
                                        >{{ $type->type_of_business_name }}</option>
                                    @endforeach
                                </select>

                                <div class="error_message">
                                    <div class="mess_notice_type_of_business_id clearfix note_text_type_of_business_id"></div>
                                    <div class="error_reg_mess clearfix error_text_type_of_business_id"></div>
                                </div>


                            </div>
                            <div class="form-group mgt20 borderSelect2">
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
                                                @if($employer->business == $busines->business_type_id) selected @endif
                                        >{{ $busines->business_type_name }}</option>
                                    @endforeach
                                </select>

                                <div class="error_message dsBlock">
                                    <div class="mess_notice_business clearfix note_text_business"></div>
                                    <div class="error_reg_mess clearfix error_text_business"></div>
                                </div>



                            </div>
                            <div class="form-group mgt20">
                                <label for="inputAddress2" class="fw6">Giới thiệu về công ty : <span
                                            class="red">(*)</span></label>

                                <textarea name="introduction" id="editor1" rows="5" cols="100"
                                          class="w100 form-control editor"
                                          style="width: 100%">{!!   isset($employer->introduction) ? $employer->introduction : ''  !!}</textarea>
                                <div class="error_message">
                                    <div class="mess_notice_introduction clearfix note_text_introduction"></div>
                                    <div class="error_reg_mess clearfix error_text_introduction"></div>
                                </div>
                            </div>

                            <div class="form-group mgt20">
                                <label for="inputAddress2" class="fw6">Website công ty: </label>
                                <input type="text" class="form-control" placeholder="Nhập địa chỉ website công ty"
                                       name="website" value="{{ isset($employer->website) ? $employer->website : '' }}">

                            </div>
                            <div class="form-group mgt20">
                                <label for="inputAddress2" class="fw6">Mã số thuế: </label>
                                <input type="text" class="form-control" placeholder="Nhập mã số thuế"
                                       name="tax_code"
                                       value="{{ isset($employer->tax_code) ? $employer->tax_code : '' }}">

                            </div>
                            <div class="form-group mgt20">
                                <label for="inputAddress2" class="fw6">Link Fanpage facebook: </label>
                                <input type="text" class="form-control" placeholder="Link Fanpage facebook ..."
                                       name="my_facebook"
                                       value="{{ isset($employer->my_facebook) ? $employer->my_facebook : '' }}">

                            </div>
                            <div class="form-group mgt20">
                                <label for="inputAddress2" class="fw6">Link zalo web: </label>
                                <input type="text" class="form-control" placeholder="Link zalo web"
                                       name="my_zalo" value="{{ isset($employer->my_zalo) ? $employer->my_zalo : '' }}">

                            </div>
                            <div class="form-group mgt20">


                                <div class="gruopRadio mgt5 pdLeft0">
                                    <div class="g-recaptcha" id="feedback-recaptcha"
                                         data-sitekey="{{ ENV('RE_CAPTCHA_HTML')  }}"></div>
                                    <!-- End Google reCaptcha -->
                                    <div class="error error_g-captcha"></div>
                                </div>
                            </div>

                            <div class="form-group mgt20">
                                <div class="gruopRadio mgt5 pdLeft0">
                                    <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5"
                                            style="border:none" id="btnloading"> Lưu hồ sơ nhà tuyển dụng
                                    </button>
                                </div>
                            </div>

                            {{--</form>--}}


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
                    enterprise_name: {
                        required: true,
                        checkName: true,
                    },
                    phone: {
                        required: true,
                        checkPhone: true,
                    },
                    image: {
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
                    introduction: {
                        required: true,
                    },
                    type_of_business_id: {
                        required: true,
                    },
                    business: {
                        required: true,
                    },
                },
                messages: {
                    enterprise_name: {
                        required: 'Vui lòng nhập tên công ty.',
                        // checkName: 'Tên công ty được chứa số và ký tự đặc biệt.',
                    },
                    phone: {
                        required: 'Số điện thoại phải là số và không được để trống.',
                        // checkPhone: 'Số điện thoại không hợp lệ',
                    },
                    image: {
                        required: 'Vui lòng chọn logo công ty.',
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
                    introduction: {
                        required: 'Vui lòng  nhập giới thiệu công ty.',
                    },
                    type_of_business_id: {
                        required: 'Vui lòng chọn loại hình doanh nghiệp.',
                    },
                    business: {
                        required: 'Vui lòng chọn loại hình kinh doanh.',
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
                $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lưu hồ sơ ...');
                $btn.attr('disabled', false);
            }
            else {
            }
        });


    </script>
@else


@endif


