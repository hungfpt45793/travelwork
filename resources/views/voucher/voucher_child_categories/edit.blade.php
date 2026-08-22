@extends('admin.layout.admin')

@section('title', ' Sửa danh mục tài liệu')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sửa danh mục
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">danh mục</a></li>
            <li class="active">Sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->

            <form role="form" action="{{ route('voucher-child-categories.update',['id_cate_child' => $category_child_voucher->id_cate_child] ) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
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
                                       required value="{{ $category_child_voucher->name_cate_child }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">slug</label>
                                <input type="text" class="form-control" name="slug_cate_child"
                                       placeholder="đường dẫn tĩnh" value="{{ $category_child_voucher->slug_cate_child }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea type="text" class="form-control" name="des_cate_child"
                                          placeholder="đường dẫn tĩnh" rows="5">{{ $category_child_voucher->des_cate_child }}</textarea>

                            </div>

                        </div>
                        <!-- /.box-body -->

                    </div>
                    <div class="box box-primary col-md-8">
                        <div class="box-header with-border">
                            <h3 class="box-title">Hỗ trợ seo</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ title</label>
                                <input type="text" class="form-control" name="meta_title" placeholder="Thẻ title" value="{{ $category_child_voucher->meta_title }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ description</label>
                                <textarea type="text" class="form-control" name="meta_description" placeholder="Thẻ description" rows="5">{{ $category_child_voucher->meta_description }}</textarea>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ keyword</label>
                                <input type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword" value="{{ $category_child_voucher->meta_keyword }}">
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
                                               value=" {{ $lists['id_cate_voucher'] }}"
                                                @if($category_child_voucher->id_cate_voucher == $lists['id_cate_voucher'])
                                                    checked
                                                    @endif />

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

