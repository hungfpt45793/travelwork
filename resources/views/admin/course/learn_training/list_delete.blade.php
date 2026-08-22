@extends('admin.layout.admin')

@section('title', 'Danh sách đào tạo khóa học đã xóa' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách đào tạo khóa học đã xóa
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
                        <a href="{{ route('create_learn',['course_id'=> $course->course_id]) }}">
                            <button class="btn btn-primary" style="float: left">Thêm mới</button>
                        </a>
                    </div>
                    <!-- /.box-header -->
                    <p>
                       Danh sách đào tạo khóa học đã xóa : {{ !empty($course->course_title) ? $course->course_title : '' }}
                    </p>

                    <div class="box-body">
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Nội dung</th>
                                <th>Giá</th>
                                <th>Giảm giá</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($learn_training  as $training)
                                <tr>
                                    <td>{{ $training->learn_id  }}</td>
                                    <td>{{ $training->learn_title }}</td>
                                    <td>{!! $training->learn_content !!}  </td>
                                    <td>{{ !empty($training->learn_price) ? number_format($training->learn_price) : '0' }}
                                        VNĐ
                                    </td>
                                    <td>{{ !empty($training->learn_discount) ? number_format($training->learn_discount) : '0' }}
                                        VNĐ
                                    </td>
                                    <td>
                                        <a href="{{ route('restore_learn',['learn_id'=> $training->learn_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true">Khôi phục</i></button>
                                        </a>
                                        <a href="{{ route('force_delete_learn',['learn_id'=> $training->learn_id]) }}"
                                           class="btn btn-danger btnDelete" data-toggle="modal"
                                           data-target="#myModalDelete" onclick="return submitDelete(this);"> <i
                                                    class="fa fa-trash-o" aria-hidden="true"></i> Xóa vĩnh viễn</a>
                                    </td>


                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pahe">
                            {{ $learn_training->links() }}
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    {{--@include('admin.partials.popup_delete')--}}
    @include('admin.partials.popup_post_delete')
@endsection
