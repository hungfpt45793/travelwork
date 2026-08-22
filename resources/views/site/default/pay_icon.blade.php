@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', !empty($information_service->title) ? $information_service->title : '')

@section('meta_description', !empty($information_service->title) ? $information_service->title : '')
@section('keywords', !empty($information_service->title) ? $information_service->title : '')
@section('meta_image', !empty($information_service->title) ? $information_service->title : '')
@section('meta_url',!empty($information_service->title) ? $information_service->title : '' )


@section('content')
<section class="PagesNewsContent bkxam pdb20 pdt20 pay_price">
    <div class="container d-container">
        <div class="link bgrWhite mgb20 p-3">
            <ul class="nav">
                <li class="nav-item pd8">
                    <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                </li>
                <li class="nav-item pd8">
                    <p class="mgt5 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                </li>
                <li class="nav-item pd8">
                    <a href="{{ route('list_price') }}" class=" f18 md-f14 mgb0">Bảng giá dịch vụ</a>
                </li>
            </ul>
        </div>
        <div class="link bgrWhite mgb20 p-3">
            <div class="row">
                {{-- <div class="col-12 mb-2 titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14">
                    <h5 class="titleJobs  fw6 f20 mgb0 col-f14">CHUYỂN TIỀN QUA INTERNET BANKING - MỜI BẠN CHỌN NGÂN
                        HÀNG</h5>
                </div> --}}
               
            {{-- <div class="box_nh row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    @foreach ($pay_prices2first as $pay_price2first)
                    <div class="logo_nh" id="logo_nh{{ $pay_price2first->service_bank_id }}">
                        <img src="{{ $pay_price2first->service_bank_image }}" alt="">
                    </div>
                    @endforeach
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 box_tt_nh  border border-secondary p-5">
                    @foreach ($pay_prices2first as $pay_price2first)
                    <div class="row box_tt_bank pt-2" data="logo_nh{{ $pay_price2first->service_bank_id }}">
                        <div class="col-8">
                            <p class="text-uppercase text-primary">THÔNG TIN TÀI KHOẢN {{ $pay_price2first->service_bank_name }}</p>
                            <p>Số Tài Khoản: {{ $pay_price2first->service_bank_number }}</p>
                            <p>Chủ Tài Khoản: {{ $pay_price2first->service_bank_own }}</p>
                        </div>
                        <div class="col-4">
                            <img src="{{ $pay_price2first->service_bank_image }}" alt="">
                        </div>
                        <div class="col-12">
                            <p>Chi Nhánh: {{ $pay_price2first->service_bank_branch }}</p>
                            {!! $pay_price2first->service_bank_content !!}
                        </div>
                    </div>
                    @endforeach
                    @foreach ($pay_prices2next as $pay_price2next)
                    <div class="row box_tt_bank pt-2" data="logo_nh{{ $pay_price2next->service_bank_id }}">
                        <div class="col-8">
                            <p class="text-uppercase text-primary">THÔNG TIN TÀI KHOẢN {{ $pay_price2next->service_bank_name }}</p>
                            <p>Số Tài Khoản: {{ $pay_price2next->service_bank_number }}</p>
                            <p>Chủ Tài Khoản: {{ $pay_price2next->service_bank_own }}</p>
                        </div>
                        <div class="col-4">
                            <img src="{{ $pay_price2next->service_bank_image }}" alt="">
                        </div>
                        <div class="col-12">
                            <p>Chi Nhánh: {{ $pay_price2next->service_bank_branch }}</p>
                            {!! $pay_price2next->service_bank_content !!}
                        </div>
                    </div>
                    @endforeach
                    @foreach ($pay_pricesend as $pay_priceend)
                    <div class="row box_tt_bank pt-2" data="logo_nh{{ $pay_priceend->service_bank_id }}">
                        <div class="col-8">
                            <p class="text-uppercase text-primary">THÔNG TIN TÀI KHOẢN {{ $pay_priceend->service_bank_name }}</p>
                            <p>Số Tài Khoản: {!! $pay_priceend->service_bank_number !!}</p>
                            <p>Chủ Tài Khoản: {!! $pay_priceend->service_bank_own !!}</p>
                        </div>
                        <div class="col-4">
                            <img src="{{ $pay_priceend->service_bank_image }}" alt="">
                        </div>
                        <div class="col-12">
                            <p>Chi Nhánh: {!! $pay_priceend->service_bank_branch !!}</p>
                            {!! $pay_priceend->service_bank_content !!}
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    @foreach ($pay_prices2next as $pay_price2next)
                    <div class="logo_nh" id="logo_nh{{ $pay_price2next->service_bank_id }}">
                        <img src="{{ $pay_price2next->service_bank_image }}" alt="">
                    </div>
                    @endforeach
                </div>

            </div> --}}

            {{-- <div class="box2_nh row ">
                @foreach ($pay_pricesend as $pay_priceend)
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <div class="logo_nh" id="logo_nh{{ $pay_priceend->service_bank_id }}">
                        <img src="{{ $pay_priceend->service_bank_image }}" alt="">
                    </div>
                </div>
                @endforeach
            </div> --}}

        </div>
        <div class="row">
            <div class="col-12 mt-2 titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14">
                <h5 class="titleJobs d-h5 text-center  fw6 f20 mgb0 col-f14">ĐĂNG KÝ SỬ DỤNG ICON</h5>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12 col-lg-6 mt-3 table-responsive">
                <table class="w-100">
                    <tr class="">
                        <td  style="word-wrap: break-word;max-width: 2px;">
                            <p>Dịch vụ: </p>
                        </td>
                        <td style="width:75%">
                            <p class="text-primary">
                                @php
                                echo title_case($service_price->service_price_title);
                                @endphp 
                            </p>
                        </td>
                    </tr>
                    <tr class="">
                        <td>
                            <p>Icon: </p>
                        </td>
                        <td>
                            <p class="text-primary">{{ $service_icon->service_icon_name }}</p>
                        </td>
                    </tr>
                    <tr class="">
                        <td>
                            <p>Giá icon: </p>
                        </td>
                        <td>
                            <p class="text-primary">{{ $service_icon->service_icon_price }}</p>
                        </td>
                    </tr>
                    <tr class="">
                        <td>
                            <p>Giá có vat: </p>
                        </td>
                        <td>
                            <p class="text-primary">{{ $service_icon->service_icon_vat }}</p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-12 col-lg-6">
                @if($errors->any())
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert" style="padding: 5px;margin: 2px;display: inline-block;">
                    <strong>{{ $error }}</strong>
                </div>
                @endforeach
                @endif
                <form
                    action="{{ route('save_order_icon') }}?service={{ $service_price->service_price_id }}&icon={{ $service_icon->service_icon_id }}"
                    method="POST">
                    {{ csrf_field() }}
                    {{-- <input type="text" hidden name="service_order_code"
                        value="DH{{ $service_price->service_price_id }}{{ $service_table_price->service_table_price_id }}"> --}}
                    <input type="text" hidden name="service_price_id" value="{{ $service_price->service_price_id }}">
                    <input type="text" hidden name="service_icon_id"
                        value="{{ $service_icon->service_icon_id }}">
                    @if (Auth::check() && Auth::user()->role!=2)
                    <div class="row pt-3 pb-3">
                        <div class="col-md-6 isset-employer">
                            <div class="form-group">
                                <label for="">Tên nhà tuyển dụng(<span class="text-danger">*</span>)</label>
                                <input type="text" class="form-control ss" name="employer_name"
                                    value="{{ Auth::user()->name }}"  required>
                            </div>
                        </div>
                        <div class="col-md-6 isset-employer">
                            <div class="form-group">
                                <label for="">SĐT nhà tuyển dụng(<span class="text-danger">*</span>)</label>
                                <input type="number" class="form-control" name="employer_phone"
                                    value="{{ Auth::user()->phone }}"  required>
                            </div>
                        </div>
                        <div class="col-md-12 isset-employer">
                            <div class="form-group">
                                <label for="">Email nhà tuyển dụng(<span class="text-danger">*</span>)</label>
                                <input type="email" class="form-control" name="employer_email"
                                    value="{{ Auth::user()->email }}"  required>
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
                        <div class="col-md-6 isset-employer">
                            <div class="form-group">
                                <label for="">Tên nhà tuyển dụng(<span class="text-danger">*</span>)</label>
                                <input type="text" class="form-control ss" name="employer_name"
                                    value="{{ $employer->enterprise_name }}"  required>
                            </div>
                        </div>
                        <div class="col-md-6 isset-employer">
                            <div class="form-group">
                                <label for="">SĐT nhà tuyển dụng(<span class="text-danger">*</span>)</label>
                                <input type="number" class="form-control" name="employer_phone"
                                    value="{{ $employer->phone }}"  required>
                            </div>
                        </div>
                        <div class="col-md-12 isset-employer">
                            <div class="form-group">
                                <label for="">Email nhà tuyển dụng(<span class="text-danger">*</span>)</label>
                                <input type="email" class="form-control" name="employer_email"
                                    value="{{ $employer->email }}"  required>
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
                        <div class="col-md-6 pl-3">
                            <div class="form-group">
                                <label for="">Tên nhà tuyển dụng(<span class="text-danger">*</span>)</label>
                                <input type="text" class="form-control ss" name="employer_name" required>
                            </div>
                        </div>
                        <div class="col-md-6 pl-3">
                            <div class="form-group">
                                <label for="">SĐT nhà tuyển dụng(<span class="text-danger">*</span>)</label>
                                <input type="number" class="form-control" name="employer_phone" required>
                            </div>  
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Email nhà tuyển dụng(<span class="text-danger">*</span>)</label>
                                <input type="email" class="form-control" name="employer_email" required>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Nội dung đơn hàng</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                            name="service_order_icon_content"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success mt-4">Đặt đơn hàng</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>
<script>
    $(function() {
        $('.box_tt_nh .box_tt_bank').addClass('d-none');
        $('.box_tt_nh .box_tt_bank:first-child').removeClass('d-none');
        $data = $('.box_tt_nh .box_tt_bank:first-child').attr('data');
        console.log($data)
        $('#'+$data+' img').css({"background":"#e9eb97"})
        // $('.logo_nh:first-child img').css({"background":"#e9eb97"})
        $('.logo_nh').click(function(){
            $('.logo_nh img').css({"background":"#fff"});
            $id = $(this).attr('id');
            $('#'+$id+' img').css({"background":"#e9eb97"})
            $('.box_tt_nh .box_tt_bank').addClass('d-none');
            $('div[data='+$id+']').removeClass('d-none');
        })

        $('.btn-edit-tt').click(function(){
            $('.isset-employer input').prop('readonly', function () {
                return ! $(this).prop('readonly');
            });
        })
    })
</script>
@endsection