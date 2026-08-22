@extends('site.layout.site')

@section('type_meta', 'article')
@section('title', isset($product->meta_title) ? $product->meta_title : $product->title )
@section('meta_description',  !empty($product->meta_description) ? $product->meta_description : $product->description)
@section('keywords', $product->meta_keyword)
@section('meta_image', !empty($product->image) ? asset($product->image) : $information['logo'] )
@section('meta_url', route('product', [ 'post_slug' => $product->slug]) )

@section('content')
    <script type='text/javascript' src='bonmuahoa/js/jquery3-3.js'></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var widthside = $(window).width();
            if (widthside >= 500) {

            }
            ;
        });
    </script>

    <!-- link rel="stylesheet" type="text/css" media="screen" href="nhathuoc365/templates/version3/scss/style.css" /> -->


  
    <script type="text/javascript" src="nhathuoc365/libraries/jquery/jquery.min.js"></script>
    <script type='text/javascript' src='nhathuoc365/js/jquery.elevatezoom.js'></script>
	@if (isset($product['banner-san-pham']) && !empty($product['banner-san-pham']))
    <section class="bannerChitiet">
        <div class="img_banner_pc">
            <img class="lazy" data-src="{{ isset($product['banner-san-pham']) ? $product['banner-san-pham'] : ''}}" alt=""
                 style="width: 100%">
        </div>
        <div class="img_banner_mb">
            <img class="lazy" data-src="{{ isset($product['banner-san-pham']) ? $product['banner-san-pham'] : ''}}" alt=""
                 style="width: 100%">
        </div>
        <div class="title_chitiet mdds-none">
            <div class="title_chitietcon">
                <span>{{ isset($product['title']) ? $product['title'] : ''}}</span>
                <p>{{ isset($product['mo-ta-banner']) ? $product['mo-ta-banner'] : ''}}</p>
                <a href="{{ isset($product['slug']) ? $product['slug'] : ''}}#bottom"
                   class="btn btn-default dathang_tuvan">Đặt hàng/ Tư vấn</a>
            </div>
        </div>
        <div class="dathang original" style="visibility: visible;">
            <div id="block-0" class="block-callme" style="float:none;margin-bottom:5px;">
                <div class="send_phone clearfix">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <p class="text_tit col-xs-6 col-sm-5 col-lg-4 mdds-none">Bạn muốn tư vấn ? Vui lòng nhập số
                                        điện thoại vào đây:</p>
                                    <form id="frm_block_call_me519759" onsubmit="return subcribeEmailSubmit(this)"
                                          method="post" class="col-ms-6 col-sm-12 col-lg-8">
                                        {{ csrf_field() }}
                                        <div class="w100">
                                            <input type="text" id="txtbmphone_sp" class="emailSubmit form-control w80 ds-inline"
                                               placeholder="SĐT của bạn" style="    margin: 8px 0;
    height: 30px;">
                                             <button class="submit_phone w20 ds-inline">Nhận tư vấn</button> 
                                        </div>
                                       
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end: .block-space-->
        </div>
        <div class="dathang  cloned"
             style="position: fixed; margin-top: 0px; z-index: 500; display: none; left: 0px; top: 0px; width: 1903px;">
            <div id="block-0" class="block-callme" style="float:none;margin-bottom:5px;">
                <div class="send_phone clearfix">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12" style="    padding-bottom: 10px;">
                                <div class="row">
                                    <p class="text_tit col-xs-6 col-sm-6">Bạn muốn tư vấn ? Vui lòng nhập số
                                        điện thoại vào đây:</p>
                                    <form id="frm_block_call_me519759" onsubmit="return subcribeEmailSubmit(this)"
                                          method="post" class="col-xs-6 col-sm-6">
                                        {{ csrf_field() }}
                                        <input type="text" id="txtbmphone_sp" class="emailSubmit form-control"
                                               placeholder="SĐT của bạn">
                                        <button class="submit_phone">Nhận tư vấn</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end: .block-space-->
        </div>
    </section>
	@endif
    <div class="wrapper wrapper-product-detail container">
        <section id="content" class="detail row ">
            <div id="detail-product" class=" ">
                <div class="product-detail-left product-images col-xs-12 col-sm-6 col-md-6 col-lg-4">
                    <div class="leftImg">
                        <div class="imgLage hidden_MB mbds-none">
                            @if(!empty($product->image_list))
                                @foreach(explode(',', $product->image_list) as $idImage => $imageProduct)
                                    @if($idImage == 0)
                                        <img class="lazy" id="zoom_01" data-src="{{ isset($imageProduct) ? $imageProduct : ''}}"
                                             data-zoom-image="{{ isset($imageProduct) ? $imageProduct : ''}}"/>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="imgLage show_MB hiddenMD ds-none mbds-block">
                            @if(!empty($product->image_list))
                                @foreach(explode(',', $product->image_list) as $idImage => $imageProduct)
                                    @if($idImage == 0)
                                        <img class="lazy" id="imageProductMobile" data-src="{{ isset($imageProduct) ? $imageProduct : ''}}"/>
                                    @endif
                                @endforeach
                            @endif

                        </div>
                        <div id="gal1" class="imgmedum mbds-none">
                            @if(!empty($product->image_list))
                                @foreach(explode(',', $product->image_list) as $imageProduct)
                                    <a href="#" data-image="{{$imageProduct}}" data-zoom-image="{{$imageProduct}}">
                                        <img class="lazy" id="zoom_01" data-src="{{$imageProduct}}"/>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                        <div id="gal1" class="imgmedum ds-none mbds-block">
                            @if(!empty($product->image_list))
                                @foreach(explode(',', $product->image_list) as $imageProduct)
                                    <a data-image="{{$imageProduct}}" data-zoom-image="{{$imageProduct}}">
                                        <img class="lazy" id="zoom_01" data-src="{{$imageProduct}}" onClick="return changeImage(this);"/>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <style type="text/css">
                        #zoom_01 {
                            max-width: 100%;
                        }

                        .leftImg .imgLage {
                           
                            text-align: center;
                        }

                        .leftImg .imgLage img {
                            height: 100%;
                            max-height: 350px;
                        }

                        #gal1 {
                            text-align: center;
                        }

                        #gal1 a img {
                            width: 80px;
                            max-width: 80px;
                            border: 1px solid #ccc;
                            height: 80px;
                            max-height: 80px;
                            margin: 10px 5px;
                        }

                        .detail-more img {
                            max-width: 100% !important;
                        }
                    </style>
                    <script>
                        //initiate the plugin and pass the id of the div containing gallery images
                        $("#zoom_01").elevateZoom({gallery: 'gal1', cursor: 'pointer'});
                        //pass the images to Fancybox
                        $("#zoom_01").bind("click", function (e) {
                            var ez = $('#zoom_01').data('elevateZoom');
                            $.fancybox(ez.getGalleryList());
                            return false;
                            $('#zoom_01').css('width', '420px');
                            $('#zoom_01').css('height', '280px');
                        });

                        function changeImage(e) {
                            var linkImage = $(e).attr('src');

                            $('#imageProductMobile').removeAttr('src');
                            $('#imageProductMobile').attr('src', linkImage);

                        }
                    </script>
                </div>
                <!--end: .thumb-->
                <div class=" col-xs-12 col-sm-6 col-md-6 col-lg-8">
                    <div class="summary">
                        <div class="a_right clearfix">
                            <h1>{{ isset($product['title']) ? $product['title'] : ''}}</h1>
                            @if (!empty($product['thuong-hieu']))
                            <p class="thuonghieu">Thương hiệu:
                                <a data-value="{{ $product['thuong-hieu'] }}" href="{{ isset(\App\Entity\Post::getPostDetail(\App\Ultility\Ultility::createSlug($product['thuong-hieu']))['duong-dan-thuong-hieu-san-pham']) ? \App\Entity\Post::getPostDetail(\App\Ultility\Ultility::createSlug($product['thuong-hieu']))['duong-dan-thuong-hieu-san-pham'] : '#' }}" style="cursor: pointer;" >
                                    {{ isset($product['thuong-hieu']) ? $product['thuong-hieu'] : ''}}
                                </a>
                            </p>
                           
                          
                            @endif
                            <p class="masanpham mgbottom20">Mã sản phẩm:
                                <span>{{ isset($product['code']) ? $product['code'] : ''}}</span></p>
                        </div>
						
                        <div class="sum_prd clearfix">
                            {!! isset($product['properties']) ? $product['properties'] : 'Đang cật nhật thông tin' !!}
                        </div>
						<div class="pdleft20">
                        @if (time() <= strtotime($product->deal_end))
                            <div class="price">{{ number_format( $product['price_deal'] , 0) }} đ</div>
                            <div class="price-old">
                                <?php
                                $sale = ($product['price_deal'] / ($product['price'] / 100));
                                $sale_price = $product['price'] - $product['price_deal'];
                                ?>
                                <span>Tiết kiệm:<span class="phan_tram"> <?php echo ceil(100 - $sale) ?> % </span><span
                                            class="price_giam">({{ number_format( $sale_price , 0) }} đ ) </span>
                                </span>
                                <span>Giá thị trường: {{ number_format( $product['price'] , 0) }} đ</span>
                            </div>
                        @elseif($product['discount'] > 0)
                            <div class="price">{{ number_format( $product['discount'] , 0) }} đ</div>
                            <div class="price-old">
                                <?php
                                $sale = ($product['discount'] / ($product['price'] / 100));
                                $sale_price = $product['price'] - $product['discount'];
                                ?>
                                <span>Tiết kiệm:<span class="phan_tram"> <?php echo ceil(100 - $sale) ?> % </span><span
                                            class="price_giam">({{ number_format( $sale_price , 0) }} đ ) </span>
                                </span>
                                <span>Giá thị trường: {{ number_format( $product['price'] , 0) }} đ</span>
                            </div>
                        @else
                            <div class="price">{{ number_format( $product['price'] , 0) }} đ</div>
                        @endif
						</div>
                        <input type="hidden" name="product_price" id="product_price" value="195000"/>
                        <div class="buy-tools clearfix">
                            <form onsubmit="return addToOrder(this);" enctype="multipart/form-data"
                                  id="add-to-cart-form" method="post" accept-charset="utf-8">
                                {{ csrf_field() }}
                                <input type="hidden" class="quantity" name="quantity[]" value="1"/>
                                <input type="hidden" class="product_id" name="product_id[]"
                                       value="{{ $product->product_id }}"/>
                                <div class="clearfix"></div>
                                <p></p>
                                <button class="dat_hang add-cart-0" style="display: block;  border: none;"
                                        type="submit">Đặt Hàng
                                </button>
                            </form>
                            @if(isset($product['link-chung-tu']))
                                <a class="payChungtu" style="display: block;  border: none;"
                                   href="{{ isset($product['link-chung-tu']) ? $product['link-chung-tu']  : ''}}"><i
                                            class="fa fa-eye" aria-hidden="true"></i> Xem chứng từ</a>
                            @endif
                            <div class="clearfix"></div>
                        </div>
                        <!--end: .buy-tools-->
                        <div class="clearfix"></div>
                        <div class="a_right5 clearfix">
                            <p class="hotline_dathang">Gọi ngay
                                Hotline: {{ isset($information['hotline']) ? $information['hotline'] : '' }}<br> <span>(Tư vấn miễn phí - Thời gian: 8h00 - 20h30)</span>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <div class="a_right5 clearfix">



                            <p class="title_1">Ngại gọi điện? Vui lòng nhập số điện thoại </p>
                            <form  id="frm_call_me631" action="#" method="post" onsubmit="return subcribeEmailSubmit(this)" class="mdds-none">
                                {{ csrf_field() }}
                                <div class="input_dathang">
                                    <input type="text"  id="txt_phone"  name="txt_phone" class="form-control emailSubmit" placeholder="Yêu cầu tư vấn">
                                    <button  class="submit_phone_2" type="submit" >Gọi lại cho tôi ngay</button>
                                </div>
                            </form>
                            @if(!empty($product['tags']))
                            <div class="tags">
                                <p class="timkiem_dathang">Gợi ý tìm kiếm:</p>

                                    @foreach(explode(',', $product['tags']) as $tag)
                                        <a href="/tags?tags={{ $tag }}" title="{{ $tag }}"><span class="tag">{{ $tag }},</span></a>
                                    @endforeach

                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <form  id="frm_call_me631" action="#" method="post" onsubmit="return subcribeEmailSubmit(this)" class="ds-none mdds-block w100 ">
                                {{ csrf_field() }}
                                <div class="input_dathang w100 contactInput">
                                    <input type="text"  id="txt_phone"  name="txt_phone" class="form-control emailSubmit w80 ds-inline" placeholder="Yêu cầu tư vấn" >
                                    <button  class="submit_phone_2 w19 ds-inline contact" type="submit" >Gọi lại cho tôi ngay</button>
                                </div>
                            </form>
                </div>
                <!--end: .summary-->
                <div class="clearfix"></div>
               
                <div class="detail-more col-xs-12">
                    {!! isset($product['content']) ? $product['content'] : 'Đang cập nhật thông tin' !!}
                </div>


                 <div class="col-12" style="margin: 15px">
                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) return;
                      js = d.createElement(s); js.id = id;
                      js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.1';
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                    <div class="fb-like" data-href="{{ route('product', ['post_slug' => $product->slug]) }}" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                </div>

                <div class="function mb30" style="margin: 15px">
                    @include('general.sub_comments', ['post_id' => $product->post_id] )
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12">
                    <p id="bottom"></p>
                    @include('site.partials.form_product')
                </div>
            </div>
            <!--end: #detail-product-->
            <div class="clearfix">
                <div id="block-112" class="block-product block-product-product_release" style="margin-bottom:20px;">
                    <div class="block-content clearfix">
                    </div>
                    <!--end: .block-content -->
                </div>
                <!--end: #block-112-->
            </div>
            @if (!empty($productSeen))
           <div id="same_products" class="col-xs-12">
                <div class="title">
                    Sản phẩm đã xem
                </div>
				
                <div class="block-content">
                    @foreach($productSeen as $id => $productSee)
                        @if ($productSee->product_id != $product->product_id)
                            @include('site.partials.itemRel', ['product' => $productSee])
                        @endif
                    @endforeach
                </div>
			
            </div>
            @endif

            <div id="same_products" class="col-xs-12">
                <div class="title">
                    Sản phẩm liên quan
                </div>
                <div class="block-content">
                    @foreach(\App\Entity\Product::relativeProduct($product->slug, $product->product_id, 20) as $id => $productRelative)
                        @include('site.partials.itemRel', ['product' => $productRelative])
                    @endforeach
                </div>
            </div>
        </section>
        <!--end: #content-->
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
        <div class="Notification" id="popupVitural">
        <div class="Closed">X</div>
        <div class="Content">
            <h3>Bạn muốn mua hàng trực tiếp</h3>
            <p>Hãy đặt hàng để được chiết khấu khi tới nhà thuốc</p>
            <form action="{{ route('sub_contact') }}" method="post" onSubmit="return contact(this);">
                {!! csrf_field() !!}
                <div class="form-group">
                   
                    <input type="text" class="form-control" name="name" required placeholder="Họ và tên"/>
                </div>

                <div class="form-group">
                  
                    <input type="email" class="form-control" name="email" required placeholder="Email"/>
                </div>

                <div class="form-group">
                  
                    <input type="number" class="form-control"  name="phone" required placeholder="Số điện thoại"/>
                </div>

                <div class="form-group textarea">
                    <textarea name="message" class="form-control" required>{{ $product->title }}</textarea>
                </div>
                <p class="peson">Quý khách điền đẩy đủ thông tin để được nhận tư vấn tốt nhất ! </p>

                <div class="form-group">
                    <Button type="submit" class="btn btnsubmit  form-control">GỬI</Button>
                </div>
            </form>
        </div>

    </div>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            $('#popupVitural').hide();

            setInterval(function(){
                $('#popupVitural').show().slideDown();
            }, 15000);


            $('#popupVitural .Closed').click(function(){
                $('#popupVitural').slideUp().hide();
                $('#popupVitural').addClass('hide');
            });
        });
    </script>
@endsection