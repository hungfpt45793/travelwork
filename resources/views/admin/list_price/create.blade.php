@extends('admin.layout.admin')

@section('title', 'Thêm mới dịch vụ' )

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Bảng giá dịch vụ
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Bảng giá</a></li>
        <li><a href="#">Tạo Bảng giá</a></li>
    </ol>
</section>
<section class="content">
    <div class="row box">
        <div class="col-md-12">
            @if($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert" style="padding: 5px;margin: 2px;display: inline-block;">
                <strong>{{ $error }}</strong>
            </div>
            @endforeach
            @endif
           
            <form action="{{ route('list_price.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="title">Tên gói</label>
                    <input type="text" value="{{ old('service_price_title') }}" name="service_price_title" id="title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="type">Tên gói</label>
                    <select name="service_price_type" id="type" class="form-control select2">
                        <option value="">--Chọn loại gói--</option>
                        <option value="0">Bảng giá</option>
                        <option value="1">Bảng icon</option>
                        <option value="2">Tuyển dụng thuê</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Chọn ảnh sản phẩm</label>
                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                           size="20"/>
                    <img src="" width="80" height="70"/>
                    <input name="image" type="hidden" value="{{ old('image') }}"/>
                </div>
                <div class="form-group">
                    <label for="feature">Dịch vụ</label>
                    <textarea id="feature" class="editor" name="feature" cols="80" rows="10">
                        {{ old('feature') }}
                            </textarea>
                </div>
                <button type="submit" class="btn btn-success">Thêm</button>
            </form>
        </div>
    </div>
</section>
@endsection