<div class="product-item-main product_box_item itemProductheight">
   <div class="product-item-image product-image display_flex">
      <a class="a_img thumb" href="{{ route('product',['cate_slug' => $product->slug]) }}">
      <img class="lazy" src="{{ isset($product['image']) ? $product['image'] : ''}}" data-lazyload="{{ isset($product['image']) ? $product['image'] : ''}}" alt="{{ isset($product['title']) ? $product['title'] : ''}}" title="{{ isset($product['title']) ? $product['title'] : ''}}">
      </a>
   </div>
   <div class="product-bottom">
      <h3 class="product-name">
         <a title="{{ isset($product['title']) ? $product['title'] : ''}}" class="text1line" href="{{ route('product',['cate_slug' => $product->slug]) }}">{{ isset($product['title']) ? $product['title'] : ''}}</a>
      </h3>
      <div class="product-item-price price-box">
         <p> <span class="id">{{ isset($product['code']) ? $product['code'] : ''}}</span></p>
         <p style="margin-bottom: 10px"> 
            <span class="special-price">

         @if (time() <= strtotime($product->deal_end))
            <span class="price product-price">{{ number_format($product['price_deal'] , 0) }} VND</span>
            <span class="price product-price" style="color: #000"><del>{{ number_format($product['price'] , 0) }} VND</del></span>
         @elseif($product['discount'] > 0)
            <span class="price product-price">{{ number_format($product['discount'] , 0) }} VND</span>
            <span class="price product-price" style="color: #000"><del>{{ number_format($product['price'] , 0) }} VND</del></span>
         @else
             <span class="price product-price">{{ number_format($product['price'] , 0) }} VND</span>
         @endif
         </span>

         </p>
         <p><a href="{{ route('product',['cate_slug' => $product->slug]) }}" class="link">Xem chi tiết</a></p>
      </div>
      <div class="review_star">
         <div class="bizweb-product-reviews-badge" data-id="12472764">
            <div class="bizweb-product-reviews-star" data-score="0" data-number="5" title="Not rated yet!" style="color: rgb(255, 190, 0);">
               @if($product['danh-gia-sao'] != '')  
                  @for($i = 1 ; $i <= $product['danh-gia-sao'] ; $i++)
                     <i data-alt="1" class="star-off-png" title="Not rated yet!"></i>&nbsp;
                  @endfor
               @endif
            </div>
            <div>
              <!--  <p>0</p> -->
            </div>
            <div><!-- <img src="https://productreviews.bizwebapps.vn//assets/images/user.png" width="18" height="17"> --></div>
         </div>
      </div>
      <div class="product-action-grid-main clearfix">

          <form onsubmit="return addToOrder(this);" method="post" class="variants" data-id="product-actions-12434804" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="contain">
               <input type="hidden" class="quantity" name="quantity[]" value="1" />
               <input type="hidden" class="product_id" name="product_id[]" value="{{ $product->product_id }}">
               <button class="button_30 btn-cart left-to add_to_cart" title="Mua hàng">
               <i class="ion-bag"></i><span class="toolstip hidden">Thêm vào giỏ hàng</span>
               </button>
               <a title="Xem chi tiết" href="{{ route('product',['cate_slug' => $product->slug]) }}" class="button_30 btn_view">
               <i class="ion-ios-search-strong"></i>
               <span class="toolstip hidden">Xem nhanh</span>
               </a>
            </div>
         </form>
      </div>
   </div>
</div>

 <script>
            //Đồng bộ chiều cao các div
            $(function() {
              $('.itemProductheight').matchHeight();
            });
            </script>

