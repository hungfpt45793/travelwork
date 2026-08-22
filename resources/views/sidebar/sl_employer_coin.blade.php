<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel" style="height: 30px;padding: 0">

            <div class="pull-left info" style="float: none !important;text-align: left; padding: 7px;">
                <p>{{Auth::user()->name}} (<a class="" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                              style="cursor: pointer;color: red">Thoát</a>)
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                </p>

            </div>
        </div>
    @if(\App\Entity\User::isCreater(\Illuminate\Support\Facades\Auth::user()->role))
        <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">

                <li class="header">Xu Nhà tuyển dụng</li>

                <li class="{{ Request::is('admin/employer_coin') ? 'active' : null }} treeview">
                    <a href="{{ route('employer.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Nhà Tuyển Dụng</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/employer_coin') ? 'active' : null }}">
                            <a href="{{ route('employer_coin.index') }}"><i class="fa fa-line-chart"></i>Tất cả NTD</a>
                        </li>
                        {{--<li class="{{ Request::is('admin/employer/create') ? 'active' : null }}">--}}
                            {{--<a href="{{ route('employer.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới NTD</a>--}}
                        {{--</li>--}}

                        {{--<li class="{{ Request::is('admin/nha-tuyen-dung-da-xoa') ? 'active' : null }}">--}}
                            {{--<a href="{{ route('listEmployerDelete') }}"><i class="fa fa-line-chart"></i>Danh sách NTD đã--}}
                                {{--xóa</a>--}}
                        {{--</li>--}}
                    </ul>
                </li>

                <li class="{{ Request::is('admin/employer_select_response', 'admin/employer_select_response/create', 'admin/employer_select_response/edit') ? 'active' : null }} treeview">
                    <a href="
                    {{-- {{ route('employer_select_response.index') }} --}}
                            ">
                        <i class="fa fa-object-group" aria-hidden="true"></i> <span>Yêu cầu NTD</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/employer_select_response') ? 'active' : null }}">
                            <a href="{{ route('employer_select_response.index') }}"><i class="fa fa-line-chart"></i>Tất cả yêu cầu</a>
                        </li>
                        <li class="{{ Request::is('admin/employer_select_response/create') ? 'active' : null }}">
                            <a href="{{ route('employer_select_response.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới yêu cầu</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ Request::is('admin/employer_select_response', 'admin/employer_select_response/create', 'admin/employer_select_response/edit') ? 'active' : null }} treeview">
                    <a href="
                    {{-- {{ route('employer_select_response.index') }} --}}
                            ">
                        <i class="fa fa-object-group" aria-hidden="true"></i> <span>Phản hồi từ NTD</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/employer_select_response') ? 'active' : null }}">
                            <a href="{{ route('list_employer_feedback') }}"><i class="fa fa-line-chart"></i>Tất cả phản hồi</a>
                        </li>
                    </ul>
                </li>



                <li class="header">Cấu hình thông tin giao dịch</li>
                <li class="{{ Request::is('admin/coin_information_employer', 'admin/coin_information_employer/create') ? 'active' : null }} ">
                    <a href="{{ route('coin_information_employer.index') }}">
                        <i class="fa fa-info-circle" aria-hidden="true"></i> <span>Thông tin giao dịch</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/coin_type_information_employer','admin/coin_type_information_employer/create') ? 'active' : null }} treeview">
                    <a>
                        <i class="fa fa-wrench" aria-hidden="true"></i> <span>Cài đặt giao dịch</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">

                        <li class="{{ Request::is('admin/coin_type_information_employer') ? 'active' : null }}">
                            <a href="{{ route('coin_type_information_employer.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới trường thông tin</a>
                        </li>
                        <li class="{{ Request::is( 'admin/coin_type_information_employer' ) ? 'active' : null }}">
                            <a href="{{ route('coin_type_information_employer.index') }}"><i class="fa fa-info-circle" aria-hidden="true"></i> Trường Thông tin</a>
                        </li>

                    </ul>
                </li>
            </ul>
        @endif
    </section>
    <!-- /.sidebar -->

</aside>
