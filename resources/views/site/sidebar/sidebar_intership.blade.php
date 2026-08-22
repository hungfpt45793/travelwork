
<div class="col-xl-3 col-lg-3 col-md-12 pdl0 mh76-mgl15 dsmbNone PostSaleRight sidebar_show_hidden" id="js_toogle_sidebar">
    <div id="dismiss">
        <i class="fas fa-arrow-left"></i>
    </div>
    <div class="UvNew bgrWhite">
        <div class="title textCenter textUpper bgrBlueN white fw7 pdt10 pdb10">
            Công ty nổi bật
        </div>
        <div class="contentsUvNew bdLightGray">

            <?php $employerStars = App\Entity\Employer::getAllStar() ?>

            @foreach ($employerStars as $employerstar)
                @include('site.employer.item_sidebar_intership',['employerstar' => $employerstar])

            @endforeach
        </div>

    </div>


    <div class="UvNew bgrWhite mgt25">
        <div class="title textCenter textUpper bgrBlueN white fw7 pdt10 pdb10">
            Công ty được quan tâm nhiều nhất
        </div>
        <div class="contentsUvNew bdLightGray">

            <?php $employernews = App\Entity\Employer::getNew() ?>

            @foreach ($employernews as $employernew)

                    @include('site.employer.item_sidebar_intership',['employerstar' => $employernew])

            @endforeach
        </div>

    </div>
    @include('site.sidebar.list_banner')

</div>