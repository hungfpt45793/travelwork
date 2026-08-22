@extends('staff_admin.layouts.master')
@section('title', 'Cập nhật nhà tuyển dụng' )
@section('content')
<div class="container-fluid">
	<div class="row row-content">
		{{-- sitebar --}}
		<div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
			@include('staff_admin.sidebars.category')
		</div>
		<div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline ">
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
					<form role="form" action="{{ route('tag-category.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                        <h3>

                        Thêm mới danh mục tag
                        <?php
                        $tag_type = isset($_GET['tag_type']) ? $_GET['tag_type'] : '1';
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
                                <input type="text" class="form-control" name="tag_title" placeholder="Tiêu đề">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea type="text" class="form-control" name="tag_description" placeholder="Mô tả"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Từ khóa</label>
                                <input type="text" class="form-control" name="tag_keyword" placeholder="Từ khóa">
                                <input type="hidden" name="tag_type" value="{{ $tag_type }}">

                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
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
