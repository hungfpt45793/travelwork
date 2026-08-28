@extends('site.layout_site.site')

@section('title', 'Chi tiết đơn hàng')
@section('meta_description', 'Chi tiết đơn hàng')
@section('keywords', 'Chi tiết đơn hàng')


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
                                        <a href="{{ route('list_order_job') }}">Chi tiết đơn hàng</a>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        <div class="list_job_employer">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12 borderTop">

                                    <div class="CV bgrWhite radius5 pd20 mgb20 pdb5">
                                        <hr class="mgt10 mgb10">
                                        <div class="title">
                                            <h1 class="">
                                                Chi tiết đơn hàng : {{ !empty($order_job->order_job_code) ? $order_job->order_job_code : '' }}
                                            </h1>

                                        </div>
                                        <div>
                                            @if(session('suscess'))
                                                <div class="alert alert-success alert-dismissible fade show"
                                                     role="alert"
                                                     style="margin-top: 15px;width: 100%">
                                                    <strong>{{ session('suscess') }}</strong>
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            @if(session('erorr'))
                                                <div class="alert alert-warning alert-dismissible fade show"
                                                     role="alert"
                                                     style="margin-top: 15px;width: 100%">
                                                    <strong>{{ session('erorr') }}</strong>
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        <hr class="mgt10 mgb10">

                                        <div class="row detail_show_order">
                                            <div class="col-md-12 f16">
                                                <h3 class="text-center title_order">Thông tin đơn hàng</h3>
                                                <div class="form-group row">
                                                    <div class="col-md-12 col-12">
                                                        <label for=""><b> Tin tuyển dụng : </b></label>
                                                        @if(!empty($order_job->slug))
                                                        <a href="{{ route('job_detail',['slug'=>$order_job->slug]) }}">
                                                            {{ !empty($order_job->title) ? $order_job->title : '' }}
                                                        </a>
                                                            @else
                                                            <span>Chưa tạo</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <label for=""><b> Giá trị đơn hàng : </b></label>
                                                       <span>{{ !empty($order_job->order_job_price) ? number_format($order_job->order_job_price) : '' }} VNĐ</span>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <label for=""><b> Giá trị đơn hàng(đã giảm) : </b></label>
                                                        <span>{{ !empty($order_job->order_job_discount) ? number_format($order_job->order_job_discount) : '' }} VNĐ</span>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <label for=""><b> Thời gian bảo hành : </b></label>
                                                        <span>{{ !empty($order_job->order_job_guarantee) ? number_format($order_job->order_job_guarantee) : '' }} ngày</span>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <label for=""><b>Ngày kích hoạt bảo hành : </b></label>
                                                        @if(!empty($order_job->order_job_guarantee_date))
                                                            <span class="f16 clGreen"><?php
                                                            if(isset($order_job->order_job_guarantee_date)){
                                                                $date_end=date_create($order_job->order_job_guarantee_date);
                                                                echo date_format($date_end,"Y-m-d");
                                                            }
                                                            ?></span>
                                                            @else
                                                            <span class="f16 clRed">Chưa kích hoạt</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <label for=""><b> Mô tả đơn hàng : </b></label>
                                                        @if(!empty($order_job->order_job_des))
                                                        <div>{!! !empty($order_job->order_job_des) ? $order_job->order_job_des : '' !!}</div>
                                                            @else
                                                            <span>Đang cập nhật</span>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-12 detail_show_file">
                                                <h3 class="text-center title_order">Hợp đồng đơn hàng</h3>
                                                @if(!empty($order_job->file_upload_contract))
                                                <iframe src="https://docs.google.com/gview?url={{ asset($order_job->file_upload_contract)}}&embedded=true"
                                                        frameborder="0"></iframe>
                                                    @else
                                                    <p>Đang cập nhật</p>
                                                @endif
                                            </div>
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


@endsection