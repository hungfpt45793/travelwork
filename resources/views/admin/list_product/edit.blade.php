@extends('admin.layout.admin')

@section('title', 'Cập nhật sản phẩm '. $product->product_name )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật sản phẩm {{ $product->product_name }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('list_product.update',['product_id'=> $product->product_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên sản phẩm</label>
                                <input type="text" class="form-control" name="product_name" placeholder="Tên sản phẩm" value="{{ isset($product->product_name) ? $product->product_name : 0  }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá sản phẩm</label>
                                <input type="text" class="form-control formatPrice" name="product_price" placeholder="Giá sản phẩm" min="1" value="{{ isset($product->product_price) ? $product->product_price : 0  }}" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá hiển thị trên sanketoan</label>
                                <input type="text" class="form-control formatPrice" name="product_discount" placeholder="Giá sản phẩm" min="1" value="{{ isset($product->product_discount) ? $product->product_discount : 0  }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Chọn ảnh sản phẩm</label>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{ isset($product->product_image) ? $product->product_image : ''  }}" width="80" height="70"/>
                                <input name="product_image" type="hidden" value="{{ isset($product->product_image) ? $product->product_image : ''  }}"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung mô tả sản phẩm</label>
                                <textarea class="editor" name="product_content" id="editor">{!! isset($product->product_content) ? $product->product_content : '' !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Link xem thêm về sản phẩm</label>
                                <input type="text" class="form-control" name="product_link" placeholder="Link xem thêm về sản phẩm" value="{{ isset($product->product_link) ? $product->product_link : ''  }}">
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-warning">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection