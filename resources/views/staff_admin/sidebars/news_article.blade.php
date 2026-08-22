<div class="tab-content hover_show mgb20" id="nav-tabContent">
    <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="item">
            <ul class="d-menu pl-0">
                <li class="">
                    <a class="block d-orange clwhite pd8-20">
                        <i class="far fa-address-card"></i><span>Quản lý bài viết</span>
                    </a>
                    <a class="block clwhite pd8-20 d-bco">
                        <span class="text-dark p-2"><i class=" far fa-address-card "></i>Bài viết</span>
                        <i class="fas fa-chevron-left custom_chevron py-2 d-expand {{ (request()->is('staff/staff_article*')) ? 'd-show' : '' }}"></i>
                    </a>
                    <ul class="pl-0" style="font-size: 17px;">
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('staff_article.index') }}" class="hvWhite pd8-20 p-2 d-block {{ (request()->is('staff/staff_article*')) ? 'activeTHS' : '' }}">
                                <i class="far fa-circle "></i><span>Tất cả bài viết
                                </span>
                            </a>
                        </li>
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('staff_article_delete') }}" class="hvWhite pd8-20 p-2 d-block {{ (request()->is('staff/bai-viet-xoa')) ? 'activeTHS' : '' }}">
                                <i class="far fa-circle "></i><span>Bài viết xóa
                                </span>
                            </a>
                        </li>
                        {{-- <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('staff_article.create') }}" class="hvWhite pd8-20 p-2 d-block {{ (request()->is('staff/staff_article/create')) ? 'activeTHS' : '' }}">
                                <i class="far fa-circle "></i><span>Thêm mới bài viết</span>
                            </a>
                        </li> --}}
                        <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                            <a href="{{ route('staff_category_article.index') }}" class="hvWhite pd8-20 p-2 d-block {{ (request()->is('staff/staff_category_article*')) ? 'activeTHS' : '' }}">
                                <i class="far fa-circle "></i><span>Chuyên mục</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
