@extends('admin.layout.admin')

@section('title', 'Sửa đơn hàng icon' )

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Sửa đơn hàng icon
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

            <form action="{{ route('service_order_icon.update', $service_order_icon->service_order_icon_id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="service_price_id">Chọn dịch vụ</label>
                    <select name="service_price_id" class="select2" id="service_price_id">
                        <option value="">--Chọn dịch vụ--</option>
                        @php
                        $service_prices = \App\Entity\Service_price::where('service_price_type', 1)->get();
                        @endphp
                        @foreach ($service_prices as $service_price)
                        <option value="{{ $service_price->service_price_id }}" selected>{{ $service_price->service_price_title }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="service_icon_id">Chọn icon</label>
                    <select name="service_icon_id" class="select2" id="service_icon_id">
                        <option value="0">--Chọn icon--</option>
                        @php
                        $service_icons = \App\Entity\Service_icon::get();
                        @endphp
                        @foreach ($service_icons as $service_icon)
                        <option value="{{ $service_icon->service_icon_id}}"
                            {{ ($service_order_icon->service_icon_id==$service_icon->service_icon_id) ? 'selected' : '' }}
                            >
                            {{ $service_icon->service_icon_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Thanh toán</label>
                    <select name="status" class="select2" id="status">
                        <option value="">--Chọn trạng thái đơn hàng--</option>
                        <option value="0" {{ ($service_order_icon->status==0) ? 'selected' : '' }} >Chưa TT</option>
                        <option value="1" {{ ($service_order_icon->status==1) ? 'selected' : '' }} >Đã TT</option>
                    </select>
                </div>
                {{-- <div class="form-group">
                    <label for="service_order_icon_price">Giá đơn hàng</label>
                    <input type="text" class="form-control" name="service_order_icon_price" value="{{ old('service_order_icon_price') }}">
                </div>
                <div class="form-group">
                    <label for="service_order_icon_discount">Chiết khấu</label>
                    <input type="text" class="form-control" name="service_order_icon_discount" value="{{ old('service_order_icon_discount') }}">
                </div>
                <div class="form-group">
                    <label for="service_order_icon_vat">Giá vat</label>
                    <input type="text" class="form-control" name="service_order_icon_vat" value="{{ old('service_order_icon_vat') }}">
                </div>

                <div class="form-group">
                    <label for="service_order_icon_benifit">Quyền lợi</label>
                    <textarea id="service_order_icon_benifit" class="editor" name="service_order_icon_benifit" cols="80"
                        rows="10">
                          {{ old('service_order_icon_benifit') }}  </textarea>
                </div>
                <div class="form-group">
                    <label for="service_order_icon_endow">Lợi ích</label>
                    <textarea id="service_order_icon_endow" class="editor" name="service_order_icon_endow" cols="80"
                        rows="10">
                          {{ old('service_order_icon_endow') }}  </textarea>
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
                          {{ old('service_order_icon_content', $service_order_icon->service_order_icon_content ?? '') }}  </textarea>
                </div>
                <button type="submit" class="btn btn-success">Lưu thông tin</button>
            </form>
        </div>
    </div>
</section>

@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $('#service_price_id').change(function () {
            $.ajax({
                url: "{{ route('ajaxServiceTable') }}",
                type: 'GET',
                data: {
                    service_price_id: $(this).val(),
                },
                success: function(data){
                    // var obj = jQuery.parseJSON(data);
                    console.log(data)
                    var html = '<option value="0">--Chọn gói dịch vụ--</option>';
                    $.each(data, function (index, element) {     
                        html += '<option value="'+ element.service_table_price_id +'">'+ element.package_name +'</option>'
                    })
                    $('#service_table_price_id').html('');
                    $('#service_table_price_id').append(html);
                }
            })
        });
    });
</script>
@endpush