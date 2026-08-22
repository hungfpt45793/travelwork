@extends('site.layout.site')

@section('title', isset($product->product_name) ? $product->product_name : '')
@section('meta_description', isset($product->product_name) ? $product->product_name : '')
@section('keywords', isset($product->product_name) ? $product->product_name : '')

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
                                            Đổi phần mềm
                                        </h5>

                                        <div class="row">
                                            <div class="col-lg-6 change_left">
                                                <h5 class="clred mgt15"> Thông tin phần mềm </h5>

                                                <h4> {{ isset($product->product_name) ? $product->product_name : '' }}</h4>
                                                <p class="f16 clred fw6 mgb10">Giá thị trường : {{ isset($product->product_price) ? number_format($product->product_price) : '' }} VND </p>
                                                @if(!empty($product->product_discount))
                                                <p class="f16 clred fw6 mgb10">Giá đổi phần mềm : {{ isset($product->product_discount) ? number_format($product->product_discount) : '' }} VND </p>
                                                @endif
                                                <div class="content contentDetail">
                                                    <article>
                                                        {!! isset($product->product_content) ? $product->product_content : '' !!}
                                                    </article>
                                                    <div class="text-center">
                                                        <a href="{{ $product->product_link }}" target="_blank" style="display: inline-block;border: 1px solid green;padding: 3px 5px ;text-align: center">Xem chi tiết</a>
                                                    </div>


                                                </div>

                                            </div>
                                            <div class="col-lg-6 change_right">
                                                <h5 class="mgt15"> Đổi phần mềm</h5>
                                                @if($employee_coints->money < $product->product_price)
                                                    <p class="clred mgb5">
                                                        Số dư của bạn không đủ để đổi phần mềm này !
                                                    </p>
                                                @endif
                                                <form method="post" action="{{ route('update_change_software') }}"
                                                      id="submitChange">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Tên phần mềm <span
                                                                    class="clred">(*)</span></label>
                                                        <input type="text" class="form-control"
                                                               name="transaction_product_name"
                                                               placeholder="Tên ngân hàng"  value="{{ isset($product->product_name) ? $product->product_name : '' }}" readonly>
                                                    </div>

                                                    @if(!empty($product->product_discount))
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Giá đổi phần mềm<span
                                                                    class="clred">(*)</span></label>
                                                        <input type="text" class="form-control "
                                                               id="transaction_bank_price" name="transaction_product_price"
                                                               placeholder="Số tiền chuyển khoản" readonly value="{{ isset($product->product_discount) ? number_format($product->product_discount) : '' }}">
                                                    </div>
                                                        @else
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Giá đổi phần mềm<span
                                                                        class="clred">(*)</span></label>
                                                            <input type="text" class="form-control "
                                                                   id="transaction_bank_price" name="transaction_product_price"
                                                                   placeholder="Số tiền chuyển khoản" readonly value="{{ isset($product->product_price) ? number_format($product->product_price) : '' }}">
                                                        </div>
                                                    @endif
                                                    <div class="form-group">
                                                        <label for="exampleFormControlTextarea1">Ghi chú</label>
                                                        <textarea class="form-control " id="note"
                                                                  name="transaction_content"
                                                                  rows="3"></textarea>
                                                    </div>
                                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">

                                                    <button type="submit" class="btn btnOrang"
                                                            @if($employee_coints->money < $product->product_price) disabled  @endif>Đổi phần mềm

                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>

                                </div>


                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">

                                    <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb10 mgt10">
                                        Lịch sử đổi phần mềm
                                    </h5>

                                    @if(!empty($transaction_history_product))
                                        <table id="jobfb" class="table table-hover table-bordered text-center mbdsNone">
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
                                                            <span class="btnGreen dsInline"style="padding: 3px 10px;">Đã duyệt </span>
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
                                                            <span class="btnGreen dsInline" style="padding: 3px 10px;" data-toggle="modal" data-target="#transaction_product{{$id_tran}}">Xem nội dung </span>
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
                                                <th>Thông tin đổi phần mềm</th>
                                                {{--<th>Giá thị trường</th>--}}
                                                {{--<th>Giá đổi phần mềm</th>--}}
                                                {{--<th>Link chi tiết</th>--}}
                                                {{--<th>Ghi chú</th>--}}
                                                {{--<th>Trạng thái</th>--}}
                                                {{--<th>Ngày đổi thẻ</th>--}}
                                                {{--<th>Admin trả lời</th>--}}
                                                {{--<th>Ngày duyệt</th>--}}
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                            @foreach($transaction_history_product as $id_tran=>$transaction_history)
                                                <tr>
                                                    <td>{{ $id_tran + 1 }}</td>
                                                    <td>
                                                        <p class="mgb5">Tên phần mềm : {{ $transaction_history->transaction_product_name }} </p>
                                                        <?php $product_link = \App\Transaction\List_product::get_product_id($transaction_history->transaction_product_id)?>
                                                        <p class="mgb5"> Giá thị trường {{ number_format($product_link->product_price) }}</p>
                                                        <p class="mgb5">Giá đổi phần mềm : {{ number_format($transaction_history->transaction_product_price) }}</p>
                                                        <p class="mgb5">Link chi tiết : <a href="{{ $product_link->product_link }}" target="_blank">Link chi tiết</a>  </p>
                                                        <p class="mgb5">Ghi chú : {{ $transaction_history->transaction_content }} </p>
                                                        <p class="mgb5">Trạng thái :
                                                            @if($transaction_history->transaction_status == 0)
                                                                <span class="btnOrang">Chưa duyệt </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 1)
                                                                <span class="btnRed">Hủy giao dịch </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 2)
                                                                <span class="btnGreen dsInline"style="padding: 3px 10px;">Đã duyệt </span>
                                                            @endif
                                                        </p>
                                                        <p class="mgb5">Ngày đổi thẻ :
                                                            <i class="far fa-clock"></i> <?php
                                                            $date = date_create($transaction_history->created_at);
                                                            echo date_format($date, "H:i:s");
                                                            ?>
                                                            <i class="far fa-calendar-times"></i> <?php
                                                            echo date_format($date, "d/m/Y");
                                                            ?>
                                                        </p>
                                                        <p class="mgb5">Admin trả lời :  @if(!empty($transaction_history->transaction_admin_reply))
                                                                <span class="btnGreen dsInline" style="padding: 3px 10px;" data-toggle="modal" data-target="#transaction_product{{$id_tran}}">Xem nội dung </span>
                                                            @endif</p>
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
    {{--<style>--}}
        {{--article {--}}
            {{--max-height: 300px; /* (4 * 1.5 = 6) */--}}
        {{--}--}}

        {{--.redmore {--}}
            {{--margin-top: 15px;--}}
            {{--text-align: center;--}}
            {{--padding: 5px 10px;--}}
            {{--font-size: 15px;--}}
        {{--}--}}

        {{--.redmore:hover {--}}
            {{--/*background: #009385;*/--}}
            {{--/*color: white;*/--}}
        {{--}--}}

        {{--.redmore span {--}}
            {{--background: #009385;--}}
            {{--border: 1px solid #009385;--}}
            {{--color: white;--}}
            {{--padding: 5px 10px;--}}
        {{--}--}}
    {{--</style>--}}


    @include('site.partials.delete')
    @if(!empty($transaction_history_product))
        @foreach($transaction_history_product as $id_tran=>$transaction_history)
            <div class="modal fade bd-example-modal-lg" id="transaction_product{{$id_tran}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Xem nội dung đổi phần mềm </h5>
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
            var money = {{ $employee_coints->money }};
            var price = {{ $product->product_price }};
            if (money < price) {
                $('#message').modal('show');
                $('.contentMessage').html('Số dư của bạn không đủ để thực hiện giao dịch này !')
                console.log(money);
                return false;
            }
        });

    </script>
    {{--<script src="/assets/js/ajax_redmore_jquery.min.js"></script>--}}
    {{--<script src="/assets/js/readmore.js"></script>--}}
    {{--<script>--}}
        {{--$('article').readmore({--}}
            {{--speed: 1000,--}}
            {{--moreLink: '<a title="Xem thêm" class="redmore" href="#"> <span> Xem thêm <i class="fas fa-angle-double-down"></i> </span></a>',--}}
            {{--lessLink: '<a title="Thu gọn" class="redmore" href="#">   <span> Thu gọn <i class="fas fa-angle-double-up"></i> </span> </a>',--}}
        {{--});--}}
    {{--</script>--}}

@endsection