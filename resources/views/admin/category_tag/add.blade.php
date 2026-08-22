@extends('admin.layout.admin')

@section('title', 'Thêm mới danh mục')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới danh mục tag
            <?php
            $tag_type = isset($_GET['tag_type']) ? $_GET['tag_type'] : '1';
            ?>
            @if($tag_type == 1)
                bài viết
            @endif @if($tag_type == 2)
                tài liệu
            @endif @if($tag_type == 3)
                công việc
            @endif
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
            <form role="form" action="{{ route('category-tag.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề</label>
                                <input type="text" class="form-control" name="tag_title" placeholder="Tiêu đề">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea type="text" class="form-control" name="tag_description" placeholder="Mô tả"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Từ khóa</label>
                                <input type="text" class="form-control" name="tag_keyword" placeholder="Từ khóa">
                                <input type="hidden" name="tag_type" value="{{ $tag_type }}">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu từ khóa</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection