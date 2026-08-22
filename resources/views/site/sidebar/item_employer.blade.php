<ul class="ul-span mgt20">
    <li class="hvbgrBlueN" data-toggle="tooltip" data-placement="right" title="Thông báo">
        <?php
        $user_id = \Illuminate\Support\Facades\Auth::user()->id;
        $count_noti = 0;
        $count_noti = \App\Entity\NotificationWindow::count_Noti($user_id);
        ?>
        <a href="{{route('noti_employer')}}" class="block hvWhite pd8-20">
            <i class="far fa-bell"></i><span class="">Thông báo</span> @if(!empty($count_noti)) <sup class="clred">({{$count_noti}} thông báo mới)</sup> @endif </a>
    </li>
    <li class="">
        <a  class="block bggreen clwhite pd8-20" data-toggle="tooltip" data-placement="right" title="Danh sách tin tuyển dụng">
            <i class="far fa-list-alt"></i><span class="">Danh sách tin tuyển dụng</span>
        </a>
        <ul class="">
            <li class="hvbgrBlueN" data-toggle="tooltip" data-placement="right" title="Thông tin tuyển dung">
                <a href="{{ route('getAllJobs') }}" class="block hvWhite pd8-20">
                    <i class="fas fa-info"></i><span class="">Thông tin tuyển dụng</span>
                </a>
            </li>
            <li class="hvbgrBlueN">
                <a href="{{ route('list_Job_Candidate_Employee') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Hồ sơ tuyển dụng">
                    <i class="far fa-file"></i><span class="">Hồ sơ tuyển dụng</span>
                </a>
            </li>

            <?php
                $check_job_email_facebook = 0;
                $check_job_email_facebook = \App\Entity\JobFacebook::get_total_job_facebook_email(\Illuminate\Support\Facades\Auth::user()->email);
            ?>
            @if(!empty($check_job_email_facebook))
            <li class="hvbgrBlueN">
                <a href="{{ route('get_job_facebook') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Hồ sơ tuyển dụng">
                    <i class="far fa-file"></i><span class="">Đăng hộ tin tuyển dụng</span> <sup class="clred">({{$check_job_email_facebook}} tin)</sup>
                </a>
            </li>
                @endif
            <?php
            $check_employer_vip = \App\Entity\Employer::check_employer_vip(\Illuminate\Support\Facades\Auth::user()->id);
            ?>
            @if(!empty($check_employer_vip))
                <hr class="mgt0 mgb0">
                <li class="hvbgrBlueN">
                    <a href="{{ route('get_job_all_vip') }}" class="block hvWhite pd8-20">
                        <i class="fas fa-info"></i><span class="">Đăng tuyển hộ công ty khác (HR)</span>
                    </a>
                </li>

                <li class="hvbgrBlueN">
                    <a href="{{ route('list_Job_Candidate_Employee') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right"
                       title="Hồ sơ ứng tuyển">
                        <i class="far fa-file"></i><span class="">Hồ sơ ứng tuyển (HR)</span>
                    </a>
                </li>
            @endif


        </ul>
    </li>
    <li class="">
        <a  class="block bggreen clwhite pd8-20"  data-toggle="tooltip" data-placement="right" title="Điểm nhà tuyển dụng">
            <i class="fas fa-coins"></i><span class="">Điểm nhà tuyển dụng</span>
        </a>

        <ul class="">
            <li class="hvbgrBlueN">
                <a href="{{ route('list_transaction_coin_employer') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Lịch sử giao dịch">
                    <i class="fas fa-history"></i><span class="">Lịch sử giao dịch</span>
                </a>
            </li>
            <li class="hvbgrBlueN">
                <a href="{{ route('list_coin_employer_show_employee') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Thông tin liên hệ ứng viên">
                    <i class="far fa-file"></i><span class="">Danh sách ứng viên đã xem </span>
                </a>
            </li>
            <li class="hvbgrBlueN">
                <a href="{{ route('list_coin_employer_invitation_employee') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Danh sách mời ứng viên">
                    <i class="far fa-file"></i><span class="">Danh sách ứng viên đã mời</span>
                </a>
            </li>
            <li class="hvbgrBlueN">
                <a href="{{ route('list_coin_employees_invitation_job') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Danh sách mời ứng viên">
                    <i class="far fa-file"></i><span class="">Mời ứng viên đồng loạt</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="">
        <a  class="block bggreen clwhite pd8-20"  data-toggle="tooltip" data-placement="right" title="Cổng thực tập">
            <i class="fas fa-user-graduate"></i><span class="">Cổng thực tập</span>
        </a>

        <ul class="">
            <li class="hvbgrBlueN">
                <a href="{{ route('show_intership') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Thông tin tuyển thực tập">
                    <i class="fas fa-info"></i><span class="">Thông tin tuyển thực tập</span>
                </a>
            </li>
            <li class="hvbgrBlueN">
                <a href="{{ route('list_intership') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Hồ sơ thực tập">
                    <i class="far fa-file"></i><span class="">Hồ sơ thực tập</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="">
        <a  class="block bggreen clwhite pd8-20" data-toggle="tooltip" data-placement="right" title="Trắc nghiệm du lịch">
            <i class="fas fa-stream"></i><span class="">Trắc nghiệm du lịch</span>
        </a>

        <ul class="">
            <li class="hvbgrBlueN">
                <a href="{{ route('showExam') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Đề thi của bạn">
                    <i class="far fa-question-circle"></i><span class="">Đề thi của bạn</span>
                </a>
            </li>
            <li class="hvbgrBlueN">
                <a href="{{ route('showAllExam') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Ngân hàng đề thi">
                    <i class="fas fa-university"></i><span class="">Ngân hàng đề thi </span>
                </a>
            </li>
            <li class="hvbgrBlueN">
                <a href="{{ route('room.index') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Danh sách phòng thi">
                    <i class="fab fa-chromecast"></i><span class="">Danh sách phòng thi </span>
                </a>
            </li>
            <li class="hvbgrBlueN">
                <a href="{{ route('getAllRomResultExam') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Kết quả phòng thi">
                    <i class="fas fa-crown"></i><span class="">Kết quả phòng thi </span>
                </a>
            </li>
        </ul>
    </li>

