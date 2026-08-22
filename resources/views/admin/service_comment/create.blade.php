@extends('admin.layout.admin')

@section('title', 'Thêm mới comment' )

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Thêm mới comment
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

            <form action="{{ route('service_comment.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="service_comment_name">Tên người comment</label>
                    <input type="text" id="service_comment_name" name="service_comment_name"
                        value="{{ old('service_comment_name') }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Chọn ảnh</label>
                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh" size="20" />
                    <img src="" width="80" height="70" />
                    <input name="service_comment_image" type="hidden" />
                </div>
                <div class="form-group">
                    <label for="service_comment_content">Nội dung comment</label>
                    <textarea id="service_comment_content" class="editor" name="service_comment_content" cols="80"
                        rows="10">
                          {{ old('service_comment_content') }}  </textarea>
                </div>
                <div class="form-group">
                    <label for="service_price_id">Chọn dịch vụ</label>
                    <select name="service_price_id" class="select2" id="service_price_id">
                        <option value="">--Chọn dịch vụ--</option>
                        @php
                        $service_prices = \App\Entity\Service_price::get();
                        @endphp
                        @foreach ($service_prices as $service_price)
                        <option value="{{ $service_price->service_price_id }}">{{ $service_price->service_price_title }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="service_table_price_id">Chọn gói dịch vụ</label>
                    <select name="service_table_price_id" class="select2" id="service_table_price_id">
                        <option value="0">--Chọn dịch vụ--</option>
                        @php
                        $service_table_prices = \App\Entity\Service_table_price::get();
                        @endphp
                        @foreach ($service_table_prices as $service_table_price)
                        <option value="{{ $service_table_price->service_table_price_id }}">
                            {{ $service_table_price->package_name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Thêm</button>
                <div id="test"></div>
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
                    var html = '<option value="0">--Chọn dịch vụ--</option>';
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