@extends('admin.layout.admin')

@section('title', 'Chỉnh sửa đăng kí nhận tư vấn')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>

           Chỉnh sửa  @if($res->status_res ==0) nhà tuyển dụng @else ứng viên @endif đăng kí tư vấn

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Liên hệ</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->

            <form role="form" action="{{ route('res-dvisory.update', ['id_res' => $res->id_res]) }}" method="POST">
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



                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Họ và tên</label>
                                        <input type="text" class="form-control" name="name_res" placeholder="Họ và tên"
                                               value="{{ $res->name_res }}" >
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Điện thoại</label>
                                        <input type="text" class="form-control" name="phone_res" placeholder="Điện thoại" value="{{ $res->phone_res }}" />
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" class="form-control" name="email_res" placeholder="Email" value="{{ $res->email_res }}"  />
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Địa chỉ</label>
                                        <input type="text" class="form-control" name="address_res" placeholder="Địa chỉ" value="{{ $res->address_res }}" >
                                    </div>



                            <div class="form-group">
                                <label for="exampleInputEmail1">Message</label>
                                <textarea rows="4" class="form-control editor" id="editor1" name="message_res"
                                          placeholder="">{!! $res->message_res !!}</textarea>
                            </div>


                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                    <!-- /.box -->

                </div>

            </form>
        </div>
    </section>
@endsection

