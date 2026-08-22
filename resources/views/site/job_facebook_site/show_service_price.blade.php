@extends('site.layout_site.site')

@section('title', '  Đơn hàng đã đăng ký tuyển hộ')
@section('meta_description', '  Đơn hàng đã đăng ký tuyển hộ')
@section('keywords', '  Đơn hàng đã đăng ký tuyển hộ')


@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/intership.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/item_service.css"/>
@endsection

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar_site.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 employer_show_intership">
                    @if(\Illuminate\Support\Facades\Auth::check()  && (\Illuminate\Support\Facades\Auth::user()->role) == 2)
                        <div class="from_employer_show_intership">
                            <div class="title_show_intership">
                                <h1 class="">
                                    Nhà tuyển dụng đăng ký thuê tuyển dụng hộ
                                </h1>
                            </div>

                            <div class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if(session('suscess'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert"
                                                 style="margin-top: 15px;width: 100%">
                                                <strong>{{ session('suscess') }}</strong>
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        @if(session('erorr'))
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert"
                                                 style="margin-top: 15px;width: 100%">
                                                <strong>{{ session('erorr') }}</strong>
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
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
                                            @if(!empty($hunter_registration))
                                                @foreach($hunter_registration as $hunter)
                                                    <div class="row item_service">
                                                        <div class="col-md-6 col-6">
                                                            <div class="item_service_left">
                                                                <p class="mgb10">Mã đơn hàng : <strong> {{ !empty($hunter->hunter_regis_code) ? $hunter->hunter_regis_code : '' }} </strong></p>
                                                                <?php
                                                                $hunter_price = \App\Entity\Hunter_price::get_hunter_price($hunter->hunter_regis_price);
                                                                ?>
                                                                <p class="mgb10">Vị trí cần tuyển : <strong>{{ !empty($hunter_price->hunter_pos_name) ? $hunter_price->hunter_pos_name : '' }}</strong>
                                                                </p>
                                                                <p class="mgb10">Thời gian tuyển : <strong>{{ !empty($hunter_price->hunter_time_name) ? $hunter_price->hunter_time_name : '' }}</strong></p>
                                                                <p class="mgb10">Chi phí: <strong>{{ !empty($hunter_price->hunter_price_name) ? $hunter_price->hunter_price_name : '' }}</strong></p>
                                                                <p class="mgb10">Trạng thái: <strong>
                                                                        @if(empty($hunter->hunter_regis_name))
                                                                            Chưa chuyển tiền
                                                                            @else
                                                                            Đã chuyển tiền
                                                                        @endif
                                                                    </strong></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <div class="item_service_right">
                                                                <p class="mgb10">Tên nhà tuyển dụng : <strong>{{ !empty($hunter->hunter_regis_name) ? $hunter->hunter_regis_name : '' }}</strong>
                                                                </p>
                                                                <p class="mgb10">Email : <strong>{{ !empty($hunter->hunter_regis_email) ? $hunter->hunter_regis_email : '' }}</strong></p>
                                                                <p class="mgb10">Số điện thoại : <strong>{{ !empty($hunter->hunter_regis_phone) ? $hunter->hunter_regis_phone : '' }}</strong></p>
                                                                <p class="mgb10">Địa chỉ: <strong>{{ !empty($hunter->hunter_regis_address) ? $hunter->hunter_regis_address : '' }}</strong></p>
                                                                <p class="mgb10">Nội dung: <strong>{{ !empty($hunter->hunter_regis_note) ? $hunter->hunter_regis_note : '' }}</strong></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>

                                        <div class="col-12 text-center">
                                            @include('site.default.item_pani',['page_link' => $hunter_registration])
                                            {{--{{ $jobs->links() }}--}}
                                        </div>


                                    </div>


                                </div>
                            </div>
                        </div>
                    @else


                    @endif


                </div>
            </div>
        </div>
    </section>

@endsection



