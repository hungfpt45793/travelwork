@extends('site.layout.site')

@section('title', 'Danh sách tin ứng viên ứng tuyển')
@section('meta_description', 'Danh sách tin ứng viên ứng tuyển')
@section('keywords', 'Danh sách tin ứng viên ứng tuyển')

@section('content')
    {{--thêm icon vao select--}}
    {{--<style>--}}
    {{--select {--}}
    {{--font-family: 'FontAwesome', 'Second Font name'--}}
    {{--}--}}
    {{--</style>--}}
    {{--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet"/>--}}

    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                <?php $user = ''; ?>
                <div class="col-xl-3 col-lg-4 col-md-12 dsmbNone">
                    <div class="side-bar-left formJobLarge  sidebarJobFacebook">
                        <div class="createNew text-center bgrBlueN" style="    padding: 4px 0;">
                            <a href="" data-toggle="modal"
                               data-target="@if (!\Illuminate\Support\Facades\Auth::check()) #loginTiva @endif"
                               class="createNewButton white">
                                <i class="fas disInBlock fa-paper-plane "></i>
                                <p class="disInBlock font20 fontBold ">Thông tin</p>
                            </a>
                        </div>
                        <div class="tab-content mgb20" id="nav-tabContent">
                            <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="account ">
                                    <br>
                                    <div class="employee">
                                        @if (\Illuminate\Support\Facades\Auth::check())
                                            <?php $user = \Illuminate\Support\Facades\Auth::user(); ?>
                                            <div class="row ">
                                                <div class="col-md-4 ">
                                                    <div class="accountThumbnail ">
                                                        <?php
                                                        $id_user = $user->id;
                                                        $role = $user->role;
                                                        ?>
                                                        @if($role == 1)
                                                            <?php $employee = \App\Entity\Employee::getEmployee_id($id_user); ?>
                                                            <img class="lazy" src="{{ !empty($employee->employee_image) ? $employee->employee_image : '/CV/Profile.jpg'}}"
                                                                 alt=""
                                                                 width="100% ">
                                                        @elseif($role == 2)
                                                            <?php $employer = \App\Entity\Employer::getIdUser($id_user);

                                                            ?>
                                                            <img class="lazy" src="{{!empty($employer->image) ? $employer->image : '/CV/Profile.jpg'}}"
                                                                 alt=""
                                                                 width="100% ">
                                                        @elseif($role == 3)
                                                            <?php $teacher = \App\Entity\Teacher::getTeacher_id($id_user);
                                                            ?>
                                                            <img class="lazy" src="{{!empty($teacher->teacher_images) ? $teacher->teacher_images : '/CV/Profile.jpg'}}"
                                                                 alt=""
                                                                 width="100% ">
                                                        @elseif($role == 4)
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="col-md-8 " style="">
                                                    <div class="accountInfo ">

                                                        @if($role == 1)
                                                            <h5 style="padding: 0 5px">{{ isset($employee->employee_name) ? $employee->employee_name : ''}}</h5>
                                                        @elseif($role == 2)
                                                            <h5 style="padding: 0 5px">{{ isset($employer->enterprise_name) ? $employer->enterprise_name : ''}}</h5>
                                                        @elseif($role == 3)
                                                            <h5 style="padding: 0 5px">{{ isset($teacher->teacher_name) ? $teacher->teacher_name : ''}}</h5>
                                                        @elseif($role == 4)
                                                        @endif


                                                        <p>
                                                            @if($role == 1)
                                                                <span class="red"><i>(Ứng viên)</i></span>
                                                            @elseif($role == 2)
                                                                <span class="red"><i>(Nhà tuyển dụng)</i></span>
                                                            @elseif($role == 3)
                                                                <span class="red"><i>(Giáo viên)</i></span>
                                                            @elseif($role == 4)
                                                                <span><i>(Quản trị viên)</i></span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <form action="{{ route('login_home') }}" method="post">
                                                {!! csrf_field() !!}
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email đăng ký <span
                                                                    class="red">(*)</span></label>
                                                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                                               aria-describedby="emailHelp" placeholder="Nhập vào email của bạn">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Mật khẩu <span class="red">(*)</span></label>
                                                        <input type="password" name="password" class="form-control"
                                                               id="exampleInputPassword1"
                                                               placeholder="Nhập mật khẩu của bạn">
                                                    </div>
                                                    @if($errors->any() && $errors->has('loginFail') )
                                                        <div class="alert alert-danger" role="alert">
                                                            <strong>Mật khẩu hoặc Email đăng nhập không đúng.</strong>
                                                        </div>
                                                    @endif
                                                    @if (\Request::is('/'))
                                                        <input type="hidden" name="home" class="form-control" id="exampleInputPassword1"
                                                               placeholder="" value="home">
                                                    @endif
                                                    @if(session('error_login'))
                                                        <div class="form-group mgb0" style="margin-bottom: 10px">
                                                            <p class="red mgb0"
                                                               style="margin-bottom: 10px">{{ session('error_login') }}</p>
                                                        </div>
                                                    @endif
                                                    @if($errors->any() && $errors->has('loginFail') )
                                                        <div class="alert alert-danger" role="alert">
                                                            <strong>Mật khẩu hoặc Email đăng nhập không đúng.</strong>
                                                        </div>
                                                    @endif
                                                    <div class="form-group mgb0">
                                                        <label class="mgb0" for="exampleInputPassword1"> <a
                                                                    href="{{ route('reset_passwrod') }}">Quên
                                                                mật
                                                                khẩu</a></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Bạn chưa có tài khoản?
                                                            <a href="{{route('register')}}"> Đăng ký tài khoản</a>
                                                        </label>
                                                    </div>
                                                    <button type="submit" class="btn bgrBlueN white">ĐĂNG NHẬP</button>
                                                </div>

                                            </form>
                                        @endif
                                    </div>
                                </div>
                                @if (\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->role) == 2)

                                    <?php
                                    $check_job_fb_employer = \App\Entity\Employer::check_is_admin(\Illuminate\Support\Facades\Auth::user()->id)
                                    ?>
                                    <hr>
                                    @if(!empty($check_job_fb_employer))
                                        <div class="createNew text-center">
                                            <a href="{{ route('job-face-user.create') }}" class="f18 md-f14 btnOrange bdr3"><i
                                                        class="fas disInBlock fa-paper-plane "></i> Đăng tin miễn phí</a>
                                        </div>
                                    @endif
                                @endif
                                <hr>




                                <div class="fillterJobSubmit text-left">
                                    <h5 class="lt-f18 fw6 f20 bdLeftBlueN5x pdl10 blueN mgb20">
                                        Lọc hồ sơ
                                    </h5>
                                    <!--                    --><?php
                                    //                        $checkbox = $_GET['id_status_submit'];
                                    //                        echo '<pre>';
                                    //                        print_r($checkbox);
                                    //                    echo '</pre>';
                                    //                    ?>
                                    <?php
                                    $id_status_submit_get = array();
                                    if(isset($_GET['id_status_submit']))
                                    {
                                        $id_status_submit_get = $_GET['id_status_submit'];
                                    }

                                    ?>

                                        <div class="">
                                            <label class="f16">Trạng thái hồ sơ</label>
                                        </div>
                                        <?php
                                        $list_status_submit = \App\Entity\Status_submit_job::getAll();
                                        ?>
                                        @if(!empty($list_status_submit ))
                                            <div class="dsBlock">

                                                <label class="f16">
                                                    <input type="checkbox" value="0" class="checkboxFilter mgr5" name="id_status_submit[]" @if($id_status_submit_get == '0')) checked @endif>
                                                    <span class="mgl5 dsInline">Trạng thái</span>
                                                    <?php
                                                    //                                    print_r($job_id);die();
                                                    $count_status = 0;
                                                    $count_status = \App\Entity\Employee_submit_job_faacebook::getTotalStatusJob($job_id,0);
                                                    //
                                                    ?>

                                                    @if(!empty($count_status))
                                                        <sup class="clHome">{{ $count_status }} hồ sơ</sup>
                                                    @endif
                                                </label>

                                            </div>
                                            @foreach($list_status_submit as $status_submit)
                                                <div class="dsBlock">

                                                    <label class="f16">
                                                        <input type="checkbox" value="{{ $status_submit->id_status }}" class="checkboxFilter mgr5" name="id_status_submit[]" @if(in_array($status_submit->id_status, $id_status_submit_get)) checked @endif>
                                                        <span class="mgl5 dsInline">{{ $status_submit->name_status }}</span>
                                                        <?php

                                                        $count_status = 0;
                                                        $count_status = \App\Entity\Employee_submit_job_faacebook::getTotalStatusJob($job_id,$status_submit->id_status);
                                                        ?>
                                                        @if(!empty($count_status))
                                                            <sup class="clHome">{{ $count_status }} hồ sơ</sup>
                                                        @endif
                                                    </label>

                                                </div>

                                            @endforeach
                                            <div class="dsBlock">
                                                <button type="submit" class="btnGreen" style="display: block;width: 100%;padding: 5px" id="btnloading_frofile">Lọc hồ sơ</button>
                                            </div>
                                        @endif


                                    <div>
                                        <a href="{{ route('list_job_face') }}" class="dsBlock mgt15 f18 clHome text-center"><i class="fas fa-long-arrow-alt-left"></i> Quay về  tủ hồ sơ  <i class="fas fa-long-arrow-alt-right"></i></a>
                                    </div>


                                    <script>
                                        $('#btnloading_frofile').click(function() {
                                            $('#check_login').modal('show');
                                        });
                                        $('.checkboxFilter').iCheck({
                                            checkboxClass: 'icheckbox_square-red',
                                            radioClass: 'iradio_square-red',
                                            increaseArea: '20%' // optional
                                        });

                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
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
                                        <a href="#" class=" f18 md-f14 mgb0">Hồ sơ tuyển dụng</a>
                                    </li>


                                </ul>
                            </div>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12 borderTop">

                                    <div class="CV bgrWhite radius5 pd20 mgb30 pdb5">
                                        <div class="title mgb20">
                                            <h5 class="lt-f18 fw6 f20 bdLeftBlueN5x pdl10 blueN mgb0">
                                                Danh sách hồ sơ ứng viên
                                            </h5>


                                        </div>
                                        <div>
                                            <div class="show_message_status">

                                            </div>
                                            @if(session('success'))
                                                <div class="alert alert-success alert-dismissible fade show"
                                                     role="alert">
                                                    {{ session('success') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            @if(session('erorr'))
                                                <div class="alert alert-warning alert-dismissible fade show"
                                                     role="alert">
                                                    {{ session('erorr') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>


                                            <table id="jobfb" class="table table-hover table-bordered"  >
                                                <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Mã tin</th>
                                                    <th>Tên ứng viên</th>
                                                    <th>Ngày nộp hồ sơ</th>
                                                    <th>Thi trắc nghiệm</th>
                                                    <th>Hồ sơ</th>
                                                    <th>Trạng thái</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($list_jobs as $id=>$jobs)
                                                    <tr>
                                                        <td style="width: 50px;vertical-align: inherit;">
                                                            {{ $id + 1 }}
                                                        </td>
                                                        <td style="width: 150px;vertical-align: inherit;">
                                                            {{ $jobs->job_code }}
                                                        </td>
                                                        <td style="vertical-align: inherit;">
                                                            {{ $jobs->employee_name }}
                                                            <p class="mgb0 clHome">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                                <?php
                                                                $district = \App\Entity\District::getId($jobs['district']);
                                                                ?>
                                                                {{ isset( $district['district_name']) ?  $district['district_name'] : '' }}
                                                            </p>
                                                            <p class="mgb0 clHome">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                                <?php
                                                                $provice = \App\Entity\Province::getId($jobs['province']);
                                                                ?>
                                                                {{ isset($provice->province_name) ? $provice->province_name : '' }}
                                                            </p>

                                                        </td>
                                                        <td style="width: 150px;vertical-align: inherit;">


                                                            <?php
                                                            $date=date_create($jobs->day_submit_job);
                                                            echo date_format($date,"d/m/Y");
                                                            ?>



                                                        </td>
                                                        <td style="vertical-align: inherit;">
                                                            @if(!empty($jobs->id_exam))
                                                                <?php
                                                                $result_job_exam = \App\Exam\Result_job_exam::getId_result_job_exam($jobs['job_id'],$jobs->employee_id);

                                                                $id_exam = $jobs->id_exam;
                                                                //                                                                        print_r($result_job_exam);
                                                                //                                                                        echo $result_job_exam->id_result_job_exam;die();
                                                                $result_id = $result_job_exam['id_result_job_exam'];
                                                                $exam = \App\Exam\Exam::getExam($id_exam);
                                                                $count_no_correct0 = 0;
                                                                //lay ra tong so cau hoi co type = 0
                                                                $count_ques0 = \App\Exam\Questions::countTypeQuestion($id_exam, 0);
                                                                // lay ra tong so cau tra loi the ma result

                                                                $count_coreect0 = \App\Exam\Detail_result_job_exam::countDetailType($result_id, 0);
                                                                //so cau chua tra loi = tong so cau - tong so dap an trong cau
                                                                $count_no_correct0 = $count_ques0 - $count_coreect0;
                                                                $correct_success0 = 0;
                                                                $detail_result0 = \App\Exam\Detail_result_job_exam::getAllResult($result_id, 0);
                                                                foreach ($detail_result0 as $id => $detail0) {
                                                                    $question0 = \App\Exam\Questions::getQuestion($detail0->id_ques, 0);
                                                                    if ($detail0->user_correct_ques == $question0->correct_answer) {
                                                                        $correct_success0++;
                                                                    }
                                                                }
                                                                $correct_erorr0 = $count_coreect0 - $correct_success0;
                                                                //            cau hoi dung sai 1
                                                                $count_no_correct1 = 0;
                                                                $count_ques1 = \App\Exam\Questions::countTypeQuestion($id_exam, 1);
                                                                $count_coreect1 = \App\Exam\Detail_result_job_exam::countDetailType($result_id, 1);
                                                                $count_no_correct1 = $count_ques1 - $count_coreect1;
                                                                $correct_success1 = 0;
                                                                $detail_result1 = \App\Exam\Detail_result_job_exam::getAllResult($result_id, 1);
                                                                foreach ($detail_result1 as $id => $detail1) {
                                                                    $question1 = \App\Exam\Questions::getQuestion($detail1->id_ques, 1);
                                                                    if ($detail1->user_correct_ques == $question1->correct_answer) {
                                                                        $correct_success1++;
                                                                    }
                                                                }
                                                                $correct_erorr1 = $count_coreect1 - $correct_success1;

                                                                //cau hoi tu luan
                                                                $count_no_correct2 = 0;
                                                                $count_correct_answen = 0;
                                                                //lay ve tong so cau hoi thuoc tu luan
                                                                $count_ques2 = \App\Exam\Questions::countTypeQuestion($id_exam, 2);
                                                                $count_coreect2 = \App\Exam\Detail_result_job_exam::countDetailType($result_id, 2);

                                                                //cau hoi da tra loi
                                                                $count_correct_answen = \App\Exam\Detail_result_job_exam::countDetailAnser($result_id, 2);
                                                                //cau hoi chua tra loi
                                                                $count_no_correct2 = $count_ques2 - $count_correct_answen;
                                                                ?>

                                                                <p class="mgb5">Câu hỏi trắc nghiệm : {{ $correct_success0 }} / {{ $count_ques0 }}</p>
                                                                <p class="mgb5">Câu hỏi đúng / sai : {{ $correct_success1 }} / {{ $count_ques1 }}</p>
                                                                <p class="mgb5">Câu hỏi tự luận : {{ $count_correct_answen }} / {{ $count_ques2 }}</p>

                                                                <a href="{{ route('detail_exam_employee',['employee_id'=>$jobs['employee_id'],'job_facebook_id'=>$jobs['job_id']]) }}"
                                                                   title="Danh sách hồ sơ" class="btnGreen clwhite"
                                                                   style="    padding: 4px 7px">Kết quả thi</a>
                                                            @else
                                                                <p>Không chọn đề thi</p>
                                                            @endif



                                                        </td>
                                                        <td style="width: 150px;vertical-align: inherit;">
                                                            <a class="btnOrange" data-toggle="modal" data-target="#check_login"> Xem hồ sơ </a>

                                                        </td>
                                                        <td style="width: 140px;vertical-align: inherit;">




                                                            <select class="custom-select form-control form-control-sm js_change_select" name="submit_job_fb_id[{{ $jobs['submit_job_fb_id']}}]">
                                                                <option value="0" data_submit_job_fb_id="{{ $jobs['submit_job_fb_id']}}" @if($jobs['id_status_submit_job'] == '0' && empty($jobs['id_status_submit_job']    )) selected @endif>Trạng thái</option>
                                                                <?php
                                                                $list_status = \App\Entity\Status_submit_job::getAll();
                                                                ?>


                                                                @foreach($list_status as $status)
                                                                    <option value="{{ isset($status->id_status) ? $status->id_status : '' }}"

                                                                            data_submit_job_fb_id="{{ $jobs['submit_job_fb_id'] }}"
                                                                            data_name = "{{ isset($status->name_status) ? $status->name_status : '' }}"
                                                                            @if($jobs['id_status_submit_job'] == $status->id_status && !empty($jobs['id_status_submit_job'] ))
                                                                            selected
                                                                            @endif >
                                                                        {{ isset($status->name_status) ? $status->name_status : '' }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>

                                            </table>
                                            <button class="btnOrang float-right" type="submit" id="js_save_submit">
                                                Lưu trạng thái
                                            </button>

                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    {{ $list_jobs->links() }}
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
        $('#js_save_submit').click(function() {
            $('#check_login').modal('show');
        });


        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });
        $('.js_change_select').change(function(){
          $('#check_login').modal('show');
        });




    </script>
    @include('site.partials.delete')
    {{--show modal thông báo thay đổi trạng thái--}}


    <!-- Modal -->
    <div class="modal fade" id="showStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="data_name_modal"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--<div class="modal-body">--}}
                {{--...--}}
                {{--</div>--}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary border-0" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary bgorang border-0 btnChangeSelect">Lưu trạng thái</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showStatusSucces" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trạng thái hồ sơ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible fade show"
                         role="alert">
                        Lưu trạng thái thành công !
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary border-0" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showStatusEroor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trạng thái hồ sơ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible fade show"
                         role="alert">
                        Lưu trạng thái thất bại !

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary border-0 reloadPage" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="check_login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Vui lòng đăng nhập tài khoản nhà tuyển dụng với tài khoản ' {{ $employer->email }} ' để sử dụng các chức năng này sanketoan.vn!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary border-0 reloadPage" data-dismiss="modal">Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection