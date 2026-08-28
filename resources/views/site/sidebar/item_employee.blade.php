
<ul class="ul-span">
    <?php
    $user_id = \Illuminate\Support\Facades\Auth::user()->id;
    ?>



    <li class="">
        <a class=" block bggreen clwhite pd8-20" data-placement="right" title="Thông tin hồ sơ"
           data-toggle="tooltip" data-placement="right" title="Danh sách bài viết kiếm tiền">
            <i class="fas fa-users"></i><span class="">Thông tin hồ sơ</span>
        </a>
        <ul class="">

            <li class="hvbgrBlueN">

                <a href="{{ route('show_step_profile_employee') }}" class="block hvWhite pd8-20" data-toggle="tooltip"
                   data-placement="right" title="Cập nhật hồ sơ">
                    <i class="far fa-edit"></i><span>Cập nhật hồ sơ</span>
                    <img src="{{ asset('assets/image/hotpng.png') }}" style="width: 40px">
                </a>


            </li>
            <li class="hvbgrBlueN">
                <a href="{{ route('setting_profile_employee') }}" class="block hvWhite pd8-20" data-toggle="tooltip"
                   data-placement="right" title="Cài đặt hồ sơ">
                    <i class="fas fa-cogs"></i><span>Cài đặt hồ sơ</span>
                </a>

            </li>
            <li class="hvbgrBlueN">
                <a href="{{ route('get_all_coe') }}" class="block hvWhite pd8-20" data-toggle="tooltip"
                   data-placement="right" title="Tính hệ số lương">
                    <i class="fas fa-calculator"></i><span>Tính hệ số lương</span>
                </a>
            </li>
            <li class="hvbgrBlueN">
                <a href="{{route('show_user_job_facebook')}}" class="block hvWhite pd8-20" data-toggle="tooltip"
                   data-placement="right" title="Đổi mật khẩu">
                    <i class="fas fa-user-circle "></i><span>Đổi mật khẩu</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="">
        <a class="block bggreen clwhite pd8-20">
            <i class="far fa-file-alt"></i><span class="">Thông tin việc làm </span>
        </a>

        <ul class="">
            <?php
            $employee = \App\Entity\Employee::getEmployee_id($user_id);
            $total_submit = 0;
            $total_job = \App\Entity\Employee_submit_job_faacebook::get_total_employer_submit($employee['employee_id']);
            $total_interhip = \App\Entity\EmployerIntership::get_total_employee($employee['employee_id']);
            $total_submit = $total_job + $total_interhip;
            ?>
            <li class="hvbgrBlueN">
                <a href="{{ route('list_Jobs_Submit_Employee') }}" class="block hvWhite pd8-20" data-toggle="tooltip"
                   data-placement="right"
                   title="Việc làm đã nộp hồ sơ @if(empty($total_submit)) ({{$total_submit}}) @endif">
                    <i class="far fa-share-square"></i>
                    <span class="">Việc làm đã nộp hồ sơ
                        @if(!empty($total_submit)) <sup class="clred">({{$total_submit}})</sup> @endif
                    </span>

                </a>
            </li>
            <?php
            $total_save = 0;
            $total_save = \App\Entity\Employees_save_job_facebook::get_total_employee($employee['employee_id']);
            ?>
            <li class="hvbgrBlueN">
                <a href="{{ route('list_Jobs_Save_Employee') }}" class="block hvWhite pd8-20" data-toggle="tooltip"
                   data-placement="right" title="Việc làm đã lưu @if(empty($total_save)) ({{$total_save}}) @endif">
                    <i class="fas fa-download"></i>
                    <span class="">
                        Việc làm đã lưu   @if(!empty($total_save)) <sup class="clred">({{$total_save}})</sup> @endif
                    </span>
                </a>
            </li>
            <?php
            $total_follow = 0;
            $total_follow = \App\Entity\Employee_follow_employer::total_follow_employee($employee['employee_id']);
            ?>
            <li class="hvbgrBlueN">
                <a href="{{ route('list_employee_follow_employer') }}" class="block hvWhite pd8-20"
                   data-toggle="tooltip" data-placement="right"
                   title="Việc làm theo dõi từ nhà tuyển dụng @if(empty($total_follow)) ({{$total_follow}}) @endif">
                    <i class="fab fa-stack-overflow"></i>
                    <span class="">Việc làm theo dõi từ nhà tuyển dụng
                        @if(!empty($total_follow)) <sup class="clred">({{$total_follow}})</sup> @endif
                    </span>
                </a>
            </li>

            <li class="hvbgrBlueN">
                <?php
                $total_desired = 0;
                $total_desired = \App\Entity\Job_desired::total_desired($user_id);
                ?>
                <a href="{{ route('job_desired_employee') }}" class="block hvWhite pd8-20" data-toggle="tooltip"
                   data-placement="right"
                   title="Việc làm mong muốn @if(empty($total_follow)) ({{$total_follow}}) @endif">
                    <i class="far fa-heart"></i>
                    <span class="">Việc làm mong muốn
                        @if(!empty($total_desired)) <sup class="clred">({{$total_desired}})</sup> @endif
                    </span>
                </a>
            </li>

        </ul>
    </li>
    <li class="">
        <a class="block bggreen clwhite pd8-20" data-toggle="tooltip" data-placement="right" title="Khóa học">
            <i class="fas fa-chalkboard-teacher"></i><span class="">Khóa học </span>
        </a>

        <ul class="">
            {{--<li class="hvbgrBlueN">--}}
                {{--<a href="{{ route('listlearn') }}" class="block hvWhite pd8-20" data-toggle="tooltip"--}}
                   {{--data-placement="right" title="Khoá học đã đăng ký">--}}
                    {{--<i class="fas fa-chalkboard-teacher"></i><span class="">Khoá học đã đăng ký</span>--}}
                {{--</a>--}}
            {{--</li>--}}

            <li class="hvbgrBlueN">
                <a href="{{ route('course_myCourse') }}" class="block hvWhite pd8-20" data-toggle="tooltip"
                   data-placement="right" title="Khoá học đã đăng ký">
                    <i class="fas fa-chalkboard-teacher"></i><span class="">Khoá học của tôi</span>
                </a>
            </li>
        </ul>
    </li>

