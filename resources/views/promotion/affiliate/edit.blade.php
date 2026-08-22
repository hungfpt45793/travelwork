@extends('admin.layout.admin')

@section('title', 'Thêm mới nhóm affiliate')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới nhóm affiliate
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Nhóm affiliate</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('affiliate-group.store') }}" method="POST">
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
                                <label for="exampleInputEmail1">Mã affiliate</label>
                                <input type="text" class="form-control" name="title" placeholder="Mã affiliate" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thông tin tài khoản ngân hàng</label>
                                <textarea class="form-control" id="content" name="content" rows="3" cols="80"/></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nhóm affiliate</label>
                                <select class="form-control">
                                    <option>- Nhóm mã affiliate - </option>
                                    <option>- Nhóm AFF - </option>
                                    <option>- Nhóm Sách - </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại</label>
                                <input type="text" class="form-control" name="title" placeholder="Số điện thoại" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ</label>
                                <input type="text" class="form-control" name="title" placeholder="Số điện thoại" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Hoa Hồng</label>
                                <input type="text" class="form-control" name="title" placeholder="Số điện thoại" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Kiểu hoa hồng</label>
                                <select class="form-control">
                                    <option>- Kiểu hoa hồng - </option>
                                    <option>- Phần trăm % - </option>
                                    <option>- Tiền mặt - </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái</label>
                                <select class="form-control">
                                    <option>- Trạng thái - </option>
                                    <option>- Ngừng hoạt động - </option>
                                    <option>- Đã duyệt - </option>
                                    <option>- Chưa duyệt - </option>
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

            </form>
        </div>
    </section>
@endsection

