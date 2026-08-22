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
    <div class="row  box">
        <div class="col-md-12">
            @if($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert" style="padding: 5px;margin: 2px;display: inline-block;">
                <strong>{{ $error }}</strong>
            </div>
            @endforeach
            @endif
            @if (session('success'))
                <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                    <div class="alert alert-success mg-b-0 ">
                        {{session('success')}}
                        <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                    </div>
                </div>
                @endif
            <form action="{{ route('service_icon.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="service_icon_name">Tên icon</label>
                    <input type="text" value="{{ old('service_icon_name') }}" id="service_icon_name" name="service_icon_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Chọn ảnh</label>
                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                           size="20"/>
                    <img src="" width="80" height="70"/>
                    <input name="service_icon_image" type="hidden" />
                </div>
                <div class="form-group">
                    <label for="service_icon_time">Thời gian tồn tại</label>
                    <input type="text" value="{{ old('service_icon_time') }}" id="service_icon_time" name="service_icon_time" class="form-control">
                </div>
                <div class="form-group">
                    <label for="service_icon_price">Giá</label>
                    <input type="text" id="service_icon_price" value="{{ old('service_icon_price') }}" name="service_icon_price" class="form-control">
                </div>
                <div class="form-group">
                    <label for="service_icon_vat">Giá vat</label>
                    <input type="text" id="service_icon_vat" value="{{ old('service_icon_vat') }}" name="service_icon_vat" class="form-control">
                </div>
                <div class="form-group">
                    <label for="service_icon_info">Giới thiệu</label>
                    <textarea id="service_icon_info" class="editor" name="service_icon_info" cols="80" rows="10">
                       {{ old('service_icon_info') }}    </textarea>
                </div>
                <div class="form-group">
                    <label for="service_price_id">Chọn dịch vụ</label>
                    <select name="service_price_id" class="select2" id="service_price_id">
                        <option value="">--Chọn dịch vụ--</option>
                        @php
                            $service_prices = \App\Entity\Service_price::get();
                        @endphp
                        @foreach ($service_prices as $service_price)
                        <option value="{{ $service_price->service_price_id }}">{{ $service_price->service_price_title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input  type="checkbox" id="keep_status" class="form-check-input"  name="optradio">Ở lại trang sau khi thêm
                    </label>
                </div>
                <button type="submit" class="btn btn-success">Thêm</button>
            </form>
        </div>
    </div>
</section>
<script>
    $(function() {
        $('#keep_status').change(function() {
            if ($(this).is(':checked')) {
                localStorage.setItem('keep_status', 'ok');
            }
            else localStorage.removeItem('keep_status');
        });
        if(localStorage.getItem('keep_status') != null){
            $('#keep_status').attr( 'checked', true )
        }
    })
</script>
@endsection