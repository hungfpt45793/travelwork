<?php
    $num = '';
    if(isset($_GET['num'])){
        $num = $_GET['num'];
    }
?>
@extends('staff_admin.layouts.master')
@section('title', 'Danh sách danh mục')
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.courses')
            </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting  col-f14 ">
                    <div class="log_error">
                        @if (session('error'))
                            <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                                <div class="alert alert-danger mg-b-0 " role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                                <div class="alert alert-success mg-b-0 ">
                                    {{session('success')}}
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="custom-order">
                        <div class="custom-paginate first-order ml-1 mt-1 row">
                            {{ $list_category_course->links() }}
                            số bản ghi của một trang:
                            <span class="input-submit">
                                <form action="" class="inline">
                                    <input type="submit" value="200" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
                                    <input type="submit" value="50" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
                                    <input type="submit" value="40" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
                                    <input type="submit" value="30" name="num" class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
                                    <input type="submit" value="20" name="num"  class="{{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
                                    <input type="submit" value="10" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
                                </form>
                            </span>
                            | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '30' }}/{{ $list_category_course->total() }} bản ghi
                        </div>
                        <div class="d-flex justify-content-between second-order" style="width:-webkit-fill-available">
                            <div>
                            <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                    <form action="" method="GET">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="submit " class="btn btn-primary">Tìm kiếm</button>
                                                <input type="reset" class="btn btn-sm btn-success" value="Reset">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <a href="{{ route('categoryCourse.index') }}" class="btn btn-sm btn-success mr-1 text-white">Làm tươi</a>
                            <a href="{{ route('categoryCourse.create') }}" class="btn btn-sm btn-success mr-1 text-white">Thêm mới</a>
                            </div>
                            <div>
                                <form action="" class="">
                                    <div class="group-form border border-primary">
                                        <input class="border-0 input-lg" type="text"
                                            name="course_id" style="width:83px"
                                            value="{{ (!empty($_GET['course_id'])) ? $_GET['course_id'] : ''  }}"
                                            placeholder="ID Danh mục">
                                        <button class="search border-0" type="submit"><i class="fa fa-search "
                                                aria-hidden="true"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row mr-1">
                        <div class="col-md-12">
                            <form action="{{route('exportExcelEmployee')}}" method="get" id="form_export_excel">
                                    {{ csrf_field() }}
                            <div id="locker" data-fl-scrolls class="custom-table table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                    </div>
                                    @foreach ($list_category_course as $employee)
                                    <div class="cellWrap">
                                        <input type="checkbox" id_customer="{{$employee->course_id}}" class="checkItem" name="list_id[]"
                                        value="{{$employee->course_id}}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            </form>
                                <div class="table-wrapper tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table  data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <td scope="col" class="lid_1"><p style="width:33px">ID<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td scope="col" class="lid_9"><p>Thao tác<button class="lockButton btn btn-sm btn-success" id="lid_9">L</button></p></td>
                                            <td scope="col" class="lid_2"><p style="width:82px">Tiêu đề<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td scope="col" class="lid_3"><p style="width:82px">Mô tả<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td scope="col" class="lid_5"><p style="width:110px">Ngày tạo<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list_category_course as $courses)
                                        <tr>
                                            <td scope="row" class="lid_1">{{ $courses->category_course_id }}</td>
                                            <td class="lid_3">
                                                <div class="dropdown show">
                                                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Thao tác
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <a class="dropdown-item" href="{{ route('categoryCourse.edit',['category_course_id'=>$courses->category_course_id]) }}">Sửa</a>
                                                        <a href="{{ route('categoryCourseDestroy',['category_course_id'=> $courses->category_course_id]) }}"
                                                            class="dropdown-item" onclick='confirm("Bạn có chắc chắc xóa?")'>Xóa
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="lid_5">{{ $courses->category_course_title }}</td>
                                            <td class="lid_6">{{ $courses->category_course_desc }}</td>
                                            <td class="lid_7">
                                                <?php
                                                    $date_edu = date_create($courses->created_at);
                                                    echo date_format($date_edu, "d/m/Y");
                                                ?>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </section>
        </div>
    </div>
</div>
<script>
    $('.delete_all').click(function(){
        var x = confirm("Bạn có chắc chắc xóa?");
        if (x){
            var Ids = [];
            $.each($(".checkItem:checked"), function () {
                Ids.push($(this).val());
            });

            if(Ids.length == 0){
                var changeHtml2 = '';
                changeHtml2+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                changeHtml2+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                changeHtml2+=        'Vui lòng chọn ứng viên';
                changeHtml2+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                changeHtml2+=    '</div>';
                changeHtml2+= '</div>';
                $('.log_error').html(changeHtml2);
                event.preventDefault();
            }
            else{
                var content = $("#feedback_all").val();
                var changeHtml = '';
                $.ajax({
                    type: 'post',
                    url: '{{route("staff_employee_delete_all")}}',
                    data: 'Ids='+Ids,
                    success: function (data) {
                        location.reload();
                        console.log(data);
                        if (data) {
                            changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                            changeHtml+=    '<div class="alert alert-success mg-b-0 ">';
                            changeHtml+=        'Xóa thành công';
                            changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                            changeHtml+=    '</div>';
                            changeHtml+= '</div>';
                            $('.log_error').html(changeHtml);
                        }

                    },
                    error: function (err) {
                        console.log(err);
                        changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
                        changeHtml+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
                        changeHtml+=        'Xóa không thành công';
                        changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
                        changeHtml+=    '</div>';
                        changeHtml+= '</div>';
                        $('.log_error').html(changeHtml);
                    }
                });
            }
        }
        else
            return false;
    });

    $('#checkAllSendMail').click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>
@endsection
