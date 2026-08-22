@extends('staff_admin.layouts.master')
@section('title', 'Thêm mới bài viết' )
@section('content')
<div class="container-fluid">
	<div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.news_article')
            </div>

            <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
			<section class="jobsInteresting bgrWhite bdLightGray radius5 ">
				<div class="contentJobsInteresting pd15 col-f14 ">
					<form action="{{ route('staff_article.update', ['post_id' => $post->post_id]) }}" method="POST">
						{!! csrf_field() !!}
						{{ method_field('PUT') }}
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<h4>Nội dung bài viết</h4>
								<hr>
								<div class="form-group">
									<label for="title">Tên bài viết</label>
									<input type="text" class="form-control" name="title" placeholder="Tiêu đề" value="{{$post->title}}" required>
								</div>
								<div class="form-group">
									<label for="content">Nội dung</label>
									<textarea class="editor"  id="content" name="content" rows="10" cols="80"/>{{ $post->content }}</textarea>

								</div>
								<div class="form-group">
									<label for="slug">Slug</label>
									<input type="text" class="form-control" name="slug" placeholder="đường dẫn tĩnh" value="{{ $post->slug }}">
								</div>
								<div class="form-group">
									<label for="description">Mô tả</label>
									<textarea rows="4" class="form-control" name="description"
										placeholder="">{{ $post->description }}</textarea>
								</div>

								{{-- từ khóa --}}
									@php
										foreach ($input_tags as $tag) {
											$tag_type = $tag['tag_type'];
										}
									@endphp
									@include('admin.layout.themtukhoa')
								{{-- END từ khóa --}}

								<div class="form-group">
									<input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
										size="20"/>
									<img src="{{ $post->image }}" width="80" height="70"/>
									<input name="image" type="hidden" value="{{ $post->image }}"/>
								</div>
								<hr class="hr">
								<h4>Hỗ trợ Seo</h4>
								<hr>
								<div class="form-group">
									<label for="meta_title">Thẻ title</label>
									<input type="text" class="form-control" name="meta_title" value="{{ $post->meta_title }}" placeholder="Thẻ title" >
								</div>
								<div class="form-group">
									<label for="meta_description">Thẻ description</label>
									<input type="text" class="form-control" name="meta_description" value="{{ $post->meta_description }}" placeholder="Thẻ description" >
								</div>
								<div class="form-group">
									<label for="meta_keyword">Thẻ keyword</label>
									<input type="text" class="form-control" name="meta_keyword" value="{{ $post->meta_keyword }}" placeholder="Thẻ keyword" >
								</div>
								<hr class="hr">
								<h4>Chọn danh mục</h4>
								<hr>
								<div class="style_company" style="column-count: 3">
									@foreach($categories as $cate)
									<div class="form-group">
										<label>
										<label>
										<input type="checkbox" name="parents[]" value="{{ $cate->category_id }}" class="flat-red"
										@if(in_array($cate->category_id, $categoryPost)) checked @endif/>
										{{ $cate->title }}
										</label>
									</div>
									@foreach($cate['sub_children'] as $child)
									<div class="form-group">
										<label>
										<input type="checkbox" name="parents[]" value="{{ $child['category_id'] }}" class="flat-red"
										@if(in_array($child['category_id'], $categoryPost)) checked @endif/>
										{{ $child['title'] }}
										</label>
									</div>
									@endforeach
									@endforeach
								</div>
								<div class="box-body">
									<div class="form-group">
										<label>Chọn template</label>
										<select class="form-control" name="template">
											<option value="default">Mặc định</option>
											{{--@foreach($templates as $template)--}}
											{{--<option value="{{ $template->slug }}"--}}
											{{--@if($template->slug == $post->template) selected @endif >{{ $template->title }}</option>--}}
											{{--@endforeach--}}
										</select>
									</div>
								</div>
								<!-- @foreach ($typeInputs as $typeInput)
								<div class="form-group">
									<label>{{ $typeInput->title }}</label>
									@if($typeInput->type_input == 'one_line')
									<input type="text" class="form-control" name="{{$typeInput->slug}}" placeholder="{{ $typeInput->placeholder }}"
										value="{{ $post[$typeInput->slug] }}" />
									@endif
									@if($typeInput->type_input == 'multi_line')
									<textarea rows="4" class="form-control" name="{{$typeInput->slug}}" placeholder="{{ $typeInput->placeholder }}">{{ $post[$typeInput->slug] }}</textarea>
									@endif
									@if($typeInput->type_input == 'image')
									<input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
										size="20"/>
									<img src="{{ $post[$typeInput->slug] }}" width="80" height="70"/>
									<input name="{{$typeInput->slug}}" type="hidden" value="{{ $post[$typeInput->slug] }}"/>
									@endif
									@if($typeInput->type_input == 'editor')
									<textarea class="editor" id="{{$typeInput->slug}}" name="{{$typeInput->slug}}" rows="10" cols="80"/>{{ $post[$typeInput->slug] }}</textarea>
									@endif
									@if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor'), true) && strpos($typeInput->type_input, 'listMultil') >= 0)
									<select name="{{$typeInput->slug}}[]" class="select22 form-control" multiple="multiple">
									<?php $slugSubPost = str_replace('listMultil', '', $typeInput->type_input);?>
									@foreach(\App\Entity\SubPost::showSubPost($slugSubPost, 100) as $subPost)
									<option value="{{ $subPost->slug }}"
									@if(in_array($subPost->slug, explode(',', $post[$typeInput->slug])) > 0 ) selected @endif>
									{{ $subPost->title }}</option>
									@endforeach
									</select>
									@elseif (!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor'), true))
									<select name="{{$typeInput->slug}}" class="form-control">
									@foreach(\App\Entity\SubPost::showSubPost($typeInput->type_input, 100) as $subPost)
									<option value="{{ $subPost->title }}"
									@if($post[$typeInput->slug] == $subPost->title) selected @endif>
									{{ $subPost->title }}</option>
									@endforeach
									</select>
									@endif
								</div>
								@endforeach -->
								<?php $productListOld = explode(',', $post->product_list)?>
								@foreach($productList as $productSearch)
								<option value="{{ $productSearch->slug }}"
								{{ (in_array($productSearch->slug, $productListOld) != false) ? 'selected' : '' }}>
								{{ $productSearch->title }}</option>
								@endforeach
								<!-- <div class="form-group">
									<label>Chọn chiến dịch cho ứng viên</label>
									<select class="form-control select22" name="campain_getfly">
									@if ( isset($campaigns['decode']) )
									@foreach ($campaigns['decode'] as $campaign)
									<option value="{{ $campaign['token_api'].'-'.$campaign['campaign_id'] }}"
									{{ ( $post->campain_getfly == $campaign['token_api']) ? 'selected' : '' }}
									>{{ $campaign['campaign_name'] }}</option>
									@endforeach
									@endif
									</select>
								</div> -->
								<div class="form-group">
									<label for="">Đồng bộ form về</label>
									<select class="form-control select22" name="form_status">
									<option value="1" {{ ($post->form_status == 1) ? 'selected' : '' }} > Nhà tuyển dụng</option>
									<option value="2" {{ ($post->form_status == 2) ? 'selected' : '' }} > Ứng viên</option>
									</select>
								</div>
								<div class="style_company">
									<div class="form-group">
										<div class="form-check">
											<label>
                                                <input type="checkbox" name="sale_money" value="1" class="flat-red" {{ $post->sale_money == 1 ? 'checked' : '' }}
                                                /> Chia sẻ bài viết lên facebook (share bài viết kiếm tiền)
                                            </label>
										</div>
									</div>
									<div class="form-group">
										<div class="form-check">
											<label>
                                                <input type="checkbox" name="noti_post" value="{{ $post->noti_post }}" class="flat-red"
                                                    {{ $post->noti_post == 1 ? 'checked' : '' }} /> Thông báo trên App
                                            </label>
										</div>
									</div>
								</div>
								<button class="btn btn-primary">Sửa bài viết</button>
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
