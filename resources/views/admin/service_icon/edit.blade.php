@extends('admin.layout.admin')

@section('title', 'Thêm mới icon' )

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Thêm mới icon
    </h1>
    <ol class="breadcrumb">
        {{-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Bảng giá</a></li>
        <li><a href="#">Tạo Bảng giá</a></li> --}}
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

            <form action="{{ route('service_icon.update',$service_icon->service_icon_id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="service_icon_name">Tên icon</label>
                    <input type="text" value="{{ old('service_icon_name',$service_icon->service_icon_name ?? '') }}"
                        id="service_icon_name" name="service_icon_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Chọn ảnh</label>
                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh" size="20" />
                    <img src="" width="80" height="70" />
                    <input name="service_icon_image" type="hidden" value="{{ old('service_icon_image',$service_icon->service_icon_image ?? '') }}"/>
                </div>
                <div class="form-group">
                    <label for="service_icon_time">Thời gian tồn tại</label>
                    <input type="text" value="{{ old('service_icon_time',$service_icon->service_icon_time ?? '') }}"
                        id="service_icon_time" name="service_icon_time" class="form-control">
                </div>
                <div class="form-group">
                    <label for="service_icon_price">Giá</label>
                    <input type="text" id="service_icon_price"
                        value="{{ old('service_icon_price',$service_icon->service_icon_price ?? '') }}"
                        name="service_icon_price" class="form-control">
                </div>
                <div class="form-group">
                    <label for="service_icon_vat">Giá vat</label>
                    <input type="text" id="service_icon_vat"
                        value="{{ old('service_icon_vat',$service_icon->service_icon_vat ?? '') }}"
                        name="service_icon_vat" class="form-control">
                </div>
                <div class="form-group">
                    <label for="service_icon_info">Giới thiệu</label>
                    <textarea id="service_icon_info" class="editor" name="service_icon_info" cols="80" rows="10">
                       {{ old('service_icon_info',$service_icon->service_icon_info ?? '') }}    </textarea>
                </div>
                <div class="form-group">
                    <label for="service_price_id">Chọn dịch vụ</label>
                    <select name="service_price_id" class="select2" id="service_price_id">
                        <option value="">--Chọn dịch vụ--</option>
                        @php
                        $service_prices = \App\Entity\Service_price::get();
                        @endphp
                        @foreach ($service_prices as $service_price)
                        <option value="{{ $service_price->service_price_id }}"
                            {{ ($service_price->service_price_id==$service_icon->service_price_id) ? 'selected' : '' }}>
                            {{ $service_price->service_price_title }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Lưu thông tin</button>
            </form>
        </div>
    </div>
</section>
@endsection