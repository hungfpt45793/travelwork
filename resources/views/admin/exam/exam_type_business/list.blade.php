@extends('admin.layout.admin')

@section('title', 'Loại hình doanh nghiệp')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Loại hình doanh nghiệp
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Loại hình doanh nghiệp</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('exam_type_business.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if(!empty($exam_locals))
                            <table id="category_exam" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Tên loại hình doanh nghiệp</th>
                                    <th>Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($exam_locals as $exam_local )
                                    <tr>
                                        <td>{{ $exam_local->exam_type_id }}</td>
                                        <td>{{ $exam_local->exam_type_name }}</td>

                                        <td>
                                        <a href="{{ route('exam_type_business.edit',['exam_type_id' => $exam_local->exam_type_id]) }}">
                                        <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a  href="{{ route('exam_type_business.destroy',['exam_type_id' => $exam_local->exam_type_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif


                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>

@endsection


