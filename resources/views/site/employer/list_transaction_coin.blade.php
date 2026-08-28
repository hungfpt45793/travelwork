@extends('site.layout.site')

@section('title', 'Lịch sử giao dịch')
@section('meta_description', 'Lịch sử giao dịch')
@section('keywords', 'Lịch sử giao dịch')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent createProfileOnline ">

                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs f18 white  pd10-20 col-f14">
                            <div class="link bgrWhite md-mgt20 disOnMobile">
                                <ul class="nav">
                                    <li class="nav-item pd8">
                                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang
                                            chủ</a>
                                    </li>
                                    <li class="nav-item pd8">
                                        <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                                    </li>
                                    <li class="nav-item pd8">
                                        <a href="#" class=" f18 md-f14 mgb0">Lịch sử giao dịch</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12 borderTop">

                                    <div class="CV bgrWhite radius5 pd20 mgb20 pdb5">
                                        <div class="title" style="margin-bottom: 10px;">
                                            <h5 class="fw6 f20 bdLeftBlueN5x pdl10 blueN mgb0">
                                                Lịch sử giao dịch
                                            </h5>

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
                                        <a data-toggle="modal" data-target="#create_coin"
                                           class="btnOrange mg10-0 d-sm-inline-block mgb10 bdr3"
                                           style="padding: 5px 15px;">Hướng dẫn nạp điểm <i class="fas fa-coins"></i></a>

                                        @if(!empty($list_transaction_coins))
                                            <table id="jobfb" class="table table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Mã giao dịch</th>
                                                    <th>Số tiền giao dịch</th>
                                                    <th>Số điểm nhận được</th>
                                                    <th>Admin giao dịch</th>
                                                    <th>Ngày giao dich</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($list_transaction_coins as $coin)
                                                    <tr>
                                                        <td>
                                                            {{ $coin->coin_money_id }}
                                                        </td>
                                                        <td>
                                                            {{ !empty($coin->coint_money) ? number_format($coin->coint_money) : 0 }}
                                                            VNĐ
                                                        </td>
                                                        <td>
                                                            {{ !empty($coin->coint) ? number_format($coin->coint) : 0 }}
                                                            điểm
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $user_tran = \App\Entity\User::getUser($coin->user_id);
                                                            ?>
                                                            {{ !empty($user_tran->name) ? $user_tran->name : '' }}
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $date = date_create($coin->created_at);
                                                            echo date_format($date, "d-m-Y  H:i");
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @if(!empty($employer->total_money_coin))
                                                <tr>
                                                    <td colspan="5">
                                                        <span>Tổng số tiền đã giao dịch : </span> <span class="clred"> {{ !empty($employer->total_money_coin) ? number_format($employer->total_money_coin) : 0 }} VNĐ</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        <span>Tổng số điểm nhận được : </span> <span class="clred"> {{ !empty($employer->total_employer_coin) ? number_format($employer->total_employer_coin) : 0 }} điểm</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        <span>Số điểm dùng để xem thông tin ứng viên : </span> <span class="clred"> {{ !empty($sum_coin_info) ? number_format($sum_coin_info) : 0 }} điểm</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        <span>Số điểm dùng để mời ứng viên ứng tuyển : </span> <span class="clred"> {{ !empty($sum_coin_send) ? number_format($sum_coin_send) : 0 }} điểm</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        <span>Số điểm còn lại : </span> <span class="clgreen"> {{ !empty($employer->employer_coin) ? number_format($employer->employer_coin) : 0 }} điểm</span>
                                                    </td>
                                                </tr>
                                                    @endif
                                                </tbody>

                                                {{--<div class="btn-group">--}}
                                                {{--<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="    padding: 2px 10px;">Thao tác--}}
                                                {{--</button>--}}
                                                {{--<div class="dropdown-menu">--}}
                                                {{--<a class="dropdown-item" href="{{ route('update_update_at',['job_id'=>$job['job_id']]) }}" title="Đẩy tin">Đẩy tin <i class="fas fa-external-link-square-alt"></i></a>--}}
                                                {{--<a class="dropdown-item" href="{{ route('job-user.edit',['job_user'=>$job['job_id']]) }}" title="Sửa tin">Sửa tin <i class="far fa-edit clorange"></i></a>--}}
                                                {{--<a class="dropdown-item" href="{{ route('update_stop_job',['job_id'=>$job['job_id']]) }}" title="Tạm dừng" class="clred" style="color: red !important;">Tạm dừng tin <i class="fas fa-stop-circle"></i></a>--}}

                                                {{--</div>--}}
                                                {{--</div>--}}


                                            </table>
                                        @else
                                            <p>Bạn chưa thực hiện giao dich nào</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                @include('site.default.item_pani',['page_link' => $list_transaction_coins])

                                </div>
                            </div>
                        </div>
                    </section>

                    @include('site.module_index.dang-ky-tu-van')

                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>
    <script>
        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });
    </script>
    @include('site.partials.delete')


@endsection
