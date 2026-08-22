@extends('admin.layout.admin')

@section('title', 'Thêm mới mẫu email cho danh mục'.$category_template_email->name_cate_tem)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật mới mẫu email cho danh mục {{ $category_template_email->name_cate_tem }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhật mới mẫu email cho danh mục {{ $category_template_email->name_cate_tem }}</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->

                <div class="col-xs-12 col-md-7">
                    <form role="form" action="{{ route('template_email.update',['id_tem'=> $template_email->id_tem]) }}"
                          method="POST">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Mẫu Email</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên mẫu emal</label>
                                <input type="text" class="form-control" name="name_tem" placeholder="Tên mẫu emal"
                                       value="{{ $template_email->name_tem }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề của mẫu email</label>
                                <input type="text" class="form-control" name="subject_tem"
                                       placeholder="Tiêu đề của mẫu email" value="{{ $template_email->subject_tem }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung gửi email</label>
                                <textarea class="form-control editor" id="content_tem"
                                          name="content_tem">{!! $template_email->content_tem  !!}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1" style="display: block">Mẫu chọn khi gửi email</label>
                                <label style="margin-right: 20px">
                                    <input type="radio" name="status_tem" class="flat-red" value="0"
                                           @if($template_email->status_tem == 0) checked @endif >
                                    Không
                                </label>
                                <label>
                                    <input type="radio" name="status_tem" class="flat-red" value="1"
                                           @if($template_email->status_tem == 1) checked @endif>
                                    Có
                                </label>
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1" style="display: block"><strong>Chọn người muốn gửi(trường hợp gửi 2 email cùng lúc)</strong></label>
                                <label style="margin-right: 20px">
                                    <input type="radio" name="status_people" class="flat-red" value="1" @if($template_email->status_people == 1) checked @endif>
                                    Ứng viên
                                </label>
                                <label style="margin-right: 20px">
                                    <input type="radio" name="status_people" class="flat-red" value="2" @if($template_email->status_people == 2) checked @endif>
                                    Nhà tuyển dụng
                                </label>
                                <label style="margin-right: 20px">
                                    <input type="radio" name="status_people" class="flat-red" value="3" @if($template_email->status_people == 3) checked @endif>
                                    Giáo viên
                                </label>
                                <label style="margin-right: 20px">
                                    <input type="radio" name="status_people" class="flat-red" value="4" @if($template_email->status_people == 4) checked @endif>
                                    Quản trị viên
                                </label>
                            </div>

                        </div>
                        <input type="hidden" name="id_cate_tem" value="{{ $category_template_email->id_cate_tem }}">

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="col-md-5">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin danh mục</h3>
                        </div>
                        <div class="box-body">
                            <div>
                                {!!  $category_template_email->note_tem_var !!}
                            </div>

                        </div>
                        <div class="box-header with-border">
                            <h3 class="box-title">Kiểm tra cấu hình email</h3>
                        </div>
                        <div class="box-body">
                            <form action="{{ route('sendEmail') }}" method="post">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label>Tên</label>
                                    <input type="text" class="form-control" name="name"
                                           placeholder="Nhập email kiểm tra cấu hình" value=""/>
                                </div>
                                <div class="form-group">
                                    <label>Số điện thoại</label>
                                    <input type="text" class="form-control" name="phone"
                                           placeholder="Nhập email kiểm tra cấu hình" value=""/>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email"
                                           placeholder="Nhập email kiểm tra cấu hình" value=""/>
                                </div>
                                @if (isset($_GET['error']) && $_GET['error'] == 1)
                                    <div class="form-group" style="color: red;">
                                        <label for="exampleInputEmail1">Lỗi xảy ra trong quá trình cấu hình
                                            email</label>
                                    </div>
                                @elseif (isset($_GET['error']) && $_GET['error'] == 0)
                                    <div class="form-group" style="color: forestgreen;">
                                        <label for="exampleInputEmail1">Email gửi thành công!. Chúc mừng bạn. ^^</label>
                                    </div>
                                @endif
                                <input type="hidden" name="id_tem" value="{{ $template_email->id_tem }}">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Kiểm tra cấu hình</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
        </div>
    </section>
@endsection