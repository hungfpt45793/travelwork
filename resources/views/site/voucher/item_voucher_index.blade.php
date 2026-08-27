<div class="News Voucher">
    <div class="itemVoucher">
        <div class="CropImg">
            {{--getVoucher--}}
            <a href="{{ route('getVoucher',['slug_voucher'=> $voucher['slug_voucher']])}}" class="thumbs"
               title="{{ isset($voucher['name_voucher']) ? $voucher['name_voucher'] : '' }}" >

                <img class="lazy" data-original="{{ asset('assets/image/no_avatar.jpg') }}" src="{{ \App\Ultility\Ultility::assetUrl(data_get($voucher, 'image_voucher'), 'assets/image/no_avatar.jpg') }}" alt="{{ isset($voucher['name_voucher']) ? $voucher['name_voucher'] : '' }}" width="100%" title="{{ isset($voucher['name_voucher']) ? $voucher['name_voucher'] : '' }}">
               
            </a>
        </div>
        <div class="info">
            <h5 class="maxTitleVoucher"><a href="{{ route('getVoucher',['slug_voucher'=> $voucher['slug_voucher']])}}"
                                           class="f18 hvBlueDN blueDN CutText2">{{ isset($voucher['name_voucher']) ? \App\Ultility\Ultility::textLimit($voucher['name_voucher'], 12) : '' }} </a>
            </h5>
            <div class="itemIcon">
                <span class="clred f16">Lượt tải : {{ isset($voucher->dowload_voucher) ? $voucher->dowload_voucher : '0' }}
                    <i class="fas fa-download"></i></span>

                <?php
                $total_comment = 0;
                $total_comment = \App\Entity\VoucherComment::countComment($voucher->id_voucher);
                ?>
                <span class="clorange f14">Bình luận : {{ $total_comment }} <i class="far fa-comments"></i></span>
                <span class="clgreen f14">Lượt xem : {{ isset($voucher->view_voucher) ? $voucher->view_voucher : '0' }}
                    <i class="far fa-eye"></i> </span>

            </div>
        </div>
    </div>
</div>
