<div class="row">
    <div class="col-md-4 ">
        <div class="accountThumbnail mgt10 mgb10">
            <?php
            $user = \Illuminate\Support\Facades\Auth::user();
            $id_user = $user->id;
            $role = $user->role;
            $static = $user->status_teacher_sc;
            $teacher_school = \App\Entity\Teacher_schools::getTeacher_id($id_user);
            ?>
            <img class="lazy pdl10"
                 src="{{!empty($teacher_school->teacher_images) ? $teacher_school->teacher_images : '/assets/image/no_avatar.jpg'}}"
                 alt="" width="100% ">
        </div>
    </div>
    <div class="col-md-8">
        <div class="accountInfo mgt10 mgb10">
            <h5 class="mgb0">
                {{ isset($teacher_school->teacher_sc_name) ? $teacher_school->teacher_sc_name : ''}}
            </h5>
            <p class="mgb0">
                <span class="clRed dsBlock mgt5 mgb5"><i>(Giáo viên)</i></span>
            </p>
        </div>
    </div>
</div>


<ul class="list_item_sidebar">
    <li>
        <a href="{{ route('management_account') }}">
            <i class="fas fa-users"></i><span>Thông tin tài khoản</span>
        </a>
    </li>

    <li class="">
        <a class="list_item_sidebar_title">
            <i class="fas fa-chalkboard-teacher"></i><span>Danh sách câu hỏi </span>
        </a>
        <?php
        $teacher_school = \App\Entity\Teacher_schools::getTeacher_id($id_user);
        ?>
        <ul class="sub_list_item">
            <li>
                <a href="{{ route('list_question_school_zero') }}">
                    <?php
                    $total_zero = 0;
                    $total_zero = \App\Exam\Questions_school::countQuestionSchool(0, $teacher_school->teacher_sc_id);
                    ?>
                    -- <span>Danh sách câu hỏi (dễ)</span> <sup class="clRed">({{ $total_zero }})
                    </sup>
                </a>
            </li>
            <li>
                <a href="{{ route('list_question_school_one') }}">
                    <?php
                    $total_one = 0;
                    $total_one = \App\Exam\Questions_school::countQuestionSchool(1, $teacher_school->teacher_sc_id);
                    ?>
                    -- <span>Danh sách câu hỏi (trung bình)</span> <sup class="clRed">({{ $total_one }})
                    </sup>
                </a>
            </li>
            <li>
                <a href="{{ route('list_question_school_two') }}">
                    <?php
                    $total_two = 0;
                    $total_two = \App\Exam\Questions_school::countQuestionSchool(2, $teacher_school->teacher_sc_id);
                    ?>
                    -- <span>Danh sách câu hỏi (khó)</span> <sup class="clRed">({{ $total_two }})
                    </sup>
                </a>
            </li>
            <li>
                <a href="{{ route('list_question_school_three') }}">
                    <?php
                    $total_three = 0;
                    $total_three = \App\Exam\Questions_school::countQuestionSchool(3, $teacher_school->teacher_sc_id);
                    ?>
                    -- <span>Danh sách câu hỏi (tự luận)</span> <sup class="clRed">({{ $total_three }})
                    </sup>
                </a>
            </li>
        </ul>
    </li>
    <li class="">
        <a class="list_item_sidebar_title">
            <i class="fas fa-chalkboard-teacher"></i><span>Phòng thi </span>
        </a>

        <ul class="sub_list_item">
            <li>
                <a href="{{ route('room_school.index') }}">
                    -- <span>Danh sách phòng thi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('list_student_room') }}">
                    -- <span>Danh sách sinh viên đang thi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('result_student_room') }}">
                    -- <span>Kết quả thi của phòng thi</span>
                </a>
            </li>

        </ul>
    </li>

    <li>

    <li>
        <a href="{{route('show_user_job_facebook')}}">
            <i class="fas fa-user-circle "></i><span>Đổi mật khẩu</span>
        </a>
    </li>

    <li>
        <a href="{{route('logoutHome')}}">
            <i class="fas fa-sign-out-alt"></i><span>Thoát tài khoản</span></a>
    </li>
    <li>
        <a href="{{route('noti_teacher')}}">
            <i class="far fa-bell"></i><span>Thông báo</span></a>
    </li>
</ul>