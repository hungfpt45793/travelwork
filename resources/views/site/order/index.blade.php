@extends('site.layout.site')

@section('title','Đặt hàng')
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
            font-size: 15px;
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
                    <h3>THÔNG TIN GIỎ HÀNG</h3>
                </div>
                <form action="{{ route('send') }}" class="formCheckOut validate" method="post">
                    {{ csrf_field() }}
                    <div class="col-12 order ">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Sản phẩm</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Tổng số tiền</th>
                                <th scope="col">Xóa</th>
                            </tr>
                            </thead>
                            <?php $sumPrice = 0;?>
                            <tbody>
                            @if (empty($orderItems))
                                <p>không có sản phẩm trong giỏ hàng</p>
                            @else
                                @foreach($orderItems as $id => $orderItem)
                                    <tr>
                                        <td >
                                            <a href="{{ route('product', ['post_slug' => $orderItem->slug]) }}">
                                                <img class="lazy" src="{{ !empty($orderItem->image) ?  asset($orderItem->image) : asset('/site/img/no-image.png') }}" alt="{{ $orderItem->title }}" width="50"> </a>
                                        </td>
                                        <td>
                                            <div class="content">
                                                <h3><a href="{{ route('product', ['post_slug' => $orderItem->slug]) }}">{{ $orderItem->title }}-{{$orderItem->color}}-{{ $orderItem->size }}</a></h3>

                                                <p class="price">
                                                    @if (time() <strtotime($orderItem->deal_end))
                                                        <span class="discont">Giá : <del>{{ number_format($orderItem->price , 0) }} đ</del>
                                                            <span style="color:red;">{{ number_format($orderItem->price_deal , 0) }} đ </span>

                                                        </span>
                                                    @elseif (!empty($orderItem->discount))
                                                        <span class="discont">Giá : <del>{{ number_format($orderItem->price , 0) }} đ</del>
                                                            <span style="color:red;">{{ number_format($orderItem->discount , 0) }} đ </span>

                                                        </span>
                                                    @else
                                                        <span class="discont" >Giá : <span style="color:red;">{{ number_format($orderItem->price , 0) }} đ </span></span>
                                                    @endif
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            @if (time() <= strtotime($orderItem->deal_end))
                                                <input type="hidden" class="unitPrice" value="{{ $orderItem->price_deal }}">
                                            @elseif (!empty($orderItem->discount))
                                                <input type="hidden" class="unitPrice" value="{{ $orderItem->discount }}">
                                            @else
                                                <input type="hidden" class="unitPrice" value="{{ $orderItem->price }}">
                                            @endif
                                            <input type="hidden" name="product_id[]" value="{{ $orderItem->product_id }}"/>
                                            <input type="number" name="quantity[]" style="width:60px;padding-right: 0;"
                                                   value="{{ $orderItem->quantity }}"
                                                   onchange="return changeQuantity(this);" min="0" />
                                        </td>
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
                                        <td class="imgpr">
                                            <a  href="/xoa-don-hang?product_id={{ $orderItem->product_id }}" class="delete" ><i class="fa fa-trash-o" aria-hidden="true" style="font-size: 18px"></i></a>
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
                                            @php $costShip = $orderShip->cost; @endphp
                                        @endif
                                        <input type="hidden" value="{{ $orderShip->method_ship }}" id="costLimit"/>
                                        <input type="hidden" value="{{ $orderShip->cost }}" id="costShip"/>
                                        <span id="showCostShip">{{ ($costShip != 0) ? number_format($costShip , 0) : '' }}</span>
                                    @endforeach
                                    <input type="hidden" value="{{ $costShip }}" name="customer_ship" id="updateCostShip"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="continue" colspan="3" rowspan="" headers="" style="text-align: left;">
                                    <a href="/" title="" class="nextpr"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Tiếp tục mua hàng</a>
                                </td>
                                <td  class="totals" colspan="2" rowspan="" headers="">
                                    <a href="" title="" class="total">Thành tiền:<br> <span class="sumPrice">{{ number_format($sumPrice + $costShip , 0) }}</span> VND </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="payments">
                        <h3 class="title">HÌNH THỨC THANH TOÁN</h3>
                        <div class="direct">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-xs-6 iconpayimg">
                                    <label>
                                        <p>Thanh toán khi nhận hàng</p>
                                        <p><img class="lazy" src="{{ asset('assets/images/cart1.png')}}"></p>
                                        
                                        <input type="radio" name="method_payment" value="Thanh toán khi nhận hàng" checked="">  
                                </label>
                                </div>
                                
                                 <div class="col-md-3 col-sm-6 col-xs-6 iconpayimg">
                                    <label>
                                        <p>Thanh toán qua tài khoản ngân hàng</p>
                                        <p><img class="lazy" src="{{ asset('assets/images/cart2.png')}}"></p>
                                        
                                            <input type="radio" name="method_payment" value="Thanh toán qua thẻ ngân hàng" >  
                                    </label>
                                 </div>
                            </div>
                        </div>
                        <div class="indirect">
                            
                        </div>
                    </div>
                    <div class="pay">
                        <h3 class="titleV bgorange">THÔNG TIN THANH TOÁN</h3>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Họ và tên <span>(*) </span>: </label>
                            <input type="text" class="form-control" name="ship_name" placeholder=""
                                   value="{{ !empty(old('ship_name')) ? old('ship_name') : '' }}"  required/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Điện thoại <span>(*) </span> : </label>
                            <input type="text" class="form-control" name="ship_phone" placeholder=""
                                   value="{{ !empty(old('ship_phone')) ? old('ship_phone') : '' }}"  required/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email : </label>
                            <input type="email" class="form-control" name="ship_email" placeholder=""
                                   value="{{ !empty(old('ship_email')) ? old('ship_email') : '' }}" />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Địa chỉ nhận hàng <span>(*) </span>: </label>
                            <textarea class="form-control" name="ship_address" required rows="7">{{ !empty(old('ship_address')) ? old('ship_address') : '' }}</textarea>
                        </div>
                        <div class="form-group" style="margin-top:10px;margin-bottom: 0">
                            <button type="submit">Đặt hàng ngay</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        function changeQuantity(e) {
            var unitPrice = $(e).parent().parent().find('.unitPrice').val();
            var quantity = $(e).val();
            var totalPrice = unitPrice*quantity;
            var sum = 0;
            var costLimit = $('#costLimit').val();
            var costShip = $('#costShip').val();
            $(e).parent().parent().find('.totalPrice').empty();
            $(e).parent().parent().find('.totalPrice').html(numeral(totalPrice).format('0,0'));

            $('.totalPrice').each(function () {
                var totalPrice = $(this).html();
                sum += parseInt(numeral(totalPrice).value());
            });
            if (parseInt(sum) >= parseInt(costLimit)) {
               costShip = 0;
            }
            if (costShip === 0) {
                $('#showCostShip').html('Miễn Phí');
                $('#updateCostShip').val(0);
            } else {
                $('#showCostShip').html(numeral(costShip).format('0,0'));
                $('#updateCostShip').val(costShip);
            }

            sum = sum + +costShip;

            $('.sumPrice').empty();
            $('.sumPrice').html(numeral( sum).format('0,0'));
        }
    </script>
@endsection
