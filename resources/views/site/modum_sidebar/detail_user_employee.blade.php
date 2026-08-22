
<style>


</style>
<?php
//tỉnh tỉ lệ hoàn thiện cv
$percent = 0;
//tinh ti le hoan thien cv
$total_comlum = 17;
$total_percent = 0;
if (!empty($employee['birthday'])) {
    $total_percent = $total_percent + 1;  //
}if (!empty($employee['employee_image'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['phone'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['province'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['district'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['address'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['career_category_id'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['salary_id'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['employee_level_id'])) {
    $total_percent = $total_percent + 1;
}if (!empty($employee['experience_id'])) {
    $total_percent = $total_percent + 1;
}if (!empty($employee['information_verifier'])) {
    $total_percent = $total_percent + 1;
}if (!empty($employee['gender'])) {
    $total_percent = $total_percent + 1; //
}if (!empty($employee['cmt'])) {
    $total_percent = $total_percent + 1;
}if (!empty($employee['cmt_date'])) {
    $total_percent = $total_percent + 1;
}if (!empty($employee['cmt_local'])) {
    $total_percent = $total_percent + 1;
}if (isset($employee['status'])) {
    $total_percent = $total_percent + 1;  //
}if (isset($employee['marry'])) {
    $total_percent = $total_percent + 1; //
}
if (!empty($employee['status_employees_experience'])) {
    $percent = $percent + 20;
}if (!empty($employee['status_employee_degree'])) {
    $percent = $percent + 20;
}
$percent_comlum = ($total_percent / $total_comlum)*60;
$total = 0;
$total = $percent_comlum + $percent;
?>
<div class="CV bgrWhite radius5 pd20  mgb20 pdb5 UpdateUserTab">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
               aria-selected="true">Thông tin ứng viên</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
               aria-selected="false">Trình độ ứng viên</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
               aria-selected="false">Kinh nghiệm ứng viên</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                <div class="content">
                    <div class="row">
                        <div class="col-md-12  mgt15">
                            <div class="row">
                                <div class=" col-md-9 pdl15 pdRight15">
                                    <div class="row">


                                        <div class="col-md-6">
                                            <p class="mgb10 mgl15"><span class="fw6"> Ngày cập nhật hồ sơ :</span>
                                                <span class="green" style="color: green">
                                                     @if(!empty($employee->updated_at))
                                                        <?php
                                                        $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->updated_at);
                                                        echo $date_facebook;
                                                        ?>
                                                    @else
                                                        <?php
                                                        $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->created_at);
                                                        echo $date_facebook;
                                                        ?>
                                                    @endif
                                                </span>
                                            </p>
                                            <p class="mgl15">
                                                <span class="fw6"> Trình độ :</span>
                                                <span class="green" style="color: green">
                                                        @if(!empty($employee->employee_level_id))
                                                        <?php
                                                        $literacy_employee = App\Entity\Literacy::getIdLi($employee->employee_level_id);
                                                        echo $literacy_employee->literacy_name;
                                                        ?>
                                                            @else
                                                            Đang cập nhật thông tin
                                                    @endif

                                                </span>

                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mgb10 mgl15"><span class="fw6"> Ngày duyệt hồ sơ :</span>
                                                <span class="green" style="color: green">
                                                     @if(!empty($employee->updated_at))
                                                        <?php
                                                        $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->updated_at);
                                                        echo $date_facebook;
                                                        ?>
                                                    @else
                                                        <?php
                                                        $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->created_at);
                                                        echo $date_facebook;
                                                        ?>
                                                    @endif
                                                </span>
                                            </p>
                                            <p class="mgl15"><span class="fw6"> Kinh nghiệm :</span>
                                                <span class="red">
                                                    @if(!empty($employee->experience_id))
                                                        <?php
                                                        $experience_employee = App\Entity\Experience::getIdEx($employee->experience_id);
                                                        echo $experience_employee->experience_name;
                                                        ?>
                                                    @else
                                                        Đang cập nhật thông tin
                                                    @endif

                                                </span></p>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3 pdl15 pdRight15 text-right">
                                    <a class="mgr15" style="color: white;;background: orange;padding: 5px 15px;">Mời ứng
                                        viên</a>
                                    <p></p>
                                    <a class="mgr15" style="color: white;;background: orange;padding: 5px 15px;">Thông
                                        tin liên hệ</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 ">
                                    <label for="inputAddress2" class="fw6 mgl15" style="display: block;">% hoàn thiện hồ sơ : </label>
                                </div>
                                <div class="col-md-10 ">
                                    <div class="progress mgr15">
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{ round($total) }}%;" aria-valuenow="{{ round($total) }}" aria-valuemin="0" aria-valuemax="100">{{ round($total) }}%</div>
                                    </div>
                                </div>
                            </div>

                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 sm-w100 textCenter clred ">Thông
                                    tin ứng viên
                                </div>
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                            </div>

                            <div class="col-xl-12 col-lg-12 left">

                                <div class="form-group mgb0">
                                    <div class="" style="margin: 10px 0">
                                        <label for="inputAddress2" class="fw6" style="display: inline-block;">Avatar:
                                            <span
                                                    class="clhome">

                                                </span></label>
                                        <img src="{{ !empty($employee['employee_image']) ? $employee['employee_image'] : '/CV/Profile.jpg' }}"
                                             class="thumbnail" style="width: 100px;display: inline-block">
                                    </div>
                                </div>
                                <div class="form-group mgb0">
                                    <label for="inputAddress2" class="fw6">Tên ứng viên : <span
                                                class="clhome">{{ isset($employee->employee_name) ? $employee->employee_name : '' }}</span></label>
                                </div>
                                <div class="form-row  gruopRadio">
                                    <div class="col-md-6">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Giới tính: <span
                                                    class="clhome">@if($employee->gender == 0)
                                                    Không xác định
                                                @endif
                                                @if($employee->gender == 1)
                                                    Nữ
                                                @endif
                                                @if($employee->gender == 2)
                                                    Nam
                                                @endif
                                                </span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Tình trạng hôn
                                            nhân:
                                            <span class="clhome">
                                                    @if($employee->marry == 0) Độc thân @endif
                                                @if($employee->marry == 1) Đã kết hôn @endif
                                                </span>
                                        </label>
                                    </div>

                                </div>
                                <div class="form-row  gruopRadio">
                                    <div class="col-md-6">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Số điện thoại:
                                            <span
                                                    class="clhome">
                                                {{ isset($employee->phone) ? $employee->phone : '' }}
                                                </span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Email liên hệ:
                                            <span
                                                    class="clhome">
                                                {{ isset($employee->email) ? $employee->email : '' }}
                                                </span></label>
                                    </div>
                                </div>
                                <div class="form-row  gruopRadio">
                                    <div class="col-md-6">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Ngày sinh: <span
                                                    class="clhome">
                                                @if(!empty($employee->birthday))
                                                    <?php
                                                    $date_birthday = date_create($employee->birthday);
                                                    echo date_format($date_birthday, "d/m/Y");
                                                    ?>
                                                @endif
                                                </span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Tuổi: <span
                                                    class="clhome">
                                                 @if(!empty($employee->birthday))
                                                    <?php
                                                    $date_year = getdate();
                                                    $age = $date_year['year'] - date_format($date_birthday, "Y");
                                                    echo $age;
                                                    ?>
                                                @endif
                                                </span></label>
                                    </div>
                                </div>


                                <div class="form-row">

                                    <div class="col-md-6">
                                        <div class="">
                                            <label for="exampleInputEmail1" class="fw6">Tỉnh/Thành phố :
                                                <span class="clhome">
                                                        @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                        @if($employee->province == $province->province_id) {{$province->province_name}} @endif
                                                    @endforeach
                                                    </span>
                                            </label>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="">
                                            <label for="exampleInputEmail1" class="fw6">Quận/Huyện :
                                                <span class="clhome">
                                                        @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                        @if($employee->district == $district->district_id) {{$district->district_name}} @endif
                                                    @endforeach
                                                    </span>
                                            </label>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="">
                                            <label for="exampleInputEmail1" class="fw6">Địa chỉ cụ thể :
                                                <span class="clhome">{{ isset($employee->address) ? $employee->address : '' }}</span>
                                            </label>

                                        </div>
                                    </div>


                                </div>

                                <div class="form-row  gruopRadio">

                                    <div class="col-md-6">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Công việc cần
                                            tìm: <span
                                                    class="clhome">
                                               <?php $careers = \App\Entity\Career::getAllCareer(); ?>
                                                @foreach($careers as $career)
                                                    @if($employee->career_category_id == $career->career_category_id) {{$career->career_category_name}} @endif
                                                @endforeach
                                                </span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Mức lương mong
                                            muốn: <span
                                                    class="clhome">

                                                <?php
                                                $salary = \App\Entity\Salary::getIdSalary($employee['salary_id'])
                                                ?>
                                                {{ isset($salary['description']) ? $salary['description'] : ''  }}
                                                </span></label>
                                    </div>

                                </div>


                                <div class="form-row  gruopRadio">
                                    <div class="col-md-4">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Chứng minh thư:
                                            <span
                                                    class="clhome">
                                                    {{ isset($employee->cmt) ? $employee->cmt : '' }}
                                                </span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Ngày cấp: <span
                                                    class="clhome">
                                                @if(!empty($employee->cmt_date))
                                                <?php
                                                $date_cmt = date_create($employee->cmt_date);
                                                echo date_format($date_cmt, "d/m/Y");
                                                ?>
                                                    @endif
                                                </span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputAddress2" class="fw6" style="display: block;">Nơi cấp: <span
                                                    class="clhome">
                                               {{ isset($employee->cmt_local) ? $employee->cmt_local : '' }}
                                                </span></label>
                                    </div>

                                </div>
                                <div class="form-group ">
                                    <label for="inputAddress2" class="fw6">Giới thiệu về bản thân :</label>
                                    <div class="InfoUser">
                                        {!!   isset($employee->information_verifier) ? $employee->information_verifier : ''  !!}
                                    </div>
                                </div>


                            </div>

                        </div>


                    </div>
                </div>


            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                <div class="content">
                    <div class="row">

                        <div class="col-md-12 mgt15">
                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter clred sm-w100 sm-mgt20">
                                    Trình độ chuyên môn
                                </div>
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
                            @if(!empty($specialize))
                                <div class="col-xl-12 col-lg-12 left">
                                    <div class="boxSchool" id="specialize">
                                        @foreach($specialize as $id=>$spec)
                                            <div class="deleteItemSpec">
                                                <p class="clorange f18" style="font-weight: bold;margin-bottom: 10px;">
                                                    Thời gian
                                                    : {{ isset($spec->star_specialize_time) ? $spec->star_specialize_time : '' }}
                                                    - {{ isset($spec->end_specialize_time) ? $spec->end_specialize_time : '' }} </p>

                                                <div class="form-row ">
                                                    <div class="col-lg-6 pdr2p lg-pd0Im">
                                                        <label for="inputZip" class="fw6">Tên trường : <span
                                                                    class="clhome">{{ isset($spec->school) ? $spec->school : '' }}</span></label>

                                                    </div>
                                                    <div class="col-lg-6 pdr2p lg-pd0Im">
                                                        <label for="inputZip" class="fw6">Trình độ : <span
                                                                    class="clhome">
                                                            @foreach(\App\Entity\Literacy::get() as $literacy)
                                                                    {{ isset($spec->leve) && ($spec->leve == $literacy->literacy_id) ? $literacy->literacy_name : ''}}
                                                                @endforeach
                                                        </span></label>

                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-lg-6 pdr2p lg-pd0Im">
                                                        <label for="inputZip" class="fw6">Ngành học : <span
                                                                    class="clhome">{{ isset($spec->majors) ? $spec->majors : '' }}</span></label>


                                                    </div>
                                                    <div class=" col-lg-6 pdr2p lg-pd0Im">
                                                        <label for="inputZip" class="fw6">Tình trạng : <span
                                                                    class="clhome">{{ isset($spec->specialize_status) ? $spec->specialize_status : '' }}</span></label>

                                                    </div>
                                                </div>
                                                <hr class="" style="border-top: 1px dotted #ccc">
                                            </div>
                                        @endforeach


                                    </div>


                                </div>
                            @endif

                        </div>

                    </div>
                </div>


            </div>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
                <div class="content">
                    <div class="row">

                        <div class="col-md-12  mgt15">
                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 inBlock disOnMobile"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 textCenter  sm-w100 sm-mgt20 clred">
                                    Kinh nghiệm làm việc
                                </div>
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
                                @if(!empty($experience))
                                    <div class="boxSchool" id="specialize">
                                        @foreach($experience as $id_ex=>$exper)
                                            <div class="deleteItemSpec">
                                                <p class="clorange f18" style="font-weight: bold;margin-bottom: 10px;">
                                                    Thời gian
                                                    : {{ isset($exper->star_working_time) ? $exper->star_working_time : '' }}
                                                    - {{ isset($exper->end_working_time) ? $exper->end_working_time : '' }} </p>


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
    </div>
</div>
@if(!empty($relate_employee))
    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20 mgb20">
        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
            Ứng viên tương tự
            {{--( {{ theo bảng thong ke so tiền }} việc làm)--}}
        </div>
        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
            <div class="row">
                @foreach($relate_employee as $relate)
                    @include('site.employee.item_employee',['employee' => $relate])
                @endforeach
            </div>
        </div>
    </section>
@endif






