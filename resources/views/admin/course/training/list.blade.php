@extends('admin.layout.admin')

@section('title', 'Nội dung đào tạo' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Nội dung đào tạo
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Nội dung đào tạo</a></li>
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
                        <a href="{{ route('training.create') }}">
                            <button class="btn btn-primary" style="float: left">Thêm mới</button>
                        </a>
                    </div>
                    <!-- /.box-header -->


                    <div class="box-body">
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Khóa học</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_training  as $training)
                                <tr>
                                    <td>{{ $training->trai_id }}</td>
                                    <td>{{ $training->trai_title }}</td>
                                    <td>{{ !empty($training->course_id) ? 'Khóa học riêng' : 'Tất cả khóa học' }}</td>
                                    <td>
                                        <a href="{{ route('training.edit', ['training' => $training->trai_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('training.destroy', ['training' => $training->trai_id]) }}"
                                           class="btn btn-danger btnDelete" data-toggle="modal"
                                           data-target="#myModalDelete" onclick="return submitDelete(this);"> <i
                                                    class="fa fa-trash-o" aria-hidden="true"></i> </a>
                                    </td>


                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pahe">
                            {{ $list_training->links() }}
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection
