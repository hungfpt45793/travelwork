@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', !empty($meta_employee->meta_title) ? $meta_employee->meta_title :'Tải CV ứng viên')
@section('meta_description', !empty($meta_employee->meta_description) ? $meta_employee->meta_description :'Tải CV ứng viên')
@section('keywords', !empty($meta_employee->meta_keywords) ? $meta_employee->meta_keywords :'Tải CV ứng viên')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : ''  )

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/nortification.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/css/upload_employee_cv.css"/>
@endsection
@section('content')
    <div class="InfoCompanyJob bgrWhite  pd20" style="border-bottom: 1px solid #ccc">

        <div class="row step_center_block">
            <div class="item_step">
            <?php
            //xác thực tài khoản
            $check_status_email_account = '';
            $check_status_email_account = \App\Entity\User::check_status_email_account(\Illuminate\Support\Facades\Auth::user()->id)
            //status_email_account
            ?>
            @if(!empty($check_status_email_account))
                <!-- <a class="clgreen " href="#" data-toggle="modal" data-target="#step_status_acoount">
                        <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                        <span class="clgreen f16"> Xác thực tài khoản</span>
                    </a> -->
                    <a class="clgreen " href="{{ route('management_account') }}">
                        <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                        <span class="clgreen f16"> Xác thực tài khoản</span>
                    </a>
            @else
                <!-- <a class="clorang  item_no_success" href="#" data-toggle="modal" data-target="#step_status_acoount">
                        <span><i class="fas fa-check  step_icon "></i></span>
                        <span class="clorang f16"> Xác thực tài khoản</span>
                    </a> -->
                    <a class="clorang  item_no_success" href="{{ route('management_account') }}">
                        <span><i class="fas fa-check  step_icon "></i></span>
                        <span class="clorang f16"> Xác thực tài khoản</span>
                    </a>
                @endif
                <img class="next_step" src="{{ asset('assets/image/next.png') }}">
                <div class="modal fade" id="step_status_acoount" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Xác thực tài khoản</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <a>Lưu ý : Nếu bạn thay đổi thông tin CV thì bạn vui lòng lưu CV trước khi quay lại bước
                                    xác thực tài khoản</a>
                            </div>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-secondary" data-dismiss="modal"
                                   style="    padding: .375rem .75rem;;color: #fff">Đóng</a>
                                <a type="button" class="btn btn-primary" href="{{ route('management_account') }}"
                                   style="    padding: .375rem .75rem;">Quay lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="item_step">
            <?php
            //check ti le hoan thien tho so
            $check_info_profile = '';
            $check_info_profile = \App\Entity\Employee::check_info_profile(\Illuminate\Support\Facades\Auth::user()->id);
            ?>
            @if(!empty($check_info_profile))
                <!-- <a class="clgreen" href="#" data-toggle="modal" data-target="#step_update_profile">
                        <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                        <span class="clgreen  f16"> Hoàn thiện hồ sơ</span>
                    </a> -->
                    <a class="clgreen" href="{{ route('show_file_job_facebook') }}">
                        <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                        <span class="clgreen  f16"> Hoàn thiện hồ sơ</span>
                    </a>
            @else
                <!-- <a class="clorange " href="#" data-toggle="modal" data-target="#step_update_profile">

                        <span><i class="fas fa-users step_icon"></i></span>
                        <span class=" clorange f16"> Hoàn thiện hồ sơ</span>
                    </a> -->
                    <a class="clorange" href="{{ route('show_file_job_facebook') }}">
                        <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                        <span class="clorange  f16"> Hoàn thiện hồ sơ</span>
                    </a>
                @endif

                <img class="next_step" src="{{ asset('assets/image/next.png') }}">
                <div class="modal fade" id="step_update_profile" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Hoàn thiện hồ sơ</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <a>Lưu ý : Nếu bạn thay đổi thông tin CV thì bạn vui lòng lưu CV trước khi quay lại bước
                                    hoàn thiện hồ sơ</a>
                            </div>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-secondary" data-dismiss="modal"
                                   style="    padding: .375rem .75rem;;color: #fff">Đóng</a>
                                <a type="button" class="btn btn-primary" href="{{ route('show_file_job_facebook') }}"
                                   style="    padding: .375rem .75rem;">Quay lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="item_step">
                <?php
                //xác thực tài khoản
                $employee_id_cv = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
                $check_cv_employee = '';
                $check_cv_employee = \App\Entity\Cv_employee::check_cv_employee($employee_id_cv->employee_id);
                ?>
                @if(!empty($check_cv_employee))
                    <a class="clgreen step_active_link_success">
                        <span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
                        <span class=" clgreen f16"> Tạo CV</span>
                    </a>
                @else
                    <a class="clorange step_active_link item_no_success">
                        <span><i class="fas fa-id-card step_icon"></i></span>
                        <span class=" clorange f16"> Tạo CV</span>
                    </a>
                @endif

                <img class="next_step" src="{{ asset('assets/image/next.png') }}">
            </div>


            <div class="item_step">
                <!-- <a class=" clgreen " href="#" data-toggle="modal" data-target="#step_syll">
                    <span> <i class="fab fa-discourse step_icon"></i></span>
                    <span class=" clgreen f16">Khóa học sandev</span>
                </a> -->
                <a class="clgreen" href="{{ route('course_index') }}">
                    <span> <i class="fab fa-discourse step_icon"></i></span>
                    <span class=" clgreen f16">Khóa học sanketoan</span>
                </a>
                <div class="modal fade" id="step_syll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Khóa học của sandev.vn</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <a>Lưu ý : Nếu bạn thay đổi thông tin CV thì bạn vui lòng lưu CV trước khi chuyển sang
                                    bước tiếp theo</a>
                            </div>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-secondary" data-dismiss="modal"
                                   style="padding: .375rem .75rem;;color: #fff">Đóng</a>
                                <a type="button" class="btn btn-primary" href="{{ route('course_index') }}"
                                   style="    padding: .375rem .75rem;">Tiếp tục</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <section class="sc_upload_cv_option">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-md-12">
                    <div class="mgt15 mgb15">
                        @if(session('suscess'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert"
                                 style="margin-top: 15px;width: 100%">
                                <strong>{{ session('suscess') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert"
                                 style="margin-top: 15px;width: 100%">
                                <strong>{{ session('error') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-12 text-center mgt20">
                    <form method="post" enctype="multipart/form-data" action="{{ route('ajax_upload_emplyee_cv') }}">
                        <label for="input_file_cv" id="label_file_cv" class="btn btn-sm btn-info">
                            <i class="fas fa-paperclip"></i> CV đính kèm
                        </label>
                        <small class="d-block name_file_cv">Không có tệp nào được chọn</small>
                        <small class="d-block"><i>CV định dạng pdf, dung lượng <= 10 MB</i></small>
                        <input type="file" name="file" id="input_file_cv" style="visibility:hidden;height:1px;width:1px">
                        <button class="btn_button_save mgt15 mgl10" type="submit" id="" value="save" name="export" style="width: 100%">
                            <span>Lưu CV </span> <i class="fa fa-floppy-o"></i></button>

                    </form>
                    <div class="noti_appro_cv">
                    <!-- @if(!empty($employee_cv->employee_cv_status))
                        <p class="f16 clGreen">
                            CV của bạn đã duyệt
                        </p>
                    @else
                        <p class="f16 clRed">CV của bạn chưa đươc duyệt</p>
                    @endif -->
                    </div>
                </div>
<<<<<<< HEAD
				
				
				
                <div class="col-md-12 col-xl-8 offset-xl-2">
                    <div style="width: 100%" class="cv_affter_upload">
                        @if(!empty($employee_cv->employee_link_cv) || file_exists(public_path($link_cv_upload_public)))
							
							  <?php
                $path_forder_images = public_path('/library_employee_cv/' . \Illuminate\Support\Facades\Auth::user()->id);
                $files_uploadted = glob($path_forder_images . '/*'); // get all file names
                foreach ($files_uploadted as $file_uploadted) { // iterate files
                    echo $file_uploadted.'</br>';
                }
                ?>
				
						
=======




                <div class="col-md-12 col-xl-8 offset-xl-2">
                    <div style="width: 100%" class="cv_affter_upload">
                        @if(!empty($employee_cv->employee_link_cv) || file_exists(public_path($link_cv_upload_public)))

                            <?php
                            $path_forder_images = public_path('/library_employee_cv/' . \Illuminate\Support\Facades\Auth::user()->id);
                            $files_uploadted = glob($path_forder_images . '/*'); // get all file names
                            foreach ($files_uploadted as $file_uploadted) { // iterate files
                                echo $file_uploadted.'</br>';
                            }
                            ?>

>>>>>>> bec2cd0ef2417b66a2a5bacb4d844b978902d663
                            @if(substr($employee_cv->employee_link_cv,-3) == 'pdf')
                                <embed style="width: 100%;height: 550px"
                                       src="{{ asset($employee_cv->employee_link_cv) }}#toolbar=0&view=fitH"
                                       type="application/pdf"/>
                            @endif
                        @else
                            <p class="text-center">File CV Chưa được upload</p>
                        @endif

                    </div>
                </div>
<<<<<<< HEAD
				
				
=======


>>>>>>> bec2cd0ef2417b66a2a5bacb4d844b978902d663
            </div>

        </div>
    </section>
    <div class="ctrl_nortification_success d-none">
        <span class="nortification success"><i class="fas fa-check-circle"></i> <span class="nortification_content"></span></span>
    </div>
    <div class="ctrl_nortification_danger d-none">
        <span class="nortification danger"><i class="fas fa-times-circle"></i> <span class="nortification_content"></span></span>
    </div>
@endsection
