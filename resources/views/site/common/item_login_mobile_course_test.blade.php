<a class="navbar-brand hiddenTabLogo" href="/"> <img class="lazy" src="{{ isset($information['logo']) ?  $information['logo'] : '' }}" alt="sanketoan.vn" title="sanketoan.vn"></a>


<?php
$url_not_button = '';
$url_not_button = \App\Ultility\Ultility::getUrl();
?>

@if($url_not_button == 'https://sanketoan.vn:443/')
    <a class="navbar-brand showTabLogo dsNone" href="/"> <img class="lazy" src="{{ isset($information['icon']) ?  $information['icon'] : '' }}" alt="sanketoan.vn" title="sanketoan.vn"></a>
@else
    <button type="button" id="js_sidebarCollapse" class="navbar-brand showTabLogo  bgrBlueN button_toggle_vertical">
        <svg class="svg-inline--fa fa-align-left fa-w-14" aria-hidden="true" data-prefix="fas"
             data-icon="align-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
             data-fa-i2svg="">
            <path fill="currentColor"
                  d="M288 44v40c0 8.837-7.163 16-16 16H16c-8.837 0-16-7.163-16-16V44c0-8.837 7.163-16 16-16h256c8.837 0 16 7.163 16 16zM0 172v40c0 8.837 7.163 16 16 16h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16zm16 312h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm256-200H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16h256c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16z"></path>
        </svg>
    </button>
@endif



<ul class="loginMobile">
    <li>
        <div class="dropdown dropdownMobileHorder">


            <a type="button" class="nav-link whiteIm f17" data-toggle="modal" data-target="#kich_hoat_klhoa_hoc">
                <i class="fas fa-check-circle"></i> Kích Hoạt
            </a>

        </div>

    </li>


    @if (\Illuminate\Support\Facades\Auth::check())
        @if (\Illuminate\Support\Facades\Auth::user())

            <?php
            $user_id = \Illuminate\Support\Facades\Auth::user()->id;
            $count_noti = 0;
            $count_noti = \App\Entity\NotificationWindow::count_Noti($user_id);
            ?>
            @if(\Illuminate\Support\Facades\Auth::user()->role == 5)

                <li >

                    <a class="nav-link blueN fw7" href="{{ route('staff_employee.index') }} " style="border-right: none">
                        <i class="far fa-bell fw6"></i> <span>Quản lý</span>
                    </a>
                </li>
            @else
                <li>
                    <a class="nav-link blueN fw7" href=" @if(\Illuminate\Support\Facades\Auth::user()->role == 1)
                    {{ route('noti_employee') }}
                    @endif
                    @if(\Illuminate\Support\Facades\Auth::user()->role == 2)
                    {{ route('noti_employer') }}
                    @endif
                    @if(\Illuminate\Support\Facades\Auth::user()->role == 3)
                    {{ route('noti_teacher') }}
                    @endif ">
                        <i class="far fa-bell fw6 f20 pdl5 pdr5"></i> @if(!empty($count_noti)) <sup
                            class="whiteIm mbdsNone">({{ $count_noti }})</sup> @endif
                    </a>
                </li>
            @endif

        @endif
    @else
        <li class="nav-item cursor" style="border-right: none">
            <a class="nav-link whiteIm f17 mobile_acount" data-toggle="modal"
               data-target="#loginTiva"><i class="fas fa-users f20"></i> Tài khoản</a>
        </li>
    @endif


    <li>
        <?php  $public_support = \App\Entity\Category::getDetailCategory('ho-tro');
        $supports = \App\Entity\Post::categoryShowAsc('ho-tro',8);
        ?>
    </li>
</ul>

@if(!empty($supports))
    <div class="dropdown-menu dropdown-menu-right" style="width: 400px;">
        @foreach( $supports as  $support)
            <a href="{{ route('post', ['cate_slug' => $public_support->slug, 'post_slug' => $support->slug]) }}"
               title="{{ isset($support['title']) ? $support['title'] : '' }}">

                <button class="dropdown-item" type="button">  <i class="fas fa-caret-right"></i> {{ isset($support['title']) ? $support['title'] : '' }}</button>
            </a>
        @endforeach
        <a href="{{ route('site_category_post',['slug_cate'=>$public_support['slug']]) }}" class="text-center" style="  width: 100%;
    display: block;"><span style="border: 1px solid green;
    padding: 5px 19px;
    background: green;

    color: #fff;">Xem thêm <i class="fas fa-angle-double-down"></i></span> </a>

    </div>
@else
    <div class="dropdown-menu dropdown-menu-right" style="width: 400px;">
        <a href="#"
           title="">
            <button class="dropdown-item" type="button">  Đang cập nhật thông tin</button>
        </a>
    </div>
@endif


