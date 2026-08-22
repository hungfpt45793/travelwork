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

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            @if(\App\Entity\User::isCreater(\Illuminate\Support\Facades\Auth::user()->role))

                <li class="header">Thông tin dịch vụ</li>
                <li class="{{ Request::is('admin/information_service', 'admin/information_service/create') ? 'active' : null }} treeview">
                    <a href="{{ route('information_service.index') }}">
                        <i class="fa fa-users" aria-hidden="true"></i> <span>Thông tin dịch vụ</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is( 'admin/information_service' ) ? 'active' : null }}">
                            <a href="{{ route('information_service.index') }}"><i class="fa fa-circle-o"></i>Danh sách</a>
                        </li>
                        <li class="{{ Request::is('admin/information_service/create') ? 'active' : null }}">
                            <a href="{{ route('information_service.create') }}"><i class="fa fa-circle-o"></i>Thêm mới</a>
                        </li>
                    </ul>
                </li>
                <li class="header">Khu vực</li>
                <li class="{{ Request::is('admin/location_area', 'admin/location_area/create') ? 'active' : null }} treeview">
                    <a href="{{ route('location_area.index') }}">
                        <i class="fa fa-users" aria-hidden="true"></i> <span>Khu vực</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is( 'admin/location_area' ) ? 'active' : null }}">
                            <a href="{{ route('location_area.index') }}"><i class="fa fa-circle-o"></i>Danh sách</a>
                        </li>
                        <li class="{{ Request::is('admin/location_area/create') ? 'active' : null }}">
                            <a href="{{ route('location_area.create') }}"><i class="fa fa-circle-o"></i>Thêm mới</a>
                        </li>
                    </ul>
                </li>
                <li class="header">Chi nhánh</li>
                <li class="{{ Request::is('admin/local_branch', 'admin/local_branch/create') ? 'active' : null }} treeview">
                    <a href="{{ route('local_branch.index') }}">
                        <i class="fa fa-users" aria-hidden="true"></i> <span>Chi nhánh</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is( 'admin/local_branch' ) ? 'active' : null }}">
                            <a href="{{ route('local_branch.index') }}"><i class="fa fa-circle-o"></i>Danh sách</a>
                        </li>
                        <li class="{{ Request::is('admin/local_branch/create') ? 'active' : null }}">
                            <a href="{{ route('local_branch.create') }}"><i class="fa fa-circle-o"></i>Thêm mới</a>
                        </li>
                    </ul>
                </li>


            @endif


        </ul>
    </section>
    <!-- /.sidebar -->

</aside>
