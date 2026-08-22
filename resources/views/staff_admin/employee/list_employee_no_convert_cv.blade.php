<?php
$num = '';
if(isset($_GET['num'])){
    $num = $_GET['num'];
}
?>
@extends('staff_admin.layouts.master')

@section('title', 'Danh sách ứng viên' )

@section('content')
    <div class="container-fluid">
        <div class="row row-content">
            {{-- sitebar --}}
            <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
                @include('staff_admin.sidebars.employee')
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
                <section class="jobsInteresting bgrWhite bdLightGray radius5 " style="height: auto">
                    <div class="contentJobsInteresting  col-f14 ">
                        <div class="log_error">
                            @if (session('error'))
                                <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                                    <div class="alert alert-danger mg-b-0 " role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="close iconAlert" data-dismiss="alert"
                                                aria-label="Close">x</button>
                                    </div>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                                    <div class="alert alert-success mg-b-0 ">
                                        {{session('success')}}
                                        <button type="button" class="close iconAlert" data-dismiss="alert"
                                                aria-label="Close">x</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Employee_id</th>
                                <th scope="col">User_id</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Link chi tiết</th>
                            </tr>
                            </thead>
                            <tbody>
                        @foreach($list_cv as $cv)
                            <tr>
                                <th scope="row">{{ $cv['employee_id'] }}</th>
                                <td>{{ $cv['user_id'] }}</td>
                                <td>{{ $cv['employee_name'] }}</td>
                                <td><a target="_blank" href="{{ route('staff_detail_convert_cv',['employee_id' => $cv['employee_id']]) }}">Link chi tiết xử lý file</a></td>
                                <td><a target="_blank" href="{{ route('detail_employee_show',['employee_slug' => $cv['employee_slug']]) }}">Link xem ngoài web</a></td>

                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </section>
                <!-- The Modal -->
            </div>
        </div>
    </div>
@endsection
