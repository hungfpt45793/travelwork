<section class="recruitmentNewsHandbook pdt20">
    <div class="title title_new_home">
        <h2 class="">Kho tài liệu du lịch </h2>
    </div>
    <div class="voucherNew">
        <div class="container container_w_1200">
            <div class="row">
                <?php $vouchers = \App\Entity\Voucher::getAllVoucher(4)?>
                @foreach($vouchers as $voucher)
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 pd0">
                        @include('site.voucher_site.item_voucher')
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="redmove text-center mgt10">
                        <a class="" href="/mau-chung-tu/kho-tai-lieu">
                            <span class="btnHome">Xem thêm</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="underLineY h10x bgrGray"></div>
