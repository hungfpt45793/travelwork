
@extends('site.layout.site')

@section('title','Information')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')


<section class="content">
   <div class="container">
        <div class="row ">

            @include('site.sidebar.sidebar_member')

	         <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9 JobSeeker">
	            <div class="main">
	               <div class="notificationBox">
	                  <p class="text-title">
	                    Công việc đã ứng tuyển 
	                  </p>
	                  <hr>
	                  <div class="bodyBox">
	                     <table class="table table-bordered table table-striped">
	                        <thead class="workHeadTable bkg whiteText">
	                           <tr>
	                              <th class="text-center verticalMidder" style="width:25%">Công ty</th>
	                              <th class="text-center verticalMidder">Ứng tuyển cho vị trí</th>
	                              <th class="text-center verticalMidder">Mức lương</th>
	                              <th class="text-center verticalMidder" colspan="2" style="text-align:center">Tác vụ</th>
	                           </tr>

	                           	<tbody class="workBodyTable">                  
		                           @foreach( App\Entity\Order::showJobEmployeeInvited($employee->employee_id) as $id => $informationJob)
		                         
		                              <tr>		                              
		                              		 <td class="verticalMidder">{{$informationJob->enterprise_name}}</td>
		                                    <td class="verticalMidder">{{$informationJob->title}}</td>

		                                    <td class="text-center verticalMidder">{{$informationJob->description}}</td>

		                                    <td class="text-center verticalMidder">
		                                       <a href="#"  data-toggle="modal" data-target="#showJob{{$id}}">Xem chi tiết</a></td>
		                                    <td class="verticalMidder text-center">	
		                                        <a onclick="return deleteJob(this)" title="xóa" href="{{ route('delete_job_invited', ['id' => $informationJob->order_id ]) }}">
		                                        	<i style="font-size: 18px; color: #333" class="far fa-trash-alt"></i>
		                                        </a>        
		                                    </td>
		                              </tr>
		                           @endforeach
		                        </tbody>
		                    </thead>
	                     </table>
	                  </div>
	               </div>
	            </div>
	         </div>
      </div>
   </div>
</div>
</section>
<script type="text/javascript">
	function deleteJob(e){
		if (confirm("Bạn có muốn xóa Công việc này khỏi danh sách !")) {
			return true;
		}	

		return false;
	}
</script>


@foreach( App\Entity\order::showJobEmployeeInvited($employee->employee_id) as $id => $informationJob)

<div class="modal fade" id="showJob{{$id}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
               <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                     </button>
               </div>
            <div class="modal-body">
               <div class="item">
                  <a href="/cong-viec/{{$informationJob->slug}}">
                     <div class="row">       
                     <div class="col-md-4">
                        <img src="{{isset($informationJob->image) ? $informationJob->image :'/CV/Profile.png'}}" alt="" width="100%">
                     </div>
                     <div class="col-md-8"><p class="fontBold mgb0 colorFont">{{$informationJob->title}}</p>
                        <i class="greyColor">{{$informationJob->enterprise_name}}</i></div>
                        <div class="col-md-12">
                           <div class="invite">
                           Bạn đã ứng tuyển vào {{$informationJob->enterprise_name}} với vị trí {{$informationJob->title}}
                           <br>
                           Ngày:  {{date_format($informationJob->created_at ,'d/m/Y')}}
                           </div>
                        </div>
                     </div>
                  </a>
                  <div class="status">

                  	@if(@informationJob['status'] == 0)
						Trạng thái : Chưa xác định
					@elseif(@informationJob['status'] == 1)	
						Trạng thái : Đã gửi CV
					@elseif(@informationJob['status'] == 2)		
						Trạng thái : Thất bại
					@elseif(@informationJob['status'] == 3)
						Trạng thái : Đã phỏng vấn
					@elseif(@informationJob['status'] == 3)
						Trạng thái : Thành công
					@else
						Đang cập nhật
					@endif
            
                  </div>
               </div>
            </div>
          
        </div>
    </div>
</div>
@endforeach

@if (Session::has('sucsses'))
   <script>
       alert ('{!! Session::get('sucsses') !!}')
   </script>
@endif
@if (Session::has('finishDelete'))
   <script>
       alert ('{!! Session::get('finishDelete') !!}')
   </script>
@endif
@if (Session::has('Error'))
   <script>
       alert ('{!! Session::get('Error') !!}')
   </script>
@endif


<script>
    $('#exampleModal').on('show.bs.modal', event => {
        var button = $(event.relatedTarget);
        var modal = $(this);
        // Use above variables to manipulate the DOM
        
    });
</script>

@endsection

 