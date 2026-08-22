@extends('admin.layout.admin')

@section('title', 'Cập nhập đổi phần mềm')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhập đổi phần mềm
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhập đổi phần mềm</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('transaction_product.update',['transaction_id'=> $transaction_product->transaction_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-6 col-md-7">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin phần mềm</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên phần mềm</label>
                                <input type="text" class="form-control" name="transaction_product_name" placeholder="Độ tuổi" value="{{ $transaction_product->transaction_product_name }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá phần mềm</label>
                                <input type="text" class="form-control formatPrice" name="transaction_product_price" placeholder="Số tiền chuyển khoản" value="{{ $transaction_product->transaction_product_price }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung</label>
                                <textarea  class="form-control" readonly>{{ $transaction_product->transaction_content }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái giao dịch</label>

                                <div class="form-group">
                                    <label style="margin-right: 50px">
                                        <input type="radio" name="transaction_status" class="flat-red" value="0" @if($transaction_product->transaction_status == 0) checked @endif>
                                        Chưa giao dịch
                                    </label>
                                    <label style="margin-right: 50px">
                                        <input type="radio" name="transaction_status" class="flat-red" value="1" @if($transaction_product->transaction_status == 1) checked @endif>
                                        Hủy giao dịch
                                    </label>
                                    <label>
                                        <input type="radio" name="transaction_status" class="flat-red" value="2" @if($transaction_product->transaction_status == 2) checked @endif>
                                        Đã giao dịch
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung trả lời</label>
                                <textarea  class="form-control editor" name="transaction_admin_reply" id="transaction_admin_reply">{!! $transaction_product->transaction_admin_reply  !!}</textarea>
                                <input type="hidden" name="transaction_id" value="{{ $transaction_product->transaction_id }}">
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-warning">Cập nhật</button>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6 col-md-5">
                    <!-- Nội dung thêm mới -->
                    @include('admin.transaction.item_employee',['employee'=>$employee])
                </div>
            </form>
        </div>
    </section>
@endsection