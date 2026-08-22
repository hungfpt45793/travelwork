@extends('site.layout.site')

@section('title','Dành cho nhà tuyển dụng')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')
@section('content')

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<section class="slideLadipage mgb10">
    <div class="container">
      <div class="slidesssss">
      @foreach(\App\Entity\SubPost::showSubPost('slide-landingpage', 8) as $id => $slide)
         <div class="item">
          <div class="row">
             <div class="col-md-6">
               <img class="lazy" src="{{isset($slide['image']) ? $slide['image'] : ''}}" alt="" width="100%">
            </div>
            <div class="col-md-6 pd30 lineHeight25">
               <p class="font20 fontBold mgb20">{{isset($slide['title']) ? $slide['title'] : ''}}</p>
               <p class="font16 text-justify">{{isset($slide['description']) ? $slide['description'] : ''}}</p>
            </div>
          </div>
         </div>
    @endforeach
       
      </div>
      <script type="text/javascript">
       $(document).ready(function(){
          $('.slidesssss').slick({
             autoplay:true,
             autoplaySpeed:3000,
          });
       })
      </script>
    </div>
 </section>
   
 <section class="bgrCall mh76-height200 mh42-height250 mh32-height270">
    <div class="container">
       <div class="row">
          <div class="col-lg-9 col-12 white lineHeight35 mgt30">
             <p class="fontBold font24">{{$post->title}}</p>
             <p class="font20">{{$post->description}}</p>
          </div>
          <div class="col-lg-3 col-12 mgt50 text-right mh10-mgt40 mh76-mgt15 mh76-textL">
             <a class="btn white bgrTim pd10-30 fontBold">
                <!-- Button trigger modal -->
                <span  class="dsInBlock font30" data-toggle="modal" data-target="#modelId">
                 <i class="fab fa-telegram-plane"></i> Liên hệ
                </span>
             </a>
          </div>
       </div>
    </div>
 </section>

 <section class="contentLadipage mgb20">
    <div class="container">
       <div class="row">
          <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
          <div class="JobSeeker EmployerRegistration mgb20">
               <div class="main">
               <form action="{{route('dang_ky_tuyen_dung')}}" id="location-form" method="post">
                  {!! csrf_field() !!}
                     <div class="notificationBox mgt20">
                        <p class="text-title font15Im mgt0Im">
                           nhà tuyển dụng đăng ký nhanh
                        </p>
                        <hr>

                        <div class="supporter text-ct">
                           <span>Nếu gặp bất kỳ khó khăn nào vui lòng liên hệ Hotline hỗ trợ nhà tuyển dụng <br><br>
                               <span class="block font20 red">
                                   <span class="dsBlock">
                                       <b> {{isset($information['hotline']) ? $information['hotline'] : ''}} </b>
                                   </span>
                               </span>
                           </span>
                        </div>
                       
                        <div class="recruitmentRegistration">
                           <p class="text-title font15Im">
                              thông tin công ty
                           </p>
                        </div>
                        <div class="bodyBox">
                           <div class="accountInfo">
                                 <div class="form-group row">
                                    <label class="col-12 text-left lable">Tên công ty<span>*</span> </label>
                                    <div class="col-12">
                                       <input type="text" name="name" class="form-control" placeholder="Tên công ty">
                                       <small id="emailHelp" class="form-text text-muted"><i>Ghi tên công ty đầy đủ và rõ
                                             ràng theo Giấy phép đăng ký kinh doanh.</i></small>
                                    </div>
                                 </div>
                                
                                 <div class="form-group row">
                                    <label for="staticEmail" class="col-12 text-left lable">Địa chỉ công ty<span>*</span>
                                    </label>
                                    <div class="col-12">
                                       <input type="text" id="location-input"  name="address"  class="form-control" placeholder="Địa chỉ công ty">
                                    </div>
                                 </div>
                                
                                 <div class="form-group row">
                                    <label for="staticEmail" class="col-12 text-left lable">Tên người phụ trách<span>*</span> </label>
                                    <div class="col-12">
                                       <input type="text"  name="employer_name"  class="form-control" placeholder="Tên người phụ trách">
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label class="col-12 text-left lable">Số điện thoại liên hệ<span>*</span> </label>
                                    <div class="col-12">
                                       <input type="text"  name='phone'  class="form-control" placeholder="Số điện thoại liên hệ">
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label class="col-12 text-left lable">Tài khoản Email<span>*</span> </label>
                                    <div class="col-12">
                                       <input type="text"  name='email'  class="form-control" placeholder="Email là tài khoản đăng nhập">
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label class="col-12 text-left lable">Mật khẩu <span>*</span> </label>
                                    <div class="col-12">
                                       <input type="password"  name='password'  class="form-control" placeholder="Mật khẩu">
                                    </div>
                                 </div>
                                    <div class="form-group row">
                                       <label class="col-12 text-left lable">Chế độ đãi ngộ<span></span> <span class="XamMo">(Tối đa 6 đãi ngộ)</span></label>
                              
                                       <div class="col-12 dai-ngo">
                                          <input type="text"  name='remuneration[]' class="form-control mgb10" placeholder="Nhập chế độ đãi ngộ  (Tối đa 50 ký tự)">
                                          <a class='them-dai-ngo'><i class="fas fa-plus"></i> Thêm đãi ngộ</a>
                                       </div>
                                    </div>
                                       <label class="col-12 text-left lable">
                                    <div class="form-group row">
                                       Vì sao nên ứng tuyển công ty tôi<span></span>
                                       <span class="XamMo mgb10">(Tối đa 3 lý do)</span>
                                    </label>
                                    <div class="col-12 pd0 li-do-chon">
                                       <textarea name="reason_choose[]" id="txtNote" rows="3" class="textarea font17 w100 pdt5" placeholder="  Nhập lý do  (Tối đa 100 ký tự)" style="width: 100%;"></textarea>
                                          <a class='them-li-do'><i class="fas fa-plus"></i> Thêm lý do</a>
                                       </div>
                                    </div>
                                    <div class="col-12 pd0 li-do-chon">
                                    <input type="text" id='lat' name='latitude' value="" class="form-control mgb10" style="display:none" placeholder="">
                                     
                                    </div>
                                    <div class="col-12 pd0 li-do-chon">
                                    <input type="text" id='lng' name='longitude' value=""  class="form-control mgb10" style="display:none" placeholder="">
                                       
                                    </div>
                                     <div class="form-group row">
                                        <div class="col-12 text-ct">
                                           <button type="submit" class="btn">ĐĂNG KÝ</button>
                                        </div>
                                     </div>
                              </div>
                        </div> 
                     </div>
                  </form>
                  <script>
                     $(".loai-hinh").select2({
                        placeholder: "Select a state",
                        allowClear: true,
                        tokenSeparators: [',', ' ']
                     })
                  </script>
                
                  <div class="form-group error">
                     @if ($errors->has('email'))
                           <label for="exampleInputEmail1">{{ $errors->first('email') }}</label>
                     @endif
                     @if ($errors->has('password'))
                           <label for="exampleInputEmail1">{{ $errors->first('password') }}</label>
                     @endif
                     @if ($errors->has('name'))
                           <label for="exampleInputEmail1">{{ $errors->first('name') }}</label>
                     @endif
                     @if ($errors->has('address'))
                           <label for="exampleInputEmail1">{{ $errors->first('address') }}</label>
                     @endif
                     @if ($errors->has('employer_name'))
                           <label for="exampleInputEmail1">{{ $errors->first('employer_name') }}</label>
                     @endif
                     @if ($errors->has('phone'))
                           <label for="exampleInputEmail1">{{ $errors->first('phone') }}</label>
                     @endif
                  </div>
                  <style>
                  .error label{
                     background:#ef5050;
                     color:#fff;
                     padding:5px;
                     margin-right:5px;


                  }
                  </style>
               
                  
               </div>
            </div>
             <div class="inf font16 text-justify bgrWhite mgt20 pd30 borderRadius10 borderLight lineHeight35 mgb20">
                {!!$post['content']!!}
             </div>
        			 <div class="SupportStaffPeople bgrWhite pdb20 borderLight borderRadius10 mgb20">
               <h3 class="text-ct fontBold font20 bgrTim pdb20 pdt20 white lineHeight25" style="border-top-left-radius: 10px;
               border-top-right-radius: 10px;"> HỖ TRỢ TƯ VẤN TUYỂN DỤNG </h3>
               <h3 class="text-ct fontBold font18 Tim mgb20 pdt20"> TEAM MIỀN BẮC </h3>
                        <div class="EmployeesTiva">
                          @foreach(\App\Entity\SubPost::showSubPost('team-mien-bac', 8) as $id => $bac)
                           <div class="PeopleTiva">
                              <div class="imgTiva">
                                 <img class="lazy" src="{{ $bac->image }}" alt="">
                              </div>
                              <div class="infoTiva text-ct fontBold">
                                 <a class="dsBlock font16 mgb5">{{ $bac->title }}</a>
                                 <a class="dsBlock font16">{{ $bac->description }}</a>
                              </div>
                           </div>
                           @endforeach
                       </div>
             <h3 class="text-ct fontBold font18 Tim mgb20 pdt20"> TEAM MIỀN TRUNG </h3>
                        <div class="EmployeesTiva">
                           @foreach(\App\Entity\SubPost::showSubPost('team-mien-nam', 8) as $id => $nam)
                           <div class="PeopleTiva">
                              <div class="imgTiva">
                                 <img class="lazy" src="{{ $nam->image }}" alt="">
                              </div>
                              <div class="infoTiva text-ct fontBold">
                                 <a class="dsBlock font16 mgb5">{{ $nam->title }}</a>
                                 <a class="dsBlock font16">{{ $nam->description }}</a>
                              </div>
                           </div>
                           @endforeach
                       </div>
             <h3 class="text-ct fontBold font18 Tim mgb20 pdt20"> TEAM MIỀN NAM </h3>
                        <div class="EmployeesTiva">
                           @foreach(\App\Entity\SubPost::showSubPost('team-mien-trung', 8) as $id => $trung)
                           <div class="PeopleTiva">
                              <div class="imgTiva">
                                 <img class="lazy" src="{{ $trung->image }}" alt="">
                              </div>
                              <div class="infoTiva text-ct fontBold">
                                 <a class="dsBlock font16 mgb5">{{ $trung->title }}</a>
                                 <a class="dsBlock font16">{{ $trung->description }}</a>
                              </div>
                           </div>
                           @endforeach
                       </div>
                     </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mgt20 pd0Im" >
             <div class="Candidate bgrWhite pdb5 borderRadius10 borderLight">
                <div class="titleCVNews bgrTim white text-center font20 pd10 fontBold">
                   CV ứng viên mới
                </div>
                <div id='listCV'>
                   
               </div>
             </div>
             <div class="Function mgt20 borderRadius10 borderLight">
                <div class="titleCVNews bgrTim white text-center font20 pd10 fontBold">
                   Các tính năng
                </div>
                <div class="Functions bgrWhite text-center lineHeight25 pd15">
                @foreach(\App\Entity\SubPost::showSubPost('cac-tinh-nang', 8) as $id => $tinhNang)
                   <div class="Fun">
                      <img class="lazy" src="{{isset($tinhNang['image']) ? $tinhNang['image'] : ''}}" alt="" width="40%">
                      <p class="font18">{{isset($tinhNang['title']) ? $tinhNang['title'] : ''}}</p>
                      <p>{{isset($tinhNang['description']) ? $tinhNang['description'] : ''}}</p>
                      <a class="btn bgrTim white fontBold mgt20 mgb30" data-toggle="modal" data-target="#modelId">Đăng tuyển ngay</a>
                   </div>
               @endforeach
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>   
 
 <section class="bgrCall mh76-height200 mh42-height220 mh37-height260 mh32-height300">
    <div class="container">
       <div class="Callssss text-center pdt30">

          <p class="white pdb20 fontBold font28 mh76-lineHeight30">Tất cả những gì bạn cần để bạn có thể tìm thấy ứng viên phù hợp</p>
          <form onSubmit="return subcribeEmailSubmit(this);" class="wpcf7-form"  id="contact_form" method="post" 
           action="{{route('subcribe_email')}} ">
            {!! csrf_field() !!}
            <input type="hidden"  name="is_json" class="form-control captcha" value="1" placeholder="">	

            <input class="SignUpFor mgr20 emailSubmit mh37-dsBlock mh37-marginAuto mh37-mgb10" type="text" name="email" placeholder="Nhập email của bạn">
            <input type="submit" class="btn bgrTim white fontBold pd12Im" value='Đăng ký nhận tin' >
         </form>

       </div>
    </div>
 </section>


 
 <!-- Modal -->
 <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
     <div class="modal-dialog setWidth modal-lg" role="document" style="width:60%;">
          
         <div class="modal-content ">
             <button  type="button" class="close" data-dismiss="modal" style="position:absolute;right:10px;z-index:999;top:5px;">&times;</button>
         <div class="col-xl-12 col-lg-12 col-md-12 JobSeeker EmployerRegistration mgb20">
               <div class="main">
               <form action="{{route('dang_ky_tuyen_dung')}}" id="location-form" method="post">
                  {!! csrf_field() !!}
                     <div class="notificationBox mgt30">
                        <p class="text-title font15Im mgt0Im">
                           nhà tuyển dụng đăng ký nhanh
                        </p>
                        <hr>

                        <div class="supporter text-ct">
                           <span>Nếu gặp bất kỳ khó khăn nào vui lòng liên
                              hệ Hotline hỗ trợ nhà tuyển dụng <br><br><span class="block font20 red"> <span class="dsBlock">
                                <b> {{isset($information['hotline']) ? $information['hotline'] : ''}} </b> </span>
                           </span>
                        </div>
                       
                        <div class="recruitmentRegistration">
                           <p class="text-title font15Im">
                              thông tin công ty
                           </p>
                        </div>
                        <div class="bodyBox">
                           <div class="accountInfo">
                             
                                 <div class="form-group row">
                                    <label class="col-12 text-left lable">Tên công ty<span>*</span> </label>
                                    <div class="col-12">
                                       <input type="text" name="name" class="form-control" placeholder="Tên công ty">
                                       <small id="emailHelp" class="form-text text-muted"><i>Ghi tên công ty đầy đủ và rõ
                                             ràng theo Giấy phép đăng ký kinh doanh.</i></small>
                                    </div>
                                 </div>
                                
                                 <div class="form-group row">
                                    <label for="staticEmail" class="col-12 text-left lable">Địa chỉ công ty<span>*</span>
                                    </label>
                                    <div class="col-12">
                                       <input type="text" id="location-input"  name="address"  class="form-control" placeholder="Địa chỉ công ty">
                                    </div>
                                 </div>
                                
                                 <div class="form-group row">
                                    <label for="staticEmail" class="col-12 text-left lable">Tên người phụ trách<span>*</span> </label>
                                    <div class="col-12">
                                       <input type="text"  name="employer_name"  class="form-control" placeholder="Tên người phụ trách">
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label class="col-12 text-left lable">Số điện thoại liên hệ<span>*</span> </label>
                                    <div class="col-12">
                                       <input type="text"  name='phone'  class="form-control" placeholder="Số điện thoại liên hệ">
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label class="col-12 text-left lable">Tài khoản Email<span>*</span> </label>
                                    <div class="col-12">
                                       <input type="text"  name='email'  class="form-control" placeholder="Email là tài khoản đăng nhập">
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label class="col-12 text-left lable">Mật khẩu <span>*</span> </label>
                                    <div class="col-12">
                                       <input type="text"  name='password'  class="form-control" placeholder="Mật khẩu">
                                    </div>
                                 </div>
                                    <div class="form-group row">
                                       <label class="col-12 text-left lable">Chế độ đãi ngộ<span></span> <span class="XamMo">(Tối đa 6 đãi ngộ)</span></label>
                              
                                       <div class="col-12 dai-ngo">
                                          <input type="text"  name='remuneration[]' class="form-control mgb10" placeholder="Nhập chế độ đãi ngộ  (Tối đa 50 ký tự)">
                                          <a class='them-dai-ngo'><i class="fas fa-plus"></i> Thêm đãi ngộ</a>
                                       </div>
                                    </div>
                                       <label class="col-12 text-left lable">
                                    <div class="form-group row">
                                       Vì sao nên ứng tuyển công ty tôi<span></span>
                                       <span class="XamMo mgb10">(Tối đa 3 lý do)</span>
                                    </label>
                                    <div class="col-12 pd0 li-do-chon">
                                       <textarea name="reason_choose[]" id="txtNote" rows="3" class="textarea font17 w100 pdt5" placeholder="  Nhập lý do  (Tối đa 100 ký tự)" style="width: 100%;"></textarea>
                                          <a class='them-li-do'><i class="fas fa-plus"></i> Thêm lý do</a>
                                       </div>
                                    </div>
                                    <div class="col-12 pd0 li-do-chon">
                                    <input type="text" id='lat' name='latitude' value="" class="form-control mgb10" style="display:none" placeholder="">
                                     
                                    </div>
                                    <div class="col-12 pd0 li-do-chon">
                                    <input type="text" id='lng' name='longitude' value=""  class="form-control mgb10" style="display:none" placeholder="">
                                       
                                    </div>
                                     <div class="form-group row">
                                        <div class="col-12 text-ct">
                                           <button type="submit" class="btn">ĐĂNG KÝ</button>
                                        </div>
                                     </div>
                              </div>
                        </div> 
                     </div>
                  </form>
                  <script>
                     $(".loai-hinh").select2({
                        placeholder: "Select a state",
                        allowClear: true,
                        tokenSeparators: [',', ' ']
                     })
                  </script>
                 
                  <div class="form-group error">
                     @if ($errors->has('email'))
                           <label for="exampleInputEmail1">{{ $errors->first('email') }}</label>
                     @endif
                     @if ($errors->has('password'))
                           <label for="exampleInputEmail1">{{ $errors->first('password') }}</label>
                     @endif
                     @if ($errors->has('name'))
                           <label for="exampleInputEmail1">{{ $errors->first('name') }}</label>
                     @endif
                     @if ($errors->has('address'))
                           <label for="exampleInputEmail1">{{ $errors->first('address') }}</label>
                     @endif
                     @if ($errors->has('employer_name'))
                           <label for="exampleInputEmail1">{{ $errors->first('employer_name') }}</label>
                     @endif
                     @if ($errors->has('phone'))
                           <label for="exampleInputEmail1">{{ $errors->first('phone') }}</label>
                     @endif
                  </div>
                  <style>
                  .error label{
                     background:#ef5050;
                     color:#fff;
                     padding:5px;
                     margin-right:5px;


                  }
                  </style>
               </div>
            </div>
         </div>
     </div>
 </div>

 <script>
     $('#exampleModal').on('show.bs.modal', event => {
         var button = $(event.relatedTarget);
         var modal = $(this);
         // Use above variables to manipulate the DOM
         
     });
 </script>

 <script type="text/javascript">
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        centerMode: false,
        focusOnSelect: true
    });
    $(document).ready(function() {
        $('.hotlineCV').click(function() {
            $('.hotlinePhone').show();
            $('.hotlineCV').css('display', 'none');
        })
    });
 </script>
