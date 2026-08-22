@extends('site.layout.site')

@section('title', 'Danh sách hồ sơ thực tập')
@section('meta_description', 'Danh sách hồ sơ thực tập')
@section('keywords', 'Danh sách hồ sơ thực tập')

@section('content')
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
//                        echo $id_status_submit_get;
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
                                                    <input type="checkbox" value="0" class="checkboxFilter mgr5" name="id_status_submit[]" @if(in_array('0', $id_status_submit_get)) checked @endif>
                                                    <span class="mgl5 dsInline">Trạng thái</span>

                                                    <?php
                                                    //
                                                    $count_status = 0;
                                                    $count_status = \App\Entity\EmployerIntership::getTotalStatus($employer->employer_id,0);
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
                                                        //
                                                        $count_status = 0;
                                                        $count_status = \App\Entity\EmployerIntership::getTotalStatus($employer->employer_id,$status_submit->id_status);
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
                                        <a href="#" class=" f18 md-f14 mgb0">Danh sách hồ sơ thực tập</a>
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
                                                Danh sách hồ sơ ứng viên thực tập
                                            </h5>


                                        </div>
                                            <table id="jobfb" class="table table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Tên ứng viên</th>
                                                    <th>Thời gian thực tập</th>
                                                    <th>Ngày nộp hồ sơ</th>
                                                    <th>Hồ sơ</th>
                                                    <th>Trạng thái</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(!empty($intership))
                                                    @foreach($intership as $id_inter=>$inter)
                                                        <tr>
                                                            <td style="width: 50px;vertical-align: inherit;">
                                                                {{ $id_inter + 1 }}
                                                            </td>
                                                            <td>
                                                                {{ isset($inter->employee_name) ? $inter->employee_name : '' }}
                                                                <p class="mgb0 clHome">
                                                                    <i class="fas fa-map-marker-alt"></i>
                                                                    <?php
                                                                    $district = \App\Entity\District::getId($inter['district']);
                                                                    ?>
                                                                    {{ isset( $district['district_name']) ?  $district['district_name'] : '' }}
                                                                    -
                                                                    <?php
                                                                    $provice = \App\Entity\Province::getId($inter['province']);
                                                                    ?>
                                                                    {{ isset($provice->province_name) ? $provice->province_name : '' }}
                                                                </p>
                                                            </td>
                                                            <td style="width: 150px;vertical-align: inherit;">
                                                                @if(!empty($inter->des_time))
                                                                @endif
                                                                <a class="btnOrange" data-toggle="modal" data-target="#show_time{{$id_inter}}">
                                                                    Xem chi tiết
                                                                </a>

                                                            </td>
                                                            <td style="width: 150px;vertical-align: inherit;">
                                                                <?php
                                                                $date = date_create($inter->created_at);
                                                                echo date_format($date, "d/m/Y");
                                                                ?>
                                                            </td>
                                                            <td style="width: 150px;vertical-align: inherit;">
                                                                <a class="btnOrange" data-toggle="modal" data-target="#check_login"> Xem hồ sơ </a>

                                                            </td>
                                                            <td style="width: 140px;vertical-align: inherit;">
                                                                <select class="form-control form-control-sm js_change_select"
                                                                        name="id_status[{{ $inter['intership_id']}}]">
                                                                    <option data_submit_job_fb_id="{{ $inter['intership_id']}}" value="0"
                                                                            id_status="{{ $inter['id_status']}}"
                                                                            @if($inter['id_status'] == '0' && empty($inter['id_status']   )) selected @endif>
                                                                        Trạng thái
                                                                    </option>
                                                                    <?php
                                                                    $list_status = \App\Entity\Status_submit_job::getAll();
                                                                    ?>
                                                                    @foreach($list_status as $status)
                                                                        <option data_submit_job_fb_id="{{ $inter['intership_id']}}"
                                                                                data_name = "  {{ isset($status->name_status) ? $status->name_status : '' }}"
                                                                                value="{{ isset($status->id_status) ? $status->id_status : '' }}"

                                                                                id_status="{{ $inter['id_status'] }}"
                                                                                @if($inter['id_status'] == $status->id_status && !empty($inter['id_status'] ))
                                                                                selected
                                                                                @endif>
                                                                            {{ isset($status->name_status) ? $status->name_status : '' }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>

                                            </table>
                                            <button class="btnOrang float-right" type="submit" id="js_save_submit">
                                                Lưu trạng thái
                                            </button>

                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    {{ $intership->links() }}
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
        $('#js_save_submit').click(function () {
           $('#check_login').modal('show');
        });
        $('.js_change_select').change(function () {
            $('#check_login').modal('show');
        });
        $('#btnloading_frofile').submit(function(){
           return false;
        });



    </script>

    @if(!empty($intership))
        @foreach($intership as $id_inter=>$inter)
            <div class="modal fade bd-example-modal-lg" id="show_time{{$id_inter}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thời gian thực tập</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {!! isset($inter->des_time) ? $inter->des_time : '' !!}


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary border-0 reloadPage" data-dismiss="modal">Đóng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
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