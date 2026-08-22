@include('site.sidebar_site.login_info_employer')

<ul class="list_item_sidebar">
    <li data-toggle="tooltip" data-placement="right" title="Thông báo">
        <?php
        $count_noti = 0;
        $count_noti = \App\Entity\NotificationWindow::count_Noti($id_user);
        ?>
        <a href="{{route('noti_employer')}}" class="list_item_title_noti">
            <i class="far fa-bell"></i><span class="">Thông báo</span> @if(!empty($count_noti)) <sup
                    class="clRed">({{$count_noti}} thông báo mới)</sup> @endif </a>
    </li>

    <li class="">
        <a class=" list_item_sidebar_title" data-toggle="tooltip" data-placement="right" title="Thông tin tài khoản">
            <i class="fas fa-users"></i><span class="">Hồ sơ tuyển dụng</span>
        </a>
        <ul class="sub_list_item">
            <li>
                <a href="{{ route('management_account') }}" data-toggle="tooltip" data-placement="right"
                   title="Thông tin">
                    <i class="fas fa-info"></i><span class="">Xác thực tài khoản</span>
                    @if(\Illuminate\Support\Facades\Auth::user()->status_email_account == 0)
                        <sup class="clRed dnavnone">(Chưa xác thực)</sup>
                    @else
                        <sup class="clgreen dnavnone">(Đã xác thực)</sup>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('show_file_job_facebook') }}" data-toggle="tooltip" data-placement="right"
                   title="Quản lý hồ sơ">
                    <i class="fas fa-id-card "></i><span class="">Quản lý hồ sơ</span>
                </a>
            </li>
        </ul>
    </li>




    <li>
        <a class="list_item_sidebar_title" data-toggle="tooltip" data-placement="right"
           title="Danh sách tin tuyển dụng">
            <i class="far fa-list-alt"></i><span class="">Danh sách tin tuyển dụng</span>
        </a>
        <ul class="sub_list_item">
            <li data-toggle="tooltip" data-placement="right" title="Thông tin tuyển dung">
                <a href="{{ route('getAllJobs') }}">
                    <i class="fas fa-info"></i><span class="">Thông tin tuyển dụng</span>
                </a>
            </li>
            <li>
                <a href="{{ route('list_Job_Candidate_Employee') }}" data-toggle="tooltip" data-placement="right"
                   title="Hồ sơ ứng tuyển">
                    <i class="far fa-file"></i><span class="">Hồ sơ ứng tuyển</span>
                </a>
            </li>



            <?php
            $check_job_email_facebook = 0;
            $check_job_email_facebook = \App\Entity\JobFacebook::get_total_job_facebook_email(\Illuminate\Support\Facades\Auth::user()->email);
            ?>
            @if(!empty($check_job_email_facebook))
                <li>
                    <a href="{{ route('get_job_all_vip') }}" data-toggle="tooltip" data-placement="right"
                       title="Hồ sơ tuyển dụng">
                        <i class="far fa-file"></i><span class="">Đăng hộ tin tuyển dụng</span> <sup
                                class="clRed">({{$check_job_email_facebook}} tin)</sup>
                    </a>
                </li>
            @endif

            <?php
            $check_employer_vip = \App\Entity\Employer::check_employer_vip(\Illuminate\Support\Facades\Auth::user()->id);
            ?>
            @if(!empty($check_employer_vip))
            <hr class="mgt0 mgb0">
            <li data-toggle="tooltip" data-placement="right" title="Thông tin tuyển dung">
                <a href="{{ route('get_job_all_vip') }}">
                    <i class="fas fa-info"></i><span class="">Đăng tuyển hộ công ty khác (HR)</span>
                </a>
            </li>

                <li>
                    <a href="{{ route('list_Job_Candidate_Employee_vip') }}" data-toggle="tooltip" data-placement="right"
                       title="Hồ sơ ứng tuyển">
                        <i class="far fa-file"></i><span class="">Hồ sơ ứng tuyển (HR)</span>
                    </a>
                </li>
            @endif

            <?php
            $employer = \App\Entity\Employer::getIdUser(\Illuminate\Support\Facades\Auth::user()->id);
            $check_order_job = \App\Entity\Order_job::check_order_employer($employer->employer_id);
            ?>
            @if(!empty($check_order_job))
                <hr class="mgt0 mgb0">
                <li data-toggle="tooltip" data-placement="right" title="Thông tin tuyển dung">
                    <a href="{{ route('list_order_job') }}">
                        <i class="fab fa-first-order-alt"></i><span class="">Đơn hàng tuyển dụng</span>
                    </a>
                </li>
                <li data-toggle="tooltip" data-placement="right" title="Hồ sơ tuyển dụng">
                    <a href="{{ route('list_submit_employee_order') }}" data-toggle="tooltip" data-placement="right"
                       title="Hồ sơ ứng tuyển">
                        <i class="far fa-file"></i><span class="">Hồ sơ ứng tuyển</span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
    <li class="">
        <a class="list_item_sidebar_title" data-toggle="tooltip" data-placement="right" title="Điểm nhà tuyển dụng">
            <i class="fas fa-coins"></i><span class="">Điểm nhà tuyển dụng</span>
        </a>

        <ul class="sub_list_item">
            <li>
                <a href="{{ route('list_transaction_coin_employer') }}" data-toggle="tooltip" data-placement="right"
                   title="Lịch sử giao dịch">
                    <i class="fas fa-history"></i><span class="">Lịch sử giao dịch</span>
                </a>
            </li>
            <li>
                <a href="{{ route('list_coin_employer_show_employee') }}" data-toggle="tooltip" data-placement="right"
                   title="Thông tin liên hệ ứng viên">
                    <i class="far fa-file"></i><span class="">Danh sách ứng viên đã xem </span>
                </a>
            </li>
            <li>
                <a href="{{ route('list_coin_employer_invitation_employee') }}" data-toggle="tooltip"
                   data-placement="right" title="Danh sách mời ứng viên">
                    <i class="far fa-file"></i><span class="">Danh sách ứng viên đã mời</span>
                </a>
            </li>
            <li>
                <a href="{{ route('list_coin_employees_invitation_job') }}" data-toggle="tooltip" data-placement="right"
                   title="Danh sách mời ứng viên">
                    <i class="far fa-file"></i><span class="">Mời ứng viên đồng loạt</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="">
        <a class="list_item_sidebar_title" data-toggle="tooltip" data-placement="right" title="Cổng thực tập">
            <i class="fas fa-user-graduate"></i><span class="">Cổng thực tập</span>
        </a>

        <ul class="sub_list_item">
            <li>
                <a href="{{ route('show_intership') }}" data-toggle="tooltip" data-placement="right"
                   title="Thông tin tuyển thực tập">
                    <i class="fas fa-info"></i><span class="">Thông tin tuyển thực tập</span>
                </a>
            </li>
            <li>
                <a href="{{ route('list_intership_employer') }}" data-toggle="tooltip" data-placement="right"
                   title="Hồ sơ thực tập">
                    <i class="far fa-file"></i><span class="">Hồ sơ thực tập</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="">
        <a class="list_item_sidebar_title" data-toggle="tooltip" data-placement="right" title="Dịch vụ đã đăng ký">
            <i class="far fa-file"></i><span class="">Dịch vụ đã đăng ký</span>
        </a>

        <ul class="sub_list_item">
            <li>
                <a href="{{ route('show_service_price') }}" data-toggle="tooltip" data-placement="right" title="Dịch vụ đã đăng ký">
                    <i class="far fa-file"></i><span class="">Dịch vụ đăng ky tuyển dụng</span>
                </a>
            </li>
            <li>
                <a href="{{ route('show_service_profile_job') }}" data-toggle="tooltip" data-placement="right" title="Dịch vụ đã đăng ký">
                    <i class="far fa-file"></i><span class="">Dịch vụ xem hồ sơ và đăng tin</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="">
        <a class="list_item_sidebar_title" data-toggle="tooltip" data-placement="right" title="Trắc nghiệm du lịch">
            <i class="fas fa-stream"></i><span class="">Trắc nghiệm du lịch</span>
        </a>

        <ul class="sub_list_item">
            <li>
                <a href="{{ route('showExam') }}" data-toggle="tooltip" data-placement="right" title="Đề thi của bạn">
                    <i class="far fa-question-circle"></i><span class="">Đề thi của bạn</span>
                </a>
            </li>
            <li>
                <a href="{{ route('showAllExam') }}" data-toggle="tooltip" data-placement="right"
                   title="Ngân hàng đề thi">
                    <i class="fas fa-university"></i><span class="">Ngân hàng đề thi </span>
                </a>
            </li>
            <li>
                <a href="{{ route('room.index') }}" data-toggle="tooltip" data-placement="right"
                   title="Danh sách phòng thi">
                    <i class="fab fa-chromecast"></i><span class="">Danh sách phòng thi </span>
                </a>
            </li>
            <li>
                <a href="{{ route('getAllRomResultExam') }}" data-toggle="tooltip" data-placement="right"
                   title="Kết quả phòng thi">
                    <i class="fas fa-crown"></i><span class="">Kết quả phòng thi </span>
                </a>
            </li>
        </ul>
    </li>

    <li class="">
        <a class=" list_item_sidebar_title" data-toggle="tooltip" data-placement="right" title="Thông tin tài khoản">
            <i class="fas fa-users"></i><span class="">Thông tin khác</span>
        </a>
        <ul class="sub_list_item">
            <li>
                <a href="{{route('show_user_job_facebook')}}" data-toggle="tooltip" data-placement="right"
                   title="Đổi mật khẩu">
                    <i class="fas fa-user-circle "></i><span class="">Đổi mật khẩu</span>
                </a>
            </li>
            <li>
                <a href="{{route('logoutHome')}}" data-toggle="tooltip" data-placement="right" title="Thoát tài khoản">
                    <i class="fas fa-sign-out-alt"></i><span class="">Thoát tài khoản</span></a>
            </li>
        </ul>
    </li>

</ul>


