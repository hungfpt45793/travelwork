<header class="header_pc bgHome dsNone_1250 ">
    <div class="row">
        <div class="col-xl-2 col-lg-2 col-md-2 block mg">
            <div class="logo">
                <a href="/">
                    <img class="lazy" src="{{ isset($information['logo']) ?  $information['logo'] : '' }}" alt="" width="100%">
                </a>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-7 block mgBottom5 pd0">
            <div class="menu_pc">
                {{--menu chinh--}}
                <ul class="nav justify-content-center">
                    <a class="" href="{{ route('list_job_face') }}">
                        <li class="nav-item text-center ">
                            <i class="fas fa-users white f25"></i>
                            <span class="nav-link white hvWhite f15 pdt0">
                                Cổng việc làm về du lịch
                            </span>
                        </li>
                    </a>
                    <a class=""  href="/mau-chung-tu/kho-tai-lieu">
                        <li class="nav-item text-center ">
                            <i class="fas fa-book white f25"></i>
                            <span class="nav-link white hvWhite f15 pdt0 ">Kho tài liệu
                        </span>
                        </li>
                    </a>
                    <!-- <a class="" href="{{ route('getTestAllExam') }}">
                        <li class="nav-item text-center ">
                            <i class="far fa-question-circle white f25"></i>
                            <span class="nav-link white hvWhite f15 pdt0 ">Trắc nghiệm
                        </span>
                        </li>
                    </a> -->
                    <a class="" href="{{ route('course_index') }}">
                        <li class="nav-item text-center ">
                            <i class="fab fa-discourse white f25"></i>
                            <span class="nav-link white hvWhite f15 pdt0 ">Khóa học
                        </span>
                        </li>
                    </a>
                    <!--
                    -->
                    <a class=""  href="{{ route('intership') }}">
                        <li class="nav-item text-center ">
                            <i class="fas fa-link white f25"></i>
                            <span class="nav-link white hvWhite f15 pdt0 ">Cổng thực tập
                        </span>
                        </li>
                    </a>
                    {{-- fas fa-chalkboard-teacher --}}
                    <a class=""  href="{{ route('portEmployer') }}">
                        <li class="nav-item text-center bdLeftWhite lg-noBorderLeft">
                            {{-- <i class=" white f25">Dành cho</i> --}}
                            {{-- <i class="fas fa- white f25">Dành cho</i> --}}
                            <i class="white f19"><span class="f12">Dành cho</span></i>
                            <span class="nav-link white hvWhite f15 pdt0 ">Nhà tuyển dụng</span>

                        </li>
                    </a>
                </ul>

                {{--menu kho tài liệu--}}
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-3 block mg">
            @include('site.common_site.item_login')
        </div>
    </div>
</header>

<header class="menu_laptop bgHome dsNone dsBlock_1250 pd15">
    <div class="row">
        <div class="col-lg-3 col-md-3 dsNone_770">
            <div class="logo ">
                <a href="/">
                    <img class="lazy" src="{{ isset($information['logo']) ?  $information['logo'] : '' }}" alt="" width="100%">
                </a>
            </div>
        </div>
        <div class="col-lg-9 col-md-12 col-sm-12 col-12 block mg justify-content-center ">
            <div class="logo_mobile dsNone" style="width: 40px">
                <a href="/">
                    <img class="lazy" src="{{ asset('assets/web/images/icon_conver.png') }}" alt="sanketoan.vn" title="sanketoan.vn" style="height: 50px" >
                </a>
            </div>
            <div class="ds_inline_block ">
                @include('site.common_site.item_login')
            </div>
            <div class="ds_inline_block flRight">
                <a class="showHidenMenu  js_showHidenMenu ">  <span class="clWhite f16">Menu</span>
                    <i class="fas fa-angle-down clWhite f16 mgl5"></i>
                </a>
            </div>


        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 toggle_menu_laptop js_toggle_menu_laptop mgt5">
            <div class="menu_ul">
                <ul class="nav justify-content-center ">
                    <a href="/" class="dsNone mbdsBlock">
                        <li class="nav-item text-center ">
                            <i class="fas fa-home white f25"></i>
                            <span class="nav-link white hvWhite f15 pdt0 ">Trang chủ
                        </span>
                        </li>
                    </a>

                    <a href="{{ route('list_job_face') }}">
                        <li class="nav-item text-center ">
                            <i class="fas fa-users white f25"></i>
                            <span class="nav-link white hvWhite f15 pdt0 ">Cổng việc làm về du lịch
                        </span>
                        </li>
                    </a>
                    <a href="/mau-chung-tu/kho-tai-lieu">
                        <li class="nav-item text-center ">
                            <i class="fas fa-book white f25"></i>
                            <span class="nav-link white hvWhite f15 pdt0 ">Kho tài liệu
                        </span>
                        </li>
                    </a>
                    <a href="{{ route('getTestAllExam') }}">
                        <li class="nav-item text-center ">
                            <i class="far fa-question-circle white f25"></i>
                            <span class="nav-link white hvWhite f15 pdt0 ">Trắc nghiệm
                        </span>
                        </li>
                    </a>


                    <a href="{{ route('intership') }}">
                        <li class="nav-item text-center ">
                            <?php  $public_link = \App\Entity\Category::getDetailCategory('thuc-tap-ke-toan');
                            ?>
                            @if(isset($public_link['icon']))
                                {!! $public_link['icon'] !!}
                            @else
                                <i class="fas fa-link white f25"></i>
                            @endif

                            <span class="nav-link white hvWhite f15 pdt0 ">Cổng thực tập
                        </span>

                        </li>
                    </a>
                    {{-- fas fa-chalkboard-teacher --}}
                    <a href="{{ route('portEmployer') }}">
                        <li class="nav-item text-center bdLeftWhite lg-noBorderLeft">
                            {{-- <i class=" white f25">Dành cho</i> --}}
                            <i class="far fa- white f25 width_auto_last"><span class="f12">Dành cho</span></i>
                            <span class="nav-link white hvWhite f15 pdt0 font-weight-bold" >Nhà tuyển dụng
                        </span>
                        </li>
                    </a>
                    <a class="dsNone mbdsBlock" href="{{ route('list_price') }}">
                        <li class="nav-item text-center ">
                            <i class="fas fa-donate white f25"></i>
                            <span class="nav-link white hvWhite f15 pdt0 ">Bảng giá
                        </span>
                        </li>
                    </a>

                    {{-- <a href="{{ route('list_price') }}">
                        <li class="nav-item text-center">
                            <i class="fas fa-file-invoice-dollar white f25"></i>
                            <span class="nav-link white hvWhite f15 pdt0 ">Bảng giá
                        </span>
                        </li>
                    </a> --}}
                </ul>
            </div>
        </div>
    </div>
</header>

