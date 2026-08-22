@extends('admin.layout.admin')

@section('title', 'Cập nhật quảng cáo')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật quản cáo
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('adv_noti.update',['adv_id'=> $adv->adv_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Mức lương mong muốn</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề</label>
                                <input type="text" class="form-control" name="adv_title" placeholder="Tiêu đề" value="{{ isset($adv->adv_title) ? $adv->adv_title : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Link đường dẫn</label>
                                <input type="text" class="form-control" name="adv_link" placeholder="Link đường dẫn" value="{{ isset($adv->adv_link) ? $adv->adv_link : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung</label>
                                <textarea id="adv_content" name="adv_content" class="editor">{!! isset($adv->adv_content) ? $adv->adv_content : '' !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Thời gian hiện quảng cáo(tinh theo tích tắc)</label>
                                <input type="text" class="form-control" name="adv_time" placeholder="Thời gian hiện quảng cáo" value="{{ isset($adv->adv_time) ? $adv->adv_time : '' }}">
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-warning">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection