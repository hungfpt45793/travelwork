@extends('admin.layout.admin')

@section('title', ' Khóa học' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Khóa học : {{ !empty($course_title)? $course_title : '' }}
        </h1>
        <h3>
            Chương : {{ !empty($course_chapter_name)? $course_chapter_name : '' }}
        </h3>
        <h4>
            Bài  học : {{ $course_chapter->course_content_title }}
        </h4>

        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Danh sách tài liệu của bài học : {{ $course_chapter->course_content_title }}</a></li>
            <li><a href="#">Danh mục</a></li>
        </ol>
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
{{--<div><embed src="http://vinasupport.com/my_pdf_file.pdf" width="800" height="500" type="application/pdf"></div>--}}
                    {{--<div><embed src="http://sanketoan.local/public/upload_file_course/13503/13503_19_doc.pdf" width="800" height="500" type="application/pdf"></div>--}}

                    <div class="box-body">
                        <p> có tất cả {{ $total_voucher }} tài liệu của bài học </p>

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl"
                                style="margin-bottom: 15px">
                            Thêm mới tài liệu cho bài học
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_xl_answer"
                                style="margin-bottom: 15px">
                            Thêm mới đáp án cho bài học
                        </button>

                        <a href="{{ route('list_chapters',['course_chapter_id'=>$course_chapter->course_chapter_id ]) }}">
                            <button class="btn btn-primary" style="margin-left: 30px;margin-bottom: 15px">Danh sách bài học</button>
                        </a>

                        <a href="{{ route('detail_course',['course_id'=>$course_chapter->course_id ]) }}">
                            <button class="btn btn-primary" style="margin-left: 30px;margin-bottom: 15px">Danh sách chương</button>
                        </a>

                        <a href="{{ route('courses.index') }}">
                            <button class="btn btn-primary" style="margin-left: 30px;margin-bottom: 15px">Danh sách khóa học</button>
                        </a>

                        <div class="modal fade" id="modal-xl">
                            <div class="modal-dialog modal-xl">
                                <form role="form" action="{{ route('admin_store_content_voucher') }}" method="POST" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Thêm mới bài học cho chương</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tiêu đề bài học</label>
                                                <input type="text" class="form-control" name="content_voucher_title"
                                                       placeholder="Tiêu đề chương khóa học"
                                                       value="{{ old('content_voucher_title') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tài liệu học</label>
                                                <input type="file" class="form-control" name="content_voucher_link"
                                                       placeholder="Tiêu đề chương khóa học"
                                                       value="{{ old('content_voucher_link') }}">
                                            </div>
                                            <input type="hidden" class="form-control" name="course_content_id"
                                                   placeholder="Tiêu đề chương khóa học"
                                                   value="{{ $course_chapter->course_content_id }}">
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
                        <div class="modal fade" id="modal_xl_answer">
                            <div class="modal-dialog modal-xl">
                                <form role="form" action="{{ route('admin_store_content_voucher_answer') }}" method="POST" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Thêm mới bài học cho chương</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tiêu đề bài học</label>
                                                <input type="text" class="form-control" name="content_voucher_title"
                                                       placeholder="Tiêu đề chương khóa học"
                                                       value="{{ old('content_voucher_title') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tài liệu đáp án</label>
                                                <input type="file" class="form-control"
                                                       name="content_voucher_answer_link"
                                                       placeholder="Tiêu đề chương khóa học"
                                                       value="{{ old('content_voucher_answer_link') }}">
                                            </div>

                                            <input type="hidden" class="form-control" name="course_content_id"
                                                   placeholder="Tiêu đề chương khóa học"
                                                   value="{{ $course_chapter->course_content_id }}">
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

                        <p>Thêm tài liệu cho bài học</p>
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Linh tài liệu</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_voucher  as $voucher)
                                <tr>
                                    <td>{{ $voucher->course_content_voucher_id }}</td>
                                    <td>{{ $voucher->content_voucher_title }}</td>
                                    <td>{{ $voucher->content_voucher_link }}</td>
                                    <td>
                                        <a data-toggle="modal"
                                           data-target="#modal_{{$voucher->course_content_voucher_id}}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('admin_delete_content_voucher',['course_content_voucher_id'=> $voucher->course_content_voucher_id]) }}"
                                           class="btn btn-danger btnDelete" data-toggle="modal"
                                           data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <p>Thêm tài liệu đáp án bài học</p>
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Linh tài liệu đáp án</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_voucher_answer  as $voucher_answer)
                                <tr>
                                    <td>{{ $voucher_answer->course_content_voucher_answer_id }}</td>
                                    <td>{{ $voucher_answer->content_voucher_title }}</td>
                                    <td>{{ $voucher_answer->content_voucher_answer_link }}</td>
                                    <td>
                                        <a data-toggle="modal"
                                           data-target="#modal_answer{{$voucher_answer->course_content_voucher_answer_id}}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('admin_delete_content_voucher_answer',['course_content_voucher_answer_id'=> $voucher_answer->course_content_voucher_answer_id]) }}"
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

    @foreach($list_voucher  as $voucher)
        <div class="modal fade" id="modal_{{$voucher->course_content_voucher_id}}">
            <div class="modal-dialog modal-xl">
                <form role="form" action="{{ route('admin_update_content_voucher') }}" method="POST" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cập tài liệu cho bài học {{ $voucher->course_content_title }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tiêu đề tài liệu</label>
                                    <input type="text" class="form-control" name="content_voucher_title"
                                           placeholder="Tiêu đề chương khóa học"
                                           value="{{ $voucher->content_voucher_title }}">
                                </div>


                                <div class="form-group">
                                    {{--<iframe src="https://docs.google.com/gview?url={{ asset($voucher->content_voucher_link) }}&embedded=true" style="width:100%; height:300px;" frameborder="0"></iframe>--}}
                                    <label>
                                        <input type="checkbox" name="check_content_voucher_link" value="1">
                                        Chọn nếu muốn thay đổi file tài liệu
                                    </label>


                                    <label for="exampleInputEmail1">Tài liệu </label>
                                    <input type="file" class="form-control"
                                           name="content_voucher_link"
                                           placeholder="Tiêu đề chương khóa học">

                                </div>

                            </div>
                            <input type="hidden" class="form-control" name="course_content_voucher_id"
                                   placeholder="id nội dung"
                                   value="{{ $voucher->course_content_voucher_id }}">

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
    @foreach($list_voucher_answer  as $voucher_answer)
        <div class="modal fade" id="modal_answer{{$voucher_answer->course_content_voucher_answer_id}}">
            <div class="modal-dialog modal-xl">
                <form role="form" action="{{ route('admin_update_content_voucher_answer') }}" method="POST" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cập tài liệu cho bài học {{ $voucher_answer->course_content_title }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tiêu đề tài liệu</label>
                                    <input type="text" class="form-control" name="content_voucher_title"
                                           placeholder="Tiêu đề chương khóa học"
                                           value="{{ $voucher_answer->content_voucher_title }}">
                                </div>

                                <div class="form-group">
                                    {{--<iframe src="https://docs.google.com/gview?url={{ asset($voucher->content_voucher_answer_link) }}&embedded=true" style="width:100%; height:300px;" frameborder="0"></iframe>--}}
                                    <label>
                                        <input type="checkbox" name="check_content_voucher_answer_link" value="1">
                                        Chọn nếu muốn thay đổi file tài liệu
                                    </label>
                                    <label for="exampleInputEmail1">Tài liệu đáp án</label>
                                    <input type="file" class="form-control"
                                           name="content_voucher_answer_link"
                                           placeholder="Tiêu đề chương khóa học">

                                </div>


                            </div>
                            <input type="hidden" class="form-control" name="course_content_voucher_answer_id"
                                   placeholder="id nội dung"
                                   value="{{ $voucher_answer->course_content_voucher_answer_id }}">

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
