@extends('site.layout_site.site')

@section('title', '  Đơn hàng đã đăng ký dịch vụ')
@section('meta_description', '  Đơn hàng đã đăng ký dịch vụ')
@section('keywords', '  Đơn hàng đã đăng ký dịch vụ')


@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/intership.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/item_service.css"/>
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
                                    Đơn hàng đã đăng ký dịch vụ
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
                                            @if(!empty($service_order))
                                                @foreach($service_order as $hunter)
                                                    <div class="row item_service">
                                                        <div class="col-md-6 col-6">
                                                            <div class="item_service_left">
                                                                <p class="mgb10">Mã đơn hàng : <strong> {{ !empty($hunter->service_order_code ) ? $hunter->service_order_code  : '' }} </strong></p>
                                                                <?php
                                                                $service_price_title =  \App\Entity\Service_price::where('service_price_id',$hunter->service_price_id)->value('service_price_title');
                                                                $package_name =  \App\Entity\Service_table_price::where('service_table_price_id',$hunter->service_table_price_id)->value('package_name');
                                                                ?>
                                                                <p class="mgb10">Dịch vụ : <strong>{{ !empty($service_price_title) ? $service_price_title : '' }}</strong>
                                                                </p>
                                                                <p class="mgb10">Gói dịch vụ : <strong>{{ !empty($package_name) ? $package_name : '' }}</strong></p>
                                                                <p class="mgb10">Giá dịch vụ: <strong>{{ !empty($hunter->service_order_price) ? $hunter->service_order_price : '' }}</strong></p>
                                                                <p class="mgb10">Chiết khấu: <strong>{{ !empty($hunter->service_order_discount) ? $hunter->service_order_discount : '' }}</strong></p>
                                                                <p class="mgb10">Giá có VAT: <strong>{{ !empty($hunter->service_order_vat) ? $hunter->service_order_vat : '' }}</strong></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <div class="item_service_right">
                                                                <p class="mgb10">Tên nhà tuyển dụng : <strong>{{ !empty($hunter->employer_name) ? $hunter->employer_name : '' }}</strong>
                                                                </p>
                                                                <p class="mgb10">Email : <strong>{{ !empty($hunter->employer_email) ? $hunter->employer_email : '' }}</strong></p>
                                                                <p class="mgb10">Số điện thoại : <strong>{{ !empty($hunter->employer_phone) ? $hunter->employer_phone : '' }}</strong></p>
                                                                <p class="mgb10">Nội dung:</p>
                                                                <p>
                                                                    {!! !empty($hunter->service_order_content) ? $hunter->service_order_content : '' !!}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>

                                        <div class="col-12 text-center">
                                            @include('site.default.item_pani',['page_link' => $service_order])
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



