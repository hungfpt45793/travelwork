<section class="list_carerr_total_home list_job_home_new" style="margin-top: 30px">
    <div class="container container_w_1200">
        <div class="row">
            <div class="col-md-12">
                <div class="content_box">
                    <div class="slide_voucher_new">
                        <?php
                        $categoryVouchers = \App\Entity\VoucherCategories::getALlCategorieVoucher();
                        ?>
                        @foreach ($categoryVouchers as $categoryVoucher)
                                <div class="total_home_carerr">
                                    <a href="{{ route('getAllCategoryVoucher',['slugCategoryVoucher'=> $categoryVoucher['slug_cate_voucher']]) }}" title=" {{ isset($categoryVoucher['name_cate_voucher']) ? $categoryVoucher['name_cate_voucher'] : '' }} du lịch">
                                        <div class="item_total_carerr">
                                            <div class="icon_total_carerr">
                                                <div class="icon_carerr">
                                                    {!! isset($categoryVoucher['icon']) ? $categoryVoucher['icon'] : '' !!}
                                                </div>
                                            </div>

                                            <div class="title_total_carerr">
                                                <h3 style="margin-top: 10px;margin-bottom: 0px">
                                                   <p class="cutTitle"> {{ isset($categoryVoucher['name_cate_voucher']) ? $categoryVoucher['name_cate_voucher'] : '' }} du lịch</p>
                                                </h3>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $('.slide_voucher_new').slick({
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
