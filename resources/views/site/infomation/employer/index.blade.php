@extends('site.layout.site') @section('title','Information') @section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '') @section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '') @section('content')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="row ">


            @include('site.sidebar.sidebar_member')
            <div class="col-xl-9 col-lg-8 col-md-12 col-12 col-12">
                <div class="supporter bgrWhite textCenter radius5 pd5 bdLightGray mgb20">
                    <p class="mgb0">Bạn đang sử dụng tài khoản tài khoản <span class="red">Miễn phí</span></p>
                    <p class="mgb0">Hãy đăng ký <a href="">Gói dịch vụ đăng tin</a> để tuyển dụng nhanh và hiệu quả với các quyển lợi hấp dẫn</p>


                </div>
                <div class="CV bgrWhite radius5 pd20 mgt20 mgb20 pdb5">
                    <div class="title" style="position: relative;">
                        <h5 class="lt-f18 textUpper fw7 bdLeftBlueN5x pdl10 blueN mgb0">
                           thông tin công ty
                        </h5>
                        <a  class="" data-toggle="modal" data-target="#resetPas" style="position: absolute;right: 0;top: 0">
                        Đổi Mật Khẩu 
                        </a>

                    </div>
                    <hr class="mgt10 mgb10">
                    <div class="content">
                        <div class="row">
                            <div class="col-12">
                                 <form action="{{route('update_employer')}}" method="post">
                                                {!! csrf_field() !!}

                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Tên công ty
                                            <span class="red">*</span> </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="enterprise_name" placeholder="Tên công ty" value="{{isset($employer->enterprise_name) ? $employer->enterprise_name : '' }}">
                                            <small id="emailHelp" class="form-text text-muted"><i>Ghi tên công ty đầy đủ và rõ ràng theo Giấy phép đăng ký kinh doanh</i></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Quy mô công ty
                                            <span class="red">*</span> </label>
                                        <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-sm-5">
                                               
                                                    <select id="inputState" name="size" class="form-control" id="selectbox">
                                                        <option value="">-- Chọn quy mô công ty --</option>
                                                        <option value="1">ít hơn 10 nhân viên</option>
                                                        <option value="2">10 - 24 nhân viên</option>
                                                        <option value="3">25 - 99 nhân viên</option>
                                                        <option value="4">100 - 499 nhân viên</option>
                                                        <option value="5">500 - 1000 nhân viên</option>
                                                        <option value="6">trên 1000 nhân viên</option>
                                                    </select>
                                                </div>
                                         
                                                <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Điện thoại
                                                    <span class="red">*</span> </label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="phone" value="{{isset($employer->phone) ? $employer->phone : '' }}" class="form-control" placeholder="Nhập số điện thoại">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Giới thiệu
                                            <span class="red">*</span>
                                        </label>
                                        <div class="col-sm-9">
                                            <textarea id="txtNote" name="introduction" rows="6" class="textarea col-12 bdLightGray radius5">{{isset($employer->introduction) ? $employer->introduction : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row ">
                                        <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Logo công ty
                                            <span class="red">*</span>
                                        </label>
                                        <div class="col-sm-9 row">
                                            <div class="camera col-sm-3" style="">
                                                <img id="avatar-webcam" width="150" oldimg="" src="{{ isset($employer->image) ? $employer->image : '/CV/noimage.png' }}">
                                            </div>
                                            <input type="hidden" name="image" value="{{ isset($employer->image) ? $employer->image : '' }}" id="logoCompany">

                                            <div class="ortext col-sm-9 ">

                                                <input style="display: none;" type="file" name="fuAvatar" id="fuAvatar" onchange="readURL(this)" class="inputfile inputfile-1">

                                                <label for="fuAvatar" id="imgInp">
                                                    <div class="col-sm-9">
                                                        <a href="" id='file-text' class="pd5-10 whiteIm bgrBlueN radius5 pdt10 pdb10"><i class="fas fa-paperclip"></i> Chọn file đính kèm</a> <span>Không có tệp nào được chọn </span>

                                                        <small id="emailHelp" class="form-text text-muted mgt10"><i>(Dạng file ảnh .jpg, .gif, .png, dung lượng &lt;=300KB và kích thước tối thiểu 300x300 pixel)</i></small>
                                                    </div>
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

                                                                $('#logoCompany').val(picFile.result);

                                                                // $('.camera').append('<input type="hidden" value="' + picFile.result + '" name="image" />');
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
                        </div>

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Mã số thuế
                            </label>
                            <div class="col-sm-9">
                                <input type="text" name="tax_code" value="{{isset($employer->tax_code) ? $employer->tax_code : ''}}" class="form-control" placeholder="Nhập mã số thuế">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Địa chỉ công ty
                                <span class="red">*</span> </label>
                            <div class="col-sm-9">
                                <input type="text" name='address' value="{{ isset($employer->address) ? $employer->address : ''}}" class="form-control" placeholder="">
                                <small id="emailHelp" class="form-text text-muted"><i>Vui lòng nhập chi tiết địa chỉ của bạn bằng tiếng Việt có dấu.</i></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Tỉnh/Thành phố
                                <span class="red">*</span> </label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <select class="form-control select2" name="province" aria-label="Tỉnh/Thành phố" id="province_id">
                                            <option value=""> -- Tất cả các tỉnh/thành phố -- </option>
                                             @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                 <option {{ $province->province_id == old('province') && !isset($employer->province) ? 'selected' : '' }} {{ isset($employer->province) && $employer->province == $province->province_id ? 'selected' : '' }} value="{{$province->province_id}}">{{$province->province_name}}</option>
                                             @endforeach
                                        </select>
                                    </div>
                                    <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Quận/Huyện
                                        <span class="red">*</span> </label>
                                    <div class="col-sm-5">
                                        <select class="form-control select2" name="district" aria-label="Quận/Huyện" id="district_id">
                                            <option value=""> -- Tất cả các quận/huyện --</option>
                                            @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                            <option {{ $district->district_id == old('district') && !isset($employer->district) ? 'selected' : '' }} {{ isset($employer->district) && $employer->district == $district->district_id ? 'selected' : '' }} value="{{$district->district_id}}">{{$district->district_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Website
                            </label>
                            <div class="col-sm-9">
                                <input type="text" name="website" value="{{isset($employer->website) ? $employer->website : ''}}" class="form-control" placeholder="">
                            </div>
                        </div>
                           <div class="form-group textCenter sm-mgt35">
                                <button href="" class="pd10-30 whiteIm bgrBlueN fw7 radius5">Lưu hồ sơ</button>
                            </div>
                        </form>
                    </div>
                </div>
             
            </div>
        </div>

      <!--   <div class="CV bgrWhite radius5 pd20 mgt20 mgb20 pdb5">
            <div class="title">
                <h5 class="lt-f18 textUpper fw7 bdLeftBlueN5x pdl10 blueN mgb0">
                           thông tin chủ khoản
                        </h5>
            </div>
            <hr class="mgt10 mgb10">
            <div class="content">
                <div class="row">
                    <div class="col-12">
                        <form>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Email đăng ký
                                    <span class="red">*</span> </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                                <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Số điện thoại
                                    <span class="red">*</span> </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Mật khẩu
                                    <span class="red">*</span> </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                                <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Xác nhận mật khẩu
                                    <span class="red">*</span> </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Tên chủ khoản
                                    <span class="red">*</span> </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                                <label for="staticEmail" class="col-sm-2 mh42-text-left lable text-right fw6 mgt5">Email liên hệ
                                    <span class="red">*</span> </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="form-group textCenter sm-mgt35">
                    <a href="" class="pd10-30 whiteIm bgrBlueN fw7 radius5">Lưu hồ sơ</a>
                </div>
            </div>
        </div> -->
    </div>
    @include('site.module_index.dang-ky-tu-van') @include('site.module_index.hotline')
    </div>

    </div>
    </div>
</section>

  <!-- The Modal -->
  <div class="modal fade" id="resetPas">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <p class="title">Đổi mật khẩu</p>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
           <form action="/doi-mat-khau" method="post" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="form-group row">
                  <label for="staticEmail" class="col-sm-4 col-form-label"><span class="text-b700">Mật khẩu cũ</span><span class="clred pd-05">(*)</span></label>
                  <div class="col-sm-8">
                      <input id="password_old" type="password" class="form-control" name="password_old" required>
                  </div>
                  @if (session('faidOldPassword'))

                  <span class="help-block">
              <strong> {{ session('faidOldPassword') }}</strong>
          </span> @endif
              </div>
              <div class="form-group row">
                  <label for="staticEmail" class="col-sm-4 col-form-label"><span class="text-b700">Mật khẩu mới</span><span class="clred pd-05">(*)</span></label>
                  <div class="col-sm-8">
                      <input id="password" type="password" class="form-control" name="password" required>
                  </div>
              </div>
              <div class="form-group row">
                  <label for="staticEmail" class="col-sm-4 col-form-label"><span class="text-b700">Nhập lại mật khẩu mới</span><span class="clred pd-05">(*)</span></label>
                  <div class="col-sm-8">
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                  </div>
                  @if ($errors->has('password'))
                  <span class="help-block">
              <strong>Mật khẩu xác nhận lại không đúng.</strong>
              </span> @endif
              </div>

              <div class="form-group row">
                  <div class="col-sm-4"></div>
                  <div class="col-sm-8 pdtop30">
                      <button type="submit" class="btn btn-primary">Thay đổi mật khẩu</button>
                  </div>
              </div>
          </form>
        </div>

      </div>
    </div>
 </div>


@if (session('setErrorMessage'))
<script>
    alert('{{ session('
        setErrorMessage ') }}')
</script>
@endif
<script>
    $('#location-input').mouseout(function(e) {
            geocode(e)
        })
        //  var locationForm = document.getElementById('location-form');
        //    locationForm.addEventListener('submit', geocode);
    function geocode(e) {
        e.preventDefault();

        var location = document.getElementById('location-input').value;

        axios.get('https://maps.googleapis.com/maps/api/geocode/json', {
                params: {
                    address: location,
                    key: 'AIzaSyDfMhsscTwP4UQh0H03FhsD_FisKDO1iBo'
                }
            })
            .then(function(response) {
                console.log(response);
                // Geometry
                var lat = response.data.results[0].geometry.location.lat;
                var lng = response.data.results[0].geometry.location.lng;
                // Output to app
                document.getElementById('lat').value = lat;
                document.getElementById('lng').value = lng;
            })
            .catch(function(error) {
                console.log(error);
            });
    }
</script>
<script>
    $(".them-dai-ngo").click(function() {
        $(this).before('<input type="text"  name="remuneration[]" class="form-control mgb10" placeholder="Nhập chế độ đãi ngộ  (Tối đa 50 ký tự)">')
    })

    $(".them-li-do").click(function() {
        $(this).before('<textarea name="reason_choose[]" id="txtNote" rows="3" class="textarea font17 w100 pdt5" placeholder="  Nhập lý do  (Tối đa 100 ký tự)" style="width: 100%;"></textarea>')
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#province_id').change(function() {
            $.get('/ajax-district/' + $(this).val(), function(data) {
                $('#district_id').html(data);
            });
        });
    });
</script>

@if (session('error'))
<script>
    alert('{{ session('
        error ') }}')
</script>
@endif @endsection