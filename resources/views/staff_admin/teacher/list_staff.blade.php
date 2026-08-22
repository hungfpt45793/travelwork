@extends('staff_admin.layouts.master')

@section('title', 'Danh sách giáo viên' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.teacher')
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

                    <div>
                        <table class="m-3 table">
                            <thead>
                                <tr>
                                    <th>Nhân viên</th>
                                    <th>Số giáo viên tương tác</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($list_staff as $staff)
                            <tr>
                                <td>
                                    <a href="{{route('list_interactive_staff',$staff->id)}}" >{{$staff->name}}</a>
                                </td>
                                <td>
                                    @php
                                        $mount = \App\Entity\InteractiveTeacher::where('user_id', $staff->id)->groupBy('teacher_id')->get();
                                    @endphp
                                    {{count($mount)}}
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
        </div>
        </section>
        <!-- The Modal -->
    </div>
</div>
</div>

@endsection
