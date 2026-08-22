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

                <li class="header">Nhà tuyển dụng</li>

                <li class="{{ Request::is('admin/employer','admin/nha-tuyen-dung-da-xoa') ? 'active' : null }} treeview">
                    <a href="{{ route('employer.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Nhà Tuyển Dụng</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/employer') ? 'active' : null }}">
                            <a href="{{ route('employer.index') }}"><i class="fa fa-line-chart"></i>Tất cả NTD</a>
                        </li>

                        <li class="{{ Request::is('admin/employer/create') ? 'active' : null }}">
                            <a href="{{ route('employer.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới NTD</a>
                        </li>
                        <li class="{{ Request::is('admin/nha-tuyen-dung-bi-de-nghi-xoa') ? 'active' : null }}">
                            <a href="{{ route('listEmployerDeleteRequest') }}"><i class="fa fa-line-chart"></i>Danh sách đề nghị xóa</a>
                        </li>
                        <li class="{{ Request::is('admin/nha-tuyen-dung-da-xoa') ? 'active' : null }}">
                            <a href="{{ route('listEmployerDelete') }}"><i class="fa fa-line-chart"></i>Danh sách NTD đã
                                xóa</a>
                        </li>
                    </ul>
                </li>

                <li class="header">Giáo viên</li>
                <li class="{{ Request::is('admin/teacher', 'admin/teacher/create','admin/giao-vien-da-xoa') ? 'active' : null }} treeview">
                    <a href="{{ route('teacher.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Giáo viên</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/teacher') ? 'active' : null }}">
                            <a href="{{ route('teacher.index') }}"><i class="fa fa-line-chart"></i>Tất cả giáo viên</a>
                        </li>

                        <li class="{{ Request::is('admin/teacher/create') ? 'active' : null }}">
                            <a href="{{ route('teacher.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới Giáo
                                viên</a>
                        </li>
                        <li class="{{ Request::is('admin/giao-vien-bi-de-nghi-xoa') ? 'active' : null }}">
                            <a href="{{ route('listTeacherDeleteRequest') }}"><i class="fa fa-line-chart"></i>Danh sách đề nghị xóa</a>
                        </li>
                        <li class="{{ Request::is('admin/giao-vien-da-xoa') ? 'active' : null }}">
                            <a href="{{ route('listTeacherDelete') }}"><i class="fa fa-line-chart"></i>Danh sách Giáo
                                viên đã xóa</a>
                        </li>
                    </ul>
                </li>

                <li class="header">Ứng viên</li>
                <li class="{{ Request::is('admin/employee', 'admin/employee/create','admin/statiscal', 'admin/statiscal/create','admin/ung-vien-da-xoa') ? 'active' : null }} treeview">
                    <a href="{{ route('employee.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span> Ứng viên</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/employee') ? 'active' : null }}">
                            <a href="{{ route('employee.index') }}"><i class="fa fa-line-chart"></i>Tất cả Ứng viên</a>
                        </li>

                        <li class="{{ Request::is('admin/employee/create') ? 'active' : null }}">
                            <a href="{{ route('employee.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới Ứng
                                viên</a>
                        </li>
                        <li class="{{ Request::is('admin/ung-vien-bi-de-nghi-xoa') ? 'active' : null }}">
                            <a href="{{ route('listEmployeeDeleteRequest') }}"><i class="fa fa-line-chart"></i>Danh sách đề nghị xóa</a>
                        </li>
                        <li class="{{ Request::is('admin/ung-vien-da-xoa') ? 'active' : null }}">
                            <a href="{{ route('listEmployeeDelete') }}"><i class="fa fa-line-chart"></i>Danh sách Ứng
                                viên đã xóa</a>
                        </li>
                        <li class="{{ Request::is('admin/statiscal', 'admin/statiscal/create') ? 'active' : null }}">
                            <a href="{{ route('statiscal.index') }}">
                                <i class="fa fa-user" aria-hidden="true"></i> <span>Thống kê ứng viên</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="header">Nhân viên(quản lý)</li>
                <li class="{{ Request::is('admin/staff', 'admin/staff','admin/staff', 'admin/staff/create','admin/nhan-vien-da-xoa') ? 'active' : null }} treeview">
                    <a href="{{ route('staff.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span> Nhân viên</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/staff') ? 'active' : null }}">
                            <a href="{{ route('staff.index') }}"><i class="fa fa-line-chart"></i>Tất cả Nhân viên</a>
                        </li>

                        <li class="{{ Request::is('admin/staff/create') ? 'active' : null }}">
                            <a href="{{ route('staff.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới Nhân viên</a>
                        </li>

                        <li class="{{ Request::is('admin/nhan-vien-da-xoa') ? 'active' : null }}">
                            <a href="{{ route('listStaffDelete') }}"><i class="fa fa-line-chart"></i>Danh sách Nhân viên
                                đã xóa</a>
                        </li>
                    </ul>
                </li>

                <li class="header">Cộng tác viên</li>
                <li class="{{ Request::is('admin/staff_member', 'admin/staff_member', 'admin/staff_member/create','admin/cong-tac-vien-da-xoa') ? 'active' : null }} treeview">
                    <a href="{{ route('staff_member.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span> Cộng tác  viên</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/staff_member') ? 'active' : null }}">
                            <a href="{{ route('staff_member.index') }}"><i class="fa fa-line-chart"></i>Tất cả Cộng tác viên</a>
                        </li>

                        <li class="{{ Request::is('admin/staff_member/create') ? 'active' : null }}">
                            <a href="{{ route('staff_member.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới Cộng tác viên</a>
                        </li>

                        <li class="{{ Request::is('admin/cong-tac-vien-da-xoa') ? 'active' : null }}">
                            <a href="{{ route('listStaffMemberDelete') }}"><i class="fa fa-line-chart"></i>Danh sách Cộng tác viên
                                đã xóa</a>
                        </li>
                    </ul>
                </li>
                <li class="header">Cộng tác viên HR</li>
                <li class="{{ Request::is('admin/staff_hr', 'admin/staff_hr', 'admin/staff_hr/create','admin/cong-tac-vien-da-xoa-hr') ? 'active' : null }} treeview">
                    <a href="{{ route('staff_hr.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span> Cộng tác  viên HR</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/staff_hr') ? 'active' : null }}">
                            <a href="{{ route('staff_hr.index') }}"><i class="fa fa-line-chart"></i>Tất cả Cộng tác viên HR</a>
                        </li>

                        <li class="{{ Request::is('admin/staff_hr/create') ? 'active' : null }}">
                            <a href="{{ route('staff_hr.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới Cộng tác viên HR</a>
                        </li>

                        <li class="{{ Request::is('admin/cong-tac-vien-da-xoa-hr') ? 'active' : null }}">
                            <a href="{{ route('listStaffHrDelete') }}"><i class="fa fa-line-chart"></i>Danh sách Cộng tác viên HR
                                đã xóa</a>
                        </li>
                    </ul>
                </li>


            @if(\App\Entity\User::isCreater(\Illuminate\Support\Facades\Auth::user()->role))
                    <li class="header">Tài khoản</li>
                    <li class="{{ Request::is('admin/users', 'admin/users/create') ? 'active' : null }} treeview">
                        <a href="{{ route('users.index') }}">
                            <i class="fa fa-users" aria-hidden="true"></i> <span>Quản lý tài khoản</span>
                            <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Request::is( 'admin/users' ) ? 'active' : null }}">
                                <a href="{{ route('users.index') }}"><i class="fa fa-circle-o"></i>Tất cả tài khoản</a>
                            </li>
                            <li class="{{ Request::is('admin/users/create') ? 'active' : null }}">
                                <a href="{{ route('users.create') }}"><i class="fa fa-circle-o"></i>Thêm mới tài khoảnn</a>
                            </li>

                            <li class="{{ Request::is('listUserDelete') ? 'active' : null }}">
                                <a href="{{ route('listUserDelete') }}"><i class="fa fa-circle-o"></i>Tài khoản đã
                                    xóa</a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li class="header">Phần quyền role</li>
                <li class="{{ Request::is('admin/role')  ? 'active' : null }} treeview">
                    <a href="{{ route('role.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Phân quyền</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/role') ? 'active' : null }}">
                            <a href="{{ route('role.index') }}"><i class="fa fa-line-chart"></i>Danh sách quyền</a>
                        </li>

                        <li class="{{ Request::is('admin/role/create') ? 'active' : null }}">
                            <a href="{{ route('role.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới quyền</a>
                        </li>

                    </ul>
                </li>
                <li class="header">Thông tin</li>


                {{--<li class="{{ Request::is('admin/contact') ? 'active' : null }} ">--}}
                {{--<a href="{{ route('contact.index') }}">--}}
                {{--<i class="fa fa-paper-plane" aria-hidden="true"></i> <span>Quản lý Liên hệ</span>--}}
                {{--</a>--}}
                {{--</li>--}}
                <li class="{{ Request::is('admin/subcribe-email') ? 'active' : null }} ">
                    <a href="{{ route('subcribe-email.index') }}">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i> <span>Đăng ký nhận email (SĐT)</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/comments') ? 'active' : null }} ">
                    <a href="{{ route('comments.index') }}">
                        <i class="fa fa-comments" aria-hidden="true"></i> <span>Quản lý thảo luận việc làm</span>
                    </a>
                </li>


                @endif
            </ul>
    </section>
    <!-- /.sidebar -->

</aside>
