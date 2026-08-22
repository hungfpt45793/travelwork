@extends('site.layout.site')

@section('title','Gửi đơn hàng thành công')
@section('meta_description','')
@section('keywords','')

@section('content')
    <style>
        section.orderPay
        {
        }
        section.orderPay h1
        {
            font-size: 24px;
            padding: 25px 0px;
            display: block;
        }
        section.orderPay  .pay h3.titleV
        {
            text-align: center;
        }
        section.orderPay  .pay h3.titleV i
        {
            padding-right: 5px;
        }
        section.orderPay .pay button
        {
            background: none;
            box-shadow: none;
            border: 1px solid #ccc;
            font-size: 16px;
            border-radius: 6px;
            padding: 7px 24px;
        }
        section.orderPay a
        {
            color: #000;
            text-decoration: none;
        }
        section.orderPay form
        {
            width: 100%;
        }
        section.orderPay form .nextpr
        {
            border: 1px dotted #ccc;
            padding: 2px 5px;
            font-size: 14px;
            display: inline-block;
        }
        .table-striped tbody tr:nth-of-type(odd)
        {
            background: none;
        }
        section.orderPay form .total
        {
            color: red;
        }
        section.orderPay form .content h3 a
        {

            font-size: 20px;
        }
        section.orderPay form .price
        {
            font-size: 14px;
        }
        section.orderPay form .price del
        {
            padding-right: 15px;
        }
    </style>
    <section class="orderPay">
        <div class="container bgpay">
            <div class="row">
                <div class="col-12 title">
                    <h3>GIỎ HÀNG CỦA BẠN</h3>
                </div>
                <form action="{{ route('send') }}" class="formCheckOut validate" method="post">
                    {{ csrf_field() }}
                    <div class="col-12 order">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Sản phẩm</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Tổng số tiền</th>
                            </tr>
                            </thead>
                            <?php $sumPrice = 0;?>
                            <tbody>
                            @if (!empty($orderItems))
                                @foreach($orderItems as $id => $orderItem)
                                    <tr>
                                        <td >
                                            <a href="{{ route('post', ['cate_slug' => 'san-pham', 'post_slug' => $orderItem->slug]) }}">
                                                <img class="lazy" src="{{ !empty($orderItem->image) ?  asset($orderItem->image) : asset('/site/img/no-image.png') }}" alt="{{ $orderItem->title }}" width="50"> </a>
                                        </td>
                                        <td>
                                            <div class="content">
                                                <p><a href="{{ route('post', ['cate_slug' => 'san-pham', 'post_slug' => $orderItem->slug]) }}">{{ $orderItem->title }}-{{$orderItem->color}}-{{ $orderItem->size }}</a></p>
                                                <p>Thông số: {{ $orderItem->properties }}</p>
                                                <p class="price">
                                                    @if (time() <= strtotime($orderItem->deal_end))
                                                        <span class="discont">Giá : <del>{{ number_format($orderItem->price , 0) }} đ</del>
                                                            <span style="color:red;">{{ number_format($orderItem->price_deal , 0) }} đ </span>
                                                        </span>
                                                    @elseif (!empty($orderItem->discount))
                                                        <span class="discont">Giá : <del>{{ number_format($orderItem->price , 0) }} VND</del>{{ number_format($orderItem->discount , 0) }} VND</span>
                                                    @else
                                                        <span class="discont">Giá : {{ number_format($orderItem->price , 0) }} VND</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </td>
                                        <td>{{ $orderItem->quantity }}</td>
                                        <td>
                                        <span class="total totalPrice">
                                            @php
                                                if (time() <= strtotime($orderItem->deal_end)) {
                                                    $sumPrice += $orderItem->price_deal*$orderItem->quantity;
                                                    echo number_format(($orderItem->price_deal*$orderItem->quantity) , 0);
                                                } else if ($orderItem->discount) {
                                                    $sumPrice += $orderItem->discount*$orderItem->quantity;
                                                    echo number_format(($orderItem->discount*$orderItem->quantity) , 0);
                                                } else {
                                                    $sumPrice += $orderItem->price*$orderItem->quantity;
                                                    echo number_format(($orderItem->price*$orderItem->quantity) , 0);
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td colspan="3" class="text-left">Phí vận chuyển:</td>
                                <td colspan="2" style="text-align: center;">
                                    @php $costShip = 0; @endphp
                                    @foreach($orderShips as $id => $orderShip)
                                        @if ($orderShip->method_ship > $sumPrice )
                                            <span class="sumPrice">{{ number_format($orderShip->cost , 0) }}</span> VND
                                            @php $costShip = $orderShip->cost; @endphp
                                        @endif
                                        @if ($orderShip->method_ship < $sumPrice )
                                            Miễn phí
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td class="continue" colspan="3" rowspan="" headers="">
                                    <a href="" title="/" class="nextpr">Tiếp tục mua hàng</a>
                                </td>
                                <td class="totals" colspan="2" rowspan="" headers="">
                                    <a href="" title="" class="total">Thành tiền : <span class="sumPrice">{{ number_format($sumPrice + $costShip , 0) }}</span> VND </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    @if ($methodPayment == 'Thanh toán qua thẻ ngân hàng')
                    <div class="pay">
                        <h3 class="titleV bgorange">
                            THÔNG TIN CHUYỂN KHOẢN
                        </h3>
                        <div class="col-12 col-md-12">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Ngân hàng</th>
                                    <th>Chủ tài khoản</th>
                                    <th>Số tài khoản</th>
                                    <th>Chi nhánh</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orderBanks as $id => $orderBank)
                                    <tr>
                                        <td>
                                            {{ $orderBank->name_bank }}
                                        </td>
                                        <td>
                                            {{ $orderBank->manager_account }}
                                        </td>
                                        <td>
                                            {{ $orderBank->number_bank }}
                                        </td>
                                        <td class="totalPrice">
                                            {{ $orderBank->branch }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-md-12">
                            <p class="lastText">Quý khách vui lòng điền mã nội dung sau: <span class="red">#{{ $orderId }} - thuocuytin.com.vn</span> trong
                                phần nội dung chuyển khoản để chúng tôi xác nhận đơn hàng.</p>
                        </div>
                    </div>
                    @endif
                    <div class="pay">
                        <h3 class="titleV titleP bgorange">
                            THÔNG TIN NHẬN HÀNG
                        </h3>
                        <div class="col-12 col-md-12">
                            <p>Họ và tên: {{ $customer['ship_name'] }}</p>
                            <p>Điện thoại: {{ $customer['ship_phone'] }}</p>
                            <p>Email: {{ $customer['ship_email'] }}</p>
                            <p>Địa chỉ: {{ $customer['ship_address'] }}</p>
                        </div>
                        <div class="col-12 col-md-12">
                            <p class="titlePayment clearfix">Cảm ơn bạn đã mua hàng của chúng tôi, Mã đơn hàng của bạn là #{{ $orderId }}</p>
                            <p class="lastText">chúng tôi sẽ xác nhận và gửi đơn hàng trong thời gian ngắn nhất.</p>
							<p class="lastText red">Hãy đăng ký bằng số điện thoại hoặc email để nhận thông báo về đơn hàng đã đặt.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
@endsection
