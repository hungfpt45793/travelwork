<?php

    $name = '';
    if(isset($_GET['name'])){
        $name = $_GET['name'];
    }
    $num = '';
    if(isset($_GET['num'])){
        $num = $_GET['num'];
    }
?>
@extends('staff_admin.layouts.master')

@section('title', 'Danh sách tương tác ứng viên' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employee')
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
                        <div class="custom-paginate first-order row mt-1 ml-1">
                            {{ $interactive_employee->links()  }}
                            <span class="input-submit">
                                <form action="" class="inline">
                                    <input type="text" name="num" value="{{ (isset($_GET['num'])) ? $_GET['num'] : '' }}" style="width:80px" placeholder="p/trang">
						            <button type="submit" class="btn btn-sm btn-success"  style="padding:initial">Xem</button>

						            <input type="hidden" name="date_search_start" value="{{ (isset($_GET['date_search_start'])) ? $_GET['date_search_start'] : '' }}">
						            <input type="hidden" name="date_search_end" value="{{ (isset($_GET['date_search_end'])) ? $_GET['date_search_end'] : '' }}">
                                </form>
                            </span>
                        </div>
                        <div class="d-flex justify-content-start second-order">
                            <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a>
                            <a href="{{ route('interactive_employee') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                            <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                    <form action="" method="GET">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm ứng viên</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row employee-search ">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationDefault01">Từ ngày(ngày ứng tuyển)</label>
                                                        @php
                                                              $d=strtotime("-1 Months");
                                                              $date = date("Y-m-d", $d)
                                                        @endphp
                                                        <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : $date }}" type="date" id="" name="date_search_start">
                                                        <input type="hidden" name="num" value="{{ (isset($_GET['num'])) ? $_GET['num'] : '' }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationDefault02">Đến ngày(ngày ứng tuyển)</label>
                                                        <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : date("Y-m-d") }}" type="date" id="" name="date_search_end">
                                                    </div>
                                                      <!-- myDatetime -->
                                                    <div class="col-md-4 offset-md-4 mb-3">
                                                        <input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày">
                                                    </div>
                                                    <div class="col-md-4 col-xs-6  "></div>
                                                    <div class="col-md-12 col-xs-12  ">
                                                        <div class="form-group">
                                                            <label for="">Tên ứng viên</label>
                                                            <?php $name_get = isset($_GET['name']) ? $_GET['name'] : '';?>
                                                            <input type="text "  placeholder="Tên ứng viên" class="form-control " name="name" value="{{ $name_get }}">
                                                        </div>
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
                    </div>

                    <div class="row mr-1">

                        <div class="col-md-12">
                                <div class="table-wrapper tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table  data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <td>Ứng viên</td>
                                            <td>Số điện thoại</td>
                                            <td>Email</td>
                                            <td>Lần tương tác</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($interactive_employee as $submit)
                                        <tr>
                                            <td><a target="_blank" href="{{ route('staff_employee_edit_form',$submit->employee_id) }}">{{ $submit->employee_name }}</a></td>
                                            <td>{{ $submit->phone }}</td>
                                            <td>{{ $submit->email }}</td>
                                            <td>
                                                <a href="{{ route('interactive_employee_list',['interactive_employee_id'=> $submit->employee_id]) }}">
                                                    <button class="btn btn-primary btn-sm"><i class="fa fa-newspaper-o" aria-hidden="true"></i>
                                                    Tương tác (<span>
                                                            <?php
                                                            $total = 0;
                                                            $total = \App\Entity\Interactive_history_employee::get_total_interactive_employee($submit->employee_id, Auth::user()->id);
                                                            echo $total;
                                                            ?>
                                                        </span>)
                                                    </button>
                                                </a>
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
            <!-- The Modal -->
        </div>
    </div>
</div>

@endsection
