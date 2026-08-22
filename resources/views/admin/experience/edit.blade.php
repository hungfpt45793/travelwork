@extends('admin.layout.admin')

@section('title', 'cập nhật kinh nghiệm')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật kinh nghiệm
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
            <form role="form" action="{{ route('experience.update',['experience_id'=> $experience->experience_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Kinh nghiệm</h3>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên</label>
                            <input type="text" class="form-control" name="experience_name" placeholder="số năm" value="{{ isset($experience->experience_name) ? $experience->experience_name: '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Mô tả</label>
                            <textarea name="experience_des" rows="5" style="width: 100%;">{{ isset($experience->experience_des) ? $experience->experience_des: '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Số tháng kinh nghiệm</label>
                            <input type="text" class="form-control" name="experience_month" placeholder="số tháng" value="{{ isset($experience->experience_month) ? $experience->experience_month: '' }}">
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