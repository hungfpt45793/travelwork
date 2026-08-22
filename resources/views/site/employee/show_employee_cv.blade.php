@extends('site.layout.site')
@section('title', 'Xem thông tin CV')
@section('meta_description', 'Xem thông tin CV')
@section('keywords', 'Xem thông tin CV')
<style>
    @page {
        margin: 0;
    }
</style>
@section('content')

    <section class="create_cv_employee_container">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb_scroll_500">

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
                                    <a href="{{route('show_profile_Employee',['submit_job_fb_id'=> $submit_job_fb_id]) }}"
                                       class=" f18 md-f14 mgb0">Xem hồ sơ ứng viên</a>
                                </li>

                                <li class="nav-item pd8">
                                    <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                                </li>
                                <li class="nav-item pd8">
                                    <?php
                                    $link_url = '#';
                                    $link_url = \App\Ultility\Ultility::getUrl();
                                    ?>
                                    <a href="{{ $link_url }}" class=" f18 md-f14 mgb0">Xem CV</a>
                                </li>

                            </ul>
                        </div>
                    </div>


                    @include('site.employee.item_cv_employee',['employee_id'=> $employee->employee_id]);

                </div>
            </div>
        </div>
    </section>
    <div class="clr"></div>
    <!-- Crop img -->
@endsection
