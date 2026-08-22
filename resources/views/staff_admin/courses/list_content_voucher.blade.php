@extends('staff_admin.layouts.master')
@section('title', 'Thông tin tài liệu' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.courses')
            </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting col-f14 ">
                    <h5 class="text-info">
                        Khóa học : {{ !empty($course_title)? $course_title : '' }}
                    </h5>
                    <h5 class="text-info">
                        Chương : {{ !empty($course_chapter_name)? $course_chapter_name : '' }}
                    </h5>
                    <h5 class="text-info">
                        Bài  học : {{ $course_chapter->course_content_title }}
                    </h5>
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-start">
                                {{-- <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a> --}}
                                {{-- <a href="{{ route('list_chapters_staff', $course_chapter->course_id) }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a> --}}
                                <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                        <form action="">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm ứng viên đăng ký tư vấn</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">

                                                        <div class="col-md-4">
                                                            <?php $money_get = isset($_GET["money"]) ? $_GET["money"] : "";
                                                            ?>
                                                            <select class="form-control select2" name="money">
                                                                <option value="">-- Số tiền ứng trước --</option>
                                                                <option value="asc" @if($money_get == "asc")  selected @endif>-- Từ thấp đến cao --</option>
                                                                <option value="desc" @if($money_get == "desc")  selected @endif>-- Từ cao đến thấp --</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <?php $total_teacher_get = isset($_GET["total_teacher"]) ? $_GET["total_teacher"] : ""?>
                                                            <select class="form-control select2" name="total_teacher">
                                                                <option value="">-- Tổng số giáo viên --</option>
                                                                <option value="asc" @if($total_teacher_get == "asc") selected @endif>-- Từ thấp đến cao --</option>
                                                                <option value="desc" @if($total_teacher_get == "desc") selected @endif>-- Từ cao đến thấp --</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <?php $total_exam_get = isset($_GET["total_exam"]) ? $_GET["total_exam"] : ""?>
                                                            <select class="form-control select2" name="total_exam">
                                                                <option value="">-- Số lần thi trắc nghiệm --</option>
                                                                <option value="asc" @if($total_exam_get == "asc")  selected @endif>-- Từ thấp đến cao --</option>
                                                                <option value="desc" @if($total_exam_get == 'desc')  selected @endif>-- Từ cao đến thấp --</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-top: 1%">
                                                        <div class="col-md-4">
                                                            <?php
                                                            $total_dowload_voucher_get = "";
                                                            if(isset($_GET["total__dowload_voucher"]))
                                                            {
                                                                $total_dowload_voucher_get = $_GET["total__dowload_voucher"];
                                                            }
                                                            ?>
                                                            <select class="form-control select2" name="total__dowload_voucher">
                                                                <option value="">-- Số lần tải tài liệu --</option>
                                                                <option value="asc" @if($total_dowload_voucher_get == "asc") selected @endif>-- Từ thấp đến cao --</option>
                                                                <option value="desc" @if($total_dowload_voucher_get == "desc") selected @endif>-- Từ cao đến thấp --</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <?php $total_view_voucher_get = isset($_GET["total_view_voucher"]) ? $_GET["total_view_voucher"] : ""?>
                                                            <select class="form-control select2" name="total_view_voucher">
                                                                <option value="">-- Số lần xem tài liệu --</option>
                                                                <option value="asc" @if($total_view_voucher_get == "asc") selected @endif>-- Từ thấp đến cao --</option>
                                                                <option value="desc" @if($total_view_voucher_get == "desc") selected @endif>-- Từ cao đến thấp --</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <?php $total_view_job_get = isset($_GET["total_view_job"]) ? $_GET["total_view_job"] : ""?>
                                                            <select class="form-control select2" name="total_view_job">
                                                                <option value="">-- Số lần xem tin tuyển dụng --</option>
                                                                <option value="asc" @if($total_view_job_get == "asc") selected @endif>-- Từ thấp đến cao --</option>
                                                                <option value="desc" @if($total_view_job_get == "desc") selected @endif>-- Từ cao đến thấp --</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-top: 1%">
                                                        <div class="col-md-4">
                                                            <?php $total_cv_get = isset($_GET["total_cv"]) ? $_GET["total_cv"] : ""?>
                                                            <select class="form-control select2" name="total_cv">
                                                                <option value="">-- Số lần cập nhật CV --</option>
                                                                <option value="asc" @if($total_cv_get == "asc") selected @endif>-- Từ thấp đến cao --</option>
                                                                <option value="desc" @if($total_cv_get == "desc") selected @endif>-- Từ cao đến thấp --</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <?php $email_get = isset($_GET["email"]) ? $_GET["email"] : ""?>
                                                            <input style="height: 28px;" type="text" placeholder="Email ứng viên"
                                                                   class="form-control " name="email" value="{{ $email_get }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <?php $phone_get = isset($_GET["phone"]) ? $_GET["phone"] : ""?>
                                                            <input type="text" placeholder="Số điện thoại ứng viên"
                                                                   class="form-control " name="phone" value="{{ $phone_get }}">
                                                        </div>
                                                    </div>
                                                <div class="row" style="margin-top: 1%">
                                                    <div class="col-md-4">
                                                        <?php $name_get = isset($_GET["name"]) ? $_GET["name"] : ""?>
                                                        <input type="text" placeholder="Tên ứng viên"
                                                               class="form-control " name="name" value="{{$name_get}}">
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit " class="btn btn-primary">Tìm kiếm</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#modal-xl">
                                    Thêm mới tài liệu cho bài học
                                </button>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_xl_answer">
                                    Thêm mới đáp án cho bài học
                                </button>
                                <div class="modal fade" id="modal-xl">
                                    <div class="modal-dialog modal-xl">
                                        <form role="form" action="{{ route('store_content_voucher_staff') }}" method="POST" enctype="multipart/form-data">
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
                                        <form role="form" action="{{ route('store_content_voucher_answer_staff') }}" method="POST" enctype="multipart/form-data">
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
                            </div>
                            {{-- <div class="custom-paginate">
                                    {{ $list_chapter_content->links() }}
                                số bản ghi của một trang:
                                <span class="input-submit">
                                    <form action="" class="inline">
                                        <input type="submit" value="200" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
                                        <input type="submit" value="50" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
                                        <input type="submit" value="40" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
                                        <input type="submit" value="30" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
                                        <input type="submit" value="20" name="num"  class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
                                        <input type="submit" value="10" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
                                    </form>
                                </span>
                                | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $total }} bản ghi
                            </div> --}}
                        </div>
                        <div class="col-md-12">
                            <div class="table-wrapper tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <h4>Tài liệu cho bài học</h4>
                                <table  data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:auto;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            {{-- <td scope="col">
                                                <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                            </td> --}}
                                            <td scope="col" class="lid_1"><p style="width:33px">ID<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td scope="col" class="lid_2"><p>Tiêu đề<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td scope="col" class="lid_3"><p style="width:500px">Link tài liệu<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td scope="col" class="lid_3"><p style="width:91px">Thao tác<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list_voucher as $voucher)
                                        <tr>
                                            <td>{{ $voucher->course_content_voucher_id }}</td>
                                            <td>{{ $voucher->content_voucher_title }}</td>
                                            <td><a href="{{ asset($voucher->content_voucher_link) }}" target="_blank" rel="noopener noreferrer">{{ $voucher->content_voucher_link }}</a></td>
                                            <td>
                                                <a data-toggle="modal"
                                                   data-target="#modal_{{$voucher->course_content_voucher_id}}">
                                                    <button class="btn btn-sm btn-primary">Sửa</button>
                                                </a>
                                                <a href="{{ route('delete_content_voucher_staff',['course_content_voucher_id'=> $voucher->course_content_voucher_id]) }}"
                                                   class="btn btn-danger btn-sm btnDelete" onclick='confirm("Bạn có chắc chắc xóa?")'>
                                                    Xóa
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <h4>Tài liệu đáp án bài học</h4>
                                <table  data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:auto;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            {{-- <td scope="col">
                                                <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                            </td> --}}
                                            <td scope="col" class="lid_1"><p style="width:33px">ID<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td scope="col" class="lid_2"><p>Tiêu đề<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td scope="col" class="lid_3"><p style="width:500px">Link tài liệu đáp án<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td scope="col" class="lid_3"><p style="width:91px">Thao tác<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list_voucher_answer as $voucher_answer)
                                        <tr>
                                            <td>{{ $voucher_answer->course_content_voucher_answer_id }}</td>
                                            <td>{{ $voucher_answer->content_voucher_title }}</td>
                                            <td><a href="{{ asset($voucher_answer->content_voucher_answer_link) }}" target="_blank" rel="noopener noreferrer">{{ $voucher_answer->content_voucher_answer_link }}</a></td>
                                            <td>
                                                <a data-toggle="modal"
                                                   data-target="#modal_answer{{$voucher_answer->course_content_voucher_answer_id}}">
                                                    <button class="btn btn-sm btn-primary">Sửa</button>
                                                </a>
                                                <a href="{{ route('delete_content_voucher_answer_staff',['course_content_voucher_answer_id'=> $voucher_answer->course_content_voucher_answer_id]) }}"
                                                   class="btn btn-danger btn-sm btnDelete" onclick='confirm("Bạn có chắc chắc xóa?")'>
                                                    Xóa
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @foreach($list_voucher  as $voucher)
            <div class="modal fade" id="modal_{{$voucher->course_content_voucher_id}}">
                <div class="modal-dialog modal-xl">
                    <form role="form" action="{{ route('update_content_voucher_staff') }}" method="POST" enctype="multipart/form-data">
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
                    <form role="form" action="{{ route('update_content_voucher_answer_staff') }}" method="POST" enctype="multipart/form-data">
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
        </div>
    </div>
</div>
@endsection
