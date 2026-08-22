<?php
    //1
    $tag_type_get = '';
    if(isset($_GET['tag_type']))
    {
        $tag_type_get = $_GET['tag_type'];
    }
    //2
    $tag_title_get = '';
    if(isset($_GET['tag_title']))
    {
        $tag_ttag_title_getype_get = $_GET['tag_title'];
    }
    //3
    $num = '';
    if(isset($_GET['num']))
    {
        $num = $_GET['num'];
    }
    //4
    $tag_key_get = '';
    if(isset($_GET['tag_key']))
    {
        $tag_key_get = $_GET['tag_key'];
    }
    //5
    $tag_description_get = '';
    if(isset($_GET['tag_description']))
    {
        $tag_description_get = $_GET['tag_description'];
    }
?>
@extends('staff_admin.layouts.master')
@section('title', 'Danh sách ứng viên đăng ký tư vấn' )
@section('content')
<div class="container-fluid">
<div class="row row-content">
	{{-- sitebar --}}
	<div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
		@include('staff_admin.sidebars.marketing')
	</div>
	<div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
		<section class="jobsInteresting bgrWhite bdLightGray radius5 ">
			<div class="contentJobsInteresting  col-f14 ">
            @if(!empty(session('success')))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success!</strong> {{session('success')}}
                </div>
            @endif
				<div class="d-flex justify-content-start">
					<a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a>
					<div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<form action="">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm từ khóa</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="form-row">
                                        <input type="hidden" name="num" class="form-control" value="{{$num}}">
                                        <input type="hidden" name="tag_type" class="form-control" value="{{$tag_type_get}}">
                                            <div class="col-md-12">
                                                <label for="title">Tên</label>
                                                <input type="text" name="tag_title" class="form-control" placeholder="Tên" id="title"
                                                value="{{ (isset($_GET['tag_title'])) ? $_GET['tag_title'] :'' }}"
                                                >
											</div>
                                            <div class="col-md-12">
                                                <label for="key">Từ khóa</label>
                                                <input type="text" name="tag_key" class="form-control" placeholder="Từ khóa" id="key"
                                                value="{{ (isset($_GET['tag_key'])) ? $_GET['tag_key'] : '' }}"
                                                >
											</div>
                                            <div class="col-md-12">
                                                <label for="des">Mô tả</label>
                                                <input type="text" name="tag_description" class="form-control" placeholder="Mô tả" id="des"
                                                value="{{ (isset($_GET['tag_description'])) ? $_GET['tag_description'] :'' }}"
                                                >
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
					<a href="{{ route('tag-category.index') }}?tag_type={{ $tag_type_get }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
					<button class="btn btn-sm btn-secondary mr-1 text-white  delete_all"><i class="fas fa-trash text-danger"></i> Xóa</button>
					<a href="{{ route('tag-category.create') }}?tag_type={{ $tag_type_get }}" class="btn btn-sm btn-secondary mr-1 text-white">Thêm mới</a>
				</div>
				<div class="custom-paginate row mt-1 ml-1">
					{{ $category_tag->links() }}
					số bản ghi của một trang:
					<span class="input-submit">
						<form action="" method="get" class="inline">
                            <input type="hidden" name="tag_type" value="{{$tag_type_get}}">
                            <input type="hidden" name="tag_key" value="{{$tag_key_get}}">
                            <input type="hidden" name="tag_description" value="{{$tag_description_get}}">
                            <input type="hidden" name="tag_title" value="{{$tag_title_get}}">
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
				<div class="row ">
					<div class="col-md-12 ">
						<div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
							<div class="lockedWrap lockedWrap-first">
								<div class="cellWrap cellWrap-first">
									<p><input type="checkbox" id="master"></p>
								</div>
								@foreach ($category_tag  as $tag)
								<div class="cellWrap">
									<input type="checkbox" class="sub_chk" data-id="{{ $tag->tag_id }}">
								</div>
								@endforeach
							</div>
						</div>
						<div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
							@if(!empty($category_tag))
							<div class="table-wrapper tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
								<table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
									<thead>
										<tr>
											<td class="lid_1"><p style="width:50px"><b>ID</b><button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
											<td class="lid_2"><p style="width:60px"><b><i class="fas fa-cogs text-default"></i></b><button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td class="lid_3"><p style="width:300px"><b>Tên</b><button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td class="lid_4"><p style="width:250px"><b>Từ khóa</b><button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td class="lid_5"><p style="width:50px"><b><i class="fas fa-eye"></i></b><button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
											<td class="lid_6"><p style="width:360px"><b>Mô tả</b><button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
											<td class="lid_7"><p style="width:250px"><b>Slug</b><button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>
											<td class="lid_8"><p style="width:150px"><b>Ngày tạo</b><button class="lockButton btn btn-sm btn-success" id="lid_8">L</button></p></td>

										</tr>
									</thead>
									<tbody>
										@foreach($category_tag  as $tag)
										<tr>
											<td class="lid_1">{{ $tag->tag_id }}</td>
                                            <td class="lid_2">
												<a class="btn btn-sm btn-primary" href="{{ route('tag-category.edit',['tag_id'=> $tag->tag_id]) }}">
												<!-- <i class="fas fa-edit text-primary"></i> -->
												Sửa
												</a>
												<!-- <a href="{{ route('tag-category.destroy',['tag_id'=> $tag->tag_id]) }}" class="btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
												<i class="fas fa-trash-alt text-danger"></i>
												</a> -->
											</td>
											<td class="lid_3">
                                                <p data-toggle="modal" data-target="#title{{$tag->tag_id}}" class="crop" style="width:300px">{{ $tag->tag_title }}</p>
                                                <div class="modal fade" id="title{{$tag->tag_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                            {{ $tag->tag_title }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="lid_4"><p data-toggle="modal" data-target="#key{{$tag->tag_id}}" class="crop" style="width:250px">{{ $tag->tag_keyword }}</p>
                                            <div class="modal fade" id="key{{$tag->tag_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                            {{ $tag->tag_keyword }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="lid_5">{{ $tag->views }}</td>
											<td class="lid_6">
                                                <p data-toggle="modal" data-target="#des{{$tag->tag_id}}" class="crop" style="width:360px">
                                                {{ $tag->tag_description }}
                                                </p>
                                                <div class="modal fade" id="des{{$tag->tag_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                            {{ $tag->tag_description }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
											<td class="lid_7">
                                            <p data-toggle="modal" data-target="#slug{{$tag->tag_id}}" class="crop" style="width:250px">{{ $tag->tag_slug }}</p>
                                            <div class="modal fade" id="slug{{$tag->tag_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                            {{ $tag->tag_description }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
											<td class="lid_8"><?php
												$date=date_create($tag->created_at );
												echo date_format($date,"d/m/Y");
												?>
											</td>

										</tr>
										@endforeach
									</tbody>
								</table>
								@else
								<p>Đang cập nhập thông tin</p>
								@endif
								@include('site.partials.popup_delete')
							</div>
						</div>
					</div>
				</div>
		</section>
		<!-- The Modal -->
		</div>
	</div>
</div>
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
	                    url: '{{ route('delete_all_tag_category') }}',
	                    type: 'POST',
	                    data: 'ids='+join_selected_values,
	                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	                    success: function (data) {
	                        if (data['success']) {
	                            $(".sub_chk:checked").each(function() {
	                                $(this).parents("tr").remove();
	                            });
	                            location.reload()
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
