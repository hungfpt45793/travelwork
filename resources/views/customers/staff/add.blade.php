@extends('admin.layout.admin')

@section('title', 'Thêm mới Nhân viên')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới Nhân viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Nhân viên</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <form role="form" action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <div class="box box-primary">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert"
                                     style="padding: 5px;margin: 2px;display: inline-block;">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin Nhân viên</h3>
                        </div>

                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Họ và tên Nhân viên</label>
                                        <input type="text" class="form-control" name="staff_name"
                                               placeholder="Họ và tên Nhân viên" value="{{ old('staff_name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email (đăng nhập)</label>
                                        <input type="email" class="form-control" name="email"
                                               placeholder="Email đăng nhập" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mật khẩu (đăng nhập)</label>
                                        <input type="password" class="form-control" name="password"
                                               placeholder="Mật khẩu (đăng nhập)" value="{{ old('password') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">SĐT</label>
                                        <input type="text" class="form-control" name="staff_phone"
                                               placeholder="Số điện thoại" value="{{ old('staff_phone') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ảnh đại diện</label><br>
                                        <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                               size="20"/>
                                        <img src="{{old('staff_image')}}" width="80" height="70"/>
                                        <input name="staff_image" type="hidden" value="{{old('staff_image')}}"/>
                                    </div>


                                </div>

                            </div>


                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu lại</button>
                        </div>
                    </div>


                </div>


            </form>
        </div>
    </section>
    <script type="text/javascript">
        $('#datepicker').datepicker({
            autoclose: true
        })
    </script>
@endsection
