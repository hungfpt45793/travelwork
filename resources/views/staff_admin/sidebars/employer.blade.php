
    <div class="tab-content hover_show mgb20" id="nav-tabContent">
        <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="item">
                <ul class="d-menu pl-0">
                    <li class=" " style="font-size: 17px;">
                        <a class="block d-orange clwhite pd8-20 ">
                            <i class="far fa-file-alt "></i><span>Nhà tuyển dụng</span>
                        </a>
                        <a class="block clwhite pd8-20 d-bco">
                        @if(isset($unemployer) && $unemployer > 0)
                        <span class="text-danger p-2"><i class=" far fa-file-alt "></i>Nhà tuyển dụng( {{$unemployer}} chưa duyệt )</span>
                        @else
                        <span class="text-dark p-2"><i class=" far fa-file-alt "></i>Nhà tuyển dụng</span>
                        @endif
                            <i class="fas fa-chevron-left custom_chevron py-2 d-expand {{ (request()->is('staff/staff_employer*')) ? 'd-show' : '' }}"></i>
                        </a>
                        <ul class="pl-0">
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_employer.index') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_employer.index')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Danh sách NTD</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_employer_statistical') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_employer_statistical')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Thống kê NTD 63 tỉnh</span>
                                </a>
                            </li>
                            {{-- <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_employer.create') }}" class="hvWhite pd8-20 p-2 d-block">
                                    <i class="far fa-circle "></i><span>Thêm mới NTD</span>
                                </a>
                            </li> --}}
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a href="{{ route('staff_employer_list_deleted') }}" class="hvWhite pd8-20 p-2 d-block {{ (request()->is('staff/staff_employer/list-deleted')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Danh sách NTD đã xóa</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a id="result" href="{{ route('staff_employer_report_employer') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('staff_employer_report_employer')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Báo cáo DS NTD</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN d-hvbgrBlueN pl-0">
                                <a id="result" href="{{ route('list_employer_follow') }}" class="hvWhite pd8-20 p-2 d-block {{ (url()->current() == route('list_employer_follow')) ? 'activeTHS' : '' }}">
                                    <i class="far fa-circle "></i><span>Danh sách NTD theo dõi</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

