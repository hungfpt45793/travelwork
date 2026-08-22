@extends('site.layout.site')

@section('title', 'Kiếm tiền từ chia sẻ tài liệu')
@section('meta_description', 'Kiếm tiền từ chia sẻ tài liệu')
@section('keywords', 'Kiếm tiền từ chia sẻ tài liệu')

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

                                    <div class="CV bgrWhite radius5 pd20  mgb30 pdb5 mbpd0">

                                        @include('site.employee.item_total_money')

                                        <div class="title mgb20">
                                            <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb0">
                                                Bảng tổng hợp thống kê chia sẻ tài liệu
                                            </h5>
                                        </div>

                                        @if(!empty($list_voucher))
                                            <table id="jobfb" class="table table-hover table-bordered mbdsNone">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">STT</th>
                                                    <th>Tên tài liệu</th>
                                                    <th class="text-center">Link tài liệu</th>
                                                    <th class="text-center">Số lần chia sẻ</th>
                                                    <th class="text-center">Số lượt xem</th>
                                                    <th class="text-center">Thành tiền</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                                <?php $total = 0;
                                                $total_money = 0;
                                                ?>
                                                @foreach($list_voucher as $id_stt=>$voucher)

                                                    <tr>
                                                        <td class="text-center">{{ $id_stt + 1 }}</td>
                                                        <td>
                                                            {{ !empty($voucher->name_voucher) ? $voucher->name_voucher : '' }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if(!empty($voucher->slug_voucher ))
                                                                <a href="{{ route('getVoucher',['slug_voucher'=>$voucher->slug_voucher]) }}"
                                                                   target="_blank">Link
                                                                    tài liệu</a></td>
                                                        @endif
                                                        <td class="text-center">{{ !empty($voucher->total_share) ? $voucher->total_share : '' }}</td>
                                                        <td class="text-center">
                                                            @if(!empty($voucher->total_view_sale)){{ number_format($voucher->total_view_sale) }}
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if(!empty($voucher->total_money_view))
                                                                {{ number_format($voucher->total_money_view) }} VND
                                                            @endif

                                                        </td>
                                                    </tr>

                                                @endforeach

                                                <tr>
                                                    <td colspan="2" class="text-center">
                                                        <p class="f20 fw6 mgb0">
                                                            Tổng số chia sẻ : {{ !empty($employee_coint->total_sale_voucher) ?number_format($employee_coint->total_sale_voucher) : '' }} lượt
                                                        </p>
                                                    </td>
                                                    <td colspan="2" class="text-center">
                                                        <p class="f20 fw6 mgb0">
                                                            Tổng số lượt xem : {{ !empty($employee_coint->total_view_voucher) ? number_format($employee_coint->total_view_voucher) : '' }} lượt
                                                        </p>
                                                    </td>
                                                    <td colspan="3" class="text-center">
                                                        <p class="f20 fw6 mgb0">
                                                            <?php
                                                            $total_money_voucher = \App\Entity\Voucher_sale_statistical::Employee_TotalMoney($employee_coint->employee_id)
                                                            ?>
                                                            Tổng tiền : {{ !empty($total_money_voucher) ? number_format($total_money_voucher) : '' }} VND
                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>


                                            <table id="jobfb" class="table table-hover table-bordered dsNone mbdsBlock">
                                                <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Thông tin</th>
                                                    {{--<th>Mã bài viết</th>--}}
                                                    {{--<th>Tiêu đề bài viết</th>--}}
                                                    {{--<th>Link bài viết</th>--}}
                                                    {{--<th>Số lần chia sẻ</th>--}}
                                                    {{--<th>Số lượt xem</th>--}}
                                                    {{--<th>Thành tiền</th>--}}
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                                <?php $total = 0;
                                                $total_money = 0;
                                                ?>
                                                @foreach($list_voucher as $id_stt=>$voucher)
                                                    <tr>
                                                        <td>{{ $id_stt + 1 }}</td>
                                                        <td>
                                                            <p class="mgb5 fw6">  <a href="{{ route('getVoucher',['slug_voucher'=>$voucher->slug_voucher]) }}" target="_blank"> {{ !empty($voucher->name_voucher) ? $voucher->name_voucher : '' }}</a></p>
                                                            <p class="mgb0">Số lần chia sẻ : {{ $voucher->total_share }}</p>
                                                            <p class="mgb0">Số lượt xem : {{ number_format($voucher->total_view_sale) }}</p>
                                                            <p class="mgb0 clred">Thành tiền : {{ number_format($voucher->total_money_view) }} vnđ</p>
                                                    </tr>

                                                @endforeach
                                                <tr>
                                                    <td colspan="2" class="text-left">
                                                        <p class="f20 fw6 mgb0">
                                                            Tổng số chia sẻ : {{ !empty($employee_coint->total_sale_voucher) ?number_format($employee_coint->total_sale_voucher) : '' }} lượt
                                                        </p>
                                                        <p class="f20 fw6 mgb0">
                                                            Tổng số lượt xem : {{ !empty($employee_coint->total_view_voucher) ? number_format($employee_coint->total_view_voucher) : '' }} lượt
                                                        </p>
                                                        <p class="f20 fw6 mgb0">
                                                            Tổng tiền : {{ !empty($total_money_voucher) ? number_format($total_money_voucher) : '' }} VND
                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        @endif




                                    </div>
                                    <div class="row pagePostSale">
                                        <div class="col-12 text-center">
                                            @include('site.default.item_pani',['page_link' => $list_voucher])
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

    @include('site.partials.delete')


@endsection