@extends('site.layout.site')

@section('title', 'Việc làm của nhà tuyển dụng')
@section('meta_description', 'Việc làm của nhà tuyển dụng')
@section('keywords', 'Việc làm của nhà tuyển dụng')

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
                                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                                    </li>
                                    <li class="nav-item pd8">
                                        <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                                    </li>
                                    <li class="nav-item pd8">
                                        <a href="#" class=" f18 md-f14 mgb0">Thông tin tuyển dụng</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12 borderTop">

                                    <div class="CV bgrWhite radius5 pd20 mgb20 pdb5">
                                        <div class="title" style="margin-bottom: 10px;">
                                            <h5 class="fw6 f20 bdLeftBlueN5x pdl10 blueN mgb0">
                                                Thông tin tuyển dụng
                                            </h5>

                                        </div>
                                        <div>
                                            @if(session('suscess'))
                                                <div class="alert alert-success alert-dismissible fade show" role="alert"
                                                     style="margin-top: 15px;width: 100%">
                                                    <strong>{{ session('suscess') }}</strong>
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            @if(session('erorr'))
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert"
                                                     style="margin-top: 15px;width: 100%">
                                                    <strong>{{ session('erorr') }}</strong>
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        <hr class="mgt10 mgb10">

                                        <div class="arror bgrWhite radius5 pd5 bdLightGray  mgb15 pd10">
                                            <p class="mg0 fw6 red">Lưu ý : Đây là thông tin chúng tôi đăng hộ nhà tuyển dụng </p>
                                        </div>

                                        <table id="jobfb" class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Mã tin</th>
                                                <th>Ngày đăng - Hạn nộp</th>
                                                <th>Tiêu đề</th>
                                                <th>Lượt xem</th>
                                                <th>Hồ sơ</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list_job_facebook as $job)
                                                <tr>
                                                    <td>{{ $job['job_facebook_code'] }}
                                                        </br>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $date_create=date_create($job['updated_at']);
                                                        echo date_format($date_create,"d/m/Y");
                                                        ?> -
                                                        <?php
                                                        $date_submit=date_create($job['date_end']);
                                                        echo date_format($date_submit,"d/m/Y");
                                                        ?>

                                                        <?php
                                                        $date_end = date_format($date_submit, "d-m-Y");
                                                        $today = date('d-m-Y');
                                                        ?>
                                                        <br>
                                                        @if(strtotime($today) > strtotime($date_end))
                                                            <p class="clred f12">
                                                                (Tin hết hạn)
                                                            </p>
                                                        @else

                                                        @endif

                                                    </td>

                                                    <td>{{ $job['title'] }}</td>

                                                    <td>{{ $job['view'] }} <i class="fas fa-eye"></i></td>

                                                    <td>
                                                        <?php $total_submit_file = \App\Entity\Employee_submit_job_faacebook::getTotalsubmitJon($job['job_facebook_id'],0)?>
                                                        <?php  $total_submit_file_teacher = \App\Entity\Teacher_submit_job_faacebook::getTotalsubmitJon($job['job_facebook_id'],0)
                                                        ?>
                                                        <a href="{{ route('submit_job_facebook',['job_facebook_id'=>$job->job_facebook_id]) }}"><span class="">
                                                                Xem hồ sơ <sup class="red"> {{ $total_subit =  $total_submit_file + $total_submit_file_teacher }} (hồ sơ)</sup>

                                                            </span>
                                                        </a>
                                                    </td>


                                                </tr>
                                            </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>

                                <div class="col-12 text-center">
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