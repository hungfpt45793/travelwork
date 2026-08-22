@extends('admin.layout.admin')

@section('title', 'Chỉnh sửa '.$user->email )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa Thông tin thành viên {{ $user->email }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Thành viên</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('users.update', ['id' => $user->id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
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

                                {{--<label for="exampleInputEmail1">Phân quyền</label>--}}
                                <p><strong style="font-weight: bold"> --- Thông tin
                                        @if($user->role == 1)
                                            Ứng viên
                                            @endif @if($user->role == 2)
                                                       Nhà tuyển dụng
                                            @endif @if($user->role == 3)
                                                       Giáo viên
                                            @endif
                                    </strong></p>
                                {{--<select class="form-control" name="role">--}}
                                    {{--<option value="3" @if($user->role == 3) selected @endif>Nhân viên</option>--}}
                                    {{--<option value="4" @if($user->role == 4) selected @endif>Giám đốc</option>--}}
                                {{--</select>--}}
                            </div>

                            @endif
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" required value="{{ $user->email }}" readonly/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Họ và tên</label>
                                <input type="text" class="form-control" name="name" placeholder="Họ và tên" value="{{ $user->name }}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại</label>
                                <input type="text" class="form-control" name="phone" placeholder="Số điện thoại" value="{{ $user->phone }}"/>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" name="is_change_password" value="1" class="flat-red"> Chọn nếu muốn thay đổi mật khẩu
                                <label for="exampleInputEmail1">Mật khẩu</label>
                                <input type="password" class="form-control" name="password" placeholder="Mật khẩu" value="{{ $user->password }}" />
                            </div>

                            <div class="form-group">
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{ $user->image }}" width="80" height="70"/>
                                <input name="image" type="hidden" value="{{ $user->image }}"/>
                            </div>

                            <div class="form-group" style="color: red;">
                                @if ($errors->has('email'))
                                    <label for="exampleInputEmail1">{{ $errors->first('email') }}</label>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-warning">Cập nhật</button>
                        </div>
                    </div>
                    <!-- /.box -->

                </div>
                
            </form>
        </div>
    </section>
@endsection

