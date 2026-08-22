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
    @if(!\App\Entity\User::isMember(\Illuminate\Support\Facades\Auth::user()->role))
        <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">Quản lý bài viết
                <li>
                <li class="{{ Request::is('admin/posts', 'admin/posts/create', 'admin/categories') ? 'active' : null }} treeview">
                    <a href="{{ route('posts.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Bài viết</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/posts') ? 'active' : null }}">
                            <a href="{{ route('posts.index') }}"><i class="fa fa-circle-o"></i>Tất cả bải viết</a>
                        </li>
                        <li class="{{ Request::is('admin/posts/create') ? 'active' : null }}">
                            <a href="{{ route('posts.create') }}"><i class="fa fa-circle-o"></i>Thêm mới bài viết</a>
                        </li>
                        <li class="{{ Request::is('admin/categories') ? 'active' : null }}">
                            <a href="{{ route('categories.index') }}"><i class="fa fa-circle-o"></i>Chuyên mục</a>
                        </li>
                    </ul>
                </li>
                <li class="header">Quản lý tag
                <li>
                <li class="{{ Request::is('admin/category-tag', 'admin/category-tag/create', 'admin/category-tag') ? 'active' : null }} treeview">
                    <a href="{{ route('category-tag.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh mục Tag</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/category-tag') ? 'active' : null }}">
                            <a href="{{ route('category-tag.index') }}?tag_type=1"><i class="fa fa-circle-o"></i>Tag bài viết</a>
                        </li>
                        <li class="{{ Request::is('admin/category-tag') ? 'active' : null }}">
                            <a href="{{ route('category-tag.index') }}?tag_type=2"><i class="fa fa-circle-o"></i>Tag tài liệu</a>
                        </li>
                        <li class="{{ Request::is('admin/category-tag') ? 'active' : null }}">
                            <a href="{{ route('category-tag.index') }}?tag_type=3"><i class="fa fa-circle-o"></i>Tag công việc</a>
                        </li>

                    </ul>
                </li>

                <li class="header">Quảng cáo trang chủ

                <li class="{{ Request::is('admin/adv_noti') ? 'active' : null }}">
                    <a href="{{ route('adv_noti.index') }}"><i class="fa fa-circle-o"></i>Quảng cáo trang chủ</a>
                </li>


                <li>
                {{--<li class="{{ Request::is('admin/adv_noti', 'admin/adv_noti/create', 'admin/adv_noti') ? 'active' : null }} treeview">--}}
                    {{--<a href="{{ route('adv_noti.index') }}">--}}
                        {{--<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh mục Tag</span>--}}
                        {{--<span class="pull-right-container">--}}
                      {{--<i class="fa fa-angle-left pull-right"></i>--}}
                    {{--</span>--}}
                    {{--</a>--}}
                    {{--<ul class="treeview-menu">--}}
                        {{--<li class="{{ Request::is('admin/adv_noti') ? 'active' : null }}">--}}
                            {{--<a href="{{ route('adv_noti.index') }}"><i class="fa fa-circle-o"></i>Tag bài viết</a>--}}
                        {{--</li>--}}


                    {{--</ul>--}}
                {{--</li>--}}

                <li class="{{ Request::is('admin/pages', 'admin/pages/create') ? 'active' : null }} treeview">
                    <a href="{{ route('pages.index') }}">
                        <i class="fa fa-file-o" aria-hidden="true"></i> <span>Trang</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/pages') ? 'active' : null }}">
                            <a href="{{ route('pages.index') }}"><i class="fa fa-circle-o"></i>Tất cả trang</a>
                        </li>
                        <li class="{{ Request::is('admin/pages/create') ? 'active' : null }}">
                            <a href="{{ route('pages.create') }}"><i class="fa fa-circle-o"></i>Thêm mới trang</a>
                        </li>
                    </ul>
                </li>

                <li class="header">Hòm thư góp ý</li>
                <li class="{{ Request::is('admin/contact', 'admin/contact', 'admin/contact') ? 'active' : null }} treeview">
                    <a href="{{ route('contact.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Hòm thư góp ý</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/contact') ? 'active' : null }}">
                            <a href="{{ route('contact.index') }}"><i class="fa fa-circle-o"></i>Danh sách liên hệ </a>
                        </li>
                        <li class="{{ Request::is('admin/resEmployer') ? 'active' : null }}">
                            <a href="{{ route('resEmployer') }}"><i class="fa fa-circle-o"></i>NTD đăng kí tư vấn </a>
                        </li>
                        <li class="{{ Request::is('admin/resEmployee') ? 'active' : null }}">
                            <a href="{{ route('resEmployee') }}"><i class="fa fa-circle-o"></i>Ứng viên đăng kí tư vấn
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="header">Bổ sung</li>
                @foreach($typeSubPostsAdmin as $typeSubPost)
                    <li class="{{ Request::is('admin/'.$typeSubPost->slug.'/sub-posts', 'admin/'.$typeSubPost->slug.'/sub-posts/create') ? 'active' : null }} treeview">
                        <a href="{{$typeSubPost->slug.'/sub-posts' }} ">
                            <i class="fa fa-th-list" aria-hidden="true"></i><span>{{ $typeSubPost->title }}</span>
                            <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Request::is('admin/'.$typeSubPost->slug.'sub-posts') ? 'active' : null }}">
                                <a href="{{ route('sub-posts.index', ['typePost' => $typeSubPost->slug]) }}"><i
                                            class="fa fa-circle-o"></i>Tất cả {{ $typeSubPost->title }}</a>
                            </li>
                            <li class="{{ Request::is('admin/'.$typeSubPost->slug.'sub-posts/create') ? 'active' : null }}">
                                <a href="{{ route('sub-posts.create', ['typePost' => $typeSubPost->slug]) }}"><i
                                            class="fa fa-circle-o"></i>Thêm mới {{ $typeSubPost->title }}</a>
                            </li>
                        </ul>
                    </li>
                @endforeach

                <li class="header">Thông tin trang và menu</li>
                <li class="{{ Request::is('admin/menus', 'admin/menus/create') ? 'active' : null }} treeview">
                    <a href="{{ route('menus.index') }}">
                        <i class="fa fa-bars" aria-hidden="true"></i> <span>Menu</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is( 'admin/menus' ) ? 'active' : null }}">
                            <a href="{{ route('menus.index') }}"><i class="fa fa-circle-o"></i>Tất cả menu</a>
                        </li>
                        <li class="{{ Request::is('admin/menus/create') ? 'active' : null }}">
                            <a href="{{ route('menus.create') }}"><i class="fa fa-circle-o"></i>Thêm mới menu</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/information', 'admin/information/create') ? 'active' : null }} ">
                    <a href="{{ route('information.index') }}">
                        <i class="fa fa-info-circle" aria-hidden="true"></i> <span>Thông tin trang</span>
                    </a>
                </li>
                @endif


                <li class="header" title="Dạng bài viết, trường dữ liệu, trường thông tin, template">Cài Đặt Website
                </li>
                <li class="{{ Request::is('admin/type-sub-post', 'admin/type-input', 'admin/type-information', 'admin/templates') ? 'active' : null }} treeview">
                    <a>
                        <i class="fa fa-wrench" aria-hidden="true"></i> <span>Cài đặt</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is( 'admin/type-sub-post' ) ? 'active' : null }}">
                            <a href="{{ route('type-sub-post.index') }}"><i class="fa fa-clipboard"
                                                                            aria-hidden="true"></i> Dạng bài viết</a>
                        </li>
                        <li class="{{ Request::is( 'admin/type-input' ) ? 'active' : null }}">
                            <a href="{{ route('type-input.index') }}"><i class="fa fa-keyboard-o"
                                                                         aria-hidden="true"></i> Trường dữ liệu</a>
                        </li>
                        <li class="{{ Request::is( 'admin/type-information' ) ? 'active' : null }}">
                            <a href="{{ route('type-information.index') }}"><i class="fa fa-info-circle"
                                                                               aria-hidden="true"></i> Trường Thông tin</a>
                        </li>
                        <li class="{{ Request::is( 'admin/templates' ) ? 'active' : null }}">
                            <a href="{{ route('templates.index') }}"><i class="fa fa-desktop" aria-hidden="true"></i>
                                Template</a>
                        </li>
                    </ul>
                </li>

            </ul>
    </section>
    <!-- /.sidebar -->

</aside>
