<?php

$date =date_create($money_month_pay->money_month_year);
?>
@extends('admin.layout.admin')

@section('title',  date_format($date,"m/Y")  )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">


        <h1>
            Cập nhật  tháng{{ date_format($date,"m/Y") }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('money_month.update',['money_id'=> $money_month_pay->money_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thêm mới  lượng tiền quy đổi trong tháng</h3>
                        </div>

                        <div class="box-body">

                            @if($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger" role="alert" style="padding: 5px;margin: 2px;display: inline-block;">
                                        <strong>{{ $error }}</strong>
                                    </div>
                                @endforeach
                            @endif

                            <div class="form-group">
                                <label for="exampleInputEmail1">Lượng tiền tối đa trong tháng</label>
                                <input type="text" class="form-control formatPrice" name="total_money_month" placeholder="Lượng tiền tối đa trong tháng" value="{{ $money_month_pay->total_money_month }}" required>
                            </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số dư còn lại</label>
                                    <input type="text" class="form-control formatPrice" name="money_surplus" placeholder="Lượng tiền còn lại trong tháng" value="{{ $money_month_pay->money_surplus }}" required>
                                </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sử dụng trong tháng</label>
                                <input type="month" class=" form-control" name="money_month_year" placeholder="Sử dụng trong tháng" value="{{ date_format($date,"Y-m") }}" required>
                            </div>

                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection