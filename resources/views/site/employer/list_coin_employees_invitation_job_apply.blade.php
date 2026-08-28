@extends('site.layout.site')

@section('title', '  Mời ứng viên ứng tuyển đồng loạt')
@section('meta_description', '  Mời ứng viên ứng tuyển đồng loạt')
@section('keywords', '  Mời ứng viên ứng tuyển đồng loạt')

@section('content')
    <style>
        #timkiem .select2-container .select2-selection--single {
            border: 1px solid #ccc;
        }

        .cutTitle2 {
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            -webkit-line-clamp: 2 !important;
            display: -webkit-box !important;
            -webkit-box-orient: vertical !important;
            color: #006859;
            height: auto;
        }

        .cutTitle3 {
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            -webkit-line-clamp: 3 !important;
            display: -webkit-box !important;
            -webkit-box-orient: vertical !important;
            color: #006859;
        }
    </style>
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent createProfileOnline ">

                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs f18 white  pd10-20 col-f14">
                            <div class="link bgrWhite md-mgt20 disOnMobile">
                                <ul class="nav">
                                    <li class="nav-item pd8">
                                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang
                                            chủ</a>
                                    </li>
                                    <li class="nav-item pd8">
                                        <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                                    </li>
                                    <li class="nav-item pd8">
                                        <a href="#" class=" f18 md-f14 mgb0"> Mời ứng viên ứng tuyển đồng loạt</a>
                                    </li>

                                </ul>
                            </div>
                        </div>


                        <div class="InfoCompanyJob">
                            <div class="main">
                                <div class="notificationBox bkwhite formJobLarge sm-f14">
                                    <div class="bodyBox ">

                                        @if(session('suscess'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert"
                                                 style="margin-top: 15px;width: 100%">
                                                <strong>{{ session('suscess') }}</strong>
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        @if(session('erorr'))
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert"
                                                 style="margin-top: 15px;width: 100%">
                                                <strong>{{ session('erorr') }}</strong>
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif


                                        <div class="mgb10 postionImg">
                                            <div class="w90">

                                                <?php
                                                $date = date_create($job->deadline_submit_profile);
                                                $date_end = date_format($date, "d-m-Y");
                                                $today = date('d-m-Y');
                                                ?>

                                                @if(strtotime($today) > strtotime($date_end))
                                                    <p class="clred f16 fw6">
                                                        Công việc này đã hết hạn nộp hồ sơ rồi !
                                                    </p>
                                                @else

                                                @endif


                                                <h1 class="fontBold blueDN mgb0 f23 lg-f20 sm-f15">{{$job->title}}</h1>

                                                @if(isset($employer->enterprise_name))
                                                    <a href="{{route('detail_employer',['slug' => $employer->slug])}}"
                                                       class="xam font18 sm-f15 clorange mgt15 titleCompanyName"
                                                       style="display: inline-block">{{ isset($employer->enterprise_name) ? $employer->enterprise_name : ''}}</a>
                                                @endif


                                            </div>
                                            <div class="w10">
                                                <img class="chuaxathuc lazy"
                                                     src="{{ asset('assets/image/xacthuc.jpg') }}"
                                                     title="Xác thực tại sanketoan.vn" alt="Xác thực tại sanketoan.vn">
                                            </div>
                                        </div>


                                        <div class="row">
                                            <?php
                                            $date = date_create($job->updated_at);
                                            $date_line = date_create($job->deadline_submit_profile);

                                            ?>
                                            <div class="col-xl-12 col-lg-12 col-md-12 showMobileDesJob">
                                                <?php
                                                $save_job_fb = 0;
                                                $teacher_save_job_fb = 0;
                                                ?>
                                                @if(\Illuminate\Support\Facades\Auth::check())
                                                    @if((\Illuminate\Support\Facades\Auth::user()->role) == 1 || (\Illuminate\Support\Facades\Auth::user()->role) == 3 )
                                                        <?php
                                                        $id_user = \Illuminate\Support\Facades\Auth::user()->id;
                                                        $employee = \App\Entity\Employee::getEmployee_id($id_user);
                                                        if (!empty($employee)) {
                                                            $save_job_fb = \App\Entity\Employees_save_job_facebook::checkSaveJobFacebook($employee->employee_id, $job->job_id, 1);
                                                        }
                                                        $teacher = \App\Entity\Teacher::getTeacher_id($id_user);
                                                        if (!empty($teacher)) {
                                                            $teacher_save_job_fb = \App\Entity\Teacher_save_job_facebook::checkSaveJobFacebook($teacher->teacher_id, $job->job_id, 1);
                                                        }
                                                        ?>
                                                    @endif

                                                    @if(\Illuminate\Support\Facades\Auth::check() && $save_job_fb > 0 && (\Illuminate\Support\Facades\Auth::user()->role) == 1)
                                                        <button class="pd5-10 mgr20 bkwhite BorderLightGray"
                                                                id="deletesaveJob"
                                                                style="color: orange;border: 1px solid;"><i
                                                                    class="fas fa-star blueN"
                                                                    style="margin-right: 5px"></i>Hủy việc
                                                            làm đã lưu
                                                        </button>
                                                    @else
                                                        <button class="pd5-10 mgr20 bkwhite BorderLightGray"
                                                                id="saveJob"><i
                                                                    class="far hoverYellow fa-star blueN"></i> Lưu việc
                                                            làm
                                                        </button>
                                                    @endif
                                                @else
                                                    <button class="pd5-10 mgr20 bkwhite BorderLightGray"
                                                            id="saveJob"><i
                                                                class="far hoverYellow fa-star blueN"></i> Lưu việc làm
                                                    </button>
                                                @endif
                                                <span class="sm-block sm-mgt10"><i
                                                            class="far fa-clock blueN"></i> Ngày đăng tin : {{ $date_facebook }}</span>


                                                <span class="sm-block sm-mgt10"
                                                      style="margin-left: 20px"><i
                                                            class="fas fa-eye blueN"></i> Lượt xem: {{$job->views}}
                                                    </span>

                                                <span class="sm-block sm-mgt10"
                                                      style="margin-left: 20px"> <i
                                                            class="fas fa-code blueN"></i> Mã tin: {{$job->job_code}}
                                                       </span>
                                            </div>


                                        </div>
                                        <p></p>
                                        <div class="row lg-mgb15 IconDetailJob">
                                            <div class="col-md-6">
                                                <p class="mgb10"><i class="far fa-money-bill-alt blueN"></i>Mức lương
                                                    : {{isset($job->salary_description) ? $job->salary_description : 'Đang cập nhật '}}
                                                </p>
                                                <p class="mgb10"><i class="fas fa-clipboard-check blueN"></i>Kinh nghiệm
                                                    :
                                                    {{isset($job->experience) ? $job->experience : 'Không yêu cầu'}}
                                                </p>
                                                <p class="mgb10"><i class="fas fa-graduation-cap blueN"></i>Trình độ :
                                                    {{isset($job->literacy_name) ? $job->literacy_name : 'Không yêu cầu'}}
                                                </p>

                                                <p class="mgb10"><i class="fab fa-microsoft blueN"></i>Phần mềm yêu cầu
                                                    :
                                                    <?php
                                                    $software = \App\Entity\Software::getId($job->software_id)
                                                    ?>
                                                    {{isset($software->software_name) ? $software->software_name : 'Không yêu cầu'}}
                                                </p>
                                                <?php
                                                $job_career = \App\Entity\JobCareer::getIdJob($job->job_id);
                                                ?>
                                                <div class="mgb10 DetailJobListCareer"><i
                                                            class="fas fa-user-tie blueN"></i>Vị
                                                    trí
                                                    công việc :

                                                    <?php
                                                    $ca = \App\Entity\Career::getIdCareer($job->career_category_id);
                                                    ?>
                                                    @if(!empty($ca))
                                                        <span>{{ $ca['career_category_name'] }}</span>
                                                    @else
                                                        <span></span>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mgb10"><i class="fas fa-users blueN"></i>Số lượng cần tuyển :
                                                    {{isset($job->number_recruit) ? $job->number_recruit : 'Đang cập nhật '}}
                                                </p>

                                                <p class="mgb10"><i class="fas fa-venus-mars blueN"></i>Giới tính :
                                                    @if($job->gender == 0)
                                                        Không yêu cầu giới tính
                                                    @elseif($job->gender == 1)
                                                        Nữ
                                                    @elseif($job->gender == 2)
                                                        Nam
                                                    @endif

                                                </p>
                                                <p class="mgb10"><i class="fas fa-birthday-cake blueN"></i>Độ tuổi :
                                                    <?php
                                                    $age = \App\Entity\Age::getIdAge($job->age_id);
                                                    ?>
                                                    @if(!empty($age))
                                                        {{ $age->name_age }}
                                                    @else
                                                        Không yêu cầu
                                                    @endif

                                                </p>
                                                <p class="mgb10"><i class="fas fa-map-marker-alt blueN"></i>Địa chỉ
                                                    : <?php
                                                    $district = \App\Entity\District::getId($job->district);
                                                    $province = \App\Entity\Province::getId($job->province);
                                                    ?>{{ isset($district->district_name) ? $district->district_name : '' }}
                                                    @if(!empty($district->district_name))
                                                        -
                                                    @endif
                                                    {{ isset($province->province_name) ? $province->province_name : '' }}
                                                </p>
                                                @if(isset($job->address_work))
                                                    <p class="mgb10"><i class="fas fa-map-marker-alt blueN"></i>Địa điểm
                                                        làm
                                                        việc
                                                        : {{isset($job->address_work) ? $job->address_work : '' }}</p>
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </section>

                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs  fw7 f18 white bgrBlueN pd10-20 col-f14">
                            Danh sách ứng viên phù hợp với tin tuyển dụng
                            {{--( {{ theo bảng thong ke ứng viên đã làm bài thi trắc nghiệm }} việc làm)--}}
                        </div>
                        <div>
                            <div class="text-center">
                                <button id="button-timkiem" class=""
                                        data-toggle="modal" data-target="#timkiem" style="border: 1px solid orange;
    color: #fff;
    background: orange;
    display: inline-block;
    padding: 5px 20px;
    font-size: 15px;
margin-top: 5px"><i
                                            class="fas fa-search text-warning" style="color: #fff !important;"></i> Lọc
                                    ứng viên
                                </button>
                            </div>

                            <div class="modal fade bd-example-modal-lg" id="timkiem" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <form action="" method="get" id="js_submit_from">
                                    <div class="modal-dialog modal-lg custom-modal-dialog modal-dialog-centered"
                                         role="document">

                                        <?php
                                        //thành phố
                                        $provice = isset($_GET['province']) ? $_GET['province'] : 0;
                                        //                    $provice = \App\Entity\Province::getId($p);
                                        //quân /huyện
                                        $district_get = isset($_GET['district_id']) ? $_GET['district_id'] : '';
                                        //                    $district = \App\Entity\District::getId($q);
                                        $salary_get = isset($_GET['salary_id']) ? $_GET['salary_id'] : array();
                                        $profile_get = isset($_GET['profile']) ? $_GET['profile'] : '';
                                        $status_get = isset($_GET['status']) ? $_GET['status'] : '';
                                        $career_category_id_get = isset($_GET['career_category_id']) ? $_GET['career_category_id'] : '';
                                        ?>
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Lọc ứng
                                                    viên</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="row employee-search ">
                                                    <div class="col-md-6 col-lg-6  ">
                                                        <div class="form-group">
                                                            <label class="f16 lpf14 fw6"> <i
                                                                        class="fas fa-filter"></i> Tìm theo
                                                                thành phố</label>
                                                            <select class="select2" name="province"
                                                                    aria-label="Tỉnh/Thành phố" id="province">
                                                                <option value="0" selected> Tất cả tỉnh/thành
                                                                    phố
                                                                </option>
                                                                <?php
                                                                $getAllProvince = \App\Entity\Province::GetAllProvinces();
                                                                ?>
                                                                @foreach($getAllProvince as $province)
                                                                    <option @if($province->province_id == $provice) selected
                                                                            @endif value="{{$province->province_id}}">{{$province->province_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6  ">
                                                        <div class="form-group">
                                                            <label class="f16 lpf14 fw6"> <i
                                                                        class="fas fa-filter"></i> Tìm theo
                                                                quận/huyện</label>

                                                            <select class="select2" name="district_id" id="district">
                                                                <option
                                                                        value="0">
                                                                    Chọn quận huyện
                                                                </option>
                                                                @if(!empty($provice))
                                                                    @foreach(\App\Entity\District::get_province_id($provice) as $district)
                                                                        <option @if($district_get == $district->district_id))
                                                                                selected @endif
                                                                                value="{{$district->district_id}}">
                                                                            {{$district->district_name}}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>

                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row employee-search ">
                                                    <div class="col-md-6 col-lg-6 ">
                                                        <div class="form-group">
                                                            <label class="f16 lpf14 fw6"> <i
                                                                        class="fas fa-filter"></i> Tìm theo công
                                                                việc</label>
                                                            <select class="select2" name="career_category_id">
                                                                <option value="0"> Chọn công việc
                                                                </option>
                                                                @foreach(\App\Entity\Career::get_all_career() as $career)
                                                                    <option @if($career_category_id_get == $career->career_category_id) selected
                                                                            @endif
                                                                            value="{{$career->career_category_id}}">
                                                                        {{$career->career_category_name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6  ">
                                                        <div class="form-group">
                                                            <label class="f16 lpf14 fw6"> <i
                                                                        class="fas fa-filter"></i> Tìm theo mức
                                                                lương</label>
                                                            <select class="select2" name="salary_id">
                                                                <option
                                                                        value="0">
                                                                    Chọn mức lương
                                                                </option>
                                                                @foreach(\App\Entity\Salary::showAllSalary() as $salary)
                                                                    <option @if($salary_get == $salary->salary_id) checked
                                                                            @endif
                                                                            value="{{$salary->salary_id}}">
                                                                        {{$salary->description}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row employee-search ">
                                                    <div class="col-md-6 col-lg-6  ">
                                                        <div class="form-group">
                                                            <label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i>Phần
                                                                trăm hồ sơ</label>
                                                            <input type="text " placeholder="Phần trăm hồ sơ"
                                                                   class="form-control " name="profile" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6  ">
                                                        <div class="form-group">
                                                            <label class="f16 lpf14 fw6"> <i class="fas fa-filter"></i>Số
                                                                lượng ứng viên cần tìm</label>
                                                            <input type="text " placeholder="Số lượng ứng viên cần tìm"
                                                                   class="form-control" name="limit_employee" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Đóng
                                                </button>
                                                <button type="submit " class="btn btn-primary" id="btn_submit_exam">Lọc ứng viên</button>
                                                {{--<input type="reset" class="btn btn-success" value="Reset">--}}
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="pd20">
                            <form action="{{ route('send_employees_invitation_job_apply') }}" method="post"
                                  id="invitation_job_apply_detail_employee">
                                <div class="row">
                                    <div class="col-md-6"><h3 class="f20 fw6 clgreen">Mời ứng viên ứng tuyển</h3>
                                        <p>Vui lòng tích vào ô <input type="checkbox"> để mới ứng viên ứng tuyển vào tin
                                            tuyển dụng ! </p></div>
                                    <div class="col-md-4">
                                        <p class="js_show_length_checkbox mgb0 clred"></p>
                                        <p class="js_total_coin mgb10 clgreen"></p>

                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btnGreen pd5-10 js_submit_disabled">Mời ứng tuyển
                                        </button>
                                        <br>
                                        <span class="js_noti_employer_coin clred f10"></span></div>
                                </div>

                                {!! csrf_field() !!}
                                {{ method_field('POST') }}
                                <div class="table-responsive">
                                    <table id="jobfb" class="table table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="max-width: 45px">
                                                <label> <input type="checkbox" id="checkAll"
                                                               class="mgr5 checkbox"></label>
                                            </th>
                                            <th>Tên ứng viên</th>
                                            <th style="max-width: 150px">Công việc mong muốn</th>
                                            <th style="max-width: 60px">Cập nhật HS</th>
                                            <th>Mức lương</th>
                                            <th style="max-width: 100px;min-width: 60px;">% hồ sơ</th>
                                            <th style="max-width: 300px">Địa chỉ</th>
                                            <th style="max-width: 100px">Thông tin</th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($list_employee as $employee)
                                            <tr>
                                                <td>
                                                    <?php
                                                    //                                                    print_r($employee);
                                                    $check_inviton_aplly = \App\Entity\Coin_apply_employee::check_employer_contact_job_employee($employer->employer_id, $employee->employee_id, $job->job_id)
                                                    ?>
                                                    {{--{{ $employee->employee_id }}--}}
                                                    <input type="checkbox" name="employee[]"
                                                           value="{{ $employee->employee_id }}"
                                                           class="checkbox js_checkbox_checked">


                                                    @if(!empty($check_inviton_aplly))
                                                        <span class="clgreen">đã mời</span>
                                                        </br>
                                                        <?php
                                                        $date_facebook = \App\Ultility\Ultility::getdateFacebook($check_inviton_aplly['created_at']);
                                                        ?>
                                                        <span class="clred">({{ $date_facebook }})</span>

                                                    @endif
                                                </td>
                                                <td>
                                                    {{ isset($employee->employee_name) ? $employee->employee_name : '' }}
                                                </td>


                                                <td>
                                                <span class="cutTitle2">
                                                <?php
                                                    $list_career_name = \App\Entity\Employee_career_categories::get_array_name($employee->employee_id);
                                                    ?>
                                                    @foreach($list_career_name as $id_c=>$career)
                                                        @if($id_c == 0)
                                                            <span> {{ $career->career_category_name }}</span>
                                                        @else
                                                            <span> | {{ $career->career_category_name }}</span>
                                                        @endif
                                                    @endforeach
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php
                                                    $date_facebook_employee = '';
                                                    ?>
                                                    @if(!empty($employee->date_update))
                                                        <?php
                                                        $date_facebook_employee = \App\Ultility\Ultility::getdateFacebook($employee['date_update']);
                                                        ?>
                                                    @else
                                                        <?php
                                                        $date_facebook_employee = \App\Ultility\Ultility::getdateFacebook($employee['date_create']);
                                                        ?>
                                                    @endif
                                                    <span class="clred">({{ $date_facebook_employee }})</span>
                                                </td>
                                                <td>  {{ isset($employee['description']) ? $employee['description'] : 'Thỏa thuận'  }}
                                                </td>

                                                <td>{{ $employee['profile'] }} %</td>
                                                <td>
                                                    <i>
                                                <span class="block gray cutTitle2"><i class="fas fa-map-marker-alt"></i>

                                                    @if(isset($employee->province_name))
                                                        {{ $employee->province_name }}
                                                    @endif
                                                    {{--//danh sach quan huyen--}}
                                                    <?php
                                                    $list_district_name = \App\Entity\Employee_district::get_district_name($employee->employee_id);
                                                    ?>
                                                    @if(!empty($list_district_name))
                                                        @foreach($list_district_name as $ids=>$district)
                                                            <i> | {{ $district->district_name }}</i>
                                                        @endforeach
                                                    @endif

                                                </span>
                                                    </i>


                                                </td>
                                                <td><a class="btngreen"
                                                       href="{{route('detail_employee_show',['employee_slug'=>$employee->employee_slug])}}">Link
                                                        CV</a></td>


                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <p class="js_show_length_checkbox mgb0 clred"></p>
                                <p class="js_total_coin mgb10 clgreen"></p>

                                <input type="hidden" name="job_id" value="{{ $job->job_id }}">
                                <button type="button" class="btnGreen pd5-10 js_submit_disabled">Mời ứng tuyển</button>
                                <span class="js_noti_employer_coin clred f10"></span>

                            </form>

                            <div class="row link_page">
                                <div class="col-12 text-center">
                                    @include('site.default.item_pani',['page_link' => $list_employee])
                                </div>
                            </div>
                        </div>

                    </section>

                    @include('site.module_index.dang-ky-tu-van')

                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>
    <script>
        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });
    </script>
    @include('site.partials.delete')
    <style>
        .checkbox, #checkAll {
            width: 20px;
            height: 20px;
        }

    </style>
    <script>

        $(document).ready(function () {

            $('.select2').select2({
                width: '100%',
            });

            $('#province').change(function () {
                var search_city = $(this).val();
                $.get('/tim-kiem-huyen/' + search_city, function (data) {
                    if (data) {
                        $('#district').html('');
                        $('#district').html(data);
                    }
                });
            });

            // $('#province').change(function () {
            //     var city = $(this).val();
            //     $.get('/tim-kiem-slug/' + city, function (data) {
            //         $('#district').html('');
            //         $('#district').html(data);
            //     });
            // });

            // $('#province').change(function () {
            //     $.get('/admin/ajax-district/' + $(this).val(), function (data) {
            //         $('#district').html(data);
            //     })
            // });
        });


        $("#checkAll").click(function () {
            $('.checkbox').not(this).prop('checked', this.checked);
        });
        <?php
        $coint_career = \App\Entity\Career::getIdCareer($job->career_category_id);
        ?>
        $('.js_submit_disabled').click(function () {
            var checked = $('.js_checkbox_checked:checked').length;
            if (checked > 0) {
                $('.js_submit_disabled').html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang mời ứng tuyển...');
                $('#invitation_job_apply_detail_employee').submit();
            } else {
                alert('Vui lòng chọn ứng viên cho tin tuyển dụng');
            }
        });
        $('.checkbox').change(function () {
            var coin_career = '{{ !empty($coint_career->view_apply) ? $coint_career->view_apply : 0 }}';
            var numberOfChecked = $('.js_checkbox_checked:checked').length;
            var total_coin = numberOfChecked * coin_career;
            var coin_free = '{{ !empty($coin_free) ?$coin_free  : 0 }}';
            var total_employer_coin = '{{ !empty($employer->total_employer_coin) ?$employer->total_employer_coin  : 0 }}';
            var employer_coin = '{{ !empty($employer->employer_coin) ?$employer->employer_coin  : 0 }}';
            // var employer_coin = '4';

            $('.js_show_length_checkbox').html('Đã chọn ' + numberOfChecked + ' ứng viên');
            $('.js_total_coin').html('Tổng điểm cần để mời ứng viên ứng tuyển là ' + total_coin + ' điểm');
            //nếu chưa chọn
            if (total_employer_coin > 0) {
                if (employer_coin < total_coin) {
                    $(".js_submit_disabled").attr("disabled", true);
                    $(".js_submit_disabled").css("background", '#326d32');
                    $('.js_noti_employer_coin').html('(<i>' + 'Số điểm của bạn không đủ để mời ứng viên' + '</i>)');
                    console.log('số điểm không đủ để đổi');
                } else {
                    $(".js_submit_disabled").attr("disabled", false);
                    $(".js_submit_disabled").css("background", 'green');
                    $('.js_noti_employer_coin').html('');
                }
            } else {
                if (coin_free < total_coin) {
                    $(".js_submit_disabled").attr("disabled", true);
                    $(".js_submit_disabled").css("background", '#326d32');
                    $('.js_noti_employer_coin').html('(<i>' + 'Số điểm miễn phí của bạn không đủ để mời ứng viên' + '</i>)');
                    console.log('số điểm không đủ để đổi');
                } else {
                    $(".js_submit_disabled").attr("disabled", false);
                    $(".js_submit_disabled").css("background", 'green');
                    $('.js_noti_employer_coin').html('');
                }
            }
            // alert(numberOfChecked);
        });

        $('#btn_submit_exam').click(function () {
            $('#btn_submit_exam').html('<i class="fas fa-spinner fa-spin mgr5"></i>' + ' Đang Lọc ứng viên...');
            $('#js_submit_from').submit();
        });
    </script>


@endsection
