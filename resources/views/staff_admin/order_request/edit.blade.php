@extends('staff_admin.layouts.master')
@section('title', 'Chỉnh sửa yêu cầu thực hiện đơn hàng' )
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
                            <h3 class="text-center">Chỉnh sửa yêu cầu thực hiện đơn hàng</h3>
                            <form action="{{ route('staff_order_request.update', $order_request->order_request_id) }}"
                                enctype="multipart/form-data" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('PUT') !!}
                                <div class="form-group">
                                    <label for=""><b><b class="text-uppercase">Chọn nhà tuyển dụng</b></b></label>
                                    <select name="employer_id" id="select2_employer" class="">
                                        <option value="">--Chọn nhà tuyển dụng--</option>
                                        <?php
                                            $employer = \App\Entity\Employer::select('employer_id', 'email', 'enterprise_name')->where('employer_id', $order_request->employer_id)->first();
                                        ?>
                                        <option selected value="{{ $employer->employer_id }}">
                                            {{$employer->email}}-{{$employer->enterprise_name}}
                                        </option>
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
                                <b class="d-block text-uppercase">
                                    HOẶC
                                    <a href="{{ route('staff_employer.create') }}" target="_blank"
                                        style="cursor: pointer;"
                                        class="d-inline font-weight-bold font-italic text-primary">
                                        TẠO NHÀ TUYỂN DỤNG
                                    </a>
                                </b>
                                <div class="form-group row">
                                    <div class="col-md-12 col-12">
                                        <label for=""><b>Chọn đơn đặt tuyển dụng</b></label>
                                        <select name="hunter_regis_id" id="select_hunter_regis_id" class="select22">
                                            <option value="">--Chọn đơn đặt tuyển dụng--</option>
                                            <?php
                                            $hunter_registrations = \App\Entity\Hunter_registration::select(
                                                'hunter_registration.hunter_regis_id',
                                                'hunter_registration.hunter_regis_code',
                                                'hunter_pos.hunter_pos_name'
                                            )
                                            ->join('hunter_pos', 'hunter_pos.hunter_pos_id', 'hunter_registration.hunter_regis_pos')
                                            ->get();
                                            ?>
                                            @foreach($hunter_registrations as $hunter_registration)
                                            <option @if($hunter_registration->hunter_regis_id ==
                                                $order_request->hunter_regis_id) selected @endif
                                                value="{{ $hunter_registration->hunter_regis_id }}">
                                                {{$hunter_registration->hunter_regis_code}}-{{$hunter_registration->hunter_pos_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for=""><b>Ngày bắt đầu tuyển dụng</b></label>
                                        <input type="date" class="form-control" name="start_time" value="<?php
                                                $date_end=date_create($order_request->start_time);
                                                echo date_format($date_end,"Y-m-d");
                                                ?>">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for=""><b>Vị trí tuyển dụng</b></label>
                                        <input type="text" name="hunter_pos" id="input_hunter_pos" class="form-control"
                                            value="{{ old('hunter_pos', $order_request->hunter_pos) }}">
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col-md-3 col-12">
                                        <label for=""><b>Thời gian tuyển dụng</b></label>
                                        <input type="number" class="form-control" id="input_hunter_time"
                                            name="hunter_time"
                                            value="{{ old('hunter_time', $order_request->hunter_time) }}">
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <label for=""><b>Thời gian bảo hành(Ngày)</b></label>
                                        <input type="number" name="guarantee_time" class="form-control"
                                            value="{{ old('guarantee_time', $order_request->guarantee_time) }}">
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <label for=""><b>Chi phí</b></label>
                                        <input type="text" name="order_request_price" id="input_order_request_price"
                                            class="form-control"
                                            value="{{ old('order_request_price', $order_request->order_request_price) }}">
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <label for=""><b>Chi phí sau giảm</b></label>
                                        <input type="text" name="order_request_discount"
                                            id="input_order_request_discount" class="form-control"
                                            value="{{ old('order_request_discount', $order_request->order_request_discount) }}">
                                    </div>
                                    <div class="col-md-6 col-12 mt-1">
                                        <label for=""><b>Tải lên file hợp đồng</b></label>
                                        <input type="file" class="" name="file_upload_contract">
                                        <br>
                                        <label for=""><b>Hình ảnh nội dung thanh toán</b></label>
                                        <input type="file" name="image_pay" id="image_pay">
                                        <?php 
                                            if($order_request->image_pay){
                                                $src_image = $order_request->image_pay;
                                            }
                                            else{
                                                $src_image = 'https://www.riobeauty.co.uk/images/product_image_not_found.gif';
                                            }
                                            
                                        ?>
                                        <img id="preview-image-before-upload" src="{{ $src_image }}" alt="preview image"
                                            style="max-height: 60px;">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="advance_status_pay"
                                                id="input_advance_status_pay" value="1"
                                                {{ (old('advance_status_pay',$order_request->advance_status_pay) == 1) ? 'checked' : '' }}>
                                            <label for="input_advance_status_pay"><b>Trạng thái thanh toán lần
                                                    1</b></label>
                                            <br>

                                            <input type="checkbox" class="form-check-input" name="all_status_pay"
                                                id="input_all_status_pay" value="1"
                                                {{ (old('all_status_pay',$order_request->all_status_pay) == 1) ? 'checked' : '' }}>
                                            <label for="input_all_status_pay"><b>Trạng thái thanh toán lần 2</b></label>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-2">Chỉnh sửa yêu cầu đơn
                                            hàng</button>
                                    </div>
                                </div>
                                <br>
                                <b class="text-uppercase">
                                    <a class="d-inline font-weight-bold font-italic text-primary" data-toggle="collapse"
                                        href="#collapseExample" role="button" aria-expanded="false"
                                        aria-controls="collapseExample">
                                        thông tin thêm
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </a>
                                </b>
                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                        <div class="col-md-12">
                                            <label for=""><b>Mô tả công việc</b></label>
                                            <textarea name="job_description" id="des_job"
                                                class="editor">{{ old('job_description',$order_request->job_description) }}</textarea>
                                            <script>
                                            CKEDITOR.replace('des_job');
                                            </script>
                                        </div>
                                        <div class="col-md-12">
                                            <label for=""><b>Yêu cầu công việc</b></label>
                                            <textarea name="job_requirements" id="request_job"
                                                class="editor">{{ old('job_requirements', $order_request->job_requirements) }}</textarea>
                                            <script>
                                            CKEDITOR.replace('request_job');
                                            </script>
                                        </div>
                                        <div class="col-md-12">
                                            <label for=""><b>Phúc lợi xã hội</b></label>
                                            <textarea name="welfare" id="welfare_job"
                                                class="editor">{{ old('welfare', $order_request->welfare) }}</textarea>
                                            <script>
                                            CKEDITOR.replace('welfare_job');
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h3 class="text-center">Hợp đồng tuyển dụng</h3>
                                        <iframe style="width: 100%;height: 550px"
                                            src="https://docs.google.com/gview?url={{ asset($order_request->file_upload_contract) }}&embedded=true"
                                            frameborder="0"></iframe>
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
<script type="text/javascript">
function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}
$(document).ready(function() {
    $('#province').change(function() {
        $.get('/ajax-district/' + $(this).val(), function(data) {
            $('#district').html(data);
        });
    });
    $('#image_pay').change(function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-image-before-upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
    //format number
    let order_request_price = $('input[name="order_request_price"]').val();
    let order_request_discount = $('input[name="order_request_discount"]').val();

    $('input[name="order_request_price"]').val(formatNumber(order_request_price));
    $('input[name="order_request_discount"]').val(formatNumber(order_request_discount));

    $('input[name="order_request_price"]').on('keyup', function() {
        let number = ($(this).val()).replaceAll(",", "");
        $(this).val(formatNumber(number))
        $('input[name="order_request_discount"]').val(formatNumber(number));
    })
    $('input[name="order_request_discount"]').on('keyup', function() {
        let number = ($(this).val()).replaceAll(",", "");
        $(this).val(formatNumber(number))
    })

    // ajax chon don dat tuyem dung
    $('#select_hunter_regis_id').on('change', function() {
        let hunter_regis_id = $(this).val();
        $.ajax({
            'type': 'get',
            'url': "{{ route('get_info_hunter_register') }}",
            'data': {
                hunter_regis_id
            },
            'success': function(res) {
                $('#input_hunter_pos').val(res.hunter_pos_name)
                $('#input_hunter_time').val(res.time)
                $('#input_order_request_price').val(formatNumber(res.hunter_price))
                $('#input_order_request_discount').val(formatNumber(res.hunter_price))
            }
        })
    })
});
</script>
@endsection