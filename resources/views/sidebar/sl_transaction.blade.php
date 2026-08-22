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

                <li class="header">Thông tin giao dịch</li>

                <li class="{{ Request::is('admin/employee_coints') ? 'active' : null }} treeview">
                    <a href="{{ route('employee_coints.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Thống kê ứng viên</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/employee_coints') ? 'active' : null }}">
                            <a href="{{ route('employee_coints.index') }}"><i class="fa fa-line-chart"></i>Danh sách ứng viên</a>
                        </li>

                        <li class="{{ Request::is('list_employee_intro') ? 'active' : null }}">
                            <a href="{{ route('list_employee_intro') }}"><i class="fa fa-line-chart"></i>Danh sách NTD đã giới thiệu</a>
                        </li>

                    </ul>
                </li>


                <li class="{{ Request::is('admin/transaction_card') ? 'active' : null }} treeview">
                    <a href="{{ route('list_product.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Đổi thẻ cào</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/transaction_card') ? 'active' : null }}">
                            <a href="{{ route('transaction_card.index') }}"><i class="fa fa-line-chart"></i>Danh sách đổi thẻ cào</a>
                        </li>

                    </ul>
                </li>

                <li class="{{ Request::is('admin/transaction_bank','admin/chuyen-khoan/dung-chuyen-khoan') ? 'active' : null }} treeview">
                    <a href="{{ route('list_product.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Chuyển khoản</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">

                        <li class="{{ Request::is('admin/transaction_bank') ? 'active' : null }}">
                            <a href="{{ route('transaction_bank.index') }}"><i class="fa fa-line-chart"></i>Danh sách chuyển khoản</a>
                        </li> <li class="{{ Request::is('admin/chuyen-khoan/dung-chuyen-khoan') ? 'active' : null }}">
                            <a href="{{ route('stop_list_bank') }}"><i class="fa fa-line-chart"></i>Danh sách dừng chuyển khoản</a>
                        </li>

                    </ul>
                </li>

                <li class="{{ Request::is('admin/transaction_product') ? 'active' : null }} treeview">
                    <a href="{{ route('list_product.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Đổi sản phẩm</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        {{--<li class="{{ Request::is('admin/list_product/create') ? 'active' : null }}">--}}
                            {{--<a href="{{ route('list_product.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới sản phẩm</a>--}}
                        {{--</li>--}}
                        <li class="{{ Request::is('admin/transaction_product') ? 'active' : null }}">
                            <a href="{{ route('transaction_product.index') }}"><i class="fa fa-line-chart"></i>Danh sách đổi sản phẩm</a>
                        </li>

                    </ul>
                </li>


                <li class="header">Sản phẩm đổi xu</li>
                <li class="{{ Request::is('admin/list_product') ? 'active' : null }} treeview">
                    <a href="{{ route('list_product.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Sản phẩm đổi xu</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/list_product/create') ? 'active' : null }}">
                            <a href="{{ route('list_product.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới sản phẩm</a>
                        </li>
                        <li class="{{ Request::is('admin/list_product') ? 'active' : null }}">
                            <a href="{{ route('list_product.index') }}"><i class="fa fa-line-chart"></i>Tất cả sản phẩm</a>
                        </li>

                    </ul>
                </li>
                <li class="header">Cấu hình thông tin kiếm tiền</li>
                <li class="{{ Request::is('admin/information-money', 'admin/information-money/create') ? 'active' : null }} ">
                    <a href="{{ route('information-money.index') }}">
                        <i class="fa fa-info-circle" aria-hidden="true"></i> <span>Thông tin trang kiếm tiền</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/type-information-money') ? 'active' : null }} treeview">
                    <a>
                        <i class="fa fa-wrench" aria-hidden="true"></i> <span>Cài đặt kiếm tiền</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">

                        <li class="{{ Request::is('admin/type-information-money') ? 'active' : null }}">
                            <a href="{{ route('type-information-money.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới trường thông tin</a>
                        </li>
                        <li class="{{ Request::is( 'admin/type-information-money' ) ? 'active' : null }}">
                            <a href="{{ route('type-information-money.index') }}"><i class="fa fa-info-circle" aria-hidden="true"></i> Trường Thông tin</a>
                        </li>

                    </ul>
                </li>
                <li class="header">Lượng tiền quy đổi trong tháng</li>
                <li class="{{ Request::is('admin/money_month') ? 'active' : null }} treeview">
                    <a>
                        <i class="fa fa-money" aria-hidden="true"></i> <span>Lượng tiền quy đổi trong tháng</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">

                        <li class="{{ Request::is('admin/money_month') ? 'active' : null }}">
                            <a href="{{ route('money_month.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới</a>
                        </li>
                        <li class="{{ Request::is( 'admin/money_month' ) ? 'active' : null }}">
                            <a href="{{ route('money_month.index') }}"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Danh sách</a>
                        </li>

                    </ul>
                </li>



            </ul>
        @endif
    </section>
    <!-- /.sidebar -->

</aside>