{{--        --}}{{--Gia sư--}}
{{--        @if(\Illuminate\Support\Facades\Auth::user()->user_advise_support == 1)--}}
{{--            <li class="">--}}
{{--                <a class="block bggreen clwhite pd8-20" data-toggle="tooltip" data-placement="right" title="Kế toán cần tư vấn">--}}
{{--                    <i class="fas fa-users fw6"></i><span class="">Danh sách kế toán kết nối (gia sư)</span>--}}
{{--                </a>--}}

{{--                <ul class="">--}}
{{--                    --}}{{--<li class="hvbgrBlueN">--}}
{{--                    --}}{{--<a href="{{ route('listlearn') }}" class="block hvWhite pd8-20" data-toggle="tooltip"--}}
{{--                    --}}{{--data-placement="right" title="Khoá học đã đăng ký">--}}
{{--                    --}}{{--<i class="fas fa-chalkboard-teacher"></i><span class="">Khoá học đã đăng ký</span>--}}
{{--                    --}}{{--</a>--}}
{{--                    --}}{{--</li>--}}

{{--                    <li class="hvbgrBlueN">--}}
{{--                        <a href="{{ route('list_advise_user') }}" class="block hvWhite pd8-20" data-toggle="tooltip"--}}
{{--                           data-placement="right" title="Kế toán cần tư vấn">--}}
{{--                            <i class="fas fa-users fw6"></i><span class="">Kế toán cần tư vấn</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}

{{--        @else--}}
{{--            --}}{{--Tư vấn--}}
{{--            --}}{{--kế toán danh sách nhưng gia sư muốn tư vấn--}}
{{--            <li class="">--}}
{{--                <a class="block bggreen clwhite pd8-20" data-toggle="tooltip" data-placement="right" title="Gia sư tư vấn">--}}
{{--                    <i class="fas fa-users fw6"></i><span class="">Danh sách gia tư vấn (kế toán)</span>--}}
{{--                </a>--}}
{{--                <ul class="">--}}
{{--                    <li class="hvbgrBlueN">--}}
{{--                        <a href="{{ route('list_support_user') }}" class="block hvWhite pd8-20" data-toggle="tooltip"--}}
{{--                           data-placement="right" title="Gia sư tư vấn">--}}
{{--                            <i class="fas fa-users fw6"></i><span class="">Gia sư tư vấn</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--        @endif--}}

    <li class="">
        <a class=" block bggreen clwhite pd8-20" data-toggle="tooltip" data-placement="right"
           title="Kiếm tiền từ chia sẻ bài">
            <i class="fas fa-donate"></i><span class="">Kiếm tiền từ chia sẻ bài</span>
        </a>
        <ul class="">
            <li class="hvbgrBlueN">
                <a href="{{route('list_post')}}" class="block hvWhite pd8-20" data-toggle="tooltip"
                   data-placement="right" title="Danh sách bài viết kiếm tiền">
                    <i class="fas fa-bars"></i><span class="">Danh sách bài viết kiếm tiền</span></a>
            </li>
            <li class="hvbgrBlueN">
                <a href="{{route('redeem_rewards')}}" class="block hvWhite pd8-20" data-toggle="tooltip"
                   data-placement="right" title="Kiếm tiền từ chia sẻ bài">
                    <i class="fas fa-bars"></i><span class="">Danh sách đổi thưởng</span>
                </a>
            </li>

            <li class="hvbgrBlueN">

                <a target="_blank" href="{{ route('post',['cate_slug'=>'tin-tuc','post_slug'=>'huong-dan-thao-tac-trong-chuc-nang-kiem-tien-tu-chia-se-bai-viet' ]) }}" class="block hvWhite pd8-20" data-toggle="tooltip"
                   data-placement="right" title=" Hướng dẫn chia sẻ bài viết">
                    <i class="fas fa-caret-right mgr5"></i> Hướng dẫn chia sẻ bài viết</span>
                </a>
            </li>
        </ul>
    </li>



    <li class="">
        <a class=" block bggreen clwhite pd8-20" data-placement="right" title="Thông tin tài khoản"
           data-toggle="tooltip" data-placement="right" title="Danh sách bài viết kiếm tiền">
            <i class="fas fa-users"></i><span class="">Thông tin tài khoản</span>
        </a>
        <ul class="">
            <li class="hvbgrBlueN">
                <a href="{{ route('management_account') }}" class="block hvWhite pd8-20" data-toggle="tooltip"
                   data-placement="right" title="Thông tin">
                    <i class="fas fa-info"></i><span>Thông tin
    @if(\Illuminate\Support\Facades\Auth::user()->status_email_account == 0)
                            <sup class="clred">(Chưa xác thực)</sup>
                        @else
                            <sup class="clgreen">(Đã xác thực)</sup>
                        @endif
    </span>
                </a>
            </li>
            <li class="hvbgrBlueN">
                <a href="{{route('show_user_job_facebook')}}" class="block hvWhite pd8-20" data-toggle="tooltip"
                   data-placement="right" title="Đổi mật khẩu">
                    <i class="fas fa-user-circle "></i><span>Đổi mật khẩu</span>
                </a>
            </li>


            <li class="hvbgrBlueN">
                <a href="{{route('logoutHome')}}" class="block hvWhite pd8-20" data-toggle="tooltip"
                   data-placement="right" title="Thoát tài khoản">
                    <i class="fas fa-sign-out-alt"></i><span>Thoát tài khoản</span></a>
            </li>
        </ul>
    </li>


</ul>
