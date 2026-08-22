<div class="tab-content hover_show mgb20" id="nav-tabContent">
    <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="item">
            <ul class="d-menu pl-0">
                <li class=" ">
                    <a class="block d-orange clwhite pd8-20 ">
                        <i class="fas fa-chalkboard-teacher"></i></i><span>Giáo viên</span>
                    </a>
                    <a class="block clwhite pd8-20 d-bco">
                        <span class="text-dark p-2"><i class="fas fa-chalkboard-teacher"></i>Giáo viên</span>
                        <i class="fas fa-chevron-left custom_chevron py-2 d-expand {{ (request()->is('staff/staff_teacher*')) ? 'd-show' : '' }}"></i>
                    </a>
                    <ul class="pl-0" style="font-size: 17px;">
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('staff_teacher.index') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_teacher.index')) ? 'activeTHS' : '' }}">
                                <i class="far fa-circle "></i><span>Danh sách giáo viên
                                </span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('getListTeacher_not_interactive') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('getListTeacher_not_interactive')) ? 'activeTHS' : '' }}">
                                <i class="far fa-circle "></i><span>DS GV chưa tương tác
                                </span>
                            </a>
                        </li>
                        {{-- <li class="hvbgrBlueN"d-hvbgrBlueN >
                            <a href="{{ route('staff_teacher.create') }}" class="hvWhite pd8-20 p-2 d-block {{ Request::is('staff/teacher/create') ? 'activeTHS' : '' }}">
                                <i class="far fa-circle "></i><span>Thêm mới giáo viên</span>
                            </a>
                        </li> --}}
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('staff_teacher_statistical') }}" class="hvWhite pd8-20 p-2 d-block  {{ (url()->current() == route('staff_teacher_statistical')) ? 'activeTHS' : '' }}">
                                <i class="far fa-circle "></i><span>Thống kê GV 63 tỉnh</span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('staff_teacher_list_deleted') }}" class="hvWhite pd8-20 p-2 d-block {{ (request()->is('staff/staff_teacher/list-deleted')) ? 'activeTHS' : '' }}">
                                <i class="far fa-circle "></i><span>DS giáo viên đã
                                    xóa</span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a id="result" href="{{ route('staff_teacher_report_teacher') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_teacher_report_teacher')) ? 'activeTHS' : '' }}">
                                <i class="far fa-circle "></i><span>Báo cáo DS giáo viên</span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a id="result" href="{{ route('list_interactive') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('list_interactive')) ? 'activeTHS' : '' }}">
                                <i class="far fa-circle "></i><span>Danh sách NV tt</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
