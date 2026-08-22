@extends('staff_admin.layouts.master')

@section('title', 'Chi tiết ứng viên' )

@section('content')
<div class="container-fluid">
	<div class="row row-content">
		{{-- sitebar --}}
		<div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
			@include('staff_admin.sidebars.employee')
		</div>
		<div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
			@if (session('error'))
			<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
				<div class="alert alert-danger mg-b-0 " role="alert">
					{{ session('error') }}
					<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
				</div>
			</div>
			@endif
			@if (session('success'))
			<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
				<div class="alert alert-success mg-b-0 ">
					{{session('success')}}
					<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
				</div>
			</div>
			@endif
			<section class="jobsInteresting bgrWhite bdLightGray radius5 ">
				<div class="contentJobsInteresting pd15 col-f14 ">
					<h5 class="text-info" style="display: inline-block">Danh sách lịch sử tương tác ứng viên &nbsp; </h5>
					<h5 style="display: inline-block" class="text-success"> {{ $employee->employee_name }}</h5>
					<form action="{{route('Create_Interactive_Employee',$employee->employee_id)}}" class="row" method="GET">
						<div class="col-6">
							<div class="form-group">
								<label for="">Nội dung tương tác</label>
								<textarea name="content" class="form-control" rows="4" required></textarea>
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label for="">Ngày tương tác</label>
								<input type="date"  value="{{ date('Y-m-d') }}" name="interactive_day" class="form-control">
							</div>
							<button type="submit" class="btn btn-sm mt-1 btn-success">Lưu</button>
							<a href="{{ route('staff_employee_edit_form',  $employee->employee_id) }}" class="btn btn-sm mt-1 btn-info">Sửa</a>
							<a data-toggle="modal" data-target="#employee_move_teacher" class="btn btn-sm mt-1 btn-danger btnGreen clwhite" > Chuyển TK <i class="fas fa-arrow-right"></i> giáo viên</a>
							{{--<a  href="{{ route('change_employee_to_teacher',['employee_id'=>$employee->employee_id]) }}" class="btn mt-1 btn-danger btnGreen"> Chuyển TK <i class="fas fa-arrow-right"></i> giáo viên</a>--}}
						</div>
					</form>
					<div id="employee_move_teacher" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<form action="{{ route('change_employee_to_teacher') }}"  method="POST">
								{!! csrf_field() !!}
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<input type="hidden" name="employee_id" value="{{ $employee->employee_id }}">
										<h4 class="modal-title">Chuyển tài khoản ứng viên sang giáo viên</h4>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<div class="modal-body">
										<textarea class="form-control"  name="move_content" rows="6" cols="80" required placeholder="Nhập nội dung chuyển tài khoản"/></textarea>
										<i>Lưu ý : Chuyển tài khoản thì tài khoản ứng sẽ bị xóa tạm thời và toàn bộ thông tin của ứng viên và trình độ kinh nghiệm của ứng viên sẽ chuyển sang giáo viên</i>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
										<button type="submit" class="btn btn-primary">Chuyển tài khoản</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					{{--
					<hr class="hr">
					--}}
					<div class="row">
						<div class="col-12">
							<div class="table-responsive" style="padding-bottom:20px;">
								<table class="table table-bordered table-hover ">
									<thead>
										<tr>
											<th scope="col ">id</th>
											<th scope="col ">Ngày tương tác</th>
											<th scope="col ">Người tt</th>
											<th scope="col ">Nội dung</th>
											<th scope="col ">Thao tác</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($interactives as $interactive)
										<tr>
											<td>{{ $interactive->id }}</td>
											<td>{{ date('d-m-Y',strtotime($interactive->interactive_day)) }}</td>
											<td>{{ $interactive->user_name }}</td>
											<td contenteditable class="content_edit" data-id="{{ $interactive->id }}">{{ $interactive->content }}</td>
											<td>
												@if (Auth::id() == $interactive->user_id)
												<!-- <button type="button" class="btn btn-primary" href="{{route('staff_employee_update_interactive',  $interactive->id)}}"
													content="{{$interactive->content}}"
													interactive_day="{{date('Y-m-d',strtotime($interactive->interactive_day))}}"
													data-toggle="modal" data-target="#editinter"
													>Sửa</button> -->
													<button class="btn btn-primary click_edit">Sửa</button>
												<a href="{{ route('staff_employee_delete_interactive',  $interactive->id) }}" class="btn btn-danger btnDelete">Xóa</a>
												@endif
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<hr class="hr">
					<div id="editinter" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<form role="form" action=""  method="POST" id="form_update_interactive">
								{!! csrf_field() !!}
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Cập nhật tương tác</h4>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<div class="modal-body">
										{{--
										<div class="col-6">
											--}}
											<div class="form-group">
												<label for="">Nội dung tương tác</label>
												<textarea name="content" id="content" class="form-control" rows="4"></textarea>
											</div>
											{{--
										</div>
										--}}
										{{--
										<div class="col-6">
											--}}
											<div class="form-group">
												<label for="">Ngày tương tác</label>
												<input type="date" name="interactive_day" id="interactive_day" class="form-control" >
											</div>
											{{--
										</div>
										--}}
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
										<button type="submit" class="btn btn-success">Lưu</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					{{--
					<div class="col-xl-9 col-lg-8 col-md-12 col-12 col-12">
						--}}
						<div class="CV bgrWhite radius5 pd20  mgb20 pdb5 UpdateUserTab">
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
										aria-selected="true">Thông tin ứng viên</a>
								</li>
							</ul>
							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
									<div class="CV bgrWhite radius5   mgb20 pdb5" style="border: 1px solid #ccc;border-top: none;">
										<div class="content">
											<div class="row">
												<div class="col-md-12  mgt15">
													<div class="row">
														<div class="col-lg-12 col-md-12 pdl15 pdRight15">
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
																		@endif
																		</span>
																	</p>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-5 ">
															<label for="inputAddress2" class="fw6 mgl15" style="display: block;">Trạng thái : @if($employee->status == 0) Đang tìm việc @else Đã đi làm @endif </label>
														</div>
														<div class="col-md-7 ">
															<div class="row">
																<div class="col-md-3 pd0">
																	<label for="inputAddress2" class="fw6 mgl15" style="display: block;">% hồ sơ : </label>
																</div>
																<div class="col-md-9">
																	<div class="progress mgr15">
																		<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{ round($employee->profile) }}%;" aria-valuenow="{{ round($employee->profile) }}" aria-valuemin="0" aria-valuemax="100">{{ round($employee->profile) }}%</div>
																	</div>
																</div>
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
																<label for="inputAddress2" class="fw6" style="display: block;">SĐT: <span
																	class="clhome">
																{{ isset($employee->phone) ? $employee->phone : '' }}
																</span></label>
															</div>
															<div class="col-md-6">
																<label for="inputAddress2" class="fw6" style="display: block;">Email:
																<span class="clhome">
																{{ isset($employee->email) ? $employee->email : '' }}
																</span>
																</label>
															</div>
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
														{{--
														<div class="form-row  gruopRadio">
															--}}
															{{--
															<div class="col-md-6">--}}
																{{--<label for="inputAddress2" class="fw6" style="display: block;">Số điện thoại:--}}
																{{--<span--}}
																{{--class="clhome">--}}
																{{--*******--}}
																{{--</span></label>--}}
																{{--
															</div>
															--}}
															{{--
															<div class="col-md-6">--}}
																{{--<label for="inputAddress2" class="fw6" style="display: block;">Email liên hệ:--}}
																{{--<span--}}
																{{--class="clhome">--}}
																{{--******--}}
																{{--</span></label>--}}
																{{--
															</div>
															--}}
															{{--
														</div>
														--}}
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
																	?>
																{{ !empty($age) ? $age : '' }}
																@endif
																</span></label>
															</div>
														</div>
														<div class="form-row">
															<div class="col-md-12">
																<label for="exampleInputEmail1" class="fw6">Khu vực cần tìm việc
																</label>
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
														<div class="form-group ">
															<label for="inputAddress2" class="fw6">Giới thiệu về bản thân :</label>
															<div class="InfoUser">
																<?php
																	$pattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
																	$replacement = "******";
																	$information_verifier_email = preg_replace($pattern, $replacement, $employee->information_verifier);

																	$information_replace = preg_replace('/([0-9]+[\- ]?[0-9]+){5,20}/', '********', $information_verifier_email);
																	//                                        $information_verifier_email = preg_replace('/\+?[0-9][0-9()-\s+]{4,20}[0-9]/', '*******', $employee->information_verifier);

																	?>
																{!!   isset($information_replace) ? $information_replace : ''  !!}
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)
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
						@endif
						{{--
					</div>
					--}}
				</div>
			</section>
		</div>
	</div>
