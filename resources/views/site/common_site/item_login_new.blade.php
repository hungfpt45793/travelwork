<ul>
    @if (!\Illuminate\Support\Facades\Auth::check())
        <li class="hd_button_login">
            <a data-toggle="modal" title="Đăng nhập"
               data-target="#loginTiva">Đăng nhập</a>
        </li>
        <li class="hd_button_res">
            <a href="{{ route('register')}}" title="Đăng ký">Đăng ký</a>
        </li>
    @else
        <?php
        $user_id = \Illuminate\Support\Facades\Auth::user()->id;
        $count_noti = 0;
        $count_noti = \App\Entity\NotificationWindow::count_Noti($user_id);
        ?>
        @if(\Illuminate\Support\Facades\Auth::user()->role == 5)
            <li class="nav-item cursor dropdown">
                <a class="clWhite nav-link whiteIm f17 " href=" {{ route('staff_employee.index') }} " title="Quản lý">
                    <i class="far fa-bell fw6"></i> <span>Quản lý</span>@if(!empty($count_noti)) <sup
                            class="whiteIm">({{ $count_noti }})</sup> @endif
                </a>
            </li>

        @else
            <li class="nav-item cursor dropdown nav_list_dropdown">
                @if(\Illuminate\Support\Facades\Auth::user()->role == 1)
                    <a class="clWhite nav-link f17 dropdown-toggle dropdown_show_a" href="#" id="navbarDropdown"
                       role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-users-cog"></i> Quản lý
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('show_step_profile_employee') }}" title="Hồ sơ của bạn">
                            <i class="far fa-edit fw6"></i> Hồ sơ của bạn
                        </a>
                        <a class="dropdown-item" href="{{ route('course_myCourse') }}" title="Khóa học của bạn">
                            <i class="fas fa-graduation-cap fw6"></i> Khóa học của bạn
                        </a>
                        <a class="dropdown-item" href="{{ route('list_Jobs_Submit_Employee') }}"
                           title="Việc làm về du lịch">
                            <i class="fas fa-briefcase fw6"></i> Việc làm về du lịch
                        </a>
                        <a class="dropdown-item" href="{{ route('list_post') }}" title="Kiếm tiền từ SKT">
                            <i class="fas fa-donate fw6"></i> Kiếm tiền từ Travelwork
                        </a>
                        @if(\Illuminate\Support\Facades\Auth::user()->user_advise_support == 1)
                            {{--//gia sư - danh sách kế toán cần tư vấn--}}
                            <a class="dropdown-item" href="{{ route('list_advise_user') }}" title=" Việc làm du lịch cần tư vấn">
                                <i class="fas fa-users fw6"></i> Việc làm du lịch cần tư vấn
                            </a>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->user_advise_support == 2)
                            {{--kế toán danh sách nhưng gia sư muốn tư vấn--}}
                            <a class="dropdown-item" href="{{ route('list_support_user') }}" title="Gia sư tư vấn">
                                <i class="fas fa-users fw6"></i> Gia sư tư vấn
                            </a>
                        @endif

                        <a class="dropdown-item" href="{{ route('noti_employee') }}">
                            <i class="far fa-bell fw6"></i>
                            Thông báo
                            @if(!empty($count_noti))
                                <sup class="whiteIm">({{ $count_noti }})</sup>
                            @endif</a>
                        <a class="dropdown-item" href="/dang-xuat">
                            <i class="fas fa-sign-out-alt"></i>
                            Đăng xuất
                        </a>
                    </div>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->role == 2)
                    <a class="clWhite nav-link f17 dropdown-toggle dropdown_show_a" href="#" id="navbarDropdown"
                       role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-users-cog"></i> Quản lý
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item" href="{{ route('show_file_job_facebook') }}" title="Hồ sơ tuyển dụng">
                            <i class="far fa-edit fw6"></i> Hồ sơ tuyển dụng
                        </a>
                        <a class="dropdown-item" href="{{ route('getAllJobs') }}" title="Danh sách tin tuyển dụng">
                            <i class="far fa-list-alt fw6"></i>
                            Danh sách tin tuyển dụng
                        </a>
                        <a class="dropdown-item" href="{{ route('list_Job_Candidate_Employee') }}"
                           title="Hồ sơ ứng tuyển">
                            <i class="far fa-file fw6"></i>
                            Hồ sơ ứng tuyển
                        </a>
                        <a class="dropdown-item" href="{{ route('list_transaction_coin_employer') }}"
                           title="Điểm nhà tuyển dụng">
                            <i class="fas fa-history fw6"></i>
                            Điểm nhà tuyển dụng
                        </a>
                        <a class="dropdown-item" href="{{ route('show_intership') }}" title="Cổng thực tập">
                            <i class="fas fa-user-graduate fw6"></i>
                            Cổng thực tập
                        </a>
                        <a class="dropdown-item" href="{{ route('showExam') }}" title="Đề thi trắc nghiệm về du lịch">
                            <i class="fas fa-stream fw6"></i>
                            Đề thi trắc nghiệm về du lịch
                        </a>
                        <a class="dropdown-item" href="{{ route('noti_employee') }}">
                            <i class="far fa-bell fw6"></i> Thông báo
                            @if(!empty($count_noti))
                                <sup class="whiteIm">({{ $count_noti }})</sup>
                            @endif</a>
                        <a class="dropdown-item" href="/dang-xuat">
                            <i class="fas fa-sign-out-alt"></i>
                            Đăng xuất
                        </a>
                    </div>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->role == 3)

                    <a class="clWhite nav-link f17 dropdown-toggle dropdown_show_a" href="#" id="navbarDropdown"
                       role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-users-cog"></i> Quản lý
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item" href="{{ route('show_file_job_facebook') }}" title="Quản lý hồ sơ">
                            <i class="far fa-edit fw6"></i> Quản lý hồ sơ
                        </a>
                        <a class="dropdown-item" href="{{ route('showExam') }}" title=" Quản lý đề thi">
                            <i class="far fa-question-circle"></i>
                            Quản lý đề thi
                        </a>
                        <a class="dropdown-item" href="{{ route('room.index') }}" title=" Quản lý phòng thi">
                            <i class="fab fa-chromecast"></i>
                            Quản lý phòng thi
                        </a>

                        <a class="dropdown-item" href="{{ route('noti_teacher') }}">
                            <i class="far fa-bell fw6"></i> Thông báo
                            @if(!empty($count_noti))
                                <sup class="whiteIm">({{ $count_noti }})</sup>
                            @endif</a>
                        <a class="dropdown-item" href="/dang-xuat">
                            <i class="fas fa-sign-out-alt"></i>
                            Đăng xuất
                        </a>
                    </div>
                @endif
            </li>
        @endif
    @endif


    <li class="hd_button_question">
        <a class="showsupport" id="showsupport"><i class="fas fa-question"></i></a>
        <?php  $public_support = \App\Entity\Category::getDetailCategory('ho-tro');
        $supports = \App\Entity\Post::categoryShowAsc('ho-tro', 20);
        ?>
    </li>
