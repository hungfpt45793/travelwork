<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel" style="height: 30px;padding: 0">

            <div class="pull-left info" style="float: none !important;text-align: left; padding: 7px;" >
                <p>{{Auth::user()->name}}  (<a class=""  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" style="cursor: pointer;color: red">Thoát</a>)
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form></p>

            </div>
        </div>
    @if(\App\Entity\User::isCreater(\Illuminate\Support\Facades\Auth::user()->role))
        <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">Tên quyền lợi</li>

                <li class="{{ Request::is('admin/service_benifit') ? 'active' : null }} treeview">
                    <a href="{{ route('service_benifit.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách tên quyền lợi</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/service_benifit') ? 'active' : null }}">
                            <a href="{{ route('service_benifit.index') }}"><i class="fa fa-line-chart"></i>Danh sách tên quyền lợi</a>
                            <a href="{{ route('service_benifit.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới tên quyền lợi</a>
                        </li>

                    </ul>
                </li>
                <li class="{{ Request::is('admin/service_name_benifit') ? 'active' : null }} treeview">
                    <a href="{{ route('service_name_benifit.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách nội dung quyền lợi</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/service_name_benifit') ? 'active' : null }}">
                            <a href="{{ route('service_name_benifit.index') }}"><i class="fa fa-line-chart"></i>Danh sách nội dung quyền lợi</a>
                            <a href="{{ route('service_name_benifit.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới nội dung quyền lợi</a>
                        </li>

                    </ul>
                </li>




                <li class="header">Dịch vụ</li>

                <li class="{{ Request::is('admin/list_price') ? 'active' : null }} treeview">
                    <a href="{{ route('list_price.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách Dịch vụ</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/list_price') ? 'active' : null }}">
                            <a href="{{ route('list_price.index') }}"><i class="fa fa-line-chart"></i>Danh sách Dịch vụ</a>
                            <a href="{{ route('list_price.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới dịch vụ</a>
                        </li>

                    </ul>
                </li>
                <li class="header">Bảng giá</li>

                <li class="{{ Request::is('admin/list_table_price') ? 'active' : null }} treeview">
                    <a href="{{ route('list_table_price.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách bảng giá</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/list_table_price') ? 'active' : null }}">
                            <a href="{{ route('list_table_price.index') }}"><i class="fa fa-line-chart"></i>Danh sách bảng giá </a>
                            <a href="{{ route('list_table_price.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới bảng giá</a>
                        </li>

                    </ul>
                </li>
                <li class="header">Comment</li>

                <li class="{{ Request::is('admin/service_comment') ? 'active' : null }} treeview">
                    <a href="{{ route('service_comment.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách comment</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/service_comment') ? 'active' : null }}">
                            <a href="{{ route('service_comment.index') }}"><i class="fa fa-line-chart"></i>Danh sách comment </a>
                            <a href="{{ route('service_comment.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới comment</a>
                        </li>

                    </ul>
                </li>

                <li class="header">Icons</li>
                <li class="{{ Request::is('admin/service_icon') ? 'active' : null }} treeview">
                    <a href="{{ route('service_icon.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách icon</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/service_icon') ? 'active' : null }}">
                            <a href="{{ route('service_icon.index') }}"><i class="fa fa-line-chart"></i>Danh sách icon</a>
                            <a href="{{ route('service_icon.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới icon</a>
                        </li>

                    </ul>
                </li>
                <li class="header">Tuyển dụng thuê</li>
                <li class="{{ Request::is('admin/service_hunter') ? 'active' : null }} treeview">
                    <a href="{{ route('service_hunter.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách tuyển dụng thuê</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/service_hunter') ? 'active' : null }}">
                            <a href="{{ route('service_hunter.index') }}"><i class="fa fa-line-chart"></i>Danh sách tuyển dụng thuê</a>
                            <a href="{{ route('service_hunter.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới tuyển dụng thuê</a>
                        </li>

                    </ul>
                </li>
                <li class="header">Ngân hàng</li>
                <li class="{{ Request::is('admin/service_order') ? 'active' : null }} treeview">
                    <a href="{{ route('service_bank.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách ngân hàng</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/service_bank') ? 'active' : null }}">
                            <a href="{{ route('service_bank.index') }}"><i class="fa fa-line-chart"></i>Danh sách ngân hàng</a>
                            <a href="{{ route('service_bank.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới ngân hàng</a>
                        </li>

                    </ul>
                </li>
                {{-- <li class="header">Đơn hàng</li>
                <li class="{{ Request::is('admin/service_order') ? 'active' : null }} treeview">
                    <a href="{{ route('service_order.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách đơn hàng</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/service_order') ? 'active' : null }}">
                            <a href="{{ route('list_employer_to_add_service_order') }}"><i class="fa fa-line-chart"></i>Danh sách NTD</a>
                            <a href="{{ route('service_order.index') }}"><i class="fa fa-line-chart"></i>Danh sách đơn hàng</a>
                            <a href="{{ route('service_order.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới đơn hàng</a>
                        </li>

                    </ul>
                </li> --}}

                <li class="header">Tuyển dụng thuê</li>
                <li class="{{ Request::is('admin/hunter_pos') ? 'active' : null }} treeview">
                    <a href="{{ route('hunter_pos.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách vị trí tuyển dụng</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/hunter_pos') ? 'active' : null }}">
                            <a href="{{ route('hunter_pos.index') }}"><i class="fa fa-line-chart"></i>Danh sách vị trí tuyển dụng</a>
                            <a href="{{ route('hunter_pos.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới vị trí tuyển dụng</a>
                        </li>

                    </ul>
                </li>
                <li class="{{ Request::is('admin/hunter_time') ? 'active' : null }} treeview">
                    <a href="{{ route('hunter_time.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Thời gian tuyển dụng</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/hunter_time') ? 'active' : null }}">
                            <a href="{{ route('hunter_time.index') }}"><i class="fa fa-line-chart"></i>Danh sách Thời gian tuyển dụng</a>
                            <a href="{{ route('hunter_time.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới Thời gian tuyển dụng</a>
                        </li>

                    </ul>
                </li>
                <li class="{{ Request::is('admin/hunter_price') ? 'active' : null }} treeview">
                    <a href="{{ route('hunter_price.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Chi phí tuyển dụng</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/hunter_price') ? 'active' : null }}">
                            <a href="{{ route('hunter_price.index') }}"><i class="fa fa-line-chart"></i>Danh sách Chi phí tuyển dụng</a>
                            <a href="{{ route('hunter_price.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới Chi phí tuyển dụng</a>
                        </li>

                    </ul>
                </li>

            </ul>
        @endif
    </section>
    <!-- /.sidebar -->

</aside>
