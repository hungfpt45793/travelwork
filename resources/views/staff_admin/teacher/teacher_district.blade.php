@extends('staff_admin.layouts.master')

@section('title', 'Thống kê giáo viên huyện' )

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

                        {{-- <div class="row"> --}}
                            {{-- <div class="col-lg-12 col-md-12 col-sm-12 col-12"> --}}
                                <h5>Tỉnh {{ $province_name }}</h5>
                            {{-- </div> --}}
                            <ul class="ul-province">
                                @foreach ($districts as $district)
                                    <?php
                                    $count = App\Http\Controllers\Staff\TeacherController::countTeacherD($district->district_id);
                                    $check = 0;
                                    $list = App\Entity\Teacher::where('district',$district->district_id)->get();
                                    foreach($list as $ls){
                                        if($ls->status_accounting == 1){
                                            $check = 1;
                                            break;
                                        }
                                    }
                                    ?>
                                    <li>
                                        <a  href="{{ route('staff_teacher.index') }}?district={{ $district->district_id }}&&province={{ $province_id }}" @if($count == 0 || $check == 0) style="color: red" @endif>
                                            {{ $district->district_name }}({{ $count }})
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>


            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
@endsection
