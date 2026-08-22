<ul class="ul-span">
    <li class="hvbgrBlueN">
        <a href="{{ route('management_account') }}" class="block hvWhite pd8-20">
            <i class="fas fa-users"></i><span>Thông tin tài khoản</span>
        </a>
    </li>

    <li class="">
        <a class="block bggreen clwhite pd8-20">
            <i class="fas fa-chalkboard-teacher"></i><span>Danh sách câu hỏi </span>
        </a>
        <?php
        $id_user = $user->id;
        $teacher_school = \App\Entity\Teacher_schools::getTeacher_id($id_user);
        ?>
        <ul class="pdf20">
            <li class="hvbgrBlueN ">
                <a href="{{ route('list_question_school_zero') }}" class="block hvWhite pd8-20">
                    <?php
                    $total_zero = 0;
                    $total_zero = \App\Exam\Questions_school::countQuestionSchool(0,$teacher_school->teacher_sc_id);
                    ?>
                    -- <span>Danh sách câu hỏi (dễ)</span> <sup class="clred">({{ $total_zero }})
                        </sup>
                </a>
            </li> <li class="hvbgrBlueN ">
                <a href="{{ route('list_question_school_one') }}" class="block hvWhite pd8-20">
                    <?php
                    $total_one = 0;
                    $total_one = \App\Exam\Questions_school::countQuestionSchool(1,$teacher_school->teacher_sc_id);
                    ?>
                    -- <span>Danh sách câu hỏi (trung bình)</span> <sup class="clred">({{ $total_one }})
                        </sup>
                </a>
            </li> <li class="hvbgrBlueN ">
                <a href="{{ route('list_question_school_two') }}" class="block hvWhite pd8-20">
                    <?php
                    $total_two = 0;
                    $total_two = \App\Exam\Questions_school::countQuestionSchool(2,$teacher_school->teacher_sc_id);
                    ?>
                    -- <span>Danh sách câu hỏi (khó)</span> <sup class="clred">({{ $total_two }})
                        </sup>
                </a>
            </li> <li class="hvbgrBlueN ">
                <a href="{{ route('list_question_school_three') }}" class="block hvWhite pd8-20">
                    <?php
                    $total_three = 0;
                    $total_three = \App\Exam\Questions_school::countQuestionSchool(3,$teacher_school->teacher_sc_id);
                    ?>
                    -- <span>Danh sách câu hỏi (tự luận)</span> <sup class="clred">({{ $total_three }})
                        </sup>
                </a>
            </li>
        </ul>
    </li>
    <li class="">
        <a class="block bggreen clwhite pd8-20">
            <i class="fas fa-chalkboard-teacher"></i><span>Phòng thi </span>
        </a>

        <ul class="pdf20">
            <li class="hvbgrBlueN ">
                <a href="{{ route('room_school.index') }}" class="block hvWhite pd8-20">
                    -- <span>Danh sách phòng thi</span>
                </a>
            </li>
            <li class="hvbgrBlueN ">
                <a href="{{ route('list_student_room') }}" class="block hvWhite pd8-20">
                    -- <span>Danh sách sinh viên đang thi</span>
                </a>
            </li>
            <li class="hvbgrBlueN ">
                <a href="{{ route('result_student_room') }}" class="block hvWhite pd8-20">
                    -- <span>Kết quả thi của phòng thi</span>
                </a>
            </li>

        </ul>
    </li>

    <li class="hvbgrBlueN">
       
    <li class="hvbgrBlueN">
        <a href="{{route('show_user_job_facebook')}}" class="block hvWhite pd8-20">
            <i class="fas fa-user-circle "></i><span>Đổi mật khẩu</span>
        </a>
    </li>

    <li class="hvbgrBlueN">
        <a href="{{route('logoutHome')}}" class="block hvWhite pd8-20">
            <i class="fas fa-sign-out-alt"></i><span>Thoát tài khoản</span></a>
    </li>
    <li class="hvbgrBlueN">
        <a href="{{route('noti_teacher')}}" class="block hvWhite pd8-20">
            <i class="far fa-bell"></i><span>Thông báo</span></a>
    </li>
</ul>