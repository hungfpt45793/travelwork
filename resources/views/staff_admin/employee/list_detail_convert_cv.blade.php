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
                        @if(!empty($files_uploadted))
                        <?php
                        foreach ($files_uploadted as $file_uploadted) { // iterate files
                            echo $file_uploadted.'</br>';
                        }
                        ?>
                        @endif
						<iframe style="width:100%;height:400px !important" src="https://docs.google.com/gview?url={{ asset($employee->employee_link_cv) }}&embedded=true"
                                                frameborder="0"></iframe>
												
												{{ asset($employee->employee_link_cv) }}
                        <a target="_blank" href="{{ route('detail_employee_show',['employee_slug' => $employee['employee_slug']]) }}">Link xem ngoài web</a>

                        <form method="post" action="{{ route('staff_convert_cv') }}">
                            <input type="hidden" name="user_id" value="{{ $employee->user_id }}">
                            <input type="hidden" name="employee_id" value="{{ $employee->employee_id }}">
                            <input type="hidden" name="employee_link_cv" value="{{ $employee->employee_link_cv }}">
                            <button class="btn-primary">Upload và convert CV</button>
                        </form>

                    </div>
                </section>
                <!-- The Modal -->
            </div>
        </div>
    </div>
@endsection
