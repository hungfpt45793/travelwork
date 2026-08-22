@extends('site.layout.site')

@section('title', 'Chuyển khoản')
@section('meta_description', 'Chuyển khoản')
@section('keywords', 'Chuyển khoản')

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

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb10 mgt0">
                                                   Chuyển khoản
                                                </h5>
                                            </div>
                                            <div class="col-lg-6">
                                                <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb10 mgt0">
                                                    <?php
                                                    $money_pay = \App\Transaction\Money_month_pay::get_month_pay(date('m'),date('Y'));
                                                    ?>
                                                    Lượng tiền còn lại trong tháng {{ date('m') }} trong hệ thống : <span class="red">{{ isset($money_pay->money_surplus) ? number_format($money_pay->money_surplus) : 0 }}
                                                        VND
                                                            </span>
                                                </h5>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 change_left Content">
                                                <h5 class="clred mgt15"> Lưu ý </h5>
                                               {!! isset($information_money['luu-y-chuyen-tien-qua-tai-khoan-ngan-hang']) ?$information_money['luu-y-chuyen-tien-qua-tai-khoan-ngan-hang'] : '' !!}

                                            </div>
                                            <div class="col-lg-6 change_right">
                                                <h5 class="mgt15"> Rút tiền </h5>
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
                                                               placeholder="Tên ngân hàng" required value="{{ isset($transaction_bank->transaction_bank_name) ? $transaction_bank->transaction_bank_name : '' }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Số tiền muốn rút<span
                                                                    class="clred">(*)</span></label>
                                                        <select  class="form-control" id="transaction_bank_price" name="transaction_bank_price">
                                                            <option value="100000" @if(isset($transaction_bank->transaction_bank_price) && $transaction_bank->transaction_bank_price == 100000) selected @endif>100.000 VND</option>
                                                            <option value="200000" @if(isset($transaction_bank->transaction_bank_price) && $transaction_bank->transaction_bank_price == 200000) selected @endif>200.000 VND</option>
                                                            <option value="300000" @if(isset($transaction_bank->transaction_bank_price) && $transaction_bank->transaction_bank_price == 300000) selected @endif>300.000 VND</option>
                                                            <option value="500000" @if(isset($transaction_bank->transaction_bank_price) && $transaction_bank->transaction_bank_price == 500000) selected @endif>500.000 VND</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Số tài khoản<span
                                                                    class="clred">(*)</span></label>
                                                        <input type="number" class="form-control"
                                                               name="transaction_bank_number"
                                                               placeholder="Số tài khoản" required value="{{ isset($transaction_bank->transaction_bank_number) ? $transaction_bank->transaction_bank_number : '' }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Tên chủ tài khoản<span
                                                                    class="clred">(*)</span></label>
                                                        <input type="text" class="form-control"
                                                               name="transaction_home_name"
                                                               placeholder="Tên chủ tài khoản" required value="{{ isset($transaction_bank->transaction_home_name) ? $transaction_bank->transaction_home_name : '' }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleFormControlTextarea1">Ghi chú</label>
                                                        <textarea class="form-control " id="note"
                                                                  name="transaction_content"
                                                                  rows="3">{{ isset($transaction_bank->transaction_content) ? $transaction_bank->transaction_content : '' }}</textarea>
                                                    </div>
                                                    <button type="submit" class="btn btnOrang"
                                                            @if($employee_coints->money < 20000) disabled @endif>Chuyển khoản
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb10 mgt10">
                                        Lịch sử đổi thẻ
                                    </h5>
                                    @if(!empty($transaction_history_bank))
                                        <table id="jobfb" class="table table-hover text-center table-bordered mbdsNone">
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
                                                    <td>{{ number_format($transaction_history->transaction_bank_price) }} VND</td>
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
                                                            <span class="btnGreen dsInline" style="padding: 3px 10px;">Đã duyệt </span>
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
                                                            <span class="btnGreen dsInline" style="padding: 3px 10px;" data-toggle="modal" data-target="#transaction_bank{{$id_tran}}">Xem nội dung </span>
                                                        @endif</td>
                                                    <td>
                                                        @if(!empty($transaction_history->updated_at))
                                                            <p class="mgb0"><i class="far fa-clock"></i> <?php
                                                                $date = date_create($transaction_history->created_at);
                                                                echo date_format($date, "H:i:s");
                                                                ?></p>
                                                            <p class="mgb0"><i class="far fa-calendar-times"></i> <?php
                                                                echo date_format($date, "d/m/Y");
                                                                ?></p>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                        <table id="jobfb" class="table table-hover table-bordered dsNone mbdsBlock">
                                            <thead>
                                            <tr>
                                                <th>STT</th>
                                                {{--<th>Tên ngân hàng</th>--}}
                                                {{--<th>Số tiền chuyển khoản</th>--}}
                                                {{--<th>Số tài khoản</th>--}}
                                                {{--<th>Tên chủ tài khoản</th>--}}
                                                {{--<th>Ghi chú</th>--}}
                                                {{--<th>Trạng thái</th>--}}

                                                {{--<th>Ngày đổi thẻ</th>--}}
                                                {{--<th>Admin trả lời</th>--}}
                                                {{--<th>Ngày duyệt</th>--}}
                                                <th class="w100impotar"> Thông tin chuyển khoản </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                            @foreach($transaction_history_bank as $id_tran=>$transaction_history)
                                                <tr>
                                                    <td>
                                                        {{ $id_tran + 1 }}
                                                    </td>
                                                    <td>
                                                        <p class="mgb5">Tên ngân hàng : {{ $transaction_history->transaction_bank_name }} </p>
                                                        <p class="mgb5">Số tiền chuyển khoản : {{ number_format($transaction_history->transaction_bank_price) }} VND</p>
                                                        <p class="mgb5">Số tài khoản : {{ $transaction_history->transaction_bank_number }} </p>
                                                        <p class="mgb5">Tên chủ tài khoản : {{ $transaction_history->transaction_home_name }} </p>
                                                        <p class="mgb5">Ghi chú : {{ $transaction_history->transaction_content }} </p>
                                                        <p class="mgb5">Trạng thái :
                                                            @if($transaction_history->transaction_status == 0)
                                                                <span class="btnOrang">Chưa duyệt </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 1)
                                                                <span class="btnRed">Hủy giao dịch </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 2)
                                                                <span class="btnGreen dsInline" style="padding: 3px 10px;">Đã duyệt </span>
                                                            @endif
                                                        </p>
                                                        <p class="mgb5">Ngày đổi thẻ : <i class="far fa-clock"></i> <?php
                                                            $date = date_create($transaction_history->created_at);
                                                            echo date_format($date, "H:i:s");
                                                            ?>

                                                            <i class="far fa-calendar-times"></i> <?php
                                                            echo date_format($date, "d/m/Y");
                                                            ?>
                                                        </p>
                                                        <p class="mgb5">Admin trả lời :  @if(!empty($transaction_history->transaction_admin_reply))
                                                                <span class="btnGreen dsInline" style="padding: 3px 10px;" data-toggle="modal" data-target="#transaction_bank{{$id_tran}}">Xem nội dung </span>
                                                            @endif </p>
                                                        @if(!empty($transaction_history->updated_at))
                                                        <p class="mgb5">Ngày duyệt :
                                                            <i class="far fa-clock"></i> <?php
                                                            $date = date_create($transaction_history->created_at);
                                                            echo date_format($date, "H:i:s");
                                                            ?>

                                                            <i class="far fa-calendar-times"></i> <?php
                                                            echo date_format($date, "d/m/Y");
                                                            ?>
                                                        </p>
                                                            @endif

                                                    </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>


                                    @endif

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

    @if(!empty($transaction_history_bank))
        @foreach($transaction_history_bank as $id_tran=>$transaction_history)
            <div class="modal fade bd-example-modal-lg" id="transaction_bank{{$id_tran}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Xem nội dung chuyển khoản</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {!! isset($transaction_history->transaction_admin_reply) ? $transaction_history->transaction_admin_reply  : ''!!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary"  data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif


    <script src="{{ asset('adminstration/jquery.priceformat.js') }}"></script>
    <script>
        $('.formatPrice').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.'
        });
    </script>
    <script>
        $('#submitChange').submit(function () {
            // var card = ;
            var string = $('#transaction_bank_price').val();
            card_number = string.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');
            var money = {{ $employee_coints->money }};
            var phone = $('#phone').val();

            var max_money_month = {{ isset($information_money['so-tien-rut-toi-da-trong-1-thang']) ? $information_money['so-tien-rut-toi-da-trong-1-thang'] : 300000 }}


            if (money < card_number && card_number > max_money_month) {
                $('#message').modal('show');
                $('.contentMessage').html('Số dư của bạn không đủ để thực hiện giao dịch này !')
                console.log(money);
                return false;
            }
            // lượng tiền trong hệ thống
            var max_money = {{ isset($money_pay->money_surplus) ? $money_pay->money_surplus : 0 }};
            if(max_money < card_number )
            {
                $('#message').modal('show');
                $('.contentMessage').html('Lượng tiền còn lại trong tháng không đủ để đổi thẻ cào !');
                return false;
            }
            return true;
        });
    </script>
    @include('site.partials.delete')


@endsection