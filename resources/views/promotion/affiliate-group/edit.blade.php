@extends('admin.layout.admin')

@section('title', 'Thêm mới mã giảm giá')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới mã giảm giá
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Mã giảm giá</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('coupon.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-6">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên đợi phát hành</label>
                                <input type="text" class="form-control" name="title" placeholder="Tên đợi phát hành" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea class="form-control" id="content" name="content" rows="10" cols="80"/></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Kiểu giảm giá</label>
                                <select class="form-control" name="template">
                                    <option value="default">Kiểu giảm giá</option>
                                    <option value="default">Tiền mặt</option>
                                    <option value="default">Chiết khấu %</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá trị coupon</label>
                                <input type="text" class="form-control" name="title" placeholder="Giá trị coupon" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái hoạt động</label>
                                <select class="form-control" name="template">
                                    <option value="default">Hoạt động</option>
                                    <option value="default">Ngừng hoạt động</option>
                                </select>
                            </div>

                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="box box-primary">
                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Ngày bắt đầu</label>
                                <input type="date" class="form-control" name="title" placeholder="Ngày bắt đầu" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Ngày kết thúc</label>
                                <input type="date" class="form-control" name="title" placeholder="Ngày kết thúc" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Số lượng coupon</label>
                                <input type="text" class="form-control" name="title" placeholder="Số lượng coupon" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Số lần sử dụng</label>
                                <input type="text" class="form-control" name="title" placeholder="Số lần sử dụng" required>
                            </div>
                        </div>
                    </div>


                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                    <!-- /.box -->

                </div>

            </form>
        </div>
    </section>
@endsection

