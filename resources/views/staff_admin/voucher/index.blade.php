@extends('staff_admin.layouts.master')
@section('title', 'Danh sách ứng viên đăng ký tư vấn' )

@section('content')
<div class="container-fluid">
	<div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.archives')
            </div>

        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
			<section class="jobsInteresting bgrWhite bdLightGray radius5 ">
				<div class="contentJobsInteresting  col-f14 ">

					<div class="row ">
                        @if (session('success'))
                            <div class="infoAlert">
                                <div class="alert alert-success">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="infoAlert">
                                <div class="alert alert-warning">
                                    <span>{{ session('error') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
						@endif
						<div class="col-12">
							<div class="d-flex justify-content-between">
                                <div>
								<a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-primary"></i> Tìm</a>
								<div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
									<form action="">
										<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm nhà tuyển dụng đăng ký tư vấn</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="col-md-5 mb-3">
													<label for="validationDefault01">Từ ngày</label>
													@php
														  $d=strtotime("-1 Months");
														  $date = date("Y-m-d", $d)
													@endphp
													<input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : $date }}" type="date" id="" name="date_search_start">
												  </div>
												  <div class="col-md-5 mb-3">
													<label for="validationDefault02">Đến ngày</label>
													<input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : date("Y-m-d") }}" type="date" id="" name="date_search_end">
												  </div>
												     <!-- myDatetime -->
													 <div class="col-md-2 mb-3">
                                                        <label for="validationDefault2" class="text-light">sd</label>
                                                        <input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày"></input>
                                                    </div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Chọn danh mục</label>
														<?php
															$id_cate_child = isset($_GET['category_voucher']) ?$_GET['category_voucher'] : '';
															?>
														<select class="form-control select2" data-placeholder="Chọn danh mục"
															style="width: 100%;height: 35px;" name="category_voucher" id="category_voucher">
															<option value="0" selected >Chọn danh mục</option>
															@foreach($categories_voucher as $category)
															<option value="{{ $category->id_cate_child }}" @if($id_cate_child ==  $category->id_cate_child) selected @endif>{{ $category->name_cate_child }}</option>
															@endforeach
														</select>
													</div>
													{{----}}
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Nhập tên tài liệu</label>
														<?php
															$name_voucher = isset($_GET['name_voucher']) ?$_GET['name_voucher'] : '';
															?>
														<input type="text" class="form-control w100" name="name_voucher"
															placeholder="Tên tài liệu" value="{{ $name_voucher }}">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Chia sẻ bài viết</label>
														<?php
															$sale_money_get = isset($_GET['sale_money']) ?$_GET['sale_money'] : '';
															?>
														<select class="form-control select2" data-placeholder="chia sẻ bài viết"
															style="width: 100%;height: 35px;" name="sale_money" id="category_voucher">
															<option value="0" selected >Chia sẻ bài viết</option>
															<option value="0" @if($sale_money_get ==  '0') selected @endif>Không</option>
															<option value="1" @if($sale_money_get ==  '1') selected @endif>Có</option>
														</select>
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
								<a href="{{ route('staff_voucher.create') }}" class="btn btn-sm btn-success mr-1 text-white">Thêm mới</a>
								<a href="{{ route('staff_voucher.index') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
								<button class="btn btn-sm btn-secondary mr-1 text-white  delete_all"><i class="fas fa-trash text-danger"></i> Xóa</button>
                                </div>
                            <!-- form tim kiem theo id tai lieu -->
                            <div>
                                <form action="" class="">
                                    <div class="group-form border border-primary">
                                        <input class="border-0 input-lg" type="text"
                                            name="id_voucher" style="width:80px"
                                            value="{{ (!empty($_GET['id_voucher'])) ? $_GET['id_voucher'] : ''  }}"
                                            placeholder="ID Tài liệu">
                                        <button class="search border-0" type="submit"><i class="fa fa-search "
                                                aria-hidden="true"></i></button>
                                    </div>
                                </form>
                            </div>
							</div>
							<div class="custom-paginate ml-1 mt-1 row">
								{{ $vouchers->links() }}
								số bản ghi của một trang:
								<span class="input-submit">
									<form action="" class="inline">
										<input type="submit" value="200" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
										<input type="submit" value="50" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
										<input type="submit" value="40" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
										<input type="submit" value="30" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
										<input type="submit" value="20" name="num"  class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
										<input type="submit" value="10" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
									</form>
								</span>
								| xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $total }} bản ghi
							</div>
						</div>
						<div class="col-md-12 ">
							<div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" id="master"></p>
                                    </div>
                                    @foreach ($vouchers as $id => $voucher)
                                    <div class="cellWrap">
										<input type="checkbox" class="sub_chk" data-id="{{ $voucher->id_voucher }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                                <div class="table-wrapper tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
										<tr>
											{{-- <td scope="col" class="">
                                                <p><input type="checkbox" id="master"></p>
                                            </td> --}}
											<td class="lid_1"><p style="width:40px">ID<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
											<td class="lid_8"><p style="width:50px">Sửa<button class="lockButton btn btn-sm btn-success" id="lid_8">L</button></p></td>
											<td class="lid_9"><p style="width:70px">Câu hỏi<button class="lockButton btn btn-sm btn-success" id="lid_9">L</button></p></td>
											<td class="lid_2"><p style="width:300px">Tên  tài liệu<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
											<td class="lid_3"><p style="width:60px">Link<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
											<td class="lid_4"><p style="width:350px">Slug  tài liệu<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
											<td class="lid_5"><p style="width:350px">File tài liệu<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
											<td class="lid_6"><p style="width:150px">Ảnh mô tả<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
											<td class="lid_7"><p style="width:130px">Share/BViết<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>

										</tr>
									</thead>
									<tbody>
										@foreach($vouchers as $id => $voucher )
										<tr>
											{{-- <td class="numeric">
                                                <input type="checkbox" class="sub_chk" data-id="{{ $voucher->id_voucher }}">
                                            </td> --}}
											<td class="lid_1">{{ $voucher->id_voucher }}</td>
											<td class="lid_8" scope="col ">
												<a class="btn btn-sm btn-primary" href="{{ route('staff_voucher.edit', ['id_voucher' => $voucher->id_voucher]) }}">
													sửa
												</a>
											</td>
											<td class="lid_9" scope="col ">
												<a href="">
													câu hỏi
												</a>
											</td>
											<td class="lid_2"><p class="crop" style="width:300px">{{ $voucher->name_voucher }}</p></td>
											<td class="lid_3"><a href="{{ route('getVoucher',['slug_voucher'=>$voucher->slug_voucher]) }}">Link</a></td>
											<td class="lid_4"><p class="crop" style="width:350px">{{ $voucher->slug_voucher }}</p></td>
											<td class="lid_5"><p class="crop" style="width:350px">{{ $voucher->link_dowload_voucher }}</p></td>
											<td class="lid_6"><img src="{{ $voucher->image_voucher }}" style="width: 50px"> </td>
											<td class="lid_7">
												@if($voucher->sale_money == 0)
												<span class="red">Không</span>
												@endif
												@if($voucher->sale_money == 1)
												<span class="green">Có</span>
												@endif
											</td>

										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- The Modal -->
		</div>
	</div>
</div>
@include('site.partials.popup_delete')
@push('custom-scripts')
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
                        url: '{{ route('delete_all_voucher') }}',
                        type: 'DELETE',
                        data: 'ids='+join_selected_values,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {
                                    $(this).parents("tr").remove();
                                });
                                location.reload()
                                alert(data['success'])
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
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
@endpush
@endsection
