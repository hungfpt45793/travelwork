<div class="tab-content hover_show mgb20" id="nav-tabContent">
    <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="item">
            <ul class="d-menu pl-0">
                <li class="" style="font-size: 17px;">
                    <a class="block d-orange clwhite pd8-20">
                    <i class="fas fa-envelope"></i><span>Khóa học</span>
                    </a>
                    <a class="block clwhite pd8-20 d-bco">
                    <span class="text-dark p-2"><i class=" far fa-address-card "></i>Khóa học</span>
                        <i class="fas fa-chevron-left custom_chevron py-2 d-expand {{ (request()->is('staff/staff_employee*')) ? 'd-show' : '' }}"></i>
                    </a>
                    <ul class="pl-0">
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('categoryCourse.index') }}" class="hvWhite pd8-20 p-2 d-block
                            {{ (url()->current() == route('categoryCourse.index') ) ? 'activeTHS' : '' }} ">
                                <i class="far fa-circle "></i><span>Danh sách danh mục
                                </span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('coursesStaff.index') }}" class="hvWhite pd8-20 p-2 d-block
                            {{ (url()->current() == route('coursesStaff.index') ) ? 'activeTHS' : '' }} ">
                                <i class="far fa-circle "></i><span>Danh sách khóa học
                                </span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('courseTag.index') }}" class="hvWhite pd8-20 p-2 d-block
                            {{ (url()->current() == route('courseTag.index') ) ? 'activeTHS' : '' }} ">
                                <i class="far fa-circle "></i><span>Từ khóa khóa học
                                </span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('courseFormality.index') }}" class="hvWhite pd8-20 p-2 d-block
                            {{ (url()->current() == route('courseFormality.index') ) ? 'activeTHS' : '' }} ">
                                <i class="far fa-circle "></i><span>Danh sách hình thức học
                                </span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('educateCategories.index') }}" class="hvWhite pd8-20 p-2 d-block
                            {{ (url()->current() == route('educateCategories.index') ) ? 'activeTHS' : '' }} ">
                                <i class="far fa-circle "></i><span>Chuyên mục đào tạo
                                </span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('educateClass.index') }}" class="hvWhite pd8-20 p-2 d-block
                            {{ (url()->current() == route('educateClass.index') ) ? 'activeTHS' : '' }} ">
                                <i class="far fa-circle "></i><span>Lớp đào tạo
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="" style="font-size: 17px;">
                    <a class="block d-orange clwhite pd8-20">
                    <i class="fas fa-envelope"></i><span>Đơn hàng khóa học</span>
                    </a>
                    <a class="block clwhite pd8-20 d-bco">
                    <span class="text-dark p-2"><i class=" far fa-address-card "></i>Đơn hàng khóa học</span>
                        <i class="fas fa-chevron-left custom_chevron py-2 d-expand {{ (request()->is('staff/staff_employee*')) ? 'd-show' : '' }}"></i>
                    </a>
                    <ul class="pl-0">
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('courseOrder.index') }}" class="hvWhite pd8-20 p-2 d-block
                            {{ (url()->current() == route('courseOrder.index') ) ? 'activeTHS' : '' }} ">
                                <i class="far fa-circle "></i><span>Danh sách đơn hàng
                                </span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('order_sales_statistics_staff') }}" class="hvWhite pd8-20 p-2 d-block
                            {{ (url()->current() == route('order_sales_statistics_staff') ) ? 'activeTHS' : '' }} ">
                                <i class="far fa-circle "></i><span>Thống kê doanh số đơn hàng
                                </span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('courseEmployee.index') }}" class="hvWhite pd8-20 p-2 d-block
                            {{ (url()->current() == route('courseEmployee.index') ) ? 'activeTHS' : '' }} ">
                                <i class="far fa-circle "></i><span>Danh sách UV đăng ký khóa học
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="" style="font-size: 17px;">
                    <a class="block d-orange clwhite pd8-20">
                    <i class="fas fa-envelope"></i><span>Phản hồi khóa học</span>
                    </a>
                    <a class="block clwhite pd8-20 d-bco">
                    <span class="text-dark p-2"><i class=" far fa-address-card "></i>Phản hồi khóa học</span>
                        <i class="fas fa-chevron-left custom_chevron py-2 d-expand {{ (request()->is('staff/staff_employee*')) ? 'd-show' : '' }}"></i>
                    </a>
                    <ul class="pl-0">
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('courseFeedback.index') }}" class="hvWhite pd8-20 p-2 d-block
                            {{ (url()->current() == route('courseFeedback.index') ) ? 'activeTHS' : '' }} ">
                                <i class="far fa-circle "></i><span>Danh sách phản hồi
                                </span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('courseQuestions.index') }}" class="hvWhite pd8-20 p-2 d-block
                            {{ (url()->current() == route('courseQuestions.index') ) ? 'activeTHS' : '' }} ">
                                <i class="far fa-circle "></i><span>Danh sách câu hỏi khóa học
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
