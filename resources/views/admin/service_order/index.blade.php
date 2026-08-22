@extends('admin.layout.admin')
@section('title', 'Đơn hàng' )

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Đơn hàng
    </h1>
</section>
<section class="content">
    <div class="row box" style="padding-top: 5px">
        <div class="col-md-12">
            @if (session('success'))
            <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                <div class="alert alert-success mg-b-0 ">
                    {{session('success')}}
                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                </div>
            </div>
            @endif
            <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                <ul style="column-count: 3;" class="list-group">
                @foreach ($list_prices as $list_price)
                @php
                $count = \App\Entity\Service_order::getCountAlowServicePrice($list_price->service_price_id);
                @endphp
                    <a href="{{ route('service_order.index') }}/?service_price={{ $list_price->service_price_id }}">
                        <li style="padding:5px 2px; font-size:12px" class="list-group-item list-group-item-success d-flex justify-content-between align-items-center">
                            <span >{{ $list_price->service_price_title }}</span> -
                            <span style="padding:2px 5px; border-radius:50%" class="bg-primary">{{ $count }}</span>
                        </li>
                    </a>
                    <hr style="border:none;margin:2px">
                @endforeach
            </ul>
            </div>
            <table class="table table-bordered" id="data_service_order">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th scope="col">Mã đơn hàng</th>
                        <th scope="col">Ngày tạo đơn</th>
                        <th scope="col">NTD</th>
                        <th scope="col">TT</th>
                        <th scope="col">Chi phí</th>
                        <th scope="col">Chiết khấu</th>
                        <th scope="col">Chi phí có vat</th>
                        <th scope="col">Tên NTD</th>
                        <th scope="col">SĐT NTD</th>
                        <th scope="col">Email NTD</th>
                        <th scope="col">Ghi chú</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($service_orders as $key => $service_order)
                    <tr class="setlenght">
                        <td>{{ ++$key }}</td>
                        <td>{{ $service_order->service_order_code }}</td>
                        <td>{{ date('d-m-Y', strtotime($service_order->created_at)) }}</td>
                        <td>
                            @if ($service_order->employer_id == 0)
                            <i class="fa fa-times text-danger"></i>
                            @else
                            <i class="fa fa-check text-success"></i>
                            @endif
                        </td>
                        <td>

                            @if($service_order->status==0)
                            <i class="fa fa-times text-danger"></i>

                            @elseif($service_order->status==1)
                            <i class="fa fa-check text-success"></i>

                            @else
                            @endif

                        </td>
                        <td>{{ $service_order->service_order_price }}</td>
                        <td>{{ $service_order->service_order_discount }}</td>
                        <td>{{ $service_order->service_order_vat }}</td>
                        <td>{{ $service_order->employer_name }}</td>
                        <td>{{ $service_order->employer_phone }}</td>
                        <td>{{ $service_order->employer_email }}</td>
                        <td>{{ $service_order->service_order_content }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Thao tác
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a href="{{ route('service_order.edit',$service_order->service_order_id ) }}">
                                        <button class="btn btn-primary"><i class="fa fa-pencil"
                                                aria-hidden="true"></i></button>
                                    </a><br>
                                    {{-- <a href="">
                                        <button class="btn btn-info"><i class="fa fa-eye"
                                                aria-hidden="true"></i></button>
                                    </a><br> --}}
                                    <a href="{{ route('service_order.destroy',$service_order->service_order_id ) }}"
                                        class="btn btn-danger btnDelete" data-toggle="modal"
                                        data-target="#myModalDelete" onclick="return submitDelete(this);">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@include('admin.partials.popup_delete')
@endsection
@push('scripts')
<script>
    $(function() {
            $('#data_service_order').DataTable({});
        });
</script>
@endpush