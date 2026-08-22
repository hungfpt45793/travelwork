@extends('admin.layout.admin')

@section('title', ' Hình thức học' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Danh sách danh mục
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Hình thức học</a></li>
            <li><a href="#">Danh mục</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        @if (session('success'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger text-center" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl" style="margin-bottom: 15px">
                                Thêm mới hình thức học
                            </button>
                    </div>
                    <!-- /.box-header -->

                    <div class="modal fade" id="modal-xl">
                        <div class="modal-dialog modal-xl">
                            <form role="form" action="{{ route('course_formality.store') }}" method="POST">
                                {!! csrf_field() !!}
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Thêm mới hình thức học</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tiêu đề</label>
                                            <input type="text" class="form-control" name="course_formality_title"
                                                   placeholder="Tiêu đề chương khóa học" value="{{ old('course_formality_title') }}">
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mô tả </label>
                                            <textarea class="form-control" name="course_formality_des" rows="3"> {{ old('course_formality_des') }}</textarea>
                                        </div>

                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                                    </div>
                                </div>
                            </form>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>



                    <div class="box-body">
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Mô tả</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_course_formality  as $formality)
                                <tr>
                                    <td>{{ $formality->course_formality_id }}</td>
                                    <td>{{ $formality->course_formality_title }}</td>
                                    <td>{{ $formality->course_formality_des }}</td>

                                    <td>
                                        <a data-toggle="modal" data-target="#modal_{{$formality->course_formality_id}}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('course_formality.destroy',['course_formality_id'=> $formality->course_formality_id]) }}"
                                           class="btn btn-danger btnDelete" data-toggle="modal"
                                           data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>

    @foreach($list_course_formality  as $formality)
        <div class="modal fade" id="modal_{{$formality->course_formality_id}}">
            <div class="modal-dialog modal-xl">
                <form role="form" action="{{ route('course_formality.update',['course_formality_id'=> $formality->course_formality_id]) }}" method="POST">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cập nhật bài học cho chương {{ $formality->course_formality_title }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề</label>
                                <input type="text" class="form-control" name="course_formality_title"
                                       placeholder="Tiêu đề chương khóa học" value="{{ $formality->course_formality_title }}">
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả </label>
                                <textarea class="form-control" name="course_formality_des" rows="3"> {{ $formality->course_formality_des }}</textarea>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach

    @include('admin.partials.popup_delete')
@endsection
