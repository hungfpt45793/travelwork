@extends('site.layout.site')

@section('title','Nhà Tuyển dụng Đăng ký')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')
    <section class="main-ctn">
        <div class="wrapper container">
            <section id="contact-content" class="w78 marginAuto">
                <div class="col-xl-12 col-lg-12 col-md-12 JobSeeker EmployerRegistration mgb20">
                    <div class="main">
                        @if(session('error'))
                        <div class="form-group">
                            <div class="alert alert-danger">
                                <i>{{ session('error') }}</i>
                            </div>
                        </div>
                        @endif
                        <form action="{{route('dang_ky_tuyen_dung')}}" id="location-form" method="post"
                              class="dang-ky-tuyen-dung">
                            {!! csrf_field() !!}
                            <div class="notificationBox mgt20">
                                <p class="text-title font15Im mgt0Im">
                                    nhà tuyển dụng đăng ký nhanh
                                </p>
                                <hr>
                                <div class="supporter text-ct">
                           <span>Nếu gặp bất kỳ khó khăn nào vui lòng liên hệ Hotline hỗ trợ nhà tuyển dụng <br><br>
                               <span class="block font20 red">
                                   <span class="dsBlock">
                                       <b> {{isset($information['hotline']) ? $information['hotline'] : ''}} </b>
                                   </span>
                               </span>
                           </span>
                                </div>

                                <div class="recruitmentRegistration">
                                    <p class="text-title font15Im">
                                        thông tin công ty
                                    </p>
                                </div>
                                <div class="bodyBox">
                                    <div class="accountInfo">
                                        <div class="form-group row">
                                            <label class="col-12 text-left lable">Tên công ty<span>*</span> </label>
                                            <div class="col-12">
                                                <input type="text" name="name" value="{{old('name')}}"
                                                       class="form-control" placeholder="Tên công ty">
                                                <small id="emailHelp" class="form-text text-muted"><i>Ghi tên công ty
                                                        đầy đủ và rõ
                                                        ràng theo Giấy phép đăng ký kinh doanh.</i></small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-12 text-left lable">Địa chỉ công
                                                ty<span>*</span>
                                            </label>
                                            <div class="col-6 mgb10">
                                                <select class="form-control select2" name="province"
                                                        aria-label="Tỉnh/Thành phố" id="province">
                                                    <option value=""> -- Tất cả các tỉnh/thành phố --</option>
                                                    @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                        <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6 mgb10">
                                                <select class="form-control select2" name="district"
                                                        aria-label="Quận/Huyện" id="district">
                                                    <option value=""> -- Tất cả các quận/huyện --</option>
                                                    @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                        <option value="{{$district->district_id}}">{{$district->district_name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="col-12">
                                                <input type="text" name="address" id="location-input"
                                                       class="form-control" placeholder="Địa chỉ chi tiết công ty" value="{{old('address')}}" >
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-12 text-left lable">Tên người đại diện
                                                <span>*</span> </label>
                                            <div class="col-12">
                                                <input type="text" name="employer_name" value="{{old('employer_name')}}"
                                                       class="form-control" placeholder="Tên người phụ trách">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 text-left lable">Số điện thoại liên hệ<span>*</span>
                                            </label>
                                            <div class="col-12">
                                                <input type="number" name='phone' value="{{old('phone')}}"
                                                       class="form-control" placeholder="Số điện thoại liên hệ">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 text-left lable">Tài khoản Email<span>*</span> </label>
                                            <div class="col-12">
                                                <input type="text" name='email' value="{{old('email')}}"
                                                       class="form-control" placeholder="Email là tài khoản đăng nhập">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 text-left lable">Mật khẩu (ít nhất 8 kí tự) <span>*</span> </label>
                                            <div class="col-12">
                                                <input type="password" name='password' class="form-control"
                                                       placeholder="Mật khẩu" value="{{old('password')}}" >
                                            </div>
                                        </div>
                                        {{--<div class="form-group row">--}}
                                            {{--<label class="col-12 text-left lable">Chế độ đãi ngộ<span></span> <span--}}
                                                        {{--class="XamMo">(Tối đa 6 đãi ngộ)</span></label>--}}

                                            {{--<div class="col-12 dai-ngo">--}}
                                                {{--<input type="text" name='remuneration[]' class="form-control mgb10"--}}
                                                       {{--placeholder="Nhập chế độ đãi ngộ  (Tối đa 50 ký tự)">--}}
                                                {{--<a class='them-dai-ngo'><i class="fas fa-plus"></i> Thêm đãi ngộ</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<label class="col-12 text-left lable">--}}
                                            {{--<div class="form-group row">--}}
                                                {{--Vì sao nên ứng tuyển công ty tôi<span></span>--}}
                                                {{--<span class="XamMo mgb10">(Tối đa 3 lý do)</span>--}}
                                        {{--</label>--}}
                                        {{--<div class="col-12 pd0 li-do-chon">--}}
                                            {{--<textarea name="reason_choose[]" id="txtNote" rows="3"--}}
                                                      {{--class="textarea font17 w100 pdt5"--}}
                                                      {{--placeholder="  Nhập lý do  (Tối đa 100 ký tự)"--}}
                                                      {{--style="width: 100%;"></textarea>--}}
                                            {{--<a class='them-li-do'><i class="fas fa-plus"></i> Thêm lý do</a>--}}
                                        {{--</div>--}}
                                    </div>
                                    <div class="col-12 pd0 li-do-chon">
                                        <input type="text" id='lat' name='latitude' value="" class="form-control mgb10"
                                               style="display:none" placeholder="">

                                    </div>
                                    <div class="col-12 pd0 li-do-chon">
                                        <input type="text" id='lng' name='longitude' value="" class="form-control mgb10"
                                               style="display:none" placeholder="">

                                    </div>
                                    <div class="form-group error">
                                        @if ($errors->has('email'))
                                            <label for="exampleInputEmail1">{{ $errors->first('email') }}</label>
                                        @endif
                                        @if ($errors->has('password'))
                                            <label for="exampleInputEmail1">{{ $errors->first('password') }}</label>
                                        @endif
                                        @if ($errors->has('name'))
                                            <label for="exampleInputEmail1">{{ $errors->first('name') }}</label>
                                        @endif
                                        @if ($errors->has('address'))
                                            <label for="exampleInputEmail1">{{ $errors->first('address') }}</label>
                                        @endif
                                        @if ($errors->has('employer_name'))
                                            <label for="exampleInputEmail1">{{ $errors->first('employer_name') }}</label>
                                        @endif
                                        @if ($errors->has('phone'))
                                            <label for="exampleInputEmail1">{{ $errors->first('phone') }}</label>
                                        @endif
                                            @if ($errors->has('g-recaptcha-response'))
                                                <label for="exampleInputEmail1">{{ $errors->first('g-recaptcha-response') }}</label>
                                            @endif
                                    </div>

                                    <div class="form-group">
                                        <!-- Google reCaptcha -->
                                        <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{{ '6Le9trIUAAAAALrCbKEVd_fFCOjZm13bNMk9DmZP'  }}"></div>
                                        <!-- End Google reCaptcha -->
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-12 text-ct">
                                            <button type="submit" class="btnOrange">Đăng kí nhà tuyển dụng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                    <script>
                        $(".loai-hinh").select2({
                            placeholder: "Select a state",
                            allowClear: true,
                            tokenSeparators: [',', ' ']
                        })
                    </script>
                    <script>
                        $(".them-dai-ngo").click(function () {
                            $(this).before('<input type="text"  name="remuneration[]" class="form-control mgb10" placeholder="Nhập chế độ đãi ngộ  (Tối đa 50 ký tự)">')
                        })

                        $(".them-li-do").click(function () {
                            $(this).before('<textarea name="reason_choose[]" id="txtNote" rows="3" class="textarea font17 w100 pdt5" placeholder="  Nhập lý do  (Tối đa 100 ký tự)" style="width: 100%;"></textarea>')
                        })

                        $(document).ready(function () {
                            $('#province').change(function () {
                                $.get('/ajax-district/' + $(this).val(), function (data) {
                                    $('#district').html(data);
                                });
                            });
                        });

                    </script>


                    <style>
                        .error label {
                            background: #ef5050;
                            color: #fff;
                            padding: 5px;
                            margin-right: 5px;

                        }
                    </style>
                </div>
        </div>
    </section><!--end: #content-->
    </div>
    </section>

@endsection
