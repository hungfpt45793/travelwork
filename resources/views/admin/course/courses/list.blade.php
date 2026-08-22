@extends('admin.layout.admin')

@section('title', ' Khóa học' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Danh sách khóa học
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Danh sách khóa học</a></li>
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
                        <a href="{{ route('courses.create') }}">
                            <button class="btn btn-primary" style="float: left">Thêm mới</button>
                        </a>
                    </div>
                    <!-- /.box-header -->


                 
                    <div class="box-body">
                        <p> có tất cả {{ $list_course->total() }} khóa học </p>
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Hình ảnh</th>
                                <th>Giáo viên</th>
                                <th>Danh mục</th>
                                <th>Admin</th>
                                <th>Trạng thái</th>
                                <th>Mã kích hoạt</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_course  as $course)
                                <tr>
                                    <td>{{ $course->course_id }}</td>
                                    <td>
                                        <a href="{{ route('course_showCourseDetail',['course_slug' => $course->course_slug]) }}">{{ $course->course_code }} - {{ $course->course_title }} </a>
                                        <?php
                                        $count = \App\Entity\Learn_training::get_total($course->course_id);
                                        ?>
                                        <sup style="color: red"> ({{$count}} đào tạo)</sup>
                                    </td>
                                    <td><img style="width: 50px" src="{{ !empty($course->course_image) ? asset($course->course_image) : '' }}"></td>
                                    <td>{{ $course->teacher_name }}</td>
                                    <td>{{ $course->category_course_title }}</td>
                                    <td>{{ $course->name }}</td>
                                    <td>
                                        @if($course->course_status == 0)
                                            <span style="color: white;background: red;padding: 5px 10px;">Không duyệt</span>
                                        @else
                                            <span style="color: white;background: green;padding: 5px 10px;">Đã duyệt</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span style="color: white;background: green;padding: 5px 10px;">{{ !empty($course->activation_code) ? $course->activation_code : '' }}</span>
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default">Thao tác</button>
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Thao tác</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a href="{{ route('detail_course',['course_id'=> $course->course_id]) }}">
                                                        Danh sách chương
                                                    </a>
                                                </li>
                                                {{--<li><a href="{{ route('list_formality',['course_id'=> $course->course_id]) }}">Hình thức học</a></li>--}}
                                                {{--<li><a href="{{ route('list_formality',['course_id'=> $course->course_id]) }}">Thống kê khóa học</a></li>--}}
                                                {{--<li>--}}
                                                <li><a href="{{ route('list_learn',['course_id'=> $course->course_id]) }}">Hình thức đào tạo</a></li>
                                                {{--<li><a href="{{ route('list_formality',['course_id'=> $course->course_id]) }}">Thống kê khóa học</a></li>--}}
                                                <li>
                                                <li><a href="{{ route('list_delete_learn',['course_id'=> $course->course_id]) }}">Hình thức đào tạo đã xóa</a></li>
                                                {{--<li><a href="{{ route('list_formality',['course_id'=> $course->course_id]) }}">Thống kê khóa học</a></li>--}}
                                                <li>
                                                    <a href="{{ route('courses.edit',['course_id'=> $course->course_id]) }}">
                                                        Sửa
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('courses.destroy',['course_id'=> $course->course_id]) }}" class="btnDelete" data-toggle="modal"  data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                        Xóa
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pahe">
                            {{ $list_course->links() }}
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
