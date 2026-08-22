@extends('site.layout.site')

@section('title','Đăng ký')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')
 <section class="content " style="background:#eeeeee;padding-top:20px; ">
      <div class="container">
         <div class="row ">
             <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                 <div class="link bgrWhite md-mgt20 mgb10">
                     <ul class="nav">
                         <li class="nav-item pd8">

                             <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                         </li>
                         <li class="nav-item pd8">
                             <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                         </li>
                         <li class="nav-item pd8">
                             <?php
                             $link_url ='#';
                             $link_url = \App\Ultility\Ultility::getUrl();
                             ?>
                             <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> <i class="fas fa-users mgr5"></i>Đăng ký tài khoản</a>
                         </li>
                     </ul>
                 </div>
             </div>


            <div class="col-xl-12 col-lg-12 col-md-12 JobSeeker">
               <div class="main">
                  <div class="notificationBox">
                     <h5 class="blueN textUpper fw7 bdLeftBlueN5x pdl10 mgf18">
                        ĐĂNG ký tài khoản
                     </h5>
                     <hr>

                     <ul class="nav justify-content-center rs_a_link_bg">
                        <li class="nav-item">
                          <a class="nav-link textUpper bgrBlueN white hvWhite fw5 pd15 mbf16 bg_empoyer" href="{{route('employer_register')}}">NHÀ TUYỂN DỤNG ĐĂNG KÝ</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link textUpper bgrBlueN white hvWhite fw5 pd15 mgl20 mgr20 mbf16 bg_empoyee" href="{{route('employee_register')}}">ỨNG VIÊN ĐĂNG KÝ</a>
                        </li>
                        <li class="nav-item">
                          <!--  -->
                            <a class="nav-link textUpper bgrBlueN white hvWhite fw5 pd15 mbf16 bg_teacher" href="{{route('teacher_register')}}">KẾ TOÁN THUẾ ĐĂNG KÝ</a>
                        </li>
                      </ul>
                <hr>
                  </div>
                 
               </div>

@include('site.module_index.dang-ky-tu-van')
							
               <section class="Support bgrWhite pd40 mgt30 mgb30">
                  <div class="notificationBox formJobLarge mt30" style="background: #f6eecc">
                     <div class="">
                        <p
                           class="supportTitle text-center fontBold f23 lg-f25 blueDN pdt0 mgb20 lg-mgb10 lg-f23 md-f17 sm-f16">
                           TỔNG ĐÀI TƯ VẤN <span class="sm-block">CHĂM SÓC KHÁCH HÀNG</span></p>
                     </div>
                     <div class="row">
                        @foreach(\App\Entity\SubPost::showSubPost('hotline', 3) as $id => $hotline)
                          <div class="col-lg-4 col-md-4 text-center">
                            <span class="lg-f16 md-f14">{{$hotline->title}}:</span> <span class="red fw7 f30 lg-f23 md-f15">&nbsp;{{$hotline->description}}</span>
                          </div>
                        @endforeach
                     </div>
                  </div>
               </section>

            </div>
         </div>
      </div>
   </section>
        
        
        

@endsection
