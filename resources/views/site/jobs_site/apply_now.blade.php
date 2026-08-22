
@extends('site.layout.site')

@section('title', 'Ứng tuyển ngay '.$job->title)
@section('meta_description', 'Ứng tuyển ngay '.$job->description)
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')
<div style="background:#eeeeee;padding-top:5px; ">
<div class="container">
<div class="notificationBox bkwhite formJobLarge sm-f14">
<form action="{{ route('update_apply_now') }}" id="divWebCandidate" method="post" enctype="multipart/form-data">
       {!! csrf_field() !!}
  <div class="CV bgrWhite radius5 pd20 mgt20 mgb20 pdb5">
     <div class="textLeft">
        <h5 class="lt-f18 textUpper fw7 bdLeftBlueN5x pdl10 blueN mgb0">
           thông tin cá nhân
        </h5>
     </div>
     <hr class="mgt10 mgb10">
     <div class="content">
        <div class="row">
        
           <div class="col-xl-9 col-lg-9 left">
                 
                 <div class="form-row mgt20">
                    <label for="inputAddress2" class="fw6">Họ và tên: <span class="red">(*)</span></label>
                    <input type="text" name="employee_name" class="form-control requiredbox" id="inputName" placeholder="Nhập Họ và tên" value="{{ isset($employee->employee_name) ? $employee->employee_name : old('employee_name') }}" autofocus="" required >
                 </div>
                 <div class="form-row mgt20">
                    <div class="form-check form-check-inline">
                       <label class="form-check-label fw6" for="inlineRadio1">Giới tính: <span class="red">(*)</span></label>
                    </div>
                    <div class="form-check form-check-inline">
                       <input type="radio" name="gender" id="male" value="1"
                                           {{ old('gender') && !isset($employee->gender) == 1 ? 'checked' :  '' }}
                                           {{ isset($employee->gender) && $employee->gender == 1 ? 'checked' : '' }}
                                    required />
                       <label class="form-check-label" for="inlineRadio2">Nữ</label>
                    </div>
                    <div class="form-check form-check-inline">
                     <input type="radio" name="gender" id="female" value="2" {{ old('gender') && !isset($employee->gender) == 2 ? 'checked' :  '' }}
                                     {{ isset($employee->gender) && $employee->gender == 2 ? 'checked' : '' }}
                                required />
                       <label class="form-check-label" for="inlineRadio3">Nam</label>
                    </div>



                    <div class="lg-block">
                       <div class="form-check form-check-inline">
                          <label class="form-check-label fw6 mgl40 lg-mg0" for="inlineRadio1">Hôn nhân: <span class="red"></span></label>
                       </div>
                       <div class="form-check form-check-inline">
                           <input type="radio" name="marry" {{ old('marry') == 0 ? 'checked' :  '' }}   id="single" value="1" required>
                          <label class="form-check-label" for="inlineRadio2">Độc thân</label>
                       </div>
                       <div class="form-check form-check-inline">
                          <input type="radio" name="marry" {{ old('marry') == 1 ? 'checked' :  '' }}  id="married" value="2" required>
                          <label class="form-check-label" for="inlineRadio3">Đã kết hôn</label>
                       </div>
                    </div>

                 </div>
                 <div class="form-row mgt20">
                    <label for="inputEmail4" class="col-12 fw6  ">Ngày sinh <span class="red">(*)</span></label>
                         <input class="form-control inBlock " type="date" value="2011-08-19" name="brithday" id="">
                 </div>

                 <div class="form-row mgt20 pd0">

                    <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                       <label for="inputZip" class="fw6">Email <span class="red">(*)</span></label>
                        <input type="email" name="email" class="requiredbox form-control" id="txtEmail" placeholder="Email của bạn" value="{{ isset($employee->email) ? $employee->email : '' }}" required>
                    </div>

                     <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                       <label for="inputZip" class="fw6">Mật khẩu <span class="red">(*)</span></label>
                       <input id="txtPassword" class="requiredbox form-control" type="password" name="password" placeholder="{{ isset($employee->phone) ? 'Bỏ trống nếu không muốn thay đổi mật khẩu' : 'Mật khẩu để đăng nhập sau này đăng nhập' }}" {{ isset($employee->phone) ? '' : 'required' }}>
                    </div> 

                 </div>

                 <div class="form-row form-group">
                       <label for="inputZip" class="fw6">Số điện thoại <span class="red">(*)</span></label>
                        <input type="number" name="phone" class="requiredbox form-control" id="txtMobile" placeholder="Điện thoại của bạn" value="{{ isset($employee->phone) ? $employee->phone : '' }}" required>
                 </div>
                 <div class="form-row form-group">
                    <label for="inputZip" class="fw6 col-12">Địa chỉ tạm trú <span class="red">(*)</span></label>
                     <div class="col-6 mgb10">
                      <select class="form-control select2" name="province" aria-label="Tỉnh/Thành phố" id="province">
                            <option value=""> -- Tất cả các tỉnh/thành phố -- </option>
                            @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mgb10">
                        <select class="form-control select2" name="district" aria-label="Quận/Huyện" id="district">
                            <option value=""> -- Tất cả các quận/huyện --</option>
                            @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                <option value="{{$district->district_id}}">{{$district->district_name}}</option>
                            @endforeach
                        </select>
                        
                    </div>

                 </div>
                 <div class="form-row mgt20">
                    <label for="inputZip" class="fw6">Địa chỉ thường trú <span class="red">(*)</span></label>
                     <input id="txtResident" type="text" name="address" class="requiredbox form-control" placeholder="Ghi theo địa chỉ CMND" value="{{ isset($employee->address) ? $employee->address : '' }}"  required>
                 </div>
                 <div class="form-group mgt20">

                    <label for="exampleFormControlTextarea1" class="fw6 ">Giới thiệu bản thân:</label>
                    <textarea id="txtNote" name="information_verifier[]" rows="6" class="textarea col-12 bdLightGray radius5">
                        {{ isset($employee->information_verifier) ? $employee->information_verifier : '' }}
                    </textarea>

                 </div>
             
           </div>

           <div class="col-xl-3 col-lg-3 right textCenter md-mgt20">
                <div class="cvright">
                  <div class="textpic">Ảnh của bạn</div>
                  <div class="camera" style="">
                      <img class="lazy" id="avatar-webcam" width="143" oldimg="" height="98" src="{{ isset($employee->employee_image) ? $employee->employee_image : asset('assets/image/camera.jpg') }}">
                      <input type="hidden" id="cameraWebcam" name="image" value="{{ isset($employee->employee_image) ? $employee->employee_image : '' }}" />
                  </div>
                  <div class="ortext">
                      <span class="or sm-block">Hoặc chọn ảnh từ máy tính của bạn</span>
                      <input type="file" name="fuAvatar" id="fuAvatar" onchange="readURL(this)" class="inputfile inputfile-1">
                      <label for="fuAvatar" id="imgInp">
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                              <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                          </svg>
                          <span>Chọn ảnh của bạn</span>
                      </label>

                  </div>
                  <input id="candidatepage" value="1" style="display: none" />
                  <canvas id="imgdisplay" style="display: none;" width="360" height="360"></canvas>
                  <canvas id="imgdisplayHide" style="display: none;" width="360" height="360"></canvas>

                  <script>
                      function readURL(input) {
                          $('.camera').empty();
                          if (input.files && input.files[0]) {
                              for (var i = 0; i < input.files.length; i++) {
                                  var file = input.files[i];

                                  var picReader = new FileReader();
                                  picReader.addEventListener("load", function(event) {
                                      var picFile = event.target;
                                      $('.camera').append("<img class='thumbnail' src='" + picFile.result + "'" +
                                          "title='" + picFile.name + "' width='143'  />");
                                      $('.camera').append('<input type="hidden" value="' + picFile.result + '" name="image" />');
                                  });
                                  //Read the image
                                  picReader.readAsDataURL(file);
                              }
                          }
                      }
                      $('#imgInp').click(function() {
                          $('#fuAvatar').click();
                          return false;
                      });
                  </script>
              </div>
           </div>
        </div>

        <div class="title mgt20">
           <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
           <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter blueN sm-w100 sm-mgt20">Trình độ chuyên môn</div>
           <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
        </div>

            <div class="boxSchool">
                <div class="form-row mgt20">
                   <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                      <label for="inputZip" class="fw6">Tên trường <span class="red">(*)</span></label>
                      <input type="text" name='school' class="form-control" id="inputZip" placeholder="Ví dụ: Đại học kinh tế TPHCM">
                   </div>
                   <div class="form-group col-lg-6 pdl2p lg-pd0Im">
                      <label for="inputZip" class="fw6">Trình độ <span class="red">(*)</span></label>
                      <select  name="literacy"  id="ddlQualificationType"  class="selectbox requiredbox form-control">
                        <option value="0">-- Chọn Bằng cấp --</option>
                        @foreach(\App\Entity\Literacy::get() as $literacy)
                            <option value="{{$literacy->literacy_id}}"
                                    {{ $literacy->literacy_id === old('literacy') && !isset($employee->literacy)  ? 'selected' : ''}}
                                    {{ isset($employee->literacy) && ($employee->literacy == $literacy->literacy_id) ? 'selected' : ''}}
                            >{{$literacy->literacy_name}}</option>
                        @endforeach
                        </select>
                   </div>
                </div>
                <div class="form-row">
                   <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                      <label for="inputZip" class="fw6">Ngành học <span class="red">(*)</span></label>
                       <input type="text" name="majors" id="txtMajorContent" class="requiredbox form-control" value="{{ isset($employee->majors) ? $employee->majors : '' }}" placeholder="Ví dụ: Quản trị kinh doanh">
                      
                   </div>
                   <div class="form-group col-lg-6 pdl2p lg-pd0Im">
                      <label for="inputZip" class="fw6">Tình trạng <span class="red">(*)</span></label>
                      <input type="text" id="txtCertificate" name="softSkill" class="requiredbox form-control" value="{{ isset($employee->soft_skills) ? $employee->soft_skills : '' }}" placeholder="Ví dụ: Đã tốt nghiệp hoặc chưa tốt nghiệp">
                   </div>
                </div>
            </div>


        <div class="form-group textRight">
           <a  class="whiteIm bgrBlueN pd10 cursor" onclick="return add(this)"><i class="fas fa-plus"></i> Thêm trình độ</a>
        </div>

        <div class="title mgt20">
           <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
           <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 sm-w100 textCenter blueN ">Quá trình làm việc</div>
           <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
        </div>
    <div class="box">
     @if (!empty($historyCompanies))
        @foreach ($historyCompanies as $historyCompany)
         <div class="company">
            <div class="form-row mgt20">
               <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                  <label for="inputZip" class="fw6">Công ty làm việc gần nhất</label>
                  <input class="form-control" type="text" id="txtCompany" name="historyCompany[]" value="{!! $historyCompany->company !!}" placeholder="Công ty ABC">
               </div>
               <div class="form-group col-lg-6 pdl2p lg-pd0Im">
                  <label for="inputZip" class="fw6">Chức vụ </label>
                   <input class="form-control" type="text" id="txtPosition" name="position[]" value="{!! $historyCompany->position !!}" placeholder="Chăm sóc khách hàng">
               </div>
            </div>
            <div class="form-group">
               <label for="exampleFormControlTextarea1" class="fw6 w100">Mô tả vị trí công việc:</label>
                <textarea id="txtNote" name="descriptionCompany[]" rows="6" class="textarea w100">{!! $historyCompany->content !!}</textarea>
            </div>
        </div>
        @endforeach
    @else
    <div class="company">
        <div class="form-row mgt20">
           <div class="form-group col-lg-6 pdr2p lg-pd0Im">
              <label for="inputZip" class="fw6">Công ty làm việc gần nhất</label>
              <input class="form-control" type="text" id="txtCompany" name="historyCompany[]" !!} placeholder="Công ty ABC">
           </div>
           <div class="form-group col-lg-6 pdl2p lg-pd0Im">
              <label for="inputZip" class="fw6">Chức vụ </label>
               <input class="form-control" type="text" id="txtPosition" name="position[]"  placeholder="Chăm sóc khách hàng">
           </div>
        </div>
        <div class="form-group">
           <label for="exampleFormControlTextarea1" class="fw6 w100 ">Mô tả vị trí công việc:</label>
            <textarea id="txtNote" name="descriptionCompany[]" rows="6" class="textarea w100"></textarea>
        </div>
    </div>
    @endif

     </div>
       <div class="form-group textRight">
           <a class="whiteIm bgrBlueN pd10 cursor" onclick="return addHistoryCompany(this)"><i class="fas fa-plus"></i> Thêm quá trình làm việc</a>
        </div>

      <script>
        function addHistoryCompany(e) {
            html = ' <div class="company">';
            html += '<div class="form-row mgt20">';
            html +=     '<div class="form-group col-lg-6 pdr2p lg-pd0Im">';
            html +=      '<label for="inputZip" class="fw6">Công ty làm việc gần nhất</label>';
            html += '<input class="form-control" type="text" id="txtCompany" name="historyCompany[]" !!} placeholder="Công ty ABC">';
            html += ' </div>'
            html += ' <div class="form-group col-lg-6 pdl2p lg-pd0Im">';
            html +=     '<label for="inputZip" class="fw6">Chức vụ </label>';
            html +=     '<input class="form-control" type="text" id="txtPosition" name="position[]"  placeholder="Chăm sóc khách hàng">';
            html += '</div>';
            html +=     '</div>';
            html += '<div class="form-group">';
            html += '<label for="exampleFormControlTextarea1" class="fw6 w100 ">Mô tả vị trí công việc:</label>';
            html += ' <textarea id="txtNote" name="descriptionCompany[]" rows="6" class="textarea w100"></textarea>';

            html += '</div>';
            html += '</div>';
            html += '</div>';


            $('.box').append(html);
        }

        function add(e){

            html = '<div class="form-row mgt20">'
            html += '<div class="form-group col-lg-6 pdr2p lg-pd0Im">'
            html += '<label for="inputZip" class="fw6">Tên trường <span class="red">(*)</span></label>'
            html += '<input type="text" class="form-control" id="inputZip" placeholder="Ví dụ: Đại học kinh tế TPHCM">'
            html += '</div>'
            html += '<div class="form-group col-lg-6 pdl2p lg-pd0Im">'
            html += '<label for="inputZip" class="fw6">Trình độ <span class="red">(*)</span></label>'
            html += '<select name="ddlQualificationType" name="literacy"  id="ddlQualificationType" class="selectbox requiredbox form-control">'
            html += '<option value="0">-- Chọn Bằng cấp --</option>'
            html += ' @foreach(\App\Entity\Literacy::get() as $literacy)'
            html += '<option value="{{$literacy->literacy_id}}">'
            html += '{{$literacy->literacy_name}}'
            html += '</option>'
            html += '@endforeach'
            html += '</select>'
            html += '</div>'
            html += '</div>'

            html += '<div class="form-row">'
            html += '<div class="form-group col-lg-6 pdr2p lg-pd0Im">'
            html += '<label for="inputZip" class="fw6">Ngành học <span class="red">(*)</span></label>'
            html += '<input type="text" name="majors" id="txtMajorContent" class="requiredbox form-control" value="{{ isset($employee->majors) ? $employee->majors : '' }}" placeholder="Ví dụ: Quản trị kinh doanh">'
                      
            html += '</div>'
            html += '<div class="form-group col-lg-6 pdl2p lg-pd0Im">'
            html += '<label for="inputZip" class="fw6">Tình trạng <span class="red">(*)</span></label>'
            html += '<input type="text" id="txtCertificate" name="softSkill" class="requiredbox form-control" value="{{ isset($employee->soft_skills) ? $employee->soft_skills : '' }}" placeholder="Ví dụ: Đã tốt nghiệp hoặc chưa tốt nghiệp">'
            html += '</div>'
            html += '</div>'


            $('.boxSchool').append(html);


        }
        </script>

         <div class="cvbox">
            <div class="cvrow">
                <div class="text">Đính kèm Hồ sơ cá nhân (.doc hoặc .pdf): <span></span></div>
                <!-- <img class="icon-file-attach" src="{{ asset('assets/image/file-attach.png') }}"> -->
                <input type="file"  name="fuFileAttach">
                <br>
            </div>
        </div>
        @if (isset($employee->employee_id))
            <input type="hidden" value="{{ $employee->employee_id }}" name="employee_id"/>
        @endif
        <input type="hidden" value="{{ $job->job_id }}" name="jobs"/>
       <div class="form-group textCenter">
            <button type="sumit" class="whiteIm bgrBlueN pd10 hvbgrBlueN ">
                Nộp hồ sơ
            </button>
        </div>
     </div>
  </div>
</form>
</div>

</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
          $('#province').change(function () {
              $.get('/ajax-district/'+ $(this).val(), function (data) {
                  $('#district').html(data);
              });
          });
      });
</script>
<script type="text/javascript">
  
  
</script>

@endsection
