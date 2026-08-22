@extends('staff_admin.layouts.master')
@section('title', 'Danh sách NTD' )
@section('content')
<section class="content">
    <div class="row row-content box">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.order')
            </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting col-f14 m-2 ">
                    <div class="row ">
                        <div class="col-md-12">
                            @if($errors->any())
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert" style="padding: 5px;margin: 2px;display: inline-block;">
                                <strong>{{ $error }}</strong>
                            </div>
                            @endforeach
                            @endif

                            <form action="{{ route('staff_service_order.store') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for=""><b><b class="text-uppercase">Chọn nhà tuyển dụng</b></b></label>
                                    <select name="employer_id" id="select2_employer" class="">
                                        @if(old('employer_id'))
                                            @php
                                                $old_employer = \App\Entity\Employer::select('employer_id', 'email', 'enterprise_name')->where('employer_id', old('employer_id'))->first();
                                            @endphp
                                            <option selected value="{{ old('employer_id') }}">
                                                {{$old_employer->email}}-{{$old_employer->enterprise_name}}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="mb-2 col-12">
                                        <select name="service_price_id" class="select22 form-control" id="service_price_id">
                                            <option value="">--Chọn dịch vụ--</option>
                                            @php
                                            $service_prices = \App\Entity\Service_price::where('service_price_type',0)->get();
                                            @endphp
                                            @foreach ($service_prices as $service_price)
                                            <option value="{{ $service_price->service_price_id }}"
                                                {{ (old('service_price_id')==$service_price->service_price_id) ? 'selected' : '' }}
                                                >{{ $service_price->service_price_title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2 col-12">
                                        <select name="service_table_price_id" class="select22 form-control" id="service_table_price_id">
                                            <option value="0">--Chọn gói dịch vụ--</option>
                                            @php
                                            $service_table_prices = \App\Entity\Service_table_price::get();
                                            @endphp
                                            @foreach ($service_table_prices as $service_table_price)
                                            <option value="{{ $service_table_price->service_table_price_id }}"
                                                {{ (old('service_table_price_id')==$service_table_price->service_table_price_id) ? 'selected' : '' }}
                                                >
                                                {{ $service_table_price->package_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2 col-12">
                                        <select name="status" class="select22 form-control" id="status">
                                            <option value="">--Chọn trạng thái đơn hàng--</option>
                                            <option value="0" {{ (old('status')==0) ?? 'selected' }} >Chưa TT</option>
                                            <option value="1" {{ (old('status')==1) ?? 'selected' }} >Đã TT</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="service_order_content">Ghi chú</label>
                                        <textarea id="service_order_content" class="editor" name="service_order_content" cols="80"
                                            rows="10">
                                            {{ old('service_order_content') }}  </textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">Thêm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
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
@endsection
