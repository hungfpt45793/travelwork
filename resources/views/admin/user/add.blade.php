@extends('admin.layout.admin')

@section('title', 'Thêm mới người dùng' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới người dùng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Thành viên</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('users.store') }}" method="POST">
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
                                @if(\App\Entity\User::isManager(\Illuminate\Support\Facades\Auth::user()->role))
                                <div class="form-group">
                                    <?php
                                        $role = '';
                                        $role = isset($_GET['role']) ? $_GET['role'] : 1;
                                    ?>
                                    <p><strong style="font-weight: bold"> --- Thêm mới
                                            @if($role == 1)
                                                Ứng viên
                                            @endif @if($role == 2)
                                                Nhà tuyển dụng
                                            @endif @if($role == 3)
                                                Giáo viên
                                            @endif
                                        </strong></p>
                                    <input type="hidden" name="role" value="{{ $role }}">
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email" required value="{{ old('email') }}" />
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Họ và tên</label>
                                    <input type="text" class="form-control" name="name" placeholder="Họ và tên"  required value="{{ old('name') }}"/>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số điện thoại</label>
                                    <input type="text" class="form-control" name="phone" placeholder="Số điện thoại" required value="{{ old('phone') }}" />
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mật khẩu</label>
                                    <input type="text" class="form-control" name="password" placeholder="Mật khẩu" required  value="{{ old('password') }}"/>
                                </div>

                                <div class="form-group">
                                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                           size="20"/>
                                    <img src="" width="80" height="70"/>
                                    <input name="image" type="hidden" value=""/>
                                </div>
                                
                                <div class="form-group" style="color: red;">
                                    @if ($errors->has('email'))
                                        <label for="exampleInputEmail1">{{ $errors->first('email') }}</label>
                                    @endif
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>
                    </div>
                    <!-- /.box -->

                </div>
            </form>
        </div>
    </section>
@endsection

