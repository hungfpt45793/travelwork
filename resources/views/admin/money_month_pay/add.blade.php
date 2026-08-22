@extends('admin.layout.admin')

@section('title', 'Thêm mới  lượng tiền quy đổi trong tháng')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới  lượng tiền quy đổi trong tháng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới  lượng tiền quy đổi trong tháng</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('money_month.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
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
                                <input type="text" class="form-control formatPrice" name="total_money_month" placeholder="Lượng tiền tối đa trong tháng" value="{{ old('product_name') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sử dụng trong tháng</label>
                                <input type="month" class=" form-control" name="money_month_year" placeholder="Sử dụng trong tháng" value="<?php
                               echo date("Y-m");
                                ?>" required>
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