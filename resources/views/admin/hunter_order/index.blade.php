@extends('admin.layout.admin')
@section('title', 'Đơn hàng tuyển dụng' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Đơn hàng tuyển dụng
        </h1> 
    </section>
    <section class="content">
        <div class="row box" style="margin-top:5px">
            <div class="col-md-12">
                @if (session('success'))
                <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                    <div class="alert alert-success mg-b-0 ">
                        {{session('success')}}
                        <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                    </div>
                </div>
            @endif
                <table class="table table-bordered" id="data_hunter_order">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Ngày tạo đơn</th>
                            <th scope="col">NTD</th>
                            <th scope="col">Thanh toán</th>
                            <th scope="col">Vị trí TD</th>
                            <th scope="col">Thời gian TD</th>
                            <th scope="col">Chi phí</th>
                            <th scope="col">Tên NTD</th>
                            <th scope="col">SĐT NTD</th>
                            <th scope="col">Email NTD</th>
                            <th scope="col">Ghi chú</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hunter_orders as $key => $hunter_order)
                        <tr class="setlenght">
                            <td>{{ ++$key }}</td>
                            <td>{{ $hunter_order->hunter_regis_code }}</td>
                            <td>{{ date('d-m-Y', strtotime($hunter_order->created_at)) }}</td>
                            <td>
                                @if ($hunter_order->employer_id == 0)
                                <i class="fa fa-times text-danger"></i>
                                @else 
                                <i class="fa fa-check text-success"></i>
                                @endif
                            </td>
                            <td>
                                
                                @if($hunter_order->hunter_regis_status==0)
                                <i class="fa fa-times text-danger"></i>
                                
                                @elseif($hunter_order->hunter_regis_status==1)
                                <i class="fa fa-check text-success"></i>
                                
                                @else
                                @endif  
                                
                            </td>
                            <td>{{ $hunter_order->hunter_pos_name }}</td>
                            <td>{{ $hunter_order->hunter_time_name }}</td>
                            <td>{{ $hunter_order->hunter_price_name }}</td>
                            <td>{{ $hunter_order->hunter_regis_name }}</td>
                            <td>{{ $hunter_order->hunter_regis_phone }}</td>
                            <td>{{ $hunter_order->hunter_regis_email }}</td>
                            <td>{{ $hunter_order->hunter_regis_note }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Thao tác
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('hunter_order.edit',$hunter_order->hunter_regis_id ) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a><br>
                                        <a href="">
                                            <button class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                        </a><br>
                                        <a href="{{ route('hunter_order.destroy',$hunter_order->hunter_regis_id ) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
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
            $('#data_hunter_order').DataTable({});
        });
    </script>
@endpush