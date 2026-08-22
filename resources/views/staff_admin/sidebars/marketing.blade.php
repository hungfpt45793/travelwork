<div class="tab-content hover_show mgb20" id="nav-tabContent">
        <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="item" style="font-size: 17px;">
                <ul class="d-menu pl-0">
                    <li class="">
                        <a class="block d-orange clwhite pd8-20">
                        <i class="fas fa-envelope"></i><span>Mẫu email</span>
                        </a>
                        <a class="block clwhite pd8-20 d-bco">
                        <span class="text-dark p-2"><i class=" far fa-address-card "></i>Mẫu email</span>
                            <i class="fas fa-chevron-left custom_chevron py-2 d-expand {{ (request()->is('staff/staff_employee*')) ? 'd-show' : '' }}"></i>
                        </a>
                        <ul class="pl-0">
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('form_email') }}" class="hvWhite pd8-20 p-2 d-block
                                {{ (url()->current() == route('form_email') ) ? 'activeTHS' : '' }} ">
                                    <i class="far fa-circle "></i><span>Các mẫu email
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=" ">
                        <a class="block d-orange clwhite pd8-20 ">
                            <i class="fas fa-key"></i><span>Danh mục từ khóa</span>
                        </a>
                        <a class="block clwhite pd8-20 d-bco">
                            <span class="text-dark p-2"><i class=" fas fa-key"></i>Danh mục từ khóa</span>
                            <i class="fas fa-chevron-left custom_chevron py-2 d-expand"></i>
                        </a>
                        <ul class="pl-0">
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('tag-category.index') }}?tag_type=1" class="hvWhite pd8-20 p-2 d-block ">
                                    <i class="far fa-circle "></i><span>Từ khóa bài viết
                                    </span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('tag-category.index') }}?tag_type=2" class="hvWhite pd8-20 p-2 d-block ">
                                    <i class="far fa-circle "></i><span>Từ khóa tài kiệu
                                    </span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('tag-category.index') }}?tag_type=3" class="hvWhite pd8-20 p-2 d-block ">
                                    <i class="far fa-circle "></i><span>Từ khóa công việc
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

