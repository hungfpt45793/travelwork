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

                <li class="header">Loại hình doanh nghiệp</li>
                <li class="{{ Request::is('admin/exam_type_business', 'admin/exam_type_business/create') ? 'active' : null }} treeview">
                    <a href="{{ route('exam_type_business.index') }}">
                        <i class="fa fa-users" aria-hidden="true"></i> <span>Loại hình doanh nghiệp</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is( 'admin/exam_type_business' ) ? 'active' : null }}">
                            <a href="{{ route('exam_type_business.index') }}"><i class="fa fa-circle-o"></i>Tất cả</a>
                        </li>
                        <li class="{{ Request::is('admin/exam_type_business/create') ? 'active' : null }}">
                            <a href="{{ route('exam_type_business.create') }}"><i class="fa fa-circle-o"></i>Thêm mới</a>
                        </li>
                    </ul>
                </li>

                <li class="header">Vị trí công việc</li>
                <li class="{{ Request::is('admin/exam_local_job', 'admin/exam_local_job/create') ? 'active' : null }} treeview">
                    <a href="{{ route('exam_local_job.index') }}">
                        <i class="fa fa-users" aria-hidden="true"></i> <span>Vị trí công việc</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is( 'admin/exam_local_job' ) ? 'active' : null }}">
                            <a href="{{ route('exam_local_job.index') }}"><i class="fa fa-circle-o"></i>Tất cả</a>
                        </li>
                        <li class="{{ Request::is('admin/exam_local_job/create') ? 'active' : null }}">
                            <a href="{{ route('exam_local_job.create') }}"><i class="fa fa-circle-o"></i>Thêm mới</a>
                        </li>
                    </ul>
                </li>

                <li class="header">Đề thi</li>
                <li class="{{ Request::is('admin/exam', 'admin/exam/create') ? 'active' : null }} treeview">
                    <a href="{{ route('exam.index') }}">
                        <i class="fa fa-users" aria-hidden="true"></i> <span>Quản lý đề thi</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is( 'admin/exam' ) ? 'active' : null }}">
                            <a href="{{ route('exam.index') }}"><i class="fa fa-circle-o"></i>Tất cả đề thi</a>
                        </li>
                        <li class="{{ Request::is('admin/exam/create') ? 'active' : null }}">
                            <a href="{{ route('exam.create') }}"><i class="fa fa-circle-o"></i>Thêm mới đề thi</a>
                        </li>
                    </ul>
                </li>
            @endif


        </ul>
    </section>
    <!-- /.sidebar -->

</aside>
