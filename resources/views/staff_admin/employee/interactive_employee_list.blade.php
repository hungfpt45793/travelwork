@extends('staff_admin.layouts.master')
@section('title', 'Tương tác ứng viên '.$employee->employee_name)
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employee')
            </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting col-f14 ">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-start">
                                {{-- <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a> --}}
                                <a href="{{ route('interactive_employee_list', ['id' => $employee->employee_id]) }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                                {{-- <a href="{{ route('staff_employee.create') }}" class="btn btn-success btn-sm mr-1 ">Thêm mới</a> --}}
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
                                                        {{-- <div class="col-md-4 mb-3">
                                                            <label for="validationDefault01">Từ ngày</label>
                                                            @php
                                                                    $d=strtotime("-1 Months");
                                                                    $date = date("Y-m-d", $d)
                                                            @endphp
                                                            <input value="{{ $date }}" class="form-control" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : '' }}" type="date" id="" name="date_search_start">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                            <label for="validationDefault02">Đến ngày</label>
                                                            <input value="{{ date("Y-m-d") }}" class="form-control" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : '' }}" type="date" id="" name="date_search_end">
                                                            </div> --}}

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
                                    {{ $interactive_employee->links() }}
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
                                | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $interactive_employee->total() }} bản ghi
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table id="locker" class="custom-table tableFixHead table-bordered table-striped" data-fl-scrolls style="overflow: scroll;height:100vh;display:block;table-layout:fixed;"></table>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <td class="lid_1"><p style="width:39px">id<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td class="lid_2"><p style="width:162px">Ứng viên<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td class="lid_3"><p style="width:101px">Số điện thoại<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td class="lid_4"><p style="width:182px">Email<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td class="lid_5"><p style="width:116px">Ngày tương tác<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            <td class="lid_6"><p>Nội dung tương tác<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($interactive_employee as $statis)
                                            <tr>
                                                <td class="lid_1">
                                                    {{ $statis->employee_id }}
                                                </td>
                                                <td class="lid_2">
                                                    {{ $statis->employee_name }}
                                                </td>
                                                <td class="lid_3 text-center">{{ $statis->phone }}</td>
                                                <td class="lid_4">{{ $statis->email }}</td>
                                                <td class="lid_5 text-center">
                                                    <?php
                                                        $date=date_create($statis->interactive_day);
                                                        echo date_format($date,"d/m/Y");
                                                    ?>
                                                </td>
                                                <td class="lid_6"><p class="crop" style="width:300px">{{ $statis->content }}</p></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
@endsection
