@extends('admin.layout.admin')

@section('title', ' Danh sách chương của khóa học' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách chương của khóa học : {{ $course->course_code }}
            - {{ $course->course_title }}
        </h1>

    </section>
    <style>
        .modal-header .close {
            margin-top: -28px;
        }
    </style>
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
                        {{--<a href="{{ route('create_course_chapter',['course_id'=> $course->course_id]) }}">--}}
                        {{--<button class="btn btn-primary" style="float: left">Thêm mới chương</button>--}}
                        {{--</a>--}}
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 style="margin-top: 0">Danh sách chương của khóa học : {{ $course->course_code }}
                                    - {{ $course->course_title }}</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Danh sách đánh giá</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Danh sách câu hỏi</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">

                                </div>
                            </div>

                        </div>


                    </div>


                    <div class="box-body">
                        <p> có tất cả {{ $total_course_chapter }} danh sách chương của khóa học </p>

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl"
                                style="margin-bottom: 15px">
                            Thêm mới chương cho khóa học
                        </button>


                        <a href="{{ route('courses.index') }}">
                            <button class="btn btn-primary" style="margin-left: 30px;margin-bottom: 15px">Danh sách khóa
                                học
                            </button>
                        </a>


                        <div class="modal fade" id="modal-xl">
                            <div class="modal-dialog modal-xl">
                                <form role="form" action="{{ route('admin_store_course_chapter') }}" method="POST">
                                    {!! csrf_field() !!}
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Thêm mới chương cho khóa học</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tiêu đề chương khóa học</label>
                                                <input type="text" class="form-control" name="course_chapter_name"
                                                       placeholder="Tiêu đề chương khóa học"
                                                       value="{{ old('course_chapter_name') }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Mô tả chương khóa học</label>
                                                <textarea class="form-control" name="course_chapter_descript"
                                                          rows="3"> {{ old('course_chapter_descript') }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Nội dung chương khóa học</label>
                                                <textarea class="form-control editor" id="course_chapter_content"
                                                          name="course_chapter_content">{!! old('course_chapter_content') !!}</textarea>

                                                <input type="hidden" class="form-control" name="course_id"
                                                        placeholder="Tiêu đề chương khóa học"
                                                        value="{{ $course->course_id }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Trạng thái chương</label>
                                                <br>
                                                <label>
                                                    <input checked type="radio" name="course_chapter_status" value="0"
                                                           style="width: 25px" >Học thử
                                                </label>
                                                <label style="margin-left: 20px">
                                                    <input type="radio" name="course_chapter_status" value="1"
                                                           checked="" style="width: 25px">Không học thử
                                                </label>
                                            </div>

                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                                            </button>
                                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                                        </div>
                                    </div>
                                </form>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Danh sách nội dung</th>
                                <th>Danh sách bài học</th>
                                <th>Trạng thái chương</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_course_chapter as $chapter)
                                <tr>
                                    <td>{{ $chapter->course_chapter_id }}</td>
                                    <td>{{ $chapter->course_chapter_name }}</td>
                                    <td>{{ $chapter->course_chapter_descript }}</td>
                                    <td>
                                        <a href="{{ route('list_chapters',['course_chapter_id'=> $chapter->course_chapter_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i>Danh sách
                                            </button>
                                        </a>
                                    </td>
                                    <td>
                                        @if($chapter->course_chapter_status == 0)
                                            <span style="color: white;background: red;padding: 5px 10px;">Học thử</span>
                                        @endif
                                            @if($chapter->course_chapter_status == 1)
                                            <span style="color: white;background: green;padding: 5px 10px;">Không học thử</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a data-toggle="modal" data-target="#modal_{{$chapter->course_chapter_id}}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('admin_delete_course_chapter',['course_chapter_id'=> $chapter->course_chapter_id]) }}"
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

    @foreach($list_course_chapter  as $chapter)
        <div class="modal fade" id="modal_{{$chapter->course_chapter_id}}">
            <div class="modal-dialog modal-xl">
                <form role="form" action="{{ route('admin_update_course_chapter') }}" method="POST">
                    {!! csrf_field() !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cập nhật chương cho khóa học</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề chương khóa học</label>
                                <input type="text" class="form-control" name="course_chapter_name"
                                       placeholder="Tiêu đề chương khóa học"
                                       value="{{ $chapter->course_chapter_name }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả chương khóa học</label>
                                <textarea class="form-control" name="course_chapter_descript"
                                          rows="3"> {{ $chapter->course_chapter_descript }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung chương khóa học</label>
                                <textarea class="form-control editor"
                                          id="course_chapter_content{{ $chapter->course_chapter_id }}"
                                          name="course_chapter_content">{!! $chapter->course_chapter_content !!}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái chương </label>
                                <br>
                                <label>
                                    <input type="radio" name="course_chapter_status" value="0" style="width: 25px"
                                           @if($chapter->course_chapter_status == 0) checked @endif>Học thử
                                </label>
                                <label style="margin-left: 20px">
                                    <input type="radio" name="course_chapter_status" value="1"
                                           style="width: 25px" @if($chapter->course_chapter_status == 1) checked @endif>Không
                                    học thử
                                </label>
                            </div>

                            <input type="hidden" class="form-control" name="course_id"
                                   placeholder="Tiêu đề chương khóa học" value="{{ $course->course_id }}">
                            <input type="hidden" class="form-control" name="course_chapter_id"
                                   placeholder="Tiêu đề chương khóa học" value="{{ $chapter->course_chapter_id }}">

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


    @include('admin.partials.popup_post_delete')
@endsection
