@extends('site.layout.site')

@section('title','Information')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')

<section class="content">
   <div class="container">
        <div class="row ">
            <div class="col-xl-12 col-lg-12 col-md-12 File ">
               <div class="main">
                  <p class="text-title ">THÔNG TIN Ứng Viên </p>
                  <div class="notificationBox bkwhite formJobLarge ">
                     <div class="bodyBox ">
                        <div class="accountInfo ">
                           <div>
                              <p><span>Họ và tên</span> : {{$order->employee_name}}</p>
                           </div>
                           @if($order->status >=3)
                            <div>
                                <p><span>Email</span> : {{$order->email}}</p>
                            </div>
                            <div>
                                <p><span>Số điện thoại</span> : {{$order->phone}}</p>
                            </div>
                           @endif
                           <div>
                              <p><span>Ngày sinh</span> :  {{$order->birthday}}</p>
                           </div>
                           @if($order->gender == 0)
                           <div>
                              <p><span>Giới tính</span> : Đang cập nhật</p>
                           </div>
                           @elseif($order->gender == 1)
                           <div>
                              <p><span>Giới tính</span> : Nam</p>
                           </div>
                           @elseif($order->gender == 2)
                           <div>
                              <p><span>Giới tính</span> :Nữ</p>
                           </div>
                           @endif 

                           <div>
                              <p><span>Địa chỉ</span> : {{$order->address}}</p>
                           </div>
                           <div>
                              <p><span>Công việc ứng tuyển </span> : {{$order->title}}</p>
                           </div>
                        </div>
    
                     </div>
                  </div>   
               </div>

            <form role="form" action="{{route('update_candidate_apply',['order_id'=> $order->order_id])}}" method="POST">
                {!! csrf_field() !!}
               <div class="main">
                  <p class="text-title ">THÔNG TIN CÔng VIệc</p>
                  <div class="notificationBox bkwhite formJobLarge ">
                     <div class="bodyBox ">
                        <div class="accountInfo ">
                        <div class="box-body">
                           <div class="form-group">
                              <label for="exampleInputEmail1">Công việc</label>
                              <select class="form-control select2" name="job_id" id="job">
                                 <option value="0" disabled='disabled' > -- Chọn công việc -- </option>
                                 @foreach(\App\Entity\Job::get() as $job)
                                       <option value="{{$job->job_id}}"
                                       {{$order->job_id != $job->job_id ? 'disabled' : ''}}>{{$job->title}}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Ngày Nộp hồ sơ</label>
                              <input type="date" disabled='disabled' class="form-control" name="date_order" value="{{$order->date_order}}" />
                           </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Trạng thái</label>
                              <select class="form-control select2" name="status">
                                 <option value="0" {{$order->order_status == 0 ? 'selected' : ''}}>Chưa xác định</option>
                                 <option value="1" {{$order->order_status == 1 ? 'selected' : ''}}>Gửi CV</option>
                                 <option value="2" {{$order->order_status == 2 ? 'selected' : ''}}>Thất bại</option>
                                 <option value="3" {{$order->order_status == 3 ? 'selected' : ''}}>Đã phỏng vấn</option>
                                 <option value="4" {{$order->order_status == 4 ? 'selected' : ''}}>Thành công</option>
                                 <option value="5" {{$order->order_status == 5 ? 'selected' : ''}}>Đã đi làm</option>
                              </select>
                           </div>
                           <div class="form-group">
                                <!-- Đoạn này làm bằng ajax để lưu thông tin ghi chú -->
                                <div class="box-body">
                                       @foreach(\App\Entity\NoteOrders::where('order_id', $order->order_id)->get() as $note)
                                          <div class="form-group">
                                                <p>- {{$note->note}} .</p>
                                          </div>
                                       @endforeach
                                       <div class="form-group" id="noteContent">
                                       </div>
                                       <div class="form-group" >
                                          <label>Ghi chú</label>
                                          <textarea rows="4" class="form-control" name="note"
                                                      id="note-order" placeholder="Ghi chú"></textarea>

                                       </div>
                                       <div class="form-group">
                                          <button type="button" class="btn btn-success" id="note">Ghi</button>
                                       </div>
                                    </div>
                                 </div>
                              <div class="form-group">
                                    <button type="submit" id='submit' class="btn btn-sucsess">Cập nhật thông tin </button>
                              </div>
                        </div>

                        </div>
                     </div>
                  </div>
               </div>

              
            </form>
               <!-- <div class="main">
                  <p class="text-title ">Đánh giá</p>
                  <div class="notificationBox bkwhite formJobLarge ">
                     <div class="bodyBox ">
                     <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Nhà tuyển dụng đánh giá</th>
                                    <th>Ngày đánh giá</th>
                                    <th>Trạng thái của ứng viên</th>
                                    <th>Phê duyệt</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                        </div>
                                    </td>
                                    <td><div class="form-group">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right" id="datepicker1">
                                            </div>
                                        </div></td>
                                    <td><div class="form-group">
                                            <select class="form-control">
                                                <option>Đã nộp CV</option>
                                                <option>Đã phỏng vấn</option>
                                                <option>Đã đi làm</option>
                                                <option>Đã nghỉ</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td style="text-align: center;"><div class="form-group">
                                            <label>
                                                <input type="checkbox" name="parents[]" value="" class="flat-red" >
                                            </label>
                                        </div></td>
                                </tr>
                                </tbody>
                            </table>
                     </div>
                  </div>
               </div> -->
            </div>

         </div>
   
        
      </div>
      <script>
        $(document).ready(function () {
            $('#note').click(function () {
                $.ajax({
                   url: '{{route('add-note-order')}}',
                   method: 'GET',
                   data: {
                       id : {{$order['order_id']}} ,
                       content : $('#note-order').val()
                   },
                   success: function (data) {
                        $('#noteContent').html(data);
                        $('#note-order').val('')
                   }
                });
            });

            $('#note-order').keypress(function (event) {
                if((event.keyCode ? event.keyCode : event.which) == 13){
                    $.ajax({
                        url: '{{route('add-note-order')}}',
                        method: 'GET',
                        data: {
                            content : $(this).val()
                        },
                        success: function (data) {
                            $('#noteContent').html(data);
                            $('#note-order').val('')
                        }
                    });
                }
            })
        })
    </script>
 
</section>

@endsection
