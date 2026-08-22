
<div class="col-xl-3 col-lg-3 col-md-12 pdl0 mh76-mgl15 sidebar_intership dsmbNone PostSaleRight sidebar_show_hidden" id="js_toogle_sidebar">
    <div class="UvNew_sidebar_intership bgrWhite">
        <div class="title_sidebar_intership textCenter textUpper bgrBlueN white fw7 pdt10 pdb10">
            Công ty nổi bật
        </div>
        <div class="content_sidebar_intership bdLightGray">

            <?php $employerStars = App\Entity\Employer::getAllStar() ?>

            @foreach ($employerStars as $employerstar)
                @include('site.employer_site.item_sidebar_intership',['employerstar' => $employerstar])

            @endforeach
        </div>

    </div>


    <div class="UvNew_sidebar_intership bgrWhite mgt25">
        <div class="title_sidebar_intership textCenter textUpper bgrBlueN white fw7 pdt10 pdb10">
            Công ty được quan tâm nhiều nhất
        </div>
        <div class="content_sidebar_intership bdLightGray">

            <?php $employernews = App\Entity\Employer::getNew() ?>

            @foreach ($employernews as $employernew)

                    @include('site.employer_site.item_sidebar_intership',['employerstar' => $employernew])

            @endforeach
        </div>

    </div>
    @include('site.sidebar.list_banner')

</div>