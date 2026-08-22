<div id="popup{{ isset($product['post_id']) ? $product['post_id'] : ''}}" class="modal fade model_xemnhanh clearfix">
   <div class="modal-dialog clearfix">
      <div class="modal-content clearfix">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Xem nhanh sản phẩm</h4>
         </div>
         <div class="modal-body">
            <div id="content" class="detail clearfix">
               <div id="detail-product" class="clearfix">
                  <div class="thumb">
                     <img class="lazy" src="{{ isset($product['image']) ? $product['image'] : ''}}" style="    width: 350px;" >
                     <p class="title_1">Ngại gọi điện? Vui lòng nhập số điện thoại </p>

                     <form  id="frm_call_me631" onsubmit="return subcribeEmailSubmit(this)">
                        {{ csrf_field() }}
                        <div class="input_dathang">
                           <input type="text"  id="txt_phone_631"  name="" class="form-control phone_c emailSubmit" placeholder="Yêu cầu tư vấn">
                           <button class="submit_phone_2" type="submit" style="border: none">Tư vấn cho tôi</button>
                         
                        </div>
                     </form>
                  </div>
                  <!--end: .thumb-->
                  <div class="summary">
                     <div class="a_right clearfix">
                        <a href="{{ route('product',['cate_slug' => $product->slug]) }}" title="{{ isset($product['title']) ? $product['title'] : ''}}"><h2 class="title_prd">{{ isset($product['title']) ? $product['title'] : ''}}</h2></a>
                        <p class="thuonghieu">Thương hiệu: <span>{{ isset($product['thuong-hieu']) ? $product['thuong-hieu'] : 'Đang cật nhật'}}</span></p>
                        <p class="masanpham">Mã sản phẩm: <span>{{ isset($product['code']) ? $product['code'] : 'Đang cật nhật' }}</span></p>
                     </div>
					 <div class="pd20">
						 <p>Thông tin sản phẩm</p>
						  <div class="clearfix" style="padding-left: 20px;">
						   {!! isset($product['properties']) ? $product['properties'] : 'Đang cật nhật thông tin' !!}
						 </div>
						 <div class="clearfix mgtop20">
							<p>
							@if($product['discount'] > 0)
							  <span class="price">{{ number_format( $product['discount'] , 0) }} đ</span>
							  <span class="price-old">
							  {{ number_format( $product['price'] , 0) }} đ     
							  </span>
							@else
							 <span class="price">{{ number_format( $product['price'] , 0) }} đ</span>
							@endif
							</p>
						 </div>
						 <div class="buy-tools clearfix">
							<form onsubmit="return addToOrder(this);" method="post" accept-charset="utf-8" id="formQuantity" enctype="multipart/form-data">
							   {{ csrf_field() }}
							   <span class="text_sl">Số lượng: </span>
								 <input type="number" class="input_quantity" id="input_quantity" name="quantity[]" value="1"  style="    width: 35px;padding-left: 2px;margin-left: 12px;" />
								  <input type="hidden" class="input_quantity" id="input_quantity" name="product_id[]" value="{{ $product->product_id }}">
							   <div class="clearfix"></div>
							<button class="buttonCart">Đặt hàng</button>
							</form>
						 </div>
					 </div>
                     <!--end: .buy-tools-->
                     <div class="clearfix"></div>
                     <div class="a_right5 clearfix">
                        <p class="ngaidh">Ngại đặt hàng?</p>
                        <p class="hotline_dathang">Gọi ngay Hotline:  {{ isset($information['hotline']) ? $information['hotline'] : '' }} <br></p>
                     </div>
                  </div>
                  <!--end: .summary-->
               </div>
               <!--end: #detail-product-->
            </div>
            <!--end: #content-->
         </div>
      </div>
   </div>
</div>