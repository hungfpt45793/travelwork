@extends('site.layout.site')

@section('title','Information')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')

<section class="content">
   <div class="container">
   <div class="row ">
    @include('site.common.sider_bar_information')
   <div class="col-xl-9 col-lg-9 col-md-12 createProfileOnline ">
      <div class="main">
         <p class="text-title mt0">
            Quản lý hồ sơ tuyển dụng
         </p>
         <p>Bạn đang có <span class="redColor fontBold">0</span> vị trí tuyển dụng và <span
            class="redColor fontBold">0</span> hồ sơ đã ứng tuyển</p>
         <div class="notificationBox bkwhite formJobLarge mb30">
            <div class="headBox ">
               <div class="form-group ">
                  <div class="form-group row">
                     <label for="staticEmail" class="col-sm-5 lable pt10 fontBold colorFont text-right">Hồ
                     sơ ứng tuyển vị trí
                     </label>
                     <div class="col-sm-7">
                        <select class="form-control">
                           <option>Nhân viên marketing</option>
                           <option>Lập trình viên php</option>
                           <option>Lập trình viên front-end</option>
                           <option>Lập trình viên back-end</option>
                           <option>Designer</option>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
            <hr>
            <div class="bodyBox">
               <table class="table table-bordered table-striped mgb0">
                  <thead class="workHeadTable bkg whiteText">
                     <tr>
                        <th class="text-center verMiddle" style="width:17%">Tên ứng viên</th>
                        <th class="text-center verMiddle" style="width:20%">Vị trí ứng tuyển</th>
                        <th class="text-center verMiddle" style="width:14%">Số điện thoại</th>
                        <th class="text-center verMiddle" style="width:14%">Ngày nộp</th>
                        <th class="text-center verMiddle" style="width:14%">Trạng thái</th>
                        <th class="text-center verMiddle">Cập nhật</th>
                     </tr>
                  </thead>
                  <tbody class="workBodyTable ">
                     <tr>
                        <td  class="verMiddle" scope="row">Phạm Hồng Sơn</td>
                        <td class="verMiddle">Nhân viên marketing</td>
                        <td class="verMiddle">0327344748</td>
                        <td class="verMiddle">17-05-2019</td>
                        <td class="verMiddle">Chưa phỏng vấn</td>
                        <td class="text-center verMiddle"><a href="#" class="btn btn-danger" title="Xóa"><i
                           class="far fa-trash-alt"></i></a>
                           <a href="#" class="btn btn-primary" title="Sửa"><i
                              class="fas fa-pencil-alt"></i></a>
                        </td>
                     </tr>
                     <tr>
                        <td class="verMiddle" scope="row">Phạm Hồng Sơn</td>
                        <td class="verMiddle">Nhân viên marketing</td>
                        <td class="verMiddle">0327344748</td>
                        <td class="verMiddle">17-05-2019</td>
                        <td class="verMiddle">Đã phỏng vấn</td>
                        <td class="text-center verMiddle">
                           <a href="#" class="btn btn-danger" title="Xóa"><i
                              class="far fa-trash-alt"></i></a>
                           <a href="#" class="btn btn-primary" title="Sửa"><i
                              class="fas fa-pencil-alt"></i></a>
                           <a href="#" class="btn bgrXanhduong" title="Đánh giá" data-toggle="modal" data-target="#EvaluateCandidates"><i class="fas fa-star colorVang"></i></a>
                           <div class="modal fade" id="EvaluateCandidates" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title colorTim textUpper" id="exampleModalLabel">Nhà tuyển dụng đánh giá</h5>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <h4 class="text-ct font18">Chất lượng cuộc phỏng vấn</h4>
                                       <div class="form-group row">
                                          <span class="star my-rating24 marginAuto">
                                          </span>
                                          <span class="live-rating24 an">4.0</span>
                                          <input type="hidden" value="4.0" name="appraise" class="appraiseStart24">
                                          <script>
                                             //Đồng bộ chiều cao các div
                                             
                                             $(function() {
                                                 $(".my-rating24").starRating({
                                                     initialRating: 4,
                                                     disableAfterRate: false,
                                                     onHover: function(currentIndex, currentRating, $el) {
                                                         $('.live-rating24').text(currentIndex);
                                                     },
                                                     onLeave: function(currentIndex, currentRating, $el) {
                                                         $('.live-rating24').text(currentRating);
                                                         $('.appraiseStart24').val(currentRating);
                                                     }
                                                 });
                                             });
                                          </script>
                                       </div>
                                       <div class="form-group row">
                                          <label for="staticEmail" class="col-sm-12 col-12 col-form-label text-left"><span class="text-b700">Ghi chú</span><span class="clred pd-05">(*)</span></label>
                                          <div class="col-sm-12 col-12">
                                             <textarea name="description" class="form-control f14" rows="5" placeholder="Nội dung ghi chú" required=""></textarea>
                                          </div>
                                       </div>
                                       <input type="hidden" value="24" name="classroom_id">
                                       <input type="hidden" value="8" name="teacher_id">
                                    </div>
                                    <div class="modal-footer">
                                       <button type="submit" class="btn bgrTim colorWhite">Đánh giá</button>
                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    </div>
                                 </div>
                              </div>
                        </td>
                     </tr>
                     <tr>
                     <td class="verMiddle" scope="row">Phạm Hồng Sơn</td>
                     <td class="verMiddle">Nhân viên marketing</td>
                     <td class="verMiddle">0327344748</td>
                     <td class="verMiddle">17-05-2019</td>
                     <td class="verMiddle">Đã phỏng vấn</td>
                     <td class="text-center verMiddle"><a href="#" class="btn btn-danger" title="Xóa"><i
                        class="far fa-trash-alt"></i></a>
                     <a href="#" class="btn btn-primary" title="Sửa"><i
                        class="fas fa-pencil-alt"></i></a>
                     <a href="#" class="btn bgrXanhduong" title="Đánh giá" data-toggle="modal" data-target="#EvaluateCandidates"><i class="fas fa-star colorVang"></i></a>
                     <div class="modal fade" id="EvaluateCandidates" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                     <div class="modal-content">
                     <div class="modal-header">
                     <h5 class="modal-title colorTim textUpper" id="exampleModalLabel">Nhà tuyển dụng đánh giá</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                     </div>
                     <div class="modal-body">
                     <h4 class="text-ct font18">Chất lượng cuộc phỏng vấn</h4>
                     <div class="form-group row">
                     <span class="star my-rating24 marginAuto">
                     </span>
                     <span class="live-rating24 an">4.0</span>
                     <input type="hidden" value="4.0" name="appraise" class="appraiseStart24">
                     <script>
                        //Đồng bộ chiều cao các div
                        
                        $(function() {
                            $(".my-rating24").starRating({
                                initialRating: 4,
                                disableAfterRate: false,
                                onHover: function(currentIndex, currentRating, $el) {
                                    $('.live-rating24').text(currentIndex);
                                },
                                onLeave: function(currentIndex, currentRating, $el) {
                                    $('.live-rating24').text(currentRating);
                                    $('.appraiseStart24').val(currentRating);
                                }
                            });
                        });
                     </script>
                     </div>
                     <div class="form-group row">
                     <label for="staticEmail" class="col-sm-12 col-12 col-form-label text-left"><span class="text-b700 ">Ghi chú</span><span class="clred pd-05">(*)</span></label>
                     <div class="col-sm-12 col-12">
                     <textarea name="description" class="form-control f14" rows="5" placeholder="Nội dung ghi chú" required=""></textarea>
                     </div>
                     </div>
                     <input type="hidden" value="24" name="classroom_id">
                     <input type="hidden" value="8" name="teacher_id">
                     </div>
                     <div class="modal-footer">
                     <button type="submit" class="btn bgrTim colorWhite">Đánh giá</button>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                     </div>
                     </div>
                     </div>
                     </td>
                     </tr>
                  </tbody>
               </table>
               </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

@endsection