<script>
  
   var listCV = [
      @foreach(\App\Entity\Employee::getNewCV(11) as $id => $newCV)
        <?php $phone = $newCV->phone;
          if(strlen($phone) > 5 ){
            $str1 = substr($newCV->phone,0,5);
            $str = substr($newCV->phone,5,10);
            $replace = str_replace($str,'*******',$newCV->phone);
          }
         ?>

         {
            "HoTen": "{{$newCV->employee_name}}",
            "Avatar": "{{$newCV->employee_image }}",
            "NgaySinh": "{{$newCV->birthday}}",
            "DiaChi": "{{$newCV->address_stay}}",
            "ViTri": " {{$newCV->majors}}",
            "DienThoai": "{{$replace}}"
        },
      
      @endforeach

];

var startPos = 0;

function formatObjCV(objCV) {
    try {
         var htmlSlice = '<div class="infomation CVCandidate bgrWhite pd10"><div class="row"><div class="col-sm-3 marginAuto pdr0Im khungAnh"><img class="lazy" src="' + objCV.Avatar + '" alt="" width="100%" class="bdr50 "></div><div class="col-sm-9 lineHeight25"><p class="font20 fontBold">' + objCV.HoTen + '</p><p class="font16"><i class="fas fa-briefcase"></i> Vị trí ứng tuyển: ' + objCV.ViTri + '</p><p class="font16"><i class="fas fa-phone-alt"></i> Số điện thoại: ' + objCV.DienThoai + '</p><p class="font16"> Đánh giá : <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></p><button  data-toggle="modal" data-target="#modelId" class="inviteBtn white bgrTim fontBold">Mời ứng viên</button></div></div></div>';
        return htmlSlice;
    } catch (e) {
        console.log(e);
    }
    return '';
}

