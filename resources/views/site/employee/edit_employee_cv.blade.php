@extends('site.layout.site')
@section('title', 'Tạo CV')
@section('meta_description', 'Tạo CV')
@section('keywords', 'Tạo CV')
<style>
	@page{
	margin:0;
	}
</style>
@section('content')
<link rel="stylesheet" href="{{ asset('employee_cv') }}/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('employee_cv') }}/slick/slick.css" type="text/css">
<link rel="stylesheet" href="{{ asset('employee_cv') }}/slick/slick-theme.css" type="text/css">
<link rel="stylesheet" href="{{ asset('employee_cv') }}/style.css@v=57.css" type="text/css">
<script src="{{ asset('employee_cv') }}/jquery.min.js"></script>
<div id="btn-shadow"></div>
<style type="text/css">
.none_in_hoso{
	display:none;
}
	.blog-hd {
	display: table;
	width: 100%
	}
	#a {
	display: table;
	width: 100%
	}
	.menu_nncv .dm_more {
	z-index: 9999;
	}
	#hoso-scroll {
	z-index: 0;
	}
textarea::-webkit-input-placeholder , input::-webkit-input-placeholder {
	color: #372d2d96;
}

textarea:-moz-placeholder ,input:-moz-placeholder { /* Firefox 18- */
	color: #372d2d96;
}
#cv-profile-job
{
	font-size: 16px;
	line-height: 12px;
}
textarea::-moz-placeholder , input::-moz-placeholder {  /* Firefox 19+ */
	color: #372d2d96;
}

textarea:-ms-input-placeholder , input:-ms-input-placeholder {
	color: #372d2d96;
}

textarea::placeholder , input::placeholder {
	color: #372d2d96;
}
</style>

<link rel="stylesheet" href="{{ asset('employee_cv') }}/roboto.css" type="text/css">
<link rel="stylesheet" href="{{ asset('employee_cv') }}/cvh.css" type="text/css">
<link rel="stylesheet" href="{{ asset('employee_cv') }}/cropper.css" type="text/css">

<link rel="stylesheet" href="{{ asset('employee_cv') }}/cuscv.css" type="text/css">


