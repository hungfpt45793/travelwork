<?php
//1
$date_search_start = '';
if(isset($_GET['date_search_start'])){
    $date_search_start = $_GET['date_search_start'];
}
//2
$date_search_end = '';
if(isset($_GET['date_search_end'])){
    $date_search_end = $_GET['date_search_end'];
}
//3
$career_category_id = '';
if(isset($_GET['career_category_id'])){
    $career_category_id = $_GET['career_category_id'];
}
//4
$status_accounting = '';
if(isset($_GET['status_accounting'])){
    $status_accounting = $_GET['status_accounting'];
}
//5
$is_delete = '';
if(isset($_GET['is_delete'])){
    $is_delete = $_GET['is_delete'];
}
//6
$province = '';
if(isset($_GET['province'])){
    $province = $_GET['province'];
}
//7
$district = '';
if(isset($_GET['district'])){
    $district = $_GET['district'];
}
//8
$teacher_status_id = '';
if(isset($_GET['teacher_status_id'])){
    $teacher_status_id = $_GET['teacher_status_id'];
}
//9
$teacher_name = '';
if(isset($_GET['teacher_name'])){
    $teacher_name = $_GET['teacher_name'];
}
//10
$email = '';
if(isset($_GET['email'])){
    $email = $_GET['email'];
}
//11
$num = '';
if(isset($_GET['num'])){
    $num = $_GET['num'];
}
?>
@extends('staff_admin.layouts.master')
@section('title', 'Danh sách giáo viên' )
@section('content')
<div id="tbody"></div>
<div class="container-fluid">
	<div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.teacher')
        </div>

        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
			<section class="jobsInteresting bgrWhite bdLightGray radius5 ">
				<div class="contentJobsInteresting col-f14 ">
					<div class="log_error">
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
					</div>
					<div class="col-md-12">
						<div class="">
							<a class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a>
							<a href="{{ route('staff_teacher.index') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
							<button  type="button" class="btn mr-1 btn-sm btn-danger delete_all">Xóa</button>
							<div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								<div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm giáo viên</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<form action="">
											<div class="modal-body">
												<div class="form-row employee-search ">
													<div class="col-md-5 mb-3">
														<label for="validationDefault01">Từ ngày(ngày update)</label>
														@php
														$d=strtotime("-1 Months");
														$date = date("Y-m-d", $d)
														@endphp
														<input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : $date }}" type="date" id="" name="date_search_start">
													</div>
													<div class="col-md-5 mb-3">
														<label for="validationDefault02">Đến ngày(ngày update)</label>
														<input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : date("Y-m-d") }}" type="date" id="" name="date_search_end">
													</div>
													<!-- myDatetime -->
													<div class="col-md-2 mb-3">
														<label for="validationDefault2" class="text-light">sd</label>
														<input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày"></input>
													</div>
													<div class="col-md-4 col-xs-6 ">
														<div class="form-group">
															<?php
																$career_category_id_get = '';
																if (isset($_GET['career_category_id'])) {
																    $career_category_id_get = $_GET['career_category_id'];
																}
																?>
																<input type="hidden" name="num" value="{{ $num }}">
															<select class="form-control js-example-basic-single select2" id="career_category_id"
																name="career_category_id">
																<option value="">--chọn công việc--</option>
																<?php
																	$career = \App\Entity\Career::getAllCareer();
																	?>
																@foreach($career as $car)
																<option value="{{$car->career_category_id}}" @if($car->career_category_id ==
																$career_category_id_get) selected @endif
																>{{$car->career_category_name}}</option>
																@endforeach
															</select>
														</div>
														<div class="form-group">
															<select class="form-control js-example-basic-single select2" name="status_accounting"
																id="status_accounting">
																<option value="">--Chuyển tài khoản--</option>
																<option value="0" @if(isset($_GET['status_accounting']) &&
																$_GET['status_accounting']==0 && $_GET['status_accounting'] != '') selected @endif>--Chưa chuyển--</option>
																<option value="1" @if(isset($_GET['status_accounting']) &&
																$_GET['status_accounting']==1) selected @endif>--Đã chuyển--</option>
															</select>
														</div>
														<div class="form-group">
															<select class="form-control js-example-basic-single select2" name="is_delete"
																id="is_delete">
																<option value="">--Đề nghị xóa--</option>
																<option value="1" @if(isset($_GET['is_delete']) &&
																$_GET['is_delete']==1) selected @endif>--Không--</option>
																<option value="2" @if(isset($_GET['is_delete']) &&
																$_GET['is_delete']==2) selected @endif>--Có--</option>
															</select>
														</div>
													</div>
													<div class="col-md-4 col-xs-6">
														<div class="form-group">
															<select class="form-control js-example-basic-single select2" id="province"
																name="province">
																<option value="">--Tỉnh/Thành phố--</option>
																@foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
																<option value="{{$province->province_id}}" @if(isset($_GET['province']) &&
																$_GET['province']==$province->province_id) selected @endif>
																{{$province->province_name}}
																</option>
																@endforeach
															</select>
														</div>
														<div class="form-group">
															<?php
																$district_get = '';
																if (isset($_GET['district'])) {
																    $district_get = $_GET['district'];
																}
																?>
															<select class="form-control js-example-basic-single select2" name="district"
																id="district">
																<option value="">--Chọn quận/huyện</option>
																@foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
																<option value="{{$district->district_id}}" @if(isset($_GET['district']) &&
																$_GET['district']==$district->district_id) selected @endif>
																{{$district->district_name}}</option>
																@endforeach
															</select>
														</div>
														<div class="form-group">
															<?php
																$list_status = \App\Entity\Teacher_status::getALL();
																$teacher_status_id = isset($_GET['teacher_status_id']) ? $_GET['teacher_status_id'] : '';
																?>
															<select class="form-control js-example-basic-single select2" name="teacher_status_id">
																<option value="" selected style="width: 175px !important;">Chọn trạng thái</option>
																@foreach($list_status as $status_t)
																<option value="{{ $status_t->teacher_status_id }}" @if($teacher_status_id == $status_t->teacher_status_id ) selected @endif style="width: 100px;">{{ isset($status_t->teacher_status_name) ? $status_t->teacher_status_name : '' }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="col-md-4 col-xs-6 ">
														<div class="form-group">
															<input type="text " placeholder="Tên giáo viên" class="form-control "
															id="teacher_name" name="teacher_name" @if(isset($_GET['teacher_name']))
															value="{{ $_GET['teacher_name'] }}" @endif>
														</div>
														<div class="form-group">
															<input type="email " placeholder="Email giáo viên" class="form-control "
															id="email" name="email" @if(isset($_GET['email']))
															value="{{ $_GET['email'] }}" @endif>
														</div>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
												<button type="submit " class="btn btn-primary">Tìm kiếm</button>
											</div>
									</div>
									</form>
								</div>
							</div>
						</div>
						<div class="custom-paginate row mt-1 ml-1">
							{{ $teachers->links() }}
							số bản ghi của một trang:
							<span class="input-submit">
								<form action="" class="inline">
									<input type="submit" value="200" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
									<input type="submit" value="50" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
									<input type="submit" value="40" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
									<input type="submit" value="30" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
									<input type="submit" value="20" name="num"  class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
									<input type="submit" value="10" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
									<input type="hidden" name="date_search_start" value="{{ $date_search_start }}">
                                    <input type="hidden" name="date_search_end" value="{{ $date_search_end }}">
                                    <input type="hidden" name="career_category_id" value="{{ $career_category_id }}">
                                    <input type="hidden" name="status_accounting" value="{{ $status_accounting }}">
                                    <input type="hidden" name="is_delete" value="{{ $is_delete }}">
                                    <input type="hidden" name="province" value="{{ $province }}">
                                    <input type="hidden" name="district" value="{{ $district }}">
                                    <input type="hidden" name="teacher_name" value="{{ $teacher_name }}">
                                    <input type="hidden" name="teacher_status_id" value="{{ $teacher_status_id }}">
                                    <input type="hidden" name="email" value="{{ $email }}">
								</form>
							</span>
							| xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $total }} giáo viên tương tác bởi  @if(isset($staff_name)){{$staff_name}}@endif
						</div>
					</div>
					</form>
					{{--
					<div class="col-md-12 space-b">
						@if(isset($_GET['district']))
						@php
						$district_name = App\Entity\District::where('district_id',$_GET['district'])->value('district_name');
						@endphp
						<b class="">Danh sách giáo viên huyện {{ $district_name }}( <span
							style="color: rgb(220, 53, 69)">{{ App\Http\Controllers\Staff\TeacherController::countTeacherD($_GET['district']) }}</span>
						)</b>
						@endif
					</div>
					--}}
					<div id="myModal1" class="modal fade" role="dialog">
						<div class="modal-dialog">
							{{--
							<form role="form" action=""  method="POST" id="send_feedback_all_teacher">
								--}}
								{!! csrf_field() !!}
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Phản hồi tới tất cả</h4>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<div class="modal-body">
										<textarea class="form-control error_border_feedback_all" id="feedback_all" name="feedback_all" rows="6" cols="80" required placeholder="Nhập phản hồi"/></textarea>
										<div class="mess_notice_feedback_all clearfix note_text_feedback_all"></div>
										<div class="error_reg_mess clearfix error_text_feedback_all"></div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
										<button type="button" class="btn btn-primary send1" id="js_btnRegidit">Gửi</button>
									</div>
								</div>
								{{--
							</form>
							--}}
						</div>
					</div>
					<div class="col-md-12 col-12">
						<div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
							<div class="lockedWrap lockedWrap-first">
								<div class="cellWrap cellWrap-first">
									<p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
								</div>
								@foreach ($teachers as $teacher)
								<div class="cellWrap">
									<input type="checkbox" id_customer="{{ $teacher->teacher_id }}" data-id="{{ $teacher->teacher_id }}" class="checkItem sub_chk"
										value="{{ $teacher->teacher_id }}">
								</div>
								@endforeach
							</div>
						</div>
						<div class="table-wrapper tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
							<table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
								<thead>
									<tr>
										{{--
										<td scope="col">
											<p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
										</td>
										--}}
										<td class="lid_1">
											<p style="width:60px">id<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p>
										</td>
										<td class="lid_2">
											<p style="width:100px">Thao tác<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p>
										</td>
										<td class="lid_3">
											<p style="width:100px">Ngày xóa<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p>
										</td>
										<td class="lid_4">
											<p style="width:250px">Tên giáo viên<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p>
										</td>
										<td class="lid_5">
											<p style="width:170px">Địa chỉ<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p>
										</td>
										<td class="lid_6">
											<p style="width:170px">Khu vực<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p>
										</td>
										<td class="lid_7">
											<p style="width:50px">CTK<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p>
										</td>
										<td class="lid_8">
											<p style="width:50px">KN<button class="lockButton btn btn-sm btn-success" id="lid_8">L</button></p>
										</td>
										<td class="lid_9">
											<p style="width:200px">Người Tương tác<button class="lockButton btn btn-sm btn-success" id="lid_9">L</button></p>
										</td>
										<td class="lid_10">
											<p style="width:350px">ND tương tác<button class="lockButton btn btn-sm btn-success" id="lid_10">L</button></p>
										</td>
										<td class="lid_11">
											<p style="width:160px">TT tương tác<button class="lockButton btn btn-sm btn-success" id="lid_11">L</button></p>
										</td>
										<td class="lid_12">
											<p style="width:60px">ĐN/X<button class="lockButton btn btn-sm btn-success" id="lid_12">L</button></p>
										</td>
									</tr>
								</thead>
								<tbody class="tbody">
									@foreach ($teachers as $teacher)
									{{--
									<div class="modal fade" id="lienlac{{ $teacher->teacher_id }}" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-body">
													<div>
														Email: <input input="text" style="border:none!important"
															value="{{ $teacher->teacher_email }}">
													</div>
													<div>SĐT:
														<span>{{ $teacher->teacher_phone }}</span>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default"
														data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
									--}}
									<tr>
										{{--
										<td data-title="Tích chọn phản hồi" class="numeric">
											<input type="checkbox" id_customer="{{ $teacher->teacher_id }}" class="checkItem"
												value="{{ $teacher->teacher_id }}">
										</td>
										--}}
										<td class="lid_1">
											{{ $teacher->teacher_id }}
										</td>
										<td class="lid_2">
											<a href="{{ route('delete_hard_teacher', $teacher->teacher_id) }}" class="btn btn-sm btn-danger">Xóa</a>
											<a href="{{ route('reset_teacher', $teacher->teacher_id) }}" class="btn btn-sm btn-success">RS</a>
										</td>
										<td class="lid_3">
											{{ date_format($teacher->deleted_at,'d/m/Y') }}
										</td>
										<td class="lid_4">
											{{ $teacher->teacher_name }}
										</td>
										<td class="lid_5">
											{{ $teacher->province_name }}
										</td>
										<td class="lid_6">
											{{ $teacher->district_name }}
										</td>
										<td class="lid_7">
											@if ($teacher->status_accounting == 0)
											<i class="fas fa-times text-danger"></i>
											@else
											<i class="fas fa-check text-success"></i>
											@endif
										</td>
										<td class="lid_8">
											@php
											$exp = \App\Entity\Teacher::getexpteacher($teacher->teacher_id)
											@endphp
											{{ $exp }}
										</td>
										<td class="lid_9">
											@php
											$user_content_intea = \App\Entity\InteractiveTeacher::get_user_id_content($teacher->teacher_id);
											if (!empty($user_content_intea)) {
											$string_name = $user_content_intea->name;
											} else {
											$string_name = '';
											}
											@endphp
											{{ $string_name }}
										</td>
										<td class="lid_10">
											@php
											$user_content_intea = \App\Entity\InteractiveTeacher::get_user_id_content($teacher->teacher_id);
											if (!empty($user_content_intea)) {
											$string_content = $user_content_intea->content;
											} else {
											$string_content = '';
											}
											@endphp
											{{ $string_content }}
										</td>
										<td class="lid_11">
											@php
											$user_status_tea = \App\Entity\Teacher_status::getId($teacher->teacher_status_id);
											if (isset($user_status_tea)) {
											$string_status_name = $user_status_tea->teacher_status_name;
											} else {
											$string_status_name = '';
											}
											@endphp
											{{ $string_status_name }}
										</td>
										<td class="lid_12">
											@php
											$check = \App\Entity\Teacher_delete_request::where('teacher_id', $teacher->teacher_id)->first();
											$string1 = '';
											if ($check != null) {
											$string1 .= '<i class="fas fa-check text-success"></i>';
											} else {
											$string1 .= '<i class="fas fa-times text-danger"></i>';
											}
											@endphp
											{!! $string1 !!}
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
							{{--
						</div>
						--}}
					</div>
					{{-- </form> --}}
				</div>
			</section>
			<!-- The Modal -->
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
	    console.log('as')
	    $('.select2').select2({width: '100%', dropdownParent: $("#timkiem"),});
	});
