@extends('admin.layout.admin')

@section('title', 'Thêm mới Kho tài liệu')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới Kho tài liệu
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh mục kho tài liệu</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('voucher-categories.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-6">
                    <div></div>
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary col-mg-6">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên kho tài liệu</label>
                                <input type="text" class="form-control" name="name_cate_voucher" placeholder="Tiêu đề" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">slug</label>
                                <input type="text" class="form-control" name="slug_cate_voucher" placeholder="đường dẫn tĩnh" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">icon</label>
                                <input type="text" class="form-control" name="icon" placeholder="Icon" >
                            </div>

                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->

                    </div>
                    <!-- /.box -->

                    <!-- Bổ sung -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
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
                                <input type="text" class="form-control" name="meta_title" placeholder="Thẻ title">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ description</label>
                                <textarea type="text" class="form-control" name="meta_description" placeholder="Thẻ description" rows="5"></textarea>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ keyword</label>
                                <input type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword">
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

