@extends('admin.layout.admin')

@section('title', 'Thêm mới danh mục mẫu email')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới danh mục mẫu email
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới danh mục mẫu email</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('category_template_email.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Danh mục mẫu email</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên danh mục mẫu emal</label>
                                <input type="text" class="form-control" name="name_cate_tem" placeholder="Tên danh mục mẫu emal">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Biến truyền vào mẫu email</label>
                                <textarea class="form-control editor" id="note_tem_var" name="note_tem_var"></textarea>

                            </div>
                        </div>

                        <div class="form-group error">
                            @if(!empty($errors->all()))
                                @foreach($errors->all() as $erorr)
                                    <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                @endforeach
                            @endif
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