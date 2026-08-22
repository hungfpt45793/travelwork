@extends('site.layout_site.site')

@section('title', 'Danh sách đổi thưởng')
@section('meta_description', 'Danh sách đổi thưởng')
@section('keywords', 'Danh sách đổi thưởng')

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/money.css"/>
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
                                <a href="{{ route('redeem_rewards') }}">Kiếm tiền đổi thưởng</a>
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
                                <a href="{{ route('redeem_rewards') }}#js_tab_link" class="active"> <i
                                            class="fa fa-check mgr5" aria-hidden="true"></i> Đổi thưởng</a>
                            </li>
                            <li>
                                <a href="{{ route('transaction_history') }}#js_tab_link">Lịch sử</a>
                            </li>
                        </ul>
                    </section>
                    <section class="content_tab_money">
                        <h5 class="pdl10">
                            Quy đổi số tiền trong tài khoản
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
                                   aria-controls="profile" aria-selected="false">Đổi qua phần mềm</a>
                            </li>


                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="content_tab_change pd15">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="pdl10">
                                                Đổi thẻ điện thoại
                                            </h5>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 class="pdl10">
                                                <?php
                                                $money_pay = \App\Transaction\Money_month_pay::get_month_pay(date('m'), date('Y'));
                                                ?>
                                                Lượng tiền còn lại trong tháng {{ date('m') }} trong hệ thống : <span
                                                        class="red">{{ isset($money_pay->money_surplus) ? number_format($money_pay->money_surplus) : 0 }}
                                                        VND
                                                            </span>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 change_left Content">
                                            <h5 class="pdl10"> Lưu ý </h5>
                                            {!! isset($information_money['luu-y-rut-tien-bang-the-dt']) ?$information_money['luu-y-rut-tien-bang-the-dt'] : '' !!}

                                        </div>
                                        <div class="col-lg-6 change_right">
                                            <h5 class="pdl10"> Đổi thẻ điện thoại </h5>
                                            @if($employee_coints->money < 20000)
                                                <p class="clred mgb5">
                                                    Số dư của bạn không đủ điều kiện để đổi thẻ cào !
                                                </p>
                                            @endif
                                            @if(empty($money_pay->money_surplus))
                                                <p class="clred mgb5">
                                                    Lượng tiền còn lại trong tháng đã hết
                                                </p>
                                            @endif


                                            <form method="post" action="{{ route('update_change_card') }}"
                                                  id="submitChange">
                                                {{ csrf_field() }}

                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect2">Tên nhà mạng <span
                                                                class="clred">(*)</span></label>
                                                    <select class="form-control" id="" name="transaction_card_name">
                                                        <option value="Vinaphone"
                                                                @if(isset($transaction_card->transaction_card_name) && $transaction_card->transaction_card_name == 'Vinaphone') selected @endif>
                                                            Vinaphone
                                                        </option>
                                                        <option value="Viettel"
                                                                @if(isset($transaction_card->transaction_card_name) && $transaction_card->transaction_card_name == 'Viettel') selected @endif>
                                                            Viettel
                                                        </option>
                                                        <option value="MobiFone"
                                                                @if(isset($transaction_card->transaction_card_name) && $transaction_card->transaction_card_name == 'MobiFone') selected @endif>
                                                            MobiFone
                                                        </option>
                                                        <option value="Vietnamobile"
                                                                @if(isset($transaction_card->transaction_card_name) && $transaction_card->transaction_card_name == 'Vietnamobile') selected @endif>
                                                            Vietnamobile
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect2">Lựu chọn mệnh giá thẻ<span
                                                                class="clred">(*)</span></label>
                                                    <select class="form-control" id="transaction_card_price"
                                                            name="transaction_card_price">
                                                        {{--<option value="20000" @if(isset($transaction_card->transaction_card_price) && $transaction_card->transaction_card_price == 20000) selected @endif>20.000 VND</option>--}}
                                                        {{--<option value="50000" @if(isset($transaction_card->transaction_card_price) && $transaction_card->transaction_card_price == 50000) selected @endif>50.000 VND</option>--}}
                                                        <option value="100000"
                                                                @if(isset($transaction_card->transaction_card_price) && $transaction_card->transaction_card_price == 100000) selected @endif>
                                                            100.000 VND
                                                        </option>
                                                        <option value="200000"
                                                                @if(isset($transaction_card->transaction_card_price) && $transaction_card->transaction_card_price == 200000) selected @endif>
                                                            200.000 VND
                                                        </option>
                                                        <option value="300000"
                                                                @if(isset($transaction_card->transaction_card_price) && $transaction_card->transaction_card_price == 300000) selected @endif>
                                                            300.000 VND
                                                        </option>
                                                        <option value="500000"
                                                                @if(isset($transaction_card->transaction_card_price) && $transaction_card->transaction_card_price == 500000) selected @endif>
                                                            500.000 VND
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Số điện thoại nạp <span
                                                                class="clred">(*)</span></label>
                                                    <input type="number" class="form-control"
                                                           name="transaction_card_phone"
                                                           placeholder="Số điện thoại nạp" required
                                                           value="{{ isset($transaction_card->transaction_card_phone) ? $transaction_card->transaction_card_phone : '' }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlTextarea1">Ghi chú</label>
                                                    <textarea class="form-control " id="note"
                                                              name="transaction_content"
                                                              rows="3">{{ isset($transaction_card->transaction_content) ? $transaction_card->transaction_content : '' }}</textarea>
                                                </div>
                                                @if($employee_coints->money < 20000 or empty($money_pay->money_surplus))
                                                    <button type="submit" class="btn btnOrang" disabled> Đổi thẻ cào
                                                    </button>
                                                    <p><span class="clRed">Số tiền của bạn không đủ đổi tiền</span></p>
                                                @else
                                                    <button type="submit" class="btn btnOrang"> Đổi thẻ cào
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="content_tab_change pd15">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="pdl10">
                                                Chuyển khoản
                                            </h5>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 class="pdl10">
                                                <?php
                                                $money_pay = \App\Transaction\Money_month_pay::get_month_pay(date('m'), date('Y'));
                                                ?>
                                                Lượng tiền còn lại trong tháng {{ date('m') }} trong hệ thống : <span
                                                        class="red">{{ isset($money_pay->money_surplus) ? number_format($money_pay->money_surplus) : 0 }}
                                                        VND
                                                            </span>
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 change_left Content">
                                            <h5 class="pdl10"> Lưu ý </h5>
                                            {!! isset($information_money['luu-y-chuyen-tien-qua-tai-khoan-ngan-hang']) ?$information_money['luu-y-chuyen-tien-qua-tai-khoan-ngan-hang'] : '' !!}

                                        </div>
                                        <div class="col-lg-6 change_right">
                                            <h5 class="pdl10"> Rút tiền </h5>
                                            @if($employee_coints->money < 20000)
                                                <p class="clred mgb5">
                                                    Số dư của bạn không đủ điều kiện để rút tiền !
                                                </p>
                                            @endif
                                            <form method="post" action="{{ route('update_change_account') }}"
                                                  id="submitChange">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Tên ngân hàng <span
                                                                class="clred">(*)</span></label>
                                                    <input type="text" class="form-control"
                                                           name="transaction_bank_name"
                                                           placeholder="Tên ngân hàng" required
                                                           value="{{ isset($transaction_bank->transaction_bank_name) ? $transaction_bank->transaction_bank_name : '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Số tiền muốn rút<span
                                                                class="clred">(*)</span></label>
                                                    <select class="form-control" id="transaction_bank_price"
                                                            name="transaction_bank_price">
                                                        <option value="100000"
                                                                @if(isset($transaction_bank->transaction_bank_price) && $transaction_bank->transaction_bank_price == 100000) selected @endif>
                                                            100.000 VND
                                                        </option>
                                                        <option value="200000"
                                                                @if(isset($transaction_bank->transaction_bank_price) && $transaction_bank->transaction_bank_price == 200000) selected @endif>
                                                            200.000 VND
                                                        </option>
                                                        <option value="300000"
                                                                @if(isset($transaction_bank->transaction_bank_price) && $transaction_bank->transaction_bank_price == 300000) selected @endif>
                                                            300.000 VND
                                                        </option>
                                                        <option value="500000"
                                                                @if(isset($transaction_bank->transaction_bank_price) && $transaction_bank->transaction_bank_price == 500000) selected @endif>
                                                            500.000 VND
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Số tài khoản<span
                                                                class="clred">(*)</span></label>
                                                    <input type="number" class="form-control"
                                                           name="transaction_bank_number"
                                                           placeholder="Số tài khoản" required
                                                           value="{{ isset($transaction_bank->transaction_bank_number) ? $transaction_bank->transaction_bank_number : '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Tên chủ tài khoản<span
                                                                class="clred">(*)</span></label>
                                                    <input type="text" class="form-control"
                                                           name="transaction_home_name"
                                                           placeholder="Tên chủ tài khoản" required
                                                           value="{{ isset($transaction_bank->transaction_home_name) ? $transaction_bank->transaction_home_name : '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlTextarea1">Ghi chú</label>
                                                    <textarea class="form-control " id="note"
                                                              name="transaction_content"
                                                              rows="3">{{ isset($transaction_bank->transaction_content) ? $transaction_bank->transaction_content : '' }}</textarea>
                                                </div>

                                                @if($employee_coints->money < 20000 or empty($money_pay->money_surplus))
                                                    <button type="submit" class="btn btnOrang" disabled>Chuyển khoản
                                                    </button>
                                                    <p><span class="clRed">Số tiền của bạn không đủ đổi tiền</span></p>
                                                @else
                                                    <button type="submit" class="btn btnOrang"> Chuyển khoản
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="content_tab_change pd15">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="pdl10">
                                                Danh sách phần mềm
                                            </h5>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 class="pdl10">
                                                <?php
                                                $money_pay = \App\Transaction\Money_month_pay::get_month_pay(date('m'), date('Y'));
                                                ?>
                                                Lượng tiền còn lại trong tháng {{ date('m') }} trong hệ thống : <span
                                                        class="red">{{ isset($money_pay->money_surplus) ? number_format($money_pay->money_surplus) : 0 }}
                                                        VND
                                                            </span>
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            @if(!empty($list_products))
                                                <div class="row chang_list_product">
                                                    @foreach($list_products as $product)
                                                        <div class="col-xl-4 col-md-6 minxl20">
                                                            <div class="item_list_product">
                                                                <a class="dsBlock pd5"
                                                                   href="{{ $product->product_link }}">
                                                                    <div class="CropImg CropImg60">
                                                                        <div class="thumbs">
                                                                            <img src="{{ asset($product->product_image) }}">
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <div class="title_product js_maxHeight">
                                                                    <a href="{{ $product->product_link }}">
                                                                        <h3 class="f16 mgt5 fw6 cutTitle2">{{ isset($product->product_name) ? $product->product_name : '' }}</h3>
                                                                    </a>
                                                                    <p class="f16 text-center">
                                                                        @if(!empty($product->product_discount))

                                                                            <span class="price_discount">{{ isset($product->product_discount) ? number_format($product->product_discount) : '' }} vnđ</span>
                                                                        @else
                                                                            <span class="price_discount">{{ isset($product->product_price) ? number_format($product->product_price) : '' }} vnđ</span>
                                                                        @endif


                                                                    </p>

                                                                </div>

                                                            </div>
                                                        </div>



                                                    @endforeach


                                                </div>
                                            @endif

                                            <div class="col-12 text-center">
                                                {{$list_products->links()}}
                                            </div>
                                        </div>

                                        <div class="col-lg-6 change_right">
                                            <h5 class="pdl10"> Đổi phần mềm </h5>
                                            @if(empty($employee_coints->money))
                                                <p class="clRed mgb5">
                                                    Số dư của bạn không đủ để đổi phần mềm này !
                                                </p>
                                            @endif
                                            <form method="post" action="{{ route('update_change_software') }}"
                                                  id="submitChange">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Tên phần mềm <span
                                                                class="clred">(*)</span></label>

                                                    <select class="select2" name="product_id">
                                                        @foreach($list_products as $product)
                                                            <?php
                                                                $product_price = $product->product_price
                                                            ?>
                                                        @if(!empty($product->product_discount))
                                                                    <?php
                                                                    $product_price = $product->product_discount
                                                                    ?>
                                                            @endif
                                                        <option value="{{ $product->product_id }}">{{ isset($product->product_name) ? $product->product_name : '' }} - {{ !empty($product_price) ? number_format($product_price) : 0}} VNĐ</option>
                                                            @endforeach

                                                    </select>
                                                </div>


                                                <div class="form-group">
                                                    <label for="exampleFormControlTextarea1">Ghi chú</label>
                                                    <textarea class="form-control " id="note"
                                                              name="transaction_content"
                                                              rows="3"></textarea>
                                                </div>

                                                <button type="submit" class="btn btnOrang">
                                                       Đổi phần mềm
                                                </button>

                                            </form>
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
    @include('site.money_site.video')
@endsection

@section('show_js')
    @include('site.layout_site.from')
@endsection