<script src="{{ asset('employee_cv') }}/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>


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
				<a class="clgreen " href="#" data-toggle="modal" data-target="#step_status_acoount">
					<span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
					<span class="clgreen f16"> Xác thực tài khoản</span>
				</a>
			@else
				<a class="clorang  item_no_success" href="#" data-toggle="modal" data-target="#step_status_acoount">
					<span><i class="fas fa-check  step_icon "></i></span>
					<span class="clorang f16"> Xác thực tài khoản</span>
				</a>
			@endif
			<img class="next_step" src="{{ asset('assets/image/next.png') }}">
			<div class="modal fade" id="step_status_acoount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Xác thực tài khoản</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<a>Lưu ý : Nếu bạn thay đổi thông tin CV thì bạn vui lòng lưu CV trước khi quay lại bước xác thực tài khoản</a>
						</div>
						<div class="modal-footer">
							<a type="button" class="btn btn-secondary" data-dismiss="modal" style="    padding: .375rem .75rem;;color: #fff">Đóng</a>
							<a type="button" class="btn btn-primary" href="{{ route('management_account') }}" style="    padding: .375rem .75rem;">Quay lại</a>
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
				<a class="clgreen" href="#" data-toggle="modal" data-target="#step_update_profile">
					<span> <img src="{{ asset('assets/image/check_png.png') }}" width="45px"></span>
					<span class="clgreen  f16"> Hoàn thiện hồ sơ</span>
				</a>
			@else
				<a class="clorange " href="#" data-toggle="modal" data-target="#step_update_profile">

					<span><i class="fas fa-users step_icon"></i></span>
					<span class=" clorange f16"> Hoàn thiện hồ sơ</span>
				</a>
			@endif

			<img class="next_step" src="{{ asset('assets/image/next.png') }}">
			<div class="modal fade" id="step_update_profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Hoàn thiện hồ sơ</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<a>Lưu ý : Nếu bạn thay đổi thông tin CV thì bạn vui lòng lưu CV trước khi quay lại bước hoàn thiện hồ sơ</a>
						</div>
						<div class="modal-footer">
							<a type="button" class="btn btn-secondary" data-dismiss="modal" style="    padding: .375rem .75rem;;color: #fff">Đóng</a>
							<a type="button" class="btn btn-primary" href="{{ route('show_file_job_facebook') }}" style="    padding: .375rem .75rem;">Quay lại</a>
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
			<a class=" clgreen " href="#" data-toggle="modal" data-target="#step_syll">
				<span> <i class="fab fa-discourse step_icon"></i></span>
				<span class=" clgreen f16">Khóa học sanketoan</span>
			</a>
			<div class="modal fade" id="step_syll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Khóa học của sanektoan.vn</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<a>Lưu ý : Nếu bạn thay đổi thông tin CV thì bạn vui lòng lưu CV trước khi chuyển sang bước tiếp theo</a>
						</div>
						<div class="modal-footer">
							<a type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: .375rem .75rem;;color: #fff">Đóng</a>
							<a type="button" class="btn btn-primary" href="{{ route('course_index') }}" style="    padding: .375rem .75rem;">Tiếp tục</a>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<section class="create_cv_employee_container">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 mb_scroll_500">
				<form action="{{ route('store_update_cv')  }}" method="POST" id="js_height_textarea">
					{!! csrf_field() !!}
					<div class="row sticky-top" id="cvo-toolbar1" style="z-index:200">
						<div class="col-12">
							<div class="toolbar-global-controls ">
								<div class="ctr">
									{{--
									<div class="item" id="cvo-toolbar-lang">
										--}}
										{{--
										<div class="title">Ngôn ngữ</div>
										--}}
										{{--
										<div class="options">--}}
											{{--<span class="flag btn-lang-option vi active" data-lang="vi" >--}}
											{{--<img src="vi.png">--}}
											{{--<i class="flag-selected"></i>--}}
											{{--</span>--}}
											{{--<span class="flag btn-lang-option en" data-lang="en" >--}}
											{{--<img src="en.png">--}}
											{{--<i class="flag-selected"></i>--}}
											{{--</span>--}}
											{{--<span class="flag btn-lang-option jp" data-lang="jp" >--}}
											{{--<img src="jp.png">--}}
											{{--<i class="flag-selected"></i>--}}
											{{--</span>--}}
											{{--<span class="flag btn-lang-option cn" data-lang="cn" >--}}
											{{--<img src="cn.png">--}}
											{{--<i class="flag-selected"></i>--}}
											{{--</span>--}}
											{{--<span class="flag btn-lang-option kr" data-lang="kr" >--}}
											{{--<img src="kr.png">--}}
											{{--<i class="flag-selected"></i>--}}
											{{--</span>--}}
											{{--
										</div>
										--}}
										{{--
									</div>
									--}}
									<div class="item" id="toolbar-color">
										<div class="title mbds_none_500">Tông màu</div>
										<div class="options">
											<?php
												$cv_color = '';
												$cv_color = App\Entity\Cv_color::get_all($cv_template->cv_template_id);
												?>
											@foreach($cv_color as $id_cl=>$color)
											<span class="color @if($color->cv_color_id == $cv_employee->cv_color) active @endif my_color_cv{{$id_cl + 1}}"
												data_cl="{{ isset($color->cv_color_id) ? $color->cv_color_id : '' }}"
												style="background-color:{{ isset($color->code_color) ? $color->code_color : '' }}"
												data-color="{{ isset($color->code_color) ? $color->code_color : '' }}"><i
												class="fa fa-check"></i></span>
											<input type="radio" name="cv_color"
											value="{{ isset($color->cv_color_id) ? $color->cv_color_id : '' }}"
											@if($color->cv_color_id ==  $cv_employee->cv_color) checked
											@endif id="checkked{{$color->cv_color_id }}"
											style="display: none"
											>
											@endforeach
										</div>
									</div>
									<div class="item button mbds_none_500" id="btn-edit-layout">
										<div class="title">Thêm mục</div>
										<i class="fa fa-plus-circle f24"></i>
									</div>

									<div class="show_hidden_employee_cv_desktop">
									<a class="btn_button_save mgt15 mgl10"  href="{{ route('show_file_job_facebook') }}" style="background: red">
										<i class="fas fa-long-arrow-alt-left f26" style="vertical-align: middle;"></i><span> Quay Lại</span>
									</a>


									<button class="btn_button_save mgt15 mgl10" type="submit" value="save" name="export">
										Lưu CV
										<i class="fa fa-floppy-o"></i>
									</button>

									<button formtarget="_blank" type="submit" value="export" name="export" class="btn_button_save mgt15 mgl10">
											<span>Xuất CV
											</span>
										<i class="fas fa-file-export"></i>
									</button>

									</div>
									<div class="show_hidden_employee_cv_mobile">
										<button class="btn_button_save mgt15 mgl10" type="submit" value="save" name="export">
											<span>Lưu CV
											</span>
											<i class="fa fa-floppy-o"></i>
										</button>
										<button formtarget="_blank" type="submit" value="export" name="export" class="btn_button_save mgt15 mgl10">
											<span>Xuất CV
											</span>
											<i class="fas fa-file-export"></i>
										</button>


									</div>

								</div>
							</div>
						</div>
					</div>
					<div style="width: 100%;overflow: auto">
					<div class="blog-hd" id="page-taocv">
						<div class="clr"></div>
						<div id="cvo-toolbar">
							{{--
							<div id="cv-form-text-editor" style="display: block;">
								--}}
								{{--
								<div class="ctr">
									--}}
									{{--
									<div class="editor-controls-wraper">
										--}}
										{{--
										<div class="editor-controls" id="tools">--}}
											{{--
										</div>
										--}}
										{{--
									</div>
									--}}
									{{--
								</div>
								--}}
								{{--
							</div>
							--}}
						</div>
						<div class="ctr" id="scollProduct">
							<!-- Giao dien mau thu-->
							<link rel="stylesheet"
								href="{{ asset('employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/cv.css"
								type="text/css">
							<link id="cv-color-css" rel="stylesheet"
								href="{{ asset('employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/colors/3a93a5.css@v=1.css"
								type="text/css">
							{{--
							<link id="cv-font" rel="stylesheet" href="{{ asset('employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/fonts/Roboto.css" type="text/css">
							--}}
							{{--
							<link id="cv-font-size" rel="stylesheet" href="{{ asset('employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/font-size/normal.css" type="text/css">
							--}}
							{{--
							<link id="cv-cpacing-css" rel="stylesheet" href="{{ asset('employee_cv') }}/cv/thiet-ke-co-dien/ke-toan-9/css/font-spacing/normal.css" type="text/css">
							--}}
							@if(session('success'))
								<div class="alert alert-success alert-dismissible fade show" role="alert"
									 style="margin-top: 15px;width: 100%">
									<strong>{{ session('success') }}</strong>
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

							<div id="page-cv" class="">
								<input type="hidden" name="cv_id" value="{{ $cv_employee->cv_id  }}">
								<input type="hidden" name="cv_template_id" value="{{ $cv_employee->cv_template_id  }}">
								<input type="hidden" name="cv_color_template" id="cv_color"
									value="{{ $cv_employee->cv_color  }}">
								<input id="cv-title"  name="cv_title" class="non-printable" contenteditable=""
									cvo-validatable=""
									placeholder="Tiêu đề CV"
									value="{{!empty($employee->employee_name) ? $employee->employee_name : '' }}">
								<div id="form-cv" class="">
									<div id="cv-top">
										<div id="cvo-profile">
											<div class="box-01">
												<div id="cvo-profile-avatar-wraper">
													{{--<input type="button"--}}
													{{--value="Chọn ảnh"--}}
													{{--size="20" class="error_text_images"/>--}}
													<img class="" src="{{ !empty($employee->employee_image) ? asset($employee->employee_image) : asset('assets/image/no_avatar.jpg') }}"
														width="80" height=""/>
													<input name="images" type="text"
														value="{{ isset($employee->employee_image) ? $employee->employee_image : asset('assets/image/no_avatar.jpg') }}"
														style="border:none !important;color: #fff !important;position: absolute;left: 0;width: 84px;z-index: -9;"/>
												</div>
												<div id="box-hvt" data_show="note_title_reference_person" data_title="{{ 'Thông tin cá nhân' }}" class="js_click_box ">
													<h1><input id="cv-profile-fullname" name="cv_namecv_name"
														placeholder="Họ tên"
														contenteditable="true" readonly
														value="{{!empty($employee->employee_name) ? $employee->employee_name : '' }}">
													</h1>
													<h2>
														<?php
														$career_category_name = '';
														$list_career = \App\Entity\Employee_career_categories::get_array_name($employee->employee_id);
														if (!empty($list_career)) {
															foreach ($list_career as $id => $career) {
																if ($id == 0) {
																	$career_category_name = $career->career_category_name;
																} else {
																	$career_category_name .= ' | ' . $career->career_category_name;
																}
															}
														}
														?>
														<textarea id="cv-profile-job" name="cv_title_job" readonly
																  contenteditable="true"
																  placeholder="Vị trí công việc bạn muốn ứng tuyển" >
                                                                    @foreach($list_career as $career)
																- {{ $career->career_category_name }}
															@endforeach
                                                                </textarea>
													</h2>
													<p><span id="cv-profile-about"></span></p>
												</div>
												<div class="clr"></div>
											</div>
										</div>
									</div>
									<div id="cv-main">
										<div id="cv-content">
											<div class="ir" id="sort_block">
												<?php
													$order_right = array();
													$order_right = explode(',', $cv_employee->cv_order_join);
													$show_hidden_right = array();
													$show_hidden_right = explode(',', $cv_employee->show_hidden_cv_order_join);
													?>
												@foreach($order_right as $or_right)
												@if($or_right == 1)
												{{--trình độ học vấn--}}
												<div id="block01" data_show="note_title_cv_specialize" data_title="{{ !empty($cv_employee->title_cv_specialize) ? $cv_employee->title_cv_specialize : 'Trình độ học vấn' }}" data_box="block01"
												class="js_click_box cvo-block"
												@if(!empty($show_hidden_right[0])) style="display: none" @endif >
												<input type="hidden" name="cv_order_join[]" value="1">
												<input type="hidden" name="show_hidden_cv_order_join[]"
												class="show_hidden_cv_order"
												@if(!empty($show_hidden_right[0])) value="1"
												@else value="0" @endif>
												<div class="blockControls">
													<div title="Di chuyển khối"
														class="show-layout-editor"><i
														class="fa fa-bars"></i></div>
													<div title="Chuyển mục này lên trên" class="up">▲
													</div>
													<div title="Chuyển mục này xuống dưới" class="down">
														▼
													</div>
													<div title="Ẩn mục này" class="hide"><i
														class="fa fa-minus"></i> Ẩn
													</div>
													<div style="background-color: #f15c4c;
                                                    width: 90px;font-family: tahoma;
                                                    display: inline-block;
                                                    text-align: center;
                                                    cursor: pointer;
                                                    font-weight: 700;
                                                    margin: 0 auto;
                                                    line-height: 14px;
                                                    font-size: 12px;
                                                    color: #fff;
                                                    border-radius: 5px;
                                                    padding: 5px;
                                                    margin-top: 6px;" class="title_cv_specialize_plus"><i
														class="fa fa-plus"></i> Thêm
													</div>
												</div>
												<p class="head">
													<input id="" class="block-title"
														placeholder="Tiêu đề mục lớn"
														contenteditable="true"
														value="{{ !empty($cv_employee->title_cv_specialize) ? $cv_employee->title_cv_specialize : 'Trình độ học vấn' }}"
														name="title_cv_specialize">
												</p>
												<div id="experience-table1">
													<?php
														$list_cv_spe = \App\Entity\Cv_specialize::get_cv_id($cv_employee->cv_id);
														?>
													@if(!empty($list_cv_spe))
													@foreach($list_cv_spe as $id_spec=>$spec)
													<div id="exp{{ $id_spec + 1 }}"
														class="ctbx experience">
														<div class="fieldgroup_controls">
															<div class="clone"><i
																class="fa fa-plus"></i>
																Thêm
															</div>
															<div class="remove"><i
																class="fa fa-minus"></i>
																Xóa
															</div>
														</div>
														<h3>
															<input class="exp-title"
																contenteditable="true"
																placeholder="Tên trường học"
																name="cv_spec_title[]"
																value="{{ !empty($spec->cv_spec_title) ? $spec->cv_spec_title : '' }}">
														</h3>
														<p class="h3"><input
															name="cv_spec_name[]"
															class="exp-subtitle"
															placeholder="Chuyên ngành"
															contenteditable="true"
															value="{{ !empty($spec->cv_spec_name) ? $spec->cv_spec_name : '' }}">
														</p>
														<textarea class="exp-content"
															contenteditable="true"
															placeholder="Mô tả chi tiết trong quá trình học làm việc."
															name="cv_spec_desc[]">{{ !empty($spec->cv_spec_desc) ? $spec->cv_spec_desc : '' }}</textarea>
													</div>
													@endforeach
													@endif
												</div>
											</div>
											@endif
											@if($or_right == 2)
											{{--kinh nghiệm làm việc--}}
											<div id="block02" data_show="note_title_cv_experience" data_title="{{ !empty($cv_employee->title_cv_experience) ? $cv_employee->title_cv_experience : 'Kinh nghiệm làm việc' }}" data_box="block02"
											class="js_click_box cvo-block"
											@if(!empty($show_hidden_right[1])) style="display: none" @endif>
											<input type="hidden" name="cv_order_join[]" value="2">
											<input type="hidden" name="show_hidden_cv_order_join[]"
											class="show_hidden_cv_order"
											@if(!empty($show_hidden_right[1])) value="1"
											@else value="0" @endif>
											<div class="blockControls">
												<div title="Di chuyển khối"
													class="show-layout-editor"><i
													class="fa fa-bars"></i></div>
												<div title="Chuyển mục này lên trên" class="up">▲
												</div>
												<div title="Chuyển mục này xuống dưới" class="down">
													▼
												</div>
												<div title="Ẩn mục này" class="hide"><i
													class="fa fa-minus"></i> Ẩn
                                                </div>
                                                <div style="background-color: #f15c4c;
                                                    width: 90px;font-family: tahoma;
                                                    display: inline-block;
                                                    text-align: center;
                                                    cursor: pointer;
                                                    font-weight: 700;
                                                    margin: 0 auto;
                                                    line-height: 14px;
                                                    font-size: 12px;
                                                    color: #fff;
                                                    border-radius: 5px;
                                                    padding: 5px;
                                                    margin-top: 6px;" class=" title_cv_experience_plus"><i
														class="fa fa-plus"></i> Thêm
												</div>
											</div>
											<p class="head">
												<input id="" class="block-title"
													placeholder="Tiêu đề mục lớn"
													contenteditable="true"
													value="{{ !empty($cv_employee->title_cv_experience) ? $cv_employee->title_cv_experience : 'Kinh nghiệm làm việc' }}"
													name="title_cv_experience">
											</p>
											<div id="experience-table2">
												<?php
													$list_cv_ex = \App\Entity\Cv_experience::get_cv_id($cv_employee->cv_id);
													?>
												@if(!empty($list_cv_ex))
												@foreach($list_cv_ex as $id_ex=>$ex)
												<div id="exp{{$id_ex + 1}}"
													class="ctbx experience">
													<div class="fieldgroup_controls">
														<div class="clone"><i
															class="fa fa-plus"></i>
															Thêm
														</div>
														<div class="remove"><i
															class="fa fa-minus"></i>
															Xóa
														</div>
													</div>
													<h3>
														<input class="exp-title"
															contenteditable="true"
															placeholder="Tên công ty"
															name="cv_ex_title[]"
															value="{{ !empty($ex->cv_ex_title) ? $ex->cv_ex_title : '' }}">
													</h3>
													<p class="h3"><input
														class="exp-subtitle"
														placeholder="Vị trí công việc"
														contenteditable="true"
														name="cv_ex_name[]"
														value="{{ !empty($ex->cv_ex_name) ? $ex->cv_ex_name : '' }}">
													</p>
													<textarea name="cv_ex_desc[]"
														class="exp-content"
														contenteditable="true"
														placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">{{ !empty($ex->cv_ex_desc) ? $ex->cv_ex_desc : '' }} </textarea>
												</div>
												@endforeach
												@endif
											</div>
										</div>
										@endif
										@if($or_right == 3)
										{{--Hoạt động--}}
										<div id="block03"  data_show="note_title_cv_work" data_title="{{ !empty($cv_employee->title_cv_work) ? $cv_employee->title_cv_work : 'Hoạt động' }}" data_box="block03"
										class="js_click_box cvo-block"
										@if(!empty($show_hidden_right[2])) style="display: none" @endif>
										<input type="hidden" name="cv_order_join[]" value="3">
										<input type="hidden" name="show_hidden_cv_order_join[]"
										class="show_hidden_cv_order"
										@if(!empty($show_hidden_right[2])) value="1"
										@else value="0" @endif>
										<div class="blockControls">
											<div title="Di chuyển khối"
												class="show-layout-editor"><i
												class="fa fa-bars"></i></div>
											<div title="Chuyển mục này lên trên" class="up">▲
											</div>
											<div title="Chuyển mục này xuống dưới" class="down">
												▼
											</div>
											<div title="Ẩn mục này" class="hide"><i
												class="fa fa-minus"></i> Ẩn
                                            </div>
                                            <div style="background-color: #f15c4c;
                                                    width: 90px;font-family: tahoma;
                                                    display: inline-block;
                                                    text-align: center;
                                                    cursor: pointer;
                                                    font-weight: 700;
                                                    margin: 0 auto;
                                                    line-height: 14px;
                                                    font-size: 12px;
                                                    color: #fff;
                                                    border-radius: 5px;
                                                    padding: 5px;
                                                    margin-top: 6px;" class="title_cv_work_plus"><i
														class="fa fa-plus"></i> Thêm
											</div>
										</div>
										<p class="head">
											<input name="title_cv_work" id=""
												class="block-title"
												placeholder="Tiêu đề mục lớn"
												contenteditable="true"
												value="{{ !empty($cv_employee->title_cv_work) ? $cv_employee->title_cv_work : 'Hoạt động' }}">
										</p>
										<div id="experience-table3">
											<?php
												$list_cv_work = \App\Entity\Cv_work::get_cv_id($cv_employee->cv_id);
												?>
											@if(!empty($list_cv_work))
											@foreach($list_cv_work as $id_work=>$work)
											<div id="exp{{ $id_work + 1 }}"
												class="ctbx experience">
												<div class="fieldgroup_controls">
													<div class="clone"><i
														class="fa fa-plus"></i>
														Thêm
													</div>
													<div class="remove"><i
														class="fa fa-minus"></i>
														Xóa
													</div>
												</div>
												<h3>
													<input class="exp-title"
														contenteditable="true"
														placeholder="Tên công ty"
														name="cv_work_title[]"
														value="{{ !empty($work->cv_work_title) ? $work->cv_work_title : '' }}">
												</h3>
												<p class="h3"><input
													name="cv_work_name[]"
													class="exp-subtitle"
													placeholder="Vị trí công việc"
													contenteditable="true"
													value="{{ !empty($work->cv_work_name) ? $work->cv_work_name : '' }}">
												</p>
												<textarea class="exp-content"
													contenteditable="true"
													placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc."
													name="cv_work_desc[]"> {{ !empty($work->cv_work_desc) ? $work->cv_work_desc : '' }}</textarea>
											</div>
											@endforeach
											@endif
										</div>
									</div>
									@endif
									@if($or_right == 4)
									{{--dự án tham gia--}}
									<div id="block04" data_show="note_title_cv_project" data_title="{{ !empty($cv_employee->title_cv_project) ? $cv_employee->title_cv_project : 'Dự án tham gia' }}" data_box="block04"
									class="js_click_box cvo-block"
									@if(!empty($show_hidden_right[3])) style="display: none" @endif>
									<input type="hidden" name="cv_order_join[]" value="4">
									<input type="hidden" name="show_hidden_cv_order_join[]"
									class="show_hidden_cv_order"
									@if(!empty($show_hidden_right[3])) value="1"
									@else value="0" @endif>
									<div class="blockControls">
										<div title="Di chuyển khối"
											class="show-layout-editor"><i
											class="fa fa-bars"></i></div>
										<div title="Chuyển mục này lên trên" class="up">▲
										</div>
										<div title="Chuyển mục này xuống dưới" class="down">
											▼
										</div>
										<div title="Ẩn mục này" class="hide"><i
											class="fa fa-minus"></i> Ẩn
                                        </div>
                                        <div style="background-color: #f15c4c;
                                                    width: 90px;font-family: tahoma;
                                                    display: inline-block;
                                                    text-align: center;
                                                    cursor: pointer;
                                                    font-weight: 700;
                                                    margin: 0 auto;
                                                    line-height: 14px;
                                                    font-size: 12px;
                                                    color: #fff;
                                                    border-radius: 5px;
                                                    padding: 5px;
                                                    margin-top: 6px;" class="title_cv_project_plus"><i
														class="fa fa-plus"></i> Thêm
											</div>
									</div>
									<p class="head">
										<input name="title_cv_project" id=""
											class="block-title"
											placeholder="Tiêu đề mục lớn"
											contenteditable="true"
											value="{{ !empty($cv_employee->title_cv_project) ? $cv_employee->title_cv_project : 'Dự án tham gia' }}">
									</p>
									<div id="experience-table4">
										<?php
											$list_cv_project = \App\Entity\Cv_project::get_cv_id($cv_employee->cv_id);
											?>
										@if(!empty($list_cv_project))
										@foreach($list_cv_project as $id_project=>$project)
										<div id="exp{{ $id_project + 1 }}"
											class="ctbx experience">
											<div class="fieldgroup_controls">
												<div class="clone"><i
													class="fa fa-plus"></i>
													Thêm
												</div>
												<div class="remove"><i
													class="fa fa-minus"></i>
													Xóa
												</div>
											</div>
											<h3>
												<input name="cv_project_title[]"
													class="exp-title"
													contenteditable="true"
													placeholder="Tên công ty"
													value="{{ !empty($project->cv_project_title) ? $project->cv_project_title : '' }}">
											</h3>
											<p class="h3"><input
												name="cv_project_name[]"
												class="exp-subtitle"
												placeholder="Vị trí công việc"
												contenteditable="true"
												value="{{ !empty($project->cv_project_name) ? $project->cv_project_name : '' }}">
											</p>
											<textarea name="cv_project_des[]"
												class="exp-content"
												contenteditable="true"
												placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">{{ !empty($project->cv_project_des) ? $project->cv_project_des : '' }}
                                        </textarea>
										</div>
										@endforeach
										@endif
									</div>
								</div>
								@endif
								@if($or_right == 5)
								{{--Thông tin thêm--}}
								<div id="block05"  data_show="note_title_cv_info" data_title="{{ !empty($cv_employee->title_cv_info) ? $cv_employee->title_cv_info : 'Thông tin thêm' }}" data_box="block05"
								class="js_click_box cvo-block"
								@if(!empty($show_hidden_right[4])) style="display: none" @endif>
								<input type="hidden" name="cv_order_join[]" value="5">
								<input type="hidden" name="show_hidden_cv_order_join[]"
								class="show_hidden_cv_order"
								@if(!empty($show_hidden_right[4])) value="1"
								@else value="0" @endif>
								<div class="blockControls">
									<div title="Di chuyển khối"
										class="show-layout-editor"><i
										class="fa fa-bars"></i></div>
									<div title="Chuyển mục này lên trên" class="up">▲
									</div>
									<div title="Chuyển mục này xuống dưới" class="down">
										▼
									</div>
									<div title="Ẩn mục này" class="hide"><i
										class="fa fa-minus"></i> Ẩn
                                    </div>
                                    <div style="background-color: #f15c4c;
                                                    width: 90px;font-family: tahoma;
                                                    display: inline-block;
                                                    text-align: center;
                                                    cursor: pointer;
                                                    font-weight: 700;
                                                    margin: 0 auto;
                                                    line-height: 14px;
                                                    font-size: 12px;
                                                    color: #fff;
                                                    border-radius: 5px;
                                                    padding: 5px;
                                                    margin-top: 6px;" class=" title_cv_info_plus"><i
														class="fa fa-plus"></i> Thêm
											</div>
								</div>
								<p class="head">
									<input name="title_cv_info" id=""
										class="block-title"
										placeholder="Tiêu đề mục lớn"
										contenteditable="true"
										value="{{ !empty($cv_employee->title_cv_info) ? $cv_employee->title_cv_info : 'Thông tin thêm' }}">
								</p>
								<div id="experience-table5">
									<?php
										$list_cv_info = \App\Entity\Cv_info::get_cv_id($cv_employee->cv_id);
										?>
									@if(!empty($list_cv_info))
									@foreach($list_cv_info as $id_info=>$info)
									<div id="exp{{ $id_info + 1 }}"
										class="ctbx experience">
										<div class="fieldgroup_controls">
											<div class="clone"><i
												class="fa fa-plus"></i>
												Thêm
											</div>
											<div class="remove"><i
												class="fa fa-minus"></i>
												Xóa
											</div>
										</div>
										<h3>
											<input name="cv_info_title[]"
												class="exp-title"
												contenteditable="true"
												placeholder="Tên công ty"
												value="{{ !empty($info->cv_info_title) ? $info->cv_info_title : '' }}">
										</h3>
										<p class="h3"><input
											name="cv_info_name[]"
											class="exp-subtitle"
											placeholder="Vị trí công việc"
											contenteditable="true"
											value="{{ !empty($info->cv_info_name) ? $info->cv_info_name : '' }}">
										</p>
										<textarea name="cv_info_des[]"
											class="exp-content"
											contenteditable="true"
											placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc.">{{ !empty($info->cv_info_des) ? $info->cv_info_des : '' }}</textarea>
									</div>
									@endforeach
									@endif
								</div>
							</div>
							@endif
							@endforeach
						</div>
					</div>
					<div id="cv-right">
						<div class="ir">
							<div id="sortable">
								<div id="box01" data_box="box01"
									data_show="note_title_reference_person" data_title="{{ 'Thông tin cá nhân' }}"
									class="js_click_box block cvo-block box-contact">
									<p class="icoweb cvi-envelope-square"><input type="email"
										id="cv-profile-email"
										placeholder="Email" readonly
										contenteditable="true"
										name="cv_email"
										value="{{!empty($cv_employee->cv_email) ? $cv_employee->cv_email : ''  }}">
									</p>
									<p class="icoweb cvi-phone"><input id="cv-profile-phone" readonly
										placeholder="Điện thoại"
										contenteditable="true"
										name="cv_phone"
										value="{{!empty($cv_employee->cv_phone) ? $cv_employee->cv_phone : ''  }}">
									</p>
									<p class="icoweb cvi-date"><input id="cv-profile-birthday" readonly
										placeholder="Ngày sinh"
										contenteditable="true"
										name="cv_birthday"
										value="{{!empty($cv_employee->cv_birthday) ? $cv_employee->cv_birthday : ''  }}">
									</p>
									<p class="icoweb cvi-map-marker" style="height:75px" readonly=""><textarea
										id="cv-profile-address"
										placeholder="Địa chỉ"
										contenteditable="true"
										name="cv_address"
										value="">{{!empty($cv_employee->cv_address ) ? $cv_employee->cv_address : $employee->address  }}</textarea>
                                    </p>

									<p class="icoweb cvi-info"><textarea style="height:60px" id="cv-profile-face"
										placeholder="Facebook"
										contenteditable="true"
										name="cv_facebook"
										value="">{{!empty($cv_employee->cv_facebook) ? $cv_employee->cv_facebook : $employee->my_facebook  }}</textarea>
									</p>
								</div>
								{{--tinh từ khoi block 2--}}
								<?php
									$order_left = array();
									$order_left = explode(',', $cv_employee->cv_order);

									$show_hidden_left = array();
									$show_hidden_left = explode(',', $cv_employee->show_hidden_cv_order);


									?>
								@foreach($order_left as $or_left)

								@if($or_left == 1)
								<div id="box02" data_box="box02"
								data_show="note_cv_title_career_goals" data_title="{{ !empty($cv_employee->cv_title_career_goals) ? $cv_employee->cv_title_career_goals : 'Thông tin thêm' }}"
								class="js_click_box block cvo-block"
								@if(!empty($show_hidden_left[0])) style="display: none" @endif>
								<input type="hidden" name="cv_order[]" value="1">
								<input type="hidden" name="show_hidden_cv_order[]"
								class="show_hidden_cv_order"
								@if(!empty($show_hidden_left[0])) value="1"
								@else value="0" @endif>
								<div class="blockControls">
									<div title="Di chuyển khối"
										class="show-layout-editor"><i
										class="fa fa-bars"></i></div>
									<div title="Chuyển mục này lên trên" class="up">
										▲
									</div>
									<div title="Chuyển mục này xuống dưới"
										class="down">▼
									</div>
									<div title="Ẩn mục này" class="hide"><i
										class="fa fa-minus"></i>
										Ẩn
									</div>
								</div>
								<h3>
									<input
										name="cv_title_career_goals"
										cv-form-field="true"
										contenteditable="true"
										placeholder="Mục tiêu nghề nghiệp"
										class="box-title input_title"
										value="{{!empty($cv_employee->cv_title_career_goals) ? $cv_employee->cv_title_career_goals : 'Mục tiêu nghề nghiệp' }}">
								</h3>
								<textarea name="cv_career_goals" class="box-content"
									contenteditable="true">{{!empty($cv_employee->cv_career_goals) ? $cv_employee->cv_career_goals : '' }}</textarea>
							</div>
							@endif
							@if($or_left == 2)
							<div id="box03" data_box="box03"
							data_show="note_title_cv_skills" data_title="{{!empty($cv_employee->title_cv_skills) ? $cv_employee->title_cv_skills : 'Kỹ năng' }}"
							class="js_click_box block cvo-block box-skills"
							@if(!empty($show_hidden_left[1])) style="display: none" @endif>
							<input type="hidden" name="cv_order[]" value="2">
							<input type="hidden" name="show_hidden_cv_order[]"
							class="show_hidden_cv_order"
							@if(!empty($show_hidden_left[1])) value="1"
							@else value="0" @endif>
							<div class="blockControls">
								<div title="Di chuyển khối"
									class="show-layout-editor"><i
									class="fa fa-bars"></i></div>
								<div title="Chuyển mục này lên trên" class="up">
									▲
								</div>
								<div title="Chuyển mục này xuống dưới"
									class="down">▼
								</div>
								<div title="Ẩn mục này" class="hide"><i
									class="fa fa-minus"></i>
									Ẩn
								</div>
								<div style="background-color: #f15c4c;
                                                    width: 90px;font-family: tahoma;
                                                    display: inline-block;
                                                    text-align: center;
                                                    cursor: pointer;
                                                    font-weight: 700;
                                                    margin: 0 auto;
                                                    line-height: 14px;
                                                    font-size: 12px;
                                                    color: #fff;
                                                    border-radius: 5px;
                                                    padding: 5px;
                                                    margin-top: 6px;" class="title_cv_skill_plus"><i
														class="fa fa-plus"></i> Thêm
											</div>
							</div>
							<h3><input name="title_cv_skills"
								cv-form-field="true"
								contenteditable="true"
								placeholder="Kỹ năng"
								class="box-title"
								value="{{!empty($cv_employee->title_cv_skills) ? $cv_employee->title_cv_skills : 'Kỹ năng' }}">
							</h3>
							<div class="exp content-edit skill">
								<?php
									$list_cv_skill = \App\Entity\Cv_skills::get_cv_id($cv_employee->cv_id);
									?>
								@if(!empty($list_cv_skill))
								@foreach($list_cv_skill as $id_skill=>$skill)
								<div class="ctbx">
									<div class="fieldgroup_controls">
										<div class="clone"><i
											class="fa fa-plus"></i>
											Thêm
										</div>
										<div class="edit js-edit-content">
											Sửa
										</div>
										<div class="remove"><i
											class="fa fa-minus"></i>
											Xóa
										</div>
									</div>
									<input name="cv_skill_title[]"
										class="skill-name"
										cv-form-field="true"
										contenteditable="true"
										value="{{ !empty($skill->cv_skill_title) ? $skill->cv_skill_title : '' }}">
									<div class="bar-exp">
										<div style="width: {{ !empty($skill->cv_skill_value) ? $skill->cv_skill_value : '50' }}%"></div>
									</div>
									<div class="bar-value-exp"><input
										name="cv_skill_value[]"
										min="0"
										max="100" type="text"
										value="{{ !empty($skill->cv_skill_value) ? $skill->cv_skill_value : '50' }}">
									</div>
								</div>
								@endforeach
								@endif
								<div class="clr"></div>
							</div>
						</div>
						@endif
						@if($or_left == 3)
						<div id="box04" data_box="box04"
						data_show="note_cv_title_prize" data_title="{{!empty($cv_employee->cv_title_prize) ? $cv_employee->cv_title_prize : 'Giải thưởng' }}"
						class="js_click_box block cvo-block"
						@if(!empty($show_hidden_left[2])) style="display: none" @endif>
						<input type="hidden" name="cv_order[]" value="3">
						<input type="hidden" name="show_hidden_cv_order[]"
						class="show_hidden_cv_order"
						@if(!empty($show_hidden_left[2])) value="1"
						@else value="0" @endif>
						<div class="blockControls">
							<div title="Di chuyển khối"
								class="show-layout-editor"><i
								class="fa fa-bars"></i></div>
							<div title="Chuyển mục này lên trên" class="up">
								▲
							</div>
							<div title="Chuyển mục này xuống dưới"
								class="down">▼
							</div>
							<div title="Ẩn mục này" class="hide"><i
								class="fa fa-minus"></i>
								Ẩn
							</div>
						</div>
						<h3>
							<input cv-form-field="true"
								contenteditable="true"
								placeholder="Giải thưởng" class="box-title"
								value="{{!empty($cv_employee->cv_title_prize) ? $cv_employee->cv_title_prize : 'Giải thưởng' }}"
								name="cv_title_prize">
						</h3>
						<p><textarea class="box-content" name="cv_prize"
							placeholder="Nội dung"
							contenteditable="true">{{!empty($cv_employee->cv_prize) ? $cv_employee->cv_prize : '' }}</textarea>
						</p>
					</div>
					@endif
					@if($or_left == 4)
					<div id="box05" data_box="box05"
					data_show="note_cv_title_card" data_title="{{!empty($cv_employee->cv_title_card) ? $cv_employee->cv_title_card : 'Chứng chỉ' }}"
					class="js_click_box block cvo-block"
					@if(!empty($show_hidden_left[3])) style="display: none" @endif>
					<input type="hidden" name="cv_order[]" value="4">
					<input type="hidden" name="show_hidden_cv_order[]"
					class="show_hidden_cv_order"
					@if(!empty($show_hidden_left[3])) value="1"
					@else value="0" @endif>
					<div class="blockControls">
						<div title="Di chuyển khối"
							class="show-layout-editor"><i
							class="fa fa-bars"></i></div>
						<div title="Chuyển mục này lên trên" class="up">
							▲
						</div>
						<div title="Chuyển mục này xuống dưới"
							class="down">▼
						</div>
						<div title="Ẩn mục này" class="hide"><i
							class="fa fa-minus"></i>
							Ẩn
						</div>
					</div>
					<h3>
						<input cv-form-field="true"
							contenteditable="true"
							placeholder="Chứng chỉ" class="box-title"
							value="{{!empty($cv_employee->cv_title_card) ? $cv_employee->cv_title_card : 'Chứng chỉ' }}"
							name="cv_title_card">
					</h3>
					<p><textarea name="cv_card" class="box-content"
						placeholder="Nội dung"
						contenteditable="true">{{!empty($cv_employee->cv_card) ? $cv_employee->cv_card : '' }} </textarea>
					</p>
			</div>
			@endif
			@if($or_left == 5)
			<div id="box06" data_box="box06"
			data_show="note_cv_title_interests" data_title="{{!empty($cv_employee->cv_title_interests) ? $cv_employee->cv_title_interests : 'Sở thích' }}"
			class="js_click_box block cvo-block"
			@if(!empty($show_hidden_left[4])) style="display: none" @endif>
			<input type="hidden" name="cv_order[]" value="5">
			<input type="hidden" name="show_hidden_cv_order[]"
			class="show_hidden_cv_order"
			@if(!empty($show_hidden_left[4])) value="1"
			@else value="0" @endif>
			<div class="blockControls">
			<div title="Di chuyển khối"
				class="show-layout-editor"><i
				class="fa fa-bars"></i></div>
			<div title="Chuyển mục này lên trên" class="up">
			▲
			</div>
			<div title="Chuyển mục này xuống dưới"
				class="down">▼
			</div>
			<div title="Ẩn mục này" class="hide"><i
				class="fa fa-minus"></i>
			Ẩn
			</div>
			</div>
			<h3>
			<input cv-form-field="true"
				contenteditable="true"
				placeholder="Sở thích" class="box-title"
				value="{{!empty($cv_employee->cv_title_interests) ? $cv_employee->cv_title_interests : 'Sở thích' }}"
				name="cv_title_interests">
			</h3>
			<p><textarea name="cv_interests" class="box-content"
				placeholder="Nội dung"
				contenteditable="true">{{!empty($cv_employee->cv_interests) ? $cv_employee->cv_interests : '' }}</textarea>
			</p>
		</div>
		@endif
		@if($or_left == 6)
		<div id="box07" data_box="box07"
		data_show="note_cv_title_reference_person" data_title="{{!empty($cv_employee->cv_title_reference_person) ? $cv_employee->cv_title_reference_person : 'Người tham chiếu' }}"
		class="js_click_box block cvo-block"
		@if(!empty($show_hidden_left[5])) style="display: none" @endif>
		<input type="hidden" name="cv_order[]" value="6">
		<input type="hidden" name="show_hidden_cv_order[]"
		class="show_hidden_cv_order"
		@if(!empty($show_hidden_left[5])) value="1"
		@else value="0" @endif>
		<div class="blockControls">
		<div title="Di chuyển khối"
			class="show-layout-editor"><i
			class="fa fa-bars"></i></div>
		<div title="Chuyển mục này lên trên" class="up">
		▲
		</div>
		<div title="Chuyển mục này xuống dưới"
			class="down">▼
		</div>
		<div title="Ẩn mục này" class="hide"><i
			class="fa fa-minus"></i>
		Ẩn
		</div>
		</div>
		<h3>
		<input cv-form-field="true"
			contenteditable="true"
			placeholder="Người tham chiếu" class="box-title"
			value="{{!empty($cv_employee->cv_title_reference_person) ? $cv_employee->cv_title_reference_person : 'Người tham chiếu' }}"
			name="cv_title_reference_person">
		</h3>
		<p><textarea name="cv_reference_person"
			class="box-content editor"
			id="cv_reference_person"
			placeholder="Nội dung"
			contenteditable="true">{{!empty($cv_employee->cv_reference_person) ? $cv_employee->cv_reference_person : '' }}</textarea>
		</p>
	</div>
	@endif
	@endforeach
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	{{--//sidebar--}}
	<div id="sidebar" class="hoso-scroll ">
	<div class="box-four make-me-sticky" id="">
	<div class="sidebar__inner">
	<div class="title_guide_cv">
	<h4 class="mg0"><i class="fa fa-info-circle"></i><span> Hướng dẫn</span>
	</h4>
	</div>
	<div class="item item_cv_note note_guide hidden_cv_guide show_cvguidden">
	<div class="content_guide_cv">
	{!!  isset($cv_note_template->note_guide) ? $cv_note_template->note_guide : '' !!}
	</div>
	</div>
	<div class="item item_cv_note note_cv_personal hidden_cv_guide">
	<div class="item_title_gui_cv">
	<h4><i class="fa fa-info-circle"></i> <span>Thông tin cá nhân</span></h4>
	</div>
	<div class="content_guide_cv">
	{!!  isset($cv_note_template->note_cv_personal) ? $cv_note_template->note_cv_personal : '' !!}
	</div>
	</div>
	<div class="item item_cv_note note_cv_title_career_goals hidden_cv_guide">
	<div class="item_title_gui_cv">
	<h4><i class="fa fa-check-circle"></i><span> Mục tiêu nghề nghiệp</span></h4>
	</div>
	<div class="content_guide_cv">
	{!!  isset($cv_note_template->note_cv_title_career_goals) ? $cv_note_template->note_cv_title_career_goals : '' !!}
	</div>
	</div>
	<div class="item item_cv_note note_cv_title_prize hidden_cv_guide">
	<div class="item_title_gui_cv">
	<h4><i class="fa fa-trophy"></i> <span>Giải thưởng</span></h4>
	</div>
	<div class="content_guide_cv">
	{!!  isset($cv_note_template->note_cv_title_prize) ? $cv_note_template->note_cv_title_prize : '' !!}
	</div>
	</div>
	<div class="item item_cv_note note_cv_title_card hidden_cv_guide">
	<div class="item_title_gui_cv">
	<h4><i class="fa fa-trophy"></i><span> Chứng chỉ</span></h4>
	</div>
	<div class="content_guide_cv">
	{!!  isset($cv_note_template->note_cv_title_card) ? $cv_note_template->note_cv_title_card : '' !!}
	</div>
	</div>
	<div class="item item_cv_note note_cv_title_interests hidden_cv_guide">
	<div class="item_title_gui_cv">
	<h4><i class="fa fa-heart"></i><span> Sở thích</span></h4>
	</div>
	<div class="content_guide_cv">
	{!!  isset($cv_note_template->note_cv_title_interests) ? $cv_note_template->note_cv_title_interests : '' !!}
	</div>
	</div>
	<div class="item item_cv_note note_title_reference_person hidden_cv_guide">
	<div class="item_title_gui_cv">
	<h4><i class="fa fa-bookmark"></i><span> Liên hệ (người tham chiếu)</span></h4>
	</div>
	<div class="content_guide_cv">
	{!!  isset($cv_note_template->note_title_reference_person) ? $cv_note_template->note_title_reference_person : '' !!}
	</div>
	</div>
	<div class="item item_cv_note note_title_cv_skills hidden_cv_guide">
	<div class="item_title_gui_cv">
	<h4><i class="fa fa-magic"></i> <span>Kỹ năng</span></h4>
	</div>
	<div class="content_guide_cv">
	{!!  isset($cv_note_template->note_title_cv_skills) ? $cv_note_template->note_title_cv_skills : '' !!}
	</div>
	</div>
	<div class="item item_cv_note note_title_cv_specialize hidden_cv_guide">
	<div class="item_title_gui_cv">
	<h4><i class="fa fa-graduation-cap"></i><span> Trình độ</span></h4>
	</div>
	<div class="content_guide_cv">
	{!!  isset($cv_note_template->note_title_cv_specialize) ? $cv_note_template->note_title_cv_specialize : '' !!}
	</div>
	</div>
	<div class="item item_cv_note note_title_cv_experience hidden_cv_guide">
	<div class="item_title_gui_cv">
	<h4><i class="fa fa-briefcase"></i> <span>Kinh nghiệm làm việc</span></h4>
	</div>
	<div class="content_guide_cv">
	{!!  isset($cv_note_template->note_title_cv_experience) ? $cv_note_template->note_title_cv_experience : '' !!}
	</div>
	</div>
	<div class="item item_cv_note note_title_cv_work hidden_cv_guide">
	<div class="item_title_gui_cv">
	<h4><i class="fa fa-group"></i> <span>Hoạt động xã hội</span></h4>
	</div>
	<div class="content_guide_cv">
	{!!  isset($cv_note_template->note_title_cv_work) ? $cv_note_template->note_title_cv_work : '' !!}
	</div>
	</div>
	<div class="item item_cv_note note_title_cv_project hidden_cv_guide">
	<div class="item_title_gui_cv">
	<h4><i class="fas fa-project-diagram"></i><span>Dự án tham gia</span></h4>
	</div>
	<div class="content_guide_cv">
	{!!  isset($cv_note_template->note_title_cv_project) ? $cv_note_template->note_title_cv_project : '' !!}
	</div>
	</div>
	<div class="item item_cv_note note_title_cv_info hidden_cv_guide">
	<div class="item_title_gui_cv">
	<h4><i class="fa fa-pencil"></i> <span>Thông tin khác</span></h4>
	</div>
	<div class="content_guide_cv">
	{!!  isset($cv_note_template->note_cv_info) ? $cv_note_template->note_cv_info : '' !!}
	</div>
	</div>

		{{-- <a class="btn_button_save mgt15 mgl10"  href="{{ route('show_step_profile_employee') }}" style="background: red">
			<i class="fas fa-long-arrow-alt-left f26" style="vertical-align: middle;"></i><span> Quay Lại</span>
		</a>



		<button class="btn_button_save mgt15 mgl10" type="submit" id="" value="save" name="export">
                                            <span>Lưu CV
                                            </span>
			<i class="fa fa-floppy-o"></i>
		</button>

		<button class="btn_button_save mgt15 mgl10" type="submit" id="" value="save_next" name="export">
                                            <span>Lưu Và Tiếp Tục
                                            </span>
			<i class="fas fa-long-arrow-alt-right"></i>
		</button>
		<button formtarget="_blank" type="submit" value="export" name="export" class="btn_button_save mgt15 mgl10">
                                            <span>Xuất CV
                                            </span>
			<i class="fas fa-file-export"></i>
		</button> --}}

	</div>
	</div>
	</div>
	</div>
	<div id="stop_cv"></div>
	</div>
					</div>
	</form>
	</div>
	</div>
	</div>
</section>
<div class="clr"></div>
<!-- Crop img -->
<div id="layout-editor-container">
	<div id="layout-editor">
		<div class="group">
			{{--
			<div class="block active" blockmain="menu" blockkey="box01">
				--}}
				{{--
				<div class="selector"><i class="fa fa-check"></i></div>
				--}}
				{{--<span>Thông tin liên hệ</span>--}}
				{{--<i class="fa fa-bars icon-order"></i>--}}
				{{--
			</div>
			--}}
			{{--Thông tin nội dung cơ bản--}}
			<!--                --><?php
				//                $order_left = array();
				//                $order_left = explode(',', $cv_employee->cv_order);
				//                $show_hidden_left = array();
				//                $show_hidden_left = explode(',', $cv_employee->show_hidden_cv_order);
				//                ?>
			@foreach($order_left as $or_left)
			@if($or_left == 1)
			<div class="block @if(!empty($show_hidden_left[0]))
				@else active @endif" blockmain="menu" blockkey="box02">
				<div class="selector"><i class="fa fa-check"></i></div>
				<span>Mục tiêu nghề nghiệp</span>
				<i class="fa fa-bars icon-order"></i>
			</div>
			@endif
			@if($or_left == 2)
			<div class="block @if(!empty($show_hidden_left[1]))
				@else active @endif" blockmain="menu" blockkey="box03">
				<div class="selector"><i class="fa fa-check"></i></div>
				<span>Kỹ năng</span>
				<i class="fa fa-bars icon-order"></i>
			</div>
			@endif
			@if($or_left == 3)
			<div class="block @if(!empty($show_hidden_left[2]))
				@else active @endif" blockmain="menu" blockkey="box04">
				<div class="selector"><i class="fa fa-check"></i></div>
				<span>Giải thưởng</span>
				<i class="fa fa-bars icon-order"></i>
			</div>
			@endif
			@if($or_left == 4)
			<div class="block @if(!empty($show_hidden_left[3]))
				@else active @endif" blockmain="menu" blockkey="box05">
				<div class="selector"><i class="fa fa-check"></i></div>
				<span>Chứng chỉ</span>
				<i class="fa fa-bars icon-order"></i>
			</div>
			@endif
			@if($or_left == 5)
			<div class="block @if(!empty($show_hidden_left[4]))
				@else active @endif" blockmain="menu" blockkey="box06">
				<div class="selector"><i class="fa fa-check"></i></div>
				<span>Sở thích</span>
				<i class="fa fa-bars icon-order"></i>
			</div>
			@endif
			@if($or_left == 6)
			<div class="block @if(!empty($show_hidden_left[5]))
				@else active @endif" blockmain="menu" blockkey="box07">
				<div class="selector"><i class="fa fa-check"></i></div>
				<span>Người tham chiếu</span>
				<i class="fa fa-bars icon-order"></i>
			</div>
			@endif
			@endforeach
		</div>
		<div class="group">
			<!--                --><?php
				//                $order_right = explode(',', $cv_employee->cv_order_join);
				//                $show_hidden_right = array();
				//                $show_hidden_right = explode(',', $cv_employee->show_hidden_cv_order_join);
				//                ?>
			{{--//thông tin kinh nghiệm làm việc và các chức năng khác--}}
			{{--?>--}}
			@foreach($order_right   as $or_right)
			@if($or_right == 1)
			<div class="block  @if(!empty($show_hidden_right[0]))
				@else active @endif " blockmain="experiences" blockkey="block01">
				<div class="selector"><i class="fa fa-check"></i></div>
				<span>{{ !empty($cv_employee->title_cv_specialize) ? $cv_employee->title_cv_specialize : 'Trình độ học vấn' }}</span>
				<i class="fa fa-bars icon-order"></i>
			</div>
			@endif
			@if($or_right == 2)
			<div class="block  @if(!empty($show_hidden_right[1]))
				@else active @endif" blockmain="experiences" blockkey="block02">
				<div class="selector"><i class="fa fa-check"></i></div>
				<span>{{ !empty($cv_employee->title_cv_experience) ? $cv_employee->title_cv_experience : 'Kinh nghiệm làm việc' }}</span>
				<i class="fa fa-bars icon-order"></i>
			</div>
			@endif
			@if($or_right == 3)
			<div class="block  @if(!empty($show_hidden_right[2]))
				@else active @endif" blockmain="experiences" blockkey="block03">
				<div class="selector"><i class="fa fa-check"></i></div>
				<span>{{ !empty($cv_employee->title_cv_work) ? $cv_employee->title_cv_work : 'Hoạt động' }}</span>
				<i class="fa fa-bars icon-order"></i>
			</div>
			@endif
			@if($or_right == 4)
			<div class="block  @if(!empty($show_hidden_right[3]))
				@else active @endif" blockmain="experiences" blockkey="block04">
				<div class="selector"><i class="fa fa-check"></i></div>
				<span>{{ !empty($cv_employee->title_cv_project) ? $cv_employee->title_cv_project : 'Dự án tham gia' }}</span>
				<i class="fa fa-bars icon-order"></i>
			</div>
			@endif
			@if($or_right == 5)
			<div class="block  @if(!empty($show_hidden_right[4]))
				@else active @endif" blockmain="experiences" blockkey="block05">
				<div class="selector"><i class="fa fa-check"></i></div>
				<span>{{ !empty($cv_employee->title_cv_info) ? $cv_employee->title_cv_info : 'Thông tin thêm' }}</span>
				<i class="fa fa-bars icon-order"></i>
			</div>
			@endif
			@endforeach
		</div>
		<div class="text-center action-bar">
			<button type="button" class="btn-cvo btn-primary btn-finish">Cập nhật</button>
		</div>
	</div>
</div>
<style>
</style>
<!-- <script src="js/jquery-ui.min.js" type="text/javascript"></script> -->
<!-- <script src="js/jquery.ui.touch-punch.min.js" type="text/javascript"></script> -->
<script src="{{ asset('employee_cv') }}/cropper.js" type="text/javascript"></script>
<script src="{{ asset('employee_cv') }}/jquery.validate.min.js"></script>
<script src="{{ asset('employee_cv') }}/html2canvas.js"></script>
<script src="{{ asset('employee_cv') }}/main.js@v=10"></script>
<script src="{{ asset('employee_cv') }}/cvh.js@v=20"></script>
<script src="{{ asset('employee_cv') }}/select2.min.js"></script>
<script src="{{ asset('employee_cv') }}/edit.js"></script>
<script src="{{ asset('employee_cv') }}/select2.min.js"></script>

<script src="{{ asset('employee_cv') }}/html2canvas.js"></script>
<script src="{{ asset('employee_cv') }}/dist/jspdf.debug.js"></script>
<script src="{{ asset('employee_cv') }}/slick/slick.min.js"></script>
<link rel="stylesheet" href="{{ asset('employee_cv') }}/select2.min.css" media="print"
	onload="if(media!='all')media='all'">

<script>
	$(document).on('click', '.title_cv_specialize_plus', function (e) {
		console.log('ok')
        $ittem1 =
        `
        <div id=""
            class="ctbx experience">
            <div class="fieldgroup_controls">
                <div class="clone"><i
                    class="fa fa-plus"></i>
                    Thêm
                </div>
                <div class="remove"><i
                    class="fa fa-minus"></i>
                    Xóa
                </div>
            </div>
            <h3>
                <input class="exp-title"
                    contenteditable="true"
                    placeholder="Tên trường học"
                    name="cv_spec_title[]"
                    value="">
            </h3>
            <p class="h3"><input
                name="cv_spec_name[]"
                class="exp-subtitle"
                placeholder="Chuyên ngành"
                contenteditable="true"
                value="">
            </p>
            <textarea class="exp-content"
                contenteditable="true"
                placeholder="Mô tả chi tiết trong quá trình học làm việc."
                name="cv_spec_desc[]"></textarea>
        </div>
        `
        ;
        $block1 = $(this).parent().parent().find('#experience-table1');
        $block1.append($ittem1);
	});
    //
	$(document).on('click', '.title_cv_info_plus', function (e) {
        $ittem2 =
        `
		<div id=""
			class="ctbx experience">
			<div class="fieldgroup_controls">
				<div class="clone"><i
					class="fa fa-plus"></i>
					Thêm
				</div>
				<div class="remove"><i
					class="fa fa-minus"></i>
					Xóa
				</div>
			</div>
			<h3>
				<input name="cv_info_title[]"
					class="exp-title"
					contenteditable="true"
					placeholder="Tên công ty"
					value="">
			</h3>
			<p class="h3"><input
				name="cv_info_name[]"
				class="exp-subtitle"
				placeholder="Vị trí công việc"
				contenteditable="true"
				value="">
			</p>
			<textarea name="cv_info_des[]"
				class="exp-content"
				contenteditable="true"
				placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc."></textarea>
		</div>
        `
        ;
        $block2 = $(this).parent().parent().find('#experience-table5');
        $block2.append($ittem2);
	});
	$(document).on('click', '.title_cv_experience_plus', function (e) {
		console.log('okw	')
        $ittem3 =
        `
        <div
        class="ctbx experience">
        <div class="fieldgroup_controls">
            <div class="clone"><i
                class="fa fa-plus"></i>
                Thêm
            </div>
            <div class="remove"><i
                class="fa fa-minus"></i>
                Xóa
            </div>
        </div>
        <h3>
            <input class="exp-title"
                contenteditable="true"
                placeholder="Tên công ty"
                name="cv_ex_title[]"
                value="">
        </h3>
        <p class="h3"><input
            class="exp-subtitle"
            placeholder="Vị trí công việc"
            contenteditable="true"
            name="cv_ex_name[]"
            value="">
        </p>
        <textarea name="cv_ex_desc[]"
            class="exp-content"
            contenteditable="true"
            placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc."></textarea>
    </div>
        `
        ;
        $block3 = $(this).parent().parent().find('#experience-table2');
        $block3.append($ittem3);
	});
	  $(document).on('click', '.title_cv_project_plus', function (e) {
        console.log('as')
        $ittem4 =
        `
        <div id="exp"
        class="ctbx experience">
        <div class="fieldgroup_controls">
            <div class="clone"><i
                class="fa fa-plus"></i>
                Thêm
            </div>
            <div class="remove"><i
                class="fa fa-minus"></i>
                Xóa
            </div>
        </div>
        <h3>
            <input name="cv_project_title[]"
                class="exp-title"
                contenteditable="true"
                placeholder="Tên công ty"
                value="">
        </h3>
        <p class="h3"><input
            name="cv_project_name[]"
            class="exp-subtitle"
            placeholder="Vị trí công việc"
            contenteditable="true"
            value="">
        </p>
        <textarea name="cv_project_des[]"
            class="exp-content"
            contenteditable="true"
            placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc."></textarea>
    </div>
        `
        ;

        $block4 = $(this).parent().parent().find('#experience-table4');
        $block4.append($ittem4);
	});

    $(document).on('click', '.title_cv_work_plus', function (e) {
        $ittem5 =
        `
        <div id="exp"
        class="ctbx experience">
        <div class="fieldgroup_controls">
            <div class="clone"><i
                class="fa fa-plus"></i>
                Thêm
            </div>
            <div class="remove"><i
                class="fa fa-minus"></i>
                Xóa
            </div>
        </div>
        <h3>
            <input class="exp-title"
                contenteditable="true"
                placeholder="Tên công ty"
                name="cv_work_title[]"
                value="">
        </h3>
        <p class="h3"><input
            name="cv_work_name[]"
            class="exp-subtitle"
            placeholder="Vị trí công việc"
            contenteditable="true"
            value="">
        </p>
        <textarea class="exp-content"
            contenteditable="true"
            placeholder="Mô tả chi tiết công việc, những gì đạt được trong quá trình làm việc."
            name="cv_work_desc[]"></textarea>
    </div>
        `
        ;
       
        $block5 = $(this).parent().parent().find('#experience-table3');
        $block5.append($ittem5);
	});
</script>
<style>
	.select2-container--default .select2-selection--multiple, .select2-container--default.select2-container--focus .select2-selection--multiple {
	border-color: #e3e3e3;
	outline: 0
	}
	.select2-container .select2-selection--single {
	height: 40px;
	font-size: 14px
	}
	.select2-container--default .select2-selection--single .select2-selection__rendered {
	height: 38px;
	line-height: 38px
	}
	.select2-container--default .select2-selection--single .select2-selection__arrow {
	top: 7px
	}
	.select2-container--default .select2-selection--single {
	border-radius: 4px !important;
	border-color: #e3e3e3
	}
	.select2-container .select2-selection--multiple {
	min-height: 40px
	}
	.select2-container .select2-search--inline .select2-search__field {
	font-size: 14px;
	line-height: normal;
	padding-top: 5px;
	}
</style>
<div class="" id="js_style_cv_color"></div>
<script src="{{ asset('employee_cv') }}/jquery.validate.min.js" async></script>
<script src="{{ asset('employee_cv') }}/cv.js@v=42" async></script>
{{--<script type="text/javascript"--}}
{{--src="https://mojotech.github.io/stickymojo/js/stickyMojo.js"></script>--}}
<script>
	$(document).ready(function () {
	    $('.js_click_box').click(function () {
	        var data_show = $(this).attr('data_show');
	        var data_title = $(this).attr('data_title');
	
	        $('.item_cv_note').css('display','none');
	        $('.'+data_show).show();
	        $('.item_title_gui_cv span').html(data_title);
	
	
	        console.log(data_show);
	        console.log(data_title);
	    });
	
	    $(window).scroll(function () {
	        if ($(this).scrollTop() > 180) {
	            $('#sidebar').css('top','90px');
	        } else {
	            $('#sidebar').css('top','inherit');
	        }
	    });
	});
	
	
</script>

<script type="text/javascript">
	if ($(window).width() < 1180) {
	    $("footer,.hd_top").css("width", "1170");
	}
</script>
<link rel="stylesheet" href="{{ asset('assets/css') }}/cusStyle_cv.css">

<script>
	$(document).ready(function () {
		$('.title_cv_skill_plus').on('click', function(){
			$('.exp.content-edit.skill').prepend(`
				<div class="ctbx">
					<div class="fieldgroup_controls">
						<div class="clone"><i
							class="fa fa-plus"></i>
							Thêm
						</div>
						<div class="edit js-edit-content">
							Sửa
						</div>
						<div class="remove"><i
							class="fa fa-minus"></i>
							Xóa
						</div>
					</div>
					<input name="cv_skill_title[]"
						class="skill-name"
						cv-form-field="true"
						contenteditable="true"
						placeholder="Tin học văn phòng"
						value="">
					<div class="bar-exp">
						<div style="50%"></div>
					</div>
					<div class="bar-value-exp"><input
						name="cv_skill_value[]"
						min="0"
						max="100" type="text"
						value="50">
					</div>
				</div>
			`);
		})

		$('.showOnLaptopMini').removeClass("sticky-top");
		$('.showOnDesktop').removeClass("sticky-top");
	
	    $('#js_height_textarea textarea').each(function () {
	        this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
	    }).on('input', function () {
	        this.style.height = 'auto';
	        this.style.height = (this.scrollHeight) + 'px';
	    });
	
	    //
	    // var color = $(this).attr('data_cl');
	    // var color2 = $(this).attr('data-color');
	    // console.log(color);
	    // console.log(color2);
	
	    <?php
		$color = \App\Entity\Cv_color::get_cv_color_id($cv_employee->cv_color);
		$list_color_cv = array();
		$list_color_cv = explode(',', $color['order_color']);
		//            echo $color['order_color'];
		//            echo '<pre>';
		//            print_r($list_color_cv);die();
		?>
	    var cl_cv_1 = '{{ $list_color_cv[0] }}';
	    var cl_cv_2 = '{{ $list_color_cv[1] }}';
	    var cl_cv_3 = '{{ $list_color_cv[2] }}';
	    var cl_cv_4 = '{{ $list_color_cv[3] }}';
	    var cl_cv_5 = '{{ $list_color_cv[4] }}';
	    var cl_cv_6 = '{{ $list_color_cv[5] }}';
	
	    $('#box-hvt').css('background', cl_cv_1);
	    $('#sortable').css('background', cl_cv_1);
	    $('#cvo-profile-avatar-wraper').css('background', cl_cv_1);
	    $('#form-cv').css('border', 'solid 1px' + cl_cv_1);
	    $('#cv-right').css('background', 'solid 1px' + cl_cv_1);
	    $('#cv-right h3 input').css('color', cl_cv_2);
	    $('h1 input').css('color', cl_cv_2);
	    $('#cv-top h2').css('color', cl_cv_3);
	    $('#cv-content .head').css('background-color', cl_cv_4);
	    $('#cv-content .head input').css('color', cl_cv_5);
	    $('#ctbx .exp-title').css('color', cl_cv_1);
	    $('textarea.box-content').css('color', cl_cv_6);
	    $('input.skill-name').css('color', cl_cv_6);
	
	    @foreach($cv_color as $id_cl=>$color)
	    $('.my_color_cv{{$id_cl + 1}}').click(function () {
	            <?php
		$list_color = array();
		$list_color = explode(',', $color->order_color);
		?>
	        var checkked_radio = $(this).attr('data_cl');
	        $('#checkked' + checkked_radio).prop("checked", true);
	        var cl_1 = '{{ $list_color[0] }}';
	        var cl_2 = '{{ $list_color[1] }}';
	        var cl_3 = '{{ $list_color[2] }}';
	        var cl_4 = '{{ $list_color[3] }}';
	        var cl_5 = '{{ $list_color[4] }}';
	        var cl_6 = '{{ $list_color[5] }}';
	
	        $('#box-hvt').css('background', cl_1);
	        $('#sortable').css('background', cl_1);
	        $('#cvo-profile-avatar-wraper').css('background', cl_1);
	        $('#form-cv').css('border', 'solid 1px' + cl_1);
	        $('#cv-right').css('background', 'solid 1px' + cl_1);
	        $('#cv-right h3 input').css('color', cl_2);
	        $('#cv-top h2').css('color', cl_3);
	        $('h1 input').css('color', cl_2);
	        $('#cv-content .head').css('background-color', cl_4);
	        $('#cv-content .head input').css('color', cl_5);
	        $('#ctbx .exp-title').css('color', cl_1);
	        $('textarea.box-content').css('color', cl_6);
	        $('input.skill-name').css('color', cl_6);
	    });
	    @endforeach
	});
</script>

@endsection
