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

                <li class="header">Giảng viên</li>

                <li class="{{ Request::is('admin/teacher_school') ? 'active' : null }} treeview">
                    <a href="{{ route('teacher_school.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách giảng viên</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/teacher_shool') ? 'active' : null }}">
                            <a href="{{ route('teacher_school.index') }}"><i class="fa fa-line-chart"></i>Danh sách
                                giảng viên</a>
                            <a href="{{ route('teacher_school.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới giảng
                                viên</a>
                        </li>

                    </ul>
                </li>
                <li class="header">Môn học</li>

                <li class="{{ Request::is('admin/school_subject') ? 'active' : null }} treeview">
                    <a href="{{ route('school_subject.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách môn học</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/school_subject') ? 'active' : null }}">
                            <a href="{{ route('school_subject.index') }}"><i class="fa fa-line-chart"></i>Danh sách môn
                                học </a>
                            <a href="{{ route('school_subject.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới môn
                                học</a>
                        </li>

                    </ul>
                </li>

                <li class="header"> Gói gia sư</li>

                <li class="{{ Request::is('admin/combo_advise') ? 'active' : null }} treeview">
                    <a href="{{ route('combo_advise.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách gói gia sư</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/combo_advise') ? 'active' : null }}">
                            <a href="{{ route('combo_advise.index') }}"><i class="fa fa-line-chart"></i>Danh sách </a>
                            <a href="{{ route('combo_advise.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới </a>
                        </li>

                    </ul>
                </li>
                <li class="header"> Gia sư Online 1 - 1</li>

                <li class="{{ Request::is('admin/user_advise') ? 'active' : null }} treeview">
                    <a href="{{ route('user_advise.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span> Gia sư Online 1 - 1</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/user_advise') ? 'active' : null }}">
                            <a href="{{ route('user_advise.index') }}"><i class="fa fa-line-chart"></i>Danh sách </a>
                            {{--<a href="{{ route('user_advise.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới </a>--}}
                        </li>
                        <li class="{{ Request::is('admin/user_advise') ? 'active' : null }}">
                            <a href="{{ route('list_user_suppotr_advise_connect') }}"><i class="fa fa-line-chart"></i>Danh
                                sách kế toán kêt nối </a>
                            {{--<a href="{{ route('user_advise.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới </a>--}}
                        </li>

                    </ul>
                </li>

                <li class="header">Kế toán hỗ trợ</li>
                <li class="{{ Request::is('admin/user_support') ? 'active' : null }} treeview">
                    <a href="{{ route('user_support.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Kế toán hỗ trợ</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/user_support') ? 'active' : null }}">
                            <a href="{{ route('user_support.index') }}"><i class="fa fa-line-chart"></i>Danh sách </a>
                            {{--<a href="{{ route('user_support.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới </a>--}}
                        </li>
                        <li class="{{ Request::is('admin/user_support') ? 'active' : null }}">
                            <a href="{{ route('list_user_suppotr_question') }}"><i class="fa fa-line-chart"></i>Danh sách hỗ trợ </a>
                            {{--<a href="{{ route('user_support.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới </a>--}}
                        </li>

                    </ul>
                </li>


            </ul>
        @endif
    </section>
    <!-- /.sidebar -->

</aside>
