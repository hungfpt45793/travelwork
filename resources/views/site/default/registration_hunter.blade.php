@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', !empty($information_service->title) ? $information_service->title : '')
@section('meta_description', !empty($information_service->title) ? $information_service->title : '')
@section('keywords', !empty($information_service->title) ? $information_service->title : '')
@section('meta_image', !empty($information_service->title) ? $information_service->title : '')
@section('meta_url',!empty($information_service->title) ? $information_service->title : '' )
<link rel="stylesheet" type="text/css" href="/public/assets/css/list_price.css"/>
<link rel="stylesheet" type="text/css" href="/public/assets/css/item_price.css"/>
<style>
    .select2-selection__rendered {
        border: 1px solid #d0d2d4;
        border-radius: 5px;
    }
</style>

@section('content')
    <section class="pay_price_new">
        <div class="container container_w_1200 pay_price_new">
            <form style="padding: 15px" action="{{ route('save_registration_hunter') }}" method="POST"
                  id="location-form">
                {{ csrf_field() }}
                <div class="box_price_new">
                    <div class="row">
                        <div class="col-md-12 title_pay_price ">
                            <h1 style="text-transform: uppercase">Nhà tuyển dụng đăng ký thuê tuyển dụng hộ</h1>
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
                        @php
                            if(isset($_GET['hunter_price_id'])){
                            $hunter_price = \App\Entity\Hunter_price::get_hunter_price($_GET['hunter_price_id']);
                            }
                        @endphp

                        <div class="col-12 col-lg-6 mt-3 table-responsive ">
                            <div class="box_table_pay">
                                <h3 class="f24">
                                    Thông tin dịch vụ
                                </h3>
                                <table class="table">
                                    <tr>
                                        <td>Vị trí cần tuyển:</td>
                                        <td class="text-success">{{ (isset($hunter_price)) ? $hunter_price->hunter_pos_name : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Thời gian tuyển:</td>
                                        <td class="text-success">{{ (isset($hunter_price)) ? $hunter_price->hunter_time_name : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Chi phí:</td>
                                        <td class="text-success">{{ (isset($hunter_price)) ? $hunter_price->hunter_price_name : '' }}</td>
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
                                <input type="text" hidden
                                       value="{{ (isset($hunter_price)) ? $hunter_price->hunter_pos_id : '' }}" required
                                       name="hunter_regis_pos">
                                <input type="text" hidden
                                       value="{{ (isset($hunter_price)) ? $hunter_price->hunter_time_id : '' }}"
                                       required name="hunter_regis_time">
                                <input type="text" hidden value="{{ $_GET['hunter_price_id'] }}" required
                                       name="hunter_regis_price">
                                @if (Auth::check() && Auth::user()->role!=2)
                                    <div class="row pt-3 pb-3">
                                        <div class="col-md-6 isset-employer">
                                            <div class="form-group">
                                                <label for="">Tên nhà tuyển dụng<span
                                                            class="text-danger">(*)</span></label>
                                                <input type="text"
                                                       class="form-control ss error_border_hunter_regis_name"
                                                       name="hunter_regis_name"
                                                       value="{{ Auth::user()->name }}" required>
                                                <div class="mess_notice_hunter_regis_name clearfix note_text_hunter_regis_name"></div>
                                                <div class="error_reg_mess clearfix error_text_hunter_regis_name"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 isset-employer">
                                            <div class="form-group">
                                                <label for="">SĐT nhà tuyển dụng(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="number"
                                                       class="form-control error_border_hunter_regis_phone"
                                                       name="hunter_regis_phone"
                                                       value="{{ Auth::user()->phone }}" required>
                                                <div class="mess_notice_hunter_regis_phone clearfix note_text_hunter_regis_phone"></div>
                                                <div class="error_reg_mess clearfix error_text_hunter_regis_phone"></div>
                                            </div>

                                        </div>
                                        <div class="col-md-12 isset-employer">
                                            <div class="form-group">
                                                <label for="">Email nhà tuyển dụng(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="email" class="form-control error_border_hunter_regis_email"
                                                       name="hunter_regis_email"
                                                       value="{{ Auth::user()->email }}" required>
                                                <div class="mess_notice_hunter_regis_email clearfix note_text_hunter_regis_email"></div>
                                                <div class="error_reg_mess clearfix error_text_hunter_regis_email"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 isset-employer">
                                            <div class="form-group">
                                                <label for="">Địa chỉ(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="text"
                                                       class="form-control error_border_hunter_regis_address"
                                                       name="hunter_regis_address"
                                                       value="{{ !empty(old('hunter_regis_address') ? old('hunter_regis_address') : '') }}"
                                                       required>
                                                <div class="mess_notice_hunter_regis_address clearfix note_text_hunter_regis_address"></div>
                                                <div class="error_reg_mess clearfix error_text_hunter_regis_address"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 isset-employer">
                                            <div class="form-group">
                                                <label for="">Nội dung(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="text" class="form-control error_border_hunter_regis_note"
                                                       name="hunter_regis_note"
                                                       value="{{ !empty(old('hunter_regis_note') ? old('hunter_regis_note') : '') }}"
                                                       required>
                                                <div class="mess_notice_hunter_regis_note clearfix note_text_hunter_regis_note"></div>
                                                <div class="error_reg_mess clearfix error_text_hunter_regis_note"></div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif(Auth::check() && Auth::user()->role==2)
                                    @php
                                        $employer = \App\Entity\Employer::where('user_id', Auth::id())->first();
                                    @endphp
                                    <div class="row pt-3 pb-3">
                                        <div class="col-md-6 isset-employer">
                                            <div class="form-group">
                                                <label for="">Tên nhà tuyển dụng<span
                                                            class="text-danger">(*)</span></label>
                                                <input type="text"
                                                       class="form-control ss error_border_hunter_regis_name"
                                                       name="hunter_regis_name"
                                                       value="{{ $employer->enterprise_name  }}" required>
                                                <div class="mess_notice_hunter_regis_name clearfix note_text_hunter_regis_name"></div>
                                                <div class="error_reg_mess clearfix error_text_hunter_regis_name"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 isset-employer">
                                            <div class="form-group">
                                                <label for="">SĐT nhà tuyển dụng(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="number"
                                                       class="form-control error_border_hunter_regis_phone"
                                                       name="hunter_regis_phone"
                                                       value="{{ $employer->phone }}" required>
                                                <div class="mess_notice_hunter_regis_phone clearfix note_text_hunter_regis_phone"></div>
                                                <div class="error_reg_mess clearfix error_text_hunter_regis_phone"></div>
                                            </div>

                                        </div>
                                        <div class="col-md-12 isset-employer">
                                            <div class="form-group">
                                                <label for="">Email nhà tuyển dụng(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="email" class="form-control error_border_hunter_regis_email"
                                                       name="hunter_regis_email"
                                                       value="{{ $employer->email }}" required>
                                                <div class="mess_notice_hunter_regis_email clearfix note_text_hunter_regis_email"></div>
                                                <div class="error_reg_mess clearfix error_text_hunter_regis_email"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 isset-employer">
                                            <div class="form-group">
                                                <label for="">Địa chỉ(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="text"
                                                       class="form-control error_border_hunter_regis_address"
                                                       name="hunter_regis_address"
                                                       value="{{ !empty(old('hunter_regis_address') ? old('hunter_regis_address') : '') }}"
                                                       required>
                                                <div class="mess_notice_hunter_regis_address clearfix note_text_hunter_regis_address"></div>
                                                <div class="error_reg_mess clearfix error_text_hunter_regis_address"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 isset-employer">
                                            <div class="form-group">
                                                <label for="">Nội dung(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="text" class="form-control error_border_hunter_regis_note"
                                                       name="hunter_regis_note"
                                                       value="{{ !empty(old('hunter_regis_note') ? old('hunter_regis_note') : '') }}"
                                                       required>
                                                <div class="mess_notice_hunter_regis_note clearfix note_text_hunter_regis_note"></div>
                                                <div class="error_reg_mess clearfix error_text_hunter_regis_note"></div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row pt-3 pb-3">
                                        <div class="col-md-6 isset-employer">
                                            <div class="form-group">
                                                <label for="">Tên nhà tuyển dụng<span
                                                            class="text-danger">(*)</span></label>
                                                <input type="text"
                                                       class="form-control ss error_border_hunter_regis_name"
                                                       name="hunter_regis_name"
                                                       value="{{ !empty(old('hunter_regis_name') ? old('hunter_regis_name') : '') }}"
                                                       required>
                                                <div class="mess_notice_hunter_regis_name clearfix note_text_hunter_regis_name"></div>
                                                <div class="error_reg_mess clearfix error_text_hunter_regis_name"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 isset-employer">
                                            <div class="form-group">
                                                <label for="">SĐT nhà tuyển dụng(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="number"
                                                       class="form-control error_border_hunter_regis_phone"
                                                       name="hunter_regis_phone"
                                                       value="{{ !empty(old('hunter_regis_phone') ? old('hunter_regis_phone') : '') }}"
                                                       required>
                                                <div class="mess_notice_hunter_regis_phone clearfix note_text_hunter_regis_phone"></div>
                                                <div class="error_reg_mess clearfix error_text_hunter_regis_phone"></div>
                                            </div>

                                        </div>
                                        <div class="col-md-12 isset-employer">
                                            <div class="form-group">
                                                <label for="">Email nhà tuyển dụng(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="email" class="form-control error_border_hunter_regis_email"
                                                       name="hunter_regis_email"
                                                       value="{{ !empty(old('hunter_regis_email') ? old('hunter_regis_email') : '') }}"
                                                       required>
                                                <div class="mess_notice_hunter_regis_email clearfix note_text_hunter_regis_email"></div>
                                                <div class="error_reg_mess clearfix error_text_hunter_regis_email"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 isset-employer">
                                            <div class="form-group">
                                                <label for="">Địa chỉ(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="text"
                                                       class="form-control error_border_hunter_regis_address"
                                                       name="hunter_regis_address"
                                                       value="{{ !empty(old('hunter_regis_address') ? old('hunter_regis_address') : '') }}"
                                                       required>
                                                <div class="mess_notice_hunter_regis_address clearfix note_text_hunter_regis_address"></div>
                                                <div class="error_reg_mess clearfix error_text_hunter_regis_address"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 isset-employer">
                                            <div class="form-group">
                                                <label for="">Nội dung(<span
                                                            class="text-danger">*</span>)</label>
                                                <input type="text" class="form-control error_border_hunter_regis_note"
                                                       name="hunter_regis_note"
                                                       value="{{ !empty(old('hunter_regis_note') ? old('hunter_regis_note') : '') }}"
                                                       required>
                                                <div class="mess_notice_hunter_regis_note clearfix note_text_hunter_regis_note"></div>
                                                <div class="error_reg_mess clearfix error_text_hunter_regis_note"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-12 isset-employer">
                                        <div class="form-group">
                                            <label for="">Mã số thuế </label>
                                            <input type="text" class="form-control" name="hunter_tax_code"
                                                   value="">
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
        $(document).ready(function () {
            $('#province').change(function () {
                $.get('/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                });
            });
        });
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
                    hunter_regis_name: {
                        required: true,
                        minlength: 10,
                    },
                    hunter_regis_phone: {
                        required: true,
                        number: true,
                    },
                    hunter_regis_email: {
                        required: true,
                        email: true,
                    },
                    hunter_regis_address: {
                        required: true,
                    },
                    hunter_regis_note: {
                        required: true,
                    },
                },
                messages: {
                    hunter_regis_name: {
                        required: 'Vui lòng nhập tên công ty.',
                        minlength: 'Tên công ty phải tối thiểu 10 ký tự.',
                    },
                    hunter_regis_phone: {
                        required: 'Số điện thoại phải là số và không được để trống.',
                    },
                    hunter_regis_email: {
                        required: 'Vui lòng nhập địa chỉ Email.',
                        email: 'Vui lòng nhập một địa chỉ Email hợp lệ !'
                    },
                    hunter_regis_address: {
                        required: 'Vui lòng nhập địa chỉ.',
                    },
                    hunter_regis_note: {
                        required: 'Vui lòng nhập tên nội dung.',
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
        $('#js_btnRegidit').click(function () {
            if ($('#location-form').valid()) {
                if (grecaptcha.getResponse() == "") {
                    $('.error_g-captcha').text("Vui lòng tích chọn ' Tôi không phải người máy ' hoặc ' I'm not a robot '");
                    $('.error_g-captcha').css('margin-bottom', '5px');
                    return false;
                } else {
                    $('.error_g-captcha').text("");
                }
                $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang xử lý đơn hàng...');
                $btn.attr('disabled', false);
            } else {
            }
        });

    </script>
@endsection