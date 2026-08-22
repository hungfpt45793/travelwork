<header class="showOnMobile bdBottomGray bgrBlueN">
    <div class="menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            @include('site.common.item_login_mobile')
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/" class="nav-link blueN fw7 " data-toggle="sidebar-colapse" title=" Trang chủ">
                            <i class="fas fa-home white mgr5"></i>
                            Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link blueN fw7 " href="{{ route('getTestAllExam') }}" title="Trắc nghiệm"><i
                                    class="far fa-question-circle white mgr5"></i> Trắc nghiệm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link blueN fw7" href="{{ route('intership') }}" title="Cổng thực tập"><i
                                    class="fas fa-link white mgr5"></i> Cổng thực tập
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link blueN fw7" href="{{ route('recruitment') }}" title="Cẩm nang tuyển dụng"><i
                                    class="fas fa-book white mgr5"></i> Cẩm nang tuyển dụng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link blueN fw7" href="{{ route('list_price') }}"><i
                                    class="fas fa-file-invoice-dollar white mgr5"></i>Bảng giá
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
    <script>
        $('#click').click(function () {
            $('#show').toggle(500);
        })

    </script>
</header>


<header class="bgrBlueN pd15-40 showOnLaptopMini">
    <div class="row">
        <div class="col-lg-3">
            <div class="logo">
                <a href="/">
                    <img class="lazy" src="{{ isset($information['logo']) ?  $information['logo'] : '' }}" alt="" width="100%">
                </a>
            </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12 col-12 block mg justify-content-center">
            @include('site.common.item_login')
        </div>
        <div class="col-lg-1">
            <a class="showHidenMenu"> <i class="fas fa-bars f22"></i></a>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-12 block mg lg-mgt20">
            <div class="menu">

                <ul class="nav justify-content-center MenudsBlock">
                    <a href="{{ route('getTestAllExam') }}">
                        <li class="nav-item text-center ">
                            <i class="far fa-question-circle white f25"></i>
                            <span class="nav-link white hvWhite f17 pdt0 ">Trắc nghiệm
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

                        <span class="nav-link white hvWhite f17 pdt0 ">Cổng thực tập
                        </span>

                        </li>
                    </a>
                    <a href="{{ route('recruitment') }}">
                        <li class="nav-item text-center">
                            <i class="fas fa-book white f25"></i>
                            <span class="nav-link white hvWhite f17 pdt0 "> Cẩm nang tuyển dụng
                        </span>
                        </li>
                    </a>
                    <a href="{{ route('list_price') }}">
                        <li class="nav-item text-center">
                            <i class="fas fa-file-invoice-dollar white f25"></i>
                            <span class="nav-link white hvWhite f17 pdt0 ">Bảng giá
                        </span>
                        </li>
                    </a>
                </ul>
            </div>
        </div>
    </div>
</header>

<header class="bgrBlueN pd15-40 showOnDesktop">
    <div class="row">
        <div class="col-xl-2 col-lg-2 col-md-2 block mg">
            <div class="logo">
                <a href="/">
                    <img class="lazy" src="{{ isset($information['logo']) ?  $information['logo'] : '' }}" alt="" width="100%">
                </a>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-7 block mg">
            <div class="menu">
                {{--menu chinh--}}
                <ul class="nav justify-content-center MenudsBlock">
                    <a href="{{ route('list_job_face') }}">
                        <li class="nav-item text-center ">
                            <i class="fas fa-users white f25"></i>
                            <span class="nav-link white hvWhite f17 pdt0 ">Cổng việc làm du lịch
                        </span>
                        </li>
                    </a>
                    <a href="{{ route('getTestAllExam') }}">
                        <li class="nav-item text-center ">
                            <i class="far fa-question-circle white f25"></i>
                            <span class="nav-link white hvWhite f17 pdt0 ">Trắc nghiệm
                        </span>
                        </li>
                    </a>
                    <!--
                    -->
                    <a href="{{ route('intership') }}">
                        <li class="nav-item text-center ">
                            <i class="fas fa-link white f25"></i>
                            <span class="nav-link white hvWhite f17 pdt0 ">Cổng thực tập
                        </span>
                        </li>
                    </a>
                    <a href="{{ route('recruitment') }}">
                        <li class="nav-item text-center ">
                            <i class="fas fa-book white f25"></i>
                            <span class="nav-link white hvWhite f17 pdt0 ">Cẩm nang tuyển dụng
                        </span>
                        </li>
                    </a>

                </ul>

                {{--menu kho tài liệu--}}
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-3 block mg">
            @include('site.common.item_login')
        </div>
    </div>
</header>
{{--hiển thị menu toggle--}}




