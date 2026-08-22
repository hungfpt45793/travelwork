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
                <li class="{{ Request::is('admin/sale', 'admin/sale/create') ? 'active' : null }}">
                    <a href="{{ route('sale.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Gói bán hàng</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/saleGroup', 'admin/saleGroup/create') ? 'active' : null }}">
                    <a href="{{ route('saleGroup.index') }}">
                        <i class="fa fa-calculator" aria-hidden="true"></i> <span>Danh mục gói bán hàng</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/nguoi-ban-hang-xuat-sac') ? 'active' : null }}">
                    <a href="{{ route('excellent_sellers') }}">
                        <i class="fa fa-user-secret" aria-hidden="true"></i> <span>Người Bán hàng xuất sắc</span>
                    </a>
                </li>

                @endif
            </ul>
    </section>
    <!-- /.sidebar -->

</aside>
