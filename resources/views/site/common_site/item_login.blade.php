<div class="login">
    <ul class="nav justify-content-end menu_pc_right">
        <li class="nav-item cursor mbdsNone">
            <a class="clWhite nav-link whiteIm f17" href="{{ route('list_price') }}"><i class="fas fa-donate f20"></i>
                Bảng giá</a>
        </li>
        @if (\Illuminate\Support\Facades\Auth::check())
            @if (\Illuminate\Support\Facades\Auth::user())
                <?php
                $user_id = \Illuminate\Support\Facades\Auth::user()->id;
                $count_noti = 0;
                $count_noti = \App\Entity\NotificationWindow::count_Noti($user_id);
                ?>
                @if(\Illuminate\Support\Facades\Auth::user()->role == 5)
                    <li class="nav-item cursor dropdown">
                        <a class="clWhite nav-link whiteIm f17 " href=" {{ route('staff_employee.index') }} ">
                            <i class="far fa-bell fw6"></i> <span>Quản lý</span>@if(!empty($count_noti)) <sup
                                    class="whiteIm">({{ $count_noti }})</sup> @endif
                        </a>
                    </li>
                @else
                    <li class="nav-item cursor dropdown nav_list_dropdown">
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 1)
                            <a class="clWhite nav-link f17 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-users-cog"></i> Quản lý
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('show_step_profile_employee') }}">
                                    <i class="far fa-edit fw6"></i> Hồ sơ của bạn
                                </a>
                                <a class="dropdown-item" href="{{ route('course_myCourse') }}">
                                    <i class="fas fa-chalkboard-teacher fw6"></i> Khóa học của bạn
                                </a>
                                <a class="dropdown-item" href="{{ route('list_Jobs_Submit_Employee') }}">
                                    <i class="far fa-file-alt fw6"></i> Việc làm về du lịch
                                </a>
                                <a class="dropdown-item" href="{{ route('list_post') }}">
                                    <i class="fas fa-donate fw6"></i> Kiếm tiền từ Travelwork
                                </a>
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
                                <a class="clWhite nav-link f17 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-users-cog"></i> Quản lý
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{ route('show_file_job_facebook') }}">
                                        <i class="far fa-edit fw6"></i> Hồ sơ tuyển dụng
                                    </a>
                                    <a class="dropdown-item" href="{{ route('getAllJobs') }}">
                                        <i class="far fa-list-alt fw6"></i>
                                        Danh sách tin tuyển dụng
                                    </a>
                                    <a class="dropdown-item" href="{{ route('list_Job_Candidate_Employee') }}">
                                        <i class="far fa-file fw6"></i>
                                        Hồ sơ ứng tuyển
                                    </a>
                                    <a class="dropdown-item" href="{{ route('list_transaction_coin_employer') }}">
                                        <i class="fas fa-history fw6"></i>
                                        Điểm nhà tuyển dụng
                                    </a>
                                    <a class="dropdown-item" href="{{ route('show_intership') }}">
                                        <i class="fas fa-user-graduate fw6"></i>
                                        Cổng thực tập
                                    </a>
                                    <a class="dropdown-item" href="{{ route('showExam') }}">
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
                            <a class="clWhite nav-link whiteIm f17 " href="{{ route('noti_teacher') }}">
                                <i class="far fa-bell fw6"></i>
                                @if(!empty($count_noti))
                                    <sup class="whiteIm">({{ $count_noti }})</sup>
                                @endif
                            </a>
                        @endif
                    </li>
                @endif
            @endif
        @else
            <li class="nav-item cursor text-center  lg-noBorderLeft border_button_resginter_login">
                {{-- <i class=" white f25">Dành cho</i> --}}
                <span class="f15"><a class="hd_btn_res" href="{{ route('register') }}"
                                     title="đăng ký">Đăng ký</a> </span>
                <span class="nav-link white hvWhite f15 pdt0 clWhite hd_btn_login" data-toggle="modal"
                      data-target="#loginTiva">Đăng nhập
                </span>
            </li>
        @endif

        {{--<li class="nav-item cursor">--}}
        {{--<a class="nav-link white f17" style="color: #fff"><i class="fas fa-question-circle f20" ></i> Hỗ trợ</a>--}}
        {{--</li>--}}
        {{--<div class="btn-group">--}}
        <li class="nav-item cursor mbdsNone">
            <button type="button" class="btn btn-secondary showsupport" style="background: none;border: none;
    margin-top: 2px;" id="showsupport">
                <i class="fas fa-question-circle f20"></i> Hỗ trợ
            </button>
            <?php  $public_support = \App\Entity\Category::getDetailCategory('ho-tro');
            $supports = \App\Entity\Post::categoryShowAsc('ho-tro', 20);
            ?>
        </li>
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
        {{--</div>--}}


    </ul>
</div>
