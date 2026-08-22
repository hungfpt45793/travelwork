@extends('admin.layout.admin')

@section('title', 'Thêm mới vị trí tuyển dụng thuê' )
<style>
    table,tr,td, th{
        border:1px solid #333!important;
    }
</style>
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Thêm mới vị trí tuyển dụng thuê
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12 col-12">
            @if($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert" style="padding: 5px;margin: 2px;display: inline-block;">
                <strong>{{ $error }}</strong>
            </div>
            @endforeach
            @endif
           
            <form action="{{ route('hunter_order.store') }}" class="row" method="POST">
                {{ csrf_field() }}
                <input type="text" hidden name="employer_id" value="{{ $employer_id }}">
                <div class="form-group col-md-6 col-lg-6">
                    <label for=""><span class="float-right">Tên nhà tuyển dụng</span></label>
                    <input type="text" class="form-control" value="{{ $employer->enterprise_name }}" name="hunter_regis_name">
                </div>
                <div class="form-group col-md-6 col-lg-6">
                    <label for=""><span class="float-right">Email</span></label>
                    <input type="text" class="form-control " value="{{ $employer->email }}" name="hunter_regis_email">
                </div>
                <div class="form-group col-md-6 col-lg-6">
                    <label for=""><span class="float-right">Số điện thoại</span></label>
                    <input type="number" class="form-control " value="{{ $employer->phone }}" name="hunter_regis_phone">
                </div>
                <div class="form-group col-md-6 col-lg-6">
                    <label for=""><span class="float-right">Thanh toán</span></label>
                    <select name="hunter_regis_status" class="form-control " >
                        <option value="0">Chưa thanh toán</option>
                        <option value="1">Đã thanh toán</option>
                    </select>
                </div>
                <div class="form-group col-md-6 col-lg-6">
                    <label for=""><span class="float-right">Tỉnh/Thành phố</span></label>
                    <select class="form-control select2"  aria-label="Tỉnh/Thành phố"
                        id="province" required name="hunter_regis_province">
                        <option value=""> -- Tất cả các tỉnh/thành phố --</option>
                        @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                        <option
                        {{ ($employer->province==$province->province_id) ? 'selected' : ''}}
                        value="{{$province->province_id}}">{{$province->province_name}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6 col-lg-6">
                    <label for=""><span class="float-right">Quận/huyện</span></label>
                    <select class="form-control select2" 
                        aria-label="Quận/Huyện" id="district" required name="hunter_regis_district">
                        <option value=""> -- Tất cả các quận/huyện --</option>
                        @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                        <option
                        {{ ($employer->district==$district->district_id) ? 'selected' : ''}}
                        value="{{$district->district_id}}">{{$district->district_name}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-12 col-lg-12">
                    <label for=""><span class="float-right">Địa chỉ</span></label>
                    <input type="text" class="form-control" value="{{ $employer->address }}" required name="hunter_regis_address">
                </div>
                <table class="table table-bordered col-lg-12 col-md-2">
                    <tr>
                        <th rowspan="2" class="text-center">Vị trí cần tuyển</th>
                        <th colspan="{{ $hunters_time->count() }}" class="text-center">Thời gian</th>
                    </tr>
                    <tr>
                        @foreach ($hunters_time as $hunter_time)
                        <th class="text-center">{{ $hunter_time->hunter_time_name }}</th>
                        @endforeach
                    </tr>
                    @foreach ($hunters_pos as $hunter_pos)
                    <tr>
                        @php
                        $hunters_price =
                        \App\Http\Controllers\Site\ListPriceController::getHunterPrice($hunter_pos->hunter_pos_id)
                        @endphp
                        <td class="text-center">{{ $hunter_pos->hunter_pos_name }}</td>
                        @foreach ($hunters_price as $hunter_price)
                        <td><span class="float-right hunter_regis_price"><input type="radio"
                                    data="btn{{ $hunter_pos->hunter_pos_id }}"
                                    name="hunter_regis_price"
                                    id="id{{ $hunter_price->hunter_price_id }}"
                                    value="{{ $hunter_price->hunter_price_id }}"> <label
                                    for="id{{ $hunter_price->hunter_price_id }}">{{ $hunter_price->hunter_price_name }}</label></span>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </table>
                <div class="form-group col-lg-12 col-md-12">
                    <label for=""><span class="float-right">Ghi chú</span></label>
                    <textarea type="text" class="form-control " placeholder="" rows="5" name="hunter_regis_note"></textarea>
                </div>
                <div class="form-group col-md-12 col-lg-12">
                    <label for=""><span class="float-right"></span></label>
                    <button type="submit" class="btn btn-success ">Đăng ký</button>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
    $('#province').change(function () {
        $.get('/ajax-district/' + $(this).val(), function (data) {
            $('#district').html(data);
        });
    });
});
</script>
@endsection
