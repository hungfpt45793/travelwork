@extends('admin.layout.admin')

@section('title', ' Danh sách lớp đào tạo' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách lớp đào tạo
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#"> Danh sách lớp đào tạo</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        @if (session('success'))
                            <div class="infoAlert">
                                <div class="alert alert-success">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert"
                                            aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="infoAlert">
                                <div class="alert alert-warning">
                                    <span>{{ session('error') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert"
                                            aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif
                        <a href="{{ route('educate_class.create') }}">
                            <button class="btn btn-primary" style="float: left">Thêm mới</button>
                        </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <p> có tất cả {{ $total }} lớp đào tạo</p>
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên lớp học</th>
                                <th>Ảnh minh họa</th>
                                <th>Chuyên mục</th>
                                <th>Giáo viên</th>
                                <th>Số lượng ứng viên</th>
                                <th>Hạn sử dụng</th>
                                <th>Ứng viên đã đăng kí</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($educate_class  as $class)
                                <tr>
                                    <td>{{ isset($class->edu_class_id) ? $class->edu_class_id : '' }}</td>
                                    <td>{{ isset($class->edu_class_name) ? $class->edu_class_name : '' }}</td>
                                    <td><img src="{{ asset($class->educate_class_image) }}" width="50px"></td>
                                    <td>
                                        <?php
                                        $edu_cate = \App\Entity\Educate_categories::getID($class->edu_cate_id)
                                        ?>
                                            {{ isset($edu_cate->edu_cate_title) ? $edu_cate->edu_cate_title : '' }}
                                    </td>
                                    <td>
                                        {{ isset($class->teacher_name) ? $class->teacher_name : '' }}
                                    </td>
                                    <td>
                                        <?php
                                        $total_employee_class = \App\Entity\Educate_employees_class::get_total_employee_class($class->edu_class_id);
                                        ?>
    {{ $total_employee_class }} / {{ isset($class->edu_total_employee) ? $class->edu_total_employee : '' }}
                                    </td>
                                    <td>
                                        <?php
                                        $date_edu = date_create($class->edu_date_end);
                                        echo date_format($date_edu, "d/m/Y");
                                        ?>
                                    </td>
                                    <td>
                                        <a href="{{ route('list_educate_employee_class',['educate_class_id'=>$class->edu_class_id]) }}" class="btnGreen">Danh sách</a>
                                    </td>

                                    <td>
                                        <a href="{{ route('educate_class.edit',['edu_class_id'=> $class->edu_class_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('educate_class.destroy',['edu_class_id'=> $class->edu_class_id]) }}"
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
                            {{ $educate_class->links() }}
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
