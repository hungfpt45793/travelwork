@extends('staff_admin.layouts.master')
@section('title', 'Thêm mới đơn hàng tuyển dụng' )
@section('content')
<section class="content">
    <div class="row box row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.order')
            </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting col-f14 m-2 ">
                <div class="row">
        <div class="col-md-12">
            @if($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert" style="padding: 5px;margin: 2px;display: inline-block;">
                <strong>{{ $error }}</strong>
            </div>
            @endforeach
            @endif

            <form action="{{ route('staff_icon_order.store') }}" method="POST">
                {{ csrf_field() }}
                <input type="text" hidden name="employer_id" value="{{ $_GET['employer_id'] }}">
                <div class="form-group">
                    <label for="service_price_id">Chọn dịch vụ</label>
                    <select name="service_price_id" class="select22 form-control" id="service_price_id">
                        <option value="">--Chọn dịch vụ--</option>
                        @php
                        $service_prices = \App\Entity\Service_price::where('service_price_type',1)->get();
                        @endphp
                        @foreach ($service_prices as $service_price)
                        <option value="{{ $service_price->service_price_id }}" selected>{{ $service_price->service_price_title }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="service_icon_id">Chọn icon</label>
                    <select name="service_icon_id" class="select22 form-control" id="service_icon_id">
                        <option value="0">--Chọn icon--</option>
                        @php
                        $service_icons = \App\Entity\Service_icon::get();
                        @endphp
                        @foreach ($service_icons as $service_icon)
                        <option value="{{ $service_icon->service_icon_id}}"
                            {{ (old('service_icon_id')==$service_icon->service_icon_id) ? 'selected' : '' }}
                            >
                            {{ $service_icon->service_icon_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Thanh toán</label>
                    <select name="status" class="select22 form-control" id="status">
                        <option value="">--Chọn trạng thái đơn hàng--</option>
                        <option value="0" {{ (old('status')==0) ?? 'selected' }} >Chưa TT</option>
                        <option value="1" {{ (old('status')==1) ?? 'selected' }} >Đã TT</option>
                    </select>
                </div>
                {{-- <div class="form-group">
                    <label for="service_order_price">Giá đơn hàng</label>
                    <input type="text" class="form-control" name="service_order_price" value="{{ old('service_order_price') }}">
                </div>
                <div class="form-group">
                    <label for="service_order_discount">Chiết khấu</label>
                    <input type="text" class="form-control" name="service_order_discount" value="{{ old('service_order_discount') }}">
                </div>
                <div class="form-group">
                    <label for="service_order_vat">Giá vat</label>
                    <input type="text" class="form-control" name="service_order_vat" value="{{ old('service_order_vat') }}">
                </div>

                <div class="form-group">
                    <label for="service_order_benifit">Quyền lợi</label>
                    <textarea id="service_order_benifit" class="editor" name="service_order_benifit" cols="80"
                        rows="10">
                          {{ old('service_order_benifit') }}  </textarea>
                </div>
                <div class="form-group">
                    <label for="service_order_endow">Lợi ích</label>
                    <textarea id="service_order_endow" class="editor" name="service_order_endow" cols="80"
                        rows="10">
                          {{ old('service_order_endow') }}  </textarea>
                </div>
                <div class="form-group">
                    <label for="employer_name">Tên NTD</label>
                    <input type="text" class="form-control" name="employer_name" value="{{ old('employer_name') }}">
                </div>
                <div class="form-group">
                    <label for="employer_phone">SĐT NTD</label>
                    <input type="text" class="form-control" name="employer_phone" value="{{ old('employer_phone') }}">
                </div>
                <div class="form-group">
                    <label for="employer_email">Email NTD</label>
                    <input type="text" class="form-control" name="employer_email" value="{{ old('employer_email') }}"> --}}
                {{-- </div> --}}
                <div class="form-group">
                    <label for="service_order_icon_content">Ghi chú</label>
                    <textarea id="service_order_icon_content" class="editor" name="service_order_icon_content" cols="80"
                        rows="10">
                          {{ old('service_order_icon_content') }}  </textarea>
                </div>
                <button type="submit" class="btn btn-success">Thêm</button>
            </form>
        </div>
    </div>
                </div>
            </section>
        </div>
    </div>
</section>
@endsection
