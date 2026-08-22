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
                <li class="{{ Request::is('admin/coupon', 'admin/coupon/create') ? 'active' : null }} ">
                    <a href="{{ route('coupon.index') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Mã khuyến mãi (coupon)</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/rose', 'admin/rose/create') ? 'active' : null }} ">
                    <a href="{{ route('rose.index') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Hoa hồng bán hàng</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/affiliate', 'admin/affiliate/create') ? 'active' : null }} ">
                    <a href="{{ route('affiliate.index') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Affiliate</span>
                    </a>
                </li>

                @endif
            </ul>
    </section>
    <!-- /.sidebar -->

</aside>
