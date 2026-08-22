@extends('staff_admin.layouts.master')

@section('title', 'Thống kê giáo viên 63 tỉnh thành' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.teacher')
        </div>

        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting pd15 col-f14 ">
                    <h5 class="text-info">Danh sách các tỉnh</h5>
                    <ul class="ul-province">

                        @foreach ($provinces as $province)
                        <?php
                            $count = App\Http\Controllers\Staff\TeacherController::countTeacherP($province->province_id);
                            $check = 0;
                            $list = App\Entity\Teacher::where('province',$province->province_id)->get();
                            foreach($list as $ls){
                                if($ls->status_accounting == 1){
                                    $check = 1;
                                    break;
                                }
                            }
                        ?>

                        <li ><a href="{{ route('staff_teacher_district',['province_id'=>$province->province_id]) }}" @if($count == 0 || $check == 0) style="color: red" @endif>{{ $province->province_name }}({{ $count }})</a></li>
                        @endforeach
                    </ul>
                </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
@endsection
