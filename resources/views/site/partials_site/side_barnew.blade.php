<aside id="aside">
    <div id="block-72" class="block-catsmenu block-catsmenu-news mgbottom20">
        <div class="sidebar-heading">
            Danh mục bài viết<span class="show-cat">
        </div>
        <!--end: .sidebar-heading-->
        <div class="sidebar-content">
            <ul class="cats">
                @foreach (\App\Entity\Menu::showWithLocation('show-slide-category-new') as $Mainmenu)
                    @foreach (\App\Entity\MenuElement::showMenuPageArray($Mainmenu->slug) as $id=>$menuelement)
                        <li class="menu-1468  "><a href="{{ $menuelement['url']}}" title="{{ $menuelement['title_show']}}">{{ $menuelement['title_show']}}</a></li>
                @endforeach
            @endforeach
            <!-- show-slide-category-new -->
            </ul>
        </div>
        <!--end: .sidebar-content-->
    </div>
    <!--end: .block-catsmenu-->
    <div id="block-116" class="block-product block-product-aside_slideshow_price" style="margin-top:20px;">
        <div class="aside-heading col-xs-12">
            sản phẩm mới
        </div>
        <!--end: .aside-heading-->
        <div class="aside-content clearfix">
            <ul>
                @foreach (\App\Entity\Product::showProduct('san-pham-moi',3) as $id => $product)
                    <li class="product-item col-md-12 col-sm-4 col-xs-12">
                        <div class="inner">
                            <div class="CropImg CropImg70 mgbottom10">
                                <div class="thumbs">
                                    <a class="thumb" title="{{ isset($product['title']) ? $product['title'] : ''}}" href="{{ route('product',['cate_slug' => $product->slug]) }}">
                                        <span><img class="lazy" alt="{{ isset($product['title']) ? $product['title'] : ''}}" src="{{ isset($product['image']) ? $product['image'] : ''}}" onerror="this.src='{{ isset($product['image']) ? $product['image'] : ''}}'"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="heading pd0 mgbottom10">
                                <a title="{{ isset($product['title']) ? $product['title'] : ''}}" href="{{ route('product',['cate_slug' => $product->slug]) }}">{{ isset($product['title']) ? $product['title'] : ''}}</a>
                            </div>
                            <p>
                                @if($product['discount'] > 0)
                                    <span class="price">{{ number_format( $product['discount'] , 0) }} đ</span>
                                    <span class="price_old" style="padding-left: 5px">
                                        <del>{{ number_format( $product['price'] , 0) }} đ</del>
                                    </span>
                                @else
                                    <span class="price">{{ number_format( $product['price'] , 0) }} đ</span>
                                @endif
                            </p>
                        </div>
                        <!--end: .inner-->
                    </li>
            @endforeach
            <!-- .product-item-->

                <!-- .product-item-->
                <!-- .product-item-->
            </ul>
        </div>
        <!--end: .aside-content-->
    </div>
    <!--end: #block-116-->
</aside>