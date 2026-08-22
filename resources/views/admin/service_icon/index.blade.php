@extends('admin.layout.admin')
@section('title', 'Danh sách icon' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Icon tăng click
        </h1>
        
    </section>
    <section class="content">
        <div class="row box">
            <div class="col-md-12">
                @if (session('success'))
                <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                    <div class="alert alert-success mg-b-0 ">
                        {{session('success')}}
                        <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                    </div>
                </div>
                @endif
            <a href="{{ route('service_icon.create') }}"><button style="margin-bottom:12px;margin-top:12px" class="btn btn-success">Thêm mới</button></a>
                <table class="table table-bordered" id="data_service_icon">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th scope="col">Tên icon</th>
                            <th scope="col">Thời gian sống</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Giá vat</th>
                            <th scope="col">Giới thiệu</th>
                            <th scope="col">Gói dịch vụ</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($service_icons as $key => $service_icon)
                        <tr class="setlenght">
                            <td>{{ ++$key }}</td>
                            <td>{{ $service_icon->service_icon_name }}</td>
                            <td>{{ $service_icon->service_icon_time }}</td>
                            <td><img src="{{ $service_icon->service_icon_image }}" style="height: 50px;width:50px;" alt=""></td>
                            <td>{{ $service_icon->service_icon_price }}</td>
                            <td>{{ $service_icon->service_icon_vat }}</td>
                            <td>{!! $service_icon->service_icon_info !!}</td>
                            <td>{{ $service_icon->service_price_title }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Thao tác
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('service_icon.edit',$service_icon->service_icon_id ) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a><br>
                                        {{-- <a href="">
                                            <button class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                        </a><br> --}}
                                        <a href="{{ route('service_icon.destroy',$service_icon->service_icon_id ) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
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
            $('#data_service_icon').DataTable({});
        });
    </script>
@endpush