@extends('site.layout_site.site')

@section('title', 'Lịch sử giao dịch')
@section('meta_description', 'Lịch sử giao dịch')
@section('keywords', 'Lịch sử giao dịch')

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/web/css/money.css"/>
@endsection

@section('content')
    <section class="content_money">
        <div class="container container_w_1200">
            <div class="row ">

                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="link_breakcrum mbdsNone pd0" style="padding-left: 0px">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('transaction_history') }}">Lịch sử giao dịch</a>
                            </li>
                        </ul>
                    </div>

                    {{--@include('site.employee.item_list_redeem')--}}
                    @include('site.employee.item_total_money')


                    <section class="tab_link" id="js_tab_link">
                        <ul>
                            <li>
                                <a href="{{ route('list_post') }}#js_tab_link"> Bài viết</a>
                            </li>
                            <li>
                                <a href="{{ route('list_course') }}#js_tab_link">Khóa học</a>
                            </li>
                            <li>
                                <a href="{{ route('list_voucher') }}#js_tab_link">Tài liệu</a>
                            </li>
                            <li>
                                <a href="{{ route('list_job') }}#js_tab_link"> Tin tuyển dụng</a>
                            </li>
                            <li>
                                <a href="{{ route('list_intership') }}#js_tab_link">Tin thực tập</a>
                            </li>
                            <li>
                                <a href="{{ route('redeem_rewards') }}#js_tab_link"> Đổi thưởng</a>
                            </li>
                            <li>
                                <a href="{{ route('transaction_history') }}#js_tab_link" class="active"> <i
                                            class="fa fa-check mgr5" aria-hidden="true"></i> Lịch sử</a>
                            </li>
                        </ul>
                    </section>
                    <section class="content_tab_money">
                        <h5 class="pdl10">
                            Lịch sử giao dịch
                        </h5>

                        <div>
                            @if (session('success'))
                                <div class="alert alert-success text-center" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger text-center" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                   aria-controls="home" aria-selected="true">Đổi qua thẻ cào</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                   aria-controls="profile" aria-selected="false">Rút tiền qua tài khoản ngân hàng</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile2" role="tab"
                                   aria-controls="profile2" aria-selected="false">Đổi phần mềm</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="content_tab_change pd15">
                                    <h5 class="pdl10">
                                        Lịch sử đổi thẻ
                                    </h5>
                                    @if(!empty($transaction_history_card))
                                        <div class="table-responsive">
                                            <table id="jobfb"
                                                   class="table table-hover text-center table-bordered mbdsNone">
                                                <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Tên nhà mạng</th>
                                                    <th>Giá trị tiền nạp </th>
                                                    <th>Số điện thoại được nạp</th>
                                                    <th>Ghi chú</th>
                                                    <th>Trạng thái</th>
                                                    <th>Ngày đổi thẻ</th>
                                                    <th>Admin trả lời</th>
                                                    <th>Ngày duyệt</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                                @foreach($transaction_history_card as $id_tran=>$transaction_history)
                                                    <tr>
                                                        <td>{{ $id_tran + 1 }}</td>
                                                        <td>{{ $transaction_history->transaction_card_name }}</td>
                                                        <td>{{ number_format($transaction_history->transaction_card_price) }}
                                                            VND - {{ number_format($transaction_history->transaction_total_coin) }} xu
                                                        </td>
                                                        <td>{{ $transaction_history->transaction_card_phone }}</td>

                                                        <td>{{ $transaction_history->transaction_content }}</td>
                                                        <td>
                                                            @if($transaction_history->transaction_status == 0)
                                                                <span class="btnOrang">Chưa duyệt </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 1)
                                                                <span class="btnRed">Hủy giao dịch </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 2)
                                                                <span class="btnGreen dsInline"
                                                                      style="padding: 3px 10px;">Đã duyệt </span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <p class="mgb0"><i class="far fa-clock"></i> <?php
                                                                $date = date_create($transaction_history->created_at);
                                                                echo date_format($date, "H:i:s");
                                                                ?></p>
                                                            <p class="mgb0"><i class="far fa-calendar-times"></i> <?php
                                                                echo date_format($date, "d/m/Y");
                                                                ?></p>

                                                        </td>
                                                        <td>
                                                            @if(!empty($transaction_history->transaction_admin_reply))
                                                                <span class="btnGreen dsInline"
                                                                      style="padding: 3px 10px;" data-toggle="modal"
                                                                      data-target="#transaction_card{{$id_tran}}">Xem nội dung </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($transaction_history->updated_at))
                                                                <p class="mgb0"><i class="far fa-clock"></i> <?php
                                                                    $date = date_create($transaction_history->updated_at);
                                                                    echo date_format($date, "H:i:s");
                                                                    ?></p>
                                                                <p class="mgb0"><i
                                                                            class="far fa-calendar-times"></i> <?php
                                                                    echo date_format($date, "d/m/Y");
                                                                    ?></p>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    @endif
                                </div>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="content_tab_change pd15">
                                    <h5 class="pdl10">
                                        Lịch sử chuyển khoản
                                    </h5>
                                    @if(!empty($transaction_history_bank))
                                        <div class="table-responsive">
                                            <table id="jobfb" class="table table-hover text-center table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Tên ngân hàng</th>
                                                    <th>Số tiền chuyển khoản</th>
                                                    <th>Số tài khoản</th>
                                                    <th>Tên chủ tài khoản</th>
                                                    <th>Ghi chú</th>
                                                    <th>Trạng thái</th>

                                                    <th>Ngày đổi thẻ</th>
                                                    <th>Admin trả lời</th>
                                                    <th>Ngày duyệt</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                                @foreach($transaction_history_bank as $id_tran=>$transaction_history)
                                                    <tr>
                                                        <td>{{ $id_tran + 1 }}</td>
                                                        <td>{{ $transaction_history->transaction_bank_name }}</td>
                                                        <td>{{ number_format($transaction_history->transaction_bank_price) }}
                                                            VND - {{ number_format($transaction_history->transaction_total_coin) }} xu
                                                        </td>
                                                        <td>{{ $transaction_history->transaction_bank_number }}</td>
                                                        <td>{{ $transaction_history->transaction_home_name }}</td>
                                                        <td>{{ $transaction_history->transaction_content }}</td>
                                                        <td>
                                                            @if($transaction_history->transaction_status == 0)
                                                                <span class="btnOrang">Chưa duyệt </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 1)
                                                                <span class="btnRed">Hủy giao dịch </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 2)
                                                                <span class="btnGreen dsInline"
                                                                      style="padding: 3px 10px;">Đã duyệt </span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <p class="mgb0"><i class="far fa-clock"></i> <?php
                                                                $date = date_create($transaction_history->created_at);
                                                                echo date_format($date, "H:i:s");
                                                                ?></p>
                                                            <p class="mgb0"><i class="far fa-calendar-times"></i> <?php
                                                                echo date_format($date, "d/m/Y");
                                                                ?></p>

                                                        </td>
                                                        <td>
                                                            @if(!empty($transaction_history->transaction_admin_reply))
                                                                <span class="btnGreen dsInline"
                                                                      style="padding: 3px 10px;" data-toggle="modal"
                                                                      data-target="#transaction_bank{{$id_tran}}">Xem nội dung </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($transaction_history->updated_at))
                                                                <p class="mgb0"><i class="far fa-clock"></i> <?php
                                                                    $date = date_create($transaction_history->updated_at);
                                                                    echo date_format($date, "H:i:s");
                                                                    ?></p>
                                                                <p class="mgb0"><i
                                                                            class="far fa-calendar-times"></i> <?php
                                                                    echo date_format($date, "d/m/Y");
                                                                    ?></p>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="content_tab_change pd15">
                                    <h5 class="pdl10">
                                        Đổi phần mềm
                                    </h5>
                                    @if(!empty($transaction_history_product))
                                        <div class="table-responsive">
                                            <table id="jobfb" class="table table-hover table-bordered text-center">
                                                <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Tên phần mềm</th>
                                                    <th>Giá thị trường</th>
                                                    <th>Giá đổi phần mềm</th>
                                                    <th>Link chi tiết</th>
                                                    <th>Ghi chú</th>
                                                    <th>Trạng thái</th>
                                                    <th>Ngày đổi thẻ</th>
                                                    <th>Admin trả lời</th>
                                                    <th>Ngày duyệt</th>
                                                </tr>
                                                </thead>
                                                <tbody>


                                                {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                                @foreach($transaction_history_product as $id_tran=>$transaction_history)

                                                    <tr>
                                                        <td>{{ $id_tran + 1 }}</td>
                                                        <td class="text-left">{{ $transaction_history->transaction_product_name }}</td>
                                                        <?php $product_link = \App\Transaction\List_product::get_product_id($transaction_history->transaction_product_id)?>

                                                        <td>
                                                            {{ number_format($product_link->product_price) }}
                                                        </td>

                                                        <td>{{ number_format($transaction_history->transaction_product_price) }}</td>

                                                        <td>
                                                            <a href="{{ $product_link->product_link }}">Xem chi tiết</a>
                                                        </td>
                                                        <td>{{ $transaction_history->transaction_content }}</td>
                                                        <td>
                                                            @if($transaction_history->transaction_status == 0)
                                                                <span class="btnOrang">Chưa duyệt </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 1)
                                                                <span class="btnRed">Hủy giao dịch </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 2)
                                                                <span class="btnGreen dsInline"
                                                                      style="padding: 3px 10px;">Đã duyệt </span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <p class="mgb0"><i class="far fa-clock"></i> <?php
                                                                $date = date_create($transaction_history->created_at);
                                                                echo date_format($date, "H:i:s");
                                                                ?></p>
                                                            <p class="mgb0"><i class="far fa-calendar-times"></i> <?php
                                                                echo date_format($date, "d/m/Y");
                                                                ?></p>

                                                        </td>
                                                        <td> @if(!empty($transaction_history->transaction_admin_reply))
                                                                <span class="btnGreen dsInline"
                                                                      style="padding: 3px 10px;" data-toggle="modal"
                                                                      data-target="#transaction_product{{$id_tran}}">Xem nội dung </span>
                                                            @endif</td>
                                                        <td>
                                                            @if(!empty($transaction_history->updated_at))
                                                                <p class="mgb0"><i class="far fa-clock"></i> <?php
                                                                    $date = date_create($transaction_history->created_at);
                                                                    echo date_format($date, "H:i:s");
                                                                    ?></p>
                                                                <p class="mgb0"><i
                                                                            class="far fa-calendar-times"></i> <?php
                                                                    echo date_format($date, "d/m/Y");
                                                                    ?></p>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    @endif
                                </div>
                            </div>

                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    @include('site.money_site.video')
@endsection

@section('show_js')
    @include('site.layout_site.from')

@endsection
