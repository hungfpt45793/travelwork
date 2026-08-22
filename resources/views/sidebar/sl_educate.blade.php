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

                <li class="header">Danh mục khóa học</li>
                <li class="{{ Request::is('admin/category_course', 'admin/category_course/create' ,'category_course/edit','category_course/index') ? 'active' : null }} treeview">
                    <a href="{{ route('category_course.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/category_course/create') ? 'active' : null }}">
                            <a href="{{ route('category_course.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới danh
                                mục</a>
                        </li>
                        <li class="{{ Request::is('admin/category_course') ? 'active' : null }}">
                            <a href="{{ route('category_course.index') }}"><i class="fa fa-line-chart"></i>Danh sách
                                danh mục</a>
                        </li>

                    </ul>
                </li>

                <li class="header">Danh sách khóa học</li>
                <li class="{{ Request::is('admin/courses', 'admin/courses/create' ,'courses/edit','courses/index') ? 'active' : null }} treeview">
                    <a href="{{ route('courses.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/courses/create') ? 'active' : null }}">
                            <a href="{{ route('courses.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới khóa học
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/courses') ? 'active' : null }}">
                            <a href="{{ route('courses.index') }}"><i class="fa fa-line-chart"></i>Danh sách khóa học
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="header">Đơn hàng của khóa học</li>
                <li class="{{ Request::is('admin/course_order', 'admin/course_order/create' ,'course_order/edit','course_order/index','admin/course_order_sales_statistics') ? 'active' : null }} treeview">
                    <a href="{{ route('courses.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        {{--<li class="{{ Request::is('admin/course_order/create') ? 'active' : null }}">--}}
                        {{--<a href="{{ route('course_order.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới đơn hàng </a>--}}
                        {{--</li>--}}
                        <li class="{{ Request::is('admin/course_order') ? 'active' : null }}">
                            <a href="{{ route('course_order.index') }}"><i class="fa fa-line-chart"></i>Danh sách đơn
                                hàng </a>
                        </li>

                        <li class="{{ Request::is('admin/course_order_sales_statistics') ? 'active' : null }}">
                            <a href="{{ route('course_order_sales_statistics') }}"><i class="fa fa-line-chart"></i>Thống kê doanh số </a>
                        </li>
                    </ul>

                </li>
                <li class="header">Ứng viên đăng kí khóa học</li>
                <li class="{{ Request::is('admin/course_employee') ? 'active' : null }}">
                    <a href="{{ route('course_employee.index') }}"><i class="fa fa-line-chart"></i>Danh sách ứng viên
                    </a>
                </li>
                </li>

                <li class="header">Feedback của khóa học</li>
                <li class="{{ Request::is('admin/course_order', 'admin/course_order/create' ,'course_order/edit','course_order/index') ? 'active' : null }} treeview">
                    <a href="{{ route('courses.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/course_feedback/create') ? 'active' : null }}">
                        <a href="{{ route('course_feedback.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới feedback </a>
                        </li>
                        <li class="{{ Request::is('admin/course_feedback') ? 'active' : null }}">
                            <a href="{{ route('course_feedback.index') }}"><i class="fa fa-line-chart"></i>Danh sách feedback </a>
                        </li>

                    </ul>
                </li>
                <li class="header">Câu hỏi khóa học</li>
                <li class="{{ Request::is('admin/course_order', 'admin/course_questions/create' ,'course_questions/edit','course_questions/index') ? 'active' : null }} treeview">
                    <a href="{{ route('courses.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/course_questions/create') ? 'active' : null }}">
                        <a href="{{ route('course_questions.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới câu hỏi</a>
                        </li>
                        <li class="{{ Request::is('admin/course_questions') ? 'active' : null }}">
                            <a href="{{ route('course_questions.index') }}"><i class="fa fa-line-chart"></i>Danh sách câu hỏi </a>
                        </li>

                    </ul>
                </li>

                <li class="header">Nội dung đào tạo</li>

                <li class="{{ Request::is('admin/training') ? 'active' : null }}">
                    <a href="{{ route('training.index') }}"><i class="fa fa-line-chart"></i>Danh sách</a>
                </li>

                <li class="{{ Request::is('admin/training') ? 'active' : null }}">
                    <a href="{{ route('training.create') }}"><i class="fa fa-line-chart"></i>Thêm mới</a>
                </li>

                {{--<li class="{{ Request::is('admin/educate_teacher') ? 'active' : null }}">--}}
                {{--<a href="{{ route('educate_teacher.index') }}"><i class="fa fa-line-chart"></i>Giáo viên đào tạo</a>--}}
                {{--</li>--}}


                <li class="header">Từ khóa khóa học</li>
                <li class="{{ Request::is('admin/course_tag', 'admin/course_tag/create' ,'course_tag/edit','course_tag/index') ? 'active' : null }} treeview">
                    <a href="{{ route('courses.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Danh sách</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/course_tag/create') ? 'active' : null }}">
                            <a href="{{ route('course_tag.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới</a>
                        </li>
                        <li class="{{ Request::is('admin/course_tag') ? 'active' : null }}">
                            <a href="{{ route('course_tag.index') }}"><i class="fa fa-line-chart"></i>Danh sách </a>
                        </li>

                    </ul>
                </li>

                {{--<li class="header">Hình thức học</li>--}}

                {{--<li class="{{ Request::is('admin/educate_categories') ? 'active' : null }}">--}}
                    {{--<a href="{{ route('course_formality.index') }}"><i class="fa fa-line-chart"></i>Danh sách</a>--}}
                {{--</li>--}}

                {{--<li class="{{ Request::is('admin/educate_categories') ? 'active' : null }}">--}}
                    {{--<a href="{{ route('educate_categories.index') }}"><i class="fa fa-line-chart"></i>Chuyên mục đào tạo</a>--}}
                {{--</li>--}}
                {{--<li class="{{ Request::is('admin/educate_teacher') ? 'active' : null }}">--}}
                {{--<a href="{{ route('educate_teacher.index') }}"><i class="fa fa-line-chart"></i>Giáo viên đào tạo</a>--}}
                {{--</li>--}}
                {{--<li class="{{ Request::is('admin/educate_class/') ? 'active' : null }}">--}}
                    {{--<a href="{{ route('educate_class.index') }}"><i class="fa fa-line-chart"></i>Lớp đào tạo</a>--}}
                {{--</li>--}}


                @endif
            </ul>
    </section>
    <!-- /.sidebar -->

</aside>
