@extends('site.layout.site')
@section('title','Ứng viên đã ứng tuyển')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')

<section class="content">
   <div class="container">
   <div class="row ">
       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 createProfileOnline ">
            <div class="main">
               <div class="notificationBox bkwhite formJobLarge mb30">
                  <p class="text-title mt0">
                     Quản lý hồ sơ tuyển dụng
                  </p>
                  <!-- <p>Bạn đang có <span class="redColor fontBold">0</span> vị trí tuyển dụng và 
                  <span class="redColor fontBold">0</span> hồ sơ đã ứng tuyển</p> -->
                  
                  <div class="headBox ">
                     <div class="form-group ">
                        <form action="{{route('search_candidate')}}" method="POST">
                        <div class="form-group row">
                           <label for="staticEmail" class="col-2 lable pt10 fontBold colorFont text-right">Tìm kiếm
                           </label>
                           <div class="col-sm-7">
                              <input type="text" class="form-control" name="word" placeholder="Nhập từ khóa tìm kiếm">
                            
                           </div>
                           <div class="col-sm-3">
                           <button type="submit" class="btn btn-primary"> Tìm kiếm </button>
                           </div>
                           
                        </div>
                     </form>
                     </div>
                  </div>
                  <hr>
                  <div class="bodyBox">
                     <table class="table table-bordered table-striped mgb0">
                        <thead class="workHeadTable bkg whiteText">
                           <tr>
                              <th class="text-center verMiddle" style="width:20%">Thông tin Ứng viên</th>
                              <th class="text-center verMiddle" style="">Vị trí tuyển dụng</th>
                              <th class="text-center verMiddle" style="">Thời gian</th>
                              <th class="text-center verMiddle" style="">Trạng thái</th>
                              <th class="text-center verMiddle" style="">Quá trình</th>
                              <th class="text-center verMiddle">Cập nhật</th>
                           </tr>
                        </thead>
                        <tbody class="workBodyTable ">
                       
                        @foreach($orders as $id => $order)                         
                           <tr>
                              <td class="verMiddle text-ct" scope="row"><b>{{$order->employee_name}}</b> <br> 
                              @if($order->order_status >=3)
                                 {{$order->phone}}
                               @endif                              
                              @if(!empty($order->cost_point))
                                 <div class='text-center'>
                                 @if($order->cost_point == 1)           
                                       <i class="fas fa-star"></i> 
                                 @elseif($order->cost_point == 2)           
                                       <i class="fas fa-star"></i>  <i class="fas fa-star"></i> 
                                 @elseif($order->cost_point == 3)           
                                       <i class="fas fa-star"></i>  <i class="fas fa-star"></i>  <i class="fas fa-star"></i> 
                                 @elseif($order->cost_point == 4)           
                                       <i class="fas fa-star"></i>  <i class="fas fa-star"></i>  <i class="fas fa-star"></i>  <i class="fas fa-star"></i> 
                                 @elseif($order->cost_point == 5)           
                                       <i class="fas fa-star"></i>  <i class="fas fa-star"></i>  <i class="fas fa-star"></i>  <i class="fas fa-star"></i>  <i class="fas fa-star"></i> 
                                 @endif
                                 </div>
                              @endif      
                             
                            </td>
                              <td class="verMiddle text-ct">{{$order->title}}</td>
                              <td class="verMiddle text-ct"><span class="sp1">Ngày nộp: </span><span class="sp2">{{$order->date_order}}</span> <br>
                              <!-- <span class="sp3">Ngày hẹn PV: </span>
                              <span class="sp4">20-05-2019</span> -->
                            </td>
                              <td class="verMiddle text-ct">
                                 @if($order->order_status == 0)
                                 Chưa xác định
                                 @elseif($order->order_status == 1)
                                 Gửi CV
                                 @elseif($order->order_status == 2)
                                 Thất bại
                                 @elseif($order->order_status == 3)
                                 Đã phỏng vấn
                                 @elseif($order->order_status == 4)
                                 Thành công
                                 @else
                                 Đã đi làm
                                 @endif
                              </td>
                              <td class="verMiddle text-ct">                           
                                 <a href="" data-toggle="modal" data-target="#exampleModalCenter{{$id}}">Xem quá trình</a>
                                    <!-- Modal -->
                              </td>
                              <td class="text-center verMiddle">
                                 <a href="/xoa-ung-vien/{{$order->order_id}}" class="btn btn-danger" title="Xóa">
                                 <i class="far fa-trash-alt"></i>
                                 </a>
                                 <a href="/sua-ung-vien/{{$order->order_id}}" class="btn btn-primary" title="Sửa">
                                 <i class="fas fa-pencil-alt"></i>
                                 </a>

                              @if(($order->order_status >= 2) && ($order->cost_point == null))
                                 <a class="btn bgrXanhduong" title="Đánh giá" data-toggle="modal" data-target="#EvaluateCandidates">
                                 <i class="fas fa-star colorVang"></i>
                                 </a>
                                 <div class="modal fade" id="EvaluateCandidates" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                       <form action="/danhgia/{{$order->order_id}}" method="post">
                                          {!! csrf_field() !!}
                                          <div class="modal-content">
                                             <div class="modal-header">
                                                <h5 class="modal-title colorTim textUpper" id="exampleModalLabel">Nhà tuyển dụng đánh giá</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                             </div>
                                             <div class="modal-body"                                                                                        
                                                      <h4 class="text-ct font18">Chất lượng cuộc phỏng vấn</h4>
                                                      <div class="form-group row">
                                                         <span class="star-rating star-5">
                                                            <input type="radio" name="status" value="1"><i></i>
                                                            <input type="radio" name="status" value="2"><i></i>
                                                            <input type="radio" name="status" value="3"><i></i>
                                                            <input type="radio" name="status" value="4"><i></i>
                                                            <input type="radio" name="status" value="5"><i></i>
                                                         </span>
                                                      </div>
                                                      <div class="form-group row">
                                                         <label for="staticEmail" class="col-sm-12 col-12 col-form-label text-left"><span class="text-b700">Ghi chú</span><span class="clred pd-05">(*)</span></label>
                                                         <div class="col-sm-12 col-12">
                                                            <textarea name='note' class="form-control f14" rows="5" placeholder="Nội dung ghi chú" required=""></textarea>
                                                         </div>
                                                      </div>                                                                                             
                                             </div>
                                             <div class="modal-footer">
                                                <button type="submit" class="btn bgrTim colorWhite">Đánh giá</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                             </div>
                                       </form>
                                       </div>
                                    </div>
                              @endif 
                              
                              
                              </td>
                           </tr> 
                        @endforeach               
                        </tbody>
                     </table>
                     </div>
                     </div>
                  </div>
               </div>
   </div>
   </div>

  @foreach($orders as $id => $order)                 
   <div class="modal fade" id="exampleModalCenter{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLongTitle">Quá trình hoạt động của ứng viên</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">×</span>
           </button>
         </div>
         <div class="modal-body text-left">
           <p>Họ và tên: <b>{{$order->employee_name}}</b></p>
           @if($order->status >=3)
           <p>Số điện thoại: <b>{{$order->phone}}</b></p>
           @endif   
           @if($order->gender == 0)
           <p>Giới tính: <b>Đang cập nhật </b></p>
           @elseif($order->gender == 1)
           <p>Giới tính: <b>Nam </b></p>
           @elseif($order->gender == 2)
           <p>Giới tính: <b>Nữ</b></p>
           @endif 
           <p>Địa chỉ: <b>{{$order->address}}</b></p>
           
           <p>Bằng cấp - Chứng chỉ: <b>{{$order->school}}</b></p>

           <p>Trình độ: <b>{{$order->literacy_name}}</b></p>

           <p>Chuyên ngành: <b>{{$order->majors}}</b></p>

           <p>Kỹ năng mềm : <b>{{$order->soft_skills}}</b></p>

           <p><b>Lịch sử làm việc</b></p>

               <table class="table">
                     <thead>
                        <tr>
                        <th scope="row" class="text-center">Tên công ty</th>
                        <th scope="row" class="text-center w333">Vị trí làm việc</th>
                        <th scope="row" class="text-center">Chi tiết quá trình</th>
                        </tr>
                     </thead>
                  <tbody>
 
                    @foreach( \App\Entity\HistoryWork::getAllWihtId($order->employee_id) as $history) 
                        <tr>
                           <td scope="row" class="text-center">{{$history->company}}</td>
                           <td scope="row"  class="text-center">{{$history->position}}</td>
                           <td scope="row"  class="">{!!$history->content!!}</td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
         </div>/
       </div>
     </div>
   </div>
   @endforeach
