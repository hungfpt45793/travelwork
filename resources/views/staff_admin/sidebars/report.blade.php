<div class="tab-content hover_show mgb20" id="nav-tabContent">
    <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="item">
            <ul class="d-menu pl-0">
                <li class="" style="font-size: 17px;">
                    <a class="block clwhite pd8-20 d-bco">
                    <span class="text-dark p-2"><i class=" far fa-address-card "></i>Tình hình UV nộp hồ sơ</span>
                        <i class="fas fa-chevron-left custom_chevron py-2 d-expand"></i>
                    </a>
                    <ul class="pl-0">
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('candidates_register_course') }}" class="hvWhite pd8-20 p-2 d-block
                            {{ (url()->current() == route('candidates_register_course') ) ? 'activeTHS' : '' }} ">
                                <i class="far fa-circle "></i><span>Báo cáo tổng hợp UV đăng ký khóa học
                                </span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('candidates_apply_for_jobs') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('candidates_apply_for_jobs')) ? 'activeTHS' : '' }}">
                                <i class="far fa-circle"></i><span>Tổng hợp UV nộp hồ sơ ứng tuyển NTD</span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('candidates_apply_for_jobs_fb') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('candidates_apply_for_jobs_fb')) ? 'activeTHS' : '' }}">
                                <i class="far fa-circle"></i><span>Tổng hợp UV nộp hồ sơ ứng tuyển FB</span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a id="result" href="{{ route('staff_employee_submit_job') }}" class="hvWhite p-2 d-block {{ (url()->current() == route('staff_employee_submit_job')) ? 'activeTHS' : '' }}">
                                <i class="far fa-circle "></i><span>Số lượng ứng viên nộp hồ sơ</span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a id="result" href="{{ route('application_details_ntd') }}" class="hvWhite p-2 d-block {{ (url()->current() == route('application_details_ntd')) ? 'activeTHS' : '' }}">
                                <i class="far fa-circle "></i><span>Chi tiết ứng viên nộp hồ sơ NTD</span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a id="result" href="{{ route('application_details_fb') }}" class="hvWhite p-2 d-block {{ (url()->current() == route('application_details_fb')) ? 'activeTHS' : '' }}">
                                <i class="far fa-circle "></i><span>Chi tiết ứng viên nộp hồ sơ FB</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
