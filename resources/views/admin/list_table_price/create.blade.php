@extends('admin.layout.admin')

@section('title', 'Thêm mới bảng giá' )

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
           
            <form action="{{ route('list_table_price.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="service_price_id">Chọn dịch vụ</label>
                    <select name="service_price_id" id="service_price_id" class="form-control select2">
                        @php
                            $list_prices = \App\Entity\Service_price::get();
                        @endphp
                        <option value="">--Chọn dịch vụ--</option>
                        @foreach ($list_prices as $list_price)
                            <option value="{{ $list_price->service_price_id }}">{{ $list_price->service_price_title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="package_name">Tên gói</label>
                    <input type="text" name="package_name" value="{{ old('package_name') }}" id="package_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="package_price">Giá</label>
                    <input type="text" name="package_price" value="{{ old('package_price') }}" id="package_price" class="form-control">
                </div>
                <div class="form-group">
                    <label for="package_discount">Chiết khấu</label>
                    <input type="text" name="package_discount" value="{{ old('package_discount') }}" id="package_discount" class="form-control">
                </div>
                <div class="form-group">
                    <label for="package_vat">Giá gồm VAT</label>
                    <input type="text" name="package_vat" value="{{ old('package_vat') }}" id="package_vat" class="form-control">
                </div>
                <div class="form-group">
                    <label for="benifit">Quyền lợi</label>
                    <textarea id="benifit" class="editor" value="{{ old('benifit') }}" name="benifit" cols="80" rows="10">
                        {{ old('benifit') }}     </textarea>
                </div>
                <div class="form-group">
                    <label for="endow">Lợi ích</label>
                    <textarea id="endow" class="editor" name="endow" cols="80" rows="10">
                       {{ old('endow') }} </textarea>
                </div>
                <button type="submit" class="btn btn-success">Thêm</button>
            </form>
        </div>
    </div>
</section>
@endsection