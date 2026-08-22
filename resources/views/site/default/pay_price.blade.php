@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', !empty($information_service->title) ? $information_service->title : 'Đăng ký dịch vụ')

@section('meta_description', !empty($information_service->title) ? $information_service->title : 'đăn ký dùng dịch vụ du lịch')
@section('keywords', !empty($information_service->title) ? $information_service->title : 'dịch vụ du lịch')
@section('meta_image', !empty($information_service->title) ? $information_service->title : '')
@section('meta_url',!empty($information_service->title) ? $information_service->title : '' )

<link rel="stylesheet" type="text/css" href="/public/assets/css/list_price.css"/>
<link rel="stylesheet" type="text/css" href="/public/assets/css/item_price.css"/>
@section('content')
    <style>
        .icon_sendemail .fa-envelope-open-text {
            position: relative;
            top: 7px;
        }
    </style>

    <section class="pay_price_new">
        <div class="container container_w_1200 pay_price_new">
            <form action="{{ route('save_order') }}?service={{ !empty($service_price->service_price_id) ? $service_price->service_price_id : '' }}&service_package={{ !empty($service_table_price->service_table_price_id) ? $service_table_price->service_table_price_id  : '' }}"
                  id="location-form"
                  method="POST">
                {{ csrf_field() }}
                <div class="box_price_new">
                    <div class="row">
                        <div class="col-md-12 title_pay_price ">
                            <h1 style="text-transform: uppercase">ĐĂNG KÝ GÓI DỊCH vụ</h1>
                        </div>

                        @if(session('success'))
                            <div class="col-md-12">
                                <div class="infoAlert">
                                    <div class="alert alert-success text-center">
                                        <span>{!! session('success') !!}</span>
                                        <button type="button" class="close iconAlert" data-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>
                                    <a href="{{ route('home') }}" class="btn btn-success f18 md-f14 mgb0 flaot-right">Quay
                                        lại</a>
                                </div>
                            </div>
                        @endif


                        <div class="col-12 col-lg-6 mt-3 table-responsive ">
                            <div class="box_table_pay">
                                <h3 class="f24">
                                    Thông tin dịch vụ
                                </h3>
                                <table class="w-100 table table_pay_price">
                                    <tr class="">
                                        <td scope="row" class="border_td_right">
                                            Dịch vụ
                                        </td>
                                        <td style="">
                                    <span class="td_span">
                                    @php
                                        echo title_case($service_price->service_price_title);
                                    @endphp
                                </span>

                                        </td>
                                    </tr>

                                    <tr class="">
                                        <td scope="row" class="border_td_right">
                                            Gói dịch vụ
                                        </td>
                                        <td>
                                            <span class="td_span">{{ !empty($service_table_price->package_name) ? $service_table_price->package_name : '' }}</span>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td scope="row" class="border_td_right">
                                            Giá dịch vụ
                                        </td>
                                        <td>
                                            <span class="td_span">{{ !empty($service_table_price->package_price) ? $service_table_price->package_price : '' }}</span>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td scope="row" class="border_td_right">
                                            Chiết khấu
                                        </td>
                                        <td>
                                            <span class="td_span">{{ !empty($service_table_price->package_discount) ? $service_table_price->package_discount : '' }}</span>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td scope="row" class="border_td_right">
                                            Giá có vat
                                        </td>
                                        <td>
                                            <span class="td_span">{{ !empty($service_table_price->package_vat) ? $service_table_price->package_vat : '' }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 mt-3 col-lg-6 ">
                            <div class="box_table_pay">
                                <h3 class="f24">
                                    Thông tin đăng ký
                                </h3>
                                @if($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger" role="alert"
                                             style="padding: 5px;margin: 2px;display: inline-block;">
                                            <strong>{{ $error }}</strong>
                                        </div>
                                    @endforeach
                                @endif
                                {{-- <input type="text" hidden name="service_order_code"
                                    value="DH{{ $service_price->service_price_id }}{{ $service_table_price->service_table_price_id }}"> --}}
                                <input type="text" hidden name="service_price_id"
                                       value="{{ !empty($service_price->service_price_id) ? $service_price->service_price_id : '' }}">
                                <input type="text" hidden name="service_table_price_id"
                                       value="{{ !empty($service_table_price->service_table_price_id) ? $service_table_price->service_table_price_id : '' }}">
                                @if (Auth::check() && Auth::user()->role!=2)
                                    <div class="row pt-3 pb-3">
                                        <div class="col-md-6 isset-employer">
                                            <div class="form-group">
                                                <label for="">Tên nhà tuyển dụng<span
                                                            class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control ss error_border_employer_name"
                                                       name="employer_name"
                                                       value="{{ Auth::user()->name }}" required>
                                                <div class="mess_notice_employer_name clearfix note_text_employer_name"></div>
                                                <div class="error_reg_mess clearfix error_text_employer_name"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 isset-employer">
                                            <div class="form-group">
                                                <label for="">SĐT nhà tuyển dụng(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="number" class="form-control error_border_employer_phone"
                                                       name="employer_phone"
                                                       value="{{ Auth::user()->phone }}" required>
                                                <div class="mess_notice_employer_phone clearfix note_text_employer_phone"></div>
                                                <div class="error_reg_mess clearfix error_text_employer_phone"></div>
                                            </div>

                                        </div>
                                        <div class="col-md-12 isset-employer">
                                            <div class="form-group">
                                                <label for="">Email nhà tuyển dụng(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="email" class="form-control error_border_employer_email"
                                                       name="employer_email"
                                                       value="{{ Auth::user()->email }}" required>
                                                <div class="mess_notice_employer_email clearfix note_text_employer_email"></div>
                                                <div class="error_reg_mess clearfix error_text_employer_email"></div>
                                            </div>
                                        </div>

                                        {{-- @if (Auth::check() && Auth::user()->role!=2)
                                        <div class="col-md-6 mt-4">
                                            <a class="btn btn-info btn-edit-tt">Sửa</a>
                                        </div>
                                        @endif --}}
                                    </div>
                                @elseif(Auth::check() && Auth::user()->role==2)
                                    @php
                                        $employer = \App\Entity\Employer::where('user_id', Auth::id())->first();
                                    @endphp
                                    <div class="rowpt-3 pb-3">
                                        <div class="col-md-12 isset-employer">
                                            <div class="form-group">
                                                <label for="">Tên nhà tuyển dụng(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="text" class="form-control ss error_border_employer_name"
                                                       name="employer_name"
                                                       value="{{ $employer->enterprise_name }}" required>
                                                <div class="mess_notice_employer_name clearfix note_text_employer_name"></div>
                                                <div class="error_reg_mess clearfix error_text_employer_name"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 isset-employer">
                                            <div class="form-group">
                                                <label for="">SĐT nhà tuyển dụng(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="number" class="form-control error_border_employer_phone"
                                                       name="employer_phone"
                                                       value="{{ $employer->phone }}" required>
                                                <div class="mess_notice_employer_phone clearfix note_text_employer_phone"></div>
                                                <div class="error_reg_mess clearfix error_text_employer_phone"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 isset-employer">
                                            <div class="form-group">
                                                <label for="">Email nhà tuyển dụng(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="email" class="form-control error_border_employer_email"
                                                       name="employer_email"
                                                       value="{{ $employer->email }}" required>
                                                <div class="mess_notice_employer_email clearfix note_text_employer_email"></div>
                                                <div class="error_reg_mess clearfix error_text_employer_email"></div>
                                            </div>
                                        </div>
                                        {{-- @if (Auth::check() && Auth::user()->role!=2)
                                        <div class="col-md-6 mt-4">
                                            <a class="btn btn-info btn-edit-tt">Sửa</a>
                                        </div>
                                        @endif --}}
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Tên nhà tuyển dụng(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="text" class="form-control ss error_border_employer_name"
                                                       name="employer_name"
                                                       required>
                                                <div class="mess_notice_employer_name clearfix note_text_employer_name"></div>
                                                <div class="error_reg_mess clearfix error_text_employer_name"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">SĐT nhà tuyển dụng(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="number" class="form-control error_border_employer_phone"
                                                       name="employer_phone"
                                                       required>
                                                <div class="mess_notice_employer_phone clearfix note_text_employer_phone"></div>
                                                <div class="error_reg_mess clearfix error_text_employer_phone"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Email nhà tuyển dụng(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="email" class="form-control error_border_employer_email"
                                                       name="employer_email" required>
                                                <div class="mess_notice_employer_email clearfix note_text_employer_email"></div>
                                                <div class="error_reg_mess clearfix error_text_employer_email"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-12 isset-employer">
                                        <div class="form-group">
                                            <label for="">Mã số thuế </label>
                                            <input type="text" class="form-control" name="tax_code">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mgb10">
                                            <p class="mgb0"><i>(Vui lòng tích chọn ' Tôi không phải người máy ' hoặc '
                                                    I'm not a robot ')</i></p>
                                            <!-- Google reCaptcha -->
                                            <div class="g-recaptcha" id="feedback-recaptcha"
                                                 data-sitekey="{{ env('RE_CAPTCHA_HTML')  }}"></div>
                                            <div class="error error_g-captcha"></div>
                                            <!-- End Google reCaptcha -->
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        @if(!empty($errors->all()))
                                            @foreach($errors->all() as $erorr)
                                                <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12 col-12">
                            <button type="submit" class="btn btn-success button_submit_pay_new" id="js_btnRegidit">Đặt
                                đơn hàng
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>

    </section>
    <script>
        $(function () {
            $('.box_tt_nh .box_tt_bank').addClass('d-none');
            $('.box_tt_nh .box_tt_bank:first-child').removeClass('d-none');
            $data = $('.box_tt_nh .box_tt_bank:first-child').attr('data');
            console.log($data)
            $('#' + $data + ' img').css({"background": "#e9eb97"})
            // $('.logo_nh:first-child img').css({"background":"#e9eb97"})
            $('.logo_nh').click(function () {
                $('.logo_nh img').css({"background": "#fff"});
                $id = $(this).attr('id');
                $('#' + $id + ' img').css({"background": "#e9eb97"})
                $('.box_tt_nh .box_tt_bank').addClass('d-none');
                $('div[data=' + $id + ']').removeClass('d-none');
            })

            $('.btn-edit-tt').click(function () {
                $('.isset-employer input').prop('readonly', function () {
                    return !$(this).prop('readonly');
                });
            })
        })
    </script>

@endsection

@section('show_js')
    <script src="/public/assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            email = $.trim('email');
            $("#location-form").validate({
                ignore: [],
                onkeyup: false,
                rules: {
                    employer_name: {
                        required: true,
                        minlength: 10,
                    },
                    employer_phone: {
                        required: true,
                        number: true,
                    },
                    employer_email: {
                        required: true,
                        email: true,
                    }

                },
                messages: {
                    employer_name: {
                        required: 'Vui lòng nhập tên công ty.',
                        minlength: 'Tên công ty phải tối thiểu 10 ký tự.',
                    },
                    employer_phone: {
                        required: 'Số điện thoại phải là số và không được để trống.',
                    },
                    employer_email: {
                        required: 'Vui lòng nhập địa chỉ Email.',
                        email: 'Vui lòng nhập một địa chỉ Email hợp lệ !'
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
        // $('#js_btnRegidit').click(function () {
        //     if ($('#location-form').valid()) {
        //         if (grecaptcha.getResponse() == "") {
        //             $('.error_g-captcha').text("Vui lòng tích chọn ' Tôi không phải người máy ' hoặc ' I'm not a robot '");
        //             $('.error_g-captcha').css('margin-bottom', '5px');
        //             return false;
        //         } else {
        //             $('.error_g-captcha').text("");
        //         }
        //         $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang xử lý đơn hàng...');
        //         $btn.attr('disabled', false);
        //     } else {
        //     }
        // });

    </script>
@endsection
