<section class="recruitmentNewsHandbook pd40 pdb0">
    <div class="title">
        <h4 class="textUpper text-center fw7 f32 xl-f28 lg-f23 red mgb20 mbf18 tile_home_index">Kho tài liệu về du lịch </h4>
    </div>
    <div class="voucherNew">
        <?php $vouchers = \App\Entity\Voucher::getAllVoucher(6)?>
        @foreach($vouchers as $voucher)
            <div class="News pd20">
                @include('site.voucher.item_voucher_index')
            </div>
        @endforeach
    </div>
    <script type="text/javascript">
        $('.voucherNew').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 1500,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 1100,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
            ]
        });
    </script>
</section>
<div class="underLineY h10x bgrGray"></div>
