<div class="News Voucher">
    <div class="itemVoucher">
        <div class="CropImg">
            {{--getVoucher--}}
            <a href="{{ route('getVoucher',['slug_voucher'=> $voucher['slug_voucher']])}}" class="thumbs"
               title="{{ isset($voucher['name_voucher']) ? $voucher['name_voucher'] : '' }}" >

                <img class="lazy"  data-src="{{ isset($voucher['image_voucher']) ? asset($voucher['image_voucher']) : '' }}"  alt="{{ isset($voucher['name_voucher']) ? $voucher['name_voucher'] : '' }}" width="100%" title="{{ isset($voucher['name_voucher']) ? $voucher['name_voucher'] : '' }}">
            </a>
        </div>
        <div class="info">
            <h4 class="title_voucher cutTitle2">
                <a href="{{ route('getVoucher',['slug_voucher'=> $voucher['slug_voucher']])}}"  class="f18 clHome" title="{{ isset($voucher['name_voucher']) ? $voucher['name_voucher'] : '' }} ">
                    {{ isset($voucher['name_voucher']) ? $voucher['name_voucher'] : '' }}
                </a>
            </h4>
            <div class="itemIcon">
                <span class="clRed f16 mgr5">Lượt tải : {{ isset($voucher->dowload_voucher) ? $voucher->dowload_voucher : '0' }}
                    <i class="fas fa-download"></i></span>

                <?php
                $total_comment = 0;
                $total_comment = \App\Entity\VoucherComment::countComment($voucher->id_voucher);
                ?>
                <span class="clOrange">Bình luận : {{ $total_comment }} <i class="far fa-comments"></i></span>
                <span class="dsBlock clGreen">Lượt xem : {{ isset($voucher->view_voucher) ? $voucher->view_voucher : '0' }}
                    <i class="far fa-eye"></i> </span>

            </div>
        </div>
    </div>
</div>