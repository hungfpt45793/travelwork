@extends('admin.layout.admin')

@section('title', 'Danh sách bài học của chương '.$course_chapter->course_chapter_name )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Khóa học : {{ !empty($course_title)? $course_title : '' }}
        </h1>
        <h3>
            Chương : {{ $course_chapter->course_chapter_name }}
        </h3>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Danh sách bài học của chương : {{ $course_chapter->course_chapter_name }}</a></li>
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



                    <div class="box-body">
                        <p> có tất cả {{ $total_chapter_content }} danh sách bài học của chương  </p>

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl" style="margin-bottom: 15px">
                            Thêm mới bài học cho chương
                        </button>


                        <a href="{{ route('detail_course',['course_id'=>$course_chapter->course_id ]) }}">
                            <button class="btn btn-primary" style="margin-left: 30px;margin-bottom: 15px">Danh sách chương</button>
                        </a>

                        <a href="{{ route('courses.index') }}">
                            <button class="btn btn-primary" style="margin-left: 30px;margin-bottom: 15px">Danh sách khóa học</button>
                        </a>

                        <div class="modal fade" id="modal-xl">
                            <div class="modal-dialog modal-xl">
                                <form role="form" action="{{ route('admin_store_chapter_content') }}" method="POST">
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
                                                <input type="text" class="form-control" name="course_content_title"
                                                       placeholder="Tiêu đề chương khóa học" value="{{ old('course_content_title') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Link Youtube</label>
                                                <textarea class="form-control" name="course_link_youtuber" rows="2"> {{ old('course_link_youtuber') }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Nội dung bài học</label>
                                                <textarea class="form-control editor" id="course_content_content"
                                                          name="course_content_content">{!! old('course_content_content') !!}</textarea>

                                                <input type="hidden" class="form-control" name="course_id"
                                                        placeholder="Tiêu đề chương khóa học" value="{{ $course_chapter->course_id }}">
                                                <input type="hidden" class="form-control" name="course_chapter_id"
                                                        placeholder="Tiêu đề chương khóa học" value="{{ $course_chapter->course_chapter_id }}">
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
                        <!-- /.modal -->

                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Hình ảnh</th>
                                <th>Mô tả</th>
                                <th>Linh Youtube</th>
                                <th>Danh sách tài liệu</th>
                                <th>Danh sách đề thi</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_chapter_content  as $content)
                                <tr>
                                    <td>{{ $content->course_content_id }}</td>
                                    <td>{{ $content->course_content_title }}</td>
                                    <td><img style="width: 50px"
                                             src="{{ !empty($content->course_content_image) ? asset($content->course_content_image) : '' }}">
                                    </td>
                                    <td>{{ $content->course_content_descript }}</td>
                                    <td>{{ $content->course_link_youtuber }}</td>
                                    <td>
                                        <?php
                                        $total_voucher = 0;
                                        $total_voucher = \App\Course\Course_content_voucher::get_total_voucher($content->course_content_id);
                                        ?>
                                        <a href="{{ route('list_content_voucher',['course_content_id'=> $content->course_content_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i>Danh sách ({{ $total_voucher }})
                                            </button>
                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                        $total_question = 0;
                                        $total_question = \App\Course\Questions_course_chapter_contents::get_total_question($content->course_content_id)
                                        ?>
                                        <a href="{{ route('list_question_content',['course_content_id'=> $content->course_content_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i>Danh sách ({{ $total_question }})
                                            </button>
                                        </a>
                                    </td>
                                    <td>
                                        <a data-toggle="modal" data-target="#modal_{{$content->course_content_id}}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('admin_delete_chapter_content',['course_content_id'=> $content->course_content_id]) }}"
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

    @foreach($list_chapter_content  as $content)
        <div class="modal fade" id="modal_{{$content->course_content_id}}">
            <div class="modal-dialog modal-xl">
                <form role="form" action="{{ route('admin_update_chapter_content') }}" method="POST">
                    {!! csrf_field() !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cập nhật bài học cho chương {{ $content->course_content_title }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề bài học</label>
                                <input type="text" class="form-control" name="course_content_title"
                                       placeholder="Tiêu đề chương khóa học" value="{{ $content->course_content_title }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Link Youtube</label>
                                <textarea class="form-control" name="course_link_youtuber" rows="2"> {{ $content->course_link_youtuber }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung bài học</label>
                                <textarea class="form-control editor" id="course_content_content{{$content->course_content_id}}"
                                          name="course_content_content">{!! $content->course_content_content !!} </textarea>

                                <input type="hidden" class="form-control" name="course_id"
                                       placeholder="Tiêu đề chương khóa học" value="{{ $course_chapter->course_id }}">
                                <input type="hidden" class="form-control" name="course_chapter_id"
                                       placeholder="Tiêu đề chương khóa học" value="{{ $course_chapter->course_chapter_id }}">
                                <input type="hidden" class="form-control" name="course_content_id"
                                       placeholder="Tiêu đề chương khóa học" value="{{ $content->course_content_id }}">
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


    @include('admin.partials.popup_post_delete')
@endsection
