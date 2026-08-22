<div class="item">
	<div class="CropImg CropImg100">
         <div class="thumbs">
            <a  href="{{ route('product',['cate_slug' => $product->slug]) }}" title="{{ isset($product['title']) ? $product['title'] : ''}}">
            <img class="lazy" src="{{ isset($product['image']) ? $product['image'] : ''}}" alt="{{ isset($product['title']) ? $product['title'] : ''}}" >
            </a>
         </div>
    </div>
	<a href="{{ route('product',['cate_slug' => $product->slug]) }}" title="{{ isset($product['title']) ? $product['title'] : ''}}">
	  {{ isset($product['title']) ? $product['title'] : ''}}         
	</a>
	<!-- <p class="price">800.000 đ</p>
	<p class="price-old">649.000 đ</p> -->
	<div class="">
	@if (time() <= strtotime($product->deal_end))
		<span class="price">{{ number_format( $product['price_deal'] , 0) }} đ</span>
		<span class="price_old">
		   {{ number_format( $product['price'] , 0) }} đ
		   </span>
	@elseif($product['discount'] > 0)
	   <p class="price">{{ number_format( $product['discount'] , 0) }} đ</p>
	   <p class="price_old">
	   <del>{{ number_format( $product['price'] , 0) }} đ   </del>         
	   </p>
	@else
	  <p class="price">{{ number_format( $product['price'] , 0) }} đ</p>
	  <p>
	  	 <del style="color: #fff">0</del>       
	  </p>
	@endif
	</div>
</div>


