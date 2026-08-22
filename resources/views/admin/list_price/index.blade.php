@extends('admin.layout.admin')

@section('title', 'Danh sách dịch vụ' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Danh sách dịch vụ
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Bảng giá</a></li>
            <li><a href="#">Danh sách Bảng giá</a></li>
        </ol>
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
            <a href="{{ route('list_price.create') }}"><button style="margin-bottom:12px;margin-top:12px" class="mb-2 btn btn-success">Thêm mới</button></a>
                <table class="table table-bordered" id="datatable_list_price">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th scope="col">Tên gói</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Dịch vụ</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_prices as $key => $list_price)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list_price->service_price_title }}</td>
                            <td><img src="{{ $list_price->image }}" alt="" style="height:50px;width:50px"></td>
                            <td>{!! $list_price->feature !!}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Thao tác
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('list_price.edit',$list_price->service_price_id) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a><br>
                                        {{-- <a href="">
                                            <button class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                        </a><br> --}}
                                        <a href="{{ route('list_price.destroy',$list_price->service_price_id) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
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
            $('#datatable_list_price').DataTable({});
        });
    </script>
@endpush
