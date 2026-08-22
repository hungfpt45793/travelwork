<section class="recruitmentNewsHandbook PagesNewsContent bkxam bgrGray pdb20 pdt20">
    <div class="title">
        <h4 class="title_home">Bảng giá Travelwork</h4>
    </div>
    <div class="container container_w_1200">
        <div class="link bg-white mgb20 pd10" id="price_list">
            <div id="service_show_on_big">
                <div class="row title_price_list">
                    <?php
                    $list_prices = App\Entity\Service_price::get_all();
                    ?>
                    @foreach ($list_prices as $list_price)
                        <div class="col-md-3 mb-3  col-sm-3 total_box"
                             id="total_box{{ $list_price->service_price_id }}">
                            <div class="grade">
                                <div class="maxHeight_service">
                                    <div class="img text-center maxHeight_service_image"
                                         style="background:url('{{ $list_price->image }}');">
                                    </div>
                                    <div class="title_goi_tin text-center">
                                        <h3 class="name_box text-center text-uppercase">
                                            {{ $list_price->service_price_title }}
                                        </h3>
                                    </div>
                                    <div class="detail_box pl-2 maxHeight_service_feature">
                                        <span style="line-height: 1em">{!! $list_price->feature !!}</span>
                                    </div>
                                </div>
                                <div class="button_more text-center">
                                    <a href="{{ route('detail_list_price',['slug'=>$list_price->service_price_slug]) }}#scroll_mouse_fixel"
                                       class="ct_button_more text-center">Xem
                                        chi tiết</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{--@if(url()->current() == route('detail_list_price', ['slug'=> $price->service_price_slug])) style="background:#ff9200" @endif--}}
            </div>
        </div>
    </div>
</section>
