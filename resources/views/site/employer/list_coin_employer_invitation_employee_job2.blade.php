@extends('site.layout.site')

@section('title', ' Danh sách ứng viên  đã mời ứng tuyển')
@section('meta_description', ' Danh sách ứng viên  đã mời ứng tuyển')
@section('keywords', ' Danh sách ứng viên  đã mời ứng tuyển')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent createProfileOnline ">

                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs f18 white  pd10-20 col-f14">
                            <div class="link bgrWhite md-mgt20 disOnMobile">
                                <ul class="nav">
                                    <li class="nav-item pd8">
                                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang
                                            chủ</a>
                                    </li>
                                    <li class="nav-item pd8">
                                        <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                                    </li>
                                    <li class="nav-item pd8">
                                        <a href="#" class=" f18 md-f14 mgb0"> Danh sách ứng viên  đã mời ứng tuyển</a>
                                    </li>

                                </ul>
                            </div>
                        </div>

                        <div class="InfoCompanyJob">
                            <div class="main">
                                <div class="notificationBox bkwhite formJobLarge sm-f14">
                                    <div class="bodyBox ">
                                       <p>Chức năng này đang xây dựng !<p>
                                    </div>
                                </div>
                            </div>
                        </div>





                    </section>
                   
                       

                    @include('site.module_index.dang-ky-tu-van')

                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>
    <script>
        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });
    </script>
    @include('site.partials.delete')


@endsection