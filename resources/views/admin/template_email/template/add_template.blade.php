@extends('admin.layout.admin')

@section('title', 'Thêm mới mẫu email cho danh mục'.$category_template_email->name_cate_tem)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới mẫu email cho danh mục {{ $category_template_email->name_cate_tem }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới mẫu email cho danh mục {{ $category_template_email->name_cate_tem }}</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('template_email.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-7">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Mẫu Email</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên mẫu emal</label>
                                <input type="text" class="form-control" name="name_tem" placeholder="Tên mẫu emal">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề của mẫu email</label>
                                <input type="text" class="form-control" name="subject_tem" placeholder="Tiêu đề của mẫu email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung gửi email</label>
                                <textarea class="form-control editor" id="content_tem" name="content_tem"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1" style="display: block">Mẫu chọn khi gửi email</label>
                                <label style="margin-right: 20px">
                                    <input type="radio" name="status_tem" class="flat-red" value="0" checked>
                                    Không
                                </label>
                                <label>
                                    <input type="radio" name="status_tem" class="flat-red" value="1">
                                    Có
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1" style="display: block"><strong>Chọn người muốn gửi(trường hợp gửi 2 email cùng lúc)</strong></label>
                                <label style="margin-right: 20px">
                                    <input type="radio" name="status_people" class="flat-red" value="1">
                                   Ứng viên
                                </label>
                                <label style="margin-right: 20px">
                                    <input type="radio" name="status_people" class="flat-red" value="2">
                                   Nhà tuyển dụng
                                </label>
                                <label style="margin-right: 20px">
                                    <input type="radio" name="status_people" class="flat-red" value="3">
                                    Giáo viên
                                </label>
                                <label style="margin-right: 20px">
                                    <input type="radio" name="status_people" class="flat-red" value="4">
                                    Quản trị viên
                                </label>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="box box-primary">
                        <div class="box-body">
                            <label>Thông tin danh mục</label>
                            <input type="hidden" name="id_cate_tem" value="{{ $category_template_email->id_cate_tem }}">

                          <div>
                              {!!  $category_template_email->note_tem_var !!}
                          </div>

                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>
@endsection