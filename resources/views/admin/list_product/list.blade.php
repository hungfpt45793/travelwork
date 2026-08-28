@extends('admin.layout.admin')

@section('title', ' Danh sách sản phẩm đổi xu' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Danh sách sản phẩm đổi xu
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#"> Danh sách sản phẩm đổi xu</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        @if (session('success'))
                            <div class="infoAlert">
                                <div class="alert alert-success">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="infoAlert">
                                <div class="alert alert-warning">
                                    <span>{{ session('error') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif
                        <a href="{{ route('list_product.create') }}"><button class="btn btn-primary" style="float: left;margin-right: 10px;">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">



                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên</th>
                                <th>Slug</th>
                                <th>Giá sản phẩm</th>
                                <th>Giá trên sanketoan</th>
                                <th>Ảnh sản phẩm</th>
                                <th>Link sản phẩm</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_product  as $product)
                                <tr>
                                    <td>{{ $product->product_id }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->product_slug }}</td>
                                    <td>{{ number_format($product->product_price) }}</td>
                                    <td>{{ number_format($product->product_discount) }}</td>
                                    <td><img src="{{ $product->product_image }}" style="width: 50px;"></td>
                                    <td>{{ $product->product_link }}</td>
                                    <td>
                                        <a href="{{ route('list_product.edit',['list_product'=> $product->product_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('list_product.destroy',['list_product'=> $product->product_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $list_product->links() }}
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection
