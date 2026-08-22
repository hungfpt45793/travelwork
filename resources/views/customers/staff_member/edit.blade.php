@extends('admin.layout.admin')

@section('title', 'Cập nhật Cộng tác viên ' . $staff->staff_name)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật Cộng tác viên {{$staff->staff_name}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Cộng tác viên</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <form role="form" action="{{ route('staff_member.update',['staff_member_id'=>$staff->staff_member_id]) }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
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
                            <h3 class="box-title">Thông tin Cộng tác viên</h3>
                        </div>

                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12 col-md-12">

                                    <div class="form-group">
                                    <label for="exampleInputEmail1">Họ và tên Cộng tác viên</label>
                                    <input type="text" class="form-control" name="staff_member_name" placeholder="Họ và tên ứng viên" value="{{ $staff->staff_member_name }}" >
                                </div>


                                <div class="form-group">

                                    <input type="checkbox" name="is_change_password" value="1" class="flat-red"> Chọn nếu muốn thay đổi mật khẩu
                                    <br>
                                    <label for="exampleInputEmail1">Mật khẩu</label>
                                    <input type="password" class="form-control" name="password" placeholder="Mật khẩu" value="{{ isset($staffInCharges->phone) ? $staffInCharges->phone :'' }}" />
                                </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">SĐT</label>
                                        <input type="text" class="form-control" name="staff_member_phone"
                                               placeholder="Số điện thoại" value="{{ $staff->staff_member_phone }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ảnh đại diện</label><br>
                                        <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                               size="20"/>
                                        <img src="{{ $staff->staff_member_image }}" width="80" height="70"/>
                                        <input name="staff_member_image" type="hidden" value="{{ $staff->staff_member_image }}"/>
                                    </div>


                                </div>

                            </div>


                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
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
