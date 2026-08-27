@extends('site.layout_site.site')

@section('title', 'Danh sách đơn hàng')
@section('meta_description', 'Danh sách đơn hàng')
@section('keywords', 'Danh sách đơn hàng')


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
                                        <a href="{{ route('list_order_job') }}">Danh sách đơn hàng</a>
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
                                                Danh sách đơn hàng
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


                                        <div class="box_guide">
                                            <p class="mg0 fw6 red">Lưu ý : Để đảm bảo đăng tin tuyển dụng hợp lệ </p>
                                            <p class="mg0 clback">1.Tin tuyển dụng của bạn phải chờ admin duyệt mới xuất
                                                hiện trên website</p>
                                            <p class="mg0 clback">2.Thông tin tài khoản phải được xác thực</p>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="jobfb" class="table table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Mã đơn hàng</th>
                                                    <th>Ngày tạo</th>
                                                    <th>Đơn giá</th>
                                                    <th>Giá khuyến mãi</th>
                                                    <th>Trạng thái thanh toán</th>
                                                    <th>Tin tuyển dụng</th>
                                                    <th>Hồ sơ đã nộp</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($list_order as $id_o=>$order)
                                                    <tr>
                                                        <td>
                                                            {{ $id_o + 1 }}
                                                        </td>
                                                        <td>
                                                            {{ $order['order_job_code'] }}
                                                            <i><a class="f12" href="{{ route('detail_order_job',['order_id'=>$order->order_job_id]) }}">(Xem đơn hàng)</a></i>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $date_create = date_create($order['created_at']);
                                                            echo date_format($date_create, "d/m/Y");
                                                            ?>
                                                        </td>

                                                        <td>
                                                            <span>{{ !empty($order->order_job_price) ? number_format($order->order_job_price) : '' }}  VNĐ</span>
                                                        </td>
                                                        <td>
                                                            <span>{{ !empty($order->order_job_discount) ? number_format($order->order_job_discount) : '' }}  VNĐ</span>
                                                        </td>

                                                        <td>
                                                            @if(!empty($order->order_job_statu_pay))
                                                                <span class="clGreen">Đã thanh toán</span>
                                                                @else
                                                                <span class="clRed">Chưa thanh toán</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a target="_blank"
                                                               href="{{ route('job_detail',['slug' => $order['slug'] ]) }}">{{ $order['title'] }}</a>
                                                        </td>


                                                        <td>
                                                            <?php $total_submit_file = \App\Entity\Employee_submit_job_faacebook::getTotalsubmitJon($order['job_id'], 1)?>

                                                            <a href="{{ route('job_Candidate_Employee',['job_id'=>$order->job_id]) }}"><span
                                                                        class="">
                                                                Xem hồ sơ <sup class="red"> {{ $total_submit_file }} (hồ sơ)</sup>
                                                            </span>
                                                            </a>
                                                        </td>


                                                    </tr>
                                                </tbody>
                                                @endforeach
                                            </table>
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