@extends('admin.layout.admin')

@section('title', 'Thêm mới danh mục tài liệu')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới danh mục tài liệu
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
            <form role="form" action="{{ route('voucher-child-categories.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-8">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Danh mục tài liệu</label>
                                <input type="text" class="form-control" name="name_cate_child" placeholder="Tiêu đề"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">slug</label>
                                <input type="text" class="form-control" name="slug_cate_child"
                                       placeholder="đường dẫn tĩnh">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea type="text" class="form-control" name="des_cate_child"
                                          placeholder="đường dẫn tĩnh" rows="5"></textarea>

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
                    <div class="box box-primary col-md-8">
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
                    <!-- Bổ sung -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </div>

                <div class="col-xs-12 col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Chọn kho tài liệu</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                @foreach($lists as $id=>$lists)
                                    <label style="display: block;margin-bottom: 15px;">
                                        <input type="radio" name="id_cate_voucher" class="flat-red"
                                               value=" {{ $lists['id_cate_voucher'] }}" {{ ($id == 0) ? 'checked': '' }}>
                                        {{ $lists['name_cate_voucher'] }}
                                    </label>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

