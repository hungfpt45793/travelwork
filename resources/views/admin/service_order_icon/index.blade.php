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
            <table class="table table-bordered" id="data_service_order_icon">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th scope="col">Mã đơn hàng</th>
                        <th scope="col">Ngày tạo đơn</th>
                        <th scope="col">NTD</th>
                        <th scope="col">TT</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Chi phí</th>
                        <th scope="col">Chi phí có vat</th>
                        <th scope="col">Tên NTD</th>
                        <th scope="col">SĐT NTD</th>
                        <th scope="col">Email NTD</th>
                        <th scope="col">Ghi chú</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($service_order_icons as $key => $service_order_icon)
                    <tr class="setlenght">
                        <td>{{ ++$key }}</td>
                        <td>{{ $service_order_icon->service_order_icon_code }}</td>
                        <td>{{ date('d-m-Y', strtotime($service_order_icon->created_at)) }}</td>
                        <td>
                            @if ($service_order_icon->employer_id == 0)
                            <i class="fa fa-times text-danger"></i>
                            @else
                            <i class="fa fa-check text-success"></i>
                            @endif
                        </td>
                        <td>

                            @if($service_order_icon->status==0)
                            <i class="fa fa-times text-danger"></i>

                            @elseif($service_order_icon->status==1)
                            <i class="fa fa-check text-success"></i>

                            @else
                            @endif

                        </td>
                        <td>
                            @php
                                 $icon_name = \App\Entity\Service_icon::where('service_icon_id', $service_order_icon->service_icon_id)->value('service_icon_name');
                                 echo $icon_name;
                            @endphp
                        </td>
                        <td>{{ $service_order_icon->service_order_icon_price }}</td>
                        <td>{{ $service_order_icon->service_order_icon_vat }}</td>
                        <td>{{ $service_order_icon->employer_name }}</td>
                        <td>{{ $service_order_icon->employer_phone }}</td>
                        <td>{{ $service_order_icon->employer_email }}</td>
                        <td>{!! $service_order_icon->service_order_icon_content !!}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Thao tác
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a href="{{ route('service_order_icon.edit',$service_order_icon->service_order_icon_id ) }}">
                                        <button class="btn btn-primary"><i class="fa fa-pencil"
                                                aria-hidden="true"></i></button>
                                    </a><br>
                                    <a href="{{ route('service_order_icon.destroy',$service_order_icon->service_order_icon_id ) }}"
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
            $('#data_service_order_icon').DataTable({});
        });
</script>
@endpush