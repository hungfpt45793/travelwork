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
                <li class="header">Kho tài liệu</li>
                <li class="{{ Request::is('admin/voucher-categories', 'admin/voucher-categories/index') ? 'active' : null }} ">
                    <a href="{{ route('voucher-categories.index') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Kho tài liệu</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/voucher-categories/create') ? 'active' : null }}">
                    <a href="{{ route('voucher-categories.create') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Thêm mới</span>
                    </a>
                </li>

                <li class="header">Danh mục tài liệu</li>
                <li class="{{ Request::is('admin/voucher-child-categories', 'admin/voucher-child-categories/index') ? 'active' : null }} ">
                    <a href="{{ route('voucher-child-categories.index') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Danh mục tài liệu</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/voucher-child-categories/create') ? 'active' : null }}">
                    <a href="{{ route('voucher-child-categories.create') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Thêm mới danh mục</span>
                    </a>
                </li>

                <li class="header">Tài liệu</li>
                <li class="{{ Request::is('admin/voucher', 'admin/voucher/index') ? 'active' : null }} ">
                    <a href="{{ route('voucher.index') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Tài liệu</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/voucher/create') ? 'active' : null }}">
                    <a href="{{ route('voucher.create') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Thêm tài liệu</span>
                    </a>
                </li>



                <li class="header">Tài liệu</li>
                <li class="{{ Request::is('admin/voucher-comment', 'admin/voucher-comment/index') ? 'active' : null }} ">
                    <a href="{{ route('voucher-comment.index') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Tất cả bình luận</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/voucher-comment/create') ? 'active' : null }}">
                    <a href="{{ route('voucher-comment.create') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Thêm bình luận</span>
                    </a>
                </li>


            </ul>
        @endif
    </section>
    <!-- /.sidebar -->

</aside>
