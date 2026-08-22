@extends('admin.layout.admin')

@section('title', 'Sửa vị trí công việc')

@section('content')

    <section class="content-header">
        <h1>
            Sửa vị trí công việc

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <!--  <li><a href="#"></a></li> -->
            <li class="active">Sửa vị trí công việc</li>
        </ol>
    </section>
    <form role="form" action="{{ route('exam_local_job.update', ['exam_local_job_id ' => $exam_local->exam_local_job_id]) }}" method="POST">
    {{--<form role="form" action="{{ route('categories.update', ['category_id' => $categoriesExam->id_cate_exam]) }}" method="POST">--}}
        {!! csrf_field() !!}
        {{ method_field('PUT') }}
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="">

                        <!-- /.box-header -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Thông tin</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class=" control-label">Tên vị trí công việc <span
                                                class="red">(*)</span></label>

                                    <div class="">
                                        <input type="text" class="form-control" id="inputEmail3" name="exam_local_job"
                                               placeholder="Tên loại hình doanh nghiệp" required value="{{ $exam_local->exam_local_job }}">
                                    </div>
                                </div>

                                <div class="button_fixed_bottom text-center">
                                    <input class="btn btn-primary submit-post" name="status1" type="submit"
                                           value="Lưu thay đổi">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </form>

@endsection