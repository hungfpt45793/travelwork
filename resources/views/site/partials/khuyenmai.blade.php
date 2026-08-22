<div class="block-product block-product-slideshow btn-next-prev" style="margin-bottom:15px;">
               <div class="head_block clearfix">
                 <?php $cateTour = \App\Entity\Category::getDetailCategory('khuyen-mai-dac-biet'); ?>
                  <a href="{{ route('site_category_product', ['cate_slug' => $cateTour->slug])}}"><h3 class="block-heading">
                     {{ isset($cateTour['title']) ? $cateTour['title'] : ''}}  

                  </h3></a>
                 
               </div>
               <div class="owl-carousel owl-theme">
                  @foreach (\App\Entity\Product::showProduct('khuyen-mai-dac-biet', 30) as $product)
                     @if (strtotime($product->deal_end) > time())
                  <div class="item product">
                     <figure class="clearfix">
                        <div class="CropImg CropImg100">
                          <div class="thumbs">
                            <a href="{{ route('product',['cate_slug' => $product->slug]) }}" title="{{ isset($product['title']) ? $product['title'] : ''}}">
                            <img class="prd_sale lazy" src="{{ isset($product['image']) ? $product['image'] : ''}}" alt="{{ isset($product['title']) ? $product['title'] : ''}}">
                                <?php $sale = ($product['price_deal'] / ($product['price'] / 100))?>
                               <span><?php echo ceil(100 - $sale) ?>%</span>
                            </a>
                        </div>
                      </div>  

                     </figure>
                     <div class="info clearfix">
                        @php
                              $date = date_create($product->deal_end);
                        @endphp
                        <input type="hidden"  class="value_countdown" value="{{ date_format($date,"Y-m-d H:i:s") }}">
                        <div  class="countdown"></div>
                        <script type="text/javascript">
                            $( document ).ready(function() {
                                var x = setInterval(function() {
                                    $('.value_countdown').each(function(index) {

                                        var countDownDate = new Date($(this).val()).getTime();

                                        // Get todays date and time
                                        var now = new Date().getTime();

                                        // Find the distance between now an the count down date
                                        var distance = countDownDate - now;

                                        // Time calculations for days, hours, minutes and seconds
                                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                        if (days == 0) {
                                            $(this).next().html("<span>" + hours + " Giờ </span>"
                                                + "<span>" + minutes + " Phút </span>" + "<span>" + seconds + " Giây </span>");
                                        } else {
                                            $(this).next().html("<span>" + days + " Ngày </span>" + "<span>" + hours + " Giờ </span>"
                                                + "<span>" + minutes + " Phút </span>" + "<span>" + seconds + " Giây </span>");
                                        }

                                        // If the count down is over, write some text
                                        if (distance < 0) {
                                            clearInterval(x);
                                            $(this).next().html("<span>00 Ngày</span>" + "<span>00 Giờ </span>" + "<span>00 Phút </span>" + "<span>00 Giây </span>");
                                        }

                                    });
                                }, 1000);


                            });

                        </script>
                        <a title="{{ isset($product['title']) ? $product['title'] : ''}}" href="{{ route('product',['cate_slug' => $product->slug]) }}">
                           {{ isset($product['title']) ?  \App\Ultility\Ultility::textLimit($product['title'], 8) : ''}}</a>
                        </br>
                         @if (time() <= strtotime($product->deal_end))
                            <p class="price" style="">{{ number_format( $product['price_deal'] , 0) }} đ</p>
                            <p class="price-old">{{ number_format( $product['price'] , 0) }} đ</p>
                         @endif
                     </div>
                  </div>
                     @endif
                  @endforeach
               </div>
            </div>