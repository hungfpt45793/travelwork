@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', 'Quản lý bài học của chương')
@section('meta_description', 'Quản lý bài học của chương')
@section('keywords', 'Quản lý bài học của chương')
@section('meta_image', !empty($course['course_image']) ? asset($course['course_image']) : asset($information['logo']))

@section('show_css')
    {{--<link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>--}}
    <link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/teacher_course.css"/>

@endsection

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar_site.sidebar_job_face')

                <div class="col-xl-9 col-lg-8 col-md-12 ">
                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_teacher_courses') }}">Quản lý khóa học</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_course_chapter',['courses_id' => $course_chapter_contents->course_id])  }}">Danh
                                    sách chương</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_chapter_content',['course_chapter_id' => $course_chapter_contents->course_chapter_id])  }}">Danh
                                    sách bài học</a>
                            </li>
                        </ul>
                    </div>
                    <section class="jobsInteresting bgrWhite  radius5 mgt10">
                        <div class="titleJobs  fw6 f20 bg-white mgb20 pd010 pd10 border_1px  ">
                            Danh sách tài liệu của bài học : {{ $course_chapter_contents->course_content_title }}
                            <p class="mgb10">
                                <a class="btnOrange f14" data-toggle="modal" data-target="#modal-xl"> Thêm mới tài
                                    liệu </a>
                            </p>


                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                @if (session('success'))
                                    <div class="alert alert-success text-center" role="alert" style="width: 100%">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger text-center" role="alert" style="width: 100%">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <table id="jobfb" class="table table-hover table-bordered text-center"
                                       style="background: #fff">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tiêu đề</th>
                                        <th>Link Tài liệu</th>
                                        <th>Thao tác</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if(!empty($list_voucher))
                                        @foreach($list_voucher as $id=>$voucher)
                                            <tr>
                                                <td>{{ $id + 1 }}</td>
                                                <td>{{ $voucher->content_voucher_title }}</td>
                                                <td><a target="_blank"
                                                       href=" https://sanketoan.vn/{{ $voucher->content_voucher_link }}"
                                                       data-id=" {{ $voucher->course_content_voucher_id }}"
                                                       download="{{ str_slug($voucher->content_voucher_title) }}.{{ isset($voucher->content_voucher_title) ? $voucher->content_voucher_title : '' }}"
                                                       class="pd10 radius5 white noDecoration hvWhite bgrDownload mgt10 dsInline js_add_upload_href"
                                                       style="background-color: orange;margin-top: 6px;padding: 6px 10px;vertical-align: text-bottom;color: #fff"
                                                       id="dowloadVoucher"><i
                                                                class="fas fa-cloud-download-alt"></i> Tải xuống</a>
                                                </td>
                                                <td>
                                                    <a data-toggle="modal"
                                                       data-target="#modal_{{$voucher->course_content_voucher_id}}">
                                                        <button class="btn btn-primary"><i class="far fa-edit"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('delete_content_voucher',['course_content_voucher_id'=> $voucher->course_content_voucher_id]) }}"
                                                       class="btn btn-danger btnDelete" data-toggle="modal"
                                                       data-target="#myModalDelete"
                                                       onclick="return submitDelete(this);"><i
                                                                class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p class="clRed">Chưa có khóa học nào được tạo</p>
                                    @endif
                                    </tbody>
                                </table>


                            </div>


                        </div>
                    </section>


                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 bg-white mgb20 pd010 pd10 border_1px  ">
                            Danh sách đáp án tài liệu của bài học : {{ $course_chapter_contents->course_content_title }}
                            <p class="mgb10">
                                <a class="btnOrange f14" data-toggle="modal" data-target="#modal_xl_answer"> Thêm mới
                                    đáp án tài liệu </a>
                            </p>


                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                @if (session('success_anwer'))
                                    <div class="alert alert-success text-center" role="alert" style="width: 100%">
                                        {{ session('success_anwer') }}
                                    </div>
                                @endif
                                @if (session('success_anwer'))
                                    <div class="alert alert-danger text-center" role="alert" style="width: 100%">
                                        {{ session('success_anwer') }}
                                    </div>
                                @endif

                                <table id="jobfb" class="table table-hover table-bordered text-center"
                                       style="background: #fff">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tiêu đề</th>
                                        <th>Link đáp án</th>
                                        <th>Thao tác</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if(!empty($list_voucher_answer))
                                        @foreach($list_voucher_answer as $id=>$voucher_answer)
                                            <tr>
                                                <td>{{ $id + 1 }}</td>
                                                <td>{{ $voucher_answer->content_voucher_title }}</td>
                                                <td>
                                                    <a target="_blank"
                                                       href=" https://sanketoan.vn/{{ $voucher->content_voucher_link }}"
                                                       data-id=" {{ $voucher->course_content_voucher_id }}"
                                                       download="{{ str_slug($voucher->content_voucher_title) }}.{{ isset($voucher->content_voucher_title) ? $voucher->content_voucher_title : '' }}"
                                                       class="pd10 radius5 white noDecoration hvWhite bgrDownload mgt10 dsInline js_add_upload_href"
                                                       style="background-color: orange;margin-top: 6px;padding: 6px 10px;vertical-align: text-bottom;color: #fff"
                                                       id="dowloadVoucher"><i
                                                                class="fas fa-cloud-download-alt"></i> Tải xuống</a>
                                                </td>

                                                <td>
                                                    <a data-toggle="modal"
                                                       data-target="#modal_answer{{$voucher_answer->course_content_voucher_answer_id}}">
                                                        <button class="btn btn-primary"><i class="far fa-edit"></i>
                                                        </button>
                                                    </a>

                                                    <a href="{{ route('delete_content_voucher_answer',['course_content_voucher_answer_id'=> $voucher_answer->course_content_voucher_answer_id]) }}"
                                                       class="btn btn-danger btnDelete" data-toggle="modal"
                                                       data-target="#myModalDelete"
                                                       onclick="return submitDelete(this);"><i
                                                                class="fas fa-trash-alt"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p class="clRed">Chưa có khóa học nào được tạo</p>
                                    @endif
                                    </tbody>
                                </table>


                            </div>


                        </div>
                    </section>
                </div>
            </div>
            {{--@include('site.module_index_site.hotline')--}}

        </div>
    </section>


    <div class="modal fade" id="myModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn muốn xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <form action="" class="submitDelete" method="post">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Đồng ý</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{--//thêm mới tài liệu modal--}}
    <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-xl">
            <form role="form" action="{{ route('store_content_voucher') }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm mới tài liệu</h4>
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
                    <div class="modal-footer">
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
            <form role="form" action="{{ route('store_content_voucher_answer') }}" method="POST"
                  enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm mới tài liệu đáp án</h4>
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
                    <div class="modal-footer">
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
    {{--//cập nhật tài liệu modal--}}
    @foreach($list_voucher  as $voucher)
        <div class="modal fade" id="modal_{{$voucher->course_content_voucher_id}}">
            <div class="modal-dialog modal-xl">
                <form role="form" action="{{ route('update_content_voucher') }}" method="POST"
                      enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cập tài liệu cho bài học {{ $voucher->course_content_title }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
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


                            <input type="hidden" class="form-control" name="course_content_voucher_id"
                                   placeholder="id nội dung"
                                   value="{{ $voucher->course_content_voucher_id }}">

                        </div>
                        <div class="modal-footer ">
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
                <form role="form" action="{{ route('update_content_voucher_answer') }}" method="POST"
                      enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cập tài liệu cho bài
                                học {{ $voucher_answer->course_content_title }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
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


                            <input type="hidden" class="form-control" name="course_content_voucher_answer_id"
                                   placeholder="id nội dung"
                                   value="{{ $voucher_answer->course_content_voucher_answer_id }}">

                        </div>
                        <div class="modal-footer">
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

@endsection

@section('show_js')
    <script>
        function submitDelete(e) {
            var url = $(e).attr('href');
            console.log(url);
            $('.submitDelete').attr('action', url);
            return false;
        }
    </script>


    <script type="text/javascript" src="/assets/js/sitebar.js"></script>
    <script>
        $('.js_show_search_job').click(function () {
            $('.js_filter_job_face').toggle();
        });
        $('.js_show_sidebar').click(function () {
            $('#js_toogle_sidebar').toggle();
            $('.js_closed_open').toggle();
        });
    </script>
@endsection

