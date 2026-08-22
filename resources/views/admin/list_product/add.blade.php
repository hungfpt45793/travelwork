@extends('admin.layout.admin')

@section('title', 'Thêm mới sản phẩm đổi xu')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới sản phẩm đổi xu
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới sản phẩm đổi xu</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('list_product.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thêm mới sản phẩm đổi xu</h3>
                        </div>

                        <div class="box-body">

                            @if($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger" role="alert" style="padding: 5px;margin: 2px;display: inline-block;">
                                        <strong>{{ $error }}</strong>
                                    </div>
                                @endforeach
                            @endif
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên sản phẩm</label>
                                <input type="text" class="form-control" name="product_name" placeholder="Tên sản phẩm" value="{{ old('product_name') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá sản phẩm</label>
                                <input type="text" class="form-control formatPrice" name="product_price" placeholder="Giá sản phẩm" min="1" value="{{ old('product_price') }}">
                            </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá hiển thị trên sanketoan</label>
                                    <input type="text" class="form-control formatPrice" name="product_discount" placeholder="Giá sản phẩm" min="1" value="{{ old('product_discount') }}">
                                </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Chọn ảnh sản phẩm</label>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="" width="80" height="70"/>
                                <input name="product_image" type="hidden" value="{{ old('product_image') }}"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung mô tả sản phẩm</label>
                                <textarea class="editor" name="product_content" id="editor">{!! old('product_content')  !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Link xem thêm về sản phẩm</label>
                                <input type="text" class="form-control" name="product_link" placeholder="Link xem thêm về sản phẩm" value="{{ old('product_link') }}">
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection