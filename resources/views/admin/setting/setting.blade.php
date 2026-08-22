@extends('admin.layout.admin')

@section('title', 'Cài đặt thanh toán')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cài thanh toán
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Cài đặt thanh toán</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-12">

                <!-- Tab panes -->
                <div class="tab-content">

                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <!-- Nội dung thêm mới -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Cấu hình email</h3>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Phương thức gửi email</label>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            <input type="radio"  name="method" class="method_email" onclick="return changeMethod(this);" value="0" {{ ($settingEmail->method == 0) ? 'checked' : '' }}/> SMTP
                                        </label>
                                        <label>
                                            <input type="radio"  name="method" class="method_email" onclick="return changeMethod(this);" value="1" {{ ($settingEmail->method == 1) ? 'checked' : '' }}/> API
                                        </label>
                                    </div>
                                </div>
                                <div class="box-body {{ ($settingEmail->method == 1) ? 'hide' : ''  }}" id="smtp"   >
                                    <form action="{{ route('updateSettingEmail') }}" method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" value="0" name="method"/>
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12">
                                                <div class="form-group">
                                                    <label>Email nhận thông tin từ khách hàng</label>
                                                    <input type="text" class="form-control" name="email_receive" placeholder="no-reply@gmail.com"  value="{{ $settingEmail->email_receive }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Email hiển thị khi gửi(MAIL_FROM_ADDRESS)</label>
                                                    <input type="email" class="form-control" name="email_send" value="{{ $settingEmail->email_send }}" placeholder="no-reply@gmail.com" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Tài khoản dùng để gửi mail(MAIL_USERNAME)</label>
                                                    <input type="text" class="form-control" name="email" value="{{ $settingEmail->email }}" placeholder="no-reply@gmail.com" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Địa chỉ máy chủ SMTP(MAIL_HOST)</label>
                                                    <input type="text" class="form-control" name="address_server" value="{{ $settingEmail->address_server }}" placeholder="smtp.gmail.com" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Phương thức truyền tin(MAIL_DRIVER)</label>
                                                    <input type="text" class="form-control" name="driver" value="{{ $settingEmail->driver }}" placeholder="smtp" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Tên hiển thị khi gửi</label>
                                                    <input type="text" class="form-control" name="name_send" placeholder="VN3C" value="{{ $settingEmail->name_send }}" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Mật khẩu(MAIL_PASSWORD)</label>
                                                    <input type="password" class="form-control" name="password" placeholder="..." value="{{ $settingEmail->password }}" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Port (MAIL_PORT)</label>
                                                    <input type="number" class="form-control" name="port" placeholder="465" value="{{ $settingEmail->port }}" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Phương thức mã hóa</label>
                                                    <input type="text" class="form-control" name="encryption" value="{{ $settingEmail->encryption }}" placeholder="ssl" />
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-xs-12">
                                                <label>Chữ ký</label>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nội dung</label>
                                                    <textarea class="editor" id="content" name="sign" rows="10" cols="80"/>{{ $settingEmail->sign }}</textarea>
                                                </div>
                                            </div>

                                            <div class="box-body" id="smtp">
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12">
                                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="box-body {{ ($settingEmail->method == 0) ? 'hide' : ''  }}" id="api" >
                                    <form action="{{ route('updateSettingEmail') }}" method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" value="1" name="method"/>
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12">
                                                <div class="form-group">
                                                    <label>Email nhận thông tin từ khách hàng</label>
                                                    <input type="text" class="form-control" name="email_receive" placeholder="no-reply@gmail.com"  value="{{ $settingEmail->email_receive }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Nhà cung cấp</label>
                                                    <input type="text" class="form-control" name="supplier" placeholder="MailGun"  value="{{ $settingEmail->supplier }}" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Email hiển thị khi gửi</label>
                                                    <input type="text" class="form-control" name="email_send" placeholder="no-reply@gmail.com" value="{{ $settingEmail->email_send }}" />
                                                </div>
                                                <div class="form-group">
                                                    <label>API KEY</label>
                                                    <input type="text" class="form-control" name="api_key" placeholder="..." value="{{ $settingEmail->api_key }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Tên hiển thị khi gửi</label>
                                                    <input type="text" class="form-control" name="name_send" placeholder="VN3C" value="{{ $settingEmail->name_send }}" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Địa chỉ kết nối</label>
                                                    <input type="text" class="form-control" name="address_server" placeholder="..." value="{{ $settingEmail->address_server }}" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Phương thức truyền tin</label>
                                                    <input type="text" class="form-control" name="driver" value="{{ $settingEmail->driver }}" placeholder="smtp" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Host</label>
                                                    <input type="text" class="form-control" name="host" value="{{ $settingEmail->host }}" placeholder="smtp.mailgun.org" />
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-xs-12">
                                                <label>Chữ ký</label>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nội dung</label>
                                                    <textarea class="editor" id="content1" name="sign" rows="10" cols="80"/>{{ $settingEmail->sign }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-body" id="smtp">
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12">
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="box-body">
                            <div class="col-xs-12 col-md-6">
                                <form action="{{ route('testEmail') }}" method="post">
                                    {!! csrf_field() !!}
                                    <div class="form-group">
                                        <label>Kiểm tra cấu hình email</label>
                                        <div class="col-md-12 col-xs-12">
                                            <label>Chữ ký</label>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Nội dung</label>
                                                <textarea class="editor" id="content2" name="contentEmail" rows="10" cols="80"/></textarea>
                                            </div>
                                        </div>
                                        <input type="email" class="form-control" name="email_test" placeholder="Nhập email kiểm tra cấu hình" value="" />
                                    </div>
                                    @if (isset($_GET['error']) && $_GET['error'] == 1)
                                        <div class="form-group" style="color: red;">
                                            <label for="exampleInputEmail1">Lỗi xảy ra trong quá trình cấu hình email</label>
                                        </div>
                                    @elseif (isset($_GET['error']) && $_GET['error'] == 0)
                                        <div class="form-group" style="color: forestgreen;">
                                            <label for="exampleInputEmail1">Email gửi thành công!. Chúc mừng bạn. ^^</label>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Kiểm tra cấu hình</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <label>- {name} : Tên khách hàng</label>
                                </br>
                                <label>{email} = le văn thêm</label>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <script>
            function changeMethod(e) {
                var val = $(e).val();
                if (val == 0) {
                    $('#smtp').removeClass('hide');
                    $('#api').addClass('hide');
                } else {
                    $('#smtp').addClass('hide');
                    $('#api').removeClass('hide');
                }
            }
        </script>
    </section>
    @include('admin.partials.popup_delete')
@endsection

