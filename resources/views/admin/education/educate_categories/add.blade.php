@extends('admin.layout.admin')

@section('title', 'Thêm mới chuyên mục')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới chuyên mục
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới chuyên mục</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('educate_categories.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Chuyên mục đào tạo</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề chuyên mục</label>
                                <input type="text" class="form-control" name="edu_cate_title" placeholder="Tiêu đề chuyên mục">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả chuyên mục</label>
                                <textarea class="form-control" name="edu_cate_des"></textarea>
                            </div> <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung chuyên mục</label>
                                <textarea class="form-control editor" id="edu_cate_content" name="edu_cate_content"></textarea>
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