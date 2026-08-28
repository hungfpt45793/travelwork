<style>.form-group {
        margin-bottom: 10px;
    }</style>
<script src="{{ asset('adminstration/jquery.priceformat.js') }}"></script>
<div class="CV bgrWhite radius5 pd20  mgb20 pdb5 UpdateUserTab">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if(session('suscess')) active @endif
            @if(!session('suscess_specialize') and !session('suscess_experience') and !session('suscess_course'))  active  @endif"
               id="home-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true">Thông
                tin giáo viên</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(session('suscess_specialize'))active @endif" id="profile-tab" data-toggle="tab"
               href="#tab2" role="tab" aria-controls="profile" aria-selected="false">Trình độ chuyên môn</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(session('suscess_experience'))active @endif" id="contact-tab" data-toggle="tab"
               href="#tab3" role="tab" aria-controls="contact" aria-selected="false">Kinh nghiệm làm việc</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(session('suscess_course'))active @endif" id="contact-tab" data-toggle="tab"
               href="#tab4" role="tab" aria-controls="contact" aria-selected="false">Công việc làm thêm</a>
        </li>
    </ul>
    {{--TAB1--}}
    <div class="tab-content " id="myTabContent">
        <div class="tab-pane fade @if(session('suscess')) show active @endif  @if(!session('suscess_specialize') and !session('suscess_experience') and !session('suscess_course')) show active @endif "
             id="tab1" role="tabpanel" aria-labelledby="home-tab">
            <div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                <div class="content">
                    <div class="row">
                        <div class="col-md-12  mgt15">

                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 sm-w100 textCenter blueN ">Thông
                                    tin giáo viên
                                </div>
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                            </div>
                            @if(session('suscess'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert"
                                     style="margin-top: 15px;width: 100%">
                                    <strong>{{ session('suscess') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if(session('erorr'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert"
                                     style="margin-top: 15px;width: 100%">
                                    <strong>{{ session('erorr') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(!empty($errors->all()))
                                @foreach($errors->all() as $erorr)
                                    <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                @endforeach
                            @endif
                            <div class="col-xl-12 col-lg-12 left">
                                <form action="{{ route('updateTeacher') }}" method="post" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6">Tên giáo viên : </label>
                                            <input type="text" class="form-control" id="inputName"
                                                   placeholder="Nhập tên giáo viên"
                                                   name="teacher_name"
                                                   value="{{  isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6">Ngày sinh : </label>
                                            <input type="date" class="form-control" id="inputName"
                                                   placeholder="Ngày sinh"
                                                   name="birthday"
                                                   value="{{ isset($teacher->birthday) ? $teacher->birthday : '' }}">

                                        </div>

                                    </div>
                                    <div class="form-row mgt20">
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6">Nhập số điện thoại : </label>
                                            <input type="number" class="form-control" id="inputName"
                                                   placeholder="Nhập số điện thoại"
                                                   name="teacher_phone"
                                                   value="{{ isset($teacher->teacher_phone) ? $teacher->teacher_phone : '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6">Email <i style="font-weight: 500">(Tài
                                                    khoản đăng nhập )</i></label>
                                            <input type="email" class="form-control" id="inputName"
                                                   placeholder="Nhập Email"
                                                   name="teacher_email"
                                                   value="{{ isset($teacher->teacher_email) ? $teacher->teacher_email : $user->email }}"
                                                   readonly>
                                        </div>
                                    </div>

                                    <div class="form-row mgt20 gruopRadio">
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6" style="display: block;">Giới tính: </label>
                                            <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                <input class="form-check-input" type="radio" name="gender"
                                                       id="exampleRadios2"
                                                       value="1" @if($teacher->gender == 1) checked @endif>
                                                <label class="form-check-label" for="exampleRadios2">
                                                    Nữ
                                                </label>
                                            </div>
                                            <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                <input class="form-check-input" type="radio" name="gender"
                                                       id="exampleRadios3"
                                                       value="2" @if($teacher->gender == 2) checked @endif>
                                                <label class="form-check-label" for="exampleRadios3">
                                                    Nam
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6">Hình ảnh giáo viên : </label>
                                            <div class="">

                                                <div class="form-group">
                                                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                                           size="20"/>
                                                    <img src="{{ isset($teacher->teacher_images) ? $teacher->teacher_images : '' }}" width="80" height=""/>
                                                    <input name="images" type="hidden" value="{{ isset($teacher->teacher_images) ? $teacher->teacher_images: '' }}"/>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="inputAddress2" class="fw6">Địa chỉ giáo viên <i
                                                        style="font-weight: 500"></i></label>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group borderSelect2">
                                                <label for="exampleInputEmail1">Tỉnh/Thành phố</label>
                                                <select class="form-control select2 " name="province"
                                                        aria-label="Tỉnh/Thành phố"
                                                        id="city">
                                                    <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                                    @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                        <option value="{{$province->province_id}}"
                                                                @if($teacher->province == $province->province_id) selected @endif
                                                        >{{$province->province_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group borderSelect2">
                                                <label for="exampleInputEmail1">Quận/Huyện</label>
                                                <select class="form-control select2 " name="district"
                                                        aria-label="Quận/Huyện"
                                                        id="county">
                                                    <option value="">-- Chọn Quận/Huyện --</option>
                                                    @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                        <option value="{{$district->district_id }}"
                                                                @if($teacher->district == $district->district_id) selected @endif
                                                        >{{$district->district_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group borderSelect2">
                                                <label for="exampleInputEmail1">Địa chỉ cụ thể </label>
                                                <input type="text" class="form-control" id="inputName"
                                                       placeholder="Địa chỉ "
                                                       name="address"
                                                       value="{{ isset($teacher->address) ? $teacher->address : '' }}">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">


                                        <div class="form-group borderSelect2">
                                            <label for="exampleInputEmail1">Lĩnh vực doanh nghiệp nhiều kinh nghiệm </label>
                                            <select class="form-control select2" name="business_type_id"
                                                    aria-label="Quận/Huyện"
                                                    id="">
                                                <?php $business_type = \App\Entity\TypeOfBusiness::getAllTypeBusiness();
                                                ?>

                                                <option value="" selected>-- Lĩnh vực doanh nghiệp --</option>
                                                @foreach($business_type as $business)
                                                    <option value="{{$business->type_of_business_id }}"
                                                            @if($teacher->business_type_id == $business->type_of_business_id) selected @endif
                                                    >{{$business->type_of_business_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">

                                        <div class="form-group borderSelect2 checkBox">
                                            <strong><label for="exampleInputEmail1"> Công việc đăng kí công việc làm thêm:</label></strong>
                                            <?php $jobgroups = \App\Entity\JobGroup::getAll()?>
                                            <div class="box-body scrollGroup row gruopRadio ">

                                                @foreach($jobgroups as $jobgroup)
                                                    <div class="col-md-6 ">
                                                        <label class="form-check" style="color: #009385;font-weight: bold;">
                                                            <input type="radio" value="{{$jobgroup->job_group_id}}" name="job_group_id[]"
                                                                   @if(in_array($jobgroup->job_group_id,$id_teacher_job)) checked @endif
                                                                   class="form-check-input"
                                                            >
                                                            <span style="    margin-top: 3px;
    margin-left: 10px;
    display: inline-block;">{{$jobgroup->job_group_name}}</span>

                                                        </label>

                                                    </div>
                                                @endforeach


                                            </div>
                                        </div>

                                    </div>
                                    {{--teacher_job--}}
                                    <div class="form-group mgt20">
                                        <label for="inputAddress2" class="fw6">Giới thiệu về bản thân :</label>
                                        <textarea name="information_verifier" id="editor1" rows="5" cols="100"
                                                  class="w100 form-control editor"
                                                  style="width: 100%">{!!   isset($teacher->information_verifier) ? $teacher->information_verifier : ''  !!}</textarea>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 right textCenter md-mgt20">
                                        <link rel="stylesheet" href="/assets/css/cv.min.css">
                                        <div id="camera-main" style="position: relative;display: none;z-index: 999;">
                                            <div id="camera-wrap" style="position: absolute; top: 50px;width:60%;">
                                                <table border="0">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <div>Live Camera</div>
                                                            <div class="livecam-html5">
                                                                <video id="video" width="360" height="360" autoplay=""></video>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <i class="fa fa-refresh fa-spin fa-lg wait-submit-camera" style="display: none"></i>
                                                            <input type="submit" value="Chụp" id="take-photo" class="btnCapture c-btn">
                                                            <input type="submit" value="Đóng" id="off-camera" class="btnCloseCapture c-btn-n">
                                                            <br>
                                                            <span id="camStatus" style="display: none"></span>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="cvright">
                                            <div class="textpic">Ảnh của bạn</div>
                                            <div class="camera" style="">
                                                <img id="avatar-webcam" width="143" oldimg="" height="98" src="./Thông tin ứng viên_files/camera.jpg">
                                                <input type="hidden" id="cameraWebcam" name="image" value="">
                                            </div>
                                            <div class="ortext">
                                                <span class="or">Hoặc chọn ảnh từ máy tính của bạn</span>
                                                <input type="file" name="fuAvatar" id="fuAvatar" onchange="readURL(this)" class="inputfile inputfile-1">
                                                <label for="fuAvatar" id="imgInp">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                                    </svg>
                                                    <span>Chọn ảnh của bạn</span>
                                                </label>
                                            </div>
                                            <input id="candidatepage" value="1" style="display: none">
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

                                    <div class="form-group">
                                        <!-- Google reCaptcha -->
                                        <div class="g-recaptcha" id="feedback-recaptcha"
                                             data-sitekey="{{ '6Le9trIUAAAAALrCbKEVd_fFCOjZm13bNMk9DmZP' }}"></div>
                                        <!-- End Google reCaptcha -->
                                    </div>



                                    <div class="col-xl-3 col-lg-3 right textCenter md-mgt20">
                                        <section class="UTN">
                                            <div id="camera-main" style="position: relative;display: none;z-index: 999;">
                                                <div id="camera-wrap" style="position: absolute; top: 50px;width:60%;">
                                                    <table border="0">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <div>Live Camera</div>
                                                                <div class="livecam-html5">
                                                                    <video id="video" width="360" height="360" autoplay=""></video>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <i class="fa fa-refresh fa-spin fa-lg wait-submit-camera" style="display: none"></i>
                                                                <input type="submit" value="Chụp" id="take-photo" class="btnCapture c-btn">
                                                                <input type="submit" value="Đóng" id="off-camera" class="btnCloseCapture c-btn-n">
                                                                <br>
                                                                <span id="camStatus" style="display: none"></span>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="cvright">
                                                <div class="textpic">Ảnh của bạn</div>
                                                <div class="camera" style="">
                                                    <img id="avatar-webcam" width="143" oldimg="" height="98" src="./Thông tin ứng viên_files/camera.jpg">
                                                    <input type="hidden" id="cameraWebcam" name="image" value="">
                                                </div>
                                                <div class="ortext">
                                                    <span class="or">Hoặc chọn ảnh từ máy tính của bạn</span>
                                                    <input type="file" name="fuAvatar" id="fuAvatar" onchange="readURL(this)" class="inputfile inputfile-1">
                                                    <label for="fuAvatar" id="imgInp">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                                        </svg>
                                                        <span>Chọn ảnh của bạn</span>
                                                    </label>
                                                </div>
                                                <input id="candidatepage" value="1" style="display: none">
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
                                        </section>
                                    </div>





                            <div class="form-row mgt20">
                                        <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5"
                                                style="border:none">
                                            Lưu
                                            hồ sơ giáo viên
                                        </button>

                                    </div>
                                </form>
                            </div>

                        </div>


                    </div>
                </div>


            </div>
        </div>
        {{--TAB2--}}
        <div class="tab-pane fade @if(session('suscess_specialize')) show active @endif" id="tab2" role="tabpanel"
             aria-labelledby="profile-tab">
            <div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                <div class="content">
                    <div class="row">
                        <div class="col-md-12  mgt15">
                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter blueN sm-w100 sm-mgt20">
                                    Trình độ chuyên môn
                                </div>
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                            </div>

                            <div class="col-xl-12 col-lg-12 left">
                                <form action="{{ route('update_Specialize_Teacher') }}" method="post"
                                      enctype="multipart/form-data">
                                    {!! csrf_field() !!}

                                    @if(session('suscess_specialize'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                                             style="margin-top: 15px;width: 100%">
                                            <strong>{{ session('suscess_specialize') }}</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    {{--trinh do chuyên môn--}}
                                    @if(!empty($specialize))
                                        <div class="boxSchool" id="specialize">
                                            @foreach($specialize as $id=>$spec)
                                                <div class="deleteItemSpec">
                                                    <p class="clorange f18"
                                                       style="font-weight: bold;margin-bottom: 10px;">Thời gian
                                                        : {{ isset($spec->star_specialize_time) ? $spec->star_specialize_time : '' }}
                                                        - {{ isset($spec->end_specialize_time) ? $spec->end_specialize_time : '' }} </p>

                                                    <div class="form-row mgt20">
                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Thời gian bắt đầu học -
                                                                <i>tính theo năm</i> </label>
                                                            <input type="year"
                                                                   name='specialize[{{ $id }}][star_specialize_time]'
                                                                   class="form-control" id="inputZip"
                                                                   placeholder="Ví dụ: 2015"
                                                                   value="{{ isset($spec->star_specialize_time) ? $spec->star_specialize_time : '' }}">
                                                        </div>
                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính
                                                                    theo năm</i> </label>
                                                            <input type="year"
                                                                   name='specialize[{{ $id }}][end_specialize_time]'
                                                                   class="form-control" id="inputZip"
                                                                   placeholder="Ví dụ:  2016"
                                                                   value="{{ isset($spec->end_specialize_time) ? $spec->end_specialize_time : '' }}">
                                                        </div>

                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Tên trường </label>
                                                            <input type="text" name='specialize[{{ $id }}][school]'
                                                                   class="form-control" id="inputZip"
                                                                   placeholder="Ví dụ: Đại học kinh tế TPHCM"
                                                                   value="{{ isset($spec->school) ? $spec->school : '' }}">
                                                        </div>
                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Trình độ </label>
                                                            <select name='specialize[{{ $id }}][leve]'
                                                                    id="ddlQualificationType"
                                                                    class="selectbox requiredbox form-control">
                                                                <option value="0" selected>-- Chọn Bằng cấp --</option>
                                                                @foreach(\App\Entity\Literacy::get() as $literacy)
                                                                    <option value="{{$literacy->literacy_id}}"
                                                                            {{ isset($spec->leve) && ($spec->leve == $literacy->literacy_id) ? 'selected' : ''}}
                                                                    >{{$literacy->literacy_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Ngành học </label>
                                                            <input type="text" name='specialize[{{ $id }}][majors]'
                                                                   id="txtMajorContent" class="requiredbox form-control"
                                                                   value="{{ isset($spec->majors) ? $spec->majors : '' }}"
                                                                   placeholder="Ví dụ: Quản trị kinh doanh">

                                                        </div>
                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Tình trạng </label>
                                                            <input type="text" id="txtCertificate"
                                                                   name='specialize[{{ $id }}][specialize_status]'
                                                                   class="requiredbox form-control"
                                                                   value="{{ isset($spec->specialize_status) ? $spec->specialize_status : '' }}"
                                                                   placeholder="Ví dụ: Đã tốt nghiệp hoặc chưa tốt nghiệp">
                                                        </div>
                                                        <div class="col-lg-12"
                                                             style="float: right;text-align: right;padding-right: 25px;">
                                                            <a class="deleteItem"
                                                               style="    color: white;background: red;padding: 5px 14px;cursor: pointer;">Xóa</a>
                                                        </div>
                                                    </div>
                                                    <hr class="bgrBlueN">
                                                </div>
                                            @endforeach


                                            <div class="form-group textRight mgt15">
                                                <a class="whiteIm bgrBlueN pd10 cursor" data-toggle="modal"
                                                   data-target="#add_specialize"><i class="fas fa-plus"></i> Thêm trình
                                                    độ </a>
                                            </div>
                                        </div>


                                        <div class="form-row mgt20">
                                            <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5"
                                                    style="border:none">
                                                Lưu thay đổi
                                            </button>

                                        </div>
                                    @endif

                                </form>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
        {{--TAB3--}}
        <div class="tab-pane fade @if(session('suscess_experience')) show active @endif" id="tab3" role="tabpanel"
             aria-labelledby="contact-tab">
            <div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                <div class="content">
                    <div class="row">
                        <div class="col-md-12  mgt15">
                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter blueN sm-w100 sm-mgt20">
                                    Kinh nghiệm làm việc
                                </div>
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                            </div>
                            <div class="col-xl-12 col-lg-12 left">
                                <form action="{{ route('update_Experience_Teacher') }}" method="post"
                                      enctype="multipart/form-data">
                                    {!! csrf_field() !!}

                                    @if(session('suscess_experience'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                                             style="margin-top: 15px;width: 100%">
                                            <strong>{{ session('suscess_experience') }}</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    {{--trinh do chuyên môn--}}
                                    @if(!empty($experience))
                                        <div class="boxSchool" id="specialize">
                                            @foreach($experience as $id_ex=>$exper)
                                                <div class="deleteItemSpec">
                                                    <p class="clorange f18"
                                                       style="font-weight: bold;margin-bottom: 10px;">Thời gian
                                                        : {{ isset($exper->star_working_time) ? $exper->star_working_time : '' }}
                                                        - {{ isset($exper->end_working_time) ? $exper->end_working_time : '' }} </p>

                                                    <div class="form-row">
                                                        <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Công ty đã làm
                                                                việc </label>
                                                            <input type="text" name='experience[{{ $id_ex }}][company]'
                                                                   id="txtMajorContent" class="requiredbox form-control"
                                                                   value="{{ isset($exper->company) ? $exper->company : '' }}"
                                                                   placeholder="Ví dụ: Công ty cổ phần sắc màu">

                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Thời gian bắt đầu làm việc
                                                                - <i>tính theo năm</i> </label>
                                                            <input type="year"
                                                                   name='experience[{{ $id_ex }}][star_working_time]'
                                                                   class="form-control" id="inputZip"
                                                                   placeholder="Ví dụ: 2015"
                                                                   value="{{ isset($exper->star_working_time	) ? $exper->star_working_time : '' }}">
                                                        </div>
                                                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính
                                                                    theo năm</i> </label>
                                                            <input type="year"
                                                                   name='experience[{{ $id_ex }}][end_working_time]'
                                                                   class="form-control" id="inputZip"
                                                                   placeholder="Ví dụ:  2016"
                                                                   value="{{ isset($exper->end_working_time	) ? $exper->end_working_time	 : '' }}">
                                                        </div>
                                                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Vị trí công việc </label>
                                                            <input type="text" name='experience[{{ $id_ex }}][position]'
                                                                   id="txtMajorContent" class="requiredbox form-control"
                                                                   value="{{ isset($exper->position) ? $exper->position : '' }}"
                                                                   placeholder="Ví dụ: Du lịch">
                                                        </div>

                                                    </div>


                                                    <div class="form-row">
                                                        <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Mô tả công việc </label>

                                                            <textarea class="w100 editor" id="editordes{{$id_ex}}"
                                                                      name="experience[{{ $id_ex }}][des_position]"
                                                                      placeholder="Ví dụ: Công việc chủ yếu về du lịch"
                                                                      rows="5">{!! isset($exper->des_position) ? $exper->des_position : '' !!}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-lg-12"
                                                             style="float: right;text-align: right;margin-right: 25px;">
                                                            <a class="deleteItem_experience"
                                                               style="    color: white;background: red;padding: 5px 14px;cursor: pointer">Xóa </a>
                                                        </div>
                                                    </div>
                                                    <hr class="bgrBlueN">
                                                </div>
                                            @endforeach


                                            <div class="form-group textRight mgt15">
                                                <a class="whiteIm bgrBlueN pd10 cursor" data-toggle="modal"
                                                   data-target="#add_experience"><i class="fas fa-plus"></i> Thêm mới
                                                    kinh nghiệm </a>
                                            </div>
                                        </div>


                                        <div class="form-row mgt20">
                                            <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5"
                                                    style="border:none">
                                                Lưu thay đổi
                                            </button>

                                        </div>
                                    @endif

                                </form>
                            </div>

                        </div>


                    </div>
                </div>


            </div>
        </div>
        {{--TAB4--}}
        <div class="tab-pane fade @if(session('suscess_course')) show active @endif" id="tab4" role="tabpanel"
             aria-labelledby="contact-tab">
            <div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">

                <p class="mgt20 mgb0 text-center">Vui lòng cập nhật công việc làm thêm để ứng viên có thể đăng kí học với bạn</p>
                <div class="content">
                    <div class="row">
                        <div class="col-md-12  mgt15">
                            <div>
                                @if(session('suscess_course'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert"
                                         style="margin-top: 15px;width: 100%">
                                        <strong>{{ session('suscess_course') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter blueN sm-w100 sm-mgt20">
                                    Công việc làm thêm
                                </div>
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                            </div>
                            <div class="col-xl-12 col-lg-12 left">
                                <div class="content">

                                    @if(!empty($errors->all()))
                                        @foreach($errors->all() as $erorr)
                                            <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                        @endforeach
                                    @endif

                                    @if(empty($course))
                                        <form role="form" action="{{ route('store_Course_Teacher') }}" method="POST" class="" enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            {{ method_field('POST') }}
                                            @else
                                                <form role="form" action="{{ route('update_Course_Teacher') }}" method="POST" class="" enctype="multipart/form-data">
                                                    {!! csrf_field() !!}
                                                    {{ method_field('POST') }}
                                                    @endif
                                                    <div class="form-group mgt15">
                                                        <label for="exampleInputEmail1">Tên công việc làm thêm</label>
                                                        <input type="text" class="form-control" name="course_name" placeholder="Tên công việc làm thêm" value="{{ isset($course->course_name) ? $course->course_name : '' }}" >
                                                    </div>
                                                    <div class="form-group mgt15">
                                                        <label for="exampleInputEmail1">Thời gian công việc làm thêm</label>
                                                        <input type="text" class="form-control" name="course_time" placeholder="Thời gian công việc làm thêm" value="{{ isset($course->course_time) ? $course->course_time : '' }}" >
                                                    </div>

                                                    <div class="form-group Giá công việc làm thêm">
                                                        <label for="exampleInputEmail1">Giá công việc làm thêm ( đ )</label>
                                                        <input type="text" class="form-control formatPrice" name="course_price" placeholder="0" min="1"  value="{{ isset($course->course_price) ? $course->course_price : '' }}">
                                                    </div>
                                                    <script>
                                                        $('.formatPrice').priceFormat({
                                                            prefix: '',
                                                            centsLimit: 0,
                                                            thousandsSeparator: '.'
                                                        });
                                                    </script>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class=" control-label">Hình ảnh<span class="clred">(*)</span></label>
                                                        <div class="">

                                                            <div id="uploadImage2" style="display: inline-block">

                                                                <img src="{{ isset($course->course_image) ? $course->course_image : '' }}" class="thumbnail" style="width: 70px">
                                                                <input type="hidden" value="{{ isset($course->course_image) ? $course->course_image : '' }}" name="images"  />
                                                            </div>

                                                            <div style="display: inline-block;align-items: center; ">
                                                                <button class="btnOrange addAvatar2" style="height: 35px;line-height: 15px;;margin-left: 10px;">
                                                                    Chọn ảnh mô tả
                                                                </button></div>

                                                            <input type='file' id="imgInp2" accept="image/*" onchange="readURL2(this)" style="display: none" />


                                                            <script>
                                                                function readURL2(input) {
                                                                    $('#uploadImage2').empty();
                                                                    if (input.files && input.files[0]) {
                                                                        for(var i = 0; i< input.files.length; i++)
                                                                        {
                                                                            var file = input.files[i];
                                                                            var picReader = new FileReader();
                                                                            picReader.addEventListener("load",function(event){
                                                                                var picFile = event.target;
                                                                                $('#uploadImage2').append("<img class='thumbnail' src='" + picFile.result + "'" +
                                                                                    "title='" + picFile.name + "' width='70' style='float: left' />");
                                                                                $('#uploadImage2').append('<input type="hidden" value="'+ picFile.result +'" name="images" />');
                                                                            });
                                                                            //Read the image
                                                                            picReader.readAsDataURL(file);
                                                                        }
                                                                    }
                                                                }
                                                                $('.addAvatar2').click(function() {
                                                                    $('#imgInp2').click();
                                                                    return false;
                                                                });
                                                            </script>

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Giới thiệu công việc làm thêm</label>

                                                        <textarea name="course_intro" class="w-100" id="" rows="5" cols="80">{{ isset($course->course_intro) ? $course->course_intro : '' }}</textarea>

                                                        {{--<textarea id="txtNote" name="content" rows="6" class="textarea col-12 bdLightGray radius5"></textarea>--}}
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Mô tả công việc làm thêm</label>
                                                        <textarea name="course_content" class="editor" id="editor3" rows="10" cols="80">{!!  isset($course->course_content) ? $course->course_content : '' !!}</textarea>
                                                        {{--<textarea id="txtNote" name="content" rows="6" class="textarea col-12 bdLightGray radius5"></textarea>--}}
                                                    </div>


                                                    <div class="form-group">
                                                        <!-- Google reCaptcha -->
                                                        <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{{ '6Le9trIUAAAAALrCbKEVd_fFCOjZm13bNMk9DmZP'  }}"></div>
                                                        <!-- End Google reCaptcha -->
                                                    </div>




                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary btnOrange">Lưu thay đổi </button>
                                                    </div>
                                                </form>



                                                <script type="text/javascript">
                                                    $(document).ready(function() {
                                                        $('.select2').select2({
                                                            placeholder: "Chọn ngành nghề",
                                                            allowClear: true
                                                        });
                                                    });
                                                </script>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>


            </div>
        </div>


    </div>
</div>
{{--modal  trinh do ung vien--}}
<div class="modal fade bd-example-modal-xl" id="add_specialize" tabindex="-1" role="dialog"
     aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('store_Specialize_Teacher') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm mới trình độ ứng viên</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-row mgt20">
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Thời gian bắt đầu học - <i>tính theo năm</i> </label>
                            <input type="text" name='star_specialize_time' class="form-control" id="inputZip"
                                   placeholder="Ví dụ: 2015">
                        </div>
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính theo năm</i> </label>
                            <input type="text" name='end_specialize_time' class="form-control" id="inputZip"
                                   placeholder="Ví dụ:  2016">
                        </div>

                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Tên trường </label>
                            <input type="text" name='school' class="form-control" id="inputZip"
                                   placeholder="Ví dụ: Đại học kinh tế TPHCM">
                        </div>
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Trình độ </label>
                            <select name='leve' id="ddlQualificationType" class="selectbox requiredbox form-control">
                                <option value="0">-- Chọn Bằng cấp --</option>
                                @foreach(\App\Entity\Literacy::get() as $literacy)
                                    <option value="{{$literacy->literacy_id}}"
                                            {{ $literacy->literacy_id === old('literacy') && !isset($teacher->literacy)  ? 'selected' : ''}}
                                            {{ isset($teacher->literacy) && ($teacher->literacy == $literacy->literacy_id) ? 'selected' : ''}}
                                    >{{$literacy->literacy_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Ngành học </label>
                            <input type="text" name='majors' id="txtMajorContent" class="requiredbox form-control"
                                   value="" placeholder="Ví dụ: Quản trị kinh doanh">

                        </div>
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Tình trạng </label>
                            <input type="text" id="txtCertificate" name='specialize_status'
                                   class="requiredbox form-control" value=""
                                   placeholder="Ví dụ: Đã tốt nghiệp hoặc chưa tốt nghiệp">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary bgorang" style="border-color: orange">Lưu lại</button>
                </div>

            </div>
        </form>
    </div>
</div>

{{--kinh nghiem ung vien--}}
<div class="modal fade bd-example-modal-xl" id="add_experience" tabindex="-1" role="dialog"
     aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('store_Experience_Teacher') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm mới kinh nghiệm làm việc</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-row mgt20">
                        <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Tên công ty đã làm việc </label>
                            <input type="text" name='company' class="form-control" id="inputZip"
                                   placeholder="Ví dụ: Công ty cổ phần sắc màu Việt Nam">
                        </div>
                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Thời gian bắt làm việc - <i>tính theo năm</i> </label>
                            <input type="text" name='star_working_time' class="form-control" id="inputZip"
                                   placeholder="Ví dụ: 2015">
                        </div>
                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính theo năm</i> </label>
                            <input type="text" name='end_working_time' class="form-control" id="inputZip"
                                   placeholder="Ví dụ:  2016">
                        </div>


                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Vị trí công việc </label>
                            <input type="text" name='position' class="form-control" id="inputZip"
                                   placeholder="Ví dụ: Du lịch">
                        </div>
                        <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Mô tả công việc </label>

                            <textarea name="des_position" id="editor2" rows="5" cols="100"
                                      class="w100 form-control editor "
                                      style="width: 100%"></textarea>


                        </div>


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary bgorang" style="border-color: orange">Lưu lại</button>
                </div>

            </div>
        </form>
    </div>
</div>
<script>
    $('.deleteItem').click(function () {
        var success_remove = '';
        success_remove = confirm("Bạn có muốn xóa thời gian này không !");
        if (success_remove) {
            $(this).parent().parent().parent().remove();
        }

    });
    $('.deleteItem_experience').click(function () {
        var success_remove = '';
        success_remove = confirm("Bạn có muốn xóa  thời gian này không !");
        if (success_remove) {
            $(this).parent().parent().parent().remove();
        }

    });
</script>



<style>
    section.UTN .cvbox {
        display: block;
        overflow: hidden;
        background: #fff;
        padding: 10px
    }

    section.UTN .cvleft {
        float: left;
        overflow: hidden;
        width: 70%
    }

    section.UTN .title {
        display: block;
        overflow: hidden;
        padding: 0 0 15px;
        font-size: 16px;
        color: #333;
        line-height: 25px;
        text-align: center
    }

    section.UTN .infotext {
        display: block;
        height: 1px;
        background: #ccc;
        position: relative;
        margin: 20px 0
    }
    section.UTN .selectbox{
        font-size: 12px;
    }
    section.UTN .infotext span {
        display: block;
        overflow: hidden;
        padding: 10px 15px;
        font-size: 19px;
        color: #802390;
        font-weight: bold;
        line-height: 32px;
        position: absolute;
        width: 300px;
        text-align: center;
        margin: -26px auto 0;
        background: #fff;
        left: 30%
    }

    section.UTN .cvrow {
        display: block;
        overflow: hidden;
        margin-bottom: 10px
    }

    section.UTN .cvrow input[type="text"],
    section.UTN .cvrow input[type="number"],
    section.UTN .cvrow input[type="password"],
    section.UTN .cvrow input[type="email"] {
        display: block;
        padding: 10px 0;
        border: 1px solid #ddd;
        font-size: 14px;
        color: #444;
        width: 95%;
        text-indent: 10px;
        border-radius: 4px
    }

    section.UTN .cvrow input[type="radio"] {
        display: inline-block;
        vertical-align: middle;
        width: 16px;
        height: 16px;
        border: 1px solid #ddd;
        background: #fff
    }

    section.UTN .cvrow label {
        display: inline-block;
        font-size: 14px;
        color: #333;
        margin-right: 10px;
        vertical-align: middle;
        cursor: pointer;
        margin-bottom: 0;
    }

    section.UTN .cvrow span {
        color: #d0021b;
        font-size: 16px
    }

    section.UTN .cvrow .texterror {
        display: none;
        clear: both;
        overflow: hidden;
        font-size: 14px;
        color: #f00;
        padding: 5px 0
    }

    section.UTN .text {
        display: block;
        overflow: hidden;
        font-size: 14px;
        padding: 5px 0;
        font-weight: 600
    }

    section.UTN .inline {
        display: inline-block;
        margin-right: 5px;
        vertical-align: middle;
        padding: 10px 0
    }

    section.UTN .cvrow input.date {
        width: 63%;
        display: inline-block;
        vertical-align: middle
    }

    section.UTN .four {
        display: inline-block;
        vertical-align: top;
        width: 40%
    }

    section.UTN .fifty {
        display: inline-block;
        width: 48.4%;
        vertical-align: top
    }

    section.UTN .six {
        display: inline-block;
        vertical-align: top;
        width: 58%
    }

    section.UTN .thirty {
        display: inline-block;
        width: 31.5%;
        vertical-align: top
    }

    section.UTN .error input {
        border-color: #f00 !important
    }

    section.UTN .error .texterror {
        display: inline-block
    }

    section.UTN .savecv {
        display: block;
        overflow: hidden;
        padding: 15px 0;
        text-align: center;
        width: 150px;
        background: #80239e;
        font-size: 16px;
        font-weight: 600;
        margin: 10px auto;
        color: #fff
    }

    section.UTN .cvright {
        float: right;
        overflow: hidden;
        width: 30%
    }

    section.UTN .textpic {
        display: block;
        overflow: hidden;
        text-align: center;
        font-size: 18px;
        line-height: 26px;
        margin-bottom: 15px
    }

    section.UTN .camera {
        display: block;
        overflow: hidden
    }

    section.UTN .camera img {
        display: block;
        width: 100%;
        height: auto;
        max-width: 143px;
        margin: auto;
        cursor: pointer
    }

    section.UTN .yourpic {
        display: block;
        overflow: hidden
    }

    section.UTN .yourpic img {
        display: block;
        width: 100%;
        height: auto;
        max-width: 143px;
        margin: auto
    }

    section.UTN .ortext {
        display: block;
        overflow: hidden;
        font-size: 12px;
        text-align: center;
        padding: 10px 0
    }

    section.UTN .ortext input {
        visibility: hidden
    }

    section.UTN .inputfile {
        width: .1px;
        height: .1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1
    }

    section.UTN .inputfile-1+label {
        color: #fff;
        background-color: #39d2b4
    }

    section.UTN .inputfile+label {
        max-width: 80%;
        font-size: 14px;
        text-overflow: ellipsis;
        white-space: nowrap;
        cursor: pointer;
        display: inline-block;
        overflow: hidden;
        padding: 8px;
        margin: 10px 0
    }

    section.UTN .inputfile+label svg {
        width: 1em;
        height: 1em;
        vertical-align: middle;
        fill: currentColor;
        margin-top: -.25em;
        margin-right: .25em
    }

    section.UTN .addschool {
        float: right;
        border-radius: 4px;
        overflow: hidden;
        padding: 10px 15px 10px 25px;
        font-size: 16px;
        color: #fff;
        background: #4a90e2;
        cursor: pointer;
        position: relative;
        margin-right: 26px
    }

    section.UTN .addschool:before,
    section.UTN .addschool:after {
        content: '';
        position: absolute;
        left: 5px;
        top: 5px;
        background: #fff
    }

    section.UTN .addschool:before {
        width: 16px;
        height: 2px;
        top: 16px
    }

    section.UTN .addschool:after {
        width: 2px;
        height: 15px;
        top: 10px;
        left: 12px
    }

    section.UTN .addcompany {
        float: right;
        border-radius: 4px;
        overflow: hidden;
        padding: 10px 15px 10px 25px;
        font-size: 16px;
        color: #fff;
        background: #80239e;
        cursor: pointer;
        position: relative;
        margin-right: 26px
    }

    section.UTN .addcompany:before,
    section.UTN .addcompany:after {
        content: '';
        position: absolute;
        left: 5px;
        top: 5px;
        background: #fff
    }

    section.UTN .addcompany:before {
        width: 16px;
        height: 2px;
        top: 16px
    }

    section.UTN .addcompany:after {
        width: 2px;
        height: 15px;
        top: 10px;
        left: 12px
    }

    section.UTN .textarea {
        display: block;
        overflow: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: 96%;
        padding: 2%;
        font-size: 14px;
        color: #444;
        text-align: left;
        resize: none;
        text-indent: 0
    }

    section.UTN .roundcv {
        display: block;
        overflow: hidden
    }

    section.UTN .roundcv li {
        display: block;
        padding: 0;
        background: #fff;
        position: relative;
        margin-top: 15px;
        overflow: hidden;
        border-radius: 5px
    }

    section.UTN .roundcv li div {
        display: block;
        color: #1e0afe;
        overflow: visible;
        padding: 15px 10px;
        font-size: 24px
    }

    section.UTN .roundcv li div img {
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
        width: 50px;
        height: 50px;
        border-radius: 50px;
        box-shadow: 0 3px 0 1px rgba(0, 0, 0, .2)
    }

    section.UTN .roundcv li a {
        display: block;
        overflow: hidden
    }

    section.UTN .roundcv li span {
        display: block;
        height: 52px;
        background: #802390;
        position: relative
    }

    section.UTN .roundcv li span b {
        font-size: 22px;
        color: #fff;
        text-align: center;
        display: block;
        margin: auto;
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        transform: translateY(-50%)
    }

    section.UTN .sample {
        display: block;
        overflow: hidden;
        padding: 15px 0;
        color: #fff;
        font-size: 18px;
        text-align: center;
        background: #802390;
        margin-top: 15px
    }

    section.UTN .sample:hover {
        background: #288ad6
    }

    section.UTN .notex {
        display: inline-block;
        overflow: hidden;
        font-size: 10px;
        color: #d0021b;
        vertical-align: middle;
        font-weight: 300
    }
    section.UTN .notey {
        display: inline-block;
        overflow: hidden;
        font-size: 12px;
        color: #d0021b;
        vertical-align: middle;
        font-weight: 300;
    }
    @media screen and (max-width:1200px) {
        section.UTN .cvrow label {
            margin-right: 8px
        }
        section.UTN .inline {
            margin-right: 0
        }
        section.UTN .cvrow input.date {
            width: 60%;
            font-size: 12px
        }
        section.UTN .cvrow,
        section.UTN .text,
        section.UTN .textarea {
            font-size: 13px
        }
        section.UTN .cvrow input[type="text"],
        section.UTN .cvrow input[type="number"],
        section.UTN .cvrow input[type="password"],
        section.UTN .cvrow input[type="email"] {
            font-size: 13px
        }
        section.UTN .roundcv li div {
            font-size: 22px
        }
    }

    section.UTN #camera-main {
        position: absolute;
        z-index: 999;
        display: none
    }

    section.UTN .livecam-html5 video {
        width: 400px;
        height: 300px
    }

    section.UTN #camera-wrap {
        margin: 0 auto;
        background: #f1f1f2;
        width: 100%;
        box-shadow: 1px 1px 8px #000
    }

    section.UTN #camera-wrap table {
        width: 100%;
        padding: 10px;
        margin: auto 0;
        text-align: center
    }

    .borderTopLeftRight5{
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
    .borderTopLeftRight10{
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .borderBotLeftRight10{
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }
</style>