</div>

@endsection
@section('scripts')
    <script>

	function edit_data(id, content) {
		$.ajax({
			url: "{{ route('edit_data') }}",
			method: "POST",
			data: {
				id: id,
				content: content,
			},
			success: function(data) {
				alert(data.messenge)
				// alert(data);
			}
		})
	}


	$(document).on('click','.click_edit',function () {
		var id = $(this).parent().parent().find('.content_edit').attr('data-id')
		var content = $(this).parent().parent().find('.content_edit').text()
		edit_data(id, content)
	})


	$('input[name="coin_profile"]').on('keyup', function () {
		if($(this).val() > 15 || $(this).val() < 0){
			$('.error_coin').html(`<p>0 <= Điểm đánh giá <= 15</p>`)
		}
		else{
			$('.error_coin').html(``)
		}
    });


	//Chức năng duyệt cv
	$('.approved').on('click', '.approved_cv', function(){
		var x = confirm("Bạn có chắc chắc muốn duyệt cv?");
		let status = $(this).attr('data-status');
		if (x)
			$.ajax({
				'type': 'get',
				'url': '{{ route("approved_cv") }}',
				'data': {
					employee_id: {{ $employee->employee_id }},
					status: status
				},
				'success': function(res){
					alert(res.mess);
					//neu cv upload bo duyet
					if(res.status == 0)
					{
						$('.approved').html(` <a class="approved_cv" data-status="0">
									Duyệt CV
								</a>`);
					}
					//neu cv upload duyet
					else{
						$('.approved').html(`<a class="approved_cv" data-status="1">
									Bỏ Duyệt CV
								</a>`);
					}
				}
			})
		else
			return false;
	});
	//Chức năng gửi phản hồi
		$('.send_response').click(function() {
		if($.trim($('#feedback').val()).length === 0){
			$('.note_text_feedback').hide();
			$('.error_text_feedback').html('<i class="error"><span class="error_reg_mess_icon">Vui lòng nhập phản hồi</span></i>');
			$('.error_reg_mess_icon').css("color", "#ff0000");
			$('.error_border_feedback').css("cssText", "border: 1px solid #ff0000  !important;");
			event.preventDefault();
		}
		let response_content = $('#response textarea').val();
		$.ajax({
			'type': 'get',
			'url': "{{ route('SendFeedbackEmployee') }}",
			'data': {
				employee_id: {{ $employee->employee_id }},
				feedback: response_content
			},
			'success': function(res){
				$('#response').modal('hide')
				alert(res);
			}
		})
	});


        function submitDelete(e) {
            var url = $(e).attr('href');

            var Ids = [];
            console.log(url);
            $('#send_feedback_employee').attr('action', url);
            return false;
        }
        $('.btnDelete').click(function(){
            var x = confirm("Bạn có chắc chắc muốn xóa?");
            if (x)
                return true;
            else
                return false;
        });


        $('.update_interactive').click(function(){
            var interactive_day = $(this).attr('interactive_day');
            console.log(interactive_day)
            var url = $(this).attr('href');
            var content = $(this).attr('content');
            $('#interactive_day').attr('value', interactive_day);
            document.getElementById("content").value = content;
            $('#form_update_interactive').attr('action', url);
            // return false;
        });
</script>
@endsection
