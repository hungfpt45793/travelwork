

    <div class="tab-content hover_show mgb20" id="nav-tabContent">
        <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="item">
                <ul class="d-menu pl-0" style="font-size: 17px;">
                    <li class="">
                        <a class="pl-0 d-block pl-1 px-2 py-2 hvWhite pd8-20 {{ (request()->is('staff/staff_archives*')) ? 'activeTHS' : '' }}" href="{{ route('staff_archives.index') }}">
                            <i class=" far fa-address-card "></i><span>Kho tài liệu</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a class="pl-0 d-block pl-1 px-2 py-2 hvWhite pd8-20 {{ (request()->is('staff/staff_category_document*')) ? 'activeTHS' : '' }}" href="{{ route('staff_category_document.index') }}">
                            <i class=" far fa-file-alt " ></i><span>Danh mục tài liệu</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="{{ route('staff_voucher.index') }}" class="pl-0 d-block pl-1 px-2 py-2 hvWhite pd8-20 {{ (request()->is('staff/staff_voucher*')) ? 'activeTHS' : '' }}">
                           <i class="fas fa-chalkboard-teacher"></i> <span>Tài liệu</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="{{ route('list_deleted_vaucher') }}" class="pl-0 d-block pl-1 px-2 py-2 hvWhite pd8-20 {{ (request()->is('staff/tai-lieu-xoa')) ? 'activeTHS' : '' }}">
                           <i class="fas fa-chalkboard-teacher"></i> <span>Tài liệu đã xóa</span>
                        </a>
                    </li>
                    <li class="hvbgrBlueN d-hvbgrBlueN ">
                        <a href="{{ route('staff_comment_voucher.index') }}" class="pl-0 d-block pl-1 px-2 py-2 hvWhite pd8-20 {{ (request()->is('staff/staff_comment_voucher*')) ? 'activeTHS' : '' }}">
                            <i class="fas fa-chalkboard-teacher"></i>
                            @if(isset($total_no_comment) && $total_no_comment > 0)
                            <span class="text-danger">Tất cả bình luận( {{ $total_no_comment }} )</span>
                            @else
                            <span>Tất cả bình luận</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

