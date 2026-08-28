<div class="row">
    <div class="col-md-4 ">
        <div class="accountThumbnail mgt10 mgb10">
            <?php
            $user = \Illuminate\Support\Facades\Auth::user();
            $id_user = $user->id;
            $role = $user->role;
            $static = $user->status_teacher_sc;
            $teacher = \App\Entity\Teacher::getTeacher_id($id_user)
            ?>
            <img class="lazy pdl10"
                 src="{{!empty($teacher->teacher_images) ? $teacher->teacher_images : '/assets/image/no_avatar.jpg'}}"
                 alt="" width="100% ">

        </div>
    </div>
    <div class="col-md-8">
        <div class="accountInfo mgt10 mgb10">
            <h5 class="mgb0">
                {{ isset($teacher->teacher_name) ? $teacher->teacher_name : ''}}
            </h5>
            <p class="mgb0">
                <span class="clRed dsBlock mgt5 mgb5"><i>(Giáo viên)</i></span>
            </p>
        </div>
    </div>
</div>


<ul class="list_item_sidebar">
    <li>
        <a href="{{ route('management_account') }}" data-toggle="tooltip" data-placement="right"
           title="Thông tin tài khoản">
            <i class="fas fa-users"></i><span> Thông tin tài khoản</span>
        </a>
    </li>
    <li>
        <a href="#" data-toggle="tooltip" data-placement="right" title="Khóa học">
            <i class="fab fa-discourse"></i><span> Quản lý khóa học</span>
        </a>

        <ul class="sd_submenu2">
            <a href="{{ route('list_teacher_courses') }}">
                <li>
                    <i class="fab fa-discourse white f16"> </i>
                    <span>Quản lý khóa học</span>
                </li>
            </a>
            <a href="{{ route('list_teacher_question') }}">
                <li>
                    <i class="fas fa-question white f16"> </i>
                    <span>
                        Câu hỏi của khóa học
                    </span>
                </li>
            </a>
            <a href="{{ route('list_static_courses') }}">
                <li>
                    <i class="fas fa-dollar-sign  white f16"> </i>
                    <span>
                        Doanh thu của khóa học
                    </span>
                </li>
            </a>
            <a href="{{ route('list_teacher_exam') }}">
                <li>
                    <i class="far fa-question-circle white f16"></i>
                    <span>
                       Đề thi của khóa học
                    </span>
                </li>
            </a>



        </ul>
    </li>
    <li>
        <a href="{{ route('show_file_job_facebook') }}" data-toggle="tooltip" data-placement="right"
           title="Quản lý hồ sơ">
            <i class="fas fa-id-card "></i><span>Quản lý hồ sơ</span>
        </a>
    </li>
    <li>
        <a href="{{ route('showExam') }}" data-toggle="tooltip" data-placement="right" title="Đề thi của bạn">
            <i class="far fa-question-circle"></i><span>Đề thi của bạn</span>
        </a>
    </li>
    <li>
        <a href="{{ route('showAllExam') }}" data-toggle="tooltip" data-placement="right" title="Ngân hàng đề thi">
            <i class="fas fa-university"></i><span>Ngân hàng đề thi </span>
        </a>
    </li>
    <li>
        <a href="{{ route('room.index') }}" data-toggle="tooltip" data-placement="right" title="Danh sách phòng thi">
            <i class="fab fa-chromecast"></i><span>Danh sách phòng thi </span>
        </a>
    </li>
    <li>
        <a href="{{ route('getAllRomResultExam') }}" data-toggle="tooltip" data-placement="right"
           title="Kết quả phòng thi">
            <i class="fas fa-crown"></i><span>Kết quả phòng thi </span>
        </a>
    </li>
    <li>
        <a href="{{ route('teacher_learn_employee') }}" data-toggle="tooltip" data-placement="right"
           title="Ứng viên đăng ký khóa học">
            <i class="fas fa-chalkboard-teacher"></i><span>Ứng viên đăng ký khóa học</span>
        </a>
    </li>
    <li>
        <a href="{{route('show_user_job_facebook')}}" data-toggle="tooltip" data-placement="right" title="Đổi mật khẩu">
            <i class="fas fa-user-circle "></i><span>Đổi mật khẩu</span>
        </a>
    </li>

    <li>
        <a href="{{route('logoutHome')}}" data-toggle="tooltip" data-placement="right" title="Thoát tài khoản">
            <i class="fas fa-sign-out-alt"></i><span>Thoát tài khoản</span></a>
    </li>
    <li>
        <a href="{{route('noti_teacher')}}" data-toggle="tooltip" data-placement="right" title="Thông báo">
            <i class="far fa-bell"></i><span>Thông báo</span></a>
    </li>
</ul>