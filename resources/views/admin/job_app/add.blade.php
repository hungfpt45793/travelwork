@extends('admin.layout.admin')

@section('title', 'Thêm mới mẫu đơn xin việc')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới mẫu đơn xin việc
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
            <form role="form" action="{{ route('job_app.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thêm mới mẫu đơn xin việc</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên mẫu đơn xin việc</label>
                                <input type="text" class="form-control" name="job_app_name" placeholder="Tên mẫu đơn xin việc">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Chọn nhóm công việc</label>
                                <select class="form-control select2" name="career_category_id">
                                    @foreach($list_category_caree as $caree)
                                        <?php
                                        $check_career_category_id = '';
                                        $check_career_category_id = \App\Entity\Job_application::check_career_category_id($caree->career_category_id);
                                        ?>
                                        <option value="{{ $caree->career_category_id }}">
                                            {{ $caree->career_category_name }}  ---( @if(!empty($check_career_category_id)) đã tạo mẫu @else chưa tạo mẫu @endif  )
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nội dung</label>
                                    <textarea class="editor" id="editor_job_app" name="job_app_content"></textarea>
                                </div>
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