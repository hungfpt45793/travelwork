@extends('staff_admin.layouts.master')
@section('title', 'Thông tin chương học' )
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
                    <h5 class="text-info">Khóa học : {{ !empty($course_title)? $course_title : '' }}</h5>
                    <h5 class="text-info">Chương : {{ $course_chapter->course_chapter_name }}</h5>
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
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-xl">
                                    Thêm mới bài học cho chương
                                </button>
                                <div class="modal fade" id="modal-xl">
                                    <div class="modal-dialog modal-xl">
                                        <form role="form" action="{{ route('store_chapter_content_staff') }}" method="POST">
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
                                                        <label for="exampleInputEmail1">Mô tả bài học</label>
                                                        <textarea class="form-control" name="course_content_descript" rows="3"> {{ old('course_content_descript') }}</textarea>
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
                            </div>
                            <div class="custom-paginate row mt-1 ml-1">
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
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table id="locker" class="custom-table tableFixHead table-bordered table-striped" data-fl-scrolls style="overflow: scroll;height:100vh;display:block;table-layout:fixed;"></table>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <td scope="col" class="lid_1"><p style="width:33px">ID<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td scope="col" class="lid_2"><p style="width:311px">Tiêu đề<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td scope="col" class="lid_4"><p style="width:311px">Mô tả<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td scope="col" class="lid_5"><p style="width:311px">Link Youtube<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            <td scope="col" class="lid_6"><p style="width:131px">Danh sách tài liệu<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                            <td scope="col" class="lid_6"><p style="width:91px">Thao tác<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list_chapter_content as $chapter)
                                        <tr>
                                            <td class="lid_1">
                                                {{ $chapter->course_content_id }}
                                            </td>
                                            <td class="lid_2">
                                                {{ $chapter->course_content_title }}
                                            </td>
                                            <td class="lid_4">
                                                {{ $chapter->course_content_descript }}
                                            </td>
                                            <td class="lid_5">{{ $chapter->course_link_youtuber }}</td>
                                            <td>
                                                <a href="{{ route('list_content_voucher_staff',['course_content_id'=> $chapter->course_content_id]) }}">
                                                    <button class="btn btn-primary btn-sm">Tài liệu</button>
                                                </a>
                                            </td>
                                            <td>
                                                <a data-toggle="modal" data-target="#modal_{{$chapter->course_content_id}}">
                                                    <button class="btn btn-primary btn-sm">Sửa</button>
                                                </a>
                                                <a href="{{ route('delete_chapter_content_staff',['course_content_id'=> $chapter->course_content_id]) }}"
                                                   class="btn btn-danger btnDelete btn-sm" onclick='confirm("Bạn có chắc chắc xóa?")'>
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
            @foreach($list_chapter_content  as $content)
        <div class="modal fade" id="modal_{{$content->course_content_id}}">
            <div class="modal-dialog modal-xl">
                <form role="form" action="{{ route('update_chapter_content_staff') }}" method="POST">
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
                                <label for="exampleInputEmail1">Mô tả bài học</label>
                                <textarea class="form-control" name="course_content_descript" rows="2"> {{ $content->course_content_descript }}</textarea>
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
        </div>
    </div>
</div>
@endsection