function initSlide() {
    var htmlSlice = '';
    if (listCV != null && listCV.length > 10) {
        $("#cvnew .panel-heading").append('<h2>CV ứng viên mới</h2>');
        startPos = Math.floor(Math.random() * (listCV.length - 0 + 1)) + 0;
        var count = 0;
        var total = listCV.length;
        if (total > 10) total = 10;
        while (count < total) {
            count++;
            startPos++;
            if (listCV.length <= startPos) {
                startPos = 0;
            }
            var objCV = listCV[startPos];
            if (objCV != null && objCV != undefined) {
                htmlSlice += formatObjCV(objCV);
            }
        }
        $("#listCV").html(htmlSlice);
            setInterval(function() {
                startPos++;
                try {
                    if (listCV.length <= startPos) {
                        startPos = 0;
                    }
                    var objCV = listCV[startPos];
                    if (objCV != null && objCV != undefined) {
                        var newCV = formatObjCV(objCV);
                        if (newCV.length > 0) {
                            $("#listCV .infomation").last().remove();
                            $(newCV).prependTo("#listCV").hide().fadeIn('slow');
                        }
                    }
                } catch (e) {
                    console.log(e);
                }
            }, 5000);
    } else {
        $("#cvnew").hide();
    }

}
$(document).ready(function() {
    initSlide();
}); 
</script>
  <script>  
  $(".them-dai-ngo").click(function(){
     $(this).before('<input type="text"  name="remuneration[]" class="form-control mgb10" placeholder="Nhập chế độ đãi ngộ  (Tối đa 50 ký tự)">')
  })

  $(".them-li-do").click(function(){
     $(this).before('<textarea name="reason_choose[]" id="txtNote" rows="3" class="textarea font17 w100 pdt5" placeholder="  Nhập lý do  (Tối đa 100 ký tự)" style="width: 100%;"></textarea>')
   })
 </script>
     <script>  
        $('#location-input').mouseout(function(e){
         geocode(e)
       })
      //  var locationForm = document.getElementById('location-form');
      //    locationForm.addEventListener('submit', geocode);
         function geocode(e){
            e.preventDefault();

            var location = document.getElementById('location-input').value;

            axios.get('https://maps.googleapis.com/maps/api/geocode/json',{
            params:{
               address: location,
               key:'AIzaSyDfMhsscTwP4UQh0H03FhsD_FisKDO1iBo'
            }
            })
            .then(function(response){
             console.log(response);        
            // Geometry
            var lat = response.data.results[0].geometry.location.lat;
            var lng = response.data.results[0].geometry.location.lng;
            // Output to app
               document.getElementById('lat').value = lat;
               document.getElementById('lng').value = lng;
            })
            .catch(function(error){
            console.log(error);
            });
         }
      </script>
	  <script>
      $(document).ready(function(){
          $('.EmployeesTiva').slick({
           slidesToShow: 3,
           slidesToScroll: 1,
           autoplay: true,
           autoplaySpeed: 5000,
         });
      });
     </script>
	  
	  
		
	   </script>

@endsection