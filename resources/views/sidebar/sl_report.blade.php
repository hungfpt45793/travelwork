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
                <li class="{{ Request::is('admin/bao-cao-doanh-thu') ? 'active' : null }} ">
                    <a href="{{ route('report_revenue') }}">
                        <i class="fa fa-hourglass-end" aria-hidden="true"></i> <span>Báo cáo doanh thu</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/bao-cao-cong-viec') ? 'active' : null }} ">
                    <a href="{{ route('report_job') }}">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i> <span>Báo cáo công việc</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/bao-cao-don-hang') ? 'active' : null }} ">
                    <a href="{{ route('report_order') }}">
                        <i class="fa fa-building" aria-hidden="true"></i> <span>Báo cáo đơn hàng</span>
                    </a>
                </li>

                @endif
            </ul>
    </section>
    <!-- /.sidebar -->

</aside>
