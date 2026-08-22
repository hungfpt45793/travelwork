@extends('admin.layout.admin')

@section('title', 'Sửa tuyển dụng thuê' )

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Sửa mới tuyển dụng thuê
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
           
            <form action="{{ route('service_hunter.update', $service_hunter->service_hunter_id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="service_hunter_name">Tiêu đề</label>
                    <input type="text" value="{{ old('service_hunter_name',$service_hunter->service_hunter_name ?? '') }}" id="service_hunter_name" name="service_hunter_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Chọn ảnh</label>
                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                           size="20"/>
                    <img src="" width="80" height="70"/>
                    <input name="service_hunter_image" type="hidden" value="{{ old('service_hunter_image',$service_hunter->service_hunter_image ?? '') }}"  />
                </div>
                <div class="form-group">
                    <label for="service_hunter_info">Thông tin</label>
                    <textarea id="service_hunter_info" class="editor" name="service_hunter_info" cols="80" rows="10">
                        {{ old('service_hunter_info',$service_hunter->service_hunter_info ?? '') }}   </textarea>
                </div>
                <div class="form-group">
                    <label for="service_hunter_pay">Hình thức thanh toán</label>
                    <textarea id="service_hunter_pay"  class="editor" name="service_hunter_pay" cols="80" rows="10">
                        {{ old('service_hunter_pay',$service_hunter->service_hunter_pay ?? '') }} </textarea>
                </div>
                <div class="form-group">
                    <label for="service_hunter_fee">Phí tuyển dụng</label>
                    <textarea id="service_hunter_fee" class="editor" name="service_hunter_fee" cols="80" rows="10">
                        {{ old('service_hunter_fee',$service_hunter->service_hunter_fee ?? '') }}  </textarea>
                </div>
                <div class="form-group">
                    <label for="service_hunter_contact">Liên lạc</label>
                    <textarea id="service_hunter_contact" class="editor" name="service_hunter_contact" cols="80" rows="10">
                       {{ old('service_hunter_contact',$service_hunter->service_hunter_contact ?? '') }}    </textarea>
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
                            {{ ($service_price->service_price_id==$service_hunter->service_price_id) ? 'selected' : '' }}
                            >{{ $service_price->service_price_title }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Lưu thông tin</button>
            </form>
        </div>
    </div>
</section>
@endsection