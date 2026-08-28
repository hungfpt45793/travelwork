@extends('admin.layout.admin')

@section('title', ' Chuyên mục đào tạo' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Danh sách danh mục
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Danh sách danh mục</a></li>
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
                        <a href="{{ route('category_course.create') }}">
                            <button class="btn btn-primary" style="float: left">Thêm mới</button>
                        </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <p> có tất cả {{ $list_category_course->total() }} danh sách </p>
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Mô tả</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_category_course  as $category)
                                <tr>
                                    <td>{{ $category->category_course_id }}</td>
                                    <td><a>{{ $category->category_course_title }}</a></td>
                                    <td>{{ $category->category_course_desc }}</td>
                                    <td>
                                        <?php
                                        $date_edu = date_create($category->created_at);
                                        echo date_format($date_edu, "d/m/Y");
                                        ?>
                                    </td>

                                    <td>
                                        <a href="{{ route('category_course.edit', ['category_course' => $category->category_course_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('category_course.destroy', ['category_course' => $category->category_course_id]) }}"
                                           class="btn btn-danger btnDelete" data-toggle="modal"
                                           data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pahe">
                            {{ $list_category_course->links() }}
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