</script>
<script>
	$(function() {
	$('.delete_request').click(function(){
	        var x = confirm("Bạn có chắc chắc đề nghị xóa?");
	        if (x){
	            var Ids = [];
	            $.each($(".checkItem:checked"), function () {
	                Ids.push($(this).val());
	            });

	            if(Ids.length == 0){
	                var changeHtml2 = '';
	                changeHtml2+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
	                changeHtml2+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
	                changeHtml2+=        'Vui lòng chọn giáo viên';
	                changeHtml2+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
	                changeHtml2+=    '</div>';
	                changeHtml2+= '</div>';
	                $('.log_error').html(changeHtml2);
	                event.preventDefault();
	            }
	            else{
	                var content = $("#feedback_all").val();
	                var changeHtml = '';
	                $.ajax({
	                    type: 'post',
	                    url: '{{route("staff_teacher_delete_all_request")}}',
	                    data: {  content: content,Ids: Ids},
	                    success: function (data) {
	                        console.log(data);
	                        if (data) {
	                            changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
	                            changeHtml+=    '<div class="alert alert-success mg-b-0 ">';
	                            changeHtml+=        'Đề nghị xóa thành công';
	                            changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
	                            changeHtml+=    '</div>';
	                            changeHtml+= '</div>';
	                            $('.log_error').html(changeHtml);
	                        }

	                    },
	                    error: function (err) {
	                        console.log(err);
	                        changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
	                        changeHtml+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
	                        changeHtml+=        'Đề nghị xóa không thành công';
	                        changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
	                        changeHtml+=    '</div>';
	                        changeHtml+= '</div>';
	                        $('.log_error').html(changeHtml);
	                    }
	                });
	            }
	        }
	        else
	            return false;
	    });
	$('.d-card').hide();
	$('.d-plus').click(function() {
	    $('.d-card').fadeToggle();
	})
	//
	$('.searchplus').click(function() {
	    $('#example_notiiii').DataTable().draw(true);
	});
	$('#btnFiterSubmitSearch').click(function() {
	    $('#laravel_datatable').DataTable().draw(true);
	});
	$('#teacher_status_id').change(function(){
	    $('#teacher_status_submit').submit();
	});

	$('#province').change(function() {
	    $.get('/admin/ajax-district/' + $(this).val(), function(data) {
	        $('#district').html(data);
	    })
	});
	$('#checkAllSendMail').click(function () {
	    $('input:checkbox').not(this).prop('checked', this.checked);
	});
	$('.send1').click(function(){
	    if($.trim($('#feedback_all').val()).length === 0){
	        $('.note_text_feedback_all').hide();
	        $('.error_text_feedback_all').html('<i class="error"><span class="error_reg_mess_icon">Vui lòng nhập phản hồi</span></i>');
	        $('.error_reg_mess_icon').css("color", "#ff0000");
	        $('.error_border_feedback_all').css("cssText", "border: 1px solid #ff0000  !important;");
	        event.preventDefault();
	    }
	    else{
	        var Ids = [];
	        $.each($(".checkItem:checked"), function () {
	            Ids.push($(this).val());
	        });
	        console.log(Ids);
	        if(Ids.length == 0){
	            var changeHtml2 = '';
	            changeHtml2+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
	            changeHtml2+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
	            changeHtml2+=        'Vui lòng chọn giáo viên';
	            changeHtml2+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
	            changeHtml2+=    '</div>';
	            changeHtml2+= '</div>';
	            $('.log_error').html(changeHtml2);
	            $('#myModal1').modal('hide');
	            event.preventDefault();
	        }
	        else{
	            var content = $("#feedback_all").val();
	            var changeHtml = '';
	                $.ajax({
	                    type: 'post',
	                    url: '{{route("SendFeedbackAllTeacher")}}',
	                    data: {  content: content,Ids: Ids},
	                    success: function (data) {
	                        console.log(data);
	                        if (data) {
	                            changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
	                            changeHtml+=    '<div class="alert alert-success mg-b-0 ">';
	                            changeHtml+=        'Phản hồi thành công';
	                            changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
	                            changeHtml+=    '</div>';
	                            changeHtml+= '</div>';
	                            $('.log_error').html(changeHtml);
	                            $('#myModal1').modal('hide');
	                        }
	                    },
	                    error: function (err) {
	                        changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
	                        changeHtml+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
	                        changeHtml+=        'Phản hồi không thành công';
	                        changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
	                        changeHtml+=    '</div>';
	                        changeHtml+= '</div>';
	                        $('.log_error').html(changeHtml);
	                        $('#myModal1').modal('hide');
	                    }
	                });
	        }
	    }
	});
	});

