


<header class="bgrBlueN pd15-40 headerReponsive">

    <div class="container-fluid">
        {{--<div class="row">--}}
        <nav class="navbar navbar-expand-lg navbar-light menureponsive">
            <div class="col-xl-2 col-lg-2 col-md-2 block mg">
                <div class="logo">
                    <a href="/">
                        <img class="lazy" data-src="{{ isset($information['logo']) ?  $information['logo'] : '' }}" alt="" width="100%">
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-7 block mg">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                        </li>
                    </ul>

                </div>

            </div>
            <div class="col-xl-4 col-lg-4 col-md-3 block mg">
                @include('site.common.item_login')
            </div>
        </nav>
        {{--</div>--}}

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>

    </div>



</header>

<header class="showOnMobile bdBottomGray">
    <div class="menu container">
        <nav class="navbar navbar-light navbar-expand-md ">
            <a class="navbar-brand" href="/" style="color:#802390">
                <img class="lazy" data-src="{{ isset($information['logo']) ?  $information['logo'] : '' }}" alt="" width="100%">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1"
                    aria-expanded="true" id='click'>
                <span class="navbar-toggler-icon"></span>
            </button>

            {{--menu chính--}}
            <div class="navbar-collapse collapse" id="show">
                <a class="nav-link blueN fw7 " href="{{ route('list_job_face') }}"> <i class="fas fa-users white mgr5"></i>Cổng việc làm du lịch
                </a>
                <a class="nav-link blueN fw7 " href="/mau-chung-tu/kho-tai-lieu"> <i class="fas fa-book white mgr5"></i>Kho tài liệu
                </a>
                <a class="nav-link blueN fw7 " href="{{ route('getTestAllExam') }}"><i class="far fa-question-circle white mgr5"></i> Trắc nghiệm
                </a>

                <a class="nav-link blueN fw7" href="{{ route('intership') }}"><i class="fas fa-link white mgr5"></i> Cổng thực tập
                </a>
                <a class="nav-link blueN fw7 " href="{{ route('portEmployer') }}"><i class="fas fa-chalkboard-teacher white mgr5"></i> Nhà tuyển dụng
                </a>

                <div class="sharethis-inline-follow-buttons"></div>


                @include('site.common.item_login_mobile')

            </div>
            {{--menu kho tài liệu--}}
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
        <div class="col-lg-5 col-md-4 col-sm-12 col-12 block mg">
            <div class="logo">
                <a href="/">
                    <img class="lazy" data-src="{{ isset($information['logo']) ?  $information['logo'] : '' }}" alt="" width="100%">
                </a>
            </div>
        </div>
        <div class="col-lg-7 col-md-8 col-sm-12 col-12 block mg">
            @include('site.common.item_login')
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 block mg lg-mgt20">
            <div class="menu">

                <ul class="nav justify-content-center MenudsBlock">
                    <li class="nav-item text-center ">
                        <i class="fas fa-users white f25"></i>
                        <a class="nav-link white hvWhite f17 pdt0 " href="{{ route('list_job_face') }}">Cổng việc làm du lịch
                        </a>
                    </li>
                    <li class="nav-item text-center ">
                        <i class="fas fa-book white f25"></i>
                        <a class="nav-link white hvWhite f17 pdt0 " href="/mau-chung-tu/kho-tai-lieu">Kho tài liệu
                        </a>
                    </li>
                    <li class="nav-item text-center ">
                        <i class="far fa-question-circle white f25"></i>
                        <a class="nav-link white hvWhite f17 pdt0 " href="{{ route('getTestAllExam') }}">Trắc nghiệm
                        </a>
                    </li>
                    <li class="nav-item text-center ">
                        <?php  $public_link = \App\Entity\Category::getDetailCategory('thuc-tap-ke-toan');
                        ?>
                        @if(isset($public_link['icon']))
                            {!! $public_link['icon'] !!}
                        @else
                            <i class="fas fa-link white f25"></i>
                        @endif

                        <a class="nav-link white hvWhite f17 pdt0 " href="{{ route('intership') }}">Cổng thực tập
                        </a>

                    </li>
                    <li class="nav-item text-center bdLeftWhite lg-noBorderLeft">
                        <i class="fas fa-chalkboard-teacher white f25"></i>
                        <a class="nav-link white hvWhite f17 pdt0 " href="{{ route('portEmployer') }}">Nhà tuyển dụng
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>



<header class="bgrBlueN pd15-40 showOnDesktop" style="display: none !important;">
    <div class="row">
        <div class="col-xl-2 col-lg-2 col-md-2 block mg">
            <div class="logo">
                <a href="/">
                    <img class="lazy" data-src="{{ isset($information['logo']) ?  $information['logo'] : '' }}" alt="" width="100%">
                </a>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-7 block mg">
            <div class="menu">
                {{--menu chinh--}}
                <ul class="nav justify-content-center MenudsBlock">
                    <li class="nav-item text-center ">
                        <i class="fas fa-users white f25"></i>
                        <a class="nav-link white hvWhite f17 pdt0 " href="{{ route('list_job_face') }}">Cổng việc làm du lịch
                        </a>
                    </li>
                    <li class="nav-item text-center ">
                        <i class="fas fa-book white f25"></i>
                        <a class="nav-link white hvWhite f17 pdt0 " href="/mau-chung-tu/kho-tai-lieu">Kho tài liệu
                        </a>
                    </li>
                    <li class="nav-item text-center ">
                        <i class="far fa-question-circle white f25"></i>
                        <a class="nav-link white hvWhite f17 pdt0 " href="{{ route('getTestAllExam') }}">Trắc nghiệm
                        </a>
                    </li>
                    <!--

                    -->

                    <li class="nav-item text-center ">
                        <i class="fas fa-link white f25"></i>
                        <a class="nav-link white hvWhite f17 pdt0 " href="{{ route('intership') }}">Cổng thực tập
                        </a>
                    </li>
                    <li class="nav-item text-center bdLeftWhite lg-noBorderLeft">
                        <i class="fas fa-chalkboard-teacher white f25"></i>
                        <a class="nav-link white hvWhite f17 pdt0 " href="{{ route('portEmployer') }}">Nhà tuyển dụng
                        </a>
                    </li>
                </ul>

                {{--menu kho tài liệu--}}
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-3 block mg">
            @include('site.common.item_login')
        </div>
    </div>
</header>


