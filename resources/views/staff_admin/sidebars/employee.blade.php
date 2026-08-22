    <div class="tab-content mgb20 hover_show" id="nav-tabContent">
        <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="item">
                <ul class="d-menu pl-0">
                        <!-- <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('employee0To20') }}" class="hvWhite p-2 d-block
                            {{ (url()->current() == route('employee0To20') ) ? 'activeTHS' : '' }} ">
                                <i class="far fa-circle "></i><span>DSUV( 0% <i class="fas fa-long-arrow-alt-right"></i>20%,
                                <span class="text-danger">
                                    <?php
                                    $total = 0;
                                    $total = \App\Entity\Employee::getTotal0To20();
                                    echo $total;
                                    ?> Chưa duyệt
                                </span>)
                                </span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('employee20To40') }}" class="hvWhite p-2 d-block
                            {{ (url()->current() == route('employee20To40') ) ? 'activeTHS' : '' }} ">
                            <i class="far fa-circle "></i><span>DSUV(20%<i class="fas fa-long-arrow-alt-right"></i>40%,
                                <span class="text-danger">
                                    <?php
                                    $total = 0;
                                    $total = \App\Entity\Employee::getTotal20To40();
                                    echo $total;
                                    ?> Chưa duyệt
                                </span>)
                                </span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('employee40To60') }}" class="hvWhite p-2 d-block
                            {{ (url()->current() == route('employee40To60') ) ? 'activeTHS' : '' }} ">
                            <i class="far fa-circle "></i><span>DSUV(40% <i class="fas fa-long-arrow-alt-right"></i>60%,
                                <span class="text-danger">
                                    <?php
                                    $total = 0;
                                    $total = \App\Entity\Employee::getTotal40To60();
                                    echo $total;
                                    ?> Chưa duyệt
                                </span>)
                                </span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('employee60ToMax') }}" class="hvWhite p-2 d-block
                            {{ (url()->current() == route('employee60ToMax') ) ? 'activeTHS' : '' }} ">
                                <i class="far fa-circle "></i><span>DSUV(60% trở lên,
                                <span class="text-danger">
                                    <?php
                                    $total = 0;
                                    $total = \App\Entity\Employee::getTotal60ToMax();
                                    echo $total;
                                    ?> Chưa duyệt
                                </span>)
                                </span>
                            </a>
                        </li> -->
                    <li class=" " style="font-size: 17px;">
                        <a class="block d-orange clwhite pd8-20 ">
                            <i class="far fa-file-alt "></i><span>Danh sách UV</span>
                        </a>
                        <a class="block clwhite pd8-20 d-bco">
                        <span class="text-dark p-2"><i class=" far fa-file-alt "></i>Danh sách UV</span>
                            <i class="fas fa-chevron-left custom_chevron py-2 d-expand d-show"></i>
                        </a>
                        <ul class="pl-0">
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_employee.index') }}" class="hvWhite p-2 d-block
                                {{ (url()->current() == route('staff_employee.index') ) ? 'activeTHS' : '' }} ">
                                    <i class="far fa-circle "></i><span>DS ứng viên(
                                    <span>
                                        <?php
                                        $total = 0;
                                        $total = \App\Entity\Employee::getTotalEmployee();
                                        echo $total;
                                        ?>
                                    </span> )
                                    </span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('list_employee_approved') }}" class="hvWhite p-2 fs d-block
                                {{ (url()->current() == route('list_employee_approved') ) ? 'activeTHS' : '' }} ">
                                    <i class="far fa-circle "></i><span>DS ứng viên đã duyệt(
                                    <span>
                                        <?php
                                        $total = 0;
                                        $total = \App\Entity\Employee::getTotalEmployeeApproved();
                                        echo $total;
                                        ?>
                                    </span> )
                                    </span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('list_employee_no_approved') }}" class="hvWhite p-2 d-block
                                {{ (url()->current() == route('list_employee_no_approved') ) ? 'activeTHS' : '' }} ">
                                    <i class="far fa-circle "></i><span>DS ứng viên chưa duyệt(
                                    <span>
                                        <?php
                                        $total = 0;
                                        $total = \App\Entity\Employee::getTotalEmployeeNoApproved();
                                        echo $total;
                                        ?>
                                    </span> )
                                    </span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_employee_statistics') }}" class="hvWhite p-2 d-block {{ (url()->current() == route('staff_employee_statistics') ) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Thống kê ứng viên </span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_employee_statistical') }}" class="hvWhite p-2 d-block  {{ (url()->current() == route('staff_employee_statistical')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Thống kê ứng viên 63 tỉnh</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a id="result" href="{{ route('staff_employee_report_employee') }}" class="hvWhite p-2 d-block {{ (url()->current() == route('staff_employee_report_employee')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Báo cáo DS ứng viên</span>
                                </a>
                            </li>

                            <!--{{--<li class="hvbgrBlueN d-hvbgrBlueN pl-0">--}}
                                {{--<a id="result" href="{{ route('staff_employee_no_convert_cv') }}" class="hvWhite p-2 d-block {{ (url()->current() == route('staff_employee_report_employee')) ? 'activeTHS' : '' }}">--}}
                                    {{--<i class="far fa-circle "></i><span>DS ứng viên chua convert CV</span>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            -->
                        </ul>
                    </li>
                    <li class=" " style="font-size: 17px;">
                        <a class="block d-orange clwhite pd8-20 ">
                            <i class="far fa-file-alt "></i><span>Báo cáo</span>
                        </a>
                        <a class="block clwhite pd8-20 d-bco">
                        <span class="text-dark p-2"><i class=" far fa-file-alt "></i>Báo cáo</span>
                            <i class="fas fa-chevron-left custom_chevron py-2 d-expand"></i>
                        </a>
                        <ul class="pl-0">
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a id="result" href="{{ route('list_employee_follow') }}" class="hvWhite p-2 d-block {{ (url()->current() == route('list_employee_follow')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>DS ứng viên theo dõi</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a id="result" href="{{ route('staff_employee_list_deleted') }}" class="hvWhite p-2 d-block {{ (url()->current() == route('staff_employee_list_deleted')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>DS ứng viên đã xóa</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a id="result" href="{{ route('interactive_employee_all') }}" class="hvWhite p-2 d-block {{ (url()->current() == route('interactive_employee_all')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>DS tất cả tương tác</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a id="result" href="{{ route('interactive_employee') }}" class="hvWhite p-2 d-block {{ (url()->current() == route('interactive_employee')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>DS tương tác của {{ Auth::user()->name }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=" " style="font-size: 17px;">
                        <a class="block d-orange clwhite pd8-20 ">
                            <i class="far fa-file-alt "></i><span>Giao việc</span>
                        </a>
                        <a class="block clwhite pd8-20 d-bco">
                        <span class="text-dark p-2"><i class=" far fa-file-alt "></i>Giao việc</span>
                            <i class="fas fa-chevron-left custom_chevron py-2 d-expand d-show"></i>
                        </a>
                        <ul class="pl-0">
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a id="result" href="{{ route('employee_no_task') }}" class="block hvWhite p-2 d-block {{ (url()->current() == route('employee_no_task')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>DS ứng viên chưa giao</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a id="result" href="{{ route('employee_task') }}" class="block hvWhite p-2 d-block {{ (url()->current() == route('employee_task')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>DS ứng viên đã giao</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a id="result" href="{{ route('employee_assigned') }}" class="block hvWhite p-2 d-block {{ (url()->current() == route('employee_assigned')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>DS ứng viên được giao</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a id="result" href="{{ route('assignment_list') }}" class="hvWhite p-2 d-block {{ (url()->current() == route('assignment_list')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Báo cáo giao việc</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a id="result" href="{{ route('daily_task_list') }}" class="hvWhite p-2 d-block {{ (url()->current() == route('daily_task_list')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Báo cáo giao việc theo ngày</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a id="result" href="{{ route('general_task') }}" class="block hvWhite p-2 d-block {{ (url()->current() == route('general_task')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Tổng hợp giao việc</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a id="result" href="{{ route('assignment_results') }}" class="block hvWhite p-2 d-block {{ (url()->current() == route('assignment_results')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Tổng hợp kết quả giao việc</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

