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
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-start">
                                {{-- <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a> --}}
                                <a href="{{ route('list_chapters_staff', $course->course_id) }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-xl">Thêm mới hình thức học</button>
                                <div class="modal fade" id="modal-xl">
                                    <div class="modal-dialog modal-xl">
                                        <form role="form" action="{{ route('store_formality_staff') }}" method="POST">
                                            {!! csrf_field() !!}
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hình thức học </h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Giá</label>
                                                        <input type="text" class="form-control formatPrice" name="course_formality_price" placeholder="Giá">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Giảm giá</label>
                                                        <input type="text" class="form-control formatPrice" name="course_formality_discount" placeholder="Giảm giá">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Mô tả </label>
                                                        <textarea class="form-control" name="course_formality_des" rows="3"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Chọn hình thức </label>
                                                        <select class="form-control select22" name="course_formality_id">
                                                            <?php
                                                                $list_forma = \App\Course\Course_formality::where('course_formality_id', '!=', 1)->get();
                                                            ?>
                                                            @foreach($list_forma as $forma)
                                                                <option value="{{ $forma->course_formality_id }}" @if(in_array($forma['course_formality_id'], $formality_id)) disabled @endif>
                                                                    {{ !empty($forma->course_formality_title) ? $forma->course_formality_title : '' }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="course_id" value="{{ $course->course_id }}">
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

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
                            </div>
                            <div class="custom-paginate row mt-1 ml-1">
                                    {{ $list_formality->links() }}
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
                                | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $list_formality->total() + 1 }} bản ghi
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-wrapper tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table  data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <td scope="col" class="lid_1"><p style="width:41px">STT<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td scope="col" class="lid_2"><p style="width:200px">Hình thức học<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td scope="col" class="lid_3"><p style="width:500px">Mô tả<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td scope="col" class="lid_4"><p>Giá<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td scope="col" class="lid_5"><p>Giảm giá<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            <td scope="col" class="lid_5"><p style="width:90px">Thao tác<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>0</td>
                                            <td>Tự học</td>
                                            <td>Học qua video</td>
                                            <td>{{ !empty($course->course_price) ? number_format($course->course_price, 0, ',', '.') : '' }} VNĐ</td>
                                            <td>{{ !empty($course->course_discount) ? number_format($course->course_discount, 0, ',', '.') : '' }} VNĐ</td>
                                            <td>
                                                <a href="{{ route('coursesStaff.edit',['course_id'=> $course->course_id]) }}">
                                                    <button class="btn btn-primary btn-sm">Sửa</button>
                                                </a>
                                            </td>
                                        </tr>
                                        @foreach($list_formality  as $id_for=>$formality)
                                            <tr>
                                                <td class="lid_1">{{ $id_for + 1 }}</td>
                                                <td class="lid_1">
                                                    <p class="crop">
                                                        {{ !empty($formality->course_formality_title) ? $formality->course_formality_title : '' }}
                                                    </p>
                                                </td>
                                                <td class="lid_1">
                                                    {{ !empty($formality->course_formality_des) ? $formality->course_formality_des : '' }}
                                                </td>
                                                <td class="lid_1 crop">{{ !empty($formality->course_formality_price) ? number_format($formality->course_formality_price, 0, ',', '.') : '' }} VNĐ</td>
                                                <td class="lid_1 crop">{{ !empty($formality->course_formality_discount) ? number_format($formality->course_formality_discount, 0, ',', '.') : '' }} VNĐ</td>
                                                <td>
                                                    <a data-toggle="modal" data-target="#modal_{{$formality->course_formality_id}}">
                                                        <button class="btn btn-sm btn-primary">Sửa</button>
                                                    </a>
                                                    <a href="{{ route('delete_formality_staff',['course_join_formality_id'=> $formality->course_join_formality_id]) }}"
                                                    class="btn btn-danger btn-sm" onclick='confirm("Bạn có chắc chắc xóa?")'>
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
            @foreach($list_formality  as $id_for=>$formality)
        <div class="modal fade" id="modal_{{$formality->course_formality_id}}">
            <div class="modal-dialog modal-xl">
                <form role="form" action="{{ route('update_formality_staff') }}" method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Hình thức học : {{ $formality->course_formality_title }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá</label>
                                <input type="text" class="form-control formatPrice" name="course_formality_price"
                                       placeholder="Giá" value="{{ $formality->course_formality_price }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giảm giá</label>
                                <input type="text" class="form-control formatPrice" name="course_formality_discount"
                                       placeholder="Giảm giá" value="{{ $formality->course_formality_discount }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả </label>
                                <textarea class="form-control" name="course_formality_des"
                                          rows="3"> {{ $formality->course_formality_des }}</textarea>
                                <input type="hidden" name="course_join_formality_id"
                                       value="{{ $formality->course_join_formality_id }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Chọn hình thức </label>
                                <select class="form-control select22" name="course_formality_id">
                                    @foreach($list_forma as $forma)
                                        <option value="{{ $forma->course_formality_id }}"
                                                @if(in_array($forma['course_formality_id'], $formality_id)) disabled @endif
                                                @if($formality->course_formality_id == $forma->course_formality_id) selected @endif >
                                            {{ !empty($forma->course_formality_title) ? $forma->course_formality_title : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
        </div>
    </div>
</div>
@endsection
