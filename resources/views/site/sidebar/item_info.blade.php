<div class="tab-content mgb20" id="nav-tabContent">
    <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="account dnavnone mgb5">
            <br>
            <div class="employee dnavnone">
                @if (\Illuminate\Support\Facades\Auth::check())
                    <?php $user = \Illuminate\Support\Facades\Auth::user(); ?>
                    <div class="row">
                        <div class="col-md-4 ">
                            <div class="accountThumbnail ">
                                <?php
                                $id_user = $user->id;
                                $role = $user->role;
                                $static = $user->status_teacher_sc;
                                ?>
                                @if($role == 1)
                                    <?php $employee = \App\Entity\Employee::getEmployee_id($id_user); ?>
                                    <img class="lazy" src="{{ !empty($employee->employee_image) ? $employee->employee_image : '/CV/Profile.jpg'}}"
                                         alt="" width="100% ">
                                @endif


                                @if($role == 2)
                                    <?php $employer = \App\Entity\Employer::getIdUser($id_user); ?>
                                    <img class="lazy" src="{{!empty($employer->image) ? $employer->image : '/CV/Profile.jpg'}}"
                                         alt="" width="100% ">
                                @endif
                                @if($role == 3 && $static == 0)
                                    <?php $teacher = \App\Entity\Teacher::getTeacher_id($id_user);
                                    ?>
                                    <img class="lazy" src="{{!empty($teacher->teacher_images) ? $teacher->teacher_images : '/CV/Profile.jpg'}}"
                                         alt="" width="100% ">
                                @endif
                                @if($role == 3 && $static == 1)
                                    <?php $teacher_school = \App\Entity\Teacher_schools::getTeacher_id($id_user);
                                    ?>
                                    <img class="lazy" src="{{!empty($teacher_school->teacher_images) ? $teacher_school->teacher_images : '/CV/Profile.jpg'}}"
                                         alt="" width="100% ">
                                @endif

                                @if($role == 4)
                                @endif

                            </div>
                        </div>
                        <div class="col-md-8 " style="">
                            <div class="accountInfo ">

                                @if($role == 1)


                                    <h5 style="padding: 0 5px">
                                        {{ isset($employee->employee_name) ? $employee->employee_name : ''}}</h5>

                                @endif
                                @if($role == 2)
                                    <h5 style="padding: 0 5px">
                                        {{ isset($employer->enterprise_name) ? $employer->enterprise_name : ''}}

                                    </h5>
                                @endif
                                @if($role == 3 && $static == 0)
                                    <h5 style="padding: 0 5px">
                                        {{ isset($teacher->teacher_name) ? $teacher->teacher_name : ''}}</h5>
                                @endif
                                @if($role == 3 && $static == 1)
                                    <h5 style="padding: 0 5px">
                                        {{ isset($teacher_school->teacher_sc_name) ? $teacher_school->teacher_sc_name : ''}}
                                    </h5>
                                @endif
                                @if($role == 4)
                                @endif


                                <p class="mgb0">
                                    @if($role == 1)
                                        <span class="clred dsBlock mgt5 mgb5"><i>(Ứng viên)</i> <i class="fas fa-caret-right"></i> [{{ $id_user }}]</span>
                                        <?php
                                        $id = \Illuminate\Support\Facades\Auth::user()->id;
                                        $employee_profile = 0;
                                        $employee_profile = \App\Entity\Employee::get_profile($id);
                                        ?>
                                        <a style="color: green !important;"  href="{{ route('show_step_profile_employee') }}" class="clgreen dsInline mgt5">Điểm hồ sơ : {{ !empty($employee_profile->profile) ? $employee_profile->profile : '0' }}
                                        điểm</a>
                                    @endif
                                    @if($role == 2)
                                        <span class="red"><i>(Nhà tuyển dụng)</i></span>
                                @if(!empty($employer->total_employer_coin))
                                    <p class="mgb0 clgreen">
                                        Điểm : {{ number_format($employer->employer_coin )}} điểm
                                        <span data-toggle="modal" data-target="#create_coin"
                                              class="btnOrange mg10-0 d-sm-inline-block  bdr3 mgf5"
                                              style="padding: 5px 15px;cursor: pointer">Nạp điểm <i
                                                    class="fas fa-coins"></i></span>
                                    </p>
                                @else
                                    <p class="mgb0 clgreen">
                                        <?php
                                        $coin_infomation = \App\Entity\Coin_type_information_employer::get_coin_info();
                                        $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);
                                        $coin_money = $coin_infomation['so-diem-mien-phi-theo-ngay'] - $history_coin;
                                        ?>
                                        Điểm miễn phí : {{ isset($coin_money) ? $coin_money : '0' }} điểm

                                            <span data-toggle="modal" data-target="#create_coin"
                                                  class="btnOrange mg10-0 d-sm-inline-block mgb10 bdr3 mgf5"
                                                  style="padding: 5px 15px;cursor: pointer">Nạp điểm <i
                                                        class="fas fa-coins"></i></span>
                                    </p>
                                @endif

                                @endif
                                @if($role == 3)
                                    <span class="red"><i>(Giáo viên)</i></span>
                                @endif
                                @if($role == 4)
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
                                       id="exampleInputPassword1" placeholder="Nhập mật khẩu của bạn">
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
                                    <p class="red mgb0" style="margin-bottom: 10px">{{ session('error_login') }}</p>
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
                                <label for="exampleInputPassword1">Chưa có tài khoản?
                                    <a href="{{route('register')}}"> Đăng ký tài khoản</a>
                                </label>
                            </div>
                            <button type="submit" class="btn bgrBlueN white">ĐĂNG NHẬP</button>
                        </div>

                    </form>
                @endif
            </div>
        </div>

        @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)

            <?php
            $check_job_fb_employer = \App\Entity\Employer::check_is_admin(\Illuminate\Support\Facades\Auth::user()->id)
            ?>
            <hr class="dnavnone">
            @if(!empty($check_job_fb_employer))
                <div class="createNew text-center" data-toggle="tooltip" data-placement="right"
                     title="Đăng tin miễn phí">
                    <a href="{{ route('job-face-user.create') }}" class="f18 md-f14 btnOrange bdr3">
                        <i class="fas disInBlock fa-paper-plane "></i>
                        <span class="dnavnone">Đăng tin miễn phí</span></a>
                </div>
            @else
                <div class="createNew text-center" data-toggle="tooltip" data-placement="right"
                     title="Đăng tin miễn phí">
                    <a href="{{ route('job-user.create') }}" class="f18 md-f14 btnOrange bdr3"><i
                                class="fas disInBlock fa-paper-plane "></i> <span class="dnavnone">Đăng tin miễn
                                phí</span></a>
                </div>
            @endif
        @else

        @endif
        {{--<hr>--}}
        {{--<div class="createNew text-center bgrBlueN">--}}
        {{--<a href="{{ route('show_file_job_facebook') }}" class="createNewButton ">--}}
        {{--<i class="fas disInBlock fa-paper-plane "></i>--}}
        {{--<p class="disInBlock font20 fontBold ">Tạo hồ sơ</p>--}}
        {{--</a>--}}
        {{--</div>--}}
        @include('site.sidebar.item_job_facebook')

    </div>
</div>