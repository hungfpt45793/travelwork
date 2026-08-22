@extends('admin.layout.admin')

@section('title', ' Thông tin ứng viên')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thông tin ứng viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content" style="background-color: #fff;" >
        <div class="row">
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">

                    <p>ID ứng viên : <span style="font-weight: bold">{{ isset($employee->employee_id) ? $employee->employee_id : 'Chưa có thông tin' }}</span> </p>
                    <p>Tên : <span style="font-weight: bold">{{ isset($employee->employee_name) ? $employee->employee_name : 'Chưa có thông tin' }}</span> </p>
                    <p>Email : <span style="font-weight: bold"> {{ isset($employee->email) ? $employee->email : 'Chưa có thông tin' }} </span></p>
                    <p>Số điện thoại : <span style="font-weight: bold">  {{ isset($employee->phone) ? $employee->phone : 'Chưa có thông tin' }} </span></p>
                    <?php
                    $provice = \App\Entity\Province::getId($employee->province);
                    $district = \App\Entity\District::getId($employee->district);
                    ?>
                    <p>Địa chỉ :
                        <span style="font-weight: bold">
                    @if(!empty($district->district_name)) {{ $district->district_name }} @endif
                            -
                            @if(!empty($provice->province_name)) {{ $provice->province_name }} @endif

                </span>
                    </p>
                    <p>Tổng số lượt chia sẻ bài viết: <span style="font-weight: bold">  {{ isset($employee->total_sale) ? $employee->total_sale : 'Chưa có thông tin' }} </span></p>
                    <p>Tổng số lượt xem : <span style="font-weight: bold">  {{ isset($employee->total_view) ? $employee->total_view : 'Chưa có thông tin' }} </span></p>
                    <p>Tổng số tiền : <span style="font-weight: bold;color: red">  {{ isset($employee->total_money) ? number_format($employee->total_money) : 0 }} VND</span></p>
                    <p>Số tiền đã đổi qua thẻ cào : <span style="font-weight: bold;color: red">  {{ isset($employee->total_change_crad) ? number_format($employee->total_change_crad) : 0 }} VND</span></p>
                    <p>Số tiền đã đổi qua chuyển khoản : <span style="font-weight: bold;color: red">  {{ isset($employee->total_change_bank) ? number_format($employee->total_change_bank) : 0 }} VND</span></p>
                    <p>Số tiền đã đổi qua phần mềm : <span style="font-weight: bold;color: red">  {{ isset($employee->total_change_product) ? number_format($employee->total_change_product) : 0 }} VND</span></p>
                    <p>Số dư hiện tại : <span style="font-weight: bold;color: red">  {{ isset($employee->money) ? number_format($employee->money) : 0 }} VND</span></p>
                    <input type="hidden" name="employee_id" value="{{ isset($employee->employee_id) ? $employee->employee_id : 'Chưa có thông tin' }}">

                </div>


            </div>
        </div>
    </section>
@endsection