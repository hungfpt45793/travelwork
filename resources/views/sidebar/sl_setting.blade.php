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


            @if(!\App\Entity\User::isMember(\Illuminate\Support\Facades\Auth::user()->role))


                {{--<li class="{{ Request::is('admin/cau-hinh-getfly') ? 'active' : null }} ">--}}
                    {{--<a href="{{ route('setting_getfly') }}">--}}
                        {{--<i class="fa fa-cogs" aria-hidden="true"></i> <span>Cài đặt getfly</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                <li class="{{ Request::is('admin/coe', 'admin/coe/create') ? 'active' : null }} treeview">
                    <a href="{{ route('coe.index') }}">
                        <i class="fa fa-cogs" aria-hidden="true"></i> <span>Thống kê hệ số lương</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/coe') ? 'active' : null }}">
                            <a href="{{ route('coe.index') }}"><i class="fa fa-circle-o"></i>Danh sách</a>
                        </li>
                        {{--<li class="{{ Request::is('admin/career/create') ? 'active' : null }}">--}}
                            {{--<a href="{{ route('coe.create') }}"><i class="fa fa-circle-o"></i>Thêm mới</a>--}}
                        {{--</li>--}}
                    </ul>
                </li>

                <li class="{{ Request::is('admin/career', 'admin/career/create') ? 'active' : null }} treeview">
                    <a href="{{ route('career.index') }}">
                        <i class="fa fa-cogs" aria-hidden="true"></i> <span>1.Danh mục ngành nghề </span> <br>(vị trí công việc)
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/career') ? 'active' : null }}">
                            <a href="{{ route('career.index') }}"><i class="fa fa-circle-o"></i>Danh sách</a>
                        </li>
                        <li class="{{ Request::is('admin/career/create') ? 'active' : null }}">
                            <a href="{{ route('career.create') }}"><i class="fa fa-circle-o"></i>Thêm mới</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/typeOfBusiness', 'admin/typeOfBusiness/create') ? 'active' : null }} treeview">
                    <a href="{{ route('typeOfBusiness.index') }}">
                        <i class="fa fa-id-card" aria-hidden="true"></i> <span>2.Loại hình doanh nghiệp</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/typeOfBusiness') ? 'active' : null }}">
                            <a href="{{ route('typeOfBusiness.index') }}"><i class="fa fa-line-chart"></i>Tất cả Loại hình</a>
                        </li>
                        <li class="{{ Request::is('admin/typeOfBusiness/create') ? 'active' : null }}">
                            <a href="{{ route('typeOfBusiness.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới Loại hình</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/business', 'admin/business/create') ? 'active' : null }} treeview">
                    <a href="{{ route('business.index') }}">
                        <i class="fa fa-briefcase" aria-hidden="true"></i> <span>3.Loại hình kinh doanh</span> <br>(loại hình sở hữu)
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/business') ? 'active' : null }}">
                            <a href="{{ route('business.index') }}"><i class="fa fa-line-chart"></i>Tất cả Loại hình</a>
                        </li>
                        <li class="{{ Request::is('admin/business/create') ? 'active' : null }}">
                            <a href="{{ route('business.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới Loại hình</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ Request::is('admin/literacy', 'admin/literacy/create') ? 'active' : null }} treeview">
                    <a href="{{ route('literacy.index') }}">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i> <span>4.Trình độ học vấn</span><br>(bằng cấp)
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/literacy') ? 'active' : null }}">
                            <a href="{{ route('literacy.index') }}"><i class="fa fa-circle-o"></i>Tất cả Trình độ</a>
                        </li>
                        <li class="{{ Request::is('admin/literacy/create') ? 'active' : null }}">
                            <a href="{{ route('literacy.create') }}"><i class="fa fa-circle-o"></i>Thêm mới Trình độ</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ Request::is('admin/office', 'admin/office/create') ? 'active' : null }} treeview">
                    <a href="{{ route('office.index') }}">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i> <span>5.Tin học văn phòng</span><br>(bằng cấp - bổ sung)
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/office') ? 'active' : null }}">
                            <a href="{{ route('office.index') }}"><i class="fa fa-circle-o"></i>Tất cả Trình độ</a>
                        </li>
                        <li class="{{ Request::is('admin/office/create') ? 'active' : null }}">
                            <a href="{{ route('office.create') }}"><i class="fa fa-circle-o"></i>Thêm mới Trình độ</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/exp_pos', 'admin/exp_pos/create') ? 'active' : null }} treeview">
                    <a href="{{ route('exp_pos.index') }}">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i> <span>6.Kinh nghiệm vị trí khác</span><br>(bổ sung - dc chọn nhiều vị trí)
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/exp_pos') ? 'active' : null }}">
                            <a href="{{ route('exp_pos.index') }}"><i class="fa fa-circle-o"></i>Tất cả Trình độ</a>
                        </li>
                        <li class="{{ Request::is('admin/exp_pos/create') ? 'active' : null }}">
                            <a href="{{ route('exp_pos.create') }}"><i class="fa fa-circle-o"></i>Thêm mới Kinh nghiệmộ</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/exp_bus', 'admin/exp_bus/create') ? 'active' : null }} treeview">
                    <a href="{{ route('exp_bus.index') }}">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i> <span>7.Kinh nghiệm loại hình DN</span><br>(bổ sung)
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/exp_bus') ? 'active' : null }}">
                            <a href="{{ route('exp_bus.index') }}"><i class="fa fa-circle-o"></i>Tất cả Kinh nghiệm</a>
                        </li>
                        <li class="{{ Request::is('admin/exp_bus/create') ? 'active' : null }}">
                            <a href="{{ route('exp_bus.create') }}"><i class="fa fa-circle-o"></i>Thêm mới Kinh nghiệm loại hình DN</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/software', 'admin/software/create') ? 'active' : null }} treeview">
                    <a href="{{ route('software.index') }}">
                        <i class="fa fa-desktop" aria-hidden="true"></i> <span>8.Phần mềm kế toán</span>
                        <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/software') ? 'active' : null }}">
                            <a href="{{ route('software.index') }}"><i class="fa fa-circle-o"></i>Tất cả Phần mềm</a>
                        </li>
                        <li class="{{ Request::is('admin/software/create') ? 'active' : null }}">
                            <a href="{{ route('software.create') }}"><i class="fa fa-circle-o"></i>Thêm mới Phần mềm</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/lang', 'admin/lang/create') ? 'active' : null }} treeview">
                    <a href="{{ route('lang.index') }}">
                        <i class="fa fa-desktop" aria-hidden="true"></i> <span>9.Trình độ ngoại ngữ</span><br>(bổ sung)
                        <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/lang') ? 'active' : null }}">
                            <a href="{{ route('lang.index') }}"><i class="fa fa-circle-o"></i>Tất cả ngoại ngữ</a>
                        </li>
                        <li class="{{ Request::is('admin/lang/create') ? 'active' : null }}">
                            <a href="{{ route('lang.create') }}"><i class="fa fa-circle-o"></i>Thêm mới ngoại ngữ</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/soft', 'admin/soft/create') ? 'active' : null }} treeview">
                    <a href="{{ route('soft.index') }}">
                        <i class="fa fa-desktop" aria-hidden="true"></i> <span>10.Kỹ năng mềm</span><br>(bổ sung)
                        <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/soft') ? 'active' : null }}">
                            <a href="{{ route('soft.index') }}"><i class="fa fa-circle-o"></i>Tất cả Kỹ năng</a>
                        </li>
                        <li class="{{ Request::is('admin/soft/create') ? 'active' : null }}">
                            <a href="{{ route('soft.create') }}"><i class="fa fa-circle-o"></i>Thêm mới Kỹ năng</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/cert', 'admin/cert/create') ? 'active' : null }} treeview">
                    <a href="{{ route('cert.index') }}">
                        <i class="fa fa-desktop" aria-hidden="true"></i> <span>11.Chứng chỉ nghề nghiệp</span><br>(bổ sung)
                        <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/cert') ? 'active' : null }}">
                            <a href="{{ route('cert.index') }}"><i class="fa fa-circle-o"></i>Tất cả chứng chỉ</a>
                        </li>
                        <li class="{{ Request::is('admin/cert/create') ? 'active' : null }}">
                            <a href="{{ route('cert.create') }}"><i class="fa fa-circle-o"></i>Thêm mới chứng chỉ</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/work', 'admin/work/create') ? 'active' : null }} treeview">
                    <a href="{{ route('work.index') }}">
                        <i class="fa fa-desktop" aria-hidden="true"></i> <span>12.Khả năng chịu áp lưc CV</span><br>(bổ sung)
                        <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/work') ? 'active' : null }}">
                            <a href="{{ route('work.index') }}"><i class="fa fa-circle-o"></i>Tất cả áp lực</a>
                        </li>
                        <li class="{{ Request::is('admin/work/create') ? 'active' : null }}">
                            <a href="{{ route('work.create') }}"><i class="fa fa-circle-o"></i>Thêm mới áp lực</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ Request::is('admin/province', 'admin/province/create') ? 'active' : null }} treeview">
                    <a href="{{ route('province.index') }}">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i> <span>13.Thành phố (khu vực làm việc)</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/province/index') ? 'active' : null }}">
                            <a href="{{ route('province.index') }}"><i class="fa fa-circle-o"></i>Tất cả thành phố</a>
                        </li>
                        <li class="{{ Request::is('admin/province/create') ? 'active' : null }}">
                            <a href="{{ route('province.create') }}"><i class="fa fa-circle-o"></i>Thêm mới thành
                                phố</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ Request::is('admin/com', 'admin/com/create') ? 'active' : null }} treeview">
                    <a href="{{ route('com.index') }}">
                        <i class="fa fa-desktop" aria-hidden="true"></i> <span>14.Cam kết gắn bó với công ty</span><br>(bổ sung)
                        <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/com') ? 'active' : null }}">
                            <a href="{{ route('com.index') }}"><i class="fa fa-circle-o"></i>Tất cả cam kết</a>
                        </li>
                        <li class="{{ Request::is('admin/com/create') ? 'active' : null }}">
                            <a href="{{ route('com.create') }}"><i class="fa fa-circle-o"></i>Thêm mới cam kết</a>
                        </li>
                    </ul>
                </li>




                <li class="{{ Request::is('admin/salary', 'admin/salary/create') ? 'active' : null }} treeview">
                    <a href="{{ route('users.index') }}">
                        <i class="fa fa-money" aria-hidden="true"></i> <span>15.Mức lương</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/salary') ? 'active' : null }}">
                            <a href="{{ route('salary.index') }}"><i class="fa fa-circle-o"></i>Tất cả Mức lương</a>
                        </li>
                        <li class="{{ Request::is('admin/salary/create') ? 'active' : null }}">
                            <a href="{{ route('salary.create') }}"><i class="fa fa-circle-o"></i>Thêm mới Mức lương</a>
                        </li>
                    </ul>
                </li>






                <li class="{{ Request::is('admin/age', 'admin/age/create') ? 'active' : null }} treeview">
                    <a href="{{ route('age.index') }}">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i> <span>16.Độ tuổi</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/age/index') ? 'active' : null }}">
                            <a href="{{ route('age.index') }}"><i class="fa fa-circle-o"></i>Tất cả độ tuổi</a>
                        </li>
                        <li class="{{ Request::is('admin/age/create') ? 'active' : null }}">
                            <a href="{{ route('age.create') }}"><i class="fa fa-circle-o"></i>Thêm mới độ tuổi</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/experience', 'admin/experience/create') ? 'active' : null }} treeview">
                    <a href="{{ route('experience.index') }}">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i> <span>17.Kinh nghiệm</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/experience/index') ? 'active' : null }}">
                            <a href="{{ route('experience.index') }}"><i class="fa fa-circle-o"></i>Tất cả kinh
                                nghiệm</a>
                        </li>
                        <li class="{{ Request::is('admin/experience/create') ? 'active' : null }}">
                            <a href="{{ route('experience.create') }}"><i class="fa fa-circle-o"></i>Thêm mới kinh
                                nghiệm</a>
                        </li>
                    </ul>
                </li>



                <li class="{{ Request::is('admin/district', 'admin/district/create') ? 'active' : null }} treeview">
                    <a href="{{ route('district.index') }}">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i> <span>18.Quận huyện</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/district/index') ? 'active' : null }}">
                            <a href="{{ route('district.index') }}"><i class="fa fa-circle-o"></i>Tất cả quận huyện</a>
                        </li>
                        <li class="{{ Request::is('admin/district/create') ? 'active' : null }}">
                            <a href="{{ route('district.create') }}"><i class="fa fa-circle-o"></i>Thêm mới quận
                                huyện</a>
                        </li>
                    </ul>
                </li>





                <li class="{{ Request::is('admin/teacher_status', 'admin/teacher_status/create') ? 'active' : null }} treeview">
                    <a href="{{ route('teacher_status.index') }}">
                        <i class="fa fa-id-card" aria-hidden="true"></i> <span>19.Trạng thái giáo viên</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/teacher_status') ? 'active' : null }}">
                            <a href="{{ route('teacher_status.index') }}"><i class="fa fa-line-chart"></i>Tất cả trạng thái</a>
                        </li>
                        <li class="{{ Request::is('admin/teacher_status/create') ? 'active' : null }}">
                            <a href="{{ route('teacher_status.create') }}"><i class="fa fa-cart-plus"></i>Thêm mới trạng thái</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/hinh-thuc-thanh-toan') ? 'active' : null }} ">
                    <a href="{{ route('method_payment') }}">
                        <i class="fa fa-envelope" aria-hidden="true"></i> <span>Cài đặt email</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/salary', 'admin/config_meta/create') ? 'active' : null }} treeview">
                    <a href="{{ route('config_meta.index') }}">
                        <i class="fa fa-cogs" aria-hidden="true"></i> <span>Cấu hình thẻ meta SEO</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/config_meta') ? 'active' : null }}">
                            <a href="{{ route('config_meta.index') }}"><i class="fa fa-circle-o"></i>Danh sách</a>
                        </li>
                        <li class="{{ Request::is('admin/config_meta/create') ? 'active' : null }}">
                            <a href="{{ route('config_meta.create') }}"><i class="fa fa-circle-o"></i>Thêm mới</a>
                        </li>
                    </ul>
                </li>

                {{--<li class="{{ Request::is('admin/subcribe-email', 'admin/subcribe-email/create') ? 'active' : null }} treeview">--}}
                    {{--<a href="{{ route('subcribe-email.index') }}">--}}
                        {{--<i class="fa fa-graduation-cap" aria-hidden="true"></i> <span>Đăng kí nhận email</span>--}}
                        {{--<span class="pull-right-container">--}}
                            {{--<i class="fa fa-angle-left pull-right"></i>--}}
                        {{--</span>--}}
                    {{--</a>--}}
                    {{--<ul class="treeview-menu">--}}
                        {{--<li class="{{ Request::is('admin/subcribe-email/index') ? 'active' : null }}">--}}
                            {{--<a href="{{ route('subcribe-email.index') }}"><i class="fa fa-circle-o"></i>Tất cả email--}}
                                {{--đăng kí</a>--}}
                        {{--</li>--}}
                        {{--<li class="{{ Request::is('admin/subcribe-email/create') ? 'active' : null }}">--}}
                            {{--<a href="{{ route('subcribe-email.create') }}"><i class="fa fa-circle-o"></i>Thêm email đăng--}}
                                {{--kí</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->

</aside>
