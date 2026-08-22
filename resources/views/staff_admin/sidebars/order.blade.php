
    <div class="tab-content hover_show mgb20" id="nav-tabContent">
        <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="item">
                <ul class="d-menu pl-0" style="font-size: 17px;">
                    <li class="">
                        <a class="block d-orange clwhite pd8-20">
                            <i class="far fa-address-card"></i><span>Danh sách đơn hàng</span>
                        </a>
                        <a class="block clwhite pd8-20 d-bco">
                        @if(isset($un_order_interactive1) && $un_order_interactive1 > 0)
                            <span class="text-danger p-2"><i class=" far fa-address-card "></i>Danh sách đơn hàng( {{$un_order_interactive1}} )</span>
                        @else
                            <span class="text-dark p-2"><i class=" far fa-address-card "></i>Danh sách đơn hàng</span>
                        @endif
                            <i class="fas fa-chevron-left custom_chevron py-2 d-expand {{ (request()->is('staff/staff_service_order*')) ? 'd-show' : '' }}"></i>
                        </a>
                        <ul class="pl-0">
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_service_order.index') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_service_order.index') ) ? 'activeTHS' : '' }} ">
                                    <i class="far fa-circle "></i><span>Danh sách đơn hàng
                                    </span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_service_order_status1') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_service_order_status1') ) ? 'activeTHS' : '' }} ">
                                    <i class="far fa-circle "></i><span>Danh sách đơn hàng đã thanh toán
                                    </span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('general_order') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('general_order') ) ? 'activeTHS' : '' }} ">
                                    <i class="far fa-circle "></i><span>Danh sách order tổng
                                    </span>
                                </a>
                            </li>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('delete_order') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('delete_order') ) ? 'activeTHS' : '' }} ">
                                    <i class="far fa-circle "></i><span>Danh sách đơn hàng xóa
                                    </span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('list_employer_to_add_service_order_in_staff') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('list_employer_to_add_service_order_in_staff') ) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Danh sách NTD</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="">
                        <a class="block d-orange clwhite pd8-20">
                            <i class="far fa-address-card"></i><span>Danh sách đơn đặt</span>
                        </a>
                        <a class="block clwhite pd8-20 d-bco">
                            @if(isset($un_order_interactive2) && $un_order_interactive2 > 0)
                                <span class="text-danger p-2"><i class=" far fa-address-card "></i>Đơn đặt tuyển dụng( {{$un_order_interactive2}} )</span>
                            @else
                                <span  class="text-dark p-2"><i class=" far fa-address-card "></i>Đơn đặt tuyển dụng</span>
                            @endif
                            <i class="fas fa-chevron-left custom_chevron py-2 d-expand {{ (request()->is('staff/staff_hunter_order*')) ? 'd-show' : '' }}"></i>
                        </a>
                        <ul class="pl-0">
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_hunter_order.index') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_hunter_order.index') ) ? 'activeTHS' : '' }} ">
                                    <i class="far fa-circle "></i><span>DS đơn đặt tuyển dụng({{$total_hunter_regis}})
                                    </span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_order_request.index') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_order_request.index') ) ? 'activeTHS' : '' }} ">
                                    <i class="far fa-circle "></i><span>DS yêu cầu thực hiện ĐH({{$total_order_request}})
                                    </span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_order_job.index') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_order_job.index') ) ? 'activeTHS' : '' }} ">
                                    <i class="far fa-circle "></i><span>DS đơn hàng({{$total_order_job}})
                                    </span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('list_employer_to_add_hunter_order_in_staff') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('list_employer_to_add_hunter_order_in_staff') ) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Danh sách NTD</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('request_orders_deleted') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('request_orders_deleted') ) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Yêu cầu DH đã xóa</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_order_job_deleted') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_order_job_deleted') ) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Đơn hàng đã xóa</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="">
                        <a class="block clwhite pd8-20 d-bco">
                            <span class="text-dark p-2"><i class=" far fa-address-card "></i>Đăng kí tư vấn</span>
                            <i class="fas fa-chevron-left custom_chevron py-2 d-expand {{ (request()->is('staff/staff_advisory*')) ? 'd-show' : '' }}"></i>
                        </a>
                        <ul class="pl-0">
                            <!-- <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_advisory_contact.index') }}" class="hvWhite pd8-20 p-2 d-block {{ (request()->is('staff/staff_advisory_contact*')) ? 'activeTHS' : '' }} ">
                                    <i class="far fa-circle "></i><span>Danh sách liên hệ
                                    </span>
                                </a>
                            </li> -->
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_advisory_employer.index') }}" class="hvWhite pd8-20 p-2 d-block {{ (request()->is('staff/staff_advisory_employer*')) ? 'activeTHS' : '' }}">
                                @if(isset($ntd_dk_untt) && $ntd_dk_untt > 0)
                                    <i class="far fa-circle text-danger"></i><span class="text-danger">NTD đăng kí tư vấn( {{$ntd_dk_untt}} )</span>
                                @else
                                    <i class="far fa-circle"></i><span>NTD đăng kí tư vấn</span>
                                @endif
                                </a>

                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_advisory_employee.index') }}" class="hvWhite pd8-20 p-2 d-block {{ (request()->is('staff/staff_advisory_employee*')) ? 'activeTHS' : '' }}">

                                    @if(isset($uv_dk_untt) && $uv_dk_untt > 0)
                                        <i class="far fa-circle"></i><span>Ứng viên đăng kí tư vấn( {{$uv_dk_untt}} )</span>
                                    @else
                                        <i class="far fa-circle"></i><span>Ứng viên đăng kí tư vấn</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

