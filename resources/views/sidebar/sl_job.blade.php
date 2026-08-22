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
                <li class="header">Việc làm từ NTD</li>
                <li class="{{ Request::is('admin/job', 'admin/job/create' ,'admin/tin-het-han','admin/tin-thuong','admin/tin-vip','admin/tin-da-xoa') ? 'active' : null }} treeview">
                    <a href="{{ route('posts.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Việc Làm</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/job/create') ? 'active' : null }}">
                            <a href="{{ route('job.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới việc làm</a>
                        </li>
                        <li class="{{ Request::is('admin/job') ? 'active' : null }}">
                            <a href="{{ route('job.index') }}"><i class="fa fa-line-chart"></i>Tất cả việc làm</a>
                        </li>
                        <li class="{{ Request::is('admin/tin-de-nghi-xoa') ? 'active' : null }}">
                            <a href="{{ route('listJobDeleteRequest') }}"><i class="fa fa-line-chart"></i>DS đề nghị xóa</a>
                        </li>
                        <li class="{{ Request::is('admin/tin-het-han') ? 'active' : null }}">
                            <a href="{{ route('list_date_end') }}"><i class="fa fa-line-chart"></i>Tin hết hạn</a>
                        </li>
                        <li class="{{ Request::is('admin/tin-vip') ? 'active' : null }}">
                            <a href="{{ route('list_vip') }}"><i class="fa fa-line-chart"></i>Tin Víp</a>
                        </li>
                        <li class="{{ Request::is('admin/tin-thuong') ? 'active' : null }}">
                            <a href="{{ route('list_believe') }}"><i class="fa fa-line-chart"></i>Tin thường</a>
                        </li>
                        <li class="{{ Request::is('admin/tin-da-xoa') ? 'active' : null }}">

                            <a href="{{ route('list_delete') }}"><i class="fa fa-line-chart"></i>Tin đã xóa</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ Request::is('admin/career', 'admin/career/create') ? 'active' : null }} treeview">
                    <a href="{{ route('career.index') }}">
                        <i class="fa fa-list-alt" aria-hidden="true"></i> <span>Danh mục ngành nghề</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/career') ? 'active' : null }}">
                            <a href="{{ route('career.index') }}"><i class="fa fa-line-chart"></i>Tất cả Danh mục</a>
                        </li>
                        <li class="{{ Request::is('admin/career/create') ? 'active' : null }}">
                            <a href="{{ route('career.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới Danh mục</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ Request::is('admin/job-group', 'admin/job-group/create', 'admin/job-group/edit') ? 'active' : null }} treeview">
                    <a href="{{ route('job-group.index') }}">
                        <i class="fa fa-object-group" aria-hidden="true"></i> <span>Nhóm Việc Làm Thêm</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/job-group') ? 'active' : null }}">
                            <a href="{{ route('job-group.index') }}"><i class="fa fa-line-chart"></i>Tất cả nhóm việc làm</a>
                        </li>
                        <li class="{{ Request::is('admin/job-group/create') ? 'active' : null }}">
                            <a href="{{ route('job-group.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới nhóm việc làm</a>
                        </li>
                    </ul>
                </li>


                <li class="{{ Request::is('admin/job_app', 'admin/job_app/create', 'admin/job_app/edit') ? 'active' : null }} treeview">
                    <a href="{{ route('job_app.index') }}">
                        <i class="fa fa-object-group" aria-hidden="true"></i> <span>Mẫu đơn xin việc</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/job-group') ? 'active' : null }}">
                            <a href="{{ route('job_app.index') }}"><i class="fa fa-line-chart"></i>Tất cả Đơn xin việc</a>
                        </li>
                        <li class="{{ Request::is('admin/job-group/create') ? 'active' : null }}">
                            <a href="{{ route('job_app.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới Đơn xin việc</a>
                        </li>
                    </ul>
                </li>




                <li class="{{\Illuminate\Support\Facades\Request::is('admin/jobApproval') ? 'active' : null}}">
                    <a href="{{ route('jobApproval') }}">
                        <i class="fa fa-check-circle" aria-hidden="true"></i> <span>Việc làm cần phê duyệt</span>
                    </a>
                </li>

                <li class="{{\Illuminate\Support\Facades\Request::is('admin/jobInventory') ? 'active' : null}}">
                    <a href="{{ route('jobInventory') }}">
                        <i class="fa fa-ambulance" aria-hidden="true"></i> <span>Việc làm tồn</span>
                    </a>
                </li>

                <li class="{{\Illuminate\Support\Facades\Request::is('admin/jobVip') ? 'active' : null}}">
                    <a href="{{ route('jobVip') }}">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i> <span>Việc làm vip</span>
                    </a>
                </li>

                <li class="{{\Illuminate\Support\Facades\Request::is('admin/jobEnough') ? 'active' : null}}">
                    <a href="{{ route('jobEnough') }}">
                        <i class="fa fa-users" aria-hidden="true"></i> <span>Việc làm tuyển đủ người</span>
                    </a>
                </li>

                <li class="header">Việc làm từ Facebook</li>

                <li class="{{ Request::is('admin/job-facebook','admin/total_user_facebook','admin/job-facebook/create','admin/danh-sach-tin-facebook-da-xoa') ? 'active' : null }} treeview">
                    <a href="{{ route('job-facebook.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Việc làm từ Facebook</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/job-facebook/create') ? 'active' : null }}">
                            <a href="{{ route('job-facebook.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới việc làm</a>
                        </li>
                        <li class="{{ Request::is('admin/job-facebook') ? 'active' : null }}">
                            <a href="{{ route('job-facebook.index') }}"><i class="fa fa-line-chart"></i>Tất cả việc làm</a>
                        </li>
                        <li class="{{ Request::is('admin/danh-sach-tin-facebook-da-xoa') ? 'active' : null }}">
                            <a href="{{ route('job_facebook_delete') }}"><i class="fa fa-line-chart"></i>Tất cả việc làm đã  xóa</a>
                        </li>

                        <li class="{{Request::is('admin/total_user_facebook') ? 'active' : null}}">
                            <a href="{{ route('total_user_facebook') }}">
                                <i class="fa fa-facebook-square" aria-hidden="true"></i> <span>Tổng hợp user đăng tin</span>
                            </a>
                        </li>


                    </ul>
                </li>


                <li class="header">Nộp hồ sơ</li>

                <li class="{{ Request::is('admin/status_submit_job','admin/status_submit_job','admin/status_submit_job/create') ? 'active' : null }} treeview">
                    <a href="{{ route('status_submit_job.index') }}">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Cấu hình trạng thái hồ sơ</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/status_submit_job/create') ? 'active' : null }}">
                            <a href="{{ route('status_submit_job.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới trạng thái </a>
                        </li>
                        <li class="{{ Request::is('admin/status_submit_job') ? 'active' : null }}">
                            <a href="{{ route('status_submit_job.index') }}"><i class="fa fa-line-chart"></i>Danh sách trạng thái</a>
                        </li>


                    </ul>
                </li>

                @endif
            </ul>
    </section>
    <!-- /.sidebar -->

</aside>
