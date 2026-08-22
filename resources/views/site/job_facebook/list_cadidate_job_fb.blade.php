@extends('site.layout.site')

@section('title', 'Việc làm trên Facebook')
@section('meta_description', 'Việc làm trên Facebook')
@section('keywords', 'Việc làm trên Facebook')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20 mgb10">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>



                        </ul>
                    </div>
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>

                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">

                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">

                                    <div class="CV bgrWhite radius5 pd20 mgt20 mgb30 pdb5">
                                        <div class="title mgb20">
                                            <h5 class="lt-f18 textUpper fw7 bdLeftBlueN5x pdl10 blueN mgb0">
                                                Danh sách ứng viên ứng tuyển
                                            </h5>


                                        </div>
                                        <div>
                                            @if(session('success'))
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    {{ session('success') }}
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            @if(session('erorr'))
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    {{ session('erorr') }}
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>


                                        <table id="jobfb" class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Mã tin</th>
                                                <th>Ngày đăng tin</th>
                                                <th>Hạn Nộp</th>
                                                <th>Tiêu đề</th>
                                                <th>Email nhân hồ sơ </th>
                                                <th>Tỉnh / TP</th>
                                                <th>Quận / Huyện</th>
                                                <th>Hồ sơ ứng tuyển</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($jobFacebooks as $job)
                                                <tr>
                                                    <td>{{ $job['job_facebook_code'] }}</td>
                                                    <td>
                                                        <?php
                                                        $date_create=date_create($job['created_at']);
                                                        echo date_format($date_create,"d/m/Y");
                                                        ?>

                                                    </td>
                                                    <td><?php
                                                        $date=date_create($job['date_end']);
                                                        echo date_format($date,"d/m/Y");
                                                        ?></td>
                                                    <td>{{ $job['title'] }}</td>
                                                    <td>{{ $job['email'] }}</td>
                                                    <td>{{ $job['province_name'] }}</td>
                                                    <td>{{ $job['district_name'] }}</td>

                                                    <td><span class="red">
                                                        <?php $total_submit_file = \App\Entity\Employee_submit_job_faacebook::getTotalsubmitJon($job['job_facebook_id'],0)?>

                                                            <?php  $total_submit_file_teacher = \App\Entity\Teacher_submit_job_faacebook::getTotalsubmitJon($job['job_facebook_id'],0)
                                                            ?>
                                                        {{ $total_subit =  $total_submit_file + $total_submit_file_teacher }} (hồ sơ)
                                                            </span>
                                                    </td>
                                                    <td>
                                                        <div class="EditDelete">
                                                            <a href="{{ route('detail_Candidate_Employee',['job_facebook_id'=>$job['job_facebook_id']]) }}" title="Danh sách hồ sơ" class="btnOrange " style="    padding: 4px 7px">Danh sách hồ sơ</a>
                                                        </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    {{ $jobFacebooks->links() }}
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