</section>

<style>
      .star-rating {
      font-size: 0;
      white-space: nowrap;
      display: inline-block;
      /* width: 250px; remove this */
      height: 50px;
      overflow: hidden;
      position: relative;
      background: url('data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIwIDIwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cG9seWdvbiBmaWxsPSIjREREREREIiBwb2ludHM9IjEwLDAgMTMuMDksNi41ODMgMjAsNy42MzkgMTUsMTIuNzY0IDE2LjE4LDIwIDEwLDE2LjU4MyAzLjgyLDIwIDUsMTIuNzY0IDAsNy42MzkgNi45MSw2LjU4MyAiLz48L3N2Zz4=');
      background-size: contain;
      }
      .star-rating i {
      opacity: 0;
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      /* width: 20%; remove this */
      z-index: 1;
      background: url('data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIwIDIwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cG9seWdvbiBmaWxsPSIjRkZERjg4IiBwb2ludHM9IjEwLDAgMTMuMDksNi41ODMgMjAsNy42MzkgMTUsMTIuNzY0IDE2LjE4LDIwIDEwLDE2LjU4MyAzLjgyLDIwIDUsMTIuNzY0IDAsNy42MzkgNi45MSw2LjU4MyAiLz48L3N2Zz4=');
      background-size: contain;
      }
      .star-rating input {
      -moz-appearance: none;
      -webkit-appearance: none;
      opacity: 0;
      display: inline-block;
      /* width: 20%; remove this */
      height: 100%;
      margin: 0;
      padding: 0;
      z-index: 2;
      position: relative;
      }
      .star-rating input:hover + i,
      .star-rating input:checked + i {
      opacity: 1;
      }
      .star-rating i ~ i {
      width: 40%;
      }
      .star-rating i ~ i ~ i {
      width: 60%;
      }
      .star-rating i ~ i ~ i ~ i {
      width: 80%;
      }
      .star-rating i ~ i ~ i ~ i ~ i {
      width: 100%;
      }
      ::after,
      ::before {
      height: 100%;
      padding: 0;
      margin: 0;
      box-sizing: border-box;
      text-align: center;
      vertical-align: middle;
      }

      .star-rating.star-5 {width: 250px;margin:auto}
      .star-rating.star-5 input,
      .star-rating.star-5 i {width: 20%;}
      .star-rating.star-5 i ~ i {width: 40%;}
      .star-rating.star-5 i ~ i ~ i {width: 60%;}
      .star-rating.star-5 i ~ i ~ i ~ i {width: 80%;}
      .star-rating.star-5 i ~ i ~ i ~ i ~i {width: 100%;}

      .star-rating.star-3 {width: 150px;}
      .star-rating.star-3 input,
      .star-rating.star-3 i {width: 33.33%;}
      .star-rating.star-3 i ~ i {width: 66.66%;}
      .star-rating.star-3 i ~ i ~ i {width: 100%;}
</style>
@if (Session::has('sucsses1'))
   <script>
       alert ('{!! Session::get('sucsses1') !!}')
   </script>
@elseif (Session::has('sucsses2'))
   <script>
       alert ('{!! Session::get('sucsses2') !!}')
   </script>
@endif


@endsection

