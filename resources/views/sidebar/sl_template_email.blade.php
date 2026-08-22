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

                <li class="header">Danh mục mẫu email</li>

                <li class="{{ Request::is('admin/category_template_email') ? 'active' : null }} treeview">
                    <a href="{{ route('category_template_email.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh mục mẫu email</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/category_template_email') ? 'active' : null }}">
                            <a href="{{ route('category_template_email.index') }}"><i class="fa fa-line-chart"></i>Danh mục mẫu email</a>
                            <a href="{{ route('category_template_email.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới danh mục mẫu email</a>
                        </li>

                    </ul>
                </li>


                <li class="header">Các mẫu email</li>

                <li class="{{ Request::is('admin/template_email') ? 'active' : null }} treeview">
                    <a>
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i>  <span>Các mẫu email</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">

                        <li class="{{ Request::is('admin/template_email') ? 'active' : null }}">
                            <a href="{{ route('template_email.index') }}"><i class="fa fa-line-chart"></i>Danh sách các mẫu email</a>
                        </li>
                        <li class="{{ Request::is( 'admin/template_email' ) ? 'active' : null }}">
                            <a href="{{ route('template_email.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới mẫu email</a>
                        </li>

                    </ul>
                </li>





                    <li class="header">Mẫu CV</li>
                    <li class="{{ Request::is('admin/cv_template', 'admin/cv_template/create') ? 'active' : null }} treeview">
                        <a href="{{ route('cv_template.index') }}">
                            <i class="fa fa-users" aria-hidden="true"></i> <span>Mẫu Cv</span>
                            <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Request::is( 'admin/cv_template' ) ? 'active' : null }}">
                                <a href="{{ route('cv_template.index') }}"><i class="fa fa-circle-o"></i>Danh sách CV</a>
                            </li>
                            <li class="{{ Request::is('admin/cv_template/create') ? 'active' : null }}">
                                <a href="{{ route('cv_template.create') }}"><i class="fa fa-circle-o"></i>Thêm mới CV</a>
                            </li>
                        </ul>
                    </li>






`



            </ul>
        @endif
    </section>
    <!-- /.sidebar -->

</aside>
