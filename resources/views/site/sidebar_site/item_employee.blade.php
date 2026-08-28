<div class="row">
    <div class="col-md-4 ">
        <div class="accountThumbnail mgt10 mgb10">
            <?php
            $user = \Illuminate\Support\Facades\Auth::user();
            $id_user = $user->id;
            $role = $user->role;
            $static = $user->status_teacher_sc;
            ?>
            <?php $employee = \App\Entity\Employee::getEmployee_id($id_user); ?>
            <img class="lazy pdl10"
                 src="{{ !empty($employee->employee_image) ? $employee->employee_image : '/assets/image/no_avatar.jpg'}}"
                 alt="" width="100% ">
        </div>
    </div>
    <div class="col-md-8">
        <div class="accountInfo mgt10 mgb10">
            <h5 class="mgb0">
                {{ isset($employee->employee_name) ? $employee->employee_name : ''}}</h5>
            <p class="mgb0">
                <span class="clRed dsBlock mgt5 mgb5"><i>(Ứng viên)</i> <i class="fas fa-caret-right"></i> [{{ $id_user }}]</span>
                <?php
                $employee_profile = 0;
                $employee_profile = \App\Entity\Employee::get_profile($id_user);
                ?>
                <a style="color: green !important;" href="{{ route('show_step_profile_employee') }}"
                   class="clgreen dsInline mgt5">Điểm hồ sơ
                    : {{ !empty($employee_profile->profile) ? $employee_profile->profile : '20' }}
                    </a>
            </p>
        </div>
    </div>
