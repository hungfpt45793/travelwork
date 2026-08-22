

<header class="showOnMobile bdBottomGray bgrBlueN">
    <div class="menu container">
        <nav class="navbar navbar-expand-lg navbar-light">

            @include('site.common.item_login_mobile')
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <?php
                    $categoryVouchers = \App\Entity\VoucherCategories::getALlCategorieVoucher();
                    ?>
                    
                    @foreach ($categoryVouchers as $categoryVoucher)
                        <li class="nav-item">
                            <a class="nav-link blueN fw7"
                               href="{{ route('getAllCategoryVoucher',['slugCategoryVoucher'=> $categoryVoucher['slug_cate_voucher']]) }}">
                                {!! isset($categoryVoucher['icon']) ? $categoryVoucher['icon'] : '' !!}
                                {{ isset($categoryVoucher['name_cate_voucher']) ? $categoryVoucher['name_cate_voucher'] : '' }}</a>
                        </li>
                        @endforeach

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
                {{--<ul class="nav justify-content-center MenudsBlock">--}}
                {{----}}
                {{--@foreach (\App\Entity\Menu::showWithLocation('footer-first') as $Mainmenu)--}}
                {{--@foreach (\App\Entity\MenuElement::showMenuPageArray($Mainmenu->slug) as $id=>$menuelement)--}}
                {{--<li class="nav-item text-center {{($id == 4) ? 'bdLeftWhite lg-noBorderLeft' : ''}}">--}}
                {{--{!! isset($menuelement['image']) ? $menuelement['image'] : '' !!}--}}
                {{--<a class="nav-link white hvWhite f17 pdt0 " href="{{ $menuelement['url'] }}">{{ isset($menuelement['title_show']) ? $menuelement['title_show'] : '' }}--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--@endforeach--}}
                {{--@endforeach--}}
                {{--</ul>--}}

                <ul class="nav justify-content-center">
                    <?php
                    $categoryVouchers = \App\Entity\VoucherCategories::getALlCategorieVoucher();
                    ?>
                    @foreach ($categoryVouchers as $categoryVoucher)
                            <a  href="{{ route('getAllCategoryVoucher',['slugCategoryVoucher'=> $categoryVoucher['slug_cate_voucher']]) }}">
                        <li class="nav-item text-center">
                            {!! isset($categoryVoucher['icon']) ? $categoryVoucher['icon'] : '' !!}
                            <span class="nav-link white hvWhite f17 pdt0">{{ isset($categoryVoucher['name_cate_voucher']) ? $categoryVoucher['name_cate_voucher'] : '' }}
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
                {{--menu kho tài liệu--}}
                <ul class="nav justify-content-center">
                    <?php
                    $categoryVouchers = \App\Entity\VoucherCategories::getALlCategorieVoucher();
                    ?>
                    @foreach ($categoryVouchers as $categoryVoucher)
                        <a  href="{{ route('getAllCategoryVoucher',['slugCategoryVoucher'=> $categoryVoucher['slug_cate_voucher']]) }}">
                        <li class="nav-item text-center">
                            {!! isset($categoryVoucher['icon']) ? $categoryVoucher['icon'] : '' !!}
                            <span class="nav-link white hvWhite f17 pdt0" >{{ isset($categoryVoucher['name_cate_voucher']) ? $categoryVoucher['name_cate_voucher'] : '' }}
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


