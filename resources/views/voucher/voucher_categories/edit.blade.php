@extends('admin.layout.admin')

@section('title', ' Sửa Kho tài liệu')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sửa Kho tài liệu
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh mục kho tài liệu</a></li>
            <li class="active">Sửa kho tài liệu</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('voucher-categories.update',['voucher_category'=>$cate_gory_voucher->id_cate_voucher]) }}" method="POST">
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
                                <label for="exampleInputEmail1">Tên kho tài liệu</label>
                                <input type="text" class="form-control" name="name_cate_voucher" placeholder="Tiêu đề" required  value="{{ $cate_gory_voucher->name_cate_voucher }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">slug</label>
                                <input type="text" class="form-control" name="slug_cate_voucher" placeholder="đường dẫn tĩnh"
                                       value="{{ $cate_gory_voucher->slug_cate_voucher }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">icon</label>
                                <input type="text" class="form-control" name="icon" placeholder="Icon"
                                       value="{{ $cate_gory_voucher->icon }}">
                            </div>
                        </div>
                        <!-- /.box-body -->

                    </div>
                    <!-- /.box -->

                    <!-- Bổ sung -->


                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="box box-primary col-md-6">
                        <div class="box-header with-border">
                            <h3 class="box-title">Hỗ trợ seo</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ title</label>
                                <input type="text" class="form-control" name="meta_title" placeholder="Thẻ title" value="{{ $cate_gory_voucher->meta_title }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ description</label>
                                <textarea type="text" class="form-control" name="meta_description" placeholder="Thẻ description" rows="5">{{ $cate_gory_voucher->meta_description }}</textarea>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ keyword</label>
                                <input type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword" value="{{ $cate_gory_voucher->meta_keyword }}">
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
