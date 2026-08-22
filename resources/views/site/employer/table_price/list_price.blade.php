@extends('site.layout.site')
@section('title',  'Nhà tuyển dụng ')
@section('meta_description', 'Danh sách nhà tuyển dụng')
@section('keywords', 'nhà tuyển dụng')
@section('content')
<section class="content bgrGray pdt5">
	<div class="container-fluid ">
		<div class="row ">
			<?php $user = \Illuminate\Support\Facades\Auth::user() ?>
			@include('site.sidebar.sidebar_job',['user'=>$user])
			<div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
				<div class="link bgrWhite md-mgt20">
					<ul class="nav">
						<li class="nav-item pd8">
							<a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
						</li>
						<li class="nav-item pd8">
							<p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
						</li>
						<li class="nav-item pd8">
							<?php
								$link_url ='#';
								$link_url = \App\Ultility\Ultility::getUrl();
								?>
							<a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> <i class="fas fa-link white mgr5"></i> Nhà tuyển dụng</a>
						</li>
					</ul>
				</div>
				<div class="notificationBox bkwhite formJobLarge mgt20">
					<div class="bodyBox ">
						<div class="accountInfo w-100 disInBlock text-center">
							<div class="disInBlock ">
								<p class="disInBlock f20">Có tất cả  <span class="clred fw6">{{ number_format($total_employee ,0) }}</span> hồ sơ đang
									tìm việc trên <span class="clhome">Travelwork </span>
								</p>
							</div>
							<div class="disInBlock text-right fright frightmb ">
								<a href="{{ route('show_employee') }}"
									class="pd10 fontBold bgrBlueN text-right white disInBlock">BẤM XEM
								NGAY</a>
							</div>
						</div>
					</div>
				</div>
				<div class="notificationBox bkwhite formJobLarge mgt20">
					<div class="bodyBox ">
						<div class="accountInfo w-100 disInBlock text-center">
							<div class="disInBlock ">
								<p class="disInBlock f20">Có tất cả <span class="clred fw6">{{ number_format($total_employer ,0) }}</span> doanh nghiệp đang tìm kiếm ứng viên trên <span class="clhome">Travelwork </span></p>
							</div>
							<div class="disInBlock text-right fright frightmb ">
								<a href="{{ route('list_employer') }}"
									class="pd10 fontBold bgrBlueN text-right white disInBlock">BẤM XEM
								NGAY</a>
							</div>
						</div>
					</div>
				</div>
				<div class="contentPage mgt20">
					<div class="underlineL disInBlock"></div>
					<div class="tittleC textUpper disInBlock text-center blueN">
						CỔNG DÀNH CHO NHÀ TUYỂN DỤNG
					</div>
					<div class="underlineR disInBlock"></div>
				</div>
				<div class="notificationBox  formJobLarge mgt20 pd0"
					style="margin-bottom:30px;background-color: #fff9f4; ">
					<div class="row">
						<div class="col-lg-4 pd15-0-15-3 col-sm-12">
							<div class="formSearchKey" style="background-color: #fff;">
								<form action="{{ route('search_employee') }}" method="get">
									<div class="form-group row">
										<div class="col-sm-12">
											<input type="text" class="form-control" id="inputKey"
												placeholder="Nhập tên ứng viên" name="word">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-12">
											<select class="form-control select2" name="career">
												<option value="0" selected>Công việc cần tìm</option>
												@foreach(\App\Entity\Career::get_all_career() as $career)
												<option value="{{$career->career_category_id}}">{{$career->career_category_name}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-12">
											<select class="form-control select2"
												name="province" aria-label="Tỉnh/Thành phố" id="city">
												<option value="0" selected> Tất cả tỉnh/thành phố</option>
												<?php
													$getAllProvince = \App\Entity\Province::GetAllProvinces();
													?>
												@foreach($getAllProvince as $province)
												<option value="{{$province->province_id}}">{{$province->province_name}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-12">
											<select class="form-control select2"
												name="district" aria-label="Quận/Huyện" id="county">
												<option value="0" selected> Tất cả quận/huyện</option>
												@foreach(\App\Entity\District::getAllDistrict() as $district)
												<option value="{{ $district->district_id }}">{{$district->district_name}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-12">
											<select class="form-control select2"
												name="salary_id">
												<option value="0" selected>Mức lương</option>
												@foreach(\App\Entity\Salary::showAllSalary() as $salary)
												<option  value="{{$salary->salary_id}}">{{$salary->description}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-12">
											<button type="submit"
												class="btn btn-warning w100 fontBold font18 white"><i class="fas fa-search"></i> Tìm kiếm hồ sơ
											</button>
										</div>
									</div>
								</form>
								<style>
									.select2 {
									border: 1px solid #ced4da;
									}
								</style>
							</div>
						</div>
						<div class="col-lg-8 col-sm-12">
                            <div style="">
                                <div class="contentImage  left25p top5p mh14-left10 mh10-Left8Right8"
                                     style="background-color: #fff9f4;">
                                    <div class="title">
                                        <h3 class="text-uppercase">Travelwork</h3>
                                        <p></p>
                                    </div>
                                    <div class="PeopleRecruitment text-center">
                                        <div class="icon1 disInBlock  mh10-mg0 mh42-w45 mgr20">
                                            <img class="lazy" src="/assets/image/icon1.png" alt="">
                                            <p class="mg0 text-center fontBold font23 mh42-font18 red">{{ number_format($total_employee ,0)  }}</p>
                                            <p class="text-center fontBold font23 blue mh42-font18">HỒ SƠ ỨNG
                                                VIÊN</p>
                                        </div>
                                        <div class="icon2 disInBlock  ">
                                            <img class="lazy" src="/assets/image/icon2.png" alt="">
                                            <p class="mg0 text-center fontBold font23 mh42-font18 red">{{ number_format($total_employer ,0) }}</p>
                                            <p class="text-center fontBold font23 blue mh42-font18">DOANH NGHIỆP</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="contentPage mgt20">
					<div class="link bgrWhite mgb20" id="price_list">
						<div id="service_show_on_big">
							<div class="row">
								<div class="col-md-12">
									<h1>Bảng giá dịch vụ</h1>
								</div>
							</div>
							<div class="row title_price_list">
								@foreach ($prices as $price)
								<div class="col-md-6 col-xl-3 mb-3  col-sm-3 total_box" id="total_box{{ $price->service_price_id }}">
									{{--
									<div class="shadow"></div>
									--}}
									<div class="grade">
										<div class="maxHieght_service">
											<div class="img d-center"><img class="lazy d-center" src="{{ $price->image }}" alt="">
											</div>
											<div class="title_goi_tin d-center">
												<h3 class="name_box d-center">
													@php
													echo title_case($price->service_price_title);
													@endphp
												</h3>
											</div>
											<div class="detail_box pl-2">
												<span style="line-height: 1em">{!! $price->feature !!}</span>
											</div>
										</div>
										<div class="button_more d-center">
											<a href="{{ route('table_price_employer', ['slug'=> $price->service_price_slug]) }}" class="ct_button_more ct_button_more1 d-center">Xem
											chi tiết</a>
										</div>
									</div>
								</div>
								@endforeach
							</div>
							<div class="row show_price_list">
								@if($type == 0)
								<div id="scroll{{ $list_price->service_price_id }}"
									class="col-12 pt-5 mt-2 item_price_list total_box{{ $list_price->service_price_id }}">
									<div class="row">
										<div class="col-7 col-full">
											<div class="table-responsive" style="padding-bottom:100px;">
												<form action="{{ route('pay_price') }}" method="get">
													<table class="table table-bordered table-hover d-table-respon">
														<thead>
															<tr>
																<th>SỐ TUẦN</th>
																<th>GIÁ (VNĐ)</th>
																<th>CHIẾT KHẤU</th>
																<th>GIÁ CÓ VAT (VNĐ)</th>
															</tr>
														</thead>
														<tbody>
															@php
															$table_prices =
															\App\Entity\Service_table_price::getTablePrices($list_price->service_price_id);
															@endphp
															{{--  --}}
															<input value="{{ $list_price->service_price_id }}" type="text"
																name="service" hidden>
															@foreach ($table_prices as $table_price)
															<tr>
																<td>
																	<input style="transform: scale(1.3)" type="radio"
																		class="select_package_name service_table_price_id"
																		id="q{{ $table_price->service_table_price_id }}"
																		name="service_package" class="mr-1 service_table_price_id"
																		value="{{ $table_price->service_table_price_id }}">
																	<label
																		for="q{{ $table_price->service_table_price_id }}">
																	{{ $table_price->package_name }}</label>
																</td>
																<td>
																	<p class="price">{{ $table_price->package_price }}</p>
																</td>
																<td>
																	<p class="center">{{ $table_price->package_discount }}</p>
																</td>
																<td>
																	<p class="price">{{ $table_price->package_vat }}</p>
																</td>
															</tr>
															@endforeach
														</tbody>
													</table>
													<button type="submit" class="btn btn-warning d-center button-submit">Sử dụng dịch vụ
													này</button>
												</form>
											</div>
										</div>
										<div class="col-5 col-full">
											<div class="title_right">
												<h3>{{ $list_price->service_price_title }}</h3>
												<small></small>
												<i class="fas fa-times btn btn-danger" style="padding:6px 6px"></i>
											</div>
											<hr class="hr">
											<div class="parent_bonus detail_title_right" >
                                                @php
                                                $table_price_first =
                                                \App\Entity\Service_table_price::getTablePriceFirst($list_price->service_price_id);
                                                @endphp
                                                {!! $table_price_first->benifit !!}
                                                <hr>
                                                {!! $table_price_first->endow !!}
                                                <hr>
                                                <?php
                                                $comments = \App\Entity\Service_comment::where('service_table_price_id', $table_price_first->service_table_price_id)->get();
                                                ?>
                                                @foreach($comments as $comment)
                                                <div class="block_comment row">
                                                    <div class="col-md-3 col-md-xs-3">
                                                        <img style="width: 50px;height:50px"
                                                            src="{{$comment->service_comment_image}}" class="logo lazy" alt="">
                                                    </div>
                                                    <div class="col-md-9 col-md-xs-9">
                                                        <p class="mess_comment">{!! $comment->service_comment_content!!}
                                                        </p>
                                                    </div>
                                                </div>
                                                @endforeach
											</div>
										</div>
									</div>
								</div>
								@endif
								@if($type == 1)
								<div id="scroll{{ $list_price->service_price_id }}"
									class="col-12 pt-5 mt-2 item_price_list total_box{{ $list_price->service_price_id }}">
									<div class="row">
										<div class="col-9 pt-2">
											<h5>Bảng giá biểu tượng tăng click</h5>
										</div>
										<div class="col-3 pt-2">
											<div class="float-right">
												<i class="fas fa-times btn btn-danger"></i>
											</div>
										</div>
									</div>
									<div class="table-responsive" style="padding-bottom:100px;">
										<table class="table table-bordered table-hover d-table-respon">
											<thead>
												<tr>
													<th>BIỂU TƯỢNG</th>
													<th>THỜI GIAN</th>
													<th>HÌNH ẢNH</th>
													<th>GIÁ(VNĐ)</th>
													<th>GIÁ VAT(VNĐ)</th>
												</tr>
											</thead>
											<tbody>
												@php
												$icons = \App\Entity\Service_icon::getIcon($list_price->service_price_id)
												@endphp
												@foreach ($icons as $icon)
												<tr>
													<td>
														{{ $icon->service_icon_name }}
													</td>
													<td>{{ $icon->service_icon_time }}</td>
													<td> <img class="lazy" src="{{ $icon->service_icon_image }}" style="width:80px" alt="">
													</td>
													<td>{{ $icon->service_icon_price }}</td>
													<td>{{ $icon->service_icon_vat }}</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								@endif
								@if($type == 2)
								@php
								$hunter = \App\Entity\Service_hunter::get_detail_hunter($list_price->service_price_id)
								@endphp
								<div id="scroll{{ $list_price->service_price_id }}"
									class="col-12 pt-5 mt-2 item_price_list total_box{{ $list_price->service_price_id }}">
									<div class="row">
										<div class="col-9 pt-2">
											<h5>{{ $hunter->service_hunter_name }}</h5>
										</div>
										<div class="col-3 pt-2">
											<div class="float-right">
												<i class="fas fa-times btn btn-danger"></i>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<img class="lazy" src="{{ $hunter->service_hunter_image }}" alt="">
										</div>
										<div class="col-12">
											<p class="intro">
												{!! $hunter->service_hunter_info !!}
											</p>
										</div>
										<hr>
										<div class="col-12">
											{!! $hunter->service_hunter_pay !!}
										</div>
										<div class="col-12">
											<div class="table-responsive">
												<table class="table table-bordered">
													<tr>
														<th rowspan="2" class="text-center">Vị trí cần tuyển</th>
														<th colspan="{{ $hunters_time->count() }}" class="text-center">Thời gian
														</th>
														<th rowspan="2" class="text-center">Đăng ký</th>
													</tr>
													<tr>
														@foreach ($hunters_time as $hunter_time)
														<th class="text-center">{{ $hunter_time->hunter_time_name }}</th>
														@endforeach
													</tr>
													@foreach ($hunters_pos as $hunter_pos)
													<tr>
														@php
														$hunters_price =
														\App\Http\Controllers\Site\ListPriceController::getHunterPrice($hunter_pos->hunter_pos_id)
														@endphp
														<td class="text-center">{{ $hunter_pos->hunter_pos_name }}</td>
														<form id="hunter_price_form"
															action="{{ route('save_registration_hunter') }}">
															@foreach ($hunters_price as $hunter_price)
															<td><span class="float-right hunter_price_id"><input type="radio"
																data="btn{{ $hunter_pos->hunter_pos_id }}"
																name="hunter_price_id"
																id="id{{ $hunter_price->hunter_price_id }}"
																value="{{ $hunter_price->hunter_price_id }}"> <label
																for="id{{ $hunter_price->hunter_price_id }}">{{ $hunter_price->hunter_price_name }}</label></span>
															</td>
															@endforeach
															<td class="d-flex justify-content-center"><button type="submit" disabled
																class="btn btn-primary btn{{ $hunter_pos->hunter_pos_id }}">Đăng
																ký</button>
															</td>
														</form>
													</tr>
													@endforeach
												</table>
											</div>
										</div>
										<div class="col-12">
											{!! $hunter->service_hunter_contact !!}
										</div>
									</div>
								</div>
								@endif
							</div>
						</div>
						<div id="service_show_on_small">
							<h2>Bảng giá dịch vụ</h2>
							<ul class="nav nav-pills mb-3 bg-info" id="d-pills-tab" role="tablist">
								@foreach($prices as $price)
								<li class="nav-item d-nav-item" @if(url()->current() == route('table_price_employer', ['slug'=> $price->service_price_slug])) style="background:#ff9200" @endif >
									<a style="border:unset;background:none!important" href="{{ route('table_price_employer', ['slug'=> $price->service_price_slug]) }}">
										<p class="font425_12">
											@php
											echo title_case($price->service_price_title);
											@endphp
										</p>
									</a>
								</li>
								@endforeach
							</ul>
							<div class="">
								@if($type == 0)
								@php
                                $table_prices =
                                \App\Entity\Service_table_price::getTablePrices($list_price->service_price_id);
                                @endphp
								<div class="tab-pane active" >
									@foreach ($table_prices as $table_price)
									<div class="one_package">
										<div class="row">
											<div class="col-6">
												<p class="font425_12 font320_11">{{ $table_price->package_name }}</p>
											</div>
											<div class="col-6">
												<p class="float-right font425_12 font320_11"><span>Giá: </span><span
													class="text-danger price">{{ $table_price->package_price }}</span></p>
											</div>
											<div class="col-6" style="height: 1em">
												<p class="font425_12 font320_11">Chiết khấu: {{ $table_price->package_discount }}</p>
											</div>
											<div class="col-6" style="height: 1em">
												<p class="float-right font425_12 font320_11"><span>Giá(vat): </span><span
													class="text-danger">{{ $table_price->package_vat }}</span></p>
											</div>
											<div class="col-12 d-center pt-3 pb-2">
												<a href="{{ route('pay_price') }}?service={{ $list_price->service_price_id }}&service_package={{ $table_price->service_table_price_id }}"
													class="btn btn-warning d-center font425_12 font320_11">Đăng ký</a>
											</div>
										</div>
										<div class="feature">
											<div>
												<p class="tabs1"><i class="fas fa-check"></i><span class="font425_12 font320_11">Quyền lợi</span></p>
											</div>
											<div>
												<p class="tabs2"><i class="fas fa-check"></i><span class="font425_12 font320_11">Ưu đãi</span></p>
											</div>
											<div>
												<p class="tabs3"><i class="fas fa-check"></i><span class="font425_12 font320_11">Bình luận</span></p>
											</div>
										</div>
										<div class="content_feature">
											<div class="tabs1">
												<p>{!! $table_price->benifit !!}</p>
											</div>
											<div class="tabs2">
												<p>{!! $table_price->endow !!}</p>
											</div>
											<div class="tabs3">
												@php
												$comments =
												\App\Entity\Service_comment::getComment($table_price->service_table_price_id)
												@endphp
												@foreach ($comments as $comment)
												<img class="lazy" style="width: 50px;height:50px; float:left;"
													src="{{ $comment->service_comment_image }}" class="logo pr-1" alt="">
												<p>{!! $comment->service_comment_content !!}</p>
												<br>
												@endforeach
											</div>
										</div>
									</div>
									@endforeach
								</div>
								@endif
								@if($type == 1)
								<div class="tab-pane active" id="scroll{{ $list_price->service_price_id }}"
									class="col-12 col-md-12 item_price_list total_box{{ $list_price->service_price_id }} d-none">
									<div class="row">
										<div class="col-12 col-md-12 pt-2">
											<h5>Bảng giá biểu tượng tăng click</h5>
										</div>
									</div>
									<div class="table-responsive" style="padding-bottom:100px;">
										<table class="table table-bordered table-hover d-table-respon">
											<thead>
												<tr>
													<th>BIỂU TƯỢNG</th>
													<th>THỜI GIAN</th>
													<th>GIÁ(VNĐ)</th>
													<th>GIÁ VAT(VNĐ)</th>
												</tr>
											</thead>
											<tbody>
												@php
												$icons = \App\Entity\Service_icon::getIcon($list_price->service_price_id)
												@endphp
												@foreach ($icons as $icon)
												<tr>
													<td> <img class="lazy" src="{{ $icon->service_icon_image }}" style="width:40px" alt="">
													</td>
													<td>{{ $icon->service_icon_time }}</td>
													<td>{{ $icon->service_icon_price }}</td>
													<td>{{ $icon->service_icon_vat }}</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								@endif
								@if($type == 2)
								@php
								$hunter = \App\Entity\Service_hunter::get_detail_hunter($list_price->service_price_id)
								@endphp
								<div class="tab-pane active" id="scroll{{ $list_price->service_price_id }}"
									class="col-12 col-md-12 item_price_list total_box{{ $list_price->service_price_id }} d-none">
									<div class="row">
										<div class="col-12 col-md-12 pt-2">
											<h5>{{ $hunter->service_hunter_name }}</h5>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<img class="lazy" src="{{ $hunter->service_hunter_image }}" alt="">
										</div>
										<div class="col-12">
											<p class="intro">
												{!! $hunter->service_hunter_info !!}
											</p>
										</div>
										<hr>
										<div class="col-12">
											{!! $hunter->service_hunter_pay !!}
										</div>
										<div class="col-12">
											<div class="table-responsive">
												<table class="table table-bordered">
													<tr>
														<th rowspan="2" class="text-center">Vị trí</th>
														<th colspan="{{ $hunters_time->count() }}" class="text-center">Thời
															gian(ngày)
														</th>
														<th rowspan="2" class="text-center">Đăng ký</th>
													</tr>
													<tr>
														@foreach ($hunters_time as $hunter_time)
														<th class="text-center">{{ $hunter_time->hunter_time_name_small }}</th>
														@endforeach
													</tr>
													@foreach ($hunters_pos as $hunter_pos)
													<tr>
														@php
														$hunters_price =
														\App\Http\Controllers\Site\ListPriceController::getHunterPrice($hunter_pos->hunter_pos_id)
														@endphp
														<td class="text-center">{{ $hunter_pos->hunter_pos_name }}</td>
														<form id="hunter_price_form"
															action="{{ route('save_registration_hunter') }}">
															@foreach ($hunters_price as $hunter_price)
															<td><span class="float-right hunter_price_id"><input type="radio"
																data="btn{{ $hunter_pos->hunter_pos_id }}"
																name="hunter_price_id"
																id="id{{ $hunter_price->hunter_price_id }}"
																value="{{ $hunter_price->hunter_price_id }}"> <label
																for="id{{ $hunter_price->hunter_price_id }}">{{ $hunter_price->hunter_price_name }}</label></span>
															</td>
															@endforeach
															<td class="d-flex justify-content-center"><button type="submit" disabled
																class="btn btn-primary btn{{ $hunter_pos->hunter_pos_id }}">Đăng
																ký</button>
															</td>
														</form>
													</tr>
													@endforeach
												</table>
											</div>
										</div>
										<div class="col-12">
											{!! $hunter->service_hunter_contact !!}
										</div>
									</div>
								</div>
								@endif
							</div>
						</div>
					</div>
				</div>
				@include('site.module_index.dang-ky-tu-van')
			</div>
		</div>
		{{--@include('site.module_index.hotline')--}}
	</div>
</section>
@include('site.mobile_bottom.fixel_bottom_list_employer')
<script>
	// chon thanh pho ra quan huyen
	$('#city').change(function () {
	    var city = $(this).val();
	    $.get('/tim-kiem-huyen/' + city , function (data) {
	        $('#county').html('');
	        $('#county').html(data);
	    });
	});
</script>
<script>
    $(document).ready(function () {
    // Handler for .ready() called.
    $('html, body').animate({
        scrollTop: $('.show_price_list').offset().top
    }, 'slow');
});
	$(function() {

	    // hien an cac tab cua div service_show_on_small
	    $('#d-pills-tab').parent().find('.d-tab-content').find('.tab-pane').addClass('d-none');
	    $('#d-pills-tab').parent().find('.d-tab-content .tab-pane:first-child').removeClass('d-none');
	    $('#d-pills-tab li:first-child').addClass('service_show_on_small_li');
	    $('#d-pills-tab li').click(function(){
	        $('#d-pills-tab li').removeClass('service_show_on_small_li');
	        $(this).addClass('service_show_on_small_li');
	        $id = $(this).attr('data');
	        $('#d-pills-tab').parent().find('.d-tab-content').find('.tab-pane').addClass('d-none');
	        $('#d-pills-tab').parent().find('.d-tab-content').find('#'+$id).removeClass('d-none');

	    })

	    // $('.show_price_list .item_price_list').hide();
	    $('.item_price_list i.fa-times').click(function(){
	        $('.item_price_list').addClass('d-none');
	    })
	    $('.ct_button_more').click(function(){
	        $id = $(this).parent().parent().parent().attr('id');
	        $('.item_price_list').addClass('d-none');
	        $('.'+$id).removeClass('d-none');
	        $('.detail_title_right').html('');
	    })
	    $('.ct_button_more1').click(function(){
	        let service_price_id = $(this).attr('data-id');
	        $.ajax({
	        url: '{{ route('detail_table_price1') }}',
	        type: 'get',
	        data: {service_price_id: service_price_id},
	        success: function(data) {
	            let obj = jQuery.parseJSON(data);
	            var string_comment = '';
	            $.each(obj.comments, function (index, element) {

	                string_comment += `
	                <div class="block_comment row">
	                        <div class="col-md-3 col-md-xs-3">
	                            <img style="width: 50px;height:50px"
	                                src="${element.service_comment_image}" class="logo lazy" alt="">
	                        </div>
	                        <div class="col-md-9 col-md-xs-9">
	                            <p class="mess_comment">${element.service_comment_content}
	                            </p>
	                        </div>
	                    </div>
	                `
	            });
	            var html1 = '';

	            html1 += obj.table_prices.benifit;
	            html1 += '<hr class="hr">';
	            html1 += obj.table_prices.endow;
	            html1 += '<hr class="hr">';
	            html1 += string_comment;

	            $('.detail_title_right').html(html1);
	        }
	    })
	})


	    //service_show_on_small
	    // $('#service_show_on_small .fade.show').hide();
	    $('#service_show_on_small .content_feature div').hide();
	    $('#service_show_on_small .feature p').on('click',function(){
	        $class = $(this).attr('class');
	        $('#service_show_on_small .feature p').not(this).removeClass('active_price');
	        $(this).toggleClass('active_price');
	        $('#service_show_on_small .content_feature div').hide();
	        $(this).parent().parent().parent().find('.content_feature').find('div.'+$class).fadeToggle();
	    })

	    //dem so phan tu cua tab to
	    // $count = 2;
	    $('#service_show_on_small>ul>li').css({"width":"50%"})
	    //hien uu dai quyen loi binh luan
	    $(".service_table_price_id").change( function(){
	        if( $(this).is(':checked') ) {
	            $idintable = $(this).attr('id');
	            console.log($idintable)
	            $('.bonus').addClass('d-none')
	            $('.'+$idintable).removeClass('d-none');
	        }
	        // $(this).parent().parent().css({"background-color":"#333"})
	    });
	    $('.d-table-respon tr:first-child td input').attr('checked', true);
	    $('.parent_bonus .bonus:first-child').removeClass('d-none');

	    //an hien nut dang kys tuyen dung thue
	    $('.hunter_price_id').find('input').click(function(){
	        $id = $(this).attr("data");
	        $('.'+$id).prop("disabled", false);
	    })

	})


	$('.select_package_name').on('click', function() {
	    let table_price_id = $(this).val();
	    $.ajax({
	        url: '{{ route('detail_table_price') }}',
	        type: 'get',
	        data: {table_price_id: table_price_id},
	        success: function(data) {
	            let obj = jQuery.parseJSON(data);
	            var string_comment = '';
	            $.each(obj.comments, function (index, element) {

	                string_comment += `
	                <div class="block_comment row">
	                        <div class="col-md-3 col-md-xs-3">
	                            <img style="width: 50px;height:50px"
	                                src="${element.service_comment_image}" class="logo lazy" alt="">
	                        </div>
	                        <div class="col-md-9 col-md-xs-9">
	                            <p class="mess_comment">${element.service_comment_content}
	                            </p>
	                        </div>
	                    </div>
	                `
	            });
	            var html1 = '';

	            html1 += obj.table_prices.benifit;
	            html1 += '<hr class="hr">';
	            html1 += obj.table_prices.endow;
	            html1 += '<hr class="hr">';
	            html1 += string_comment;
	            $('.detail_title_right').html(html1);
	        }
	    })
	})
	if ($(window).width() <= 1024) {

	    function goToEndow() {
	        $('html,body').animate({
	            scrollTop: $(".button-submit").offset().top
	        }, 'slow');
	    }

	    $(".service_table_price_id").click(function(e) {
	        console.log('ok')
	        goToEndow();
	    });
	}
</script>
@endsection
