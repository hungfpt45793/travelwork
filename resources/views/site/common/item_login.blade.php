    <div class="login">
    <ul class="nav justify-content-end centerLaptopmini">
        <div class="dropdown dropdownHorder">
            {{-- <a class="nav-link whiteIm f17 dropdown-toggle " href="#" id="dropdownMenuButton" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
             <i class="fas fa-donate f20 "></i> Kiếm tiền
         </a> --}}
         <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

             @if (! \Illuminate\Support\Facades\Auth::check())
                 <a class="dropdown-item" href="#" data-toggle="modal" data-target="#loginMoney"><i
                             class="fas fa-caret-right mgr5"></i>
                     Đăng nhập với tài khoản hoặc facebook
                 </a>
             @endif
             <a class="dropdown-item" href="{{ route('show_category_post') }}"><i class="fas fa-caret-right mgr5"></i>
                Danh sách chia sẻ
             </a>
             <a class="dropdown-item" href="{{ route('list_category_post_share') }}"><i class="fas fa-caret-right mgr5"></i>
                 Tốp bài viết chia sẻ
             </a>

             <a class="dropdown-item" href="{{ route('list_change_product') }}"><i
                         class="fas fa-caret-right mgr5"></i>
                 Danh sách phần mềm đổi thưởng
             </a>
             @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 )
                 <a class="dropdown-item" href="{{ route('post_sale_employee') }}"><i
                             class="fas fa-caret-right mgr5"></i>
                     Thống kê chia sẻ của bạn
                 </a>
             @endif
             <?php  $public_suppot_post = \App\Entity\Category::getDetailCategory('huong-dan-chia-se-bai-viet');
             ?>
             @if(!empty($public_suppot_post))
                 <a class="dropdown-item"
                    href="{{ route('site_category_post',['slug_cate'=>$public_suppot_post->slug]) }}"><i
                             class="fas fa-caret-right mgr5"></i>
                     {{ isset($public_suppot_post->title) ? $public_suppot_post->title : '' }}
                 </a>
             @endif
             @if (\Illuminate\Support\Facades\Auth::check())
                 <a class="dropdown-item" href="{{route('site_contact')}}"><i class="fas fa-caret-right mgr5"></i>
                     Hòm thư góp ý
                 </a>
             @endif
             @if (\Illuminate\Support\Facades\Auth::check())
                 <a class="dropdown-item" href="{{route('logoutHome')}}"><i class="fas fa-caret-right mgr5"></i>
                     Thoát tài khoản
                 </a>
             @endif
         </div>

        </div>


        <li class="nav-item cursor">
            <a class="nav-link whiteIm f17" href="{{ route('list_price') }}"><i class="fas fa-donate f20"></i> Bảng giá</a>
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
                                        <i class="far fa-file-alt fw6"></i> Việc làm du lịch
                                    </a>
                                    <a class="dropdown-item" href="{{ route('list_post') }}">
                                        <i class="fas fa-donate fw6"></i> Kiếm tiền từ SKT
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
                                            Đề thi trắc nghiệm du lịch
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
            <li class="nav-item cursor">
                <a class="nav-link whiteIm f17" data-toggle="modal"
                   data-target="#loginTiva"><i class="fas fa-users f20"></i> Tài khoản</a>
            </li>
        @endif

        {{--<li class="nav-item cursor">--}}
        {{--<a class="nav-link white f17" style="color: #fff"><i class="fas fa-question-circle f20" ></i> Hỗ trợ</a>--}}
        {{--</li>--}}
        {{--<div class="btn-group">--}}
        <li class="nav-item cursor">
            <button type="button" class="btn btn-secondary showsupport" style="background: none;border: none;font-size: 17px;
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
                    <h3> Hỗ trợ</h3>
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


                            <span><i class="fas fa-caret-right"></i> {{ isset($support['title']) ? $support['title'] : '' }}</span>

                        </a>
                    @endforeach
                </div>
                <div class="DropContentItem hiddenAjax">
                </div>
            </div>
        @else
            <div class="dropdown-menu dropdown-menu-right dropSupport">
                <div class="dropTitle">
                    <span class="hiddenAjax showAjax"><i class="fas fa-arrow-left"></i></span>
                    <h3> Hỗ trợ</h3>
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


                            <span><i class="fas fa-caret-right"></i> {{ isset($support['title']) ? $support['title'] : '' }}</span>

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
