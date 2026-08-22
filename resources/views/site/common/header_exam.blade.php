<header class="showOnMobile bdBottomGray bgrBlueN">
    <div class="menu container">
        <nav class="navbar navbar-expand-lg navbar-light">

            @include('site.common.item_login_mobile')
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <?php  $public_exam = \App\Entity\Category::getDetailCategory('cuoc-thi-trac-nghiem');
                ?>
                <?php  $public_test = \App\Entity\Category::getDetailCategory('huong-dan-trac-nghiem');
                ?>
                <ul class="navbar-nav">
                    
                    <li class="nav-item">
                        <a class="nav-link  blueN fw7" target="_blank"
                           href="{{ route('site_category_post',['site_category_post'=>$public_exam['slug']]) }}"><i
                                    class="fas fa-compress-arrows-alt white mgr5"></i> {{ isset($public_exam['title']) ? $public_exam['title'] : '' }}
                        </a>
                    </li>
                    
                    <li class="nav-item">

                        <a class="nav-link  blueN fw7" href="{{ route('getRomAll') }}"> <i
                                    class="fab fa-chromecast white mgr5"></i>Phòng
                            thi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  blueN fw7"
                           href="{{ route('getAllExam') }}"> <i class="fas fa-question white mgr5"></i>
                            Tất cả đề thi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  blueN fw7"
                           href="{{ route('getTestAllExam') }}"><i class="fas fa-text-width white mgr5"></i>
                            Đề thi thử
                        </a>
                    </li>
                    <li class="nav-item">


                        <a class="nav-link  blueN fw7" target="_blank"
                           href="{{ route('site_category_post',['site_category_post'=>$public_test['slug']]) }}"><i
                                    class="fab fa-slideshare white mgr5"></i>
                            {{ isset($public_test['title']) ? $public_test['title'] : '' }}
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
        <div class="col-lg-3 col-md-3">
            <div class="logo">
                <a href="/">
                    <img class="lazy" src="{{ isset($information['logo']) ?  $information['logo'] : '' }}" alt="" width="100%">
                </a>
            </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12 col-12 block mg justify-content-center">
            @include('site.common.item_login')
        </div>
        <div class="col-lg-1 col-md-1">
            <a class="showHidenMenu"> <i class="fas fa-bars f22"></i></a>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 block mg lg-mgt20">
            <div class="menu">


                <ul class="nav justify-content-center">
                    <a target="_blank"
                       href="{{ route('site_category_post',['site_category_post'=>$public_exam['slug']]) }}">
                        <li class="nav-item text-center">
                            @if(isset($public_exam['icon']))
                                {!! $public_exam['icon'] !!}
                            @else
                                <i class="fas fa-compress-arrows-alt white f25"></i>
                            @endif

                            <span class="nav-link white hvWhite f17 pdt0"> {{ isset($public_exam['title']) ? $public_exam['title'] : '' }}
                        </span>
                        </li>
                    </a>
                    <a href="{{ route('getRomAll') }}">
                        <li class="nav-item text-center">
                            <i class="fab fa-chromecast white f25"></i>
                            <span class="nav-link white hvWhite f17 pdt0">Phòng
                            thi
                        </span>
                        </li>
                    </a>
                    <a href="{{ route('getAllExam') }}">
                        <li class="nav-item text-center">
                            <i class="fas fa-question white f25"></i>
                            <span class="nav-link white hvWhite f17 pdt0">
                            Tất cả đề thi
                        </span>
                        </li>
                    </a>
                    <a href="{{ route('getTestAllExam') }}">
                        <li class="nav-item text-center">
                            <i class="fas fa-text-width white f25"></i>
                            <span class="nav-link white hvWhite f17 pdt0">
                            Đề thi thử
                        </span>
                        </li>
                    </a>
                    <a target="_blank"
                       href="{{ route('site_category_post',['site_category_post'=>$public_test['slug']]) }}">
                        <li class="nav-item text-center">
                            @if(isset($public_test['icon']))
                                {!! $public_test['icon'] !!}
                            @else
                                <i class="fab fa-slideshare white f25"></i>
                            @endif
                            <span class="nav-link white hvWhite f17 pdt0">
                             {{ isset($public_test['title']) ? $public_test['title'] : '' }}
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


                <ul class="nav justify-content-center">
                    <a target="_blank"
                       href="{{ route('site_category_post',['site_category_post'=>$public_exam['slug']]) }}">
                    <li class="nav-item text-center">
                        @if(isset($public_exam['icon']))
                            {!! $public_exam['icon'] !!}
                        @else
                            <i class="fas fa-compress-arrows-alt white f25"></i>
                        @endif
                        <span class="nav-link white hvWhite f17 pdt0" > {{ isset($public_exam['title']) ? $public_exam['title'] : '' }}
                        </span>
                    </li>
                    </a>
                    <a href="{{ route('getRomAll') }}">
                    <li class="nav-item text-center">
                        <i class="fab fa-chromecast white f25"></i>
                        <span class="nav-link white hvWhite f17 pdt0"
                           >Phòng
                            thi
                        </span>
                    </li>
                    </a>
                    <a  href="{{ route('getAllExam') }}">
                    <li class="nav-item text-center">
                        <i class="fas fa-question white f25"></i>
                        <span class="nav-link white hvWhite f17 pdt0" >
                            Tất cả đề thi
                        </span>
                    </li>
                    </a>
                    <a href="{{ route('getTestAllExam') }}">
                    <li class="nav-item text-center">
                        <i class="fas fa-text-width white f25"></i>
                        <span class="nav-link white hvWhite f17 pdt0" >
                            Đề thi thử
                        </span>
                    </li>
                    </a>
                    <a href="{{ route('site_category_post',['site_category_post'=>$public_test['slug']]) }}"
                       target="_blank">
                    <li class="nav-item text-center">
                        @if(isset($public_test['icon']))
                            {!! $public_test['icon'] !!}
                        @else
                            <i class="fab fa-slideshare white f25"></i>
                        @endif
                        <span class="nav-link white hvWhite f17 pdt0" >
                            {{ isset($public_test['title']) ? $public_test['title'] : '' }}
                        </span>
                    </li>
                    </a>
                </ul>

            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-3 block mg">
            @include('site.common.item_login')
        </div>
    </div>
</header>


