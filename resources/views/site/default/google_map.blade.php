@extends('site.layout.site')

@section('title','Xem trên bản đồ')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')

<div class="jobInMap">
  <div class="filter bgrTim">
     
        <form action="" method="" class="form-control">
         <div class="row">
               <div class="col-lg-3 col-md-6">
                  <input type="text" name="word" class="form-control" placeholder="Vị trí công việc...">
               </div>
               <div class="col-lg-2 col-md-6">
                  <select class="form-control" id="FormControlSelect1" name="province[]">
                  <option value="">Chọn tỉnh thành </option>
                     @foreach (\App\Entity\Province::getAllProvince() as $province)
                        <option {{ isset($_GET['province']) && in_array($province->province_id, $_GET['province']) == true ? 'selected' : '' }}
                            value="{{$province->province_id}}">{{$province->province_name}}</option>
                     @endforeach 
                  </select>
               </div>

               <div class="col-lg-2 col-md-4">
                  <select class="form-control" id="FormControlSelect2" name="careers[]">
                     <option value="">Chọn ngành nghê</option>
                     @foreach (\App\Entity\Career::getAllCareer() as $carrer)
                        <option {{ isset($_GET['careers']) && in_array($carrer->career_category_id, $_GET['careers']) == true ? 'selected' : '' }} 
                           value="{{$carrer->career_category_id}}"> {{$carrer->career_category_name}}</option>
                     @endforeach  
                  </select>
               </div>
               <div class="col-lg-3 col-md-4">
                  <select class="form-control" id="FormControlSelect2" name="salaries[]">
                  <option value="">Chọn mức lương</option>
                     @foreach (\App\Entity\Salary::showAllSalary() as $salary)
                        <option {{ isset($_GET['salaries']) && in_array($salary->salary_id, $_GET['salaries']) == true ? 'selected' : '' }}  
                           value="{{$salary->salary_id}}">{{number_format($salary->salary_from)}} VNĐ - {{number_format($salary->salary_to) }} VNĐ</option>
                     @endforeach   
                  </select>
               </div>
               <div class="col-lg-2 col-md-4">
                  <button type="submit" class="btn btn-block Tim ">
                  <i class="fas fa-search Tim"></i>
                  Tìm ngay</button>
               </div>
            </div>
        </form>
     
  </div>
  <div class="AllJobSearchs bgrWhite pd10">
     <div class="row">
        <div class="col-lg-4 col-md-12 col-sm-12 jobDetail">
         @if(!empty($jobs))
           @foreach($jobs as $id => $job)
           <div class="jobDetailSingle">
              <div class="row">
                 
                  <div class="col-md-3">
                     <img data-src="{{$job->image}}" class="w100 mh42-w30 lazy">
                  </div>
                  <div class="col-md-9">

                     <h5 id="firstHeading" class="firstHeading mgb0 font18 Tim">
                        <a href="{{ route("job_detail", ["slug" => $job->slug]) }}">
                          {{$job->title}}
                        </a>
                     </h5>

                     <p class="mgb5 fontBold Xam"><i>{{$job->enterprise_name}}</i></p>
                     <div id="bodyContent"  style="color:#666">
                        <p class="mgb5"><i class="fas fa-map-marker-alt" style="color: #159ff6;"></i> {{$job->address_work}}
                        </p>
                        <p class="info mgb5 dsInBlock"><i class="fas fa-coins" style="color: #ffc100"></i> Lương :{{$job->salary_description}} &emsp; &emsp;
                        </p>
                        <p class="info mgb5 dsInBlock"><i class="fas fa-user-friends"></i> Số lượng : {{$job->number_recruit}} 
                           &emsp; &emsp;<span class="info dsInBlock"><i class="fas fa-eye"></i>  {{$job->people_seen}}  </span>
                        </p>
                        <a href="{{ route('apply_now', ['jobId' => $job->job_id ]) }}" class="btn btn-default dsBlockIm">Ứng tuyển ngay</a>
                     </div>
                  </div>
            
              </div>
           </div>
           @endforeach
      @endif
      </div>
        <div class="col-lg-8 col-md-12 col-sm-12 " style="height:550px;">
           <div id="map">
           </div>
        </div>
      </div>
  </div>
  <script>
         function initMap() {
          try {
           var map;
           var bounds = new google.maps.LatLngBounds();
           var mapOptions = {
            mapTypeId: 'roadmap'
           };
           map = new google.maps.Map(document.getElementById("map"), mapOptions);
           var markers =
           [
         @if(!empty($jobs))
           @foreach($jobs as $id => $job)
            @if(!empty($job->latitude) && !empty($job->longitude) )
               ['{{isset($job->address_work) ? $job->address_work : "Đang Cập nhật"}}',
               {{$job->latitude}}, 
               {{$job->longitude}},
                  {
                     url: '{{isset($job->image) ? $job->image : "/CV/map.png"}}', // url
                     scaledSize: new google.maps.Size(30, 30), // scaled size  
                  }
               ],
            @endif
           @endforeach
         @endif
           ];
           var infoWindowContent = [
            @if(!empty($jobs))
               @foreach($jobs as $id => $job)
                  @if(!empty($job->latitude) && !empty($job->longitude))
                  ['<div id="content">' +
                  '<div class="row">' +
                  '<div class="col-md-2">' +
                  '<img src="{{isset($job->image) ? $job->image : "/CV/Profile.jpg"}}" style="width:100%">' +
                  '</div>' +
                  '<div class="col-md-10">' +
                  '<h5 id="firstHeading" class="firstHeading" style="color: #802390;"><a href="{{ route("job_detail", ["slug" => $job->slug]) }}">{{$job->title}}</a></h5>' +
                  '<p><i style="font-weight:bold;color:grey">{{$job->enterprise_name}}</i></p>' +
                  '<div id="bodyContent">' +
                  '<p><span class="info"><i class="fas fa-map-marker-alt" style="color: #159ff6;"></i>{{$job->address_work}} </span>' +
                  '&emsp;<span class="info"><i class="fas fa-coins" style="color: #ffc100"></i> Lương : {{$job->salary_description}} </span>' +
                  '&emsp;<span class="info"><i class="fas fa-user-friends"></i> Số lượng :{{$job->number_recruit}} </span>' +
                  '&emsp;<span class="info"><i class="fas fa-eye"></i> {{$job->people_seen}}  </span></p>' +
                  '<a href="{{ route("apply_now", ["jobId" => $job->job_id ]) }}" class="btn btn-default dsBlockIm">Ứng tuyển ngay</a>' +
                  '</div>' +
                  '</div>' +
                  '</div>' +
                  '</div>'],
                  @endif
               @endforeach
            @endif
           ];

           var infoWindow = new google.maps.InfoWindow(), marker, i;
           for (i = 0; i < markers.length; i++) {
             var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
             bounds.extend(position);
             marker = new google.maps.Marker({
               position: position,
               map: map,
               title: markers[i][0],
               // label: { color: '#80298f',background: '#fff', fontWeight: 'bold', fontSize: '14px', text: 'Your text here' },
               icon: markers[i][3]
             });
         
             google.maps.event.addListener(marker, 'click', (function (marker, i) {
               return function () {
                 infoWindow.setContent(infoWindowContent[i][0]);
                 infoWindow.open(map, marker);
               }
             })(marker, i));
         
             map.fitBounds(bounds);
           }
           var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function (event) {
             this.setZoom(15);
             google.maps.event.removeListener(boundsListener);
           });
                  }
                  
         catch(err) {
           return 0;
         }
         
         }
         // Load initialize function
      
      </script>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfMhsscTwP4UQh0H03FhsD_FisKDO1iBo&callback=initMap"
         async defer></script>


@endsection