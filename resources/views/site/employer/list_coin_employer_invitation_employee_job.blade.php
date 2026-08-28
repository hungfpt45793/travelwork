@extends('site.layout.site')

@section('title', ' Danh sách ứng viên  đã mời ứng tuyển')
@section('meta_description', ' Danh sách ứng viên  đã mời ứng tuyển')
@section('keywords', ' Danh sách ứng viên  đã mời ứng tuyển')

@section('content')
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
                                        <a href="#" class=" f18 md-f14 mgb0"> Danh sách ứng viên  đã mời ứng tuyển</a>
                                    </li>

                                </ul>
                            </div>
                        </div>

                        <div class="InfoCompanyJob">
                            <div class="main">
                                <div class="notificationBox bkwhite formJobLarge sm-f14">
                                    <div class="bodyBox ">
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
                                                <img class="chuaxathuc lazy" src="{{ asset('assets/image/xacthuc.jpg') }}"
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
                                                                    class="far hoverYellow fa-star blueN"></i> Lưu việc làm
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
                                                <p class="mgb10"><i class="fas fa-clipboard-check blueN"></i>Kinh nghiệm :
                                                    {{isset($job->experience) ? $job->experience : 'Không yêu cầu'}}
                                                </p>
                                                <p class="mgb10"><i class="fas fa-graduation-cap blueN"></i>Trình độ :
                                                    {{isset($job->literacy_name) ? $job->literacy_name : 'Không yêu cầu'}}
                                                </p>

                                                <p class="mgb10"><i class="fab fa-microsoft blueN"></i>Phần mềm yêu cầu :
                                                    <?php
                                                    $software = \App\Entity\Software::getId($job->software_id)
                                                    ?>
                                                    {{isset($software->software_name) ? $software->software_name : 'Không yêu cầu'}}
                                                </p>
                                                <?php
                                                $job_career = \App\Entity\JobCareer::getIdJob($job->job_id);
                                                ?>
                                                <div class="mgb10 DetailJobListCareer"><i class="fas fa-user-tie blueN"></i>Vị
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
                                                <p class="mgb10"><i class="fas fa-map-marker-alt blueN"></i>Địa chỉ : <?php
                                                    $district = \App\Entity\District::getId($job->district);
                                                    $province = \App\Entity\Province::getId($job->province);
                                                    ?>{{ isset($district->district_name) ? $district->district_name : '' }}
                                                    @if(!empty($district->district_name))
                                                        -
                                                    @endif
                                                    {{ isset($province->province_name) ? $province->province_name : '' }}
                                                </p>
                                                @if(isset($job->address_work))
                                                    <p class="mgb10"><i class="fas fa-map-marker-alt blueN"></i>Địa điểm làm
                                                        việc
                                                        : {{isset($job->address_work) ? $job->address_work : '' }}</p>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 && $job->sale_money == 1)
                                                    <?php $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id); ?>
                                                    <div class="mgb15">
                                                        <div id="fb-root"></div>
                                                        <script async defer crossorigin="anonymous"
                                                                src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0"></script>
                                                        <div class="fb-share-button"
                                                             data-href="{{ route('job_detail',['slug'=>$job->slug]) }}?user_id_sale={{$employee->employee_id}}"
                                                             data-layout="button" data-size="large"><a target="_blank"
                                                                                                       href="https://www.facebook.com/sharer/sharer.php?u={{ route('job_detail',['slug'=>$job->slug]) }}?user_id_sale={{$employee->employee_id}}&amp;src=sdkpreparse"
                                                                                                       class="fb-xfbml-parse-ignore js_add_employee_money share_facebook"><i class="fas fa-dollar-sign"></i> Chia sẻ lên
                                                                facebook</a>
                                                        </div>

                                                        <div class="input-group mb-3 copy_link_post">
                                                            <input type="text"
                                                                   value="{{ route('job_detail',['slug'=>$job->slug]) }}?user_id_sale={{$employee->employee_id}}"
                                                                   id="myInput" class="form-control js_add_employee_money css_no_copy" placeholder="copy link chia sẻ" readonly
                                                                   style="width: 100%;">

                                                            <div class="input-group-append">
                                                                <button onclick="myFunction()" class="btn btn-outline-secondary copylink js_add_employee_money">Copy
                                                                    link tuyển dụng
                                                                </button>

                                                            </div>
                                                        </div>




                                                    </div>
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
                            Danh sách ứng viên  đã mời ứng tuyển
                            {{--( {{ theo bảng thong ke ứng viên đã làm bài thi trắc nghiệm }} việc làm)--}}
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                @foreach($list_employer_show_employee as $emp_new)
                                    @include('site.employee.item_employee',['employee'=>$emp_new])
                                @endforeach

                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    @include('site.default.item_pani',['page_link' => $list_employer_show_employee])

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


@endsection
