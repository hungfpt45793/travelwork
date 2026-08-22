@extends('site.layout.site')

@section('title', 'Ứng viên nộp hồ sơ')
@section('meta_description', 'Ứng viên nộp hồ sơ')
@section('keywords', 'Ứng viên nộp hồ sơ')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                <script>
                    // location.reload();
                </script>
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent col-12 col-12">

                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Nộp hồ sơ</a>
                            </li>
                        </ul>
                    </div>


                    <div class="InfoCompanyJob mgt20">
                        <div class="main">
                            <article>
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
                                                <a href="{{route('detail_employer',['id' => $employer->slug])}}"
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
                                                <?php
                                                $job_experience = \App\Entity\Experience::getIdEx($job->experience_id);
                                                ?>
                                                {{isset($job_experience->experience_des) ? $job_experience->experience_des : 'Không yêu cầu'}}
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

                                    </div>

                                </div>


                                     <div class="">
                                         <hr>
                                         <div class="row sm-pd10 pdl20 pdr20">
                                             <h2 class="font18 fontBold textUpper sm-f15">Mô tả công việc</h2>
                                             <div class="col-md-12 contentResetCss" id="content_remove_a">
                                                 @if(!empty($job->description))
                                                     <?php
                                                     $description = App\Ultility\Ultility::ReplaceContent($job->description);
                                                     $description_replace = preg_replace('/(?<=@.)[a-zA-Z0-9-]*(?=(?:[.]|$))/', '*', $description);
                                                     ?>
                                                     <?= $description_replace ?>
                                                 @else
                                                     <p>Đang cập nhật thông tin</p>
                                                 @endif
                                             </div>
                                         </div>
        <hr>
                                         <div class="row sm-pd10 pdl20 pdr20 ">
                                             <h2 class="font18 fontBold textUpper sm-f15">Yêu cầu công việc</h2>
                                             <div class="col-md-12 contentResetCss" id="content_remove_a">
                                                 <?php
                                                 $content = App\Ultility\Ultility::ReplaceContent($job->content);
                                                 $content_replace = preg_replace('/(?<=@)[a-zA-Z0-9-]*(?=(?:[.]|$))/', '******', $content);
                                                 //                                            $content_replace = preg_replace('/^[a-z0-9_-]{3,15}$/', '****', $content);
                                                 ?>
                                                 <?= $content_replace ?>


                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row sm-pd10 pdl20 pdr20">
                                             <h2 class="font18 fontBold textUpper sm-f15">Phúc lợi xã hội</h2>
                                             <div class="col-md-12 contentResetCss" id="content_remove_a">
                                                 @if(!empty($job->welfare))
                                                     <?php
                                                     $welfare = App\Ultility\Ultility::ReplaceContent($job->welfare);
                                                     $welfare_replace = preg_replace('/(?<=@.)[a-zA-Z0-9-]*(?=(?:[.]|$))/', '*', $welfare);
                                                     ?>
                                                     <?= $welfare_replace ?>
                                                 @else
                                                     <p>Đang cập nhật thông tin</p>
                                                 @endif
                                                 <hr>

                                             </div>
                                         </div>
                                     </div>



                            </div>
                            </article>
                        </div>






                    </div>

                    <form action="{{ route('submit_apply_now') }}" method="post"
                          enctype="multipart/form-data" id="submit_apply_now">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id_job_fb" value="{{ $id_job_fb }}"/>
                        <input type="hidden" name="status_job" value="{{ $status_job }}"/>

                        <div class="CV bgrWhite radius5 mgt20 mgb20 pdb5 pdt10" style="border: 1px solid #ccc;">

                            <div class="content">


                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="content_detail_job_submit pd20">

                                            <?php

                                            $list_job_app = \App\Entity\Job_application::get_all();
                                            $list_join_job_app = \App\Entity\Job_application::get_join_all();
                                            ?>
                                            <div class="form-group row  borderSelect2 mgb0">
                                                <label for="staticEmail" class="col-lg-2 col-md-3 col-sm-3 col-5 col-form-label">Chọn mẫu đơn xin
                                                    việc</label>
                                                <div class="cl-lg-10 col-md-9 col-sm-9 col-7" style="width: 250px">
                                                    <select class="form-control select2 error_border_province js_select_2_change"
                                                            name="list_job_app"
                                                            aria-label="Năm bắt đầu đi làm việc" id="list_job_app">
                                                        @foreach($list_join_job_app as $item_job_app)
                                                            <option value="show{{ $item_job_app->career_category_id }}"
                                                                    @if($item_job_app->career_category_id == $job->career_category_id) selected @endif
                                                            >{{ isset($item_job_app->career_category_name) ? $item_job_app->career_category_name : '' }} </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <h3 class="inBlock fw7 f18 ">Đơn xin việc</h3>


                                            @foreach($list_job_app as $item_job_app)
                                                <div id="show{{ $item_job_app->career_category_id }}"
                                                     class="js_hidden_job_app @if($job->career_category_id == $item_job_app->career_category_id) show_item_job_app @else hidden_item_job_app @endif">
                                            <textarea class="textarea w100 form-control editor_basic"
                                                      name="show{{ $item_job_app->career_category_id }}"
                                                      id="editor_job_app_content{{ $item_job_app->career_category_id }}"
                                                      style="width: 50%;">{!!   isset($item_job_app->job_app_content) ? $item_job_app->job_app_content : ''  !!}</textarea>
                                                </div>
                                            @endforeach

                                            <h3 class="inBlock fw7 f18   mgt15">Hồ sơ xin việc</h3>
                                            <div class="popup-tcv mgt10">

                                                    <div class="slideNews submit_job_slide">
                                                        <div class="text-center">
                                                            <label class="clgreen f16 fw6"><input type="checkbox" class="form-check-input" id="exampleCheck1" name="" checked value="1" disabled>Hồ sơ ứng viên</label>
                                                            <div class="submit_job_img">
                                                                <img class="js_max_height_img mg_0_auto" src="{{ asset('assets/image/item_hs1.jpg') }}">
                                                                <a target="_blank" href="{{ route('show_file_job_facebook') }}">Cập nhật hồ sơ</a>
                                                            </div>


                                                        </div>
                                                        <div class="text-center">
                                                            <label class="clgreen f16 fw6"><input type="checkbox" class="form-check-input" id="exampleCheck1" name="" checked value="1" disabled> CV ứng viên</label>
                                                            <div class="submit_job_img">
                                                                <img class="js_max_height_img mg_0_auto" src="{{ asset('assets/image/item_cv.jpg') }}">
                                                                <a target="_blank" href="{{ route('create_emplyee_cv') }}">Cập nhật CV</a>
                                                            </div>

                                                        </div>
                                                    </div>

                                            </div>

                                            <div class="form-check mgt5 mgb5 pdf0">

                                                <label class="form-check-label" for="exampleCheck1">Lưu ý : Hồ sơ ứng viên  và CV ứng viên mặc định sẽ được gửi kèm cùng đơn xin việc</label>


                                            </div>




                                                <script type="text/javascript">
                                                    $('.slideNews').slick({
                                                        slidesToShow: 2,
                                                        slidesToScroll: 1,
                                                        autoplay: true,
                                                        autoplaySpeed: 2000,
                                                        responsive: [
                                                            {
                                                                breakpoint: 1500,
                                                                settings: {
                                                                    slidesToShow: 2,
                                                                    slidesToScroll: 1
                                                                }
                                                            },
                                                            {
                                                                breakpoint: 1100,
                                                                settings: {
                                                                    slidesToShow: 2,
                                                                    slidesToScroll: 1
                                                                }
                                                            },
                                                            {
                                                                breakpoint: 800,
                                                                settings: {
                                                                    slidesToShow: 2,
                                                                    slidesToScroll: 1
                                                                }
                                                            },
                                                            {
                                                                breakpoint: 501,
                                                                settings: {
                                                                    slidesToShow: 1,
                                                                    slidesToScroll: 1
                                                                }
                                                            },
                                                        ]
                                                    });

                                                    // $('#show_notification').modal('show');
                                                    // Nếu trình duyệt không hỗ trợ thông báo
                                                    $(document).ready(function () {

                                                    });
                                                </script>




                                            <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5 js_btn_loading btnGreen"
                                                    value="btn_save" style="border:none" id="btnloading"
                                                    name="submit_form"> Ứng tuyển ngay
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>

                    <script>
                        $('#list_job_app').change(function () {
                            var show_category_id = $(this).val();
                            $('.js_hidden_job_app').hide();
                            $('#' + show_category_id).show();
                            console.log(show_category_id);
                        });
                        $('#is_click_appen').click(function () {
                            $('#show_hidden').hide();
                        });


                        $('.js_btn_loading').click(function () {
                                $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang Ứng tuyển ...');
                                $btn.attr('disabled', false);
                        });
                    </script>
                </div>
            </div>
        </div>
    </section>
    <script>
        // chon thanh pho ra quan huyen

    </script>
    <style>
        article {
            max-height: 300px; /* (4 * 1.5 = 6) */
        }

        .redmore {
            margin-top: 15px;
            text-align: center;
            padding: 5px 10px;
            font-size: 15px;
        }

        .redmore:hover {
            /*background: #009385;*/
            /*color: white;*/
        }

        .redmore span {
            background: #009385;
            border: 1px solid #009385;
            color: white;
            padding: 5px 10px;
        }
    </style>

    <script src="/assets/js/ajax_redmore_jquery.min.js"></script>
    <script src="/assets/js/readmore.js"></script>
    <script>
        $('article').readmore({
            speed: 1000,
            moreLink: '<a title="Xem thêm" class="redmore" href="#"> <span> Xem thêm <i class="fas fa-angle-double-down"></i> </span></a>',
            lessLink: '<a title="Thu gọn" class="redmore" href="#">   <span> Thu gọn <i class="fas fa-angle-double-up"></i> </span> </a>',
        });
    </script>
    <script src="/public/assets/ckeditor_easy/ckeditor.js"></script>
    <script>

        $('.editor_basic').each(function (e) {
            CKEDITOR.replace(this.id);
        });
        $('.select2').select2({
            width: '100%',
        });
    </script>
@endsection