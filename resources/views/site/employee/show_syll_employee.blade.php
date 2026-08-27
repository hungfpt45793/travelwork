@extends('site.layout.site')

@section('title', 'Sơ yếu lý lịch')
@section('meta_description', 'Sơ yếu lý lịch')
@section('keywords', 'Sơ yếu lý lịch')

@section('content')


    <link rel="stylesheet" type="text/css" href="/assets/css/so-yeu-ly-lich.css" />
    <style>
        .none_in_hoso{
            display:none;
        }
        input,textarea{
            color:rgb(26, 77, 172);
        }
        input:focus,textarea:focus{
            color:rgb(26, 77, 172);
        }
    </style>
    <?php
    //      echo '<pre>';
    //      print_r($employee_curriculum);die();
    //
    //?>
    <section class="content bgrGray pdt5 curriculum">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12">
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
                                    <a href="{{route('show_profile_Employee',['submit_job_fb_id'=> $submit_job_fb_id]) }}" class=" f18 md-f14 mgb0">Xem hồ sơ ứng viên</a>
                                </li>

                                <li class="nav-item pd8">
                                    <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                                </li>
                                <li class="nav-item pd8">
                                    <?php
                                    $link_url = '#';
                                    $link_url = \App\Ultility\Ultility::getUrl();
                                    ?>
                                    <a href="{{ $link_url }}" class=" f18 md-f14 mgb0">Xem sơ yếu lý lịch</a>
                                </li>

                            </ul>
                        </div>
                    </div>

@include('site.employee.item_syll_employee',['employee_id' => $employee->employee_id]);

                </div>
            </div>

        </div>
    </section>


@endsection