</script>
<script type="text/javascript">
	$(document).ready(function () {


	    $('#master').on('click', function(e) {
	     if($(this).is(':checked',true))
	     {
	        $(".sub_chk").prop('checked', true);
	     } else {
	        $(".sub_chk").prop('checked',false);
	     }
	    });


	    $('.delete_all').on('click', function(e) {


	        var allVals = [];
	        $(".sub_chk:checked").each(function() {
	            allVals.push($(this).attr('data-id'));
	        });


	        if(allVals.length <=0)
	        {
	            alert("Bạn chưa chọn bản ghi nào.");
	        }  else {


	            var check = confirm("Bạn có chắc muốn xóa?");
	            if(check == true){


	                var join_selected_values = allVals.join(",");
	                console.log(join_selected_values)

	                $.ajax({
	                    url: '{{ route('delete_all_hard_teacher') }}',
	                    type: 'get',
	                    data: 'Ids='+join_selected_values,
	                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	                    success: function (data) {
	                        console.log(data)
							location.reload();
                            alert(data['success'])
	                    },
	                    error: function (data) {
	                        alert(data.responseText);
	                    }
	                });


	              $.each(allVals, function( index, value ) {
	                  $('table tr').filter("[data-row-id='" + value + "']").remove();
	              });
	            }
	        }
	    });


	    $('[data-toggle=confirmation]').confirmation({
	        rootSelector: '[data-toggle=confirmation]',
	        onConfirm: function (event, element) {
	            element.trigger('confirm');
	        }
	    });


	    $(document).on('confirm', function (e) {
	        var ele = e.target;
	        e.preventDefault();


	        $.ajax({
	            url: ele.href,
	            type: 'DELETE',
	            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	            success: function (data) {
	                if (data['success']) {
	                    $("#" + data['tr']).slideUp("slow");
	                    alert(data['success']);
	                } else if (data['error']) {
	                    alert(data['error']);
	                } else {
	                    alert('Whoops Something went wrong!!');
	                }
	            },
	            error: function (data) {
	                alert(data.responseText);
	            }
	        });


	        return false;
	    });
	});
</script>
@endsection
