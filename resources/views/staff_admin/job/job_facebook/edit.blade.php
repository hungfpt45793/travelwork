@extends('staff_admin.layouts.master')
@section('title', 'Cập nhật việc làm từ facebook' )
@section('content')
<div class="container-fluid">
	<div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.job')
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
				<div class="inter pd15">
					<h5 class="text-info" style="display: inline-block">Danh sách lịch sử tương tác việc làm facebook &nbsp; </h5>
					<h5 style="display: inline-block" class="text-success"> {{ $jobFacebook->title }}</h5>
					<form action="{{ route('create_interactive_jobfb') }}" class="row" method="post">
						<div class="col-6">
							<div class="form-group">
								<label for="">Nội dung tương tác</label>
								<textarea name="content" class="form-control" rows="4" required></textarea>
								<input type="hidden" name="jobfb_id" value="{{ $jobFacebook->job_facebook_id }}">
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label for="">Ngày tương tác</label>
								<input type="date"  value="{{ date('Y-m-d') }}" name="interactive_day" class="form-control">
							</div>
							<button type="submit" class="btn mt-1 btn-success">Lưu</button>
						</div>
					</form>
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
											<td>
												@php
												$user_name = App\Entity\User::where('id', $interactive->user_id)->value('name')
												@endphp
												{{ $user_name }}
											</td>
											<td>{{ $interactive->content }}</td>
											<td>
												@if (Auth::id() == $interactive->user_id)
												<button type="button"
                                                 class="btn btn-primary update_interactive"
                                                 content="{{$interactive->content}}"
                                                 interactive_day="{{date('Y-m-d',strtotime($interactive->interactive_day))}}"
                                                 href="{{ route('update_interactive_jobfb',$interactive->id) }}"
                                                 data-toggle="modal" data-target="#editinter">Sửa</button>

												<a href="{{ route('delete_interactive_jobfb', $interactive->id) }}" class="btn btn-danger btnDelete">Xóa</a>
												@endif
											</td>
										</tr>
										@endforeach
                                        <div id="editinter" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <form role="form" action=""  method="POST" id="form_update_interactive">
                                                    {!! csrf_field() !!}
                                                    {{ method_field('PUT') }}
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Cập nhật tương tác</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="">Nội dung tương tác</label>
                                                                <textarea name="content" id="content1" class="form-control" rows="4"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Ngày tương tác</label>
                                                                <input type="date" name="interactive_day" id="interactive_day1"  class="form-control" >
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-success">Lưu</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
									</tbody>
								</table>
							</div>
						</div>
                        <div class="col-12">
                            <div class="pagination-bootstrap">
                                {{ $interactives->links() }}
                            </div>
                        </div>
					</div>
					<hr class="hr">
				</div>
				<div class="contentJobsInteresting pd15 col-f14 ">
					<form role="form"
						action="{{ route('staff_job-facebook.update',$jobFacebook->job_facebook_id) }}"
						method="POST">
						{!! csrf_field() !!}
						{{ method_field('PUT') }}
						<div class="row">
							<div class="col-xs-12 col-md-7">
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Nội dung tuyển dụng</h3>
									</div>
									<!-- /.box-header -->
									<div class="box-body">
										<div class="form-group">
											<label for="exampleInputEmail1">Tên Việc Làm</label>
											<input type="text" class="form-control" name="title" placeholder="Tên Việc Làm"
												value="{{ $jobFacebook->title }}" required>
										</div>
										{{--
										<div class="form-group">--}}
											{{--<label for="exampleInputEmail1">Mô Tả Việc Làm</label>--}}
											{{--<textarea style="padding: 10px" class="w100" id="" name="des_facebook" rows="4" cols="80" />{{ $jobFacebook->des_facebook }}</textarea>--}}
											{{--
										</div>
										--}}
										<div class="form-group">
											<label for="exampleInputEmail1">Nội dung tin tuyển dụng</label>
											<textarea class="editor" id="content" name="content" rows="5"
												cols="80"/>{!! $jobFacebook->content !!}</textarea>
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">Thông tin tham khảo</label>
											<textarea name="job_info_contact" class="editor" id="editor2" rows="10" cols="80">{!!  $jobFacebook->job_info_contact !!}</textarea>
											{{--<textarea id="txtNote" name="content" rows="6" class="textarea col-12 bdLightGray radius5"></textarea>--}}
										</div>

										{{-- từ khóa --}}
                                        @php
                                            foreach ($input_tags as $tag) {
                                                $tag_type = $tag['tag_type'];
                                            }
                                        @endphp
                                        @include('admin.layout.themtukhoa')
                                        {{-- END từ khóa --}}

									</div>
								</div>
							</div>
							<div class="col-xs-12 col-md-5">
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Thông tin bổ sung</h3>
									</div>
									<!-- /.box-header -->
									<div class="box-body">
										<div class="row detail-employer">
											<div class="col-md-12">
												<div class="form-group">
													<label for="exampleInputEmail1">Nhà tuyển dụng</label>
													<?php
														if (!empty($jobFacebook->employer_id)) {
														    $employer = \App\Entity\Employer::getIdemployer($jobFacebook->employer_id);
														}
														?>
													<select class="form-control select22" name="employer_id">
														<option value="" selected> -- Chọn nhà tuyển dụng --</option>
														@if(!empty($jobFacebook->employer_id))
														@foreach($employers as $emp)
														<option value="{{$emp['employer_id']}}"
														@if($employer->employer_id == $emp['employer_id']) selected @endif>
														{{ isset($emp['enterprise_name']) ? $emp['enterprise_name'] : '' }}</option>
														@endforeach
														@else
														@foreach($employers as $emp)
														<option value="{{$emp['employer_id']}}"
															>
															{{ isset($emp['enterprise_name']) ? $emp['enterprise_name'] : '' }}
														</option>
														@endforeach
														@endif
													</select>
												</div>
											</div>
										</div>
										<div class="form-group">
											<select class="js-example-basic-single select22" name="career_category_id">
												<option value=""> -- Chọn ngành nghề --</option>
												@foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
												<option value="{{$career->career_category_id}}" {{ $career->career_category_id == $jobFacebook->career_category_id ? 'selected' : ''}}>{{$career->career_category_name}}</option>
												@endforeach
											</select>
											{{--<label>--}}
											{{--<input type="radio" name="careers" class="flat-red" value="{{$career->career_category_id}}" >--}}
											{{--{{$career->career_category_name}}--}}
											{{--</label>--}}
										</div>
										@if ($errors->has('career_category_id'))
										<div class="form-group">
											<div class="alert alert-danger">
												<i>Vui lòng chọn ngành nghề !</i>
											</div>
										</div>
										@endif
										<div class="form-group">
											<label>Mức lương</label>
											<select class="form-control select22" name="salary_id">
												<option value=""> -- Chọn mức lương --</option>
												@foreach($salaries as $salary)
												<option value="{{$salary->salary_id}}"
												{{$salary->salary_id == $jobFacebook->salary_id ? 'selected' : ''}}
												>{{$salary->description}}</option>
												@endforeach
											</select>
											@if ($errors->has('salary_id'))
											<div class="form-group">
												<div class="alert alert-danger">
													<i>Vui lòng chọn mức lương !</i>
												</div>
											</div>
											@endif
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">Email nhận hồ sơ</label>
											<input type="text" class="form-control" name="email" placeholder="Email nhận hồ sơ"
												value="{{ $jobFacebook->email }}">
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">SĐT nhận hồ sơ</label>
											<input type="text" class="form-control" name="phone" placeholder="SĐT nhận hồ sơ"
												value="{{ $jobFacebook->phone }}">
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">Tên công ty tuyển dụng</label>
											<input type="text" class="form-control" name="company_name" placeholder="Tên công ty tuyển dụng"
												value="{{ $jobFacebook->company_name }}">
										</div>
										{{--
										<div class="form-group">--}}
											{{--<label for="exampleInputEmail1">Địa chỉ</label>--}}
											{{--<input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{ $jobFacebook->address }}" >--}}
											{{--
										</div>
										--}}
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="exampleInputEmail1">Tỉnh/Thành phố</label>
													<select class="form-control select22" name="province" aria-label="Tỉnh/Thành phố"
														id="city">
														<option value="0">-- Chọn Tỉnh/Thành phố --</option>
														@foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
														<option value="{{$province->province_id}}"
														{{$province->province_id == $jobFacebook->province ? 'selected' : ''}}
														>{{$province->province_name}}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="exampleInputEmail1">Quận/Huyện</label>
													<select class="form-control select22" name="district" aria-label="Quận/Huyện"
														id="county">
														<option value="0">-- Chọn Quận/Huyện --</option>
														@foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
														<option value="{{$district->district_id}}"
														{{$district->district_id == $jobFacebook->district ? 'selected' : ''}}
														>{{$district->district_name}}</option>
														@endforeach
													</select>
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">Địa chỉ</label>
													<input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{ $jobFacebook->address }}" >
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">Báo tin sai</label>
											<input type="text" class="form-control" name="warning_job_fb" placeholder="Email"
												value="{{ $jobFacebook->warning_job_fb }}">
										</div>
										<div class="form-group">
											<label style="margin-right: 20px">
											<input type="radio" name="vip" class="flat-red" value="0" @if($jobFacebook->vip == 0) checked @endif  >
											Tin thường
											</label>
											<label>
											<input type="radio" name="vip" class="flat-red" value="1" @if($jobFacebook->vip == 1) checked @endif>
											Tin víp
											</label>
										</div>
										<div class="box-footer">
											<button type="submit" class="btn btn-primary">Cập nhật công việc</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</section>
			<!-- The Modal -->
		</div>
	</div>
</div>
<script>
	$('#city').change(function () {
	    $.get('/admin/ajax-district/' + $(this).val(), function (data) {
	        $('#county').html(data);
	    });
	});

    $('.update_interactive').click(function(){
            var interactive_day = $(this).attr('interactive_day');
            console.log(interactive_day)
            var url = $(this).attr('href');
            var content = $(this).attr('content');
            $('#interactive_day1').attr('value', interactive_day);
            document.getElementById("content1").value = content;
            $('#form_update_interactive').attr('action', url);
            // return false;
        });
</script>
@endsection
