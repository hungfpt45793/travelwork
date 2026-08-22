@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', isset($category['meta_title']) && !empty($category['meta_title']) ? $category['meta_title'] : $category->title)
@section('meta_description',  isset($category['meta_description']) && !empty($category['meta_description']) ? $category['meta_description'] : $category->description)
@section('keywords', isset($category['meta_keyword']) && !empty($category['meta_keyword']) ? $category['meta_keyword'] : '')
@section('meta_image', isset($category->image) && !empty($category->image) ?  asset($category->image) : $information['logo'] )
@section('meta_url', isset($category->slug) ? '/cua-hang/'.$category->slug : '/cua-hang/san-pham')

@section('content')
<section class="main-ctn">
	<div class="container">
   <div class="wrapper wrapper-product-category">
      <div class="breadcrumbs row">
         <div class="wrapper col-xs-12">
            <ul class="breadcrumbUrl">
               <li class="breadcrumb-item">
                  <a class="home" href="/">Trang chủ <i class="fa fa-angle-right mgleft10"></i></a>
               </li>
               <li class="breadcrumb-item">
                  <a><span itemprop="title">{{ isset($category->title) ? $category->title : '' }}</span></a>
               </li>
            </ul>
         </div>
      </div>
      <!--end: .breadcrumbs-->
      <section class="product-category-content">
         <div class="block-categories block-categories-default " style="margin-bottom:20px;">
            <!--end: .block-heading-->
            <div class="block-content row">

               <div class="list_cat_child col-md-3 col-sm-5 col-xs-12">
                  <aside id="aside">
                     <div class="block-catsmenu block-catsmenu-products">
                        <div class="sidebar-heading-f">
                           Lọc sản phẩm
                           <i class="show_mb"></i>
                        </div>
                        <div class="span3-cotent sidebar-content">
                           <div class="sidebar span3-cotent sidebar-content" >
                              <ul class="submenu-mb color-border cats">
                                 @foreach (\App\Entity\Menu::showWithLocation('side-left-menu') as $Mainmenu)
                                    @foreach (\App\Entity\MenuElement::showMenuPageArray($Mainmenu->slug) as $id=>$menuelement)
                                 <li class="item menu-1 has-child">
                                    <a href="{{ $menuelement['url'] }}" class="current" title="{{ $menuelement['title_show'] }}">
                                    {{ $menuelement['title_show'] }}
                                    </a>
                                    <i class="fa fa-angle-down show-hidden" aria-hidden="true"></i>
                                     @if (!empty($menuelement['children']))
                                      <ul class="submenu-mb1">
                                       @foreach ($menuelement['children'] as $elemenparent)
                                         
                                             <li><a href="{{ $elemenparent['url']}}" title=" {{ $elemenparent['title_show']}} "><i class="fa fa-caret-right" aria-hidden="true"></i> {{ $elemenparent['title_show']}} </a></li>
                                             
                                      @endforeach
                                     </ul>
                                   @endif
                                    
                                 </li>
                                  @endforeach
                               @endforeach
                                 
                              </ul>
                           </div>
                        </div>
						<script>
							$('.submenu-mb li').click(function(){
								if($(this).find('.submenu-mb1').is(":hidden")){
									$(this).find('.submenu-mb1').slideDown();
									$(this).find('.show-hidden').removeClass('fa-angle-down');
									$(this).find('.show-hidden').addClass('fa-angle-up');
								}
								else {
									$(this).find('.submenu-mb1').slideUp();
									$(this).find('.show-hidden').removeClass('fa-angle-up');
									$(this).find('.show-hidden').addClass('fa-angle-down');
								}
							});
						</script>
                        <!--end: .span3-cotent-->
                     </div>
                     <!--end: .block-catsmenu-->
                     <!--end: #block-87-->            
                  </aside>
                  @foreach(\App\Entity\FilterGroup::showFilterGroup() as $id => $filterGroup)
                  <div class="filter">
                     <div class="filter-title">{{ $filterGroup->group_name }}</div>
                     <ul tabindex="0" style="overflow: hidden; outline: none;">
                        @foreach(\App\Entity\Filter::showFilter($filterGroup->group_filter_id) as $id => $filter)
                        <li class="check">
                           <a data-value="{{ $filter->name_filter }}" onClick="return checkFilter(this);"> <i class="fa fa-caret-right" aria-hidden="true"></i>
                              {{ $filter->name_filter }}
                           </a>
                        </li>
                        @endforeach
                     </ul>
                  </div>
                  @endforeach
                  <form action="" method="get" id="filterProduct">
            
                    </form>
                    <script>
                       function checkFilter(e) {
                          var valFilter = $(e).attr('data-value');
                          $('#filterProduct').append('<input type="hidden" value="' + valFilter + '" name="filter[]">')
                          $('#filterProduct').submit();

                          return true;
                       }
                    </script>
                  @if(!empty($category['image']))
                  <div  id="banner-103" class="item">
                     <a rel="nofollow" href="/" title="{{ $category['title'] }}">
                     <img class="lazy" data-src="{{ $category['image'] }}" alt="Khuyến mại lớn Nano Fucoidan">
                     </a>
                  </div>
                  @endif
               </div>

               <div class="list-item clearfix col-md-9 col-sm-7 col-xs-12">
                  <div class="row">
                  @if(empty($products) || $products->isEmpty())
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12 cateItem noPadding">
                      <p>Không có sản phẩm phù hợp</p>
                  </div>
                  @else

                  @foreach ($products as $id => $product)
                  @include('site.partials.itempr')
                  @endforeach
                  @endif

                  <!--end: .product-item-->  
                  <p>
                  <div class='web-pagination Page'>
                     @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator )
                        {{ $products->links() }}
                      @endif
                  </div>
                
                  </p>
                    </div>

               </div>
                

            </div>
            <!--end: .block-content-->
         </div>
      </section>
   </div>
   </div>
</section>
<div class="banner_left"></div>
<div class="banner_right"></div>
@endsection