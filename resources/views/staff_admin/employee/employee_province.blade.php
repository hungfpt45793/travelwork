@extends('staff_admin.layouts.master')

@section('title', 'Thống kê giáo viên 63 tỉnh thành' )

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
                    <h5 class="text-info">Danh sách các tỉnh</h5>
                    <ul class="ul-province">

                        @foreach ($provinces as $province)
                        <?php
                            $count = App\Http\Controllers\Staff\EmployeeController::countEmployeeP($province->province_id);
                            $countEmployeeApprovedP = App\Http\Controllers\Staff\EmployeeController::countEmployeeApprovedP($province->province_id);
                            $countEmployeeNotApprovedP = App\Http\Controllers\Staff\EmployeeController::countEmployeeNotApprovedP($province->province_id);
                        ?>

                        <li>
                            <a href="{{ route('staff_employee_district',['province_id'=>$province->province_id]) }}"
                                @if($count == 0)
                                    style="color: red"
                                @endif>
                                    <span>{{ $province->province_name }}(
                                    <span @if($countEmployeeApprovedP == 0)
                                            style="color: red"
                                        @else
                                            class="text-success"
                                        @endif> {{$countEmployeeApprovedP}}</span>/
                                    <span @if($countEmployeeNotApprovedP == 0)
                                            style="color: red"
                                        @else
                                            class="text-danger"
                                        @endif>{{$countEmployeeNotApprovedP}}</span> )</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
@endsection
