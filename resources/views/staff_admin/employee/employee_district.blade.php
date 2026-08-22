@extends('staff_admin.layouts.master')

@section('title', 'Thống kê giáo viên huyện' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employee')
            </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting pd15 col-f14 ">
                    <h5>Tỉnh {{ $province_name }}</h5>
                    <ul class="ul-province">
                        @foreach ($districts as $district)
                        <?php
                            $count = App\Http\Controllers\Staff\EmployeeController::countEmployeeD($district->district_id);
                            $countEmployeeApprovedD = App\Http\Controllers\Staff\EmployeeController::countEmployeeApprovedD($district->district_id);
                            $countEmployeeNotApprovedD = App\Http\Controllers\Staff\EmployeeController::countEmployeeNotApprovedD($district->district_id);
                        ?>
                        <!-- <form action="{{ route('staff_employee.index') }}" method="get">
                            <input type="hidden" value="{{ $district->district_id }}" name="district">
                            <input type="hidden" value="{{ $province_id }}" name="province"> -->
                            <li>
                                <a href="{{ route('staff_employee.index') }}?district_id[]={{ $district->district_id }}&&province={{ $province_id }}"
                                    @if($count == 0)
                                        style="color: red"
                                    @endif>
                                        {{ $district->district_name }}(
                                        <span @if($countEmployeeApprovedD == 0)
                                                style="color: red"
                                            @else
                                                class="text-success"
                                            @endif>{{$countEmployeeApprovedD}}</span>/
                                        <span @if($countEmployeeNotApprovedD == 0)
                                                style="color: red"
                                            @else
                                                class="text-danger"
                                            @endif>{{$countEmployeeNotApprovedD}}</span> )
                                </a>
                            </li>
                        <!-- </form> -->
                        @endforeach
                    </ul>
                </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
@endsection