{{--    <li class="">--}}
{{--        <a class="block bggreen clwhite pd8-20" data-toggle="tooltip" data-placement="right" title="Gia sư tư vấn">--}}
{{--            <i class="fas fa-users fw6"></i><span class="">Danh sách gia tư vấn (kế toán)</span>--}}
{{--        </a>--}}
{{--        <ul class="">--}}
{{--            <li class="hvbgrBlueN">--}}
{{--                <a href="{{ route('list_support_user') }}" class="block hvWhite pd8-20" data-toggle="tooltip"--}}
{{--                   data-placement="right" title="Gia sư tư vấn">--}}
{{--                    <i class="fas fa-users fw6"></i><span class="">Gia sư tư vấn</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </li>--}}

    <li class="">
        <a  class=" block bggreen clwhite pd8-20" data-toggle="tooltip" data-placement="right" title="Thông tin tài khoản">
            <i class="fas fa-users"></i><span class="">Thông tin tài khoản</span>
        </a>
        <ul class="">
            <li class="hvbgrBlueN">
                <a href="{{ route('management_account') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Thông tin">
                    <i class="fas fa-info"></i><span class="">Thông tin</span>
                    @if(\Illuminate\Support\Facades\Auth::user()->status_email_account == 0)
                    <sup class="clred dnavnone">(Chưa xác thực)</sup>
                    @else
                        <sup class="clgreen dnavnone">(Đã xác thực)</sup>
                    @endif
                </a>
            </li>
            <li class="hvbgrBlueN">
                <a href="{{ route('show_file_job_facebook') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Quản lý hồ sơ">
                    <i class="fas fa-id-card "></i><span class="">Quản lý hồ sơ</span>
                </a>
            </li>
            <li class="hvbgrBlueN">
                <a href="{{route('show_user_job_facebook')}}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Đổi mật khẩu">
                    <i class="fas fa-user-circle "></i><span class="">Đổi mật khẩu</span>
                </a>
            </li>

            <li class="hvbgrBlueN">
                <a href="{{route('logoutHome')}}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Thoát tài khoản">
                    <i class="fas fa-sign-out-alt"></i><span class="">Thoát tài khoản</span></a>
            </li>
        </ul>
    </li>

</ul>


