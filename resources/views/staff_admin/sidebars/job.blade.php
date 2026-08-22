
    <div class="tab-content hover_show mgb20" id="nav-tabContent">
        <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="item">
                <ul class="d-menu pl-0">

                    <li class=" " style="font-size: 17px;">
                        <a class="block d-orange clwhite pd8-20 ">
                            <i class="far fa-newspaper "></i><span>Tin tuyển dụng</span>
                        </a>
                        <ul class="pl-0">
                            <li class="not-padding">
                                <a class="block clwhite pd8-20 d-bco">
                                    <span class="text-dark p-2"><i class="fas fa-user-md"></i>Việc làm NTD</span>
                                    <i class="fas fa-chevron-left custom_chevron py-2 d-expand {{ (request()->is('staff/staff_job-ntd')) ? 'd-show' : '' }}"></i>
                                </a>
                                <ul class="pl-0">
                                    {{-- <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href="{{ route('staff_job-ntd.create') }}" class="hvWhite pd8-20 p-2 d-block ">
                                            <i class="far fa-circle "></i><span>Thêm mới việc làm</span>
                                        </a>
                                    </li> --}}
                                    <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href="{{ route('staff_job-ntd.index') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_job-ntd.index')) ? 'activeTHS' : '' }}">
                                            <i class="far fa-circle"></i>
                                            @if($job_not_active > 0)
                                            <span class="text-danger">Tất cả việc làm( {{$job_not_active}} )</span>
                                            @else
                                            <span>Tất cả việc làm</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href="{{ route('staff_job_ntd_job_vip') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_job_ntd_job_vip')) ? 'activeTHS' : '' }}">
                                            <i class="far fa-circle"></i>
                                            @if(isset($job_vip_not_active) && $job_vip_not_active > 0)
                                            <span class="text-danger">Tin Vip( {{$job_vip_not_active}} )</span>
                                            @else
                                            <span>Tin Vip</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href="{{ route('staff_job_ntd_job_casual') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_job_ntd_job_casual')) ? 'activeTHS' : '' }}">
                                            <i class="far fa-circle"></i>
                                            @if(isset($job_cas_not_active) && $job_cas_not_active > 0)
                                            <span class="text-danger">Tin thường( {{$job_cas_not_active}} )</span>
                                            @else
                                            <span>Tin thường</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href="{{ route('staff_job_ntd_list_date_end') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_job_ntd_list_date_end')) ? 'activeTHS' : '' }}">
                                            <i class="far fa-circle"></i><span>Tin hết hạn</span>
                                        </a>
                                    </li>
                                    <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href="{{ route('job_ntd_deleted') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('job_ntd_deleted')) ? 'activeTHS' : '' }}">
                                            <i class="far fa-circle"></i><span>Tin đã xóa</span>
                                        </a>
                                    </li>
                                    <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href="{{ route('employer_job_list') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('employer_job_list')) ? 'activeTHS' : '' }}">
                                            <i class="far fa-circle"></i><span>Báo cáo việc làm NTD</span>
                                        </a>
                                    </li>
                                    <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href="{{ route('employee_submit_job_ntd') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('employee_submit_job_ntd')) ? 'activeTHS' : '' }}">
                                            <i class="far fa-circle"></i><span>Ứng viên nộp hồ sơ NTD</span>
                                        </a>
                                    </li>
                                    <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href="{{ route('employee_submit_apply_job') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('employee_submit_apply_job')) ? 'activeTHS' : '' }}">
                                            <?php
                                            $total_cv = \App\Entity\Employee_submit_job_faacebook::check_apply_cv();
                                            ?>
                                            <i class="far fa-circle"></i><span>Ứng viên nộp CV (ứng tuyển nhanh) <span class="text-danger">({{ $total_cv }})</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="not-padding">
                                <a class="block clwhite pd8-20 d-bco">
                                    <span class="text-dark p-2"><i class="fab fa-facebook-square"></i>Việc làm Facebook</span>
                                    <i class="fas fa-chevron-left custom_chevron py-2 d-expand  {{ (request()->is('staff/staff_job-facebook')) ? 'd-show' : '' }}"></i>
                                </a>
                                <ul class="pl-0">
                                    {{-- <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href="{{ route('staff_job-facebook.create') }}" class="hvWhite pd8-20 p-2 d-block ">
                                            <i class="far fa-circle "></i><span>Thêm mới việc làm</span>
                                        </a>
                                    </li> --}}
                                    <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href="{{ route('staff_job-facebook.index') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_job-facebook.index')) ? 'activeTHS' : '' }}">
                                            <i class="far fa-circle "></i><span>Tất cả việc làm</span>
                                        </a>
                                    </li>
                                    {{-- <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href=" " class="hvWhite pd8-20 p-2 d-block  ">
                                            <i class="far fa-circle "></i><span>Tất cả việc làm đã
                                                xóa</span>
                                        </a>
                                    </li> --}}
                                    <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href="{{ route('staff_job_facebook_total_user_facebook') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_job_facebook_total_user_facebook')) ? 'activeTHS' : '' }}">
                                            <i class="far fa-circle "></i><span>Tổng hợp User đăng
                                                tin</span>
                                        </a>
                                    </li>
                                    <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href="{{ route('staff_job_facebook_deleted') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_job_facebook_deleted')) ? 'activeTHS' : '' }}">
                                            <i class="far fa-circle "></i><span>Tin đã xóa</span>
                                        </a>
                                    </li>
                                    <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href="{{ route('bao_cao_thong_ke_jobfb') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('bao_cao_thong_ke_jobfb')) ? 'activeTHS' : '' }}">
                                            <i class="far fa-circle "></i><span>Báo cáo thống kê</span>
                                        </a>
                                    </li>
                                    <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                        <a href="{{ route('employee_submit_job_fb') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('employee_submit_job_fb')) ? 'activeTHS' : '' }}">
                                            <i class="far fa-circle"></i><span>Ứng viên nộp hồ sơ Facebook</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </div>

