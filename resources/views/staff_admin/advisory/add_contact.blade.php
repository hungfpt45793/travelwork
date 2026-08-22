@extends('staff_admin.layouts.master')
@section('title', 'Danh sách liên hệ' )
@section('content')
<div class="container-fluid">
	<div class="row row-content">
		{{-- sitebar --}}
		<div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
			@include('staff_admin.sidebars.order')
		</div>
		<div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
			<section class="jobsInteresting bgrWhite bdLightGray radius5 ">
				<div class="contentJobsInteresting pd15 col-f14 ">
					<h5 class="text-info">Thêm mới liên hệ</h5>
					<!-- form start -->
					<form role="form" action="{{ route('staff_advisory_contact.store') }}" method="POST">
						{!! csrf_field() !!}
						{{ method_field('POST') }}
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<!-- Nội dung thêm mới -->
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Nội dung</h3>
									</div>
									<!-- /.box-header -->
									<div class="box-body">
										<div class="form-group">
											<label for="exampleInputEmail1">Họ và tên</label>
											<input type="text" class="form-control" name="name" placeholder="Họ và tên" required>
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">Điện thoại</label>
											<input type="text" class="form-control" name="phone" placeholder="Điện thoại" required>
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">Email</label>
											<input type="email" class="form-control" name="email" placeholder="Email" required>
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">Địa chỉ</label>
											<input type="text" class="form-control" name="address" placeholder="Địa chỉ" required>
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">Trạng thái</label>
											<select class="form-control" name="status">
												<option value="1">Đã tư vấn</option>
												<option value="0">Chưa tư vấn</option>
											</select>
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">Message</label>
											<textarea rows="4" class="form-control" name="message"
												placeholder=""></textarea>
										</div>
										<div class="form-group" style="color: red;">
											@if ($errors->has('name'))
											<label for="exampleInputEmail1">{{ $errors->first('name') }}</label>
											@endif
										</div>
									</div>
									<!-- /.box-body -->
									<div class="box-footer">
										<button type="submit" class="btn btn-primary">Thêm mới</button>
									</div>
								</div>
								<!-- /.box -->
							</div>
						</div>
					</form>
				</div>
			</section>
			<!-- The Modal -->
		</div>
	</div>
</div>
@endsection
