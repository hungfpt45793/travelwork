@extends('site.layout.site')

@section('title', 'Danh sách ứng xem đã mời')
@section('meta_description', 'Danh sách ứng xem đã mời')
@section('keywords', 'Danh sách ứng xem đã mời')

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
                                        <a href="#" class=" f18 md-f14 mgb0">Danh sách ứng xem đã mời </a>
                                    </li>

                                </ul>
                            </div>
                        </div>

                        <table id="jobfb" class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>Mã tin</th>
                                <th>Ngày đăng - Hạn nộp</th>
                                <th>Tiêu đề</th>
                                <th>Lượt xem</th>
                                <th>Danh sách ứng viên đã mời</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($jobs as $job)
                                <tr>
                                    <td>{{ $job['job_code'] }}
                                        </br>
                                        @if($job['active_job'] == 1)
                                            <p class="mg0  clgreen"><i class="fas fa-check"></i> Đã đăng tin </p>
                                        @else
                                            <p class="mg0 red "><i class="fas fa-exclamation mgr5"></i>Chưa đăng tin </p>
                                        @endif
                                    </td>
                                    <td>
                                        <?php
                                        $date_create=date_create($job['date_submit']);
                                        echo date_format($date_create,"d/m/Y");
                                        ?> -
                                        <?php
                                        $date_submit=date_create($job['deadline_submit_profile']);
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

                                    <td>{{ $job['views'] }} <i class="fas fa-eye"></i></td>
                                    <td>
                                        <a href="{{ route('list_invitation_employee_job',['job_id'=>$job->job_id ]) }}"  class="btn btn-info  clwhite"  style="padding: 2px 10px;" target="_blank">Xem danh sách
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>

                    </section>

                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs  fw7 f18 white bgrBlueN pd10-20 col-f14">
                            Danh sách ứng viên  đã mời ứng tuyển
                            {{--( {{ theo bảng thong ke ứng viên đã làm bài thi trắc nghiệm }} việc làm)--}}
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                @foreach($list_employer_show_employee as $emp_new)
                                    @include('site.employee.item_employee',['employee'=>$emp_new])
                                @endforeach

                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    @include('site.default.item_pani',['page_link' => $list_employer_show_employee])

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