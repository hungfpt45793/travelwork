@extends('admin.layout.admin')

@section('title', ' Thêm mới vị trí công việc')

@section('content')

    <section class="content-header">
        <h1>
            Thêm mới vị trí công việc

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <!--  <li><a href="#"></a></li> -->
            <li class="active"> Thêm mới vị trí công việc</li>
        </ol>
    </section>
    <form role="form" action="{{ route('exam_local_job.store') }}" method="POST">
        {!! csrf_field() !!}
        {{ method_field('POST') }}
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
                                               placeholder="Tên vị trí công việc" required value="">
                                    </div>
                                </div>

                                <div class="button_fixed_bottom text-center">
                                    <input class="btn btn-primary submit-post" name="status1" type="submit"
                                           value="Lưu lại">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </form>

@endsection