</ul>
@if(!empty($supports))
    <div class="dropdown-menu dropdown-menu-right dropSupport">
        <div class="dropTitle">
            <span class="hiddenAjax showAjax"><i class="fas fa-arrow-left"></i></span>
            <h3 class="clWhite"> Hỗ trợ</h3>
            <span class="removeSupport">x</span>
            <div class="searchAjaxNew">
                <form class="" method="get" action="{{ route('site_category_post',['slug_cate'=> 'ho-tro']) }}">
                    <div class="form-group row mgb0">
                        <div class="col-sm-12">
                            <button type="submit"><i class="fas fa-search"></i></button>
                            <input type="text" class="form-control searchAjax" name="word"
                                   placeholder="Tìm kiếm hỗ trợ ..." autocomplete="off">
                        </div>
                    </div>
                </form>
                <div class="ContentSearch">

                </div>
            </div>
        </div>
        <div class="DropContent">
            @foreach( $supports as  $support)
                <a data-id="{{ $support->post_id }}">
                            <span>
                                <i class="fas fa-caret-right"></i>
                                {{ isset($support['title']) ? $support['title'] : '' }}
                            </span>
                </a>
            @endforeach
        </div>
        <div class="DropContentItem hiddenAjax">
        </div>
    </div>
@endif
