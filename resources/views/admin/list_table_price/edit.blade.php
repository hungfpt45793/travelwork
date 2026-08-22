@extends('admin.layout.admin')

@section('title', 'Sửa bảng giá' )

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
           
            <form action="{{ route('list_table_price.update',$table_price->service_table_price_id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group">
                    <label for="service_price_id">Chọn dịch vụ</label>
                    <select name="service_price_id" id="service_price_id" class="form-control select2">
                        @php
                            $list_prices = \App\Entity\Service_price::get();
                        @endphp
                        <option value="">--Chọn dịch vụ--</option>
                        @foreach ($list_prices as $list_price)
                            <option value="{{ $list_price->service_price_id }}"
                                {{ ($list_price->service_price_id==$table_price->service_price_id) ? 'selected' : '' }}
                                >{{ $list_price->service_price_title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="package_name">Tên gói</label>
                    <input type="text" name="package_name" id="package_name" class="form-control" value="{{ old('package_name',$table_price->package_name ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="package_price">Giá</label>
                    <input type="text" name="package_price" id="package_price" class="form-control" value="{{ old('package_price',$table_price->package_price ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="package_discount">Chiết khấu</label>
                    <input type="text" name="package_discount" id="package_discount" class="form-control" value="{{ old('package_discount',$table_price->package_discount ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="package_vat">Giá gồm VAT</label>
                    <input type="text" name="package_vat" id="package_vat" class="form-control" value="{{ old('package_vat',$table_price->package_vat ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="benifit">Quyền lợi</label>
                    <textarea id="benifit" class="editor" name="benifit" required
                        cols="80" rows="10">
                        {{ old('benifit',$table_price->benifit ?? '') }}
                        </textarea>
                </div>
                <div class="form-group">
                    <label for="endow">Lợi ích</label>
                    <textarea id="endow" class="editor" name="endow" required
                        cols="80" rows="10">
                        {{ old('endow',$table_price->endow ?? '') }}
                        </textarea>
                </div>
                <button type="submit" class="btn btn-success">Lưu thông tin</button>
            </form>
        </div>
    </div>
</section>
@endsection