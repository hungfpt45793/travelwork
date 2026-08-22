@extends('admin.layout.admin')

@section('title', 'Thêm mới Mức lương')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới thông tin dịch vụ
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('information_service.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin dịch vụ</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề</label>
                                <input type="text" class="form-control" name="title" placeholder="Tiêu đề">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh</label>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="" width="80" height="70"/>
                                <input name="images" type="hidden" value=""/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea rows="4" class="form-control editor" name="description"
                                          placeholder="" id="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung(hiển thị ở trang chi tiết)</label>
                                <textarea rows="4" class="form-control editor" name="content"
                                          placeholder="" id="content"></textarea>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection