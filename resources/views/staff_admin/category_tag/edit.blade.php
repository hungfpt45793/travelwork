@extends('staff_admin.layouts.master')
@section('title', 'Cập nhật nhà tuyển dụng' )
@section('content')
<div class="container-fluid">
	<div class="row row-content">
		{{-- sitebar --}}
		<div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
			@include('staff_admin.sidebars.marketing')
		</div>
		<div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
			<section class="jobsInteresting bgrWhite bdLightGray radius5 ">

				<div class="contentJobsInteresting pd15 col-f14 ">
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
					<!-- form start -->
					<form role="form" action="{{ route('tag-category.update',['tag_id'=> $category_tag->tag_id]) }}" method="POST">
						{!! csrf_field() !!}
						{{ method_field('PUT') }}
						<div class="col-xs-12 col-md-12">
							<!-- Nội dung thêm mới -->
							<div class="box box-primary">
								<div class="box-header with-border">
                                    <h3>
                                        Cập nhập danh mục tag
                                        <?php
                                        $tag_type = $category_tag->tag_type;
                                        ?>
                                        @if($tag_type == 1)
                                            bài viết
                                        @endif @if($tag_type == 2)
                                            tài liệu
                                        @endif @if($tag_type == 3)
                                            công việc
                                        @endif
                                    </h3>
								</div>
								<div class="box-body">
									<div class="form-group">
										<label for="exampleInputEmail1">Tiêu đề</label>
										<input type="text" class="form-control" name="tag_title" placeholder="Tiêu đề" value="{{  $category_tag->tag_title }}">
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">Mô tả</label>
										<textarea type="text" class="form-control" name="tag_description" placeholder="Mô tả">{{  $category_tag->tag_description }}</textarea>
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">Từ khóa</label>
										<input type="text" class="form-control" name="tag_keyword" placeholder="Từ khóa" value="{{  $category_tag->tag_keyword }}">
										<input type="hidden" name="tag_type" value="{{ $tag_type }}">
									</div>
								</div>
								<div class="box-footer">
									<button type="submit" class="btn btn-primary">Lưu thay đổi</button>
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
<script type="text/javascript">
	$(document).ready(function () {
	        $('#province').change(function () {
	            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
	                $('#district').html(data);
	            })
	        });
	    });
</script>
@endsection
