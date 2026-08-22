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
                        <form method="get">
                            <div class="form-group col-xs-12 col-md-6">
                                <input class="form-control"
                                       value="{{ !empty($_GET['order_id']) ? $_GET['order_id'] : '' }}" name="order_id"
                                       placeholder="id đơn hàng"/>
                            </div>
                            <div class="form-group col-xs-12 col-md-6">
                                <input class="form-control" value="{{ !empty($_GET['phone']) ? $_GET['phone'] : '' }}"
                                       name="phone" placeholder="Số điện thoại khách hàng"/>
                            </div>
                            <div class="form-group col-xs-12 col-md-6">
                                <input class="form-control" value="{{ !empty($_GET['email']) ? $_GET['email'] : '' }}"
                                       name="email" placeholder="Mail khách hàng"/>
                            </div>
                            <div class="form-group col-xs-12 col-md-6">
                                <input class="form-control" value="{{ !empty($_GET['name']) ? $_GET['name'] : '' }}"
                                       name="name" placeholder="Tên khách hàng"/>
                            </div>
                            <div class="form-group col-xs-12 col-md-6">
                                <label class="control-label">Ngày giờ</label>
                                <input type="checkbox" name="is_search_time" value="1"
                                       class="flat-red" {{ (!empty($_GET['is_search_time']) && $_GET['is_search_time'] == 1) ? 'checked' : '' }}/>
                                Tích chọn để search theo thời gian
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="reservationtime"
                                           name="search_start_end"/>
                                </div>
                            </div>
                            <input type="hidden" value="{{ !empty($_GET['user_id']) ? $_GET['user_id'] : '' }}"
                                   name="user_id"/>
                            <div class="form-group col-xs-12 col-md-12">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                <a href="{{ route('exportToExcel') }}" class="btn btn-success">Xuất ra Excel</a>
                            </div>
                        </form>
                    </div>

                    <div class="box-body">
                        <table  class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">Mã đơn hàng</th>
                                <th>Tên và SĐT</th>
                                <th>Tổng tiền</th>
                                <th>Địa chỉ</th>
                                <th>Ngày đặt hàng</th>
                                <th>Trạng thái</th>
                                <th width="20%">Ghi chú (nếu có)</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $id => $order)
                                    <?php $sumPrice = 0;?>
                                    @foreach($order->orderItems as $idx => $orderItem)
                                        <?php $sumPrice += $orderItem->cost*$orderItem->quantity ?>
                                    @endforeach

                                    <tr>
                                        <td>#{{ $order->order_id }}</td>
                                        <td>
                                            <p>{{ $order->shipping_name }}</p>
                                            <p>{{ $order->shipping_phone }}</p>
                                        </td>
                                        <td>
                                            {{ number_format($sumPrice + $order->customer_ship, 0, ',', '.') }} VNĐ
                                        </td>
                                        <td>
                                            <p>{{ $order->shipping_address }}</p>

                                        </td>
                                        <td>
                                            <?php $dateOrder = new \DateTime($order->updated_at); echo $dateOrder->format('d/m/Y H:i'); ?>
                                        </td>
										<td>
                                            @php 
												switch ($order->status) {
													case 0:
														echo "Hủy đơn hàng";
														break;
													case 1:
														echo "Đã đặt đơn hàng";
														break;
													case 2:
														echo "Đã nhận đơn hàng";
														break;
													case 3:
														echo "Đang vận chuyển";
														break;
													case 4:
														echo "Đã giao hàng";
														break;	
												}
											@endphp
                                        </td>
                                        <td>
                                            <p>{{ $order->shipping_note }}</p>
                                        </td>
                                        <td>
                                            <a href="{{ route('orderAdmin.show', ['order_id' => $order->order_id]) }}">
                                                <button class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                            </a>
                                            <a  href="{{ route('orderAdmin.destroy', ['order_id' => $order->order_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{ $orders->links() }}
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection

