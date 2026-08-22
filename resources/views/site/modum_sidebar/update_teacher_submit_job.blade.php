
<div class="CV bgrWhite radius5 pd20  mgb20 pdb5 UpdateUserTab">
    <p class="text-center clorange">Kiểm tra lại thông tin hồ sơ rồi ứng tuyển ngay công việc này </p>

        <p class="text-center clorange">Vui lòng cập nhật thêm trình độ và kinh nghiêm làm việc của bạn để nhà tuyển dụng biết rõ được năng lực của bạn</p>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if(session('suscess')) active @endif @if(!session('suscess_specialize') and !session('suscess_experience')) active @endif" id="home-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true">Thông tin giáo viên</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(session('suscess_specialize'))active @endif" id="profile-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="profile" aria-selected="false">Trình độ chuyên môn</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(session('suscess_experience'))active @endif" id="contact-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="contact" aria-selected="false">Kinh nghiệm làm việc</a>
        </li>
    </ul>
    {{--TAB1--}}
    <div class="tab-content " id="myTabContent">
        <div class="tab-pane fade @if(session('suscess')) show active @endif  @if(!session('suscess_specialize') and !session('suscess_experience')) show active @endif " id="tab1" role="tabpanel" aria-labelledby="home-tab">
            <div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                <div class="content">
                    <div class="row">
                        <div class="col-md-12  mgt15">

                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 sm-w100 textCenter blueN ">Thông tin giáo viên</div>
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
                                <form action="{{ route('updateTeacherSubmit') }}" method="post" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6">Tên giáo viên : </label>
                                            <input type="text" class="form-control" id="inputName" placeholder="Nhập tên giáo viên"
                                                   name="teacher_name"
                                                   value="{{  isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6">Ngày sinh : </label>
                                            <input type="date" class="form-control" id="inputName" placeholder="Ngày sinh"
                                                   name="birthday"
                                                   value="{{ isset($teacher->birthday) ? $teacher->birthday : '' }}">

                                        </div>

                                    </div>
                                    <div class="form-row mgt20">
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6">Nhập số điện thoại : </label>
                                            <input type="number" class="form-control" id="inputName"
                                                   placeholder="Nhập số điện thoại"
                                                   name="teacher_phone" value="{{ isset($teacher->teacher_phone) ? $teacher->teacher_phone : '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6">Email <i style="font-weight: 500">(Tài khoản đăng nhập )</i></label>
                                            <input type="email" class="form-control" id="inputName" placeholder="Nhập Email"
                                                   name="teacher_email" value="{{ isset($teacher->teacher_email) ? $teacher->teacher_email : $user->email }}" readonly>
                                        </div>
                                    </div>

                                    <div class="form-row mgt20 gruopRadio">
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6" style="display: block;">Giới tính: </label>
                                            <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                <input class="form-check-input" type="radio" name="gender" id="exampleRadios2"
                                                       value="1" @if($teacher->gender == 1) checked @endif>
                                                <label class="form-check-label" for="exampleRadios2">
                                                    Nữ
                                                </label>
                                            </div>
                                            <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                <input class="form-check-input" type="radio" name="gender" id="exampleRadios3"
                                                       value="2" @if($teacher->gender == 2) checked @endif>
                                                <label class="form-check-label" for="exampleRadios3">
                                                    Nam
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6">Hình ảnh giáo viên : </label>
                                            <div class="">
                                                <div id="uploadImage" style="display: inline-block;vertical-align: bottom;">

                                                    <img src="{{ isset($teacher->teacher_images) ? $teacher->teacher_images : '' }}"
                                                         class="thumbnail" style="width: 70px">
                                                    <input type="hidden"
                                                           value="{{ isset($teacher->teacher_images) ? $teacher->teacher_images : '' }}"
                                                           name="images"/>
                                                </div>

                                                <div style="display: inline-block;align-items: center; ">
                                                    <button class="btnOrange addAvatar"
                                                            style="height: 35px;line-height: 15px;;margin-left: 10px;">Chọn ảnh mô
                                                        tả
                                                    </button>
                                                </div>

                                                <input type='file' id="imgInp" accept="image/*" onchange="readURL(this)"
                                                       style="display: none" multiple/>


                                                <script>
                                                    function readURL(input) {
                                                        $('#uploadImage').empty();
                                                        if (input.files && input.files[0]) {
                                                            for (var i = 0; i < input.files.length; i++) {
                                                                var file = input.files[i];
                                                                var picReader = new FileReader();
                                                                picReader.addEventListener("load", function (event) {
                                                                    var picFile = event.target;
                                                                    $('#uploadImage').append("<img class='thumbnail' src='" + picFile.result + "'" +
                                                                        "title='" + picFile.name + "' width='70' style='float: left' />");
                                                                    $('#uploadImage').append('<input type="hidden" value="' + picFile.result + '" name="images" />');
                                                                });
                                                                //Read the image
                                                                picReader.readAsDataURL(file);
                                                            }
                                                        }
                                                    }

                                                    $('.addAvatar').click(function () {
                                                        $('#imgInp').click();
                                                        return false;
                                                    });
                                                </script>

                                                {{--,--}}

                                            </div>
                                        </div>

                                    </div>



                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="inputAddress2" class="fw6">Địa chỉ giáo viên <i style="font-weight: 500"></i></label>
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
                                                <select class="form-control select2 " name="district" aria-label="Quận/Huyện"
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
                                            <label for="exampleInputEmail1">Công việc yêu thích </label>
                                            <select class="form-control select2" name="career_category_id" aria-label="Quận/Huyện"
                                                    id="">
                                                <?php $careers = \App\Entity\Career::getAllCareer(); ?>
                                                <option value="" selected>-- Chọn ngành nghề --</option>
                                                @foreach($careers as $career)
                                                    <option value="{{$career->career_category_id }}"
                                                            @if($teacher->career_category_id == $career->career_category_id) selected @endif
                                                    >{{$career->career_category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group mgt20">
                                        <label for="inputAddress2" class="fw6">Giới thiệu về bản thân :</label>
                                        <textarea name="information_verifier" id="editor1" rows="5" cols="100"
                                                  class="w100 form-control editor"
                                                  style="width: 100%">{!!   isset($teacher->information_verifier) ? $teacher->information_verifier : ''  !!}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <!-- Google reCaptcha -->
                                        <div class="g-recaptcha" id="feedback-recaptcha"
                                             data-sitekey="{{ '6Le9trIUAAAAALrCbKEVd_fFCOjZm13bNMk9DmZP' }}"></div>
                                        <!-- End Google reCaptcha -->

                                        <input type="hidden" name="id_job_fb" value="{{ $id_job_fb }}"/>
                                        <input type="hidden" name="status_job" value="{{ $status_job }}"/>
                                    </div>
                                    <div class="form-row mgt20">
                                        <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5" style="border:none">
                                            Ứng tuyển ngay
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
        <div class="tab-pane fade @if(session('suscess_specialize')) show active @endif" id="tab2" role="tabpanel" aria-labelledby="profile-tab"><div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                <div class="content">
                    <div class="row">
                        <div class="col-md-12  mgt15">
                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter blueN sm-w100 sm-mgt20">Trình độ chuyên môn</div>
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                            </div>

                            <div class="col-xl-12 col-lg-12 left">
                                <form action="{{ route('update_Specialize_Teacher') }}" method="post" enctype="multipart/form-data">
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
                                                    <p class="clorange f18" style="font-weight: bold;margin-bottom: 10px;">Thời gian : {{ isset($spec->star_specialize_time) ? $spec->star_specialize_time : '' }} - {{ isset($spec->end_specialize_time) ? $spec->end_specialize_time : '' }} </p>

                                                    <div class="form-row mgt20">
                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Thời gian bắt đầu học - <i>tính theo năm</i> </label>
                                                            <input type="year" name='specialize[{{ $id }}][star_specialize_time]' class="form-control" id="inputZip" placeholder="Ví dụ: 2015" value="{{ isset($spec->star_specialize_time) ? $spec->star_specialize_time : '' }}">
                                                        </div>
                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính theo năm</i> </label>
                                                            <input type="year" name='specialize[{{ $id }}][end_specialize_time]' class="form-control" id="inputZip" placeholder="Ví dụ:  2016" value="{{ isset($spec->end_specialize_time) ? $spec->end_specialize_time : '' }}">
                                                        </div>

                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Tên trường </label>
                                                            <input type="text" name='specialize[{{ $id }}][school]' class="form-control" id="inputZip" placeholder="Ví dụ: Đại học kinh tế TPHCM" value="{{ isset($spec->school) ? $spec->school : '' }}">
                                                        </div>
                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Trình độ </label>
                                                            <select  name='specialize[{{ $id }}][leve]' id="ddlQualificationType"  class="selectbox requiredbox form-control">
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
                                                            <input type="text" name='specialize[{{ $id }}][majors]' id="txtMajorContent" class="requiredbox form-control" value="{{ isset($spec->majors) ? $spec->majors : '' }}" placeholder="Ví dụ: Quản trị kinh doanh" >

                                                        </div>
                                                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Tình trạng </label>
                                                            <input type="text" id="txtCertificate" name='specialize[{{ $id }}][specialize_status]' class="requiredbox form-control" value="{{ isset($spec->specialize_status) ? $spec->specialize_status : '' }}" placeholder="Ví dụ: Đã tốt nghiệp hoặc chưa tốt nghiệp">
                                                        </div>
                                                        <div class="col-lg-12" style="float: right;text-align: right;padding-right: 25px;">
                                                            <a class="deleteItem" style="    color: white;background: red;padding: 5px 14px;cursor: pointer;" >Xóa</a>
                                                        </div>
                                                    </div>
                                                    <hr class="bgrBlueN">
                                                </div>
                                            @endforeach


                                            <div class="form-group textRight mgt15">
                                                <a class="whiteIm bgrBlueN pd10 cursor" data-toggle="modal" data-target="#add_specialize"><i class="fas fa-plus"></i> Thêm trình độ </a>
                                            </div>
                                        </div>


                                        <div class="form-row mgt20">
                                            <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5" style="border:none">
                                                Lưu thay đổi
                                            </button>

                                        </div>
                                    @endif

                                </form>
                            </div>

                        </div>


                    </div>
                </div>
            </div></div>
        {{--TAB3--}}
        <div class="tab-pane fade @if(session('suscess_experience')) show active @endif" id="tab3" role="tabpanel" aria-labelledby="contact-tab"><div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                <div class="content">
                    <div class="row">
                        <div class="col-md-12  mgt15">
                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter blueN sm-w100 sm-mgt20">Kinh nghiệm làm việc</div>
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                            </div>
                            <div class="col-xl-12 col-lg-12 left">
                                <form action="{{ route('update_Experience_Teacher') }}" method="post" enctype="multipart/form-data">
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
                                                    <p class="clorange f18" style="font-weight: bold;margin-bottom: 10px;">Thời gian : {{ isset($exper->star_working_time) ? $exper->star_working_time : '' }} - {{ isset($exper->end_working_time) ? $exper->end_working_time : '' }} </p>

                                                    <div class="form-row">
                                                        <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Công ty đã làm việc </label>
                                                            <input type="text" name='experience[{{ $id_ex }}][company]' id="txtMajorContent" class="requiredbox form-control" value="{{ isset($exper->company) ? $exper->company : '' }}" placeholder="Ví dụ: Công ty cổ phần sắc màu" >

                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Thời gian bắt đầu làm việc - <i>tính theo năm</i> </label>
                                                            <input type="year" name='experience[{{ $id_ex }}][star_working_time]' class="form-control" id="inputZip" placeholder="Ví dụ: 2015" value="{{ isset($exper->star_working_time	) ? $exper->star_working_time : '' }}">
                                                        </div>
                                                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính theo năm</i> </label>
                                                            <input type="year" name='experience[{{ $id_ex }}][end_working_time]' class="form-control" id="inputZip" placeholder="Ví dụ:  2016" value="{{ isset($exper->end_working_time	) ? $exper->end_working_time	 : '' }}">
                                                        </div>
                                                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Vị trí công việc </label>
                                                            <input type="text" name='experience[{{ $id_ex }}][position]' id="txtMajorContent" class="requiredbox form-control" value="{{ isset($exper->position) ? $exper->position : '' }}" placeholder="Ví dụ: Du lịch" >
                                                        </div>

                                                    </div>


                                                    <div class="form-row">
                                                        <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                                            <label for="inputZip" class="fw6">Mô tả công việc </label>

                                                            <textarea class="w100 editor" id="editordes{{ $id_ex }}" name="experience[{{ $id_ex }}][des_position]" placeholder="Ví dụ: Công việc chủ yếu về du lịch" rows="5"> {!! isset($exper->des_position) ? $exper->des_position : '' !!}  </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-lg-12" style="float: right;text-align: right;margin-right: 25px;">
                                                            <a class="deleteItem_experience" style="    color: white;background: red;padding: 5px 14px;cursor: pointer" >Xóa </a>
                                                        </div>
                                                    </div>
                                                    <hr class="bgrBlueN">
                                                </div>
                                            @endforeach


                                            <div class="form-group textRight mgt15">
                                                <a class="whiteIm bgrBlueN pd10 cursor" data-toggle="modal" data-target="#add_experience"><i class="fas fa-plus"></i> Thêm mới kinh nghiệm </a>
                                            </div>
                                        </div>


                                        <div class="form-row mgt20">
                                            <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5" style="border:none">
                                                Lưu thay đổi
                                            </button>

                                        </div>
                                    @endif

                                </form>
                            </div>

                        </div>


                    </div>
                </div>



            </div></div>



    </div>
</div>
{{--modal  trinh do ung vien--}}
<div class="modal fade bd-example-modal-xl" id="add_specialize" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
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
                            <input type="text" name='star_specialize_time' class="form-control" id="inputZip" placeholder="Ví dụ: 2015">
                        </div>
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính theo năm</i> </label>
                            <input type="text" name='end_specialize_time' class="form-control" id="inputZip" placeholder="Ví dụ:  2016">
                        </div>

                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Tên trường </label>
                            <input type="text" name='school' class="form-control" id="inputZip" placeholder="Ví dụ: Đại học kinh tế TPHCM">
                        </div>
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Trình độ </label>
                            <select  name='leve' id="ddlQualificationType"  class="selectbox requiredbox form-control">
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
                            <input type="text" name='majors' id="txtMajorContent" class="requiredbox form-control" value="" placeholder="Ví dụ: Quản trị kinh doanh">

                        </div>
                        <div class="form-group col-lg-6 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Tình trạng </label>
                            <input type="text" id="txtCertificate" name='specialize_status' class="requiredbox form-control" value="" placeholder="Ví dụ: Đã tốt nghiệp hoặc chưa tốt nghiệp">
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
<div class="modal fade bd-example-modal-xl" id="add_experience" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
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
                            <input type="text" name='company' class="form-control" id="inputZip" placeholder="Ví dụ: Công ty cổ phần sắc màu Việt Nam">
                        </div>
                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Thời gian bắt làm việc - <i>tính theo năm</i> </label>
                            <input type="text" name='star_working_time' class="form-control" id="inputZip" placeholder="Ví dụ: 2015">
                        </div>
                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Thời gian kết thúc - <i>tính theo năm</i> </label>
                            <input type="text" name='end_working_time' class="form-control" id="inputZip" placeholder="Ví dụ:  2016">
                        </div>


                        <div class="form-group col-lg-4 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Vị trí công việc </label>
                            <input type="text" name='position' class="form-control" id="inputZip" placeholder="Ví dụ: Du lịch">
                        </div>
                        <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                            <label for="inputZip" class="fw6">Mô tả công việc </label>

                            <textarea name="information_verifier" id="editor2" rows="5" cols="100"
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
        if(success_remove)
        {
            $(this).parent().parent().parent().remove();
        }

    });
    $('.deleteItem_experience').click(function () {
        var success_remove = '';
        success_remove = confirm("Bạn có muốn xóa  thời gian này không !");
        if(success_remove)
        {
            $(this).parent().parent().parent().remove();
        }

    });
</script>


