@extends('admin.layout.admin')

@section('title', 'Thêm mới quảng cáo')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới quảng cáo
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
            <form role="form" action="{{ route('adv_noti.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thêm mới quảng cáo</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề</label>
                                <input type="text" class="form-control" name="adv_title" placeholder="Tiêu đề">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Link đường dẫn</label>
                                <input type="text" class="form-control" name="adv_link" placeholder="Link đường dẫn">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung</label>
                                <textarea id="adv_content" name="adv_content" class="editor"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Thời gian hiện quảng cáo(tinh theo tích tắc)</label>
                                <input type="text" class="form-control" name="adv_time" placeholder="Thời gian hiện quảng cáo">
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