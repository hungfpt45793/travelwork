@extends('site.layout.site')

@section('title', 'hồ  sơ ứng viên')
@section('meta_description', 'hồ  sơ ứng viên')
@section('keywords', 'hồ  sơ ứng viên')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                {{--@include('site.sidebar.sidebar_job_face')--}}
                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                    <div class="titleJobs f18 white col-f14">
                        <div class="link bgrWhite md-mgt20 disOnMobile">
                            <ul class="nav">
                                <li class="nav-item pd8">
                                    <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                                </li>
                                <li class="nav-item pd8">
                                    <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                                </li>
                                <li class="nav-item pd8">
                                    <a href="{{ route('show_profile_Employee_intership',['intership'=> $intership]) }}" class=" f18 md-f14 mgb0">Hồ sơ ứng viên</a>
                                </li>
                                <li class="nav-item pd8">
                                    <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                                </li>
                                <li class="nav-item pd8">
                                    <?php
                                    $link_url ='#';
                                    $link_url = \App\Ultility\Ultility::getUrl();
                                    ?>
                                    <a href="{{ $link_url }}" class=" f18 md-f14 mgb0">Xem cv ứng viên</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="borderTop"></div>
                        </div>
                        <div class="col-md-12">

                            @if(session('success'))
                                <div class="bg-white pdt15 ">
                                    <div class="alert alert-success alert-dismissible fade show"
                                         role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                            @if(session('erorr'))
                                <div class="bg-white pdt15 ">
                                    <div class="alert alert-warning alert-dismissible fade show"
                                         role="alert">
                                        {{ session('erorr') }}
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>

                 {{--//include show_cv--}}
                    @include('site.employee.item_cv_employee',['employee_id' => $employee->employee_id])


                </div>
            </div>
        </div>
    </section>
    <script>
        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });
    </script>



@endsection