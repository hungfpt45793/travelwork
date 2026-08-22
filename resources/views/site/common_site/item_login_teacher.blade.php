<div class="login">
    <ul class="nav justify-content-end menu_pc_right">
        @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 3)
        <li class="nav-item cursor">
            <a class="clWhite nav-link whiteIm f17 button_active_course" href="{{ route('list_teacher_courses') }}" ><i class="fa fa-check-circle f17 mgr5" aria-hidden="true"></i>Quản lý <span class="mbdsNone">khóa học</span> </a>
        </li>
        @else
            @if(\Illuminate\Support\Facades\Auth::check())
                <li class="nav-item cursor">
                    <a class="clWhite nav-link whiteIm f17 button_active_course" data-toggle="modal"
                       data-target="#show_active_course"><i class="fa fa-check-circle f17 mgr5" aria-hidden="true"></i>Kích hoạt <span class="mbdsNone">khóa học</span> </a>
            </li>
                @else
                <li class="nav-item cursor">
                    <a class="clWhite nav-link whiteIm f17 button_active_course" href="{{ route('employee_register') }}?url=kich-hoat-khoa-hoc" ><i class="fa fa-check-circle f17 mgr5" aria-hidden="true"></i>Kích hoạt <span class="mbdsNone">khóa học</span> </a>
                </li>
                @endif
            @endif
        @if (\Illuminate\Support\Facades\Auth::check())
            @if (\Illuminate\Support\Facades\Auth::user())
                <?php
                $user_id = \Illuminate\Support\Facades\Auth::user()->id;
                $count_noti = 0;
                $count_noti = \App\Entity\NotificationWindow::count_Noti($user_id);
                ?>
                @if(\Illuminate\Support\Facades\Auth::user()->role == 5)
                    <li class="nav-item cursor">
                        <a class="clWhite nav-link whiteIm f17" href=" {{ route('staff_employee.index') }} ">
                            <i class="far fa-bell fw6"></i> <span>Quản lý</span>@if(!empty($count_noti)) <sup
                                    class="whiteIm">({{ $count_noti }})</sup> @endif
                        </a>
                    </li>
                @else

                    @if(\Illuminate\Support\Facades\Auth::user()->role == 1)
                        <li class="nav-item cursor">
                            <a class="clWhite nav-link whiteIm f17 button_go_class" href="{{ route('course_myCourse') }}">
                                <i class="far fa-user-circle"></i>
                                Vào học <span class="mbdsNone">ngay</span>
                            </a>
                        </li>
                    @endif
                    @if(\Illuminate\Support\Facades\Auth::user()->role == 2)
                        <li class="nav-item cursor">
                            <a class="clWhite nav-link whiteIm f17 " href="{{ route('noti_employer') }}">
                                <i class="far fa-bell fw6"></i>@if(!empty($count_noti)) <sup
                                        class="whiteIm">({{ $count_noti }})</sup> @endif
                            </a>
                        </li>
                    @endif
                    @if(\Illuminate\Support\Facades\Auth::user()->role == 3)
                        <li class="nav-item cursor">
                            <a class="clWhite nav-link whiteIm f17 " href="{{ route('noti_teacher') }}">
                                <i class="far fa-bell fw6"></i>@if(!empty($count_noti)) <sup
                                        class="whiteIm">({{ $count_noti }})</sup> @endif
                            </a>
                        </li>

                    @endif

                @endif
            @endif
        @else
            <li class="nav-item cursor text-center bdLeftWhite lg-noBorderLeft border_button_resginter_login">
                {{-- <i class=" white f25">Dành cho</i> --}}
                <span class="f15"><a class="hd_btn_res" href="{{ route('register') }}" title="đăng ký">Đăng ký</a> </span>
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
            <?php  $public_support = \App\Entity\Category::getDetailCategory('ho-tro-khoa-hoc');
            $supports = \App\Entity\Post::categoryShowAsc('ho-tro-khoa-hoc', 20);
            ?>
        </li>
        @if(!empty($supports))
            <div class="dropdown-menu dropdown-menu-right dropSupport">
                <div class="dropTitle">
                    <span class="hiddenAjax showAjax"><i class="fas fa-arrow-left"></i></span>
                    <h3 class="clWhite"> Hỗ trợ</h3>
                    <span class="removeSupport">x</span>
                    <div class="searchAjaxNew">
                        <form class="" method="get" action="{{ route('site_category_post',['slug_cate'=> 'ho-tro-khoa-hoc']) }}">
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

