@extends('admin.layout.admin')
@section('title', 'Thẻ ngân hàng' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thẻ ngân hàng
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
            <a href="{{ route('service_bank.create') }}"><button style="margin-bottom:12px;margin-top:12px" class="btn btn-success">Thêm mới</button></a>
                <table class="table table-bordered" id="data_service_bank">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th scope="col">Tên ngân hàng</th>
                            <th scope="col">Chủ tài khoản</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Số tài khoản</th>
                            <th scope="col">Chi nhánh</th>
                            <th scope="col">Nội dung</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($service_banks as $key => $service_bank)
                        <tr class="setlenght">
                            <td>{{ ++$key }}</td>
                            <td>{{ $service_bank->service_bank_name }}</td>
                            <td>{!! $service_bank->service_bank_own !!}</td>
                            <td><img src="{{ $service_bank->service_bank_image }}" style="height: 50px;width:50px;" alt=""></td>
                            <td>{!! $service_bank->service_bank_number !!}</td>
                            <td>{!! $service_bank->service_bank_branch !!}</td>
                            <td>{!! $service_bank->service_bank_content !!}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Thao tác
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('service_bank.edit',$service_bank->service_bank_id ) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a><br>
                                        {{-- <a href="">
                                            <button class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                        </a><br> --}}
                                        <a href="{{ route('service_bank.destroy',$service_bank->service_bank_id ) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
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
            $('#data_service_bank').DataTable({});
        });
    </script>
@endpush