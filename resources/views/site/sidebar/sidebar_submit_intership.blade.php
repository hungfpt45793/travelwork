<?php $user = ''; ?>
<div class="dnav col-xl-3 col-lg-4 col-md-12 dsmbNone sidebar_show_hidden" id="js_toogle_sidebar">
    <div class="d-toggle">

        <div class="side-bar-left formJobLarge  sidebarJobFacebook">
            <div class="createNew text-center bgrBlueN dnavnone" style="    padding: 4px 0;">
                <a href="" data-toggle="modal"
                data-target="@if (!\Illuminate\Support\Facades\Auth::check()) #loginTiva @endif"
                class="createNewButton white">
                    <i class="fas disInBlock fa-paper-plane "></i>
                    <p class="disInBlock font20 fontBold ">Thông tin</p>
                </a>
            </div>
            <div class="tab-content mgb20 " id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="account dnavnone">
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
                                                <img class='lazy' src="{{ !empty($employee->employee_image) ? $employee->employee_image : '/CV/Profile.jpg'}}"
                                                    alt=""
                                                    width="100% ">
                                            @elseif($role == 2)
                                                <?php $employer = \App\Entity\Employer::getIdUser($id_user);

                                                ?>
                                                <img class='lazy' src="{{!empty($employer->image) ? $employer->image : '/CV/Profile.jpg'}}"
                                                    alt=""
                                                    width="100% ">
                                            @elseif($role == 3)
                                                <?php $teacher = \App\Entity\Teacher::getTeacher_id($id_user);
                                                ?>
                                                <img class='lazy' src="{{!empty($teacher->teacher_images) ? $teacher->teacher_images : '/CV/Profile.jpg'}}"
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
                        <hr class="dnavnone">
                        @if(!empty($check_job_fb_employer))
                            <div class="createNew text-center">
                                <a href="{{ route('job-face-user.create') }}" class="f18 md-f14 btnOrange bdr3"><i
                                            class="fas disInBlock fa-paper-plane "></i> Đăng tin miễn phí</a>
                            </div>
                        @endif
                    @endif

                    <hr class="dnavnone">

                    <div class="fillterJobSubmit text-left">
                        <h5 class="lt-f18 fw6 f20 bdLeftBlueN5x pdl10 blueN mgb20 dnavnone">
                            Lọc hồ sơ
                        </h5>
                        <?php
                        $id_status_submit_get = array();
                        if(isset($_GET['id_status_submit']))
                        {
                            $id_status_submit_get = $_GET['id_status_submit'];
                        }

                        ?>
                        <form action="" method="get">
                            <div class="">
                                <label class="f16 dnavnone">Trạng thái hồ sơ</label>
                            </div>
                            <?php
                            $list_status_submit = \App\Entity\Status_submit_job::getAll();
                            ?>
                            @if(!empty($list_status_submit ))

                                <div class="dsBlock">

                                    <label class="f16">
                                        <input type="checkbox" value="0" class="checkboxFilter mgr5" name="id_status_submit[]" @if(in_array('0', $id_status_submit_get)) checked @endif>
                                        <span class="mgl5 dsInline dnavnone">Trạng thái</span>

                                        <?php
                                        //
                                        $count_status = 0;
                                        $count_status = \App\Entity\EmployerIntership::getTotalStatus($employer->employer_id,0);
                                        ?>
                                        @if(!empty($count_status))
                                            <sup class="clHome dnavnone">{{ $count_status }} hồ sơ</sup>
                                        @endif
                                    </label>

                                </div>


                                @foreach($list_status_submit as $status_submit)
                                    <div class="dsBlock">

                                        <label class="f16">
                                            <input type="checkbox" value="{{ $status_submit->id_status }}" class="checkboxFilter mgr5" name="id_status_submit[]" @if(in_array($status_submit->id_status, $id_status_submit_get)) checked @endif>
                                            <span class="mgl5 dsInline dnavnone">{{ $status_submit->name_status }}</span>

                                            <?php
    //
                                            $count_status = 0;
                                            $count_status = \App\Entity\EmployerIntership::getTotalStatus($employer->employer_id,$status_submit->id_status);
                                            ?>
                                            @if(!empty($count_status))
                                                <sup class="clHome dnavnone">{{ $count_status }} hồ sơ</sup>
                                            @endif
                                        </label>

                                    </div>


                                @endforeach
                                <div class="dsBlock">
                                    <button data-toggle="tooltip" data-placement="right" title="Lọc hồ sơ" type="submit" class="btnGreen" style="display: block;width: 100%;padding: 5px" id="btnloading_frofile"><i class="fas fa-filter"></i><span class="dnavnone">  Lọc hồ sơ</span></button>
                                </div>
                            @endif

                            <div>
                                <a href="{{ route('list_job_face') }}" class="dsBlock mgt15 f18 clHome text-center" data-toggle="tooltip" data-placement="right" title="Quay về  tủ hồ sơ"><i class="fas fa-long-arrow-alt-left"></i> <span class="dnavnone"> Quay về  tủ hồ sơ  <i class="fas fa-long-arrow-alt-right"></i></span></a>
                            </div>
                        </form>


                        <script>
                            $('#btnloading_frofile').click(function() {
                                $(this).html( '<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lọc hồ sơ...');
                                $btn.attr('disabled', false);
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
    {{-- end d-toggle --}}
</div>



