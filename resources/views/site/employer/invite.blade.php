@extends('site.layout.site')

@section('title','Mời ứng viên ứng tuyển')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')
<section class="content">
        <div class="container">
            <div class="row ">
               @include('site.sidebar.sidebar_employer')
                <div class="col-xl-9 col-lg-9 col-md-12 createProfileOnline ">
                    <div class="main">
                        <p class="text-title mt0">
                            Ứng viên
                        </p>
                        <div class="notificationBox bkwhite formJobLarge mb30">
                            <div class="bodyBox">
                                <div class="contentPage JobNew">
                                    <div class="job">
                                        <div class="formJobLarge">
                                            <?php $candidateCount = 0 ?>
                                            @foreach($candidates as $id => $candidate)
                                                <div class="formJob">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="logo disInBlock">
                                                                <img class="lazy" src="{{isset($candidate['employee_image']) ? $candidate['employee_image'] :'/CV/Profile.jpg'}}" width="100%">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-10"  style="position: relative;">
                                                            <div class="information disInBlock">
                                                                <a style="position: absolute; right:0 ;top: 0;" href="" data-toggle="modal" data-target="#exampleModalCenter{{$id}}">Xem quá trình <i class="fas fa-search-plus"></i>
                                                                </a>
                                                                <a href="#" class="fontBold textCap colorFont">
                                                                    {{isset($candidate->employee_name) ? $candidate->employee_name :''}}
                                                                </a>
                                                                <p class="fontBold">Địa chỉ hiện tại : <span class="fontNormal">
                                                                    {{isset($candidate->address) ? $candidate->address :''}}
                                                                    </span>
                                                                </p>
                                                                <p class="address"><i class="fas fa-briefcase"></i> 
                                                                    {{isset($candidate->majors) ? $candidate->majors :''}}
                                                                </p> 
                                                                <p class="salary"> <i class="fas fa-clipboard-check"></i>
                                                                    Kinh nghiệm : 
                                                                    {{isset($candidate->experience) ? $candidate->experience :''}}
                                                                </p> 
                                                                <p class="time"> <i class="fas fa-bookmark"></i>
                                                                    Trình độ :{{isset($candidate->literacy_name) ? $candidate->literacy_name :''}}
                                                                </p>
                                                                <br>

                                                                <form action="{{route('invite_candidates')}}" method="post">
                                                                    <input type="hidden" name="employer_id" value="{{$user->id}}">
                                                                    <input type="hidden" name="employee_id" value="{{$candidate->employee_id}}">         
                                                                    <!-- Button trigger modal -->
                                                                <button type="button" class="btn bkg whiteText JoinInvite mt10 pd10-20" data-toggle="modal" data-target="#modelId{{$candidateCount}}">
                                                                    Mời ứng viên
                                                                </button>



                                                                <!-- Modal -->
                                                                <div class="modal fade" id="modelId{{$candidateCount}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header bgrTim">
                                                                                <h5 class="modal-title textUpper fontBold font18 Tim white">Danh sách công việc</h5>
                                                                                <button type="button" class="close white" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                @foreach(\App\Entity\Job::showJobWithEmployerId($employer->employer_id) as $job)
                                                                                    <form action="" method="" onSubmit="return submitInvite(this);">
                                                                                        <div class="JobOfCompany">
                                                                                            <div class="row">
                                                                                                <div class="col-lg-9 dsBlock marginAuto">
                                                                                                    <p class="dsInBlock font18">{{$job->title}}</p>
                                                                                                    <input type="hidden" class="job_id" name="job_id" value="{{$job->job_id}}">
                                                                                                    <input type="hidden" class="employer_id" name="employer_id" value="{{$employer->employer_id}}">
                                                                                                    <input type="hidden" class="employee_id" name="employee_id" value="{{$candidate->employee_id}}">
                                                                                                </div>
                                                                                                <div class="col-lg-3 text-right">
                                                                                                    <button class="dsInBlock pd10 white bgrTim noBorder invite"  type="submit">Mời ứng viên</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <hr>
                                                                                    </form>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $candidateCount++ ?>
                                            @endforeach 
                                            <i class="greyColor">(Hãy nâng cấp tài khoản của bạn lên tài khoản vip để xem thêm ứng viên.)</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>

@foreach($candidates as $id => $candidate)               
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
           <p>Họ và tên: <b>{{$candidate->employee_name}}</b></p>
           @if($candidate->status >=3)
           <p>Số điện thoại: <b>{{$candidate->phone}}</b></p>
           @endif   
           @if($candidate->gender == 0)
           <p>Giới tính: <b>Đang cập nhật </b></p>
           @elseif($candidate->gender == 1)
           <p>Giới tính: <b>Nam </b></p>
           @elseif($candidate->gender == 2)
           <p>Giới tính: <b>Nữ</b></p>
           @endif 
           <p>Địa chỉ: <b>{{$candidate->address}}</b></p>
           
           <p>Bằng cấp - Chứng chỉ: <b>{{$candidate->school}}</b></p>

           <p>Trình độ: <b>{{$candidate->literacy_name}}</b></p>

           <p>Chuyên ngành: <b>{{$candidate->majors}}</b></p>

           <p>Kỹ năng mềm : <b>{{$candidate->soft_skills}}</b></p>

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
 
                    @foreach( \App\Entity\HistoryWork::getAllWihtId($candidate->employee_id) as $history) 
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

<script>
    $('#exampleModal').on('show.bs.modal', event => {
        var button = $(event.relatedTarget);
        var modal = $(this);
        // Use above variables to manipulate the DOM
        
    });
    function submitInvite(e) {
        $(e).find('.invite').attr('disabled', true);
        $(e).find('.invite').text('Đang mời ứng viên...');
        $(e).find('.invite').css({
            'color' : '#000000',
            'background' : '#777777'
        });
        $.ajax({
            url : '{{route('invite_candidates')}}',
            type : 'GET',
            data : {
                employer_id : $(e).find('.employer_id').val(),
                employee_id : $(e).find('.employee_id').val(),
                job_id : $(e).find('.job_id').val()
            },
            success : function (){
                $(e).find('.invite').text('Đã mời ứng viên');
                return false;
            },
            error: function () {
                $(e).find('.invite').attr('disabled', false);
                $(e).find('.invite').text('Mời ứng viên thất bại');
                return false;
            }
        });
        return false;
    }
</script>
@endsection