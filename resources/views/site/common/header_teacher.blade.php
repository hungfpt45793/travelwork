<?php $jobgroups = \App\Entity\JobGroup::getAll() ?>
<header class="showOnMobile bdBottomGray bgrBlueN">
    <div class="menu container">
        <nav class="navbar navbar-expand-lg navbar-light">
            @include('site.common.item_login_mobile')
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    @foreach($jobgroups as $jobgroup)
                        <li class="nav-item">
                            <a class="nav-link  blueN fw7"
                               href="{{ route('showCategoryTeacher',['slug'=>$jobgroup->slug]) }}">
                                @if(isset($jobgroup['icon']))
                                    {!! $jobgroup['icon'] !!}
                                @else
                                    <i class="fas fa-compress-arrows-alt white f25"></i>
                                @endif
                                {{ isset($jobgroup->job_group_name) ? $jobgroup->job_group_name : '' }}
                            </a>

                        </li>
                    @endforeach

                </ul>
            </div>
        </nav>
    </div>
    <script>
        $('#click').click(function () {
            $('#show').toggle(500);
        });
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
                <ul class="nav justify-content-center">
                    @foreach($jobgroups as $jobgroup)
                        <a href="{{ route('showCategoryTeacher',['slug'=>$jobgroup->slug]) }}">
                            <li class="nav-item text-center">
                                @if(isset($jobgroup['icon']))
                                    {!! $jobgroup['icon'] !!}
                                @else
                                    <i class="fas fa-compress-arrows-alt white f25"></i>
                                @endif

                                <span class="nav-link white hvWhite f17 pdt0"> {{ isset($jobgroup->job_group_name) ? $jobgroup->job_group_name : '' }}
                                </span>
                            </li>
                        </a>
                    @endforeach
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
                    @foreach($jobgroups as $jobgroup)
                        <a href="{{ route('showCategoryTeacher',['slug'=>$jobgroup->slug]) }}">
                            <li class="nav-item text-center">
                                @if(isset($jobgroup['icon']))
                                    {!! $jobgroup['icon'] !!}
                                @else
                                    <i class="fas fa-compress-arrows-alt white f25"></i>
                                @endif

                                <span class="nav-link white hvWhite f17 pdt0"> {{ isset($jobgroup->job_group_name) ? $jobgroup->job_group_name : '' }}
                                </span>
                            </li>
                        </a>
                    @endforeach
                </ul>

            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-3 block mg">
            @include('site.common.item_login')
        </div>
    </div>
</header>

