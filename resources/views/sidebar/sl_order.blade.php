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
                <li class="header">Menu Chính</li>
                <li class="{{ Request::is('admin/order', 'admin/order/create') ? 'active' : null }} ">
                    <a href="{{ route('order.index') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Đơn hàng</span>
                    </a>
                </li>
                
                <li class="{{ Request::is('admin/order-duplicate') ? 'active' : null }}">
                    <a href="{{ route('order_duplicate') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Đơn hàng trùng</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/order-complain') ? 'active' : null }}">
                    <a href="{{ route('order_complain') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Đơn hàng khiếu nại</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/order-affiliate') ? 'active' : null }}">
                    <a href="{{ route('order_affiliate') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Đơn hàng affiliate</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/order-deleted') ? 'active' : null }}">
                    <a href="{{ route('order_deleted') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Đơn hàng đã xóa</span>
                    </a>
                </li>
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
                        </li>

                    </ul>
                </li>
                <li class="{{ Request::is('admin/hunter_order') ? 'active' : null }} treeview">
                    <a href="{{ route('hunter_order.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Đơn hàng tuyển dụng</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/hunter_order') ? 'active' : null }}">
                            <a href="{{ route('list_employer_to_add_hunter_order') }}"><i class="fa fa-line-chart"></i>Danh sách NTD</a>
                            <a href="{{ route('hunter_order.index') }}"><i class="fa fa-line-chart"></i>Đơn hàng tuyển dụng</a>
                        </li>

                    </ul>
                </li>

                
                <li class="{{ Request::is('admin/service_order_icon') ? 'active' : null }} treeview">
                    <a href="{{ route('service_order_icon.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Đơn hàng biểu tượng</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/service_order_icon') ? 'active' : null }}">
                            {{-- <a href="{{ route('list_employer_to_add_hunter_order') }}"><i class="fa fa-line-chart"></i>Danh sách NTD</a> --}}
                            <a href="{{ route('list_employer_to_add_order_icon') }}"><i class="fa fa-line-chart"></i>Danh sách NTD</a>
                        </li>
                        <li class="{{ Request::is('admin/service_order_icon') ? 'active' : null }}">
                            {{-- <a href="{{ route('list_employer_to_add_hunter_order') }}"><i class="fa fa-line-chart"></i>Danh sách NTD</a> --}}
                            <a href="{{ route('service_order_icon.index') }}"><i class="fa fa-line-chart"></i>Đơn hàng biểu tượng</a>
                        </li>

                    </ul>
                </li>
                @endif
            </ul>
    </section>
    <!-- /.sidebar -->

</aside>
