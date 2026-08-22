<style>


</style>
<div class="CV bgrWhite radius5 pd20  mgb20 pdb5 UpdateUserTab">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if(session('suscess')) active @endif @if(!session('suscess_specialize') and !session('suscess_experience')) active @endif" id="home-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true">Thông tin giáo viên</a>
        </li>

    </ul>
    {{--TAB1--}}
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade @if(session('suscess')) show active @endif  @if(!session('suscess_specialize') and !session('suscess_experience')) show active @endif " id="tab1" role="tabpanel" aria-labelledby="home-tab">
            <div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                <div class="content">
                    <div class="row">
                        <div class="col-md-12  mgt15">

                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 sm-w100 textCenter clred ">Thông tin giáo viên</div>
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                            </div>

                            <div class="col-xl-12 col-lg-12 left">

                                <div class="form-group mgb0">
                                    <div class="" style="margin: 10px 0">
                                        <label for="inputAddress2" class="fw6" style="display: inline-block;">Avatar:  <span
                                                    class="clhome">

                                                </span></label>
                                        <img src="{{ isset($teacher->teacher_images) ? $teacher->teacher_images : asset('/CV/Profile.jpg') }}"
                                             class="thumbnail" style="width: 100px;display: inline-block">
                                    </div>
                                </div>
                                <div class="form-group mgb0">
                                    <label for="inputAddress2" class="fw6">Tên giáo viên : <span
                                                class="clhome">{{ isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}</span></label>
                                </div>
                                <div class="form-row  gruopRadio">
                                    <div class="col-md-12">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Giới tính:  <span
                                                    class="clhome">@if($teacher->gender == 0)
                                                    Không xác định
                                                @endif
                                                @if($teacher->gender == 1)
                                                    Nữ
                                                @endif
                                                @if($teacher->gender == 2)
                                                    Nam
                                                @endif
                                                </span></label>
                                    </div>

                                </div>
                                <div class="form-row  gruopRadio">
                                    <div class="col-md-6">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Số điện thoại:  <span
                                                    class="clhome">
                                                {{ isset($teacher->teacher_phone) ? $teacher->teacher_phone : '' }}
                                                </span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Email liên hệ:  <span
                                                    class="clhome">
                                                {{ isset($teacher->teacher_email) ? $teacher->teacher_email : '' }}
                                                </span></label>
                                    </div>
                                </div>
                                <div class="form-row  gruopRadio">
                                    <div class="col-md-6">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Ngày sinh:  <span
                                                    class="clhome">
                                                <?php
                                                $date=date_create($teacher->birthday);
                                                echo date_format($date,"d/m/Y");
                                                ?>
                                                </span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Tuổi:  <span
                                                    class="clhome">
                                                    <?php
                                                $date_year = getdate();
                                                $age = $date_year['year'] - date_format($date,"Y");
                                                echo $age;
                                                ?>
                                                </span></label>
                                    </div>
                                </div>







                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="inputAddress2" class="fw6">Địa chỉ ứng viên :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="">
                                            <label for="exampleInputEmail1" class="fw6">Tỉnh/Thành phố :
                                                <span class="clhome">
                                                        @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                        @if($teacher->province == $province->province_id) {{$province->province_name}} @endif
                                                    @endforeach
                                                    </span>
                                            </label>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="">
                                            <label for="exampleInputEmail1" class="fw6">Quận/Huyện :
                                                <span class="clhome">
                                                        @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                        @if($teacher->district == $district->district_id) {{$district->district_name}} @endif
                                                    @endforeach
                                                    </span>
                                            </label>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="">
                                            <label for="exampleInputEmail1" class="fw6">Địa chỉ cụ thể :
                                                <span class="clhome">{{ isset($teacher->address) ? $teacher->address : '' }}</span>
                                            </label>

                                        </div>
                                    </div>


                                </div>
                                <div class="form-row  gruopRadio">

                                    <div class="col-md-12">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Công việc yêu thích:  <span
                                                    class="clhome">
                                               <?php $careers = \App\Entity\Career::getAllCareer(); ?>
                                                @foreach($careers as $career)
                                                    @if($teacher->career_category_id == $career->career_category_id) {{$career->career_category_name}} @endif
                                                @endforeach
                                                </span></label>
                                    </div>

                                </div>
                                <div class="form-group ">
                                    <label for="inputAddress2" class="fw6">Giới thiệu về bản thân :</label>
                                    <div>
                                        {!!   isset($teacher->information_verifier) ? $teacher->information_verifier : ''  !!}
                                    </div>
                                </div>z
                            </div>

                        </div>

                        <div class="col-md-12 mgt15">
                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter clred sm-w100 sm-mgt20">Trình độ chuyên môn</div>
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                            </div>
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
                                <div class="col-xl-12 col-lg-12 left">
                                    <div class="boxSchool" id="specialize">
                                        @foreach($specialize as $id=>$spec)
                                            <div class="deleteItemSpec">
                                                <p class="clorange f18" style="font-weight: bold;margin-bottom: 10px;">Thời gian : {{ isset($spec->star_specialize_time) ? $spec->star_specialize_time : '' }} - {{ isset($spec->end_specialize_time) ? $spec->end_specialize_time : '' }} </p>

                                                <div class="form-row ">
                                                    <div class="col-lg-6 pdr2p lg-pd0Im">
                                                        <label for="inputZip" class="fw6">Tên trường : <span class="clhome">{{ isset($spec->school) ? $spec->school : '' }}</span></label>

                                                    </div>
                                                    <div class="col-lg-6 pdr2p lg-pd0Im">
                                                        <label for="inputZip" class="fw6">Trình độ : <span class="clhome">
                                                            @foreach(\App\Entity\Literacy::get() as $literacy)
                                                                    {{ isset($spec->leve) && ($spec->leve == $literacy->literacy_id) ? $literacy->literacy_name : ''}}
                                                                @endforeach
                                                        </span></label>

                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-lg-6 pdr2p lg-pd0Im">
                                                        <label for="inputZip" class="fw6">Ngành học : <span class="clhome">{{ isset($spec->majors) ? $spec->majors : '' }}</span></label>


                                                    </div>
                                                    <div class=" col-lg-6 pdr2p lg-pd0Im">
                                                        <label for="inputZip" class="fw6">Tình trạng : <span class="clhome">{{ isset($spec->specialize_status) ? $spec->specialize_status : '' }}</span></label>

                                                    </div>
                                                </div>
                                                <hr class="" style="border-top: 1px dotted #ccc">
                                            </div>
                                        @endforeach


                                    </div>


                                </div>
                            @endif

                        </div>
                        <div class="col-md-12  mgt15">
                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter  sm-w100 sm-mgt20 clred">Kinh nghiệm làm việc</div>
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                            </div>

                            <div class="col-xl-12 col-lg-12 left">


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
                                                        <label for="inputZip" class="fw6">Công ty đã làm việc :</label>
                                                        <div>
                                                            <span class="clhome fw6">{{ isset($exper->company) ? $exper->company : '' }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                                        <label for="inputZip" class="fw6">Vị trí công việc : </label>

                                                        <div>
                                                            <span class="clhome fw6">{{ isset($exper->position) ? $exper->position : '' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                                        <label for="inputZip" class="fw6">Mô tả công việc : </label>
                                                        <div>
                                                            <span class="clhome fw6">{!! isset($exper->des_position) ? $exper->des_position : '' !!}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <hr class="" style="border-top: 1px dotted #ccc">
                                            </div>
                                        @endforeach



                                    </div>

                                @endif

                            </div>
                        </div>





                    </div>
                </div>



            </div>
        </div>
        {{--TAB2--}}





    </div>
</div>



