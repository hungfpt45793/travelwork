<section class="dd-menu">
   <div class="wrapper container">
      <div class="contain_slide clearfi row">
         <div class="col-md-3">
         </div>
         <div class="col-md-9 slide-h" style="padding:0;">
            <div id="slide_homel" class="carousel slide" data-ride="carousel">
               <!-- Wrapper for carousel items -->
               <div class="carousel-inner">
                  @foreach(\App\Entity\SubPost::showSubPost('slider', 10) as $id => $slide)
                  <div class="item {{ ($id == 0) ? 'active' : '' }}">
                     <a href="{{ $slide['duong-dan'] }}">
                     <img class="img-responsive lazy" src="{{ $slide['image'] }}" />
                     </a>
                  </div>
                  @endforeach
               </div>
               <!-- Carousel controls -->
               <a class="carousel-control left" href="#slide_homel" data-slide="prev">
               <span class="prev"></span>
               </a>
               <a class="carousel-control right" href="#slide_homel" data-slide="next">
               <span class="next"></span>
               </a>
            </div>
         </div>
      </div>
   </div>
   <!--end: .canvas-->
</section>