<section class="list_carerr_total_home">
    <div class="container container_w_1200">
        <div class="row">
            <div class="col-md-12">
                <div class="content_box">
                    <div class="slide_home_new">
                        <?php
                        $list_category_carerr = \App\Entity\Career::get_all_statu_show();
                        ?>
                        @foreach($list_category_carerr as $carerr)
                            <?php
                            $slug_carerr = 'tuyen-' . $carerr->career_category_slug . '?' . 'c=' . $carerr->career_category_id;
                            ?>
                            <?php
                            $total_carerr_job = \App\Entity\Job::total_carerr_job($carerr->career_category_id);
                            ?>
                            @if(!empty($total_carerr_job))
                            <div class="total_home_carerr">
                                <a href="{{ route('seacrh_job_facebook',['slug'=>$slug_carerr]) }}">
                                    <div class="item_total_carerr">
                                        <div class="icon_total_carerr">
                                            <div class="icon_carerr">
                                                <i class="fas fa-briefcase"></i>
                                            </div>
                                        </div>

                                        <div class="title_total_carerr">
                                            <h3 style="margin-top: 10px;margin-bottom: 0px">
                                            <p class="cutTitle">
                                                {{ !empty($carerr->career_category_name) ? $carerr->career_category_name : '' }}
                                            </p>
                                            </h3>

                                            <span>
                                        {{ !empty($total_carerr_job) ? number_format($total_carerr_job) : 1000 }} việc làm
                                        </span>
                                        </div>

                                    </div>
                                </a>
                            </div>
                                @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
    $('.slide_home_new').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        responsive: [
            {
                breakpoint: 1490,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    infinite: true,
                }
            },
            {
                breakpoint: 1124,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                }
            },
            {
                breakpoint: 1000,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            }, {
                breakpoint: 900,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 800,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
</script>