</div>
<ul class="list_item_sidebar">
    <li>
        <a class="list_item_sidebar_title" data-placement="right" title="Thông tin hồ sơ"
           data-toggle="tooltip" data-placement="right" title="Danh sách bài viết kiếm tiền">
            <i class="fas fa-users"></i><span class="">Thông tin hồ sơ</span>
        </a>
        <ul class="sub_list_item">
            <li>
                <a href="{{ route('show_step_profile_employee') }}" data-toggle="tooltip"
                   data-placement="right" title="Cập nhật hồ sơ">
                    <i class="far fa-edit"></i><span>Cập nhật hồ sơ</span>
                    <img src="{{ asset('assets/image/hotpng.png') }}" style="width: 40px">
                </a>
            </li>
            <li>
                <a href="{{ route('setting_profile_employee') }}" data-toggle="tooltip"
                   data-placement="right" title="Cài đặt hồ sơ">
                    <i class="fas fa-cogs"></i><span>Cài đặt hồ sơ</span>
                </a>
            </li>
            <li>
                <a href="{{ route('get_all_coe') }}" data-toggle="tooltip"
                   data-placement="right" title="Tính hệ số lương">
                    <i class="fas fa-calculator"></i><span>Tính hệ số lương</span>
                </a>
            </li>
            <?php
            $check_coe_id = \App\Entity\Coefficients_salary::where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->orderBy('coe_id','desc')->value('coe_id');
            $career_category_id = \App\Entity\Coefficients_salary::where('coe_id',$check_coe_id)->value('career_category_id');
            $career_category_slug  = \App\Entity\Career::where('career_category_id',$career_category_id)->value('career_category_slug');
            ?>
            @if(!empty($check_coe_id))
                <li>
                    <a href="{{ route('total_get_all_coe',['career_category_slug'=>$career_category_slug,'coe_id'=>$check_coe_id ]) }}" data-toggle="tooltip"
                       data-placement="right" title="Kết quả phân tích lương gần nhất">
                        <i class="fas fa-dollar-sign"></i><span>Kết quả phân tích lương gần nhất</span>
                    </a>
                </li>
            @endif

            <li>
                <a href="{{route('show_user_job_facebook')}}" data-toggle="tooltip"
                   data-placement="right" title="Đổi mật khẩu">
                    <i class="fas fa-user-circle "></i><span>Đổi mật khẩu</span>
                </a>
            </li>

        </ul>
    </li>

    <li>
        <a class="list_item_sidebar_title">
            <i class="far fa-file-alt"></i><span class="">Thông tin việc làm </span>
        </a>
        <ul class="sub_list_item">
            <?php
            $employee = \App\Entity\Employee::getEmployee_id($id_user);
            $total_submit = 0;
            $total_job = \App\Entity\Employee_submit_job_faacebook::get_total_employer_submit($employee['employee_id']);
            $total_interhip = \App\Entity\EmployerIntership::get_total_employee($employee['employee_id']);
            $total_submit = $total_job + $total_interhip;
            ?>
            <li>
                <a href="{{ route('list_Jobs_Submit_Employee') }}" data-toggle="tooltip"
                   data-placement="right"
                   title="Việc làm đã nộp hồ sơ @if(empty($total_submit)) ({{$total_submit}}) @endif">
                    <i class="far fa-share-square"></i>
                    <span class="">Việc làm đã nộp hồ sơ
                        @if(!empty($total_submit)) <sup class="clRed">({{$total_submit}})</sup> @endif
                    </span>

                </a>
            </li>
            <?php
            $total_save = 0;
            $total_save = \App\Entity\Employees_save_job_facebook::get_total_employee($employee['employee_id']);
            ?>
            <li>
                <a href="{{ route('list_Jobs_Save_Employee') }}" data-toggle="tooltip"
                   data-placement="right" title="Việc làm đã lưu @if(empty($total_save)) ({{$total_save}}) @endif">
                    <i class="fas fa-download"></i>
                    <span class="">
                        Việc làm đã lưu   @if(!empty($total_save)) <sup class="clRed">({{$total_save}})</sup> @endif
                    </span>
                </a>
            </li>
            <?php
            $total_follow = 0;
            $total_follow = \App\Entity\Employee_follow_employer::total_follow_employee($employee['employee_id']);
            ?>
            <li>
                <a href="{{ route('list_employee_follow_employer') }}"
                   data-toggle="tooltip" data-placement="right"
                   title="Việc làm theo dõi từ nhà tuyển dụng @if(empty($total_follow)) ({{$total_follow}}) @endif">
                    <i class="fab fa-stack-overflow"></i>
                    <span class="">Việc làm theo dõi từ nhà tuyển dụng
                        @if(!empty($total_follow)) <sup class="clRed">({{$total_follow}})</sup> @endif
                    </span>
                </a>
            </li>

            <li>
                <?php
                $total_desired = 0;
                $total_desired = \App\Entity\Job_desired::total_desired($id_user);
                ?>
                <a href="{{ route('job_desired_employee') }}" data-toggle="tooltip"
                   data-placement="right"
                   title="Việc làm mong muốn @if(empty($total_follow)) ({{$total_follow}}) @endif">
                    <i class="far fa-heart"></i>
                    <span class="">Việc làm mong muốn
                        @if(!empty($total_desired)) <sup class="clRed">({{$total_desired}})</sup> @endif
                    </span>
                </a>
            </li>

        </ul>
    </li>
    <li>
        <a class="list_item_sidebar_title" data-toggle="tooltip" data-placement="right" title="Khóa học">
            <i class="fas fa-chalkboard-teacher"></i><span class="">Khóa học </span>
        </a>

        <ul class="sub_list_item">
            {{--<li class="hvbgrBlueN">--}}
                {{--<a href="{{ route('listlearn') }}" data-toggle="tooltip"--}}
                   {{--data-placement="right" title="Khoá học đã đăng ký">--}}
                    {{--<i class="fas fa-chalkboard-teacher"></i><span class="">Khoá học đã đăng ký</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            <li class="hvbgrBlueN">
                <a href="{{ route('course_myCourse') }}" data-toggle="tooltip"
                   data-placement="right" title="Khoá học đã đăng ký" target="_blank">
                    <i class="fas fa-chalkboard-teacher"></i><span class="">Khoá học của tôi</span>
                </a>
            </li>
        </ul>
    </li>

    <li>

        @if(\Illuminate\Support\Facades\Auth::user()->user_advise_support == 1)
            <a class="list_item_sidebar_title" data-toggle="tooltip" data-placement="right" title="Khóa học">
                <i class="fas fa-users fw6"></i><span class="">Việc làm du lịch cần tư vấn</span>
            </a>

            <ul class="sub_list_item">
                <li class="hvbgrBlueN">
                    <a href="{{ route('list_advise_user') }}" data-toggle="tooltip"
                       data-placement="right" title="Du lịch cần tư vấn" target="_blank">
                        <i class="fas fa-users fw6"></i><span class=""> Việc làm du lịch cần tư vấn</span>
                    </a>
                </li>
            </ul>
        @endif





    </li>

    <li>
        <a class="list_item_sidebar_title" data-toggle="tooltip" data-placement="right"
           title="Kiếm tiền từ chia sẻ bài">
            <i class="fas fa-donate"></i><span class="">Kiếm tiền</span>
        </a>
        <ul class="sub_list_item">
            <li>
                <a href="{{route('list_post')}}" data-toggle="tooltip"
                   data-placement="right" title="Danh sách bài viết kiếm tiền">
                    <i class="fas fa-bars"></i><span class="">Danh sách bài viết kiếm tiền</span></a>
            </li>
            <li>
                <a href="{{route('redeem_rewards')}}" data-toggle="tooltip"
                   data-placement="right" title="Kiếm tiền từ chia sẻ bài">
                    <i class="fas fa-bars"></i><span class="">Danh sách đổi thưởng</span>
                </a>
            </li>

            <li>

                <a target="_blank"
                   href="{{ route('post',['cate_slug'=>'tin-tuc','post_slug'=>'huong-dan-thao-tac-trong-chuc-nang-kiem-tien-tu-chia-se-bai-viet' ]) }}"
                   data-toggle="tooltip"
                   data-placement="right" title=" Hướng dẫn chia sẻ bài viết">
                    <i class="fas fa-caret-right mgr5"></i> Hướng dẫn chia sẻ bài viết</span>
                </a>
            </li>
            {{--<li>--}}
                {{--<a href="{{route('list_intro_employer')}}" data-toggle="tooltip"--}}
                   {{--data-placement="right" title="Danh sách bài viết kiếm tiền">--}}
                    {{--<i class="fas fa-donate"></i><span class="">Danh sách giới thiệu NTD</span> <sup class="clRed f14">(mới)</sup></a>--}}
            {{--</li>--}}
        </ul>
    </li>
    <li>
        <a class=" list_item_sidebar_title" data-placement="right" title="Thông tin tài khoản"
           data-toggle="tooltip" data-placement="right" title="Danh sách bài viết kiếm tiền">
            <i class="fas fa-users"></i><span class="">Thông tin tài khoản</span>
        </a>
        <ul class="sub_list_item">
            <li>
                <a href="{{ route('management_account') }}" data-toggle="tooltip"
                   data-placement="right" title="Thông tin">
                    <i class="fas fa-info"></i><span>Thông tin
    @if(\Illuminate\Support\Facades\Auth::user()->status_email_account == 0)
                            <sup class="clRed">(Chưa xác thực)</sup>
                        @else
                            <sup class="clgreen">(Đã xác thực)</sup>
                        @endif
    </span>
                </a>
            </li>
            <li>
                <a href="{{route('show_user_job_facebook')}}" data-toggle="tooltip"
                   data-placement="right" title="Đổi mật khẩu">
                    <i class="fas fa-user-circle "></i><span>Đổi mật khẩu</span>
                </a>
            </li>

            <li>
                <a href="{{route('logoutHome')}}" data-toggle="tooltip"
                   data-placement="right" title="Thoát tài khoản">
                    <i class="fas fa-sign-out-alt"></i><span>Thoát tài khoản</span></a>
            </li>
        </ul>
    </li>


</ul>
