@extends('site.layout.site')

@section('title', 'Danh sách đổi thưởng')
@section('meta_description', 'Danh sách đổi thưởng')
@section('keywords', 'Danh sách đổi thưởng')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">

                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20 mgb10">
                        <ul class="nav">
                            <li class="nav-item pd8">

                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">

                                <a href="{{ route('post_sale_employee') }}" class="f18 md-f14 blueDN hvBlueDN"> <i
                                            class="fas fa-donate mgr5"></i>Kiếm tiền từ chia sẻ bài</a>
                            </li>
                        </ul>
                    </div>
                    @include('site.employee.item_list_redeem')
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">

                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">

                                    <div class="CV bgrWhite radius5 pd20  mgb20 pdb5 mbpd0">

                                        @include('site.employee.item_total_money')

                                        <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb10 mgt0">
                                            Quy đổi số tiền trong tài khoản
                                        </h5>
                                        <div class="row text-center list_change_redeem">
                                            <div class="col-md-4">
                                                <div class="item_change_redeem item_card">
                                                    <a class="hvr-bob" href="{{ route('change_card') }}">
                                                        <p class="mgb10 f18">Quy đổi qua thẻ cào</p>
                                                        <img class="lazy" data-src="{{ asset('assets/image/naptiendt.png') }}">
                                                    </a>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="item_change_redeem item_bank">
                                                    <a class="hvr-bob" href="{{ route('change_account') }}">
                                                        <p class="mgb10 f18">Rút tiền qua tài khoản ngân hàng</p>
                                                        <img class="lazy" data-src="{{ asset('assets/image/chuyentien.png') }}">
                                                    </a>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="item_change_redeem item_bank">
                                                    <a class="hvr-bob" href="{{ route('change_software') }}">
                                                        <p class="mgb10 f18">Quy đổi qua phần mềm du lịch</p>
                                                        <img class="lazy" data-src="{{ asset('assets/image/sp.png') }}">
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">

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
    @include('site.partials.delete')


@endsection
