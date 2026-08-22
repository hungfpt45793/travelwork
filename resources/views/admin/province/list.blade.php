@extends('admin.layout.admin')

@section('title', 'Danh sách thành phố' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thành phố
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Thành phố</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh sách Thành phố</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header float-left">
                        <a href="{{ route('province.create') }}">
                            <button class="btn btn-primary" style="float: right">Thêm mới</button>
                        </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        Tổng số : {{ $total }}
                        <table id="provinceTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên thành phố</th>
                                <th>Slug thành phố</th>
                                <th>Trọng số lương</th>
                                <th>Mã bưu chính/zipcode</th>
                                <th>Sắp xếp</th>
                                <th>Khu vực</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($province  as $pro)
                                <tr>
                                    <td>{{ $pro->province_id }}</td>
                                    <td>{{ $pro->province_name }}</td>
                                    <td>{{ $pro->province_slug }}</td>
                                    <td>{{ $pro->province_salary }}</td>
                                    <td>{{ $pro->postalcode }}</td>

                                    <td>{{ $pro->sort_id }}</td>
                                    <td>
                                        @if($pro->local_area == 1)
                                            Miền Bắc
                                        @endif    @if($pro->local_area == 2)
                                            Miền Trung
                                        @endif    @if($pro->local_area == 3)
                                            Miền Nam
                                        @endif

                                    </td>
                                    <td>
                                        <a href="{{ route('province.edit',['province_id'=> $pro->province_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('province.destroy',['province_id'=> $pro->province_id]) }}"
                                           class="btn btn-danger btnDelete" data-toggle="modal"
                                           data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>

    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
@endsection
