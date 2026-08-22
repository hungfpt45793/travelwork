@extends('admin.layout.admin')

@section('title', 'Cài đặt thanh toán')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách đơn hàng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Cài đặt thanh toán</li>
        </ol>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tìm kiếm</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <tr>
                                <td colspan="2">
                                    <h4>Thông tin đơn hàng</h4>
                                    <p>IP khách hàng: {{ $order->ip_customer }}</p>
                                    <p>Ngày
                                        đặt: <?php $dateOrder = new \DateTime($order->updated_at); echo $dateOrder->format('d/m/Y H:i'); ?></p>
                                    {{--<p>Hình thức vận chuyển: </p>--}}
                                    <p>Hình thức thanh toán: {{ $order->method_payment }}</p>
                                </td>
                                <td colspan="2">
                                    <h4>Thông tin người nhận hàng</h4>
                                    <p>{{ $order->shipping_name }}</p>
                                    <p>Địa chỉ: {{ $order->shipping_address }}</p>
                                    <p>Số điện thoại: {{ $order->shipping_phone }}</p>
                                    <p>Email: {{ $order->shipping_email }}</p>
                                </td>
                                <td>
                                    <h4>Ghi chú</h4>
                                    <p>{{ $order->shipping_note }}</p>
                                </td>
                            </tr>
                        </table>
                        <table id="" class="table table-bordered table-striped">
                            <tr>
                                <td>Ảnh Sản phẩm</td>
                                <td>Tên SP</td>
                                <td>Mã SP</td>
                                <td>Số lượng</td>
                                <td>Giá gốc</td>
                                <td>Đơn giá khi mua</td>
                            </tr>
                            <?php $sumPrice = 0;?>
                            @foreach($orderItems as $idx => $orderItem)
                                <tr>

                                    <td><img src="{{ asset($orderItem->image) }}" alt="{{ $orderItem->title }}" width="70"/></td>
                                    <td><p>{{ $orderItem->title }}</p></td>
                                    <td><p>{{ $orderItem->code }}</p></td>
                                    <td><p>{{ $orderItem->quantity }}</p></td>
                                    <td><p>{{ $orderItem->origin_price }}</p></td>
                                    <td>
                                        <div class="price">
                                            {{ number_format($orderItem->cost, 0, ',', '.') }}
                                        </div>
                                    </td>

                                </tr>
                                <?php $sumPrice += $orderItem->cost*$orderItem->quantity ?>
                            @endforeach
                            <tr>
                                <td colspan="5">Phí vận chuyển</td>
                                <td>
                                    {{ !empty($order->customer_ship) ? $order->customer_ship : 'Miễn Phí'  }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">Thành tiền</td>
                                <td><p>{{ number_format($sumPrice + $order->customer_ship, 0, ',', '.') }} VNĐ</p></td>
                            </tr>
                            {{--<tr>--}}
                            {{--<td colspan="5">Mã giảm giá</td>--}}
                            {{--<td>-{{ number_format($order->cost_sale, 0, ',', '.') }} VNĐ</td>                                    --}}
                            {{--</tr>--}}

                            {{--<tr>--}}
                                {{--<td colspan="5">Tổng cộng</td>--}}
                                {{--<td><p>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</p></td>--}}
                            {{--</tr>--}}
                        </table>

                    </div>

                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ghi chú quản trị</h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('orderUpdateStatus') }}" method="post">
                            {!! csrf_field() !!}
                            <select name="status" class="
                                <?php switch ($order->status) {
                                case 1:
                                    echo 'btn-info';
                                    break;
                                case 2:
                                    echo 'btn-warning';
                                    break;
                                case 3:
                                    echo 'btn-danger';
                                    break;
                                case 4:
                                    echo 'btn-success';
                                    break;
                            }?>" >
								<option value="0"
                                        class="btn-danger clearfix" {{ ($order->status==0) ? 'selected' : ''}}>
                                    Hủy đơn hàng
                                </option>
                                <option value="1"
                                        class="btn-info clearfix" {{ ($order->status==1) ? 'selected' : ''}}>
                                    Đã đặt đơn hàng
                                </option>
                                <option value="2"
                                        class="btn-warning clearfix" {{ ($order->status==2) ? 'selected' : ''}}>
                                    Đã nhận đơn hàng
                                </option>
                                <option value="3"
                                        class="btn-danger clearfix" {{ ($order->status==3) ? 'selected' : ''}}>
                                    Đang vận chuyển
                                </option>
                                <option value="4"
                                        class="btn-success clearfix" {{ ($order->status==4) ? 'selected' : ''}}>
                                    Đã giao hàng
                                </option>
                            </select>
                            <div class="form-group">
                                <label for="noteAdmin">Thông báo cho khách hàng</label>
                                <input type="checkbox" name="is_mail_customer" value="1"
                                       {{ !empty($order->is_mail_customer) ? 'checked' : '' }} class="flat-red">
                            </div>
                            <div class="form-group">
                                <label for="noteAdmin">Ghi chú Admin</label>
                                <textarea class="form-control" rows="3" name="noteAdmin" id="noteAdmin">{{ $order->note_admin }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="noteAdmin">Tiền shipping hàng</label>
                                <input type="number" class="form-control formatPrice" name="cost_ship" value="{{ $order->cost_ship }}" placeholder="Tiền shipping hàng" step="any">
                            </div>
                            <input type="hidden" value="{{ $order->order_id }}" name="order_id"/>
                            <button type="submit" class="btn btn-primary">Xác nhận</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection

