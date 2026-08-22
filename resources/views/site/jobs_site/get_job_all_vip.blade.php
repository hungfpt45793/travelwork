@extends('site.layout_site.site')

@section('title', 'HR tuyển dụng hộ công ty')
@section('meta_description', 'HR tuyển dụng hộ công ty')
@section('keywords', 'HR tuyển dụng hộ công ty')


@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/form.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/employer_job.css"/>
@endsection

@section('content')
    <section class="content bgrGray pdt5 UpdateUserTab">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar_site.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs">

                            <div class="link_breakcrum mbdsNone">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                                    </li>
                                    <li class="nav-item ">
                                        <span><i class="fas fa-chevron-right"></i></span>
                                    </li>
                                    <li class="nav-item pd8">
                                        <a href="{{ route('get_job_all_vip') }}">Danh sách tin tuyển dụng</a>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        <div class="list_job_employer">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12 borderTop">

                                    <div class="CV bgrWhite radius5 pd20 mgb20 pdb5">
                                        <hr class="mgt10 mgb10">
                                        <div class="title">
                                            <h1 class="">
                                                Thông tin tuyển dụng
                                            </h1>

                                        </div>
                                        <div>
                                            @if(session('suscess'))
                                                <div class="alert alert-success alert-dismissible fade show"
                                                     role="alert"
                                                     style="margin-top: 15px;width: 100%">
                                                    <strong>{{ session('suscess') }}</strong>
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            @if(session('erorr'))
                                                <div class="alert alert-warning alert-dismissible fade show"
                                                     role="alert"
                                                     style="margin-top: 15px;width: 100%">
                                                    <strong>{{ session('erorr') }}</strong>
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        <hr class="mgt10 mgb10">
                                        <a href="{{ route('create_job_all_vip') }}"
                                           class="btnOrange mg10-0 d-sm-inline-block mgb10 bdr3"
                                           style="padding: 5px 15px;">HR đăng tuyển tin tuyển dụng</a>

                                        <div class="box_guide">
                                            <p class="mg0 fw6 red">Lưu ý : Để đảm bảo đăng tin tuyển dụng hợp lệ </p>
                                            <p class="mg0 clback">1.Tin tuyển dụng của bạn phải chờ admin duyệt mới xuất hiện trên website</p>
                                            <p class="mg0 clback">2.Thông tin tài khoản phải được xác thực</p>
                                        </div>
                                        <div class="table-responsive">
                                        <table id="jobfb" class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Mã tin</th>
                                                <th>Ngày đăng - Hạn nộp</th>
                                                <th>Tiêu đề - Tên công ty</th>
                                                <th>Lượt xem</th>
                                                <th>Đề thi</th>
                                                <th>Hồ sơ</th>
                                                <th>Thao Tác</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($jobs as $job)
                                                <tr>
                                                    <td>{{ $job['job_code'] }}
                                                        </br>
                                                        @if($job['active_job'] == 1)
                                                            <p class="mg0  clGreen"><i class="fas fa-check"></i> Đã đăng
                                                                tin </p>
                                                        @else
                                                            <p class="mg0 clRed "><i class="fas fa-exclamation mgr5"></i>Chưa
                                                                đăng tin </p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $date_create = date_create($job['date_submit']);
                                                        echo date_format($date_create, "d/m/Y");
                                                        ?> -
                                                        <?php
                                                        $date_submit = date_create($job['deadline_submit_profile']);
                                                        echo date_format($date_submit, "d/m/Y");
                                                        ?>

                                                        <?php
                                                        $date_end = date_format($date_submit, "d-m-Y");
                                                        $today = date('d-m-Y');
                                                        ?>
                                                        <br>
                                                        @if(strtotime($today) > strtotime($date_end))
                                                            <p class="clRed f12">
                                                                (Tin hết hạn)
                                                            </p>
                                                        @else

                                                        @endif

                                                    </td>

                                                    <td>
                                                        <?php
                                                        $job_company = \App\Entity\Job_company::get_post_id($job['job_id']);
                                                        ?>
                                                        <a target="_blank"  href="{{ route('job_detail',['slug' => $job['slug'] ]) }}">{{ $job['title'] }}</a>
                                                        <p style="margin-bottom: 0"><i class="clGreen">({{ !empty($job_company->job_company_title) ? $job_company->job_company_title : '' }})</i></p>
                                                    </td>

                                                    <td>{{ $job['views'] }} <i class="fas fa-eye"></i></td>
                                                    <td>
                                                        @if(!empty($job['id_exam']))
                                                            <?php
                                                            $exam = \App\Exam\Exam::getCodeExam($job['id_exam']);
                                                            ?>
                                                            <span class="btnGreen">{{ $exam['code_exam'] }}</span>
                                                            <a href="{{ route('getExam',['slug_exam' => $exam['slug_exam']]) }}">Link
                                                                đề thi</a>
                                                        @else
                                                            <p>Không chọn đề thi</p>
                                                        @endif


                                                    </td>
                                                    <td>
                                                        <?php $total_submit_file = \App\Entity\Employee_submit_job_faacebook::getTotalsubmitJon($job['job_id'], 1)?>
                                                        <?php  $total_submit_file_teacher = \App\Entity\Teacher_submit_job_faacebook::getTotalsubmitJon($job['job_id'], 1)
                                                        ?>
                                                        <a href="{{ route('job_Candidate_Employee',['job_id'=>$job->job_id]) }}"><span
                                                                    class="">
                                                                Xem hồ sơ <sup class="red"> {{ $total_subit =  $total_submit_file + $total_submit_file_teacher }} (hồ sơ)</sup>

                                                            </span>
                                                        </a>
                                                    </td>

                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-info dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false"
                                                                    style="    padding: 2px 10px;">Thao tác
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                   href="{{ route('update_update_at',['job_id'=>$job['job_id']]) }}"
                                                                   title="Đẩy tin">Đẩy tin <i
                                                                            class="fas fa-external-link-square-alt"></i></a>
                                                                <a class="dropdown-item"
                                                                   href="{{ route('edit_job_all_vip',['job_id'=>$job['job_id']]) }}"
                                                                   title="Sửa tin">Sửa tin <i
                                                                            class="far fa-edit clorange"></i></a>
                                                                <a class="dropdown-item"
                                                                   href="{{ route('update_stop_job',['job_id'=>$job['job_id']]) }}"
                                                                   title="Tạm dừng" class="clred"
                                                                   style="color: red !important;">Tạm dừng tin <i
                                                                            class="fas fa-stop-circle"></i></a>

                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                            </tbody>
                                            @endforeach
                                        </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    @include('site.default.item_pani',['page_link' => $jobs])
                                    {{--{{ $jobs->links() }}--}}
                                </div>
                            </div>
                        </div>

                    </section>
                </div>
            </div>

        </div>
    </section>

@endsection




@section('show_js')


@endsection