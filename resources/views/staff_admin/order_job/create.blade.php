@extends('staff_admin.layouts.master')
@section('title', 'Thêm mới đơn hàng tuyển dụng' )
@section('content')
<section class="content">
    <div class="row box row-content mr-0">
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
                            <div class="alert alert-danger" role="alert"
                                style="padding: 5px;margin: 2px;display: inline-block;">
                                <strong>{{ $error }}</strong>
                            </div>
                            @endforeach
                            @endif
                            @if(session('error'))
                            <div class="alert alert-danger" role="alert"
                                style="padding: 5px;margin: 2px;display: inline-block;">
                                <strong>{{ session('error') }}</strong>
                            </div>
                            @endif
                            <h3 class="text-center">Thêm mới đơn hàng tuyển dụng</h3>
                            <form action="{{ route('staff_order_job.store') }}" enctype="multipart/form-data"
                                method="POST">
                                {!! csrf_field() !!}
                                <div class="form-group row">
                                    <div class="col-md-6 col-12 ">
                                        <label for=""><b> Chọn yêu cầu thực hiện đơn hàng</b></label>
                                        <select name="order_request_id" class="select22">
                                            <option value="">--Chọn yêu cầu thực hiện đơn hàng--</option>
                                            <?php
                                                $order_requests = \App\Entity\Order_request::select('order_request_id', 'order_request_code', 'hunter_pos')->orderBy('order_request_id', 'desc')->get();
                                            ?>
                                            @foreach($order_requests as $order_request)
                                            <option @if(isset($order_req->order_request_id) &&
                                                $order_req->order_request_id == $order_request->order_request_id)
                                                selected @endif
                                                @if(old('order_request_id') == $order_request->order_request_id)
                                                selected @endif
                                                value="{{ $order_request->order_request_id }}">
                                                {{ $order_request->order_request_code }} - {{ $order_request->hunter_pos }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12 ">
                                        <label for=""><b> Ngày bắt đầu tuyển dụng</b></label>
                                        <input type="date" class="form-control" name="start_time"
                                        value="<?php
                                            if(isset($order_req->start_time)){
                                                $date_end=date_create($order_req->start_time);
                                                echo date_format($date_end,"Y-m-d");
                                            }
                                            if(old('start_time')){
                                                $date_end=date_create(old('start_time'));
                                                echo date_format($date_end,"Y-m-d");
                                            }
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 col-12">
                                        <label for="">
                                            <b class="">Chọn nhà tuyển dụng</b>
                                            <b class=" ">
                                                HOẶC
                                                <a href="{{ route('staff_employer.create') }}" target="_blank"
                                                    style="cursor: pointer;"
                                                    class="d-inline font-weight-bold font-italic text-primary">
                                                    TẠO NHÀ TUYỂN DỤNG
                                                </a>
                                            </b>
                                        </label>
                                        <select name="employer_id" id="select2_employer" class="">
                                            <option value="">--Chọn nhà tuyển dụng--</option>
                                            @if(isset($order_req->employer_id))
                                            <?php $employer = \App\Entity\Employer::select('employer_id', 'email', 'enterprise_name')->where('employer_id', $order_req->employer_id)->first(); ?>
                                            <option value="{{ $employer->employer_id }}" selected>
                                                {{ $employer->email }}-{{ $employer->enterprise_name }}
                                            </option>
                                            @endif
                                            @if(old('employer_id'))
                                            <?php
                                                    $old_employer = \App\Entity\Employer::select('employer_id', 'email', 'enterprise_name')->where('employer_id', old('employer_id'))->first();
                                                ?>
                                            <option selected value="{{ old('employer_id') }}">
                                                {{$old_employer->email}}-{{$old_employer->enterprise_name}}
                                            </option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for="">
                                            <b class="">Chọn việc làm</b>
                                            <b class=" ">
                                                HOẶC
                                                <a href="{{ route('form_create_job') }}" target="_blank"
                                                    style="cursor: pointer;"
                                                    class="d-inline font-weight-bold font-italic text-primary">
                                                    TẠO MỚI VIỆC LÀM
                                                </a>
                                            </b>
                                        </label>
                                        <select name="job_id" id="select2_job" class="select22">
                                            <option value="" selected>--Chọn việc làm--</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-md-6 col-12 ">
                                        <label for=""><b> Chọn đơn đặt tuyển dụng</b></label>
                                        <select name="hunter_regis_id" id="select_hunter_regis_id" class="select22">
                                            <option value="">--Chọn đơn đặt tuyển dụng--</option>
                                            <?php
                                            $hunter_registrations = \App\Entity\Hunter_registration::select(
                                                'hunter_registration.hunter_regis_id',
                                                'hunter_registration.hunter_regis_code',
                                                'hunter_pos.hunter_pos_name'
                                            )
                                            ->join('hunter_pos', 'hunter_pos.hunter_pos_id', 'hunter_registration.hunter_regis_pos')->orderBy('hunter_registration.hunter_regis_id', 'desc')
                                            ->get();
                                            ?>
                                            @foreach($hunter_registrations as $hunter_registration)
                                            <option 
                                            @if(isset($order_req->hunter_regis_id) && $order_req->hunter_regis_id == $hunter_registration->hunter_regis_id) selected @endif
                                            @if(old('hunter_regis_id') == $hunter_registration->hunter_regis_id)
                                            selected
                                            @endif
                                            value="{{ $hunter_registration->hunter_regis_id }}">
                                                {{$hunter_registration->hunter_regis_code}}-{{$hunter_registration->hunter_pos_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-12 ">
                                        <label for=""><b> Chi phí</b></label>
                                        <input type="text" name="order_job_price" id="input_order_job_price"
                                            class="form-control" value="@if(isset($order_req->order_request_price)) {{old('order_job_price', $order_req->order_request_price)}} @endif">
                                    </div>
                                    <div class="col-md-3 col-12 ">
                                        <label for=""><b> Chi phí sau giảm</b></label>
                                        <input type="text" name="order_job_discount"
                                            id="input_order_job_discount" class="form-control"
                                            value="@if(isset($order_req->order_request_discount)) {{old('order_job_discount', $order_req->order_request_discount)}} @endif">
                                    </div>
                                    <div class="col-md-6 col-12 ">
                                        <label for=""><b> Thời gian bảo hành(Ngày)</b></label>
                                        <input type="number" name="order_job_guarantee" class="form-control" value="{{old('order_job_guarantee', 60)}}">
                                    </div>
                                    <div class="col-md-3 col-12 ">
                                        <label for=""><b> Thanh toán(1)</b></label>
                                        <select name="order_job_statu_pay" class="select22 from-control">
                                            <option value="0" selected>Chưa thanh toán</option>
                                            <option value="1"@if(isset($order_req->advance_status_pay)) {{($order_req->advance_status_pay == 1) ? 'selected' : '' }}@endif
                                            @if(old('order_job_statu_pay')) {{(old('order_job_statu_pay') == 1) ? 'selected' : '' }}@endif
                                            >
                                                Đã thanh toán</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-12 ">
                                        <label for=""><b> Thanh toán(2)</b></label>
                                        <select name="order_job_status_pay_all" class="select22 from-control">
                                            <option value="0" selected>Chưa thanh toán</option>
                                            <option value="1"@if(isset($order_req->all_status_pay)) {{($order_req->all_status_pay == 1) ? 'selected' : ''}} @endif
                                            @if(old('order_job_status_pay_all')) {{(old('order_job_status_pay_all') == 1) ? 'selected' : ''}} @endif
                                            >Đã thanh toán</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 col-12">
                                        <label for=""><b> Tải lên file hợp đồng</b></label>
                                        <input type="file" class="form-control" name="file_upload_contract">
                                        <br>
                                        <label for=""><b>Mô tả đơn hàng</b></label>
                                        <textarea name="order_job_des" id="order_job_des" class="form-control">
                                            {{ old('order_job_des') ? old('order_job_des') : '' }}
                                        </textarea>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for=""><b> Hình ảnh chụp nội dung thanh toán</b></label>
                                        <input type="file" class="form-control" id="order_job_statu_content" name="order_job_statu_content">
                                        <img id="preview-image-before-upload"
                                            src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                                            alt="preview image" style="max-height: 60px;">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 col-12 ">
                                        <button type="submit" class="btn btn-primary ">Tạo đơn hàng</button>
                                    </div>
                                </div>
                                @if(isset($order_req->file_upload_contract))
                                <div class="row">
                                    <div class="col-12">
                                        <h3 class="text-center">Hợp đồng đơn hàng</h3>
                                        <iframe style="width: 100%;height: 550px"
                                            src="https://docs.google.com/gview?url={{ asset($order_req->file_upload_contract) }}&embedded=true"
                                            frameborder="0">
                                        </iframe>
                                    </div>
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<script>
function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}
$(document).ready(function(){
    //format number
    let order_job_price = $('input[name="order_job_price"]').val();
    let order_job_discount = $('input[name="order_job_discount"]').val();

    $('input[name="order_job_price"]').val(formatNumber(order_job_price));
    $('input[name="order_job_discount"]').val(formatNumber(order_job_discount));

    $('input[name="order_job_price"]').on('keyup', function() {
        let number = ($(this).val()).replaceAll(",", "");
        $(this).val(formatNumber(number));
        $('input[name="order_job_discount"]').val(formatNumber(number));
    })
    $('input[name="order_job_discount"]').on('keyup', function() {
        let number = ($(this).val()).replaceAll(",", "");
        $(this).val(formatNumber(number))
    })
    $('#order_job_statu_content').change(function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            console.log(e.target);
            $('#preview-image-before-upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
})
</script>
@endsection