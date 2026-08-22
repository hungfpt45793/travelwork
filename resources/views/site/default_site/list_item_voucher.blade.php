<section class="recruitmentNewsHandbook pdt20 list_job_home_new ">

    <div class="voucherNew">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-md-12 title_new_home">
                    <h3><p>Kho tài liệu Travelwork</p></h3>
                    <a href="/mau-chung-tu/kho-tai-lieu">Xem tất cả</a>
                </div>
            </div>
            <div class="row">
                <?php $vouchers = \App\Entity\Voucher::getAllVoucher(4)?>
                @foreach($vouchers as $voucher)
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 pd0">
                        @include('site.voucher_site.item_voucher_index')
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</section>
<div class="underLineY h10x bgrGray"></div>
