<ul class="ul-span">
    <li class="hvbgrBlueN">
        <a href="{{ route('management_account') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Thông tin tài khoản">
            <i class="fas fa-users"></i><span>Thông tin tài khoản</span>
        </a>
    </li>
    <li class="hvbgrBlueN">
        <a href="{{ route('show_file_job_facebook') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Quản lý hồ sơ">
            <i class="fas fa-id-card "></i><span>Quản lý hồ sơ</span>
        </a>
    </li>
    <li class="hvbgrBlueN">
        <a href="{{ route('showExam') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Đề thi của bạn">
            <i class="far fa-question-circle"></i><span>Đề thi của bạn</span>
        </a>
    </li>
    <li class="hvbgrBlueN">
        <a href="{{ route('showAllExam') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Ngân hàng đề thi">
            <i class="fas fa-university"></i><span>Ngân hàng đề thi </span>
        </a>
    </li>
    <li class="hvbgrBlueN">
        <a href="{{ route('room.index') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Danh sách phòng thi">
            <i class="fab fa-chromecast"></i><span>Danh sách phòng thi </span>
        </a>
    </li>
    <li class="hvbgrBlueN">
        <a href="{{ route('getAllRomResultExam') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Kết quả phòng thi">
            <i class="fas fa-crown"></i><span>Kết quả phòng thi </span>
        </a>
    </li>




    <li class="hvbgrBlueN">
        <a href="{{ route('teacher_learn_employee') }}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Ứng viên đăng ký khóa học">
            <i class="fas fa-chalkboard-teacher"></i><span>Ứng viên đăng ký khóa học</span>
        </a>
    </li>


{{--    <li class="hvbgrBlueN">--}}
{{--        <a href="{{ route('list_advise_user') }}" class="block hvWhite pd8-20" data-toggle="tooltip"--}}
{{--           data-placement="right" title="Kế toán cần tư vấn">--}}
{{--            <i class="fas fa-users fw6"></i><span class="">Danh sách kế toán kết nối (Gia sư)</span>--}}
{{--        </a>--}}
{{--    </li>--}}


    <li class="hvbgrBlueN">
        <a href="{{route('show_user_job_facebook')}}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Đổi mật khẩu">
            <i class="fas fa-user-circle "></i><span>Đổi mật khẩu</span>
        </a>
    </li>

    <li class="hvbgrBlueN">
        <a href="{{route('logoutHome')}}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Thoát tài khoản">
            <i class="fas fa-sign-out-alt"></i><span>Thoát tài khoản</span></a>
    </li>
    <li class="hvbgrBlueN">
        <a href="{{route('noti_teacher')}}" class="block hvWhite pd8-20" data-toggle="tooltip" data-placement="right" title="Thông báo">
            <i class="far fa-bell"></i><span>Thông báo</span></a>
    </li>
</ul>
