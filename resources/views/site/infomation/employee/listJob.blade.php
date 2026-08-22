
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
                     Lời mời ứng tuyển
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
                        </thead>
                        <tbody class="workBodyTable">                  
                           @foreach( App\Entity\Invite::getInviteWihtEmployeeId($employee->employee_id) as $id => $informationJob)
                              <tr>
                                    <td class="verticalMidder">{{$informationJob->enterprise_name}}</td>
                                    <td class="verticalMidder">{{$informationJob->title}}</td>
                                    <td class="text-center verticalMidder">{{$informationJob->description}}</td>
                                    <td class="text-center verticalMidder">
                                       <a href="#"  data-toggle="modal" data-target="#showInfo{{$id}}">Xem chi tiết</a></td>
                                    <td class="verticalMidder text-center">
                                          @if($informationJob['status'] == 1 )
                                              <a style="color: #fff" class="btn btn-success">Đã nộp hồ sơ</a>
                                          @else
                                             <a href="{{ route('accept_job', ['jobId' => $informationJob->job_id ]) }}" class="btn bkg whiteText cf btn-sm">Nộp hồ sơ</a>   
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
</div>
</section>

<!-- Modal -->
@foreach( App\Entity\Invite::getInviteWihtEmployeeId($employee->employee_id) as $id => $informationJob)
<div class="modal fade" id="showInfo{{$id}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                           {{$informationJob->enterprise_name}} mời bạn ứng tuyển vào vị trí {{$informationJob->title}}
                           </div>
                        </div>
                     </div>
                  </a>
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

<script>
    $('#exampleModal').on('show.bs.modal', event => {
        var button = $(event.relatedTarget);
        var modal = $(this);
        // Use above variables to manipulate the DOM
        
    });
</script>



@endsection
  