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
                                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang
                                            chủ</a>
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
                                        <a href="{{ route('job-user.create') }}"
                                           class="btnOrange mg10-0 d-sm-inline-block mgb10 bdr3"
                                           style="padding: 5px 15px;">Thêm mới tin tuyển dụng</a>

                                        <div class="arror bgrWhite radius5 pd5 bdLightGray  mgb15 pd10">
                                            <p class="mg0 fw6 red">Lưu ý : Để đảm bảo đăng tin tuyển dụng hợp lệ </p>
                                            <p class="mg0 clback">1.Tin tuyển dụng của bạn phải chờ admin duyệt mới xuất hiện trên website</p>
                                            <p class="mg0 clback">2.Thông tin tài khoản phải được xác thực</p>
                                        </div>

                                        <table id="jobfb" class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Mã tin</th>
                                                <th>Ngày đăng - Hạn nộp</th>
                                                <th>Tiêu đề</th>
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
                                                            <p class="mg0  clgreen"><i class="fas fa-check"></i> Đã đăng
                                                                tin </p>
                                                        @else
                                                            <p class="mg0 red "><i class="fas fa-exclamation mgr5"></i>Chưa
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
                                                            <p class="clred f12">
                                                                (Tin hết hạn)
                                                            </p>
                                                        @else

                                                        @endif

                                                    </td>

                                                    <td><a target="_blank"
                                                           href="{{ route('job_detail',['slug' => $job['slug'] ]) }}">{{ $job['title'] }}</a>
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
                                                                   href="{{ route('job-user.edit',['job_id'=>$job['job_id']]) }}"
                                                                   title="Sửa tin">Sửa tin <i
                                                                            class="far fa-edit clorange"></i></a>
                                                                <a class="dropdown-item"
                                                                   href="{{ route('update_stop_job',['job_id'=>$job['job_id']]) }}"
                                                                   title="Tạm dừng" class="clred"
                                                                   style="color: red !important;">Tạm dừng tin <i
                                                                            class="fas fa-stop-circle"></i></a>

                                                            </div>
                                                        </div>


                                                        {{--<div class="EditDelete">--}}
                                                        {{--<button><a href="{{ route('update_update_at',['job_id'=>$job['job_id']]) }}" title="Đẩy tin">Đẩy tin </a></button>--}}
                                                        {{--</br>--}}
                                                        {{--<button><a href="{{ route('job-user.edit',['job_id'=>$job['job_id']]) }}" title="Sửa tin"></a></button>--}}
                                                        {{--<button><a href="{{ route('update_stop_job',['job_id'=>$job['job_id']]) }}" title="Tạm dừng" class="clred" style="color: red !important;"></a></button>--}}

                                                        {{--<button><a href="{{ route('job-user.destroy',['job_id'=>$job['job_id']]) }}" title="Xóa" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);"><i class="fas fa-trash-alt clorange"></i></a></button>--}}
                                                        {{--</div>--}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                            @endforeach
                                        </table>
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
            @include('site.module_index.hotline')
        </div>
    </section>



    <!-- Modal -->

    <script>
        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });
    </script>
    @if(!empty($_GET['job_id']))
        <div class="modal fade" id="modal_noti_save_job" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! isset($information['noi-dung-chia-se-tin-tuyen-dung']) ?  $information['noi-dung-chia-se-tin-tuyen-dung'] : 'Đang cập nhật'  !!}
                        <?php
                            $job_fr = App\Entity\Job::get_post_slug($_GET['job_id']);
                        ?>

                        <div id="fb-root"></div>
                        <script async defer crossorigin="anonymous"
                                src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0"></script>
                        <div class="fb-share-button"
                             data-href="{{ route('job_detail',['slug'=>$job_fr->slug]) }}"
                             data-layout="button" data-size="large"><a target="_blank"
                                                                       href="https://www.facebook.com/sharer/sharer.php?u={{ route('job_detail',['slug'=>$job_fr->slug]) }}&amp;src=sdkpreparse"
                                                                       class="fb-xfbml-parse-ignore js_add_employee_money share_facebook"><i class="fas fa-dollar-sign"></i> Chia sẻ  tin lên
                                facebook</a>
                        </div>




                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#modal_noti_save_job').modal('show');
        </script>

    @endif
    @include('site.partials.delete')


@endsection